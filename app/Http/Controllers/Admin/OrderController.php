<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\BillingDetail;
use App\Models\Ticket;
use App\Models\User;
use App\Helpers\PaymentLogger;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OrdersExport;
use App\Exports\IndividualOrderExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

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
                $order->ticket_ids = collect($order->cart_items)->pluck('ticket_id')->toArray();
                return $order;
            });
            
        $tickets = \App\Models\Ticket::select('id', 'name')->get();
            
        return view('admin.orders.index', compact('orders', 'tickets'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $tickets = Ticket::where('stock', '>', 0)->get();
        $users = User::all();
        return view('admin.orders.create', compact('tickets', 'users'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
            'category' => 'required|in:individual,organization,academician',
            'country' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postcode' => 'required|string|max:20',
            'identity_number' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'business_registration_number' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:255',
            'student_id' => 'nullable|string|max:255',
            'academic_institution' => 'nullable|string|max:255',
            'reference_number' => 'required|string|max:255|unique:orders,reference_number',
            'order_date' => 'required|date',
            'order_time' => 'required|date_format:H:i',
            'tickets' => 'required|array|min:1',
            'tickets.*.ticket_id' => 'required|exists:tickets,id',
            'tickets.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:stripe,toyyibpay,cash,bank_transfer',
            'payment_country' => 'nullable|string|max:255',
            'processing_fee' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ], [
            'reference_number.unique' => 'This reference number already exists. Please choose a different one.',
            'reference_number.required' => 'Reference number is required.',
            'order_date.required' => 'Order date is required.',
            'order_date.date' => 'Please enter a valid date.',
            'order_time.required' => 'Order time is required.',
            'order_time.date_format' => 'Please enter a valid time format (HH:MM).',
        ]);

        try {
            \DB::beginTransaction();

            // Create billing details
            $billingDetail = BillingDetail::create([
                'user_id' => $request->user_id ?: null,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'category' => $request->category,
                'country' => $request->country,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'city' => $request->city,
                'state' => $request->state,
                'postcode' => $request->postcode,
                'identity_number' => $request->identity_number,
                'company_name' => $request->company_name,
                'business_registration_number' => $request->business_registration_number,
                'tax_number' => $request->tax_number,
                'student_id' => $request->student_id,
                'academic_institution' => $request->academic_institution,
            ]);

            // Calculate total amount
            $totalAmount = 0;
            $cartItems = [];

            foreach ($request->tickets as $ticketData) {
                $ticket = Ticket::find($ticketData['ticket_id']);
                $quantity = $ticketData['quantity'];
                
                // Check stock availability
                if ($ticket->stock < $quantity) {
                    throw new \Exception("Insufficient stock for ticket: {$ticket->name}. Available: {$ticket->stock}, Requested: {$quantity}");
                }

                // Calculate discounted price
                $discountedPrice = $ticket->getDiscountedPrice($quantity);
                $subtotal = $discountedPrice * $quantity;
                $totalAmount += $subtotal;

                $cartItems[] = [
                    'ticket_id' => $ticket->id,
                    'quantity' => $quantity,
                    'price' => $ticket->price,
                    'discounted_price' => $discountedPrice,
                    'subtotal' => $subtotal,
                ];

                // Update stock
                $ticket->decrement('stock', $quantity);
            }

            // Add processing fee if provided
            $processingFee = $request->processing_fee ?? 0;
            $totalAmount += $processingFee;

            // Use admin-provided reference number
            $referenceNumber = $request->reference_number;

            // Combine date and time for order creation timestamp
            $orderDateTime = $request->order_date . ' ' . $request->order_time . ':00';

            // Create order with manual timestamp
            $order = Order::create([
                'billing_detail_id' => $billingDetail->id,
                'reference_number' => $referenceNumber,
                'total_amount' => $totalAmount,
                'status' => 'paid', // Since this is manually created, mark as paid
                'cart_items' => $cartItems,
                'payment_method' => $request->payment_method,
                'payment_country' => $request->payment_country,
                'processing_fee' => $processingFee,
                'payment_id' => 'MANUAL-' . time(), // Manual payment ID
                'created_at' => $orderDateTime,
                'updated_at' => $orderDateTime,
            ]);

            \DB::commit();

            // Generate QR codes for the order
            try {
                $order->generateTicketQRCodes();
            } catch (\Exception $e) {
                \Log::warning('Failed to generate QR codes for order: ' . $referenceNumber, [
                    'error' => $e->getMessage()
                ]);
                // Don't fail the order creation if QR generation fails
            }

            return redirect()->route('admin.orders.index')
                ->with('success', "Order created successfully with reference number: {$referenceNumber}");

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Failed to create order: ' . $e->getMessage()]);
        }
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
                'ticket_id' => $ticket->id,
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

        try {
            // Generate QR codes
            $qrCodes = $order->generateTicketQRCodes();
            
            // Add absolute paths for PDF generation
            $qrCodesWithPaths = array_map(function($qrCode) {
                $qrCode['qr_code_path'] = public_path('storage/' . $qrCode['filename']);
                return $qrCode;
            }, $qrCodes);

            // Prepare billing data
            $billingData = [
                'first_name' => $order->billingDetail->first_name,
                'last_name' => $order->billingDetail->last_name,
                'gender' => $order->billingDetail->gender,
                'category' => $order->billingDetail->category,
                'identity_number' => $order->billingDetail->identity_number,
                'company_name' => $order->billingDetail->company_name,
                'business_registration_number' => $order->billingDetail->business_registration_number,
                'tax_number' => $order->billingDetail->tax_number,
                'email' => $order->billingDetail->email,
                'phone' => $order->billingDetail->phone,
                'address1' => $order->billingDetail->address1,
                'address2' => $order->billingDetail->address2,
                'city' => $order->billingDetail->city,
                'state' => $order->billingDetail->state,
                'postcode' => $order->billingDetail->postcode,
                'country' => $order->billingDetail->country,
            ];

            // Generate PDF with QR codes
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('emails.order-confirmation-pdf', [
                'billingData' => $billingData,
                'referenceNo' => $order->reference_number,
                'cartItems' => $order->cart_items,
                'qrCodes' => $qrCodesWithPaths,
                'orderDate' => $order->created_at,
                'order' => $order
            ]);

            // Configure PDF options
            $pdf->setOption(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->setPaper('a4');
            $pdf->setOption('margin-top', 10);
            $pdf->setOption('margin-right', 10);
            $pdf->setOption('margin-bottom', 10);
            $pdf->setOption('margin-left', 10);

            $filename = "order-{$order->reference_number}.pdf";
            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('Failed to generate order PDF with QR codes', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Fallback to original PDF without QR codes
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
        $pdf->setOption('margin-top', 10);
        $pdf->setOption('margin-right', 10);
        $pdf->setOption('margin-bottom', 10);
        $pdf->setOption('margin-left', 10);
        $pdf->setOption('enable-local-file-access', true);
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);

        $filename = "attendance-form-{$order->reference_number}.pdf";
        return $pdf->download($filename);
    }

    /**
     * Generate compiled attendance form PDF for all orders
     */
    public function downloadCompiledAttendanceForm(Request $request)
    {
        $event = $request->query('event', 'all');
        $orders = Order::with('billingDetail')->get();
        
        // Filter orders based on event type
        if ($event !== 'all') {
            $orders = $orders->filter(function ($order) use ($event) {
                foreach ($order->cart_items as $item) {
                    $ticket = Ticket::find($item['ticket_id']);
                    if ($ticket) {
                        $ticketName = strtolower($ticket->name);
                        switch ($event) {
                            case 'industry':
                                if (str_contains($ticketName, 'industry')) {
                                    return true;
                                }
                                break;
                            case 'facility':
                                // Include both facility management tickets and combo tickets
                                if (str_contains($ticketName, 'facility management') && 
                                    !str_contains($ticketName, 'industry')) {
                                    return true;
                                }
                                if (str_contains($ticketName, 'combo')) {
                                    return true;
                                }
                                break;
                            case 'modular':
                                // Include both modular asia tickets and combo tickets
                                if (str_contains($ticketName, 'modular asia')) {
                                    return true;
                                }
                                if (str_contains($ticketName, 'combo')) {
                                    return true;
                                }
                                break;
                        }
                    }
                }
                return false;
            });
        }
        
        // Compile all orders' ticket information
        $compiledTicketGroups = [];
        
        foreach ($orders as $order) {
            foreach ($order->cart_items as $item) {
                $ticket = Ticket::find($item['ticket_id']);
                $ticketId = $item['ticket_id'];
                
                // Skip tickets that don't match the event filter
                if ($event !== 'all') {
                    $ticketName = strtolower($ticket->name);
                    $shouldSkip = false;
                    
                    switch ($event) {
                        case 'industry':
                            $shouldSkip = !str_contains($ticketName, 'industry');
                            break;
                        case 'facility':
                            // Include both facility management tickets and combo tickets
                            $shouldSkip = !(str_contains($ticketName, 'facility management') && 
                                          !str_contains($ticketName, 'industry')) && 
                                        !str_contains($ticketName, 'combo');
                            break;
                        case 'modular':
                            // Include both modular asia tickets and combo tickets
                            $shouldSkip = !str_contains($ticketName, 'modular asia') && 
                                        !str_contains($ticketName, 'combo');
                            break;
                    }
                    
                    if ($shouldSkip) {
                        continue;
                    }
                }
                
                            // Determine the event name for grouping
            $eventName = '';
            $ticketName = strtolower($ticket->name);
            
            if ($event === 'all') {
                // For 'all' events, group by actual event type
                if (str_contains($ticketName, 'facility management') && !str_contains($ticketName, 'industry')) {
                    $eventName = 'Facility Management Engagement Day';
                } elseif (str_contains($ticketName, 'modular asia')) {
                    $eventName = 'Modular Asia Forum & Exhibition';
                } elseif (str_contains($ticketName, 'industry')) {
                    $eventName = 'Sarawak Facility Management Engagement Day';
                } elseif (str_contains($ticketName, 'combo')) {
                    // For combo tickets in 'all' view, we'll show them in both events
                    // We'll handle this by creating separate entries
                    $eventName = 'Combo (Both Events)';
                }
            } else {
                // For specific events, use the event name
                $eventNames = [
                    'facility' => 'Facility Management Engagement Day',
                    'modular' => 'Modular Asia Forum & Exhibition',
                    'industry' => 'Sarawak Facility Management Engagement Day'
                ];
                $eventName = $eventNames[$event] ?? 'Unknown Event';
            }
            
            // Special handling for combo tickets in 'all' view - add to both events
            if ($event === 'all' && str_contains($ticketName, 'combo')) {
                // Add to Facility Management Engagement Day
                if (!isset($compiledTicketGroups['Facility Management Engagement Day'])) {
                    $compiledTicketGroups['Facility Management Engagement Day'] = [
                        'ticket_name' => 'Facility Management Engagement Day',
                        'quantity' => 0,
                        'orders' => []
                    ];
                }
                
                // Add to Modular Asia Forum & Exhibition
                if (!isset($compiledTicketGroups['Modular Asia Forum & Exhibition'])) {
                    $compiledTicketGroups['Modular Asia Forum & Exhibition'] = [
                        'ticket_name' => 'Modular Asia Forum & Exhibition',
                        'quantity' => 0,
                        'orders' => []
                    ];
                }
                
                // Add the order to both events
                $orderData = [
                    'order_ref' => $order->reference_number,
                    'order_date' => $order->created_at->format('d M Y'),
                    'purchaser_name' => $order->billingDetail->first_name . ' ' . $order->billingDetail->last_name,
                    'purchaser_email' => $order->billingDetail->email,
                    'purchaser_phone' => $order->billingDetail->phone,
                    'purchaser_identity_number' => $order->billingDetail->identity_number,
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
                
                $compiledTicketGroups['Facility Management Engagement Day']['orders'][] = $orderData;
                $compiledTicketGroups['Facility Management Engagement Day']['quantity'] += $item['quantity'];
                
                $compiledTicketGroups['Modular Asia Forum & Exhibition']['orders'][] = $orderData;
                $compiledTicketGroups['Modular Asia Forum & Exhibition']['quantity'] += $item['quantity'];
                
                // Skip the normal processing for combo tickets in 'all' view
                continue;
            }
            
            // Use event name as the group key for non-combo tickets
            $groupKey = $eventName;
            
            if (!isset($compiledTicketGroups[$groupKey])) {
                $compiledTicketGroups[$groupKey] = [
                    'ticket_name' => $eventName,
                    'quantity' => 0,
                    'orders' => []
                ];
            }
                
                // Group attendees by order reference
                $compiledTicketGroups[$groupKey]['orders'][] = [
                    'order_ref' => $order->reference_number,
                    'order_date' => $order->created_at->format('d M Y'),
                    'purchaser_name' => $order->billingDetail->first_name . ' ' . $order->billingDetail->last_name,
                    'purchaser_email' => $order->billingDetail->email,
                    'purchaser_phone' => $order->billingDetail->phone,
                    'purchaser_identity_number' => $order->billingDetail->identity_number,
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
                
                $compiledTicketGroups[$groupKey]['quantity'] += $item['quantity'];
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

        $eventNames = [
            'all' => 'All Events',
            'facility' => 'Facility Management Engagement Day',
            'modular' => 'Modular Asia Forum & Exhibition',
            'industry' => 'Sarawak Facility Management Engagement Day'
        ];

        $pdf = PDF::loadView('admin.orders.attendance-form', [
            'ticketGroups' => $compiledTicketGroups,
            'isSingleOrder' => false,
            'totalOrders' => $orders->count(),
            'eventName' => $eventNames[$event] ?? 'All Events'
        ]);

        $pdf->setPaper('a4');
        $pdf->setOption('margin-top', 10);
        $pdf->setOption('margin-right', 10);
        $pdf->setOption('margin-bottom', 10);
        $pdf->setOption('margin-left', 10);
        $pdf->setOption('enable-local-file-access', true);
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);

        $filename = "attendance-form-" . str_replace(' ', '-', strtolower($eventNames[$event] ?? 'all-events')) . "-" . now()->format('Y-m-d') . ".pdf";
        return $pdf->download($filename);
    }

    /**
     * Download orders data as Excel file
     */
    public function downloadExcel(Request $request)
    {
        $event = $request->query('event', 'all');
        $eventNames = [
            'all' => 'All Events',
            'bina' => 'BINA Events',
            'industry' => 'Sarawak Facility Management Engagement Day'
        ];
        
        $filename = 'orders-';
        if ($event === 'all') {
            $filename .= 'all-events';
        } else {
            $filename .= strtolower(str_replace([' & ', ' '], ['-', '-'], $eventNames[$event] ?? 'all-events'));
        }
        $filename .= '-' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new OrdersExport($event), $filename);
    }

    /**
     * Download individual order data as Excel file
     */
    public function downloadIndividualExcel(Order $order)
    {
        $filename = 'order-' . $order->reference_number . '-' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new IndividualOrderExport($order), $filename);
    }
} 