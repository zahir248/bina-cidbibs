<?php

namespace App\Exports;

use App\Models\BillingDetail;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketPurchasersExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return BillingDetail::query()
            ->whereHas('orders', function($query) {
                $query->where('status', 'paid');
            })
            ->with(['orders' => function($query) {
                $query->where('status', 'paid');
            }]);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Identity Number',
            'Gender',
            'Category',
            'Email',
            'Phone',
            'Company Name',
            'Business Registration',
            'Tax Number',
            'Student ID',
            'Academic Institution',
            'Address',
            'City',
            'State',
            'Postcode',
            'Country',
            'Total Orders',
            'Total Amount'
        ];
    }

    public function map($purchaser): array
    {
        return [
            $purchaser->first_name . ' ' . $purchaser->last_name,
            $purchaser->identity_number ?? '-',
            ucfirst($purchaser->gender ?? '-'),
            ucfirst($purchaser->category ?? '-'),
            $purchaser->email,
            $purchaser->phone,
            $purchaser->company_name ?? '-',
            $purchaser->business_registration_number ?? '-',
            $purchaser->tax_number ?? '-',
            $purchaser->student_id ?? '-',
            $purchaser->academic_institution ?? '-',
            $purchaser->address1 . ($purchaser->address2 ? ', ' . $purchaser->address2 : ''),
            $purchaser->city,
            $purchaser->state,
            $purchaser->postcode,
            $purchaser->country,
            $purchaser->orders->count(),
            'RM ' . number_format($purchaser->orders->sum('total_amount'), 2)
        ];
    }
} 