<?php

namespace App\Exports;

use App\Models\BusinessMatchingBooking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BusinessMatchingBookingsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $businessMatching;

    public function __construct($businessMatching)
    {
        $this->businessMatching = $businessMatching;
    }

    public function collection()
    {
        $bookings = BusinessMatchingBooking::where('business_matching_bookings.business_matching_id', $this->businessMatching->id)
            ->with(['timeSlot', 'user'])
            ->join('business_matching_time_slots', 'business_matching_bookings.time_slot_id', '=', 'business_matching_time_slots.id')
            ->orderBy('business_matching_time_slots.start_time', 'asc')
            ->orderBy('business_matching_time_slots.end_time', 'asc')
            ->orderBy('business_matching_bookings.created_at', 'asc')
            ->select('business_matching_bookings.*')
            ->get();

        // Group bookings by time slot
        $groupedBookings = $bookings->groupBy('time_slot_id');
        $result = collect();

        foreach ($groupedBookings as $timeSlotId => $timeSlotBookings) {
            $timeSlot = $timeSlotBookings->first()->timeSlot;
            
            // Add time slot header row
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
            'Time Slot',
            'Areas of Interest',
            'Registered Date',
            'User Account'
        ];
    }

    public function map($booking): array
    {
        // Handle time slot header rows
        if (isset($booking->is_time_slot_header) && $booking->is_time_slot_header) {
            return [
                'TIME SLOT: ' . $booking->time_slot,
                'Participants: ' . $booking->participant_count,
                '', '', '', '', '', '', '', ''
            ];
        }

        // Handle regular booking rows
        return [
            $booking->getReferenceNumber(),
            $booking->participant_name,
            $booking->participant_email,
            $booking->participant_phone ?? '-',
            $booking->company_name ?? '-',
            $booking->business_type ?? '-',
            $booking->timeSlot->getFormattedTimeRange(),
            $booking->getFormattedInterests(),
            $booking->created_at->format('d M Y H:i'),
            $booking->user ? $booking->user->name : 'Guest User'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row (headings)
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E6E6FA']
                ]
            ],
        ];
    }
}
