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
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url("{{ asset('images/hero-hero-section.png') }}") no-repeat center center;
        background-size: cover; /* Ensures full coverage */        
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
        color: white;
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

    /* Countdown Section */
    .countdown-section {
        background-color: #F8F4F8;
        padding: 3rem 1.5rem;
        color: var(--text-dark);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .countdown-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: var(--text-dark);
    }

    .countdown-timer {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .countdown-item {
        background: white;
        padding: 1.5rem 1rem;
        border-radius: 1rem;
        border: 2px solid #e2e8f0;
        min-width: 120px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .countdown-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: var(--primary-blue);
    }

    .countdown-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-blue);
        line-height: 1;
        margin-bottom: 0.5rem;
        display: block;
    }

    .countdown-label {
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-light);
    }

    .event-ended {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-blue);
        margin-top: 1rem;
    }

    /* Introduction Section */
    .introduction-section {
        padding: 5rem 1.5rem;
        background-color: white;
    }

    .intro-images-container {
        height: 100%;
        min-height: 600px;
        display: flex;
        align-items: stretch;
    }

    .intro-images-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        height: 100%;
        width: 100%;
    }

    .intro-image {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        background-color: #f1f5f9;
        position: relative;
    }

    .intro-image:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .intro-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .intro-image:hover img {
        transform: scale(1.05);
    }

    .intro-image.large {
        grid-row: span 2;
    }

    .intro-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(37, 99, 235, 0.1), rgba(147, 51, 234, 0.1));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .intro-image:hover::before {
        opacity: 1;
    }

    .intro-content {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        padding-left: 2rem;
        height: 100%;
    }

    .intro-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .intro-title span {
        color: var(--primary-blue);
        position: relative;
    }

    .intro-title span::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-blue), #9333ea);
        border-radius: 2px;
    }

    .intro-description {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--text-light);
        margin-bottom: 2rem;
    }

    .intro-highlights {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .intro-highlights li {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 1rem;
        color: var(--text-dark);
    }

    .intro-highlights li::before {
        content: '✦';
        color: var(--primary-blue);
        font-weight: bold;
        margin-right: 0.75rem;
        font-size: 1.2rem;
    }

    /* Introduction Section Feature Blocks */
    .intro-features {
        margin: 2rem 0;
    }

    .intro-feature-block {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background-color: #F8F4F8;
        border-radius: 0.75rem;
        /* border-left: 4px solid var(--primary-blue); */
        transition: all 0.3s ease;
    }

    .intro-feature-block:hover {
        background-color: #f1f5f9;
        transform: translateX(5px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .intro-feature-icon {
        width: 3rem;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #FF8C00, #FFD700);
        border-radius: 0.75rem;
        color: white;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .intro-feature-content {
        flex: 1;
    }

    .intro-feature-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        line-height: 1.3;
        letter-spacing: -0.025em;
    }

    .intro-feature-text {
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--text-light);
        margin: 0;
    }

    /* Read More Button */
    .read-more-container {
        text-align: center;
        margin-top: 2.5rem;
        padding-top: 1rem;
    }

    .btn-read-more {
        background: linear-gradient(135deg, #FFD700 0%, #FF8C00 100%);
        color: white !important;
        border: none;
        padding: 0.875rem 2.5rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 50px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-read-more:hover {
        background: linear-gradient(135deg, #FFC000 0%, #FF7F00 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 140, 0, 0.4);
        color: white !important;
    }

    .btn-read-more::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-read-more:hover::before {
        left: 100%;
    }

    .btn-read-more i {
        font-size: 0.9rem;
        transition: transform 0.3s ease;
    }

    .btn-read-more:hover i {
        transform: translateX(3px);
    }

    /* Responsive adjustments for feature blocks */
    @media (max-width: 768px) {
        .intro-feature-block {
            flex-direction: column;
            text-align: center;
            padding: 1.25rem;
        }
        
        .intro-feature-icon {
            align-self: center;
            margin-bottom: 1rem;
        }
        
        .intro-feature-title {
            font-size: 1rem;
        }
        
        .intro-feature-text {
            font-size: 0.9rem;
        }

        .btn-read-more {
            padding: 0.75rem 2rem;
            font-size: 0.95rem;
        }
    }

    @media (max-width: 576px) {
        .intro-features {
            margin: 1.5rem 0;
        }
        
        .intro-feature-block {
            margin-bottom: 1.5rem;
            padding: 1rem;
        }
        
        .intro-feature-icon {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 1.125rem;
        }

        .read-more-container {
            margin-top: 2rem;
        }

        .btn-read-more {
            padding: 0.75rem 1.75rem;
            font-size: 0.9rem;
        }
    }
    @media (max-width: 768px) {
        .introduction-section .row {
            flex-direction: column-reverse;
        }
        
        .intro-content {
            padding-left: 0;
            margin-bottom: 2rem;
            text-align: center;
            height: auto;
        }
        
        .intro-title {
            font-size: 2rem;
        }
        
        .intro-images-container {
            min-height: 450px;
        }
        
        .intro-images-grid {
            height: 100%;
            grid-template-columns: 1fr;
            grid-template-rows: repeat(4, 1fr);
        }
        
        .intro-image.large {
            grid-row: span 2;
        }
    }

    @media (max-width: 576px) {
        .intro-title {
            font-size: 1.75rem;
        }
        
        .intro-description {
            font-size: 1rem;
        }
        
        .intro-images-container {
            min-height: 350px;
        }
        
        .intro-images-grid {
            height: 100%;
        }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
        }

        .countdown-timer {
            gap: 1rem;
        }

        .countdown-item {
            min-width: 100px;
            padding: 1rem 0.75rem;
        }

        .countdown-number {
            font-size: 2rem;
        }

        .countdown-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }

        .countdown-timer {
            gap: 0.75rem;
        }

        .countdown-item {
            min-width: 80px;
            padding: 0.75rem 0.5rem;
        }

        .countdown-number {
            font-size: 1.5rem;
        }

        .countdown-label {
            font-size: 0.75rem;
        }

        .countdown-title {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }
    }

    .event-info {
    display: flex;
    flex-wrap: wrap; /* Allow items to wrap on small screens */
    gap: 20px;
    justify-content: center;
    margin: 10px auto 30px;
    max-width: 90%; /* Prevent stretching on large screens */
    color: white; /* Set text color to white */
}

/* Style icons red */
.event-info .fas {
    color: white; /* white icons */
    font-size: 1em;
    min-width: 16px;
}

/* Ensure text stays white */
.event-date span, 
.event-location span {
    color: white !important; /* Force white text */
}

.event-date, .event-location {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1.2rem;
    font-weight: 600;
    white-space: nowrap; /* Prevent text breaking */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .event-info {
        gap: 15px;
    }
    
    .event-date, .event-location {
        font-size: 1.1rem;
    }
}

@media (max-width: 576px) {
    .event-info {
        flex-direction: column; /* Stack vertically on mobile */
        align-items: center;
        gap: 10px;
    }
    
    .event-date, .event-location {
        font-size: 1rem;
    }
    
    .hero-title {
        margin-bottom: 0.5rem; /* Reduce space below title */
    }
}

/* Ensure icons scale properly */
.fas {
    color: #555;
    font-size: 1em; /* Relative to parent */
    min-width: 16px; /* Prevent icon shrinking */
}

/* Logo Styles */
.logo-container {
    text-align: center;
    margin-bottom: 1.5rem; /* Space between logo and title */
}

.bina-logo {
    max-height: 80px; /* Adjust based on your logo size */
    width: auto; /* Maintain aspect ratio */
    max-width: 100%; /* Ensure responsiveness */
}

/* Adjust hero-title margin if needed */
.hero-title {
    margin-top: 0; /* Remove default top margin */
}

@media (max-width: 768px) {
    .bina-logo {
        max-height: 60px; /* Slightly smaller on tablets */
    }
}

@media (max-width: 576px) {
    .bina-logo {
        max-height: 50px; /* Even smaller on mobile */
    }
    
    .logo-container {
        margin-bottom: 1rem; /* Reduce space on small screens */
    }
}

/* Gradient Yellow-Orange Ticket Button */
.btn-ticket {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); /* Yellow to Orange */
    color: white !important;
    border: none;
    padding: 0.75rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden; /* For hover effect */
}

.btn-ticket:hover {
    background: linear-gradient(135deg, #FFC000 0%, #FF8C00 100%); /* Darker gradient on hover */
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
}

/* Optional: Add a shine effect on hover */
.btn-ticket:hover::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: rgba(255, 255, 255, 0.1);
    transform: rotate(30deg);
    transition: all 0.3s ease;
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <!-- Add BINA Logo Here -->
        <div class="logo-container">
            <img 
                src="{{ asset('images/bina-logo.png') }}" 
                alt="BINA Logo" 
                class="bina-logo"
            >
        </div>
        
        <h1 class="hero-title">CONSTRUCTING THE FUTURE OF ASEAN</h1>
        
        <div class="event-info">
            <div class="event-date">
                <i class="fas fa-calendar-alt"></i>
                <span>2025 OCT 28-30</span>
            </div>
            <div class="event-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>MITEC, KUALA LUMPUR</span>
            </div>
        </div>
        
        <div class="hero-btn">
            <a href="#" class="btn btn-ticket ms-3">Get Ticket</a>        
        </div>
    </div>
</div>

<!-- Countdown Section -->
<div class="countdown-section">
    <div class="container">
        <h2 class="countdown-title">Our Event Starts In:</h2>
        <div class="countdown-timer" id="countdown">
            <div class="countdown-item">
                <span class="countdown-number" id="days">00</span>
                <span class="countdown-label">Days</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="hours">00</span>
                <span class="countdown-label">Hours</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="minutes">00</span>
                <span class="countdown-label">Minutes</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number" id="seconds">00</span>
                <span class="countdown-label">Seconds</span>
            </div>
        </div>
        <div class="event-ended" id="event-ended" style="display: none;">
            🎉 The Event Has Started! 🎉
        </div>
    </div>
</div>

<!-- Introduction Section -->
<div class="introduction-section">
    <div class="container">
        <div class="row align-items-stretch">
            <!-- Left Side - Images Grid -->
            <div class="col-lg-6">
                <div class="intro-images-container">
                    <div class="intro-images-grid">
                        <div class="intro-image large">
                            <img 
                                src="{{ asset('images/bina-intro-1.jpg') }}" 
                                alt="BINA 2025 Construction Exhibition"
                            >
                        </div>
                        <div class="intro-image">
                            <img 
                                src="{{ asset('images/bina-intro-2.jpg') }}" 
                                alt="Construction Technology"
                            >
                        </div>
                        <div class="intro-image">
                            <img 
                                src="{{ asset('images/bina-intro-3.png') }}" 
                                alt="Building Innovation"
                            >
                        </div>
                        <div class="intro-image">
                            <img 
                                src="{{ asset('images/bina-intro-4.jpg') }}" 
                                alt="Future Construction"
                            >
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Content -->
            <div class="col-lg-6">
                <div class="intro-content">
                    <h2 class="intro-title">Introduction About <span>BINA 2025</span></h2>
                    <p class="intro-description">
                        BINA 2025 will showcase breakthrough solutions, foster high-impact discussions, and shape the next era of construction. Join us in celebrating five years of innovation—here industry meets transformation!
                    </p>
                    
                    <!-- Feature Blocks -->
                    <div class="intro-features">
                        <div class="intro-feature-block">
                            <div class="intro-feature-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="intro-feature-content">
                                <h4 class="intro-feature-title">TRANSFORMING ASEAN'S CONSTRUCTION LANDSCAPE</h4>
                                <p class="intro-feature-text">
                                    As part of BINA Conference at ICW 2025, MODULAR ASIA is a premier forum and exhibition dedicated to advancing 
                                    Modular Technology, Modern Methods of Construction (MMC), and Industrialised Building Systems (IBS).
                                </p>
                            </div>
                        </div>
                        
                        <div class="intro-feature-block">
                            <div class="intro-feature-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div class="intro-feature-content">
                                <h4 class="intro-feature-title">WHERE EXPERTISE MEETS BUSINESS GROWTH!</h4>
                                <p class="intro-feature-text">
                                    As part of BINA 2025 at ICW, Facility Management Engagement Day goes beyond a traditional conference—
                                    it's a dynamic platform for industry leaders, innovators, and businesses to exchange expertise, explore best practices, 
                                    and unlock new opportunities in facility management.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Read More Button -->
                    <div class="read-more-container">
                        <a href="#" class="btn-read-more">
                            <span>Read More</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Countdown Timer JavaScript
function updateCountdown() {
    // Set the event date - October 28, 2025 at 00:00:00
    const eventDate = new Date('2025-10-28T00:00:00').getTime();
    const now = new Date().getTime();
    const timeLeft = eventDate - now;

    // If the event has passed
    if (timeLeft < 0) {
        document.getElementById('countdown').style.display = 'none';
        document.getElementById('event-ended').style.display = 'block';
        return;
    }

    // Calculate time units
    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    // Update the countdown display
    document.getElementById('days').textContent = days.toString().padStart(2, '0');
    document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
    document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
    document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
}

// Update countdown immediately and then every second
updateCountdown();
setInterval(updateCountdown, 1000);

// Add smooth animation when numbers change
const countdownElements = ['days', 'hours', 'minutes', 'seconds'];
countdownElements.forEach(id => {
    const element = document.getElementById(id);
    let previousValue = element.textContent;
    
    const observer = new MutationObserver(() => {
        if (element.textContent !== previousValue) {
            element.style.transform = 'scale(1.1)';
            element.style.color = '#1e40af'; // Use primary-dark color
            setTimeout(() => {
                element.style.transform = 'scale(1)';
                element.style.color = '#2563eb'; // Back to primary-blue
            }, 200);
            previousValue = element.textContent;
        }
    });
    
    observer.observe(element, { childList: true, subtree: true });
});
</script>
@endsection