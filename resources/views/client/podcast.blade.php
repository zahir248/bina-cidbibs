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
@endsection 