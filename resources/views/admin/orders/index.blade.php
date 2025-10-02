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
                                <li>
                                    <a class="dropdown-item" href="#" id="downloadPendingLog">
                                        <i class="bi bi-clock text-warning me-2"></i>Pending Transactions
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
                        <form id="searchForm" class="row g-3" method="GET" action="{{ route('admin.orders.index') }}">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchReference" name="search" 
                                           placeholder="Search by Reference Number" value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchIdentity" name="identity" 
                                           placeholder="Search by Identity Number" value="{{ request('identity') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="paymentMethod" name="payment_method">
                                    <option value="">All Payment Methods</option>
                                    <option value="stripe" {{ request('payment_method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                                    <option value="toyyibpay" {{ request('payment_method') == 'toyyibpay' ? 'selected' : '' }}>ToyyibPay</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="ticketFilter" name="ticket">
                                    <option value="">All Tickets</option>
                                    @foreach($tickets as $ticket)
                                        <option value="{{ $ticket->id }}" {{ request('ticket') == $ticket->id ? 'selected' : '' }}>
                                            {{ $ticket->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="eventFilter" name="event">
                                    <option value="all" {{ request('event', 'all') == 'all' ? 'selected' : '' }}>All Events</option>
                                    <option value="bina" {{ request('event') == 'bina' ? 'selected' : '' }}>BINA Events</option>
                                    <option value="industry" {{ request('event') == 'industry' ? 'selected' : '' }}>Sarawak Facility Management Engagement Day</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="paymentCountry" name="payment_country">
                                    <option value="">All Countries</option>
                                    <option value="Afghanistan" {{ request('payment_country') == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                                    <option value="Albania" {{ request('payment_country') == 'Albania' ? 'selected' : '' }}>Albania</option>
                                    <option value="Algeria" {{ request('payment_country') == 'Algeria' ? 'selected' : '' }}>Algeria</option>
                                    <option value="Andorra" {{ request('payment_country') == 'Andorra' ? 'selected' : '' }}>Andorra</option>
                                    <option value="Angola" {{ request('payment_country') == 'Angola' ? 'selected' : '' }}>Angola</option>
                                    <option value="Argentina" {{ request('payment_country') == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                                    <option value="Armenia" {{ request('payment_country') == 'Armenia' ? 'selected' : '' }}>Armenia</option>
                                    <option value="Australia" {{ request('payment_country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                    <option value="Austria" {{ request('payment_country') == 'Austria' ? 'selected' : '' }}>Austria</option>
                                    <option value="Azerbaijan" {{ request('payment_country') == 'Azerbaijan' ? 'selected' : '' }}>Azerbaijan</option>
                                    <option value="Bahamas" {{ request('payment_country') == 'Bahamas' ? 'selected' : '' }}>Bahamas</option>
                                    <option value="Bahrain" {{ request('payment_country') == 'Bahrain' ? 'selected' : '' }}>Bahrain</option>
                                    <option value="Bangladesh" {{ request('payment_country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                    <option value="Barbados" {{ request('payment_country') == 'Barbados' ? 'selected' : '' }}>Barbados</option>
                                    <option value="Belarus" {{ request('payment_country') == 'Belarus' ? 'selected' : '' }}>Belarus</option>
                                    <option value="Belgium" {{ request('payment_country') == 'Belgium' ? 'selected' : '' }}>Belgium</option>
                                    <option value="Belize" {{ request('payment_country') == 'Belize' ? 'selected' : '' }}>Belize</option>
                                    <option value="Benin" {{ request('payment_country') == 'Benin' ? 'selected' : '' }}>Benin</option>
                                    <option value="Bhutan" {{ request('payment_country') == 'Bhutan' ? 'selected' : '' }}>Bhutan</option>
                                    <option value="Bolivia" {{ request('payment_country') == 'Bolivia' ? 'selected' : '' }}>Bolivia</option>
                                    <option value="Bosnia and Herzegovina" {{ request('payment_country') == 'Bosnia and Herzegovina' ? 'selected' : '' }}>Bosnia and Herzegovina</option>
                                    <option value="Botswana" {{ request('payment_country') == 'Botswana' ? 'selected' : '' }}>Botswana</option>
                                    <option value="Brazil" {{ request('payment_country') == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                    <option value="Brunei" {{ request('payment_country') == 'Brunei' ? 'selected' : '' }}>Brunei</option>
                                    <option value="Bulgaria" {{ request('payment_country') == 'Bulgaria' ? 'selected' : '' }}>Bulgaria</option>
                                    <option value="Burkina Faso" {{ request('payment_country') == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
                                    <option value="Burundi" {{ request('payment_country') == 'Burundi' ? 'selected' : '' }}>Burundi</option>
                                    <option value="Cambodia" {{ request('payment_country') == 'Cambodia' ? 'selected' : '' }}>Cambodia</option>
                                    <option value="Cameroon" {{ request('payment_country') == 'Cameroon' ? 'selected' : '' }}>Cameroon</option>
                                    <option value="Canada" {{ request('payment_country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                    <option value="China" {{ request('payment_country') == 'China' ? 'selected' : '' }}>China</option>
                                    <option value="Colombia" {{ request('payment_country') == 'Colombia' ? 'selected' : '' }}>Colombia</option>
                                    <option value="Denmark" {{ request('payment_country') == 'Denmark' ? 'selected' : '' }}>Denmark</option>
                                    <option value="Egypt" {{ request('payment_country') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                                    <option value="Finland" {{ request('payment_country') == 'Finland' ? 'selected' : '' }}>Finland</option>
                                    <option value="France" {{ request('payment_country') == 'France' ? 'selected' : '' }}>France</option>
                                    <option value="Germany" {{ request('payment_country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                    <option value="Greece" {{ request('payment_country') == 'Greece' ? 'selected' : '' }}>Greece</option>
                                    <option value="Hong Kong" {{ request('payment_country') == 'Hong Kong' ? 'selected' : '' }}>Hong Kong</option>
                                    <option value="Hungary" {{ request('payment_country') == 'Hungary' ? 'selected' : '' }}>Hungary</option>
                                    <option value="Iceland" {{ request('payment_country') == 'Iceland' ? 'selected' : '' }}>Iceland</option>
                                    <option value="India" {{ request('payment_country') == 'India' ? 'selected' : '' }}>India</option>
                                    <option value="Indonesia" {{ request('payment_country') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="Iran" {{ request('payment_country') == 'Iran' ? 'selected' : '' }}>Iran</option>
                                    <option value="Iraq" {{ request('payment_country') == 'Iraq' ? 'selected' : '' }}>Iraq</option>
                                    <option value="Ireland" {{ request('payment_country') == 'Ireland' ? 'selected' : '' }}>Ireland</option>
                                    <option value="Israel" {{ request('payment_country') == 'Israel' ? 'selected' : '' }}>Israel</option>
                                    <option value="Italy" {{ request('payment_country') == 'Italy' ? 'selected' : '' }}>Italy</option>
                                    <option value="Jamaica" {{ request('payment_country') == 'Jamaica' ? 'selected' : '' }}>Jamaica</option>
                                    <option value="Japan" {{ request('payment_country') == 'Japan' ? 'selected' : '' }}>Japan</option>
                                    <option value="Jordan" {{ request('payment_country') == 'Jordan' ? 'selected' : '' }}>Jordan</option>
                                    <option value="Kazakhstan" {{ request('payment_country') == 'Kazakhstan' ? 'selected' : '' }}>Kazakhstan</option>
                                    <option value="Kenya" {{ request('payment_country') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                    <option value="Kuwait" {{ request('payment_country') == 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
                                    <option value="Malaysia" {{ request('payment_country') == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                                    <option value="Maldives" {{ request('payment_country') == 'Maldives' ? 'selected' : '' }}>Maldives</option>
                                    <option value="Mexico" {{ request('payment_country') == 'Mexico' ? 'selected' : '' }}>Mexico</option>
                                    <option value="Morocco" {{ request('payment_country') == 'Morocco' ? 'selected' : '' }}>Morocco</option>
                                    <option value="Myanmar" {{ request('payment_country') == 'Myanmar' ? 'selected' : '' }}>Myanmar</option>
                                    <option value="Nepal" {{ request('payment_country') == 'Nepal' ? 'selected' : '' }}>Nepal</option>
                                    <option value="Netherlands" {{ request('payment_country') == 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
                                    <option value="New Zealand" {{ request('payment_country') == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
                                    <option value="Nigeria" {{ request('payment_country') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                    <option value="Norway" {{ request('payment_country') == 'Norway' ? 'selected' : '' }}>Norway</option>
                                    <option value="Oman" {{ request('payment_country') == 'Oman' ? 'selected' : '' }}>Oman</option>
                                    <option value="Pakistan" {{ request('payment_country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                    <option value="Philippines" {{ request('payment_country') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                                    <option value="Poland" {{ request('payment_country') == 'Poland' ? 'selected' : '' }}>Poland</option>
                                    <option value="Portugal" {{ request('payment_country') == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                                    <option value="Qatar" {{ request('payment_country') == 'Qatar' ? 'selected' : '' }}>Qatar</option>
                                    <option value="Romania" {{ request('payment_country') == 'Romania' ? 'selected' : '' }}>Romania</option>
                                    <option value="Russia" {{ request('payment_country') == 'Russia' ? 'selected' : '' }}>Russia</option>
                                    <option value="Saudi Arabia" {{ request('payment_country') == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                    <option value="Singapore" {{ request('payment_country') == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                    <option value="South Africa" {{ request('payment_country') == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                    <option value="South Korea" {{ request('payment_country') == 'South Korea' ? 'selected' : '' }}>South Korea</option>
                                    <option value="Spain" {{ request('payment_country') == 'Spain' ? 'selected' : '' }}>Spain</option>
                                    <option value="Sri Lanka" {{ request('payment_country') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                    <option value="Sweden" {{ request('payment_country') == 'Sweden' ? 'selected' : '' }}>Sweden</option>
                                    <option value="Switzerland" {{ request('payment_country') == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
                                    <option value="Taiwan" {{ request('payment_country') == 'Taiwan' ? 'selected' : '' }}>Taiwan</option>
                                    <option value="Thailand" {{ request('payment_country') == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                                    <option value="Turkey" {{ request('payment_country') == 'Turkey' ? 'selected' : '' }}>Turkey</option>
                                    <option value="Ukraine" {{ request('payment_country') == 'Ukraine' ? 'selected' : '' }}>Ukraine</option>
                                    <option value="United Arab Emirates" {{ request('payment_country') == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                                    <option value="United Kingdom" {{ request('payment_country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="United States" {{ request('payment_country') == 'United States' ? 'selected' : '' }}>United States</option>
                                    <option value="Vietnam" {{ request('payment_country') == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                                    <option value="Yemen" {{ request('payment_country') == 'Yemen' ? 'selected' : '' }}>Yemen</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="date" class="form-control" id="startDate" name="start_date" placeholder="Start Date" value="{{ request('start_date') }}">
                                    <span class="input-group-text">to</span>
                                    <input type="date" class="form-control" id="endDate" name="end_date" placeholder="End Date" value="{{ request('end_date') }}">
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle"></i> Clear
                                    </a>
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
                                    <th>Under Affiliate</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $index => $order)
                                <tr data-ticket-ids='@json($order->ticket_ids)'>
                                    <td>{{ ($currentPage - 1) * $perPage + $loop->iteration }}</td>
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
                                    <td>
                                        @if($order->affiliate)
                                            <span class="badge bg-info">{{ $order->affiliate->affiliate_code }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
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
                                    {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
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
    // Billing Details Modal - Use event delegation
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-billing')) {
            e.preventDefault();
            const link = e.target.closest('.view-billing');
            const billingId = link.dataset.billingId;
            
            console.log('Fetching billing details for ID:', billingId);
            
            // Fetch billing details
                    fetch(`/admin/billing-details/${billingId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                    console.log('Billing details received:', data);
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
                    
                    // Show the modal
                    const billingModal = document.getElementById('billingModal');
                    const modal = new bootstrap.Modal(billingModal);
                    modal.show();
                })
                .catch(error => {
                    console.error('Error fetching billing details:', error);
                    alert('Error loading billing details. Please try again.');
                });
        }
    });

    // Cart Items Modal - Use event delegation
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-items')) {
            e.preventDefault();
            const link = e.target.closest('.view-items');
            const orderId = link.dataset.orderId;
            const processingFee = parseFloat(link.dataset.processingFee);
            const totalAmount = parseFloat(link.dataset.totalAmount);
            
            console.log('Fetching cart items for order ID:', orderId);
            
            // Fetch cart items
            fetch(`/admin/orders/${orderId}/items`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Cart items received:', data);
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
                    
                    // Show the modal
                    const itemsModal = document.getElementById('itemsModal');
                    const modal = new bootstrap.Modal(itemsModal);
                    modal.show();
                })
                .catch(error => {
                    console.error('Error fetching cart items:', error);
                    alert('Error loading cart items. Please try again.');
                });
        }
    });

    // Update Participants Modal - Use event delegation
    document.addEventListener('click', function(e) {
        if (e.target.closest('.update-participants')) {
            e.preventDefault();
            const link = e.target.closest('.update-participants');
            const orderId = link.dataset.orderId;
            
            console.log('Fetching participants for order ID:', orderId);
            
            // Fetch participants
            fetch(`/admin/orders/${orderId}/participants`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Participants received:', data);
                    document.getElementById('updateOrderId').value = orderId;
                    
                    const container = document.getElementById('updateParticipantsContainer');
                    container.innerHTML = '';
                    
                    // Group participants by ticket
                    const participantsByTicket = {};
                    data.forEach(participant => {
                        if (!participantsByTicket[participant.ticket_id]) {
                            participantsByTicket[participant.ticket_id] = [];
                        }
                        participantsByTicket[participant.ticket_id].push(participant);
                    });
                    
                    let ticketNumber = 1;
                    Object.keys(participantsByTicket).forEach(ticketId => {
                        const participants = participantsByTicket[ticketId];
                        participants.forEach(participant => {
                            const formDiv = document.createElement('div');
                            formDiv.className = 'participant-form mb-4 p-3 border rounded';
                            formDiv.innerHTML = `
                                <h6 class="mb-3">Participant ${ticketNumber} - ${participant.ticket_name}</h6>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="participant_full_name_${ticketNumber}">Full Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="participant_full_name_${ticketNumber}" name="participants[${ticketNumber}][full_name]" value="${participant.full_name || '-'}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="participant_phone_${ticketNumber}">Phone <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="participant_phone_${ticketNumber}" name="participants[${ticketNumber}][phone]" value="${participant.phone || '-'}" placeholder="e.g. 0123456789" required pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="participant_email_${ticketNumber}">Email Address <span class="required">*</span></label>
                                        <input type="email" class="form-control" id="participant_email_${ticketNumber}" name="participants[${ticketNumber}][email]" value="${participant.email || '-'}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="participant_gender_${ticketNumber}">Gender <span class="required">*</span></label>
                                        <select class="form-control" id="participant_gender_${ticketNumber}" name="participants[${ticketNumber}][gender]" required>
                                            <option value="">Select Gender</option>
                                            <option value="male" ${participant.gender === 'male' ? 'selected' : ''}>Male</option>
                                            <option value="female" ${participant.gender === 'female' ? 'selected' : ''}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="participant_company_${ticketNumber}">Company Name</label>
                                        <input type="text" class="form-control" id="participant_company_${ticketNumber}" name="participants[${ticketNumber}][company_name]" value="${participant.company_name || '-'}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="participant_identity_${ticketNumber}">Identity Card Number / Passport <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="participant_identity_${ticketNumber}" name="participants[${ticketNumber}][identity_number]" value="${participant.identity_number || '-'}" placeholder="e.g. 901234567890 or A12345678" required>
                                    </div>
                                </div>
                                <input type="hidden" name="participants[${ticketNumber}][ticket_id]" value="${participant.ticket_id}">
                                <input type="hidden" name="participants[${ticketNumber}][ticket_number]" value="${ticketNumber}">
                                ${participant.id ? `<input type="hidden" name="participants[${ticketNumber}][id]" value="${participant.id}">` : ''}
                            `;
                            container.appendChild(formDiv);
                            ticketNumber++;
            });
    });

                    // Show the modal
                    const updateModal = document.getElementById('updateParticipantsModal');
                    const modal = new bootstrap.Modal(updateModal);
                    modal.show();
            })
            .catch(error => {
                    console.error('Error fetching participants:', error);
                    alert('Error loading participants. Please try again.');
            });
        }
    });

    // View Participants Modal - Use event delegation
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-participants')) {
            e.preventDefault();
            const link = e.target.closest('.view-participants');
            const orderId = link.dataset.orderId;
            
            console.log('Fetching participants for viewing, order ID:', orderId);
            
            // Show the modal immediately with loading state
            const participantsModal = document.getElementById('participantsModal');
            const modal = new bootstrap.Modal(participantsModal);
            modal.show();
            
            // Show loading state
            const tbody = document.getElementById('participants-table-body');
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading participants...</span>
                        </div>
                        <div class="mt-2 text-muted">Loading participant details...</div>
                    </td>
                </tr>
            `;
            
            // Fetch participants with timeout
            const fetchTimeout = setTimeout(() => {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center text-warning">
                            <i class="bi bi-clock me-2"></i>
                            Taking longer than expected. Please wait...
                        </td>
                    </tr>
                `;
            }, 3000);
            
            fetch(`/admin/orders/${orderId}/participants`)
                .then(response => {
                    clearTimeout(fetchTimeout);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Participants for viewing received:', data);
                    tbody.innerHTML = '';
                    
                    if (data.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    <i class="bi bi-info-circle me-2"></i>
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
                    clearTimeout(fetchTimeout);
                    console.error('Error fetching participants for viewing:', error);
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="8" class="text-center text-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Error loading participant details. Please try again.
                            </td>
                        </tr>
                    `;
                });
        }
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

    // Auto-submit form when select dropdowns change
    const autoSubmitSelects = document.querySelectorAll('#paymentMethod, #ticketFilter, #eventFilter, #paymentCountry');
    autoSubmitSelects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('searchForm').submit();
        });
    });

    // Auto-submit form when date inputs change
    const dateInputs = document.querySelectorAll('#startDate, #endDate');
    dateInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Only submit if both dates are filled or if end date is filled after start date
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            if (this.id === 'startDate' && endDate) {
                document.getElementById('searchForm').submit();
            } else if (this.id === 'endDate' && startDate) {
                document.getElementById('searchForm').submit();
            }
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
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }

    // Download success log
    document.getElementById('downloadSuccessLog').addEventListener('click', function(e) {
        e.preventDefault();
        this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Generating...';
        this.disabled = true;
        
        fetch('/admin/orders/download-success-log')
            .then(response => response.text())
            .then(content => {
                downloadLog(content, 'successful_transactions_' + new Date().toISOString().split('T')[0] + '.log');
            })
            .catch(error => {
                console.error('Error downloading success log:', error);
                alert('Error downloading success log. Please try again.');
            })
            .finally(() => {
                this.innerHTML = '<i class="bi bi-check-circle text-success me-2"></i>Successful Transactions';
                this.disabled = false;
            });
    });

    // Download failed log
    document.getElementById('downloadFailedLog').addEventListener('click', function(e) {
        e.preventDefault();
        this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Generating...';
        this.disabled = true;
        
        fetch('/admin/orders/download-failed-log')
            .then(response => response.text())
            .then(content => {
                downloadLog(content, 'failed_transactions_' + new Date().toISOString().split('T')[0] + '.log');
            })
            .catch(error => {
                console.error('Error downloading failed log:', error);
                alert('Error downloading failed log. Please try again.');
            })
            .finally(() => {
                this.innerHTML = '<i class="bi bi-x-circle text-danger me-2"></i>Failed Transactions';
                this.disabled = false;
            });
    });

    // Download pending transactions log
    document.getElementById('downloadPendingLog').addEventListener('click', function(e) {
        e.preventDefault();
        this.innerHTML = '<i class="bi bi-clock text-warning me-2"></i>Downloading...';
        this.disabled = true;
        
        fetch('/admin/orders/download-pending-log')
            .then(response => response.text())
            .then(content => {
                downloadLog(content, 'pending_transactions_' + new Date().toISOString().split('T')[0] + '.log');
            })
            .catch(error => {
                console.error('Error downloading pending log:', error);
                alert('Error downloading pending log. Please try again.');
            })
            .finally(() => {
                this.innerHTML = '<i class="bi bi-clock text-warning me-2"></i>Pending Transactions';
                this.disabled = false;
            });
    });

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