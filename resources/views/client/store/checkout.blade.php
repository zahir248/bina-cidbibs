@extends('client.layouts.app')

@section('title', 'BINA | Checkout')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        color: #ff9900;
        display: flex;
        justify-content: space-between;
        margin-top: 1rem;
    }

    .checkout-summary-label {
        color: #1e293b;
        font-weight: 600;
    }

    .checkout-summary-value {
        color: #ff9900;
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

    /* Custom radio button styles */
    input[type="radio"] {
        appearance: none;
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border: 2px solid #ff9900;
        border-radius: 50%;
        outline: none;
        position: relative;
        margin-right: 10px;
        cursor: pointer;
    }

    input[type="radio"]:checked {
        background-color: #ff9900;
    }

    input[type="radio"]:checked::before {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: white;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Participant Form Styles */
    .participant-form {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6 !important;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .participant-form h6 {
        color: #495057;
        font-weight: 600;
        border-bottom: 2px solid #ff9900;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }

    .participant-form .form-control {
        border: 1px solid #ced4da;
    }

    .participant-form .form-control:focus {
        border-color: #ff9900;
        box-shadow: 0 0 0 0.2rem rgba(255, 153, 0, 0.25);
    }

    .participant-form .is-invalid {
        border-color: #dc3545;
    }

    .participant-info {
        background-color: #e3f2fd;
        border-left: 4px solid #2196f3;
        padding: 1rem;
        border-radius: 4px;
    }

    /* Red asterisk for required fields */
    .required {
        color: #dc3545;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
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

<!-- Checkout Content Section -->
<div id="checkoutContent" class="container">
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
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="e.g. John" maxlength="10" required>
                        @error('first_name')<div class="error">Billing First name is a required field.</div>@enderror
                    </div>
                    <div>
                        <label for="last_name">Last Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="e.g. Doe" maxlength="10" required>
                        @error('last_name')<div class="error">Billing Last name is a required field.</div>@enderror
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <label for="gender">Gender <span class="required">*</span></label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="" disabled selected>Select your gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')<div class="error">Gender is a required field.</div>@enderror
                    </div>
                    <div>
                        <label for="category">Category <span class="required">*</span> <i class="fas fa-info-circle" style="color: #ff9800;" data-bs-toggle="tooltip" data-bs-placement="top" title="For B2B transactions, select 'Organization' to enable FPX online banking for corporate payments."></i></label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="" disabled selected>Select your category</option>
                            <option value="individual" {{ old('category') == 'individual' ? 'selected' : '' }}>Individual</option>
                            <option value="academician" {{ old('category') == 'academician' ? 'selected' : '' }}>Academician</option>
                            <option value="organization" {{ old('category') == 'organization' ? 'selected' : '' }}>Organization</option>
                        </select>
                        @error('category')<div class="error">Category is a required field.</div>@enderror
                    </div>
                </div>
                <div>
                    <label for="identity_number">Identity Card Number / Passport <span class="required">*</span> <i class="fas fa-info-circle" style="color: #ff9800;" data-bs-toggle="tooltip" data-bs-placement="top" title="For Malaysian citizens, please enter your IC number. For international customers, please enter your passport number."></i></label>
                    <input type="text" class="form-control" id="identity_number" name="identity_number" value="{{ old('identity_number') }}" placeholder="e.g. 901234567890 or A12345678" required>
                    @error('identity_number')<div class="error">Identity Card Number/Passport is a required field.</div>@enderror
                </div>
                
                <!-- B2B Fields (shown only when organization is selected) -->
                <div id="b2b-fields" style="display: none;">
                    <div class="form-row">
                        <div>
                            <label for="company_name">Company Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="e.g. ABC Corporation">
                            @error('company_name')<div class="error">Company name is a required field for organizations.</div>@enderror
                        </div>
                        <div>
                            <label for="business_registration_number">Business Registration Number <span class="required">*</span></label>
                            <input type="text" class="form-control" id="business_registration_number" name="business_registration_number" value="{{ old('business_registration_number') }}" placeholder="e.g. 123456789">
                            @error('business_registration_number')<div class="error">Business registration number is a required field for organizations.</div>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="tax_number">Tax Number (if applicable)</label>
                        <input type="text" class="form-control" id="tax_number" name="tax_number" value="{{ old('tax_number') }}" placeholder="e.g. TAX123456">
                        @error('tax_number')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Academician Fields (shown only when academician is selected) -->
                <div id="academician-fields" style="display: none;">
                    <div class="form-row">
                        <div>
                            <label for="student_id">Student ID <span class="required">*</span></label>
                            <input type="text" class="form-control" id="student_id" name="student_id" value="{{ old('student_id') }}" placeholder="e.g. A12345">
                            @error('student_id')<div class="error">Student ID is a required field for academicians.</div>@enderror
                        </div>
                        <div>
                            <label for="academic_institution">Academic Institution <span class="required">*</span></label>
                            <input type="text" class="form-control" id="academic_institution" name="academic_institution" value="{{ old('academic_institution') }}" placeholder="e.g. University of Malaysia">
                            @error('academic_institution')<div class="error">Academic Institution is a required field for academicians.</div>@enderror
                        </div>
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

                <!-- Divider between sections -->
                <hr class="my-4" style="border-color: #dee2e6; border-width: 2px;">

                <!-- Participant Details Section -->
                <div class="checkout-form-col" id="participantDetailsSection" style="display: none;">
                    <div class="checkout-title">Participant Details</div>
                    <div class="participant-info mb-3">
                        <p class="text-muted">Please provide details for each participant attending the event.</p>
                    </div>
                    <div id="participantForms">
                        <!-- Participant forms will be dynamically generated here -->
                    </div>
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
                <div class="payment-info mt-3">
                    <h6 class="mb-3">Available Payment Methods:</h6>
                    <div class="payment-method-info mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-university me-2"></i>
                            <strong>FPX Online Banking (Malaysia Only)</strong>
                        </div>
                        <div class="ms-4 text-muted">Pay securely with ToyyibPay FPX.</div>
                    </div>
                    <div class="payment-method-info mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-credit-card me-2"></i>
                            <strong>Credit/Debit Card (International)</strong>
                        </div>
                        <div class="ms-4 text-muted">Pay securely with Stripe.</div>
                    </div>
                </div>
                <div class="text-muted mt-3" style="font-size:0.97rem;">
                    Your personal data will be used to process your order, support your experience, and for other purposes described in our privacy policy.
                </div>
                <button type="submit" form="checkoutForm" class="btn btn-checkout mt-3">Proceed to Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Method Modal -->
<div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentMethodModalLabel">Select Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="payment-method-option mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <input type="radio" name="modal_payment_method" id="modal_toyyibpay" value="toyyibpay" class="me-2">
                        <label for="modal_toyyibpay" class="mb-0">
                            <strong>FPX Online Banking (Malaysia Only)</strong>
                        </label>
                    </div>
                    <div class="ms-4 text-muted">
                        Pay securely using Malaysian online banking via ToyyibPay FPX.
                    </div>
                </div>
                <div class="payment-method-option">
                    <div class="d-flex align-items-center mb-2">
                        <input type="radio" name="modal_payment_method" id="modal_stripe" value="stripe" class="me-2">
                        <label for="modal_stripe" class="mb-0">
                            <strong>Credit/Debit Card (International)</strong>
                        </label>
                    </div>
                    <div class="ms-4 text-muted">
                        Pay securely using credit or debit card via Stripe.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn rounded-pill px-4" id="confirmPaymentMethod" style="background-color: #ff9900; color: white;">Continue to Payment</button>
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
    const firstName = document.getElementById('first_name');
    const lastName = document.getElementById('last_name');
    const companyName = document.getElementById('company_name');
    const category = document.getElementById('category');

    // Payment Method Modal
    const paymentMethodModal = new bootstrap.Modal(document.getElementById('paymentMethodModal'));

    // Create validation modal
    const validationModalHtml = `
        <div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold" id="validationModalLabel" style="color: #dc3545;">
                            <i class="fas fa-exclamation-circle me-2"></i>Validation Error
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center pb-4">
                        <div class="validation-icon mb-3">
                            <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #dc3545;"></i>
                        </div>
                        <div id="validationMessage" style="font-size: 1.1rem; color: #dc3545; font-weight: 500;"></div>
                    </div>
                    <div class="modal-footer border-0 justify-content-center pb-4">
                        <button type="button" class="btn px-4 py-2 rounded-pill" 
                                data-bs-dismiss="modal" 
                                style="background-color: #ff9900; color: white; font-weight: 500; min-width: 120px;">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', validationModalHtml);
    const validationModal = new bootstrap.Modal(document.getElementById('validationModal'));

    function showValidationError(message) {
        document.getElementById('validationMessage').textContent = message;
        validationModal.show();
    }

    function validateName() {
        // Check individual name lengths
        if (firstName.value.length > 10) {
            showValidationError('First name should not exceed 10 characters.');
            return false;
        }
        if (lastName.value.length > 10) {
            showValidationError('Last name should not exceed 10 characters.');
            return false;
        }

        // Check combined name length
        const fullName = `${firstName.value} ${lastName.value}`;
        if (fullName.length > 20) {
            showValidationError('Please use shorter first and last names. Combined name should not exceed 20 characters.');
            return false;
        }

        // Check company name if organization is selected
        if (category.value === 'organization' && companyName) {
            if (companyName.value.length > 30) {
                showValidationError('Company name should not exceed 30 characters.');
                return false;
            }
        }

        return true;
    }

    // Validate identity number
    function validateIdentityNumber() {
        const identityNumber = document.getElementById('identity_number');
        const value = identityNumber.value.trim();
        
        // Basic validation for length
        if (value.length < 6 || value.length > 20) {
            showValidationError('Identity Card Number/Passport must be between 6 and 20 characters.');
            return false;
        }
        
        // Basic format validation - alphanumeric only
        if (!/^[A-Za-z0-9]+$/.test(value)) {
            showValidationError('Identity Card Number/Passport can only contain letters and numbers.');
            return false;
        }
        
        return true;
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate name lengths first
        if (!validateName()) {
            return;
        }

        // Validate identity number
        if (!validateIdentityNumber()) {
            return;
        }

        // Validate participant details if there are multiple tickets
        if (hasMultipleTickets() && !validateParticipantDetails()) {
            return;
        }

        // Show payment method modal if validation passes
        paymentMethodModal.show();
    });

    // Check if there are tickets to collect participant details
    function hasMultipleTickets() {
        const cartItems = @json($cartItems);
        let totalTickets = 0;
        
        cartItems.forEach(item => {
            totalTickets += item.quantity;
        });
        
        return totalTickets >= 1;
    }

    // Show participant details section
    function showParticipantDetails() {
        const participantSection = document.getElementById('participantDetailsSection');
        const participantForms = document.getElementById('participantForms');
        
        // Generate participant forms
        generateParticipantForms();
        
        // Show the section
        participantSection.style.display = 'block';
        
        // Scroll to the section
        participantSection.scrollIntoView({ behavior: 'smooth' });
    }

    // Generate participant forms based on cart items
    function generateParticipantForms() {
        const participantForms = document.getElementById('participantForms');
        const cartItems = @json($cartItems);
        let ticketNumber = 1;
        
        participantForms.innerHTML = '';
        
        cartItems.forEach(item => {
            for (let i = 0; i < item.quantity; i++) {
                const participantForm = createParticipantForm(item, ticketNumber, i + 1);
                participantForms.appendChild(participantForm);
                ticketNumber++;
            }
        });
    }

    // Create individual participant form
    function createParticipantForm(item, ticketNumber, itemNumber) {
        const formDiv = document.createElement('div');
        formDiv.className = 'participant-form mb-4 p-3 border rounded';
        formDiv.innerHTML = `
            <h6 class="mb-3">Participant ${ticketNumber} - ${item.ticket.name}</h6>
            <div class="form-row">
                <div>
                    <label for="participant_full_name_${ticketNumber}">Full Name <span class="required">*</span></label>
                    <input type="text" class="form-control" id="participant_full_name_${ticketNumber}" name="participants[${ticketNumber}][full_name]" required>
                </div>
                <div>
                    <label for="participant_phone_${ticketNumber}">Phone <span class="required">*</span></label>
                    <input type="text" class="form-control" id="participant_phone_${ticketNumber}" name="participants[${ticketNumber}][phone]" placeholder="e.g. 0123456789" required pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="participant_email_${ticketNumber}">Email Address <span class="required">*</span> <i class="fas fa-info-circle" style="color: #ff9800;" data-bs-toggle="tooltip" data-bs-placement="top" title="Please provide your active email address. This will be used to send your purchase confirmation and can be used to retrieve your purchase information if you register an account later."></i></label>
                    <input type="email" class="form-control" id="participant_email_${ticketNumber}" name="participants[${ticketNumber}][email]" required>
                </div>
                <div>
                    <label for="participant_gender_${ticketNumber}">Gender <span class="required">*</span></label>
                    <select class="form-control" id="participant_gender_${ticketNumber}" name="participants[${ticketNumber}][gender]" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="participant_company_${ticketNumber}">Company Name</label>
                    <input type="text" class="form-control" id="participant_company_${ticketNumber}" name="participants[${ticketNumber}][company_name]">
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="participant_identity_${ticketNumber}">Identity Card Number / Passport <span class="required">*</span> <i class="fas fa-info-circle" style="color: #ff9800;" data-bs-toggle="tooltip" data-bs-placement="top" title="For Malaysian citizens, please enter your IC number. For international customers, please enter your passport number."></i></label>
                    <input type="text" class="form-control" id="participant_identity_${ticketNumber}" name="participants[${ticketNumber}][identity_number]" placeholder="e.g. 901234567890 or A12345678" required>
                </div>
            </div>
            <input type="hidden" name="participants[${ticketNumber}][ticket_id]" value="${item.ticket_id}">
            <input type="hidden" name="participants[${ticketNumber}][ticket_number]" value="${ticketNumber}">
        `;
        
        return formDiv;
    }



    // Validate participant details
    function validateParticipantDetails() {
        const participantForms = document.querySelectorAll('.participant-form');
        let isValid = true;
        
        participantForms.forEach(form => {
            const requiredFields = form.querySelectorAll('input[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
        });
        
        if (!isValid) {
            alert('Please fill in all required participant details.');
        }
        
        return isValid;
    }

    // Initialize participant section
    if (hasMultipleTickets()) {
        showParticipantDetails();
    }

    // Handle payment method selection
    document.getElementById('confirmPaymentMethod').addEventListener('click', function() {
        const selectedMethod = document.querySelector('input[name="modal_payment_method"]:checked');
        if (!selectedMethod) {
            alert('Please select a payment method');
            return;
        }
        
        // Add payment_method to form data
        const paymentMethodInput = document.createElement('input');
        paymentMethodInput.type = 'hidden';
        paymentMethodInput.name = 'payment_method';
        paymentMethodInput.value = selectedMethod.value;
        form.appendChild(paymentMethodInput);
        
        // Hide modal
        paymentMethodModal.hide();
        
        // Submit form
        form.submit();
    });

    // ... rest of your existing script ...
});

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});

// Handle B2B fields visibility
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category');
    const b2bFields = document.getElementById('b2b-fields');
    const academicianFields = document.getElementById('academician-fields');
    const companyName = document.getElementById('company_name');
    const businessRegistrationNumber = document.getElementById('business_registration_number');
    const studentId = document.getElementById('student_id');
    const academicInstitution = document.getElementById('academic_institution');

    function toggleB2BFields() {
        if (categorySelect.value === 'organization') {
            b2bFields.style.display = 'block';
            academicianFields.style.display = 'none';
            companyName.required = true;
            businessRegistrationNumber.required = true;
            studentId.required = false;
            academicInstitution.required = false;
        } else if (categorySelect.value === 'academician') {
            b2bFields.style.display = 'none';
            academicianFields.style.display = 'block';
            companyName.required = false;
            businessRegistrationNumber.required = false;
            studentId.required = true;
            academicInstitution.required = true;
        } else {
            b2bFields.style.display = 'none';
            academicianFields.style.display = 'none';
            companyName.required = false;
            businessRegistrationNumber.required = false;
            studentId.required = false;
            academicInstitution.required = false;
        }
    }

    // Initial check
    toggleB2BFields();

    // Listen for changes
    categorySelect.addEventListener('change', toggleB2BFields);
});

document.addEventListener('DOMContentLoaded', function() {
    // Scroll to checkout content
    const checkoutContent = document.getElementById('checkoutContent');
    if (checkoutContent) {
        // Add a small delay to ensure smooth scrolling after page load
        setTimeout(() => {
            checkoutContent.scrollIntoView({ behavior: 'smooth' });
        }, 100);
    }

    // Existing checkout page JavaScript
    const categorySelect = document.getElementById('category');
    const b2bFields = document.getElementById('b2b-fields');
    const academicianFields = document.getElementById('academician-fields');
    const companyName = document.getElementById('company_name');
    const businessRegistrationNumber = document.getElementById('business_registration_number');
    const studentId = document.getElementById('student_id');
    const academicInstitution = document.getElementById('academic_institution');

    if (categorySelect) {
        // Show/hide fields based on initial value
        if (categorySelect.value === 'organization') {
            b2bFields.style.display = 'block';
            academicianFields.style.display = 'none';
            companyName.required = true;
            businessRegistrationNumber.required = true;
            studentId.required = false;
            academicInstitution.required = false;
        } else if (categorySelect.value === 'academician') {
            b2bFields.style.display = 'none';
            academicianFields.style.display = 'block';
            companyName.required = false;
            businessRegistrationNumber.required = false;
            studentId.required = true;
            academicInstitution.required = true;
        }

        // Show/hide fields on change
        categorySelect.addEventListener('change', function() {
            if (this.value === 'organization') {
                b2bFields.style.display = 'block';
                academicianFields.style.display = 'none';
                companyName.required = true;
                businessRegistrationNumber.required = true;
                studentId.required = false;
                academicInstitution.required = false;
            } else if (this.value === 'academician') {
                b2bFields.style.display = 'none';
                academicianFields.style.display = 'block';
                companyName.required = false;
                businessRegistrationNumber.required = false;
                studentId.required = true;
                academicInstitution.required = true;
            } else {
                b2bFields.style.display = 'none';
                academicianFields.style.display = 'none';
                companyName.required = false;
                businessRegistrationNumber.required = false;
                studentId.required = false;
                academicInstitution.required = false;
            }
        });
    }

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush