<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $event;

    public function __construct($event = 'all')
    {
        $this->event = $event;
    }

    public function collection()
    {
        $orders = Order::with(['billingDetail', 'participants.ticket'])->get();

        if ($this->event !== 'all') {
            $orders = $orders->filter(function ($order) {
                foreach ($order->cart_items as $item) {
                    $ticket = Ticket::find($item['ticket_id']);
                    if ($ticket) {
                        $ticketName = strtolower($ticket->name);
                        switch ($this->event) {
                            case 'bina':
                                if (str_contains($ticketName, 'facility management') && !str_contains($ticketName, 'industry') ||
                                    str_contains($ticketName, 'modular asia') ||
                                    str_contains($ticketName, 'combo')) {
                                    return true;
                                }
                                break;
                            case 'industry':
                                if (str_contains($ticketName, 'industry')) {
                                    return true;
                                }
                                break;
                        }
                    }
                }
                return false;
            });
        }

        return $orders;
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
            'Tickets Details',

            // Participant Details
            'Participant Details'
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

        // Format participants information with fallback logic
        $allParticipants = [];
        
        // Process each cart item to generate participant list
        foreach ($order->cart_items as $item) {
            $ticket = Ticket::find($item['ticket_id']);
            $participants = $order->participants->where('ticket_id', $item['ticket_id']);
            
            for ($i = 1; $i <= $item['quantity']; $i++) {
                $participant = $participants->skip($i - 1)->first();
                
                // If participant details exist, use them
                if ($participant) {
                    $allParticipants[] = sprintf(
                        "Name: %s, Phone: %s, Email: %s, Gender: %s, Company: %s, Identity: %s, Ticket: %s",
                        $participant->full_name,
                        $participant->phone,
                        $participant->email,
                        $participant->gender ?: 'N/A',
                        $participant->company_name ?: 'N/A',
                        $participant->identity_number,
                        $ticket->name
                    );
                } else {
                    // If no participant details, use purchaser info for first ticket only
                    if ($i === 1) {
                        $allParticipants[] = sprintf(
                            "Name: %s, Phone: %s, Email: %s, Gender: %s, Company: %s, Identity: %s, Ticket: %s (Purchaser)",
                            $billingDetail->first_name . ' ' . $billingDetail->last_name,
                            $billingDetail->phone,
                            $billingDetail->email,
                            $billingDetail->gender ?: 'N/A',
                            $billingDetail->company_name ?: 'N/A',
                            $billingDetail->identity_number,
                            $ticket->name
                        );
                    } else {
                        // For additional tickets, show as empty
                        $allParticipants[] = sprintf(
                            "Name: %s, Phone: %s, Email: %s, Gender: %s, Company: %s, Identity: %s, Ticket: %s (Empty)",
                            'N/A',
                            'N/A',
                            'N/A',
                            'N/A',
                            'N/A',
                            'N/A',
                            $ticket->name
                        );
                    }
                }
            }
        }
        
        $participantsInfo = implode(" | ", $allParticipants);

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
            $ticketsInfo,

            // Participant Details
            $participantsInfo ?: 'No participants'
        ];
    }
} 