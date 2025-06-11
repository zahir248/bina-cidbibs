@extends('client.layouts.app')

@section('title', 'BINA | Cart')

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
        padding: 32px 0 32px;
    }

    .store-container {
        display: flex;
        gap: 2rem;
        padding: 0 1rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Cart Items (Left Column) */
    .cart-items {
        flex: 2;
        min-width: 0; /* Prevents flex item from overflowing */
    }

    /* Cart Summary (Right Column) */
    .cart-summary {
        flex: 1;
        min-width: 280px;
        max-width: 350px;
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
        .cart-table { display: none; }
        .cart-card-list { display: block; }
        .cart-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            position: relative;
            border: 1px solid #f1f1f1;
        }
        .cart-card-img {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0;
        }
        .cart-card-content {
            flex: 1;
            min-width: 0;
        }
        .cart-card-title {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
        }
        .cart-card-label {
            color: #888;
            font-size: 0.95rem;
            margin-right: 0.5rem;
        }
        .cart-card-remove {
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            background: #ff4d4f;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            z-index: 2;
        }
        .cart-card-remove:hover { background: #ff7875; }
    }
    @media (min-width: 577px) {
        .cart-card-list { display: none; }
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

    .bg-orange { background: #ff9800 !important; color: #fff !important; }
    .btn-orange { background: #ff9800; color: #fff; border: none; border-radius: 8px; font-weight: 600; letter-spacing: 1px; }
    .btn-orange:hover { background: #ffb84d; color: #fff; }
    .cart-img { border-radius: 0; width: 44px; height: 44px; object-fit: cover; }
    .summary-box { border: 1px solid #eee; background: #fff; border-radius: 0; padding: 1.25rem 1rem; }
    .cart-items { min-width: 0; }
    .cart-table { 
        background: #fff; 
        border-radius: 0; 
        overflow: hidden; 
        font-size: 0.97rem; 
    }
    .cart-table th, .cart-table td { 
        padding: 0.5rem 0.5rem; 
        vertical-align: middle; 
    }
    .cart-table th.bg-orange { 
        border-top-left-radius: 0; 
    }
    .cart-table th.bg-orange:last-child { 
        border-top-right-radius: 0; 
    }
    .cart-table input[type='number'] { text-align: center; }
    .qty-btn { width: 32px; height: 32px; border-radius: 6px; border: none; background: #ff9800; color: #fff; font-size: 1.2rem; font-weight: bold; }
    .qty-btn:hover { background: #ffb84d; }
    .remove-btn { background: #ff4d4f; color: #fff; border: none; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 1rem; }
    .remove-btn:hover { background: #ff7875; }
    .return-btn { 
        background: #ff9800; 
        color: #fff; 
        border: none; 
        border-radius: 2rem; 
        font-weight: 700; 
        letter-spacing: 1px; 
        padding: 0.5rem 1.5rem; 
        font-size: 1rem;
        text-decoration: none;
        display: inline-block;
        margin: 1.5rem auto;
        text-align: center;
    }
    .return-btn:hover { 
        background: #ffb84d; 
        color: #fff;
        text-decoration: none;
    }
    .btn, .btn-lg, .btn-sm {
        font-size: 1rem;
        padding: 0.5rem 1.25rem;
    }
    @media (max-width: 900px) {
        .store-container {
            flex-direction: column;
            gap: 1.5rem;
            padding: 0 0.5rem;
        }
        .cart-summary {
            max-width: 100%;
            min-width: 0;
            margin-left: 0 !important;
            margin-top: 1.5rem;
        }
        .summary-box {
            width: 100%;
        }
    }
    @media (max-width: 576px) {
        .return-btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section for Cart Page (same as store page) -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">CART</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <a href="{{ route('client.store') }}">Store</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Cart</span>
    </div>
</div>
<!-- Cart Section (modern two-column layout) -->
<div class="store-section">
    <div class="store-container">
        <!-- Cart Items (Left) -->
        <div class="cart-items">
            <table class="table cart-table">
                <thead>
                    <tr>
                        <th class="bg-orange">Ticket Name</th>
                        <th class="bg-orange">Price</th>
                        <th class="bg-orange">Quantity</th>
                        <th class="bg-orange">Subtotal</th>
                        <th class="bg-orange"></th>
                    </tr>
                </thead>
                <tbody>
                    @if($cartItems->isEmpty())
                        <tr><td colspan="5"><div class="alert" style="background:#fff3cd;border:1px solid #ff9800;color:#b26a00;">The cart is empty.</div></td></tr>
                    @else
                        @php $subtotal = 0; @endphp
                        @foreach($cartItems as $item)
                            @php 
                                $discountedPrice = $item->ticket->getDiscountedPrice($item->quantity);
                                $itemSubtotal = $discountedPrice * $item->quantity; 
                                $subtotal += $itemSubtotal; 
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($item->ticket->image) }}" class="cart-img me-2">
                                        <span>{{ strtoupper($item->ticket->name) }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($discountedPrice < $item->ticket->price)
                                        <span class="text-decoration-line-through text-muted">RM {{ number_format($item->ticket->price, 2) }}</span>
                                        <br>
                                        <span class="text-success">RM {{ number_format($discountedPrice, 2) }}</span>
                                    @else
                                        RM {{ number_format($item->ticket->price, 2) }}
                                    @endif
                                </td>
                                <td>
                                    {{ $item->quantity }}
                                </td>
                                <td>RM {{ number_format($itemSubtotal, 2) }}</td>
                                <td>
                                    <form action="{{ route('client.cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="remove-btn"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <!-- Desktop: Return to Store button below table -->
            <div class="text-center">
                <a href="{{ route('client.store') }}" class="return-btn d-none d-sm-inline-block">RETURN TO STORE</a>
            </div>
            <!-- Mobile Card Layout -->
            <div class="cart-card-list">
                @if($cartItems->isEmpty())
                    <div class="alert" style="background:#fff3cd;border:1px solid #ff9800;color:#b26a00;">The cart is empty.</div>
                @else
                    @foreach($cartItems as $item)
                        <div class="cart-card">
                            <form action="{{ route('client.cart.remove', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="cart-card-remove"><i class="fas fa-times"></i></button>
                            </form>
                            <img src="{{ asset($item->ticket->image) }}" class="cart-card-img">
                            <div class="cart-card-content">
                                <div class="cart-card-title">{{ strtoupper($item->ticket->name) }}</div>
                                @php 
                                    $discountedPrice = $item->ticket->getDiscountedPrice($item->quantity);
                                    $itemSubtotal = $discountedPrice * $item->quantity;
                                @endphp
                                <div>
                                    <span class="cart-card-label">Price:</span>
                                    @if($discountedPrice < $item->ticket->price)
                                        <span class="text-decoration-line-through text-muted">RM {{ number_format($item->ticket->price, 2) }}</span>
                                        <span class="text-success fw-bold">RM {{ number_format($discountedPrice, 2) }}</span>
                                    @else
                                        <span class="fw-bold">RM {{ number_format($item->ticket->price, 2) }}</span>
                                    @endif
                                </div>
                                <div><span class="cart-card-label">Subtotal:</span> <span class="fw-bold">RM {{ number_format($itemSubtotal, 2) }}</span></div>
                                <div><span class="cart-card-label">Qty:</span> {{ $item->quantity }}</div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <!-- Mobile: Return to Shop button below card list -->
                <div class="text-center">
                    <a href="{{ route('client.store') }}" class="return-btn d-inline-block d-sm-none">RETURN TO SHOP</a>
                </div>
            </div>
        </div>
        <!-- Cart Summary (Right) -->
        <div class="cart-summary">
            <div class="summary-box">
                @php
                    $originalSubtotal = 0;
                    $discountedSubtotal = 0;
                    foreach ($cartItems as $item) {
                        $originalSubtotal += $item->ticket->price * $item->quantity;
                        $discountedSubtotal += $item->ticket->getDiscountedPrice($item->quantity) * $item->quantity;
                    }
                    $discount = $originalSubtotal - $discountedSubtotal;
                @endphp
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span class="fw-bold">RM {{ number_format($originalSubtotal, 2) }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Discount</span>
                    <span class="fw-bold text-success">-RM {{ number_format($discount, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold">RM {{ number_format($discountedSubtotal, 2) }}</span>
                </div>
                <a href="{{ route('client.checkout') }}"
                   class="btn btn-dark w-100 {{ $cartItems->isEmpty() ? 'disabled' : '' }}"
                   @if($cartItems->isEmpty()) tabindex="-1" aria-disabled="true" @endif>
                    <i class="fas fa-shopping-bag me-2"></i>Proceed to checkout
                </a>
                @if($cartItems->isEmpty())
                    <div class="text-danger text-center mt-2" style="font-weight:600;">The cart is empty. Please add items before checking out.</div>
                @endif
            </div>
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