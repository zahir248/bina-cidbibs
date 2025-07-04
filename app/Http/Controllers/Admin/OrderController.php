<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\BillingDetail;
use App\Helpers\PaymentLogger;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('billingDetail')
            ->latest()
            ->paginate(10)
            ->through(function ($order) {
                $order->cart_items_count = count($order->cart_items);
                return $order;
            });
            
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Get billing details for modal
     */
    public function getBillingDetails($id)
    {
        $billingDetail = BillingDetail::findOrFail($id);
        return response()->json($billingDetail);
    }

    /**
     * Get order items for modal
     */
    public function getOrderItems(Order $order)
    {
        $items = collect($order->cart_items)->map(function ($item) {
            $ticket = \App\Models\Ticket::find($item['ticket_id']);
            $quantity = $item['quantity'];
            $originalPrice = $ticket->price;
            $discountedPrice = $ticket->getDiscountedPrice($quantity);
            $discountedSubtotal = $discountedPrice * $quantity;
            return [
                'ticket_name' => $ticket->name,
                'quantity' => $quantity,
                'price' => $originalPrice,
                'discounted_price' => $discountedPrice,
                'subtotal' => $discountedSubtotal
            ];
        });

        return response()->json($items);
    }

    public function downloadPdf(Order $order)
    {
        $order->load('billingDetail');

        $cartItems = collect($order->cart_items)->map(function ($item) {
            $ticket = \App\Models\Ticket::find($item['ticket_id']);
            $quantity = $item['quantity'];
            $originalPrice = $ticket->price;
            $discountedPrice = $ticket->getDiscountedPrice($quantity);
            $subtotal = $discountedPrice * $quantity;

            return [
                'ticket_name' => $ticket->name,
                'quantity' => $quantity,
                'original_price' => $originalPrice,
                'discounted_price' => $discountedPrice,
                'subtotal' => $subtotal,
            ];
        });

        $originalSubtotal = $cartItems->sum(function($item) {
            return $item['original_price'] * $item['quantity'];
        });
        $discountedSubtotal = $cartItems->sum('subtotal');
        $discount = $originalSubtotal - $discountedSubtotal;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.orders.pdf', [
            'order' => $order,
            'billingDetail' => $order->billingDetail,
            'cartItems' => $cartItems,
            'originalSubtotal' => $originalSubtotal,
            'discount' => $discount,
            'discountedSubtotal' => $discountedSubtotal,
        ]);

        $pdf->setPaper('a4');
        $pdf->setOption('margin-top', 10);
        $pdf->setOption('margin-right', 10);
        $pdf->setOption('margin-bottom', 10);
        $pdf->setOption('margin-left', 10);

        $filename = "order-{$order->reference_number}.pdf";
        return $pdf->download($filename);
    }

    /**
     * Download successful transactions log
     */
    public function downloadSuccessLog()
    {
        $content = PaymentLogger::getSuccessfulPaymentLogs();
        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="successful_transactions_' . date('Y-m-d') . '.log"');
    }

    /**
     * Download failed transactions log
     */
    public function downloadFailedLog()
    {
        $content = PaymentLogger::getFailedPaymentLogs();
        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="failed_transactions_' . date('Y-m-d') . '.log"');
    }

    /**
     * Generate attendance form PDF for an order
     */
    public function downloadSingleAttendanceForm(Order $order)
    {
        $order->load('billingDetail');

        // Group cart items by ticket
        $ticketGroups = collect($order->cart_items)->groupBy('ticket_id')->map(function ($items, $ticketId) {
            $ticket = \App\Models\Ticket::find($ticketId);
            $quantity = $items->sum('quantity');
            
            // Generate rows for each attendee
            $attendeeRows = [];
            for ($i = 1; $i <= $quantity; $i++) {
                $attendeeRows[] = [
                    'no' => $i,
                    'name' => '', // Will be filled during the event
                    'email' => '',
                    'phone' => '',
                    'signature' => '',
                    'check' => '' // For check/verification purpose
                ];
            }

            return [
                'ticket_name' => $ticket->name,
                'quantity' => $quantity,
                'attendees' => $attendeeRows
            ];
        });

        $pdf = PDF::loadView('admin.orders.attendance-form', [
            'order' => $order,
            'billingDetail' => $order->billingDetail,
            'ticketGroups' => $ticketGroups,
            'eventDate' => now()->format('d F Y'),
            'isSingleOrder' => true
        ]);

        $pdf->setPaper('a4');
        $pdf->setOption('margin-top', 15);
        $pdf->setOption('margin-right', 15);
        $pdf->setOption('margin-bottom', 15);
        $pdf->setOption('margin-left', 15);

        $filename = "attendance-form-{$order->reference_number}.pdf";
        return $pdf->download($filename);
    }

    /**
     * Generate compiled attendance form PDF for all orders
     */
    public function downloadCompiledAttendanceForm()
    {
        $orders = Order::with('billingDetail')->get();
        
        // Compile all orders' ticket information
        $compiledTicketGroups = [];
        
        foreach ($orders as $order) {
            foreach ($order->cart_items as $item) {
                $ticket = \App\Models\Ticket::find($item['ticket_id']);
                $ticketId = $item['ticket_id'];
                
                if (!isset($compiledTicketGroups[$ticketId])) {
                    $compiledTicketGroups[$ticketId] = [
                        'ticket_name' => $ticket->name,
                        'quantity' => 0,
                        'orders' => []
                    ];
                }
                
                // Group attendees by order reference
                $compiledTicketGroups[$ticketId]['orders'][] = [
                    'order_ref' => $order->reference_number,
                    'order_date' => $order->created_at->format('d M Y'),
                    'purchaser_name' => $order->billingDetail->first_name . ' ' . $order->billingDetail->last_name,
                    'purchaser_email' => $order->billingDetail->email,
                    'purchaser_phone' => $order->billingDetail->phone,
                    'quantity' => $item['quantity'],
                    'attendees' => array_map(function($index) {
                        return [
                            'name' => '',
                            'email' => '',
                            'phone' => '',
                            'signature' => ''
                        ];
                    }, range(1, $item['quantity']))
                ];
                
                $compiledTicketGroups[$ticketId]['quantity'] += $item['quantity'];
            }
        }

        // Sort orders within each ticket group by date (newest first) then by reference
        foreach ($compiledTicketGroups as &$group) {
            usort($group['orders'], function($a, $b) {
                $dateCompare = strtotime($b['order_date']) - strtotime($a['order_date']);
                if ($dateCompare === 0) {
                    return strcmp($a['order_ref'], $b['order_ref']);
                }
                return $dateCompare;
            });
        }

        $pdf = PDF::loadView('admin.orders.attendance-form', [
            'ticketGroups' => $compiledTicketGroups,
            'eventDate' => now()->format('d F Y'),
            'isSingleOrder' => false,
            'totalOrders' => $orders->count()
        ]);

        $pdf->setPaper('a4');
        $pdf->setOption('margin-top', 15);
        $pdf->setOption('margin-right', 15);
        $pdf->setOption('margin-bottom', 15);
        $pdf->setOption('margin-left', 15);

        $filename = "attendance-form-" . now()->format('Y-m-d') . ".pdf";
        return $pdf->download($filename);
    }
} 