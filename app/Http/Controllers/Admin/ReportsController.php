<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Order;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportsController extends Controller
{
    public function index()
    {
        // Debug: Check orders and cart items
        $orders = Order::where('status', 'completed')->get();
        Log::info('Completed Orders:', ['count' => $orders->count()]);
        
        foreach ($orders as $order) {
            Log::info('Order Cart Items:', [
                'order_id' => $order->id,
                'cart_items' => $order->cart_items
            ]);
        }

        // Get ticket statistics
        $ticketStats = [
            'total_stock' => Ticket::sum('stock'),
            'total_sold' => $this->getTotalSold(),
            'monthly_sales' => $this->getMonthlySales(),
            'ticket_types' => $this->getTicketTypeStats(),
            'total_revenue' => Order::where('status', 'paid')
                ->selectRaw('SUM(total_amount - COALESCE(processing_fee, 0)) as total')
                ->value('total'),
        ];

        return view('admin.reports.index', compact('ticketStats'));
    }

    public function downloadPDF(Request $request)
    {
        try {
            $type = $request->type ?? 'all';
            $month = $request->month ?? Carbon::now()->month;
            $year = $request->year ?? Carbon::now()->year;

            Log::info('Generating PDF report', [
                'type' => $type,
                'month' => $month,
                'year' => $year
            ]);

            $data = [];
            
            switch ($type) {
                case 'tickets':
                    $data = [
                        'total_stock' => Ticket::sum('stock'),
                        'total_sold' => $this->getTotalSold(),
                        'ticket_types' => $this->getTicketTypeStats(),
                    ];
                    break;
                
                case 'sales':
                    $data = [
                        'monthly_sales' => $this->getMonthlySales($month, $year),
                        'total_revenue' => Order::where('status', 'paid')
                            ->whereMonth('created_at', $month)
                            ->whereYear('created_at', $year)
                            ->selectRaw('SUM(total_amount - COALESCE(processing_fee, 0)) as total')
                            ->value('total'),
                    ];
                    break;
                
                default:
                    $data = [
                        'total_stock' => Ticket::sum('stock'),
                        'total_sold' => $this->getTotalSold(),
                        'monthly_sales' => $this->getMonthlySales($month, $year),
                        'ticket_types' => $this->getTicketTypeStats(),
                        'total_revenue' => Order::where('status', 'paid')
                            ->whereMonth('created_at', $month)
                            ->whereYear('created_at', $year)
                            ->selectRaw('SUM(total_amount - COALESCE(processing_fee, 0)) as total')
                            ->value('total'),
                    ];
            }

            Log::info('Data prepared for PDF', ['data' => $data]);

            $pdf = PDF::loadView('admin.reports.pdf', compact('data', 'type', 'month', 'year'));
            
            $filename = 'report-' . $type . '-' . $month . '-' . $year . '.pdf';
            Log::info('PDF generated, attempting download', ['filename' => $filename]);

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('Error generating PDF report', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed to generate PDF report. Please try again.');
        }
    }

    private function getTotalSold()
    {
        $totalSold = 0;
        $orders = Order::where('status', 'paid')->get();

        foreach ($orders as $order) {
            $cartItems = $order->cart_items;
            foreach ($cartItems as $item) {
                if (isset($item['quantity'])) {
                    $totalSold += (int)$item['quantity'];
                }
            }
        }

        return $totalSold;
    }

    private function getMonthlySales($month = null, $year = null)
    {
        $query = Order::where('status', 'paid');
        
        if ($month && $year) {
            $query->whereMonth('created_at', $month)
                  ->whereYear('created_at', $year);
        }

        $orders = $query->get();
        $salesByDate = [];

        foreach ($orders as $order) {
            $date = $order->created_at->format('Y-m-d');
            $cartItems = $order->cart_items;
            $totalQuantity = 0;

            foreach ($cartItems as $item) {
                if (isset($item['quantity'])) {
                    $totalQuantity += (int)$item['quantity'];
                }
            }

            if (!isset($salesByDate[$date])) {
                $salesByDate[$date] = [
                    'total_quantity' => 0,
                    'total_amount' => 0
                ];
            }

            $salesByDate[$date]['total_quantity'] += $totalQuantity;
            $salesByDate[$date]['total_amount'] += ($order->total_amount - ($order->processing_fee ?? 0));
        }

        return collect($salesByDate)->map(function ($data, $date) {
            return (object)[
                'date' => $date,
                'total_quantity' => $data['total_quantity'],
                'total_amount' => $data['total_amount']
            ];
        })->values();
    }

    private function getTicketTypeStats()
    {
        $tickets = Ticket::select('id', 'name', 'stock', 'price', 'quantity_discounts')->get();
        $orders = Order::where('status', 'paid')->get();
        $ticketStats = [];

        foreach ($tickets as $ticket) {
            $sold = 0;
            $totalSales = 0;
            foreach ($orders as $order) {
                $cartItems = $order->cart_items;
                foreach ($cartItems as $item) {
                    if (isset($item['ticket_id']) && $item['ticket_id'] == $ticket->id && isset($item['quantity'])) {
                        $quantity = (int)$item['quantity'];
                        $sold += $quantity;

                        // Determine the price to use (with discount if available)
                        $price = (float)$ticket->price;
                        if (!empty($ticket->quantity_discounts) && is_array($ticket->quantity_discounts)) {
                            foreach ($ticket->quantity_discounts as $discount) {
                                $min = isset($discount['min']) ? $discount['min'] : null;
                                $max = isset($discount['max']) ? $discount['max'] : null;
                                if ($min !== null && $quantity >= $min && ($max === null || $quantity <= $max)) {
                                    $price = (float)$discount['price'];
                                    break;
                                }
                            }
                        }
                        $totalSales += $price * $quantity;
                    }
                }
            }

            $ticketStats[] = [
                'name' => $ticket->name,
                'stock' => $ticket->stock,
                'sold' => $sold,
                'total_sales' => $totalSales
            ];
        }

        return $ticketStats;
    }
} 