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
    .terms-section {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 2.5rem 2rem;
        margin: 3rem auto 2rem auto;
        max-width: 900px;
        position: relative;
        z-index: 2;
    }
    .terms-section h2 {
        font-size: 1.4rem;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        color: #2563eb;
    }
    .terms-section p {
        font-size: 1.05rem;
        color: #333;
        margin-bottom: 1.2rem;
        line-height: 1.7;
    }
    .terms-bg {
        background: #f8fafc;
        width: 100%;
        min-height: 100px;
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
            <ul style="padding-left: 1.2em; font-size: 1.08rem; color: #333; line-height: 1.7;">
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
                    <ul style="list-style-type: circle; margin-top: 0.7em;">
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