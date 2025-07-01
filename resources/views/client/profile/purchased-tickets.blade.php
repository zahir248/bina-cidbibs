@extends('client.layouts.app')

@section('title', 'BINA | Purchased Tickets')

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

    .store-container {
        padding: 0 1.5rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Desktop Table View */
    @media (min-width: 769px) {
        .orders-table {
            display: block;
        }
        .orders-card {
            display: none;
        }
    }

    /* Orders Table */
    .orders-table {
        width: 100%;
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        margin-top: 2rem;
    }

    .orders-table table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .orders-table th,
    .orders-table td {
        padding: 1.25rem 1.5rem;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
        font-size: 0.95rem;
    }

    .orders-table th {
        background: #ff9800;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.85rem;
    }

    .orders-table th:first-child {
        border-top-left-radius: 0.5rem;
    }

    .orders-table th:last-child {
        border-top-right-radius: 0.5rem;
    }

    .orders-table tr:last-child td {
        border-bottom: none;
    }

    .orders-table tr:hover td {
        background: #fff8e1;
        transition: background-color 0.2s ease;
    }

    .orders-table td {
        color: #4b5563;
        transition: all 0.2s ease;
    }

    .orders-table td:first-child {
        font-weight: 600;
        color: #1f2937;
    }

    /* Mobile Card View */
    .orders-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
        padding: 1.25rem;
    }

    .orders-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #ff9800;
    }

    .orders-card-title {
        font-weight: 600;
        color: #1f2937;
    }

    .orders-card-body {
        display: grid;
        gap: 0.75rem;
    }

    .orders-card-row {
        display: grid;
        grid-template-columns: 120px 1fr;
        gap: 0.5rem;
        align-items: center;
    }

    .orders-card-label {
        font-weight: 500;
        color: #6b7280;
        font-size: 0.875rem;
    }

    .orders-card-value {
        color: #1f2937;
        font-size: 0.875rem;
    }

    /* Enhanced Button Styling */
    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-download svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    /* Primary button (Download Order Details) */
    .btn-download {
        background-color: #ff9800;
        color: white;
    }

    .btn-download:hover {
        background-color: #f57c00;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Secondary button (Download QR Codes) */
    .btn-download.btn-secondary {
        background-color: #78909c;
        color: white;
        display: inline-flex;
        align-items: center;
    }

    .btn-download.btn-secondary:hover {
        background-color: #607d8b;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-group {
        display: flex;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    @media (max-width: 640px) {
        .btn-group {
            flex-direction: column;
            width: 100%;
        }

        .btn-download {
            width: 100%;
            justify-content: center;
        }
    }

    /* Enhanced Badge Styling */
    .badge {
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-success {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .badge-pending {
        background-color: #fff3e0;
        color: #ef6c00;
    }

    .badge-failed {
        background-color: #ffebee;
        color: #c62828;
    }

    /* Amount Column Styling */
    .amount-column {
        font-family: 'Roboto Mono', monospace;
        font-weight: 500;
    }

    /* Empty State Styling */
    .empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
        color: #6b7280;
    }

    .empty-state svg {
        width: 3rem;
        height: 3rem;
        margin-bottom: 1rem;
        color: #9ca3af;
    }

    .empty-state-text {
        font-size: 0.95rem;
        font-weight: 500;
    }

    .text-center {
        text-align: center;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .store-container {
            padding: 0 1rem;
        }

        .orders-table th,
        .orders-table td {
            padding: 1rem;
        }
    }

    @media (max-width: 768px) {
        .store-section {
            padding: 40px 0;
        }

        .store-container {
            padding: 0 1rem;
        }

        /* Hide table on mobile */
        .orders-table {
            display: none;
        }

        /* Show cards on mobile */
        .orders-card {
            display: block;
            margin: 1rem;
        }

        .hero-section-store {
            min-height: 50vh;
        }

        .hero-title-store {
            font-size: 2rem;
        }

        .orders-card-row {
            grid-template-columns: 100px 1fr;
        }
    }

    @media (max-width: 640px) {
        .store-container {
            padding: 0 0.75rem;
        }

        .orders-card {
            margin: 0.75rem;
            padding: 1rem;
        }

        .orders-card-row {
            grid-template-columns: 1fr;
            gap: 0.25rem;
        }

        .orders-card-label {
            color: #4b5563;
        }

        .btn-group {
            flex-direction: column;
        }

        .hero-title-store {
            font-size: 1.75rem;
            padding: 0 1rem;
        }

        .breadcrumb-store {
            padding: 0 1rem;
            text-align: center;
            flex-wrap: wrap;
            justify-content: center;
        }
    }

    /* Loading state for buttons */
    .btn-download.loading {
        opacity: 0.8;
        cursor: wait;
        background-color: #78909c !important;
    }

    .btn-download.success {
        background-color: #4caf50 !important;
    }

    .btn-download.error {
        background-color: #f44336 !important;
    }

    .btn-download.loading svg {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section-store">
    <h1 class="hero-title-store">Purchased Tickets</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Purchased Tickets</span>
    </div>
</section>

<!-- Store Section -->
<section id="storeSection" class="store-section">
    <div class="store-container">
        <!-- Desktop Table View -->
        <div class="orders-table">
            <table>
                <thead>
                    <tr>
                        <th style="width: 70px;">No.</th>
                        <th>Reference Number</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $order->reference_number }}</td>
                            <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            <td class="amount-column">RM {{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                @if($order->status === 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @elseif($order->status === 'pending')
                                    <span class="badge badge-pending">Pending</span>
                                @else
                                    <span class="badge badge-failed">Failed</span>
                                @endif
                            </td>
                            <td>
                                @if($order->status === 'paid')
                                    <div class="btn-group">
                                        <a href="{{ route('client.profile.orders.download-pdf', $order) }}" 
                                           class="btn-download">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                            <span>Download<br>Order Details</span>
                                        </a>
                                        <a href="{{ route('client.profile.orders.download-qr-codes', $order) }}" 
                                           class="btn-download btn-secondary"
                                           data-qr-download>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zM13 3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2v1h1V5h-1z" clip-rule="evenodd" />
                                            </svg>
                                            <span>Download<br>QR Codes</span>
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="empty-state-text">No orders found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        @forelse($orders as $order)
            <div class="orders-card">
                <div class="orders-card-header">
                    <div class="orders-card-title">#{{ $loop->iteration }}</div>
                    @if($order->status === 'paid')
                        <span class="badge badge-success">Paid</span>
                    @elseif($order->status === 'pending')
                        <span class="badge badge-pending">Pending</span>
                    @else
                        <span class="badge badge-failed">Failed</span>
                    @endif
                </div>
                <div class="orders-card-body">
                    <div class="orders-card-row">
                        <div class="orders-card-label">Reference No.</div>
                        <div class="orders-card-value">{{ $order->reference_number }}</div>
                    </div>
                    <div class="orders-card-row">
                        <div class="orders-card-label">Date</div>
                        <div class="orders-card-value">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                    <div class="orders-card-row">
                        <div class="orders-card-label">Total Amount</div>
                        <div class="orders-card-value amount-column">RM {{ number_format($order->total_amount, 2) }}</div>
                    </div>
                    @if($order->status === 'paid')
                        <div class="btn-group">
                            <a href="{{ route('client.profile.orders.download-pdf', $order) }}" 
                               class="btn-download">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                <span>Download<br>Order Details</span>
                            </a>
                            <a href="{{ route('client.profile.orders.download-qr-codes', $order) }}" 
                               class="btn-download btn-secondary"
                               data-qr-download>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zM13 3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2v1h1V5h-1z" clip-rule="evenodd" />
                                </svg>
                                <span>Download<br>QR Codes</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="orders-card">
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="empty-state-text">No orders found.</p>
                </div>
            </div>
        @endforelse
    </div>
</section>
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

document.addEventListener('DOMContentLoaded', function() {
    // Scroll to cart content
    const cartContent = document.getElementById('cartContent');
    if (cartContent) {
        // Add a small delay to ensure smooth scrolling after page load
        setTimeout(() => {
            cartContent.scrollIntoView({ behavior: 'smooth' });
        }, 100);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Scroll to store section
    const storeSection = document.getElementById('storeSection');
    if (storeSection) {
        // Add a small delay to ensure smooth scrolling after page load
        setTimeout(() => {
            storeSection.scrollIntoView({ behavior: 'smooth' });
        }, 100);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Function to download a file from URL and convert SVG to PNG if needed
    async function downloadFile(url, filename, isSvg) {
        try {
            const response = await fetch(url);
            const blob = await response.blob();

            if (isSvg) {
                // Convert SVG to PNG
                return new Promise((resolve, reject) => {
                    const img = new Image();
                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        canvas.width = 300;  // Match the QR Server size
                        canvas.height = 300;
                        
                        const ctx = canvas.getContext('2d');
                        ctx.fillStyle = 'white';
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                        
                        canvas.toBlob((pngBlob) => {
                            const link = document.createElement('a');
                            link.href = URL.createObjectURL(pngBlob);
                            link.download = filename;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                            resolve();
                        }, 'image/png');
                    };
                    img.onerror = reject;
                    img.src = URL.createObjectURL(blob);
                });
            } else {
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        } catch (error) {
            console.error('Download failed:', error);
            throw error;
        }
    }

    // Handle QR code downloads
    const qrDownloadButtons = document.querySelectorAll('[data-qr-download]');
    qrDownloadButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            
            // Show loading state
            const originalText = this.querySelector('span').innerHTML;
            let currentFile = 0;
            
            try {
                // Get QR code data
                const response = await fetch(url);
                const data = await response.json();
                
                if (data.success) {
                    const totalFiles = data.qr_codes.length;
                    
                    // Update button to show progress
                    this.classList.add('loading');
                    
                    // Show if using local generation
                    if (data.using_local_generation) {
                        this.querySelector('span').innerHTML = 'Using Local<br>Generation';
                        await new Promise(resolve => setTimeout(resolve, 1000));
                    }
                    
                    // Download files one by one
                    for (let i = 0; i < data.qr_codes.length; i++) {
                        const qrCode = data.qr_codes[i];
                        currentFile = i + 1;
                        
                        // Update progress text
                        this.querySelector('span').innerHTML = `Downloading<br>${currentFile} of ${totalFiles}`;
                        
                        // Download the file
                        await downloadFile(qrCode.url, qrCode.filename, qrCode.is_svg);
                        
                        // Small delay between downloads
                        if (i < data.qr_codes.length - 1) {
                            await new Promise(resolve => setTimeout(resolve, 300));
                        }
                    }
                    
                    // Show success message briefly
                    this.querySelector('span').innerHTML = `Downloaded<br>${totalFiles} Files`;
                    this.classList.remove('loading');
                    this.classList.add('success');
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        this.querySelector('span').innerHTML = originalText;
                        this.classList.remove('success');
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Download failed');
                }
            } catch (error) {
                // Show error state
                this.classList.remove('loading');
                this.classList.add('error');
                this.querySelector('span').innerHTML = 'Error<br>Try Again';
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    this.querySelector('span').innerHTML = originalText;
                    this.classList.remove('error');
                }, 2000);
            }
        });
    });
});
</script>
@endpush