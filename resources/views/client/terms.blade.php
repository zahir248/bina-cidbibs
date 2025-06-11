@extends('client.layouts.app')

@section('title', 'BINA | Terms of Service')

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

    .terms-section {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2.5rem 2rem;
        margin: 3rem auto 2rem auto;
        max-width: 900px;
        position: relative;
        z-index: 2;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease 0.6s forwards;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .terms-section:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .terms-section h2 {
        font-size: 1.4rem;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        color: #2563eb;
        opacity: 0;
        animation: fadeIn 0.8s ease forwards;
    }

    .terms-section p {
        font-size: 1.05rem;
        color: #333;
        margin-bottom: 1.2rem;
        line-height: 1.7;
        opacity: 0;
        animation: fadeIn 0.8s ease forwards;
    }

    .terms-bg {
        background: #f8fafc;
        width: 100%;
        min-height: 100px;
        position: relative;
    }

    .terms-list {
        padding-left: 1.2em;
        font-size: 1.08rem;
        color: #333;
        line-height: 1.7;
        list-style-type: none;
    }

    .terms-list li {
        position: relative;
        padding-left: 1.5em;
        margin-bottom: 1rem;
        opacity: 0;
        transform: translateY(20px);
    }

    .terms-list li::before {
        content: '•';
        color: #ff9800;
        font-weight: bold;
        position: absolute;
        left: 0;
        top: 0;
    }

    .terms-list li:nth-child(1) { animation: fadeInUp 0.5s ease 0.2s forwards; }
    .terms-list li:nth-child(2) { animation: fadeInUp 0.5s ease 0.3s forwards; }
    .terms-list li:nth-child(3) { animation: fadeInUp 0.5s ease 0.4s forwards; }
    .terms-list li:nth-child(4) { animation: fadeInUp 0.5s ease 0.5s forwards; }
    .terms-list li:nth-child(5) { animation: fadeInUp 0.5s ease 0.6s forwards; }
    .terms-list li:nth-child(6) { animation: fadeInUp 0.5s ease 0.7s forwards; }
    .terms-list li:nth-child(7) { animation: fadeInUp 0.5s ease 0.8s forwards; }
    .terms-list li:nth-child(8) { animation: fadeInUp 0.5s ease 0.9s forwards; }
    .terms-list li:nth-child(9) { animation: fadeInUp 0.5s ease 1.0s forwards; }
    .terms-list li:nth-child(10) { animation: fadeInUp 0.5s ease 1.1s forwards; }
    .terms-list li:nth-child(11) { animation: fadeInUp 0.5s ease 1.2s forwards; }

    .sub-list {
        list-style-type: circle;
        margin-top: 0.7em;
        margin-left: 1em;
    }

    .sub-list li {
        padding-left: 0.5em;
        margin-bottom: 0.5rem;
    }

    .sub-list li::before {
        content: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .terms-section {
            padding: 2rem 1.5rem;
            margin: 2rem auto;
        }

        .terms-list {
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .terms-section {
            padding: 1.5rem 1rem;
            margin: 1.5rem auto;
        }

        .terms-list {
            font-size: 0.95rem;
            padding-left: 0.8em;
        }

        .terms-list li {
            padding-left: 1.2em;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">TERMS OF SERVICE</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Terms of Service</span>
    </div>
</div>

<!-- Main Content Section -->
<div class="terms-bg">
    <div class="container py-5">
        <div class="terms-section">
            <ul class="terms-list">
                <li>Ticket is not-refundable and non-exchangeable for cash or other products and services.</li>
                <li>Your personal information will be collected or used by an organizer on an event page for our own purposes.</li>
                <li>You give your express consent to the use of your actual or simulated likeness in connection with the production, exhibition, advertising or exploitation of any photograph, film, video and/or audio recording of the conference and/or any element thereof in any/all media throughout the world.</li>
                <li>Admission to the venue and the conference is at your own risk. Neither the venue nor organizer will be held liable for any loss, cost, expense, injury or damage sustained at the venue and/or the conference.</li>
                <li>BINA: Conference check-in counters open at 8:00 am. The conference starts at 9:00 am sharp.</li>
                <li>Kindly present the online e-ticket QR code for verification purpose upon registration on the event day.</li>
                <li>No refund on tickets will be made under any circumstances except pursuant to conditions under "Event Cancellation" or "Postponement".</li>
                <li>The event organizer may add, withdraw or substitute the speakers and/or vary advertised programs, and event times without prior notice.</li>
                <li>We bear no responsibility or liability for any loss or damage to your personal property during the event.</li>
                <li>By submitting this form, I/We hereby agree and consent that the organizer may collect, use, disclose and process my/our personal information set out in this form and/or otherwise provided by me/us for one or more of the purposes as stated which in summary includes but is not limited to the following:
                    <ul class="sub-list">
                        <li>processing my/our application for and providing me/us with the services and products of the organizer and related companies</li>
                        <li>sending me/us marketing, advertising and promotional information about other products/services that the organizer, related companies, business partners and sponsors may be offering, and which organizer believes may be of interest or benefit to me/us.</li>
                    </ul>
                </li>
                <li>By purchasing from us, you are agreeing to our terms and conditions.</li>
            </ul>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const heroSection = document.querySelector('.hero-section-store');
        const scrolled = window.pageYOffset;
        heroSection.style.backgroundPositionY = -(scrolled * 0.5) + 'px';
    });
});
</script>
@endpush 