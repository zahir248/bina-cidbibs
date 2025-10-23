<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessMatching;
use App\Models\BusinessMatchingPanel;
use App\Models\BusinessMatchingTimeSlot;
use App\Models\BusinessMatchingBooking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BusinessMatchingController extends Controller
{
    /**
     * Display a listing of business matching sessions.
     */
    public function index(Request $request)
    {
        $query = BusinessMatching::with(['event', 'panels', 'timeSlots', 'bookings']);

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('event', function($eventQuery) use ($search) {
                      $eventQuery->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // Apply status filter
        if ($request->has('status') && !empty($request->status)) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $businessMatchings = $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return view('admin.business-matching.index', compact('businessMatchings'));
    }

    /**
     * Show the form for creating a new business matching session.
     */
    public function create()
    {
        $events = Event::where('is_published', true)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('admin.business-matching.create', compact('events'));
    }

    /**
     * Store a newly created business matching session.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_active' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $businessMatching = BusinessMatching::create([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->route('admin.business-matching.show', $businessMatching)
            ->with('success', 'Business matching session created successfully!');
    }

    /**
     * Display the specified business matching session.
     */
    public function show(BusinessMatching $businessMatching)
    {
        $businessMatching->load(['event', 'panels', 'timeSlots.bookings', 'bookings.user']);
        
        // Get statistics
        $stats = [
            'total_panels' => $businessMatching->panels->count(),
            'total_time_slots' => $businessMatching->timeSlots->count(),
            'total_bookings' => $businessMatching->bookings->count(),
            'capacity_utilization' => $businessMatching->getCapacityUtilization()
        ];

        return view('admin.business-matching.show', compact('businessMatching', 'stats'));
    }

    /**
     * Show the form for editing the specified business matching session.
     */
    public function edit(BusinessMatching $businessMatching)
    {
        $events = Event::where('is_published', true)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('admin.business-matching.edit', compact('businessMatching', 'events'));
    }

    /**
     * Update the specified business matching session.
     */
    public function update(Request $request, BusinessMatching $businessMatching)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_active' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $businessMatching->update([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->route('admin.business-matching.show', $businessMatching)
            ->with('success', 'Business matching session updated successfully!');
    }

    /**
     * Remove the specified business matching session.
     */
    public function destroy(BusinessMatching $businessMatching)
    {
        // Check if there are any bookings
        if ($businessMatching->bookings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete business matching session with existing bookings.');
        }

        $businessMatching->delete();

        return redirect()->route('admin.business-matching.index')
            ->with('success', 'Business matching session deleted successfully!');
    }

    /**
     * Toggle the active status of a business matching session.
     */
    public function toggleStatus(BusinessMatching $businessMatching)
    {
        $businessMatching->update(['is_active' => !$businessMatching->is_active]);

        $status = $businessMatching->is_active ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('success', "Business matching session {$status} successfully!");
    }

    /**
     * Show panels management for a business matching session.
     */
    public function panels(BusinessMatching $businessMatching)
    {
        $panels = $businessMatching->panels()->orderBy('order')->get();
        
        return view('admin.business-matching.panels', compact('businessMatching', 'panels'));
    }

    /**
     * Store a new panel for a business matching session.
     */
    public function storePanel(Request $request, BusinessMatching $businessMatching)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1',
            'is_active' => 'sometimes',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('panel-images', 'public');
        }

        BusinessMatchingPanel::create([
            'business_matching_id' => $businessMatching->id,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'order' => $request->order,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->back()
            ->with('success', 'Panel created successfully!');
    }

    /**
     * Update a panel.
     */
    public function updatePanel(Request $request, BusinessMatchingPanel $panel)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1',
            'is_active' => 'sometimes',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'description' => $request->description,
            'order' => $request->order,
            'is_active' => $request->boolean('is_active')
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($panel->image && Storage::disk('public')->exists($panel->image)) {
                Storage::disk('public')->delete($panel->image);
            }
            $updateData['image'] = $request->file('image')->store('panel-images', 'public');
        }

        $panel->update($updateData);

        return redirect()->back()
            ->with('success', 'Panel updated successfully!');
    }

    /**
     * Delete a panel.
     */
    public function deletePanel(BusinessMatchingPanel $panel)
    {
        // Since panels are now auto-assigned and don't have direct bookings,
        // we can safely delete them without checking for bookings
        $panel->delete();

        return redirect()->back()
            ->with('success', 'Panel deleted successfully!');
    }

    /**
     * Show time slots management for a business matching session.
     */
    public function timeSlots(BusinessMatching $businessMatching)
    {
        $timeSlots = $businessMatching->timeSlots()->orderBy('order')->get();
        
        return view('admin.business-matching.time-slots', compact('businessMatching', 'timeSlots'));
    }

    /**
     * Store a new time slot for a business matching session.
     */
    public function storeTimeSlot(Request $request, BusinessMatching $businessMatching)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'order' => 'required|integer|min:1',
            'is_active' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        BusinessMatchingTimeSlot::create([
            'business_matching_id' => $businessMatching->id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'order' => $request->order,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->back()
            ->with('success', 'Time slot created successfully!');
    }

    /**
     * Update a time slot.
     */
    public function updateTimeSlot(Request $request, BusinessMatchingTimeSlot $timeSlot)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'order' => 'required|integer|min:1',
            'is_active' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $timeSlot->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'order' => $request->order,
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->back()
            ->with('success', 'Time slot updated successfully!');
    }

    /**
     * Delete a time slot.
     */
    public function deleteTimeSlot(BusinessMatchingTimeSlot $timeSlot)
    {
        // Check if time slot has bookings
        if ($timeSlot->bookings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete time slot with existing bookings.');
        }

        $timeSlot->delete();

        return redirect()->back()
            ->with('success', 'Time slot deleted successfully!');
    }

    /**
     * Show bookings for a business matching session.
     */
    public function bookings(BusinessMatching $businessMatching, Request $request)
    {
        $query = $businessMatching->bookings()->with(['user', 'timeSlot']);

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('participant_name', 'like', "%{$search}%")
                  ->orWhere('participant_email', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        // Apply time slot filter
        if ($request->has('time_slot') && !empty($request->time_slot)) {
            $query->where('time_slot_id', $request->time_slot);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get time slots for filter dropdown
        $timeSlots = $businessMatching->timeSlots()->orderBy('order')->get();

        return view('admin.business-matching.bookings', compact('businessMatching', 'bookings', 'timeSlots'));
    }


    /**
     * Export bookings to Excel.
     */
    public function exportBookings(BusinessMatching $businessMatching)
    {
        $export = new \App\Exports\BusinessMatchingBookingsExport($businessMatching);
        $filename = 'business-matching-bookings-' . $businessMatching->name . '-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
        
        return \Maatwebsite\Excel\Facades\Excel::download($export, $filename);
    }

    /**
     * Export bookings for a specific time slot.
     */
    public function exportTimeSlotBookings(BusinessMatching $businessMatching, BusinessMatchingTimeSlot $timeSlot)
    {
        $export = new \App\Exports\BusinessMatchingTimeSlotBookingsExport($businessMatching, $timeSlot);
        $filename = 'time-slot-bookings-' . $timeSlot->getFormattedTimeRange() . '-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
        
        return \Maatwebsite\Excel\Facades\Excel::download($export, $filename);
    }
}
