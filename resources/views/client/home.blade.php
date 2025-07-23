@extends('client.layouts.app')

@section('title', 'BINA | Home')

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
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("{{ asset('images/hero-section.png') }}") no-repeat center center;
        background-size: cover;
        text-align: center;
        padding: 0 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .hero-content {
        max-width: 1000px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
        animation: fadeInUp 1s ease-out;
    }

    .hero-title {
        font-size: 4rem;
        font-weight: 800;
        color: white;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        letter-spacing: 1px;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--text-light);
        max-width: 600px;
        margin: 0 auto 2rem;
        line-height: 1.6;
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-ticket, .btn-trailer {
        padding: 0.875rem 2.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-ticket {
        background: linear-gradient(135deg, #FFD700 0%, #FF8C00 100%);
        color: white !important;
        border: none;
    }

    .btn-ticket:hover {
        background: linear-gradient(135deg, #FFC000 0%, #FF7F00 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 140, 0, 0.4);
    }

    .btn-trailer {
        background: transparent;
        color: white !important;
        border: 2px solid white;
    }

    .btn-trailer:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
    }

    /* Video Modal Styles */
    .video-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 9999; /* Increased z-index to be above everything */
        opacity: 0;
        transition: opacity 0.3s ease;
        backdrop-filter: blur(5px); /* Add blur effect to background */
    }

    .video-modal.active {
        display: flex;
        opacity: 1;
    }

    .video-modal-content {
        position: relative;
        width: 90%;
        max-width: 1000px;
        margin: auto;
        background: #000;
        border-radius: 10px;
        overflow: hidden;
        transform: scale(0.9);
        transition: transform 0.3s ease;
        padding: 20px;
        z-index: 10000; /* Ensure content is above the overlay */
    }

    .video-modal.active .video-modal-content {
        transform: scale(1);
    }

    .video-modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        color: white;
        font-size: 2.5rem;
        cursor: pointer;
        z-index: 10001; /* Ensure close button is above everything */
        transition: all 0.3s ease;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        border: 2px solid white;
    }

    .video-modal-close:hover {
        color: #ff9800;
        background: rgba(0, 0, 0, 0.8);
        transform: rotate(90deg);
    }

    .video-modal video {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 5px;
    }

    /* Add styles for when modal is open */
    body.modal-open {
        overflow: hidden; /* Prevent scrolling when modal is open */
    }

    /* Add animation for modal content */
    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .video-modal.active .video-modal-content {
        animation: modalFadeIn 0.3s ease forwards;
    }

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

    /* Responsive adjustments for hero section */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 3.5rem;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.8rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
        }

        .btn-ticket, .btn-trailer {
            padding: 0.75rem 2rem;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .hero-title {
            font-size: 2.2rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }

        .hero-buttons {
            flex-direction: column;
            gap: 1rem;
        }

        .btn-ticket, .btn-trailer {
            width: 100%;
            justify-content: center;
        }
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
        max-width: 600px;
        margin: 0 auto;
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
        border-color: #ff9800;
    }

    .countdown-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #ff9800;
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

    .intro-subtitle {
        font-size: 1.1rem;
        font-weight: 600;
        color: #ff9800; /* Orange color */
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        line-height: 1.2;
        text-align: center;
    }

    .intro-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 1rem;
        line-height: 1.2;
        text-align: center;
    }

    .intro-title span {
        color: #ff9800;
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
        text-align: justify;
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

    .intro-feature-icon i {
        color: white;
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
        text-align: left;
    }

    .intro-feature-text {
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--text-light);
        margin: 0;
        text-align: justify;
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
            text-align: center;
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
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            max-width: 400px;
            padding: 0 1rem;
        }

        .countdown-item {
            width: 100%;
            min-width: unset;
            padding: 1.25rem 0.75rem;
        }

        .countdown-number {
            font-size: 2.25rem;
        }

        .countdown-label {
            font-size: 0.8rem;
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

.event-date i, .event-location i {
    color: #ff9800 !important;
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

/* New Counters Section */
.counters-section {
    background-color: #F8F4F8;
    padding: 4rem 1.5rem;
    text-align: center;
}

.counters-container {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 0 auto;
}

.counter-card {
    background-color: white;
    padding: 2rem 1.5rem;
    border-radius: 1.5rem;
    border: 1px solid #f0e6db;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.08);
    flex: 1;
    min-width: 220px;
    max-width: 280px;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.counter-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.12);
}

.counter-number {
    font-size: 4rem;
    font-weight: 900;
    color: black;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.counter-number span.plus {
    color: #ff9800;
    font-size: 0.8em;
    vertical-align: top;
}

.counter-label {
    font-size: 1.1rem;
    font-weight: 600;
    color: #546e7a;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Responsive Adjustments for Counters */
@media (max-width: 768px) {
    .counters-section {
        padding: 3rem 1rem;
    }

    .counters-container {
        gap: 0.75rem;
        padding: 0;
    }

    .counter-card {
        flex: 1;
        min-width: 0;
        max-width: none;
        padding: 1rem;
    }

    .counter-number {
        font-size: 2.5rem;
    }

    .counter-label {
        font-size: 0.85rem;
    }
}

@media (max-width: 480px) {
    .counters-section {
        padding: 2rem 0.5rem;
    }

    .counter-card {
        padding: 0.75rem 0.5rem;
    }

    .counter-number {
        font-size: 2rem;
    }

    .counter-label {
        font-size: 0.75rem;
        letter-spacing: 0.02em;
    }
}

/* Event Detail Section */
.event-detail-section {
    background-color: #000; /* Black background */
    padding: 5rem 1.5rem;
}

.event-section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.event-section-title {
    font-size: 3.5rem;
    font-weight: 900;
    color: white;
    margin-bottom: 0.75rem;
    line-height: 1.1;
    text-transform: uppercase;
}

.event-section-subtitle {
    font-size: 1.25rem;
    font-weight: 600;
    color: #ff9800; /* Orange color */
    margin-bottom: 0;
    text-align: center;
    max-width: 800px; /* Limit width for better readability */
    margin-left: auto;
    margin-right: auto;
}

.event-detail-card {
    background-color: #1a1a1a; /* Dark background for the card */
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    display: flex;
    flex-direction: column; /* Stack on small screens */
    margin-bottom: 2rem; /* Add space below each card */
}

.event-image-container {
    flex-shrink: 0;
}

.event-image-container img {
    display: block;
    width: 100%;
    height: auto; /* Default height auto */
    object-fit: cover;
}

.event-content-container {
    padding: 2rem;
    color: white;
    flex-grow: 1;
}

.event-meta {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap; /* Allow wrapping */
}

.event-meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    color: #b0bec5; /* Light grey for meta info */
}

.event-meta-item i {
    color: #ff9800; /* Orange icon color */
}

/* Add classes for specific meta items */
.event-meta-item.location {
    order: 1;
}

.event-meta-item.date {
    order: 2;
}

.event-meta-item.time {
    order: 3;
}

@media (max-width: 768px) {
    .event-meta {
        gap: 1rem;
        justify-content: center;
    }

    .event-meta-item {
        font-size: 0.95rem;
    }

    /* Reorder items on mobile */
    .event-meta-item.location {
        order: 1;
        flex-basis: 100%; /* Full width */
        justify-content: center;
    }

    .event-meta-item.date {
        order: 2;
    }

    .event-meta-item.time {
        order: 3;
    }
}

.event-detail-title {
    font-size: 2rem;
    font-weight: 800;
    color: white;
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .event-detail-title {
        font-size: 1.5rem;
        text-align: center;
    }
}

.event-detail-description {
    font-size: 1rem;
    line-height: 1.6;
    color: #b0bec5;
    margin-bottom: 2rem;
    text-align: justify;
}

.event-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap; /* Allow buttons to wrap */
}

.btn-view-more, .btn-get-ticket {
    padding: 0.75rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-view-more {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); /* Orange gradient */
    color: white !important;
    border: none;
    box-shadow: 0 4px 10px rgba(255, 152, 0, 0.3);
}

.btn-view-more:hover {
    background: linear-gradient(135deg, #f57c00 0%, #ef6c00 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(255, 152, 0, 0.4);
}

/* Override hover effect for first event card */
.event-detail-section .container:first-child .btn-view-more:hover {
    background: linear-gradient(90deg,#0e6389 0%,#157ba6 100%);
    box-shadow: 0 6px 12px rgba(17, 116, 158, 0.4);
}

.btn-get-ticket {
    background-color: white;
    color: #1a1a1a !important; /* Dark text */
    border: 2px solid #b0bec5; /* Light grey border */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.btn-get-ticket:hover {
    background-color: #e0e0e0;
    border-color: #90a4ae;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Responsive adjustments for Event Detail */
@media (min-width: 768px) {
    .event-detail-card {
        flex-direction: row;
        align-items: stretch; /* Ensure children stretch to fill height */
    }

    .event-image-container {
        flex-basis: 32%; /* Reduced size on larger screens */
        height: 100%; /* Ensure container takes full height of flex item */
    }

    .event-image-container img {
        width: 100%;
        height: 100%; /* Make image take full height of its container */
        object-fit: cover;
    }

    .event-content-container {
        flex-basis: 70%; /* Increased size for content */
    }
}

@media (max-width: 768px) {
    .event-detail-card {
        flex-direction: column; /* Stack vertically on small screens */
    }

    .event-image-container img {
        height: 250px; /* Fixed height for images on small screens */
        object-fit: cover;
    }

    .event-content-container {
        padding: 1.5rem;
    }

    .event-detail-title {
        font-size: 1.5rem;
    }

    .event-detail-description {
        font-size: 0.95rem;
    }

    .event-meta {
        gap: 1rem;
    }

    .event-buttons {
        flex-direction: column; /* Stack buttons on extra small screens */
        gap: 0.75rem;
    }

     .btn-view-more, .btn-get-ticket {
        width: 100%; /* Full width buttons */
     }
}

/* New Offering Section */
.offering-section {
    background-color: white;
    padding: 5rem 1.5rem;
    text-align: center;
}

.offering-header {
    margin-bottom: 3rem;
}

.offering-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a1a1a; /* Dark text */
    margin-bottom: 0;
    line-height: 1.2;
    text-transform: uppercase;
}

.offering-cards-container {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 0 auto;
}

.offering-card {
    background-color: #ffffff;
    padding: 2rem 1.5rem;
    border-radius: 1rem;
    border: 1px solid #e0e0e0; /* Light grey border */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    flex: 1;
    min-width: 200px;
    max-width: 280px;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: all 0.3s ease;
}

.offering-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.offering-icon {
    width: 4rem;
    height: 4rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #ff9800; /* Orange background */
    border-radius: 0.75rem;
    color: white;
    font-size: 2rem;
    margin-bottom: 1.5rem;
}

.offering-icon i {
    color: white;
}

.offering-label {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a; /* Dark text */
    text-transform: uppercase;
    text-align: center;
}

/* Responsive adjustments for Offering Section */
@media (max-width: 992px) {
    .offering-section {
        padding: 3rem 1rem;
    }

    .offering-cards-container {
        gap: 1.5rem;
    }

    .offering-card {
        min-width: 180px;
        max-width: 250px;
        padding: 1.5rem 1rem;
    }
}

@media (max-width: 768px) {
    .offering-header {
        margin-bottom: 2rem;
    }

    .offering-title {
        font-size: 2rem;
    }

    .offering-cards-container {
        gap: 1rem;
    }

    .offering-card {
        flex: 0 1 calc(50% - 1rem); /* Two cards per row with gap */
        min-width: 150px;
        max-width: none;
        padding: 1.25rem 1rem;
    }

    .offering-icon {
        width: 3.5rem;
        height: 3.5rem;
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }

    .offering-label {
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .offering-section {
        padding: 2rem 0.75rem;
    }

    .offering-title {
        font-size: 1.75rem;
    }

    .offering-cards-container {
        gap: 1rem;
        flex-direction: column;
        align-items: center;
    }

    .offering-card {
        width: 100%;
        max-width: 280px;
        padding: 1.25rem;
    }

    .offering-icon {
        width: 3rem;
        height: 3rem;
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .offering-label {
        font-size: 0.9rem;
    }
}

/* New Why Should Attend Section */
.why-attend-section {
    background-color: #f8f4f8; /* Light background */
    padding: 5rem 1.5rem;
    text-align: center;
}

.why-attend-header {
    margin-bottom: 3rem;
}

.why-attend-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a1a1a; /* Dark text */
    margin-bottom: 0.5rem;
    line-height: 1.2;
    text-transform: uppercase;
}

.why-attend-subtitle {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ff9800; /* Orange color */
    margin-bottom: 0;
    text-align: center;
    max-width: 800px; /* Limit width for better readability */
    margin-left: auto;
    margin-right: auto;
}

.why-attend-cards-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.why-attend-card {
    background-color: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.why-attend-card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a; /* Dark text */
    margin-bottom: 1rem;
    text-align: center;
    text-align-last: center; /* For the last line when justified */
}

.why-attend-card-description {
    font-size: 1rem;
    line-height: 1.6;
    color: #546e7a; /* Greyish blue text */
    margin-bottom: 0;
    text-align: justify;
}

/* Responsive adjustments for Why Should Attend Section */
@media (max-width: 992px) {
    .why-attend-cards-container {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 0 1rem;
    }

    .why-attend-card {
        padding: 1.5rem;
    }
}

@media (max-width: 480px) {
    .why-attend-cards-container {
        gap: 1rem;
    }

    .why-attend-card {
        padding: 1.25rem;
    }
}

.event-highlight-section {
    background-color: white;
    padding: 5rem 0;
}

.event-highlight-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
    flex-wrap: wrap;
    gap: 1rem;
    padding: 0 1.5rem;
    max-width: 1400px;
    margin-left: auto;
    margin-right: auto;
}

.event-highlight-title-container {
    text-align: left;
    flex-grow: 1;
}

.event-highlight-subtitle {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ff9800;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
}

.event-highlight-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 0;
    line-height: 1.2;
    text-transform: uppercase;
}

.btn-see-more {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    color: white !important;
    border: none;
    padding: 0.75rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 0.5rem;
    box-shadow: 0 4px 10px rgba(255, 152, 0, 0.3);
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.btn-see-more:hover {
    background: linear-gradient(135deg, #f57c00 0%, #ef6c00 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(255, 152, 0, 0.4);
}

.event-highlight-cards-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

.event-highlight-card {
    background-color: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    aspect-ratio: 16/9;
}

.event-highlight-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.event-highlight-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

@media (max-width: 992px) {
    .event-highlight-section {
        padding: 4rem 0;
    }

    .event-highlight-cards-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        padding: 0 1rem;
    }

    .event-highlight-header {
        padding: 0 1rem;
    }
}

@media (max-width: 768px) {
    .event-highlight-header {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 2rem;
    }

    .event-highlight-title-container {
        text-align: center;
        width: 100%;
    }

    .event-highlight-subtitle {
        text-align: center;
    }

    .event-highlight-title {
        font-size: 2rem;
        text-align: center;
    }

    .btn-see-more {
        width: 100%;
        margin-top: 1rem;
    }
}

@media (max-width: 576px) {
    .event-highlight-section {
        padding: 3rem 0;
    }

    .event-highlight-cards-container {
        grid-template-columns: 1fr;
        padding: 0 0.75rem;
    }

    .event-highlight-header {
        padding: 0 0.75rem;
    }

    .event-highlight-title {
        font-size: 1.75rem;
    }

    .event-highlight-subtitle {
        font-size: 1rem;
    }
}

.speaker-section {
    background-color: #f8f8f8; /* Light background */
    padding: 5rem 1.5rem;
}

.speaker-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.speaker-title-container {
    text-align: left;
    flex-grow: 1;
}

.speaker-subtitle {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ff9800; /* Orange color */
    margin-bottom: 0.5rem;
    text-transform: uppercase;
}

.speaker-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a1a1a; /* Dark text */
    margin-bottom: 0;
    line-height: 1.2;
    text-transform: uppercase;
}

.btn-speaker-see-more {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); /* Orange gradient */
    color: white !important;
    border: none;
    padding: 0.75rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 0.5rem;
    box-shadow: 0 4px 10px rgba(255, 152, 0, 0.3);
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.btn-speaker-see-more:hover {
     background: linear-gradient(135deg, #f57c00 0%, #ef6c00 100%);
     transform: translateY(-2px);
     box-shadow: 0 6px 12px rgba(255, 152, 0, 0.4);
}

.speaker-cards-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive grid for cards */
    gap: 2rem;
}

.speaker-card {
    background-color: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-bottom: 1.5rem; /* Space below content */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.speaker-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.speaker-image-container {
    background-color: #e0e0e0; /* Grey background for placeholder */
    border-radius: 50%; /* Circular image */
    width: 150px; /* Size of the circle */
    height: 150px; /* Size of the circle */
    margin-top: 2rem;
    margin-bottom: 1.5rem;
    overflow: hidden;
}

 .speaker-image-container img {
     display: block;
     width: 100%;
     height: 100%;
     object-fit: cover;
 }

.speaker-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a; /* Dark text */
    margin-bottom: 0.25rem;
    text-align: center;
}

.speaker-position {
    font-size: 1rem;
    color: #ff9800; /* Orange color */
    margin-bottom: 1rem;
    text-align: center;
    text-transform: uppercase;
}

.speaker-social {
    display: flex;
    gap: 0.75rem;
}

.speaker-social a {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ff9800;
    border-radius: 50%;
    transition: all 0.3s ease;
    text-decoration: none;
}

.speaker-social a i {
    color: white;
}

.speaker-social a:hover {
    background: #f57c00;
    transform: translateY(-2px);
}

/* Responsive adjustments for Speaker Section */
 @media (max-width: 768px) {
    .speaker-section {
        padding: 3rem 1rem;
    }

    .speaker-header {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 2rem;
    }

    .speaker-title-container {
        text-align: center;
        width: 100%;
    }

    .speaker-subtitle {
        text-align: center;
    }

    .speaker-title {
        font-size: 2rem;
        text-align: center;
    }

    .btn-speaker-see-more {
        width: 100%;
        margin-top: 1rem;
    }

    .speaker-cards-container {
        gap: 1.5rem;
    }

    .speaker-image-container {
        width: 120px;
        height: 120px;
         margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .speaker-name {
        font-size: 1.1rem;
    }

    .speaker-position {
        font-size: 0.9rem;
         margin-bottom: 0.75rem;
    }

     .speaker-social a {
        width: 30px;
        height: 30px;
        font-size: 0.9rem;
     }
}

@media (max-width: 480px) {
     .speaker-section {
        padding: 2rem 0.5rem;
    }

    .speaker-title {
        font-size: 1.75rem;
    }

    .speaker-subtitle {
        font-size: 1rem;
    }

    .speaker-cards-container {
         grid-template-columns: 1fr; /* Stack cards */
         gap: 1rem;
    }

    .speaker-image-container {
        width: 100px;
        height: 100px;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }

     .speaker-name {
        font-size: 1rem;
    }

    .speaker-position {
        font-size: 0.8rem;
         margin-bottom: 0.5rem;
    }

    .speaker-social a {
        width: 25px;
        height: 25px;
        font-size: 0.8rem;
     }
}

/* New Location Section */
.location-section {
    background-color: white;
    padding: 5rem 1.5rem;
}

.location-content {
    display: flex;
    flex-direction: column; /* Stack on small screens */
    gap: 2rem;
}

.location-text {
    flex: 1;
}

.location-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a1a1a; /* Dark text */
    margin-bottom: 1.5rem;
    line-height: 1.2;
    text-transform: uppercase;
    text-align: center;
}

.location-description {
    font-size: 1.125rem;
    line-height: 1.8;
    color: #546e7a; /* Greyish blue text */
    margin-bottom: 0;
    text-align: justify;
}

.location-map {
    flex: 1;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
}

.location-map iframe {
    width: 100%;
    height: 100%; /* Fixed height for the map */
    border: 0;
}

/* Responsive adjustments for Location Section */
@media (min-width: 768px) {
    .location-content {
        flex-direction: row; /* Row layout on larger screens */
    }

    .location-text {
        flex-basis: 50%; /* Adjust as needed */
    }

    .location-map {
        flex-basis: 50%; /* Adjust as needed */
    }
}

@media (max-width: 768px) {
    .location-section {
        padding: 3rem 1rem;
    }

    .location-title {
        font-size: 2rem;
    }

    .location-description {
        font-size: 1rem;
    }

    .location-map iframe {
        height: 300px;
    }
}

@media (max-width: 480px) {
    .location-section {
        padding: 2rem 0.5rem;
    }

    .location-title {
        font-size: 1.75rem;
    }

    .location-description {
        font-size: 0.9rem;
    }

    .location-map iframe {
        height: 250px;
    }
}

/* New Partners Section */
.partners-section {
    background-color: #F8F8F8;
    padding: 5rem 1.5rem;
}

.partners-header {
    margin-bottom: 3rem;
}

.partners-subtitle {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ff9800;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
}

.partners-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 0;
    line-height: 1.2;
    text-transform: uppercase;
}

.partners-content {
    display: flex;
    gap: 3rem;
    flex-wrap: wrap;
}

.partners-text-container {
    flex: 1;
    min-width: 300px;
}

.partners-description {
    font-size: 1.125rem;
    line-height: 1.8;
    color: #546e7a;
    margin-bottom: 2rem;
    text-align: justify;
}

.partners-logo-grid {
    flex: 1;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    align-items: center;
    justify-items: center;
    min-width: 300px;
}

.partner-logo-item {
    width: 100%;
    aspect-ratio: 16/9;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

.partner-logo-item:hover {
    transform: translateY(-5px);
}

.partner-logo-item img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

/* Responsive adjustments for Partners Section */
@media (max-width: 992px) {
    .partners-logo-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .partners-section {
        padding: 3rem 1rem;
    }

    .partners-content {
        flex-direction: column;
        gap: 2rem;
    }

    .partners-header {
        text-align: center;
    }

    .partners-text-container {
        min-width: unset;
        text-align: center;
    }

    .partners-logo-grid {
        grid-template-columns: 1fr;
        max-width: 300px;
        margin: 0 auto;
        gap: 2rem;
    }

    .partner-logo-item {
        width: 100%;
        aspect-ratio: 3/2;
    }
}

@media (max-width: 480px) {
    .partners-section {
        padding: 2rem 0.75rem;
    }

    .partners-title {
        font-size: 2rem;
    }

    .partners-subtitle {
        font-size: 1rem;
    }

    .partners-description {
        font-size: 1rem;
    }

    .partners-logo-grid {
        max-width: 250px;
        gap: 1.5rem;
    }

    .partner-logo-item {
        aspect-ratio: 4/3;
    }
}

/* New Feedback Section */
.feedback-section {
    background-color: #0d1117; /* Dark background */
    padding: 5rem 1.5rem;
    text-align: center;
}

.feedback-header {
    margin-bottom: 3rem;
}

.feedback-subtitle {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ff9800; /* Orange color */
    margin-bottom: 0.5rem;
    text-transform: uppercase;
}

.feedback-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: white; /* White text */
    margin-bottom: 0;
    line-height: 1.2;
}

.feedback-cards-container {
    display: flex;
    justify-content: center;
    gap: 2rem; /* Space between cards */
    flex-wrap: wrap; /* Allow wrapping on smaller screens */
}

.feedback-card {
    background-color: #161b22; /* Slightly lighter dark background for cards */
    border-radius: 1rem; /* Rounded corners */
    padding: 2rem;
    max-width: 450px; /* Max width for cards */
    color: #c9d1d9; /* Light text color */
    text-align: left;
    display: flex;
    flex-direction: column;
    align-items: center; /* Center content vertically within the card */
}

.feedback-text {
    font-size: 1.125rem;
    line-height: 1.8;
    margin-bottom: 1.5rem;
    font-style: italic; /* Italicize the quote text */
    text-align: justify;
}

.feedback-avatar {
    width: 80px; /* Avatar size */
    height: 80px;
    border-radius: 50%; /* Circular avatar */
    background-color: #e0e0e0; /* Placeholder background */
    margin-bottom: 1rem;
    overflow: hidden; /* Hide overflow for the circular image */
}

.feedback-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Cover the container */
}

.feedback-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: white; /* White name color */
    text-align: center;
}

.feedback-position {
    font-size: 0.9rem; /* Smaller font size for position */
    color: #b0bec5; /* Light grey color for position */
    text-align: center;
    margin-top: 0.25rem; /* Space above the position */
}

/* Responsive adjustments for Feedback Section */
@media (max-width: 768px) {
    .feedback-section {
        padding: 3rem 1rem;
    }

    .feedback-header {
        margin-bottom: 2rem;
    }

    .feedback-title {
        font-size: 2rem;
    }

    .feedback-subtitle {
        font-size: 1rem;
    }

    .feedback-cards-container {
        gap: 1.5rem;
    }

    .feedback-card {
        padding: 1.5rem;
    }

    .feedback-text {
        font-size: 1rem;
    }

    .feedback-avatar {
        width: 60px;
        height: 60px;
        margin-bottom: 0.75rem;
    }

    .feedback-name {
        font-size: 1.1rem;
    }

    .feedback-position {
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }
}

@media (max-width: 480px) {
    .feedback-section {
        padding: 2rem 0.5rem;
    }

    .feedback-title {
        font-size: 1.75rem;
    }

    .feedback-cards-container {
        gap: 1rem;
    }

    .feedback-card {
        padding: 1rem;
    }

    .feedback-text {
        font-size: 0.9rem;
    }

    .feedback-avatar {
        width: 50px;
        height: 50px;
    }

    .feedback-name {
        font-size: 1rem;
    }

    .feedback-position {
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }
}

@media (min-width: 992px) {
    .hero-section {
        padding-top: 6rem;
    }
}

.hero-social-floating {
    position: absolute;
    right: 2.5rem;
    bottom: 2.5rem;
    display: flex;
    gap: 1.2rem;
    z-index: 10;
}
.hero-social-icon {
    width: 48px;
    height: 48px;
    background: #ff9800;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.7rem;
    transition: background 0.2s, transform 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.10);
    text-decoration: none;
}
.hero-social-icon:hover {
    background: #ffb347;
    transform: translateY(-3px) scale(1.08);
}
@media (max-width: 768px) {
    .hero-social-floating {
        display: none;
    }
}

.btn-ticket .fa-ticket-alt {
    color: #fff !important;
}
.btn-trailer .fa-play-circle {
    color: #fff !important;
}

.desktop-only {
    display: inline-flex;
}

.mobile-see-more {
    display: none;
    margin-top: 2rem;
    text-align: center;
    padding: 0 1.5rem;
}

@media (max-width: 768px) {
    .desktop-only {
        display: none;
    }

    .mobile-see-more {
        display: block;
    }

    .mobile-see-more .btn-see-more {
        width: 100%;
    }
}

/* Update existing mobile-see-more styles to handle both buttons */
.mobile-see-more {
    display: none;
    margin-top: 2rem;
    text-align: center;
    padding: 0 1.5rem;
}

.mobile-see-more .btn-see-more,
.mobile-see-more .btn-speaker-see-more {
    width: 100%;
}

@media (max-width: 768px) {
    .desktop-only {
        display: none;
    }

    .mobile-see-more {
        display: block;
    }
}

/* Add this to the style section */
.event-speakers-container {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    margin-top: 2rem;
}

.event-speakers-card {
    background: white;
    border-radius: 1.5rem;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
}

.event-speakers-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e5e7eb;
}

.event-speakers-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.event-speakers-subtitle {
    font-size: 1rem;
    color: #64748b;
    font-weight: 500;
}

.event-speakers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.speaker-card {
    background: #f8fafc;
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.speaker-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    border-color: #ff9800;
}

.speaker-image-container {
    width: 120px;
    height: 120px;
    margin: 0 auto 1rem;
}

.speaker-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.speaker-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.speaker-position {
    font-size: 0.9rem;
    color: #64748b;
    margin-bottom: 1rem;
    line-height: 1.4;
}

.speaker-social {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
}

.speaker-social a {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ff9800;
    border-radius: 50%;
    transition: all 0.3s ease;
    text-decoration: none;
}

.speaker-social a i {
    color: white;
}

.speaker-social a:hover {
    background: #f57c00;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .event-speakers-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    
    .speaker-image-container {
        width: 100px;
        height: 100px;
    }
    
    .speaker-name {
        font-size: 1rem;
    }
    
    .speaker-position {
        font-size: 0.85rem;
    }
}

<div class="speaker-section">
    <div class="container">
        <div class="speaker-header">
            <div class="speaker-title-container">
                <p class="speaker-subtitle">OUR SPEAKER</p>
                <h2 class="speaker-title">MEET OUR SPEAKERS</h2>
            </div>
        </div>
        
        <div class="event-speakers-container">
            <!-- Facility Management Card -->
            <div class="event-speakers-card">
                <div class="event-speakers-header">
                    <h3 class="event-speakers-title">FACILITY MANAGEMENT ENGAGEMENT DAY</h3>
                </div>
                <div class="event-speakers-grid">
                    <div class="speaker-card">
                        <div class="speaker-image-container">
                            <img src="{{ asset('images/dr-azrin-ahmad.jpg') }}" alt="Dr. Azrin Bin Ahmad">
                        </div>
                        <div class="speaker-name">Dr. Azrin Bin Ahmad</div>
                        <div class="speaker-position">Project Director<br>Maltimur Aktif Unggul Jv Sdn Bhd</div>
                        <div class="speaker-social">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modular Asia Card -->
            <div class="event-speakers-card">
                <div class="event-speakers-header">
                    <h3 class="event-speakers-title">MODULAR ASIA FORUM & EXHIBITION</h3>
                </div>
                <div class="event-speakers-grid">
                    <div class="speaker-card">
                        <div class="speaker-image-container">
                            <img src="{{ asset('images/erlend-spets.jpg') }}" alt="Erlend Spets" style="object-position: top">
                        </div>
                        <div class="speaker-name">Erlend Spets</div>
                        <div class="speaker-position">Associate Partner<br>McKinsey & Company</div>
                        <div class="speaker-social">
                            <a href="https://www.linkedin.com/in/erlend-spets-b533106a/" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="speaker-card">
                        <div class="speaker-image-container">
                            <img src="{{ asset('images/tobias-schaefer.jpg') }}" alt="Tobias Schaefer">
                        </div>
                        <div class="speaker-name">Tobias Schaefer</div>
                        <div class="speaker-position">Global Head of Prefab<br>ARDEX Group</div>
                        <div class="speaker-social">
                            <a href="https://www.linkedin.com/in/tobias1schaefer/" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="speaker-card">
                        <div class="speaker-image-container">
                            <img src="{{ asset('images/martins-motivans.jpg') }}" alt="Martins Motivans" style="object-position: top">
                        </div>
                        <div class="speaker-name">Martins Motivans</div>
                        <div class="speaker-position">CEO<br>LAMOD</div>
                        <div class="speaker-social">
                            <a href="https://www.linkedin.com/in/martins-motivans-75b15724/" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
                            <a href="https://www.lamod.eu/" target="_blank" rel="noopener noreferrer"><i class="fas fa-globe"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
        
        <div class="hero-buttons">
            <a href="{{ route('client.store') }}" class="btn-ticket">
                <i class="fas fa-ticket-alt"></i>
                Get Ticket
            </a>
            <a href="#" class="btn-trailer" id="watchTrailerBtn">
                <i class="fas fa-play-circle"></i>
                Watch Trailer
            </a>
        </div>
    </div>
    <!-- Add this inside the .hero-section div, after .hero-content -->
    <div class="hero-social-floating">
        <a href="https://www.facebook.com/cidbibsofficial/?locale=ms_MY" class="hero-social-icon" aria-label="Facebook" target="_blank" rel="noopener">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://www.linkedin.com/company/cidbibsofficial/posts/?feedView=all" class="hero-social-icon" aria-label="LinkedIn" target="_blank" rel="noopener">
            <i class="fab fa-linkedin-in"></i>
        </a>
    </div>
</div>

<!-- Video Modal -->
<div class="video-modal" id="videoModal">
    <div class="video-modal-content">
        <span class="video-modal-close" id="closeModal">
            <i class="fas fa-times"></i>
        </span>
        <iframe 
            id="trailerVideo"
            src="https://www.youtube.com/embed/vOYaOb8QgWc?si=idCCvUAfBm4iMwVg"
            width="100%" height="480"
            allow="autoplay"
            allowfullscreen
            style="border:0; border-radius:5px;"
        ></iframe>
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
                    <p class="intro-subtitle">Introduction About</p>
                    <h2 class="intro-title">BINA 2025</h2>
                    <p class="intro-description">
                        BINA 2025 will showcase breakthrough solutions, foster high-impact discussions, and shape the next era of construction. Join us in celebrating five years of innovation—here industry meets transformation!
                    </p>
                    
                    <!-- Feature Blocks -->
                    <div class="intro-features">
                        <div class="intro-feature-block">
                            <div class="intro-feature-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="intro-feature-content">
                                <h4 class="intro-feature-title">SARAWAK LEADS: THE FUTURE OF SUSTAINABLE FACILITY MANAGEMENT STARTS HERE</h4>
                                <p class="intro-feature-text">
                                    Join us at SARAWAK FME DAY 2025 for an extraordinary gathering of industry pioneers. Experience a day filled with 
                                    knowledge sharing, networking opportunities, and discover innovative approaches to sustainable facility management 
                                    in East Malaysia's premier event.
                                </p>
                            </div>
                        </div>

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
                        <a href="{{ route('client.about') }}" class="btn-read-more">
                            <span>Read More</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Counters Section -->
<div class="counters-section">
    <div class="container">
        <div class="counters-container">
            <div class="counter-card">
                <div class="counter-number">16<span class="plus">+</span></div>
                <div class="counter-label">Our Speaker</div>
            </div>
            <div class="counter-card">
                <div class="counter-number">3<span class="plus">+</span></div>
                <div class="counter-label">Our Session</div>
            </div>
            <div class="counter-card">
                <div class="counter-number">20<span class="plus">+</span></div>
                <div class="counter-label">Our Sponsors</div>
            </div>
        </div>
    </div>
</div>

<!-- Event Detail Section -->
<div class="event-detail-section">
    <div class="container">
        <div class="event-section-header">
            <h2 class="event-section-title">OUR EVENTS</h2>
            <p class="event-section-subtitle">THIS YEAR WE BRINGS YOU INDUSTRY LEADERS, INNOVATORS AND DECISION-MAKERS AT THE PREMIER EVENT OF THE YEAR!</p>
        </div>
        <div class="event-detail-card" style="display: flex; align-items: stretch;">
            <div class="event-image-container">
                <img src="{{ asset('images/gallery-8.jpg') }}" alt="Sarawak FME Day 2025">
            </div>
            <div class="event-content-container">
                <div class="event-meta">
                    <div class="event-meta-item location">
                        <i class="fas fa-map-marker-alt" style="color: #11749e;"></i>
                        <span>Raia Hotel, Kuching, Sarawak</span>
                    </div>
                    <div class="event-meta-item date">
                        <i class="fas fa-calendar-alt" style="color: #11749e;"></i>
                        <span>04 Sept 2025</span>
                    </div>
                    <div class="event-meta-item time">
                        <i class="fas fa-clock" style="color: #11749e;"></i>
                        <span>08:00 AM - 05:00 PM</span>
                    </div>
                </div>
                <h3 class="event-detail-title">SARAWAK LEADS: THE FUTURE OF SUSTAINABLE FACILITY MANAGEMENT STARTS HERE</h3>
                <p class="event-detail-description">
                    Be part of something extraordinary at SARAWAK FME DAY 2025, where innovation meets excellence in Facility Management Industry. Join us for a day of knowledge sharing, networking, and exploring the future of sustainable facility management.
                </p>
                <p class="event-detail-description">
                    by FACILITY MANAGEMENT INDUSTRY ENGAGEMENT DAY 2025
                </p>
                <div class="event-buttons">
                    <a href="{{ route('client.facility-industry-management') }}" class="btn-view-more" style="background:linear-gradient(90deg,#11749e 0%,#1a8fc1 100%); box-shadow: 0 4px 10px rgba(17, 116, 158, 0.3);">VIEW MORE</a>
                    <a href="{{ route('client.store') }}" class="btn-get-ticket">GET TICKET</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Duplicate the event-detail-card structure -->
    <div class="container">
        <div class="event-detail-card">
            <div class="event-image-container">
                <img src="{{ asset('images/event-home-1.jpg') }}" alt="Event Image">
            </div>
            <div class="event-content-container">
                <div class="event-meta">
                    <div class="event-meta-item location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>MITEC, Kuala Lumpur</span>
                    </div>
                    <div class="event-meta-item date">
                        <i class="fas fa-calendar-alt"></i>
                        <span>29 Oct 2025</span>
                    </div>
                    <div class="event-meta-item time">
                        <i class="fas fa-clock"></i>
                        <span>08:00 AM - 05:00 PM</span>
                    </div>
                </div>
                <h3 class="event-detail-title">TRANSFORMING ASEAN'S CONSTRUCTION LANDSCAPE</h3>
                <p class="event-detail-description">
                    As part of BINA 2025 at ICW, Facility Management Engagement Day goes beyond a traditional conference—it's a dynamic platform for industry leaders, innovators, and businesses to exchange expertise, explore best practices, and unlock new opportunities in facility management.
                </p>
                <p class="event-detail-description">
                    by FACILITY MANAGEMENT ENGAGEMENT DAY 2025
                </p>
                <div class="event-buttons">
                    <a href="{{ route('client.facility-management') }}" class="btn-view-more">VIEW MORE</a>
                    <a href="{{ route('client.store') }}" class="btn-get-ticket">GET TICKET</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Duplicate the event-detail-card structure -->
    <div class="container">
        <div class="event-detail-card">
            <div class="event-image-container">
                <img src="{{ asset('images/event-home-2.jpg') }}" alt="Another Event Image">
            </div>
            <div class="event-content-container">
                <div class="event-meta">
                    <div class="event-meta-item location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>MITEC, Kuala Lumpur</span>
                    </div>
                    <div class="event-meta-item date">
                        <i class="fas fa-calendar-alt"></i>
                        <span>30 Oct 2025</span>
                    </div>
                    <div class="event-meta-item time">
                        <i class="fas fa-clock"></i>
                        <span>08:30 AM - 05:00 PM</span>
                    </div>
                </div>
                <h3 class="event-detail-title">WHERE EXPERTISE MEETS BUSINESS GROWTH!</h3>
                <p class="event-detail-description">
                    As part of BINA Conference at ICW 2025, MODULAR ASIA is a premier forum and exhibition dedicated to advancing Modular 
                    Technology, Modern Methods of Construction (MMC), and Industrialised Building Systems (IBS).
                </p>
                <p class="event-detail-description">
                    by MODULAR ASIA FORUM & EXHIBITION
                </p>
                <div class="event-buttons">
                    <a href="{{ route('client.modular-asia') }}" class="btn-view-more">VIEW MORE</a>
                    <a href="{{ route('client.store') }}" class="btn-get-ticket">GET TICKET</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Offering Section -->
<div class="offering-section">
    <div class="container">
        <div class="offering-header">
            <h2 class="offering-title">EXPERIENCE OUR OFFERING</h2>
        </div>
        <div class="offering-cards-container">
            <div class="offering-card">
                <div class="offering-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <div class="offering-label">DELIVERING OUR INSIGHT</div>
            </div>
            <div class="offering-card">
                <div class="offering-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="offering-label">NETWORKING POTENTIAL</div>
            </div>
            <div class="offering-card">
                <div class="offering-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="offering-label">SHAPING THE DIALOGUE</div>
            </div>
        </div>
    </div>
</div>

<!-- New Why Should Attend Section -->
<div class="why-attend-section">
    <div class="container">
        <div class="why-attend-header">
            <h2 class="why-attend-title">WHY SHOULD ATTEND?</h2>
            <p class="why-attend-subtitle">THIS YEAR WE BRINGS YOU INDUSTRY LEADERS, INNOVATORS, AND DECISION-MAKERS AT THE PREMIER EVENT OF THE YEAR!</p>
        </div>
        <div class="why-attend-cards-container">
            <div class="why-attend-card">
                <h3 class="why-attend-card-title">CONSTRUCTION PROFESSIONALS</h3>
                <p class="why-attend-card-description">
                    Architects, engineers, contractors, and developers looking to stay ahead with cutting-edge technologies
                </p>
            </div>
            <div class="why-attend-card">
                <h3 class="why-attend-card-title">TECHNOLOGY PROVIDERS</h3>
                <p class="why-attend-card-description">
                    Explore innovations like modular, IBS, BIM, 3D printing, facility, maintenance and automation
                </p>
            </div>
            <div class="why-attend-card">
                <h3 class="why-attend-card-title">ARE THESE RESOURCES AVAILABLE FOR REMOTE PARTICIPATION IN EVENTS?</h3>
                <p class="why-attend-card-description">
                    Explore new innovation and opportunities in current construction technology
                </p>
            </div>
            <div class="why-attend-card">
                <h3 class="why-attend-card-title">ARE THESE RESOURCES AVAILABLE FOR REMOTE PARTICIPATION IN EVENTS?</h3>
                <p class="why-attend-card-description">
                    Learn about the economic and social impacts of advanced building technologies
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Event Highlight Section -->
<div class="event-highlight-section">
    <div class="container">
        <div class="event-highlight-header">
            <div class="event-highlight-title-container">
                <p class="event-highlight-subtitle">OUR BLOG</p>
                <h2 class="event-highlight-title">EVENT AND HIGHLIGHT</h2>
            </div>
            <a href="{{ route('client.gallery') }}" class="btn-see-more desktop-only">SEE MORE</a>
        </div>
        <div class="event-highlight-cards-container">
            <div class="event-highlight-card">
                <img src="{{ asset('images/event-hightlight-1.jpg') }}" alt="Event Highlight Image 1">
            </div>
            <div class="event-highlight-card">
                <img src="{{ asset('images/event-hightlight-2.jpg') }}" alt="Event Highlight Image 2">
            </div>
            <div class="event-highlight-card">
                <img src="{{ asset('images/event-hightlight-3.jpg') }}" alt="Event Highlight Image 3">
            </div>
            <div class="event-highlight-card">
                <img src="{{ asset('images/event-hightlight-4.jpg') }}" alt="Event Highlight Image 4">
            </div>
            <div class="event-highlight-card">
                <img src="{{ asset('images/event-hightlight-5.jpg') }}" alt="Event Highlight Image 5">
            </div>
            <div class="event-highlight-card">
                <img src="{{ asset('images/event-hightlight-6.jpg') }}" alt="Event Highlight Image 6">
            </div>
        </div>
        <div class="mobile-see-more">
            <a href="{{ route('client.gallery') }}" class="btn-see-more">SEE MORE</a>
        </div>
    </div>
</div>

<!-- New Speaker Section -->
<div class="speaker-section">
    <div class="container">
        <div class="speaker-header">
            <div class="speaker-title-container">
                <p class="speaker-subtitle">OUR SPEAKER</p>
                <h2 class="speaker-title">MEET OUR SPEAKERS</h2>
            </div>
        </div>
        
        <div class="event-speakers-container">
            <!-- Facility Management Card -->
            <div class="event-speakers-card">
                <div class="event-speakers-header">
                    <h3 class="event-speakers-title">FACILITY MANAGEMENT ENGAGEMENT DAY</h3>
                </div>
                <div class="event-speakers-grid">
                    <div class="speaker-card">
                        <div class="speaker-image-container">
                            <img src="{{ asset('images/dr-azrin-ahmad.jpg') }}" alt="Dr. Azrin Bin Ahmad">
                        </div>
                        <div class="speaker-name">Dr. Azrin Bin Ahmad</div>
                        <div class="speaker-position">Project Director<br>Maltimur Aktif Unggul Jv Sdn Bhd</div>
                        <div class="speaker-social">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modular Asia Card -->
            <div class="event-speakers-card">
                <div class="event-speakers-header">
                    <h3 class="event-speakers-title">MODULAR ASIA FORUM & EXHIBITION</h3>
                </div>
                <div class="event-speakers-grid">
                    <div class="speaker-card">
                        <div class="speaker-image-container">
                            <img src="{{ asset('images/erlend-spets.jpg') }}" alt="Erlend Spets" style="object-position: top">
                        </div>
                        <div class="speaker-name">Erlend Spets</div>
                        <div class="speaker-position">Associate Partner<br>McKinsey & Company</div>
                        <div class="speaker-social">
                            <a href="https://www.linkedin.com/in/erlend-spets-b533106a/" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="speaker-card">
                        <div class="speaker-image-container">
                            <img src="{{ asset('images/tobias-schaefer.jpg') }}" alt="Tobias Schaefer">
                        </div>
                        <div class="speaker-name">Tobias Schaefer</div>
                        <div class="speaker-position">Global Head of Prefab<br>ARDEX Group</div>
                        <div class="speaker-social">
                            <a href="https://www.linkedin.com/in/tobias1schaefer/" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="speaker-card">
                        <div class="speaker-image-container">
                            <img src="{{ asset('images/martins-motivans.jpg') }}" alt="Martins Motivans" style="object-position: top">
                        </div>
                        <div class="speaker-name">Martins Motivans</div>
                        <div class="speaker-position">CEO<br>LAMOD</div>
                        <div class="speaker-social">
                            <a href="https://www.linkedin.com/in/martins-motivans-75b15724/" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
                            <a href="https://www.lamod.eu/" target="_blank" rel="noopener noreferrer"><i class="fas fa-globe"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Location Section -->
<div class="location-section">
    <div class="container">
        <div class="location-content">
            <div class="location-text">
                <h2 class="location-title">MALAYSIA INTERNATIONAL TRADE AND EXHIBITION</h2>
                <p class="location-description">
                    The Malaysia International Trade and Exhibition Centre (MITEC) is the country's largest exhibition centre with 1 million square feet of gross exhibition space. The first component and flagship of KL Metropolis, a city within a city where trade, commerce, living and transport converge over 75.5 acres of prime land development, MITEC is poised to be the exhibition venue of choice in the Southeast Asia region. The 12,960 sqm of column-free space on level 3 providing an unobstructed and expansive view, making it the largest pillar-less exhibition hall in Malaysia. The entire combined exhibition halls are able to accommodate up to 47,700 visitors in theatre style seating and 28,300 guests in the banquet arrangement at any one time.
                </p>
            </div>
            <div class="location-map">
                <iframe
                    src="https://www.google.com/maps?q=Malaysia+International+Trade+and+Exhibition+Centre&hl=en&z=17&output=embed"
                    allowfullscreen
                    loading="lazy"
                    style="width: 100%; height: 100%; border: 0;">
                </iframe>            
            </div>
        </div>
    </div>
</div>

<!-- New Partners Section -->
<div class="partners-section">
    <div class="container">
        <div class="partners-header">
            <p class="partners-subtitle">SPONSORS & PARTNERS</p>
            <h2 class="partners-title">OUR OFFICIAL PARTNERS</h2>
        </div>
        <div class="partners-content">
            <div class="partners-text-container">
                <p class="partners-description">
                    Now, it's your turn to be part of something bigger! Join us at BINA 2025 and
                    be a driving force in shaping the future of ASEAN's construction industry.
                </p>
                <p class="partners-description">
                    Together, let's innovate, collaborate, and build a smarter, more sustainable
                    future! Partner with us. Lead the change. Construct the future!
                </p>
            </div>
            <div class="partners-logo-grid">
                <div class="partner-logo-item">
                    <img src="{{ asset('images/partners.png') }}" alt="Partner Logo">
                </div>
                <div class="partner-logo-item">
                    <img src="{{ asset('images/partners.png') }}" alt="Partner Logo">
                </div>
                <div class="partner-logo-item">
                    <img src="{{ asset('images/partners.png') }}" alt="Partner Logo">
                </div>
                <div class="partner-logo-item">
                    <img src="{{ asset('images/partners.png') }}" alt="Partner Logo">
                </div>
                <div class="partner-logo-item">
                    <img src="{{ asset('images/partners.png') }}" alt="Partner Logo">
                </div>
                <div class="partner-logo-item">
                    <img src="{{ asset('images/partners.png') }}" alt="Partner Logo">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Feedback Section -->
<div class="feedback-section">
    <div class="container">
        <div class="feedback-header">
            <p class="feedback-subtitle">Feedback</p>
            <h2 class="feedback-title">WHAT DO VISITORS SAY?</h2>
        </div>
        <div class="feedback-cards-container">
            <div class="feedback-card">
                <div class="feedback-text">"Bina 2025 was a game-changer for our team. The insights we gained were invaluable and the networking opportunities were fantastic."</div>
                <div class="feedback-avatar">
                    <img src="https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg" alt="Avatar">
                </div>
                <div class="feedback-name">Tommy Yeoh</div>
                <div class="feedback-position">Area Sales Manager (South East Asia mbk Maschinenbau GmBH)</div>
            </div>
            <div class="feedback-card">
                <div class="feedback-text">"The event exceeded all our expectations. The speakers were knowledgeable and the discussions were insightful."</div>
                <div class="feedback-avatar">
                    <img src="https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg" alt="Avatar">
                </div>
                <div class="feedback-name">Zuliza Zulkifli</div>
                <div class="feedback-position">Project Director Summercube Sdn Bhd</div>
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
            element.style.color = '#ff9800'; // Use primary-dark color
            setTimeout(() => {
                element.style.transform = 'scale(1)';
                element.style.color = '#b36b00'; // Back to primary-blue
            }, 200);
            previousValue = element.textContent;
        }
    });
    
    observer.observe(element, { childList: true, subtree: true });
});

// Video Modal Functionality
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('videoModal');
    const btn = document.getElementById('watchTrailerBtn');
    const closeBtn = document.getElementById('closeModal');
    const iframe = document.getElementById('trailerVideo');
    const body = document.body;

    function openModal() {
        modal.classList.add('active');
        body.classList.add('modal-open');
        // No autoplay for iframe, user must click play
    }

    function closeModal() {
        modal.classList.remove('active');
        body.classList.remove('modal-open');
        // Reset iframe by reloading src to stop playback
        iframe.src = iframe.src;
    }

    btn.addEventListener('click', function(e) {
        e.preventDefault();
        openModal();
    });

    closeBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Close modal when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
});
</script>
@endsection