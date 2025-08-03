@extends('admin.layouts.app')

@section('title', 'ADMIN | Users')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Users</h3>
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

                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Admin</h4>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>
                                Add New Admin
                            </a>
                        </div>
                        <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by admin name or email..." 
                                       name="admin_search" value="{{ request('admin_search') }}" id="adminSearchInput">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                                @if(request('admin_search'))
                                    <button type="button" class="btn btn-outline-secondary clear-search-btn" data-section="admin">
                                        <i class="bi bi-x"></i>
                                    </button>
                                @endif
                            </div>
                        </form>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th style="width: 150px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($adminUsers as $index => $user)
                                    <tr>
                                        <td>{{ $adminUsers->firstItem() + $index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal{{ $user->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="bi bi-people fs-1 text-muted"></i>
                                            <p class="mt-2 mb-0">No admin users found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div>
                                Showing {{ $adminUsers->firstItem() }} to {{ $adminUsers->lastItem() }} of {{ $adminUsers->total() }} results
                            </div>
                            <div>
                                {{ $adminUsers->appends(['admin_search' => request('admin_search')])->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 border border-secondary border-1 opacity-25">

                    <div class="table-responsive mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Community Members</h4>
                            <a href="{{ route('admin.users.download-community') }}" class="btn btn-success">
                                <i class="bi bi-download me-1"></i> Download Excel
                            </a>
                        </div>
                        <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name, email, organization, job title or student ID..." 
                                       name="client_search" value="{{ request('client_search') }}" id="clientSearchInput">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                                @if(request('client_search'))
                                    <button type="button" class="btn btn-outline-secondary clear-search-btn" data-section="community">
                                        <i class="bi bi-x"></i>
                                    </button>
                                @endif
                            </div>
                        </form>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Category</th>
                                    <th>Organization/Institution</th>
                                    <th>Job Title/Student ID</th>
                                    <th>Mobile Number</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clientUsers as $index => $user)
                                    <tr>
                                        <td>{{ $clientUsers->firstItem() + $index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->profile->category ?? '-' }}</td>
                                        <td>
                                            @if($user->profile)
                                                @if($user->profile->category === 'student')
                                                    {{ $user->profile->academic_institution ?? '-' }}
                                                @else
                                                    {{ $user->profile->organization ?? '-' }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->profile)
                                                @if($user->profile->category === 'student')
                                                    {{ $user->profile->student_id ?? '-' }}
                                                @else
                                                    {{ $user->profile->job_title ?? '-' }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $user->profile->mobile_number ?? '-' }}</td>
                                        <td>{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="bi bi-people fs-1 text-muted"></i>
                                            <p class="mt-2 mb-0">No client users found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div>
                                Showing {{ $clientUsers->firstItem() }} to {{ $clientUsers->lastItem() }} of {{ $clientUsers->total() }} results
                            </div>
                            <div>
                                {{ $clientUsers->appends(['client_search' => request('client_search')])->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 border border-secondary border-1 opacity-25">

                    <div class="table-responsive mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Ticket Purchasers</h4>
                            <a href="{{ route('admin.users.download-purchasers') }}" class="btn btn-success">
                                <i class="bi bi-download me-1"></i> Download Excel
                            </a>
                        </div>
                        <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name, email, identity number, company name or student ID..." 
                                       name="purchaser_search" value="{{ request('purchaser_search') }}" id="purchaserSearchInput">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                                @if(request('purchaser_search'))
                                    <button type="button" class="btn btn-outline-secondary clear-search-btn" data-section="purchasers">
                                        <i class="bi bi-x"></i>
                                    </button>
                                @endif
                            </div>
                        </form>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No.</th>
                                    <th>Name</th>
                                    <th>Identity Number</th>
                                    <th>Gender</th>
                                    <th>Category</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company Details</th>
                                    <th>Academic Details</th>
                                    <th>Address</th>
                                    <th>Orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ticketPurchasers as $index => $purchaser)
                                    <tr>
                                        <td>{{ $ticketPurchasers->firstItem() + $index }}</td>
                                        <td>{{ $purchaser->first_name }} {{ $purchaser->last_name }}</td>
                                        <td>{{ $purchaser->identity_number ?? '-' }}</td>
                                        <td>{{ ucfirst($purchaser->gender ?? '-') }}</td>
                                        <td>{{ ucfirst($purchaser->category ?? '-') }}</td>
                                        <td>{{ $purchaser->email }}</td>
                                        <td>{{ $purchaser->phone }}</td>
                                        <td>
                                            @if($purchaser->company_name || $purchaser->business_registration_number || $purchaser->tax_number)
                                                <strong>Company:</strong> {{ $purchaser->company_name }}<br>
                                                <strong>Reg No:</strong> {{ $purchaser->business_registration_number }}<br>
                                                <strong>Tax No:</strong> {{ $purchaser->tax_number }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($purchaser->student_id || $purchaser->academic_institution)
                                                <strong>Student ID:</strong> {{ $purchaser->student_id }}<br>
                                                <strong>Institution:</strong> {{ $purchaser->academic_institution }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            {{ $purchaser->address1 }}<br>
                                            @if($purchaser->address2)
                                                {{ $purchaser->address2 }}<br>
                                            @endif
                                            {{ $purchaser->city }}, {{ $purchaser->state }} {{ $purchaser->postcode }}<br>
                                            {{ $purchaser->country }}
                                        </td>
                                        <td>
                                            @foreach($purchaser->orders as $order)
                                                <div class="mb-2">
                                                    <strong>Ref:</strong> {{ $order->reference_number }}<br>
                                                    <strong>Amount:</strong> RM {{ number_format($order->total_amount, 2) }}<br>
                                                    <strong>Date:</strong> {{ $order->created_at->format('d M Y') }}
                                                </div>
                                                @if(!$loop->last)
                                                    <hr class="my-2">
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-4">
                                            <i class="bi bi-ticket-perforated fs-1 text-muted"></i>
                                            <p class="mt-2 mb-0">No ticket purchasers found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div>
                                Showing {{ $ticketPurchasers->firstItem() }} to {{ $ticketPurchasers->lastItem() }} of {{ $ticketPurchasers->total() }} results
                            </div>
                            <div>
                                {{ $ticketPurchasers->appends(['purchaser_search' => request('purchaser_search')])->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 border border-secondary border-1 opacity-25">

                    <div class="table-responsive mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">Participants</h4>
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Rows with <span class="badge bg-warning text-dark">P</span> badge use purchaser data (no participant details provided)
                                    @if(request('participant_search'))
                                        <br><span class="text-info"><i class="bi bi-search me-1"></i>Searching for: "{{ request('participant_search') }}"</span>
                                    @endif
                                </small>
                            </div>
                            <a href="{{ route('admin.users.download-participants') }}" class="btn btn-success">
                                <i class="bi bi-download me-1"></i> Download Excel
                            </a>
                        </div>
                        <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name, email, phone, company or identity number..." 
                                       name="participant_search" value="{{ request('participant_search') }}" id="participantSearchInput">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                                @if(request('participant_search'))
                                    <button type="button" class="btn btn-outline-secondary clear-search-btn" data-section="participants">
                                        <i class="bi bi-x"></i>
                                    </button>
                                @endif
                            </div>
                        </form>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No.</th>
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Company Name</th>
                                    <th>Identity Number</th>
                                    <th>Ticket Name</th>
                                    <th>Ticket Price</th>
                                    <th>Order Reference</th>
                                    <th>Order Date</th>
                                    <th>Order Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($participants as $index => $participant)
                                    <tr class="{{ isset($participant->is_virtual) && $participant->is_virtual ? 'table-warning' : '' }}">
                                        <td>{{ $participants->firstItem() + $index }}</td>
                                        <td>
                                            {{ $participant->full_name }}
                                            @if(isset($participant->is_virtual) && $participant->is_virtual)
                                                <span class="badge bg-warning text-dark ms-1" title="Uses purchaser data">P</span>
                                            @endif
                                        </td>
                                        <td>{{ $participant->phone ?? '-' }}</td>
                                        <td>{{ $participant->email ?? '-' }}</td>
                                        <td>{{ ucfirst($participant->gender ?? '-') }}</td>
                                        <td>{{ $participant->company_name ?? '-' }}</td>
                                        <td>{{ $participant->identity_number ?? '-' }}</td>
                                        <td>{{ $participant->ticket->name ?? '-' }}</td>
                                        <td>{{ $participant->ticket->price ? 'RM ' . number_format($participant->ticket->price, 2) : '-' }}</td>
                                        <td>{{ $participant->order->reference_number ?? '-' }}</td>
                                        <td>{{ $participant->order->created_at ? $participant->order->created_at->format('d M Y H:i') : '-' }}</td>
                                        <td>{{ $participant->order->total_amount ? 'RM ' . number_format($participant->order->total_amount, 2) : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-4">
                                            <i class="bi bi-people fs-1 text-muted"></i>
                                            <p class="mt-2 mb-0">No participants found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div>
                                Showing {{ $participants->firstItem() }} to {{ $participants->lastItem() }} of {{ $participants->total() }} results
                            </div>
                            <div>
                                {{ $participants->appends(['participant_search' => request('participant_search')])->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modals -->
@foreach($adminUsers as $user)
<div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    Delete Confirmation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user?</p>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">{{ $user->name }}</h6>
                        <p class="card-text mb-1">
                            <small class="text-muted">Email: {{ $user->email }}</small>
                        </p>
                        <p class="card-text mb-0">
                            <small class="text-muted">Created: {{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</small>
                        </p>
                    </div>
                </div>
                <div class="alert alert-danger mb-0">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    This action cannot be undone. All associated data will be permanently deleted.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>
                    Cancel
                </button>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to handle search form
        function setupSearchForm(formSelector, inputId, pageParam, sectionName) {
            const searchForm = document.querySelector(formSelector);
            const searchInput = document.getElementById(inputId);

            // Submit form when pressing Enter in search input
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchForm.submit();
                }
            });

            // Add submit event listener to scroll to the section
            searchForm.addEventListener('submit', function() {
                // Store the section name in sessionStorage to check after page reload
                sessionStorage.setItem('scrollToSection', sectionName);
            });
        }

        // Handle clear search buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.clear-search-btn')) {
                e.preventDefault();
                const clearBtn = e.target.closest('.clear-search-btn');
                const section = clearBtn.getAttribute('data-section');
                
                // Store the section name for scrolling after clear
                sessionStorage.setItem('scrollToSection', section);
                
                // Build the URL to clear the specific search parameter
                const url = new URL(window.location);
                const searchParams = {
                    'admin': 'admin_search',
                    'community': 'client_search', 
                    'purchasers': 'purchaser_search',
                    'participants': 'participant_search'
                };
                
                // Remove the specific search parameter
                const paramToRemove = searchParams[section];
                if (paramToRemove) {
                    url.searchParams.delete(paramToRemove);
                }
                
                // Navigate to the cleared URL
                window.location.href = url.toString();
            }
        });

        // Setup search for each table
        setupSearchForm('form:has(#adminSearchInput)', 'adminSearchInput', 'admin_page', 'admin');
        setupSearchForm('form:has(#clientSearchInput)', 'clientSearchInput', 'client_page', 'community');
        setupSearchForm('form:has(#purchaserSearchInput)', 'purchaserSearchInput', 'purchaser_page', 'purchasers');
        setupSearchForm('form:has(#participantSearchInput)', 'participantSearchInput', 'participant_page', 'participants');

        // Check if we should scroll to a specific section after page load
        const scrollToSection = sessionStorage.getItem('scrollToSection');
        if (scrollToSection) {
            // Clear the flag
            sessionStorage.removeItem('scrollToSection');
            
            // Find the appropriate section and scroll to it
            let targetSection = null;
            switch (scrollToSection) {
                case 'admin':
                    targetSection = document.querySelector('.table-responsive:has(#adminSearchInput)');
                    break;
                case 'community':
                    targetSection = document.querySelector('.table-responsive:has(#clientSearchInput)');
                    break;
                case 'purchasers':
                    targetSection = document.querySelector('.table-responsive:has(#purchaserSearchInput)');
                    break;
                case 'participants':
                    targetSection = document.querySelector('.table-responsive:has(#participantSearchInput)');
                    break;
            }
            
            if (targetSection) {
                setTimeout(function() {
                    targetSection.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                }, 100);
            }
        }

        // Also scroll to appropriate section if there's a search term in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const searchParams = ['admin_search', 'client_search', 'purchaser_search', 'participant_search'];
        
        for (const param of searchParams) {
            if (urlParams.has(param) && urlParams.get(param).trim() !== '') {
                let targetSection = null;
                switch (param) {
                    case 'admin_search':
                        targetSection = document.querySelector('.table-responsive:has(#adminSearchInput)');
                        break;
                    case 'client_search':
                        targetSection = document.querySelector('.table-responsive:has(#clientSearchInput)');
                        break;
                    case 'purchaser_search':
                        targetSection = document.querySelector('.table-responsive:has(#purchaserSearchInput)');
                        break;
                    case 'participant_search':
                        targetSection = document.querySelector('.table-responsive:has(#participantSearchInput)');
                        break;
                }
                
                if (targetSection) {
                    setTimeout(function() {
                        targetSection.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start' 
                        });
                    }, 100);
                }
                break; // Only scroll to the first found search parameter
            }
        }
    });
</script>
@endpush
@endsection 