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

    /* Tech cards hover effects and animation */
    .tech-card {
        transition: all 0.3s ease;
        animation: fadeInUp 0.8s ease-out;
        cursor: pointer;
    }

    .tech-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .tech-icon {
        transition: all 0.3s ease;
    }

    .tech-card:hover .tech-icon {
        animation: pulse 1s infinite;
        background: var(--primary-dark);
    }

    /* Video preview interactions */
    .ma-play-btn {
        transition: all 0.3s ease;
    }

    .ma-play-btn:hover {
        transform: translate(-50%, -50%) scale(1.1);
        background: var(--primary-dark);
    }

    /* Social media hover effects */
    .social-icon {
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 152, 0, 0.3);
    }

    /* Event card hover effect */
    .ma-card {
        transition: all 0.3s ease;
    }

    .ma-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
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

    /* Speaker card animation */
    .speaker-card {
        animation: float 3s ease-in-out infinite;
    }

    /* Get ticket button effect */
    .ticket-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
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
        text-align: justify;
        text-justify: inter-word;
    }

    @media (max-width: 991px) {
        .ma-flex-row {
            flex-direction: column;
        }

        .ma-card {
            margin-top: 2rem;
        }
    }

    .ma-tech-categories {
        padding: 2rem 0;
    }

    .tech-section-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #22223b;
        text-align: center;
        margin-bottom: 1rem;
    }

    .tech-section-subtitle {
        text-align: center;
        color: #4b5563;
        font-size: 1.2rem;
        margin-bottom: 3rem;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .tech-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        padding: 1rem;
    }

    .tech-card {
        background: white;
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .tech-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .tech-icon {
        width: 60px;
        height: 60px;
        background: #ff9800;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .tech-icon i {
        font-size: 1.75rem;
        color: white;
    }

    .tech-card h3 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #22223b;
        margin-bottom: 1rem;
    }

    .tech-card p {
        color: #4b5563;
        line-height: 1.6;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .tech-section-title {
            font-size: 2rem;
        }

        .tech-grid {
            grid-template-columns: 1fr;
            padding: 0.5rem;
        }

        .tech-card {
            padding: 1.5rem;
        }
    }

    .sticky-sidebar {
        position: sticky;
        top: 2rem;
        height: fit-content;
    }

    @media (max-width: 991px) {
        .sticky-sidebar {
            position: static;
        }
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

    @media (max-width: 991px) {
        .ma-flex-row {
            flex-direction: column;
        }

        .ma-card {
            margin-top: 2rem;
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

        .speaker-card {
            width: 100%;
            max-width: 340px;
            margin: 2rem auto 0;
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

        .ticket-btn-wrapper {
            text-align: center;
            width: 100%;
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

        .tech-section-title {
            font-size: 1.5rem;
            text-align: center;
        }

        .tech-section-subtitle {
            font-size: 1.1rem;
            text-align: center;
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
            <div class="ma-desc" style="max-width: 100%;">
                Modular Asia leads the charge in transforming the construction and design industry through modular technology. By emphasizing flexibility, efficiency, and sustainability, Modular Asia offers cutting-edge solutions for creating adaptable spaces that cater to diverse needs. Discover how modular designs are reshaping industries, reducing waste, and enhancing operational efficiency, one innovative project at a time.
            </div>
            <!-- Video Preview Section -->
            <div class="ma-video-preview position-relative mt-4" style="width:100%; max-width:100%; max-height: 500px; overflow: hidden;">
                <img src="{{ asset('images/modular.jpg') }}" alt="Video Preview" style="width:100%; border-radius: 2rem; display:block; object-fit: cover; height: 500px;">
                <a href="#" id="maPlayBtn" class="ma-play-btn d-flex align-items-center justify-content-center" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:80px;height:80px;background:#ff9800;border-radius:50%;box-shadow:0 4px 24px rgba(0,0,0,0.12);z-index:2;text-decoration:none;">
                    <svg width="32" height="32" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="24" fill="none"/>
                        <polygon points="20,16 36,24 20,32" fill="#fff"/>
                    </svg>
                </a>
            </div>

            <!-- Video Modal -->
            <div id="maVideoModal" class="ma-modal" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.75);align-items:center;justify-content:center;">
                <div class="ma-modal-content" style="position:relative;width:95%;max-width:1200px;background:none;">
                    <button id="maModalClose" style="position:absolute;top:-40px;right:0;background:none;border:none;font-size:2.5rem;color:#fff;z-index:2;cursor:pointer;">&times;</button>
                    <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:1.5rem;">
                        <iframe id="maVideoIframe" src="" allow="autoplay; encrypted-media" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;border-radius:1.5rem;"></iframe>
                    </div>
                </div>
            </div>

            <!-- Technology Categories Section -->
            <div class="ma-tech-categories mt-5 mb-5">
                <h2 class="tech-section-title">Explore Our Technology Categories</h2>
                <p class="tech-section-subtitle">Discover the future of construction and design through our innovative solutions</p>
                
                <div class="tech-grid">
                    <!-- Digitalisation Technology -->
                    <div class="tech-card">
                        <div class="tech-icon">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <h3>Digitalisation Technology</h3>
                        <p>Embracing digital transformation through BIM, IoT, and smart construction management systems for enhanced efficiency and precision.</p>
                    </div>

                    <!-- Advance Building Materials -->
                    <div class="tech-card">
                        <div class="tech-icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <h3>Advance Building Materials</h3>
                        <p>Innovative materials engineered for durability, sustainability, and superior performance in modular construction.</p>
                    </div>

                    <!-- Pre-fabricated Volumetric Modular -->
                    <div class="tech-card">
                        <div class="tech-icon">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <h3>Pre-fabricated Volumetric Modular</h3>
                        <p>Complete room modules manufactured off-site for rapid assembly and superior quality control.</p>
                    </div>

                    <!-- Autonomous Construction -->
                    <div class="tech-card">
                        <div class="tech-icon">
                            <i class="fas fa-robot"></i>
                        </div>
                        <h3>Autonomous Construction</h3>
                        <p>Robotics and automation technologies revolutionizing construction processes for increased safety and efficiency.</p>
                    </div>

                    <!-- Innovative Supply Chain -->
                    <div class="tech-card">
                        <div class="tech-icon">
                            <i class="fas fa-link"></i>
                        </div>
                        <h3>Innovative Supply Chain</h3>
                        <p>Advanced logistics and supply chain solutions optimized for modular construction projects.</p>
                    </div>

                    <!-- Facility Management -->
                    <div class="tech-card">
                        <div class="tech-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3>Facility Management</h3>
                        <p>Smart building management systems for efficient operation and maintenance of modular structures.</p>
                    </div>
                </div>
            </div>

            <!-- Important Points and Schedule Section -->
            <div class="ma-session-points mt-5">
                <div style="font-size:1.1rem;font-weight:600;letter-spacing:0.5px;color:#22223b;margin-bottom:1rem;">IMPORTANT POINTS IN THIS SESSION :</div>
                <ul style="color:#4b5563;font-size:1rem;margin-bottom:2rem;">
                    <li style="margin-bottom:0.5rem;">Applications in healthcare, education, and commercial sectors.</li>
                    <li style="margin-bottom:0.5rem;">Trends and opportunities in modular innovation.</li>
                    <li>Interactive discussions with industry experts.</li>
                </ul>

                <!-- Schedule Section -->
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
        <!-- Right: Event Details Card -->
        <div class="sticky-sidebar">
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
            <div class="speaker-card" style="background:#ffefdf;border-radius:1.5rem;padding:2rem 1.5rem 1.5rem 1.5rem;margin-top:2rem;max-width:340px;">
                <div style="font-size:1.35rem;font-weight:500;color:#181b2c;margin-bottom:1.2rem;">SPEAKER :</div>
                <div style="display:flex;align-items:center;margin-bottom:1.2rem;">
                    <div style="width:60px;height:60px;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;overflow:hidden;margin-right:1.2rem;">
                        <img src='https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg' alt='Speaker Avatar' style='width:60px;height:60px;object-fit:cover;border-radius:50%;'>
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:1.15rem;color:#181b2c;">SPEAKER NAME</div>
                        <div style="color:#6b7280;font-size:1rem;">Event Conference</div>
                    </div>
                </div>
                <div style="font-size:1.08rem;color:#181b2c;margin-bottom:0.7rem;">Share This :</div>
                <div style="display:flex;gap:0.7rem;">
                    <a href="#" class="social-icon" style="display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;background:#ff9800;border-radius:50%;color:#fff;font-size:1.3rem;text-decoration:none;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon" style="display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;background:#ff9800;border-radius:50%;color:#fff;font-size:1.3rem;text-decoration:none;"><i class="fab fa-linkedin-in"></i></a>
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

    // Animate elements on scroll
    const animateElements = document.querySelectorAll('.tech-card, .ma-desc, .ma-video-preview, .ma-card');
    
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

    // Add hover effect to tech cards
    const techCards = document.querySelectorAll('.tech-card');
    techCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
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