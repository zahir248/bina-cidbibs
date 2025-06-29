<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QROutputInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        'processing_fee'
    ];

    protected $casts = [
        'cart_items' => 'array',
        'total_amount' => 'decimal:2',
        'processing_fee' => 'decimal:2'
    ];

    public function billingDetail()
    {
        return $this->belongsTo(BillingDetail::class);
    }

    public function generateTicketQRCodes()
    {
        try {
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
                    // Light (false)
                    1536 => '#ffffff',
                    // Dark (true)
                    6 => '#000000',
                ]
            ]);

            $qrCodes = [];
            $ticketCount = 1;

            foreach ($this->cart_items as $item) {
                $ticket = \App\Models\Ticket::find($item['ticket_id']);
                
                for ($i = 0; $i < $item['quantity']; $i++) {
                    $data = json_encode([
                        'ref' => $this->reference_number,
                        'tkt' => $ticket->name
                    ]);

                    Log::debug('Generating QR code', [
                        'data_length' => strlen($data),
                        'data' => $data
                    ]);

                    $qrcode = new QRCode($options);
                    
                    // Generate unique filename using reference number and ticket name
                    $safeTicketName = str_replace([' ', '/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $ticket->name);
                    $filename = 'qrcodes/' . $this->reference_number . '_' . $safeTicketName;
                    if ($item['quantity'] > 1) {
                        $filename .= '_' . ($i + 1);
                    }
                    $filename .= '.svg';
                    
                    // Get SVG content
                    $svgContent = $qrcode->render($data);
                    
                    // Save to storage
                    Storage::disk('public')->put($filename, $svgContent);

                    // Store QR code info
                    $qrCodes[] = [
                        'qr_code' => asset('storage/' . $filename),
                        'filename' => $filename,
                        'ticket_name' => $ticket->name,
                        'ticket_number' => $ticketCount,
                        'quantity' => $item['quantity']
                    ];

                    Log::debug('QR code generated successfully', [
                        'svg_length' => strlen($svgContent),
                        'ticket_name' => $ticket->name,
                        'ticket_number' => $ticketCount
                    ]);

                    $ticketCount++;
                }
            }

            return $qrCodes;
        } catch (\Exception $e) {
            Log::error('Error generating QR code: ' . $e->getMessage());
            throw $e;
        }
    }
} 