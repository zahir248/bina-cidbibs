@extends('client.community.layouts.app')

@section('title', 'Home | BINA Community')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1 class="display-4 fw-bold">BINA COMMUNITY</h1>
        <p class="lead">Connecting talents and opportunities within the local community.</p>
    </div>
</section>

<!-- Demo Content Section -->
<section class="content-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2 class="text-center mb-4">About Our Community</h2>
                <p>Bina Community is a platform designed to connect local talents with opportunities in their area. Whether you're looking for work, seeking to hire, or wanting to collaborate on projects, our community brings people together.</p>
                <p>Our advanced profile matching system helps you find the perfect connections based on skills, interests, and location. Join thousands of community members who have already found success through our platform.</p>
                <div class="text-center mt-4">
                    <a href="{{ route('client.community.profile-matching') }}" class="btn btn-orange">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Profile Completion Modal -->
<div class="modal fade" id="profileCompletionModal" tabindex="-1" aria-labelledby="profileCompletionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 py-4">
                <h3 class="fw-bold mb-3">Complete Your Profile</h3>
                <p class="text-muted mb-4">Your profile is incomplete. A complete profile helps you:</p>
                <ul class="list-unstyled text-start mb-4">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Get matched with relevant opportunities</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Connect with like-minded professionals</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Showcase your skills and experience</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Stand out in the community</li>
                </ul>
                <div class="d-grid gap-2">
                    <a href="{{ route('client.profile') }}" class="btn btn-orange btn-lg">Complete Profile Now</a>
                    <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">Remind Me Later</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.hero {
    height: 100vh;
    min-height: 100vh;
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("{{ asset('images/hero-section.png') }}") no-repeat center center;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    margin-top: -76px;
}

.hero h1,
.hero .lead {
    color: #ffffff;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.content-section {
    padding: 80px 0;
    background-color: #f8f9fa;
}

/* Modal Styles */
.modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.btn-orange {
    background-color: #ff6b00;
    border-color: #ff6b00;
    color: white;
    transition: all 0.3s ease;
}

.btn-orange:hover {
    background-color: #e65c00;
    border-color: #e65c00;
    color: white;
}

@media (max-width: 768px) {
    .hero {
        min-height: 100vh;
        min-height: 100dvh;
        padding: 80px 15px 20px;
    }
    
    .hero h1 {
        font-size: 2.5rem;
    }
    
    .hero .lead {
        font-size: 1.1rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if user has a profile
    @if(!$profile)
        // Show the modal
        var profileModal = new bootstrap.Modal(document.getElementById('profileCompletionModal'));
        profileModal.show();
    @endif
});
</script>
@endsection