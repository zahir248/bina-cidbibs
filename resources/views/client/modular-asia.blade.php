@extends('client.layouts.app')

@section('title', 'BINA | Modular Asia Forum & Exhibition 2025')

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
    .ma-logo {
        height: 48px;
        margin-bottom: 0.5rem;
    }
    .ma-card {
        background: #f7f5fa;
        border-radius: 1.25rem;
        padding: 2rem 2rem 1.5rem 2rem;
        box-shadow: 0 2px 12px rgba(80, 80, 120, 0.04);
        color: #22223b;
    }
    .ma-icon {
        color: #ff9800;
        font-size: 1.25rem;
        width: 1.75rem;
        display: inline-block;
        text-align: center;
    }
    .ma-detail-row {
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .ma-title {
        color: #ff9800;
        font-weight: 800;
        font-size: 2rem;
        letter-spacing: 1px;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .ma-headline {
        font-size: 2rem;
        font-weight: 900;
        color: #22223b;
        margin-bottom: 1.25rem;
        margin-top: 1.5rem;
    }
    .ma-desc {
        color: #4b5563;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
        max-width: 600px;
    }
    @media (max-width: 991px) {
        .ma-flex-row {
            flex-direction: column;
        }
        .ma-card {
            margin-top: 2rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">MODULAR ASIA</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Modular Asia</span>
    </div>
</div>

<!-- Main Content Section (as per screenshot) -->
<div class="container py-5">
    <div class="d-flex ma-flex-row flex-lg-row flex-column align-items-start justify-content-between gap-4">
        <!-- Left: Logo, Title, Headline, Description -->
        <div class="flex-grow-1" style="min-width: 300px;">
            <div class="ma-title">
                <img src="{{ asset('images/modular-logo.png') }}" alt="Modular Asia Logo" class="ma-logo" onerror="this.style.display='none'">
            </div>
            <div class="ma-headline">WHERE EXPERTISE MEETS BUSINESS GROWTH!</div>
            <div class="ma-desc">
                Modular Asia leads the charge in transforming the construction and design industry through modular technology. By emphasizing flexibility, efficiency, and sustainability, Modular Asia offers cutting-edge solutions for creating adaptable spaces that cater to diverse needs. Discover how modular designs are reshaping industries, reducing waste, and enhancing operational efficiency, one innovative project at a time.
            </div>
            <!-- Video Preview Section -->
            <div class="ma-video-preview position-relative mt-4" style="max-width: 600px;">
                <img src="{{ asset('images/modular.jpg') }}" alt="Video Preview" style="width:100%; border-radius: 2rem; display:block;">
                <a href="#" id="maPlayBtn" class="ma-play-btn d-flex align-items-center justify-content-center" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:100px;height:100px;background:#ff9800;border-radius:50%;box-shadow:0 4px 24px rgba(0,0,0,0.12);z-index:2;text-decoration:none;">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="24" fill="none"/>
                        <polygon points="20,16 36,24 20,32" fill="#fff"/>
                    </svg>
                </a>
            </div>

            <!-- Video Modal -->
            <div id="maVideoModal" class="ma-modal" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.75);align-items:center;justify-content:center;">
                <div class="ma-modal-content" style="position:relative;max-width:900px;width:90vw;background:none;">
                    <button id="maModalClose" style="position:absolute;top:-40px;right:0;background:none;border:none;font-size:2.5rem;color:#fff;z-index:2;cursor:pointer;">&times;</button>
                    <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:1.5rem;">
                        <iframe id="maVideoIframe" src="" allow="autoplay; encrypted-media" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;border-radius:1.5rem;"></iframe>
                    </div>
                </div>
            </div>

            <!-- Important Points and Schedule Section -->
            <div class="ma-session-points mt-5">
                <div style="font-size:1.25rem;font-weight:600;letter-spacing:0.5px;color:#22223b;margin-bottom:1rem;">IMPORTANT POINTS IN THIS SESSION :</div>
                <ul style="color:#4b5563;font-size:1.08rem;margin-bottom:2rem;">
                    <li style="margin-bottom:0.5rem;">Applications in healthcare, education, and commercial sectors.</li>
                    <li style="margin-bottom:0.5rem;">Trends and opportunities in modular innovation.</li>
                    <li>Interactive discussions with industry experts.</li>
                </ul>
                <div class="ma-schedule-list">
                    @php
                        $currentSession = null;
                    @endphp
                    
                    @foreach($schedules as $schedule)
                        @if($schedule->session && $schedule->session !== $currentSession)
                            @php
                                $currentSession = $schedule->session;
                            @endphp
                            <div style="background:#ff9800;color:#fff;display:inline-block;font-weight:700;font-size:1.1rem;padding:0.5rem 1.2rem 0.4rem 1.2rem;border-radius:0.15rem;margin-bottom:2rem;letter-spacing:0.5px;">
                                SESSION {{ strtoupper($schedule->session) }}
                            </div>
                        @endif
                        
                        @if(!empty($schedule->description))
                            <div class="ma-schedule-row" style="display:flex;align-items:flex-start;margin-bottom:1.5rem;">
                                <span style="font-weight:700;font-size:1.1rem;color:#22223b;min-width:170px;">{{ $schedule->formatted_time }}</span>
                                <span style="color:#ff9800;font-size:2rem;margin:0 18px 0 18px;">|</span>
                                <div>
                                    <div style="font-weight:800;font-size:1.1rem;color:#0a183d;letter-spacing:0.5px;">{{ $schedule->title }}</div>
                                    <div style="margin-top:1rem;margin-bottom:0.5rem;color:#22223b;font-size:1.08rem;max-width:500px;">
                                        {!! nl2br(e($schedule->description)) !!}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="ma-schedule-row" style="display:flex;align-items:center;margin-bottom:1.5rem;">
                                <span style="font-weight:700;font-size:1.1rem;color:#22223b;min-width:170px;">{{ $schedule->formatted_time }}</span>
                                <span style="color:#ff9800;font-size:2rem;margin:0 18px 0 18px;">|</span>
                                <div style="font-weight:800;font-size:1.1rem;color:#0a183d;letter-spacing:0.5px;">
                                    {{ $schedule->title }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('client.store') }}" style="display:inline-block;padding:0.9rem 2.5rem;font-weight:700;letter-spacing:0.15em;font-size:1.1rem;border-radius:2.5rem;background:#ff9800;color:#fff;text-decoration:none;box-shadow:0 2px 8px rgba(0,0,0,0.08);transition:background 0.2s;">GET TICKET</a>
                </div>
            </div>
        </div>
        <!-- Right: Event Details Card -->
        <div>
            <div class="ma-card" style="min-width:270px;max-width:340px;">
                <div class="mb-3" style="font-weight:700;font-size:1.1rem;">
                    Join us at <span style="font-weight:900;">Modular Asia Forum & Exhibition 2025</span>, where innovation meets sustainability. Discover how modular designs are transforming industries and shaping a smarter future.
                </div>
                <div class="ma-detail-row">
                    <span class="ma-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>MITEC, Kuala Lumpur</span>
                </div>
                <div class="ma-detail-row">
                    <span class="ma-icon"><i class="fas fa-calendar-alt"></i></span>
                    <span>30 Oct 2025</span>
                </div>
                <div class="ma-detail-row">
                    <span class="ma-icon"><i class="fas fa-clock"></i></span>
                    <span>08 AM – 05 PM</span>
                </div>
            </div>
            <!-- Speaker Card -->
            <div style="background:#ffefdf;border-radius:1.5rem;padding:2rem 1.5rem 1.5rem 1.5rem;margin-top:2rem;max-width:340px;">
                <div style="font-size:1.35rem;font-weight:500;color:#181b2c;margin-bottom:1.2rem;">SPEAKER :</div>
                <div style="display:flex;align-items:center;margin-bottom:1.2rem;">
                    <div style="width:60px;height:60px;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;overflow:hidden;margin-right:1.2rem;">
                        <img src='https://www.w3schools.com/howto/img_avatar.png' alt='Speaker Avatar' style='width:60px;height:60px;object-fit:cover;border-radius:50%;'>
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:1.15rem;color:#181b2c;">SPEAKER NAME</div>
                        <div style="color:#6b7280;font-size:1rem;">Event Conference</div>
                    </div>
                </div>
                <div style="font-size:1.08rem;color:#181b2c;margin-bottom:0.7rem;">Share This :</div>
                <div style="display:flex;gap:0.7rem;">
                    <a href="#" style="display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;background:#ff9800;border-radius:50%;color:#fff;font-size:1.3rem;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" style="display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;background:#ff9800;border-radius:50%;color:#fff;font-size:1.3rem;"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var playBtn = document.getElementById('maPlayBtn');
    var modal = document.getElementById('maVideoModal');
    var closeBtn = document.getElementById('maModalClose');
    var iframe = document.getElementById('maVideoIframe');
    var videoUrl = 'https://www.youtube.com/embed/4BUA0YC8UeU?autoplay=1&rel=0&showinfo=0';

    playBtn.addEventListener('click', function(e) {
        e.preventDefault();
        iframe.src = videoUrl;
        modal.style.display = 'flex';
    });
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        iframe.src = '';
    });
    // Close modal when clicking outside the video
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            iframe.src = '';
        }
    });
});
</script>
@endpush 