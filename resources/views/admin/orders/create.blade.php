@extends('admin.layouts.app')

@section('title', 'ADMIN | Create Order')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Create New Order</h3>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Orders
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.orders.store') }}" method="POST" id="createOrderForm">
                        @csrf
                        
                        <!-- User Selection -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">Customer Information</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Select User (Optional)</label>
                                    <select class="form-select" id="user_id" name="user_id">
                                        <option value="">Create new customer (no existing account)</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Optional: Select an existing user to link this order to their account</small>
                                </div>
                            </div>
                        </div>

                        <!-- Billing Details -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">Billing Details</h5>
                            </div>
                            
                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name *</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone *</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender *</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category *</label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="individual" {{ old('category') == 'individual' ? 'selected' : '' }}>Individual</option>
                                        <option value="organization" {{ old('category') == 'organization' ? 'selected' : '' }}>Organization</option>
                                        <option value="academician" {{ old('category') == 'academician' ? 'selected' : '' }}>Academician</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="identity_number" class="form-label">Identity Number</label>
                                    <input type="text" class="form-control" id="identity_number" name="identity_number" value="{{ old('identity_number') }}">
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country *</label>
                                    <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="address1" class="form-label">Address Line 1 *</label>
                                    <input type="text" class="form-control" id="address1" name="address1" value="{{ old('address1') }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="address2" class="form-label">Address Line 2</label>
                                    <input type="text" class="form-control" id="address2" name="address2" value="{{ old('address2') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City *</label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="state" class="form-label">State *</label>
                                    <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="postcode" class="form-label">Postcode *</label>
                                    <input type="text" class="form-control" id="postcode" name="postcode" value="{{ old('postcode') }}" required>
                                </div>
                            </div>

                            <!-- B2B Fields -->
                            <div class="col-md-6 b2b-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}">
                                </div>
                            </div>
                            <div class="col-md-6 b2b-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="business_registration_number" class="form-label">Business Registration Number</label>
                                    <input type="text" class="form-control" id="business_registration_number" name="business_registration_number" value="{{ old('business_registration_number') }}">
                                </div>
                            </div>
                            <div class="col-md-6 b2b-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="tax_number" class="form-label">Tax Number</label>
                                    <input type="text" class="form-control" id="tax_number" name="tax_number" value="{{ old('tax_number') }}">
                                </div>
                            </div>

                            <!-- Academician Fields -->
                            <div class="col-md-6 academician-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="student_id" class="form-label">Student ID</label>
                                    <input type="text" class="form-control" id="student_id" name="student_id" value="{{ old('student_id') }}">
                                </div>
                            </div>
                            <div class="col-md-6 academician-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="academic_institution" class="form-label">Academic Institution</label>
                                    <input type="text" class="form-control" id="academic_institution" name="academic_institution" value="{{ old('academic_institution') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Ticket Selection -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">Ticket Selection</h5>
                                <div id="tickets-container">
                                    <div class="ticket-row row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Ticket *</label>
                                            <select class="form-select ticket-select" name="tickets[0][ticket_id]" required>
                                                <option value="">Select Ticket</option>
                                                @foreach($tickets as $ticket)
                                                    <option value="{{ $ticket->id }}" data-price="{{ $ticket->price }}" data-stock="{{ $ticket->stock }}">
                                                        {{ $ticket->name }} - RM {{ number_format($ticket->price, 2) }} (Stock: {{ $ticket->stock }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Quantity *</label>
                                            <input type="number" class="form-control ticket-quantity" name="tickets[0][quantity]" min="1" value="1" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm remove-ticket" style="display: none;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-ticket">
                                    <i class="bi bi-plus"></i> Add Another Ticket
                                </button>
                            </div>
                        </div>

                        <!-- Participant Details -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">Participant Details</h5>
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Note:</strong> Participant details are optional. If not provided, the billing details will be used for the first ticket, and subsequent tickets will be left empty.
                                </div>
                                <div id="participants-container">
                                    <!-- Participant forms will be dynamically generated here -->
                                </div>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="add-participant" style="display: none;">
                                    <i class="bi bi-plus"></i> Add Participant Details
                                </button>
                            </div>
                        </div>

                        <!-- Order Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">Order Information</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reference_number" class="form-label">Reference Number *</label>
                                    <input type="text" class="form-control" id="reference_number" name="reference_number" value="{{ old('reference_number') }}" required>
                                    <small class="form-text text-muted">Enter a unique reference number for this order (e.g., CASH-001, BANK-20250115-001, ORD-20250115-001)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order_date" class="form-label">Order Date *</label>
                                    <input type="date" class="form-control" id="order_date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required>
                                    <small class="form-text text-muted">Select the date when the order was actually created</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order_time" class="form-label">Order Time *</label>
                                    <input type="time" class="form-control" id="order_time" name="order_time" value="{{ old('order_time', date('H:i')) }}" required>
                                    <small class="form-text text-muted">Select the time when the order was actually created</small>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">Payment Information</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method *</label>
                                    <select class="form-select" id="payment_method" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="stripe" {{ old('payment_method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                                        <option value="toyyibpay" {{ old('payment_method') == 'toyyibpay' ? 'selected' : '' }}>ToyyibPay</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_country" class="form-label">Payment Country</label>
                                    <input type="text" class="form-control" id="payment_country" name="payment_country" value="{{ old('payment_country') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="processing_fee" class="form-label">Processing Fee (RM)</label>
                                    <input type="number" class="form-control" id="processing_fee" name="processing_fee" value="{{ old('processing_fee', 0) }}" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">Order Summary</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Subtotal:</strong> <span id="subtotal">RM 0.00</span></p>
                                                <p><strong>Processing Fee:</strong> <span id="processing-fee-display">RM 0.00</span></p>
                                                <p><strong>Total Amount:</strong> <span id="total-amount" class="h5 text-primary">RM 0.00</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Reference Number:</strong> <span id="reference-preview" class="text-primary">Enter above</span></p>
                                                <p><strong>Order Date:</strong> <span id="order-date-preview" class="text-primary">{{ date('d M Y') }}</span></p>
                                                <p><strong>Order Time:</strong> <span id="order-time-preview" class="text-primary">{{ date('H:i') }}</span></p>
                                                <p><strong>Status:</strong> <span class="badge bg-success">Paid</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i> Create Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let ticketIndex = 0;

    // Category change handler
    document.getElementById('category').addEventListener('change', function() {
        const category = this.value;
        const b2bFields = document.querySelectorAll('.b2b-fields');
        const academicianFields = document.querySelectorAll('.academician-fields');

        // Hide all category-specific fields
        b2bFields.forEach(field => field.style.display = 'none');
        academicianFields.forEach(field => field.style.display = 'none');

        // Show relevant fields based on category
        if (category === 'organization') {
            b2bFields.forEach(field => field.style.display = 'block');
        } else if (category === 'academician') {
            academicianFields.forEach(field => field.style.display = 'block');
        }
    });

    // Add ticket row
    document.getElementById('add-ticket').addEventListener('click', function() {
        ticketIndex++;
        const container = document.getElementById('tickets-container');
        const newRow = document.createElement('div');
        newRow.className = 'ticket-row row mb-3';
        newRow.innerHTML = `
            <div class="col-md-6">
                <label class="form-label">Ticket *</label>
                <select class="form-select ticket-select" name="tickets[${ticketIndex}][ticket_id]" required>
                    <option value="">Select Ticket</option>
                    @foreach($tickets as $ticket)
                        <option value="{{ $ticket->id }}" data-price="{{ $ticket->price }}" data-stock="{{ $ticket->stock }}">
                            {{ $ticket->name }} - RM {{ number_format($ticket->price, 2) }} (Stock: {{ $ticket->stock }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Quantity *</label>
                <input type="number" class="form-control ticket-quantity" name="tickets[${ticketIndex}][quantity]" min="1" value="1" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-danger btn-sm remove-ticket">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newRow);
        updateRemoveButtons();
        attachTicketEventListeners(newRow);
    });

    // Remove ticket row
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-ticket')) {
            e.target.closest('.ticket-row').remove();
            updateRemoveButtons();
            calculateTotal();
        }
    });

    // Update remove buttons visibility
    function updateRemoveButtons() {
        const ticketRows = document.querySelectorAll('.ticket-row');
        const removeButtons = document.querySelectorAll('.remove-ticket');
        
        removeButtons.forEach((button, index) => {
            button.style.display = ticketRows.length > 1 ? 'block' : 'none';
        });
    }

    // Attach event listeners to ticket row
    function attachTicketEventListeners(row) {
        const ticketSelect = row.querySelector('.ticket-select');
        const quantityInput = row.querySelector('.ticket-quantity');

        ticketSelect.addEventListener('change', function() {
            calculateTotal();
            updateParticipantForms();
        });
        quantityInput.addEventListener('input', function() {
            calculateTotal();
            updateParticipantForms();
        });
    }

    // Calculate total amount
    function calculateTotal() {
        let subtotal = 0;
        const ticketRows = document.querySelectorAll('.ticket-row');

        ticketRows.forEach(row => {
            const ticketSelect = row.querySelector('.ticket-select');
            const quantityInput = row.querySelector('.ticket-quantity');
            
            if (ticketSelect.value && quantityInput.value) {
                const selectedOption = ticketSelect.options[ticketSelect.selectedIndex];
                const price = parseFloat(selectedOption.dataset.price);
                const quantity = parseInt(quantityInput.value);
                
                // Apply discount logic (same as in backend)
                let discountedPrice = price;
                if (quantity >= 5) {
                    discountedPrice = price * 0.8; // 20% discount
                } else if (quantity >= 3) {
                    discountedPrice = price * 0.9; // 10% discount
                }
                
                subtotal += discountedPrice * quantity;
            }
        });

        const processingFee = parseFloat(document.getElementById('processing_fee').value) || 0;
        const total = subtotal + processingFee;

        document.getElementById('subtotal').textContent = `RM ${subtotal.toFixed(2)}`;
        document.getElementById('processing-fee-display').textContent = `RM ${processingFee.toFixed(2)}`;
        document.getElementById('total-amount').textContent = `RM ${total.toFixed(2)}`;
    }

    // Attach event listeners to initial ticket row
    attachTicketEventListeners(document.querySelector('.ticket-row'));

    // Processing fee change handler
    document.getElementById('processing_fee').addEventListener('input', calculateTotal);

    // Reference number handler
    document.getElementById('reference_number').addEventListener('input', function() {
        const referenceNumber = this.value.trim();
        const previewElement = document.getElementById('reference-preview');
        
        if (referenceNumber) {
            previewElement.textContent = referenceNumber;
            previewElement.className = 'text-primary';
        } else {
            previewElement.textContent = 'Enter above';
            previewElement.className = 'text-primary';
        }
    });

    // Order date handler
    document.getElementById('order_date').addEventListener('change', function() {
        const orderDate = this.value;
        const previewElement = document.getElementById('order-date-preview');
        
        if (orderDate) {
            const date = new Date(orderDate);
            const formattedDate = date.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
            previewElement.textContent = formattedDate;
        } else {
            previewElement.textContent = 'Select date';
        }
    });

    // Order time handler
    document.getElementById('order_time').addEventListener('change', function() {
        const orderTime = this.value;
        const previewElement = document.getElementById('order-time-preview');
        
        if (orderTime) {
            previewElement.textContent = orderTime;
        } else {
            previewElement.textContent = 'Select time';
        }
    });

    // User selection handler
    document.getElementById('user_id').addEventListener('change', function() {
        const userId = this.value;
        if (userId) {
            // Here you could fetch user data and pre-fill the form
            // For now, we'll just show a message
            console.log('User selected:', userId);
        }
    });

    // Form validation
    document.getElementById('createOrderForm').addEventListener('submit', function(e) {
        const ticketRows = document.querySelectorAll('.ticket-row');
        let hasValidTicket = false;

        ticketRows.forEach(row => {
            const ticketSelect = row.querySelector('.ticket-select');
            const quantityInput = row.querySelector('.ticket-quantity');
            
            if (ticketSelect.value && quantityInput.value) {
                hasValidTicket = true;
                
                // Check stock availability
                const selectedOption = ticketSelect.options[ticketSelect.selectedIndex];
                const stock = parseInt(selectedOption.dataset.stock);
                const quantity = parseInt(quantityInput.value);
                
                if (quantity > stock) {
                    e.preventDefault();
                    alert(`Insufficient stock for ${selectedOption.text}. Available: ${stock}, Requested: ${quantity}`);
                    return false;
                }
            }
        });

        if (!hasValidTicket) {
            e.preventDefault();
            alert('Please select at least one ticket.');
            return false;
        }

        // Validate participant forms if any are filled
        const participantForms = document.querySelectorAll('.participant-form');
        let hasFilledParticipant = false;
        let hasEmptyParticipant = false;

        participantForms.forEach(form => {
            const fullName = form.querySelector('input[name*="[full_name]"]').value.trim();
            const phone = form.querySelector('input[name*="[phone]"]').value.trim();
            const email = form.querySelector('input[name*="[email]"]').value.trim();
            const gender = form.querySelector('select[name*="[gender]"]').value.trim();
            const identityNumber = form.querySelector('input[name*="[identity_number]"]').value.trim();

            if (fullName || phone || email || gender || identityNumber) {
                hasFilledParticipant = true;
                
                if (!fullName || !phone || !email || !gender || !identityNumber) {
                    hasEmptyParticipant = true;
                }
            }
        });

        if (hasFilledParticipant && hasEmptyParticipant) {
            e.preventDefault();
            alert('Please fill in all required fields for participant details or leave them completely empty.');
            return false;
        }
    });

    // Participant management
    let participantIndex = 0;

    // Function to generate participant forms based on ticket selection
    function generateParticipantForms() {
        const participantsContainer = document.getElementById('participants-container');
        const addParticipantBtn = document.getElementById('add-participant');
        participantsContainer.innerHTML = '';
        participantIndex = 0;

        const ticketRows = document.querySelectorAll('.ticket-row');
        let totalTickets = 0;

        ticketRows.forEach(row => {
            const ticketSelect = row.querySelector('.ticket-select');
            const quantityInput = row.querySelector('.ticket-quantity');
            
            if (ticketSelect.value && quantityInput.value) {
                const ticketId = ticketSelect.value;
                const quantity = parseInt(quantityInput.value);
                const ticketName = ticketSelect.options[ticketSelect.selectedIndex].text.split(' - ')[0];
                
                totalTickets += quantity;
                
                // Generate participant forms for this ticket
                for (let i = 1; i <= quantity; i++) {
                    const participantForm = createParticipantForm(ticketId, ticketName, participantIndex + 1);
                    participantsContainer.appendChild(participantForm);
                    participantIndex++;
                }
            }
        });

        // Show/hide add participant button
        if (totalTickets > 0) {
            addParticipantBtn.style.display = 'inline-block';
        } else {
            addParticipantBtn.style.display = 'none';
        }
    }

    // Function to create a participant form
    function createParticipantForm(ticketId, ticketName, ticketNumber) {
        const formDiv = document.createElement('div');
        formDiv.className = 'participant-form mb-4 p-3 border rounded';
        formDiv.innerHTML = `
            <h6 class="mb-3">Participant ${participantIndex + 1} - ${ticketName}</h6>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="participants[${participantIndex}][full_name]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="participants[${participantIndex}][phone]" placeholder="e.g. 0123456789" required pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Email Address <span class="text-danger">*</span> <i class="fas fa-info-circle" style="color: #ff9800;" data-bs-toggle="tooltip" data-bs-placement="top" title="Please provide your active email address. This will be used to send your purchase confirmation and can be used to retrieve your purchase information if you register an account later."></i></label>
                    <input type="email" class="form-control" name="participants[${participantIndex}][email]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                    <select class="form-select" name="participants[${participantIndex}][gender]" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Company Name</label>
                    <input type="text" class="form-control" name="participants[${participantIndex}][company_name]">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Identity Card Number / Passport <span class="text-danger">*</span> <i class="fas fa-info-circle" style="color: #ff9800;" data-bs-toggle="tooltip" data-bs-placement="top" title="For Malaysian citizens, please enter your IC number. For international customers, please enter your passport number."></i></label>
                    <input type="text" class="form-control" name="participants[${participantIndex}][identity_number]" placeholder="e.g. 901234567890 or A12345678" required>
                </div>
            </div>
            <input type="hidden" name="participants[${participantIndex}][ticket_id]" value="${ticketId}">
            <input type="hidden" name="participants[${participantIndex}][ticket_number]" value="${ticketNumber}">
        `;
        return formDiv;
    }

    // Add participant button handler
    document.getElementById('add-participant').addEventListener('click', function() {
        const participantsContainer = document.getElementById('participants-container');
        const ticketRows = document.querySelectorAll('.ticket-row');
        
        // Find the first ticket with quantity > 0
        let ticketId = null;
        let ticketName = null;
        
        ticketRows.forEach(row => {
            const ticketSelect = row.querySelector('.ticket-select');
            const quantityInput = row.querySelector('.ticket-quantity');
            
            if (ticketSelect.value && quantityInput.value && parseInt(quantityInput.value) > 0) {
                if (!ticketId) {
                    ticketId = ticketSelect.value;
                    ticketName = ticketSelect.options[ticketSelect.selectedIndex].text.split(' - ')[0];
                }
            }
        });
        
        if (ticketId) {
            const participantForm = createParticipantForm(ticketId, ticketName, 1);
            participantsContainer.appendChild(participantForm);
            participantIndex++;
        }
    });

    // Update participant forms when tickets change
    function updateParticipantForms() {
        generateParticipantForms();
    }



    // Initialize
    updateRemoveButtons();
    calculateTotal();
    generateParticipantForms();
});
</script>
@endpush 