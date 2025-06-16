@extends('client.community.layouts.app')

@section('title', 'Connections | BINA Community')

@section('content')
<script>
async function handleRequest(action, senderId, button) {
    const spinner = button.querySelector('.spinner-border');
    const btnText = button.querySelector('.btn-text');
    const route = action === 'accept' 
        ? "{{ route('client.community.connections.accept') }}"
        : "{{ route('client.community.connections.reject') }}";
    
    try {
        if (spinner) spinner.classList.remove('d-none');
        if (btnText) btnText.classList.add('d-none');
        button.disabled = true;

        const response = await fetch(route, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ sender_id: senderId })
        });

        const data = await response.json();
        console.log('Response:', response.status, data);

        if (response.ok) {
            const listItem = button.closest('.list-group-item');
            listItem.style.transition = 'opacity 0.3s ease';
            listItem.style.opacity = '0';
            setTimeout(() => {
                window.location.reload();
            }, 300);
        } else {
            throw new Error(data.message || `Failed to ${action} request`);
        }
    } catch (error) {
        console.error(`Error ${action}ing request:`, error);
        if (spinner) spinner.classList.add('d-none');
        if (btnText) btnText.classList.remove('d-none');
        button.disabled = false;
        alert(`Error ${action}ing request: ${error.message}`);
    }
}
</script>

<div class="container py-5" style="min-height: calc(100vh - 76px);">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="section-title text-center mb-5">
                <h2 class="display-5 fw-bold" style="color: #1B1F31;">My Network</h2>
                <p class="text-muted lead">Manage your connections and grow your professional network</p>
            </div>
            
            <div class="row">
                <!-- Pending Requests -->
                <div class="col-md-5">
                    <div class="card mb-4 shadow-sm border-0 rounded-4 overflow-hidden h-100">
                        <div class="card-header py-3" style="background-color: #1B1F31;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-clock text-white fs-4 me-2"></i>
                                <h5 class="card-title mb-0 text-white">Pending Requests</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @php
                                $pendingRequests = \App\Models\ConnectionRequest::with('sender')
                                    ->where('receiver_id', auth()->id())
                                    ->where('status', 'pending')
                                    ->get();
                            @endphp

                            @if($pendingRequests->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox text-orange-light fs-1 mb-3"></i>
                                    <p class="text-muted mb-0">No pending connection requests at the moment.</p>
                                </div>
                            @else
                                <div class="list-group">
                                    @foreach($pendingRequests as $request)
                                        <div class="list-group-item border-0 mb-3 bg-light rounded-3 hover-shadow">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center user-section" 
                                                     onclick="showProfileModal({
                                                        name: '{{ $request->sender->profile->first_name }} {{ $request->sender->profile->last_name }}',
                                                        email: '{{ $request->sender->email }}',
                                                        avatar: '{{ $request->sender->avatar }}',
                                                        profile: {
                                                            job_title: '{{ $request->sender->profile->job_title ?? '' }}',
                                                            about_me: '{{ $request->sender->profile->about_me ?? '' }}',
                                                            mobile_number: '{{ $request->sender->profile->mobile_number ?? '' }}',
                                                            website: '{{ $request->sender->profile->website ?? '' }}',
                                                            category: '{{ $request->sender->profile->category ?? '' }}',
                                                            organization: '{{ $request->sender->profile->organization ?? '' }}',
                                                            academic_institution: '{{ $request->sender->profile->academic_institution ?? '' }}',
                                                            student_id: '{{ $request->sender->profile->student_id ?? '' }}',
                                                            impact_number: '{{ $request->sender->profile->impact_number ?? '' }}',
                                                            green_card: '{{ $request->sender->profile->green_card ?? '' }}',
                                                            address: '{{ $request->sender->profile->address ?? '' }}',
                                                            city: '{{ $request->sender->profile->city ?? '' }}',
                                                            state: '{{ $request->sender->profile->state ?? '' }}',
                                                            postal_code: '{{ $request->sender->profile->postal_code ?? '' }}',
                                                            country: '{{ $request->sender->profile->country ?? '' }}',
                                                            linkedin: '{{ $request->sender->profile->linkedin ?? '' }}',
                                                            facebook: '{{ $request->sender->profile->facebook ?? '' }}',
                                                            twitter: '{{ $request->sender->profile->twitter ?? '' }}',
                                                            instagram: '{{ $request->sender->profile->instagram ?? '' }}'
                                                        }
                                                    })">
                                                    <div class="position-relative">
                                                        <img src="{{ $request->sender->avatar ? route('avatar.show', $request->sender->avatar) : asset('images/default-avatar.png') }}" 
                                                             class="rounded-circle border border-3 border-white shadow-sm" 
                                                             style="width: 60px; height: 60px; object-fit: cover;"
                                                             alt="{{ $request->sender->profile->first_name }} {{ $request->sender->profile->last_name }}">
                                                    </div>
                                                    <div class="ms-3">
                                                        <h6 class="mb-1 fw-bold">{{ $request->sender->profile->first_name }} {{ $request->sender->profile->last_name }}</h6>
                                                        <p class="text-muted small mb-0">
                                                            <i class="fas fa-briefcase me-1"></i>
                                                            {{ $request->sender->profile->job_title ?? 'No title specified' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-success btn-sm accept-request px-3" data-sender-id="{{ $request->sender_id }}" onclick="handleRequest('accept', {{ $request->sender_id }}, this)">
                                                        <span class="btn-text">
                                                            <i class="fas fa-check me-1"></i>Accept
                                                        </span>
                                                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm reject-request px-3" data-sender-id="{{ $request->sender_id }}" onclick="handleRequest('reject', {{ $request->sender_id }}, this)">
                                                        <span class="btn-text">
                                                            <i class="fas fa-times me-1"></i>Reject
                                                        </span>
                                                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Connected Users -->
                <div class="col-md-7">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100">
                        <div class="card-header py-3" style="background-color: #1B1F31;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users text-white fs-4 me-2"></i>
                                <h5 class="card-title mb-0 text-white">My Connections</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @php
                                $connections = \App\Models\ConnectionRequest::with(['sender', 'receiver'])
                                    ->where(function($query) {
                                        $query->where('sender_id', auth()->id())
                                            ->orWhere('receiver_id', auth()->id());
                                    })
                                    ->where('status', 'accepted')
                                    ->get()
                                    ->map(function($request) {
                                        return $request->sender_id === auth()->id() 
                                            ? $request->receiver 
                                            : $request->sender;
                                    });
                            @endphp

                            @if($connections->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fas fa-user-friends text-orange-light fs-1 mb-3"></i>
                                    <p class="text-muted mb-0">You haven't connected with anyone yet.</p>
                                    <a href="{{ route('client.community.profile-matching') }}" class="btn btn-orange mt-3">
                                        <i class="fas fa-search me-1"></i>Find Connections
                                    </a>
                                </div>
                            @else
                                <div class="list-group">
                                    @foreach($connections as $connection)
                                        <div class="list-group-item border-0 mb-3 bg-light rounded-3 hover-shadow">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="position-relative">
                                                        <img src="{{ $connection->avatar ? route('avatar.show', $connection->avatar) : asset('images/default-avatar.png') }}" 
                                                             class="rounded-circle border border-3 border-white shadow-sm" 
                                                             style="width: 60px; height: 60px; object-fit: cover;"
                                                             alt="{{ $connection->profile->first_name }} {{ $connection->profile->last_name }}">
                                                    </div>
                                                    <div class="ms-3">
                                                        <h6 class="mb-1 fw-bold">{{ $connection->profile->first_name }} {{ $connection->profile->last_name }}</h6>
                                                        <p class="text-muted small mb-0">
                                                            <i class="fas fa-briefcase me-1"></i>
                                                            {{ $connection->profile->job_title ?? 'No title specified' }}
                                                        </p>
                                                        @if($connection->profile->organization)
                                                        <p class="text-muted small mb-0">
                                                            <i class="fas fa-building me-1"></i>
                                                            {{ $connection->profile->organization }}
                                                        </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-orange-soft btn-sm px-3" 
                                                            onclick="showProfileModal({
                                                                name: '{{ $connection->profile->first_name }} {{ $connection->profile->last_name }}',
                                                                email: '{{ $connection->email }}',
                                                                avatar: '{{ $connection->avatar }}',
                                                                profile: {
                                                                    job_title: '{{ $connection->profile->job_title ?? '' }}',
                                                                    about_me: '{{ $connection->profile->about_me ?? '' }}',
                                                                    mobile_number: '{{ $connection->profile->mobile_number ?? '' }}',
                                                                    website: '{{ $connection->profile->website ?? '' }}',
                                                                    category: '{{ $connection->profile->category ?? '' }}',
                                                                    organization: '{{ $connection->profile->organization ?? '' }}',
                                                                    academic_institution: '{{ $connection->profile->academic_institution ?? '' }}',
                                                                    student_id: '{{ $connection->profile->student_id ?? '' }}',
                                                                    impact_number: '{{ $connection->profile->impact_number ?? '' }}',
                                                                    green_card: '{{ $connection->profile->green_card ?? '' }}',
                                                                    address: '{{ $connection->profile->address ?? '' }}',
                                                                    city: '{{ $connection->profile->city ?? '' }}',
                                                                    state: '{{ $connection->profile->state ?? '' }}',
                                                                    postal_code: '{{ $connection->profile->postal_code ?? '' }}',
                                                                    country: '{{ $connection->profile->country ?? '' }}',
                                                                    linkedin: '{{ $connection->profile->linkedin ?? '' }}',
                                                                    facebook: '{{ $connection->profile->facebook ?? '' }}',
                                                                    twitter: '{{ $connection->profile->twitter ?? '' }}',
                                                                    instagram: '{{ $connection->profile->instagram ?? '' }}'
                                                                }
                                                            })">
                                                        <i class="fas fa-user me-1"></i>View Profile
                                                    </button>
                                                    <a href="#" class="btn btn-orange-soft btn-sm px-3">
                                                        <i class="fas fa-envelope me-1"></i>Message
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="profileModalLabel">Profile Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Column - Basic Info -->
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        <img id="modalAvatar" src="" alt="Profile Picture" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        <h4 id="modalName" class="mb-2"></h4>
                        <p id="modalJobTitle" class="text-muted mb-2"></p>
                    </div>
                    <!-- Right Column - Tabbed Info -->
                    <div class="col-md-8">
                        <!-- Tabs Navigation -->
                        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab">
                                    <i class="fas fa-user me-2" style="color: #ff9900;"></i>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab">
                                    <i class="fas fa-address-book me-2" style="color: #ff9900;"></i>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="professional-tab" data-bs-toggle="tab" data-bs-target="#professional" type="button" role="tab">
                                    <i class="fas fa-briefcase me-2" style="color: #ff9900;"></i>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="location-tab" data-bs-toggle="tab" data-bs-target="#location" type="button" role="tab">
                                    <i class="fas fa-map-marker-alt me-2" style="color: #ff9900;"></i>
                                </button>
                            </li>
                        </ul>

                        <!-- Tabs Content -->
                        <div class="tab-content pt-4" id="profileTabsContent">
                            <!-- About Tab -->
                            <div class="tab-pane fade show active" id="about" role="tabpanel">
                                <p id="modalAboutMe" class="text-muted"></p>
                            </div>

                            <!-- Contact & Social Tab -->
                            <div class="tab-pane fade" id="contact" role="tabpanel">
                                <h6 class="mb-3" style="color: #ff9900;">Contact Information</h6>
                                <ul class="list-unstyled mb-4">
                                    <li class="mb-2"><i class="fas fa-envelope me-2" style="color: #ff9900;"></i> <span id="modalEmail"></span></li>
                                    <li class="mb-2"><i class="fas fa-phone me-2" style="color: #ff9900;"></i> <span id="modalPhone"></span></li>
                                    <li class="mb-2"><i class="fas fa-globe me-2" style="color: #ff9900;"></i> <span id="modalWebsite"></span></li>
                                </ul>

                                <h6 class="mb-3" style="color: #ff9900;">Social Media</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fab fa-linkedin me-2" style="color: #ff9900;"></i>
                                        <span id="modalLinkedin" class="text-muted">Not provided</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fab fa-facebook me-2" style="color: #ff9900;"></i>
                                        <span id="modalFacebook" class="text-muted">Not provided</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fab fa-twitter me-2" style="color: #ff9900;"></i>
                                        <span id="modalTwitter" class="text-muted">Not provided</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fab fa-instagram me-2" style="color: #ff9900;"></i>
                                        <span id="modalInstagram" class="text-muted">Not provided</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Professional Tab -->
                            <div class="tab-pane fade" id="professional" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Category:</strong> <span id="modalCategory"></span></p>
                                        <p class="mb-2"><strong>Organization:</strong> <span id="modalOrganization"></span></p>
                                        <p class="mb-2"><strong>Academic Institution:</strong> <span id="modalAcademicInstitution"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Student ID:</strong> <span id="modalStudentId"></span></p>
                                        <p class="mb-2"><strong>Impact Number:</strong> <span id="modalImpactNumber"></span></p>
                                        <p class="mb-2"><strong>Green Card:</strong> <span id="modalGreenCard"></span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Tab -->
                            <div class="tab-pane fade" id="location" role="tabpanel">
                                <p class="mb-1" id="modalAddress"></p>
                                <p class="mb-1" id="modalCityState"></p>
                                <p class="mb-1" id="modalCountry"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
:root {
    --orange-primary: #FF6B00;
    --orange-secondary: #FF8533;
    --orange-light: #FFE0CC;
}

.container {
    display: flex;
    flex-direction: column;
}

.row {
    flex: 1;
}

.card {
    height: 100%;
}

.text-orange {
    color: #FF6B00 !important;
}

.text-orange-light {
    color: #FF8533 !important;
}

.bg-orange {
    background-color: #FF6B00 !important;
}

/* Override any Bootstrap card header styles */
.card .card-header {
    background-color: #FF6B00 !important;
    border-bottom: none !important;
}

.card .card-header .card-title {
    color: #FFFFFF !important;
}

.card .card-header i {
    color: #FFFFFF !important;
}

.btn-orange {
    background-color: #FF6B00;
    border-color: #FF6B00;
    color: white;
    transition: all 0.3s ease;
}

.btn-orange:hover {
    background-color: #FF8533;
    border-color: #FF8533;
    color: white;
    transform: translateY(-1px);
}

.btn-orange-soft {
    background-color: #FFE0CC;
    border-color: #FFE0CC;
    color: #FF6B00;
    transition: all 0.3s ease;
}

.btn-orange-soft:hover {
    background-color: #FF6B00;
    border-color: #FF6B00;
    color: white;
}

.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
}

.connection-card {
    transition: all 0.3s ease;
}

.connection-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
}

.btn:disabled {
    opacity: 0.65;
}

.spinner-border {
    width: 1rem;
    height: 1rem;
    border-width: 0.15em;
}

.btn-sm .spinner-border {
    margin: 0 0.25rem;
}

/* Modal styling */
.text-orange {
    color: var(--bina-orange);
}

.modal-content {
    border: none;
    border-radius: 15px;
}

.modal-header {
    border-radius: 15px 15px 0 0;
    border-bottom: 1px solid #eee;
}

/* Modal Tab Styling */
#profileModal .nav-tabs {
    border-bottom: 2px solid #dee2e6;
}

#profileModal .nav-tabs .nav-link {
    color: #666 !important;
    border: none !important;
    padding: 0.75rem 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
    background: transparent !important;
}

#profileModal .nav-tabs .nav-link:hover {
    color: var(--orange-primary) !important;
}

#profileModal .nav-tabs .nav-link.active {
    color: var(--orange-primary) !important;
    position: relative;
}

#profileModal .nav-tabs .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: var(--orange-primary);
}

/* Icon colors in tabs */
#profileModal .nav-tabs .nav-link i {
    color: #666;
    transition: all 0.3s ease;
}

#profileModal .nav-tabs .nav-link:hover i,
#profileModal .nav-tabs .nav-link.active i {
    color: var(--orange-primary) !important;
}

/* Modal content styling */
#profileModal .text-orange {
    color: var(--orange-primary) !important;
}

#profileModal .text-orange-light {
    color: var(--orange-secondary) !important;
}

#profileModal i.text-orange {
    color: var(--orange-primary) !important;
}

/* Override any Bootstrap focus states */
#profileModal .nav-tabs .nav-link:focus {
    color: #666 !important;
    border: none !important;
    box-shadow: none !important;
}

#profileModal .nav-tabs .nav-link.active:focus {
    color: var(--orange-primary) !important;
}

/* Responsive tabs */
@media (max-width: 767px) {
    .nav-tabs {
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }
    
    .nav-tabs::-webkit-scrollbar {
        display: none;
    }
    
    .nav-tabs .nav-link {
        white-space: nowrap;
    }
}

/* Clickable user section styles */
.user-section {
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 8px;
    border-radius: 8px;
}

.user-section:hover {
    background-color: rgba(255, 107, 0, 0.05);
}
</style>
@endpush

@section('scripts')
@parent
<script>
// Initialize Bootstrap's Modal functionality
let profileModalInstance = null;

document.addEventListener('DOMContentLoaded', function() {
    // Debug log
    console.log('Page loaded, initializing modal functionality');
    
    // Get the modal element
    const profileModal = document.getElementById('profileModal');
    
    // Initialize the modal
    if (profileModal) {
        console.log('Found profile modal, initializing...');
        profileModalInstance = new bootstrap.Modal(profileModal, {
            keyboard: true,
            backdrop: true
        });
    } else {
        console.error('Profile modal element not found!');
    }
});

window.showProfileModal = function(user) {
    console.log('Opening modal for user:', user);
    try {
        // Update modal content
        document.getElementById('modalAvatar').src = user.avatar 
            ? `{{ url('avatar') }}/${user.avatar}`
            : "{{ asset('images/default-avatar.png') }}";
        document.getElementById('modalName').textContent = user.name;
        document.getElementById('modalJobTitle').textContent = user.profile?.job_title || 'Not specified';
        document.getElementById('modalAboutMe').textContent = user.profile?.about_me || 'No description available';
        document.getElementById('modalEmail').textContent = user.email;
        document.getElementById('modalPhone').textContent = user.profile?.mobile_number || 'Not provided';
        document.getElementById('modalWebsite').textContent = user.profile?.website || 'Not provided';
        
        // Professional details
        document.getElementById('modalCategory').textContent = user.profile?.category || 'Not specified';
        document.getElementById('modalOrganization').textContent = user.profile?.organization || 'Not specified';
        document.getElementById('modalAcademicInstitution').textContent = user.profile?.academic_institution || 'Not specified';
        document.getElementById('modalStudentId').textContent = user.profile?.student_id || 'Not specified';
        document.getElementById('modalImpactNumber').textContent = user.profile?.impact_number || 'Not specified';
        document.getElementById('modalGreenCard').textContent = user.profile?.green_card || 'Not specified';
        
        // Location
        document.getElementById('modalAddress').textContent = user.profile?.address || '';
        document.getElementById('modalCityState').textContent = 
            `${user.profile?.city || ''} ${user.profile?.state ? ', ' + user.profile.state : ''} ${user.profile?.postal_code || ''}`.trim() || 'Address not provided';
        document.getElementById('modalCountry').textContent = user.profile?.country || '';

        // Social Media Links
        document.getElementById('modalLinkedin').textContent = user.profile?.linkedin || 'Not provided';
        document.getElementById('modalFacebook').textContent = user.profile?.facebook || 'Not provided';
        document.getElementById('modalTwitter').textContent = user.profile?.twitter || 'Not provided';
        document.getElementById('modalInstagram').textContent = user.profile?.instagram || 'Not provided';

        // Show the modal
        if (profileModalInstance) {
            profileModalInstance.show();
        } else {
            console.error('Modal instance not found, reinitializing...');
            const modalElement = document.getElementById('profileModal');
            if (modalElement) {
                profileModalInstance = new bootstrap.Modal(modalElement);
                profileModalInstance.show();
            } else {
                console.error('Modal element not found!');
            }
        }
    } catch (error) {
        console.error('Error showing modal:', error);
    }
}
</script>
@endsection
