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

        return view('client.business-matching.index', compact('businessMatchings'));
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

        $validator = Validator::make($request->all(), [
            'participant_name' => 'required|string|max:255',
            'participant_email' => 'required|email|max:255',
            'participant_phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'identity_number' => 'required|string|max:50',
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

        // Validate that the time slot belongs to this business matching
        if (!$timeSlot || $timeSlot->business_matching_id !== $businessMatching->id) {
            return redirect()->back()
                ->with('error', 'Invalid time slot selected.')
                ->withInput();
        }


        // Check if the selected time slot has available capacity (max 2 people per time slot)
        $bookingsInSlot = BusinessMatchingBooking::where('business_matching_id', $businessMatching->id)
            ->where('time_slot_id', $timeSlot->id)
            ->count();

        if ($bookingsInSlot >= 2) {
            return redirect()->back()
                ->with('error', 'The selected time slot is full. Please choose another time slot.')
                ->withInput();
        }

        // Check if user already has a booking for this business matching (only if authenticated)
        if (Auth::check()) {
            $existingBooking = BusinessMatchingBooking::where('business_matching_id', $businessMatching->id)
                ->where('user_id', Auth::id())
                ->first();

            if ($existingBooking) {
                return redirect()->back()
                    ->with('error', 'You already have a registration for this business matching session.')
                    ->withInput();
            }
        }

        // Check if identity number is already registered for this business matching session
        $existingIdentityBooking = BusinessMatchingBooking::where('business_matching_id', $businessMatching->id)
            ->where('identity_number', $request->identity_number)
            ->first();

        if ($existingIdentityBooking) {
            return redirect()->back()
                ->with('error', 'This identity number is already registered for this business matching session. Each person can only register once per session.')
                ->withInput();
        }

        // Create the booking
        try {
            $booking = BusinessMatchingBooking::create([
                'business_matching_id' => $businessMatching->id,
                'time_slot_id' => $timeSlot->id,
                'user_id' => Auth::id(), // Will be null for guest users
                'participant_name' => $request->participant_name,
                'participant_email' => $request->participant_email,
                'participant_phone' => $request->participant_phone,
                'company_name' => $request->company_name,
                'identity_number' => $request->identity_number,
                'business_type' => $request->business_type,
                'interests' => $request->interests,
            ]);

            return redirect()->route('client.business-matching.booking.success', $booking)
                ->with('success', 'Your business matching registration has been confirmed!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle unique constraint violation
            if ($e->getCode() == 23000) { // Integrity constraint violation
                return redirect()->back()
                    ->with('error', 'This identity number is already registered for this business matching session. Each person can only register once per session.')
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
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load(['businessMatching', 'timeSlot']);

        return view('client.business-matching.booking-success', compact('booking'));
    }

    /**
     * Show user's business matching bookings.
     */
    public function myBookings(Request $request)
    {
        $bookings = collect();
        $identityNumber = $request->input('identity_number');

        if ($identityNumber) {
            $bookings = BusinessMatchingBooking::where('identity_number', $identityNumber)
                ->with(['businessMatching', 'timeSlot'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('client.business-matching.my-bookings', compact('bookings', 'identityNumber'));
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
