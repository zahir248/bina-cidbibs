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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $event = $request->query('event', 'all');
        
        // Get orders based on event type
        $orders = Order::where('status', 'paid');
        
        if ($event !== 'all') {
            $orders = $orders->get()->filter(function ($order) use ($event) {
                foreach ($order->cart_items as $item) {
                    $ticket = Ticket::find($item['ticket_id']);
                    if ($ticket) {
                        $ticketName = strtolower($ticket->name);
                        switch ($event) {
                            case 'bina':
                                if ((str_contains($ticketName, 'facility management') && !str_contains($ticketName, 'industry')) ||
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
        } else {
            $orders = $orders->get();
        }

        // Get ticket statistics
        $ticketStats = [
            'total_stock' => $this->getTotalStock($event),
            'total_sold' => $this->getTotalSold($event),
            'monthly_sales' => $this->getMonthlySales(null, null, $event),
            'ticket_types' => $this->getTicketTypeStats($event),
            'total_revenue' => $this->getTotalRevenue($event),
        ];

        return view('admin.reports.index', compact('ticketStats', 'event'));
    }

    public function downloadPDF(Request $request)
    {
        try {
            $event = $request->event ?? 'all';

            Log::info('Generating PDF report', [
                'event' => $event
            ]);

            $data = [
                'total_stock' => $this->getTotalStock($event),
                'total_sold' => $this->getTotalSold($event),
                'ticket_types' => $this->getTicketTypeStats($event),
                'total_revenue' => $this->getTotalRevenue($event),
                'monthly_sales' => $this->getMonthlySales(null, null, $event)
            ];

            Log::info('Data prepared for PDF', ['data' => $data]);

            $pdf = PDF::loadView('admin.reports.pdf', compact('data', 'event'));
            
            $eventName = match($event) {
                'bina' => 'BINA-Events',
                'industry' => 'Sarawak-FM-Day',
                default => 'All-Events'
            };
            
            $filename = "{$eventName}-Report-" . Carbon::now()->format('Y-m-d') . ".pdf";
            
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

    public function downloadExcel(Request $request)
    {
        try {
            $event = $request->event ?? 'all';

            Log::info('Generating Excel report', [
                'event' => $event
            ]);

            $data = [
                'total_stock' => $this->getTotalStock($event),
                'total_sold' => $this->getTotalSold($event),
                'ticket_types' => $this->getTicketTypeStats($event),
                'total_revenue' => $this->getTotalRevenue($event),
                'monthly_sales' => $this->getMonthlySales(null, null, $event)
            ];

            $eventName = match($event) {
                'bina' => 'BINA-Events',
                'industry' => 'Sarawak-FM-Day',
                default => 'All-Events'
            };
            
            $fileName = "{$eventName}-Report-" . date('Y-m-d') . '.xlsx';

            return Excel::download(new ReportsExport($data, 'all'), $fileName);
        } catch (\Exception $e) {
            Log::error('Error generating Excel report: ' . $e->getMessage());
            return back()->with('error', 'Error generating Excel report. Please try again.');
        }
    }

    private function getTotalStock($event = 'all')
    {
        $query = Ticket::query();

        if ($event !== 'all') {
            $query->where(function($q) use ($event) {
                switch ($event) {
                    case 'bina':
                        $q->where(function($q) {
                            $q->whereRaw('LOWER(name) LIKE ?', ['%facility management%'])
                              ->whereRaw('LOWER(name) NOT LIKE ?', ['%industry%'])
                              ->orWhereRaw('LOWER(name) LIKE ?', ['%modular asia%'])
                              ->orWhereRaw('LOWER(name) LIKE ?', ['%combo%']);
                        });
                        break;
                    case 'industry':
                        $q->whereRaw('LOWER(name) LIKE ?', ['%industry%']);
                        break;
                }
            });
        }

        return $query->sum('stock');
    }

    private function getTotalSold($event = 'all')
    {
        $totalSold = 0;
        $orders = Order::where('status', 'paid')->get();

        foreach ($orders as $order) {
            foreach ($order->cart_items as $item) {
                if (isset($item['quantity'])) {
                    $ticket = Ticket::find($item['ticket_id']);
                    if ($ticket) {
                        $ticketName = strtolower($ticket->name);
                        $shouldCount = true;

                        if ($event !== 'all') {
                            $shouldCount = false;
                            switch ($event) {
                                case 'bina':
                                    if ((str_contains($ticketName, 'facility management') && !str_contains($ticketName, 'industry')) ||
                                        str_contains($ticketName, 'modular asia') ||
                                        str_contains($ticketName, 'combo')) {
                                        $shouldCount = true;
                                    }
                                    break;
                                case 'industry':
                                    if (str_contains($ticketName, 'industry')) {
                                        $shouldCount = true;
                                    }
                                    break;
                            }
                        }

                        if ($shouldCount) {
                            $totalSold += (int)$item['quantity'];
                        }
                    }
                }
            }
        }

        return $totalSold;
    }

    private function getMonthlySales($month = null, $year = null, $event = 'all')
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
            $totalQuantity = 0;
            $totalAmount = 0;

            foreach ($order->cart_items as $item) {
                if (isset($item['quantity'])) {
                    $ticket = Ticket::find($item['ticket_id']);
                    if ($ticket) {
                        $ticketName = strtolower($ticket->name);
                        $shouldCount = true;

                        if ($event !== 'all') {
                            $shouldCount = false;
                            switch ($event) {
                                case 'bina':
                                    if ((str_contains($ticketName, 'facility management') && !str_contains($ticketName, 'industry')) ||
                                        str_contains($ticketName, 'modular asia') ||
                                        str_contains($ticketName, 'combo')) {
                                        $shouldCount = true;
                                    }
                                    break;
                                case 'industry':
                                    if (str_contains($ticketName, 'industry')) {
                                        $shouldCount = true;
                                    }
                                    break;
                            }
                        }

                        if ($shouldCount) {
                            $totalQuantity += (int)$item['quantity'];
                            // Calculate price with any applicable discounts
                            $price = (float)$ticket->price;
                            if (!empty($ticket->quantity_discounts) && is_array($ticket->quantity_discounts)) {
                                foreach ($ticket->quantity_discounts as $discount) {
                                    $min = isset($discount['min']) ? $discount['min'] : null;
                                    $max = isset($discount['max']) ? $discount['max'] : null;
                                    if ($min !== null && $item['quantity'] >= $min && ($max === null || $item['quantity'] <= $max)) {
                                        $price = (float)$discount['price'];
                                        break;
                                    }
                                }
                            }
                            $totalAmount += ($item['quantity'] * $price);
                        }
                    }
                }
            }

            if (!isset($salesByDate[$date])) {
                $salesByDate[$date] = [
                    'date' => $date,
                    'total' => 0
                ];
            }

            $salesByDate[$date]['total'] += $totalAmount;
        }

        // Sort by date in reverse chronological order
        krsort($salesByDate);

        return array_values($salesByDate);
    }

    private function getTotalRevenue($event = 'all', $month = null, $year = null)
    {
        $query = Order::where('status', 'paid');

        if ($month && $year) {
            $query->whereMonth('created_at', $month)
                  ->whereYear('created_at', $year);
        }

        $orders = $query->get();
        $totalRevenue = 0;

        foreach ($orders as $order) {
            foreach ($order->cart_items as $item) {
                if (isset($item['quantity'])) {
                    $ticket = Ticket::find($item['ticket_id']);
                    if ($ticket) {
                        $ticketName = strtolower($ticket->name);
                        $shouldCount = true;

                        if ($event !== 'all') {
                            $shouldCount = false;
                            switch ($event) {
                                case 'bina':
                                    if ((str_contains($ticketName, 'facility management') && !str_contains($ticketName, 'industry')) ||
                                        str_contains($ticketName, 'modular asia') ||
                                        str_contains($ticketName, 'combo')) {
                                        $shouldCount = true;
                                    }
                                    break;
                                case 'industry':
                                    if (str_contains($ticketName, 'industry')) {
                                        $shouldCount = true;
                                    }
                                    break;
                            }
                        }

                        if ($shouldCount) {
                            // Calculate price with any applicable discounts
                            $price = (float)$ticket->price;
                            if (!empty($ticket->quantity_discounts) && is_array($ticket->quantity_discounts)) {
                                foreach ($ticket->quantity_discounts as $discount) {
                                    $min = isset($discount['min']) ? $discount['min'] : null;
                                    $max = isset($discount['max']) ? $discount['max'] : null;
                                    if ($min !== null && $item['quantity'] >= $min && ($max === null || $item['quantity'] <= $max)) {
                                        $price = (float)$discount['price'];
                                        break;
                                    }
                                }
                            }
                            $totalRevenue += ($item['quantity'] * $price);
                        }
                    }
                }
            }
        }

        return $totalRevenue;
    }

    private function getTicketTypeStats($event = 'all')
    {
        $query = Ticket::select('id', 'name', 'stock', 'price', 'quantity_discounts');

        if ($event !== 'all') {
            $query->where(function($q) use ($event) {
                switch ($event) {
                    case 'bina':
                        $q->where(function($q) {
                            $q->whereRaw('LOWER(name) LIKE ?', ['%facility management%'])
                              ->whereRaw('LOWER(name) NOT LIKE ?', ['%industry%'])
                              ->orWhereRaw('LOWER(name) LIKE ?', ['%modular asia%'])
                              ->orWhereRaw('LOWER(name) LIKE ?', ['%combo%']);
                        });
                        break;
                    case 'industry':
                        $q->whereRaw('LOWER(name) LIKE ?', ['%industry%']);
                        break;
                }
            });
        }

        $tickets = $query->get();
        $orders = Order::where('status', 'paid')->get();
        $ticketStats = [];

        foreach ($tickets as $ticket) {
            $sold = 0;
            $totalSales = 0;

            foreach ($orders as $order) {
                foreach ($order->cart_items as $item) {
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