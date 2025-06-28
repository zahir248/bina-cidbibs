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
        array $additionalData = []
    ): void {
        self::logPayment(self::FAILED_LOG_FILE, $paymentMethod, $status, $reason, $additionalData);
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
} 