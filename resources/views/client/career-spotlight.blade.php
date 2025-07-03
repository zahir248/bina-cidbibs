@extends('client.layouts.app')

@section('title', 'BINA | Career Spotlight @ Bina')

@push('styles')
<style>
    :root {
        --primary-blue: #2563eb;
        --primary-dark: #1e40af;
        --bg-light-gray: #f8fafc;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --mobile-vh: 100vh;
        --accent-orange: #ff5722;
        --accent-yellow: #ffd700;
        --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
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
        padding: 2rem;
        margin: 0;
        z-index: 1;
    }
    
    .hero-title-store {
        font-size: clamp(2.5rem, 8vw, 4.5rem);
        font-weight: 800;
        color: #fff;
        margin-bottom: 1.5rem;
        letter-spacing: 2px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }

    .breadcrumb-store {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        color: #fff;
        font-size: clamp(1rem, 3vw, 1.25rem);
        font-weight: 500;
        opacity: 0;
        animation: fadeIn 0.8s ease 0.4s forwards;
    }

    .breadcrumb-store a {
        color: #fff;
        text-decoration: none;
        opacity: 0.85;
        transition: var(--transition-smooth);
        position: relative;
    }

    .breadcrumb-store a::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -4px;
        left: 0;
        background-color: var(--accent-yellow);
        transition: var(--transition-smooth);
    }

    .breadcrumb-store a:hover::after {
        width: 100%;
    }

    .breadcrumb-store a:hover {
        opacity: 1;
        transform: translateY(-2px);
    }

    .key-features-section {
        padding: 6rem 2rem;
        background: linear-gradient(135deg, var(--bg-light-gray) 0%, #ffffff 100%);
        position: relative;
        overflow: hidden;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
    }

    .features-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: start;
    }

    .features-left {
        display: flex;
        flex-direction: column;
        gap: 3rem;
    }

    .section-header {
        text-align: left;
        margin-bottom: 2rem;
    }

    .header-content {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .section-header .logo-image {
        max-width: 220px;
        height: auto;
        opacity: 0;
        animation: fadeInUp 0.8s ease forwards;
    }

    .header-title {
        font-size: clamp(2rem, 5vw, 2.75rem);
        font-weight: 900;
        color: #1e293b;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.2s forwards;
    }

    .key-features-title {
        font-size: clamp(1.75rem, 4vw, 2.25rem);
        font-weight: 800;
        color: #ff9800;
        margin: 1.5rem 0 1rem;
        position: relative;
        display: inline-block;
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.2s forwards;
    }

    .key-features-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -0.75rem;
        width: 80px;
        height: 4px;
        background: var(--accent-yellow);
        border-radius: 2px;
        transform: translateX(0);
        transition: var(--transition-smooth);
    }

    .key-features-title:hover::after {
        width: 120px;
    }

    .description-content {
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.4s forwards;
        width: 100%;
        margin-bottom: 2rem;
    }

    .logos-container {
        position: relative;
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.2s forwards;
        width: 100%;
        background: transparent;
    }

    .logos-container .logo-image {
        width: 100%;
        max-width: 100%;
        height: auto;
        object-fit: contain;
        background: transparent;
    }

    .description-text {
        color: var(--text-dark);
        font-size: clamp(1rem, 2vw, 1.15rem);
        line-height: 1.8;
        margin: 0;
        text-align: justify;
    }

    .description-text strong {
        color: var(--accent-orange);
        font-weight: 700;
    }

    .features-right {
        display: grid;
        grid-template-rows: repeat(2, 1fr);
        gap: 2rem;
        height: 100%;
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.6s forwards;
    }

    .feature-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 1rem;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
        background: transparent;
    }

    .feature-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.2) 100%);
        opacity: 0;
        transition: var(--transition-smooth);
    }

    .feature-image:hover {
        transform: scale(1.03);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .feature-image:hover::after {
        opacity: 1;
    }

    @media (max-width: 1200px) {
        .features-content {
            gap: 3rem;
        }

        .logo-image {
            max-width: 350px;
        }

        .feature-image {
            height: 250px;
        }
    }

    @media (max-width: 992px) {
        .features-content {
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        .features-right {
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: none;
        }

        .section-header {
            text-align: center;
        }

        .header-content {
            align-items: center;
        }

        .section-header .logo-image {
            max-width: 200px;
        }

        .key-features-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .logos-container {
            display: flex;
            justify-content: center;
        }

        .description-text {
            text-align: justify;
            padding: 0 1rem;
        }
    }

    @media (max-width: 768px) {
        .features-right {
            grid-template-columns: 1fr;
        }

        .section-header .logo-image {
            max-width: 180px;
        }

        .header-title {
            font-size: 1.75rem;
        }

        .logo-image {
            max-width: 300px;
        }

        .description-text {
            text-align: justify;
            padding: 0;
        }
    }

    @media (max-width: 480px) {
        .key-features-section {
            padding: 3rem 1rem;
        }

        .section-header {
            margin-bottom: 2rem;
        }

        .section-header .logo-image {
            max-width: 160px;
        }

        .header-title {
            font-size: 1.5rem;
        }

        .logo-image {
            max-width: 250px;
        }

        .feature-image {
            height: 200px;
        }
    }

    /* Logo section styles */
    .logo-section {
        padding: 4rem 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .logo-content {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .logo-image {
        max-width: 400px;
        height: auto;
        opacity: 0;
        animation: fadeInUp 0.8s ease forwards;
        background: transparent;
    }

    .logo-heading {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 800;
        color: var(--text-dark);
        margin: 0;
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.2s forwards;
    }

    .logo-description {
        font-size: clamp(1rem, 2vw, 1.15rem);
        line-height: 1.8;
        color: var(--text-dark);
        max-width: 1000px;
        opacity: 0;
        animation: fadeInUp 0.8s ease 0.4s forwards;
    }

    @media (max-width: 768px) {
        .logo-section {
            padding: 3rem 1.5rem;
        }

        .logo-image {
            max-width: 300px;
            margin: 0 auto;
        }

        .logo-heading {
            text-align: center;
        }

        .logo-description {
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .logo-section {
            padding: 2rem 1rem;
        }

        .logo-image {
            max-width: 250px;
        }
    }

    .objectives-section {
        padding: 6rem 0;
        background: #f5f5f5;
        position: relative;
        overflow: hidden;
    }

    .objectives-container {
        display: grid;
        grid-template-columns: 0.8fr 1fr;
        gap: 4rem;
        align-items: start;
        position: relative;
    }

    .objectives-content {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(255, 152, 0, 0.08);
        border: 1px solid rgba(255, 152, 0, 0.1);
        max-width: 600px;
    }

    .section-title {
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 800;
        color: #ff9800;
        margin-bottom: 2.5rem;
        position: relative;
        display: inline-block;
        opacity: 0;
        animation: fadeInUp 0.8s ease forwards;
        text-transform: uppercase;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -0.75rem;
        width: 80px;
        height: 4px;
        background: var(--accent-orange);
        border-radius: 2px;
        transform: translateX(0);
        transition: var(--transition-smooth);
    }

    .section-title:hover::after {
        width: 120px;
    }

    .objectives-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .objective-item {
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        padding: 1rem;
        border-radius: 0.75rem;
        transition: var(--transition-smooth);
        border: 1px solid transparent;
    }

    .objective-item:hover {
        background: rgba(255, 152, 0, 0.03);
        border-color: rgba(255, 152, 0, 0.1);
    }

    .objective-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #ffa726 0%, #ff9800 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(255, 152, 0, 0.2);
    }

    .objective-icon svg {
        width: 30px;
        height: 30px;
        fill: white;
    }

    .objective-content {
        flex-grow: 1;
    }

    .objective-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.4rem;
        text-transform: uppercase;
    }

    .objective-description {
        font-size: 0.95rem;
        line-height: 1.5;
        color: #64748b;
    }

    .target-audiences {
        background: white;
        padding: 3rem;
        border-radius: 1rem;
        height: 100%;
        border: 1px solid rgba(255, 152, 0, 0.1);
        box-shadow: 0 4px 20px rgba(255, 152, 0, 0.08);
    }

    .target-title {
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 800;
        margin-bottom: 2.5rem;
        color: #ff9800;
        position: relative;
        display: inline-block;
        text-transform: uppercase;
    }

    .target-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -0.75rem;
        width: 80px;
        height: 4px;
        background: var(--accent-orange);
        border-radius: 2px;
        transform: translateX(0);
        transition: var(--transition-smooth);
    }

    .target-title:hover::after {
        width: 120px;
    }

    .audience-groups {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .audience-group h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-dark);
    }

    .audience-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .audience-list li {
        margin-bottom: 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: var(--text-light);
    }

    @media (max-width: 1200px) {
        .objectives-container {
            grid-template-columns: 1fr 1fr;
        }

        .objectives-content {
            max-width: none;
        }
    }

    @media (max-width: 992px) {
        .objectives-container {
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        .objectives-content {
            padding: 1.75rem;
            margin: 0 auto;
            max-width: 600px;
        }

        .section-title {
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }

        .section-title::after {
            left: 50%;
            transform: translateX(-50%);
        }
    }

    @media (max-width: 768px) {
        .objectives-section {
            padding: 4rem 0;
        }

        .objectives-content {
            padding: 1.5rem;
        }

        .objective-item {
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 1rem;
        }

        .objective-title {
            font-size: 1rem;
        }

        .objective-description {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .objectives-section {
            padding: 3rem 0;
        }

        .objectives-content {
            padding: 1.25rem;
        }

        .objective-item {
            padding: 0.875rem;
        }
    }

    /* Event Details Section styles */
    .event-details-section {
        padding: 6rem 2rem;
        background: #fff;
        position: relative;
        overflow: hidden;
    }

    .event-details-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }

    .event-info {
        text-align: left;
    }

    .event-venue {
        font-size: clamp(2.5rem, 6vw, 4rem);
        font-weight: 900;
        color: #ff9800;
        margin-bottom: 1rem;
        letter-spacing: 1px;
    }

    .venue-details {
        margin-bottom: 3rem;
    }

    .venue-location, .event-date {
        font-size: clamp(1.25rem, 3vw, 1.75rem);
        font-weight: 600;
        color: var(--text-dark);
        margin: 0.5rem 0;
    }

    .event-stats {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        background: #fff;
        padding: 1.25rem 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(255, 152, 0, 0.08);
        border: 4px solid rgba(255, 152, 0, 0.1);
        transition: var(--transition-smooth);
    }

    .stat-item:hover {
        transform: translateX(10px);
        box-shadow: 0 6px 25px rgba(255, 152, 0, 0.12);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: #ff9800;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon svg {
        width: 24px;
        height: 24px;
        fill: white;
    }

    .stat-content {
        text-align: left;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0;
    }

    .stat-label {
        font-size: 1rem;
        font-weight: 500;
        color: var(--text-light);
        margin: 0;
    }

    .event-image {
        width: 100%;
        height: 100%;
        min-height: 400px;
        position: relative;
        border-radius: 1rem;
        overflow: hidden;
    }

    .venue-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background: transparent;
    }

    @media (max-width: 992px) {
        .event-details-container {
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        .event-info {
            text-align: center;
        }

        .stat-item {
            justify-content: center;
        }

        .stat-content {
            text-align: left;
        }
    }

    @media (max-width: 768px) {
        .event-details-section {
            padding: 4rem 1.5rem;
        }

        .stat-item {
            padding: 1rem 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .event-details-section {
            padding: 3rem 1rem;
        }

        .venue-location, .event-date {
            font-size: 1.25rem;
        }

        .stat-item {
            padding: 0.875rem 1.25rem;
        }
    }

    .features-highlight-section {
        padding: 6rem 2rem;
        background: #f5f5f5;
        position: relative;
        overflow: hidden;
    }

    .features-highlight-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .features-highlight-title {
        font-size: clamp(2.5rem, 6vw, 3.5rem);
        font-weight: 900;
        color: #ff9800;
        margin-bottom: 4rem;
        text-align: center;
        position: relative;
        display: inline-block;
        left: 50%;
        transform: translateX(-50%);
    }

    .features-highlight-title::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: -15px;
        width: 80px;
        height: 4px;
        background: #ff9800;
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .features-highlight-title::before {
        content: '';
        position: absolute;
        left: 50%;
        bottom: -15px;
        width: 150px;
        height: 4px;
        background: rgba(255, 152, 0, 0.2);
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .features-list {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        padding: 0 1rem;
    }

    .feature-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 2rem 1.5rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(255, 152, 0, 0.08);
        border: 1px solid rgba(255, 152, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .feature-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: #ff9800;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .feature-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 30px rgba(255, 152, 0, 0.15);
    }

    .feature-item:hover::before {
        transform: scaleX(1);
    }

    .feature-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #ffa726 0%, #ff9800 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 20px rgba(255, 152, 0, 0.2);
        transform: rotate(-5deg);
        transition: transform 0.3s ease;
    }

    .feature-item:hover .feature-icon {
        transform: rotate(0deg) scale(1.1);
    }

    .feature-icon svg {
        width: 32px;
        height: 32px;
        fill: white;
    }

    .feature-text {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        line-height: 1.4;
    }

    @media (max-width: 1200px) {
        .features-list {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .features-highlight-section {
            padding: 4rem 1.5rem;
        }

        .features-list {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }

        .feature-item {
            padding: 1.5rem 1rem;
        }

        .feature-icon {
            width: 56px;
            height: 56px;
        }

        .feature-icon svg {
            width: 28px;
            height: 28px;
        }

        .feature-text {
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .features-highlight-section {
            padding: 3rem 1rem;
        }

        .feature-item {
            padding: 1.25rem 0.875rem;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            margin-bottom: 1.25rem;
        }

        .feature-icon svg {
            width: 24px;
            height: 24px;
        }
    }

    .website-link {
        margin-top: 4rem;
        text-align: center;
    }

    .website-button {
        display: inline-block;
        padding: 1rem 3rem;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
        text-decoration: none;
        border: 2px solid #ff9800;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .website-button:hover {
        background: #ff9800;
        color: white;
        transform: translateY(-2px);
    }

    .setup-pavillion-section {
        padding: 6rem 2rem;
        background: white;
        position: relative;
        overflow: hidden;
    }

    .setup-pavillion-container {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 4rem;
        align-items: center;
    }

    .setup-content {
        padding-right: 2rem;
    }

    .setup-title {
        font-size: clamp(2.5rem, 6vw, 3.5rem);
        font-weight: 900;
        color: #ff9800;
        margin-bottom: 2rem;
        position: relative;
        display: inline-block;
    }

    .setup-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 80px;
        height: 4px;
        background: #ff9800;
        border-radius: 2px;
    }

    .setup-title::before {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 150px;
        height: 4px;
        background: rgba(255, 152, 0, 0.2);
        border-radius: 2px;
    }

    .setup-description {
        margin-top: 2rem;
    }

    .setup-description p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
    }

    .setup-gallery {
        display: grid;
        grid-template-rows: auto auto;
        gap: 2rem;
        max-width: 600px;
        margin-left: auto;
    }

    .gallery-item {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        aspect-ratio: 16/9;
        background: transparent;
        border: none;
    }

    .layout-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    @media (max-width: 1200px) {
        .setup-pavillion-container {
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        .setup-content {
            padding-right: 0;
            text-align: center;
        }

        .setup-gallery {
            margin: 0 auto;
        }

        .setup-title::after,
        .setup-title::before {
            left: 50%;
            transform: translateX(-50%);
        }
    }

    @media (max-width: 768px) {
        .setup-pavillion-section {
            padding: 4rem 1.5rem;
        }

        .setup-description p {
            font-size: 1rem;
            text-align: left;
        }

        .setup-gallery {
            gap: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .setup-pavillion-section {
            padding: 3rem 1rem;
        }

        .setup-gallery {
            gap: 1rem;
        }
    }

    .pocket-talk-section {
        padding: 6rem 2rem;
        background: #f5f5f5;
        position: relative;
        overflow: hidden;
    }

    .pocket-talk-container {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }

    .pocket-talk-image {
        border-radius: 2rem;
        overflow: hidden;
        position: relative;
        aspect-ratio: 16/9;
    }

    .forum-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pocket-talk-content {
        padding: 2rem 0;
    }

    .pocket-talk-title {
        font-size: clamp(2.5rem, 6vw, 3.5rem);
        font-weight: 900;
        color: #ff9800;
        margin-bottom: 1rem;
        position: relative;
    }

    .title-accent {
        width: 60px;
        height: 4px;
        background: #ffd700;
        margin-bottom: 2rem;
    }

    .pocket-talk-features {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .feature-point {
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        padding: 0.75rem 0;
        position: relative;
    }

    .point-bullet {
        width: 24px;
        height: 24px;
        background: transparent;
        position: relative;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .point-bullet::before {
        content: '';
        position: absolute;
        width: 6px;
        height: 6px;
        background: #ff9800;
        clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        transform: rotate(90deg);
    }

    .point-bullet::after {
        content: '';
        position: absolute;
        width: 12px;
        height: 2px;
        background: #ff9800;
        right: 0;
    }

    .feature-point p {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #333;
        flex: 1;
    }

    @media (max-width: 992px) {
        .pocket-talk-container {
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        .pocket-talk-content {
            text-align: center;
        }

        .title-accent {
            margin: 0 auto 2rem auto;
        }

        .feature-point {
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .pocket-talk-section {
            padding: 4rem 1.5rem;
        }

        .feature-point {
            gap: 1rem;
        }

        .feature-point p {
            font-size: 0.95rem;
        }
    }

    @media (max-width: 480px) {
        .pocket-talk-section {
            padding: 3rem 1rem;
        }

        .point-bullet {
            width: 20px;
            height: 20px;
        }

        .point-bullet::before {
            width: 5px;
            height: 5px;
        }

        .point-bullet::after {
            width: 10px;
        }

        .feature-point p {
            font-size: 0.9rem;
            line-height: 1.5;
        }
    }

    /* Last Event Visual Highlights Section Styles */
    .last-event-section {
        padding: 6rem 2rem;
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .last-event-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .last-event-title {
        font-size: clamp(2.5rem, 6vw, 3.5rem);
        font-weight: 900;
        color: #ff9800;
        margin-bottom: 0.5rem;
        text-align: left;
    }

    .last-event-subtitle {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
        color: #ff9800;
        margin-bottom: 3rem;
        text-align: left;
    }

    .visual-highlights-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .grid-item {
        position: relative;
        border-radius: 1rem;
        overflow: hidden;
        aspect-ratio: 4/3;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .grid-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .highlight-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .grid-item:hover .highlight-image {
        transform: scale(1.05);
    }

    @media (max-width: 992px) {
        .visual-highlights-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .visual-highlights-grid {
            grid-template-columns: 1fr;
        }

        .last-event-section {
            padding: 4rem 1rem;
        }

        .last-event-title,
        .last-event-subtitle {
            text-align: center;
        }
    }

    /* Career Spotlight Collaboration Section */
    .collaboration-section {
        padding: 6rem 2rem;
        background: #f5f5f5;
        position: relative;
        overflow: hidden;
    }

    .collaboration-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .collaboration-header {
        margin-bottom: 3rem;
    }

    .collaboration-title {
        font-size: clamp(2.5rem, 6vw, 3.5rem);
        font-weight: 900;
        color: #ff9800;
        margin-bottom: 0.5rem;
    }

    .collaboration-subtitle {
        font-size: clamp(1.75rem, 4vw, 2.25rem);
        font-weight: 800;
        color: #ff9800;
        opacity: 0.9;
    }

    .benefits-grid {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .benefits-row {
        display: grid;
        grid-template-columns: 300px 1fr;
        min-height: 60px;
    }

    .benefits-row.header-row {
        background: #ff5722;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .benefits-col, .description-col {
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
    }

    .benefits-col {
        background: orange;
        font-weight: 700;
        color: white;
    }

    .description-col {
        background: white;
        color: #444;
        line-height: 1.6;
    }

    @media (max-width: 992px) {
        .benefits-row {
            grid-template-columns: 1fr;
        }

        .benefits-col {
            padding: 1rem;
            justify-content: center;
            text-align: center;
        }

        .description-col {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid #eee;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .collaboration-section {
            padding: 4rem 1rem;
        }

        .collaboration-header {
            text-align: center;
        }

        .benefits-col, .description-col {
            padding: 1rem;
            font-size: 0.95rem;
        }

        .description-col {
            padding: 1.25rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-height: 80px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">CAREER SPOTLIGHT</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Career Spotlight</span>
    </div>
</div>

<!-- Key Features Section -->
<div class="key-features-section">
    <div class="container">
        <div class="features-content">
            <div class="features-left">
                <div class="section-header">
                    <div class="header-content">
                        <img src="{{ asset('images/career-logo.png') }}" alt="Career Spotlight Logo" class="logo-image">
                    </div>
                    <h2 class="key-features-title">CAREER SPOTLIGHT @ BINA</h2>
                </div>
                
                <div class="description-content">
                    <p class="description-text">The <strong>BINA</strong> Construction Career Spotlight is an integral part of International Construction Week (<strong>ICW 2025</strong>), designed to bridge a gap between job seekers, academic & TVET students, and industry professionals with leading employers in the construction sector</p>
                </div>

                <div class="logos-container">
                    <img src="{{ asset('images/career-1.png') }}" alt="BINA 2025" class="logo-image">
                </div>
            </div>

            <div class="features-right">
                <img src="{{ asset('images/career-2.png') }}" alt="Career Spotlight Event" class="feature-image">
                <img src="{{ asset('images/career-3.png') }}" alt="Career Spotlight Activities" class="feature-image">
            </div>
        </div>
    </div>
</div>

<!-- Objectives Section -->
<div class="objectives-section">
    <div class="container">
        <div class="objectives-container">
            <div class="objectives-content">
                <h2 class="section-title">The Objectives</h2>
                <div class="objectives-list">
                    <div class="objective-item">
                        <div class="objective-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 4a4 4 0 0 1 4 4 4 4 0 0 1-4 4 4 4 0 0 1-4-4 4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4z"/>
                            </svg>
                        </div>
                        <div class="objective-content">
                            <h3 class="objective-title">CONNECTING CAREER SEEKERS WITH EMPLOYERS</h3>
                            <p class="objective-description">Serve as a bridge between job seekers and employers, attendees to explore various career paths in the construction industry.</p>
                        </div>
                    </div>

                    <div class="objective-item">
                        <div class="objective-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3m6.82 6L12 12.72 5.18 9 12 5.28 18.82 9M17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                            </svg>
                        </div>
                        <div class="objective-content">
                            <h3 class="objective-title">HIGHLIGHTING TVET AND PROFESSIONAL AREAS</h3>
                            <p class="objective-description">Emphasize opportunities in both TVET and professional areas within the construction sector.</p>
                        </div>
                    </div>

                    <div class="objective-item">
                        <div class="objective-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4m2.5 11.9l-.9 3.2-1.6.2-1.6-.2-.9-3.2-3.2-.9-.2-1.6.2-1.6 3.2-.9.9-3.2 1.6-.2 1.6.2.9 3.2 3.2.9.2 1.6-.2 1.6-3.2.9z"/>
                            </svg>
                        </div>
                        <div class="objective-content">
                            <h3 class="objective-title">EMPOWER CONSTRUCTION BEST PRACTICES</h3>
                            <p class="objective-description">Elevate the construction professions while promoting and empowering best practices within the construction industry.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="target-audiences">
                <h2 class="target-title">Target Audiences</h2>
                <div class="audience-groups">
                    <div class="audience-group">
                        <h3>CAREER PROVIDER :</h3>
                        <ul class="audience-list">
                            <li><b>Construction Related Industry Including :</b></li>
                            <li>Built Environment</li>
                            <li>Manufacturing</li>
                            <li>Logistics</li>
                            <li>Academians / Vocationals</li>
                            <li>Financial Institutions</li>
                            <li>Solution / Services Profivers</li>
                        </ul>
                    </div>
                    <div class="audience-group">
                        <h3>JOB SEEKER :</h3>
                        <ul class="audience-list">
                            <li>Construction Professionals & Practitioners</li>
                            <li>Technical Experts</li>
                            <li>Environmental & sustainability experts</li>
                            <li>IT and digital technology enthusiasist</li>
                            <li>Students & TVET Graduates</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event Details Section -->
<div class="event-details-section">
    <div class="container">
        <div class="event-details-container">
            <div class="event-info">
                <h2 class="event-venue">MITEC</h2>
                <div class="venue-details">
                    <p class="venue-location">Level 1, Hall 2 - Hall 3</p>
                    <p class="event-date">28 - 30 OCTOBER 2025</p>
                </div>
                <div class="event-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">17,000++</h3>
                            <p class="stat-label">VISITORS</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">500++</h3>
                            <p class="stat-label">BOOTHS</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">30++</h3>
                            <p class="stat-label">CAREER EXHIBITOR</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">200++</h3>
                            <p class="stat-label">CAREER OPENINGS</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="event-image">
                <img src="{{ asset('images/career-4.png') }}" alt="Career Event Space" class="venue-image">
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="features-highlight-section">
    <div class="features-highlight-container">
        <h2 class="features-highlight-title">FEATURES</h2>
        <div class="features-list">
            <div class="feature-item">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M21 13v10h-6v-6h-6v6h-6v-10h-3l12-12 12 12h-3zm-1-5.907v-5.093h-3v2.093l3 3z"/>
                    </svg>
                </div>
                <p class="feature-text">EXCLUSIVE CAREER PAVILLION</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9c.83 0 1.5-.67 1.5-1.5 0-.39-.15-.74-.39-1.01-.23-.26-.38-.61-.38-.99 0-.83.67-1.5 1.5-1.5h1.77c2.76 0 5-2.24 5-5 0-4.42-4.03-8-9-8zm-5.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm3-4c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm5 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm3 4c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                    </svg>
                </div>
                <p class="feature-text">INDUSTRY-INSIGHT SESSIONS</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 14H6l-2 2V4h16v12z M11.5 11h1v1h-1v-1zm3-5h-5v1h5V6z M13 8H8v1h5V8z M16 8h-2v1h2V8z"/>
                    </svg>
                </div>
                <p class="feature-text">ON-THE-SPOT INTERVIEWS</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                </div>
                <p class="feature-text">NETWORKING OPPORTUNITIES</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                </div>
                <p class="feature-text">RESUME DROP-OFF POINTS</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3m6.82 6L12 12.72 5.18 9 12 5.28 18.82 9M17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                    </svg>
                </div>
                <p class="feature-text">TVET SHOWCASE ZONE</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z M11.5 11h1v1h-1v-1zm3-5h-5v1h5V6z M13 8H8v1h5V8z M16 8h-2v1h2V8z"/>
                    </svg>
                </div>
                <p class="feature-text">CAREER TALK</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M15 7.5V2H9v5.5l3 3 3-3zM7.5 9H2v6h5.5l3-3-3-3zM9 16.5V22h6v-5.5l-3-3-3 3zM16.5 9l-3 3 3 3H22V9h-5.5z"/>
                    </svg>
                </div>
                <p class="feature-text">INTERACTIVE ZONE</p>
            </div>
        </div>
    </div>
</div>

<!-- Setting-up Pavillion Section -->
<div class="setup-pavillion-section">
    <div class="container">
        <div class="setup-pavillion-container">
            <div class="setup-content">
                <h2 class="setup-title">SETTING-UP PAVILLION</h2>
                <div class="setup-description">
                    <p>The provided layout showcases the planned arrangement of booths and spaces for the Career Spotlight at Buildexpo 2024. The design emphasizes efficient space utilization and an engaging flow for attendees.</p>
                    <p>The layout illustrates the planned arrangement for the Career Spotlight zone at Buildexpo 2024. It is designed to balance exhibitor engagement, attendee navigation, and interactive activities, ensuring an engaging experience for all participants.</p>
                </div>
            </div>
            <div class="setup-gallery">
                <div class="gallery-item perspective-view">
                    <img src="{{ asset('images/career-5.png') }}" alt="3D Layout View" class="layout-image">
                </div>
                <div class="gallery-item top-view">
                    <img src="{{ asset('images/career-6.png') }}" alt="Top Layout View" class="layout-image">
                </div>
                <div class="gallery-item top-view">
                    <img src="{{ asset('images/career-7.png') }}" alt="Top Layout View" class="layout-image">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pocket Talk Section -->
<div class="pocket-talk-section">
    <div class="container">
        <div class="pocket-talk-container">
            <div class="pocket-talk-image">
                <img src="{{ asset('images/career-8.png') }}" alt="Open Forum Discussion" class="forum-image">
            </div>
            <div class="pocket-talk-content">
                <h2 class="pocket-talk-title">POCKET TALK</h2>
                <div class="title-accent"></div>
                <div class="pocket-talk-features">
                    <div class="feature-point">
                        <div class="point-bullet"></div>
                        <p>Conduct talk sharing initiatives, subsidies, and discussing topics on career development</p>
                    </div>
                    <div class="feature-point">
                        <div class="point-bullet"></div>
                        <p>An interactive forum for attendees to engage in short, dynamic discussions with industry experts.</p>
                    </div>
                    <div class="feature-point">
                        <div class="point-bullet"></div>
                        <p>This session provides a platform to share ideas, ask questions, and gain insights into topics
                        ranging from emerging trends and technologies to best practices in construction.</p>
                    </div>
                    <div class="feature-point">
                        <div class="point-bullet"></div>
                        <p>Pocket Talks are designed to be informal yet impactful, fostering open dialogue and knowledge
                        exchange.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Last Event Visual Highlights Section -->
<div class="last-event-section">
    <div class="container">
        <div class="last-event-container">
            <h2 class="last-event-title">LAST EVENT</h2>
            <h3 class="last-event-subtitle">VISUAL HIGHLIGHTS</h3>
            <div class="visual-highlights-grid">
                <div class="grid-item">
                    <img src="{{ asset('images/career-9.png') }}" alt="IJM Industry Booth" class="highlight-image">
                </div>
                <div class="grid-item">
                    <img src="{{ asset('images/career-10.png') }}" alt="Interview Session" class="highlight-image">
                </div>
                <div class="grid-item">
                    <img src="{{ asset('images/career-11.png') }}" alt="Interactive Activities" class="highlight-image">
                </div>
                <div class="grid-item">
                    <img src="{{ asset('images/career-12.png') }}" alt="Career Discussion" class="highlight-image">
                </div>
                <div class="grid-item">
                    <img src="{{ asset('images/career-13.png') }}" alt="Exhibition Overview" class="highlight-image">
                </div>
                <div class="grid-item">
                    <img src="{{ asset('images/career-14.png') }}" alt="Career Activities" class="highlight-image">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Career Spotlight Collaboration Section -->
<div class="collaboration-section">
    <div class="container">
        <div class="collaboration-container">
            <div class="collaboration-header">
                <h2 class="collaboration-title">Career Spotlight</h2>
                <h3 class="collaboration-subtitle">Collaboration Contribution & Benefits</h3>
            </div>
            <div class="benefits-grid">
                <div class="benefits-row header-row">
                    <div class="benefits-col">Benefits</div>
                    <div class="description-col">Description</div>
                </div>
                <div class="benefits-row">
                    <div class="benefits-col">LOGO PLACING</div>
                    <div class="description-col">Perkeso and/or MyFuture Jobs logo shall be featured with "BINA Construction Career Spotlight" logo to upscale impact and benefit from strategic branding opportunitie</div>
                </div>
                <div class="benefits-row">
                    <div class="benefits-col">LOGO APPEARANCES</div>
                    <div class="description-col">Logo appearance in the career pavilion, marketing collaterals, social media posting, email newsletter and websites</div>
                </div>
                <div class="benefits-row">
                    <div class="benefits-col">CAREER PAVILION</div>
                    <div class="description-col">216 sqm shared pavilion</div>
                </div>
                <div class="benefits-row">
                    <div class="benefits-col">CAREER PROVIDERS</div>
                    <div class="description-col">25++ career providers shall be invited for job offering (1 career provider shall provide > 8 openings)</div>
                </div>
                <div class="benefits-row">
                    <div class="benefits-col">COLLABORATIVE COUNTER</div>
                    <div class="description-col">1-shared counter</div>
                </div>
                <div class="benefits-row">
                    <div class="benefits-col">HONOURABLE MENTION</div>
                    <div class="description-col">Exclusive mention of the collaboration in the opening ceremony by Prime Minister during Opening Ceremony</div>
                </div>
                <div class="benefits-row">
                    <div class="benefits-col">CAREER TALK</div>
                    <div class="description-col">Conduct talk sharing initiatives, subsidies, and discussing topics on career development</div>
                </div>
                <div class="benefits-row">
                    <div class="benefits-col">EVENT REPORT</div>
                    <div class="description-col">An in-depth analysis of the event, featuring details in attendees, statistics and feedback through a detailed survey</div>
                </div>
                <div class="benefits-row">
                    <div class="benefits-col">CONTRIBUTION</div>
                    <div class="description-col">RM50,000</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const heroSection = document.querySelector('.hero-section-store');
        const scrolled = window.pageYOffset;
        heroSection.style.backgroundPositionY = -(scrolled * 0.5) + 'px';
    });

    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('.logo-image, .description-content').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        observer.observe(el);
    });
});
</script>
@endpush

@endsection