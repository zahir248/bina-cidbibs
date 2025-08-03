<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParticipantsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Get all participants (real + virtual) without pagination first
        $allParticipants = collect();
        
        // Get real participants
        $realParticipants = Participant::query()
            ->with(['order.billingDetail', 'ticket'])
            ->get();
        $allParticipants = $allParticipants->merge($realParticipants);
        
        // Get orders with participants to identify which orders need purchaser fallback
        $ordersWithParticipants = \App\Models\Order::whereHas('participants')->pluck('id')->toArray();
        
        // Get orders without participants but with paid status
        $ordersWithoutParticipants = \App\Models\Order::where('status', 'paid')
            ->whereNotIn('id', $ordersWithParticipants)
            ->with(['billingDetail'])
            ->get();

        // Create virtual participants from purchaser data for orders without participants
        foreach ($ordersWithoutParticipants as $order) {
            foreach ($order->cart_items as $item) {
                $ticket = \App\Models\Ticket::find($item['ticket_id']);
                if (!$ticket) continue;
                
                $quantity = $item['quantity'];
                
                // For each ticket quantity, create a virtual participant
                for ($i = 0; $i < $quantity; $i++) {
                    // Only use purchaser data for the first ticket, leave others empty
                    if ($i === 0) {
                        $virtualParticipant = new \App\Models\Participant([
                            'id' => 'virtual_' . $order->id . '_' . $i,
                            'full_name' => $order->billingDetail->first_name . ' ' . $order->billingDetail->last_name,
                            'phone' => $order->billingDetail->phone,
                            'email' => $order->billingDetail->email,
                            'gender' => null,
                            'company_name' => $order->billingDetail->company_name,
                            'identity_number' => $order->billingDetail->identity_number,
                            'ticket_number' => null,
                        ]);
                        $virtualParticipant->order = $order;
                        $virtualParticipant->ticket = $ticket;
                        $virtualParticipant->is_virtual = true;
                        $allParticipants->push($virtualParticipant);
                    } else {
                        // Empty participant for additional tickets
                        $virtualParticipant = new \App\Models\Participant([
                            'id' => 'virtual_' . $order->id . '_' . $i,
                            'full_name' => '',
                            'phone' => '',
                            'email' => '',
                            'gender' => null,
                            'company_name' => '',
                            'identity_number' => '',
                            'ticket_number' => null,
                        ]);
                        $virtualParticipant->order = $order;
                        $virtualParticipant->ticket = $ticket;
                        $virtualParticipant->is_virtual = true;
                        $allParticipants->push($virtualParticipant);
                    }
                }
            }
        }

        // Sort by latest (most recent orders first)
        $allParticipants = $allParticipants->sortByDesc(function($participant) {
            return $participant->order->created_at;
        });

        return $allParticipants;
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Phone',
            'Email',
            'Gender',
            'Company Name',
            'Identity Number',
            'Ticket Name',
            'Ticket Price',
            'Order Reference',
            'Order Date',
            'Order Amount'
        ];
    }

    public function map($participant): array
    {
        return [
            $participant->full_name,
            $participant->phone ?? '-',
            $participant->email ?? '-',
            ucfirst($participant->gender ?? '-'),
            $participant->company_name ?? '-',
            $participant->identity_number ?? '-',
            $participant->ticket->name ?? '-',
            $participant->ticket->price ? 'RM ' . number_format($participant->ticket->price, 2) : '-',
            $participant->order->reference_number ?? '-',
            $participant->order->created_at ? $participant->order->created_at->format('d M Y H:i') : '-',
            $participant->order->total_amount ? 'RM ' . number_format($participant->order->total_amount, 2) : '-'
        ];
    }
} 