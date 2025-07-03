@extends('client.layouts.app')

@section('title', 'BINA | Podcast')

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
    
    /* Audio Player Styles */
    .audio-player-container {
        position: relative;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .play-button {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(90deg,#ff9800 0%,#ffb347 100%);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .play-button:hover {
        transform: scale(1.05);
    }
    
    .play-button i {
        color: white;
        font-size: 1.2rem;
    }
    
    .audio-player {
        display: none;
    }
    
    .audio-progress {
        flex-grow: 1;
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        position: relative;
        cursor: pointer;
    }
    
    .audio-progress-bar {
        position: absolute;
        height: 100%;
        background: #ff9800;
        border-radius: 2px;
        width: 0%;
    }
    
    .audio-time {
        font-size: 0.9rem;
        color: #64748b;
        min-width: 100px;
        text-align: right;
    }
    
    /* YouTube Player Container */
    .youtube-player-container {
        display: none;
        position: fixed;
        bottom: 0;
        right: 0;
        width: 1px;
        height: 1px;
        z-index: -1;
    }
    
    /* Loading State */
    .play-button.loading i {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .podcast-info-card {
            margin: 0 0.5rem;
        }
        
        .podcast-episode-card {
            margin: 0 0.5rem;
        }
        
        .table-responsive {
            margin: 0 -0.5rem;
        }
        
        .audio-player-container {
            width: 100%;
            padding-left: 0;
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
        
        .event-highlight-card img {
            height: 200px;
        }
    }

    /* Fix table responsiveness */
    .table {
        width: 100%;
        min-width: 100%;
    }

    @media (max-width: 576px) {
        td {
            min-width: 120px;
            font-size: 0.9rem;
        }
        
        .table > :not(caption) > * > * {
            padding: 0.75rem;
        }
    }

    /* General responsive container fixes */
    .container {
        width: 100%;
        padding-right: var(--bs-gutter-x, 0.75rem);
        padding-left: var(--bs-gutter-x, 0.75rem);
        margin-right: auto;
        margin-left: auto;
    }

    /* Coming Soon Styles */
    .coming-soon-container {
        /* background: linear-gradient(135deg, rgba(255,153,0,0.05) 0%, rgba(255,153,0,0.1) 100%);
        border: 1px dashed rgba(255,153,0,0.3); */
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        margin: 1rem 0;
    }

    .coming-soon-text {
        color: #FF9900;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .coming-soon-subtext {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        background-color: #FF9900;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 1.5s ease-in-out infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.5); opacity: 0.5; }
        100% { transform: scale(1); opacity: 1; }
    }

    /* Card Layout for Mobile */
    .podcast-cards-container {
        display: none;
    }

    .podcast-episode-card-mobile {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .podcast-card-header {
        background: #f8fafc;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .podcast-card-episode {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .podcast-card-description {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.4;
    }

    .podcast-card-body {
        padding: 1.5rem;
    }

    .podcast-card-section {
        margin-bottom: 1.5rem;
    }

    .podcast-card-section:last-child {
        margin-bottom: 0;
    }

    .podcast-card-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .podcast-card-content {
        color: #4b5563;
        line-height: 1.6;
    }

    .podcast-panelist-item {
        margin-bottom: 1rem;
    }

    .podcast-panelist-item:last-child {
        margin-bottom: 0;
    }

    .podcast-panelist-name {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .podcast-panelist-title {
        font-size: 0.9rem;
        color: #6b7280;
    }

    .podcast-card-media {
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        padding: 1.5rem;
    }

    .podcast-media-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .podcast-image-container {
        width: 100%;
        max-width: 300px;
        min-height: 200px;
        background: #f3f4f6;
        border-radius: 0.75rem;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        padding: 0.5rem;
    }

    .podcast-image-container img {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
        cursor: pointer;
        border-radius: 0.5rem;
    }

    .podcast-buttons-container {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }

    .podcast-action-button {
        flex: 1;
        max-width: 120px;
        padding: 0.75rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.9rem;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .podcast-view-more-btn {
        background: linear-gradient(90deg, #ff9800 0%, #ffb347 100%);
        color: #fff;
    }

    .podcast-watch-now-btn {
        background: #181b2c;
        color: #fff;
    }

    .podcast-action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        color: #fff;
    }

    .podcast-audio-player-mobile {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    /* Media Queries for Responsive Design */
    @media (max-width: 992px) {
        .table-responsive {
            display: none;
        }
        
        .podcast-cards-container {
            display: block;
        }
        
        .podcast-media-container {
            max-width: none;
            width: 100%;
        }
        
        .audio-player-container {
            width: 100% !important;
            padding-left: 0 !important;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">PODCAST</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Podcast</span>
    </div>
</div>
<!-- Main Content Section -->
<div class="container py-4 px-3 px-sm-4" style="max-width:1400px;">
    <div class="podcast-info-card d-flex flex-column p-3 p-sm-4" style="background:#fff;border-radius:1.25rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);margin:0 auto;border:2px solid #e5e7eb;">
        <!-- Content Section -->
        <div class="flex-grow-1 d-flex flex-column" style="min-width:0;">
            <div style="background:#f1f5f9;border-radius:0.75rem;padding:0.75rem 1.5rem;margin-bottom:1rem;text-align:center;">
                <h2 style="font-size:clamp(1.25rem, 4vw, 1.5rem);font-weight:800;color:#1e293b;margin:0;">ABOUT</h2>
            </div>
            <div style="font-size:0.95rem;color:#334155;line-height:1.5;text-align:justify;">
                The first-ever podcast series by CIDB IBS, launched under the <b>BINA 2025</b> initiative to amplify conversations that matter in Malaysia's construction and built environment sector. We offer two podcast segments: <b>BINA Podcast</b>, which features insightful conversations with construction industry leaders and innovators, and <b>FM Podcast</b>, which focuses on facility management, highlighting best practices, sustainability, and digitalisation in the built environment.<br><br>
                As the industry <b>embraces digitalisation and innovation</b>, this Podcast series provides a platform for insightful, video-based discussions. Each episode features relaxed yet thought-provoking conversations with industry leaders, policymakers, contractors, manufacturers, consultants, financial institutions, and innovators.<br><br>
                This podcast is more than a conversation—it's a strategic initiative by CIDB IBS to foster <b>knowledge-sharing platforms</b> that connect stakeholders and provide insights into <b>industry best practices</b>.
            </div>
        </div>
    </div>
</div>
<!-- FM Engagement Day Podcast Section -->
<div class="container py-4 px-3 px-sm-4" style="max-width:1400px;">
    <div class="row g-4">
        <!-- BINA Podcast Column -->
        <div class="col-lg-6">
            <div class="podcast-episode-card d-flex flex-column h-100" style="background:#fff;border:1.5px solid #d1d5db;border-radius:1.25rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);overflow:hidden;">
                <!-- Header -->
                <div style="background:#ff9900;color:#fff;padding:1rem 1.5rem;display:flex;align-items:center;justify-content:center;height:92px;">
                    <img src="{{ asset('images/bina-podcast-logo.png') }}" 
                         alt="BINA PODCAST" 
                         style="height:80px;width:auto;object-fit:contain;max-width:500px;">
                </div>
                <!-- Content -->
                <div class="p-3 p-md-4 d-flex flex-column flex-grow-1">
                    <!-- Episode Table -->
                    <div class="table-responsive">
                        <table class="table" style="border:1px solid #e5e7eb;border-radius:0.5rem;overflow:hidden;">
                            <thead style="background:#f8fafc;">
                                <tr>
                                    <th style="padding:1rem;font-weight:700;color:#181b2c;border-bottom:2px solid #e5e7eb;">Episode</th>
                                    <th style="padding:1rem;font-weight:700;color:#181b2c;border-bottom:2px solid #e5e7eb;">Panelist</th>
                                    <th style="padding:1rem;font-weight:700;color:#181b2c;border-bottom:2px solid #e5e7eb;">Topic</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($binaPodcasts as $podcast)
                                <!-- Episode Info Row -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;font-size:1.1rem;margin-bottom:0.5rem;">
                                            @if($podcast->is_special)
                                                Special Edition
                                            @else
                                                Ep. {{ $podcast->episode_number }}
                                            @endif
                                        </div>
                                        @if($podcast->is_live_streaming)
                                        <div style="font-size:0.9rem;color:#64748b;">(Live Streaming - {{ $podcast->live_streaming_event }})</div>
                                        @endif
                                        <div style="font-size:0.9rem;color:#64748b;margin-top:0.5rem;">
                                            {!! $podcast->description !!}
                                        </div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        @if($podcast->panelists)
                                            @foreach($podcast->panelists as $panelist)
                                        <div style="line-height:1.6;">
                                                @if($loop->first)
                                                <div style="font-weight:600;margin-bottom:0.5rem;">Panel{{ count($podcast->panelists) > 1 ? ' ' . $loop->iteration : '' }}:</div>
                                                @else
                                                <div style="font-weight:600;margin-top:0.5rem;">Panel {{ $loop->iteration }}:</div>
                                                @endif
                                                @php
                                                    $parts = explode(' - ', $panelist, 2);
                                                    $name = $parts[0];
                                                    $title = isset($parts[1]) ? $parts[1] : '';
                                                @endphp
                                                {{ $name }}
                                                @if($title)
                                                <div style="font-size:0.9rem;color:#64748b;margin-top:0.25rem;">{{ $title }}</div>
                                                @endif
                                        </div>
                                            @endforeach
                                        @else
                                            <div style="color:#64748b;">TBA</div>
                                        @endif
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="line-height:1.6;">
                                            {!! $podcast->formatted_title !!}
                                        </div>
                                    </td>
                                </tr>
                                <!-- Episode Media Row -->
                                <tr>
                                    <td colspan="3" style="padding:1.5rem;border-bottom:1px solid #e5e7eb;background:#f8fafc;">
                                        @if($podcast->is_coming_soon)
                                        <div class="coming-soon-container">
                                            <div class="coming-soon-text">
                                                Coming Soon <span class="pulse-dot"></span>
                                                </div>
                                            <div class="coming-soon-subtext">
                                                Stay tuned for exciting content from this episode!
                                                </div>
                                            </div>
                                        @else
                                        <div class="d-flex flex-column gap-4" style="max-width:800px;margin:0 auto;">
                                            <!-- Image and Buttons Section -->
                                            <div class="d-flex flex-column flex-md-row align-items-center gap-4" style="width:450px;">
                                                <!-- Speaker Image -->
                                                <div style="width:320px;height:240px;flex-shrink:0;background:#f8fafc;border-radius:1rem;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                                                    @if($podcast->image)
                                                    <img src="{{ $podcast->formatted_image_url }}" 
                                                         alt="@if($podcast->is_special)Special Edition @else Episode {{ $podcast->episode_number }} @endif" 
                                                         data-bs-toggle="modal"
                                                         data-bs-target="#imageModal"
                                                         onclick="showImage(this.src)"
                                                         style="max-width:100%;max-height:100%;object-fit:contain;border-radius:0.75rem;cursor:pointer;">
                                                    @else
                                                    <div style="color:#64748b;text-align:center;">
                                                        <i class="fas fa-image fa-3x mb-2"></i><br>
                                                        No image available
                                                </div>
                                                    @endif
                                                </div>
                                                <!-- Buttons Section -->
                                                <div class="flex-grow-1 d-flex flex-column gap-2" style="min-width:110px;">
                                                    <a href="{{ route('client.facility-management') }}" 
                                                       class="btn w-100" 
                                                       style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);color:#fff;font-weight:600;font-size:0.85rem;border-radius:1.5rem;padding:0.5rem 0;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                                                       VIEW<br>MORE
                                                    </a>
                                                    @if($podcast->youtube_url)
                                                    <a href="{{ $podcast->youtube_url }}" 
                                                       class="btn w-100" 
                                                       style="background:#181b2c;color:#fff;font-weight:600;font-size:0.85rem;border-radius:1.5rem;padding:0.5rem 0;box-shadow:0 2px 8px rgba(0,0,0,0.08);"
                                                       target="_blank" rel="noopener noreferrer">
                                                       WATCH<br>NOW
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Audio Player -->
                                            @if($podcast->youtube_url)
                                            <div class="audio-player-container" style="width:450px;padding-left:1.5rem;">
                                                <div class="d-flex align-items-center gap-1 mb-2">
                                                    @php
                                                        $audioId = $podcast->is_special ? "audioSpecial{$podcast->id}" : "audio{$podcast->id}";
                                                        $buttonId = $podcast->is_special ? "playButtonSpecial{$podcast->id}" : "playButton{$podcast->id}";
                                                        $timeId = $podcast->is_special ? "timeSpecial{$podcast->id}" : "time{$podcast->id}";
                                                        $progressId = $podcast->is_special ? "progressSpecial{$podcast->id}" : "progress{$podcast->id}";
                                                    @endphp
                                                    <button class="play-button" id="{{ $buttonId }}" onclick="toggleAudio('{{ $audioId }}')" 
                                                            style="width:44px;height:44px;flex-shrink:0;">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                    <div class="audio-time" id="{{ $timeId }}" style="font-size:0.9rem;color:#64748b;width:80px;">0:00 / 0:00</div>
                                                </div>
                                                <div class="audio-progress" onclick="seekAudio('{{ $audioId }}', event)" 
                                                     style="height:6px;background:#e2e8f0;border-radius:3px;">
                                                    <div class="audio-progress-bar" id="{{ $progressId }}" 
                                                         style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);height:100%;border-radius:3px;"></div>
                                                </div>
                                                <div id="{{ $audioId }}" class="audio-player"></div>
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <p class="text-muted">No BINA podcasts available yet.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Card Layout for Mobile -->
                    <div class="podcast-cards-container">
                        @forelse($binaPodcasts as $podcast)
                        <div class="podcast-episode-card-mobile">
                            <!-- Card Header -->
                            <div class="podcast-card-header">
                                <div class="podcast-card-episode">
                                    @if($podcast->is_special)
                                        Special Edition
                                    @else
                                        Episode {{ $podcast->episode_number }}
                                    @endif
                                </div>
                                @if($podcast->is_live_streaming)
                                <div class="podcast-card-description">
                                    Live Streaming - {{ $podcast->live_streaming_event }}
                                </div>
                                @endif
                                @if($podcast->description)
                                <div class="podcast-card-description">
                                    {!! $podcast->description !!}
                                </div>
                                @endif
                            </div>
                            
                            <!-- Card Body -->
                            <div class="podcast-card-body">
                                <!-- Topic Section -->
                                <div class="podcast-card-section">
                                    <div class="podcast-card-label">Topic</div>
                                    <div class="podcast-card-content">
                                        {!! $podcast->formatted_title !!}
                                    </div>
                                </div>
                                
                                <!-- Panelist Section -->
                                <div class="podcast-card-section">
                                    <div class="podcast-card-label">Panelist</div>
                                    <div class="podcast-card-content">
                                        @if($podcast->panelists)
                                            @foreach($podcast->panelists as $panelist)
                                            <div class="podcast-panelist-item">
                                                @php
                                                    $parts = explode(' - ', $panelist, 2);
                                                    $name = $parts[0];
                                                    $title = isset($parts[1]) ? $parts[1] : '';
                                                @endphp
                                                <div class="podcast-panelist-name">{{ $name }}</div>
                                                @if($title)
                                                <div class="podcast-panelist-title">{{ $title }}</div>
                                                @endif
                                            </div>
                                            @endforeach
                                        @else
                                            <div style="color:#64748b;">TBA</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Card Media -->
                            <div class="podcast-card-media">
                                @if($podcast->is_coming_soon)
                                <div class="coming-soon-container">
                                    <div class="coming-soon-text">
                                        Coming Soon <span class="pulse-dot"></span>
                                    </div>
                                    <div class="coming-soon-subtext">
                                        Stay tuned for exciting content from this episode!
                                    </div>
                                </div>
                                @else
                                <div class="podcast-media-container">
                                    <!-- Image -->
                                    <div class="podcast-image-container">
                                        @if($podcast->image)
                                        <img src="{{ $podcast->formatted_image_url }}" 
                                             alt="@if($podcast->is_special)Special Edition @else Episode {{ $podcast->episode_number }} @endif" 
                                             data-bs-toggle="modal"
                                             data-bs-target="#imageModal"
                                             onclick="showImage(this.src)">
                                        @else
                                        <div style="color:#64748b;text-align:center;">
                                            <i class="fas fa-image fa-2x mb-2"></i><br>
                                            No image available
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Buttons -->
                                    <div class="podcast-buttons-container">
                                        <a href="{{ route('client.facility-management') }}" 
                                           class="podcast-action-button podcast-view-more-btn">
                                           VIEW<br>MORE
                                        </a>
                                        @if($podcast->youtube_url)
                                        <a href="{{ $podcast->youtube_url }}" 
                                           class="podcast-action-button podcast-watch-now-btn"
                                           target="_blank" rel="noopener noreferrer">
                                           WATCH<br>NOW
                                        </a>
                                        @endif
                                    </div>
                                    
                                    <!-- Audio Player -->
                                    @if($podcast->youtube_url)
                                    <div class="podcast-audio-player-mobile">
                                        <div class="audio-player-container">
                                            <div class="d-flex align-items-center gap-1 mb-2">
                                                @php
                                                    $audioId = $podcast->is_special ? "audioSpecialMobile{$podcast->id}" : "audioMobile{$podcast->id}";
                                                    $buttonId = $podcast->is_special ? "playButtonSpecialMobile{$podcast->id}" : "playButtonMobile{$podcast->id}";
                                                    $timeId = $podcast->is_special ? "timeSpecialMobile{$podcast->id}" : "timeMobile{$podcast->id}";
                                                    $progressId = $podcast->is_special ? "progressSpecialMobile{$podcast->id}" : "progressMobile{$podcast->id}";
                                                @endphp
                                                <button class="play-button" id="{{ $buttonId }}" onclick="toggleAudio('{{ $audioId }}')" 
                                                        style="width:44px;height:44px;flex-shrink:0;">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                                <div class="audio-time" id="{{ $timeId }}" style="font-size:0.9rem;color:#64748b;width:80px;">0:00 / 0:00</div>
                                            </div>
                                            <div class="audio-progress" onclick="seekAudio('{{ $audioId }}', event)" 
                                                 style="height:6px;background:#e2e8f0;border-radius:3px;">
                                                <div class="audio-progress-bar" id="{{ $progressId }}" 
                                                     style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);height:100%;border-radius:3px;"></div>
                                            </div>
                                            <div id="{{ $audioId }}" class="audio-player"></div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <p class="text-muted">No BINA podcasts available yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <!-- FM Podcast Column -->
        <div class="col-lg-6">
            <div class="podcast-episode-card d-flex flex-column h-100" style="background:#fff;border:1.5px solid #d1d5db;border-radius:1.25rem;box-shadow:0 2px 12px rgba(80,80,120,0.04);overflow:hidden;">
                <!-- Header -->
                <div style="background:#ff9900;color:#fff;padding:1rem 1.5rem;display:flex;align-items:center;justify-content:center;height:92px;">
                    <img src="{{ asset('images/fm-podcast-logo.png') }}" 
                         alt="FM PODCAST" 
                         style="height:80px;width:auto;object-fit:contain;max-width:500px;">
                </div>
                <!-- Content -->
                <div class="p-3 p-md-4 d-flex flex-column flex-grow-1">
                    <!-- Episode Table -->
                    <div class="table-responsive">
                        <table class="table" style="border:1px solid #e5e7eb;border-radius:0.5rem;overflow:hidden;">
                            <thead style="background:#f8fafc;">
                                <tr>
                                    <th style="padding:1rem;font-weight:700;color:#181b2c;border-bottom:2px solid #e5e7eb;">Episode</th>
                                    <th style="padding:1rem;font-weight:700;color:#181b2c;border-bottom:2px solid #e5e7eb;">Panelist</th>
                                    <th style="padding:1rem;font-weight:700;color:#181b2c;border-bottom:2px solid #e5e7eb;">Topic</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fmPodcasts as $podcast)
                                <!-- Episode Info Row -->
                                <tr>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="font-weight:600;font-size:1.1rem;margin-bottom:0.5rem;">
                                            @if($podcast->is_special)
                                                Special Edition
                                            @else
                                                Ep. {{ $podcast->episode_number }}
                                            @endif
                                        </div>
                                        @if($podcast->is_live_streaming)
                                        <div style="font-size:0.9rem;color:#64748b;">(Live Streaming - {{ $podcast->live_streaming_event }})</div>
                                        @endif
                                        <div style="font-size:0.9rem;color:#64748b;margin-top:0.5rem;">
                                            {!! $podcast->description !!}
                                        </div>
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        @if($podcast->panelists)
                                            @foreach($podcast->panelists as $panelist)
                                            <div style="line-height:1.6;">
                                                @if($loop->first)
                                                <div style="font-weight:600;margin-bottom:0.5rem;">Panel{{ count($podcast->panelists) > 1 ? ' ' . $loop->iteration : '' }}:</div>
                                                @else
                                                <div style="font-weight:600;margin-top:0.5rem;">Panel {{ $loop->iteration }}:</div>
                                                @endif
                                                @php
                                                    $parts = explode(' - ', $panelist, 2);
                                                    $name = $parts[0];
                                                    $title = isset($parts[1]) ? $parts[1] : '';
                                                @endphp
                                                {{ $name }}
                                                @if($title)
                                                <div style="font-size:0.9rem;color:#64748b;margin-top:0.25rem;">{{ $title }}</div>
                                                @endif
                                            </div>
                                            @endforeach
                                        @else
                                            <div style="color:#64748b;">TBA</div>
                                        @endif
                                    </td>
                                    <td style="padding:1rem;vertical-align:top;border-bottom:1px solid #e5e7eb;">
                                        <div style="line-height:1.6;">
                                            {!! $podcast->formatted_title !!}
                                        </div>
                                    </td>
                                </tr>
                                <!-- Episode Media Row -->
                                <tr>
                                    <td colspan="3" style="padding:1.5rem;border-bottom:1px solid #e5e7eb;background:#f8fafc;">
                                        @if($podcast->is_coming_soon)
                                        <div class="coming-soon-container">
                                            <div class="coming-soon-text">
                                                Coming Soon <span class="pulse-dot"></span>
                                            </div>
                                            <div class="coming-soon-subtext">
                                                Stay tuned for exciting content from this episode!
                                            </div>
                                        </div>
                                        @else
                                        <div class="d-flex flex-column gap-4" style="max-width:800px;margin:0 auto;">
                                            <!-- Image and Buttons Section -->
                                            <div class="d-flex flex-column flex-md-row align-items-center gap-4" style="width:450px;">
                                                <!-- Speaker Image -->
                                                <div style="width:320px;height:240px;flex-shrink:0;background:#f8fafc;border-radius:1rem;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                                                    @if($podcast->image)
                                                    <img src="{{ $podcast->formatted_image_url }}" 
                                                         alt="@if($podcast->is_special)Special Edition @else Episode {{ $podcast->episode_number }} @endif" 
                                                         data-bs-toggle="modal"
                                                         data-bs-target="#imageModal"
                                                         onclick="showImage(this.src)"
                                                         style="max-width:100%;max-height:100%;object-fit:contain;border-radius:0.75rem;cursor:pointer;">
                                                    @else
                                                    <div style="color:#64748b;text-align:center;">
                                                        <i class="fas fa-image fa-3x mb-2"></i><br>
                                                        No image available
                                            </div>
                                                    @endif
                                            </div>
                                                <!-- Buttons Section -->
                                                <div class="flex-grow-1 d-flex flex-column gap-2" style="min-width:110px;">
                                                    <a href="{{ route('client.facility-management') }}" 
                                                       class="btn w-100" 
                                                       style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);color:#fff;font-weight:600;font-size:0.85rem;border-radius:1.5rem;padding:0.5rem 0;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                                                       VIEW<br>MORE
                                                    </a>
                                                    @if($podcast->youtube_url)
                                                    <a href="{{ $podcast->youtube_url }}" 
                                                       class="btn w-100" 
                                                       style="background:#181b2c;color:#fff;font-weight:600;font-size:0.85rem;border-radius:1.5rem;padding:0.5rem 0;box-shadow:0 2px 8px rgba(0,0,0,0.08);"
                                                       target="_blank" rel="noopener noreferrer">
                                                       WATCH<br>NOW
                                                    </a>
                                                    @endif
                                        </div>
                                            </div>
                                            <!-- Audio Player -->
                                            @if($podcast->youtube_url)
                                            <div class="audio-player-container" style="width:450px;padding-left:1.5rem;">
                                                <div class="d-flex align-items-center gap-1 mb-2">
                                                    @php
                                                        $audioId = $podcast->is_special ? "audioSpecial{$podcast->id}" : "audio{$podcast->id}";
                                                        $buttonId = $podcast->is_special ? "playButtonSpecial{$podcast->id}" : "playButton{$podcast->id}";
                                                        $timeId = $podcast->is_special ? "timeSpecial{$podcast->id}" : "time{$podcast->id}";
                                                        $progressId = $podcast->is_special ? "progressSpecial{$podcast->id}" : "progress{$podcast->id}";
                                                    @endphp
                                                    <button class="play-button" id="{{ $buttonId }}" onclick="toggleAudio('{{ $audioId }}')" 
                                                            style="width:44px;height:44px;flex-shrink:0;">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                    <div class="audio-time" id="{{ $timeId }}" style="font-size:0.9rem;color:#64748b;width:80px;">0:00 / 0:00</div>
                                                </div>
                                                <div class="audio-progress" onclick="seekAudio('{{ $audioId }}', event)" 
                                                     style="height:6px;background:#e2e8f0;border-radius:3px;">
                                                    <div class="audio-progress-bar" id="{{ $progressId }}" 
                                                         style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);height:100%;border-radius:3px;"></div>
                                        </div>
                                                <div id="{{ $audioId }}" class="audio-player"></div>
                                            </div>
                                            @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <p class="text-muted">No FM podcasts available yet.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Card Layout for Mobile -->
                    <div class="podcast-cards-container">
                        @forelse($fmPodcasts as $podcast)
                        <div class="podcast-episode-card-mobile">
                            <!-- Card Header -->
                            <div class="podcast-card-header">
                                <div class="podcast-card-episode">
                                    @if($podcast->is_special)
                                        Special Edition
                                    @else
                                        Episode {{ $podcast->episode_number }}
                                    @endif
                                </div>
                                @if($podcast->is_live_streaming)
                                <div class="podcast-card-description">
                                    Live Streaming - {{ $podcast->live_streaming_event }}
                                </div>
                                @endif
                                @if($podcast->description)
                                <div class="podcast-card-description">
                                    {!! $podcast->description !!}
                                </div>
                                @endif
                            </div>
                            
                            <!-- Card Body -->
                            <div class="podcast-card-body">
                                <!-- Topic Section -->
                                <div class="podcast-card-section">
                                    <div class="podcast-card-label">Topic</div>
                                    <div class="podcast-card-content">
                                        {!! $podcast->formatted_title !!}
                                    </div>
                                </div>
                                
                                <!-- Panelist Section -->
                                <div class="podcast-card-section">
                                    <div class="podcast-card-label">Panelist</div>
                                    <div class="podcast-card-content">
                                        @if($podcast->panelists)
                                            @foreach($podcast->panelists as $panelist)
                                            <div class="podcast-panelist-item">
                                                @php
                                                    $parts = explode(' - ', $panelist, 2);
                                                    $name = $parts[0];
                                                    $title = isset($parts[1]) ? $parts[1] : '';
                                                @endphp
                                                <div class="podcast-panelist-name">{{ $name }}</div>
                                                @if($title)
                                                <div class="podcast-panelist-title">{{ $title }}</div>
                                                @endif
                                            </div>
                                            @endforeach
                                        @else
                                            <div style="color:#64748b;">TBA</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Card Media -->
                            <div class="podcast-card-media">
                                @if($podcast->is_coming_soon)
                                <div class="coming-soon-container">
                                    <div class="coming-soon-text">
                                        Coming Soon <span class="pulse-dot"></span>
                                    </div>
                                    <div class="coming-soon-subtext">
                                        Stay tuned for exciting content from this episode!
                                    </div>
                                </div>
                                @else
                                <div class="podcast-media-container">
                                    <!-- Image -->
                                    <div class="podcast-image-container">
                                        @if($podcast->image)
                                        <img src="{{ $podcast->formatted_image_url }}" 
                                             alt="@if($podcast->is_special)Special Edition @else Episode {{ $podcast->episode_number }} @endif" 
                                             data-bs-toggle="modal"
                                             data-bs-target="#imageModal"
                                             onclick="showImage(this.src)">
                                        @else
                                        <div style="color:#64748b;text-align:center;">
                                            <i class="fas fa-image fa-2x mb-2"></i><br>
                                            No image available
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Buttons -->
                                    <div class="podcast-buttons-container">
                                        <a href="{{ route('client.facility-management') }}" 
                                           class="podcast-action-button podcast-view-more-btn">
                                           VIEW<br>MORE
                                        </a>
                                        @if($podcast->youtube_url)
                                        <a href="{{ $podcast->youtube_url }}" 
                                           class="podcast-action-button podcast-watch-now-btn"
                                           target="_blank" rel="noopener noreferrer">
                                           WATCH<br>NOW
                                        </a>
                                        @endif
                                    </div>
                                    
                                    <!-- Audio Player -->
                                    @if($podcast->youtube_url)
                                    <div class="podcast-audio-player-mobile">
                                        <div class="audio-player-container">
                                            <div class="d-flex align-items-center gap-1 mb-2">
                                                @php
                                                    $audioId = $podcast->is_special ? "audioSpecialMobileFM{$podcast->id}" : "audioMobileFM{$podcast->id}";
                                                    $buttonId = $podcast->is_special ? "playButtonSpecialMobileFM{$podcast->id}" : "playButtonMobileFM{$podcast->id}";
                                                    $timeId = $podcast->is_special ? "timeSpecialMobileFM{$podcast->id}" : "timeMobileFM{$podcast->id}";
                                                    $progressId = $podcast->is_special ? "progressSpecialMobileFM{$podcast->id}" : "progressMobileFM{$podcast->id}";
                                                @endphp
                                                <button class="play-button" id="{{ $buttonId }}" onclick="toggleAudio('{{ $audioId }}')" 
                                                        style="width:44px;height:44px;flex-shrink:0;">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                                <div class="audio-time" id="{{ $timeId }}" style="font-size:0.9rem;color:#64748b;width:80px;">0:00 / 0:00</div>
                                            </div>
                                            <div class="audio-progress" onclick="seekAudio('{{ $audioId }}', event)" 
                                                 style="height:6px;background:#e2e8f0;border-radius:3px;">
                                                <div class="audio-progress-bar" id="{{ $progressId }}" 
                                                     style="background:linear-gradient(90deg,#ff9800 0%,#ffb347 100%);height:100%;border-radius:3px;"></div>
                                            </div>
                                            <div id="{{ $audioId }}" class="audio-player"></div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <p class="text-muted">No FM podcasts available yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Engagement Content -->
<div class="container py-5">
    <div class="engagement-section" style="background:linear-gradient(135deg, #1B1F31  0%, #2C3149  100%);border-radius:1.5rem;padding:3rem 2rem;box-shadow:0 4px 20px rgba(255, 153, 0, 0.2);max-width:1000px;margin:0 auto;">
        <div class="text-center">
            <h2 style="font-size:2rem;color:#fff;font-weight:800;margin-bottom:1.5rem;text-shadow:2px 2px 4px rgba(0,0,0,0.1);">Join Our Podcast!</h2>
            <p style="font-size:1.25rem;color:#fff;font-weight:500;line-height:1.6;margin-bottom:2rem;">
                Got something to say about the future of construction? Join us as a panelist on BINA Podcast—<br>
                contact us today!<br>
            </p
        </div>
    </div>
</div>

<!-- Update YouTube Player Containers -->
<div class="youtube-player-container">
    @foreach($binaPodcasts->merge($fmPodcasts) as $podcast)
        @if($podcast->youtube_url)
            @php
                $videoId = last(explode('/', parse_url($podcast->youtube_url, PHP_URL_PATH)));
                if (str_contains($podcast->youtube_url, 'watch?v=')) {
                    parse_str(parse_url($podcast->youtube_url, PHP_URL_QUERY), $params);
                    $videoId = $params['v'] ?? '';
                }
                $playerId = $podcast->is_special ? "playerSpecial{$podcast->id}" : "player{$podcast->id}";
            @endphp
            <iframe id="{{ $playerId }}" 
                    width="1" 
                    height="1" 
                    src="https://www.youtube.com/embed/{{ $videoId }}?enablejsapi=1&controls=0&showinfo=0&rel=0&modestbranding=1" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
            </iframe>
        @endif
    @endforeach
    
    <!-- Mobile Players for BINA Podcasts -->
    @foreach($binaPodcasts as $podcast)
        @if($podcast->youtube_url)
            @php
                $videoId = last(explode('/', parse_url($podcast->youtube_url, PHP_URL_PATH)));
                if (str_contains($podcast->youtube_url, 'watch?v=')) {
                    parse_str(parse_url($podcast->youtube_url, PHP_URL_QUERY), $params);
                    $videoId = $params['v'] ?? '';
                }
                $playerId = $podcast->is_special ? "playerSpecialMobile{$podcast->id}" : "playerMobile{$podcast->id}";
            @endphp
            <iframe id="{{ $playerId }}" 
                    width="1" 
                    height="1" 
                    src="https://www.youtube.com/embed/{{ $videoId }}?enablejsapi=1&controls=0&showinfo=0&rel=0&modestbranding=1" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
            </iframe>
        @endif
    @endforeach
    
    <!-- Mobile Players for FM Podcasts -->
    @foreach($fmPodcasts as $podcast)
        @if($podcast->youtube_url)
            @php
                $videoId = last(explode('/', parse_url($podcast->youtube_url, PHP_URL_PATH)));
                if (str_contains($podcast->youtube_url, 'watch?v=')) {
                    parse_str(parse_url($podcast->youtube_url, PHP_URL_QUERY), $params);
                    $videoId = $params['v'] ?? '';
                }
                $playerId = $podcast->is_special ? "playerSpecialMobileFM{$podcast->id}" : "playerMobileFM{$podcast->id}";
            @endphp
            <iframe id="{{ $playerId }}" 
                    width="1" 
                    height="1" 
                    src="https://www.youtube.com/embed/{{ $videoId }}?enablejsapi=1&controls=0&showinfo=0&rel=0&modestbranding=1" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
            </iframe>
        @endif
    @endforeach
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="max-width:90vw;">
        <div class="modal-content border-0" style="background:transparent;">
            <div class="modal-header border-0 p-3">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center p-3" style="min-height:80vh;">
                <img id="modalImage" src="" alt="Modal Image" style="max-width:85%;max-height:80vh;object-fit:contain;border-radius:1.25rem;box-shadow:0 4px 24px rgba(0,0,0,0.1);">
            </div>
        </div>
    </div>
</div>
@endsection 

@push('scripts')
<script>
// Load YouTube API with timeout
let apiLoadTimeout;
let isAPIReady = false;
let players = {};
let currentPlayer = null;

function loadYouTubeAPI() {
    const tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    tag.async = true;
    
    apiLoadTimeout = setTimeout(() => {
        console.log('YouTube API load timeout - using fallback');
        initializeFallbackPlayers();
    }, 5000);
    
    const firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

function initializeFallbackPlayers() {
    console.log('Initializing fallback players');
    isAPIReady = true;
    document.querySelectorAll('.play-button').forEach(button => {
        updateButtonState(button.id, false, false);
    });
}

function onYouTubeIframeAPIReady() {
    console.log('YouTube API Ready');
    clearTimeout(apiLoadTimeout);
    isAPIReady = true;
    
    const playerInitTimeout = setTimeout(() => {
        console.log('Player initialization timeout - using fallback');
        initializeFallbackPlayers();
    }, 3000);
    
    try {
        document.querySelectorAll('iframe[id^="player"]').forEach(iframe => {
            const playerId = iframe.id;
            players[playerId] = new YT.Player(playerId, {
                events: {
                    'onReady': (event) => {
                        console.log(`${playerId} Ready`);
                        const buttonId = playerId.replace(/player/, 'playButton');
                        updateButtonState(buttonId, false, false);
                    },
                    'onStateChange': onPlayerStateChange,
                    'onError': onPlayerError
                }
            });
        });
        
        clearTimeout(playerInitTimeout);
    } catch (error) {
        console.error('Error initializing players:', error);
        initializeFallbackPlayers();
    }
}

function onPlayerError(event) {
    console.error('YouTube Player Error:', event.data);
    const player = event.target;
    const playerId = player.getIframe().id;
    const buttonId = playerId.replace(/player/, 'playButton');
    updateButtonState(buttonId, false, false);
    
    const timeId = playerId.replace(/player/, 'time');
    const timeDisplay = document.getElementById(timeId);
    if (timeDisplay) {
        timeDisplay.textContent = 'Error loading audio';
        timeDisplay.style.color = '#ef4444';
    }
}

function onPlayerStateChange(event) {
    if (!event.target) return;
    
    const player = event.target;
    const playerId = player.getIframe().id;
    const buttonId = playerId.replace(/player/, 'playButton');
    const timeId = playerId.replace(/player/, 'time');
    const progressId = playerId.replace(/player/, 'progress');
    
    const timeDisplay = document.getElementById(timeId);
    const progressBar = document.getElementById(progressId);

    if (!timeDisplay || !progressBar) return;

    if (event.data === YT.PlayerState.PLAYING) {
        updateButtonState(buttonId, false, true);
        updateProgress(player, progressBar, timeDisplay);
    } else if (event.data === YT.PlayerState.PAUSED) {
        updateButtonState(buttonId, false, false);
    } else if (event.data === YT.PlayerState.ENDED) {
        updateButtonState(buttonId, false, false);
        progressBar.style.width = '0%';
        timeDisplay.textContent = '0:00 / ' + formatTime(player.getDuration());
    }
}

function toggleAudio(audioId) {
    console.log('Toggle Audio:', audioId);
    
    if (!isAPIReady) {
        console.log('Players not ready yet, showing loading state');
        const buttonId = audioId.replace(/audio/, 'playButton');
        updateButtonState(buttonId, true, false);
        return;
    }
    
    const playerId = audioId.replace(/audio/, 'player');
    const player = players[playerId];
    const buttonId = audioId.replace(/audio/, 'playButton');
    
    if (!player) {
        console.error('Player not found:', audioId);
        return;
    }
    
    try {
        if (currentPlayer && currentPlayer !== player) {
            currentPlayer.pauseVideo();
        }
        
        const state = player.getPlayerState();
        if (state === YT.PlayerState.PLAYING) {
            player.pauseVideo();
        } else {
            player.playVideo();
            currentPlayer = player;
        }
    } catch (error) {
        console.error('Error toggling audio:', error);
        updateButtonState(buttonId, false, false);
    }
}

function seekAudio(audioId, event) {
    if (!isAPIReady) return;
    
    const playerId = audioId.replace(/audio/, 'player');
    const player = players[playerId];
    if (!player) return;
    
    const progressBar = event.currentTarget;
    const rect = progressBar.getBoundingClientRect();
    const pos = (event.clientX - rect.left) / rect.width;
    
    try {
        const duration = player.getDuration();
        player.seekTo(pos * duration, true);
    } catch (error) {
        console.error('Error seeking audio:', error);
    }
}

function updateProgress(player, progressBar, timeDisplay) {
    if (!player || !progressBar || !timeDisplay) return;
    
    try {
        const duration = player.getDuration();
        const currentTime = player.getCurrentTime();
        const progress = (currentTime / duration) * 100;
        
        progressBar.style.width = `${progress}%`;
        timeDisplay.textContent = `${formatTime(currentTime)} / ${formatTime(duration)}`;
        
        if (player.getPlayerState() === YT.PlayerState.PLAYING) {
            requestAnimationFrame(() => updateProgress(player, progressBar, timeDisplay));
        }
    } catch (error) {
        console.error('Error updating progress:', error);
    }
}

function formatTime(seconds) {
    if (!seconds) return '0:00';
    const minutes = Math.floor(seconds / 60);
    seconds = Math.floor(seconds % 60);
    return `${minutes}:${seconds.toString().padStart(2, '0')}`;
}

function updateButtonState(buttonId, isLoading = false, isPlaying = false) {
    const button = document.getElementById(buttonId);
    if (!button) return;
    
    const icon = button.querySelector('i');
    if (!icon) return;
    
    button.classList.remove('loading');
    icon.classList.remove('fa-spinner', 'fa-spin', 'fa-play', 'fa-pause');
    
    if (isLoading) {
        button.classList.add('loading');
        icon.classList.add('fa-spinner', 'fa-spin');
    } else {
        icon.classList.add(isPlaying ? 'fa-pause' : 'fa-play');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    
    // Initialize time displays
    document.querySelectorAll('[id^="time"]').forEach(timeDisplay => {
        timeDisplay.textContent = '0:00 / 0:00';
    });
    
    // Set initial button states
    document.querySelectorAll('.play-button').forEach(button => {
        updateButtonState(button.id, true, false);
    });
    
    // Load YouTube API
    loadYouTubeAPI();

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
    document.querySelectorAll('.scroll-reveal').forEach((el) => {
        observer.observe(el);
    });

    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const heroSection = document.querySelector('.hero-section-store');
        const scrolled = window.pageYOffset;
        heroSection.style.backgroundPositionY = -(scrolled * 0.5) + 'px';
    });
});

function showImage(src) {
    document.getElementById('modalImage').src = src;
}

// Handle modal open
document.getElementById('imageModal').addEventListener('show.bs.modal', function () {
    document.body.style.overflow = 'hidden';
});

// Handle modal close
document.getElementById('imageModal').addEventListener('hidden.bs.modal', function () {
    document.body.style.overflow = 'auto';
});
</script>
@endpush 