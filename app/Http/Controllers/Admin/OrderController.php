<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\BillingDetail;
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
            ->get()
            ->map(function ($order) {
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
} 