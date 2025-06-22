@extends('client.layouts.app')

@section('title', 'BINA | Store')

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
        padding: 60px 2rem;
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
        max-width: 1400px;
        margin: 0 auto;
    }

    .store-products {
        flex: 1 1 0%;
    }

    .category-section {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 2rem;
        padding: 1.5rem;
    }

    .category-header {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .sale-info {
        color: #64748b;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
    }

    .product-table th {
        background: #f8fafc;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #1e293b;
        border-bottom: 2px solid #e2e8f0;
    }

    .product-table td {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    .product-table tr:last-child td {
        border-bottom: none;
    }

    .original-price {
        text-decoration: line-through;
        color: #94a3b8;
        font-size: 0.9rem;
        display: block;
    }

    .discounted-price {
        color: #ef4444;
        font-weight: 600;
    }

    .early-bird {
        color: #94a3b8;
        font-size: 0.9rem;
        margin-left: 0.5rem;
    }

    .quantity-column {
        flex: 1;
        display: flex;
        justify-content: flex-end;
    }

    /* Add styles for details button */
    .details-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.9rem;
        color: #ffa000;
        text-decoration: none;
        margin-left: 1rem;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: color 0.2s;
    }

    .details-button:hover {
        color: #ff8f00;
    }

    .details-button i {
        font-size: 1rem;
    }

    .product-name-cell {
        display: flex;
        align-items: center;
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
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.5rem;
    }

    .product-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 600;
        color: #111a3a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .product-price {
        color: #1e293b;
        font-weight: 600;
        font-size: 1rem;
    }

    .view-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s;
    }

    .view-button:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .store-products {
            margin: 0 -1rem;
            border-radius: 0;
        }

        .product-table {
            display: block;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .product-table th,
        .product-table td {
            white-space: nowrap;
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

    /* Cart Buttons */
    .cart-buttons-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-right: 1.5rem;
    }

    .cart-buttons {
        display: flex;
        flex-direction: row;
        gap: 1rem;
        width: 25%;
        min-width: 200px;
    }

    .cart-button {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1rem;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .add-to-cart {
        background: #212529;
        color: white;
        border: none;
    }

    .add-to-cart:hover {
        background: #212529;
        color: white;
    }

    .view-cart {
        background: #ff9900;
        color: white;
        border: none;
    }

    .view-cart:hover {
        background: #ffb300;
        color: white;
    }

    .quantity-select {
        padding: 0.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.25rem;
        width: 80px;
        background: white;
        color: #1e293b;
        font-size: 1rem;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }

    .quantity-select:focus {
        outline: none;
        border-color: orange;
        box-shadow: orange;
    }

    /* Category Styles */
    .category-section {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 2rem;
        padding: 1.5rem;
    }

    .category-header {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .sale-info {
        color: #64748b;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
    }

    .product-table th {
        background: #f8fafc;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #1e293b;
        border-bottom: 2px solid #e2e8f0;
    }

    .product-table td {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    .product-table tr:last-child td {
        border-bottom: none;
    }

    .original-price {
        text-decoration: line-through;
        color: #94a3b8;
        font-size: 0.9rem;
        display: block;
    }

    .discounted-price {
        color: #ef4444;
        font-weight: 600;
    }

    .early-bird {
        color: #94a3b8;
        font-size: 0.9rem;
        margin-left: 0.5rem;
    }

    .quantity-column {
        flex: 1;
        display: flex;
        justify-content: flex-end;
    }

    /* Add styles for details button */
    .details-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.9rem;
        color: #ff9900;
        text-decoration: none;
        margin-left: 1rem;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: color 0.2s;
    }

    .details-button:hover {
        color: #ff8f00;
    }

    .details-button i {
        font-size: 1rem;
    }

    .product-name-cell {
        display: flex;
        align-items: center;
    }

    /* Add pricing table styles */
    .pricing-table-section {
        margin: 0 auto 3.5rem;
        max-width: 1400px;
    }

    .pricing-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .pricing-table th {
        background: #666;
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
    }

    .pricing-table td {
        padding: 1rem;
        background: #f0f0f0;
        border-bottom: 2px solid white;
    }

    .pricing-table tr:last-child td {
        border-bottom: none;
    }

    .pricing-table .price-column {
        width: 30%;
    }

    .per-pax {
        color: #666;
        font-size: 0.9rem;
        margin-left: 0.25rem;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .cart-buttons {
            width: 40%;
        }
    }

    @media (max-width: 768px) {
        .cart-buttons {
            width: 50%;
        }
        .cart-button {
            font-size: 0.9rem;
            padding: 0.75rem 0.875rem;
        }
    }

    @media (max-width: 576px) {
        .cart-buttons-container {
            padding-right: 0;
        }
        .cart-buttons {
            width: 100%;
        }
        .cart-button {
            font-size: 1rem;
            padding: 0.875rem 1rem;
        }
    }

    /* Modal styles to prevent scrolling */
    body.modal-open {
        overflow: hidden;
        padding-right: 17px;
    }

    #cartMessageModal {
        background: rgba(0, 0, 0, 0.5);
    }

    #cartMessageModal .modal-dialog {
        margin: 1.75rem auto;
        max-width: 90%;
        width: 400px;
    }

    #cartMessageModal .modal-content {
        max-height: calc(100vh - 3.5rem);
        overflow: hidden;
        border-radius: 12px;
        border: none;
    }

    #cartMessageModal .modal-header {
        padding: 1rem;
        border-bottom: none;
    }

    #cartMessageModal .modal-header.bg-success,
    #cartMessageModal .modal-header.bg-danger {
        border-radius: 12px 12px 0 0;
    }

    #cartMessageModal .modal-title {
        font-size: 1.1rem;
        font-weight: 600;
    }

    #cartMessageModal .modal-body {
        padding: 1.25rem;
        font-size: 1rem;
        color: #1e293b;
    }

    #cartMessageModal .modal-footer {
        border-top: none;
        padding: 1rem;
        justify-content: center;
    }

    #cartMessageModal .btn-secondary {
        background: #64748b;
        border: none;
        padding: 0.5rem 2rem;
        font-weight: 500;
        border-radius: 6px;
    }

    #cartMessageModal .btn-secondary:hover {
        background: #475569;
    }

    /* Mobile specific modal adjustments */
    @media (max-width: 576px) {
        #cartMessageModal .modal-dialog {
            margin: 1rem;
            width: auto;
        }

        #cartMessageModal .modal-content {
            margin: 0 1rem;
        }

        #cartMessageModal .modal-title {
            font-size: 1rem;
        }

        #cartMessageModal .modal-body {
            padding: 1rem;
            font-size: 0.95rem;
        }
    }

    /* Mobile Product Cards */
    .mobile-product-cards {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .mobile-product-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1.25rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
    }

    .mobile-product-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .mobile-product-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .mobile-details-link {
        color: #ffa000;
        font-size: 1.25rem;
        text-decoration: none;
    }

    .mobile-product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
    }

    .mobile-product-quantity {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .mobile-product-quantity label {
        font-weight: 500;
        color: #64748b;
    }

    .mobile-product-quantity .quantity-select {
        flex: 1;
        max-width: 120px;
    }

    /* Adjust cart buttons container for mobile */
    @media (max-width: 768px) {
        .cart-buttons-container {
            padding: 0 1rem;
            margin-top: 2rem;
        }

        .cart-buttons {
            width: 100%;
            flex-direction: row;
            background: white;
            padding: 0;
            gap: 0.75rem;
        }

        .cart-button {
            flex: 1;
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
        }

        .store-section {
            padding-bottom: 2rem;
        }
    }

    /* Hide horizontal scroll on mobile */
    @media (max-width: 768px) {
        .category-section {
            margin: 0 1rem 1rem;
            overflow: visible;
        }

        .mobile-product-cards {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">STORE</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Store</span>
    </div>
</div>

<!-- Store Content Section -->
<div id="storeContent" class="store-section">
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

    <hr class="announcement-divider">

    <div class="pricing-table-section">
        <table class="pricing-table">
            <thead>
                <tr>
                    <th></th>
                    <th class="price-column">PRICE (RM)</th>
                    <th class="price-column">PRICE (USD)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>NORMAL PRICE</td>
                    <td>349.00 <span class="per-pax">- per pax</span></td>
                    <td>80.00</td>
                </tr>
                <tr>
                    <td>STUDENT PRICE</td>
                    <td>249.00 <span class="per-pax">- per pax</span></td>
                    <td>60.00</td>
                </tr>
                <tr>
                    <td>EARLY BIRD</td>
                    <td>249.00 <span class="per-pax">- per pax</span></td>
                    <td>60.00</td>
                </tr>
                <tr>
                    <td>COMBO**</td>
                    <td>450.00 <span class="per-pax">- per pax</span></td>
                    <td>110.00</td>
                </tr>
                <tr>
                    <td rowspan="3">GROUP PRICE</td>
                    <td>319.00 <span class="per-pax">- 1 to 3pax</span></td>
                    <td>80.00</td>
                </tr>
                <tr>
                    <td>299.00 <span class="per-pax">- 4 to 7pax</span></td>
                    <td>70.00</td>
                </tr>
                <tr>
                    <td>249.00 <span class="per-pax">- 8 pax and above</span></td>
                    <td>60.00</td>
                </tr>
            </tbody>
        </table>
    </div>

    <hr class="announcement-divider">

    <div class="store-container">
        <section class="store-products">
            @php
                $categories = [
                    'Facility Management' => [],
                    'Modular Asia' => [],
                    'Combo' => []
                ];
                
                foreach($tickets as $ticket) {
                    $name = strtolower($ticket->name);
                    if (str_contains($name, 'facility')) {
                        $categories['Facility Management'][] = $ticket;
                    } elseif (str_contains($name, 'modular')) {
                        $categories['Modular Asia'][] = $ticket;
                    } else {
                        $categories['Combo'][] = $ticket;
                    }
                }

                // Sort Facility Management and Modular Asia categories by price
                $categories['Facility Management'] = collect($categories['Facility Management'])
                    ->sortBy('price')
                    ->values()
                    ->all();
                
                $categories['Modular Asia'] = collect($categories['Modular Asia'])
                    ->sortBy('price')
                    ->values()
                    ->all();
            @endphp

            @foreach($categories as $categoryName => $categoryTickets)
                @if(count($categoryTickets) > 0)
                    <div class="category-section">
                        <div class="category-header">{{ $categoryName }}</div>
                        
                        <!-- Desktop Table View -->
                        <div class="d-none d-md-block">
                            <table class="product-table">
                                <thead>
                                    <tr>
                                        <th>Ticket</th>
                                        <th>Price (MYR)</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categoryTickets as $ticket)
                                        <tr data-ticket-id="{{ $ticket->id }}">
                                            <td>
                                                <div class="product-name-cell">
                                                    {{ $ticket->name }}
                                                    <a href="{{ route('client.ticket.detail', $ticket->id) }}" class="details-button">
                                                        <i class="fas fa-info-circle"></i>
                                                        Details
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="product-price">{{ number_format($ticket->price, 2) }}</span>
                                            </td>
                                            <td>
                                                <select class="quantity-select" data-ticket-id="{{ $ticket->id }}">
                                                    <option value="0">0</option>
                                                    @for($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="d-md-none">
                            <div class="mobile-product-cards">
                                @foreach($categoryTickets as $ticket)
                                    <div class="mobile-product-card" data-ticket-id="{{ $ticket->id }}">
                                        <div class="mobile-product-header">
                                            <h3 class="mobile-product-title">{{ $ticket->name }}</h3>
                                            <a href="{{ route('client.ticket.detail', $ticket->id) }}" class="mobile-details-link">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        </div>
                                        <div class="mobile-product-price">
                                            RM {{ number_format($ticket->price, 2) }}
                                        </div>
                                        <div class="mobile-product-quantity">
                                            <label>Quantity:</label>
                                            <select class="quantity-select" data-ticket-id="{{ $ticket->id }}">
                                                <option value="0">0</option>
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <hr class="announcement-divider">

            <!-- Cart Buttons -->
            <div class="cart-buttons-container">
                <div class="cart-buttons">
                    <form id="addToCartForm" action="{{ route('client.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="ticket_data" id="ticketData" value="">
                        <button type="submit" class="cart-button add-to-cart">
                            <span>ADD TO CART</span>
                        </button>
                    </form>
                    <a href="{{ route('client.cart.index') }}" class="cart-button view-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <span>RM {{ number_format($cartTotal ?? 0, 2) }}</span>
                    </a>
                </div>
            </div>
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

<!-- Cart Message Modal -->
<div class="modal fade" id="cartMessageModal" tabindex="-1" aria-labelledby="cartMessageModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cartMessageModalLabel">Cart Message</h5>
      </div>
      <div class="modal-body" id="cartMessageBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

// Cart functionality
document.addEventListener('DOMContentLoaded', function() {
    const addToCartForm = document.getElementById('addToCartForm');
    const quantitySelects = document.querySelectorAll('.quantity-select');
    const cartMessageModal = new bootstrap.Modal(document.getElementById('cartMessageModal'), {
        backdrop: 'static',
        keyboard: false
    });
    const cartMessageBody = document.getElementById('cartMessageBody');
    const cartMessageModalEl = document.getElementById('cartMessageModal');
    const modalHeaderEl = cartMessageModalEl.querySelector('.modal-header');
    
    // Function to handle modal show/hide
    function toggleScrollLock(lock) {
        const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
        document.body.style.paddingRight = lock ? `${scrollbarWidth}px` : '';
        document.body.style.overflow = lock ? 'hidden' : '';
    }

    // Add event listeners for modal events
    cartMessageModalEl.addEventListener('show.bs.modal', function () {
        toggleScrollLock(true);
    });

    cartMessageModalEl.addEventListener('hidden.bs.modal', function () {
        toggleScrollLock(false);
    });
    
    addToCartForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Store current scroll position
        const scrollPos = window.scrollY;
        
        // Collect all selected quantities
        const selectedTickets = [];
        quantitySelects.forEach(select => {
            const quantity = parseInt(select.value);
            if (quantity > 0) {
                // Get the ticket ID from the closest row
                const ticketId = select.closest('tr').dataset.ticketId;
                selectedTickets.push({
                    ticket_id: ticketId,
                    quantity: quantity
                });
            }
        });
        
        if (selectedTickets.length === 0) {
            // Show error in modal
            modalHeaderEl.className = 'modal-header bg-danger text-white';
            cartMessageBody.textContent = 'Please select at least one ticket to add to cart.';
            cartMessageModal.show();
            // Restore scroll position after modal is shown
            window.scrollTo(0, scrollPos);
            return;
        }
        
        // Create a hidden form to submit multiple tickets
        const formData = new FormData();
        selectedTickets.forEach((ticket, index) => {
            formData.append(`tickets[${index}][ticket_id]`, ticket.ticket_id);
            formData.append(`tickets[${index}][quantity]`, ticket.quantity);
        });
        
        // Send AJAX request
        fetch('{{ route('client.cart.add') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success in modal
                modalHeaderEl.className = 'modal-header bg-success text-white';
                cartMessageBody.textContent = data.message;
                cartMessageModal.show();
                
                // Reset all quantity selects to 0
                quantitySelects.forEach(select => {
                    select.value = '0';
                });

                // Update cart total
                if (data.cartTotal !== undefined) {
                    const viewCartBtn = document.querySelector('.view-cart span');
                    if (viewCartBtn) {
                        viewCartBtn.textContent = 'RM ' + parseFloat(data.cartTotal).toFixed(2);
                    }
                }
            } else {
                // Show error in modal
                modalHeaderEl.className = 'modal-header bg-danger text-white';
                cartMessageBody.textContent = data.message || 'Error adding items to cart. Please try again.';
                cartMessageModal.show();
                // Restore scroll position after modal is shown
                window.scrollTo(0, scrollPos);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error in modal
            modalHeaderEl.className = 'modal-header bg-danger text-white';
            cartMessageBody.textContent = 'Error adding items to cart. Please try again.';
            cartMessageModal.show();
            // Restore scroll position after modal is shown
            window.scrollTo(0, scrollPos);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Scroll to store content
    const storeContent = document.getElementById('storeContent');
    if (storeContent) {
        // Add a small delay to ensure smooth scrolling after page load
        setTimeout(() => {
            storeContent.scrollIntoView({ behavior: 'smooth' });
        }, 100);
    }
});
</script>
@endpush