@extends('client.layouts.app')

@section('title', 'Business Matching Registration - ' . $businessMatching->name)

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

    .time-slot-card {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        background: white;
        transition: all 0.2s ease;
        cursor: pointer;
        min-height: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .time-slot-card:hover {
        border-color: var(--primary-orange);
        background: #fff7ed;
    }

    .form-check-input:checked + .form-check-label .time-slot-card {
        border-color: var(--primary-orange);
        background: #fff7ed;
        box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.1);
    }

    .time-slot-time {
        font-weight: 600;
        font-size: 1rem;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .time-slot-status {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-check-input:disabled + .form-check-label .time-slot-card,
    .time-slot-card.disabled {
        opacity: 0.6;
        background: #f8f9fa;
        cursor: not-allowed;
        border-color: #e2e8f0;
    }

    .form-check-input:disabled + .form-check-label,
    .form-check-label.disabled {
        cursor: not-allowed;
    }

    .form-check-input:disabled + .form-check-label .time-slot-card:hover,
    .time-slot-card.disabled:hover {
        border-color: #e2e8f0;
        background: #f8f9fa;
        box-shadow: none;
    }

    /* Orange radio buttons and checkboxes */
    .form-check-input[type="radio"]:checked {
        background-color: #e67e00 !important;
        border-color: #e67e00 !important;
    }

    .form-check-input[type="checkbox"]:checked {
        background-color: #e67e00 !important;
        border-color: #e67e00 !important;
    }

    .form-check-input[type="radio"]:focus,
    .form-check-input[type="checkbox"]:focus {
        border-color: #e67e00 !important;
        box-shadow: 0 0 0 0.25rem rgba(230, 126, 0, 0.25) !important;
    }

    /* Orange active input fields */
    .form-control:focus {
        border-color: #e67e00 !important;
        box-shadow: 0 0 0 0.25rem rgba(230, 126, 0, 0.25) !important;
    }

    .form-select:focus {
        border-color: #e67e00 !important;
        box-shadow: 0 0 0 0.25rem rgba(230, 126, 0, 0.25) !important;
    }

    /* Orange progress bar */
    .progress-bar {
        background-color: #e67e00 !important;
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
    <h1 class="hero-title-store">BUSINESS MATCHING</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <a href="{{ route('client.business-matching.index') }}">Business Matching</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>{{ $businessMatching->name }}</span>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">{{ $businessMatching->name }}</h1>
                    <p class="text-muted mb-0">{{ $businessMatching->date->format('M d, Y') }} • {{ \Carbon\Carbon::parse($businessMatching->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($businessMatching->end_time)->format('H:i') }}</p>
                </div>
                <a href="{{ route('client.business-matching.index') }}" class="btn btn-outline-warning">
                    <i class="fas fa-arrow-left me-2"></i>Back to Sessions
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

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Registration Form</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('client.business-matching.store', $businessMatching) }}" method="POST" id="registrationForm">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="participant_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('participant_name') is-invalid @enderror" 
                                               id="participant_name" name="participant_name" 
                                               value="{{ old('participant_name') }}" required>
                                        @error('participant_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="participant_email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('participant_email') is-invalid @enderror" 
                                               id="participant_email" name="participant_email" 
                                               value="{{ old('participant_email') }}" required>
                                        @error('participant_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="participant_phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control @error('participant_phone') is-invalid @enderror" 
                                               id="participant_phone" name="participant_phone" 
                                               value="{{ old('participant_phone') }}" required>
                                        @error('participant_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="company_name" class="form-label">Company Name</label>
                                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                               id="company_name" name="company_name" 
                                               value="{{ old('company_name') }}">
                                        @error('company_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="identity_number" class="form-label">Identity Card Number / Passport <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('identity_number') is-invalid @enderror" 
                                               id="identity_number" name="identity_number" 
                                               value="{{ old('identity_number') }}" required>
                                        @error('identity_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="business_type" class="form-label">Business Type</label>
                                        <select class="form-select @error('business_type') is-invalid @enderror" 
                                                id="business_type" name="business_type">
                                            <option value="">Select Business Type</option>
                                            <option value="Technology" {{ old('business_type') == 'Technology' ? 'selected' : '' }}>Technology</option>
                                            <option value="Manufacturing" {{ old('business_type') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                            <option value="Construction" {{ old('business_type') == 'Construction' ? 'selected' : '' }}>Construction</option>
                                            <option value="Consulting" {{ old('business_type') == 'Consulting' ? 'selected' : '' }}>Consulting</option>
                                            <option value="Other" {{ old('business_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('business_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">Select Time Slot <span class="text-danger">*</span></label>
                                    <div class="row">
                                        @foreach($businessMatching->timeSlots->sortBy('order') as $index => $timeSlot)
                                            @php
                                                $bookingsInSlot = $businessMatching->bookings()->where('time_slot_id', $timeSlot->id)->count();
                                                $isFull = $bookingsInSlot >= 2;
                                            @endphp
                                            <div class="col-md-6 col-lg-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input @error('time_slot_id') is-invalid @enderror" 
                                                           type="radio" 
                                                           name="time_slot_id" 
                                                           id="time_slot_{{ $timeSlot->id }}" 
                                                           value="{{ $timeSlot->id }}" 
                                                           {{ old('time_slot_id') == $timeSlot->id ? 'checked' : '' }}
                                                           {{ $isFull ? 'disabled' : '' }}
                                                           required>
                                                    <label class="form-check-label {{ $isFull ? 'disabled' : '' }}" for="time_slot_{{ $timeSlot->id }}">
                                                        <div class="time-slot-card {{ $isFull ? 'disabled' : '' }}">
                                                            <div class="time-slot-time">{{ $timeSlot->getFormattedTimeRange() }}</div>
                                                            <div class="time-slot-status">
                                                                @if($isFull)
                                                                    <span class="badge bg-danger">Full</span>
                                                                @else
                                                                    <span class="badge bg-success">{{ 2 - $bookingsInSlot }} spots left</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('time_slot_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label for="interests" class="form-label">Areas of Interest</label>
                                    <div class="row">
                                        @php
                                            $interestOptions = [
                                                'Networking', 'Partnership Opportunities', 'Technology Transfer',
                                                'Investment Opportunities', 'Supply Chain', 'Innovation',
                                                'Market Expansion', 'Joint Ventures', 'Research Collaboration'
                                            ];
                                        @endphp
                                        @foreach($interestOptions as $index => $interest)
                                            <div class="col-md-4 col-lg-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="interests[]" value="{{ $interest }}" 
                                                           id="interest_{{ $index }}"
                                                           {{ in_array($interest, old('interests', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="interest_{{ $index }}">
                                                        {{ $interest }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>


                                <div class="d-grid">
                                    <button type="submit" class="btn btn-warning btn-lg">
                                        <i class="fas fa-calendar-plus me-2"></i>Register for Business Matching
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Session Details</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">{{ $businessMatching->description }}</p>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold">Schedule</h6>
                                @foreach($businessMatching->timeSlots->sortBy('order') as $timeSlot)
                                    <div class="mb-1">
                                        <small>{{ $timeSlot->getFormattedTimeRange() }}</small>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mb-3">
                                <h6 class="fw-bold">Available Panels</h6>
                                <small>{{ $businessMatching->panels->count() }} panels available</small>
                                <div class="mt-2">
                                    @foreach($businessMatching->panels->sortBy('order') as $panel)
                                        <div class="mb-1">
                                            <small class="text-muted">{{ $panel->name }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6 class="fw-bold">Capacity</h6>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: {{ $businessMatching->getCapacityUtilization() }}%"
                                         aria-valuenow="{{ $businessMatching->getCapacityUtilization() }}" 
                                         aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-muted">
                                    {{ $businessMatching->getTotalParticipants() }}/{{ $businessMatching->timeSlots->count() * 2 }} participants
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

});
</script>
@endsection
