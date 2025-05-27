@extends('client.layouts.app')

@section('title', 'BINA | About')

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
    .about-bg {
        background: #f8fafc;
        width: 100%;
        min-height: 100px;
    }
    .about-section {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 2.5rem 2rem;
        margin: 3rem auto 2rem auto;
        max-width: 900px;
        position: relative;
        z-index: 2;
    }
    .about-section h2 {
        font-size: 1.4rem;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        color: #2563eb;
    }
    .about-section p {
        font-size: 1.08rem;
        color: #333;
        margin-bottom: 1.2rem;
        line-height: 1.7;
    }
    .about-logo-header-wrap {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 1.2rem;
        max-width: 300px;
    }
    .about-logo-img {
        width: 100%;
        max-width: 200px;
        height: auto;
        display: block;
        margin-bottom: 2.0rem;
    }
    .about-header-text {
        font-size:2rem;
        font-weight:800;
        color:#22223b;
        margin-bottom:1.2rem;
        letter-spacing:1px;
        line-height:1.1;
        text-align:left;
        width: 100%;
        max-width: 300px;
    }
    /* Add summary section styles */
    .summary-section {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 2.5rem 2rem 2rem 2rem;
        margin: 3rem auto 2rem auto;
        max-width: 1100px;
        position: relative;
        z-index: 2;
    }
    .summary-title {
        font-size: 2rem;
        font-weight: 800;
        color: #181818;
        text-align: center;
        margin-bottom: 2.2rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .summary-title span {
        display: block;
        font-size: 1.25rem;
        font-weight: 700;
        margin-top: 0.5rem;
        text-transform: none;
    }
    .summary-divider {
        width: 100px;
        height: 2px;
        background: linear-gradient(90deg, #ff9800 0%, #ff5e62 100%);
        margin: 0 auto 1.5rem auto;
        border-radius: 2px;
    }
    .summary-cards-row {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
    .summary-card {
        background: #f5f5f7;
        border-radius: 1rem;
        padding: 1.5rem 1.5rem 1.2rem 1.5rem;
        flex: 1 1 320px;
        min-width: 280px;
        max-width: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .summary-card img {
        max-height: 48px;
        margin-bottom: 0.7rem;
    }
    .summary-card .summary-card-title {
        font-size: 1.15rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
        text-align: center;
    }
    .summary-card .summary-card-title.modular {
        color: #ff9800;
    }
    .summary-card .summary-card-title.facility {
        color: #1cc7b6;
    }
    .summary-card .summary-card-desc {
        font-size: 1.05rem;
        color: #22223b;
        text-align: center;
        margin-bottom: 0;
    }
    @media (max-width: 991px) {
        .summary-cards-row {
            flex-direction: column;
            gap: 1.5rem;
        }
        .summary-card {
            max-width: 100%;
        }
    }
    /* Three Key Showcase section styles */
    .showcase-section {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 2.5rem 2rem 2rem 2rem;
        margin: 3rem auto 2rem auto;
        max-width: 1100px;
        position: relative;
        z-index: 2;
    }
    .showcase-title {
        font-size: 2rem;
        font-weight: 800;
        color: #181818;
        text-align: center;
        margin-bottom: 2.2rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .showcase-cards-row {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
    .showcase-card {
        background: #f5f5f7;
        border-radius: 1rem;
        padding: 1.5rem 1.5rem 1.2rem 1.5rem;
        flex: 1 1 320px;
        min-width: 280px;
        max-width: 370px;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .showcase-card img {
        max-height: 48px;
        margin-bottom: 0.7rem;
        background: #ededed;
        border-radius: 0.7rem;
        padding: 0.5rem 1.2rem;
    }
    .showcase-card .showcase-card-desc {
        font-size: 1.05rem;
        color: #22223b;
        text-align: center;
        margin-bottom: 0;
    }
    @media (max-width: 991px) {
        .showcase-cards-row {
            flex-direction: column;
            gap: 1.5rem;
        }
        .showcase-card {
            max-width: 100%;
        }
    }
    /* Modular Asia section styles */
    .modular-asia-section {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 2.5rem 2rem 2rem 2rem;
        margin: 3rem auto 2rem auto;
        max-width: 1100px;
        position: relative;
        z-index: 2;
    }
    .modular-asia-row {
        display: flex;
        flex-wrap: wrap;
        gap: 2.5rem;
        align-items: flex-start;
        margin-bottom: 2.5rem;
    }
    .modular-asia-left {
        flex: 1 1 340px;
        min-width: 260px;
        max-width: 420px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .modular-asia-logo {
        max-width: 260px;
        margin-bottom: 1.2rem;
    }
    .modular-asia-heading {
        font-size: 2.1rem;
        font-weight: 800;
        color: #181818;
        margin-bottom: 0.7rem;
        line-height: 1.1;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .modular-asia-right {
        flex: 2 1 400px;
        min-width: 260px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }
    .modular-asia-right p {
        font-size: 1.08rem;
        color: #333;
        margin-bottom: 1.1rem;
        line-height: 1.7;
    }
    .modular-asia-images-row {
        display: flex;
        gap: 2rem;
        width: 100%;
        margin-top: 1.5rem;
    }
    .modular-asia-img-wrap {
        flex: 1 1 0;
        position: relative;
    }
    .modular-asia-img-wrap img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        border-radius: 1.2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    .modular-asia-img-main {
        border-radius: 1.2rem;
        max-width: 520px;
        width: 100%;
        height: 320px;
        object-fit: cover;
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        position: relative;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    .modular-asia-img-main:hover {
        transform: translateY(-5px);
    }
    .modular-asia-img-secondary {
        border-radius: 1.2rem;
        max-width: 280px;
        width: 100%;
        height: 320px;
        object-fit: cover;
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        transition: transform 0.3s ease;
    }
    .modular-asia-img-secondary:hover {
        transform: translateY(-5px);
    }
    .modular-asia-play-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255, 152, 0, 0.9);
        color: #fff;
        border-radius: 50%;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        z-index: 2;
        transition: all 0.3s ease;
    }
    .modular-asia-img-main:hover .modular-asia-play-btn {
        background: rgba(255, 152, 0, 1);
        transform: translate(-50%, -50%) scale(1.1);
    }
    @media (max-width: 991px) {
        .modular-asia-row, .modular-asia-images-row {
            flex-direction: column;
            gap: 1.5rem;
            align-items: stretch;
        }
        .modular-asia-left, .modular-asia-right {
            max-width: 100%;
        }
        .modular-asia-img-main, .modular-asia-img-secondary {
            max-width: 100%;
            height: 280px;
        }
        .modular-asia-img-wrap img {
            height: 180px;
        }
    }
    .event-gallery-section {
        max-width: 1100px;
        margin: 3rem auto 2rem auto;
    }
    .event-gallery-section img {
        height: 420px;
        object-fit: cover;
        border-radius: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.10);
    }
    @media (max-width: 991px) {
        .event-gallery-section img {
            height: 240px !important;
            max-width: 100% !important;
        }
    }
    .audiences-section {
        max-width: 1100px;
        margin: 4.5rem auto 4.5rem auto;
        background: #f5f6fa;
        border-radius: 1.2rem;
        padding: 3rem 2rem;
    }
    .audiences-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 900;
        color: #0a102f;
        letter-spacing: 1px;
        margin-bottom: 2.5rem;
    }
    .audience-heading {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0a102f;
        text-transform: uppercase;
        margin-bottom: 0.7rem;
        letter-spacing: 0.5px;
    }
    .audience-desc {
        display: flex;
        align-items: flex-start;
        font-size: 1.08rem;
        color: #22223b;
        line-height: 1.6;
        font-weight: 400;
    }
    .audience-bar {
        display: inline-block;
        width: 6px;
        height: 1.5em;
        background: #ff9800;
        border-radius: 2px;
        margin-right: 0.7em;
        margin-top: 0.15em;
        flex-shrink: 0;
    }
    @media (max-width: 991px) {
        .audiences-section {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .audiences-title {
            font-size: 2rem;
        }
        .audience-heading {
            font-size: 1.1rem;
        }
        .audience-desc {
            font-size: 1rem;
        }
    }
    .unveil-section {
        background: linear-gradient(180deg,#fff 60%,#f7f6fb 100%);
        padding: 3.5rem 0 2.5rem 0;
    }
    .unveil-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 900;
        color: #0a102f;
        letter-spacing: 1px;
        margin-bottom: 2.8rem;
    }
    .unveil-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        border: 2px solid #e5e7eb;
        padding: 2.2rem 1.2rem 1.5rem 1.2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 260px;
        max-width: 340px;
        width: 100%;
        transition: box-shadow 0.2s;
    }
    .unveil-card:hover {
        box-shadow: 0 6px 32px rgba(255,152,0,0.13);
        border-color: #ff9800;
    }
    .unveil-icon {
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .unveil-label {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0a102f;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    @media (max-width: 991px) {
        .unveil-title {
            font-size: 1.5rem;
        }
        .unveil-card {
            min-width: 100%;
            max-width: 100%;
            margin-bottom: 1.5rem;
        }
        .unveil-section .row {
            flex-direction: column;
            align-items: center;
        }
    }
    .sponsor-logo {
        max-width: 180px;
        width: 100%;
        height: auto;
        margin: 0 10px;
        transition: transform 0.2s;
        border-radius: 0;
    }
    .sponsor-logo:hover {
        transform: scale(1.05);
    }
    .sponsorship-title {
        text-align: center;
        font-size: 2.3rem;
        font-weight: 900;
        color: #0a102f;
        letter-spacing: 1px;
        margin-bottom: 2.2rem;
    }
    @media (max-width: 991px) {
        .sponsor-logo {
            max-width: 120px;
            margin: 0 5px;
        }
    }
    .cpd-section {
        background: #f5f6fa;
        border-radius: 1.2rem;
        padding: 3rem 2rem;
        margin-top: 4.5rem !important;
        margin-bottom: 4.5rem !important;
    }
    .cpd-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 900;
        color: #0a102f;
        letter-spacing: 1px;
        margin-bottom: 2.8rem;
    }
    .cpd-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        border: 2px solid #e5e7eb;
        padding: 2.2rem 1.2rem 1.5rem 1.2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 260px;
        max-width: 370px;
        width: 100%;
        transition: box-shadow 0.2s;
        margin-bottom: 0;
    }
    .cpd-card:hover {
        box-shadow: 0 6px 32px rgba(255,152,0,0.13);
        border-color: #ff9800;
    }
    .cpd-icon {
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cpd-label {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0a102f;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    @media (max-width: 991px) {
        .cpd-title {
            font-size: 1.5rem;
        }
        .cpd-card {
            min-width: 100%;
            max-width: 100%;
            margin-bottom: 1.5rem;
        }
        .cpd-section .row {
            flex-direction: column;
            align-items: center;
        }
    }
    .speakers-section {
        background: #fafbfc;
        padding: 3.5rem 0 2.5rem 0;
    }
    .join-btn {
        display: inline-block;
        background: #ff9800;
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 24px;
        padding: 0.6rem 1.6rem;
        margin-top: 0.5rem;
        text-decoration: none;
        letter-spacing: 1px;
        box-shadow: 0 2px 8px rgba(255,152,0,0.08);
        transition: background 0.2s;
    }
    .join-btn:hover {
        background: #ffb347;
        color: #fff;
    }
    .speaker-card {
        background: #fff;
        border-radius: 20px 20px 16px 16px/20px 20px 32px 32px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        border: 2px solid #e5e7eb;
        padding: 0 0 1.2rem 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        max-width: 270px;
        min-width: 220px;
        margin-bottom: 0;
        position: relative;
        transition: box-shadow 0.2s;
    }
    .speaker-card:hover {
        box-shadow: 0 6px 32px rgba(255,152,0,0.13);
        border-color: #ff9800;
    }
    .speaker-img {
        width: 120px;
        height: 120px;
        background: none;
        border-radius: 50%;
        margin-top: -40px;
        margin-bottom: 1.2rem;
        border: 6px solid #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .speaker-info {
        background: #fff;
        border-radius: 0 0 16px 16px/0 0 32px 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        padding: 1.2rem 1rem 0.7rem 1rem;
        width: 100%;
        text-align: center;
        position: relative;
        z-index: 2;
    }
    .speaker-name {
        font-size: 1.08rem;
        font-weight: 700;
        color: #0a102f;
        margin-bottom: 0.2rem;
    }
    .speaker-position {
        font-size: 0.98rem;
        color: #ff9800;
        font-weight: 600;
        margin-bottom: 0.7rem;
    }
    .speaker-socials {
        display: flex;
        justify-content: center;
        gap: 0.7rem;
    }
    .speaker-social {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #ff9800;
        color: #fff;
        font-size: 1.1rem;
        transition: background 0.2s;
        text-decoration: none;
    }
    .speaker-social:hover {
        background: #ffb347;
        color: #fff;
    }
    @media (max-width: 991px) {
        .speakers-section {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .speaker-card {
            max-width: 100%;
            min-width: 100%;
            margin-bottom: 1.5rem;
        }
        .speaker-img {
            width: 90px;
            height: 90px;
            margin-top: -30px;
        }
    }
    .summary-section,
    .showcase-section,
    .modular-asia-section,
    .facility-mgmt-section,
    .event-gallery-section,
    .audiences-section,
    .unveil-section,
    .sponsorship-section,
    .cpd-section,
    .speakers-section {
        margin-top: 4.5rem !important;
        margin-bottom: 4.5rem !important;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">ABOUT</h1>
    <div class="breadcrumb-store">
        <a href="/">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>About</span>
    </div>
</div>

<!-- Main Content Section -->
<div class="about-bg">
    <div class="container py-5">
        <div class="row g-4 align-items-center">
            <!-- Left: Logo and About Text -->
            <div class="col-lg-7">
                <div style="display: flex; align-items: flex-start; gap: 1.5rem;">
                    <!-- Vertical Accent Bar -->
                    <div style="width: 16px; min-width: 16px; height: 100%; border-radius: 12px; background: linear-gradient(180deg, #ff9800 0%, #ff5e62 100%); margin-right: 0.5rem;"></div>
                    <div class="about-section" style="box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                        <div class="about-logo-header-wrap">
                            <img src="{{ asset('images/about-bina-logo.png') }}" alt="BINA 2025 Logo" class="about-logo-img">
                            <div class="about-header-text">ABOUT BINA</div>
                        </div>
                        <p>Formerly known as CR4.0 Conference, BINA 2025 is a platform to introduce building technologies into the construction industry, including infrastructure, real estate and other built assets that are designed, constructed, operated and maintained. In-line with the vision of the International Construction Week (ICW) 2025, this premier event will be held on 28 – 30th October 2025 with two overarching platforms.</p>
                        <p>As a premier platform for showcasing transformative building technologies, we aims to drive any innovation and efficiency within the IBS sector. By aligning with the government's vision, BINA 2025 aims to propel the IBS industry forward, delivering substantial economic and social impacts and establishing Malaysia as a leader in modern construction practices.</p>
                        <p style="margin-bottom:0;"><b>In conjunction with International Construction Week</b><br>
                        BINA 2025 is one of the exclusive event of the ICW 2025. While ICW focuses on the overall aspect of construction industry in Malaysia, BINA 2025 will be the platform for the construction industry players especially in Industrialised Building System (IBS) to explore in person, the latest trends, developments and technologies in the construction industry</p>
                    </div>
                </div>
            </div>
            <!-- Right: Image -->
            <div class="col-lg-5 d-flex justify-content-center">
                <img src="{{ asset('images/about-1.jpg') }}" alt="About BINA" style="max-width:100%;border-radius:1.2rem;box-shadow:0 2px 12px rgba(0,0,0,0.08);object-fit:cover;">
            </div>
        </div>
    </div>
</div>

<!-- Summary Section -->
<div class="summary-section">
    <div class="summary-divider"></div>
    <div class="summary-title">
        SUMMARY OF BINA 2025:<br>
        <span>-CONSTRUCTING THE FUTURE OF ASEAN-</span>
    </div>
    <div class="summary-cards-row">
        <!-- Modular Asia Card -->
        <div class="summary-card">
            <img src="{{ asset('images/modular-logo.png') }}" alt="Modular Asia Forum & Exhibition 2025 Logo">
        </div>
        <!-- Facility Management Card -->
        <div class="summary-card">
            <img src="{{ asset('images/facility-logo.png') }}" alt="Facility Management Engagement Day 2025 Logo">
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="summary-card-desc" style="text-align:left;">
                MODULAR ASIA will serve as the premier platform advancing Modular Technology, Modern Methods of Construction (MMC), and Industrialised Building Systems (IBS), gathering global leaders to exchange best practices and showcase breakthroughs driving construction efficiency, sustainability, and scalability across ASEAN and beyond.
            </div>
        </div>
        <div class="col-lg-6">
            <div class="summary-card-desc" style="text-align:left;">
                Facility Management Engagement Day will foster dynamic exchanges among facility managers, technology providers, and industry experts, unlocking business opportunities while exploring the latest trends and challenges in facility management.
            </div>
        </div>
    </div>
</div>

<!-- Three Key Showcase Section -->
<div class="showcase-section">
    <div class="showcase-title">THREE KEY SHOWCASE</div>
    <div class="showcase-cards-row">
        <!-- Modular Thinker Card -->
        <div class="showcase-card">
            <img src="{{ asset('images/about-2.png') }}" alt="NextGen TVET Modular Thinker Logo">
            <div class="showcase-card-desc">
                Modular Thinkers invites TVET students to design sustainable, affordable township developments, promoting the next generation of smart modular living.
            </div>
        </div>
        <!-- Career Spotlight Card -->
        <div class="showcase-card">
            <img src="{{ asset('images/about-3.png') }}" alt="Career Spotlight Logo">
            <div class="showcase-card-desc">
                BINA: Career Spotlight returns for its second year, empowering talents and professionals by connecting them with top employers in the construction industry, with strong collaboration support from PERKESO.
            </div>
        </div>
        <!-- IBS Homes Card -->
        <div class="showcase-card">
            <img src="{{ asset('images/about-2.png') }}" alt="IBS Homes Logo">
            <div class="showcase-card-desc">
                IBS Homes Powered by Modular Technology: CIDB IBS presents a bold evolution of housing solutions that are faster, smarter, and more sustainable, offering the public an immersive experience into the future of urban living.
            </div>
        </div>
    </div>
</div>

<!-- Modular Asia Section -->
<div class="modular-asia-section">
    <div class="modular-asia-row">
        <div class="modular-asia-left">
            <img src="{{ asset('images/modular-logo.png') }}" alt="Modular Asia Forum & Exhibition 2025 Logo" class="modular-asia-logo">
            <div class="modular-asia-heading">TRANSFORMING SEN'S<br>CONSTRUCTION LANDSCAPE</div>
        </div>
        <div class="modular-asia-right">
            <p>As part of BINA Conference at ICW 2025, MODULAR ASIA is a premier forum and exhibition dedicated to advancing Modular Technology, Modern Methods of Construction (MMC), and Industrialised Building Systems (IBS).</p>
            <p>This exclusive platform will bring together global modular leaders, innovators, and industry pioneers to share best practices, insights, and breakthroughs that are revolutionizing construction efficiency, sustainability, and scalability across SEN and Global market.</p>
        </div>
    </div>
    <div class="modular-asia-images-row">
        <div class="modular-asia-img-wrap">
            <img src="{{ asset('images/about-4.jpg') }}" alt="Modular Asia Main" class="img-fluid">
            <a href="#" class="modular-asia-play-btn" style="text-decoration:none;" tabindex="-1">
                <span style="display:inline-block;margin-left:6px;">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="14" cy="14" r="14" fill="none"/>
                        <polygon points="11,9 21,14 11,19" fill="white"/>
                    </svg>
                </span>
            </a>
        </div>
        <div class="modular-asia-img-wrap">
            <img src="{{ asset('images/about-5.jpg') }}" alt="Modular Asia Secondary" class="img-fluid">
        </div>
    </div>
</div>

<!-- Facility Management Engagement Day Section -->
<div class="facility-mgmt-section" style="background:#fff;border-radius:1rem;box-shadow:0 2px 12px rgba(0,0,0,0.06);padding:2.5rem 2rem 2rem 2rem;margin:3rem auto 2rem auto;max-width:1100px;position:relative;z-index:2;">
    <div class="row align-items-center g-4 flex-wrap">
        <!-- Left: Description Text -->
        <div class="col-lg-6 order-lg-1 order-2">
            <div style="color:#7a7671;font-size:1.13rem;line-height:1.7;font-family:'Inter',sans-serif;">
                <p style="margin-bottom:1.5rem;">As part of BINA Conference at ICW 2025, MODULAR ASIA is a premier forum and exhibition dedicated to advancing Modular Technology, Modern Methods of Construction (MMC), and Industrialised Building Systems (IBS).</p>
                <p style="margin-bottom:0;">This exclusive platform will bring together global modular leaders, innovators, and industry pioneers to share best practices, insights, and breakthroughs that are revolutionizing construction efficiency, sustainability, and scalability across SEN and Global market.</p>
            </div>
        </div>
        <!-- Right: Logo and Heading -->
        <div class="col-lg-6 order-lg-2 order-1 d-flex flex-column align-items-lg-start align-items-center text-lg-left text-center">
            <div class="d-flex align-items-center mb-2" style="gap:0.7rem;">
                <img src="{{ asset('images/facility-logo.png') }}" alt="Facility Management Engagement Day 2025 Logo" style="max-width:200px;width:200px;height:auto;">
            </div>
            <div style="font-size:2.5rem;font-weight:900;color:#0a102f;line-height:1.1;text-transform:uppercase;letter-spacing:0.5px;text-align:left;">
                TRANSFORMING SEN'S<br>CONSTRUCTION<br>LANDSCAPE
            </div>
        </div>
    </div>
</div>

<!-- Event Gallery Section -->
<div class="event-gallery-section" style="max-width:1100px;margin:3rem auto 2rem auto;">
    <div class="row g-3 align-items-center flex-wrap">
        <!-- Left Image (Speaker) -->
        <div class="col-lg-6 d-flex justify-content-center">
            <img src="{{ asset('images/about-6.jpg') }}" alt="Event Speaker" style="width:100%;max-width:420px;height:420px;object-fit:cover;border-radius:1.5rem;box-shadow:0 4px 20px rgba(0,0,0,0.10);">
        </div>
        <!-- Right Image (Booth with Play Button) -->
        <div class="col-lg-6 d-flex justify-content-center position-relative">
            <div style="position:relative;width:100%;max-width:520px;">
                <img src="{{ asset('images/about-7.jpg') }}" alt="Exhibition Booth" style="width:100%;height:420px;object-fit:cover;border-radius:1.5rem;box-shadow:0 4px 20px rgba(0,0,0,0.10);">
                <a href="#" class="event-gallery-play-btn" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:#ff9800;color:#fff;border-radius:50%;width:90px;height:90px;display:flex;align-items:center;justify-content:center;font-size:2.8rem;box-shadow:0 4px 15px rgba(0,0,0,0.18);z-index:2;text-decoration:none;transition:background 0.2s;">
                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="22" cy="22" r="22" fill="none"/>
                        <polygon points="18,14 32,22 18,30" fill="white"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Our Audiences Section -->
<div class="audiences-section">
    <div class="audiences-title">
        - OUR AUDIENCES -
    </div>
    <div class="row g-5">
        <!-- Left Column -->
        <div class="col-md-6">
            <div class="audience-block mb-5">
                <div class="audience-heading">CONSTRUCTION PROFESSIONALS</div>
                <div class="audience-desc"><span class="audience-bar"></span>Architects, engineers, contractors, and developers looking to stay ahead with cutting-edge technologies.</div>
            </div>
            <div class="audience-block mb-5">
                <div class="audience-heading">REAL ESTATE DEVELOPERS</div>
                <div class="audience-desc"><span class="audience-bar"></span>Learn about the economic and social impacts of advanced building technologies</div>
            </div>
            <div class="audience-block mb-5 mb-md-0">
                <div class="audience-heading">TECHNOLOGY PROVIDERS</div>
                <div class="audience-desc"><span class="audience-bar"></span>Showcase and explore innovations like IBS, BIM, 3D printing, and automation</div>
            </div>
        </div>
        <!-- Right Column -->
        <div class="col-md-6">
            <div class="audience-block mb-5">
                <div class="audience-heading">INVESTORS & BUSINESS LEADERS</div>
                <div class="audience-desc"><span class="audience-bar"></span>Explore new opportunities in current construction technology</div>
            </div>
            <div class="audience-block">
                <div class="audience-heading">ACADEMICIAN</div>
                <div class="audience-desc"><span class="audience-bar"></span>Researchers, professors and students specializing in construction, engineering and related fields can gain insights into the latest technologies and connect with industry professionals</div>
            </div>
        </div>
    </div>
</div>

<!-- Unveil the Extraordinary Section -->
<div class="unveil-section" style="background:linear-gradient(180deg,#fff 60%,#f7f6fb 100%);padding:3.5rem 0 2.5rem 0;">
    <div class="container" style="max-width:1200px;">
        <div class="unveil-title" style="text-align:center;font-size:2.5rem;font-weight:900;color:#0a102f;letter-spacing:1px;margin-bottom:2.8rem;">
            UNVEIL THE EXTRAORDINRY AT BINA<br>2025
        </div>
        <div class="row g-4 justify-content-center">
            <!-- Card 1 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="unveil-card">
                    <div class="unveil-icon">
                        <!-- Target SVG -->
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><circle cx="24" cy="24" r="10" stroke="#fff" stroke-width="2"/><circle cx="24" cy="24" r="4" fill="#fff"/></svg>
                    </div>
                    <div class="unveil-label">DELIVERING OUR INSIGHT</div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="unveil-card">
                    <div class="unveil-icon">
                        <!-- Networking SVG -->
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><g stroke="#fff" stroke-width="2"><circle cx="16" cy="22" r="3"/><circle cx="32" cy="22" r="3"/><circle cx="24" cy="16" r="3"/><path d="M24 19v3m-5 0h10m-13 5c0-2.2 2.7-4 6-4s6 1.8 6 4"/></g></svg>
                    </div>
                    <div class="unveil-label">NETWORKING POTENTIAL</div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="unveil-card">
                    <div class="unveil-icon">
                        <!-- Dialogue SVG -->
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><g stroke="#fff" stroke-width="2"><circle cx="16" cy="22" r="3"/><circle cx="32" cy="22" r="3"/><path d="M24 28c-4 0-8-2-8-6v-2a8 8 0 0 1 16 0v2c0 4-4 6-8 6Z"/></g></svg>
                    </div>
                    <div class="unveil-label">SHAPING THE DIALOGUE</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sponsorship Section -->
<div class="sponsorship-section" style="background:#fff;padding:3rem 0 2rem 0;">
    <div class="sponsorship-title" style="text-align:center;font-size:2.3rem;font-weight:900;color:#0a102f;letter-spacing:1px;margin-bottom:2.2rem;">
        SPONSORSHIP
    </div>
    <div id="sponsorshipCarousel" class="carousel slide" data-bs-ride="carousel" style="max-width:900px;margin:0 auto;">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="d-flex justify-content-center align-items-center gap-4 flex-wrap">
                    <img src="{{ asset('images/about-sponsor.png') }}" alt="Sponsor 1" class="sponsor-logo">
                    <img src="{{ asset('images/about-sponsor.png') }}" alt="Sponsor 2" class="sponsor-logo">
                    <img src="{{ asset('images/about-sponsor.png') }}" alt="Sponsor 3" class="sponsor-logo">
                    <img src="{{ asset('images/about-sponsor.png') }}" alt="Sponsor 4" class="sponsor-logo">
                </div>
            </div>
            <div class="carousel-item">
                <div class="d-flex justify-content-center align-items-center gap-4 flex-wrap">
                    <img src="{{ asset('images/about-sponsor.png') }}" alt="Sponsor 2" class="sponsor-logo">
                    <img src="{{ asset('images/about-sponsor.png') }}" alt="Sponsor 3" class="sponsor-logo">
                    <img src="{{ asset('images/about-sponsor.png') }}" alt="Sponsor 4" class="sponsor-logo">
                    <img src="{{ asset('images/about-sponsor.png') }}" alt="Sponsor 1" class="sponsor-logo">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CCD ND CPD Points Applied Section -->
<div class="cpd-section" style="background:linear-gradient(180deg,#fff 60%,#f7f6fb 100%);padding:3.5rem 0 2.5rem 0;">
    <div class="container" style="max-width:1300px;">
        <div class="cpd-title" style="text-align:center;font-size:2.5rem;font-weight:900;color:#0a102f;letter-spacing:1px;margin-bottom:2.8rem;">
            CCD ND CPD POINTS APPLIED
        </div>
        <div class="row g-4 justify-content-center">
            <!-- Card 1 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="cpd-card">
                    <div class="cpd-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><circle cx="24" cy="24" r="10" stroke="#fff" stroke-width="2"/><circle cx="24" cy="24" r="4" fill="#fff"/></svg>
                    </div>
                    <div class="cpd-label">LEMBAGA ARKITEK MALAYSIA</div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="cpd-card">
                    <div class="cpd-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><circle cx="24" cy="24" r="10" stroke="#fff" stroke-width="2"/><circle cx="24" cy="24" r="4" fill="#fff"/></svg>
                    </div>
                    <div class="cpd-label">ROYAL INSTITUTION OF SURVEYORS MALAYSIA</div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="cpd-card">
                    <div class="cpd-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><g stroke="#fff" stroke-width="2"><rect x="14" y="18" width="20" height="12" rx="2"/><path d="M18 22h12M18 26h8"/></g></svg>
                    </div>
                    <div class="cpd-label">BOARD OF QUANTITY SURVEYORS</div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="cpd-card">
                    <div class="cpd-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><g stroke="#fff" stroke-width="2"><rect x="14" y="18" width="20" height="12" rx="2"/><path d="M18 22h12M18 26h8"/></g></svg>
                    </div>
                    <div class="cpd-label">MALAYSIA BOARD OF TECHNOLOGIES</div>
                </div>
            </div>
            <!-- Card 5 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="cpd-card">
                    <div class="cpd-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><g stroke="#fff" stroke-width="2"><circle cx="24" cy="24" r="10"/><circle cx="24" cy="24" r="4" fill="#fff"/></g></svg>
                    </div>
                    <div class="cpd-label">BOARD OF ENGINEERS MALAYSIA</div>
                </div>
            </div>
            <!-- Card 6 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="cpd-card">
                    <div class="cpd-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><g stroke="#fff" stroke-width="2"><path d="M16 32V16h16v16"/><path d="M20 20h8v8h-8z"/></g></svg>
                    </div>
                    <div class="cpd-label">CONSTRUCTION INDUSTRY DEVELOPMENT BOARD</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Our Speakers Section -->
<div class="speakers-section" style="background:#fafbfc;padding:3.5rem 0 2.5rem 0;">
    <div class="container" style="max-width:1300px;">
        <div class="row g-5 align-items-start">
            <!-- Left Column -->
            <div class="col-lg-3 d-flex flex-column align-items-lg-start align-items-center mb-4 mb-lg-0">
                <div style="color:#ff9800;font-size:1rem;font-weight:600;letter-spacing:1px;margin-bottom:0.5rem;">OUR SPEAKER</div>
                <div style="font-size:2.1rem;font-weight:900;color:#0a102f;letter-spacing:1px;margin-bottom:1.5rem;text-align:left;">OUR SPEAKERS</div>
                <a href="#" class="join-btn">JOIN WITH US</a>
            </div>
            <!-- Right Column: Speaker Cards -->
            <div class="col-lg-9">
                <div class="row g-4">
                    <!-- Speaker Card (repeat 6x) -->
                    @for ($i = 0; $i < 6; $i++)
                    <div class="col-md-4 d-flex justify-content-center @if($i==3) mt-4 @endif">
                        <div class="speaker-card">
                            <div class="speaker-img" style="background: none;">
                                <img src="https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg" alt="Speaker Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 6px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                            </div>
                            <div class="speaker-info">
                                <div class="speaker-name">SPEAKER NAME</div>
                                <div class="speaker-position">POSITION</div>
                                <div class="speaker-socials">
                                    <a href="#" class="speaker-social"><svg width="20" height="20" fill="none" viewBox="0 0 20 20"><circle cx="10" cy="10" r="10" fill="#ff9800"/><path d="M13.5 10.5H11.5V16H9V10.5H8V8.5H9V7.5C9 6.39543 9.89543 5.5 11 5.5H13V7.5H11.5C11.2239 7.5 11 7.72386 11 8V8.5H13L12.5 10.5Z" fill="#fff"/></svg></a>
                                    <a href="#" class="speaker-social"><svg width="20" height="20" fill="none" viewBox="0 0 20 20"><circle cx="10" cy="10" r="10" fill="#ff9800"/><path d="M7.5 8.5V13H9V8.5H7.5ZM8.25 7.75C8.66421 7.75 9 7.41421 9 7C9 6.58579 8.66421 6.25 8.25 6.25C7.83579 6.25 7.5 6.58579 7.5 7C7.5 7.41421 7.83579 7.75 8.25 7.75ZM10.5 10.5V13H12V10.75C12 10.3358 12.3358 10 12.75 10C13.1642 10 13.5 10.3358 13.5 10.75V13H15V10.5C15 9.39543 14.1046 8.5 13 8.5C12.4067 8.5 11.8457 8.79107 11.5 9.26756C11.1543 8.79107 10.5933 8.5 10 8.5C8.89543 8.5 8 9.39543 8 10.5V13H9.5V10.5C9.5 10.2239 9.72386 10 10 10C10.2761 10 10.5 10.2239 10.5 10.5Z" fill="#fff"/></svg></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var carousel = document.querySelector('#sponsorshipCarousel');
    if (carousel) {
        var bsCarousel = new bootstrap.Carousel(carousel, {
            interval: 2500,
            ride: 'carousel',
            pause: false
        });
    }
});
</script>
@endsection 