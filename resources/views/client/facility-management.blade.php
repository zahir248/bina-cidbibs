@extends('client.layouts.app')

@section('title', 'BINA | Facility Management Forum & Exhibition 2025')

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

    /* Animation Keyframes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        to {
            opacity: 1;
        }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
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
        background-attachment: fixed;
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
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
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
        opacity: 0;
        animation: fadeIn 0.8s ease 0.4s forwards;
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
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }

    .ma-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
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
        opacity: 0;
        animation: fadeInUp 0.8s ease forwards;
    }

    .ma-headline {
        font-size: 2rem;
        font-weight: 900;
        color: #22223b;
        margin-bottom: 1.25rem;
        margin-top: 1.5rem;
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.2s forwards;
    }

    .ma-desc {
        color: #4b5563;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
        text-align: justify;
        text-justify: inter-word;
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.4s forwards;
    }

    .ma-video-preview {
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.6s forwards;
        transition: transform 0.3s ease;
    }

    .ma-video-preview:hover {
        transform: scale(1.02);
    }

    .sticky-sidebar {
        position: sticky;
        top: 2rem;
        height: fit-content;
    }

    .speaker-card {
        animation: float 3s ease-in-out infinite;
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.8s forwards, float 3s ease-in-out infinite 0.8s;
    }

    .social-icon {
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 152, 0, 0.3);
    }

    .ticket-btn-wrapper {
        margin-top: 2rem;
    }

    .ticket-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.6s forwards;
        display: inline-block;
        padding: 0.9rem 2.5rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        font-size: 1.1rem;
        border-radius: 2.5rem;
        background: #ff9800;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .ticket-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(255, 152, 0, 0.4);
    }

    .ticket-btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }

    .ticket-btn:hover::after {
        left: 100%;
    }

    /* Animate on scroll class */
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease;
    }

    .animate-on-scroll.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Schedule styles */
    .ma-schedule-row {
        display: flex;
        align-items: flex-start;
        margin-bottom: 2rem;
    }

    .ma-schedule-time {
        font-weight: 700;
        font-size: 1.1rem;
        color: #22223b;
        min-width: 170px;
    }

    .ma-schedule-separator {
        color: #ff9800;
        font-size: 2rem;
        margin: 0 18px 0 18px;
    }

    .ma-schedule-content {
        flex: 1;
    }

    .ma-schedule-title {
        font-weight: 800;
        font-size: 1.1rem;
        color: #0a183d;
        letter-spacing: 0.5px;
    }

    .ma-schedule-description {
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        color: #22223b;
        font-size: 1.08rem;
        max-width: 500px;
    }

    @media (max-width: 991px) {
        .ma-flex-row {
            flex-direction: column;
        }
        .ma-card {
            margin-top: 2rem;
        }
        .sticky-sidebar {
            position: static;
        }
        .ma-title {
            justify-content: center;
        }
        .ma-headline {
            text-align: center;
            font-size: 1.5rem;
            line-height: 1.3;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        .ma-schedule-row {
            flex-direction: column;
            padding-left: 1rem;
            border-left: 3px solid #ff9800;
        }
        .ma-schedule-time {
            margin-bottom: 0.75rem;
        }
        .ma-schedule-separator {
            display: none;
        }
        .ma-schedule-content {
            padding-left: 0;
        }
        .ma-schedule-description {
            margin-top: 0.5rem;
        }
        .ticket-btn-wrapper {
            text-align: center;
            width: 100%;
        }
        .sticky-sidebar {
            position: static;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .ma-card {
            margin: 2rem auto 0;
            width: 100%;
            max-width: 340px;
        }
        .ma-card .mb-3 {
            text-align: center;
        }
        .ma-detail-row {
            justify-content: center;
        }
        .speaker-card {
            width: 100%;
            max-width: 340px;
            margin: 2rem auto 0;
        }
    }

    .speaker-name-container {
        flex-direction: column !important;
        align-items: center !important;
        gap: 0.3rem !important;
    }

    @media (max-width: 480px) {
        .speaker-card-upgraded .speaker-name {
            font-size: 1rem !important;
        }
    }

    .speaker-card-upgraded {
        transition: box-shadow 0.3s cubic-bezier(.4,2,.6,1), transform 0.3s cubic-bezier(.4,2,.6,1);
    }
    .speaker-card-upgraded:hover {
        box-shadow: 0 12px 32px rgba(255,152,0,0.18), 0 2px 12px rgba(80,80,120,0.10);
        transform: translateY(-8px) scale(1.025);
        z-index: 2;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">FACILITY MANAGEMENT</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Facility Management</span>
    </div>
</div>

<!-- Main Content Section -->
<div class="container py-5">
    <div class="d-flex ma-flex-row flex-lg-row flex-column align-items-start justify-content-between gap-4">
        <!-- Left: Logo, Title, Headline, Description -->
        <div class="flex-grow-1" style="min-width: 300px;">
            <div class="ma-title">
                <img src="{{ asset('images/facility-logo.png') }}" alt="Facility Management Logo" class="ma-logo" onerror="this.style.display='none'">
            </div>
            <div class="ma-headline">TRANSFORMING ASEAN'S CONSTRUCTION LANDSCAPE</div>
            <div class="ma-desc">
                Facility management goes beyond maintaining buildings—it's about fostering productive environments where people can thrive. In this session, we explore practical strategies to navigate challenging interpersonal situations, ensuring smooth operations and positive outcomes. Learn how to effectively manage workplace dynamics, build stronger teams, and maintain a harmonious work environment while addressing the complexities of human interaction.
            </div>
            <!-- Image Section -->
            <div class="ma-video-preview position-relative mt-4" style="width:100%; max-width:100%; max-height: 500px; overflow: hidden;">
                <img src="{{ asset('images/facility.jpg') }}" alt="Facility Management" style="width:100%; border-radius: 2rem; display:block; object-fit: cover; height: 500px;">
            </div>
            <!-- Important Points and Schedule Section -->
            <div class="ma-session-points mt-5">
                <div style="font-size:1.1rem;font-weight:600;letter-spacing:0.5px;color:#22223b;margin-bottom:1rem;">IMPORTANT POINTS IN THIS SESSION :</div>
                <ul style="color:#4b5563;font-size:1rem;margin-bottom:2rem;">
                    <li style="margin-bottom:0.5rem;">Conflict management strategies for facility managers.</li>
                    <li style="margin-bottom:0.5rem;">Best practices for engaging challenging stakeholders.</li>
                    <li>Building a resilient and collaborative workplace.</li>
                </ul>
                <!-- SESSION 1 SCHEDULE -->
                <div class="mt-5">
                    <div class="ma-schedule-list mt-4">
                        @php
                            $currentSession = null;
                            $sessionNumber = 1;
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
                            
                            <div class="ma-schedule-row">
                                <span class="ma-schedule-time">{{ $schedule->formatted_time }}</span>
                                <span class="ma-schedule-separator">|</span>
                                <div class="ma-schedule-content">
                                    <div class="ma-schedule-title">{{ $schedule->title }}</div>
                                    @if(!empty($schedule->description))
                                        <div class="ma-schedule-description">{!! nl2br(e($schedule->description)) !!}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="ticket-btn-wrapper">
                        <a href="{{ route('client.store') }}" class="ticket-btn">GET TICKET</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right: Event Details Card -->
        <div class="sticky-sidebar">
            <div class="ma-card" style="min-width:270px;max-width:340px;width:100%;margin-left:auto;margin-right:auto;">
                <div class="mb-3" style="font-weight:700;font-size:1.1rem;text-align:center;">
                    Join us at <span style="font-weight:900;">Facility Management Engagement Day 2025</span> to explore innovative strategies and best practices in facility management. Connect with industry leaders and experts.
                </div>
                <div class="ma-detail-row">
                    <span class="ma-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>MITEC, Kuala Lumpur</span>
                </div>
                <div class="ma-detail-row">
                    <span class="ma-icon"><i class="fas fa-calendar-alt"></i></span>
                    <span>29 Oct 2025</span>
                </div>
                <div class="ma-detail-row">
                    <span class="ma-icon"><i class="fas fa-clock"></i></span>
                    <span>08:00 AM – 05.00 PM</span>
                </div>
            </div>
            <!-- Emcee Card -->
            <div class="speaker-card-upgraded" style="background:#fff; border-radius:1.5rem; box-shadow:0 8px 32px rgba(80,80,120,0.08); border:0px solid #1B1F31; padding:0 0 2rem 0; margin-top:2.2rem; max-width:340px; min-width:270px; width:100%; text-align:center; position:relative; overflow:hidden; margin-left:auto; margin-right:auto;">
                <div style="width:100%; background:#1B1F31; color:#fff; font-weight:700; font-size:1.1rem; padding:1.1rem 0 0.9rem 0; border-top-left-radius:1.5rem; border-top-right-radius:1.5rem; letter-spacing:0.5px;">
                    EVENT HOST
                </div>
                <div style="display:flex; flex-direction:column; align-items:center; margin-top:1.2rem;">
                    <img src="{{ asset('images/haji-yusuf.jpg') }}" alt="Ir. Haji Yusuf bin Haji Abd. Wahab"
                         style="width:80px; height:80px; object-fit:cover; object-position:top; border-radius:50%; border:0px solid #1B1F31; box-shadow:0 2px 12px rgba(27,31,49,0.15); margin-bottom:1rem; cursor:pointer;" id="emceeImage">
                    <div class="speaker-name-container" style="display:flex; align-items:center; gap:0.5rem; justify-content:center; flex-wrap:wrap;">
                        <div class="speaker-name" style="font-weight:900; font-size:1.25rem; color:#181b2c; margin-bottom:0.2rem; margin-top:0.2rem; line-height:1.3;">Ir. Haji Yusuf Bin Haji<br>Abd. Wahab</div>
                        <span style="background:#1B1F31; color:#fff; font-weight:700; font-size:0.85rem; padding:0.2rem 0.8rem; border-radius:1rem; display:inline-block;">WELCOMING SPEECH</span>
                    </div>
                    <div style="color:#1B1F31; font-size:1.05rem; font-weight:600; margin-bottom:0.2rem;">Chairman</div>
                    <div style="color:#6b7280; font-size:0.98rem; margin-bottom:1.2rem;">CIDB Malaysia</div>
                </div>
            </div>
            <!-- Speaker Card -->
            <div class="speaker-card-upgraded" style="background:#fff; border-radius:1.5rem; box-shadow:0 8px 32px rgba(80,80,120,0.08); border:0px solid #1B1F31; padding:0 0 2rem 0; margin-top:2.2rem; max-width:340px; min-width:270px; width:100%; text-align:center; position:relative; overflow:hidden; margin-left:auto; margin-right:auto;">
                <div style="width:100%; background:#1B1F31; color:#fff; font-weight:700; font-size:1.1rem; padding:1.1rem 0 0.9rem 0; border-top-left-radius:1.5rem; border-top-right-radius:1.5rem; letter-spacing:0.5px;">
                    EVENT SPEAKERS
                </div>
                <div style="display:flex; flex-direction:column; align-items:center; margin-top:1.2rem;">
                    <img src="{{ asset('images/dr-azrin-ahmad.jpg') }}" alt="Br. Dr. Hj. Azrin Bin Ahmad"
                         style="width:80px; height:80px; object-fit:cover; border-radius:50%; border:0px solid #ff9800; box-shadow:0 2px 12px rgba(255,152,0,0.15); margin-bottom:1rem; cursor:pointer;" id="speakerImage">
                    <div class="speaker-name-container" style="display:flex; align-items:center; gap:0.5rem; justify-content:center; flex-wrap:wrap;">
                        <div class="speaker-name" style="font-weight:900; font-size:1.25rem; color:#181b2c; margin-bottom:0.2rem; margin-top:0.2rem;">Br. Dr. Hj. Azrin Bin Ahmad</div>
                        <span style="background:#1B1F31; color:#fff; font-weight:700; font-size:0.85rem; padding:0.2rem 0.8rem; border-radius:1rem; display:inline-block;">BEST PRACTICES SHARING 6</span>
                    </div>
                    <div style="color:#1B1F31; font-size:1.05rem; font-weight:600; margin-bottom:0.2rem;">Project Director</div>
                    <div style="color:#6b7280; font-size:0.98rem; margin-bottom:1.2rem;">Maltimur Aktif Unggul Jv Sdn Bhd</div>
                </div>
            </div>
            <!-- Emcee Image Modal -->
            <div id="emceeImageModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7); align-items:center; justify-content:center;">
                <span id="closeEmceeModal" style="position:absolute; top:30px; right:40px; color:#fff; font-size:2.5rem; font-weight:700; cursor:pointer; z-index:10001;">&times;</span>
                <img src="{{ asset('images/haji-yusuf.jpg') }}" alt="Ir. Haji Yusuf bin Haji Abd. Wahab" style="max-width:90vw; max-height:90vh; border-radius:1.5rem; box-shadow:0 8px 32px rgba(0,0,0,0.25); border:6px solid #fff;">
            </div>
            <!-- Speaker Image Modal -->
            <div id="speakerImageModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7); align-items:center; justify-content:center;">
                <span id="closeSpeakerModal" style="position:absolute; top:30px; right:40px; color:#fff; font-size:2.5rem; font-weight:700; cursor:pointer; z-index:10001;">&times;</span>
                <img src="{{ asset('images/dr-azrin-ahmad.jpg') }}" alt="Br. Dr. Hj. Azrin Bin Ahmad" style="max-width:90vw; max-height:90vh; border-radius:1.5rem; box-shadow:0 8px 32px rgba(0,0,0,0.25); border:6px solid #fff;">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on scroll
    const animateElements = document.querySelectorAll('.ma-desc, .ma-video-preview, .ma-card, .ma-session-points');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    animateElements.forEach(element => {
        element.classList.add('animate-on-scroll');
        observer.observe(element);
    });

    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const heroSection = document.querySelector('.hero-section-store');
        const scrolled = window.pageYOffset;
        heroSection.style.backgroundPositionY = -(scrolled * 0.5) + 'px';
    });

    // Emcee image modal logic
    const emceeImg = document.getElementById('emceeImage');
    const emceeModal = document.getElementById('emceeImageModal');
    const closeEmceeModal = document.getElementById('closeEmceeModal');
    if (emceeImg && emceeModal && closeEmceeModal) {
        emceeImg.addEventListener('click', function() {
            emceeModal.style.display = 'flex';
        });
        closeEmceeModal.addEventListener('click', function() {
            emceeModal.style.display = 'none';
        });
        emceeModal.addEventListener('click', function(e) {
            if (e.target === emceeModal) {
                emceeModal.style.display = 'none';
            }
        });
    }

    // Speaker image modal logic
    const speakerImg = document.getElementById('speakerImage');
    const modal = document.getElementById('speakerImageModal');
    const closeModal = document.getElementById('closeSpeakerModal');
    if (speakerImg && modal && closeModal) {
        speakerImg.addEventListener('click', function() {
            modal.style.display = 'flex';
        });
        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
        });
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }
});
</script>
@endpush 