<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    public function show()
    {
        return view('admin.scanner.index');
    }

    public function verify(Request $request)
    {
        try {
            $data = json_decode($request->input('data'), true);
            
            if (!$data || !isset($data['ref']) || !isset($data['tkt'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid QR code format'
                ]);
            }

            $order = Order::with(['billingDetail', 'participants'])->where('reference_number', $data['ref'])->first();

            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ticket not found'
                ]);
            }

            // Check if the ticket exists in the order's cart items
            $ticketFound = false;
            $ticketQuantity = 0;
            $ticketDetails = null;
            foreach ($order->cart_items as $item) {
                $ticket = \App\Models\Ticket::find($item['ticket_id']);
                if ($ticket && $ticket->name === $data['tkt']) {
                    $ticketFound = true;
                    $ticketQuantity = $item['quantity'];
                    $ticketDetails = [
                        'name' => $ticket->name,
                        'quantity' => $item['quantity'],
                        'price' => number_format($ticket->price, 2),
                        'discounted_price' => number_format($ticket->getDiscountedPrice($item['quantity']), 2)
                    ];
                    break;
                }
            }

            if (!$ticketFound) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ticket does not match order'
                ]);
            }

            // Format billing details
            $billingDetail = $order->billingDetail;
            $billingInfo = [
                'name' => trim($billingDetail->first_name . ' ' . $billingDetail->last_name),
                'email' => $billingDetail->email ?? 'N/A',
                'phone' => $billingDetail->phone ?? 'N/A',
                'gender' => $billingDetail->gender ?? 'N/A',
                'category' => $billingDetail->category ?? 'N/A',
                'address' => array_filter([
                    $billingDetail->address1,
                    $billingDetail->address2
                ]),
                'city' => $billingDetail->city ?? 'N/A',
                'state' => $billingDetail->state ?? 'N/A',
                'country' => $billingDetail->country ?? 'N/A',
                'postcode' => $billingDetail->postcode ?? 'N/A'
            ];

            // Add business/academic fields if they exist
            if ($billingDetail->company_name) {
                $billingInfo['business'] = [
                    'company_name' => $billingDetail->company_name,
                    'registration_number' => $billingDetail->business_registration_number ?? 'N/A',
                    'tax_number' => $billingDetail->tax_number ?? 'N/A'
                ];
            }

            if ($billingDetail->academic_institution) {
                $billingInfo['academic'] = [
                    'institution' => $billingDetail->academic_institution,
                    'student_id' => $billingDetail->student_id ?? 'N/A'
                ];
            }

            // Format participant details - same logic as admin side
            $participants = [];
            
            // Get all ticket IDs from cart items to fetch tickets in one query
            $ticketIds = collect($order->cart_items)->pluck('ticket_id')->unique();
            $tickets = \App\Models\Ticket::whereIn('id', $ticketIds)->get()->keyBy('id');
            
            // Process each cart item to generate participant list
            foreach ($order->cart_items as $item) {
                $ticket = $tickets->get($item['ticket_id']);
                if (!$ticket) continue;
                
                // Get participants for this ticket
                $ticketParticipants = $order->participants->where('ticket_id', $item['ticket_id']);
                
                for ($i = 1; $i <= $item['quantity']; $i++) {
                    $participant = $ticketParticipants->where('ticket_number', $i)->first();
                    
                    // If participant details exist, use them
                    if ($participant) {
                        $participants[] = [
                            'full_name' => $participant->full_name ?? 'N/A',
                            'phone' => $participant->phone ?? 'N/A',
                            'email' => $participant->email ?? 'N/A',
                            'gender' => $participant->gender ?? 'N/A',
                            'company_name' => $participant->company_name ?? 'N/A',
                            'identity_number' => $participant->identity_number ?? 'N/A',
                            'ticket_number' => $participant->ticket_number ?? 'N/A',
                            'ticket_name' => $ticket->name
                        ];
                    } else {
                        // If no participant details, use purchaser info for first ticket only
                        if ($i === 1) {
                            $participants[] = [
                                'full_name' => trim($billingDetail->first_name . ' ' . $billingDetail->last_name),
                                'phone' => $billingDetail->phone ?? 'N/A',
                                'email' => $billingDetail->email ?? 'N/A',
                                'gender' => $billingDetail->gender ?? 'N/A',
                                'company_name' => $billingDetail->company_name ?? 'N/A',
                                'identity_number' => $billingDetail->identity_number ?? 'N/A',
                                'ticket_number' => $i,
                                'ticket_name' => $ticket->name
                            ];
                        } else {
                            // For additional tickets, leave empty
                            $participants[] = [
                                'full_name' => 'N/A',
                                'phone' => 'N/A',
                                'email' => 'N/A',
                                'gender' => 'N/A',
                                'company_name' => 'N/A',
                                'identity_number' => 'N/A',
                                'ticket_number' => $i,
                                'ticket_name' => $ticket->name
                            ];
                        }
                    }
                }
            }

            // Format order details
            $orderInfo = [
                'reference' => $data['ref'],
                'status' => $order->status,
                'created_at' => $order->created_at->format('d F Y, h:i A'),
                'ticket' => $ticketDetails,
                'payment' => [
                    'method' => $order->payment_method ?? 'N/A',
                    'subtotal' => number_format($order->total_amount - ($order->processing_fee ?? 0), 2),
                    'processing_fee' => number_format($order->processing_fee ?? 0, 2),
                    'total_amount' => number_format($order->total_amount, 2)
                ]
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Valid ticket',
                'data' => [
                    'order' => $orderInfo,
                    'billing' => $billingInfo,
                    'participants' => $participants
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error verifying ticket'
            ]);
        }
    }
} 