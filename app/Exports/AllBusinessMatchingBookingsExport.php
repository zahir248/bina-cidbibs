<?php

namespace App\Exports;

use App\Models\BusinessMatchingBooking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllBusinessMatchingBookingsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
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
        $result = collect();

        foreach ($sessionGroups as $sessionId => $sessionBookings) {
            $businessMatching = $sessionBookings->first()->businessMatching;
            $panelName = $businessMatching->panels->first() ? $businessMatching->panels->first()->name : 'No Panel Assigned';
            
            // Add session header
            $result->push((object) [
                'is_session_header' => true,
                'panel_name' => $panelName,
                'session_date' => $businessMatching->date,
                'total_participants' => $sessionBookings->count()
            ]);

            // Group time slots within this session
            $timeSlotGroups = $sessionBookings->groupBy('time_slot_id');
            
            foreach ($timeSlotGroups as $timeSlotId => $timeSlotBookings) {
                $timeSlot = $timeSlotBookings->first()->timeSlot;
                
                // Add time slot header
                $result->push((object) [
                    'is_time_slot_header' => true,
                    'time_slot' => $timeSlot->getFormattedTimeRange(),
                    'participant_count' => $timeSlotBookings->count()
                ]);

                // Add bookings for this time slot
                foreach ($timeSlotBookings as $booking) {
                    $result->push($booking);
                }
            }

            // Add separator row between sessions
            $result->push((object) [
                'is_separator' => true
            ]);
        }

        return $result;
    }

    public function headings(): array
    {
        return [
            'Reference Number',
            'Participant Name',
            'Email',
            'Phone',
            'Company Name',
            'Business Type',
            'Panel Name',
            'Session Date',
            'Time Slot',
            'Areas of Interest',
            'Registered Date',
            'User Account'
        ];
    }

    public function map($booking): array
    {
        // Handle session header rows
        if (isset($booking->is_session_header) && $booking->is_session_header) {
            return [
                'PANEL: ' . $booking->panel_name . ' (' . $booking->session_date . ')',
                'Total Participants: ' . $booking->total_participants,
                '', '', '', '', '', '', '', '', '', ''
            ];
        }

        // Handle time slot header rows
        if (isset($booking->is_time_slot_header) && $booking->is_time_slot_header) {
            return [
                'TIME SLOT: ' . $booking->time_slot,
                'Participants: ' . $booking->participant_count,
                '', '', '', '', '', '', '', '', ''
            ];
        }

        // Handle separator rows
        if (isset($booking->is_separator) && $booking->is_separator) {
            return [
                '', '', '', '', '', '', '', '', '', '', '', ''
            ];
        }

        // Handle regular booking rows
        $panelName = $booking->businessMatching->panels->first() ? $booking->businessMatching->panels->first()->name : 'No Panel Assigned';
        
        return [
            $booking->getReferenceNumber(),
            $booking->participant_name,
            $booking->participant_email,
            $booking->participant_phone ?? '-',
            $booking->company_name ?? '-',
            $booking->business_type ?? '-',
            $panelName,
            $booking->businessMatching->date,
            $booking->timeSlot->getFormattedTimeRange(),
            $booking->getFormattedInterests(),
            $booking->created_at->format('d M Y H:i'),
            $booking->user ? $booking->user->name : 'Guest User'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $styles = [
            // Style the first row (headings)
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E6E6FA']
                ]
            ],
        ];

        // Style session headers (bold, blue background)
        $row = 2;
        foreach ($this->collection() as $item) {
            if (isset($item->is_session_header) && $item->is_session_header) {
                $styles[$row] = [
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4472C4']
                    ]
                ];
            } elseif (isset($item->is_time_slot_header) && $item->is_time_slot_header) {
                $styles[$row] = [
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F2F2F2']
                    ]
                ];
            }
            $row++;
        }

        return $styles;
    }
}
