@extends('client.layouts.app')

@section('title', 'Home - My Professional Site')

@push('styles')
<style>
    :root {
        --primary-blue: #2563eb;
        --primary-dark: #1e40af;
        --bg-light-gray: #f8fafc;
        --text-dark: #1e293b;
        --text-light: #64748b;
    }

    /* Hero Section */
    .hero-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        text-align: center;
        padding: 0 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyMDQsIDIxOCwgMjQxLCAwLjEpIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+') repeat;
        opacity: 0.6;
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.2;
        margin-bottom: 1.5rem;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--text-light);
        max-width: 600px;
        margin: 0 auto 2rem;
        line-height: 1.6;
    }

    .hero-btn .btn {
        padding: 0.75rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .hero-btn .btn-primary {
        background-color: var(--primary-blue);
        border-color: var(--primary-blue);
    }

    .hero-btn .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* Features Section */
    .features-section {
        padding: 5rem 1.5rem;
        background-color: #fff;
    }

    .section-title {
        text-align: center;
        margin-bottom: 3rem;
        color: var(--text-dark);
        font-weight: 700;
        font-size: 2.25rem;
    }

    .section-title span {
        color: var(--primary-blue);
    }

    .feature-card {
        padding: 2rem;
        border-radius: 0.75rem;
        background-color: white;
        height: 100%;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: var(--primary-blue);
    }

    .feature-icon {
        width: 3.5rem;
        height: 3.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #dbeafe;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        color: var(--primary-blue);
        font-size: 1.5rem;
    }

    .feature-card h5 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-dark);
    }

    .feature-card p {
        color: var(--text-light);
        line-height: 1.6;
    }

    /* About Section */
    .about-section {
        padding: 5rem 1.5rem;
        background-color: var(--bg-light-gray);
        text-align: center;
    }

    .about-section p {
        max-width: 800px;
        margin: 0 auto;
        color: var(--text-light);
        line-height: 1.8;
        font-size: 1.125rem;
    }

    /* Testimonials Section */
    .testimonials-section {
        padding: 5rem 1.5rem;
        background-color: white;
    }

    .testimonial {
        padding: 2rem;
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        position: relative;
        border: 1px solid #e2e8f0;
    }

    .testimonial::before {
        content: '"';
        position: absolute;
        top: 0;
        left: 1.5rem;
        font-size: 5rem;
        color: var(--primary-blue);
        opacity: 0.1;
        font-family: serif;
        line-height: 1;
    }

    .testimonial p {
        font-style: italic;
        color: var(--text-light);
        line-height: 1.8;
        position: relative;
        z-index: 1;
    }

    .testimonial strong {
        display: block;
        margin-top: 1.5rem;
        color: var(--text-dark);
        font-style: normal;
    }

    /* CTA Section */
    .cta-section {
        padding: 5rem 1.5rem;
        color: black;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjEpIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+') repeat;
    }

    .cta-section h2 {
        font-size: 2.25rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .cta-section .btn {
        padding: 0.75rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 0.5rem;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }

    .cta-section .btn-light {
        background-color: white;
        color: var(--primary-blue);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .cta-section .btn-light:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
        }
        
        .section-title {
            font-size: 1.75rem;
        }
        
        .cta-section h2 {
            font-size: 1.75rem;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .feature-card {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Transform Your Digital Presence</h1>
        <p class="hero-subtitle">We craft modern, responsive web solutions that drive results and elevate your brand in the digital landscape.</p>
        <div class="hero-btn">
            <a href="#" class="btn btn-outline-primary ms-3">Learn More</a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="features-section container">
    <h2 class="section-title">Our <span>Features</span></h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h5>Responsive Design</h5>
                <p>Your site will look perfect on any device, from desktop to mobile, ensuring seamless user experience across all platforms.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h5>Fast Performance</h5>
                <p>Optimized for speed with modern techniques to enhance user experience and improve your search engine rankings.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-server"></i>
                </div>
                <h5>Scalable Backend</h5>
                <p>Built with robust Laravel architecture for easy maintenance, future growth, and handling increased traffic.</p>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<div class="about-section">
    <div class="container">
        <h2 class="section-title">About <span>Our Company</span></h2>
        <p>
            We are a team of passionate developers and designers dedicated to creating innovative digital solutions. 
            With years of experience in web development, we combine technical expertise with creative vision to deliver 
            platforms that not only look stunning but also perform exceptionally. Our approach focuses on understanding 
            your unique needs and translating them into effective digital experiences.
        </p>
    </div>
</div>

<!-- Testimonials Section -->
<div class="testimonials-section container">
    <h2 class="section-title">Client <span>Testimonials</span></h2>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="testimonial">
                <p>The team delivered our e-commerce platform ahead of schedule with exceptional attention to detail. The site has helped increase our online sales by 40% in the first quarter.</p>
                <strong>- Sarah M., CEO of RetailPlus</strong>
            </div>
        </div>
        <div class="col-md-6">
            <div class="testimonial">
                <p>From initial concept to final delivery, the communication was excellent. They transformed our outdated website into a modern, functional platform that truly represents our brand.</p>
                <strong>- James K., Marketing Director at TechSolutions</strong>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action Section -->
<div class="cta-section">
    <div class="container">
        <h2>Ready to elevate your digital presence?</h2>
        <p class="mb-4">Let's discuss how we can help grow your business with a custom web solution.</p>
        <a href="#" class="btn btn-light">Contact Us Today</a>
    </div>
</div>
@endsection