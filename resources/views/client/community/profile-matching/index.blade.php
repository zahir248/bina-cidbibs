@extends('client.community.layouts.app')

@section('title', 'Profile Matching | BINA Community')

@section('content')
<section class="py-5 min-vh-100">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="display-5 fw-bold" style="color: #1B1F31;">Recommended Matches</h2>
            <p class="text-muted lead">Discover and connect with professionals in your field</p>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('client.community.profile-matching') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="location" class="form-label">Country</label>
                        <select class="form-control" id="location" name="location">
                            <option value="">All Countries</option>
                            <option value="Afghanistan" {{ request('location') == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                            <option value="Albania" {{ request('location') == 'Albania' ? 'selected' : '' }}>Albania</option>
                            <option value="Algeria" {{ request('location') == 'Algeria' ? 'selected' : '' }}>Algeria</option>
                            <option value="Andorra" {{ request('location') == 'Andorra' ? 'selected' : '' }}>Andorra</option>
                            <option value="Angola" {{ request('location') == 'Angola' ? 'selected' : '' }}>Angola</option>
                            <option value="Argentina" {{ request('location') == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                            <option value="Armenia" {{ request('location') == 'Armenia' ? 'selected' : '' }}>Armenia</option>
                            <option value="Australia" {{ request('location') == 'Australia' ? 'selected' : '' }}>Australia</option>
                            <option value="Austria" {{ request('location') == 'Austria' ? 'selected' : '' }}>Austria</option>
                            <option value="Azerbaijan" {{ request('location') == 'Azerbaijan' ? 'selected' : '' }}>Azerbaijan</option>
                            <option value="Bahamas" {{ request('location') == 'Bahamas' ? 'selected' : '' }}>Bahamas</option>
                            <option value="Bahrain" {{ request('location') == 'Bahrain' ? 'selected' : '' }}>Bahrain</option>
                            <option value="Bangladesh" {{ request('location') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                            <option value="Barbados" {{ request('location') == 'Barbados' ? 'selected' : '' }}>Barbados</option>
                            <option value="Belarus" {{ request('location') == 'Belarus' ? 'selected' : '' }}>Belarus</option>
                            <option value="Belgium" {{ request('location') == 'Belgium' ? 'selected' : '' }}>Belgium</option>
                            <option value="Belize" {{ request('location') == 'Belize' ? 'selected' : '' }}>Belize</option>
                            <option value="Benin" {{ request('location') == 'Benin' ? 'selected' : '' }}>Benin</option>
                            <option value="Bhutan" {{ request('location') == 'Bhutan' ? 'selected' : '' }}>Bhutan</option>
                            <option value="Bolivia" {{ request('location') == 'Bolivia' ? 'selected' : '' }}>Bolivia</option>
                            <option value="Bosnia and Herzegovina" {{ request('location') == 'Bosnia and Herzegovina' ? 'selected' : '' }}>Bosnia and Herzegovina</option>
                            <option value="Botswana" {{ request('location') == 'Botswana' ? 'selected' : '' }}>Botswana</option>
                            <option value="Brazil" {{ request('location') == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                            <option value="Brunei" {{ request('location') == 'Brunei' ? 'selected' : '' }}>Brunei</option>
                            <option value="Bulgaria" {{ request('location') == 'Bulgaria' ? 'selected' : '' }}>Bulgaria</option>
                            <option value="Burkina Faso" {{ request('location') == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
                            <option value="Burundi" {{ request('location') == 'Burundi' ? 'selected' : '' }}>Burundi</option>
                            <option value="Cambodia" {{ request('location') == 'Cambodia' ? 'selected' : '' }}>Cambodia</option>
                            <option value="Cameroon" {{ request('location') == 'Cameroon' ? 'selected' : '' }}>Cameroon</option>
                            <option value="Canada" {{ request('location') == 'Canada' ? 'selected' : '' }}>Canada</option>
                            <option value="China" {{ request('location') == 'China' ? 'selected' : '' }}>China</option>
                            <option value="Colombia" {{ request('location') == 'Colombia' ? 'selected' : '' }}>Colombia</option>
                            <option value="Denmark" {{ request('location') == 'Denmark' ? 'selected' : '' }}>Denmark</option>
                            <option value="Egypt" {{ request('location') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                            <option value="Finland" {{ request('location') == 'Finland' ? 'selected' : '' }}>Finland</option>
                            <option value="France" {{ request('location') == 'France' ? 'selected' : '' }}>France</option>
                            <option value="Germany" {{ request('location') == 'Germany' ? 'selected' : '' }}>Germany</option>
                            <option value="Greece" {{ request('location') == 'Greece' ? 'selected' : '' }}>Greece</option>
                            <option value="Hong Kong" {{ request('location') == 'Hong Kong' ? 'selected' : '' }}>Hong Kong</option>
                            <option value="Hungary" {{ request('location') == 'Hungary' ? 'selected' : '' }}>Hungary</option>
                            <option value="Iceland" {{ request('location') == 'Iceland' ? 'selected' : '' }}>Iceland</option>
                            <option value="India" {{ request('location') == 'India' ? 'selected' : '' }}>India</option>
                            <option value="Indonesia" {{ request('location') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                            <option value="Iran" {{ request('location') == 'Iran' ? 'selected' : '' }}>Iran</option>
                            <option value="Iraq" {{ request('location') == 'Iraq' ? 'selected' : '' }}>Iraq</option>
                            <option value="Ireland" {{ request('location') == 'Ireland' ? 'selected' : '' }}>Ireland</option>
                            <option value="Israel" {{ request('location') == 'Israel' ? 'selected' : '' }}>Israel</option>
                            <option value="Italy" {{ request('location') == 'Italy' ? 'selected' : '' }}>Italy</option>
                            <option value="Jamaica" {{ request('location') == 'Jamaica' ? 'selected' : '' }}>Jamaica</option>
                            <option value="Japan" {{ request('location') == 'Japan' ? 'selected' : '' }}>Japan</option>
                            <option value="Jordan" {{ request('location') == 'Jordan' ? 'selected' : '' }}>Jordan</option>
                            <option value="Kazakhstan" {{ request('location') == 'Kazakhstan' ? 'selected' : '' }}>Kazakhstan</option>
                            <option value="Kenya" {{ request('location') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                            <option value="Kuwait" {{ request('location') == 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
                            <option value="Malaysia" {{ request('location') == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                            <option value="Maldives" {{ request('location') == 'Maldives' ? 'selected' : '' }}>Maldives</option>
                            <option value="Mexico" {{ request('location') == 'Mexico' ? 'selected' : '' }}>Mexico</option>
                            <option value="Morocco" {{ request('location') == 'Morocco' ? 'selected' : '' }}>Morocco</option>
                            <option value="Myanmar" {{ request('location') == 'Myanmar' ? 'selected' : '' }}>Myanmar</option>
                            <option value="Nepal" {{ request('location') == 'Nepal' ? 'selected' : '' }}>Nepal</option>
                            <option value="Netherlands" {{ request('location') == 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
                            <option value="New Zealand" {{ request('location') == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
                            <option value="Nigeria" {{ request('location') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                            <option value="Norway" {{ request('location') == 'Norway' ? 'selected' : '' }}>Norway</option>
                            <option value="Oman" {{ request('location') == 'Oman' ? 'selected' : '' }}>Oman</option>
                            <option value="Pakistan" {{ request('location') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                            <option value="Philippines" {{ request('location') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                            <option value="Poland" {{ request('location') == 'Poland' ? 'selected' : '' }}>Poland</option>
                            <option value="Portugal" {{ request('location') == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                            <option value="Qatar" {{ request('location') == 'Qatar' ? 'selected' : '' }}>Qatar</option>
                            <option value="Romania" {{ request('location') == 'Romania' ? 'selected' : '' }}>Romania</option>
                            <option value="Russia" {{ request('location') == 'Russia' ? 'selected' : '' }}>Russia</option>
                            <option value="Saudi Arabia" {{ request('location') == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                            <option value="Singapore" {{ request('location') == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                            <option value="South Africa" {{ request('location') == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                            <option value="South Korea" {{ request('location') == 'South Korea' ? 'selected' : '' }}>South Korea</option>
                            <option value="Spain" {{ request('location') == 'Spain' ? 'selected' : '' }}>Spain</option>
                            <option value="Sri Lanka" {{ request('location') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                            <option value="Sweden" {{ request('location') == 'Sweden' ? 'selected' : '' }}>Sweden</option>
                            <option value="Switzerland" {{ request('location') == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
                            <option value="Taiwan" {{ request('location') == 'Taiwan' ? 'selected' : '' }}>Taiwan</option>
                            <option value="Thailand" {{ request('location') == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                            <option value="Turkey" {{ request('location') == 'Turkey' ? 'selected' : '' }}>Turkey</option>
                            <option value="Ukraine" {{ request('location') == 'Ukraine' ? 'selected' : '' }}>Ukraine</option>
                            <option value="United Arab Emirates" {{ request('location') == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                            <option value="United Kingdom" {{ request('location') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                            <option value="United States" {{ request('location') == 'United States' ? 'selected' : '' }}>United States</option>
                            <option value="Vietnam" {{ request('location') == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                            <option value="Yemen" {{ request('location') == 'Yemen' ? 'selected' : '' }}>Yemen</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="nature_of_business" class="form-label">Nature of Business</label>
                        <select class="form-control" id="nature_of_business" name="nature_of_business">
                            <option value="">All Business Types</option>
                            <option value="Manufacturing" {{ request('nature_of_business') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                            <option value="Construction" {{ request('nature_of_business') == 'Construction' ? 'selected' : '' }}>Construction</option>
                            <option value="Real Estate" {{ request('nature_of_business') == 'Real Estate' ? 'selected' : '' }}>Real Estate</option>
                            <option value="Technology" {{ request('nature_of_business') == 'Technology' ? 'selected' : '' }}>Technology</option>
                            <option value="Consulting" {{ request('nature_of_business') == 'Consulting' ? 'selected' : '' }}>Consulting</option>
                            <option value="Education" {{ request('nature_of_business') == 'Education' ? 'selected' : '' }}>Education</option>
                            <option value="Healthcare" {{ request('nature_of_business') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                            <option value="Retail" {{ request('nature_of_business') == 'Retail' ? 'selected' : '' }}>Retail</option>
                            <option value="Other" {{ request('nature_of_business') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn flex-grow-1" style="background-color: #ff9900; color: white;">
                                <i class="fas fa-search me-2"></i>Apply Filters
                            </button>
                            @if(request('location') || request('nature_of_business'))
                                <a href="{{ route('client.community.profile-matching') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Clear
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">
            @forelse($users as $user)
                <div class="col-md-4">
                    <div class="card card-profile p-3 text-center bg-white">
                        @if($user['job_title'] !== 'Not provided' || $user['about_me'] !== 'No description available')
                            <div class="profile-image-container">
                                <img src="{{ $user['avatar'] }}" alt="{{ $user['full_name'] }}'s Profile Picture">
                            </div>
                            <h5 class="mt-3 mb-1">{{ $user['full_name'] }}</h5>
                            <p class="mb-1 text-muted">{{ $user['job_title'] }}</p>
                            <p class="text-secondary small">{{ Str::limit($user['about_me'], 100) }}</p>
                            <div class="d-flex gap-2 mt-auto">
                                <button type="button" class="btn" style="background-color: #ff9900; color: white;" onclick='showProfileModal(@json($user))'>
                                    <i class="fas fa-user me-2"></i>View Profile
                                </button>
                                <button class="btn connection-request-btn" style="border: 2px solid #ff9900; color: #ff9900; background-color: transparent;" data-user-id="{{ $user['id'] }}">
                                    <span class="btn-text"><i class="fas fa-user-plus me-2"></i>Send Connection Request</span>
                                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                </button>
                            </div>
                        @else
                            <div class="compact-profile">
                                <div class="profile-image-container mb-2">
                                    <img src="{{ $user['avatar'] }}" alt="{{ $user['full_name'] }}'s Profile Picture">
                                </div>
                                <h5 class="mb-3">{{ $user['full_name'] }}</h5>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #ff9900; color: white;" onclick='showProfileModal(@json($user))'>
                                        <i class="fas fa-user me-2"></i>View Profile
                                    </button>
                                    <button class="btn connection-request-btn" style="border: 2px solid #ff9900; color: #ff9900; background-color: transparent;" data-user-id="{{ $user['id'] }}">
                                        <span class="btn-text"><i class="fas fa-user-plus me-2"></i>Send Connection Request</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    </button>
                                </div>
                            </div>
                        @endif
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
                                <button class="nav-link active" id="about-tab" data-bs-toggle="tab" data-bs-target="#about-tab-pane" type="button" role="tab" aria-controls="about-tab-pane" aria-selected="true">
                                    <i class="fas fa-user me-2"></i>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                                    <i class="fas fa-address-book me-2"></i>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="professional-tab" data-bs-toggle="tab" data-bs-target="#professional-tab-pane" type="button" role="tab" aria-controls="professional-tab-pane" aria-selected="false">
                                    <i class="fas fa-briefcase me-2"></i>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="location-tab" data-bs-toggle="tab" data-bs-target="#location-tab-pane" type="button" role="tab" aria-controls="location-tab-pane" aria-selected="false">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                </button>
                            </li>
                        </ul>

                        <!-- Tabs Content -->
                        <div class="tab-content pt-4" id="profileTabsContent">
                            <!-- About Tab -->
                            <div class="tab-pane fade show active" id="about-tab-pane" role="tabpanel" aria-labelledby="about-tab" tabindex="0">
                                <p id="modalAboutMe" class="text-muted"></p>
                            </div>

                            <!-- Contact & Social Tab -->
                            <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
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
                            <div class="tab-pane fade" id="professional-tab-pane" role="tabpanel" aria-labelledby="professional-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Category:</strong> <span id="modalCategory"></span></p>
                                        <p class="mb-2"><strong>Organization:</strong> <span id="modalOrganization"></span></p>
                                        <p class="mb-2"><strong>Nature of Business:</strong> <span id="modalNatureOfBusiness"></span></p>
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
                            <div class="tab-pane fade" id="location-tab-pane" role="tabpanel" aria-labelledby="location-tab" tabindex="0">
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
    height: 100%;
    display: flex;
    flex-direction: column;
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

.compact-profile {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
    padding: 1rem 0;
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
    background-color: #FFA726 !important;
    border-color: #FFA726 !important;
    color: white !important;
}

.connection-request-btn.connected {
    background-color: #66BB6A !important;
    border-color: #66BB6A !important;
    color: white !important;
}

.connection-request-btn.rejected {
    background-color: #EF5350 !important;
    border-color: #EF5350 !important;
    color: white !important;
}

.connection-request-btn:hover {
    background-color: #ff9900 !important;
    border-color: #ff9900 !important;
    color: white !important;
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
    document.getElementById('modalEmail').textContent = user.email || 'Not provided';
    document.getElementById('modalPhone').textContent = user.mobile_number || 'Not provided';
    document.getElementById('modalWebsite').textContent = user.website || 'Not provided';
    
    // Professional details
    document.getElementById('modalCategory').textContent = user.category || 'Not specified';
    document.getElementById('modalOrganization').textContent = user.organization || 'Not specified';
    document.getElementById('modalNatureOfBusiness').textContent = user.nature_of_business || 'Not specified';
    document.getElementById('modalAcademicInstitution').textContent = user.academic_institution || 'Not specified';
    document.getElementById('modalStudentId').textContent = user.student_id || 'Not specified';
    document.getElementById('modalImpactNumber').textContent = user.impact_number || 'Not specified';
    document.getElementById('modalGreenCard').textContent = user.green_card || 'Not specified';
    
    // Location - Handle empty fields with appropriate messages
    const address = user.address || 'Address not provided';
    const cityState = [
        user.city,
        user.state,
        user.postal_code
    ].filter(Boolean).join(', ') || 'City/State not provided';
    const country = user.country || 'Country not provided';

    document.getElementById('modalAddress').textContent = address;
    document.getElementById('modalCityState').textContent = cityState;
    document.getElementById('modalCountry').textContent = country;

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