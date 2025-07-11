<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BillingDetail;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Ticket;
use App\Helpers\PaymentLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckoutController extends Controller
{
    // Show the checkout form
    public function show(Request $request)
    {
        $query = CartItem::with('ticket');
        
        if (auth()->check()) {
            // If user is logged in, get items by user_id or session_id
            $query->where(function($q) use ($request) {
                $q->where('user_id', auth()->id())
                  ->orWhere('session_id', $request->session()->getId());
            });
        } else {
            // If user is not logged in, get items by session_id only
            $query->where('session_id', $request->session()->getId());
        }
        
        $cartItems = $query->get();

        // Check stock availability for all items
        $stockErrors = [];
        foreach ($cartItems as $item) {
            if (!$item->ticket->hasEnoughStock($item->quantity)) {
                $stockErrors[] = "{$item->ticket->name}: only {$item->ticket->stock} available (you have {$item->quantity} in cart)";
            }
        }
        
            if (!empty($stockErrors)) {
        $errorMessage = "Stock availability issues:\n\n" . implode("\n", $stockErrors) . "\n\nPlease update your cart.";
        return redirect()->route('client.cart.index')->with('error', $errorMessage);
    }
        
        $cartTotal = $cartItems->sum(function($item) {
            return $item->ticket->getDiscountedPrice($item->quantity) * $item->quantity;
        });
        return view('client.store.checkout', compact('cartItems', 'cartTotal'));
    }

    // Process the checkout form
    public function process(Request $request)
    {
        \Log::info('Checkout process started', ['input' => $request->all()]);

        $validationRules = [
            'first_name' => [
                'required',
                'string',
                'max:10', // Limiting first name to 10 characters
                function ($attribute, $value, $fail) use ($request) {
                    // Check if combined name length exceeds 20 characters
                    $fullName = $value . ' ' . $request->input('last_name');
                    if (strlen($fullName) > 20) {
                        $fail('Please use shorter first and last names. Combined name should not exceed 20 characters.');
                    }
                },
            ],
            'last_name' => [
                'required',
                'string',
                'max:10', // Limiting last name to 10 characters
            ],
            'gender' => 'required|in:male,female',
            'category' => 'required|in:individual,academician,organization',
            'identity_number' => [
                'required',
                'string',
                'min:6',
                'max:20',
                'regex:/^[A-Za-z0-9]+$/',
            ],
            'country' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postcode' => 'required|string|max:20',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|max:255',
            'payment_method' => 'required|in:toyyibpay,stripe',
        ];

        // Add B2B validation rules if organization is selected
        if ($request->input('category') === 'organization') {
            $validationRules['company_name'] = [
                'required',
                'string',
                'max:30', // Limiting company name to match ToyyibPay's limit
            ];
            $validationRules['business_registration_number'] = 'required|string|max:50';
            $validationRules['tax_number'] = 'nullable|string|max:50';
        }

        // Add academician validation rules if academician is selected
        if ($request->input('category') === 'academician') {
            $validationRules['student_id'] = 'required|string|max:50';
            $validationRules['academic_institution'] = 'required|string|max:255';
        }

        $validated = $request->validate($validationRules, [
            'first_name.max' => 'First name should not exceed 10 characters.',
            'last_name.max' => 'Last name should not exceed 10 characters.',
            'company_name.max' => 'Company name should not exceed 30 characters.',
        ]);
        
        // Add user_id to billing data if user is logged in
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }
        
        \Log::info('Validation passed', ['validated' => $validated]);

        // Get cart total
        $query = CartItem::with('ticket');
        
        if (auth()->check()) {
            // If user is logged in, get items by user_id or session_id
            $query->where(function($q) use ($request) {
                $q->where('user_id', auth()->id())
                  ->orWhere('session_id', $request->session()->getId());
            });
        } else {
            // If user is not logged in, get items by session_id only
            $query->where('session_id', $request->session()->getId());
        }
        
        $cartItems = $query->get();
        $cartTotal = $cartItems->sum(function($item) {
            return $item->ticket->getDiscountedPrice($item->quantity) * $item->quantity;
        });

        \Log::info('Cart total calculated', ['cart_total' => $cartTotal, 'cart_items' => $cartItems->toArray()]);

        // Store billing and cart info in session for callback
        session([
            'pending_billing' => $validated,
            'pending_cart' => $cartItems->toArray(),
            'pending_cart_total' => $cartTotal,
        ]);

        if ($validated['payment_method'] === 'toyyibpay') {
            return $this->processToyyibPay($validated, $cartTotal);
        } else {
            return $this->processStripe($validated, $cartTotal);
        }
    }

    private function processToyyibPay($validated, $cartTotal)
    {
        // Format phone number for ToyyibPay
        $phone = preg_replace('/[^0-9]/', '', $validated['phone']);
        if (strpos($phone, '0') === 0) {
            $phone = '6' . substr($phone, 1);
        }

        // Create a bill name that won't exceed 30 characters
        $customerName = $validated['first_name'] . ' ' . $validated['last_name'];
        $billName = 'Order-' . substr($customerName, 0, 23); // "Order-" takes 6 chars, leaving 24 for name

        // Prepare ToyyibPay bill data
        $billData = [
            'userSecretKey' => config('services.toyyibpay.secret_key'),
            'categoryCode' => config('services.toyyibpay.category_code'),
            'billName' => $billName,
            'billDescription' => 'Ticket purchase',
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => $cartTotal * 100, // Convert to cents for ToyyibPay
            'billReturnUrl' => url('/payment/callback'),
            'billCallbackUrl' => url('/payment/callback'),
            'billExternalReferenceNo' => uniqid('ORDER-'),
            'billTo' => $validated['first_name'] . ' ' . $validated['last_name'],
            'billEmail' => $validated['email'],
            'billPhone' => $phone,
        ];

        // Enable FPX B2B for organizations
        if ($validated['category'] === 'organization') {
            $billData['enableFPXB2B'] = '1';  // Enable FPX Corporate Banking
            $billData['chargeFPXB2B'] = '1';  // Charge on bill owner
            // Add company name to bill description but ensure it doesn't exceed limit
            $companyBillName = 'Order-' . substr($validated['company_name'], 0, 23);
            $billData['billName'] = $companyBillName;
            $billData['billDescription'] = 'Ticket purchase - ' . $validated['company_name'];
            $billData['billTo'] = $validated['company_name'];
        }

        \Log::info('ToyyibPay bill data', $billData);

        try {
            $response = Http::asForm()->withOptions(['verify' => false])->post('https://toyyibpay.com/index.php/api/createBill', $billData);
            $result = $response->json();
            \Log::info('ToyyibPay response', ['result' => $result]);

            if (isset($result[0]['BillCode'])) {
                $billCode = $result[0]['BillCode'];
                \Log::info('Redirecting to ToyyibPay', ['bill_code' => $billCode]);
                return redirect('https://toyyibpay.com/' . $billCode);
            } else {
                PaymentLogger::logFailedPayment(
                    'toyyibpay',
                    'FAILED',
                    'Bill creation failed - No bill code returned',
                    [
                        'customer_name' => $validated['first_name'] . ' ' . $validated['last_name'],
                        'customer_email' => $validated['email'],
                        'amount' => $cartTotal,
                        'response' => $result
                    ]
                );
                return back()->with('error', 'Payment gateway error. Please try again.');
            }
        } catch (\Exception $e) {
            PaymentLogger::logFailedPayment(
                'toyyibpay',
                'ERROR',
                'API Error: ' . $e->getMessage(),
                [
                    'customer_name' => $validated['first_name'] . ' ' . $validated['last_name'],
                    'customer_email' => $validated['email'],
                    'amount' => $cartTotal
                ]
            );
            \Log::error('ToyyibPay API error', ['exception' => $e]);
            return back()->with('error', 'Payment gateway error. Please try again.');
        }
    }

    private function processStripe($validated, $cartTotal)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Calculate processing fee based on country
            $processingFee = 0;
            $country = $validated['country'];
            
            if ($country === 'Malaysia') {
                // 3% + RM1.00 for domestic
                $processingFee = ($cartTotal * 0.03) + 1.00;
            } else {
                // 4% + RM1.00 for international (3% + 1% international fee)
                $processingFee = ($cartTotal * 0.04) + 1.00;
                // Add 2% if currency conversion is needed
                $processingFee += ($cartTotal * 0.02);
            }

            // Calculate total amount including fees
            $totalWithFees = $cartTotal + $processingFee;

            // Create a PaymentIntent with the total including fees
            $paymentIntent = PaymentIntent::create([
                'amount' => round($totalWithFees * 100), // Convert to cents for Stripe
                'currency' => 'myr',
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never'
                ],
                'metadata' => [
                    'order_id' => uniqid('ORDER-'),
                    'customer_name' => $validated['first_name'] . ' ' . $validated['last_name'],
                    'customer_email' => $validated['email'],
                    'processing_fee' => $processingFee,
                    'country' => $country,
                ],
            ]);

            // Store the payment intent ID in session
            session(['stripe_payment_intent_id' => $paymentIntent->id]);

            return view('client.store.stripe-payment', [
                'clientSecret' => $paymentIntent->client_secret,
                'publicKey' => config('services.stripe.key'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Stripe API error', ['exception' => $e]);
            return back()->with('error', 'Payment gateway error. Please try again.');
        }
    }

    public function stripeCallback(Request $request)
    {
        try {
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            
            // Get session data
            $billingData = session('pending_billing');
            $cartItems = session('pending_cart');
            $cartTotal = session('pending_cart_total');
            
            if (empty($cartItems) || empty($billingData)) {
                PaymentLogger::logFailedPayment(
                    'stripe',
                    'ERROR',
                    'Missing cart items or billing information',
                    [
                        'customer_email' => $billingData['email'] ?? 'Unknown',
                        'amount' => $cartTotal ?? 0
                    ]
                );
                return redirect()->route('client.cart.index')->with('error', 'No items in cart or missing billing information.');
            }

            // Get the payment intent ID from the request
            $payment_intent = null;
            if ($request->has('payment_intent')) {
                $payment_intent = $stripe->paymentIntents->retrieve($request->payment_intent);
            }

            if (!$payment_intent) {
                PaymentLogger::logFailedPayment(
                    'stripe',
                    'ERROR',
                    'Payment intent not found',
                    [
                        'customer_name' => $billingData['first_name'] . ' ' . $billingData['last_name'],
                        'customer_email' => $billingData['email'],
                        'amount' => $cartTotal
                    ]
                );
                return redirect()->route('client.cart.index')->with('error', 'Payment failed. Please try again.');
            }

            $country = $request->country;
            $calculatedTotal = floatval($request->calculated_total);
            
            if ($payment_intent->status === 'succeeded') {
                try {
                    DB::beginTransaction();

                    // Save billing details
                    $billing = BillingDetail::create($billingData);

                    // Create order
                    $order = Order::create([
                        'billing_detail_id' => $billing->id,
                        'reference_number' => 'STR-' . strtoupper(uniqid()),
                        'total_amount' => $calculatedTotal,
                        'status' => 'paid',
                        'cart_items' => $cartItems,
                        'payment_id' => $payment_intent->id,
                        'payment_method' => 'stripe',
                        'payment_country' => $country,
                        'processing_fee' => $calculatedTotal - $cartTotal
                    ]);

                    // Log successful payment
                    PaymentLogger::logSuccessfulPayment(
                        'stripe',
                        $order->reference_number,
                        $calculatedTotal,
                        [
                            'customer_name' => $billingData['first_name'] . ' ' . $billingData['last_name'],
                            'customer_email' => $billingData['email'],
                            'payment_country' => $country,
                            'processing_fee' => $calculatedTotal - $cartTotal,
                            'payment_intent_id' => $payment_intent->id,
                            'items_count' => count($cartItems),
                            'order_id' => $order->id
                        ]
                    );

                    // Update ticket stock
                    foreach ($cartItems as $item) {
                        $ticket = \App\Models\Ticket::find($item['ticket']['id']);
                        if ($ticket) {
                            if (!$ticket->reduceStock($item['quantity'])) {
                                throw new \Exception("Not enough stock for {$ticket->name}");
                            }
                        }
                    }

                    // Send confirmation email
                    try {
                        // Generate QR codes first and validate
                        $qrCodes = $order->generateTicketQRCodes();
                        
                        // Validate that QR codes were generated successfully
                        if (empty($qrCodes)) {
                            throw new \Exception('Failed to generate QR codes');
                        }
                        
                        // Validate each QR code
                        foreach ($qrCodes as $qrCode) {
                            if (empty($qrCode['qr_code']) || !is_string($qrCode['qr_code'])) {
                                throw new \Exception('Invalid QR code generated');
                            }
                        }

                        // If QR codes are valid, send the email
                        $this->sendOrderConfirmationEmail($order, $billingData);

                    } catch (\Exception $e) {
                        \Log::error('Failed to send order confirmation email', [
                            'error' => $e->getMessage(),
                            'email' => $billingData['email'],
                            'trace' => $e->getTraceAsString()
                        ]);

                        // Don't throw the exception - we still want to complete the order
                        // but let's notify admin about the email failure
                        \Log::channel('slack')->error('Order email failed but order completed', [
                            'order_id' => $order->id,
                            'email' => $billingData['email'],
                            'error' => $e->getMessage()
                        ]);
                    }

                    // Clear session data
                    session()->forget(['pending_billing', 'pending_cart', 'pending_cart_total', 'stripe_payment_intent_id']);
                    
                    // Clear cart items
                    if (auth()->check()) {
                        CartItem::where(function($query) {
                            $query->where('user_id', auth()->id())
                                  ->orWhere('session_id', session()->getId());
                        })->delete();
                    } else {
                        CartItem::where('session_id', session()->getId())->delete();
                    }

                    DB::commit();

                    return redirect()->route('client.store')->with([
                        'show_modal' => true,
                        'modal_type' => 'success',
                        'modal_title' => 'Payment Successful!',
                        'modal_message' => 'Your order details will be sent to your email address. Thank you for your purchase.'
                    ]);

                } catch (\Exception $e) {
                    DB::rollBack();
                    \Log::error('Error processing Stripe payment: ' . $e->getMessage());
                    return redirect()->route('client.cart.index')->with('error', 'An error occurred while processing your order. Please contact support.');
                }
            } else {
                PaymentLogger::logFailedPayment(
                    'stripe',
                    'FAILED',
                    'Payment intent status: ' . $payment_intent->status,
                    [
                        'customer_name' => $billingData['first_name'] . ' ' . $billingData['last_name'],
                        'customer_email' => $billingData['email'],
                        'amount' => $cartTotal,
                        'payment_intent_id' => $payment_intent->id,
                        'payment_intent_status' => $payment_intent->status,
                        'last_payment_error' => $payment_intent->last_payment_error ? $payment_intent->last_payment_error->message : null
                    ]
                );
                return redirect()->route('client.cart.index')->with('error', 'Payment failed. Please try again.');
            }
        } catch (\Exception $e) {
            PaymentLogger::logFailedPayment(
                'stripe',
                'ERROR',
                'Stripe callback error: ' . $e->getMessage(),
                [
                    'customer_name' => $billingData['first_name'] . ' ' . $billingData['last_name'] ?? 'Unknown',
                    'customer_email' => $billingData['email'] ?? 'Unknown',
                    'amount' => $cartTotal ?? 0
                ]
            );
            \Log::error('Stripe callback error: ' . $e->getMessage());
            return redirect()->route('client.cart.index')->with('error', 'An error occurred while processing your payment.');
        }
    }

    public function paymentCallback(Request $request)
    {
        $status = $request->status_id; // 1 = success
        $reference_no = $request->billcode ?? $request->order_id;

        if ($status == '1') {
            return $this->processSuccessfulPayment($reference_no);
        } else {
            // Log the failed payment
            $billingData = session('pending_billing');
            PaymentLogger::logFailedPayment(
                'toyyibpay',
                'CANCELLED',
                'Payment was not completed or was cancelled by user',
                [
                    'customer_name' => $billingData['first_name'] . ' ' . $billingData['last_name'] ?? 'Unknown',
                    'customer_email' => $billingData['email'] ?? 'Unknown',
                    'amount' => session('pending_cart_total', 0),
                    'reference_no' => $reference_no,
                    'status_id' => $status
                ]
            );

            return redirect()->route('client.store')->with([
                'show_modal' => true,
                'modal_type' => 'error',
                'modal_title' => 'Payment Unsuccessful',
                'modal_message' => 'Your payment was not completed or was cancelled. Please try again or contact support if you need help.',
            ]);
        }
    }

    private function processSuccessfulPayment($reference_no, $additionalData = [])
    {
        $billingData = session('pending_billing');
        $cartItems = session('pending_cart');
        $cartTotal = session('pending_cart_total');

        \Log::info('Processing successful payment', [
            'billing_data' => $billingData,
            'cart_items' => $cartItems,
            'cart_total' => $cartTotal
        ]);

        if ($billingData && $cartItems && $cartTotal) {
            try {
                DB::beginTransaction();

                // Save billing details
                $billing = BillingDetail::create($billingData);
                \Log::info('Created billing details', ['billing' => $billing->toArray()]);

                // Prepare order data
                $orderData = [
                    'billing_detail_id' => $billing->id,
                    'reference_number' => $reference_no,
                    'total_amount' => $cartTotal,
                    'status' => 'paid',
                    'cart_items' => $cartItems,
                    'payment_method' => 'toyyibpay',
                    'payment_country' => 'Malaysia',
                    'processing_fee' => 0.00
                ];

                // Create order
                $order = Order::create($orderData);

                // Log successful payment
                PaymentLogger::logSuccessfulPayment(
                    'toyyibpay',
                    $reference_no,
                    $cartTotal,
                    [
                        'customer_name' => $billingData['first_name'] . ' ' . $billingData['last_name'],
                        'customer_email' => $billingData['email'],
                        'payment_country' => 'Malaysia',
                        'items_count' => count($cartItems),
                        'order_id' => $order->id
                    ]
                );

                // Reduce stock for each item
                foreach ($cartItems as $item) {
                    $ticket = Ticket::find($item['ticket_id']);
                    if (!$ticket->reduceStock($item['quantity'])) {
                        throw new \Exception("Not enough stock for {$ticket->name}");
                    }
                }

                // Clear cart items based on user status
                if (auth()->check()) {
                    CartItem::where(function($query) {
                        $query->where('user_id', auth()->id())
                              ->orWhere('session_id', session()->getId());
                    })->delete();
                } else {
                    CartItem::where('session_id', session()->getId())->delete();
                }

                // Send confirmation email
                try {
                    // Generate QR codes first and validate
                    $qrCodes = $order->generateTicketQRCodes();
                    
                    // Validate that QR codes were generated successfully
                    if (empty($qrCodes)) {
                        throw new \Exception('Failed to generate QR codes');
                    }
                    
                    // Validate each QR code
                    foreach ($qrCodes as $qrCode) {
                        if (empty($qrCode['qr_code']) || !is_string($qrCode['qr_code'])) {
                            throw new \Exception('Invalid QR code generated');
                        }
                    }

                    // If QR codes are valid, send the email
                    $this->sendOrderConfirmationEmail($order, $billingData);

                } catch (\Exception $e) {
                    \Log::error('Failed to send order confirmation email', [
                        'error' => $e->getMessage(),
                        'email' => $billingData['email'],
                        'trace' => $e->getTraceAsString()
                    ]);

                    // Don't throw the exception - we still want to complete the order
                    // but let's notify admin about the email failure
                    \Log::channel('slack')->error('Order email failed but order completed', [
                        'order_id' => $order->id,
                        'email' => $billingData['email'],
                        'error' => $e->getMessage()
                    ]);
                }

                // Clear session and cart
                session()->forget(['pending_billing', 'pending_cart', 'pending_cart_total']);

                DB::commit();

                return redirect()->route('client.store')->with([
                    'show_modal' => true,
                    'modal_type' => 'success',
                    'modal_title' => 'Payment Successful!',
                    'modal_message' => 'Your order details will be sent to your email address. Thank you for your purchase.',
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Error processing payment', ['error' => $e->getMessage()]);
                return redirect()->route('client.store')->with([
                    'show_modal' => true,
                    'modal_type' => 'error',
                    'modal_title' => 'Order Processing Error',
                    'modal_message' => 'There was an error processing your order. Please contact support.',
                ]);
            }
        } else {
            return redirect()->route('client.store')->with([
                'show_modal' => true,
                'modal_type' => 'error',
                'modal_title' => 'Invalid Order Data',
                'modal_message' => 'Required order information is missing. Please try again.',
            ]);
        }
    }

    public function updatePaymentAmount(Request $request)
    {
        try {
            $request->validate([
                'country' => 'required|string',
                'amount' => 'required|numeric|min:0'
            ]);

            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            
            // Get the current PaymentIntent ID from session
            $paymentIntentId = session('stripe_payment_intent_id');
            
            if (!$paymentIntentId) {
                return response()->json(['error' => 'No payment intent found'], 400);
            }

            // Convert amount to cents for Stripe
            $amountInCents = round($request->amount * 100);

            // Update the PaymentIntent with new amount
            $stripe->paymentIntents->update(
                $paymentIntentId,
                [
                    'amount' => $amountInCents,
                    'metadata' => [
                        'payment_country' => $request->country
                    ]
                ]
            );

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error updating payment amount: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function sendOrderConfirmationEmail($order, $billingData)
    {
        try {
            $qrCodes = $order->generateTicketQRCodes();
            
            // Add absolute paths for PDF generation
            $qrCodesWithPaths = array_map(function($qrCode) {
                $qrCode['qr_code_path'] = public_path('storage/' . $qrCode['filename']);
                return $qrCode;
            }, $qrCodes);

            // Generate PDF
            $pdf = PDF::loadView('emails.order-confirmation-pdf', [
                'billingData' => $billingData,
                'referenceNo' => $order->reference_number,
                'cartItems' => $order->cart_items,
                'qrCodes' => $qrCodesWithPaths,
                'orderDate' => $order->created_at,
                'order' => $order
            ]);

            // Configure PDF options
            $pdf->setOption(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            
            // Save PDF temporarily
            $pdfPath = 'pdfs/order_' . $order->reference_number . '.pdf';
            Storage::disk('public')->put($pdfPath, $pdf->output());
            
            Mail::send('emails.order-confirmation', [
                'billingData' => $billingData,
                'referenceNo' => $order->reference_number,
                'cartItems' => $order->cart_items,
                'orderDate' => $order->created_at,
                'order' => $order
            ], function($message) use ($billingData, $order, $pdfPath) {
                $message->to($billingData['email'])
                        ->subject('Order Confirmation - ' . config('app.name'));

                // Attach PDF only
                $message->attach(Storage::disk('public')->path($pdfPath), [
                    'as' => 'Order_Confirmation_' . $order->reference_number . '.pdf',
                    'mime' => 'application/pdf'
                ]);
            });

            // Clean up temporary PDF file
            Storage::disk('public')->delete($pdfPath);

            // Clean up QR code files after sending email
            foreach ($qrCodes as $qrCode) {
                Storage::disk('public')->delete($qrCode['filename']);
            }

            Log::info('Order confirmation email sent successfully', [
                'order_id' => $order->id,
                'email' => $billingData['email']
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email', [
                'error' => $e->getMessage(),
                'email' => $billingData['email'],
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
