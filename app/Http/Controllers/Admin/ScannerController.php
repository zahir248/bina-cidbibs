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

            $order = Order::with('billingDetail')->where('reference_number', $data['ref'])->first();

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
                    'billing' => $billingInfo
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