@extends('client.layouts.app')

@section('title', 'My Affiliate Links')

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

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-blue), var(--accent-orange));
        border-radius: 2px;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: var(--text-light);
        max-width: 600px;
        margin: 0 auto;
    }

    /* Card Styles */
    .affiliate-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
        height: 100%;
    }

    .affiliate-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .affiliate-card-header {
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
        color: white;
        padding: 1.5rem;
        position: relative;
    }

    .affiliate-card-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 20px;
        background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.1));
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .status-badge {
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background: rgba(34, 197, 94, 0.2);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-inactive {
        background: rgba(107, 114, 128, 0.2);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.3);
    }

    .affiliate-card-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        display: block;
    }

    .input-group {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        border: none;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        background: #f8fafc;
    }

    .form-control:focus {
        box-shadow: none;
        background: white;
    }

    .btn-copy {
        background: var(--primary-blue);
        border: none;
        color: white;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .btn-copy:hover {
        background: var(--primary-dark);
        transform: scale(1.05);
    }

    .btn-copy.copied {
        background: #16a34a;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .stat-box {
        text-align: center;
        padding: 1rem;
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-radius: 15px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-blue);
        display: block;
        margin-bottom: 0.25rem;
    }

    .stat-text {
        font-size: 0.8rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .affiliate-card-footer {
        padding: 1.5rem 2rem;
        background: #f8fafc;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .btn-group-custom {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-custom {
        flex: 1;
        min-width: 80px;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary-custom {
        background: var(--primary-blue);
        color: white;
    }

    .btn-primary-custom:hover {
        background: var(--primary-dark);
        color: white;
        transform: translateY(-2px);
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

    .btn-danger-custom {
        background: #dc2626;
        color: white;
    }

    .btn-danger-custom:hover {
        background: #b91c1c;
        color: white;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .empty-state-icon {
        font-size: 4rem;
        color: var(--text-light);
        margin-bottom: 1.5rem;
    }

    .empty-state h4 {
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: var(--text-light);
        margin-bottom: 2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .affiliate-hero h1 {
            font-size: 2.5rem;
        }
        
        .affiliate-stats {
            gap: 1rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .btn-group-custom {
            flex-direction: column;
        }
    }
    
    /* Create New Link Button Styling */
    .create-link-btn {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%) !important;
        border: none !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3) !important;
        transition: all 0.3s ease !important;
        font-weight: 600 !important;
        letter-spacing: 0.5px !important;
        text-decoration: none !important;
    }
    
    .create-link-btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4) !important;
        background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%) !important;
        color: white !important;
        text-decoration: none !important;
    }
    
    .create-link-btn:active {
        transform: translateY(0) !important;
        color: white !important;
    }
    
    .create-link-btn:focus {
        color: white !important;
        text-decoration: none !important;
    }
    
    .create-link-btn i {
        color: white !important;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section-store">
    <h1 class="hero-title-store">My Affiliate Links</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Affiliate Links</span>
    </div>
</section>

<!-- Store Section -->
<section id="storeSection" class="store-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Your Affiliate Links</h2>
            <p class="section-subtitle">Manage your affiliate links and track their performance in real-time</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Create New Link Button -->
        <div class="text-center mb-4">
            <a href="{{ route('affiliate.create') }}" class="btn btn-primary btn-lg px-4 py-3 rounded-pill create-link-btn">
                <i class="fas fa-plus me-2"></i> Create New Link
            </a>
        </div>

        @if($affiliates->count() > 0)
            <div class="row">
                @foreach($affiliates as $affiliate)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="affiliate-card">
                            <div class="affiliate-card-header">
                                <h5 class="card-title">
                                    {{ $affiliate->name ?: 'Affiliate Link' }}
                                    <span class="status-badge {{ $affiliate->is_active ? 'status-active' : 'status-inactive' }}">
                                        {{ $affiliate->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </h5>
                            </div>
                            <div class="affiliate-card-body">
                                <div class="form-group">
                                    <label class="form-label">Affiliate Code:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $affiliate->affiliate_code }}" readonly>
                                        <button class="btn btn-copy" type="button" onclick="copyToClipboard('{{ $affiliate->affiliate_code }}', this)">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Affiliate Link:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $affiliate->affiliate_link }}" readonly>
                                        <button class="btn btn-copy" type="button" onclick="copyToClipboard('{{ $affiliate->affiliate_link }}', this)">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>

                                @if($affiliate->description)
                                    <p class="text-muted mb-3">{{ $affiliate->description }}</p>
                                @endif

                                <div class="stats-grid">
                                    <div class="stat-box">
                                        <span class="stat-value">{{ $affiliate->total_clicks }}</span>
                                        <div class="stat-text">Clicks</div>
                                    </div>
                                    <div class="stat-box">
                                        <span class="stat-value">{{ $affiliate->total_conversions }}</span>
                                        <div class="stat-text">Conversions</div>
                                    </div>
                                </div>
                            </div>
                            <div class="affiliate-card-footer">
                                <div class="btn-group-custom">
                                    <a href="{{ route('affiliate.show', $affiliate) }}" class="btn-custom btn-primary-custom">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                    <a href="{{ route('affiliate.edit', $affiliate) }}" class="btn-custom btn-secondary-custom">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('affiliate.destroy', $affiliate) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-custom btn-danger-custom" 
                                                onclick="return confirm('Are you sure you want to delete this affiliate link?')">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-link empty-state-icon"></i>
                <h4>No affiliate links yet</h4>
                <p>Create your first affiliate link to start tracking referrals and growing your network with BINA 2025!</p>
                <a href="{{ route('affiliate.create') }}" class="btn btn-primary btn-lg px-4 py-3 rounded-pill">
                    <i class="fas fa-plus me-2"></i> Create Your First Link
                </a>
            </div>
        @endif
    </div>
</section>

<script>
function copyToClipboard(text, button) {
    navigator.clipboard.writeText(text).then(function() {
        // Show a temporary success message
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i>';
        button.classList.add('copied');
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('copied');
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            const originalHTML = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check"></i>';
            button.classList.add('copied');
            
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('copied');
            }, 2000);
        } catch (err) {
            console.error('Fallback copy failed: ', err);
        }
        document.body.removeChild(textArea);
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
