<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Form - {{ isset($order) ? $order->reference_number : 'Compiled' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .order-info {
            margin-bottom: 20px;
        }
        .order-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-info td {
            padding: 5px;
        }
        .ticket-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .ticket-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            background-color: #f0f0f0;
            padding: 5px;
        }
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .attendance-table th,
        .attendance-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 11px;
            vertical-align: top;
        }
        .attendance-table th {
            background-color: #f0f0f0;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
        }
        .page-break {
            page-break-after: always;
        }
        .small-text {
            font-size: 10px;
            color: #666;
            margin-bottom: 2px;
        }
        .merged-cell {
            background-color: #f9f9f9;
        }
        .purchaser-info {
            margin-bottom: 2px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>ATTENDANCE FORM</h2>
    </div>

    @if($isSingleOrder)
        <div class="order-info">
            <table>
                <tr>
                    <td><strong>Order Reference:</strong></td>
                    <td>{{ $order->reference_number }}</td>
                    <td><strong>Order Date:</strong></td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Purchaser Name:</strong></td>
                    <td>{{ $billingDetail->first_name }} {{ $billingDetail->last_name }}</td>
                    <td><strong>Email:</strong></td>
                    <td>{{ $billingDetail->email }}</td>
                </tr>
            </table>
        </div>
    @endif

    @foreach($ticketGroups as $group)
        <div class="ticket-section">
            <div class="ticket-title">
                {{ $group['ticket_name'] }}
            </div>

            <table class="attendance-table">
                <thead>
                    <tr>
                        <th width="4%">No.</th>
                        @if(!$isSingleOrder)
                            <th width="8%">Reference Number</th>
                            <th width="8%">Order Date</th>
                            <th width="15%">Purchaser Info</th>
                        @endif
                        <th width="{{ $isSingleOrder ? '25%' : '16%' }}">Attendee Name</th>
                        <th width="{{ $isSingleOrder ? '25%' : '16%' }}">Email</th>
                        <th width="{{ $isSingleOrder ? '20%' : '13%' }}">Phone</th>
                        <th width="{{ $isSingleOrder ? '30%' : '20%' }}">Signature</th>
                    </tr>
                </thead>
                <tbody>
                    @if($isSingleOrder)
                        @foreach($group['attendees'] as $attendee)
                            <tr>
                                <td>{{ $attendee['no'] }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    @else
                        @php $rowNumber = 1; @endphp
                        @foreach($group['orders'] as $order)
                            @foreach($order['attendees'] as $index => $attendee)
                                <tr>
                                    <td>{{ $rowNumber++ }}</td>
                                    @if($index === 0)
                                        <td class="merged-cell" rowspan="{{ count($order['attendees']) }}">{{ $order['order_ref'] }}</td>
                                        <td class="merged-cell" rowspan="{{ count($order['attendees']) }}">{{ $order['order_date'] }}</td>
                                        <td class="merged-cell" rowspan="{{ count($order['attendees']) }}">
                                            <div class="purchaser-info">{{ $order['purchaser_name'] }}</div>
                                            <div class="small-text">Email: {{ $order['purchaser_email'] }}</div>
                                            <div class="small-text">Phone: {{ $order['purchaser_phone'] }}</div>
                                        </td>
                                    @endif
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</div>
</body>
</html> 