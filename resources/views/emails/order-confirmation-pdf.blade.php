<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .page {
            page-break-after: always;
        }
        .page:last-child {
            page-break-after: avoid;
        }
        .header {
            background: #ff9800;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .order-details {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .order-details h3 {
            border-bottom: 2px solid #ff9800;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th {
            background: #ff9800;
            color: white;
            padding: 8px;
            text-align: left;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .total {
            font-weight: bold;
            color: #ff9800;
        }
        .qr-code-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
        }
        .qr-code-item {
            width: 100%;
            text-align: center;
            border: none;
            background: white;
            margin: 0;
            padding: 0;
        }
        .qr-code-image {
            margin: 50px auto;
        }
        .qr-code-image img {
            width: 600px;
            height: 600px;
            display: block;
            margin: 0 auto;
        }
        .qr-code-text {
            margin-top: 20px;
            font-size: 16px;
            text-align: center;
            background: white;
        }
        .footer {
            text-align: center;
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            margin: 0 auto;
            padding: 20px;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <!-- Order Details Page -->
    <div class="page">
        <div class="header">
            <h1>Order Confirmation</h1>
        </div>
        <div class="content">
            <p>Dear {{ $billingData['first_name'] }} {{ $billingData['last_name'] }},</p>
            
            <p>Thank you for your purchase! Your order has been confirmed.</p>

            <div class="order-details">
                <h3>Order Details</h3>
                <p><strong>Reference Number:</strong> {{ $referenceNo }}</p>
                <p><strong>Order Date:</strong> {{ $orderDate->format('d F Y, h:i A') }}</p>
                
                <h4>Tickets Purchased:</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th style="text-align:center">Quantity</th>
                            <th style="text-align:right">Original Price</th>
                            <th style="text-align:right">Discounted Price</th>
                            <th style="text-align:right">Original Subtotal</th>
                            <th style="text-align:right">Discounted Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $originalSubtotal = 0;
                            $discountedSubtotal = 0;
                        @endphp
                        @foreach($cartItems as $item)
                            @php
                                $ticket = \App\Models\Ticket::find($item['ticket_id']);
                                $quantity = $item['quantity'];
                                $originalPrice = $ticket->price;
                                $discountedPrice = $ticket->getDiscountedPrice($quantity);
                                $origSub = $originalPrice * $quantity;
                                $discSub = $discountedPrice * $quantity;
                                $originalSubtotal += $origSub;
                                $discountedSubtotal += $discSub;
                            @endphp
                            <tr>
                                <td>{{ $ticket->name }}</td>
                                <td style="text-align:center">{{ $quantity }}</td>
                                <td style="text-align:right">RM {{ number_format($originalPrice, 2) }}</td>
                                <td style="text-align:right">RM {{ number_format($discountedPrice, 2) }}</td>
                                <td style="text-align:right">RM {{ number_format($origSub, 2) }}</td>
                                <td style="text-align:right">RM {{ number_format($discSub, 2) }}</td>
                            </tr>
                        @endforeach
                        @php $discount = $originalSubtotal - $discountedSubtotal; @endphp
                    </tbody>
                </table>
                <div style="text-align:right;margin-top:10px;">
                    <div>Subtotal: RM {{ number_format($originalSubtotal, 2) }}</div>
                    <div>Discount: - RM {{ number_format($discount, 2) }}</div>
                    <div>Processing Fee: RM {{ number_format($order->processing_fee ?? 0, 2) }}</div>
                    <div class="total">Total Amount: RM {{ number_format($discountedSubtotal + ($order->processing_fee ?? 0), 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Billing Information Page -->
    <div class="page">
        <div class="header">
            <h1>Billing Information</h1>
        </div>
        <div class="content">
            <div class="order-details">
                <p><strong>Reference Number:</strong> {{ $referenceNo }}</p>
                <p><strong>Name:</strong> {{ $billingData['first_name'] }} {{ $billingData['last_name'] }}</p>
                @if(isset($billingData['identity_number']))
                <p><strong>Identity Card/Passport:</strong> {{ $billingData['identity_number'] }}</p>
                @endif
                <p><strong>Gender:</strong> {{ ucfirst($billingData['gender']) }}</p>
                <p><strong>Category:</strong> {{ ucfirst($billingData['category']) }}</p>
                @if($billingData['category'] === 'organization')
                    <p><strong>Company Name:</strong> {{ $billingData['company_name'] }}</p>
                    <p><strong>Business Registration Number:</strong> {{ $billingData['business_registration_number'] }}</p>
                    @if($billingData['tax_number'])
                        <p><strong>Tax Number:</strong> {{ $billingData['tax_number'] }}</p>
                    @endif
                @endif
                <p><strong>Email:</strong> {{ $billingData['email'] }}</p>
                <p><strong>Phone:</strong> {{ $billingData['phone'] }}</p>
                <p><strong>Address:</strong><br>
                    {{ $billingData['address1'] }}<br>
                    @if($billingData['address2'])
                        {{ $billingData['address2'] }}<br>
                    @endif
                    {{ $billingData['city'] }}, {{ $billingData['state'] }} {{ $billingData['postcode'] }}<br>
                    {{ $billingData['country'] }}
                </p>
            </div>
        </div>
    </div>

    <!-- QR Codes Pages -->
    @foreach($qrCodes as $index => $qrCode)
    <div class="page">
        <div class="content">
            <div class="qr-code-container">
                <div class="qr-code-item">
                    <div class="qr-code-text">
                        <strong>{{ $qrCode['ticket_name'] }}</strong>
                    </div>
                    <div class="qr-code-image">
                        <img src="file://{{ $qrCode['qr_code_path'] }}" 
                             alt="QR Code for {{ $qrCode['ticket_name'] }}"
                             style="width:600px;height:600px;background-color:white;">
                    </div>
                    <div class="qr-code-text">
                        @if($qrCode['quantity'] > 1)
                            QR Code {{ $qrCode['ticket_number'] }} of {{ $qrCode['quantity'] }} tickets
                        @else
                            Single Ticket QR Code
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if($index === count($qrCodes) - 1)
        <div class="footer">
            <p>This is an automated message. For any inquiries, please contact our support team.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
        @endif
    </div>
    @endforeach
</body>
</html> 