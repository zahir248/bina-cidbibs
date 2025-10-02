<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\BillingDetail;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Affiliate;
use App\Helpers\PaymentLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function index(Request $request)
    {
        // Check for success parameter and set session message
        if ($request->has('success') && $request->get('success') === 'participants_updated') {
            session()->flash('success', 'Participants updated successfully!');
        }

        $query = Order::with(['billingDetail', 'affiliate']);

        // Apply reference number search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('reference_number', 'like', "%{$search}%");
        }

        // Apply identity number filter
        if ($request->has('identity') && !empty($request->identity)) {
            $identity = $request->identity;
            $query->where(function($q) use ($identity) {
                $q->whereHas('billingDetail', function($billingQuery) use ($identity) {
                    $billingQuery->where('identity_number', 'like', "%{$identity}%");
                })->orWhereHas('participants', function($participantQuery) use ($identity) {
                    $participantQuery->where('identity_number', 'like', "%{$identity}%");
                });
            });
        }

        // Apply payment method filter
        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->where('payment_method', $request->payment_method);
        }

        // Apply payment country filter
        if ($request->has('payment_country') && !empty($request->payment_country)) {
            $query->where('payment_country', $request->payment_country);
        }

        // Apply date range filters
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->latest()->get();

        // Apply event filter
        if ($request->has('event') && $request->event !== 'all') {
            $eventFilter = $request->event;
            
            $orders = $orders->filter(function($order) use ($eventFilter) {
                foreach ($order->cart_items as $item) {
                    $ticket = \App\Models\Ticket::find($item['ticket_id']);
                    if ($ticket) {
                        $ticketName = strtolower($ticket->name);
                        switch ($eventFilter) {
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

        // Apply ticket filter
        if ($request->has('ticket') && !empty($request->ticket)) {
            $ticketId = $request->ticket;
            
            $orders = $orders->filter(function($order) use ($ticketId) {
                // Convert cart_items to array if it's not already
                $cartItems = is_array($order->cart_items) ? $order->cart_items : json_decode($order->cart_items, true);
                
                if (!is_array($cartItems)) {
                    return false;
                }
                
                foreach ($cartItems as $item) {
                    // Handle different possible structures
                    $itemTicketId = null;
                    
                    if (is_array($item)) {
                        // Direct array access
                        $itemTicketId = $item['ticket_id'] ?? $item['ticket']['id'] ?? null;
                    } elseif (is_object($item)) {
                        // Object access
                        $itemTicketId = $item->ticket_id ?? $item->ticket->id ?? null;
                    }
                    
                    if ($itemTicketId == $ticketId) {
                        return true;
                    }
                }
                return false;
            });
        }

        // Paginate the filtered results
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $totalItems = $orders->count();
        
        $orders = new \Illuminate\Pagination\LengthAwarePaginator(
            $orders->forPage($currentPage, $perPage),
            $totalItems,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $orders = $orders->through(function ($order) {
                $order->cart_items_count = count($order->cart_items);
                $order->ticket_ids = collect($order->cart_items)->pluck('ticket_id')->toArray();
                return $order;
            });
            
        $tickets = \App\Models\Ticket::select('id', 'name')->get();
            
        // Debug: Log available tickets
        \Log::info('Available tickets for filtering', [
            'tickets' => $tickets->toArray(),
            'requested_ticket' => $request->get('ticket')
        ]);
            
        return view('admin.orders.index', compact('orders', 'tickets', 'currentPage', 'perPage'));
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
            'participants' => 'nullable|array',
            'participants.*.full_name' => 'required|string|max:255',
            'participants.*.phone' => 'required|string|max:30',
            'participants.*.email' => 'required|email|max:255',
            'participants.*.gender' => 'required|in:male,female',
            'participants.*.company_name' => 'nullable|string|max:255',
            'participants.*.identity_number' => [
                'required',
                'string',
                'min:6',
                'max:20',
                'regex:/^[A-Za-z0-9]+$/',
            ],
            'participants.*.ticket_id' => 'required|exists:tickets,id',
            'participants.*.ticket_number' => 'required|integer|min:1',
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

            // Prepare order data
            $orderData = [
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
            ];

            // Handle affiliate tracking if affiliate code is provided
            if ($request->has('affiliate_code') && $request->affiliate_code) {
                $affiliate = Affiliate::where('affiliate_code', $request->affiliate_code)
                    ->where('is_active', true)
                    ->first();
                
                if ($affiliate) {
                    $orderData['affiliate_id'] = $affiliate->id;
                    $orderData['affiliate_code'] = $request->affiliate_code;
                    
                    // Update affiliate statistics
                    $affiliate->addConversion();
                }
            }

            // Create order with manual timestamp
            $order = Order::create($orderData);

            // Create participant records if provided
            if ($request->has('participants') && is_array($request->participants)) {
                foreach ($request->participants as $participantData) {
                    $participantData['order_id'] = $order->id;
                    \App\Models\Participant::create($participantData);
                }
                \Log::info('Created participant records for manual order', [
                    'order_id' => $order->id,
                    'participants_count' => count($request->participants)
                ]);
            }

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

    public function getParticipants(Order $order)
    {
        // Load all relationships in one query
        $order->load(['participants.ticket', 'billingDetail']);
        
        // Get all ticket IDs from cart items to fetch tickets in one query
        $ticketIds = collect($order->cart_items)->pluck('ticket_id')->unique();
        $tickets = \App\Models\Ticket::whereIn('id', $ticketIds)->get()->keyBy('id');
        
        $allParticipants = [];
        
        // Process each cart item to generate participant list
        foreach ($order->cart_items as $item) {
            $ticket = $tickets->get($item['ticket_id']);
            if (!$ticket) continue;
            
            // Get participants for this ticket
            $participants = $order->participants->where('ticket_id', $item['ticket_id']);
            
            for ($i = 1; $i <= $item['quantity']; $i++) {
                $participant = $participants->where('ticket_number', $i)->first();
                
                // If participant details exist, use them
                if ($participant) {
                    $allParticipants[] = [
                        'id' => $participant->id,
                        'full_name' => $participant->full_name,
                        'phone' => $participant->phone,
                        'email' => $participant->email,
                        'gender' => $participant->gender,
                        'company_name' => $participant->company_name,
                        'identity_number' => $participant->identity_number,
                        'ticket_id' => $item['ticket_id'],
                        'ticket_name' => $ticket->name,
                        'ticket_number' => $participant->ticket_number
                    ];
                } else {
                    // If no participant details, use purchaser info for first ticket only
                    if ($i === 1) {
                        $allParticipants[] = [
                            'id' => null,
                            'full_name' => $order->billingDetail->first_name . ' ' . $order->billingDetail->last_name,
                            'phone' => $order->billingDetail->phone,
                            'email' => $order->billingDetail->email,
                            'gender' => $order->billingDetail->gender,
                            'company_name' => $order->billingDetail->company_name ?? '',
                            'identity_number' => $order->billingDetail->identity_number,
                            'ticket_id' => $item['ticket_id'],
                            'ticket_name' => $ticket->name,
                            'ticket_number' => $i
                        ];
                    } else {
                        // For additional tickets, leave empty
                        $allParticipants[] = [
                            'id' => null,
                            'full_name' => '',
                            'phone' => '',
                            'email' => '',
                            'gender' => '',
                            'company_name' => '',
                            'identity_number' => '',
                            'ticket_id' => $item['ticket_id'],
                            'ticket_name' => $ticket->name,
                            'ticket_number' => $i
                        ];
                    }
                }
            }
        }
        
        return response()->json($allParticipants);
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
     * Download pending transactions log
     */
    public function downloadPendingLog()
    {
        $content = PaymentLogger::getPendingPaymentLogs();
        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="pending_transactions_' . date('Y-m-d') . '.log"');
    }

    /**
     * Generate attendance form PDF for an order
     */
    public function downloadSingleAttendanceForm(Order $order)
    {
        $order->load(['billingDetail', 'participants.ticket']);

        // Group cart items by ticket
        $ticketGroups = collect($order->cart_items)->groupBy('ticket_id')->map(function ($items, $ticketId) use ($order) {
            $ticket = \App\Models\Ticket::find($ticketId);
            $quantity = $items->sum('quantity');
            
            // Get participants for this ticket
            $participants = $order->participants->where('ticket_id', $ticketId);
            
            // Generate rows for each attendee
            $attendeeRows = [];
            for ($i = 0; $i < $quantity; $i++) {
                $participant = $participants->skip($i)->first();
                
                // If participant details exist, use them
                if ($participant) {
                    $attendeeRows[] = [
                        'no' => $i + 1,
                        'name' => $participant->full_name,
                        'email' => $participant->email,
                        'phone' => $participant->phone,
                        'company' => $participant->company_name,
                        'datetime' => $this->getEventDateTime($ticket->name, $eventName),
                        'signature' => '',
                        'check' => '' // For check/verification purpose
                    ];
                } else {
                    // If no participant details, use purchaser info for first ticket only
                    if ($i === 0) {
                        $attendeeRows[] = [
                            'no' => $i + 1,
                            'name' => $order->billingDetail->first_name . ' ' . $order->billingDetail->last_name,
                            'email' => $order->billingDetail->email,
                            'phone' => $order->billingDetail->phone,
                            'company' => $order->billingDetail->company_name ?? '',
                            'datetime' => $this->getEventDateTime($ticket->name, $eventName),
                            'signature' => '',
                            'check' => '' // For check/verification purpose
                        ];
                    } else {
                        // For additional tickets, leave empty
                        $attendeeRows[] = [
                            'no' => $i + 1,
                            'name' => '',
                            'email' => '',
                            'phone' => '',
                            'company' => '',
                            'datetime' => $this->getEventDateTime($ticket->name, $eventName),
                            'signature' => '',
                            'check' => '' // For check/verification purpose
                        ];
                    }
                }
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
        $pdf->setOption('margin-top', 0);
        $pdf->setOption('margin-right', 0);
        $pdf->setOption('margin-bottom', 0);
        $pdf->setOption('margin-left', 0);
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
        $orders = Order::with(['billingDetail', 'participants.ticket'])->get();
        
        // Debug: Log the total number of orders found
        \Log::info('Compiled attendance form - Total orders found: ' . $orders->count());
        \Log::info('Compiled attendance form - Event filter: ' . $event);
        
        // Debug: Log each order reference number
        foreach ($orders as $order) {
            \Log::info('Order found: ' . $order->reference_number . ' - Status: ' . $order->status . ' - Created: ' . $order->created_at);
        }
        
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
        
        // Debug: Log the number of orders after event filtering
        \Log::info('Compiled attendance form - Orders after event filtering: ' . $orders->count());
        
        // Debug: Log each order reference number after filtering
        foreach ($orders as $order) {
            \Log::info('Order after filtering: ' . $order->reference_number . ' - Status: ' . $order->status);
        }
        
        // Compile all orders' ticket information
        $compiledTicketGroups = [];
        
        // First, group all attendees by order reference
        $orderGroups = [];
        
        foreach ($orders as $order) {
            $orderRef = $order->reference_number;
            
            // Debug: Log each order being processed
            \Log::info('Processing order: ' . $orderRef . ' with ' . count($order->cart_items) . ' cart items');
            
            if (!isset($orderGroups[$orderRef])) {
                $orderGroups[$orderRef] = [
                    'order_ref' => $order->reference_number,
                    'order_date' => $order->created_at->format('d M Y'),
                    'purchaser_name' => $order->billingDetail->first_name . ' ' . $order->billingDetail->last_name,
                    'purchaser_email' => $order->billingDetail->email,
                    'purchaser_phone' => $order->billingDetail->phone,
                    'purchaser_identity_number' => $order->billingDetail->identity_number,
                    'attendees' => []
                ];
            }
            
            foreach ($order->cart_items as $item) {
                $ticket = Ticket::find($item['ticket_id']);
                $ticketId = $item['ticket_id'];
                
                // Debug: Log ticket information
                \Log::info('Processing ticket: ' . $ticket->name . ' (ID: ' . $ticketId . ') for order: ' . $orderRef);
                
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
                        \Log::info('Skipping ticket: ' . $ticket->name . ' for order: ' . $orderRef);
                        continue;
                    }
                    
                    \Log::info('Including ticket: ' . $ticket->name . ' for order: ' . $orderRef);
                }
                
                // Get participants for this ticket
                $participants = $order->participants->where('ticket_id', $item['ticket_id']);
                
                // Add attendees to the order group
                for ($i = 1; $i <= $item['quantity']; $i++) {
                    $participant = $participants->skip($i - 1)->first();
                    
                    // Debug: Log attendee generation
                    \Log::info('Generating attendee ' . $i . ' for ticket: ' . $ticket->name . ' in order: ' . $orderRef . ' - Participant found: ' . ($participant ? 'Yes' : 'No'));
                    
                    // If participant details exist, use them
                    if ($participant) {
                        $orderGroups[$orderRef]['attendees'][] = [
                            'name' => $participant->full_name,
                            'email' => $participant->email,
                            'phone' => $participant->phone,
                            'company' => $participant->company_name,
                            'datetime' => $this->getEventDateTime($ticket->name, null), // Will be updated later with event context
                            'ticket_name' => $ticket->name, // Store ticket name for later use
                            'signature' => ''
                        ];
                    } else {
                        // If no participant details, use purchaser info for first ticket only
                        if ($i === 1) {
                            $orderGroups[$orderRef]['attendees'][] = [
                                'name' => $order->billingDetail->first_name . ' ' . $order->billingDetail->last_name,
                                'email' => $order->billingDetail->email,
                                'phone' => $order->billingDetail->phone,
                                'company' => $order->billingDetail->company_name ?? '',
                                'datetime' => $this->getEventDateTime($ticket->name, null), // Will be updated later with event context
                                'ticket_name' => $ticket->name, // Store ticket name for later use
                                'signature' => ''
                            ];
                        } else {
                            // For additional tickets, leave empty
                            $orderGroups[$orderRef]['attendees'][] = [
                                'name' => '',
                                'email' => '',
                                'phone' => '',
                                'company' => '',
                                'datetime' => $this->getEventDateTime($ticket->name, null), // Will be updated later with event context
                                'ticket_name' => $ticket->name, // Store ticket name for later use
                                'signature' => ''
                            ];
                        }
                    }
                }
            }
        }
        
        // Debug: Log the order groups before event processing
        \Log::info('Order groups before event processing: ' . count($orderGroups));
        foreach ($orderGroups as $orderRef => $orderData) {
            \Log::info('Order group: ' . $orderRef . ' with ' . count($orderData['attendees']) . ' attendees');
        }
        
        // Now process the grouped orders by event
        foreach ($orderGroups as $orderRef => $orderData) {
            // Determine which events this order belongs to
            $orderEvents = [];
            
            // Debug: Log order being processed for event distribution
            \Log::info('Processing order ' . $orderRef . ' for event distribution');
            
            foreach ($orders as $order) {
                if ($order->reference_number === $orderRef) {
                    foreach ($order->cart_items as $item) {
                        $ticket = Ticket::find($item['ticket_id']);
                        $ticketName = strtolower($ticket->name);
                        
                        // Debug: Log ticket being checked for event distribution
                        \Log::info('Checking ticket: ' . $ticket->name . ' for event distribution in order: ' . $orderRef);
                        
                        // Check if this ticket matches the current event filter
                        $shouldInclude = false;
                        
                        if ($event === 'all') {
                            if (str_contains($ticketName, 'facility management') && !str_contains($ticketName, 'industry')) {
                                $orderEvents['Facility Management Engagement Day'] = true;
                                \Log::info('Adding to Facility Management Engagement Day');
                            } elseif (str_contains($ticketName, 'modular asia')) {
                                $orderEvents['Modular Asia Forum & Exhibition'] = true;
                                \Log::info('Adding to Modular Asia Forum & Exhibition');
                            } elseif (str_contains($ticketName, 'industry')) {
                                $orderEvents['Sarawak Facility Management Engagement Day'] = true;
                                \Log::info('Adding to Sarawak Facility Management Engagement Day');
                            }
                        } else {
                            switch ($event) {
                                case 'industry':
                                    if (str_contains($ticketName, 'industry')) {
                                        $orderEvents['Sarawak Facility Management Engagement Day'] = true;
                                        \Log::info('Adding to Sarawak Facility Management Engagement Day (industry filter)');
                                    }
                                    break;
                                case 'facility':
                                    if (str_contains($ticketName, 'facility management') && !str_contains($ticketName, 'industry')) {
                                        $orderEvents['Facility Management Engagement Day'] = true;
                                        \Log::info('Adding to Facility Management Engagement Day (facility filter)');
                                    }
                                    if (str_contains($ticketName, 'combo')) {
                                        $orderEvents['Facility Management Engagement Day'] = true;
                                        \Log::info('Adding combo ticket to Facility Management Engagement Day (facility filter)');
                                    }
                                    break;
                                case 'modular':
                                    if (str_contains($ticketName, 'modular asia')) {
                                        $orderEvents['Modular Asia Forum & Exhibition'] = true;
                                        \Log::info('Adding to Modular Asia Forum & Exhibition (modular filter)');
                                    }
                                    if (str_contains($ticketName, 'combo')) {
                                        $orderEvents['Modular Asia Forum & Exhibition'] = true;
                                        \Log::info('Adding combo ticket to Modular Asia Forum & Exhibition (modular filter)');
                                    }
                                    break;
                            }
                        }
                    }
                }
            }
            
            // Debug: Log the events this order will be added to
            \Log::info('Order ' . $orderRef . ' will be added to events: ' . implode(', ', array_keys($orderEvents)));
            
            // Add the order to each relevant event
            foreach ($orderEvents as $eventName => $include) {
                if (!isset($compiledTicketGroups[$eventName])) {
                    $compiledTicketGroups[$eventName] = [
                        'ticket_name' => $eventName,
                        'quantity' => 0,
                        'orders' => []
                    ];
                }
                
                // Create a copy of order data and update datetime for combo tickets
                $orderDataCopy = $orderData;
                foreach ($orderDataCopy['attendees'] as &$attendee) {
                    if (isset($attendee['ticket_name']) && str_contains(strtolower($attendee['ticket_name']), 'combo')) {
                        $attendee['datetime'] = $this->getEventDateTime($attendee['ticket_name'], $eventName);
                    }
                    // Remove the ticket_name from the final output
                    unset($attendee['ticket_name']);
                }
                
                $compiledTicketGroups[$eventName]['orders'][] = $orderDataCopy;
                $compiledTicketGroups[$eventName]['quantity'] += count($orderDataCopy['attendees']);
                
                // Debug: Log the addition to compiled groups
                \Log::info('Added order ' . $orderRef . ' to ' . $eventName . ' with ' . count($orderDataCopy['attendees']) . ' attendees');
            }
        }

        // Debug: Log the final compiled ticket groups
        \Log::info('Final compiled ticket groups: ' . count($compiledTicketGroups));
        foreach ($compiledTicketGroups as $eventName => $group) {
            \Log::info('Event: ' . $eventName . ' - Orders: ' . count($group['orders']) . ' - Total attendees: ' . $group['quantity']);
            foreach ($group['orders'] as $order) {
                \Log::info('  - Order: ' . $order['order_ref'] . ' with ' . count($order['attendees']) . ' attendees');
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
        $pdf->setOption('margin-top', 0);
        $pdf->setOption('margin-right', 0);
        $pdf->setOption('margin-bottom', 0);
        $pdf->setOption('margin-left', 0);
        $pdf->setOption('enable-local-file-access', true);
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);

        $filename = "attendance-form-" . str_replace(' ', '-', strtolower($eventNames[$event] ?? 'all-events')) . "-" . now()->format('Y-m-d') . ".pdf";
        return $pdf->download($filename);
    }

    /**
     * Get event date/time based on ticket name and event context
     */
    private function getEventDateTime($ticketName, $eventContext = null)
    {
        $ticketName = strtolower($ticketName);
        
        // Check if it's Sarawak Facility Management Engagement Day
        if (str_contains($ticketName, 'industry')) {
            return '4/9/2025';
        }
        
        // Check if it's Facility Management Engagement Day
        if (str_contains($ticketName, 'facility management') && !str_contains($ticketName, 'industry')) {
            return '29/10/2025';
        }
        
        // Check if it's Modular Asia Forum & Exhibition
        if (str_contains($ticketName, 'modular asia')) {
            return '30/10/2025';
        }
        
        // Handle combo tickets based on event context
        if (str_contains($ticketName, 'combo')) {
            if ($eventContext === 'Facility Management Engagement Day') {
                return '29/10/2025';
            } elseif ($eventContext === 'Modular Asia Forum & Exhibition') {
                return '30/10/2025';
            }
        }
        
        // For other events, return empty (manual entry)
        return '';
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

    /**
     * Update participants for an order
     */
    public function updateParticipants(Request $request, Order $order)
    {
        try {
            // Get the request data - handle both JSON and form data
            $data = $request->all();
            
            // Log the incoming data for debugging
            \Log::info('Update participants request data', [
                'order_id' => $order->id,
                'data' => $data,
                'content_type' => $request->header('Content-Type')
            ]);

            // Convert flat form data to nested array structure
            $participants = [];
            foreach ($data as $key => $value) {
                if (preg_match('/^participants\[(\d+)\]\[([^\]]+)\]$/', $key, $matches)) {
                    $participantIndex = $matches[1];
                    $fieldName = $matches[2];
                    
                    if (!isset($participants[$participantIndex])) {
                        $participants[$participantIndex] = [];
                    }
                    
                    $participants[$participantIndex][$fieldName] = $value;
                }
            }

            // Log the converted participants data
            \Log::info('Converted participants data', [
                'participants' => $participants
            ]);

            // Validate the converted data
            $validator = \Validator::make(['participants' => $participants], [
                'participants' => 'required|array',
                'participants.*.full_name' => 'required|string|max:255',
                'participants.*.phone' => 'required|string|max:30',
                'participants.*.email' => 'required|email|max:255',
                'participants.*.company_name' => 'nullable|string|max:255',
                'participants.*.identity_number' => [
                    'required',
                    'string',
                    'min:6',
                    'max:20',
                    'regex:/^[A-Za-z0-9]+$/',
                ],
                'participants.*.ticket_id' => 'required|exists:tickets,id',
                'participants.*.ticket_number' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Delete existing participants for this order
            $order->participants()->delete();

            // Create new participants
            foreach ($participants as $participantData) {
                // Skip if the participant data is just "-" (placeholder)
                if (isset($participantData['full_name']) && $participantData['full_name'] === '-') {
                    continue;
                }
                
                $participantData['order_id'] = $order->id;
                \App\Models\Participant::create($participantData);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Participants updated successfully',
                'redirect' => true
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Failed to update participants', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update participants: ' . $e->getMessage()
            ], 500);
        }
    }
} 