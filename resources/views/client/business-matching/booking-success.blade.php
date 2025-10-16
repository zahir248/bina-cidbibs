@extends('client.layouts.app')

@section('title', 'Registration Confirmed')

@push('styles')
<style>
    :root {
        --primary-orange: #e67e00;
        --primary-dark: #e67e00;
        --bg-light-gray: #f8fafc;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --mobile-vh: 100vh;
    }

    html { scroll-behavior: smooth; }
    body { margin: 0; padding: 0; }

    .hero-section-store {
        min-height: 100vh; min-height: 100svh; min-height: 100dvh;
        height: 100vh; height: 100svh; height: 100dvh;
        width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center;
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('images/hero-section.png') }}') no-repeat center center;
        background-size: cover; background-attachment: scroll; text-align: center; position: relative;
        padding: 0 1.5rem; box-sizing: border-box; margin: 0; z-index: 1; overflow: hidden;
    }
    @supports (-webkit-touch-callout: none) {
        .hero-section-store { min-height: -webkit-fill-available; height: -webkit-fill-available; }
    }
    .hero-title-store { font-size: 4rem; font-weight: 800; color: white; line-height: 1.2; margin-bottom: 1.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); letter-spacing: 1px; }
    .breadcrumb-store {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        color: #fff;
        font-size: clamp(1rem, 3vw, 1.25rem); /* Responsive font size */
        font-weight: 500;
        flex-wrap: wrap;
        margin-top: 1rem;
        
        /* Ensure it doesn't get too small */
        min-font-size: 0.9rem;
    }

    .breadcrumb-store a {
        color: #fff;
        text-decoration: none;
        opacity: 0.85;
        transition: all 0.3s ease;
    }

    .breadcrumb-store a:hover {
        opacity: 1;
        text-decoration: underline;
        transform: translateY(-2px);
    }

    .breadcrumb-separator {
        color: #fff;
        opacity: 0.7;
        font-size: 1.2em;
    }

    .btn-warning {
        background-color: #e67e00 !important;
        border-color: #e67e00 !important;
        color: white !important;
    }

    .btn-warning:hover {
        background-color: #d47300 !important;
        border-color: #d47300 !important;
        color: white !important;
    }

    .btn-outline-warning {
        color: #e67e00 !important;
        border-color: #e67e00 !important;
    }

    .btn-outline-warning:hover {
        background-color: #e67e00 !important;
        border-color: #e67e00 !important;
        color: white !important;
    }
    @media screen and (max-width: 992px) { .hero-section-store { min-height: 100vh; min-height: 100svh; height: 100vh; padding: 0 1rem; } }
    @media screen and (max-width: 768px) {
        .hero-section-store { min-height: 100vh; min-height: 100svh; min-height: 100dvh; height: 100vh; height: 100svh; height: 100dvh; padding: 0 1rem; }
        .hero-title-store { font-size: 2.5rem; max-width: 90vw; word-wrap: break-word; }
    }
    @media screen and (max-width: 576px) {
        .hero-section-store { min-height: 100vh; min-height: 100svh; min-height: 100dvh; height: 100vh; height: 100svh; height: 100dvh; padding: 0 0.75rem; padding-top: env(safe-area-inset-top, 0); padding-bottom: env(safe-area-inset-bottom, 0); }
        .hero-title-store { font-size: 2rem; max-width: 95vw; }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection" style="overflow-x: hidden;">
    <h1 class="hero-title-store">REGISTRATION CONFIRMED</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <a href="{{ route('client.business-matching.index') }}">Business Matching</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Registration Confirmed</span>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-success">
                <div class="card-header bg-success text-white text-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-check-circle me-2"></i>Registration Confirmed!
                    </h3>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-calendar-check fa-4x text-success"></i>
                    </div>
                    
                    <h4 class="text-success mb-3">Your Business Matching Registration is Confirmed</h4>
                    <p class="text-muted mb-4">You have successfully registered for the business matching session.</p>

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Registration Details</h5>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>Reference:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <span class="badge bg-warning text-dark">{{ $booking->getReferenceNumber() }}</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>Session:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            {{ $booking->businessMatching->name }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>Date:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            {{ $booking->businessMatching->date->format('M d, Y') }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>Time Slot:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            {{ $booking->timeSlot->getFormattedTimeRange() }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>Panel:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <span class="text-muted">Panel will be assigned automatically</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>Participant:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            {{ $booking->participant_name }}
                                        </div>
                                    </div>
                                    @if($booking->company_name)
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>Company:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            {{ $booking->company_name }}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="alert alert-warning" style="background-color: #e67e00; border-color: #e67e00; color: white;">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Important:</strong> Please arrive 15 minutes before your scheduled time slot. 
                            Bring a business card and be prepared to network with other participants.
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('client.business-matching.download', $booking) }}" class="btn btn-warning me-3">
                            <i class="fas fa-download me-2"></i>Download Registration Details
                        </a>
                        <a href="{{ route('client.business-matching.my-bookings') }}" class="btn btn-outline-warning me-3">
                            <i class="fas fa-calendar-check me-2"></i>View My Bookings
                        </a>
                        <a href="{{ route('client.business-matching.index') }}" class="btn btn-outline-warning">
                            <i class="fas fa-calendar-plus me-2"></i>Register for Another Session
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
