@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Orders</h3>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <div class="mb-3">
                        <form id="searchForm" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchReference" placeholder="Search by Reference Number">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="date" class="form-control" id="startDate" placeholder="Start Date">
                                    <span class="input-group-text">to</span>
                                    <input type="date" class="form-control" id="endDate" placeholder="End Date">
                                    <button class="btn btn-secondary" type="button" id="clearDates">
                                        <i class="bi bi-x-circle"></i> Clear
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Reference Number</th>
                                    <th>Total Amount</th>
                                    <th>Cart Items</th>
                                    <th>Billing Details</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $order->reference_number }}</td>
                                    <td>RM {{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <a href="#" class="text-primary view-items" 
                                           data-bs-toggle="modal" 
                                           data-bs-target="#itemsModal"
                                           data-order-id="{{ $order->id }}">
                                            View Items
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-primary view-billing" 
                                           data-bs-toggle="modal" 
                                           data-bs-target="#billingModal"
                                           data-billing-id="{{ $order->billing_detail_id }}">
                                            View Details
                                        </a>
                                    </td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status === 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.download-pdf', $order->id) }}" 
                                           class="text-primary">
                                            Download PDF
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Billing Details Modal -->
<div class="modal fade" id="billingModal" tabindex="-1" aria-labelledby="billingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="billingModalLabel">Billing Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> <span id="billing-name"></span></p>
                        <p><strong>Email:</strong> <span id="billing-email"></span></p>
                        <p><strong>Phone:</strong> <span id="billing-phone"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Country:</strong> <span id="billing-country"></span></p>
                        <p><strong>Address 1:</strong> <span id="billing-address1"></span></p>
                        <p><strong>Address 2:</strong> <span id="billing-address2"></span></p>
                        <p><strong>City:</strong> <span id="billing-city"></span></p>
                        <p><strong>State:</strong> <span id="billing-state"></span></p>
                        <p><strong>Postcode:</strong> <span id="billing-postcode"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cart Items Modal -->
<div class="modal fade" id="itemsModal" tabindex="-1" aria-labelledby="itemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemsModalLabel">Cart Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ticket</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="items-table-body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchReference');
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const clearDatesBtn = document.getElementById('clearDates');
    const tableRows = document.querySelectorAll('tbody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
        const endDate = endDateInput.value ? new Date(endDateInput.value) : null;

        // Set end date to end of day if it exists
        if (endDate) {
            endDate.setHours(23, 59, 59, 999);
        }

        tableRows.forEach(row => {
            const referenceCell = row.querySelector('td:nth-child(2)');
            const dateCell = row.querySelector('td:nth-child(6)');
            const referenceNumber = referenceCell.textContent.toLowerCase();
            const orderDate = new Date(dateCell.textContent);

            const matchesSearch = referenceNumber.includes(searchTerm);
            const matchesDateRange = (!startDate || orderDate >= startDate) && 
                                   (!endDate || orderDate <= endDate);

            row.style.display = (matchesSearch && matchesDateRange) ? '' : 'none';
        });
    }

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        filterTable();
    });

    // Filter when dates change
    startDateInput.addEventListener('change', filterTable);
    endDateInput.addEventListener('change', filterTable);

    // Clear dates button
    clearDatesBtn.addEventListener('click', function() {
        startDateInput.value = '';
        endDateInput.value = '';
        filterTable();
    });

    // Clear search when input is cleared
    searchInput.addEventListener('input', function() {
        if (this.value === '') {
            filterTable();
        }
    });

    // Billing Details Modal
    const billingModal = document.getElementById('billingModal');
    const viewBillingLinks = document.querySelectorAll('.view-billing');

    viewBillingLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const billingId = this.dataset.billingId;
            
            // Fetch billing details
            fetch(`/admin/billing-details/${billingId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('billing-name').textContent = `${data.first_name} ${data.last_name}`;
                    document.getElementById('billing-email').textContent = data.email;
                    document.getElementById('billing-phone').textContent = data.phone;
                    document.getElementById('billing-country').textContent = data.country;
                    document.getElementById('billing-address1').textContent = data.address1;
                    document.getElementById('billing-address2').textContent = data.address2 || 'N/A';
                    document.getElementById('billing-city').textContent = data.city;
                    document.getElementById('billing-state').textContent = data.state;
                    document.getElementById('billing-postcode').textContent = data.postcode;
                })
                .catch(error => {
                    console.error('Error fetching billing details:', error);
                    alert('Error loading billing details. Please try again.');
                });
        });
    });

    // Cart Items Modal
    const itemsModal = document.getElementById('itemsModal');
    const viewItemsLinks = document.querySelectorAll('.view-items');

    viewItemsLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const orderId = this.dataset.orderId;
            
            // Fetch cart items
            fetch(`/admin/orders/${orderId}/items`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('items-table-body');
                    tbody.innerHTML = '';
                    
                    data.forEach(item => {
                        // Calculate discounted subtotal
                        const discountedSubtotal = (item.discounted_price !== undefined)
                            ? (parseFloat(item.discounted_price) * parseInt(item.quantity))
                            : (parseFloat(item.price) * parseInt(item.quantity));
                        const discountedPrice = item.discounted_price !== undefined ? item.discounted_price : item.price;
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.ticket_name}</td>
                            <td>${item.quantity}</td>
                            <td>RM ${parseFloat(discountedPrice).toFixed(2)}</td>
                            <td>RM ${discountedSubtotal.toFixed(2)}</td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching cart items:', error);
                    alert('Error loading cart items. Please try again.');
                });
        });
    });

    // Add loading state to download buttons
    const downloadButtons = document.querySelectorAll('[href*="download-pdf"]');
    downloadButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Generating PDF...';
            this.disabled = true;
            
            // Reset button after 5 seconds if download hasn't started
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 5000);
        });
    });
});
</script>
@endpush 