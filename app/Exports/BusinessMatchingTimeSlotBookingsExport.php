<?php

namespace App\Exports;

use App\Models\BusinessMatching;
use App\Models\BusinessMatchingTimeSlot;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BusinessMatchingTimeSlotBookingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $businessMatching;
    protected $timeSlot;

    public function __construct(BusinessMatching $businessMatching, BusinessMatchingTimeSlot $timeSlot)
    {
        $this->businessMatching = $businessMatching;
        $this->timeSlot = $timeSlot;
    }

    public function collection()
    {
        return $this->timeSlot->bookings()->with(['user'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Reference Number',
            'Participant Name',
            'Email',
            'Phone',
            'Identity Number',
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
        return [
            $booking->getReferenceNumber(),
            $booking->participant_name,
            $booking->participant_email,
            $booking->participant_phone ?: '-',
            $booking->identity_number ?: '-',
            $booking->company_name ?: '-',
            $booking->business_type ?: '-',
            $this->timeSlot->getFormattedTimeRange(),
            $booking->getFormattedInterests(),
            $booking->created_at->format('M d, Y H:i'),
            $booking->user ? $booking->user->name : 'Guest User'
        ];
    }
}
