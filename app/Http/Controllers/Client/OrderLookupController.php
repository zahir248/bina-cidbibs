<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderLookupController extends Controller
{
    public function show()
    {
        return view('client.order-lookup');
    }

    public function lookup(Request $request)
    {
        $request->validate([
            'identity_number' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ], [
            'identity_number.max' => 'Identity Card Number/Passport must not exceed 20 characters.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        // Check if at least one field is provided
        if (empty($request->identity_number) && empty($request->email)) {
            return back()->withErrors([
                'identity_number' => 'Please provide either your Identity Card Number/Passport OR email address.',
                'email' => 'Please provide either your Identity Card Number/Passport OR email address.'
            ])->withInput();
        }

        // Search for orders where the user is the purchaser (billing detail)
        $purchaserOrders = Order::whereHas('billingDetail', function($query) use ($request) {
                if (!empty($request->identity_number) && !empty($request->email)) {
                    // Both fields provided - search with OR logic
                    $query->where(function($q) use ($request) {
                        $q->where('email', $request->email)
                          ->orWhere('identity_number', $request->identity_number);
                    });
                } elseif (!empty($request->identity_number)) {
                    // Only identity number provided
                    $query->where('identity_number', $request->identity_number);
                } else {
                    // Only email provided
                    $query->where('email', $request->email);
                }
            })
            ->with(['billingDetail'])
            ->get();

        // Search for orders where the user is a participant
        $participantOrders = Order::whereHas('participants', function($query) use ($request) {
                if (!empty($request->identity_number) && !empty($request->email)) {
                    // Both fields provided - search with OR logic
                    $query->where(function($q) use ($request) {
                        $q->where('email', $request->email)
                          ->orWhere('identity_number', $request->identity_number);
                    });
                } elseif (!empty($request->identity_number)) {
                    // Only identity number provided
                    $query->where('identity_number', $request->identity_number);
                } else {
                    // Only email provided
                    $query->where('email', $request->email);
                }
            })
            ->with(['billingDetail', 'participants'])
            ->get();

        // Merge and deduplicate orders
        $allOrders = $purchaserOrders->merge($participantOrders)->unique('id');

        if ($allOrders->isEmpty()) {
            $errorMessage = 'No orders found. ';
            if (!empty($request->identity_number) && !empty($request->email)) {
                $errorMessage .= 'Please check your Identity Card Number/Passport and email address and try again.';
            } elseif (!empty($request->identity_number)) {
                $errorMessage .= 'Please check your Identity Card Number/Passport and try again.';
            } else {
                $errorMessage .= 'Please check your email address and try again.';
            }
            
            return back()->withErrors([
                'identity_number' => $errorMessage
            ])->withInput();
        }

        // Filter only paid orders
        $paidOrders = $allOrders->where('status', 'paid');
        
        if ($paidOrders->isEmpty()) {
            return back()->withErrors([
                'identity_number' => 'No paid orders found. Please complete payment for your orders first.'
            ])->withInput();
        }

        return view('client.order-lookup-result', compact('paidOrders', 'request'));
    }

    public function downloadPdf(Order $order, Request $request)
    {
        // Verify the order belongs to the provided email or identity number (either as purchaser or participant)
        $isPurchaser = false;
        $isParticipant = false;
        
        if ($request->has('email') && !empty($request->query('email'))) {
            $isPurchaser = $order->billingDetail->email === $request->query('email');
            $isParticipant = $order->participants()->where('email', $request->query('email'))->exists();
        }
        
        if ($request->has('identity_number') && !empty($request->query('identity_number'))) {
            if (!$isPurchaser) {
                $isPurchaser = $order->billingDetail->identity_number === $request->query('identity_number');
            }
            if (!$isParticipant) {
                $isParticipant = $order->participants()->where('identity_number', $request->query('identity_number'))->exists();
            }
        }
        
        if (!$isPurchaser && !$isParticipant) {
            abort(403, 'Unauthorized access to this order.');
        }

        if ($order->status !== 'paid') {
            abort(400, 'This order has not been paid yet.');
        }

        // Rate limiting for security
        $key = 'order_lookup_' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) { // 10 attempts per minute
            abort(429, 'Too many download attempts. Please try again later.');
        }
        RateLimiter::hit($key, 60); // 1 minute window

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

            // Generate PDF
            $pdf = Pdf::loadView('emails.order-confirmation-pdf', [
                'billingData' => $billingData,
                'referenceNo' => $order->reference_number,
                'cartItems' => $order->cart_items,
                'qrCodes' => $qrCodesWithPaths,
                'orderDate' => $order->created_at,
                'order' => $order
            ]);

            // Configure PDF options
            $pdf->setOption(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            
            $filename = "order-{$order->reference_number}.pdf";
            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('Failed to generate order PDF for public lookup', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed to generate PDF. Please try again.');
        }
    }

    public function downloadQrCodes(Order $order, Request $request)
    {
        // Verify the order belongs to the provided email or identity number (either as purchaser or participant)
        $isPurchaser = false;
        $isParticipant = false;
        
        if ($request->has('email') && !empty($request->query('email'))) {
            $isPurchaser = $order->billingDetail->email === $request->query('email');
            $isParticipant = $order->participants()->where('email', $request->query('email'))->exists();
        }
        
        if ($request->has('identity_number') && !empty($request->query('identity_number'))) {
            if (!$isPurchaser) {
                $isPurchaser = $order->billingDetail->identity_number === $request->query('identity_number');
            }
            if (!$isParticipant) {
                $isParticipant = $order->participants()->where('identity_number', $request->query('identity_number'))->exists();
            }
        }
        
        if (!$isPurchaser && !$isParticipant) {
            abort(403, 'Unauthorized access to this order.');
        }

        if ($order->status !== 'paid') {
            abort(400, 'This order has not been paid yet.');
        }

        // Rate limiting for security
        $key = 'order_lookup_qr_' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) { // 10 attempts per minute
            abort(429, 'Too many download attempts. Please try again later.');
        }
        RateLimiter::hit($key, 60); // 1 minute window

        try {
            $qrCodes = $order->generateTicketQRCodes();
            
            if (empty($qrCodes)) {
                return back()->with('error', 'No QR codes found for this order.');
            }

            // Create a ZIP file containing all QR codes
            $zip = new \ZipArchive();
            $zipName = 'qr-codes-' . $order->reference_number . '.zip';
            $zipPath = storage_path('app/temp/' . $zipName);
            
            // Ensure temp directory exists
            if (!file_exists(dirname($zipPath))) {
                mkdir(dirname($zipPath), 0755, true);
            }

            if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
                foreach ($qrCodes as $qrCode) {
                    $filePath = public_path('storage/' . $qrCode['filename']);
                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, $qrCode['filename']);
                    }
                }
                $zip->close();

                return response()->download($zipPath)->deleteFileAfterSend();
            } else {
                return back()->with('error', 'Failed to create QR codes archive.');
            }

        } catch (\Exception $e) {
            \Log::error('Failed to generate QR codes for public lookup', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed to generate QR codes. Please try again.');
        }
    }
} 