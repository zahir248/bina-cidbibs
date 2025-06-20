<!DOCTYPE html>
<html>
<head>
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
                <p><strong>Reference Number:</strong> {{ $referenceNo }}</p>
                
                <h4>Tickets Purchased:</h4>
                <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse:collapse;">
                    <thead>
                        <tr style="background:#ff9800;color:#fff;">
                            <th align="left">Ticket</th>
                            <th align="center">Quantity</th>
                            <th align="right">Original Price</th>
                            <th align="right">Discounted Price</th>
                            <th align="right">Original Subtotal</th>
                            <th align="right">Discounted Subtotal</th>
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
                            <tr style="background:#fff;">
                                <td>{{ $ticket->name }}</td>
                                <td align="center">{{ $quantity }}</td>
                                <td align="right">RM {{ number_format($originalPrice, 2) }}</td>
                                <td align="right">RM {{ number_format($discountedPrice, 2) }}</td>
                                <td align="right">RM {{ number_format($origSub, 2) }}</td>
                                <td align="right">RM {{ number_format($discSub, 2) }}</td>
                            </tr>
                        @endforeach
                        @php $discount = $originalSubtotal - $discountedSubtotal; @endphp
                    </tbody>
                </table>
                <div style="margin-top:10px;text-align:right;">
                    <div>Subtotal: RM {{ number_format($originalSubtotal, 2) }}</div>
                    <div>Discount: - RM {{ number_format($discount, 2) }}</div>
                    <div style="font-weight:bold;">Total Amount: RM {{ number_format($discountedSubtotal, 2) }}</div>
                </div>
            </div>

            <div class="order-details">
                <h3>Billing Information</h3>
                <p><strong>Name:</strong> {{ $billingData['first_name'] }} {{ $billingData['last_name'] }}</p>
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

            <p>If you have any questions about your order, please don't hesitate to contact us.</p>

            <div class="footer">
                <p>This is an automated message, please do not reply to this email.</p>
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html> 