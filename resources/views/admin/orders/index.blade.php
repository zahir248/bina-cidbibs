@extends('admin.layouts.app')

@section('title', 'ADMIN | Orders')

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
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchReference" placeholder="Search by Reference Number">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="paymentMethod">
                                    <option value="">All Payment Methods</option>
                                    <option value="stripe">Stripe</option>
                                    <option value="toyyibpay">ToyyibPay</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="paymentCountry">
                                    <option value="">All Countries</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="Brunei">Brunei</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="China">China</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Hong Kong">Hong Kong</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Iran">Iran</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russia">Russia</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Korea">South Korea</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Taiwan">Taiwan</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                    <option value="Vietnam">Vietnam</option>
                                    <option value="Yemen">Yemen</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="date" class="form-control" id="startDate" placeholder="Start Date">
                                    <span class="input-group-text">to</span>
                                    <input type="date" class="form-control" id="endDate" placeholder="End Date">
                                    <button class="btn btn-secondary" type="button" id="clearFilters">
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
                                    <th>Payment Method</th>
                                    <th>Payment Country</th>
                                    <th>Processing Fee</th>
                                    <th>Payment ID</th>
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
                                           data-order-id="{{ $order->id }}"
                                           data-processing-fee="{{ $order->processing_fee ?? 0 }}"
                                           data-total-amount="{{ $order->total_amount }}">
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
                                    <td>{{ ucfirst($order->payment_method ?? 'N/A') }}</td>
                                    <td>{{ $order->payment_country ?? 'N/A' }}</td>
                                    <td>RM {{ number_format($order->processing_fee ?? 0, 2) }}</td>
                                    <td>{{ $order->payment_id ?? 'N/A' }}</td>
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
                        <p><strong>Gender:</strong> <span id="billing-gender"></span></p>
                        <p><strong>Category:</strong> <span id="billing-category"></span></p>
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
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                <td id="items-subtotal"></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Processing Fee:</strong></td>
                                <td id="items-processing-fee"></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                                <td id="items-total"></td>
                            </tr>
                        </tfoot>
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
    const paymentMethodSelect = document.getElementById('paymentMethod');
    const paymentCountrySelect = document.getElementById('paymentCountry');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const tableRows = document.querySelectorAll('tbody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
        const endDate = endDateInput.value ? new Date(endDateInput.value) : null;
        const selectedPaymentMethod = paymentMethodSelect.value.toLowerCase();
        const selectedPaymentCountry = paymentCountrySelect.value;

        // Set end date to end of day if it exists
        if (endDate) {
            endDate.setHours(23, 59, 59, 999);
        }

        tableRows.forEach(row => {
            const referenceCell = row.querySelector('td:nth-child(2)');
            const dateCell = row.querySelector('td:nth-child(10)');
            const paymentMethodCell = row.querySelector('td:nth-child(6)');
            const paymentCountryCell = row.querySelector('td:nth-child(7)');

            const referenceNumber = referenceCell.textContent.toLowerCase();
            const orderDate = new Date(dateCell.textContent);
            const paymentMethod = paymentMethodCell.textContent.toLowerCase();
            const paymentCountry = paymentCountryCell.textContent.trim();

            const matchesSearch = referenceNumber.includes(searchTerm);
            const matchesDateRange = (!startDate || orderDate >= startDate) && 
                                   (!endDate || orderDate <= endDate);
            const matchesPaymentMethod = !selectedPaymentMethod || paymentMethod.includes(selectedPaymentMethod);
            const matchesPaymentCountry = !selectedPaymentCountry || paymentCountry === selectedPaymentCountry;

            row.style.display = (matchesSearch && matchesDateRange && 
                               matchesPaymentMethod && matchesPaymentCountry) ? '' : 'none';
        });
    }

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        filterTable();
    });

    // Filter when any filter changes
    startDateInput.addEventListener('change', filterTable);
    endDateInput.addEventListener('change', filterTable);
    paymentMethodSelect.addEventListener('change', filterTable);
    paymentCountrySelect.addEventListener('change', filterTable);

    // Clear filters button
    clearFiltersBtn.addEventListener('click', function() {
        searchInput.value = '';
        startDateInput.value = '';
        endDateInput.value = '';
        paymentMethodSelect.value = '';
        paymentCountrySelect.value = '';
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
            // fetch({{ url('admin/billing-details') }}/${billingId})
                .then(response => response.json())
                .then(data => {
                    document.getElementById('billing-name').textContent = `${data.first_name} ${data.last_name}`;
                    document.getElementById('billing-gender').textContent = data.gender;
                    document.getElementById('billing-category').textContent = data.category;
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
            const processingFee = parseFloat(this.dataset.processingFee);
            const totalAmount = parseFloat(this.dataset.totalAmount);
            
            // Fetch cart items
            fetch(`/admin/orders/${orderId}/items`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('items-table-body');
                    tbody.innerHTML = '';
                    
                    let subtotal = 0;
                    
                    data.forEach(item => {
                        // Calculate discounted subtotal
                        const discountedSubtotal = (item.discounted_price !== undefined)
                            ? (parseFloat(item.discounted_price) * parseInt(item.quantity))
                            : (parseFloat(item.price) * parseInt(item.quantity));
                        const discountedPrice = item.discounted_price !== undefined ? item.discounted_price : item.price;
                        
                        subtotal += discountedSubtotal;
                        
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.ticket_name}</td>
                            <td>${item.quantity}</td>
                            <td>RM ${parseFloat(discountedPrice).toFixed(2)}</td>
                            <td>RM ${discountedSubtotal.toFixed(2)}</td>
                        `;
                        tbody.appendChild(row);
                    });

                    // Update summary
                    document.getElementById('items-subtotal').textContent = `RM ${subtotal.toFixed(2)}`;
                    document.getElementById('items-processing-fee').textContent = `RM ${processingFee.toFixed(2)}`;
                    document.getElementById('items-total').textContent = `RM ${totalAmount.toFixed(2)}`;
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