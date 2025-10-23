<?php

namespace App\Exports;

use App\Models\BusinessMatchingBooking;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class AllBusinessMatchingBookingsPdfExport
{
    public function download()
    {
        $bookings = BusinessMatchingBooking::with(['timeSlot', 'user', 'businessMatching.panels'])
            ->join('business_matching_time_slots', 'business_matching_bookings.time_slot_id', '=', 'business_matching_time_slots.id')
            ->join('business_matchings', 'business_matching_bookings.business_matching_id', '=', 'business_matchings.id')
            ->orderBy('business_matchings.date', 'asc')
            ->orderBy('business_matchings.start_time', 'asc')
            ->orderBy('business_matching_time_slots.start_time', 'asc')
            ->orderBy('business_matching_time_slots.end_time', 'asc')
            ->orderBy('business_matching_bookings.created_at', 'asc')
            ->select('business_matching_bookings.*')
            ->get();

        // Group bookings by business matching session first
        $sessionGroups = $bookings->groupBy('business_matching_id');
        $groupedData = [];

        foreach ($sessionGroups as $sessionId => $sessionBookings) {
            $businessMatching = $sessionBookings->first()->businessMatching;
            $panelName = $businessMatching->panels->first() ? $businessMatching->panels->first()->name : 'No Panel Assigned';
            
            $sessionData = [
                'panel_name' => $panelName,
                'session_date' => $businessMatching->date,
                'total_participants' => $sessionBookings->count(),
                'time_slots' => []
            ];

            // Group time slots within this session
            $timeSlotGroups = $sessionBookings->groupBy('time_slot_id');
            
            foreach ($timeSlotGroups as $timeSlotId => $timeSlotBookings) {
                $timeSlot = $timeSlotBookings->first()->timeSlot;
                
                $sessionData['time_slots'][] = [
                    'time_slot' => $timeSlot->getFormattedTimeRange(),
                    'participant_count' => $timeSlotBookings->count(),
                    'bookings' => $timeSlotBookings->map(function ($booking) {
                        return [
                            'reference_number' => $booking->getReferenceNumber(),
                            'participant_name' => $booking->participant_name,
                            'participant_email' => $booking->participant_email,
                            'participant_phone' => $booking->participant_phone ?? '-',
                            'company_name' => $booking->company_name ?? '-',
                            'business_type' => $booking->business_type ?? '-',
                            'panel_name' => $booking->businessMatching->panels->first() ? $booking->businessMatching->panels->first()->name : 'No Panel Assigned',
                            'session_date' => $booking->businessMatching->date,
                            'time_slot' => $booking->timeSlot->getFormattedTimeRange(),
                            'interests' => $booking->getFormattedInterests(),
                            'registered_date' => $booking->created_at->format('d M Y H:i'),
                            'user_account' => $booking->user ? $booking->user->name : 'Guest User'
                        ];
                    })->toArray()
                ];
            }

            $groupedData[] = $sessionData;
        }

        $filename = 'all-business-matching-bookings-' . now()->format('Y-m-d-H-i-s') . '.pdf';
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.business-matching.pdf.all-bookings', [
            'groupedData' => $groupedData,
            'exportDate' => now()->format('d M Y H:i')
        ]);

        return $pdf->download($filename);
    }
}
