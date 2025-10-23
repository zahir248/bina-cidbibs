@extends('client.layouts.app')

@section('title', 'Business Matching Registration')

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

    .card-header.bg-warning {
        background-color: #e67e00 !important;
        color: white !important;
    }

    .card-header.bg-warning .card-title {
        color: white !important;
    }

    /* Orange icons for date, time, and capacity */
    .fas.fa-calendar-alt,
    .fas.fa-clock,
    .fas.fa-users {
        color: #e67e00 !important;
    }

    /* Orange progress bar */
    .progress-bar {
        background-color: #e67e00 !important;
    }

    /* Panel image styles */
    .panel-image-container {
        flex-shrink: 0;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .panel-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .panel-image-container:empty::before {
        content: "👤";
        font-size: 24px;
        color: #e67e00;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        margin: 0;
        padding: 0;
    }

    .hero-section-store {
        min-height: 100vh;
        min-height: 100svh;
        min-height: 100dvh;
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
        background-attachment: scroll;
        text-align: center;
        position: relative;
        padding: 0 1.5rem;
        box-sizing: border-box;
        margin: 0;
        z-index: 1;
        overflow: hidden;
    }

    @supports (-webkit-touch-callout: none) {
        .hero-section-store {
            min-height: -webkit-fill-available;
            height: -webkit-fill-available;
        }
    }

    .hero-title-store {
        font-size: 4rem;
        font-weight: 800;
        color: white;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        letter-spacing: 1px;
    }

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

    @media screen and (max-width: 992px) {
        .hero-section-store {
            min-height: 100vh;
            min-height: 100svh;
            height: 100vh;
            padding: 0 1rem;
        }
    }

    @media screen and (max-width: 768px) {
        .hero-section-store {
            min-height: 100vh;
            min-height: 100svh;
            min-height: 100dvh;
            height: 100vh;
            height: 100svh;
            height: 100dvh;
            padding: 0 1rem;
        }
        .hero-title-store {
            font-size: 2.5rem;
            max-width: 90vw;
            word-wrap: break-word;
        }
    }

    @media screen and (max-width: 576px) {
        .hero-section-store {
            min-height: 100vh;
            min-height: 100svh;
            min-height: 100dvh;
            height: 100vh;
            height: 100svh;
            height: 100dvh;
            padding: 0 0.75rem;
            padding-top: env(safe-area-inset-top, 0);
            padding-bottom: env(safe-area-inset-bottom, 0);
        }
        .hero-title-store {
            font-size: 2rem;
            max-width: 95vw;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection" style="overflow-x: hidden;">
    <h1 class="hero-title-store">BUSINESS MATCHING</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Business Matching</span>
    </div>
</div>

<!-- Wrapper to prevent horizontal scroll -->
<div style="overflow-x: hidden; width: 100%;">

<!-- Main Content Section -->
<div style="background: #f5f5f5; width: 100%;">
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Business Matching Registration</h1>
                <a href="{{ route('client.business-matching.my-bookings') }}" class="btn btn-outline-warning">
                    <i class="fas fa-calendar-check me-2"></i>My Bookings
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($businessMatchings->count() > 0)
                <div class="row">
                    @foreach($businessMatchings as $businessMatching)
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">{{ $businessMatching->name }}</h5>
                                </div>
                                <div class="card-body">
                                    @if($businessMatching->panels->count() > 0)
                                        <h6 class="fw-bold mb-3"><i class="fas fa-user-tie me-2" style="color: #e67e00;"></i>Panel:</h6>
                                        @foreach($businessMatching->panels->sortBy('order') as $panel)
                                            <div class="mb-3 d-flex align-items-start">
                                                 @if($panel->image)
                                                     <div class="panel-image-container me-3">
                                                         <img src="{{ route('panel-image.show', basename($panel->image)) }}" 
                                                              alt="{{ $panel->name }}" 
                                                              class="panel-image">
                                                     </div>
                                                 @endif
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $panel->name }}</h6>
                                                    @if($panel->description)
                                                        <p class="text-muted mb-0" style="line-height: 1.6;">{{ $panel->description }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    
                                    <p class="card-text text-muted text-justify" style="text-align: justify; line-height: 1.6;">{{ $businessMatching->description }}</p>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            <span class="fw-bold">Date:</span>
                                            <span class="ms-2">{{ $businessMatching->date->format('M d, Y') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-clock me-2"></i>
                                            <span class="fw-bold">Time:</span>
                                            <span class="ms-2">{{ \Carbon\Carbon::parse($businessMatching->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($businessMatching->end_time)->format('H:i') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-users me-2"></i>
                                            <span class="fw-bold">Capacity:</span>
                                            <span class="ms-2">{{ $businessMatching->getTotalParticipants() }}/{{ $businessMatching->timeSlots->count() * 3 }}</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: {{ $businessMatching->getCapacityUtilization() }}%"
                                                 aria-valuenow="{{ $businessMatching->getCapacityUtilization() }}" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ number_format($businessMatching->getCapacityUtilization(), 1) }}% capacity utilized</small>
                                    </div>

                                </div>
                                <div class="card-footer bg-transparent">
                                    @if($hasExistingBooking)
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="fas fa-check-circle me-2"></i>Already Registered
                                        </button>
                                    @elseif($businessMatching->isOpenForRegistration())
                                        <a href="{{ route('client.business-matching.show', $businessMatching) }}" 
                                           class="btn btn-warning w-100">
                                            <i class="fas fa-calendar-plus me-2"></i>Register Now
                                        </a>
                                    @else
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="fas fa-lock me-2"></i>Registration Closed
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No Business Matching Sessions Available</h4>
                    <p class="text-muted">There are currently no business matching sessions open for registration.</p>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endsection
