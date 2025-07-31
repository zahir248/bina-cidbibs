<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Form - {{ isset($order) ? $order->reference_number : ($eventName ?? 'Compiled') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
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
        }
        .ticket-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            background-color: #f0f0f0;
            padding: 5px;
            page-break-after: avoid;
        }
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: auto;
        }
        .attendance-table thead {
            display: table-header-group;
        }
        .attendance-table tbody {
            display: table-row-group;
        }
        .attendance-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        .attendance-table th,
        .attendance-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            font-size: 10px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .attendance-table th {
            background-color: #f0f0f0;
            font-weight: bold;
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
        /* Additional styles for better table handling */
        .attendance-table td {
            max-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        /* Override for reference number cells specifically */
        .attendance-table td.reference-number {
            max-width: none !important;
            overflow: visible !important;
            text-overflow: unset !important;
            white-space: normal !important;
            min-width: 120px !important;
        }
        /* Force table to use fixed layout for better column control */
        .attendance-table {
            table-layout: fixed;
        }
        /* Allow reference numbers to wrap */
        .reference-number {
            white-space: normal !important;
            word-wrap: break-word !important;
            word-break: break-all !important;
            font-size: 8px !important;
            font-family: 'Courier New', monospace !important;
            line-height: 1.1 !important;
            padding: 3px 4px !important;
            overflow: visible !important;
            text-overflow: unset !important;
            max-width: none !important;
        }
        .purchaser-info {
            white-space: normal;
            word-wrap: break-word;
        }
        .small-text {
            white-space: normal;
            word-wrap: break-word;
        }
        /* Ensure table headers repeat on each page */
        @media print {
            .attendance-table thead {
                display: table-header-group;
            }
            .attendance-table tbody {
                display: table-row-group;
            }
            .attendance-table tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
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
                <tr>
                    <td><strong>Identity Number:</strong></td>
                    <td colspan="3">{{ $billingDetail->identity_number }}</td>
                </tr>
            </table>
        </div>
    @else
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">{{ $eventName }}</h2>
            <p style="margin: 5px 0;">Attendance Form</p>
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
                        <th width="5%">No.</th>
                        @if(!$isSingleOrder)
                            <th width="15%">Reference Number</th>
                                                    <th width="10%">Order Date</th>
                        <th width="16%">Purchaser Info</th>
                        @endif
                        <th width="{{ $isSingleOrder ? '25%' : '16%' }}">Attendee Name</th>
                        <th width="{{ $isSingleOrder ? '25%' : '16%' }}">Email</th>
                        <th width="{{ $isSingleOrder ? '20%' : '12%' }}">Phone</th>
                        <th width="{{ $isSingleOrder ? '15%' : '12%' }}">Date/Time</th>
                        <th width="{{ $isSingleOrder ? '15%' : '9%' }}">Signature</th>
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
                                        <td class="merged-cell reference-number" rowspan="{{ count($order['attendees']) }}">
                                            <div style="word-break: break-all; font-size: 8px; line-height: 1.1;">
                                                {{ $order['order_ref'] }}
                                            </div>
                                        </td>
                                        <td class="merged-cell" rowspan="{{ count($order['attendees']) }}">{{ $order['order_date'] }}</td>
                                        <td class="merged-cell" rowspan="{{ count($order['attendees']) }}">
                                            <div class="purchaser-info"><strong>{{ $order['purchaser_name'] }}</strong></div>
                                            <div class="small-text">{{ Str::limit($order['purchaser_email'], 25) }}</div>
                                            <div class="small-text">{{ $order['purchaser_phone'] }}</div>
                                            <div class="small-text">{{ $order['purchaser_identity_number'] }}</div>
                                        </td>
                                    @endif
                                    <td></td>
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