<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IndividualOrderExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function collection()
    {
        return collect([$this->order]);
    }

    public function headings(): array
    {
        return [
            // Order Details
            'Reference Number',
            'Total Amount (RM)',
            'Processing Fee (RM)',
            'Payment Method',
            'Payment ID',
            'Payment Country',
            'Status',
            'Created At',

            // Basic Billing Details
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Identity Number',
            'Gender',
            'Category',
            'Country',
            'Address 1',
            'Address 2',
            'City',
            'State',
            'Postcode',

            // Organization Details
            'Company Name',
            'Business Registration Number',
            'Tax Number',

            // Academician Details
            'Student ID',
            'Academic Institution',

            // Purchased Tickets
            'Tickets Details'
        ];
    }

    public function map($order): array
    {
        // Format tickets information
        $ticketsInfo = collect($order->cart_items)->map(function ($item) {
            $ticket = Ticket::find($item['ticket_id']);
            $originalPrice = $ticket ? $ticket->price : 0;
            $quantity = $item['quantity'];
            $discountedPrice = $ticket ? $ticket->getDiscountedPrice($quantity) : 0;
            $subtotal = $discountedPrice * $quantity;
            
            return sprintf(
                "Ticket: %s, Quantity: %d, Original Price: RM%.2f, Discounted Price: RM%.2f, Subtotal: RM%.2f",
                $ticket ? $ticket->name : 'Unknown Ticket',
                $quantity,
                $originalPrice,
                $discountedPrice,
                $subtotal
            );
        })->implode(" | ");

        $billingDetail = $order->billingDetail;

        return [
            // Order Details
            $order->reference_number,
            number_format($order->total_amount, 2),
            number_format($order->processing_fee ?? 0, 2),
            ucfirst($order->payment_method ?? 'N/A'),
            $order->payment_id ?? 'N/A',
            $order->payment_country ?? 'N/A',
            ucfirst($order->status),
            $order->created_at->format('d M Y H:i:s'),

            // Basic Billing Details
            $billingDetail->first_name ?? 'N/A',
            $billingDetail->last_name ?? 'N/A',
            $billingDetail->email ?? 'N/A',
            $billingDetail->phone ?? 'N/A',
            $billingDetail->identity_number ?? 'N/A',
            $billingDetail->gender ?? 'N/A',
            $billingDetail->category ?? 'N/A',
            $billingDetail->country ?? 'N/A',
            $billingDetail->address1 ?? 'N/A',
            $billingDetail->address2 ?? 'N/A',
            $billingDetail->city ?? 'N/A',
            $billingDetail->state ?? 'N/A',
            $billingDetail->postcode ?? 'N/A',

            // Organization Details
            $billingDetail->company_name ?? 'N/A',
            $billingDetail->business_registration_number ?? 'N/A',
            $billingDetail->tax_number ?? 'N/A',

            // Academician Details
            $billingDetail->student_id ?? 'N/A',
            $billingDetail->academic_institution ?? 'N/A',

            // Purchased Tickets
            $ticketsInfo
        ];
    }

    public function title(): string
    {
        return 'Order Details';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2EFDA']
                ]
            ]
        ];
    }
} 