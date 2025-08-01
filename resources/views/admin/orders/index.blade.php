@extends('admin.layouts.app')

@section('title', 'ADMIN | Orders')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Orders</h3>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.orders.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Create Order
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="downloadOrdersDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-file-excel me-1"></i> Download Orders
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="downloadOrdersDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.orders.download-excel', ['event' => 'all']) }}">
                                        <i class="bi bi-file-excel text-success me-2"></i>All Events
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.orders.download-excel', ['event' => 'bina']) }}">
                                        <i class="bi bi-file-excel text-success me-2"></i>BINA Events
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.orders.download-excel', ['event' => 'industry']) }}">
                                        <i class="bi bi-file-excel text-success me-2"></i>Sarawak Facility Management Engagement Day
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="downloadAttendanceDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-file-earmark-text me-1"></i> Download Attendance Form
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="downloadAttendanceDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.orders.attendance-form.compiled', ['event' => 'all']) }}">
                                        <i class="bi bi-file-earmark-text text-primary me-2"></i>All Events
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.orders.attendance-form.compiled', ['event' => 'facility']) }}">
                                        <i class="bi bi-file-earmark-text text-primary me-2"></i>Facility Management Engagement Day
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.orders.attendance-form.compiled', ['event' => 'modular']) }}">
                                        <i class="bi bi-file-earmark-text text-primary me-2"></i>Modular Asia Forum & Exhibition
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.orders.attendance-form.compiled', ['event' => 'industry']) }}">
                                        <i class="bi bi-file-earmark-text text-primary me-2"></i>Sarawak Facility Management Engagement Day
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="downloadLogsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-download me-1"></i> Download Transaction Log
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="downloadLogsDropdown">
                                <li>
                                    <a class="dropdown-item" href="#" id="downloadSuccessLog">
                                        <i class="bi bi-check-circle text-success me-2"></i>Successful Transactions
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" id="downloadFailedLog">
                                        <i class="bi bi-x-circle text-danger me-2"></i>Failed Transactions
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

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
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchIdentity" placeholder="Search by Identity Number">
                                    <button class="btn btn-primary" type="button" id="searchIdentityBtn">
                                        <i class="bi bi-search"></i>
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
                                <select class="form-select" id="ticketFilter">
                                    <option value="">All Tickets</option>
                                    @foreach($tickets as $ticket)
                                        <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="eventFilter">
                                    <option value="all">All Events</option>
                                    <option value="bina">BINA Events</option>
                                    <option value="industry">Sarawak Facility Management Engagement Day</option>
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
                                    <th>Participants</th>
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
                                <tr data-ticket-ids='@json($order->ticket_ids)'>
                                    <td>{{ $orders->firstItem() + $index }}</td>
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
                                    <td>
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-primary view-participants" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#participantsModal"
                                               data-order-id="{{ $order->id }}">
                                                View Participants
                                            </a>
                                            <hr class="my-1" style="border-color: #dee2e6;">
                                            <a href="#" class="text-primary update-participants" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#updateParticipantsModal"
                                               data-order-id="{{ $order->id }}">
                                                Update Participants
                                            </a>
                                        </div>
                                    </td>
                                    <td>{{ ucfirst($order->payment_method ?? 'N/A') }}</td>
                                    <td>{{ $order->payment_country ?? 'N/A' }}</td>
                                    <td>RM {{ number_format($order->processing_fee ?? 0, 2) }}</td>
                                    <td>{{ $order->payment_id ?? 'N/A' }}</td>
                                    <td>{{ $order->created_at->format('d M Y H:i:s') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status === 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('admin.orders.download-pdf', $order) }}" 
                                               class="text-primary text-decoration-underline">
                                                Download PDF
                                            </a>
                                            <hr class="my-1" style="border-color: #dee2e6;">
                                            <a href="{{ route('admin.orders.download-individual-excel', $order) }}" 
                                               class="text-primary text-decoration-underline">
                                                Download Excel
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                                </div>
                                <div>
                                    {{ $orders->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
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
                        <p><strong>Identity Number:</strong> <span id="billing-identity-number"></span></p>
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

<!-- Participants Modal -->
<div class="modal fade" id="participantsModal" tabindex="-1" aria-labelledby="participantsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="participantsModalLabel">Participant Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Company Name</th>
                                <th>Identity Number</th>
                                <th>Ticket Name</th>
                            </tr>
                        </thead>
                        <tbody id="participants-table-body">
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Participants Modal -->
<div class="modal fade" id="updateParticipantsModal" tabindex="-1" aria-labelledby="updateParticipantsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateParticipantsModalLabel">Update Participants</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateParticipantsForm">
                    <input type="hidden" id="updateOrderId" name="order_id">
                    <div id="updateParticipantsContainer">
                        <!-- Participant forms will be dynamically generated here -->
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Update Participants</button>
                    </div>
                </form>
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
    const searchIdentityInput = document.getElementById('searchIdentity');
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const paymentMethodSelect = document.getElementById('paymentMethod');
    const paymentCountrySelect = document.getElementById('paymentCountry');
    const ticketFilterSelect = document.getElementById('ticketFilter');
    const eventFilterSelect = document.getElementById('eventFilter');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const tableRows = document.querySelectorAll('tbody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const identityTerm = searchIdentityInput.value.toLowerCase().trim();
        const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
        const endDate = endDateInput.value ? new Date(endDateInput.value) : null;
        const selectedPaymentMethod = paymentMethodSelect.value.toLowerCase();
        const selectedPaymentCountry = paymentCountrySelect.value;
        const selectedTicket = ticketFilterSelect.value;
        const selectedEvent = eventFilterSelect.value;

        // Debug logging
        console.log('Filtering with:', {
            searchTerm,
            identityTerm,
            startDate,
            endDate,
            selectedPaymentMethod,
            selectedPaymentCountry,
            selectedTicket,
            selectedEvent
        });

        tableRows.forEach(row => {
            try {
                const referenceCell = row.querySelector('td:nth-child(2)');
                const dateCell = row.querySelector('td:nth-child(10)');
                const paymentMethodCell = row.querySelector('td:nth-child(6)');
                const paymentCountryCell = row.querySelector('td:nth-child(7)');
                const billingLink = row.querySelector('.view-billing');
                const billingId = billingLink ? billingLink.dataset.billingId : null;
                const itemsLink = row.querySelector('.view-items');
                const orderId = itemsLink ? itemsLink.dataset.orderId : null;

                const referenceNumber = referenceCell.textContent.toLowerCase();
                const orderDate = new Date(dateCell.textContent);
                const paymentMethod = paymentMethodCell.textContent.toLowerCase();
                const paymentCountry = paymentCountryCell.textContent.trim();

                // Debug logging for ticket filtering
                const ticketIds = row.dataset.ticketIds;
                console.log('Row ticket data:', {
                    rowId: referenceNumber,
                    ticketIds,
                    selectedTicket,
                    parsedIds: ticketIds ? JSON.parse(ticketIds) : null
                });

                // Check if ticket IDs are valid JSON
                let parsedTicketIds = [];
                try {
                    parsedTicketIds = ticketIds ? JSON.parse(ticketIds).map(id => parseInt(id)) : [];
                } catch (e) {
                    console.error('Error parsing ticket IDs:', e, ticketIds);
                }

                const matchesTicket = !selectedTicket || parsedTicketIds.includes(parseInt(selectedTicket));

                // Debug logging for visibility
                console.log('Visibility check:', {
                    rowId: referenceNumber,
                    matchesTicket,
                    selectedTicket,
                    parsedTicketIds
                });

                // Check identity number only if there's a search term
                let matchesIdentity = !identityTerm; // true if no identity search term
                if (identityTerm && billingId) {
                    // Fetch billing details and check identity number
                    fetch(`/admin/billing-details/${billingId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            const billingIdentityNumber = (data.identity_number || '').toLowerCase();
                            let billingMatches = billingIdentityNumber.includes(identityTerm);
                            
                            // Also check participant identity numbers
                            if (orderId) {
                                fetch(`/admin/orders/${orderId}/participants`)
                                    .then(participantResponse => {
                                        if (!participantResponse.ok) {
                                            throw new Error(`HTTP error! status: ${participantResponse.status}`);
                                        }
                                        return participantResponse.json();
                                    })
                                    .then(participants => {
                                        let participantMatches = false;
                                        participants.forEach(participant => {
                                            const participantIdentityNumber = (participant.identity_number || '').toLowerCase();
                                            if (participantIdentityNumber.includes(identityTerm)) {
                                                participantMatches = true;
                                            }
                                        });
                                        
                                        // Show row if either billing or participant identity matches
                                        matchesIdentity = billingMatches || participantMatches;
                                        updateRowVisibility();
                                    })
                                    .catch(participantError => {
                                        console.error('Error fetching participants:', participantError);
                                        // Fall back to billing identity only
                                        matchesIdentity = billingMatches;
                                        updateRowVisibility();
                                    });
                            } else {
                                // No order ID, use billing identity only
                                matchesIdentity = billingMatches;
                                updateRowVisibility();
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching billing details:', error);
                            matchesIdentity = false;
                            updateRowVisibility();
                        });
                }

                const matchesSearch = referenceNumber.includes(searchTerm);
                const matchesDateRange = (!startDate || orderDate >= startDate) && 
                                       (!endDate || orderDate <= endDate);
                const matchesPaymentMethod = !selectedPaymentMethod || paymentMethod.includes(selectedPaymentMethod);
                const matchesPaymentCountry = !selectedPaymentCountry || paymentCountry === selectedPaymentCountry;

                // Check event match
                let matchesEvent = true;
                if (selectedEvent !== 'all' && orderId) {
                    matchesEvent = false;
                    fetch(`/admin/orders/${orderId}/items`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(items => {
                            items.forEach(item => {
                                const ticketName = item.ticket_name.toLowerCase();
                                switch (selectedEvent) {
                                    case 'bina':
                                        if ((ticketName.includes('facility management') && !ticketName.includes('industry')) ||
                                            ticketName.includes('modular asia') ||
                                            ticketName.includes('combo')) {
                                            matchesEvent = true;
                                        }
                                        break;
                                    case 'industry':
                                        if (ticketName.includes('industry')) {
                                            matchesEvent = true;
                                        }
                                        break;
                                }
                            });
                            updateRowVisibility();
                        })
                        .catch(error => {
                            console.error('Error fetching order items:', error);
                            updateRowVisibility();
                        });
                }

                function updateRowVisibility() {
                    const shouldShow = matchesSearch && matchesIdentity && 
                                     matchesDateRange && matchesPaymentMethod && 
                                     matchesPaymentCountry && matchesTicket && matchesEvent;
                    
                    // Debug logging for row visibility
                    console.log('Row visibility:', {
                        rowId: referenceNumber,
                        shouldShow,
                        matchesSearch,
                        matchesIdentity,
                        matchesDateRange,
                        matchesPaymentMethod,
                        matchesPaymentCountry,
                        matchesTicket,
                        matchesEvent
                    });
                    
                    row.style.display = shouldShow ? '' : 'none';
                }

                // Only update display immediately if not searching by identity or event
                if (!identityTerm && selectedEvent === 'all') {
                    updateRowVisibility();
                }
            } catch (error) {
                console.error('Error processing row:', error, row);
            }
        });
    }

    // Add event listeners
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        filterTable();
    });

    startDateInput.addEventListener('change', filterTable);
    endDateInput.addEventListener('change', filterTable);
    paymentMethodSelect.addEventListener('change', filterTable);
    paymentCountrySelect.addEventListener('change', filterTable);
    ticketFilterSelect.addEventListener('change', filterTable);
    eventFilterSelect.addEventListener('change', filterTable);

    // Clear filters button
    clearFiltersBtn.addEventListener('click', function() {
        searchInput.value = '';
        searchIdentityInput.value = '';
        startDateInput.value = '';
        endDateInput.value = '';
        paymentMethodSelect.value = '';
        paymentCountrySelect.value = '';
        ticketFilterSelect.value = '';
        eventFilterSelect.value = 'all';
        filterTable();
    });

    // Clear search when input is cleared
    searchInput.addEventListener('input', function() {
        if (this.value === '') {
            filterTable();
        }
    });

    // Add event listener for identity number search button
    document.getElementById('searchIdentityBtn').addEventListener('click', filterTable);
    
    // Add event listener for identity number input (search as you type)
    document.getElementById('searchIdentity').addEventListener('input', function() {
        if (this.value === '') {
            filterTable(); // Clear identity number filter if input is empty
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
                    document.getElementById('billing-identity-number').textContent = data.identity_number || 'N/A';
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
    const downloadButtons = document.querySelectorAll('[href*="download-pdf"], [href*="download-excel"]');
    downloadButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const originalText = this.innerHTML;
            const isExcel = this.href.includes('download-excel');
            this.innerHTML = `<i class="bi bi-hourglass-split me-1"></i> Generating ${isExcel ? 'Excel' : 'PDF'}...`;
            this.disabled = true;
            
            // Reset button after 5 seconds if download hasn't started
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 5000);
        });
    });

    // Function to download log file content
    function downloadLog(content, filename) {
        const blob = new Blob([content], { type: 'text/plain' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    }

    // Handle successful transactions log download
    document.getElementById('downloadSuccessLog').addEventListener('click', function(e) {
        e.preventDefault();
        fetch('/admin/orders/download-success-log')
            .then(response => response.text())
            .then(content => {
                downloadLog(content, `successful_transactions_${new Date().toISOString().split('T')[0]}.log`);
            })
            .catch(error => {
                console.error('Error downloading success log:', error);
                alert('Error downloading success log. Please try again.');
            });
    });

    // Handle failed transactions log download
    document.getElementById('downloadFailedLog').addEventListener('click', function(e) {
        e.preventDefault();
        fetch('/admin/orders/download-failed-log')
            .then(response => response.text())
            .then(content => {
                downloadLog(content, `failed_transactions_${new Date().toISOString().split('T')[0]}.log`);
            })
            .catch(error => {
                console.error('Error downloading failed log:', error);
                alert('Error downloading failed log. Please try again.');
            });
    });

    // Handle participants modal
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('view-participants')) {
            e.preventDefault();
            const orderId = e.target.dataset.orderId;
            
            // Show loading state
            const tbody = document.getElementById('participants-table-body');
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </td>
                </tr>
            `;
            
            // Fetch participants
            fetch(`/admin/orders/${orderId}/participants`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('participants-table-body');
                    tbody.innerHTML = '';
                    
                    if (data.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    No participant details found for this order.
                                </td>
                            </tr>
                        `;
                        return;
                    }
                    
                    data.forEach((participant, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${participant.full_name || '-'}</td>
                            <td>${participant.phone || '-'}</td>
                            <td>${participant.email || '-'}</td>
                            <td>${participant.gender || '-'}</td>
                            <td>${participant.company_name || '-'}</td>
                            <td>${participant.identity_number || '-'}</td>
                            <td>${participant.ticket_name || '-'}</td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching participants:', error);
                    const tbody = document.getElementById('participants-table-body');
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="8" class="text-center text-danger">
                                Error loading participant details. Please try again.
                            </td>
                        </tr>
                    `;
                });
        }
    });

    // Handle update participants modal
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('update-participants')) {
            e.preventDefault();
            const orderId = e.target.dataset.orderId;
            document.getElementById('updateOrderId').value = orderId;
            
            // Show loading state
            const container = document.getElementById('updateParticipantsContainer');
            container.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading order details...</p>
                </div>
            `;
            
            // Fetch order details and participants
            Promise.all([
                fetch(`/admin/orders/${orderId}/items`).then(response => response.json()),
                fetch(`/admin/orders/${orderId}/participants`).then(response => response.json())
            ])
            .then(([items, participants]) => {
                generateUpdateParticipantForms(items, participants);
            })
            .catch(error => {
                console.error('Error fetching order details:', error);
                container.innerHTML = `
                    <div class="text-center text-danger">
                        <p>Error loading order details. Please try again.</p>
                    </div>
                `;
            });
        }
    });

    // Generate participant forms for update
    function generateUpdateParticipantForms(items, participants) {
        const container = document.getElementById('updateParticipantsContainer');
        container.innerHTML = '';
        
        let ticketNumber = 1;
        
        items.forEach(item => {
            for (let i = 0; i < item.quantity; i++) {
                // Find participant by ticket_id and ticket_number
                const participant = participants.find(p => p.ticket_id == item.ticket_id && p.ticket_number == ticketNumber);
                
                // Debug logging
                console.log('Generating form for ticket:', {
                    ticketNumber,
                    ticketId: item.ticket_id,
                    ticketName: item.ticket_name,
                    participant: participant
                });
                
                const formDiv = document.createElement('div');
                formDiv.className = 'participant-form mb-4 p-3 border rounded';
                formDiv.innerHTML = `
                    <h6 class="mb-3">Participant ${ticketNumber} - ${item.ticket_name}</h6>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="participant_full_name_${ticketNumber}">Full Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="participant_full_name_${ticketNumber}" name="participants[${ticketNumber}][full_name]" value="${participant && participant.full_name ? participant.full_name : '-'}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="participant_phone_${ticketNumber}">Phone <span class="required">*</span></label>
                            <input type="text" class="form-control" id="participant_phone_${ticketNumber}" name="participants[${ticketNumber}][phone]" value="${participant && participant.phone ? participant.phone : '-'}" placeholder="e.g. 0123456789" required pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="participant_email_${ticketNumber}">Email Address <span class="required">*</span> <i class="fas fa-info-circle" style="color: #ff9800;" data-bs-toggle="tooltip" data-bs-placement="top" title="Please provide your active email address. This will be used to send your purchase confirmation and can be used to retrieve your purchase information if you register an account later."></i></label>
                            <input type="email" class="form-control" id="participant_email_${ticketNumber}" name="participants[${ticketNumber}][email]" value="${participant && participant.email ? participant.email : '-'}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="participant_gender_${ticketNumber}">Gender <span class="required">*</span></label>
                            <select class="form-control" id="participant_gender_${ticketNumber}" name="participants[${ticketNumber}][gender]" required>
                                <option value="">Select Gender</option>
                                <option value="male" ${participant && participant.gender === 'male' ? 'selected' : ''}>Male</option>
                                <option value="female" ${participant && participant.gender === 'female' ? 'selected' : ''}>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="participant_company_${ticketNumber}">Company Name</label>
                            <input type="text" class="form-control" id="participant_company_${ticketNumber}" name="participants[${ticketNumber}][company_name]" value="${participant && participant.company_name ? participant.company_name : '-'}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="participant_identity_${ticketNumber}">Identity Card Number / Passport <span class="required">*</span> <i class="fas fa-info-circle" style="color: #ff9800;" data-bs-toggle="tooltip" data-bs-placement="top" title="For Malaysian citizens, please enter your IC number. For international customers, please enter your passport number."></i></label>
                            <input type="text" class="form-control" id="participant_identity_${ticketNumber}" name="participants[${ticketNumber}][identity_number]" value="${participant && participant.identity_number ? participant.identity_number : '-'}" placeholder="e.g. 901234567890 or A12345678" required>
                        </div>
                    </div>
                    <input type="hidden" name="participants[${ticketNumber}][ticket_id]" value="${item.ticket_id}">
                    <input type="hidden" name="participants[${ticketNumber}][ticket_number]" value="${ticketNumber}">
                    ${participant && participant.id ? `<input type="hidden" name="participants[${ticketNumber}][id]" value="${participant.id}">` : ''}
                `;
                container.appendChild(formDiv);
                ticketNumber++;
            }
        });
    }



    // Function to show Bootstrap alert messages
    function showAlert(message, type = 'success') {
        // Remove any existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Insert alert at the top of the main content area
        const mainContent = document.querySelector('.container-fluid');
        if (mainContent) {
            mainContent.insertBefore(alertDiv, mainContent.firstChild);
        }
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                const bsAlert = new bootstrap.Alert(alertDiv);
                bsAlert.close();
            }
        }, 5000);
    }

    // Handle update participants form submission
    document.getElementById('updateParticipantsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const orderId = document.getElementById('updateOrderId').value;
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Updating...';
        submitBtn.disabled = true;
        
        // Convert FormData to object and clean up "-" values
        const formDataObj = Object.fromEntries(formData);
        
        // Clean up participants data - replace "-" with empty strings
        if (formDataObj.participants) {
            Object.keys(formDataObj.participants).forEach(key => {
                const participant = formDataObj.participants[key];
                Object.keys(participant).forEach(field => {
                    if (participant[field] === '-') {
                        participant[field] = '';
                    }
                });
            });
        }
        
        fetch(`/admin/orders/${orderId}/update-participants`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formDataObj)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal first
                const modal = bootstrap.Modal.getInstance(document.getElementById('updateParticipantsModal'));
                modal.hide();
                
                // Redirect to orders page with session success message
                window.location.href = '{{ route("admin.orders.index") }}?success=participants_updated';
                // Clean up URL after redirect
                setTimeout(() => {
                    const newUrl = window.location.pathname;
                    window.history.replaceState({}, document.title, newUrl);
                }, 100);
            } else {
                showAlert('Error updating participants: ' + (data.message || 'Unknown error'), 'danger');
            }
        })
        .catch(error => {
            console.error('Error updating participants:', error);
            showAlert('Error updating participants. Please try again.', 'danger');
        })
        .finally(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    });
});
</script>
@endpush 