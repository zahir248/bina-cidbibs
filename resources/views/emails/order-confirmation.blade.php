@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
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
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #ff9800;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }
        .order-details {
            margin: 20px 0;
            padding: 15px;
            background: white;
            border-radius: 5px;
        }
        .order-details h3 {
            border-bottom: 2px solid #ff9800;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .total {
            font-weight: bold;
            color: #ff9800;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
        .ticket-card {
            background: white;
            border: 1px solid #eee;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .ticket-card-header {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
            color: #ff9800;
        }
        .ticket-card-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 4px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .ticket-card-label {
            color: #666;
            font-size: 14px;
            padding-right: 8px;
        }
        .ticket-card-label::after {
            content: " ";
            white-space: pre;
        }
        .ticket-card-value {
            font-weight: bold;
            text-align: right;
        }
        .order-summary {
            background: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
        }
        .order-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 4px 0;
        }
        .summary-label {
            color: #666;
            font-size: 14px;
            padding-right: 8px;
        }
        .summary-value {
            font-weight: bold;
            text-align: right;
        }
        .order-total {
            border-top: 2px solid #ff9800;
            padding-top: 10px;
            margin-top: 10px;
            font-weight: bold;
            font-size: 16px;
        }
        .order-total .summary-label,
        .order-total .summary-value {
            font-weight: bold;
            color: #333;
        }
        .important-notice {
            background: #f8f9fa;
            border-left: 4px solid #ff9800;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .important-notice h4 {
            color: #ff9800;
            margin: 0 0 10px 0;
        }
        .important-notice p {
            margin: 0;
            color: #555;
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmation</h1>
        </div>
        <div class="content">
            <p>Dear {{ $billingData['first_name'] }} {{ $billingData['last_name'] }},</p>
            
            <p>Thank you for your purchase! Your order has been confirmed.</p>

            <div class="order-details">
                <h3>Order Details</h3>
                <p><strong>Reference Number: </strong> {{ $referenceNo }}</p>
                <p><strong>Order Date: </strong> {{ $orderDate->format('d F Y, h:i A') }}</p>
                
                <h4>Tickets Purchased:</h4>
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
                    <div class="ticket-card">
                        <div class="ticket-card-header">{{ $ticket->name }}</div>
                        <div class="ticket-card-row">
                            <span class="ticket-card-label">Quantity:</span>
                            <span class="ticket-card-value">{{ $quantity }}</span>
                        </div>
                        <div class="ticket-card-row">
                            <span class="ticket-card-label">Original Price:</span>
                            <span class="ticket-card-value">RM {{ number_format($originalPrice, 2) }}</span>
                        </div>
                        <div class="ticket-card-row">
                            <span class="ticket-card-label">Discounted Price:</span>
                            <span class="ticket-card-value">RM {{ number_format($discountedPrice, 2) }}</span>
                        </div>
                        <div class="ticket-card-row">
                            <span class="ticket-card-label">Original Subtotal:</span>
                            <span class="ticket-card-value">RM {{ number_format($origSub, 2) }}</span>
                        </div>
                        <div class="ticket-card-row">
                            <span class="ticket-card-label">Discounted Subtotal:</span>
                            <span class="ticket-card-value">RM {{ number_format($discSub, 2) }}</span>
                        </div>
                    </div>
                @endforeach
                
                @php $discount = $originalSubtotal - $discountedSubtotal; @endphp
                
                <div class="order-summary">
                    <div class="order-summary-row">
                        <span class="summary-label">Subtotal: </span>
                        <span class="summary-value">RM {{ number_format($originalSubtotal, 2) }}</span>
                    </div>
                    <div class="order-summary-row">
                        <span class="summary-label">Discount: </span>
                        <span class="summary-value">- RM {{ number_format($discount, 2) }}</span>
                    </div>
                    <div class="order-summary-row">
                        <span class="summary-label">Processing Fee: </span>
                        <span class="summary-value">RM {{ number_format($order->processing_fee ?? 0, 2) }}</span>
                    </div>
                    <div class="order-summary-row order-total">
                        <span class="summary-label">Total Amount: </span>
                        <span class="summary-value">RM {{ number_format($discountedSubtotal + ($order->processing_fee ?? 0), 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="important-notice">
                <h4>Important: Your Ticket QR Codes</h4>
                <p>We have attached a PDF document containing your official ticket QR codes to this email. For security purposes, the QR codes are only available in the attached PDF. Please download and save this PDF as you will need to present these QR codes for entry validation at the event. We recommend keeping a copy on your mobile device for easy access.</p>
            </div>

            <div class="order-details">
                <h3>Billing Information</h3>
                <p><strong>Name: </strong> {{ $billingData['first_name'] }} {{ $billingData['last_name'] }}</p>
                <p><strong>Gender: </strong> {{ ucfirst($billingData['gender']) }}</p>
                <p><strong>Category: </strong> {{ ucfirst($billingData['category']) }}</p>
                @if($billingData['category'] === 'organization')
                    <p><strong>Company Name: </strong> {{ $billingData['company_name'] }}</p>
                    <p><strong>Business Registration Number: </strong> {{ $billingData['business_registration_number'] }}</p>
                    @if($billingData['tax_number'])
                        <p><strong>Tax Number: </strong> {{ $billingData['tax_number'] }}</p>
                    @endif
                @endif
                <p><strong>Email: </strong> {{ $billingData['email'] }}</p>
                <p><strong>Phone: </strong> {{ $billingData['phone'] }}</p>
                <p><strong>Address: </strong><br>
                    {{ $billingData['address1'] }}<br>
                    @if($billingData['address2'])
                        {{ $billingData['address2'] }}<br>
                    @endif
                    {{ $billingData['city'] }}, {{ $billingData['state'] }} {{ $billingData['postcode'] }}<br>
                    {{ $billingData['country'] }}
                </p>
            </div>

            <p>If you have any questions about your order, please don't hesitate to contact us.</p>

            <div class="footer">
                <p>This is an automated message, please do not reply to this email.</p>
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html> 