<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
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
            background-color: #f4f4f4;
        }
        .summary-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Report - {{ ucfirst($type) }}</h1>
        <p>Generated on: {{ now()->format('d M Y H:i:s') }}</p>
        @if($month && $year)
        <p>Period: {{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}</p>
        @endif
    </div>

    @if($type == 'all' || $type == 'tickets')
    <div class="section">
        <h2>Ticket Statistics</h2>
        <div class="summary-box">
            <p><strong>Total Stock:</strong> {{ $data['total_stock'] }}</p>
            <p><strong>Total Sold:</strong> {{ $data['total_sold'] }}</p>
        </div>

        <h3>Ticket Type Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Ticket Type</th>
                    <th>Stock</th>
                    <th>Sold</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['ticket_types'] as $ticket)
                <tr>
                    <td>{{ $ticket['name'] }}</td>
                    <td>{{ $ticket['stock'] }}</td>
                    <td>{{ $ticket['sold'] }}</td>
                    <td>RM {{ number_format($ticket['total_sales'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($type == 'all' || $type == 'sales')
    <div class="section">
        <h2>Sales Report</h2>
        <div class="summary-box">
            <p><strong>Total Revenue:</strong> RM {{ number_format($data['total_revenue'], 2) }}</p>
        </div>

        <h3>Daily Sales</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Quantity Sold</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['monthly_sales'] as $sale)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}</td>
                    <td>{{ $sale->total_quantity }}</td>
                    <td>RM {{ number_format($sale->total_amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</body>
</html> 