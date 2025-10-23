<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>All Business Matching Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        
        .header p {
            margin: 5px 0 0 0;
            color: #7f8c8d;
        }
        
        .session-group {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }
        
        .session-header {
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .session-header-0 {
            background-color: #3498db;
        }
        
        .session-header-1 {
            background-color: #e74c3c;
        }
        
        .session-header-2 {
            background-color: #27ae60;
        }
        
        .session-header-3 {
            background-color: #f39c12;
        }
        
        .session-header-4 {
            background-color: #9b59b6;
        }
        
        .session-header-5 {
            background-color: #1abc9c;
        }
        
        .session-header-6 {
            background-color: #34495e;
        }
        
        .session-header-7 {
            background-color: #e67e22;
        }
        
        .session-header-8 {
            background-color: #2ecc71;
        }
        
        .session-header-9 {
            background-color: #8e44ad;
        }
        
        .session-header h2 {
            margin: 0;
            font-size: 18px;
        }
        
        .session-header p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        
        .time-slot-group {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .time-slot-header {
            background-color: #ecf0f1;
            padding: 10px 15px;
            margin-bottom: 15px;
            border-left: 4px solid #3498db;
        }
        
        .time-slot-header h3 {
            margin: 0;
            font-size: 14px;
            color: #2c3e50;
        }
        
        .time-slot-header p {
            margin: 3px 0 0 0;
            font-size: 12px;
            color: #7f8c8d;
        }
        
        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .bookings-table th {
            background-color: #34495e;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
        }
        
        .bookings-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        
        .bookings-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .bookings-table tr:hover {
            background-color: #e8f4f8;
        }
        
        
        .participant-name {
            font-weight: bold;
        }
        
        .email {
            color: #3498db;
        }
        
        .interests {
            max-width: 150px;
            word-wrap: break-word;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .no-data {
            text-align: center;
            color: #7f8c8d;
            font-style: italic;
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>All Business Matching Bookings</h1>
        <p>Generated on: {{ $exportDate }}</p>
    </div>

    @if(count($groupedData) > 0)
        @foreach($groupedData as $index => $sessionData)
             <div class="session-group {{ $index > 0 ? 'page-break' : '' }}">
                 <div class="session-header session-header-{{ $index % 10 }}">
                     <h2>Panel: {{ $sessionData['panel_name'] }}</h2>
                     <p>Date: {{ $sessionData['session_date'] }} | Total Participants: {{ $sessionData['total_participants'] }}</p>
                 </div>

                @foreach($sessionData['time_slots'] as $timeSlotData)
                    <div class="time-slot-group">
                        <div class="time-slot-header">
                            <h3>Time Slot: {{ $timeSlotData['time_slot'] }}</h3>
                            <p>Participants: {{ $timeSlotData['participant_count'] }}</p>
                        </div>

                        @if(count($timeSlotData['bookings']) > 0)
                            <table class="bookings-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Company</th>
                                        <th>Business Type</th>
                                        <th>Panel</th>
                                        <th>Interests</th>
                                        <th>Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($timeSlotData['bookings'] as $booking)
                                        <tr>
                                            <td class="participant-name">{{ $booking['participant_name'] }}</td>
                                            <td class="email">{{ $booking['participant_email'] }}</td>
                                            <td>{{ $booking['participant_phone'] }}</td>
                                            <td>{{ $booking['company_name'] }}</td>
                                            <td>{{ $booking['business_type'] }}</td>
                                            <td>{{ $booking['panel_name'] }}</td>
                                            <td class="interests">{{ $booking['interests'] }}</td>
                                            <td>{{ $booking['registered_date'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="no-data">No bookings found for this time slot</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <div class="no-data">No business matching bookings found</div>
    @endif

    <div class="footer">
        <p>This report was generated automatically on {{ $exportDate }}</p>
        <p>BINA CIDBIBS Business Matching System</p>
    </div>
</body>
</html>
