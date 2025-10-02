@extends('client.layouts.app')

@section('title', 'Affiliate Link Details')

@push('styles')
<style>
    html {
        scroll-behavior: smooth;
    }

    :root {
        --primary-blue: #2563eb;
        --primary-dark: #1e40af;
        --bg-light-gray: #f8fafc;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --mobile-vh: 100vh;
    }

    body {
        margin: 0;
        padding: 0;
    }

    .content-section {
        min-height: 100vh;
        min-height: 100svh;
        padding: 2rem 1.5rem;
        background-color: #fff;
        box-sizing: border-box;
    }

    .content-section .container-fluid {
        height: 100%;
        max-width: 1920px;
        margin: 0 auto;
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
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section-store">
    <h1 class="hero-title-store">{{ $affiliate->name ?: 'Affiliate Link Details' }}</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <a href="{{ route('affiliate.index') }}">Affiliate Links</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Details</span>
    </div>
</section>

<!-- Store Section -->
<section id="storeSection" class="store-section">
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>{{ $affiliate->name ?: 'Affiliate Link Details' }}</h2>
                <div>
                    <a href="{{ route('affiliate.edit', $affiliate) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('affiliate.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Links
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Link Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Affiliate Code:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $affiliate->affiliate_code }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('{{ $affiliate->affiliate_code }}')">
                                        <i class="fas fa-copy"></i> Copy Code
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Affiliate Link:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $affiliate->affiliate_link }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('{{ $affiliate->affiliate_link }}')">
                                        <i class="fas fa-copy"></i> Copy Link
                                    </button>
                                </div>
                                <div class="form-text">Share this link with others to start tracking referrals!</div>
                            </div>

                            @if($affiliate->description)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description:</label>
                                    <p class="form-control-plaintext">{{ $affiliate->description }}</p>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status:</label>
                                <span class="badge {{ $affiliate->is_active ? 'bg-success' : 'bg-secondary' }} fs-6">
                                    {{ $affiliate->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Created:</label>
                                <p class="form-control-plaintext">{{ $affiliate->created_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-12 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="h2 text-primary mb-0">{{ $affiliate->total_clicks }}</div>
                                        <small class="text-muted">Total Clicks</small>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="h2 text-success mb-0">{{ $affiliate->total_conversions }}</div>
                                        <small class="text-muted">Conversions</small>
                                    </div>
                                </div>
                            </div>

                            @if($affiliate->total_clicks > 0)
                                <div class="mt-3">
                                    <label class="form-label fw-bold">Conversion Rate:</label>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: {{ ($affiliate->total_conversions / $affiliate->total_clicks) * 100 }}%">
                                            {{ number_format(($affiliate->total_conversions / $affiliate->total_clicks) * 100, 1) }}%
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">Referral Tracking Info</h6>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-2">
                                <strong>Tracking:</strong> All referrals through your link are tracked and attributed to you
                            </p>
                            <p class="small text-muted mb-0">
                                <strong>Analytics:</strong> View detailed statistics about clicks, conversions, and referral performance.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show a temporary success message
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i> Copied!';
        button.classList.add('btn-success');
        button.classList.remove('btn-outline-secondary');
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
    });
}

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
