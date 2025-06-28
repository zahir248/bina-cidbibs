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
        animation: fadeInUp 0.8s ease 0.2s forwards;
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
        transition: transform 0.3s ease;
    }

    .ma-logo:hover {
        transform: scale(1.05);
    }

    .ma-card {
        background: #f7f5fa;
        border-radius: 1.25rem;
        padding: 2rem 2rem 1.5rem 2rem;
        box-shadow: 0 2px 12px rgba(80, 80, 120, 0.04);
        color: #22223b;
        transition: all 0.3s ease;
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
        transition: transform 0.3s ease;
    }

    .ma-detail-row:hover {
        transform: translateX(5px);
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
        max-width: 700px;
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

    @media (max-width: 991px) {
        .ma-flex-row {
            flex-direction: column;
            align-items: center !important;
        }
        .ma-card {
            margin-top: 2rem;
            margin: 2rem auto 0;
            width: 100%;
            max-width: 340px;
        }
        .sticky-sidebar {
            position: static;
            width: 100%;
            display: flex;
            justify-content: center;
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
        
        .ma-card {
            margin: 2rem 1rem 0;
            padding: 1.5rem;
        }

        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .ma-headline {
            font-size: 1.75rem;
            text-align: center;
        }

        .ma-desc {
            font-size: 1rem;
        }
    }

    .objectives-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .objectives-list li {
        position: relative;
        padding-left: 2.5rem;
        margin-bottom: 1.5rem;
        color: #4b5563;
        font-size: 1.08rem;
        transition: transform 0.3s ease;
    }

    .objectives-list li:last-child {
        margin-bottom: 0;
    }

    .objectives-list li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0.35rem;
        width: 1.5rem;
        height: 1.5rem;
        background: linear-gradient(45deg, #ff9800, #ffb347);
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(255, 152, 0, 0.2);
        transition: all 0.3s ease;
    }

    .objectives-list li::after {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0.85rem;
        width: 0.5rem;
        height: 0.5rem;
        border: 2px solid white;
        border-top: 0;
        border-left: 0;
        transform: rotate(45deg);
    }

    .objectives-list li:hover {
        transform: translateX(5px);
    }

    .objectives-list li:hover::before {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">NEXTGEN BINA</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>NextGen BINA</span>
    </div>
</div>

<!-- Main Content Section -->
<div class="container py-5">
    <!-- Main content wrapper -->
    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between gap-4">
        <!-- Left column content -->
        <div class="flex-grow-1" style="min-width: 300px;">
            <!-- Logo and Description Section - Always First -->
            <div class="order-1">
                <div class="ma-title text-center text-lg-start">
                    <img src="{{ asset('images/nextgen-logo.png') }}" alt="NextGen BINA Logo" class="ma-logo mx-auto mx-lg-0" onerror="this.style.display='none'">
                </div>
                <div class="ma-headline">NEXTGEN TVET: MODULAR THINKERS</div>
                <div class="ma-desc" style="max-width: 100%; text-align: justify; text-justify: inter-word;">
                    BINA 2025 proudly introduces NextGen TVET: Modular Thinkers, an exciting competition designed to spark innovation and real-world problem-solving among TVET students through the lens of modular construction.
                </div>
                <div class="ma-desc" style="max-width: 100%; text-align: justify; text-justify: inter-word;">
                    The competition challenges participants to design innovative, functional, and cost-effective modular building solutions that address critical global needs such as affordable housing, disaster relief shelters, and eco-friendly structures. Beyond design, students will also be tested on their ability to assemble modular structures quickly and accurately under time constraints, simulating the fast-paced demands of real-world construction scenarios.
                </div>
                <!-- Image Section with hover effect -->
                <div class="ma-video-preview position-relative mt-4" style="width:100%; max-width:100%; max-height: 500px; overflow: hidden;">
                    <img src="{{ asset('images/facility.jpg') }}" alt="NextGen BINA" 
                         style="width:100%; height: 500px; border-radius: 2rem; display:block; object-fit: cover; transition: transform 0.3s ease;"
                         onmouseover="this.style.transform='scale(1.02)'"
                         onmouseout="this.style.transform='scale(1)'">
                </div>
                <div class="ma-desc" style="color:#6b7280; font-size:1.18rem; margin-top:2rem; margin-bottom:1.5rem; max-width:100%; text-align: justify; text-justify: inter-word;">
                    NextGen TVET: Modular Thinkers is more than a competition—it's a platform to showcase the future talents who will drive innovation, sustainability, and smart urban development through modular technology.
                </div>
            </div>

            <!-- Event Details Card - Second on Mobile -->
            <div class="d-block d-lg-none order-2 mb-5">
                <div class="ma-card animate-on-scroll mx-auto" style="min-width:270px;max-width:340px;">
                    <div style="font-size:1.25rem;font-weight:600;color:#22223b;margin-bottom:1.5rem;border-bottom:2px solid #ff9800;padding-bottom:0.75rem;">
                        Key objectives of the competition:
                    </div>
                    <ul class="objectives-list">
                        <li>
                            <div style="font-weight:500;">Encouraging Creativity</div>
                            <div style="font-size:0.95rem;margin-top:0.25rem;line-height:1.5;">
                                Fostering practicality in designing modular solutions that solve real-world challenges.
                            </div>
                        </li>
                        <li>
                            <div style="font-weight:500;">Testing Hands-on Skills</div>
                            <div style="font-size:0.95rem;margin-top:0.25rem;line-height:1.5;">
                                Mirroring industry expectations for speed and precision in modular assembly.
                            </div>
                        </li>
                        <li>
                            <div style="font-weight:500;">Promoting Sustainability</div>
                            <div style="font-size:0.95rem;margin-top:0.25rem;line-height:1.5;">
                                Inspiring students to build modular structures that prioritize environmental responsibility.
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Competition Modules Section - Third on Mobile -->
            <div class="order-3">
                <h2 class="mb-4" style="font-size: 1.8rem; font-weight: 700; color: #22223b;">Competition Modules</h2>
                <div class="ma-video-preview position-relative" style="width:100%; max-width:100%; max-height: 800px; overflow: hidden; border-radius: 2.5rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
                    <img src="{{ $poster_image }}" alt="TVET Competition Modules" 
                         style="width:100%; height: auto; display:block; object-fit: contain; transition: transform 0.3s ease, box-shadow 0.3s ease;"
                         onmouseover="this.style.transform='scale(1.02)'; this.parentElement.style.boxShadow='0 15px 40px rgba(0, 0, 0, 0.15)';"
                         onmouseout="this.style.transform='scale(1)'; this.parentElement.style.boxShadow='0 10px 30px rgba(0, 0, 0, 0.1)';">
                </div>
            </div>

            <!-- Registration Form Download Section - Always Last -->
            <div class="text-center mt-5 order-4">
                <h3 class="mb-3" style="font-size: 1.5rem; font-weight: 600; color: #22223b;">Ready to Participate? / Sedia untuk Menyertai?</h3>
                <p class="mb-4" style="color: #4b5563; font-size: 1.1rem;">Download the registration form below to join the NextGen TVET: Modular Thinkers Competition</p>
                <div class="d-flex justify-content-center gap-5 flex-wrap">
                    <div class="text-center">
                        <a href="{{ $pdf_file }}" download="NextGen_TVET_Registration_Form.pdf" class="btn btn-primary btn-lg" style="background-color: #ff9800; border: none; padding: 1rem 2rem; border-radius: 1rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s ease;">
                            <i class="fas fa-file-download me-2"></i> Download Form (English)
                        </a>
                        <p class="mt-2" style="color: #6b7280; font-size: 0.9rem;">PDF format • Fill out and submit to participate</p>
                    </div>
                    <div class="text-center">
                        <a href="{{ $pdf_file_bm }}" download="Borang_Pendaftaran_NextGen_TVET.pdf" class="btn btn-primary btn-lg" style="background-color: #ff9800; border: none; padding: 1rem 2rem; border-radius: 1rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s ease;">
                            <i class="fas fa-file-download me-2"></i> Muat Turun Borang (BM)
                        </a>
                        <p class="mt-2" style="color: #6b7280; font-size: 0.9rem;">Format PDF • Isi dan hantar untuk menyertai</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Details Card - Desktop Only (Right Column) -->
        <div class="d-none d-lg-block sticky-sidebar">
            <div class="ma-card animate-on-scroll" style="min-width:270px;max-width:340px;">
                <div style="font-size:1.25rem;font-weight:600;color:#22223b;margin-bottom:1.5rem;border-bottom:2px solid #ff9800;padding-bottom:0.75rem;">
                    Key objectives of the competition:
                </div>
                <ul class="objectives-list">
                    <li>
                        <div style="font-weight:500;">Encouraging Creativity</div>
                        <div style="font-size:0.95rem;margin-top:0.25rem;line-height:1.5;">
                            Fostering practicality in designing modular solutions that solve real-world challenges.
                        </div>
                    </li>
                    <li>
                        <div style="font-weight:500;">Testing Hands-on Skills</div>
                        <div style="font-size:0.95rem;margin-top:0.25rem;line-height:1.5;">
                            Mirroring industry expectations for speed and precision in modular assembly.
                        </div>
                    </li>
                    <li>
                        <div style="font-weight:500;">Promoting Sustainability</div>
                        <div style="font-size:0.95rem;margin-top:0.25rem;line-height:1.5;">
                            Inspiring students to build modular structures that prioritize environmental responsibility.
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on scroll
    const animateElements = document.querySelectorAll('.animate-on-scroll');
    
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
        observer.observe(element);
    });

    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const heroSection = document.querySelector('.hero-section-store');
        const scrolled = window.pageYOffset;
        heroSection.style.backgroundPositionY = -(scrolled * 0.5) + 'px';
    });
});
</script>
@endpush

@endsection 