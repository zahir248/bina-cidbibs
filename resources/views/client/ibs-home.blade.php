@extends('client.layouts.app')

@section('title', 'BINA | IBS Home')

@push('styles')
<style>
    :root {
        --primary-blue: #2563eb;
        --primary-dark: #1e40af;
        --bg-light-gray: #f8fafc;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --mobile-vh: 100vh;
        --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
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

    .ibs-intro-section {
        padding: 5rem 1.5rem;
        background-color: var(--bg-light-gray);
        position: relative;
        overflow: hidden;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .intro-content {
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
    }

    .intro-text {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease;
        text-align: justify;
        text-justify: inter-word;
    }

    .intro-text.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Features Section */
    .features-section {
        padding: 5rem 1.5rem;
        background: white;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .feature-card {
        background: white;
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        cursor: pointer;
        opacity: 0;
        transform: translateY(20px);
    }

    .feature-card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

    .feature-icon {
        font-size: 2rem;
        color: var(--primary-blue);
        margin-bottom: 1rem;
    }

    .feature-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
    }

    .feature-description {
        color: var(--text-light);
        line-height: 1.6;
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
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">IBS HOME</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>IBS Home</span>
    </div>
</div>

<!-- IBS Homes Introduction Section -->
<div class="ibs-intro-section scroll-reveal">
    <div class="container">
        <div class="intro-content">
            <p class="intro-text">
                CIDB IBS is thrilled to present our <b>innovative IBS Homes, powered by modular technology</b>. This
                exclusive showcase offers a unique opportunity for the public to <b>explore and experience the next
                generation of housing solutions</b>, designed for speed, efficiency, and sustainability.
            </p>
            <p class="intro-text">
                First unveiled at <b>Kompleks CIDB Malaysia, Chan Sow Lin</b>, IBS Homes now take a bold step forward with
                <b>modular construction</b> — a game-changer in the built environment. Through our <b>collaboration with
                leading modular technology providers</b>, we bring to life a smarter, faster, and more sustainable way to build.
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        document.querySelectorAll('.scroll-reveal, .feature-card, .intro-text').forEach((el) => {
            observer.observe(el);
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