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

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
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

    @keyframes fadeIn {
        to {
            opacity: 1;
        }
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

    /* Scroll Animation Classes */
    .scroll-reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease;
    }

    .scroll-reveal.visible {
        opacity: 1;
        transform: translateY(0);
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

    /* Responsive styles */
    @media (max-width: 768px) {
        .podcast-info-card {
            margin: 0 0.5rem;
        }
        
        .podcast-episode-card {
            margin: 0 0.5rem;
        }
        
        .table-responsive {
            margin: 0 -0.5rem;
        }
        
        .audio-player-container {
            width: 100%;
            padding-left: 0;
        }
    }

    @media (max-width: 576px) {
        .hero-section-store {
            min-height: 40vh;
        }
        
        .hero-title-store {
            font-size: 2rem;
        }
        
        .breadcrumb-store {
            font-size: 0.9rem;
        }
        
        .event-highlight-card img {
            height: 200px;
        }
    }

    /* Fix table responsiveness */
    .table {
        width: 100%;
        min-width: 100%;
    }

    @media (max-width: 576px) {
        td {
            min-width: 120px;
            font-size: 0.9rem;
        }
        
        .table > :not(caption) > * > * {
            padding: 0.75rem;
        }
    }

    /* General responsive container fixes */
    .container {
        width: 100%;
        padding-right: var(--bs-gutter-x, 0.75rem);
        padding-left: var(--bs-gutter-x, 0.75rem);
        margin-right: auto;
        margin-left: auto;
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
<div class="container py-4 px-3 px-sm-4" style="max-width:1400px;">
    <div class="podcast-info-card d-flex flex-column flex-md-row align-items-stretch p-3 p-sm-4" style="background:#fff;border-radius:1.25rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);gap:3rem;margin:0 auto;border:2px solid #e5e7eb;">
        <!-- Image Section -->
        <div class="flex-shrink-0 d-flex justify-content-center align-items-center" style="width:100%;max-width:450px;">
            <img src="{{ asset('images/podcast-about.png') }}" 
                 alt="CIDB IBS Podcast"
                 style="width:100%;height:auto;max-height:380px;object-fit:contain;border-radius:1.25rem;box-shadow:0 4px 20px rgba(80,80,120,0.1);display:block;"
                 data-bs-toggle="modal"
                 data-bs-target="#imageModal"
                 onclick="showImage(this.src)">
        </div>
        <!-- Content Section -->
        <div class="flex-grow-1 d-flex flex-column" style="min-width:0;">
            <div style="background:#f1f5f9;border-radius:0.75rem;padding:0.75rem 1.5rem;margin-bottom:1rem;">
                <h2 style="font-size:clamp(1.25rem, 4vw, 1.5rem);font-weight:800;color:#1e293b;margin:0;">ABOUT</h2>
            </div>
            <div style="font-size:0.95rem;color:#334155;line-height:1.5;text-align:justify;">
                The first-ever podcast series by CIDB IBS, launched under the <b>BINA 2025</b> initiative to amplify conversations that matter in Malaysia's construction and built environment sector. We offer two podcast segments: <b>BINA Podcast</b>, which features insightful conversations with construction industry leaders and innovators, and <b>FM Podcast</b>, which focuses on facility management, highlighting best practices, sustainability, and digitalisation in the built environment.<br><br>
                As the industry <b>embraces digitalisation and innovation</b>, this Podcast series provides a platform for insightful, video-based discussions. Each episode features relaxed yet thought-provoking conversations with industry leaders, policymakers, contractors, manufacturers, consultants, financial institutions, and innovators.<br><br>
                This podcast is more than a conversation—it's a strategic initiative by CIDB IBS to foster <b>knowledge-sharing platforms</b> that connect stakeholders and provide insights into <b>industry best practices</b>.
            </div>
        </div>
    </div>
</div>
<!-- FM Engagement Day Podcast Section -->
<div class="container py-4 px-3 px-sm-4" style="max-width:1400px;">
    <div class="row g-4">
        <!-- BINA Podcast Column -->
        <div class="col-lg-6">
            <div class="podcast-episode-card d-flex flex-column h-100" style="background:#fff;border:1.5px solid #d1d5db;border-radius:1.25rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);overflow:hidden;">
                <!-- Header -->
                <div style="background:#181b2c;color:#fff;padding:1rem 1.5rem;">
                    <h3 style="font-size:clamp(1.25rem, 4vw, 1.5rem);font-weight:800;margin:0;">BINA PODCAST</h3>
                </div>
                <!-- Content -->
                <div class="p-3 p-md-4 d-flex flex-column flex-grow-1">
                    <!-- Episode Table -->
                    <div class="table-responsive">
                        <table class="table" style="border:1px solid #e5e7eb;border-radius:0.5rem;overflow:hidden;">
                            <thead style="background:#f8fafc;">
                                <tr>
                                    <th style="padding:1rem;font-weight:700;color:#181b2c;border-bottom:2px solid #e5e7eb;">Episode</th>
                                    <th style="padding:1rem;font-weight:700;color:#181b2c;border-bottom:2px solid #e5e7eb;">Panelist</th>
                                    <th style="padding:1rem;font-weight:700;color:#181b2c;border-bottom:2px solid #e5e7eb;">Topic</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Episode 1 - Info Row -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;width:25%;">
                                        <div style="font-weight:600;font-size:1.1rem;margin-bottom:0.5rem;">Ep. 1</div>
                                        <div style="font-size:0.9rem;color:#64748b;">(Live Streaming - ICW Borneo)</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;width:35%;">
                                        <div style="font-weight:600;font-size:1.1rem;margin-bottom:0.5rem;">Panel:</div>
                                        <div style="line-height:1.6;">
                                            Prof. Ir. Resdiansyah
                                            <div style="font-size:0.9rem;color:#64748b;margin-top:0.25rem;">Senior Advisor of Infrastructure and Regional Development, Indonesia</div>
                                        </div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;width:40%;">
                                        <div style="line-height:1.6;">
                                            BINA - ICW Borneo:<br>
                                            <i>Building Green – How Construction Technology Leads the Sustainable Revolution</i>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Episode 1 - Media Row -->
                                <tr>
                                    <td colspan="3" style="padding:1.5rem;border-bottom:1px solid #e5e7eb;background:#f8fafc;">
                                        <div class="d-flex flex-column gap-4" style="max-width:800px;margin:0 auto;">
                                            <!-- Image and Buttons Section -->
                                            <div class="d-flex flex-column flex-md-row align-items-center gap-4" style="width:450px;">
                                                <!-- Speaker Image -->
                                                <div style="width:320px;height:240px;flex-shrink:0;background:#f8fafc;border-radius:1rem;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                                                    <img src="{{ asset('images/posterbina-ep1.png') }}" 
                                                         alt="Speaker" 
                                                         data-bs-toggle="modal"
                                                         data-bs-target="#imageModal"
                                                         onclick="showImage(this.src)"
                                                         style="max-width:100%;max-height:100%;object-fit:contain;border-radius:0.75rem;cursor:pointer;">
                                                </div>
                                                <!-- Buttons Section -->
                                                <div class="flex-grow-1 d-flex flex-column gap-2" style="min-width:110px;">
                                                    <a href="{{ route('client.facility-management') }}" 
                                                       class="btn w-100" 
                                                       style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);color:#fff;font-weight:600;font-size:0.85rem;border-radius:1.5rem;padding:0.5rem 0;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                                                       VIEW<br>MORE
                                                    </a>
                                                    <a href="https://www.youtube.com/watch?v=Bjaj_ye_djQ&t=2022s" 
                                                       class="btn w-100" 
                                                       style="background:#181b2c;color:#fff;font-weight:600;font-size:0.85rem;border-radius:1.5rem;padding:0.5rem 0;box-shadow:0 2px 8px rgba(0,0,0,0.08);"
                                                       target="_blank" rel="noopener noreferrer">
                                                       WATCH<br>NOW
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- Audio Player -->
                                            <div class="audio-player-container" style="width:450px;padding-left:1.5rem;">
                                                <div class="d-flex align-items-center gap-1 mb-2">
                                                    <button class="play-button" id="playButton1" onclick="toggleAudio('audio1')" 
                                                            style="width:44px;height:44px;flex-shrink:0;">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                    <div class="audio-time" id="time1" style="font-size:0.9rem;color:#64748b;width:80px;">0:00 / 0:00</div>
                                                </div>
                                                <div class="audio-progress" onclick="seekAudio('audio1', event)" 
                                                     style="height:6px;background:#e2e8f0;border-radius:3px;">
                                                    <div class="audio-progress-bar" id="progress1" 
                                                         style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);height:100%;border-radius:3px;"></div>
                                                </div>
                                                <div id="audio1" class="audio-player"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Episode 2 -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Ep. 2</div>
                                        <div style="font-size:0.9rem;color:#64748b;">(Live Streaming - ICW Borneo)</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Panel 1:</div>
                                        Prof. Patrick Bellew RDI – SJ Group
                                        <div style="font-weight:600;margin-top:0.5rem;">Panel 2:</div>
                                        Neil Thomas MBE – Founder, Atelier One
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        BINA - ICW Borneo: <i>Challenges and Innovations in Construction Technology</i>
                                    </td>
                                </tr>
                                <!-- Episode 2 - Media Row -->
                                <tr>
                                    <td colspan="3" style="padding:1.5rem;border-bottom:1px solid #e5e7eb;background:#f8fafc;">
                                        <div class="d-flex flex-column gap-4" style="max-width:800px;margin:0 auto;">
                                            <!-- Image and Buttons Section -->
                                            <div class="d-flex flex-column flex-md-row align-items-center gap-4" style="width:450px;">
                                                <!-- Speaker Image -->
                                                <div style="width:320px;height:240px;flex-shrink:0;background:#f8fafc;border-radius:1rem;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                                                    <img src="{{ asset('images/posterbina-ep2.png') }}" 
                                                         alt="Speaker" 
                                                         data-bs-toggle="modal"
                                                         data-bs-target="#imageModal"
                                                         onclick="showImage(this.src)"
                                                         style="max-width:100%;max-height:100%;object-fit:contain;border-radius:0.75rem;cursor:pointer;">
                                                </div>
                                                <!-- Buttons Section -->
                                                <div class="flex-grow-1 d-flex flex-column gap-2" style="min-width:110px;">
                                                    <a href="{{ route('client.facility-management') }}" 
                                                       class="btn w-100" 
                                                       style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);color:#fff;font-weight:600;font-size:0.85rem;border-radius:1.5rem;padding:0.5rem 0;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                                                       VIEW<br>MORE
                                                    </a>
                                                    <a href="https://www.youtube.com/watch?v=wY7fdrD4fkI&t=1887s" 
                                                       class="btn w-100" 
                                                       style="background:#181b2c;color:#fff;font-weight:600;font-size:0.85rem;border-radius:1.5rem;padding:0.5rem 0;box-shadow:0 2px 8px rgba(0,0,0,0.08);"
                                                       target="_blank" rel="noopener noreferrer">
                                                       WATCH<br>NOW
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- Audio Player -->
                                            <div class="audio-player-container" style="width:450px;padding-left:1.5rem;">
                                                <div class="d-flex align-items-center gap-1 mb-2">
                                                    <button class="play-button" id="playButton3" onclick="toggleAudio('audio3')" 
                                                            style="width:44px;height:44px;flex-shrink:0;">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                    <div class="audio-time" id="time3" style="font-size:0.9rem;color:#64748b;width:80px;">0:00 / 0:00</div>
                                                </div>
                                                <div class="audio-progress" onclick="seekAudio('audio3', event)" 
                                                     style="height:6px;background:#e2e8f0;border-radius:3px;">
                                                    <div class="audio-progress-bar" id="progress3" 
                                                         style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);height:100%;border-radius:3px;"></div>
                                                </div>
                                                <div id="audio3" class="audio-player"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Episode 3 -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Ep. 3</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Panel 1:</div>
                                        TBA
                                        <div style="font-weight:600;margin-top:0.5rem;">Panel 2:</div>
                                        Datuk Ir. Elias Ismail – Chairman, Certibuild
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <i>The CIDB IBS Story – Overview of Construction Technology and Its Impact</i>
                                    </td>
                                </tr>
                                <!-- Episode 4 -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Ep. 4</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Panel 1:</div>
                                        TBA
                                        <div style="font-weight:600;margin-top:0.5rem;">Panel 2:</div>
                                        Ir Ts. Rofizlan Ahmad – Senior GM, CIDB Malaysia
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <i>Game-Changer Policies – Visionary Policies Shaping the Industry</i>
                                    </td>
                                </tr>
                                <!-- Episode 5 -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Ep. 5</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Panel 1:</div>
                                        Tan Sri Lim Kheng Cheng – Board of Director, Ekovest
                                        <div style="font-weight:600;margin-top:0.5rem;">Panel 2:</div>
                                        Zainora Zainal – CEO, CIDB Malaysia
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <i>Modular Building Technology – Global Trends in Modular Construction</i>
                                    </td>
                                </tr>
                                <!-- Episode 6 -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Ep. 6</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Panel 1:</div>
                                        Datuk Richard Lim Lit Chek – CEO, MGB Berhad
                                        <div style="font-weight:600;margin-top:0.5rem;">Panel 2:</div>
                                        Ir Ts. Zuraihi Abdul Ghani – CEO, CIDB IBS
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <i>Vendor Development and FM Ecosystem Growth – How the VDP Supports Construction Technology</i>
                                    </td>
                                </tr>
                                <!-- Episode 7 -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;">
                                        <div style="font-weight:600;">Ep. 7</div>
                                        <div style="font-size:0.9rem;color:#64748b;">(Live Streaming - ICW Kuala Lumpur)</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;">
                                        <div style="font-weight:600;">Panel:</div>
                                        Lawrence Chua – Executive Director, Scandinavian IBS Sdn Bhd (SIBS Malaysia)
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;">
                                        <i>BINA - ICW: The Future of Construction Through Modular & Construction Technology</i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- FM Podcast Column -->
        <div class="col-lg-6">
            <div class="podcast-episode-card d-flex flex-column h-100" style="background:#fff;border:1.5px solid #d1d5db;border-radius:1.25rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);overflow:hidden;">
                <!-- Header -->
                <div style="background:#181b2c;color:#fff;padding:1rem 1.5rem;">
                    <h3 style="font-size:clamp(1.25rem, 4vw, 1.5rem);font-weight:800;margin:0;">FM PODCAST</h3>
                </div>
                <!-- Content -->
                <div class="p-3 p-md-4 d-flex flex-column flex-grow-1">
                    <!-- Episode Table -->
                    <div class="table-responsive">
                        <table class="table" style="border:1px solid #e5e7eb;border-radius:0.5rem;overflow:hidden;">
                            <thead style="background:#f8fafc;">
                                <tr>
                                    <th style="padding:1rem;font-weight:700;color:#181b2c;border-bottom:2px solid #e5e7eb;">Episode</th>
                                    <th style="padding:1rem;font-weight:700;color:#181b2c;border-bottom:2px solid #e5e7eb;">Panelist</th>
                                    <th style="padding:1rem;font-weight:700;color:#181b2c;border-bottom:2px solid #e5e7eb;">Topic</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Episode 1 -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Ep. 1</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Panel 1:</div>
                                        Zainora Zainal – CEO, CIDB Malaysia
                                        <div style="font-weight:600;margin-top:0.5rem;">Panel 2:</div>
                                        YBhg. Dato' Seri Azman Bin Ibrahim – KSU, KKR
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <i>Sustainable Facility Management – Green buildings, energy efficiency, and ESG strategies</i>
                                    </td>
                                </tr>
                                <!-- Episode 2 -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Ep. 2</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Panel 1:</div>
                                        Sr Dr. Syamilah Yacob – JKR Malaysia
                                        <div style="font-weight:600;margin-top:0.5rem;">Panel 2:</div>
                                        Ts. Rohana Binti Abdul Manan – CIDB Malaysia
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <i>Smart FM Technologies – IoT, AI, automation, and predictive maintenance</i>
                                    </td>
                                </tr>
                                <!-- Episode 3 -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Ep. 3</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Panel 1:</div>
                                        Sr Ahmad Farrin Mokhtar – CIDB Malaysia
                                        <div style="font-weight:600;margin-top:0.5rem;">Panel 2:</div>
                                        TBA
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <i>Regulations & Compliance – Safety, certification, and industry standards</i>
                                    </td>
                                </tr>
                                <!-- Episode 4 -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Ep. 4</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Panel 1:</div>
                                        TBA
                                        <div style="font-weight:600;margin-top:0.5rem;">Panel 2:</div>
                                        Dato' Tengku Ab. Aziz Tengku Mahmud – CEO, PNB Merdeka Ventures Sdn
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <i>Asset & Lifecycle Management – Best practices in prolonging asset lifespan</i>
                                    </td>
                                </tr>
                                <!-- Episode 5 -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Ep. 5</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;">Panel 1:</div>
                                        Ahmad Ridzuan Ismail – CIDB Malaysia
                                        <div style="font-weight:600;margin-top:0.5rem;">Panel 2:</div>
                                        UDA Holdings
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <i>Workforce & Skill Development – Upskilling FM professionals for the future</i>
                                    </td>
                                </tr>
                                <!-- Episode 6 -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;">
                                        <div style="font-weight:600;">Ep. 6</div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;">
                                        <div style="font-weight:600;">Panel 1:</div>
                                        Mohammad Shahrizal Mohammad Idris – GFM Services Berhad
                                        <div style="font-weight:600;margin-top:0.5rem;">Panel 2:</div>
                                        Kementerian (TBA)
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;">
                                        <i>Challenges & Opportunities – Addressing operational and financial challenges in FM</i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Engagement Content -->
<div class="container py-4">
    <div class="text-center" style="max-width:800px;margin:0 auto;">
        <p style="font-size:1.15rem;color:#374151;font-weight:500;line-height:1.6;">
            Got something to say about the future of construction? Join us as a panelist on BINA Podcast—contact us today!
        </p>
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
    <iframe id="player3" 
            width="1" 
            height="1" 
            src="https://www.youtube.com/embed/wY7fdrD4fkI?enablejsapi=1&controls=0&showinfo=0&rel=0&modestbranding=1" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
    </iframe>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="max-width:90vw;">
        <div class="modal-content border-0" style="background:transparent;">
            <div class="modal-header border-0 p-3">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center p-3" style="min-height:80vh;">
                <img id="modalImage" src="" alt="Modal Image" style="max-width:85%;max-height:80vh;object-fit:contain;border-radius:1.25rem;box-shadow:0 4px 24px rgba(0,0,0,0.1);">
            </div>
        </div>
    </div>
</div>
@endsection 

@push('scripts')
<script>
// Load YouTube API with timeout
let apiLoadTimeout;
let isAPIReady = false;
let playersReady = {
    player1: false,
    player2: false,
    player3: false
};
let player1 = null;
let player2 = null;
let player3 = null;
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
    playersReady.player3 = true;
    updateButtonState('playButton1', false, false);
    updateButtonState('playButton2', false, false);
    updateButtonState('playButton3', false, false);
}

function onYouTubeIframeAPIReady() {
    console.log('YouTube API Ready');
    clearTimeout(apiLoadTimeout);
    isAPIReady = true;
    
    // Initialize players with timeout
    const playerInitTimeout = setTimeout(() => {
        console.log('Player initialization timeout - using fallback');
        initializeFallbackPlayers();
    }, 3000);
    
    try {
        player1 = new YT.Player('player1', {
            events: {
                'onReady': (event) => {
                    console.log('Player 1 Ready');
                    playersReady.player1 = true;
                    updateButtonState('playButton1', false, false);
                    if (playersReady.player1 && playersReady.player2 && playersReady.player3) {
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
                    if (playersReady.player1 && playersReady.player2 && playersReady.player3) {
                        clearTimeout(playerInitTimeout);
                    }
                },
                'onStateChange': onPlayerStateChange,
                'onError': onPlayerError
            }
        });

        player3 = new YT.Player('player3', {
            events: {
                'onReady': (event) => {
                    console.log('Player 3 Ready');
                    playersReady.player3 = true;
                    updateButtonState('playButton3', false, false);
                    if (playersReady.player1 && playersReady.player2 && playersReady.player3) {
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
    return playersReady.player1 && playersReady.player2 && playersReady.player3;
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
    const playerId = player.getIframe().id === 'player1' ? 'audio1' : player.getIframe().id === 'player2' ? 'audio2' : 'audio3';
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
    const playerId = player.getIframe().id === 'player1' ? 'audio1' : player.getIframe().id === 'player2' ? 'audio2' : 'audio3';
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
    
    const player = audioId === 'audio1' ? player1 : audioId === 'audio2' ? player2 : player3;
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
    
    const player = audioId === 'audio1' ? player1 : audioId === 'audio2' ? player2 : player3;
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
    const timeDisplay3 = document.querySelector('#time3');
    if (timeDisplay1) timeDisplay1.textContent = '0:00 / 0:00';
    if (timeDisplay2) timeDisplay2.textContent = '0:00 / 0:00';
    if (timeDisplay3) timeDisplay3.textContent = '0:00 / 0:00';
    
    // Set initial button states
    updateButtonState('playButton1', true, false);
    updateButtonState('playButton2', true, false);
    updateButtonState('playButton3', true, false);
    
    // Load YouTube API
    loadYouTubeAPI();

    // Intersection Observer for scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1
    });

    // Observe all elements with scroll-reveal class
    document.querySelectorAll('.scroll-reveal').forEach((el) => {
        observer.observe(el);
    });

    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const heroSection = document.querySelector('.hero-section-store');
        const scrolled = window.pageYOffset;
        heroSection.style.backgroundPositionY = -(scrolled * 0.5) + 'px';
    });
});

function showImage(src) {
    document.getElementById('modalImage').src = src;
}

// Handle modal open
document.getElementById('imageModal').addEventListener('show.bs.modal', function () {
    document.body.style.overflow = 'hidden';
});

// Handle modal close
document.getElementById('imageModal').addEventListener('hidden.bs.modal', function () {
    document.body.style.overflow = 'auto';
});
</script>
@endpush 