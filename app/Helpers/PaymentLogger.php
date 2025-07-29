<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class PaymentLogger
{
    private const LOG_PATH = 'storage/logs/payments/';
    private const FAILED_LOG_FILE = 'payment_failures.log';
    private const SUCCESS_LOG_FILE = 'payment_success.log';

    public static function logFailedPayment(
        string $paymentMethod,
        string $status,
        string $reason,
        array $additionalData = [],
        array $billingData = null,
        array $cartItems = null,
        float $cartTotal = null
    ): void {
        // Add comprehensive transaction data to additionalData
        $comprehensiveData = $additionalData;
        
        if ($billingData) {
            $comprehensiveData['billing_details'] = [
                'first_name' => $billingData['first_name'] ?? 'N/A',
                'last_name' => $billingData['last_name'] ?? 'N/A',
                'email' => $billingData['email'] ?? 'N/A',
                'phone' => $billingData['phone'] ?? 'N/A',
                'gender' => $billingData['gender'] ?? 'N/A',
                'category' => $billingData['category'] ?? 'N/A',
                'country' => $billingData['country'] ?? 'N/A',
                'address1' => $billingData['address1'] ?? 'N/A',
                'address2' => $billingData['address2'] ?? 'N/A',
                'city' => $billingData['city'] ?? 'N/A',
                'state' => $billingData['state'] ?? 'N/A',
                'postcode' => $billingData['postcode'] ?? 'N/A',
                'identity_number' => $billingData['identity_number'] ?? 'N/A',
                'company_name' => $billingData['company_name'] ?? 'N/A',
                'business_registration_number' => $billingData['business_registration_number'] ?? 'N/A',
                'tax_number' => $billingData['tax_number'] ?? 'N/A',
                'student_id' => $billingData['student_id'] ?? 'N/A',
                'academic_institution' => $billingData['academic_institution'] ?? 'N/A',
            ];
        }
        
        if ($cartItems) {
            $comprehensiveData['cart_items'] = [];
            foreach ($cartItems as $item) {
                $ticket = \App\Models\Ticket::find($item['ticket_id']);
                $comprehensiveData['cart_items'][] = [
                    'ticket_id' => $item['ticket_id'],
                    'ticket_name' => $ticket ? $ticket->name : 'Unknown Ticket',
                    'quantity' => $item['quantity'],
                    'price' => $ticket ? $ticket->price : 0,
                    'discounted_price' => $ticket ? $ticket->getDiscountedPrice($item['quantity']) : 0,
                    'subtotal' => $ticket ? ($ticket->getDiscountedPrice($item['quantity']) * $item['quantity']) : 0,
                ];
            }
        }
        
        if ($cartTotal !== null) {
            $comprehensiveData['cart_total'] = $cartTotal;
            $comprehensiveData['cart_total_formatted'] = 'RM ' . number_format($cartTotal, 2);
        }
        
        // Add timestamp for tracking
        $comprehensiveData['failed_at'] = now()->format('Y-m-d H:i:s');
        $comprehensiveData['session_id'] = session()->getId();
        
        self::logPayment(self::FAILED_LOG_FILE, $paymentMethod, $status, $reason, $comprehensiveData);
    }

    public static function logSuccessfulPayment(
        string $paymentMethod,
        string $referenceNumber,
        float $amount,
        array $additionalData = []
    ): void {
        $additionalData = array_merge([
            'reference_number' => $referenceNumber,
            'amount' => number_format($amount, 2)
        ], $additionalData);

        self::logPayment(
            self::SUCCESS_LOG_FILE,
            $paymentMethod,
            'SUCCESS',
            'Payment completed successfully',
            $additionalData
        );
    }

    private static function logPayment(
        string $logFile,
        string $paymentMethod,
        string $status,
        string $reason,
        array $additionalData = []
    ): void {
        $timestamp = Carbon::now();
        $fullPath = storage_path('logs/payments/' . $logFile);

        // Ensure the directory exists
        if (!File::exists(dirname($fullPath))) {
            File::makeDirectory(dirname($fullPath), 0755, true);
        }

        // Format the log entry
        $logEntry = sprintf(
            "[%s] Payment Method: %s | Status: %s | Reason: %s\n",
            $timestamp->format('Y-m-d H:i:s'),
            strtoupper($paymentMethod),
            strtoupper($status),
            $reason
        );

        // Add additional data if provided
        if (!empty($additionalData)) {
            $logEntry .= "Additional Information:\n";
            foreach ($additionalData as $key => $value) {
                $logEntry .= sprintf("- %s: %s\n", $key, is_array($value) ? json_encode($value) : $value);
            }
        }

        $logEntry .= str_repeat('-', 80) . "\n\n";

        // Get existing content
        $existingContent = File::exists($fullPath) ? File::get($fullPath) : '';

        // Prepend new entry to existing content
        File::put($fullPath, $logEntry . $existingContent);
    }

    public static function getFailedPaymentLogs(): string
    {
        return self::getLogs(self::FAILED_LOG_FILE);
    }

    public static function getSuccessfulPaymentLogs(): string
    {
        return self::getLogs(self::SUCCESS_LOG_FILE);
    }

    private static function getLogs(string $logFile): string
    {
        $fullPath = storage_path('logs/payments/' . $logFile);

        if (File::exists($fullPath)) {
            return File::get($fullPath);
        }

        return "No payment logs found.";
    }

    /**
     * Parse failed payment logs to extract transaction data
     * This helps admins recreate orders from failed transactions
     */
    public static function parseFailedPaymentLogs(): array
    {
        $logContent = self::getFailedPaymentLogs();
        $transactions = [];
        
        // Split by separator line
        $entries = explode(str_repeat('-', 80), $logContent);
        
        foreach ($entries as $entry) {
            $entry = trim($entry);
            if (empty($entry)) continue;
            
            $lines = explode("\n", $entry);
            $transaction = [
                'timestamp' => '',
                'payment_method' => '',
                'status' => '',
                'reason' => '',
                'billing_details' => [],
                'cart_items' => [],
                'cart_total' => 0,
                'additional_data' => []
            ];
            
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                
                // Parse timestamp and basic info
                if (preg_match('/\[(.*?)\]/', $line, $matches)) {
                    $transaction['timestamp'] = $matches[1];
                }
                
                // Parse payment method, status, reason
                if (strpos($line, 'Payment Method:') !== false) {
                    preg_match('/Payment Method: (.*?) \|/', $line, $matches);
                    $transaction['payment_method'] = $matches[1] ?? '';
                }
                
                if (strpos($line, 'Status:') !== false) {
                    preg_match('/Status: (.*?) \|/', $line, $matches);
                    $transaction['status'] = $matches[1] ?? '';
                }
                
                if (strpos($line, 'Reason:') !== false) {
                    preg_match('/Reason: (.*?)$/', $line, $matches);
                    $transaction['reason'] = $matches[1] ?? '';
                }
                
                // Parse additional data
                if (strpos($line, 'billing_details:') !== false) {
                    // Extract billing details from JSON
                    $jsonStart = strpos($line, '{');
                    if ($jsonStart !== false) {
                        $jsonStr = substr($line, $jsonStart);
                        $billingData = json_decode($jsonStr, true);
                        if ($billingData) {
                            $transaction['billing_details'] = $billingData;
                        }
                    }
                }
                
                if (strpos($line, 'cart_items:') !== false) {
                    // Extract cart items from JSON
                    $jsonStart = strpos($line, '{');
                    if ($jsonStart !== false) {
                        $jsonStr = substr($line, $jsonStart);
                        $cartData = json_decode($jsonStr, true);
                        if ($cartData) {
                            $transaction['cart_items'] = $cartData;
                        }
                    }
                }
                
                if (strpos($line, 'cart_total:') !== false) {
                    preg_match('/cart_total: (.*?)$/', $line, $matches);
                    $transaction['cart_total'] = floatval($matches[1] ?? 0);
                }
            }
            
            if (!empty($transaction['timestamp'])) {
                $transactions[] = $transaction;
            }
        }
        
        return $transactions;
    }
} 