@extends('client.layouts.app')

@section('title', 'BINA | NextGen BINA')

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
    <h1 class="hero-title-store">NEXTGEN BINA</h1>
    <div class="breadcrumb-store">
        <a href="/">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>NextGen BINA</span>
    </div>
</div>

<!-- Main Content Section -->
<div class="container py-5">
    <div class="d-flex ma-flex-row flex-lg-row flex-column align-items-start justify-content-between gap-4">
        <!-- Left: Logo, Title, Headline, Description -->
        <div class="flex-grow-1" style="min-width: 300px;">
            <div class="ma-title">
                <img src="{{ asset('images/nextgen-logo.png') }}" alt="NextGen BINA Logo" class="ma-logo" onerror="this.style.display='none'">
            </div>
            <div class="ma-headline">NEXTGEN TVET: MODULAR THINKERS</div>
            <div class="ma-desc">
                BINA 2025 proudly introduces NextGen TVET: Modular Thinkers, an exciting competition designed to spark innovation and real-world problem-solving among TVET students through the lens of modular construction.
            </div>
            <div class="ma-desc">
                The competition challenges participants to design innovative, functional, and cost-effective modular building solutions that address critical global needs such as affordable housing, disaster relief shelters, and eco-friendly structures. Beyond design, students will also be tested on their ability to assemble modular structures quickly and accurately under time constraints, simulating the fast-paced demands of real-world construction scenarios.
            </div>
            <!-- Image Section (no video preview) -->
            <div class="ma-video-preview position-relative mt-4" style="max-width: 600px;">
                <img src="{{ asset('images/facility.jpg') }}" alt="NextGen BINA" style="width:100%; border-radius: 2rem; display:block;">
            </div>
            <div style="color:#6b7280;font-size:1.18rem;margin-top:2rem;margin-bottom:1.5rem;max-width:700px;">
                NextGen TVET: Modular Thinkers is more than a competition—it's a platform to showcase the future talents who will drive innovation, sustainability, and smart urban development through modular technology.
            </div>
        </div>
        <!-- Right: Event Details Card -->
        <div>
            <div class="ma-card" style="min-width:270px;max-width:340px;background:#f7f5fa;border-radius:1.25rem;padding:2rem 2rem 1.5rem 2rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);color:#22223b;">
                <div style="font-size:1.18rem;font-weight:500;color:#22223b;margin-bottom:1.2rem;">Key objectives of the competition include:</div>
                <ul style="color:#4b5563;font-size:1.08rem;padding-left:1.1em;">
                    <li style="margin-bottom:1.2em;">Encouraging creativity and practicality in designing modular solutions that solve real-world challenges.</li>
                    <li style="margin-bottom:1.2em;">Testing hands-on skills in modular assembly to mirror industry expectations for speed and precision.</li>
                    <li>Promoting sustainability and energy efficiency, inspiring students to build modular structures that prioritize environmental responsibility.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 