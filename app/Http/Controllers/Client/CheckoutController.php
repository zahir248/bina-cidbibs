<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Http;
use App\Models\BillingDetail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class CheckoutController extends Controller
{
    // Show the checkout form
    public function show(Request $request)
    {
        $sessionId = $request->session()->getId();
        $cartItems = CartItem::with('ticket')
            ->where('session_id', $sessionId)
            ->get();
        $cartTotal = $cartItems->sum(function($item) {
            return $item->ticket->getDiscountedPrice($item->quantity) * $item->quantity;
        });
        return view('client.store.checkout', compact('cartItems', 'cartTotal'));
    }

    // Process the checkout form
    public function process(Request $request)
    {
        \Log::info('Checkout process started', ['input' => $request->all()]);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'category' => 'required|in:individual,academician,organization',
            'country' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postcode' => 'required|string|max:20',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|max:255',
        ]);
        \Log::info('Validation passed', ['validated' => $validated]);

        // Get cart total
        $sessionId = $request->session()->getId();
        $cartItems = \App\Models\CartItem::with('ticket')
            ->where('session_id', $sessionId)
            ->get();
        $cartTotal = $cartItems->sum(function($item) {
            return $item->ticket->getDiscountedPrice($item->quantity) * $item->quantity;
        });
        
        // Set cart total to RM 1 for testing
        // $cartTotal = 1.00;

        \Log::info('Cart total calculated', ['cart_total' => $cartTotal, 'cart_items' => $cartItems->toArray()]);

        // Store billing and cart info in session for callback
        session([
            'pending_billing' => $validated,
            'pending_cart' => $cartItems->toArray(),
            'pending_cart_total' => $cartTotal,
        ]);

        // Format phone number for ToyyibPay
        $phone = preg_replace('/[^0-9]/', '', $validated['phone']);
        if (strpos($phone, '0') === 0) {
            $phone = '6' . substr($phone, 1);
        }

        // Prepare ToyyibPay bill data
        $billData = [
            'userSecretKey' => config('services.toyyibpay.secret_key'),
            'categoryCode' => config('services.toyyibpay.category_code'),
            'billName' => 'Order from ' . $validated['first_name'] . ' ' . $validated['last_name'],
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
        \Log::info('ToyyibPay bill data', $billData);

        try {
            $response = Http::asForm()->withOptions(['verify' => false])->post('https://toyyibpay.com/index.php/api/createBill', $billData);
            $result = $response->json();
            \Log::info('ToyyibPay response', ['result' => $result]);
        } catch (\Exception $e) {
            \Log::error('ToyyibPay API error', ['exception' => $e]);
            return back()->with('error', 'Payment gateway error. Please try again.');
        }

        if (isset($result[0]['BillCode'])) {
            $billCode = $result[0]['BillCode'];
            \Log::info('Redirecting to ToyyibPay', ['bill_code' => $billCode]);
            return redirect('https://toyyibpay.com/' . $billCode);
        } else {
            \Log::error('ToyyibPay did not return BillCode', ['result' => $result]);
            return back()->with('error', 'Payment gateway error. Please try again.');
        }
    }

    public function paymentCallback(Request $request)
    {
        $status = $request->status_id; // 1 = success
        $reference_no = $request->billcode ?? $request->order_id;

        if ($status == '1') {
            $billingData = session('pending_billing');
            $cartItems = session('pending_cart');
            $cartTotal = session('pending_cart_total');

            if ($billingData && $cartItems && $cartTotal) {
                try {
                    DB::beginTransaction();

                    // Save billing details
                    $billing = \App\Models\BillingDetail::create($billingData);

                    // Save order
                    $order = \App\Models\Order::create([
                        'billing_detail_id' => $billing->id,
                        'reference_number' => $reference_no,
                        'total_amount' => $cartTotal,
                        'status' => 'paid',
                        'cart_items' => $cartItems,
                    ]);

                    // Reduce stock for each item
                    foreach ($cartItems as $item) {
                        $ticket = \App\Models\Ticket::find($item['ticket_id']);
                        if (!$ticket->reduceStock($item['quantity'])) {
                            throw new \Exception("Not enough stock for {$ticket->name}");
                        }
                    }

                    // Send confirmation email
                    try {
                        Mail::send('emails.order-confirmation', [
                            'billingData' => $billingData,
                            'cartItems' => $cartItems,
                            'cartTotal' => $cartTotal,
                            'referenceNo' => $reference_no
                        ], function($message) use ($billingData) {
                            $message->to($billingData['email'])
                                    ->subject('Order Confirmation - ' . config('app.name'));
                        });
                    } catch (\Exception $e) {
                        \Log::error('Failed to send order confirmation email', [
                            'error' => $e->getMessage(),
                            'email' => $billingData['email']
                        ]);
                    }

                    // Clear session and cart
                    session()->forget(['pending_billing', 'pending_cart', 'pending_cart_total']);
                    \App\Models\CartItem::where('session_id', session()->getId())->delete();

                    DB::commit();

                    return redirect()->route('client.store')->with([
                        'show_modal' => true,
                        'modal_type' => 'success',
                        'modal_title' => 'Payment Successful!',
                        'modal_message' => 'Your order details will be sent to your email address. Thank you for your purchase.',
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    \Log::error('Payment processing error', [
                        'error' => $e->getMessage(),
                        'reference_no' => $reference_no
                    ]);
                    return redirect()->route('client.store')->with([
                        'show_modal' => true,
                        'modal_type' => 'error',
                        'modal_title' => 'Payment Error',
                        'modal_message' => 'There was an error processing your payment. Please contact support.',
                    ]);
                }
            } else {
                return redirect()->route('client.store')->with([
                    'show_modal' => true,
                    'modal_type' => 'error',
                    'modal_title' => 'Session Expired',
                    'modal_message' => 'Session expired. Please try again.',
                ]);
            }
        } else {
            return redirect()->route('client.store')->with([
                'show_modal' => true,
                'modal_type' => 'error',
                'modal_title' => 'Payment Unsuccessful',
                'modal_message' => 'Your payment was not completed or was cancelled. Please try again or contact support if you need help.',
            ]);
        }
    }
}
