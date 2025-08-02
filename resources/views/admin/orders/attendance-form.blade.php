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
        
        /* Allow email and phone cells to wrap text */
        .attendance-table td.email-cell,
        .attendance-table td.phone-cell,
        .attendance-table td.name-cell,
        .attendance-table td.company-cell,
        .attendance-table td.reference-cell,
        .attendance-table td.date-cell {
            white-space: normal !important;
            word-wrap: break-word !important;
            word-break: break-all !important;
            overflow: visible !important;
            text-overflow: unset !important;
            max-width: none !important;
            line-height: 1.2 !important;
            padding: 4px 6px !important;
        }
        /* Override for reference number cells specifically */
        .attendance-table td.reference-cell {
            max-width: none !important;
            overflow: visible !important;
            text-overflow: unset !important;
            white-space: normal !important;
            word-wrap: break-word !important;
            word-break: break-all !important;
            font-size: 8px !important;
            font-family: 'Courier New', monospace !important;
            line-height: 1.1 !important;
            padding: 3px 4px !important;
            width: 12% !important;
            min-width: 80px !important;
        }
        /* Force table to use fixed layout for better column control */
        .attendance-table {
            table-layout: fixed;
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
                            <th width="12%">Reference Number</th>
                            <th width="10%">Order Date</th>
                            <th width="18%">Purchaser Info</th>
                        @endif
                        <th width="{{ $isSingleOrder ? '20%' : '14%' }}">Attendee Name</th>
                        <th width="{{ $isSingleOrder ? '20%' : '14%' }}">Email</th>
                        <th width="{{ $isSingleOrder ? '15%' : '10%' }}">Phone</th>
                        <th width="{{ $isSingleOrder ? '15%' : '12%' }}">Company</th>
                        <th width="{{ $isSingleOrder ? '15%' : '10%' }}">Date/Time</th>
                        <th width="{{ $isSingleOrder ? '15%' : '10%' }}">Signature</th>
                    </tr>
                </thead>
                <tbody>
                    @if($isSingleOrder)
                        @foreach($group['attendees'] as $attendee)
                            <tr>
                                <td>{{ $attendee['no'] }}</td>
                                <td class="name-cell">{{ $attendee['name'] }}</td>
                                <td class="email-cell">{{ $attendee['email'] }}</td>
                                <td class="phone-cell">{{ $attendee['phone'] }}</td>
                                <td class="company-cell">{{ $attendee['company'] ?? '' }}</td>
                                <td>{{ $attendee['datetime'] ?? '' }}</td>
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
                                        <td class="merged-cell reference-cell" rowspan="{{ count($order['attendees']) }}">
                                            <div style="word-break: break-all; font-size: 8px; line-height: 1.1;">
                                                {{ $order['order_ref'] }}
                                            </div>
                                        </td>
                                        <td class="merged-cell date-cell" rowspan="{{ count($order['attendees']) }}">{{ $order['order_date'] }}</td>
                                        <td class="merged-cell" rowspan="{{ count($order['attendees']) }}">
                                            <div class="purchaser-info"><strong>{{ $order['purchaser_name'] }}</strong></div>
                                            <div class="small-text">{{ Str::limit($order['purchaser_email'], 25) }}</div>
                                            <div class="small-text">{{ $order['purchaser_phone'] }}</div>
                                            <div class="small-text">{{ $order['purchaser_identity_number'] }}</div>
                                        </td>
                                    @endif
                                    <td class="name-cell">{{ $attendee['name'] }}</td>
                                    <td class="email-cell">{{ $attendee['email'] }}</td>
                                    <td class="phone-cell">{{ $attendee['phone'] }}</td>
                                    <td class="company-cell">{{ $attendee['company'] ?? '' }}</td>
                                    <td>{{ $attendee['datetime'] ?? '' }}</td>
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