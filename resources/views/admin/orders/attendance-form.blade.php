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
            margin: 0;
            padding: 0;
        }
        .order-info {
            margin-bottom: 15px;
        }
        .order-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-info td {
            padding: 5px;
        }
        .ticket-section {
            margin-bottom: 20px;
            page-break-inside: avoid;
            page-break-after: auto;
        }
        .ticket-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
            background-color: #f0f0f0;
            padding: 5px;
            page-break-after: avoid;
        }
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
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
            text-align: center;
        }
        .no-column {
            font-size: 8px;
        }
        .signature-header {
            background-color: #90EE90;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
        }
        .signature-subheader {
            background-color: #90EE90;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
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
        .attendance-table td.identity-cell,
        .attendance-table td.company-cell,
        .attendance-table td.reference-cell,
        .attendance-table td.date-cell,
        .attendance-table td.datetime-cell {
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
            /* Force page breaks to respect table structure */
            .attendance-table {
                page-break-inside: auto;
            }
            .attendance-table tbody tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            /* Ensure merged cells don't break across pages */
            .merged-cell {
                page-break-inside: avoid;
            }
            /* Force page breaks when needed */
            tr[style*="page-break-before: always"] {
                page-break-before: always !important;
            }
        }
        
        /* Ensure table rows don't break inappropriately */
        .attendance-table tbody tr {
            break-inside: avoid;
        }
        
        /* Hidden row for page breaks */
        .page-break-row {
            height: 0 !important;
            padding: 0 !important;
            border: none !important;
            page-break-before: always;
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
        {{-- Title and subtitle removed --}}
    @endif

    @foreach($ticketGroups as $group)
        @if(!$loop->first)
            <div style="page-break-before: always;"></div>
        @endif
        <div class="ticket-section">
            <div class="ticket-title">
                {{ $group['ticket_name'] }}
            </div>

            <table class="attendance-table">
                <thead>
                    <tr>
                        <th rowspan="2" width="4%" class="no-column">No</th>
                        @if(!$isSingleOrder)
                            <th rowspan="2" width="8%">Reference Number</th>
                            <th rowspan="2" width="6%">Order Date</th>
                            <th rowspan="2" width="14%">Purchaser Info</th>
                        @endif
                        <th rowspan="2" width="{{ $isSingleOrder ? '15%' : '10%' }}">Attendee Name</th>
                        <th rowspan="2" width="{{ $isSingleOrder ? '12%' : '8%' }}">Identity Number</th>
                        <th rowspan="2" width="{{ $isSingleOrder ? '15%' : '10%' }}">Email</th>
                        <th rowspan="2" width="{{ $isSingleOrder ? '10%' : '7%' }}">Phone</th>
                        <th rowspan="2" width="{{ $isSingleOrder ? '10%' : '8%' }}">Company</th>
                        <th rowspan="2" width="{{ $isSingleOrder ? '8%' : '6%' }}">Date/Time</th>
                        <th colspan="2" class="signature-header">Signature</th>
                    </tr>
                    <tr>
                        <th class="signature-subheader">AM</th>
                        <th class="signature-subheader">PM</th>
                    </tr>
                </thead>
                <tbody>
                    @if($isSingleOrder)
                        @foreach($group['attendees'] as $attendee)
                            <tr>
                                <td>{{ $attendee['no'] }}</td>
                                <td class="name-cell">{{ $attendee['name'] }}</td>
                                <td class="identity-cell">{{ $attendee['identity_number'] ?? '' }}</td>
                                <td class="email-cell">{{ $attendee['email'] }}</td>
                                <td class="phone-cell">{{ $attendee['phone'] }}</td>
                                <td class="company-cell">{{ $attendee['company'] ?? '' }}</td>
                                <td class="datetime-cell">{{ $attendee['datetime'] ?? '' }}</td>
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
                                    <td class="reference-cell">
                                        <div style="word-break: break-all; font-size: 8px; line-height: 1.1;">
                                            {{ $order['order_ref'] }}
                                        </div>
                                    </td>
                                    <td class="date-cell">{{ $order['order_date'] }}</td>
                                    <td class="purchaser-info-cell">
                                        <div class="purchaser-info"><strong>{{ $order['purchaser_name'] }}</strong></div>
                                        <div class="small-text">{{ Str::limit($order['purchaser_email'], 25) }}</div>
                                        <div class="small-text">{{ $order['purchaser_phone'] }}</div>
                                        <div class="small-text">{{ $order['purchaser_identity_number'] }}</div>
                                    </td>
                                    <td class="name-cell">{{ $attendee['name'] }}</td>
                                    <td class="identity-cell">{{ $attendee['identity_number'] ?? '' }}</td>
                                    <td class="email-cell">{{ $attendee['email'] }}</td>
                                    <td class="phone-cell">{{ $attendee['phone'] }}</td>
                                    <td class="company-cell">{{ $attendee['company'] ?? '' }}</td>
                                    <td class="datetime-cell">{{ $attendee['datetime'] ?? '' }}</td>
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