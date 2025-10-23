@extends('client.layouts.app')

@section('title', 'My Business Matching Bookings')

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

    /* Orange input field focus */
    .form-control:focus {
        border-color: #e67e00 !important;
        box-shadow: 0 0 0 0.25rem rgba(230, 126, 0, 0.25) !important;
    }

    /* Orange icons */
    .fas.fa-calendar-alt,
    .fas.fa-clock,
    .fas.fa-users,
    .fas.fa-hashtag {
        color: #e67e00 !important;
    }

    /* Orange Details button */
    .btn-outline-info {
        color: #e67e00 !important;
        border-color: #e67e00 !important;
    }

    .btn-outline-info:hover {
        background-color: #e67e00 !important;
        border-color: #e67e00 !important;
        color: white !important;
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
    <h1 class="hero-title-store">MY BOOKINGS</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <a href="{{ route('client.business-matching.index') }}">Business Matching</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>My Bookings</span>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">My Business Matching Bookings</h1>
                <a href="{{ route('client.business-matching.index') }}" class="btn btn-warning">
                    <i class="fas fa-calendar-plus me-2"></i>Register for New Session
                </a>
            </div>

            <!-- Search Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Find Your Bookings</h5>
                    <p class="text-muted">Enter your email address to view your business matching bookings.</p>
                    <form method="GET" action="{{ route('client.business-matching.my-bookings') }}">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email') }}" placeholder="Enter your email address" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-search me-2"></i>Find Bookings
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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

            @if($bookings->count() > 0)
                <div class="row">
                    @foreach($bookings as $booking)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">{{ $booking->businessMatching->name }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            <span class="fw-bold">Date:</span>
                                            <span class="ms-2">{{ $booking->businessMatching->date->format('M d, Y') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-clock me-2"></i>
                                            <span class="fw-bold">Time:</span>
                                            <span class="ms-2">{{ $booking->timeSlot->getFormattedTimeRange() }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-hashtag me-2"></i>
                                            <span class="fw-bold">Reference:</span>
                                            <span class="ms-2">{{ $booking->getReferenceNumber() }}</span>
                                        </div>
                                    </div>

                                    @if($booking->company_name)
                                        <div class="mb-3">
                                            <strong>Company:</strong> {{ $booking->company_name }}
                                        </div>
                                    @endif

                                    @if($booking->business_type)
                                        <div class="mb-3">
                                            <strong>Business Type:</strong> {{ $booking->business_type }}
                                        </div>
                                    @endif

                                    @if($booking->interests && count($booking->interests) > 0)
                                        <div class="mb-3">
                                            <strong>Interests:</strong>
                                            <div class="mt-1">
                                                @foreach($booking->interests as $interest)
                                                    <span class="badge bg-light text-dark me-1 mb-1">{{ $interest }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if($booking->notes)
                                        <div class="mb-3">
                                            <strong>Notes:</strong>
                                            <p class="text-muted small">{{ $booking->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex gap-2">
                                        @if(!$booking->businessMatching->date->isPast())
                                            <form action="{{ route('client.business-matching.cancel', $booking) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-times me-1"></i>Cancel
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <button type="button" class="btn btn-outline-info btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#bookingModal{{ $booking->id }}">
                                            <i class="fas fa-eye me-1"></i>Details
                                        </button>
                                        
                                        <a href="{{ route('client.business-matching.download', $booking) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Details Modal -->
                        <div class="modal fade" id="bookingModal{{ $booking->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Booking Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Session Information</h6>
                                                <p><strong>Name:</strong> {{ $booking->businessMatching->name }}</p>
                                                <p><strong>Date:</strong> {{ $booking->businessMatching->date->format('M d, Y') }}</p>
                                                <p><strong>Time:</strong> {{ $booking->businessMatching->start_time }} - {{ $booking->businessMatching->end_time }}</p>
                                                <p><strong>Description:</strong> {{ $booking->businessMatching->description }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Your Details</h6>
                                                <p><strong>Name:</strong> {{ $booking->participant_name }}</p>
                                                <p><strong>Email:</strong> {{ $booking->participant_email }}</p>
                                                @if($booking->participant_phone)
                                                    <p><strong>Phone:</strong> {{ $booking->participant_phone }}</p>
                                                @endif
                                                @if($booking->company_name)
                                                    <p><strong>Company:</strong> {{ $booking->company_name }}</p>
                                                @endif
                                                @if($booking->business_type)
                                                    <p><strong>Business Type:</strong> {{ $booking->business_type }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Assignment</h6>
                                                <p><strong>Time Slot:</strong> {{ $booking->timeSlot->getFormattedTimeRange() }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Status & Reference</h6>
                                                <p><strong>Status:</strong> Registered</p>
                                                <p><strong>Reference:</strong> {{ $booking->getReferenceNumber() }}</p>
                                                <p><strong>Booked:</strong> {{ $booking->created_at->format('M d, Y H:i') }}</p>
                                            </div>
                                        </div>

                                        @if($booking->interests && count($booking->interests) > 0)
                                            <div class="mt-3">
                                                <h6 class="fw-bold">Areas of Interest</h6>
                                                <div>
                                                    @foreach($booking->interests as $interest)
                                                        <span class="badge bg-light text-dark me-1 mb-1">{{ $interest }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        @if($booking->notes)
                                            <div class="mt-3">
                                                <h6 class="fw-bold">Additional Notes</h6>
                                                <p class="text-muted">{{ $booking->notes }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @if($email)
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Bookings Found</h4>
                        <p class="text-muted">No business matching bookings found for: <strong>{{ $email }}</strong></p>
                        <p class="text-muted">Please check your search term or register for a business matching session.</p>
                        <a href="{{ route('client.business-matching.index') }}" class="btn btn-warning">
                            <i class="fas fa-calendar-plus me-2"></i>Register for Business Matching
                        </a>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-id-card fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Enter Your Email or Name</h4>
                        <p class="text-muted">Please enter your email address or name above to view your business matching bookings.</p>
                    </div>
                @endif
            @endif
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
