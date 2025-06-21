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

<!-- About Section -->
<section class="content-section about-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="section-title">About Our Community</h2>
                <div class="section-divider"></div>
                <p class="section-description">Bina Community is a platform designed to connect local talents with opportunities in their area. Whether you're looking for work, seeking to hire, or wanting to collaborate on projects, our community brings people together.</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="content-section features-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center mb-5">
                <h2 class="section-title">Why Join Our Community?</h2>
                <div class="section-divider"></div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Connect with Professionals</h3>
                    <p>Build meaningful connections with industry experts and like-minded professionals in your field.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3>Career Opportunities</h3>
                    <p>Discover exciting job opportunities and career advancement possibilities within the community.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3>Knowledge Sharing</h3>
                    <p>Learn from peers, share experiences, and grow together through collaborative learning.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="content-section cta-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="section-title">Ready to Get Started?</h2>
                <div class="section-divider"></div>
                <p class="section-description mb-4">Join thousands of community members who have already found success through our platform.</p>
                <div class="cta-buttons">
                    <a href="{{ route('client.community.profile-matching') }}" class="btn btn-lg me-3" style="background-color: #ff9900; color: white;">Explore Matches</a>
                    <a href="{{ route('client.profile') }}" class="btn btn-outline-light btn-lg">Complete Profile</a>
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
    padding: 100px 0;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #333;
}

.section-divider {
    width: 80px;
    height: 4px;
    background: #ff6b00;
    margin: 1.5rem auto;
    border-radius: 2px;
}

.section-description {
    font-size: 1.1rem;
    color: #666;
    line-height: 1.8;
}

/* Feature Cards */
.features-section {
    background-color: #f8f9fa;
}

.feature-card {
    background: #fff;
    padding: 2rem;
    border-radius: 15px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.feature-icon {
    font-size: 2.5rem;
    color: #ff9900;
    margin-bottom: 1.5rem;
}

.feature-card h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: #333;
}

.feature-card p {
    color: #666;
    margin-bottom: 0;
}

/* Stats Section */
.stats-section {
    background-color: #fff;
}

.stat-card {
    text-align: center;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 15px;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-number {
    font-size: 3rem;
    font-weight: 700;
    color: #ff6b00;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1.1rem;
    color: #666;
}

/* About Section */
.about-section {
    background-color: #ffffff;
}

/* CTA Section */
.cta-section {
    background-color: #1a1a1a;
    margin-bottom: -100px;
    padding-bottom: 100px;
}

.cta-section .section-title {
    color: #ffffff;
}

.cta-section .section-description {
    color: #f1f1f1;
}

.cta-section .section-divider {
    background: #ff6b00;
}

.btn-orange {
    background-color: #ff6b00;
    border-color: #ff6b00;
    color: white;
    transition: all 0.3s ease;
    padding: 0.75rem 2rem;
}

.btn-orange:hover {
    background-color: #e65c00;
    border-color: #e65c00;
    color: white;
    transform: translateY(-2px);
}

/* Modal Styles */
.modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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

    .section-title {
        font-size: 2rem;
    }

    .stat-number {
        font-size: 2.5rem;
    }

    .cta-buttons .btn {
        display: block;
        width: 100%;
        margin: 0.5rem 0;
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

    // Add animation on scroll
    function revealOnScroll() {
        var elements = document.querySelectorAll('.feature-card, .stat-card');
        elements.forEach(function(element) {
            var elementTop = element.getBoundingClientRect().top;
            var elementVisible = 150;
            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('visible');
            }
        });
    }

    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll();
});
</script>
@endsection