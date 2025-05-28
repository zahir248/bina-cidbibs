@extends('client.layouts.app')

@section('title', 'BINA | Event Calendar')

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
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('images/hero-hero-section.png') }}') no-repeat center center;
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
    .hero-title-store {
        font-size: clamp(2rem, 8vw, 4rem);
        font-weight: 800;
        color: #fff;
        margin-bottom: 1rem;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    .breadcrumb-store {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        color: #fff;
        font-size: clamp(1rem, 3vw, 1.25rem);
        font-weight: 500;
        flex-wrap: wrap;
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
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">EVENT LIST</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Event List</span>
    </div>
</div>

<!-- Contact Info Section -->
<div class="container py-5">
    <div class="row justify-content-center text-center align-items-start" style="gap:0;">
        <!-- Email -->
        <div class="col-12 col-md-4 mb-4 mb-md-0">
            <div style="font-size:3rem;color:#6b7280;margin-bottom:0.5rem;">
                <i class="fas fa-envelope"></i>
            </div>
            <div style="font-size:1.1rem;color:#22223b;">
                <a href="mailto:bina@cidbibs.com.my" style="color:#22223b;text-decoration:none;">bina@cidbibs.com.my</a>
            </div>
        </div>
        <!-- Phone -->
        <div class="col-12 col-md-4 mb-4 mb-md-0">
            <div style="font-size:3rem;color:#6b7280;margin-bottom:0.5rem;">
                <i class="fas fa-phone-alt"></i>
            </div>
            <div style="font-size:1.1rem;color:#22223b;">
                +603-92242280<br>+6012-6909457
            </div>
        </div>
        <!-- WhatsApp -->
        <div class="col-12 col-md-4">
            <div style="font-size:3rem;color:#6b7280;margin-bottom:0.5rem;">
                <i class="far fa-comment-dots"></i>
            </div>
            <div style="font-size:1.1rem;color:#22223b;">
                +6012 - 690 9457
            </div>
        </div>
    </div>
</div>

<!-- Schedule Plan Section -->
<div class="container py-5">
    <div class="text-center mb-4">
        <div style="color:#ff9800;font-size:1.1rem;font-weight:600;letter-spacing:0.5px;">OUR TIMETABLE</div>
        <h2 style="font-size:2.7rem;font-weight:900;color:#181b2c;letter-spacing:1px;margin-bottom:0.5rem;">OUR SCHEDULE PLAN</h2>
    </div>
    
    @foreach($events as $event)
    <div class="schedule-card d-flex flex-column flex-lg-row align-items-stretch p-3 p-md-4" style="background:#fff;border:1.5px solid #d1d5db;border-radius:1.25rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);gap:2rem;max-width:1200px;margin:0 auto;margin-bottom:2rem;">
        <!-- Left: Event Image -->
        <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="max-width:240px;width:100%;">
            <img src="{{ asset($event->image ?? 'images/event-home-2.jpg') }}" alt="{{ $event->title }}" style="width:100%;max-width:220px;aspect-ratio:1/1;object-fit:cover;border-radius:1.1rem;">
        </div>
        <!-- Center: Event Info -->
        <div class="flex-grow-1 d-flex flex-column justify-content-center px-lg-3" style="min-width:0;border-left:1.5px solid #eee;border-right:1.5px solid #eee;">
            <div class="d-flex align-items-center gap-4 mb-2 flex-wrap" style="font-size:1.08rem;color:#ff9800;font-weight:600;">
                <span><i class="fas fa-map-marker-alt me-1"></i> {{ $event->location }}</span>
                <span><i class="fas fa-calendar-alt me-1"></i> {{ $event->start_date->format('d M Y') }}</span>
                <span><i class="fas fa-clock me-1"></i> {{ $event->start_date->format('h:i A') }} - {{ $event->end_date->format('h:i A') }}</span>
            </div>
            <div style="font-size:1.35rem;font-weight:900;color:#181b2c;line-height:1.3;margin-bottom:0.7rem;">
                {{ $event->title }}
            </div>
            <div style="font-size:1.08rem;color:#6b7280;line-height:1.7;margin-bottom:1.2rem;">
                {{ $event->description }}
            </div>
            <div style="font-size:1.05rem;color:#181b2c;font-weight:600;">by {{ $event->organizer }}</div>
        </div>
        <!-- Right: Buttons -->
        <div class="d-flex flex-column align-items-center justify-content-center gap-3 py-3 px-lg-3" style="min-width:180px;">
            <a href="{{ $event->slug }}" class="btn" style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);color:#fff;font-weight:700;font-size:1.1rem;border-radius:2rem;padding:0.7rem 2.2rem;box-shadow:0 2px 8px rgba(0,0,0,0.08);letter-spacing:0.08em;">VIEW MORE</a>
            <a href="{{ route('client.store') }}" class="btn" style="background:#181b2c;color:#fff;font-weight:700;font-size:1.1rem;border-radius:2rem;padding:0.7rem 2.2rem;box-shadow:0 2px 8px rgba(0,0,0,0.08);letter-spacing:0.08em;">GET TICKET</a>
        </div>
    </div>
    @endforeach
</div>
@endsection 