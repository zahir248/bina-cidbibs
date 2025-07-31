<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - BINA</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-client.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-client.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon-client.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Simple Header -->
<nav class="simple-header">
    <div class="container">
        <div class="header-content">
            <a href="{{ route('client.home') }}" class="logo-link">
                <img src="{{ asset('images/bina-logo.png') }}" alt="BINA Logo" class="header-logo">
            </a>
            <a href="{{ route('client.home') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Main Site
            </a>
        </div>
    </div>
</nav>

<div class="order-result-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="order-result-card">
                    <div class="order-result-header">
                        <h1>Orders Found!</h1>
                        <p>Here are your order details ({{ $paidOrders->count() }} order{{ $paidOrders->count() > 1 ? 's' : '' }})</p>
                    </div>

                    <div class="orders-table-section">
                        <h3>Your Orders</h3>
                        <div class="table-responsive">
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>Order Reference</th>
                                        <th>Date</th>
                                        <th>Total Amount</th>
                                        <th>Tickets</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paidOrders as $order)
                                        <tr>
                                            <td>
                                                <strong>{{ $order->reference_number }}</strong>
                                            </td>
                                            <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <span class="amount">RM {{ number_format($order->total_amount, 2) }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $ticketCount = 0;
                                                    $ticketNames = [];
                                                    foreach($order->cart_items as $item) {
                                                        $ticket = \App\Models\Ticket::find($item['ticket_id']);
                                                        $ticketCount += $item['quantity'];
                                                        $ticketNames[] = $ticket->name;
                                                    }
                                                @endphp
                                                <div class="ticket-summary">
                                                    <span class="ticket-count">{{ $ticketCount }} ticket{{ $ticketCount > 1 ? 's' : '' }}</span>
                                                    <div class="ticket-names">
                                                        @foreach(array_unique($ticketNames) as $name)
                                                            <span class="ticket-name">{{ $name }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('client.order-lookup.download-pdf', $order) }}?email={{ urlencode($order->billingDetail->email) }}" 
                                                       class="btn-action btn-pdf" title="Download PDF">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                    <a href="{{ route('client.order-lookup.download-qr-codes', $order) }}?email={{ urlencode($order->billingDetail->email) }}" 
                                                       class="btn-action btn-qr" title="Download QR Codes">
                                                        <i class="fas fa-qrcode"></i>
                                                    </a>
                                                    <button class="btn-action btn-details" 
                                                            onclick="showOrderDetails('{{ $order->reference_number }}')" 
                                                            title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Order Details Modals -->
                    @foreach($paidOrders as $order)
                        <div id="modal-{{ $order->reference_number }}" class="order-modal">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3>Order Details - {{ $order->reference_number }}</h3>
                                    <button class="modal-close" onclick="closeOrderDetails('{{ $order->reference_number }}')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="order-info-grid">
                                        <div class="info-item">
                                            <span class="label">Reference Number:</span>
                                            <span class="value">{{ $order->reference_number }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label">Order Date:</span>
                                            <span class="value">{{ $order->created_at->format('d F Y, h:i A') }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label">Status:</span>
                                            <span class="value status-paid">
                                                <i class="fas fa-check-circle"></i> Paid
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label">Total Amount:</span>
                                            <span class="value">RM {{ number_format($order->total_amount, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class="tickets-section">
                                        <h4>Tickets Purchased</h4>
                                        <div class="tickets-list">
                                            @foreach($order->cart_items as $item)
                                                @php
                                                    $ticket = \App\Models\Ticket::find($item['ticket_id']);
                                                    $quantity = $item['quantity'];
                                                    $originalPrice = $ticket->price;
                                                    $discountedPrice = $ticket->getDiscountedPrice($quantity);
                                                @endphp
                                                <div class="ticket-item">
                                                                                                    <div class="ticket-info">
                                                    <h5>{{ $ticket->name }}</h5>
                                                    <div class="ticket-description">{!! $ticket->description !!}</div>
                                                        <div class="ticket-details">
                                                            <span class="quantity">Quantity: {{ $quantity }}</span>
                                                            <span class="price">Price: RM {{ number_format($originalPrice, 2) }}</span>
                                                            @if($discountedPrice != $originalPrice)
                                                                <span class="discounted-price">Discounted: RM {{ number_format($discountedPrice, 2) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="modal-actions">
                                        <a href="{{ route('client.order-lookup.download-pdf', $order) }}?email={{ urlencode($order->billingDetail->email) }}" 
                                           class="btn-download btn-primary">
                                            <i class="fas fa-file-pdf"></i>
                                            Download PDF
                                        </a>
                                        <a href="{{ route('client.order-lookup.download-qr-codes', $order) }}?email={{ urlencode($order->billingDetail->email) }}" 
                                           class="btn-download btn-secondary">
                                            <i class="fas fa-qrcode"></i>
                                            Download QR Codes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="download-info">
                        <p><strong>Important:</strong></p>
                        <ul>
                            <li>Keep your order confirmation PDFs safe - you may need them for entry</li>
                            <li>QR codes are required for event entry - download and save them</li>
                            <li>You can access these documents anytime using this lookup system</li>
                        </ul>
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('client.order-lookup') }}" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i> Look Up Another Order
                        </a>
                        <a href="{{ route('client.home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home"></i> Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Simple Header Styles */
.simple-header {
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 1rem 0;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo-link {
    text-decoration: none;
}

.header-logo {
    height: 40px;
    width: auto;
}

.back-link {
    color: #3498db;
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: color 0.3s ease;
}

.back-link:hover {
    color: #2980b9;
    text-decoration: none;
}

.order-result-container {
    padding: 60px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

.order-result-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 40px;
    margin-top: 20px;
}

.order-result-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #ecf0f1;
}

.order-result-header h1 {
    color: #27ae60;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.order-result-header p {
    color: #7f8c8d;
    font-size: 1.1rem;
    margin: 0;
}

.order-section {
    margin-bottom: 30px;
    padding: 25px;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #3498db;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #ecf0f1;
}

.order-header h3 {
    color: #2c3e50;
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
}

.order-date {
    color: #7f8c8d;
    font-size: 0.9rem;
    font-weight: 500;
}

.order-separator {
    border: none;
    height: 2px;
    background: linear-gradient(90deg, transparent, #3498db, transparent);
    margin: 40px 0;
}

/* Orders Table Styles */
.orders-table-section {
    margin-bottom: 30px;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.orders-table th {
    background: #3498db;
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
    font-size: 0.9rem;
}

.orders-table td {
    padding: 15px;
    border-bottom: 1px solid #ecf0f1;
    vertical-align: top;
}

.orders-table tr:hover {
    background: #f8f9fa;
}

.orders-table tr:last-child td {
    border-bottom: none;
}

.amount {
    font-weight: 600;
    color: #27ae60;
}

.ticket-summary {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.ticket-count {
    font-weight: 600;
    color: #2c3e50;
}

.ticket-names {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.ticket-name {
    background: #ecf0f1;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    color: #5a6c7d;
}

.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
}

.btn-pdf {
    background: #e74c3c;
    color: white;
}

.btn-pdf:hover {
    background: #c0392b;
    color: white;
}

.btn-qr {
    background: #9b59b6;
    color: white;
}

.btn-qr:hover {
    background: #8e44ad;
    color: white;
}

.btn-details {
    background: #3498db;
    color: white;
}

.btn-details:hover {
    background: #2980b9;
    color: white;
}

/* Modal Styles */
.order-modal {
    display: none;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
}

.modal-content {
    background-color: white;
    margin: 5% auto;
    padding: 0;
    border-radius: 15px;
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    border-bottom: 1px solid #ecf0f1;
    background: #f8f9fa;
    border-radius: 15px 15px 0 0;
}

.modal-header h3 {
    margin: 0;
    color: #2c3e50;
    font-size: 1.3rem;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #7f8c8d;
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.modal-close:hover {
    background: #e74c3c;
    color: white;
}

.modal-body {
    padding: 25px;
}

.modal-actions {
    display: flex;
    gap: 15px;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #ecf0f1;
}

.modal-actions .btn-download {
    flex: 1;
    justify-content: center;
    padding: 12px 20px;
    font-size: 0.9rem;
}

.order-details-section,
.billing-details-section,
.tickets-section,
.download-section {
    margin-bottom: 20px;
    padding: 20px;
    background: white;
    border-radius: 8px;
    border-left: 3px solid #3498db;
}

.order-details-section {
    border-left-color: #27ae60;
}

.billing-details-section {
    border-left-color: #e67e22;
}

.tickets-section {
    border-left-color: #9b59b6;
}

.download-section {
    border-left-color: #f39c12;
}

h3 {
    color: #2c3e50;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

h4 {
    color: #2c3e50;
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

h5 {
    color: #2c3e50;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 8px;
}

.order-info-grid,
.billing-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #ecf0f1;
}

.info-item:last-child {
    border-bottom: none;
}

.label {
    font-weight: 600;
    color: #5a6c7d;
    min-width: 120px;
}

.value {
    color: #2c3e50;
    font-weight: 500;
}

.status-paid {
    color: #27ae60;
    font-weight: 600;
}

.status-paid i {
    margin-right: 5px;
}

.tickets-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.ticket-item {
    background: white;
    border-radius: 8px;
    padding: 20px;
    border: 1px solid #ecf0f1;
}

.ticket-item h4 {
    color: #2c3e50;
    margin-bottom: 8px;
    font-weight: 600;
}

.ticket-description {
    color: #7f8c8d;
    margin-bottom: 12px;
    font-size: 0.9rem;
    line-height: 1.5;
}

.ticket-description ul {
    margin: 8px 0;
    padding-left: 20px;
}

.ticket-description li {
    margin-bottom: 5px;
    line-height: 1.4;
}

.ticket-description b {
    font-weight: 600;
    color: #2c3e50;
}

.ticket-details {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    font-size: 0.9rem;
}

.ticket-details span {
    background: #ecf0f1;
    padding: 4px 8px;
    border-radius: 4px;
    color: #5a6c7d;
}

.discounted-price {
    color: #e74c3c !important;
    font-weight: 600;
}

.download-buttons {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 20px;
}

.btn-download {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-download.btn-primary {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
}

.btn-download.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
}

.btn-download.btn-secondary {
    background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
    color: white;
}

.btn-download.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(149, 165, 166, 0.4);
}

.download-info {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 8px;
    padding: 15px;
}

.download-info p {
    margin-bottom: 10px;
    color: #856404;
    font-weight: 600;
}

.download-info ul {
    margin: 0;
    padding-left: 20px;
    color: #856404;
}

.download-info li {
    margin-bottom: 5px;
}

.action-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 30px;
    padding-top: 30px;
    border-top: 2px solid #ecf0f1;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-primary {
    border: 2px solid #3498db;
    color: #3498db;
}

.btn-outline-primary:hover {
    background-color: #3498db;
    color: white;
}

.btn-outline-secondary {
    border: 2px solid #95a5a6;
    color: #95a5a6;
}

.btn-outline-secondary:hover {
    background-color: #95a5a6;
    color: white;
}

@media (max-width: 768px) {
    .simple-header {
        padding: 0.75rem 0;
    }
    
    .header-logo {
        height: 35px;
    }
    
    .back-link {
        font-size: 0.9rem;
    }
    
    .order-result-container {
        padding: 40px 0;
    }
    
    .order-result-card {
        padding: 30px 20px;
        margin: 10px;
    }
    
    .order-result-header h1 {
        font-size: 2rem;
    }
    
    .orders-table {
        font-size: 0.9rem;
    }
    
    .orders-table th,
    .orders-table td {
        padding: 10px 8px;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 5px;
    }
    
    .btn-action {
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }
    
    .ticket-names {
        flex-direction: column;
        gap: 3px;
    }
    
    .ticket-name {
        font-size: 0.7rem;
        padding: 1px 6px;
    }
    
    .modal-content {
        width: 95%;
        margin: 10% auto;
    }
    
    .modal-actions {
        flex-direction: column;
    }
    
    .order-info-grid,
    .billing-info-grid {
        grid-template-columns: 1fr;
    }
    
    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .ticket-details {
        flex-direction: column;
        gap: 8px;
    }
}
</style>

<script>
// JavaScript for modal functionality
function showOrderDetails(orderRef) {
    const modal = document.getElementById('modal-' + orderRef);
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function closeOrderDetails(orderRef) {
    const modal = document.getElementById('modal-' + orderRef);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.order-modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = document.querySelectorAll('.order-modal');
        modals.forEach(modal => {
            if (modal.style.display === 'block') {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    }
});
</script>
</body>
</html> 