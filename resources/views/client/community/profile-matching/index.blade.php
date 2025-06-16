@extends('client.community.layouts.app')

@section('title', 'Profile Matching | BINA Community')

@section('content')
<section class="py-5 min-vh-100">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="display-5 fw-bold" style="color: #1B1F31;">Recommended Matches</h2>
            <p class="text-muted lead">Discover and connect with professionals in your field</p>
        </div>
        <div class="row g-4">
            @forelse($users as $user)
                <div class="col-md-4">
                    <div class="card card-profile p-3 text-center bg-white">
                        <div class="profile-image-container">
                            <img src="{{ $user['avatar'] }}" alt="{{ $user['full_name'] }}'s Profile Picture">
                        </div>
                        <h5 class="mt-3 mb-1">{{ $user['full_name'] }}</h5>
                        <p class="mb-1 text-muted">{{ $user['job_title'] ?? 'Not specified' }}</p>
                        <p class="text-secondary small">{{ Str::limit($user['about_me'] ?? 'No description available', 100) }}</p>
                        <div class="d-flex gap-2 mt-3">
                            <button type="button" class="btn btn-orange" onclick='showProfileModal(@json($user))'>
                                <i class="fas fa-user me-2"></i>View Profile
                            </button>
                            <button class="btn btn-orange-outline connection-request-btn" data-user-id="{{ $user['id'] }}">
                                <span class="btn-text"><i class="fas fa-user-plus me-2"></i>Send Connection Request</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state text-center py-5">
                        <div class="empty-state-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="empty-state-title">No profiles found at the moment</h3>
                        <p class="empty-state-description">Check back later for new community members!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

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
                                    <i class="fas fa-user me-2"></i>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab">
                                    <i class="fas fa-address-book me-2"></i>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="professional-tab" data-bs-toggle="tab" data-bs-target="#professional" type="button" role="tab">
                                    <i class="fas fa-briefcase me-2"></i>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="location-tab" data-bs-toggle="tab" data-bs-target="#location" type="button" role="tab">
                                    <i class="fas fa-map-marker-alt me-2"></i>
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

@section('styles')
<style>
.card-profile {
    border: none;
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-profile:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.card-profile img {
    border-radius: 50%;
    width: 80px;
    height: 80px;
    object-fit: cover;
    display: block;
    margin: 0 auto;
}

.profile-image-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Empty state styling */
.empty-state {
    background: rgba(255, 153, 0, 0.1);
    border-radius: 15px;
    padding: 3rem;
}

.empty-state-icon {
    font-size: 3rem;
    color: var(--bina-orange);
    margin-bottom: 1.5rem;
}

.empty-state-title {
    color: var(--bina-orange);
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.empty-state-description {
    color: #666;
    font-size: 1.1rem;
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

/* Tab Styling */
.nav-tabs {
    border-bottom: 2px solid #dee2e6;
}

.nav-tabs .nav-link {
    color: #666;
    border: none;
    padding: 0.75rem 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
    color: var(--bina-orange);
    border: none;
    background: transparent;
}

.nav-tabs .nav-link.active {
    color: var(--bina-orange);
    border: none;
    background: transparent;
    position: relative;
}

.nav-tabs .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: var(--bina-orange);
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

.btn-orange {
    background-color: #FF6B00;
    color: white;
    border: 2px solid #FF6B00;
    transition: all 0.3s ease;
}

.btn-orange:hover {
    background-color: #E65100;
    border-color: #E65100;
    color: white;
}

.btn-orange-outline {
    background-color: transparent;
    color: #FF6B00;
    border: 2px solid #FF6B00;
    transition: all 0.3s ease;
}

.btn-orange-outline:hover {
    background-color: #FF6B00;
    color: white;
}

/* Connection request button states */
.connection-request-btn.pending {
    background-color: #FFA726;
    border-color: #FFA726;
    color: white;
}

.connection-request-btn.connected {
    background-color: #66BB6A;
    border-color: #66BB6A;
    color: white;
}

.connection-request-btn.rejected {
    background-color: #EF5350;
    border-color: #EF5350;
    color: white;
}
</style>
@endsection

@section('scripts')
<script>
function showProfileModal(user) {
    // Update modal content
    document.getElementById('modalAvatar').src = user.avatar;
    document.getElementById('modalName').textContent = user.full_name;
    document.getElementById('modalJobTitle').textContent = user.job_title || 'Not specified';
    document.getElementById('modalAboutMe').textContent = user.about_me || 'No description available';
    document.getElementById('modalEmail').textContent = user.email;
    document.getElementById('modalPhone').textContent = user.mobile_number || 'Not provided';
    document.getElementById('modalWebsite').textContent = user.website || 'Not provided';
    
    // Professional details
    document.getElementById('modalCategory').textContent = user.category || 'Not specified';
    document.getElementById('modalOrganization').textContent = user.organization || 'Not specified';
    document.getElementById('modalAcademicInstitution').textContent = user.academic_institution || 'Not specified';
    document.getElementById('modalStudentId').textContent = user.student_id || 'Not specified';
    document.getElementById('modalImpactNumber').textContent = user.impact_number || 'Not specified';
    document.getElementById('modalGreenCard').textContent = user.green_card || 'Not specified';
    
    // Location
    document.getElementById('modalAddress').textContent = user.address || '';
    document.getElementById('modalCityState').textContent = 
        `${user.city || ''} ${user.state ? ', ' + user.state : ''} ${user.postal_code || ''}`.trim() || 'Address not provided';
    document.getElementById('modalCountry').textContent = user.country || '';

    // Social Media Links
    document.getElementById('modalLinkedin').textContent = user.linkedin || 'Not provided';
    document.getElementById('modalFacebook').textContent = user.facebook || 'Not provided';
    document.getElementById('modalTwitter').textContent = user.twitter || 'Not provided';
    document.getElementById('modalInstagram').textContent = user.instagram || 'Not provided';

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('profileModal'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    const connectionButtons = document.querySelectorAll('.connection-request-btn');
    
    connectionButtons.forEach(button => {
        const userId = button.dataset.userId;
        updateConnectionStatus(button, userId);
        
        button.addEventListener('click', async function() {
            const spinner = button.querySelector('.spinner-border');
            const btnText = button.querySelector('.btn-text');
            
            // Show loading state
            spinner.classList.remove('d-none');
            btnText.classList.add('d-none');
            button.disabled = true;

            // Get current button state
            const currentState = button.classList.contains('pending') ? 'pending' : 'none';
            
            // Immediately update button state
            updateButtonState(button, currentState === 'pending' ? 'none' : 'pending');
            
            try {
                const response = await fetch("{{ route('client.community.connections.send') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receiver_id: userId
                    })
                });
                
                const data = await response.json();
                if (data.status === 'error') {
                    // If there's an error, revert to original state
                    updateButtonState(button, currentState);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                // Revert to original state on error
                updateButtonState(button, currentState);
            } finally {
                // Hide loading state
                spinner.classList.add('d-none');
                btnText.classList.remove('d-none');
                button.disabled = false;
            }
        });
    });
    
    async function updateConnectionStatus(button, userId) {
        try {
            const response = await fetch(`{{ route('client.community.connections.status') }}?user_id=${userId}`);
            const data = await response.json();
            updateButtonState(button, data.status);
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    function updateButtonState(button, status) {
        const btnText = button.querySelector('.btn-text');
        button.disabled = false;
        
        switch (status) {
            case 'none':
                button.className = 'btn btn-orange-outline connection-request-btn';
                btnText.innerHTML = '<i class="fas fa-user-plus me-2"></i>Send Connection Request';
                break;
            case 'pending':
                button.className = 'btn btn-orange-outline connection-request-btn pending';
                btnText.innerHTML = '<i class="fas fa-clock me-2"></i>Cancel Request';
                break;
            case 'accepted':
                button.className = 'btn connection-request-btn connected';
                btnText.innerHTML = '<i class="fas fa-check me-2"></i>Connected';
                button.disabled = true;
                break;
            case 'rejected':
                button.className = 'btn connection-request-btn rejected';
                btnText.innerHTML = '<i class="fas fa-times me-2"></i>Request Rejected';
                button.disabled = true;
                break;
            case 'removed':
                button.className = 'btn btn-orange-outline connection-request-btn';
                btnText.innerHTML = '<i class="fas fa-user-plus me-2"></i>Send Connection Request';
                break;
        }
    }
});
</script>
@endsection