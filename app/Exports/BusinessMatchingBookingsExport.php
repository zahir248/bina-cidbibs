<?php

namespace App\Exports;

use App\Models\BusinessMatchingBooking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BusinessMatchingBookingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $businessMatching;

    public function __construct($businessMatching)
    {
        $this->businessMatching = $businessMatching;
    }

    public function collection()
    {
        return BusinessMatchingBooking::where('business_matching_id', $this->businessMatching->id)
            ->with(['timeSlot', 'user'])
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
            $booking->participant_phone ?? '-',
            $booking->identity_number ?? '-',
            $booking->company_name ?? '-',
            $booking->business_type ?? '-',
            $booking->timeSlot->getFormattedTimeRange(),
            $booking->getFormattedInterests(),
            $booking->created_at->format('d M Y H:i'),
            $booking->user ? $booking->user->name : 'Guest User'
        ];
    }
}
