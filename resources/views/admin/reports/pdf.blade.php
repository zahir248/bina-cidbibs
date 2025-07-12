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
        .summary-cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .summary-card {
            flex: 1;
            margin: 0 10px;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            text-align: center;
        }
        .card-title {
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .card-value {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .total-row {
            background-color: #f4f4f4;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Report</h1>
        <p>Generated on: {{ now()->format('d M Y H:i:s') }}</p>
        <p>Event: {{ $event === 'all' ? 'All Events' : ($event === 'bina' ? 'BINA Events' : 'Sarawak Facility Management Engagement Day') }}</p>
    </div>

    <!-- Summary Cards -->
    <div class="section">
        <div class="summary-cards">
            @if(isset($data['total_stock']))
            <div class="summary-card">
                <div class="card-title">Total Stock</div>
                <div class="card-value">{{ $data['total_stock'] }}</div>
            </div>
            @endif
            @if(isset($data['total_sold']))
            <div class="summary-card">
                <div class="card-title">Total Sold</div>
                <div class="card-value">{{ $data['total_sold'] }}</div>
            </div>
            @endif
            @if(isset($data['total_revenue']))
            <div class="summary-card">
                <div class="card-title">Total Sales</div>
                <div class="card-value">RM {{ number_format($data['total_revenue'], 2) }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Ticket Type Statistics -->
    @if(isset($data['ticket_types']) && !empty($data['ticket_types']))
    <div class="section">
        <h2>Ticket Type Statistics</h2>
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
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">Total:</td>
                    <td>RM {{ number_format(collect($data['ticket_types'])->sum('total_sales'), 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    <!-- Monthly Sales -->
    @if(isset($data['monthly_sales']) && !empty($data['monthly_sales']))
    <div class="section">
        <h2>Monthly Sales</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['monthly_sales'] as $sale)
                <tr>
                    <td>{{ $sale['date'] }}</td>
                    <td>RM {{ number_format($sale['total'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</body>
</html> 