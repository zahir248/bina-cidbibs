@extends('client.layouts.app')

@section('title', 'Create Affiliate Link')

@push('styles')
<style>
    :root {
        --primary-blue: #2563eb;
        --primary-dark: #1e40af;
        --bg-light-gray: #f8fafc;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --accent-orange: #ff9800;
    }

    /* Enhanced Hero Section for Better Mobile Support */
    .hero-section-store {
        /* Use multiple viewport units for maximum compatibility */
        min-height: 100vh;
        min-height: 100svh; /* Small viewport height */
        min-height: 100dvh; /* Dynamic viewport height */
        height: 100vh;
        height: 100svh;
        height: 100dvh;
        
        width: 100%;
        
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('images/hero-section.png') }}') no-repeat center center;
        background-size: cover;
        background-attachment: scroll; /* Better for mobile */
        
        text-align: center;
        position: relative;
        
        padding: 0 1.5rem;
        box-sizing: border-box;
        margin: 0;
        
        /* Ensure it's always above other content */
        z-index: 1;
        
        /* Handle potential browser UI interference */
        overflow: hidden;
    }

    /* Fix for iOS Safari and other mobile browsers */
    @supports (-webkit-touch-callout: none) {
        .hero-section-store {
            /* iOS Safari specific */
            min-height: -webkit-fill-available;
            height: -webkit-fill-available;
        }
    }

    /* Enhanced title styling */
    .hero-title-store {
        font-size: clamp(2rem, 8vw, 4rem); /* Responsive font size */
        font-weight: 800;
        color: #fff;
        margin-bottom: 1rem;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        
        /* Prevent text from being too small on very small screens */
        min-font-size: 1.75rem;
    }

    /* Enhanced breadcrumb styling */
    .breadcrumb-store {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        color: #fff;
        font-size: clamp(1rem, 3vw, 1.25rem); /* Responsive font size */
        font-weight: 500;
        flex-wrap: wrap;
        
        /* Ensure it doesn't get too small */
        min-font-size: 0.9rem;
    }

    .breadcrumb-store a {
        color: #fff;
        text-decoration: none;
        opacity: 0.85;
        transition: opacity 0.2s;
    }

    .breadcrumb-store a:hover {
        opacity: 1;
        text-decoration: underline;
    }

    .breadcrumb-separator {
        color: #fff;
        opacity: 0.7;
        font-size: 1.2em;
    }

    /* Mobile-specific adjustments */
    @media screen and (max-width: 992px) {
        .hero-section-store {
            /* Ensure full height on tablets */
            min-height: 100vh;
            min-height: 100svh;
            height: 100vh;
            padding: 0 1rem;
        }
    }

    @media screen and (max-width: 768px) {
        .hero-section-store {
            /* Adjust for mobile landscape */
            min-height: 100vh;
            min-height: 100svh;
            min-height: 100dvh;
            height: 100vh;
            height: 100svh;
            height: 100dvh;
            padding: 0 1rem;
        }
        
        /* Ensure content is centered even on very wide mobile screens */
        .hero-title-store {
            max-width: 90vw;
            word-wrap: break-word;
        }
    }

    @media screen and (max-width: 576px) {
        .hero-section-store {
            /* Mobile portrait - ensure full screen coverage */
            min-height: 100vh;
            min-height: 100svh;
            min-height: 100dvh;
            height: 100vh;
            height: 100svh;
            height: 100dvh;
            
            padding: 0 0.75rem;
            
            /* Handle notches on newer phones */
            padding-top: env(safe-area-inset-top, 0);
            padding-bottom: env(safe-area-inset-bottom, 0);
            padding-left: max(0.75rem, env(safe-area-inset-left));
            padding-right: max(0.75rem, env(safe-area-inset-right));
        }
    }

    /* Very small screens (older phones) */
    @media screen and (max-width: 375px) {
        .hero-section-store {
            padding: 0 0.5rem;
            min-height: 100vh;
            height: 100vh;
        }
        
        .hero-title-store {
            font-size: 1.75rem;
            line-height: 1.2;
        }
        
        .breadcrumb-store {
            font-size: 0.9rem;
        }
    }

    /* Landscape mobile devices */
    @media screen and (max-height: 500px) and (orientation: landscape) {
        .hero-section-store {
            min-height: 100vh;
            height: 100vh;
            padding: 1rem;
            justify-content: center;
        }
        
        .hero-title-store {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .breadcrumb-store {
            font-size: 1rem;
        }
    }

    /* Fix for browsers that don't handle vh well on mobile */
    @media screen and (max-width: 768px) {
        .hero-section-store {
            position: relative;
        }
        
        /* Fallback using JavaScript will be applied here */
        .hero-section-store.js-mobile-vh {
            height: var(--vh, 100vh);
            min-height: var(--vh, 100vh);
        }
    }

    /* Store Section */
    .store-section {
        padding: 60px 0;
        min-height: 100vh;
        background: #f8fafc;
    }

    .form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .form-card-header {
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .form-card-header h4 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
    }

    .form-card-body {
        padding: 3rem;
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        display: block;
        font-size: 1.1rem;
    }

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-control:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: white;
    }

    .form-text {
        font-size: 0.9rem;
        color: var(--text-light);
        margin-top: 0.5rem;
    }

    .info-card {
        background: linear-gradient(135deg, #e0f2fe, #f0f9ff);
        border: 1px solid #bae6fd;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .info-card h6 {
        color: var(--primary-blue);
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-card ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    .info-card li {
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }

    .btn-custom {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-custom {
        background: var(--primary-blue);
        color: white;
    }

    .btn-primary-custom:hover {
        background: var(--primary-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
    }

    .btn-secondary-custom {
        background: #6b7280;
        color: white;
    }

    .btn-secondary-custom:hover {
        background: #4b5563;
        color: white;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .affiliate-hero h1 {
            font-size: 2.5rem;
        }
        
        .form-card-body {
            padding: 2rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section-store">
    <h1 class="hero-title-store">Create New Affiliate Link</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <a href="{{ route('affiliate.index') }}">Affiliate Links</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Create New</span>
    </div>
</section>

<!-- Store Section -->
<section id="storeSection" class="store-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    <div class="form-card-header">
                        <h4>Create New Affiliate Link</h4>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('affiliate.store') }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="name" class="form-label">Link Name (Optional)</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="e.g., Social Media Campaign">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Give your affiliate link a memorable name for easy identification.</div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">Description (Optional)</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3" 
                                          placeholder="Describe where you'll be sharing this link...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Add a description to help you remember where you'll use this link.</div>
                            </div>

                            <div class="info-card">
                                <h6><i class="fas fa-info-circle"></i> How it works:</h6>
                                <ul>
                                    <li>You'll get a unique affiliate code and link</li>
                                    <li>Share your link with others</li>
                                    <li>When someone purchases tickets using your link, you can track the referral</li>
                                    <li>Track your clicks, conversions, and referrals in real-time</li>
                                </ul>
                            </div>

                            <div class="d-flex justify-content-between flex-wrap gap-3">
                                <a href="{{ route('affiliate.index') }}" class="btn-custom btn-secondary-custom">
                                    <i class="fas fa-arrow-left"></i> Back to Links
                                </a>
                                <button type="submit" class="btn-custom btn-primary-custom">
                                    <i class="fas fa-plus"></i> Create Link
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('affiliateForm');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const submitBtn = document.getElementById('submitBtn');
    
    // Auto-generate description based on name
    nameInput.addEventListener('input', function() {
        if (this.value.trim() && !descriptionInput.value.trim()) {
            descriptionInput.value = `Affiliate link for ${this.value}`;
        }
    });
    
    // Form validation
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        if (!nameInput.value.trim()) {
            showAlert('Please enter a name for your affiliate link.', 'error');
            nameInput.focus();
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
        
        // Submit form
        this.submit();
    });
    
    function showAlert(message, type) {
        // Remove existing alerts
        const existingAlert = document.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        // Create new alert
        const alert = document.createElement('div');
        alert.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Insert after form header
        const formHeader = document.querySelector('.form-card-header');
        formHeader.insertAdjacentElement('afterend', alert);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
});

// Mobile viewport height fix
document.addEventListener('DOMContentLoaded', function() {
    function setMobileVH() {
        // Get the viewport height
        const vh = window.innerHeight * 0.01;
        
        // Set CSS custom property
        document.documentElement.style.setProperty('--vh', `${vh}px`);
        document.documentElement.style.setProperty('--mobile-vh', `${window.innerHeight}px`);
        
        // Apply to hero sections
        const heroSections = document.querySelectorAll('.hero-section-store');
        heroSections.forEach(section => {
            section.classList.add('js-mobile-vh');
            section.style.height = `${window.innerHeight}px`;
            section.style.minHeight = `${window.innerHeight}px`;
        });
    }
    
    // Function to handle resize events
    function handleResize() {
        // Debounce resize events
        clearTimeout(window.resizeTimeout);
        window.resizeTimeout = setTimeout(setMobileVH, 100);
    }
    
    // Set initial viewport height
    setMobileVH();
    
    // Listen for resize events
    window.addEventListener('resize', handleResize);
    
    // Listen for orientation change
    window.addEventListener('orientationchange', function() {
        setTimeout(setMobileVH, 500);
    });
    
    // Additional fix for iOS Safari
    if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
        window.addEventListener('scroll', function() {
            setMobileVH();
        }, { passive: true });
    }
});
</script>
@endsection
