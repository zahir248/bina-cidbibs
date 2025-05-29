@extends('client.layouts.app')

@section('title', 'BINA | Gallery')

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
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }
    .gallery-item img {
        width: 100%;
        border-radius: 1.2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        object-fit: cover;
        aspect-ratio: 4/3;
        display: block;
    }
    @media (max-width: 991px) {
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 600px) {
        .gallery-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (min-width: 992px) {
        .hero-section-store {
            padding-top: 6rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">GALLERY</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Gallery</span>
    </div>
</div>

<!-- Main Content Section -->
<div class="container py-5">
    <div class="gallery-grid">
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-1.jpg') }}" alt="Gallery Image 1">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-2.jpg') }}" alt="Gallery Image 2">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-3.jpg') }}" alt="Gallery Image 3">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-4.jpg') }}" alt="Gallery Image 4">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-5.jpg') }}" alt="Gallery Image 5">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-6.jpg') }}" alt="Gallery Image 6">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-7.jpg') }}" alt="Gallery Image 7">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-8.jpg') }}" alt="Gallery Image 8">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-9.jpg') }}" alt="Gallery Image 9">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-10.jpg') }}" alt="Gallery Image 10">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-11.jpg') }}" alt="Gallery Image 11">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-12.jpg') }}" alt="Gallery Image 12">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-13.jpg') }}" alt="Gallery Image 13">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-14.jpg') }}" alt="Gallery Image 14">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-15.jpg') }}" alt="Gallery Image 15">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-16.jpg') }}" alt="Gallery Image 16">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-17.jpg') }}" alt="Gallery Image 17">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery-18.jpg') }}" alt="Gallery Image 18">
        </div>
    </div>
</div>
@endsection 