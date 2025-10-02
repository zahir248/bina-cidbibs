<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QROutputInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Http;

class Order extends Model
{
    protected $fillable = [
        'billing_detail_id',
        'reference_number',
        'total_amount',
        'status',
        'cart_items',
        'payment_id',
        'payment_method',
        'payment_country',
        'processing_fee',
        'affiliate_id',
        'affiliate_code'
    ];

    protected $casts = [
        'cart_items' => 'array',
        'total_amount' => 'decimal:2',
        'processing_fee' => 'decimal:2'
    ];

    public function billingDetail(): BelongsTo
    {
        return $this->belongsTo(BillingDetail::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function generateTicketQRCodes()
    {
        try {
            $qrCodes = [];
            $useLocalGeneration = false;
            $ticketCount = 1;

            // First try to check if QR Server is accessible
            try {
                $testResponse = Http::withoutVerifying()->timeout(5)->get('https://api.qrserver.com/v1/create-qr-code/', [
                    'data' => 'test',
                    'size' => '100x100'
                ]);
                
                if (!$testResponse->successful()) {
                    $useLocalGeneration = true;
                }
            } catch (\Exception $e) {
                $useLocalGeneration = true;
                \Log::warning('QR Server not accessible, falling back to local generation', [
                    'error' => $e->getMessage()
                ]);
            }

            if ($useLocalGeneration) {
                // Use local SVG generation as fallback
                $options = new QROptions([
                    'version' => QRCode::VERSION_AUTO,
                    'eccLevel' => EccLevel::H,
                    'outputType' => QROutputInterface::CUSTOM,
                    'outputInterface' => 'chillerlan\QRCode\Output\QRMarkupSVG',
                    'imageBase64' => false,
                    'scale' => 10,
                    'addQuietzone' => true,
                    'quietzoneSize' => 2,
                    'drawCircularModules' => true,
                    'circleRadius' => 0.45,
                    'keepAsSquare' => [],
                    'svgAddXmlHeader' => false,
                    'moduleValues' => [
                        1536 => '#ffffff', // Light
                        6 => '#000000',    // Dark
                    ]
                ]);

                foreach ($this->cart_items as $item) {
                    $ticket = \App\Models\Ticket::find($item['ticket_id']);
                    
                    for ($i = 0; $i < $item['quantity']; $i++) {
                        $data = json_encode([
                            'ref' => $this->reference_number,
                            'tkt' => $ticket->name
                        ]);

                        $qrcode = new QRCode($options);
                        
                        // Generate unique filename
                        $safeTicketName = str_replace([' ', '/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $ticket->name);
                        $filename = 'qrcodes/' . $this->reference_number . '_' . $safeTicketName;
                        if ($item['quantity'] > 1) {
                            $filename .= '_' . ($i + 1);
                        }
                        $filename .= '.svg';
                        
                        // Get SVG content and save
                        $svgContent = $qrcode->render($data);
                        Storage::disk('public')->put($filename, $svgContent);

                        $qrCodes[] = [
                            'qr_code' => asset('storage/' . $filename),
                            'filename' => $filename,
                            'ticket_name' => $ticket->name,
                            'ticket_number' => $ticketCount,
                            'quantity' => $item['quantity'],
                            'is_svg' => true
                        ];

                        $ticketCount++;
                    }
                }
            } else {
                // Use QR Server API
                foreach ($this->cart_items as $item) {
                    $ticket = \App\Models\Ticket::find($item['ticket_id']);
                    
                    for ($i = 0; $i < $item['quantity']; $i++) {
                        $data = json_encode([
                            'ref' => $this->reference_number,
                            'tkt' => $ticket->name
                        ]);
                        
                        // Generate QR code URL
                        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?' . http_build_query([
                            'data' => $data,
                            'size' => '300x300',
                            'format' => 'png',
                            'qzone' => 2,
                            'ecc' => 'H'
                        ]);

                        // Download and save QR code
                        try {
                            $response = Http::withoutVerifying()->timeout(5)->get($qrUrl);
                            if ($response->successful()) {
                                $safeTicketName = str_replace([' ', '/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $ticket->name);
                                $filename = 'qrcodes/' . $this->reference_number . '_' . $safeTicketName;
                                if ($item['quantity'] > 1) {
                                    $filename .= '_' . ($i + 1);
                                }
                                $filename .= '.png';

                                Storage::disk('public')->put($filename, $response->body());

                                $qrCodes[] = [
                                    'qr_code' => asset('storage/' . $filename),
                                    'filename' => $filename,
                                    'ticket_name' => $ticket->name,
                                    'ticket_number' => $ticketCount,
                                    'quantity' => $item['quantity'],
                                    'is_svg' => false
                                ];
                            } else {
                                throw new \Exception('Failed to download QR code from server');
                            }
                        } catch (\Exception $e) {
                            \Log::error('Failed to download QR code from server, falling back to local generation', [
                                'error' => $e->getMessage()
                            ]);
                            // Fall back to local generation for this QR code
                            return $this->generateLocalQRCode($item, $ticketCount);
                        }

                        $ticketCount++;
                    }
                }
            }

            return $qrCodes;
        } catch (\Exception $e) {
            \Log::error('Error generating QR code: ' . $e->getMessage());
            throw $e;
        }
    }

    private function generateLocalQRCode($item, $ticketCount)
    {
        $options = new QROptions([
            'version' => QRCode::VERSION_AUTO,
            'eccLevel' => EccLevel::H,
            'outputType' => QROutputInterface::CUSTOM,
            'outputInterface' => 'chillerlan\QRCode\Output\QRMarkupSVG',
            'imageBase64' => false,
            'scale' => 10,
            'addQuietzone' => true,
            'quietzoneSize' => 2,
            'drawCircularModules' => true,
            'circleRadius' => 0.45,
            'keepAsSquare' => [],
            'svgAddXmlHeader' => false,
            'moduleValues' => [
                1536 => '#ffffff', // Light
                6 => '#000000',    // Dark
            ]
        ]);

        $ticket = \App\Models\Ticket::find($item['ticket_id']);
        $qrCodes = [];
        
        for ($i = 0; $i < $item['quantity']; $i++) {
            $data = json_encode([
                'ref' => $this->reference_number,
                'tkt' => $ticket->name
            ]);

            $qrcode = new QRCode($options);
            
            // Generate unique filename
            $safeTicketName = str_replace([' ', '/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $ticket->name);
            $filename = 'qrcodes/' . $this->reference_number . '_' . $safeTicketName;
            if ($item['quantity'] > 1) {
                $filename .= '_' . ($i + 1);
            }
            $filename .= '.svg';
            
            // Get SVG content and save
            $svgContent = $qrcode->render($data);
            Storage::disk('public')->put($filename, $svgContent);

            $qrCodes[] = [
                'qr_code' => asset('storage/' . $filename),
                'filename' => $filename,
                'ticket_name' => $ticket->name,
                'ticket_number' => $ticketCount + $i,
                'quantity' => $item['quantity'],
                'is_svg' => true
            ];
        }

        return $qrCodes;
    }
} 