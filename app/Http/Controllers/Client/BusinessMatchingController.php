<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BusinessMatching;
use App\Models\BusinessMatchingPanel;
use App\Models\BusinessMatchingTimeSlot;
use App\Models\BusinessMatchingBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BusinessMatchingController extends Controller
{
    /**
     * Display the business matching registration page.
     */
    public function index()
    {
        $businessMatchings = BusinessMatching::with(['panels', 'timeSlots'])
            ->where('is_active', true)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        // Check if user already has a booking
        $hasExistingBooking = false;
        if (Auth::check()) {
            $hasExistingBooking = BusinessMatchingBooking::where('user_id', Auth::id())->exists();
        }

        return view('client.business-matching.index', compact('businessMatchings', 'hasExistingBooking'));
    }

    /**
     * Show the registration form for a specific business matching.
     */
    public function show(BusinessMatching $businessMatching)
    {
        // Check if business matching is open for registration
        if (!$businessMatching->isOpenForRegistration()) {
            return redirect()->route('client.business-matching.index')
                ->with('error', 'This business matching session is not currently open for registration.');
        }

        $businessMatching->load(['panels', 'timeSlots']);

        return view('client.business-matching.show', compact('businessMatching'));
    }

    /**
     * Store a new business matching booking.
     */
    public function store(Request $request, BusinessMatching $businessMatching)
    {
        // Check if business matching is open for registration
        if (!$businessMatching->isOpenForRegistration()) {
            return redirect()->route('client.business-matching.index')
                ->with('error', 'This business matching session is not currently open for registration.');
        }

        // Check if business matching has time slots
        if ($businessMatching->timeSlots->count() === 0) {
            \Log::error('Business matching has no time slots', [
                'business_matching_id' => $businessMatching->id
            ]);
            
            return redirect()->back()
                ->with('error', 'No time slots available for this session. Please contact support.')
                ->withInput();
        }

        $validator = Validator::make($request->all(), [
            'participant_name' => 'required|string|max:255',
            'participant_email' => 'required|email|max:255',
            'participant_phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'time_slot_id' => 'required|exists:business_matching_time_slots,id',
            'interests' => 'nullable|array',
            'interests.*' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get the selected time slot
        $timeSlot = BusinessMatchingTimeSlot::find($request->time_slot_id);

        // Debug logging for deployed environment
        \Log::info('Time slot validation debug', [
            'requested_time_slot_id' => $request->time_slot_id,
            'business_matching_id' => $businessMatching->id,
            'time_slot_found' => $timeSlot ? true : false,
            'time_slot_business_matching_id' => $timeSlot ? $timeSlot->business_matching_id : null,
            'available_time_slots' => $businessMatching->timeSlots->pluck('id')->toArray()
        ]);

        // Validate that the time slot belongs to this business matching
        if (!$timeSlot) {
            \Log::error('Time slot not found', [
                'time_slot_id' => $request->time_slot_id,
                'business_matching_id' => $businessMatching->id
            ]);
            
            return redirect()->back()
                ->with('error', 'Selected time slot not found. Please refresh the page and try again.')
                ->withInput();
        }
        
        // Check if the time slot belongs to this business matching using a more robust method
        $isValidTimeSlot = $businessMatching->timeSlots->contains('id', $timeSlot->id);
        
        if (!$isValidTimeSlot) {
            \Log::error('Time slot not found in business matching time slots', [
                'time_slot_id' => $request->time_slot_id,
                'time_slot_business_matching_id' => $timeSlot->business_matching_id,
                'requested_business_matching_id' => $businessMatching->id,
                'available_time_slot_ids' => $businessMatching->timeSlots->pluck('id')->toArray()
            ]);
            
            return redirect()->back()
                ->with('error', 'Selected time slot is not available for this session. Please refresh the page and try again.')
                ->withInput();
        }


        // Check if the selected time slot has available capacity (max 3 people per time slot)
        $bookingsInSlot = BusinessMatchingBooking::where('business_matching_id', $businessMatching->id)
            ->where('time_slot_id', $timeSlot->id)
            ->count();

        if ($bookingsInSlot >= 3) {
            return redirect()->back()
                ->with('error', 'The selected time slot is full. Please choose another time slot.')
                ->withInput();
        }

        // Check if user already has a booking for ANY business matching session (only if authenticated)
        if (Auth::check()) {
            $existingBooking = BusinessMatchingBooking::where('user_id', Auth::id())
                ->first();

            if ($existingBooking) {
                return redirect()->back()
                    ->with('error', 'You already have a business matching registration. Each person can only register for one business matching session.')
                    ->withInput();
            }
        }

        // Check if email is already registered for ANY business matching session
        $existingEmailBooking = BusinessMatchingBooking::where('participant_email', $request->participant_email)
            ->first();

        if ($existingEmailBooking) {
            return redirect()->back()
                ->with('error', 'This email is already registered for a business matching session. Each person can only register for one business matching session.')
                ->withInput();
        }


        // Create the booking
        try {
            $userId = Auth::id();
            \Log::info('Creating business matching booking', [
                'user_id' => $userId,
                'user_authenticated' => Auth::check(),
                'business_matching_id' => $businessMatching->id,
                'time_slot_id' => $timeSlot->id
            ]);
            
            $booking = BusinessMatchingBooking::create([
                'business_matching_id' => $businessMatching->id,
                'time_slot_id' => $timeSlot->id,
                'user_id' => $userId, // Will be null for guest users
                'participant_name' => $request->participant_name,
                'participant_email' => $request->participant_email,
                'participant_phone' => $request->participant_phone,
                'company_name' => $request->company_name,
                'business_type' => $request->business_type,
                'interests' => $request->interests,
            ]);

            return redirect()->route('client.business-matching.booking.success', $booking)
                ->with('success', 'Your business matching registration has been confirmed!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle unique constraint violation
            if ($e->getCode() == 23000) { // Integrity constraint violation
                return redirect()->back()
                    ->with('error', 'This email is already registered for this business matching session. Each person can only register once per session.')
                    ->withInput();
            }
            
            // Re-throw other database errors
            throw $e;
        }
    }

    /**
     * Show the booking success page.
     */
    public function bookingSuccess(BusinessMatchingBooking $booking)
    {
        \Log::info('Accessing booking success page', [
            'booking_id' => $booking->id,
            'booking_user_id' => $booking->user_id,
            'current_user_id' => Auth::id(),
            'user_authenticated' => Auth::check()
        ]);
        
        // For authenticated users, ensure the booking belongs to them
        if (Auth::check()) {
            // Convert both IDs to integers for proper comparison
            $bookingUserId = (int) $booking->user_id;
            $currentUserId = (int) Auth::id();
            
            if ($bookingUserId !== $currentUserId) {
                \Log::error('Booking access denied', [
                    'booking_id' => $booking->id,
                    'booking_user_id' => $booking->user_id,
                    'booking_user_id_int' => $bookingUserId,
                    'current_user_id' => Auth::id(),
                    'current_user_id_int' => $currentUserId,
                    'user_authenticated' => Auth::check()
                ]);
                abort(403);
            }
        }
        // For guest users, we allow access since they don't have user_id

        $booking->load(['businessMatching', 'timeSlot']);

        return view('client.business-matching.booking-success', compact('booking'));
    }

    /**
     * Show user's business matching bookings.
     */
    public function myBookings(Request $request)
    {
        $bookings = collect();
        $email = $request->input('email');

        // If email is provided, search for bookings
        if ($email) {
            $bookings = BusinessMatchingBooking::where('participant_email', 'like', '%' . $email . '%')
                ->with(['businessMatching', 'timeSlot'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('client.business-matching.my-bookings', compact('bookings', 'email'));
    }

    /**
     * Cancel a booking.
     */
    public function cancelBooking(BusinessMatchingBooking $booking)
    {
        // Check if it's too close to the event time (e.g., within 24 hours)
        $eventDate = $booking->businessMatching->date->format('Y-m-d');
        $eventTime = $booking->businessMatching->start_time->format('H:i:s');
        $eventDateTime = \Carbon\Carbon::parse($eventDate . ' ' . $eventTime);
        
        if (now()->diffInHours($eventDateTime) < 24) {
            return redirect()->back()
                ->with('error', 'Cannot cancel booking within 24 hours of the event.');
        }

        // Check if the event has already passed
        if ($booking->businessMatching->date->isPast()) {
            return redirect()->back()
                ->with('error', 'Cannot cancel a booking for an event that has already passed.');
        }

        // Delete the booking (since we don't have status tracking)
        $booking->delete();

        return redirect()->back()
            ->with('success', 'Your booking has been cancelled successfully.');
    }

    /**
     * Download booking details as PDF.
     */
    public function download(BusinessMatchingBooking $booking)
    {
        try {
            $pdf = \PDF::loadView('client.business-matching.pdf.booking-details', compact('booking'));
            $filename = 'business-matching-registration-' . $booking->getReferenceNumber() . '.pdf';
            
            return $pdf->download($filename);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to generate PDF. Please try again.');
        }
    }

}
