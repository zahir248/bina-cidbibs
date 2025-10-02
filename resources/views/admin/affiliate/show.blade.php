@extends('admin.layouts.app')

@section('title', 'Affiliate Details')

@push('styles')
<style>
    .order-row {
        transition: all 0.2s ease;
    }
    
    .order-row:hover {
        background-color: #f8f9fa !important;
        transform: translateX(2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .order-row:hover td {
        color: #0d6efd !important;
    }
    
    .order-row:hover .text-primary {
        color: #0a58ca !important;
    }
    
    .order-row:hover .text-muted {
        color: #6c757d !important;
    }
    
    .order-row:hover .fa-external-link-alt {
        color: #0d6efd !important;
        transform: scale(1.1);
    }
    
    /* Total Amount Card Styling */
    .card.text-center .h2.text-info {
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    .card.text-center .text-info {
        color: #0dcaf0 !important;
    }
    
    .card.text-center .fa-dollar-sign {
        font-size: 0.9em;
        opacity: 0.8;
    }
    
    /* Ensure all cards have equal height */
    .card.h-100 {
        display: flex;
        flex-direction: column;
    }
    
    .card.h-100 .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    /* Affiliate Link Styling */
    .affiliate-link-input {
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        background-color: #f8f9fa;
        border: 2px solid #e9ecef;
    }
    
    .affiliate-link-input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .copy-btn {
        transition: all 0.2s ease;
        min-width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .copy-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Ensure copy buttons are visible */
    .input-group .btn {
        display: flex !important;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        z-index: 2;
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: white !important;
    }
    
    .input-group .btn:hover {
        background-color: #0b5ed7 !important;
        border-color: #0a58ca !important;
        color: white !important;
    }
    
    .input-group .btn i {
        font-size: 0.9rem;
        color: white !important;
    }
    
    .affiliate-link-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        border-left: 4px solid #0d6efd;
    }
    
    .affiliate-link-section .form-label {
        color: #0d6efd;
        font-weight: 700;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Affiliate Details</h2>
                <a href="{{ route('admin.affiliates.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">Affiliate Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">User:</label>
                                <p class="form-control-plaintext">
                                    <strong>{{ $affiliate->user->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $affiliate->user->email ?? 'N/A' }}</small>
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Affiliate Code:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $affiliate->affiliate_code }}" readonly>
                                    <button class="btn btn-primary" type="button" onclick="copyToClipboard('{{ $affiliate->affiliate_code }}')">
                                        <i class="bi bi-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="affiliate-link-section">
                                <label class="form-label fw-bold">Affiliate Link:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control affiliate-link-input" value="{{ $affiliate->affiliate_link }}" readonly id="affiliateLink">
                                    <button class="btn btn-primary copy-btn" type="button" onclick="copyToClipboard('{{ $affiliate->affiliate_link }}')" title="Copy Link">
                                        <i class="bi bi-copy"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Share this link to track referrals
                                    </small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Name:</label>
                                <p class="form-control-plaintext">{{ $affiliate->name ?: 'N/A' }}</p>
                            </div>

                            @if($affiliate->description)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description:</label>
                                    <p class="form-control-plaintext">{{ $affiliate->description }}</p>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status:</label>
                                <form action="{{ route('admin.affiliates.update-status', $affiliate) }}" method="POST" class="d-inline">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                               name="is_active"
                                               value="1"
                                               {{ $affiliate->is_active ? 'checked' : '' }}
                                               onchange="this.form.submit()">
                                        <label class="form-check-label">
                                            {{ $affiliate->is_active ? 'Active' : 'Inactive' }}
                                        </label>
                                    </div>
                                </form>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Created:</label>
                                <p class="form-control-plaintext">{{ $affiliate->created_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Last Updated:</label>
                                <p class="form-control-plaintext">{{ $affiliate->updated_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <div class="h2 text-primary mb-0">{{ $affiliate->total_clicks }}</div>
                                    <small class="text-muted">Total Clicks</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <div class="h2 text-success mb-0">{{ $affiliate->total_conversions }}</div>
                                    <small class="text-muted">Conversions</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <div class="h2 text-info mb-0">
                                        <i class="fas fa-dollar-sign me-1"></i>
                                        RM {{ number_format($totalAmount, 2) }}
                                    </div>
                                    <small class="text-muted">Total Amount</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <div class="h2 text-warning mb-0">{{ $recentOrders->count() }}</div>
                                    <small class="text-muted">Recent Orders</small>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Recent Orders</h6>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Click on any order row to view details in the orders page
                            </small>
                        </div>
                        <div class="card-body">
                            @if($recentOrders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Customer</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentOrders as $order)
                                                <tr class="order-row" style="cursor: pointer;" onclick="viewOrder('{{ $order->reference_number }}')" title="Click to view order details">
                                                    <td>
                                                        <strong class="text-primary">{{ $order->reference_number }}</strong>
                                                        <i class="fas fa-external-link-alt ms-1 text-muted" style="font-size: 0.8em;"></i>
                                                    </td>
                                                    <td>
                                                        {{ $order->billingDetail->first_name }} {{ $order->billingDetail->last_name }}
                                                        <br>
                                                        <small class="text-muted">{{ $order->billingDetail->email }}</small>
                                                    </td>
                                                    <td>RM {{ number_format($order->total_amount, 2) }}</td>
                                                    <td>{{ $order->created_at->format('M j, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted text-center py-3">No orders found for this affiliate.</p>
                            @endif
                        </div>
                    </div>

                    @if($monthlyStats->count() > 0)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="mb-0">Monthly Statistics</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th>Orders</th>
                                                <th>Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($monthlyStats as $stat)
                                                <tr>
                                                    <td>{{ $stat->month }}</td>
                                                    <td>{{ $stat->orders_count }}</td>
                                                    <td>RM {{ number_format($stat->total_revenue, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show a temporary success message
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="bi bi-check"></i>';
        button.classList.add('btn-success');
        button.classList.remove('btn-primary');
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('btn-success');
            button.classList.add('btn-primary');
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            // Show success message even with fallback
            const button = event.target.closest('button');
            const originalHTML = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check"></i>';
            button.classList.add('btn-success');
            button.classList.remove('btn-primary');
            
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('btn-success');
                button.classList.add('btn-primary');
            }, 2000);
        } catch (fallbackErr) {
            console.error('Fallback copy failed: ', fallbackErr);
        }
        document.body.removeChild(textArea);
    });
}

function viewOrder(referenceNumber) {
    // Redirect to orders page with the specific order reference number as search filter
    const ordersUrl = '{{ route("admin.orders.index") }}?search=' + encodeURIComponent(referenceNumber);
    window.open(ordersUrl, '_blank');
}

</script>
@endsection
