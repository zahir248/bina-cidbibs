@extends('client.layouts.app')

@section('title', 'BINA | Checkout')

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
    .checkout-hero {
        /* Use multiple viewport units for maximum compatibility */
        min-height: 180px;
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
        margin: 0 0 2rem 0;
        
        /* Ensure it's always above other content */
        z-index: 1;
        
        /* Handle potential browser UI interference */
        overflow: hidden;
    }

    /* Fix for iOS Safari and other mobile browsers */
    @supports (-webkit-touch-callout: none) {
        .checkout-hero {
            /* iOS Safari specific */
            min-height: -webkit-fill-available;
            height: -webkit-fill-available;
        }
    }

    /* Enhanced title styling */
    .checkout-hero-title {
        font-size: clamp(2rem, 8vw, 3rem); /* Responsive font size */
        font-weight: 800;
        color: #fff;
        margin-bottom: 1rem;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        
        /* Prevent text from being too small on very small screens */
        min-font-size: 1.75rem;
    }

    /* Enhanced breadcrumb styling */
    .breadcrumb-checkout {
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

    .breadcrumb-checkout a {
        color: #fff;
        text-decoration: none;
        opacity: 0.85;
        transition: opacity 0.2s;
    }

    .breadcrumb-checkout a:hover {
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
        .checkout-hero {
            /* Ensure full height on tablets */
            min-height: 100vh;
            min-height: 100svh;
            height: 100vh;
            padding: 0 1rem;
        }
    }

    @media screen and (max-width: 768px) {
        .checkout-hero {
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
        .checkout-hero-title {
            max-width: 90vw;
            word-wrap: break-word;
        }
    }

    @media screen and (max-width: 576px) {
        .checkout-hero {
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
        .checkout-hero {
            padding: 0 0.5rem;
            min-height: 100vh;
            height: 100vh;
        }
        
        .checkout-hero-title {
            font-size: 1.75rem;
            line-height: 1.2;
        }
        
        .breadcrumb-checkout {
            font-size: 0.9rem;
        }
    }

    /* Landscape mobile devices */
    @media screen and (max-height: 500px) and (orientation: landscape) {
        .checkout-hero {
            min-height: 100vh;
            height: 100vh;
            padding: 1rem;
            justify-content: center;
        }
        
        .checkout-hero-title {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .breadcrumb-checkout {
            font-size: 1rem;
        }
    }

    /* Fix for browsers that don't handle vh well on mobile */
    @media screen and (max-width: 768px) {
        .checkout-hero {
            position: relative;
        }
        
        /* Fallback using JavaScript will be applied here */
        .checkout-hero.js-mobile-vh {
            height: var(--vh, 100vh);
            min-height: var(--vh, 100vh);
        }
    }

    /* Ensure the hero section starts from the very top */
    body {
        margin: 0;
        padding: 0;
    }

    .checkout-hero {
        margin-top: 0;
        position: relative;
        top: 0;
    }

    /* Checkout Section */
    .checkout-main {
        max-width: 1200px;
        margin: 0 auto 40px auto;
        display: flex;
        gap: 2.5rem;
        background: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        padding: 2.5rem 2rem;
    }

    .checkout-form-col {
        flex: 2;
        min-width: 0;
    }

    .checkout-summary-col {
        flex: 1;
        min-width: 320px;
        max-width: 400px;
    }

    .checkout-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        color: #1e293b;
        letter-spacing: 1px;
    }

    .checkout-form label {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .checkout-form .required {
        color: #e3342f;
        margin-left: 2px;
    }

    .checkout-form .form-control {
        border-radius: 0.4rem;
        border: 1px solid #e2e8f0;
        margin-bottom: 0.2rem;
        font-size: 1rem;
        padding: 0.75rem 1rem;
    }

    .checkout-form .form-row {
        display: flex;
        gap: 1rem;
    }

    .checkout-form .form-row > div {
        flex: 1;
    }

    .checkout-form .error {
        color: #e3342f;
        font-size: 0.97rem;
        margin-bottom: 1rem;
        margin-top: 0.1rem;
    }

    @media (max-width: 992px) {
        .checkout-main {
            flex-direction: column;
            padding: 1.5rem 0.5rem;
            gap: 2rem;
        }
    }

    @media (max-width: 768px) {
        .checkout-form .form-row {
            flex-direction: column;
            gap: 0;
        }
        .checkout-summary-col {
            min-width: 0;
            max-width: 100%;
        }
    }

    .checkout-summary-box {
        background: #f8fafc;
        border: 1px solid #eee;
        border-radius: 0.5rem;
        padding: 2rem 1.5rem 1.5rem 1.5rem;
    }

    .checkout-summary-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1.2rem;
        color: #1e293b;
    }

    .checkout-summary-list {
        list-style: none;
        padding: 0;
        margin: 0 0 1.2rem 0;
    }

    .checkout-summary-list li {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .checkout-summary-total {
        font-weight: 700;
        font-size: 1.1rem;
        color: #bfa600;
        display: flex;
        justify-content: space-between;
        margin-top: 1rem;
    }

    .checkout-summary-label {
        color: #1e293b;
        font-weight: 600;
    }

    .checkout-summary-value {
        color: #bfa600;
        font-weight: 700;
    }

    .checkout-shipping {
        color: #1e293b;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .payment-method {
        margin-top: 2rem;
        margin-bottom: 1.2rem;
    }

    .payment-radio {
        accent-color: #ff9800;
        margin-right: 0.5rem;
    }

    .payment-label {
        font-weight: 600;
        color: #1e293b;
        margin-right: 0.5rem;
    }

    .payment-desc {
        color: #64748b;
        font-size: 0.97rem;
        margin-left: 2rem;
        margin-bottom: 1.2rem;
    }

    .btn-checkout {
        background: #ff9800;
        color: #fff;
        border: none;
        border-radius: 2rem;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 0.75rem 2.5rem;
        font-size: 1.1rem;
        margin-top: 1.5rem;
        width: 100%;
        transition: background 0.2s;
    }

    .btn-checkout:hover {
        background: #ffb84d;
        color: #fff;
    }

    html, body {
        overflow-x: hidden;
    }
</style>
@endpush

@section('content')
<!-- Hero Section for Checkout Page -->
<div class="checkout-hero" id="heroSection">
    <h1 class="checkout-hero-title">CHECKOUT</h1>
    <div class="breadcrumb-checkout">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <a href="{{ route('client.store') }}">Store</a>
        <span class="breadcrumb-separator">&gt;</span>
        <a href="{{ route('client.cart.index') }}">Cart</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Checkout</span>
    </div>
</div>
<div class="checkout-main">
    <!-- Billing Details -->
    <div class="checkout-form-col">
        <div class="checkout-title">Billing Details</div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('client.checkout.process') }}" class="checkout-form" id="checkoutForm">
            @csrf
            <div class="form-row">
                <div>
                    <label for="first_name">First Name <span class="required">*</span></label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="e.g. John" required>
                    @error('first_name')<div class="error">Billing First name is a required field.</div>@enderror
                </div>
                <div>
                    <label for="last_name">Last Name <span class="required">*</span></label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="e.g. Doe" required>
                    @error('last_name')<div class="error">Billing Last name is a required field.</div>@enderror
                </div>
            </div>
            <div>
                <label for="country">Country / Region <span class="required">*</span></label>
                <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" placeholder="e.g. Malaysia" required pattern="[A-Za-z ]*">
                @error('country')<div class="error">Billing Country/Region is a required field.</div>@enderror
            </div>
            <div>
                <label for="address1">Street Address <span class="required">*</span></label>
                <input type="text" class="form-control" id="address1" name="address1" value="{{ old('address1') }}" placeholder="e.g. 123 Jalan Ampang" required>
                @error('address1')<div class="error">Billing Street address is a required field.</div>@enderror
            </div>
            <div>
                <input type="text" class="form-control" id="address2" name="address2" value="{{ old('address2') }}" placeholder="e.g. Apartment 5A, Block B (optional)">
            </div>
            <div class="form-row">
                <div>
                    <label for="city">Town / City <span class="required">*</span></label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" placeholder="e.g. Kuala Lumpur" required>
                    @error('city')<div class="error">Billing Town/City is a required field.</div>@enderror
                </div>
                <div>
                    <label for="state">State <span class="required">*</span></label>
                    <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" placeholder="e.g. Wilayah Persekutuan" required>
                    @error('state')<div class="error">Billing State is a required field.</div>@enderror
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="postcode">Postcode / ZIP <span class="required">*</span></label>
                    <input type="text" class="form-control" id="postcode" name="postcode" value="{{ old('postcode') }}" placeholder="e.g. 50450" required pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    @error('postcode')<div class="error">Billing Postcode/ZIP is a required field.</div>@enderror
                </div>
                <div>
                    <label for="phone">Phone <span class="required">*</span></label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="e.g. 0123456789" required pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    @error('phone')<div class="error">Billing Phone is a required field.</div>@enderror
                </div>
            </div>
            <div>
                <label for="email">Email Address <span class="required">*</span> <i class="fas fa-info-circle" style="color: #ff9800;" data-bs-toggle="tooltip" data-bs-placement="top" title="Please provide your active email address. This will be used to send your purchase confirmation and can be used to retrieve your purchase information if you register an account later."></i></label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="e.g. john@gmail.com" required>
                @error('email')<div class="error">Billing Email address is a required field.</div>@enderror
            </div>
        </form>
    </div>
    <!-- Order Summary -->
    <div class="checkout-summary-col">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('client.cart.index') }}" class="btn btn-dark" style="background:#020326;border-radius:2rem;padding:0.5rem 1.5rem;font-weight:700;letter-spacing:0.12em;font-size:0.98rem;text-transform:uppercase;box-shadow:none;">Return to Cart</a>
        </div>
        <div class="checkout-summary-box">
            <div class="checkout-summary-title">Your Order</div>
            <div class="d-flex justify-content-between mb-2" style="font-weight:600;">
                <span>Product</span>
                <span>Subtotal</span>
            </div>
            <ul class="checkout-summary-list">
                @php
                    $originalSubtotal = 0;
                    $discountedSubtotal = 0;
                @endphp
                @foreach($cartItems as $item)
                    @php
                        $originalSubtotal += $item->ticket->price * $item->quantity;
                        $discountedSubtotal += $item->ticket->getDiscountedPrice($item->quantity) * $item->quantity;
                    @endphp
                    <li>
                        <span>{{ $item->ticket->name }} &times; {{ $item->quantity }}</span>
                        <span>
                            @if($item->ticket->getDiscountedPrice($item->quantity) < $item->ticket->price)
                                <span class="text-decoration-line-through text-muted">RM {{ number_format($item->ticket->price * $item->quantity, 2) }}</span>
                                <span class="text-success">RM {{ number_format($item->ticket->getDiscountedPrice($item->quantity) * $item->quantity, 2) }}</span>
                            @else
                                RM {{ number_format($item->ticket->price * $item->quantity, 2) }}
                            @endif
                        </span>
                    </li>
                @endforeach
                @php
                    $discount = $originalSubtotal - $discountedSubtotal;
                @endphp
            </ul>
            <div class="d-flex justify-content-between mb-2">
                <span class="checkout-summary-label">Subtotal</span>
                <span class="checkout-summary-value">RM {{ number_format($originalSubtotal, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="checkout-summary-label">Discount</span>
                <span class="checkout-summary-value text-success">-RM {{ number_format($discount, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between checkout-shipping mb-2">
                <span>Shipping</span>
                <span>Free shipping</span>
            </div>
            <hr>
            <div class="checkout-summary-total">
                <span>Total</span>
                <span>RM {{ number_format($discountedSubtotal, 2) }}</span>
            </div>
            <div class="payment-method">
                <input type="radio" class="payment-radio" id="toyyibpay" name="payment_method" value="toyyibpay" checked>
                <label for="toyyibpay" class="payment-label">toyyibPay</label>
            </div>
            <div class="payment-desc">Pay securely with toyyibPay.</div>
            <div class="text-muted" style="font-size:0.97rem;">
                Your personal data will be used to process your order, support your experience, and for other purposes described in our privacy policy.
            </div>
            <button type="submit" form="checkoutForm" class="btn btn-checkout mt-3">Proceed to Payment</button>
        </div>
    </div>
</div>
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
        const heroSections = document.querySelectorAll('.checkout-hero');
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

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkoutForm');
    const button = document.querySelector('.btn-checkout[form="checkoutForm"]');
    if (form && button) {
        button.addEventListener('click', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                form.reportValidity();
            }
        });
    }
});

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endpush