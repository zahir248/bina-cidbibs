@extends('client.layouts.app')

@section('title', 'BINA | Podcast')

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
    
    /* Audio Player Styles */
    .audio-player-container {
        position: relative;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .play-button {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(90deg,#ff9800 0%,#ffb347 100%);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .play-button:hover {
        transform: scale(1.05);
    }
    
    .play-button i {
        color: white;
        font-size: 1.2rem;
    }
    
    .audio-player {
        display: none;
    }
    
    .audio-progress {
        flex-grow: 1;
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        position: relative;
        cursor: pointer;
    }
    
    .audio-progress-bar {
        position: absolute;
        height: 100%;
        background: #ff9800;
        border-radius: 2px;
        width: 0%;
    }
    
    .audio-time {
        font-size: 0.9rem;
        color: #64748b;
        min-width: 100px;
        text-align: right;
    }
    
    /* YouTube Player Container */
    .youtube-player-container {
        display: none;
        position: fixed;
        bottom: 0;
        right: 0;
        width: 1px;
        height: 1px;
        z-index: -1;
    }
    
    /* Loading State */
    .play-button.loading i {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">PODCAST</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Podcast</span>
    </div>
</div>
<!-- Main Content Section -->
<div class="container py-5">
    <div class="podcast-info-card d-flex flex-column flex-md-row align-items-stretch p-3 p-md-4" style="background:#fff;border:1.5px solid #22223b;border-radius:1.25rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);gap:2rem;max-width:1100px;margin:0 auto;">
        <!-- Left: Image -->
        <div class="flex-shrink-0" style="max-width:340px;width:100%;display:flex;align-items:center;justify-content:center;">
            <img src="{{ asset('images/podcast-1.png') }}" alt="FM Podcast" style="width:100%;max-width:320px;aspect-ratio:4/3;object-fit:cover;border-radius:1.1rem;">
        </div>
        <!-- Right: Text -->
        <div class="flex-grow-1 d-flex flex-column justify-content-center" style="min-width:0;">
            <div style="background:#e5e7eb;border-radius:0.75rem;padding:0.5rem 1.5rem 0.5rem 1.5rem;display:inline-block;font-size:1.35rem;font-weight:800;color:#22223b;margin-bottom:1.1rem;">WHAT IS FM PODCAST?</div>
            <div style="font-size:1.13rem;color:#374151;line-height:1.7;">
                Facility Management (FM) is an integral part of the built environment, ensuring operational efficiency, sustainability, and long-term asset value. As the industry <b>embraces digitalisation and innovation</b>, there is a growing need for <b>knowledge-sharing platforms</b> that connect stakeholders and provide insights into <b>industry best practices</b>.
            </div>
        </div>
    </div>
</div>
<!-- WHY CIDB IBS Section -->
<div class="container py-5">
    <div class="text-center mb-2">
        <h2 style="font-size:2.7rem;font-weight:900;color:#181b2c;letter-spacing:1px;margin-bottom:0.5rem;">WHY CIDB IBS?</h2>
        <div style="color:#ff9800;font-size:1.15rem;font-weight:600;margin-bottom:2.5rem;">
            THIS YEAR WE BRINGS YOU INDUSTRY LEADERS, INNOVATORS, AND DECISION-MAKERS AT THE PREMIER EVENT OF THE YEAR!
        </div>
    </div>
    <div class="row g-4 justify-content-center align-items-stretch">
        <div class="col-md-6 d-flex">
            <div class="d-flex flex-column h-100 w-100" style="background:#faf7fd;border-radius:1rem;padding:2rem 1.5rem;box-shadow:0 2px 12px rgba(80,80,120,0.03);border:1.5px solid #e5e7eb;">
                <div style="background:#fff;border-radius:0.75rem;padding:0.7rem 1.5rem;font-size:1.25rem;font-weight:700;color:#181b2c;box-shadow:0 1px 4px rgba(80,80,120,0.03);border:1.5px solid #d1d5db;display:inline-block;margin-bottom:1.2rem;">ESTABLISHED INDUSTRY LEADERSHIP</div>
                <div style="font-size:1.08rem;color:#181b2c;line-height:1.7;">
                    As the leading body for IBS in Malaysia, CIDB IBS has an unmatched network and reputation within the construction industry. This gives us the credibility needed to attract high-profile experts and industry leaders to participate in the podcast series.
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex">
            <div class="d-flex flex-column h-100 w-100" style="background:#faf7fd;border-radius:1rem;padding:2rem 1.5rem;box-shadow:0 2px 12px rgba(80,80,120,0.03);border:1.5px solid #e5e7eb;">
                <div style="background:#fff;border-radius:0.75rem;padding:0.7rem 1.5rem;font-size:1.25rem;font-weight:700;color:#181b2c;box-shadow:0 1px 4px rgba(80,80,120,0.03);border:1.5px solid #d1d5db;display:inline-block;margin-bottom:1.2rem;">ACCESS TO RESOURCES</div>
                <div style="font-size:1.08rem;color:#181b2c;line-height:1.7;">
                    CIDB IBS has the infrastructure, knowledge, and relationships to effectively host and produce this podcast. With our existing team and resources, we can easily integrate the podcast into our broader marketing and branding strategy.
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex">
            <div class="d-flex flex-column h-100 w-100" style="background:#faf7fd;border-radius:1rem;padding:2rem 1.5rem;box-shadow:0 2px 12px rgba(80,80,120,0.03);border:1.5px solid #e5e7eb;">
                <div style="background:#fff;border-radius:0.75rem;padding:0.7rem 1.5rem;font-size:1.25rem;font-weight:700;color:#181b2c;box-shadow:0 1px 4px rgba(80,80,120,0.03);border:1.5px solid #d1d5db;display:inline-block;margin-bottom:1.2rem;">COMMITMENT TO INNOVATION</div>
                <div style="font-size:1.08rem;color:#181b2c;line-height:1.7;">
                    CIDB IBS is a pioneer in driving innovation within the construction sector, with it's BINA brand and launching this podcast aligns with our core mission of fostering growth and modernization within the industry.
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex">
            <div class="d-flex flex-column h-100 w-100" style="background:#faf7fd;border-radius:1rem;padding:2rem 1.5rem;box-shadow:0 2px 12px rgba(80,80,120,0.03);border:1.5px solid #e5e7eb;">
                <div style="background:#fff;border-radius:0.75rem;padding:0.7rem 1.5rem;font-size:1.25rem;font-weight:700;color:#181b2c;box-shadow:0 1px 4px rgba(80,80,120,0.03);border:1.5px solid #d1d5db;display:inline-block;margin-bottom:1.2rem;">INDUSTRY TRUST</div>
                <div style="font-size:1.08rem;color:#181b2c;line-height:1.7;">
                    As a trusted institution, CIDB IBS is positioned to make a significant impact with a podcast series that speaks to the needs and challenges of the construction sector.
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FM Engagement Day Podcast Section -->
<div class="container py-5">
    <div class="mb-4">
        <img src="{{ asset('images/facility-logo-2.png') }}" alt="FM Engagement Day 2025" style="height:64px;width:auto;">
    </div>
    <div class="podcast-episode-card d-flex flex-column flex-lg-row align-items-stretch p-3 p-md-4" style="background:#fff;border:1.5px solid #d1d5db;border-radius:1.25rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);gap:2rem;max-width:1200px;margin:0 auto;">
        <!-- Left: Speaker Image -->
        <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="max-width:200px;width:100%;">
            <img src="{{ asset('images/podcast.jpeg') }}" alt="Speaker" style="width:100%;max-width:180px;aspect-ratio:1/1;object-fit:cover;border-radius:1.1rem;">
        </div>
        <!-- Center: Event Info -->
        <div class="flex-grow-1 d-flex flex-column justify-content-center px-lg-3" style="min-width:0;border-left:1.5px solid #eee;border-right:1.5px solid #eee;">
            <div class="d-flex align-items-center gap-3 mb-2" style="font-size:1.08rem;color:#ff9800;font-weight:600;flex-wrap:wrap;">
                <span><i class="fas fa-map-marker-alt me-1"></i> BCCK</span>
                <span><i class="fas fa-calendar-alt me-1"></i> 13 Mei 2025</span>
                <span><i class="fas fa-clock me-1"></i> 3.00 - 4.00 pm</span>
            </div>
            <div style="font-size:1.35rem;font-weight:900;color:#181b2c;line-height:1.3;">
                BINA - ICW BORNEO: BUILDING GREEN - HOW CONSTRUCTION TECHNOLOGY LEADS THE SUSTAINABLE CONSTRUCTION REVOLUTION
            </div>
            <!-- Audio Player -->
            <div class="audio-player-container mt-3">
                <button class="play-button" id="playButton1" onclick="toggleAudio('audio1')">
                    <i class="fas fa-play"></i>
                </button>
                <div class="audio-progress" onclick="seekAudio('audio1', event)">
                    <div class="audio-progress-bar" id="progress1"></div>
                </div>
                <div class="audio-time" id="time1">0:00 / 0:00</div>
                <div id="audio1" class="audio-player"></div>
            </div>
        </div>
        <!-- Right: Buttons -->
        <div class="d-flex flex-column align-items-center justify-content-center gap-3 py-3 px-lg-3" style="min-width:180px;">
            <a href="{{ route('client.facility-management') }}" class="btn" style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);color:#fff;font-weight:700;font-size:1.1rem;border-radius:2rem;padding:0.7rem 2.2rem;box-shadow:0 2px 8px rgba(0,0,0,0.08);letter-spacing:0.08em;">VIEW MORE</a>
            <a href="https://www.youtube.com/watch?v=Bjaj_ye_djQ&t=2022s" 
               class="btn" 
               style="background:#181b2c;color:#fff;font-weight:700;font-size:1.1rem;border-radius:2rem;padding:0.7rem 2.2rem;box-shadow:0 2px 8px rgba(0,0,0,0.08);letter-spacing:0.08em;"
               target="_blank" rel="noopener noreferrer">
               WATCH NOW
            </a>
        </div>
    </div>
</div>
<!-- Schedule Section -->
<div class="container py-5">
    <div class="podcast-schedule-card" style="background:#fff;border:1.5px solid #d1d5db;border-radius:1.25rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);max-width:900px;margin:0 auto;padding:2.5rem 1.5rem;">
        <div class="d-flex flex-column gap-4">
            <!-- 1st Row -->
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <div style="min-width:120px;font-weight:800;font-size:1.15rem;color:#181b2c;">8.00 - 11.00 PM</div>
                <div style="width:12px;display:flex;align-items:center;justify-content:center;"><div style="width:3px;height:40px;background:#ff9800;border-radius:2px;"></div></div>
                <div style="font-weight:800;font-size:1.13rem;color:#181b2c;">PERSIAPAN TEKNIKAL & SIARAN</div>
            </div>
            <!-- 2nd Row -->
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <div style="min-width:120px;font-weight:800;font-size:1.15rem;color:#181b2c;">1.30 - 2.00 PM</div>
                <div style="width:12px;display:flex;align-items:center;justify-content:center;"><div style="width:3px;height:40px;background:#ff9800;border-radius:2px;"></div></div>
                <div style="font-weight:800;font-size:1.13rem;color:#181b2c;">KEHADIRAN PANELIS</div>
            </div>
            <!-- 3rd Row -->
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <div style="min-width:120px;font-weight:800;font-size:1.15rem;color:#181b2c;">2.00 - 3.00 PM</div>
                <div style="width:12px;display:flex;align-items:center;justify-content:center;"><div style="width:3px;height:40px;background:#ff9800;border-radius:2px;"></div></div>
                <div style="font-weight:800;font-size:1.13rem;color:#181b2c;">TAKLIMAT RINGKAS & LATIHAN PENUH SIARAN</div>
            </div>
            <!-- 4th Row -->
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <div style="min-width:120px;font-weight:800;font-size:1.15rem;color:#181b2c;">3.00 - 4.00 PM</div>
                <div style="width:12px;display:flex;align-items:center;justify-content:center;"><div style="width:3px;height:40px;background:#ff9800;border-radius:2px;"></div></div>
                <div>
                    <div style="font-weight:800;font-size:1.13rem;color:#181b2c;">SIARAN LANGSUNG – EPISOD 1</div>
                    <div style="font-size:1.08rem;color:#181b2c;margin-top:0.3rem;max-width:420px;">BINA – ICW Borneo: Building Green – How Construction Technology Leads the Sustainable Construction Revolution</div>
                </div>
            </div>
            <!-- 5th Row -->
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <div style="min-width:120px;font-weight:800;font-size:1.15rem;color:#181b2c;">4.00 PM</div>
                <div style="width:12px;display:flex;align-items:center;justify-content:center;"><div style="width:3px;height:40px;background:#ff9800;border-radius:2px;"></div></div>
                <div style="font-weight:800;font-size:1.13rem;color:#181b2c;">SIARAN LANGSUNG TAMAT</div>
            </div>
        </div>
    </div>
</div>
<hr style="border-top:1.5px solid #22223b; margin:3.5rem 0 2.5rem 0;">
<div class="container pb-5">
    <div class="podcast-episode-card d-flex flex-column flex-lg-row align-items-stretch p-3 p-md-4" style="background:#fff;border:1.5px solid #d1d5db;border-radius:1.25rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);gap:2rem;max-width:1200px;margin:0 auto;">
        <!-- Left: Speaker Image -->
        <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="max-width:200px;width:100%;">
            <img src="{{ asset('images/podcast-2.jpeg') }}" alt="Speaker" style="width:100%;max-width:180px;aspect-ratio:1/1;object-fit:cover;border-radius:1.1rem;">
        </div>
        <!-- Center: Event Info -->
        <div class="flex-grow-1 d-flex flex-column justify-content-center px-lg-3" style="min-width:0;border-left:1.5px solid #eee;border-right:1.5px solid #eee;">
            <div class="d-flex align-items-center gap-3 mb-2" style="font-size:1.08rem;color:#ff9800;font-weight:600;flex-wrap:wrap;">
                <span><i class="fas fa-map-marker-alt me-1"></i> BCCK</span>
                <span><i class="fas fa-calendar-alt me-1"></i> 14 Mei 2025</span>
                <span><i class="fas fa-clock me-1"></i> 1.30 - 2.30 pm</span>
            </div>
            <div style="font-size:1.35rem;font-weight:900;color:#181b2c;line-height:1.3;">
                BINA - ICW BORNEO: CHALLENGES AND INNOVATIONS IN CONSTRUCTION TECHNOLOGY - OVERCOMING INDUSTRY CHALLENGES
            </div>
            <!-- Audio Player -->
            <div class="audio-player-container mt-3">
                <button class="play-button" id="playButton2" onclick="toggleAudio('audio2')">
                    <i class="fas fa-play"></i>
                </button>
                <div class="audio-progress" onclick="seekAudio('audio2', event)">
                    <div class="audio-progress-bar" id="progress2"></div>
                </div>
                <div class="audio-time" id="time2">0:00 / 0:00</div>
                <div id="audio2" class="audio-player"></div>
            </div>
        </div>
        <!-- Right: Buttons -->
        <div class="d-flex flex-column align-items-center justify-content-center gap-3 py-3 px-lg-3" style="min-width:180px;">
            <a href="{{ route('client.facility-management') }}" class="btn" style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);color:#fff;font-weight:700;font-size:1.1rem;border-radius:2rem;padding:0.7rem 2.2rem;box-shadow:0 2px 8px rgba(0,0,0,0.08);letter-spacing:0.08em;">VIEW MORE</a>
            <a href="https://www.youtube.com/watch?v=wY7fdrD4fkI&t=1887s" 
                class="btn" 
                style="background:#181b2c;color:#fff;font-weight:700;font-size:1.1rem;border-radius:2rem;padding:0.7rem 2.2rem;box-shadow:0 2px 8px rgba(0,0,0,0.08);letter-spacing:0.08em;"
                target="_blank" rel="noopener noreferrer">
                WATCH NOW
            </a>
        </div>
    </div>
</div>
<!-- Schedule Section -->
<div class="container py-5">
    <div class="podcast-schedule-card" style="background:#fff;border:1.5px solid #d1d5db;border-radius:1.25rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);max-width:900px;margin:0 auto;padding:2.5rem 1.5rem;">
        <div class="d-flex flex-column gap-4">
            <!-- 1st Row -->
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <div style="min-width:120px;font-weight:800;font-size:1.15rem;color:#181b2c;">8.00 - 11.00 PM</div>
                <div style="width:12px;display:flex;align-items:center;justify-content:center;"><div style="width:3px;height:40px;background:#ff9800;border-radius:2px;"></div></div>
                <div style="font-weight:800;font-size:1.13rem;color:#181b2c;">PERSIAPAN TEKNIKAL & SIARAN</div>
            </div>
            <!-- 2nd Row -->
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <div style="min-width:120px;font-weight:800;font-size:1.15rem;color:#181b2c;">11.00 - 12.30 PM</div>
                <div style="width:12px;display:flex;align-items:center;justify-content:center;"><div style="width:3px;height:40px;background:#ff9800;border-radius:2px;"></div></div>
                <div style="font-weight:800;font-size:1.13rem;color:#181b2c;">KEHADIRAN PANELIS</div>
            </div>
            <!-- 3rd Row -->
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <div style="min-width:120px;font-weight:800;font-size:1.15rem;color:#181b2c;">12.30 - 1.30 PM</div>
                <div style="width:12px;display:flex;align-items:center;justify-content:center;"><div style="width:3px;height:40px;background:#ff9800;border-radius:2px;"></div></div>
                <div style="font-weight:800;font-size:1.13rem;color:#181b2c;">TAKLIMAT RINGKAS & LATIHAN PENUH SIARAN</div>
            </div>
            <!-- 4th Row -->
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <div style="min-width:120px;font-weight:800;font-size:1.15rem;color:#181b2c;">1.30 - 2.30 PM</div>
                <div style="width:12px;display:flex;align-items:center;justify-content:center;"><div style="width:3px;height:40px;background:#ff9800;border-radius:2px;"></div></div>
                <div>
                    <div style="font-weight:800;font-size:1.13rem;color:#181b2c;">SIARAN LANGSUNG – EPISOD 2</div>
                    <div style="font-size:1.08rem;color:#181b2c;margin-top:0.3rem;max-width:420px;">BINA – ICW Borneo: Challenges and Innovations in Construction Technology – Overcoming Industry Challenges</div>
                </div>
            </div>
            <!-- 5th Row -->
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <div style="min-width:120px;font-weight:800;font-size:1.15rem;color:#181b2c;">2.30 PM</div>
                <div style="width:12px;display:flex;align-items:center;justify-content:center;"><div style="width:3px;height:40px;background:#ff9800;border-radius:2px;"></div></div>
                <div style="font-weight:800;font-size:1.13rem;color:#181b2c;">SIARAN LANGSUNG TAMAT</div>
            </div>
        </div>
    </div>
</div>

<!-- Add YouTube Player Containers -->
<div class="youtube-player-container">
    <iframe id="player1" 
            width="1" 
            height="1" 
            src="https://www.youtube.com/embed/Bjaj_ye_djQ?enablejsapi=1&controls=0&showinfo=0&rel=0&modestbranding=1" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
    </iframe>
    <iframe id="player2" 
            width="1" 
            height="1" 
            src="https://www.youtube.com/embed/wY7fdrD4fkI?enablejsapi=1&controls=0&showinfo=0&rel=0&modestbranding=1" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
    </iframe>
</div>
@endsection 

@push('scripts')
<script>
// Load YouTube API with timeout
let apiLoadTimeout;
let isAPIReady = false;
let playersReady = {
    player1: false,
    player2: false
};
let player1 = null;
let player2 = null;
let currentPlayer = null;

function loadYouTubeAPI() {
    // Create script element
    const tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    tag.async = true;
    
    // Add timeout
    apiLoadTimeout = setTimeout(() => {
        console.log('YouTube API load timeout - using fallback');
        initializeFallbackPlayers();
    }, 5000); // 5 second timeout
    
    // Add to document
    const firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

function initializeFallbackPlayers() {
    console.log('Initializing fallback players');
    isAPIReady = true;
    playersReady.player1 = true;
    playersReady.player2 = true;
    updateButtonState('playButton1', false, false);
    updateButtonState('playButton2', false, false);
}

function onYouTubeIframeAPIReady() {
    console.log('YouTube API Ready');
    clearTimeout(apiLoadTimeout);
    isAPIReady = true;
    
    // Initialize players with timeout
    const playerInitTimeout = setTimeout(() => {
        console.log('Player initialization timeout - using fallback');
        initializeFallbackPlayers();
    }, 3000); // 3 second timeout for player initialization
    
    try {
        player1 = new YT.Player('player1', {
            events: {
                'onReady': (event) => {
                    console.log('Player 1 Ready');
                    playersReady.player1 = true;
                    updateButtonState('playButton1', false, false);
                    if (playersReady.player1 && playersReady.player2) {
                        clearTimeout(playerInitTimeout);
                    }
                },
                'onStateChange': onPlayerStateChange,
                'onError': onPlayerError
            }
        });

        player2 = new YT.Player('player2', {
            events: {
                'onReady': (event) => {
                    console.log('Player 2 Ready');
                    playersReady.player2 = true;
                    updateButtonState('playButton2', false, false);
                    if (playersReady.player1 && playersReady.player2) {
                        clearTimeout(playerInitTimeout);
                    }
                },
                'onStateChange': onPlayerStateChange,
                'onError': onPlayerError
            }
        });
    } catch (error) {
        console.error('Error initializing players:', error);
        initializeFallbackPlayers();
    }
}

// Function to check if all players are ready
function arePlayersReady() {
    return playersReady.player1 && playersReady.player2;
}

// Function to update button state
function updateButtonState(buttonId, isLoading = false, isPlaying = false) {
    const button = document.getElementById(buttonId);
    if (!button) return;
    
    const icon = button.querySelector('i');
    if (!icon) return;
    
    button.classList.remove('loading');
    icon.classList.remove('fa-spinner', 'fa-spin', 'fa-play', 'fa-pause');
    
    if (isLoading) {
        button.classList.add('loading');
        icon.classList.add('fa-spinner', 'fa-spin');
    } else {
        icon.classList.add(isPlaying ? 'fa-pause' : 'fa-play');
    }
}

function onPlayerError(event) {
    console.error('YouTube Player Error:', event.data);
    const player = event.target;
    const playerId = player.getIframe().id === 'player1' ? 'audio1' : 'audio2';
    const buttonId = `playButton${playerId.slice(-1)}`;
    updateButtonState(buttonId, false, false);
    
    const timeDisplay = document.querySelector(`#time${playerId.slice(-1)}`);
    if (timeDisplay) {
        timeDisplay.textContent = 'Error loading audio';
        timeDisplay.style.color = '#ef4444';
    }
}

function onPlayerStateChange(event) {
    if (!event.target) return;
    
    const player = event.target;
    const playerId = player.getIframe().id === 'player1' ? 'audio1' : 'audio2';
    const buttonId = `playButton${playerId.slice(-1)}`;
    const timeDisplay = document.querySelector(`#time${playerId.slice(-1)}`);
    const progressBar = document.querySelector(`#progress${playerId.slice(-1)}`);

    if (!timeDisplay || !progressBar) return;

    if (event.data === YT.PlayerState.PLAYING) {
        updateButtonState(buttonId, false, true);
        updateProgress(player, progressBar, timeDisplay);
    } else if (event.data === YT.PlayerState.PAUSED) {
        updateButtonState(buttonId, false, false);
    } else if (event.data === YT.PlayerState.ENDED) {
        updateButtonState(buttonId, false, false);
        progressBar.style.width = '0%';
        timeDisplay.textContent = '0:00 / ' + formatTime(player.getDuration());
    }
}

function updateProgress(player, progressBar, timeDisplay) {
    if (!player || !progressBar || !timeDisplay) return;
    
    try {
        const duration = player.getDuration();
        const currentTime = player.getCurrentTime();
        const progress = (currentTime / duration) * 100;
        
        progressBar.style.width = `${progress}%`;
        timeDisplay.textContent = `${formatTime(currentTime)} / ${formatTime(duration)}`;
        
        if (player.getPlayerState() === YT.PlayerState.PLAYING) {
            requestAnimationFrame(() => updateProgress(player, progressBar, timeDisplay));
        }
    } catch (error) {
        console.error('Error updating progress:', error);
    }
}

function formatTime(seconds) {
    if (!seconds) return '0:00';
    const minutes = Math.floor(seconds / 60);
    seconds = Math.floor(seconds % 60);
    return `${minutes}:${seconds.toString().padStart(2, '0')}`;
}

function toggleAudio(audioId) {
    console.log('Toggle Audio:', audioId);
    
    if (!isAPIReady || !arePlayersReady()) {
        console.log('Players not ready yet, showing loading state');
        const buttonId = `playButton${audioId.slice(-1)}`;
        updateButtonState(buttonId, true, false);
        return;
    }
    
    const player = audioId === 'audio1' ? player1 : player2;
    const buttonId = `playButton${audioId.slice(-1)}`;
    
    if (!player) {
        console.error('Player not found:', audioId);
        return;
    }
    
    try {
        if (currentPlayer && currentPlayer !== player) {
            currentPlayer.pauseVideo();
        }
        
        const state = player.getPlayerState();
        if (state === YT.PlayerState.PLAYING) {
            player.pauseVideo();
        } else {
            player.playVideo();
            currentPlayer = player;
        }
    } catch (error) {
        console.error('Error toggling audio:', error);
        updateButtonState(buttonId, false, false);
    }
}

function seekAudio(audioId, event) {
    if (!isAPIReady || !arePlayersReady()) return;
    
    const player = audioId === 'audio1' ? player1 : player2;
    if (!player) return;
    
    const progressBar = event.currentTarget;
    const rect = progressBar.getBoundingClientRect();
    const pos = (event.clientX - rect.left) / rect.width;
    
    try {
        const duration = player.getDuration();
        player.seekTo(pos * duration, true);
    } catch (error) {
        console.error('Error seeking audio:', error);
    }
}

// Initialize time displays and button states
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    const timeDisplay1 = document.querySelector('#time1');
    const timeDisplay2 = document.querySelector('#time2');
    if (timeDisplay1) timeDisplay1.textContent = '0:00 / 0:00';
    if (timeDisplay2) timeDisplay2.textContent = '0:00 / 0:00';
    
    // Set initial button states
    updateButtonState('playButton1', true, false);
    updateButtonState('playButton2', true, false);
    
    // Load YouTube API
    loadYouTubeAPI();
});
</script>
@endpush 