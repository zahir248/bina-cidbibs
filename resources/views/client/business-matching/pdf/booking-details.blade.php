<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Matching Registration Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
            color: #333;
            margin: 0;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #e67e00;
            padding-bottom: 10px;
        }
        
        .header h1 {
            color: #e67e00;
            font-size: 18px;
            margin: 0 0 5px 0;
            font-weight: bold;
        }
        
        .header h2 {
            color: #666;
            font-size: 14px;
            margin: 0;
            font-weight: normal;
        }
        
        .content {
            margin-bottom: 15px;
        }
        
        .section {
            margin-bottom: 12px;
        }
        
        .section h3 {
            color: #e67e00;
            font-size: 12px;
            margin: 0 0 8px 0;
            padding-bottom: 3px;
            border-bottom: 1px solid #e67e00;
            font-weight: bold;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 4px;
            align-items: flex-start;
        }
        
        .info-label {
            font-weight: bold;
            width: 120px;
            color: #555;
            font-size: 9px;
        }
        
        .info-value {
            flex: 1;
            color: #333;
            font-size: 9px;
        }
        
        .badge {
            background-color: #e67e00;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 8px;
        }
        
        .important-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 3px;
            padding: 8px;
            margin: 10px 0;
        }
        
        .important-notice h4 {
            color: #e67e00;
            margin: 0 0 5px 0;
            font-size: 10px;
        }
        
        .important-notice p {
            margin: 0;
            font-size: 8px;
        }
        
        .interests {
            display: flex;
            flex-wrap: wrap;
            gap: 3px;
        }
        
        .interest-badge {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 1px 4px;
            border-radius: 2px;
            font-size: 8px;
        }
        
        .two-column {
            display: flex;
            gap: 20px;
        }
        
        .column {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BUSINESS MATCHING REGISTRATION</h1>
        <h2>Registration Confirmation</h2>
    </div>

    <div class="content">
        <div class="two-column">
            <!-- Left Column -->
            <div class="column">
                <!-- Registration Details -->
                <div class="section">
                    <h3>Registration Details</h3>
                    <div class="info-row">
                        <div class="info-label">Reference:</div>
                        <div class="info-value">
                            <span class="badge">{{ $booking->getReferenceNumber() }}</span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Date:</div>
                        <div class="info-value">{{ $booking->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Status:</div>
                        <div class="info-value">
                            <span class="badge">Registered</span>
                        </div>
                    </div>
                </div>

                <!-- Session Information -->
                <div class="section">
                    <h3>Session Information</h3>
                    <div class="info-row">
                        <div class="info-label">Session:</div>
                        <div class="info-value">{{ $booking->businessMatching->name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Date:</div>
                        <div class="info-value">{{ $booking->businessMatching->date->format('M d, Y') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Time Slot:</div>
                        <div class="info-value">{{ $booking->timeSlot->getFormattedTimeRange() }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Panel:</div>
                        <div class="info-value">Auto-assigned</div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="column">
                <!-- Participant Information -->
                <div class="section">
                    <h3>Participant Information</h3>
                    <div class="info-row">
                        <div class="info-label">Name:</div>
                        <div class="info-value">{{ $booking->participant_name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email:</div>
                        <div class="info-value">{{ $booking->participant_email }}</div>
                    </div>
                    @if($booking->participant_phone)
                    <div class="info-row">
                        <div class="info-label">Phone:</div>
                        <div class="info-value">{{ $booking->participant_phone }}</div>
                    </div>
                    @endif
                    @if($booking->identity_number)
                    <div class="info-row">
                        <div class="info-label">ID Number:</div>
                        <div class="info-value">{{ $booking->identity_number }}</div>
                    </div>
                    @endif
                    @if($booking->company_name)
                    <div class="info-row">
                        <div class="info-label">Company:</div>
                        <div class="info-value">{{ $booking->company_name }}</div>
                    </div>
                    @endif
                    @if($booking->business_type)
                    <div class="info-row">
                        <div class="info-label">Business Type:</div>
                        <div class="info-value">{{ $booking->business_type }}</div>
                    </div>
                    @endif
                </div>

                <!-- Areas of Interest -->
                @if($booking->interests && count($booking->interests) > 0)
                <div class="section">
                    <h3>Areas of Interest</h3>
                    <div class="interests">
                        @foreach($booking->interests as $interest)
                            <span class="interest-badge">{{ $interest }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Important Notice -->
        <div class="important-notice">
            <h4>Important Reminders</h4>
            <p><strong>Please arrive 15 minutes before your scheduled time slot.</strong> Bring a business card and be prepared to network with other participants. Panel assignments will be provided on the day of the event.</p>
        </div>
    </div>

    <div class="footer">
        <p>This is an automated confirmation. Please keep this document for your records.</p>
        <p>Generated on {{ now()->format('M d, Y H:i') }}</p>
    </div>
</body>
</html>
