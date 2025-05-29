@extends('client.layouts.app')

@section('title', 'BINA | Store')

@push('styles')
<style>
    :root {
        --primary-blue: #2563eb;
        --primary-dark: #1e40af;
        --bg-light-gray: #f8fafc;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --mobile-vh: 100vh;
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
        
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('images/hero-hero-section.png') }}') no-repeat center center;
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

    /* Ensure the hero section starts from the very top */
    body {
        margin: 0;
        padding: 0;
    }

    .hero-section-store {
        margin-top: 0;
        position: relative;
        top: 0;
    }

    /* Store Section */
    .store-section {
        padding: 60px 2rem 60px 2rem;
        background-color: transparent;
        position: relative;
        z-index: 10;
        margin-top: 0;
    }

    /* Announcement Section Styles */
    .announcement-section {
        background: #ffa000;
        padding: 1.5rem;
        margin: 0 auto 3.5rem;
        max-width: 1400px;
        box-shadow: 0 6px 24px 0 rgba(255, 152, 0, 0.12), 0 1.5px 6px 0 rgba(0,0,0,0.08);
        border-radius: 16px;
        border: 1.5px solid #ff9800;
    }

    .announcement-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        color: white;
    }

    .announcement-icon {
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #fff3cd 0%, #ffe082 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(255,193,7,0.10);
    }

    .announcement-icon i {
        font-size: 1.7rem;
        color: #ff9800;
    }

    .announcement-text {
        flex-grow: 1;
        font-size: 1.1rem;
        line-height: 1.5;
    }

    .announcement-text strong {
        font-weight: 600;
    }

    .announcement-contact {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-top: 0.75rem;
        font-size: 0.95rem;
    }

    .announcement-contact a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: opacity 0.2s;
    }

    .announcement-contact a:hover {
        opacity: 0.9;
    }

    .announcement-contact i {
        width: 20px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .announcement-section {
            margin: 0 1rem 2rem;
        }

        .announcement-content {
            flex-direction: column;
            text-align: center;
        }

        .announcement-contact {
            align-items: center;
        }
    }

    .store-container {
        display: flex;
        gap: 2.5rem;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .store-sidebar {
        flex: 0 0 270px;
        background: transparent;
        display: flex;
        flex-direction: column;
        gap: 2.5rem;
    }

    /* Updated Single Price Slider Styles */
    .price-slider-container {
        margin-bottom: 2.5rem;
    }

    .price-filter-title {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        color: var(--text-dark);
        letter-spacing: 0.5px;
    }

    .price-display {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 1rem;
        gap: 0.5rem;
    }

    .price-value {
        font-weight: 600;
        color: orange;
        background: #fff;
        padding: 0.5rem 1.25rem;
        border-radius: 1.5rem;
        font-size: 1.1rem;
        box-shadow: orange;
        border: 2px solid orange;
        min-width: 100px;
        text-align: center;
    }

    .price-slider {
        width: 100%;
        height: 8px;
        border-radius: 4px;
        background: #e2e8f0;
        outline: none;
        -webkit-appearance: none;
        appearance: none;
        cursor: pointer;
        margin: 1rem 0;
    }

    .price-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: orange;
        cursor: pointer;
        border: 3px solid #fff;
        box-shadow: 0 2px 8px rgba(37,99,235,0.3);
        transition: all 0.2s ease;
    }

    .price-slider::-webkit-slider-thumb:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(37,99,235,0.4);
    }

    .price-slider::-moz-range-thumb {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: var(--primary-blue);
        cursor: pointer;
        border: 3px solid #fff;
        box-shadow: 0 2px 8px rgba(37,99,235,0.3);
        transition: all 0.2s ease;
    }

    .price-slider::-moz-range-thumb:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(37,99,235,0.4);
    }

    .price-range-info {
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
        color: var(--text-light);
        margin-top: 0.5rem;
    }

    .store-categories {
        margin-top: 1.5rem;
    }

    .categories-title {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        color: var(--text-dark);
        letter-spacing: 0.5px;
    }

    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category-item {
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .category-checkbox {
        width: 20px;
        height: 20px;
        accent-color: var(--primary-blue);
    }

    .category-label {
        font-size: 1rem;
        color: var(--text-dark);
        cursor: pointer;
    }

    /* Product Grid */
    .store-products {
        flex: 1 1 0%;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 2rem;
    }

    .product-card {
        background: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .product-card:hover {
        box-shadow: 0 8px 24px rgba(37,99,235,0.12);
        transform: translateY(-4px) scale(1.02);
    }
    .product-image {
        width: 100%;
        aspect-ratio: 1/1;
        object-fit: cover;
        background: #f1f1f1;
    }
    .product-info {
        padding: 1.25rem 1rem 1rem 1rem;
        width: 100%;
    }
    .product-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #111a3a;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .product-price {
        color: #bfa600;
        font-weight: 600;
        font-size: 1.05rem;
        margin-bottom: 0.5rem;
    }
    .product-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        font-size: 1rem;
    }
    .product-meta i {
        color: #64748b;
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .store-container {
            flex-direction: column;
            gap: 2rem;
            padding: 0 1rem;
        }
        .store-sidebar {
            flex-direction: row;
            gap: 2rem;
            flex-wrap: wrap;
        }
        .store-categories {
            margin-top: 0;
        }
    }
    @media (max-width: 768px) {
        .store-container {
            flex-direction: column;
            gap: 1.5rem;
            padding: 0 0.5rem;
        }
        .store-sidebar {
            flex-direction: column;
            gap: 1.5rem;
            width: 100%;
        }
        .store-products {
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
    }
    @media (max-width: 576px) {
        .store-products {
            grid-template-columns: 1fr;
        }
        .store-sidebar {
            width: 100%;
        }
    }

    /* Additional mobile device classes */
    .is-mobile .hero-section-store {
        min-height: 100vh;
        height: 100vh;
    }

    .is-ios .hero-section-store {
        min-height: -webkit-fill-available;
        height: -webkit-fill-available;
    }

    .is-android .hero-section-store {
        min-height: 100vh;
        height: 100vh;
    }

    html, body {
        overflow-x: hidden;
    }

    .modal-header .btn-close {
        filter: invert(1) grayscale(1) brightness(2);
        opacity: 1;
    }

    /* Add after existing styles */
    .announcement-divider {
        border: none;
        height: 2px;
        background: #e0e0e0;
        border-radius: 1px;
        margin: 0 auto 2.5rem auto;
        max-width: 1400px;
        width: 100%;
    }
</style>
@endpush

@section('content')
<!-- Hero Section for Store Page -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">STORE</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Store</span>
    </div>
</div>

<!-- Store Section -->
<div class="store-section">
    <!-- Announcement Section -->
    <div class="announcement-section">
        <div class="announcement-content">
            <div class="announcement-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="announcement-text">
                <strong>Important Notice:</strong> For invoice requests or manual payment arrangements, please contact our support team.
                <div class="announcement-contact">
                    <a href="mailto:bina@cidbibs.com.my">
                        <i class="fas fa-envelope"></i>
                        bina@cidbibs.com.my
                    </a>
                    <a href="tel:+603-92242280">
                        <i class="fas fa-phone"></i>
                        +603-92242280
                    </a>
                    <a href="tel:+6012-6909457">
                        <i class="fas fa-mobile-alt"></i>
                        +6012-6909457
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Divider below announcement section -->
    <hr class="announcement-divider">

    <div class="store-container">
        <!-- Sidebar -->
        <aside class="store-sidebar">
            <a href="{{ route('client.cart.index') }}" class="btn btn-warning btn-lg d-flex align-items-center justify-content-center gap-2 mb-4" style="width:100%;height:48px;font-size:1.1rem;border-radius:0.5rem;">
                <i class="fas fa-shopping-cart" style="font-size:1.5rem;"></i>
                <span class="fw-bold">RM {{ number_format($cartTotal ?? 0, 2) }}</span>
            </a>
            <div class="price-slider-container">
                <div class="price-filter-title">PRICE FILTER</div>
                <div class="price-display">
                    <span class="price-value" id="priceValue">RM 249</span>
                </div>
                <input type="range" min="249" max="450" value="249" class="price-slider" id="priceSlider" step="1">
                <div class="price-range-info">
                    <span>RM 249</span>
                    <span>RM 450</span>
                </div>
            </div>
            <div class="store-categories">
                <div class="categories-title">PRODUCT CATEGORIES</div>
                <ul class="category-list">
                    <li class="category-item">
                        <input type="checkbox" class="category-checkbox" id="cat-facility">
                        <label for="cat-facility" class="category-label">Facility Management</label>
                    </li>
                    <li class="category-item">
                        <input type="checkbox" class="category-checkbox" id="cat-general">
                        <label for="cat-general" class="category-label">General</label>
                    </li>
                    <li class="category-item">
                        <input type="checkbox" class="category-checkbox" id="cat-modular">
                        <label for="cat-modular" class="category-label">Modular Asia</label>
                    </li>
                    <li class="category-item">
                        <input type="checkbox" class="category-checkbox" id="cat-ticket">
                        <label for="cat-ticket" class="category-label">Ticket</label>
                    </li>
                </ul>
            </div>
        </aside>
        <!-- Product Grid -->
        <section class="store-products">
            @foreach($tickets as $ticket)
                <a href="{{ route('client.ticket.detail', $ticket->id) }}" class="product-card" style="text-decoration:none;color:inherit;">
                    <img src="{{ asset($ticket->image) }}" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-title">{{ strtoupper($ticket->name) }}</div>
                        <div class="product-price">RM {{ number_format($ticket->price, 2) }}</div>
                        <div class="product-meta">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </section>
    </div>
</div>

@if(session('show_modal'))
<div class="modal fade" id="paymentSuccessModal" tabindex="-1" aria-labelledby="paymentSuccessModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header
        @if(session('modal_type') === 'success') bg-success text-white
        @elseif(session('modal_type') === 'error') bg-danger text-white
        @else bg-secondary text-white
        @endif">
        <h5 class="modal-title" id="paymentSuccessModalLabel">{{ session('modal_title') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ session('modal_message') }}
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = new bootstrap.Modal(document.getElementById('paymentSuccessModal'), {
        backdrop: 'static',
        keyboard: false
    });
    modal.show();
});
</script>
@endif
@endsection

@push('scripts')
<script>
// Mobile viewport height fix for hero section
document.addEventListener('DOMContentLoaded', function() {
    // Function to set proper viewport height for mobile devices
    function setMobileVH() {
        // Get the actual viewport height
        let vh = window.innerHeight * 0.01;
        
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
    
    // Function to handle orientation change
    function handleOrientationChange() {
        // Wait for orientation change to complete
        setTimeout(() => {
            setMobileVH();
        }, 500);
    }
    
    // Initial setup
    setMobileVH();
    
    // Listen for resize events
    window.addEventListener('resize', handleResize, { passive: true });
    
    // Listen for orientation changes
    window.addEventListener('orientationchange', handleOrientationChange, { passive: true });
    
    // Listen for viewport changes (for browsers that support it)
    if ('visualViewport' in window) {
        window.visualViewport.addEventListener('resize', handleResize, { passive: true });
    }
    
    // Handle iOS Safari address bar hide/show
    let lastInnerHeight = window.innerHeight;
    window.addEventListener('scroll', function() {
        if (window.innerHeight !== lastInnerHeight) {
            lastInnerHeight = window.innerHeight;
            setMobileVH();
        }
    }, { passive: true });
    
    // Force recalculation after page load
    window.addEventListener('load', function() {
        setTimeout(setMobileVH, 100);
    });
    
    // Handle focus events that might change viewport on mobile
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            setTimeout(setMobileVH, 300);
        });
        
        input.addEventListener('blur', function() {
            setTimeout(setMobileVH, 300);
        });
    });
});

// Price slider functionality
document.addEventListener('DOMContentLoaded', function() {
    const priceSlider = document.getElementById('priceSlider');
    const priceValue = document.getElementById('priceValue');
    
    // Update price display when slider moves
    priceSlider.addEventListener('input', function() {
        const value = this.value;
        priceValue.textContent = `RM ${value}`;
        
        // Here you can add filtering logic
        filterProductsByPrice(value);
    });
    
    // Function to filter products by price
    function filterProductsByPrice(maxPrice) {
        const productCards = document.querySelectorAll('.product-card');
        
        productCards.forEach(card => {
            const priceElement = card.querySelector('.product-price');
            if (priceElement) {
                // Extract numeric price from text (e.g., "RM249.00" -> 249)
                const price = parseFloat(priceElement.textContent.replace(/[^\d.-]/g, ''));
                
                if (price <= maxPrice) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }
});

// Additional mobile detection and fixes
(function() {
    // Detect mobile devices
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
    const isAndroid = /Android/.test(navigator.userAgent);
    
    if (isMobile) {
        document.documentElement.classList.add('is-mobile');
        
        if (isIOS) {
            document.documentElement.classList.add('is-ios');
        }
        
        if (isAndroid) {
            document.documentElement.classList.add('is-android');
        }
        
        // Prevent zoom on double tap for iOS
        if (isIOS) {
            let lastTouchEnd = 0;
            document.addEventListener('touchend', function(event) {
                const now = (new Date()).getTime();
                if (now - lastTouchEnd <= 300) {
                    event.preventDefault();
                }
                lastTouchEnd = now;
            }, false);
        }
    }
})();

// Category filtering functionality
document.addEventListener('DOMContentLoaded', function() {
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            filterProductsByCategory();
        });
    });
    
    function filterProductsByCategory() {
        const checkedCategories = Array.from(categoryCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.id.replace('cat-', ''));
        
        const productCards = document.querySelectorAll('.product-card');
        
        // If no categories are selected, show all products
        if (checkedCategories.length === 0) {
            productCards.forEach(card => {
                card.style.display = 'flex';
            });
            return;
        }
        
        // Filter products based on selected categories
        productCards.forEach(card => {
            const productTitle = card.querySelector('.product-title').textContent.toLowerCase();
            if (checkedCategories.includes('general')) {
                // If 'General' is checked, show all tickets
                card.style.display = 'flex';
                return;
            }
            const shouldShow = checkedCategories.some(category => {
                switch(category) {
                    case 'facility':
                        return productTitle.includes('facility');
                    case 'modular':
                        return productTitle.includes('modular');
                    case 'ticket':
                        return productTitle.includes('ticket');
                    default:
                        return false;
                }
            });
            card.style.display = shouldShow ? 'flex' : 'none';
        });
    }
});

// Additional smooth scrolling for purchase buttons
document.addEventListener('DOMContentLoaded', function() {
    const purchaseButtons = document.querySelectorAll('.btn-purchase');
    
    purchaseButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Add your purchase logic here
            // For now, we'll just prevent the default action
            e.preventDefault();
            
            // You can add your purchase/redirect logic here
            console.log('Purchase button clicked for:', this.closest('.ticket-card').querySelector('.ticket-type').textContent);
            
            // Example: Redirect to checkout or open modal
            // window.location.href = '/checkout?ticket=' + ticketType;
        });
    });
});
</script>
@endpush