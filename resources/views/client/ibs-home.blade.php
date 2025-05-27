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
    .coming-soon-icon {
        margin-bottom: 2rem;
    }
    .coming-soon-title {
        font-size: clamp(2.5rem, 7vw, 4rem);
        font-weight: 900;
        color: #fff;
        letter-spacing: 2px;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.25);
    }
    .coming-soon-subtext {
        color: #fff;
        font-size: 1.25rem;
        font-weight: 400;
        margin-top: 0.5rem;
        text-shadow: 1px 1px 6px rgba(0,0,0,0.18);
    }
</style>
@endpush

@section('content')
<!-- Hero Section: Coming Soon -->
<div class="hero-section-store" id="heroSection">
    <div class="coming-soon-title">COMING SOON!</div>
    <div class="coming-soon-subtext">Look forward to our new feature !!</div>
</div>
@endsection