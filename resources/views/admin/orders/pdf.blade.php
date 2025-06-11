<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Order Details</h1>
        <p>Reference Number: {{ $order->reference_number }}</p>
        <p>Date: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Billing Details</div>
        <table>
            <tr>
                <th>Name</th>
                <td>{{ $billingDetail->first_name }} {{ $billingDetail->last_name }}</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>{{ ucfirst($billingDetail->gender) }}</td>
            </tr>
            <tr>
                <th>Category</th>
                <td>{{ ucfirst($billingDetail->category) }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $billingDetail->email }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $billingDetail->phone }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>
                    {{ $billingDetail->address1 }}<br>
                    @if($billingDetail->address2)
                        {{ $billingDetail->address2 }}<br>
                    @endif
                    {{ $billingDetail->city }}, {{ $billingDetail->state }} {{ $billingDetail->postcode }}<br>
                    {{ $billingDetail->country }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Order Items</div>
        <table>
            <thead>
                <tr>
                    <th>Ticket</th>
                    <th>Quantity</th>
                    <th>Original Price</th>
                    <th>Discounted Price</th>
                    <th>Original Subtotal</th>
                    <th>Discounted Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item['ticket_name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>RM {{ number_format($item['original_price'], 2) }}</td>
                    <td>RM {{ number_format($item['discounted_price'], 2) }}</td>
                    <td>RM {{ number_format($item['original_price'] * $item['quantity'], 2) }}</td>
                    <td>RM {{ number_format($item['discounted_price'] * $item['quantity'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total">
            <div>Subtotal: RM {{ number_format($originalSubtotal, 2) }}</div>
            <div>Discount: - RM {{ number_format($discount, 2) }}</div>
            <div><strong>Total Amount: RM {{ number_format($discountedSubtotal, 2) }}</strong></div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Order Status</div>
        <p>Status: {{ ucfirst($order->status) }}</p>
    </div>
</body>
</html> 