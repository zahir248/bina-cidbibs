@extends('admin.layouts.app')

@section('title', 'ADMIN | Affiliate Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Affiliate Details</h3>
                    <a href="{{ route('admin.affiliates.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Back to List
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">User</label>
                                <p class="form-control-plaintext">
                                    <strong>{{ $affiliate->user->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $affiliate->user->email ?? 'N/A' }}</small>
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Affiliate Code</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $affiliate->affiliate_code }}" readonly>
                                    <button class="btn btn-primary" type="button" onclick="copyToClipboard('{{ $affiliate->affiliate_code }}')">
                                        <i class="bi bi-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Affiliate Link</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $affiliate->affiliate_link }}" readonly>
                                    <button class="btn btn-primary" type="button" onclick="copyToClipboard('{{ $affiliate->affiliate_link }}')">
                                        <i class="bi bi-copy"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Share this link to track referrals
                                </small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <p class="form-control-plaintext">{{ $affiliate->name ?: 'N/A' }}</p>
                            </div>

                            @if($affiliate->description)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <p class="form-control-plaintext">{{ $affiliate->description }}</p>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <form action="{{ route('admin.affiliates.update-status', $affiliate) }}" method="POST" class="d-inline">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                               name="is_active"
                                               value="1"
                                               {{ $affiliate->is_active ? 'checked' : '' }}
                                               onchange="this.form.submit()">
                                        <label class="form-check-label">
                                            @if($affiliate->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-warning">Inactive</span>
                                            @endif
                                        </label>
                                    </div>
                                </form>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Created</label>
                                <p class="form-control-plaintext">{{ $affiliate->created_at->format('M j, Y g:i A') }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Last Updated</label>
                                <p class="form-control-plaintext">{{ $affiliate->updated_at->format('M j, Y g:i A') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h2 class="text-primary">{{ $affiliate->total_clicks }}</h2>
                                            <p class="text-muted mb-0">Total Clicks</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h2 class="text-success">{{ $affiliate->total_conversions }}</h2>
                                            <p class="text-muted mb-0">Conversions</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h2 class="text-info">{{ $ordersCount }}</h2>
                                            <p class="text-muted mb-0">Total Orders</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h2 class="text-info">RM {{ number_format($totalAmount, 2) }}</h2>
                                            <p class="text-muted mb-0">Total Amount</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="mt-4" id="orders-section">
                        <h5 class="mb-3">All Orders</h5>
                        @if($recentOrders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">No</th>
                                            <th>Order #</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentOrders as $order)
                                        <tr>
                                            <td class="text-center">{{ $recentOrders->firstItem() + $loop->index }}</td>
                                            <td class="text-primary">{{ $order->reference_number }}</td>
                                            <td>
                                                <div>
                                                    <strong>{{ $order->billingDetail->first_name }} {{ $order->billingDetail->last_name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $order->billingDetail->email }}</small>
                                                </div>
                                            </td>
                                            <td class="text-success">RM {{ number_format($order->total_amount, 2) }}</td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.orders.index') }}?search={{ $order->reference_number }}" 
                                                   class="btn btn-sm btn-warning" target="_blank">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="mt-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        Showing {{ $recentOrders->firstItem() }} to {{ $recentOrders->lastItem() }} of {{ $recentOrders->total() }} results
                                    </div>
                                    <div>
                                        {{ $recentOrders->appends(['scroll' => 'orders'])->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-cart-x fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">No orders found for this affiliate</p>
                            </div>
                        @endif
                    </div>

                    @if($monthlyStats->count() > 0)
                        <div class="mt-4">
                            <h5 class="mb-3">Monthly Statistics</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
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

// Auto-scroll to orders table when pagination is clicked
document.addEventListener('DOMContentLoaded', function() {
    // Check if we should scroll to orders section
    const urlParams = new URLSearchParams(window.location.search);
    
    // If there's a scroll parameter, scroll to orders section
    if (urlParams.get('scroll') === 'orders') {
        setTimeout(function() {
            const ordersSection = document.getElementById('orders-section');
            if (ordersSection) {
                ordersSection.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }, 300);
    }
});
</script>
@endpush
