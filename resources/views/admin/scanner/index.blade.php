<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Scanner</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 16px;
            background-color: #f8fafc;
            color: #1e293b;
            line-height: 1.5;
        }
        #reader {
            width: 100%;
            max-width: 500px;
            margin: 0 auto 24px;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        #result {
            margin: 16px auto;
            max-width: 500px;
            border-radius: 12px;
            display: none;
        }
        .success {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
        }
        .error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 16px;
        }
        h1 {
            text-align: center;
            color: #0f172a;
            margin: 24px 0 32px;
            font-weight: 600;
            font-size: 1.875rem;
        }
        .result-details {
            margin-top: 16px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .section {
            padding: 20px;
        }
        .section + .section {
            border-top: 1px solid #e2e8f0;
        }
        .section-title {
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 16px;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        .detail-item {
            min-width: 0;
        }
        .detail-label {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 4px;
        }
        .detail-value {
            color: #0f172a;
            font-weight: 500;
            overflow-wrap: break-word;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            line-height: 1.25;
        }
        .status-paid {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-pending {
            background-color: #fef9c3;
            color: #854d0e;
        }
        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .message-banner {
            padding: 12px 16px;
            border-radius: 8px;
            font-weight: 500;
            margin-bottom: 16px;
        }
        .success .message-banner {
            background-color: #bbf7d0;
            color: #166534;
        }
        .error .message-banner {
            background-color: #fecaca;
            color: #991b1b;
        }
        @media (max-width: 640px) {
            .detail-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .section {
                padding: 16px;
            }
            h1 {
                font-size: 1.5rem;
                margin: 20px 0 24px;
            }
        }
        .subsection-title {
            color: #475569;
            font-weight: 600;
            font-size: 0.9rem;
            margin: 20px 0 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
        }
        .ticket-details,
        .payment-details,
        .address-details,
        .business-details,
        .academic-details {
            margin-top: 24px;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        .total {
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #e2e8f0;
            grid-column: 1 / -1;
        }
        .total .detail-value {
            color: #059669;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ticket Scanner</h1>
        <div id="reader"></div>
        <div id="result"></div>
    </div>

    <script>
        function formatResultHTML(data) {
            const order = data.order;
            const billing = data.billing;
            const participants = data.participants || [];
            
            const getStatusClass = (status) => {
                switch(status.toLowerCase()) {
                    case 'paid':
                        return 'status-paid';
                    case 'pending':
                        return 'status-pending';
                    case 'cancelled':
                        return 'status-cancelled';
                    default:
                        return '';
                }
            };

            return `
                <div class="result-details">
                    <div class="section">
                        <div class="section-title">Order Information</div>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Reference</div>
                                <div class="detail-value">${order.reference}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    <span class="status-badge ${getStatusClass(order.status)}">${order.status}</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Purchase Date</div>
                                <div class="detail-value">${order.created_at}</div>
                            </div>
                        </div>

                        <div class="ticket-details">
                            <div class="subsection-title">Ticket Details</div>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Ticket Name</div>
                                    <div class="detail-value">${order.ticket.name}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Quantity</div>
                                    <div class="detail-value">${order.ticket.quantity}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Original Price</div>
                                    <div class="detail-value">RM ${order.ticket.price}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Discounted Price</div>
                                    <div class="detail-value">RM ${order.ticket.discounted_price}</div>
                                </div>
                            </div>
                        </div>

                        <div class="payment-details">
                            <div class="subsection-title">Payment Summary</div>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Payment Method</div>
                                    <div class="detail-value">${order.payment.method}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Subtotal</div>
                                    <div class="detail-value">RM ${order.payment.subtotal}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Processing Fee</div>
                                    <div class="detail-value">RM ${order.payment.processing_fee}</div>
                                </div>
                                <div class="detail-item total">
                                    <div class="detail-label">Total Amount</div>
                                    <div class="detail-value">RM ${order.payment.total_amount}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section">
                        <div class="section-title">Billing Information</div>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Full Name</div>
                                <div class="detail-value">${billing.name}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Email</div>
                                <div class="detail-value">${billing.email}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Phone</div>
                                <div class="detail-value">${billing.phone}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Gender</div>
                                <div class="detail-value">${billing.gender}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Category</div>
                                <div class="detail-value">${billing.category}</div>
                            </div>
                        </div>

                        <div class="address-details">
                            <div class="subsection-title">Address</div>
                            <div class="detail-grid">
                                <div class="detail-item full-width">
                                    <div class="detail-label">Street Address</div>
                                    <div class="detail-value">${billing.address.join('<br>')}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">City</div>
                                    <div class="detail-value">${billing.city}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">State</div>
                                    <div class="detail-value">${billing.state}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Country</div>
                                    <div class="detail-value">${billing.country}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Postal Code</div>
                                    <div class="detail-value">${billing.postcode}</div>
                                </div>
                            </div>
                        </div>

                        ${billing.business ? `
                            <div class="business-details">
                                <div class="subsection-title">Business Information</div>
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <div class="detail-label">Company Name</div>
                                        <div class="detail-value">${billing.business.company_name}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Registration No.</div>
                                        <div class="detail-value">${billing.business.registration_number}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Tax Number</div>
                                        <div class="detail-value">${billing.business.tax_number}</div>
                                    </div>
                                </div>
                            </div>
                        ` : ''}

                        ${billing.academic ? `
                            <div class="academic-details">
                                <div class="subsection-title">Academic Information</div>
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <div class="detail-label">Institution</div>
                                        <div class="detail-value">${billing.academic.institution}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Student ID</div>
                                        <div class="detail-value">${billing.academic.student_id}</div>
                                    </div>
                                </div>
                            </div>
                        ` : ''}
                    </div>
                    
                    ${participants.length > 0 ? `
                        <div class="section">
                            <div class="section-title">Participant Details</div>
                            ${participants.map((participant, index) => `
                                <div class="participant-details" style="margin-top: ${index > 0 ? '24px' : '0'}; padding-top: ${index > 0 ? '24px' : '0'}; border-top: ${index > 0 ? '1px solid #e2e8f0' : 'none'};">
                                    <div class="subsection-title">Participant ${index + 1}</div>
                                    <div class="detail-grid">
                                        <div class="detail-item">
                                            <div class="detail-label">Full Name</div>
                                            <div class="detail-value">${participant.full_name}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Phone</div>
                                            <div class="detail-value">${participant.phone}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Email</div>
                                            <div class="detail-value">${participant.email}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Gender</div>
                                            <div class="detail-value">${participant.gender}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Company Name</div>
                                            <div class="detail-value">${participant.company_name}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Identity Number</div>
                                            <div class="detail-value">${participant.identity_number}</div>
                                        </div>
                                                                            <div class="detail-item">
                                        <div class="detail-label">Ticket Number</div>
                                        <div class="detail-value">${participant.ticket_number}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Ticket Name</div>
                                        <div class="detail-value">${participant.ticket_name}</div>
                                    </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    ` : ''}
                </div>
            `;
        }

        function onScanSuccess(decodedText) {
            let resultDiv = document.getElementById('result');
            resultDiv.style.display = 'block';

            try {
                fetch('{{ route("scanner.verify") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        data: decodedText
                    })
                })
                .then(response => response.json())
                .then(data => {
                    resultDiv.className = data.status === 'success' ? 'success' : 'error';
                    
                    if (data.status === 'success' && data.data) {
                        resultDiv.innerHTML = `
                            <div class="message-banner">${data.message}</div>
                            ${formatResultHTML(data.data)}
                        `;
                    } else {
                        resultDiv.innerHTML = `<div class="message-banner">${data.message}</div>`;
                    }
                })
                .catch(error => {
                    resultDiv.className = 'error';
                    resultDiv.innerHTML = '<div class="message-banner">Error processing QR code</div>';
                });
            } catch (error) {
                resultDiv.className = 'error';
                resultDiv.innerHTML = '<div class="message-banner">Invalid QR code format</div>';
            }
        }

        function onScanError(error) {
            console.warn(`QR error: ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", 
            { 
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            }
        );
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>
</body>
</html> 