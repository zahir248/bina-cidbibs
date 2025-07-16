@extends('client.layouts.app')

@section('title', 'BINA | Facility Management Industry Engagement Day 2025')

@push('styles')
<style>
    :root {
        --primary-blue: #11749e;
        --primary-dark: #0d5a7a;
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
        color: #11749e;
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
        color: #11749e;
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
        box-shadow: 0 5px 15px rgba(17, 116, 158, 0.3);
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
        background: #11749e;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .ticket-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(17, 116, 158, 0.4);
        background: #0d5a7a;
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
        color: #11749e;
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
            border-left: 3px solid #11749e;
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
        box-shadow: 0 12px 32px rgba(17, 116, 158, 0.18), 0 2px 12px rgba(80,80,120,0.10);
        transform: translateY(-8px) scale(1.025);
        z-index: 2;
    }

    /* Update the session label background */
    .ma-schedule-list .session-label {
        background: #11749e;
        color: #fff;
        display: inline-block;
        font-weight: 700;
        font-size: 1.1rem;
        padding: 0.5rem 1.2rem 0.4rem 1.2rem;
        border-radius: 0.15rem;
        margin-bottom: 2rem;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">FACILITY MANAGEMENT INDUSTRY</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Facility Management Industry</span>
    </div>
</div>

<!-- Main Content Section -->
<div class="container py-5">
    <div class="d-flex ma-flex-row flex-lg-row flex-column align-items-start justify-content-between gap-4">
        <!-- Left: Logo, Title, Headline, Description -->
        <div class="flex-grow-1" style="min-width: 300px;">
            <div class="ma-title">
                <img src="{{ asset('images/facility-logo-2.png') }}" alt="Facility Management Industry Logo" class="ma-logo" onerror="this.style.display='none'">
            </div>
            <div class="ma-headline">SARAWAK LEADS: THE FUTURE OF SUSTAINABLE FACILITY
            MANAGEMENT STARTS HERE</div>
            <div class="ma-desc">
                Unveil the extraordinary at SARAWAK FME DAY 2025, where industry pioneers and experts converge to explore cutting-edge solutions and best practices. This exclusive event brings together facility management professionals, technology innovators, and industry leaders to discuss emerging trends, sustainable practices, and the future of facility management in the digital age. Join us in shaping the next generation of facility management excellence in Sarawak.
            </div>
            <!-- Image Section -->
            <div class="ma-video-preview position-relative mt-4" style="width:100%; max-width:100%; max-height: 500px; overflow: hidden;">
                <img src="{{ asset('images/event-hightlight-6.jpg') }}" alt="Facility Management Industry" style="width:100%; border-radius: 2rem; display:block; object-fit: cover; height: 500px;">
            </div>
            
            <!-- CCD and CPD Points Section -->
            <div class="mt-5">
                <div style="font-size:1.5rem;font-weight:800;letter-spacing:0.5px;color:#22223b;margin-bottom:2rem;" class="text-start text-md-start text-sm-center text-center">
                    CCD AND CPD POINTS APPLIED
                </div>
                <div class="row g-4">
                    <!-- LAM -->
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex flex-column align-items-center text-center p-3" style="background: rgba(17, 116, 158, 0.1); border-radius: 1rem;">
                            <i class="fas fa-drafting-compass mb-3" style="font-size: 2.5rem; color: #11749e;"></i>
                            <div style="font-weight: 700; color: #11749e;">LAM</div>
                            <div style="font-size: 0.9rem; color: #4b5563;">Lembaga Arkitek Malaysia</div>
                        </div>
                    </div>
                    <!-- RISM -->
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex flex-column align-items-center text-center p-3" style="background: rgba(17, 116, 158, 0.1); border-radius: 1rem;">
                            <i class="fas fa-ruler-combined mb-3" style="font-size: 2.5rem; color: #11749e;"></i>
                            <div style="font-weight: 700; color: #11749e;">RISM</div>
                            <div style="font-size: 0.9rem; color: #4b5563;">Royal Institution of Surveyors Malaysia</div>
                        </div>
                    </div>
                    <!-- BQSM -->
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex flex-column align-items-center text-center p-3" style="background: rgba(17, 116, 158, 0.1); border-radius: 1rem;">
                            <i class="fas fa-calculator mb-3" style="font-size: 2.5rem; color: #11749e;"></i>
                            <div style="font-weight: 700; color: #11749e;">BQSM</div>
                            <div style="font-size: 0.9rem; color: #4b5563;">Board of Quantity Surveyors</div>
                        </div>
                    </div>
                    <!-- MBOT -->
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex flex-column align-items-center text-center p-3" style="background: rgba(17, 116, 158, 0.1); border-radius: 1rem;">
                            <i class="fas fa-microchip mb-3" style="font-size: 2.5rem; color: #11749e;"></i>
                            <div style="font-weight: 700; color: #11749e;">MBOT</div>
                            <div style="font-size: 0.9rem; color: #4b5563;">Malaysia Board of Technologies</div>
                        </div>
                    </div>
                    <!-- BEM -->
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex flex-column align-items-center text-center p-3" style="background: rgba(17, 116, 158, 0.1); border-radius: 1rem;">
                            <i class="fas fa-cogs mb-3" style="font-size: 2.5rem; color: #11749e;"></i>
                            <div style="font-weight: 700; color: #11749e;">BEM</div>
                            <div style="font-size: 0.9rem; color: #4b5563;">Board of Engineers Malaysia</div>
                        </div>
                    </div>
                    <!-- CCD -->
                    <div class="col-md-4 col-sm-6">
                        <div class="d-flex flex-column align-items-center text-center p-3" style="background: rgba(17, 116, 158, 0.1); border-radius: 1rem;">
                            <i class="fas fa-building mb-3" style="font-size: 2.5rem; color: #11749e;"></i>
                            <div style="font-weight: 700; color: #11749e;">CCD</div>
                            <div style="font-size: 0.9rem; color: #4b5563;">Construction Industry Development Board</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conference Layout Section -->
            <div class="mt-5">
                <div style="font-size:1.5rem;font-weight:800;letter-spacing:0.5px;color:#22223b;margin-bottom:2rem;" class="text-start text-md-start text-sm-center text-center">
                    CONFERENCE LAYOUT
                </div>
                <div class="conference-layout-container" style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
                    <div style="max-width: 1000px; margin: 0 auto;">
                        <div style="position: relative; width: 100%; background: white; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 2rem;">
                            <img 
                                src="{{ asset('images/conference-layout.png') }}" 
                                alt="Conference Hall Layout" 
                                style="width: 100%; height: auto; display: block;"
                            >
                            <div class="layout-details mt-4">
                                <div class="row g-3">
                                    <div class="col-md-3 col-6">
                                        <div style="padding: 0.75rem; background: rgba(17, 116, 158, 0.1); border-radius: 0.5rem; text-align: center;">
                                            <i class="fas fa-door-open mb-2" style="color: #11749e; font-size: 1.25rem;"></i>
                                            <div style="font-weight: 600; color: #22223b; font-size: 0.9rem;">2 Entry/Exit Points</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div style="padding: 0.75rem; background: rgba(17, 116, 158, 0.1); border-radius: 0.5rem; text-align: center;">
                                            <i class="fas fa-chair mb-2" style="color: #11749e; font-size: 1.25rem;"></i>
                                            <div style="font-weight: 600; color: #22223b; font-size: 0.9rem;">Theatre Style Seating</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div style="padding: 0.75rem; background: rgba(17, 116, 158, 0.1); border-radius: 0.5rem; text-align: center;">
                                            <i class="fas fa-tv mb-2" style="color: #11749e; font-size: 1.25rem;"></i>
                                            <div style="font-weight: 600; color: #22223b; font-size: 0.9rem;">LED Screen Display</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div style="padding: 0.75rem; background: rgba(17, 116, 158, 0.1); border-radius: 0.5rem; text-align: center;">
                                            <i class="fas fa-table mb-2" style="color: #11749e; font-size: 1.25rem;"></i>
                                            <div style="font-weight: 600; color: #22223b; font-size: 0.9rem;">Exhibition Booths</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 text-center" style="color: #64748b; font-size: 0.95rem; font-style: italic;">
                            * Layout may be subject to minor adjustments based on venue requirements
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Points and Schedule Section -->
            <div class="ma-session-points mt-5">

                <!-- Schedule Section -->
                <div class="mt-5">
                    <div style="background:#11749e;color:#fff;display:inline-block;font-weight:700;font-size:1.1rem;padding:0.5rem 1.2rem 0.4rem 1.2rem;border-radius:0.15rem;margin-bottom:2rem;letter-spacing:0.5px;">
                        EVENT SCHEDULE
                    </div>
                    <div class="ma-schedule-list mt-4">
                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">8:00 am - 8:30 am</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">PARTICIPANT REGISTRATION</div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">8:30 am - 8:45 am</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">OPENING CEREMONY</div>
                                <div class="ma-schedule-description">
                                    • Prayer Recitation<br>
                                    • Welcoming Remarks - Director of CIDB Sarawak
                                </div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">9:00 am - 9:30 am</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">SHARING SESSION TOPIC 1: DEVELOPING FM MALAYSIA – STRUCTURED GOVERNANCE & PROFESSIONAL STANDARDS</div>
                                <div class="ma-schedule-description">
                                    Proposed Panel: CIDB, MoF, KKR/JKR- JK TWG4
                                </div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">9:30 am - 10:30 am</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">SHARING SESSION TOPIC 2: THE FUTURE OF FACILITY MANAGEMENT IN MALAYSIA – COLLABORATION, INNOVATION & SUSTAINABILITY</div>
                                <div class="ma-schedule-description">
                                    Proposed Panel: JKR Sarawak, Unit Pentadbiran, Jabatan Premier Sarawak, JKR Malaysia
                                </div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">10:30 am - 10:45 am</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">MORNING REFRESHMENTS</div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">11:00 am</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">VIP ARRIVAL</div>
                                <div class="ma-schedule-description">
                                    • YB Dato Sri Alexander Nanta Linggi,<br>
                                    &nbsp;&nbsp;Menteri Kerja Raya<br><br>
                                    • YAB Datuk Patinggi Tan Sri (Dr) Abang Haji Abdul Rahman<br>
                                    &nbsp;&nbsp;Zohari bin Tun Datuk Abang Haji Openg<br>
                                    &nbsp;&nbsp;Premier Sarawak<br><br>
                                </div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">11:10 am</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">NATIONAL & STATE ANTHEMS</div>
                                <div class="ma-schedule-description">
                                    • National Anthem<br>
                                    • Sarawak State Anthem - Ibu Pertiwiku
                                </div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">11:30 am - 12:00 pm</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">WELCOMING REMARKS</div>
                                <div class="ma-schedule-description">
                                    YB Dato Sri Alexender Nanta Linggi<br>
                                    Minister of Works
                                </div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">12:00 pm - 12:30 pm</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">OPENING CEREMONY & WELCOMING REMARKS BY PREMIER SARAWAK</div>
                                <div class="ma-schedule-description">
                                    YAB Datuk Patinggi Tan Sri (Dr) Abang Haji Abdul Rahman Zohari bin Tun<br>
                                    Datuk Abang Haji Openg
                                </div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">12:45 pm</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">PHOTO SESSION</div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">1:00 pm - 2:00pm</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">BRUNCH</div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">2:30 pm - 3:30pm</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">SHARING SESSION TOPIC 3: REVOLUTIONISING FACILITY MANAGEMENT – INDUSTRY COLLABORATION TOWARDS A SUSTAINABLE FUTURE</div>
                                <div class="ma-schedule-description">
                                    Proposed Panel: Industri - PNB/TRX & Putrajaya Holding (2 wakil semenanjung), Pansar - Borneo Cultural Museum/ LCDA - IAC Project (1 wakil sarawak)
                                </div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">3:30 pm - 4:30pm</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">SHARING SESSION TOPIC 4: FM HUMAN CAPITAL DEVELOPMENT – TRANSFORMATION THROUGH EDUCATION & TRAINING</div>
                                <div class="ma-schedule-description">
                                    Proposed Panel: Swinburne University/Uni Teknologi Sarawak & CIDB Latihan Kemahiran Kompetensi
                                </div>
                            </div>
                        </div>

                        <div class="ma-schedule-row">
                            <span class="ma-schedule-time">4:30 pm - 5:00pm</span>
                            <span class="ma-schedule-separator">|</span>
                            <div class="ma-schedule-content">
                                <div class="ma-schedule-title">NETWORKING SESSION</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="ticket-btn-wrapper">
                    <a href="{{ route('client.store') }}" class="ticket-btn">GET TICKET</a>
                </div>
            </div>
        </div>
        <!-- Right: Event Details Card -->
        <div class="sticky-sidebar">
            <div class="ma-card" style="min-width:270px;max-width:340px;width:100%;margin-left:auto;margin-right:auto;">
                <div class="mb-3" style="font-weight:700;font-size:1.1rem;text-align:center;">
                    Be part of something extraordinary at <span style="font-weight:900;">SARAWAK FME DAY 2025</span>, where innovation meets excellence in Facility Management Industry.
                </div>
                <div class="ma-detail-row">
                    <span class="ma-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>Raia Hotel, Kuching, Sarawak</span>
                </div>
                <div class="ma-detail-row">
                    <span class="ma-icon"><i class="fas fa-calendar-alt"></i></span>
                    <span>04 Sept 2025</span>
                </div>
                <div class="ma-detail-row">
                    <span class="ma-icon"><i class="fas fa-clock"></i></span>
                    <span>08:00 AM – 05:00 PM</span>
                </div>
                <div class="ma-detail-row">
                    <span class="ma-icon"><i class="fas fa-users"></i></span>
                    <span>Limited to 450 participants</span>
                </div>
                <div class="ma-detail-row">
                    <span class="ma-icon"><i class="fas fa-store"></i></span>
                    <span>20 Exhibitors</span>
                </div>
                <div class="ma-detail-row">
                    <span class="ma-icon"><i class="fas fa-microphone"></i></span>
                    <span>13 Industry Speakers</span>
                </div>
                <div style="margin-top: 1.5rem;">
                    <div style="font-weight:700;font-size:1rem;color:#11749e;margin-bottom:0.75rem;">Main Components:</div>
                    <div class="ma-detail-row" style="margin-bottom: 0.5rem;">
                        <span class="ma-icon"><i class="fas fa-check-circle"></i></span>
                        <span>Best Practices Sharing</span>
                    </div>
                    <div class="ma-detail-row">
                        <span class="ma-icon"><i class="fas fa-check-circle"></i></span>
                        <span>Strategic Networking</span>
                    </div>
                </div>
            </div>
            <!-- Speaker Card -->
            <div class="speaker-card-upgraded" style="background:#fff; border-radius:1.5rem; box-shadow:0 8px 32px rgba(80,80,120,0.08); border:0px solid #1B1F31; padding:0 0 2rem 0; margin-top:2.2rem; max-width:340px; min-width:270px; width:100%; text-align:center; position:relative; overflow:hidden; margin-left:auto; margin-right:auto;">
                <div style="width:100%; background:#1B1F31; color:#fff; font-weight:700; font-size:1.1rem; padding:1.1rem 0 0.9rem 0; border-top-left-radius:1.5rem; border-top-right-radius:1.5rem; letter-spacing:0.5px;">
                    EVENT SPEAKERS
                </div>
                <div style="display:flex; flex-direction:column; align-items:center; margin-top:1.2rem;">
                    <div style="width:80px; height:80px; background:#f1f5f9; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;">
                        <i class="fas fa-user" style="font-size:2rem; color:#94a3b8;"></i>
                    </div>
                    <div class="speaker-name-container" style="display:flex; align-items:center; gap:0.5rem; justify-content:center; flex-wrap:wrap;">
                        <div class="speaker-name" style="font-weight:900; font-size:1.25rem; color:#64748b; margin-bottom:0.2rem; margin-top:0.2rem; line-height:1.3;">To Be Announced</div>
                        <span style="background:#f1f5f9; color:#64748b; font-weight:700; font-size:0.85rem; padding:0.2rem 0.8rem; border-radius:1rem; display:inline-block;">COMING SOON</span>
                    </div>
                    <div style="color:#94a3b8; font-size:1.05rem; font-weight:600; margin-bottom:0.2rem;">Details will be updated</div>
                    <div style="color:#94a3b8; font-size:0.95rem;">Stay tuned for updates</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 