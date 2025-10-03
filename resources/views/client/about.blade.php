@extends('client.layouts.app')

@section('title', 'BINA | About')

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

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
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

    .about-bg {
        background: #f8fafc;
        width: 100%;
        min-height: 100px;
        position: relative;
    }

    .about-section {
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

    .about-section:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .about-section h2 {
        font-size: 1.4rem;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        color: #2563eb;
        opacity: 0;
        animation: fadeIn 0.8s ease forwards;
    }

    .about-section p {
        font-size: 1.08rem;
        color: #333;
        margin-bottom: 1.2rem;
        line-height: 1.7;
        opacity: 0;
        animation: fadeIn 0.8s ease forwards 0.4s;
    }

    .about-logo-header-wrap {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 1.2rem;
        max-width: 300px;
        opacity: 0;
        animation: fadeInUp 0.8s ease forwards 0.2s;
    }

    .about-logo-img {
        width: 100%;
        max-width: 200px;
        height: auto;
        display: block;
        margin-bottom: 2.0rem;
        transition: transform 0.3s ease;
    }

    .about-logo-img:hover {
        transform: scale(1.05);
    }

    .about-header-text {
        font-size: 2rem;
        font-weight: 800;
        color: #22223b;
        margin-bottom: 1.2rem;
        letter-spacing: 1px;
        line-height: 1.1;
        text-align: left;
        width: 100%;
        max-width: 300px;
    }

    /* Summary Section */
    .summary-section {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }

    .summary-divider {
        width: 100px;
        height: 2px;
        background: linear-gradient(90deg, #ff9800 0%, #ff5e62 100%);
        margin: 0 auto 1.5rem auto;
        border-radius: 2px;
        opacity: 0;
        animation: fadeIn 0.8s ease 0.4s forwards;
    }

    .summary-card {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .summary-card:nth-child(1) { animation: fadeInUp 0.5s ease 0.2s forwards; }
    .summary-card:nth-child(2) { animation: fadeInUp 0.5s ease 0.4s forwards; }

    /* Showcase Section */
    .showcase-section {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }

    .showcase-card {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .showcase-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .showcase-card:nth-child(1) { animation: fadeInUp 0.5s ease 0.2s forwards; }
    .showcase-card:nth-child(2) { animation: fadeInUp 0.5s ease 0.4s forwards; }
    .showcase-card:nth-child(3) { animation: fadeInUp 0.5s ease 0.6s forwards; }

    /* Modular Asia Section */
    .modular-asia-section {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }

    .modular-asia-left {
        opacity: 0;
        animation: slideInLeft 0.8s ease 0.4s forwards;
    }

    .modular-asia-right {
        opacity: 0;
        animation: slideInRight 0.8s ease 0.4s forwards;
    }

    .modular-asia-img-wrap {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease 0.6s forwards;
    }

    /* Facility Management Section */
    .facility-mgmt-section {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }

    /* Event Gallery Section */
    .event-gallery-section img {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }

    /* Audiences Section */
    .audiences-section {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }

    .audience-block {
        opacity: 0;
        transform: translateY(20px);
    }

    .audience-block:nth-child(1) { animation: fadeInUp 0.5s ease 0.2s forwards; }
    .audience-block:nth-child(2) { animation: fadeInUp 0.5s ease 0.4s forwards; }
    .audience-block:nth-child(3) { animation: fadeInUp 0.5s ease 0.6s forwards; }

    /* Unveil Section */
    .unveil-card {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .unveil-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(255,152,0,0.2);
    }

    .unveil-card:nth-child(1) { animation: fadeInUp 0.5s ease 0.2s forwards; }
    .unveil-card:nth-child(2) { animation: fadeInUp 0.5s ease 0.4s forwards; }
    .unveil-card:nth-child(3) { animation: fadeInUp 0.5s ease 0.6s forwards; }

    /* Sponsorship Section */
    .sponsor-logo {
        opacity: 0;
        animation: fadeIn 0.8s ease forwards;
    }

    /* CPD Section */
    .cpd-card {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .cpd-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(255,152,0,0.2);
    }

    .cpd-card:nth-child(1) { animation: fadeInUp 0.5s ease 0.2s forwards; }
    .cpd-card:nth-child(2) { animation: fadeInUp 0.5s ease 0.4s forwards; }
    .cpd-card:nth-child(3) { animation: fadeInUp 0.5s ease 0.6s forwards; }
    .cpd-card:nth-child(4) { animation: fadeInUp 0.5s ease 0.8s forwards; }
    .cpd-card:nth-child(5) { animation: fadeInUp 0.5s ease 1.0s forwards; }
    .cpd-card:nth-child(6) { animation: fadeInUp 0.5s ease 1.2s forwards; }

    /* Speakers Section */
    .speaker-card {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .speaker-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(255,152,0,0.2);
    }

    .speaker-card:nth-child(1) { animation: fadeInUp 0.5s ease 0.2s forwards; }
    .speaker-card:nth-child(2) { animation: fadeInUp 0.5s ease 0.4s forwards; }
    .speaker-card:nth-child(3) { animation: fadeInUp 0.5s ease 0.6s forwards; }
    .speaker-card:nth-child(4) { animation: fadeInUp 0.5s ease 0.8s forwards; }
    .speaker-card:nth-child(5) { animation: fadeInUp 0.5s ease 1.0s forwards; }
    .speaker-card:nth-child(6) { animation: fadeInUp 0.5s ease 1.2s forwards; }

    /* Keep existing responsive styles */
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
    .about-bg {
        background: #f8fafc;
        width: 100%;
        min-height: 100px;
    }
    .about-section {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 2.5rem 2rem;
        margin: 3rem auto 2rem auto;
        max-width: 900px;
        position: relative;
        z-index: 2;
    }
    .about-section h2 {
        font-size: 1.4rem;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        color: #2563eb;
    }
    .about-section p {
        font-size: 1.08rem;
        color: #333;
        margin-bottom: 1.2rem;
        line-height: 1.7;
    }
    .about-logo-header-wrap {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 1.2rem;
        max-width: 300px;
    }
    .about-logo-img {
        width: 100%;
        max-width: 200px;
        height: auto;
        display: block;
        margin-bottom: 2.0rem;
    }
    .about-header-text {
        font-size:2rem;
        font-weight:800;
        color:#22223b;
        margin-bottom:1.2rem;
        letter-spacing:1px;
        line-height:1.1;
        text-align:left;
        width: 100%;
        max-width: 300px;
    }
    /* Add summary section styles */
    .summary-section {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 2.5rem 2rem 2rem 2rem;
        margin: 3rem auto 2rem auto;
        max-width: 1100px;
        position: relative;
        z-index: 2;
    }
    .summary-title {
        font-size: 2rem;
        font-weight: 800;
        color: #181818;
        text-align: center;
        margin-bottom: 2.2rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .summary-title span {
        display: block;
        font-size: 1.25rem;
        font-weight: 700;
        margin-top: 0.5rem;
        text-transform: none;
    }
    .summary-divider {
        width: 100px;
        height: 2px;
        background: linear-gradient(90deg, #ff9800 0%, #ff5e62 100%);
        margin: 0 auto 1.5rem auto;
        border-radius: 2px;
    }
    .summary-cards-row {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
    .summary-card {
        background: #f5f5f7;
        border-radius: 1rem;
        padding: 1.5rem 1.5rem 1.2rem 1.5rem;
        flex: 1 1 320px;
        min-width: 280px;
        max-width: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .summary-card img {
        max-height: 48px;
        margin-bottom: 0.7rem;
    }
    .summary-card .summary-card-title {
        font-size: 1.15rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
        text-align: center;
    }
    .summary-card .summary-card-title.modular {
        color: #ff9800;
    }
    .summary-card .summary-card-title.facility {
        color: #1cc7b6;
    }
    .summary-card .summary-card-desc {
        font-size: 1.05rem;
        color: #22223b;
        text-align: center;
        margin-bottom: 0;
    }
    @media (max-width: 991px) {
        .summary-cards-row {
            flex-direction: column;
            gap: 1.5rem;
        }
        .summary-card {
            max-width: 100%;
        }
    }
    /* Three Key Showcase section styles */
    .showcase-section {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 2.5rem 2rem 2rem 2rem;
        margin: 3rem auto 2rem auto;
        max-width: 1100px;
        position: relative;
        z-index: 2;
    }
    .showcase-title {
        font-size: 2rem;
        font-weight: 800;
        color: #181818;
        text-align: center;
        margin-bottom: 2.2rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .showcase-cards-row {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
    .showcase-card {
        background: #f5f5f7;
        border-radius: 1rem;
        padding: 1.5rem 1.5rem 1.2rem 1.5rem;
        flex: 1 1 320px;
        min-width: 280px;
        max-width: 370px;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .showcase-card img {
        max-height: 48px;
        margin-bottom: 0.7rem;
        background: #ededed;
        border-radius: 0.7rem;
        padding: 0.5rem 1.2rem;
    }
    .showcase-card .showcase-card-desc {
        font-size: 1.05rem;
        color: #22223b;
        text-align: center;
        margin-bottom: 0;
    }
    @media (max-width: 991px) {
        .showcase-cards-row {
            flex-direction: column;
            gap: 1.5rem;
        }
        .showcase-card {
            max-width: 100%;
        }
    }
    /* Modular Asia section styles */
    .modular-asia-section {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        padding: 2.5rem 2rem 2rem 2rem;
        margin: 3rem auto 2rem auto;
        max-width: 1100px;
        position: relative;
        z-index: 2;
    }
    .modular-asia-row {
        display: flex;
        flex-wrap: wrap;
        gap: 2.5rem;
        align-items: flex-start;
        margin-bottom: 2.5rem;
    }
    .modular-asia-left {
        flex: 1 1 340px;
        min-width: 260px;
        max-width: 420px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .modular-asia-logo {
        max-width: 260px;
        margin-bottom: 1.2rem;
    }
    .modular-asia-heading {
        font-size: 2.1rem;
        font-weight: 800;
        color: #181818;
        margin-bottom: 0.7rem;
        line-height: 1.1;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .modular-asia-right {
        flex: 2 1 400px;
        min-width: 260px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }
    .modular-asia-right p {
        font-size: 1.08rem;
        color: #333;
        margin-bottom: 1.1rem;
        line-height: 1.7;
    }
    .modular-asia-images-row {
        display: flex;
        gap: 2rem;
        width: 100%;
        margin-top: 1.5rem;
    }
    .modular-asia-img-wrap {
        flex: 1 1 0;
        position: relative;
    }
    .modular-asia-img-wrap img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        border-radius: 1.2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    .modular-asia-img-main {
        border-radius: 1.2rem;
        max-width: 520px;
        width: 100%;
        height: 320px;
        object-fit: cover;
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        position: relative;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    .modular-asia-img-main:hover {
        transform: translateY(-5px);
    }
    .modular-asia-img-secondary {
        border-radius: 1.2rem;
        max-width: 280px;
        width: 100%;
        height: 320px;
        object-fit: cover;
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        transition: transform 0.3s ease;
    }
    .modular-asia-img-secondary:hover {
        transform: translateY(-5px);
    }
    .modular-asia-play-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255, 152, 0, 0.9);
        color: #fff;
        border-radius: 50%;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        z-index: 2;
        transition: all 0.3s ease;
    }
    .modular-asia-img-main:hover .modular-asia-play-btn {
        background: rgba(255, 152, 0, 1);
        transform: translate(-50%, -50%) scale(1.1);
    }
    @media (max-width: 991px) {
        .modular-asia-row, .modular-asia-images-row {
            flex-direction: column;
            gap: 1.5rem;
            align-items: stretch;
        }
        .modular-asia-left, .modular-asia-right {
            max-width: 100%;
        }
        .modular-asia-img-main, .modular-asia-img-secondary {
            max-width: 100%;
            height: 280px;
        }
        .modular-asia-img-wrap img {
            height: 180px;
        }
    }
    .event-gallery-section {
        max-width: 1100px;
        margin: 3rem auto 2rem auto;
    }
    .event-gallery-section img {
        height: 420px;
        object-fit: cover;
        border-radius: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.10);
    }
    @media (max-width: 991px) {
        .event-gallery-section img {
            height: 240px !important;
            max-width: 100% !important;
        }
    }
    .audiences-section {
        max-width: 1100px;
        margin: 4.5rem auto 4.5rem auto;
        background: #f5f6fa;
        border-radius: 1.2rem;
        padding: 3rem 2rem;
    }
    .audiences-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 900;
        color: #0a102f;
        letter-spacing: 1px;
        margin-bottom: 2.5rem;
    }
    .audience-heading {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0a102f;
        text-transform: uppercase;
        margin-bottom: 0.7rem;
        letter-spacing: 0.5px;
    }
    .audience-desc {
        display: flex;
        align-items: flex-start;
        font-size: 1.08rem;
        color: #22223b;
        line-height: 1.6;
        font-weight: 400;
    }
    .audience-bar {
        display: inline-block;
        width: 6px;
        height: 1.5em;
        background: #ff9800;
        border-radius: 2px;
        margin-right: 0.7em;
        margin-top: 0.15em;
        flex-shrink: 0;
    }
    @media (max-width: 991px) {
        .audiences-section {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .audiences-title {
            font-size: 2rem;
        }
        .audience-heading {
            font-size: 1.1rem;
        }
        .audience-desc {
            font-size: 1rem;
        }
    }
    .unveil-section {
        background: linear-gradient(180deg,#fff 60%,#f7f6fb 100%);
        padding: 3.5rem 0 2.5rem 0;
    }
    .unveil-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 900;
        color: #0a102f;
        letter-spacing: 1px;
        margin-bottom: 2.8rem;
    }
    .unveil-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        border: 2px solid #e5e7eb;
        padding: 2.2rem 1.2rem 1.5rem 1.2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 260px;
        max-width: 340px;
        width: 100%;
        transition: box-shadow 0.2s;
    }
    .unveil-card:hover {
        box-shadow: 0 6px 32px rgba(255,152,0,0.13);
        border-color: #ff9800;
    }
    .unveil-icon {
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .unveil-label {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0a102f;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    @media (max-width: 991px) {
        .unveil-title {
            font-size: 1.5rem;
        }
        .unveil-card {
            min-width: 100%;
            max-width: 100%;
            margin-bottom: 1.5rem;
        }
        .unveil-section .row {
            flex-direction: column;
            align-items: center;
        }
    }
    .sponsor-logo {
        max-width: 180px;
        width: 100%;
        height: auto;
        margin: 0 10px;
        transition: transform 0.2s;
        border-radius: 0;
    }
    .sponsor-logo:hover {
        transform: scale(1.05);
    }
    .sponsorship-title {
        text-align: center;
        font-size: 2.3rem;
        font-weight: 900;
        color: #0a102f;
        letter-spacing: 1px;
        margin-bottom: 2.2rem;
    }
    @media (max-width: 991px) {
        .sponsor-logo {
            max-width: 120px;
            margin: 0 5px;
        }
    }
    .cpd-section {
        background: #f5f6fa;
        border-radius: 1.2rem;
        padding: 3rem 2rem;
        margin-top: 4.5rem !important;
        margin-bottom: 4.5rem !important;
    }
    .cpd-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 900;
        color: #0a102f;
        letter-spacing: 1px;
        margin-bottom: 2.8rem;
    }
    .cpd-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        border: 2px solid #e5e7eb;
        padding: 2.2rem 1.2rem 1.5rem 1.2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 260px;
        max-width: 370px;
        width: 100%;
        transition: box-shadow 0.2s;
        margin-bottom: 0;
    }
    .cpd-card:hover {
        box-shadow: 0 6px 32px rgba(255,152,0,0.13);
        border-color: #ff9800;
    }
    .cpd-icon {
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cpd-label {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0a102f;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    @media (max-width: 991px) {
        .cpd-title {
            font-size: 1.5rem;
        }
        .cpd-card {
            min-width: 100%;
            max-width: 100%;
            margin-bottom: 1.5rem;
        }
        .cpd-section .row {
            flex-direction: column;
            align-items: center;
        }
    }
    .speakers-section {
        background: #fafbfc;
        padding: 3.5rem 0 2.5rem 0;
    }
    .join-btn {
        display: inline-block;
        background: #ff9800;
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 24px;
        padding: 0.6rem 1.6rem;
        margin-top: 0.5rem;
        text-decoration: none;
        letter-spacing: 1px;
        box-shadow: 0 2px 8px rgba(255,152,0,0.08);
        transition: background 0.2s;
    }
    .join-btn:hover {
        background: #ffb347;
        color: #fff;
    }
    .speaker-card {
        background: #fff;
        border-radius: 20px 20px 16px 16px/20px 20px 32px 32px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        border: 2px solid #e5e7eb;
        padding: 0 0 1.2rem 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        max-width: 270px;
        min-width: 220px;
        margin-bottom: 0;
        position: relative;
        transition: box-shadow 0.2s;
    }
    .speaker-card:hover {
        box-shadow: 0 6px 32px rgba(255,152,0,0.13);
        border-color: #ff9800;
    }
    .speaker-img {
        width: 120px;
        height: 120px;
        background: none;
        border-radius: 50%;
        margin-top: -40px;
        margin-bottom: 1.2rem;
        border: 6px solid #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .speaker-info {
        background: #fff;
        border-radius: 0 0 16px 16px/0 0 32px 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        padding: 1.2rem 1rem 0.7rem 1rem;
        width: 100%;
        text-align: center;
        position: relative;
        z-index: 2;
    }
    .speaker-name {
        font-size: 1.08rem;
        font-weight: 700;
        color: #0a102f;
        margin-bottom: 0.2rem;
    }
    .speaker-position {
        font-size: 0.98rem;
        color: #ff9800;
        font-weight: 600;
        margin-bottom: 0.7rem;
    }
    .speaker-social {
        display: flex;
        justify-content: center;
        gap: 1rem; /* Increased from 0.7rem */
        margin-top: 1.5rem; /* Increased from 1rem */
    }
    .speaker-social a {
        width: 36px; /* Increased from 32px */
        height: 36px; /* Increased from 32px */
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ff9800;
        border-radius: 50%;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(255, 152, 0, 0.2); /* Added shadow */
    }
    .speaker-social a i {
        color: white;
        font-size: 1rem; /* Adjusted icon size */
    }
    .speaker-social a:hover {
        background: #ff9800; /* Keep consistent orange */
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255, 152, 0, 0.3); /* Enhanced shadow on hover */
    }
    .speaker-position {
        font-size: 0.98rem;
        color: #ff9800;
        font-weight: 600;
        margin-bottom: 0; /* Removed margin bottom since we increased margin-top of social icons */
        line-height: 1.4; /* Added for better spacing between lines */
    }
    @media (max-width: 768px) {
        .speaker-social a {
            width: 32px;
            height: 32px;
        }
        
        .speaker-social a i {
            font-size: 0.9rem;
        }
    }
    @media (max-width: 991px) {
        .speakers-section {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .speaker-card {
            max-width: 100%;
            min-width: 100%;
            margin-bottom: 1.5rem;
        }
        .speaker-img {
            width: 90px;
            height: 90px;
            margin-top: -30px;
        }
        /* Fix for mobile horizontal scroll */
        .container {
            padding-left: 15px;
            padding-right: 15px;
            max-width: 100% !important;
            width: 100% !important;
            overflow-x: hidden;
        }
        .row {
            margin-left: -15px;
            margin-right: -15px;
        }
        [class*="col-"] {
            padding-left: 15px;
            padding-right: 15px;
        }
    }
    .summary-section,
    .showcase-section,
    .modular-asia-section,
    .facility-mgmt-section,
    .event-gallery-section,
    .audiences-section,
    .unveil-section,
    .sponsorship-section,
    .cpd-section,
    .speakers-section {
        margin-top: 4.5rem !important;
        margin-bottom: 4.5rem !important;
    }

    /* Enhanced Mobile Responsiveness */
    @media (max-width: 768px) {
        .hero-title-store {
            font-size: clamp(1.8rem, 6vw, 2.5rem);
            padding: 0 1rem;
        }

        .breadcrumb-store {
            font-size: clamp(0.9rem, 2.5vw, 1.1rem);
            padding: 0 1rem;
        }

        .about-section {
            padding: 2rem 1.5rem;
            margin: 2rem 1rem;
        }

        .about-logo-header-wrap {
            align-items: center;
            text-align: center;
            margin: 0 auto 1.5rem auto;
        }

        .about-header-text {
            font-size: 1.6rem;
            text-align: center;
        }

        .about-section p {
            font-size: 1rem;
            line-height: 1.6;
        }

        .summary-title, .showcase-title, .sponsorship-title, .cpd-title {
            font-size: 1.8rem;
            padding: 0 1rem;
        }

        .summary-card, .showcase-card, .unveil-card, .cpd-card {
            padding: 1.2rem 1rem;
            margin: 0 1rem 1.5rem 1rem;
        }

        .modular-asia-heading {
            font-size: 1.8rem;
            text-align: center;
            margin-top: 1rem;
        }

        .modular-asia-logo {
            margin: 0 auto 1.2rem auto;
            display: block;
        }

        .modular-asia-section {
            padding: 2rem 1.5rem;
            margin: 2rem 1rem;
        }

        .audiences-section {
            padding: 2.5rem 1.5rem;
            margin: 2rem 1rem;
        }

        .audience-heading {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .audience-desc {
            font-size: 1rem;
        }

        .speaker-card {
            margin: 0 1rem 2rem 1rem;
        }

        .speaker-img {
            width: 100px;
            height: 100px;
            margin-top: -30px;
        }

        .speaker-name {
            font-size: 1rem;
        }

        .speaker-position {
            font-size: 0.9rem;
        }

        /* Improved spacing for mobile */
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        .row {
            margin-left: -10px;
            margin-right: -10px;
        }

        [class*="col-"] {
            padding-left: 10px;
            padding-right: 10px;
        }

        /* Fix image heights on mobile */
        .modular-asia-img-main,
        .modular-asia-img-secondary,
        .modular-asia-img-wrap img {
            height: 200px !important;
        }

        /* Adjust sponsor logos for mobile */
        .sponsor-logo {
            max-width: 100px;
            margin: 0.5rem;
        }

        /* Improve button responsiveness */
        .join-btn {
            width: 100%;
            text-align: center;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
        }

        /* Fix section spacing */
        .summary-section,
        .showcase-section,
        .modular-asia-section,
        .facility-mgmt-section,
        .event-gallery-section,
        .audiences-section,
        .unveil-section,
        .sponsorship-section,
        .cpd-section,
        .speakers-section {
            margin-top: 3rem !important;
            margin-bottom: 3rem !important;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        /* Improve text readability on mobile */
        p {
            font-size: 1rem !important;
            line-height: 1.6 !important;
        }

        /* Better card layouts for mobile */
        .summary-cards-row,
        .showcase-cards-row {
            flex-direction: column;
            gap: 1rem;
        }

        .summary-card,
        .showcase-card {
            width: 100%;
            max-width: none;
        }

        /* Improve spacing between sections */
        .section-divider {
            margin: 2rem 0;
        }

        /* Better video play button size for mobile */
        .modular-asia-play-btn {
            width: 50px;
            height: 50px;
            font-size: 1.8rem;
        }
    }

    /* Additional breakpoint for very small devices */
    @media (max-width: 375px) {
        .hero-title-store {
            font-size: clamp(1.5rem, 5vw, 2rem);
        }

        .about-header-text {
            font-size: 1.4rem;
        }

        .sponsor-logo {
            max-width: 80px;
        }

        .speaker-card {
            min-width: auto;
        }
    }

    /* Improve touch targets on mobile */
    @media (hover: none) {
        .speaker-social,
        .join-btn,
        .sponsor-logo {
            min-width: 44px;
            min-height: 44px;
        }
    }

    /* Add text justification to paragraphs */
    p, .about-section p, .summary-card-desc, .showcase-card-desc, .modular-asia-right p, .audience-desc {
        text-align: justify;
        text-justify: inter-word;
        hyphens: auto;
    }

    /* Ensure justified text works well on mobile */
    @media (max-width: 768px) {
        p, .about-section p, .summary-card-desc, .showcase-card-desc, .modular-asia-right p, .audience-desc {
            text-align: justify;
            text-justify: inter-word;
            hyphens: auto;
            word-break: break-word;
        }
    }

    /* Keep certain text elements center-aligned */
    .hero-title-store,
    .breadcrumb-store,
    .summary-title,
    .showcase-title,
    .sponsorship-title,
    .cpd-title,
    .summary-card .summary-card-title,
    .speaker-name,
    .speaker-position,
    .unveil-label,
    .cpd-label {
        text-align: center !important;
    }

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
        margin-bottom: 3.5rem;  /* Increased from 2rem */
        padding-bottom: 1.5rem; /* Increased from 1rem */
        border-bottom: 2px solid #e5e7eb;
    }

    .event-speakers-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .event-speakers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        padding-top: 1rem; /* Added padding to create more space */
    }

    .speaker-image-container {
        width: 120px;
        height: 120px;
        margin: -60px auto 1.5rem; /* Adjusted margin-top from -40px to -60px and bottom margin from 1.2rem to 1.5rem */
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .speaker-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .speaker-social {
        display: flex;
        justify-content: center;
        gap: 1rem; /* Increased from 0.7rem */
        margin-top: 1.5rem; /* Increased from 1rem */
    }

    .speaker-social a {
        width: 36px; /* Increased from 32px */
        height: 36px; /* Increased from 32px */
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ff9800;
        border-radius: 50%;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(255, 152, 0, 0.2); /* Added shadow */
    }

    .speaker-social a i {
        color: white;
        font-size: 1rem; /* Adjusted icon size */
    }

    .speaker-social a:hover {
        background: #ff9800; /* Keep consistent orange */
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255, 152, 0, 0.3); /* Enhanced shadow on hover */
    }

    .speaker-position {
        font-size: 0.98rem;
        color: #ff9800;
        font-weight: 600;
        margin-bottom: 0; /* Removed margin bottom since we increased margin-top of social icons */
        line-height: 1.4; /* Added for better spacing between lines */
    }

    @media (max-width: 768px) {
        .speaker-social a {
            width: 32px;
            height: 32px;
        }
        
        .speaker-social a i {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 991px) {
        .event-speakers-grid {
            grid-template-columns: 1fr;
        }
        
        .speaker-image-container {
            width: 100px;
            height: 100px;
            margin-top: -50px; /* Adjusted from -30px */
        }
        
        .event-speakers-header {
            margin-bottom: 3rem; /* Slightly reduced for mobile */
            padding-bottom: 1.2rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection" style="overflow-x: hidden;">
    <h1 class="hero-title-store">ABOUT</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>About</span>
    </div>
</div>

<!-- Wrapper to prevent horizontal scroll -->
<div style="overflow-x: hidden; width: 100%;">

<!-- Main Content Section -->
<div style="background: #f5f5f5; width: 100%;">
    <div class="container py-5" style="max-width: 1300px;">
        <div class="row g-5 align-items-center">
        <!-- Left: Logo and About Text -->
        <div class="col-lg-7">
            <div style="display: flex; flex-direction: column; align-items: center; text-align: center; margin-bottom: 1.5rem;">
                <img src="{{ asset('images/about-bina-logo.png') }}" alt="BINA 2025 Logo" style="width: 100%; max-width: 150px; height: auto; display: block; margin-bottom: 1rem;">
                <h1 style="font-size: 2.0rem; font-weight: 800; color: #22223b; margin-bottom: 1rem; letter-spacing: 1px; line-height: 1.1;">ABOUT BINA</h1>
            </div>
            <div style="text-align: center; max-width: 800px; margin: 0 auto;">
                <div style="font-size: 1.08rem; color: #333; line-height: 1.7;">
                    <p style="margin-bottom: 1.5rem; text-align: justify; text-justify: inter-word; hyphens: auto;">Formerly known as CR4.0 Conference, BINA 2025 is a platform to introduce building technologies into the construction industry, including infrastructure, real estate and other built assets that are designed, constructed, operated and maintained. In-line with the vision of the International Construction Week (ICW) 2025, this premier event will be held on 28 – 30th October 2025 with two overarching platforms.</p>
                    <p style="margin-bottom: 1.5rem; text-align: justify; text-justify: inter-word; hyphens: auto;">As a premier platform for showcasing transformative building technologies, we aims to drive any innovation and efficiency within the IBS sector. By aligning with the government's vision, BINA 2025 aims to propel the IBS industry forward, delivering substantial economic and social impacts and establishing Malaysia as a leader in modern construction practices.</p>
                    <div style="text-align: center; margin-bottom: 0;"><b>In conjunction with International Construction Week</b></div>
                    <p style="margin-bottom: 0; text-align: justify; text-justify: inter-word; hyphens: auto;">BINA 2025 is one of the exclusive event of the ICW 2025. While ICW focuses on the overall aspect of construction industry in Malaysia, BINA 2025 will be the platform for the construction industry players especially in Industrialised Building System (IBS) to explore in person, the latest trends, developments and technologies in the construction industry</p>
                </div>
            </div>
        </div>
        <!-- Right: Image -->
        <div class="col-lg-5">
            <img src="{{ asset('images/about-1.jpg') }}" alt="About BINA" style="width: 100%; border-radius: 1.2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.12); object-fit: cover;">
        </div>
        </div>
    </div>
</div>

<!-- Summary Section -->
<div class="container" style="max-width: 1100px; margin: 4.5rem auto;">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h2 style="font-size: 2rem; font-weight: 800; color: #181818; margin-bottom: 0.5rem; text-transform: uppercase;">SUMMARY OF BINA 2025</h2>
        <p style="font-size: 1.25rem; font-weight: 700; color: #181818; margin: 0; text-align: center;">CONSTRUCTING THE FUTURE OF ASEAN</p>
    </div>

    <div style="display: flex; justify-content: center; gap: 2rem; margin-bottom: 3rem;">
        <div style="flex: 1; max-width: 400px; text-align: center;">
            <img src="{{ asset('images/modular-logo.png') }}" alt="Modular Asia Forum & Exhibition 2025 Logo" style="max-width: 100%; height: auto;">
        </div>
        <div style="flex: 1; max-width: 400px; text-align: center;">
            <img src="{{ asset('images/facility-logo.png') }}" alt="Facility Management Engagement Day 2025 Logo" style="max-width: 100%; height: auto;">
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <p style="font-size: 1.08rem; color: #22223b; line-height: 1.7; margin-bottom: 0;">
                MODULAR ASIA will serve as the premier platform advancing Modular Technology, Modern Methods of Construction (MMC), and Industrialised Building Systems (IBS), gathering global leaders to exchange best practices and showcase breakthroughs driving construction efficiency, sustainability, and scalability across ASEAN and beyond.
            </p>
        </div>
        <div class="col-lg-6">
            <p style="font-size: 1.08rem; color: #22223b; line-height: 1.7; margin-bottom: 0;">
                Facility Management Engagement Day will foster dynamic exchanges among facility managers, technology providers, and industry experts, unlocking business opportunities while exploring the latest trends and challenges in facility management.
            </p>
        </div>
    </div>
</div>

<!-- Three Key Showcase Section -->
<div style="background: #f5f5f5; padding: 4.5rem 0;">
    <div class="container" style="max-width: 1100px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <h2 style="font-size: 2rem; font-weight: 800; color: #181818; margin-bottom: 0; text-transform: uppercase;">THREE KEY SHOWCASE</h2>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Modular Thinker -->
            <div class="col-lg-4">
                <div style="text-align: center;">
                    <div style="background: #fff; display: inline-block; padding: 1rem 2rem; border-radius: 0.7rem; margin-bottom: 1.5rem;">
                        <img src="{{ asset('images/about-2.png') }}" alt="NextGen TVET Modular Thinker Logo" style="height: 48px; width: auto;">
                    </div>
                    <p style="font-size: 1.05rem; color: #22223b; line-height: 1.7; margin: 0;">
                        Modular Thinkers invites TVET students to design sustainable, affordable township developments, promoting the next generation of smart modular living.
                    </p>
                </div>
            </div>

            <!-- Career Spotlight -->
            <div class="col-lg-4">
                <div style="text-align: center;">
                    <div style="background: #fff; display: inline-block; padding: 1rem 2rem; border-radius: 0.7rem; margin-bottom: 1.5rem;">
                        <img src="{{ asset('images/about-3.png') }}" alt="Career Spotlight Logo" style="height: 48px; width: auto;">
                    </div>
                    <p style="font-size: 1.05rem; color: #22223b; line-height: 1.7; margin: 0;">
                        BINA: Career Spotlight returns for its second year, empowering talents and professionals by connecting them with top employers in the construction industry, with strong collaboration support from PERKESO.
                    </p>
                </div>
            </div>

            <!-- IBS Homes -->
            <div class="col-lg-4">
                <div style="text-align: center;">
                    <div style="background: #fff; display: inline-block; padding: 1rem 2rem; border-radius: 0.7rem; margin-bottom: 1.5rem;">
                        <img src="{{ asset('images/about-2.png') }}" alt="IBS Homes Logo" style="height: 48px; width: auto;">
                    </div>
                    <p style="font-size: 1.05rem; color: #22223b; line-height: 1.7; margin: 0;">
                        IBS Homes Powered by Modular Technology: CIDB IBS presents a bold evolution of housing solutions that are faster, smarter, and more sustainable, offering the public an immersive experience into the future of urban living.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modular Asia Section -->
<div style="background: #fff; padding: 4.5rem 0;">
    <div class="container" style="max-width: 1100px; margin: 0 auto;">
        <div class="row g-5">
            <!-- Left Column: Logo and Heading -->
            <div class="col-lg-5 d-flex flex-column align-items-center text-center">
                <img src="{{ asset('images/modular-logo.png') }}" alt="Modular Asia Forum & Exhibition 2025 Logo" style="max-width: 260px; width: 100%; height: auto; margin-bottom: 1.5rem;">
                <h2 style="font-size: 2.1rem; font-weight: 800; color: #181818; margin-bottom: 0.7rem; line-height: 1.1; letter-spacing: 0.5px; text-transform: uppercase; text-align: center;">TRANSFORMING SEN'S<br>CONSTRUCTION LANDSCAPE</h2>
            </div>

            <!-- Right Column: Description -->
            <div class="col-lg-7">
                <div style="font-size: 1.08rem; color: #333; line-height: 1.7;">
                    <p style="margin-bottom: 1.5rem;">As part of BINA Conference at ICW 2025, MODULAR ASIA is a premier forum and exhibition dedicated to advancing Modular Technology, Modern Methods of Construction (MMC), and Industrialised Building Systems (IBS).</p>
                    <p style="margin-bottom: 0;">This exclusive platform will bring together global modular leaders, innovators, and industry pioneers to share best practices, insights, and breakthroughs that are revolutionizing construction efficiency, sustainability, and scalability across SEN and Global market.</p>
                </div>
            </div>
        </div>

        <!-- Images Row -->
        <div class="row g-4 mt-4">
            <div class="col-lg-7 position-relative">
                <img src="{{ asset('images/about-4.jpg') }}" alt="Modular Asia Main" style="width: 100%; height: 320px; object-fit: cover; border-radius: 1.2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.12);">
                <a href="#" class="d-flex align-items-center justify-content-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 70px; height: 70px; background: rgba(255, 152, 0, 0.9); border-radius: 50%; text-decoration: none; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <span style="display: inline-block; margin-left: 6px;">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="14" cy="14" r="14" fill="none"/>
                            <polygon points="11,9 21,14 11,19" fill="white"/>
                        </svg>
                    </span>
                </a>
            </div>
            <div class="col-lg-5">
                <img src="{{ asset('images/about-5.jpg') }}" alt="Modular Asia Secondary" style="width: 100%; height: 320px; object-fit: cover; border-radius: 1.2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.12);">
            </div>
        </div>
    </div>
</div>

<!-- Facility Management Engagement Day Section -->
<div style="background: #f5f5f5; padding: 4.5rem 0;">
    <div class="container" style="max-width: 1100px; margin: 0 auto;">
        <!-- Top Content -->
        <div class="row align-items-center g-5 mb-5">
            <!-- Left: Description Text -->
            <div class="col-lg-6 order-lg-1 order-2">
                <div style="font-size: 1.08rem; color: #333; line-height: 1.7;">
                    <p style="margin-bottom: 1.5rem;">As part of BINA Conference at ICW 2025, MODULAR ASIA is a premier forum and exhibition dedicated to advancing Modular Technology, Modern Methods of Construction (MMC), and Industrialised Building Systems (IBS).</p>
                    <p style="margin-bottom: 0;">This exclusive platform will bring together global modular leaders, innovators, and industry pioneers to share best practices, insights, and breakthroughs that are revolutionizing construction efficiency, sustainability, and scalability across SEN and Global market.</p>
                </div>
            </div>

            <!-- Right: Logo and Heading -->
            <div class="col-lg-6 order-lg-2 order-1">
                <div style="max-width: 500px; margin: 0 auto; text-align: center;">
                    <img src="{{ asset('images/facility-logo.png') }}" alt="Facility Management Engagement Day 2025 Logo" style="max-width: 200px; width: 100%; height: auto; margin: 0 auto 1.5rem auto; display: block;">
                    <h2 style="font-size: 2.5rem; font-weight: 900; color: #0a102f; line-height: 1.2; text-transform: uppercase; letter-spacing: 0.5px; text-align: center;">
                        TRANSFORMING SEN'S<br>CONSTRUCTION<br>LANDSCAPE
                    </h2>
                </div>
            </div>
        </div>

        <!-- Gallery Images -->
        <div class="row g-4 mt-2">
            <!-- Left Image (Speaker) -->
            <div class="col-lg-6">
                <img src="{{ asset('images/about-6.jpg') }}" alt="Event Speaker" style="width: 100%; height: 420px; object-fit: cover; border-radius: 1.2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.12);">
            </div>
            <!-- Right Image (Booth with Play Button) -->
            <div class="col-lg-6 position-relative">
                <img src="{{ asset('images/about-7.jpg') }}" alt="Exhibition Booth" style="width: 100%; height: 420px; object-fit: cover; border-radius: 1.2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.12);">
                <a href="#" class="d-flex align-items-center justify-content-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 90px; height: 90px; background: rgba(255, 152, 0, 0.9); border-radius: 50%; text-decoration: none; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="22" cy="22" r="22" fill="none"/>
                        <polygon points="18,14 32,22 18,30" fill="white"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Our Audiences Section -->
<div class="container" style="max-width: 1100px; margin: 4.5rem auto;">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h2 style="font-size: 2.5rem; font-weight: 900; color: #0a102f; letter-spacing: 1px;">
             OUR AUDIENCES 
        </h2>
    </div>
    <div class="row g-5 justify-content-center">
        <!-- Content Column -->
        <div class="col-lg-10">
            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div style="margin-bottom: 3rem; text-align: center;">
                        <h3 style="font-size: 1.35rem; font-weight: 800; color: #0a102f; text-transform: uppercase; margin-bottom: 1rem; letter-spacing: 0.5px; text-align: center;">CONSTRUCTION PROFESSIONALS</h3>
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 60px; height: 3px; background: #ff9800; border-radius: 2px; margin-bottom: 1rem;"></div>
                            <p style="font-size: 1.08rem; color: #22223b; line-height: 1.6; font-weight: 400; margin: 0; text-align: center;">Architects, engineers, contractors, and developers looking to stay ahead with cutting-edge technologies.</p>
                        </div>
                    </div>
                    <div style="margin-bottom: 3rem; text-align: center;">
                        <h3 style="font-size: 1.35rem; font-weight: 800; color: #0a102f; text-transform: uppercase; margin-bottom: 1rem; letter-spacing: 0.5px; text-align: center;">REAL ESTATE DEVELOPERS</h3>
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 60px; height: 3px; background: #ff9800; border-radius: 2px; margin-bottom: 1rem;"></div>
                            <p style="font-size: 1.08rem; color: #22223b; line-height: 1.6; font-weight: 400; margin: 0; text-align: center;">Learn about the economic and social impacts of advanced building technologies</p>
                        </div>
                    </div>
                    <div style="text-align: center;">
                        <h3 style="font-size: 1.35rem; font-weight: 800; color: #0a102f; text-transform: uppercase; margin-bottom: 1rem; letter-spacing: 0.5px; text-align: center;">TECHNOLOGY PROVIDERS</h3>
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 60px; height: 3px; background: #ff9800; border-radius: 2px; margin-bottom: 1rem;"></div>
                            <p style="font-size: 1.08rem; color: #22223b; line-height: 1.6; font-weight: 400; margin: 0; text-align: center;">Showcase and explore innovations like IBS, BIM, 3D printing, and automation</p>
                        </div>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="col-md-6">
                    <div style="margin-bottom: 3rem; text-align: center;">
                        <h3 style="font-size: 1.35rem; font-weight: 800; color: #0a102f; text-transform: uppercase; margin-bottom: 1rem; letter-spacing: 0.5px; text-align: center;">INVESTORS & BUSINESS LEADERS</h3>
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 60px; height: 3px; background: #ff9800; border-radius: 2px; margin-bottom: 1rem;"></div>
                            <p style="font-size: 1.08rem; color: #22223b; line-height: 1.6; font-weight: 400; margin: 0; text-align: center;">Explore new opportunities in current construction technology</p>
                        </div>
                    </div>
                    <div style="text-align: center;">
                        <h3 style="font-size: 1.35rem; font-weight: 800; color: #0a102f; text-transform: uppercase; margin-bottom: 1rem; letter-spacing: 0.5px; text-align: center;">ACADEMICIAN</h3>
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 60px; height: 3px; background: #ff9800; border-radius: 2px; margin-bottom: 1rem;"></div>
                            <p style="font-size: 1.08rem; color: #22223b; line-height: 1.6; font-weight: 400; margin: 0; text-align: center;">Researchers, professors and students specializing in construction, engineering and related fields can gain insights into the latest technologies and connect with industry professionals</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Unveil the Extraordinary Section -->
<div class="unveil-section" style="background:#f5f5f5;padding:3.5rem 0 2.5rem 0;">
    <div class="container" style="max-width:1200px;">
        <div class="unveil-title" style="text-align:center;font-size:2.5rem;font-weight:900;color:#0a102f;letter-spacing:1px;margin-bottom:2.8rem;">
            UNVEIL THE EXTRAORDINARY AT BINA<br>2025
        </div>
        <div class="row g-4 justify-content-center">
            <!-- Card 1 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="unveil-card">
                    <div class="unveil-icon">
                        <!-- Target SVG -->
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><circle cx="24" cy="24" r="10" stroke="#fff" stroke-width="2"/><circle cx="24" cy="24" r="4" fill="#fff"/></svg>
                    </div>
                    <div class="unveil-label">DELIVERING OUR INSIGHT</div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="unveil-card">
                    <div class="unveil-icon">
                        <!-- Networking SVG -->
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><g stroke="#fff" stroke-width="2"><circle cx="16" cy="22" r="3"/><circle cx="32" cy="22" r="3"/><circle cx="24" cy="16" r="3"/><path d="M24 19v3m-5 0h10m-13 5c0-2.2 2.7-4 6-4s6 1.8 6 4"/></g></svg>
                    </div>
                    <div class="unveil-label">NETWORKING POTENTIAL</div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="unveil-card">
                    <div class="unveil-icon">
                        <!-- Dialogue SVG -->
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><g stroke="#fff" stroke-width="2"><circle cx="16" cy="22" r="3"/><circle cx="32" cy="22" r="3"/><path d="M24 28c-4 0-8-2-8-6v-2a8 8 0 0 1 16 0v2c0 4-4 6-8 6Z"/></g></svg>
                    </div>
                    <div class="unveil-label">SHAPING THE DIALOGUE</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sponsorship Section -->
<div class="sponsorship-section" style="background:#fff;padding:3rem 0 2rem 0;">
    <div class="sponsorship-title" style="text-align:center;font-size:2.3rem;font-weight:900;color:#0a102f;letter-spacing:1px;margin-bottom:2.2rem;">
        SPONSORSHIP
    </div>
    <div id="sponsorshipCarousel" class="carousel slide" data-bs-ride="carousel" style="max-width:900px;margin:0 auto;height:200px;">
        <div class="carousel-inner" style="height:100%;">
            <div class="carousel-item active" style="height:100%;">
                <div class="d-flex justify-content-center align-items-center gap-4 flex-wrap" style="height:100%;">
                    <img src="{{ asset('images/partner1.png') }}" alt="Partner 1" class="sponsor-logo">
                    <img src="{{ asset('images/partner2.png') }}" alt="Partner 2" class="sponsor-logo">
                    <img src="{{ asset('images/partner3.png') }}" alt="Partner 3" class="sponsor-logo">
                </div>
            </div>
            <div class="carousel-item" style="height:100%;">
                <div class="d-flex justify-content-center align-items-center gap-4 flex-wrap" style="height:100%;">
                    <img src="{{ asset('images/partner4.png') }}" alt="Partner 4" class="sponsor-logo">
                    <img src="{{ asset('images/partner5.png') }}" alt="Partner 5" class="sponsor-logo">
                    <img src="{{ asset('images/partner6.png') }}" alt="Partner 6" class="sponsor-logo">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CCD ND CPD Points Applied Section -->
<div class="cpd-section" style="background:#f5f5f5;padding:3.5rem 0 2.5rem 0;">
    <div class="container" style="max-width:1300px;">
        <div class="cpd-title" style="text-align:center;font-size:2.5rem;font-weight:900;color:#0a102f;letter-spacing:1px;margin-bottom:2.8rem;">
            CCD AND CPD POINTS APPLIED
        </div>
        <div class="row g-4 justify-content-center">
            <!-- Card 1 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="cpd-card">
                    <div class="cpd-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><circle cx="24" cy="24" r="10" stroke="#fff" stroke-width="2"/><circle cx="24" cy="24" r="4" fill="#fff"/></svg>
                    </div>
                    <div class="cpd-label">LEMBAGA ARKITEK MALAYSIA</div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="cpd-card">
                    <div class="cpd-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><circle cx="24" cy="24" r="10" stroke="#fff" stroke-width="2"/><circle cx="24" cy="24" r="4" fill="#fff"/></svg>
                    </div>
                    <div class="cpd-label">ROYAL INSTITUTION OF SURVEYORS MALAYSIA</div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="cpd-card">
                    <div class="cpd-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><g stroke="#fff" stroke-width="2"><rect x="14" y="18" width="20" height="12" rx="2"/><path d="M18 22h12M18 26h8"/></g></svg>
                    </div>
                    <div class="cpd-label">BOARD OF QUANTITY SURVEYORS</div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="cpd-card">
                    <div class="cpd-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><g stroke="#fff" stroke-width="2"><rect x="14" y="18" width="20" height="12" rx="2"/><path d="M18 22h12M18 26h8"/></g></svg>
                    </div>
                    <div class="cpd-label">MALAYSIA BOARD OF TECHNOLOGIES</div>
                </div>
            </div>
            <!-- Card 5 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="cpd-card">
                    <div class="cpd-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><g stroke="#fff" stroke-width="2"><circle cx="24" cy="24" r="10"/><circle cx="24" cy="24" r="4" fill="#fff"/></g></svg>
                    </div>
                    <div class="cpd-label">BOARD OF ENGINEERS MALAYSIA</div>
                </div>
            </div>
            <!-- Card 6 -->
            <div class="col-md-4 d-flex justify-content-center">
                <div class="cpd-card">
                    <div class="cpd-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect width="48" height="48" rx="12" fill="#ff9800"/><g stroke="#fff" stroke-width="2"><path d="M16 32V16h16v16"/><path d="M20 20h8v8h-8z"/></g></svg>
                    </div>
                    <div class="cpd-label">CONSTRUCTION INDUSTRY DEVELOPMENT BOARD</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Our Speakers Section -->
<div class="speakers-section" style="background:#fff;padding:3.5rem 0 2.5rem 0;">
    <div class="container" style="max-width:1300px;">
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 style="font-size: 2rem; font-weight: 800; color: #181818; margin-bottom: 0.5rem; text-transform: uppercase;">OUR SPEAKERS</h2>
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
                            <img src="{{ asset('images/majed-ghamdi.jpg') }}" alt="Eng. Majed Al Ghamdi">
                        </div>
                        <div class="speaker-name">Eng. Majed Al Ghamdi</div>
                        <div class="speaker-position">General Manager<br>Alborj Facility Management, Saudi Arabia</div>
                        <div class="speaker-social">
                        </div>
                    </div>
                    <div class="speaker-card">
                        <div class="speaker-image-container">
                            <img src="{{ asset('images/fazly-izwan.jpg') }}" alt="Fazly Izwan Bin A. Jalil">
                        </div>
                        <div class="speaker-name">Fazly Izwan Bin A. Jalil</div>
                        <div class="speaker-position">General Manager<br>Technology & Contract, Chulia Middle East, Dubai, UAE</div>
                        <div class="speaker-social">
                        </div>
                    </div>
                    <div class="speaker-card">
                        <div class="speaker-image-container">
                            <img src="{{ asset('images/en-mahput.jpg') }}" alt="En. Mahput Sairan" style="object-position: center 10%">
                        </div>
                        <div class="speaker-name">En. Mahput Sairan</div>
                        <div class="speaker-position">Pengarah Strategi & Inovasi<br>GFM Solutions Sdn. Bhd.</div>
                        <div class="speaker-social">
                        </div>
                    </div>
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
                            <img src="{{ asset('images/lee-wei-thiam.jpg') }}" alt="Ir. Lee Wei Thiam" style="object-position: center 15%">
                        </div>
                        <div class="speaker-name">Ir. Lee Wei Thiam</div>
                        <div class="speaker-position">Assistant General Manager, Marketing<br>Eastern Pretech</div>
                        <div class="speaker-social">
                        </div>
                    </div>
                    <div class="speaker-card">
                        <div class="speaker-image-container">
                            <img src="{{ asset('images/idr-rien-tan.jpg') }}" alt="Ar. Ts. IDr Rien Tan" style="object-position: center 20%">
                        </div>
                        <div class="speaker-name">Ar. Ts. IDr Rien Tan</div>
                        <div class="speaker-position">Director<br>TKCA Architects Sdn Bhd</div>
                        <div class="speaker-social">
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
                    <div class="speaker-card">
                        <div class="speaker-image-container">
                            <img src="{{ asset('images/john-woo.jpg') }}" alt="John Woo" style="object-position: center 15%">
                        </div>
                        <div class="speaker-name">John Woo</div>
                        <div class="speaker-position">Chief Technical Officer<br>Nimova Intersales (Malaysia) Sdn Bhd</div>
                        <div class="speaker-social">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
    margin-bottom: 3.5rem;  /* Increased from 2rem */
    padding-bottom: 1.5rem; /* Increased from 1rem */
    border-bottom: 2px solid #e5e7eb;
}

.event-speakers-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.event-speakers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    padding-top: 1rem; /* Added padding to create more space */
}

.speaker-image-container {
    width: 120px;
    height: 120px;
    margin: 2rem auto 1.5rem; /* Added top margin to create space from card top */
    border-radius: 50%;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.speaker-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.speaker-social {
    display: flex;
    justify-content: center;
    gap: 1rem; /* Increased from 0.7rem */
    margin-top: 1.5rem; /* Increased from 1rem */
}

.speaker-social a {
    width: 36px; /* Increased from 32px */
    height: 36px; /* Increased from 32px */
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ff9800;
    border-radius: 50%;
    transition: all 0.3s ease;
    text-decoration: none;
    box-shadow: 0 2px 6px rgba(255, 152, 0, 0.2); /* Added shadow */
}

.speaker-social a i {
    color: white;
    font-size: 1rem; /* Adjusted icon size */
}

.speaker-social a:hover {
    background: #ff9800; /* Keep consistent orange */
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(255, 152, 0, 0.3); /* Enhanced shadow on hover */
}

.speaker-position {
    font-size: 0.98rem;
    color: #ff9800;
    font-weight: 600;
    margin-bottom: 0; /* Removed margin bottom since we increased margin-top of social icons */
    line-height: 1.4; /* Added for better spacing between lines */
}

@media (max-width: 768px) {
    .speaker-social a {
        width: 32px;
        height: 32px;
    }
    
    .speaker-social a i {
        font-size: 0.9rem;
    }
}

@media (max-width: 991px) {
    .event-speakers-grid {
        grid-template-columns: 1fr;
    }
    
    .speaker-image-container {
        width: 100px;
        height: 100px;
        margin: 1.5rem auto 1.5rem; /* Added top margin for mobile too */
    }
    
    .event-speakers-header {
        margin-bottom: 3rem; /* Slightly reduced for mobile */
        padding-bottom: 1.2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const heroSection = document.querySelector('.hero-section-store');
        const scrolled = window.pageYOffset;
        heroSection.style.backgroundPositionY = -(scrolled * 0.5) + 'px';
    });

    // Initialize carousel
    var carousel = document.querySelector('#sponsorshipCarousel');
    if (carousel) {
        var bsCarousel = new bootstrap.Carousel(carousel, {
            interval: 2500,
            ride: 'carousel',
            pause: false
        });
    }

    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.summary-section, .showcase-section, .modular-asia-section, .facility-mgmt-section, .event-gallery-section, .audiences-section, .unveil-card, .cpd-card, .speaker-card').forEach(el => {
        el.style.animationPlayState = 'paused';
        observer.observe(el);
    });
});
</script>

</div> <!-- Close wrapper div -->

@endsection 