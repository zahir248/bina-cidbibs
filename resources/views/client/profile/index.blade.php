@extends('client.layouts.app')

@section('title', 'BINA | Profile')

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

    html {
        scroll-behavior: smooth;
    }

    body {
        margin: 0;
        padding: 0;
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
        background-attachment: scroll;
        text-align: center;
        position: relative;
        padding: 0 1.5rem;
        box-sizing: border-box;
        margin: 0;
        z-index: 1;
        overflow: hidden;
    }

    @supports (-webkit-touch-callout: none) {
        .hero-section-store {
            min-height: -webkit-fill-available;
            height: -webkit-fill-available;
        }
    }

    .profile-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem 1rem;
        position: relative;
        z-index: 2;
        background: #fff;
    }

    @media screen and (max-width: 992px) {
        .hero-section-store {
            min-height: 100vh;
            min-height: 100svh;
            height: 100vh;
            padding: 0 1rem;
        }
    }

    @media screen and (max-width: 768px) {
        .hero-section-store {
            min-height: 100vh;
            min-height: 100svh;
            min-height: 100dvh;
            height: 100vh;
            height: 100svh;
            height: 100dvh;
            padding: 0 1rem;
        }
        .hero-title-store {
            max-width: 90vw;
            word-wrap: break-word;
        }
    }

    @media screen and (max-width: 576px) {
        .hero-section-store {
            min-height: 100vh;
            min-height: 100svh;
            min-height: 100dvh;
            height: 100vh;
            height: 100svh;
            height: 100dvh;
            padding: 0 0.75rem;
            padding-top: env(safe-area-inset-top, 0);
            padding-bottom: env(safe-area-inset-bottom, 0);
            padding-left: max(0.75rem, env(safe-area-inset-left));
            padding-right: max(0.75rem, env(safe-area-inset-right));
        }
    }

    @media screen and (max-width: 375px) {
        .hero-section-store {
            padding: 0 0.5rem;
            min-height: 100vh;
            height: 100vh;
        }
        .hero-title-store {
            font-size: 1.75rem;
            line-height: 1.2;
        }
        .breadcrumb-store {
            font-size: 0.9rem;
        }
    }

    @media screen and (max-height: 500px) and (orientation: landscape) {
        .hero-section-store {
            min-height: 100vh;
            height: 100vh;
            padding: 1rem;
            justify-content: center;
        }
        .hero-title-store {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .breadcrumb-store {
            font-size: 1rem;
        }
    }

    @media screen and (max-width: 768px) {
        .hero-section-store {
            position: relative;
        }
        .hero-section-store.js-mobile-vh {
            height: var(--vh, 100vh);
            min-height: var(--vh, 100vh);
        }
    }

    .hero-section-store {
        margin-top: 0;
        position: relative;
        top: 0;
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
    .profile-content {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .profile-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    .profile-avatar-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto 1.5rem;
    }
    .profile-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        border: 6px solid #fff;
        overflow: hidden;
        position: relative;
    }
    .avatar-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .avatar-upload {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
        padding: 8px;
        opacity: 1;
    }
    .change-photo-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        color: white;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s ease;
        margin: 0;
        padding: 4px;
        border: none;
        background: transparent;
    }
    .change-photo-btn:hover {
        transform: scale(1.05);
        color: #0d6efd;
    }
    .change-photo-btn .bi-pencil {
        font-size: 14px;
    }
    .profile-name {
        font-size: 2rem;
        color: var(--text-dark);
        margin: 0;
        font-weight: 700;
    }
    .profile-email {
        color: var(--text-light);
        margin: 0.5rem 0;
        font-size: 1.1rem;
    }
    .profile-category {
        display: inline-block;
        padding: 0.5rem 1.5rem;
        background: #ff9800;
        color: #fff;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .section-title {
        font-size: 1.5rem;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f1f5f9;
        font-weight: 700;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: #ff9800;
        box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
    }
    .btn-save {
        background: #ff9800;
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    .btn-save:hover {
        background: #f57c00;
        transform: translateY(-1px);
    }
    .social-links {
        background-color: #f8fafc;
        padding: 1.5rem;
        border-radius: 8px;
        margin-top: 2rem;
    }
    .social-links h5 {
        color: #1e293b;
        margin-bottom: 1.5rem;
        font-size: 1rem;
        font-weight: 600;
    }
    .alert {
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    .profile-section {
        margin-bottom: 2rem;
    }
    .category-select {
        margin-bottom: 2rem;
        padding: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background-color: #f8fafc;
    }
    .category-select .form-check {
        margin-bottom: 0.75rem;
    }
    .category-select .form-check:last-child {
        margin-bottom: 0;
    }
    .category-select .form-check-input:checked {
        background-color: #ff9900 !important;
        border-color: #ff9900 !important;
    }
    .category-select .form-check-input:focus {
        border-color: #ff9900;
        box-shadow: 0 0 0 0.25rem rgba(255, 153, 0, 0.25);
    }
    .category-select .form-check-input:hover {
        cursor: pointer;
        border-color: #ff9900;
    }
    .category-select .form-check-label:hover {
        cursor: pointer;
        color: #ff9900;
    }
    .all-fields {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }
    /* Style for disabled fields */
    input:disabled {
        background-color: #f8f9fa;
        cursor: not-allowed;
        opacity: 0.7;
    }
    /* Modal Styles */
    .modal-content {
        border-radius: 15px;
        border: none;
        background: #f8f9fa;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    .modal-header {
        padding: 1.5rem 1.5rem 0.5rem;
        background: #f8f9fa;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .modal-title {
        font-weight: 600;
        color: #2c3e50;
    }
    .modal-body {
        padding: 1.5rem;
        background: #f8f9fa;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
    }
    .btn-lg {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .upload-btn {
        background: #0d6efd;
        border: none;
        font-size: 1rem;
    }
    .upload-btn:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }
    .remove-btn {
        border: 2px solid #dc3545;
        color: #dc3545;
        font-size: 1rem;
    }
    .remove-btn:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
    }
    /* Override modal backdrop */
    .modal-backdrop {
        opacity: 0.7 !important;
        background-color: #1a1a1a;
    }
    /* Make modal draggable */
    .modal-dialog {
        pointer-events: all;
    }
    .btn-close {
        opacity: 0.7;
        transition: all 0.2s ease;
    }
    .btn-close:hover {
        opacity: 1;
        transform: scale(1.1);
    }
    /* Confirmation Modal Styles */
    #removePhotoModal .modal-content {
        background: white;
    }

    #removePhotoModal .modal-body {
        background: white;
    }

    #removePhotoModal .btn {
        padding: 0.6rem 2rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    #removePhotoModal .btn:hover {
        transform: translateY(-1px);
    }

    #removePhotoModal .text-warning {
        color: #ffc107 !important;
    }

    /* Custom Deactivate Account Modal Styles */
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #bb2d3b;
        border-color: #b02a37;
        transform: translateY(-1px);
    }

    .custom-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(108, 117, 125, 0.8);
        backdrop-filter: blur(2px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-modal-container {
        width: 100%;
        max-width: 500px;
        margin: 0 1rem;
    }

    .custom-modal-content {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .custom-modal-header {
        padding: 1.5rem 1.5rem 0.5rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .custom-modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #dc3545;
        margin: 0;
    }

    .custom-modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #6c757d;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-modal-close:hover {
        background-color: #f8f9fa;
        color: #dc3545;
    }

    .custom-modal-body {
        padding: 1.5rem;
    }

    .custom-modal-warning {
        background-color: #fff3cd;
        border: 1px solid #ffecb5;
        color: #664d03;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .custom-modal-warning i {
        color: #856404;
    }

    .custom-modal-list {
        color: #6c757d;
        margin: 1rem 0;
    }

    .custom-modal-list li {
        margin-bottom: 0.5rem;
    }

    .custom-modal-footer {
        padding: 1rem 1.5rem 1.5rem;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .custom-modal-btn {
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .custom-modal-btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .custom-modal-btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-1px);
    }

    .custom-modal-btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .custom-modal-btn-danger:hover {
        background-color: #bb2d3b;
        transform: translateY(-1px);
    }

    /* Prevent scrolling when modal is open */
    body.modal-open {
        overflow: hidden;
        padding-right: 0 !important;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .custom-modal-container {
            margin: 0 0.5rem;
        }
        
        .custom-modal-footer {
            flex-direction: column;
        }
        
        .custom-modal-btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Profile Reminder Modal Styles */
    .reminder-modal .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .reminder-modal .modal-header {
        border-bottom: none;
        padding: 2rem 2rem 1rem;
        text-align: center;
        display: block;
    }

    .reminder-modal .modal-body {
        padding: 1rem 2rem;
        text-align: center;
    }

    .reminder-modal .modal-footer {
        border-top: none;
        padding: 1rem 2rem 2rem;
        justify-content: center;
        gap: 1rem;
    }

    .reminder-modal .modal-title {
        color: #1e293b;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .reminder-modal .modal-icon {
        font-size: 3rem;
        color: #ff9800;
        margin-bottom: 1rem;
    }

    .reminder-modal .modal-description {
        color: #64748b;
        font-size: 1rem;
        line-height: 1.6;
    }

    .reminder-modal .btn-complete-profile {
        background-color: #ff9800;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .reminder-modal .btn-complete-profile:hover {
        background-color: #f57c00;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
    }

    .reminder-modal .btn-remind-later {
        color: #64748b;
        background: none;
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .reminder-modal .btn-remind-later:hover {
        color: #1e293b;
    }

    .reminder-modal .benefits-list {
        text-align: left;
        margin: 1.5rem 0;
        padding-left: 1.5rem;
    }

    .reminder-modal .benefits-list li {
        color: #475569;
        margin-bottom: 0.75rem;
        position: relative;
    }

    .reminder-modal .benefits-list li:before {
        content: "•";
        color: #ff9800;
        font-weight: bold;
        position: absolute;
        left: -1.2rem;
    }

    #hero-end {
        height: 0;
        margin: 0;
        padding: 0;
    }

    /* Add new styles for tabs */
    .profile-tabs {
        margin-bottom: 2rem;
        border-bottom: none;
        background-color: #f8f9fa;
        padding: 0.5rem;
        border-radius: 12px;
        display: flex;
        gap: 0.5rem;
    }

    .profile-tabs .nav-item {
        flex: 1;
    }

    .profile-tabs .nav-link {
        color: #64748b;
        font-weight: 600;
        padding: 1rem 1.5rem;
        border: none;
        border-radius: 8px;
        margin-bottom: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        white-space: nowrap;
        width: 100%;
    }

    .profile-tabs .nav-link i {
        font-size: 1.1rem;
    }

    .profile-tabs .nav-link:hover {
        color: #ff9900;
        background-color: #fff1e0;
    }

    .profile-tabs .nav-link.active {
        color: #ff9900;
        background-color: #ffffff;
        box-shadow: 0 2px 8px rgba(255, 153, 0, 0.15);
    }

    .profile-tab-content {
        padding: 2rem;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        margin-top: 1rem;
    }

    .tab-pane {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .profile-container {
            padding: 1rem;
        }

        .profile-content {
            padding: 1rem;
        }

        .profile-header {
            padding: 1rem;
        }

        .profile-name {
            font-size: 1.5rem;
            line-height: 1.3;
        }

        .profile-email {
            font-size: 1rem;
        }

        .profile-category {
            font-size: 0.8rem;
            padding: 0.4rem 1rem;
        }

        /* Tab Navigation */
        .profile-tabs {
            display: flex;
            flex-direction: row;
            padding: 0.75rem;
            gap: 0.5rem;
            width: 100%;
            flex-wrap: nowrap;
            justify-content: space-between;
        }

        .profile-tabs .nav-item {
            flex: 1;
            width: auto;
            display: flex;
        }

        .profile-tabs .nav-link {
            border: 1px solid #e9ecef;
            background-color: #fff;
            text-align: center;
            padding: 0.75rem 0.5rem;
            font-size: 0.9rem;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            white-space: normal;
            line-height: 1.2;
            gap: 0.35rem;
        }

        .profile-tabs .nav-link i {
            font-size: 1rem;
            margin: 0;
        }

        .profile-tabs .nav-link.active {
            border-color: #ff9900;
            background-color: #fff3e0;
        }

        .profile-tabs .nav-link:hover {
            background-color: #fff3e0;
        }

        .profile-tab-content {
            width: 100%;
            padding: 1rem;
        }

        /* Form and Button Styles */
        .form-group {
            margin-bottom: 1rem;
        }

        .btn-save {
            width: 100%;
            margin-top: 1rem;
        }

        .btn-danger {
            width: 100%;
        }

        .text-end {
            text-align: center !important;
        }

        .category-select {
            padding: 0.75rem;
        }

        .info-section {
            padding: 1rem !important;
        }

        /* Modal Styles */
        .modal-dialog {
            margin: 0.5rem;
        }

        .modal-body {
            padding: 1rem;
        }

        .modal-footer {
            flex-direction: column;
            gap: 0.5rem;
        }

        .modal-footer .btn {
            width: 100%;
        }

        .profile-avatar-container {
            width: 120px;
            height: 120px;
        }

        .change-photo-btn {
            font-size: 0.8rem;
            padding: 2px;
        }

        .avatar-upload {
            padding: 4px;
        }
    }

    /* Additional adjustments for very small screens */
    @media (max-width: 480px) {
        .profile-tabs .nav-link {
            padding: 0.5rem 0.25rem;
            font-size: 0.8rem;
            gap: 0.25rem;
        }

        .profile-tabs .nav-link i {
            font-size: 0.9rem;
        }
    }

    /* Modal and backdrop improvements */
    .modal {
        background: none !important;
    }

    .modal-backdrop {
        display: none !important;
    }

    .modal-dialog {
        margin: 1.75rem auto;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    /* Photo Options Modal specific styles */
    #photoOptionsModal {
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }

    #photoOptionsModal .modal-dialog {
        max-width: 400px;
    }

    #photoOptionsModal .upload-btn {
        background: #0d6efd;
        border: none;
        transition: all 0.3s ease;
    }

    #photoOptionsModal .upload-btn:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
    }

    #photoOptionsModal .remove-btn {
        border: 2px solid #dc3545;
        color: #dc3545;
        transition: all 0.3s ease;
    }

    #photoOptionsModal .remove-btn:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
    }

    @media (max-width: 576px) {
        #photoOptionsModal .modal-dialog {
            margin: 1rem;
        }
    }

    /* Improved Modal Styles */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 1.5rem 1.5rem 0.5rem;
    }

    .modal-title {
        font-size: 1.25rem;
        color: #2c3e50;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .upload-btn {
        background: #0d6efd;
        border: none;
        padding: 1rem;
        font-weight: 600;
        font-size: 1rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .upload-btn:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    .remove-btn {
        padding: 1rem;
        font-weight: 600;
        font-size: 1rem;
        border-radius: 0.75rem;
        border: 2px solid #dc3545;
        transition: all 0.3s ease;
    }

    .remove-btn:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
    }

    .btn-close {
        opacity: 0.7;
        transition: all 0.2s ease;
    }

    .btn-close:hover {
        opacity: 1;
        transform: scale(1.1);
    }

    /* Photo Options Modal Container */
    .photo-options-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1050;
    }

    .photo-options-content {
        background: white;
        width: 90%;
        max-width: 360px;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .photo-options-header {
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f1f5f9;
    }

    .photo-options-title {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

                .photo-close-btn {
                background: none;
                border: none;
                padding: 8px;
                cursor: pointer;
                color: #94a3b8;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
                transition: all 0.2s ease;
            }

            .photo-close-btn:hover {
                background-color: #f1f5f9;
                color: #64748b;
            }

            .photo-close-btn i {
                font-size: 20px;
                font-weight: 300;
            }

    .photo-options-body {
        padding: 24px;
    }

    .photo-options-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .photo-upload-btn {
        background-color: #0ea5e9;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .photo-upload-btn:hover {
        background-color: #0284c7;
        transform: translateY(-1px);
    }

    .photo-upload-btn input {
        display: none;
    }

    .photo-remove-btn {
        background-color: white;
        color: #ef4444;
        border: 2px solid #ef4444;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .photo-remove-btn:hover {
        background-color: #ef4444;
        color: white;
        transform: translateY(-1px);
    }

    @media (max-width: 576px) {
        .photo-options-content {
            width: calc(100% - 32px);
            margin: 16px;
        }

        .photo-options-header {
            padding: 16px 20px;
        }

        .photo-options-body {
            padding: 20px;
        }

        .photo-upload-btn,
        .photo-remove-btn {
            padding: 10px 16px;
            font-size: 14px;
        }
    }

    .photo-modal-close-btn {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        margin-top: 4px;
        transition: all 0.2s ease;
    }
    .photo-modal-close-btn:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">PROFILE</h1>
    <div class="breadcrumb-store">
        <a href="{{ route('client.home') }}">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>Profile</span>
    </div>
</div>
<div id="hero-end"></div>

<div class="profile-container" id="profile-container">
    @if(session('success') && !session('show_profile_reminder'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="profile-content">
        <div class="profile-header">
            <div class="profile-avatar-container">
                <div class="profile-avatar">
                    @if(Auth::user()->avatar)
                        @php
                            $avatar = Auth::user()->avatar;
                            $isExternalUrl = filter_var($avatar, FILTER_VALIDATE_URL);
                        @endphp
                        @if($isExternalUrl)
                            <img src="{{ $avatar }}" alt="Profile Avatar" class="avatar-image" onerror="this.src='https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg';">
                        @else
                            <img src="{{ route('avatar.show', $avatar) }}" alt="Profile Avatar" class="avatar-image" onerror="this.src='https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg';">
                        @endif
                    @else
                        <img src="https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg" alt="Default Avatar" class="avatar-image">
                    @endif
                    <div class="avatar-upload">
                        <button type="button" class="change-photo-btn" data-bs-toggle="modal" data-bs-target="#photoOptionsModal">
                            <i class="bi bi-pencil me-1"></i>
                            Edit Photo
                        </button>
                    </div>
                </div>
            </div>
            <h1 class="profile-name">
                @php
                    $profile = Auth::user()->profile;
                    $fullName = trim(($profile->title ?? '') . ' ' . ($profile->first_name ?? Auth::user()->name) . ' ' . ($profile->last_name ?? ''));
                @endphp
                {{ $fullName }}
            </h1>
            <p class="profile-email">{{ Auth::user()->email }}</p>
            <span class="profile-category">{{ ucfirst($profile->category ?? 'Individual') }}</span>
        </div>

        <!-- Photo Options Modal -->
        <div class="photo-options-container" id="photoOptionsModal" style="display: none;">
            <div class="photo-options-content">
                <div class="photo-options-header">
                    <h5 class="photo-options-title">
                        Profile Photo Options
                    </h5>
                    <button type="button" class="photo-close-btn" onclick="togglePhotoModal(false)">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="photo-options-body">
                    <form id="avatarForm" action="{{ route('client.profile.update.avatar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="photo-options-buttons">
                            <label class="photo-upload-btn">
                                <i class="bi bi-cloud-upload me-2"></i>
                                Upload New Photo
                                <input type="file" 
                                       id="avatar" 
                                       name="avatar" 
                                       accept="image/*"
                                       onchange="submitPhotoForm(this)">
                            </label>
                            @if(Auth::user()->avatar)
                                <button type="button" class="photo-remove-btn" onclick="removePhoto()">
                                    <i class="bi bi-trash me-2"></i>
                                    Remove Current Photo
                                </button>
                            @endif
                            <button type="button" class="photo-modal-close-btn" onclick="togglePhotoModal(false)">
                                Close
                            </button>
                        </div>
                    </form>
                    <!-- Hidden form for removing photo -->
                    <form id="removePhotoForm" action="{{ route('client.profile.remove.avatar') }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>

        <form action="{{ route('client.profile.update') }}" method="POST">
            @csrf
            
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs profile-tabs" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="true">
                        <i class="bi bi-person me-2"></i>Personal Information
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="false">
                        <i class="bi bi-geo-alt me-2"></i>Address Information
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">
                        <i class="bi bi-share me-2"></i>Social Media Links
                    </button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content profile-tab-content" id="profileTabsContent">
                <!-- Personal Information Tab -->
                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                    <div class="profile-section">
                        <!-- Category Selection -->
                        <div class="category-select mb-4">
                            <label class="form-label fw-bold mb-3">Select your category:</label>
                            <div class="form-check">
                                <input class="form-check-input category-radio" 
                                       type="radio" 
                                       name="category" 
                                       id="category-individual" 
                                       value="individual" 
                                       {{ old('category', $profile->category ?? 'individual') == 'individual' ? 'checked' : '' }}>
                                <label class="form-check-label" for="category-individual">
                                    Individual
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input category-radio" 
                                       type="radio" 
                                       name="category" 
                                       id="category-academician" 
                                       value="academician"
                                       {{ old('category', $profile->category ?? '') == 'academician' ? 'checked' : '' }}>
                                <label class="form-check-label" for="category-academician">
                                    Academician
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input category-radio" 
                                       type="radio" 
                                       name="category" 
                                       id="category-org" 
                                       value="organization"
                                       {{ old('category', $profile->category ?? '') == 'organization' ? 'checked' : '' }}>
                                <label class="form-check-label" for="category-org">
                                    Organization
                                </label>
                            </div>
                        </div>

                        <!-- Additional Information Sections -->
                        <div class="additional-info">
                            <!-- Academician Fields -->
                            <div id="academician-fields" class="category-fields" style="display: none;">
                                <div class="info-section p-4 bg-light rounded-3 mb-4">
                                    <h5 class="mb-3">Academic Information</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="student_id" class="form-label">Student ID (optional)</label>
                                                <input type="text" 
                                                       class="form-control @error('student_id') is-invalid @enderror" 
                                                       name="student_id" 
                                                       id="student_id"
                                                       value="{{ old('student_id', $profile->student_id ?? '') }}">
                                                @error('student_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="academic_institution" class="form-label">Academic Institution (optional)</label>
                                                <input type="text" 
                                                       class="form-control @error('academic_institution') is-invalid @enderror" 
                                                       name="academic_institution" 
                                                       id="academic_institution"
                                                       value="{{ old('academic_institution', $profile->academic_institution ?? '') }}">
                                                @error('academic_institution')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Organization Fields -->
                            <div id="organization-fields" class="category-fields" style="display: none;">
                                <div class="info-section p-4 bg-light rounded-3 mb-4">
                                    <h5 class="mb-3">Organization Information</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="organization" class="form-label">Organization (optional)</label>
                                                <input type="text" 
                                                       class="form-control @error('organization') is-invalid @enderror" 
                                                       name="organization" 
                                                       id="organization"
                                                       value="{{ old('organization', $profile->organization ?? '') }}">
                                                @error('organization')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="green_card" class="form-label">Green Card Number (optional)</label>
                                                <input type="text" 
                                                       class="form-control @error('green_card') is-invalid @enderror" 
                                                       name="green_card" 
                                                       id="green_card"
                                                       value="{{ old('green_card', $profile->green_card ?? '') }}">
                                                @error('green_card')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="impact_number" class="form-label">IMPACT Certified Number (optional)</label>
                                                <input type="text" 
                                                       class="form-control @error('impact_number') is-invalid @enderror" 
                                                       name="impact_number" 
                                                       id="impact_number"
                                                       value="{{ old('impact_number', $profile->impact_number ?? '') }}">
                                                @error('impact_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Common Fields -->
                        <div class="common-fields mt-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Title</label>
                                        <select class="form-control" name="title">
                                            <option value="">Select Title</option>
                                            <option value="Mr" {{ ($profile->title ?? '') == 'Mr' ? 'selected' : '' }}>Mr.</option>
                                            <option value="Mrs" {{ ($profile->title ?? '') == 'Mrs' ? 'selected' : '' }}>Mrs.</option>
                                            <option value="Ms" {{ ($profile->title ?? '') == 'Ms' ? 'selected' : '' }}>Ms.</option>
                                            <option value="Dr" {{ ($profile->title ?? '') == 'Dr' ? 'selected' : '' }}>Dr.</option>
                                            <option value="Prof" {{ ($profile->title ?? '') == 'Prof' ? 'selected' : '' }}>Prof.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="first_name" value="{{ $profile->first_name ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" value="{{ $profile->last_name ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_title" class="form-label">Job Title (optional)</label>
                                        <input type="text" 
                                               class="form-control @error('job_title') is-invalid @enderror" 
                                               name="job_title" 
                                               id="job_title"
                                               value="{{ old('job_title', $profile->job_title ?? '') }}">
                                        @error('job_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile_number" class="form-label">Mobile Number</label>
                                        <input type="tel" 
                                               class="form-control @error('mobile_number') is-invalid @enderror" 
                                               name="mobile_number" 
                                               id="mobile_number"
                                               pattern="[0-9]*"
                                               inputmode="numeric"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                               maxlength="15"
                                               placeholder="e.g. 0123456789"
                                               value="{{ old('mobile_number', $profile->mobile_number ?? '') }}">
                                        @error('mobile_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nature_of_business" class="form-label">Nature of Business (optional)</label>
                                        <select class="form-control @error('nature_of_business') is-invalid @enderror" 
                                                name="nature_of_business" 
                                                id="nature_of_business">
                                            <option value="">Select Nature of Business</option>
                                            <option value="Manufacturing" {{ old('nature_of_business', $profile->nature_of_business ?? '') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                            <option value="Construction" {{ old('nature_of_business', $profile->nature_of_business ?? '') == 'Construction' ? 'selected' : '' }}>Construction</option>
                                            <option value="Real Estate" {{ old('nature_of_business', $profile->nature_of_business ?? '') == 'Real Estate' ? 'selected' : '' }}>Real Estate</option>
                                            <option value="Technology" {{ old('nature_of_business', $profile->nature_of_business ?? '') == 'Technology' ? 'selected' : '' }}>Technology</option>
                                            <option value="Consulting" {{ old('nature_of_business', $profile->nature_of_business ?? '') == 'Consulting' ? 'selected' : '' }}>Consulting</option>
                                            <option value="Education" {{ old('nature_of_business', $profile->nature_of_business ?? '') == 'Education' ? 'selected' : '' }}>Education</option>
                                            <option value="Healthcare" {{ old('nature_of_business', $profile->nature_of_business ?? '') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                            <option value="Retail" {{ old('nature_of_business', $profile->nature_of_business ?? '') == 'Retail' ? 'selected' : '' }}>Retail</option>
                                            <option value="Other" {{ old('nature_of_business', $profile->nature_of_business ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('nature_of_business')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">About Me</label>
                                <textarea class="form-control" name="about_me" rows="4">{{ $profile->about_me ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information Tab -->
                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                    <div class="profile-section">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ $profile->address ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="city" value="{{ $profile->city ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control" name="state" value="{{ $profile->state ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" name="postal_code" value="{{ $profile->postal_code ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Country</label>
                                    <input type="text" class="form-control" name="country" value="{{ $profile->country ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media Links Tab -->
                <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                    <div class="profile-section">
                        <div class="social-links">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="website" class="form-label">Website (optional)</label>
                                        <input type="text" 
                                               class="form-control @error('website') is-invalid @enderror" 
                                               name="website" 
                                               id="website" 
                                               placeholder="e.g. company.com"
                                               value="{{ old('website', $profile->website ?? '') }}">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="linkedin" class="form-label">LinkedIn (optional)</label>
                                        <input type="text" 
                                               class="form-control @error('linkedin') is-invalid @enderror" 
                                               name="linkedin" 
                                               id="linkedin" 
                                               placeholder="LinkedIn Name or Username"
                                               value="{{ old('linkedin', $profile->linkedin ?? '') }}">
                                        @error('linkedin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="facebook" class="form-label">Facebook (optional)</label>
                                        <input type="text" 
                                               class="form-control @error('facebook') is-invalid @enderror" 
                                               name="facebook" 
                                               id="facebook" 
                                               placeholder="Facebook Name or Username"
                                               value="{{ old('facebook', $profile->facebook ?? '') }}">
                                        @error('facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="twitter" class="form-label">Twitter (optional)</label>
                                        <input type="text" 
                                               class="form-control @error('twitter') is-invalid @enderror" 
                                               name="twitter" 
                                               id="twitter" 
                                               placeholder="Twitter Username"
                                               value="{{ old('twitter', $profile->twitter ?? '') }}">
                                        @error('twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="instagram" class="form-label">Instagram (optional)</label>
                                        <input type="text" 
                                               class="form-control @error('instagram') is-invalid @enderror" 
                                               name="instagram" 
                                               id="instagram" 
                                               placeholder="Instagram Username"
                                               value="{{ old('instagram', $profile->instagram ?? '') }}">
                                        @error('instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="button" class="btn btn-danger me-2" onclick="openDeactivateModal()">
                    <i class="bi bi-exclamation-triangle"></i> Deactivate Account
                </button>
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check2"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Custom Deactivate Account Modal -->
<div class="custom-modal-overlay" id="deactivateModal" style="display: none;">
    <div class="custom-modal-container">
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h5 class="custom-modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Deactivate Account
                </h5>
                <button type="button" class="custom-modal-close" onclick="closeDeactivateModal()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <div class="custom-modal-body">
                <div class="custom-modal-warning">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone.
                </div>
                <p>Are you sure you want to deactivate your account? This will:</p>
                <ul class="custom-modal-list">
                    <li>Delete all your personal information</li>
                    <li>Remove your profile data</li>
                    <li>Delete your account permanently</li>
                </ul>
                <p class="mb-0">Please confirm if you wish to proceed with account deactivation.</p>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="custom-modal-btn custom-modal-btn-secondary" onclick="closeDeactivateModal()">
                    <i class="bi bi-x-circle me-1"></i>
                    Cancel
                </button>
                <form action="{{ route('client.user.deactivate') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="custom-modal-btn custom-modal-btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Deactivate Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Profile Completion Modal -->
<div class="modal fade" id="profileCompletionModal" tabindex="-1" aria-labelledby="profileCompletionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 py-4">
                @if(session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                <h3 class="fw-bold mb-3">Complete Your Profile</h3>
                <p class="text-muted mb-4">Your profile is incomplete. A complete profile helps you:</p>
                <ul class="list-unstyled text-start mb-4">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Get matched with relevant opportunities</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Connect with like-minded professionals</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Showcase your skills and experience</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Stand out in the community</li>
                </ul>
                <button type="button" class="btn btn-orange w-100" data-bs-dismiss="modal">
                    <i class="fas fa-pencil-alt me-2"></i>Start Completing My Profile
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePhotoModal(show) {
    var modal = document.getElementById('photoOptionsModal');
    var body = document.body;
    
    if (modal) {
        if (show) {
            modal.style.display = 'flex';
            body.classList.add('modal-open');
            body.style.overflow = 'hidden';
        } else {
            modal.style.display = 'none';
            body.classList.remove('modal-open');
            body.style.overflow = '';
        }
    }
}

function removePhoto() {
    var form = document.getElementById('removePhotoForm');
    if (form) {
        form.submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Profile Completion Modal - Only show if coming from registration
    @if(session('show_profile_reminder'))
        var profileModal = new bootstrap.Modal(document.getElementById('profileCompletionModal'));
        profileModal.show();
        // Clear the session flag via AJAX after showing the modal
        fetch('{{ route("client.profile.clear-reminder") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
    @endif

    // Always scroll to profile container on page load
    const profileContainer = document.getElementById('profile-container');
    if (profileContainer) {
        // Add a small delay to ensure smooth scrolling after page load
        setTimeout(() => {
            profileContainer.scrollIntoView({ behavior: 'smooth' });
        }, 100);
    }

    // Avatar upload functionality
    const avatarInput = document.getElementById('avatar');
    const avatarForm = document.getElementById('avatarForm');
    // Remove Bootstrap modal usage for photo modal
    // const photoModal = new bootstrap.Modal(document.getElementById('photoOptionsModal'));

    if (avatarInput) {
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarForm.submit();
                    togglePhotoModal(false);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Update the click handler for the edit photo button
    var editPhotoBtn = document.querySelector('.change-photo-btn');
    if (editPhotoBtn) {
        editPhotoBtn.addEventListener('click', function(e) {
            e.preventDefault();
            togglePhotoModal(true);
        });
    }

    // Form submission handling
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
            // Submit the form
            this.submit();
        });
    }

    // Function to handle category change
    function handleCategoryChange() {
        const selectedCategory = document.querySelector('input[name="category"]:checked').value;
        const academicianFields = document.getElementById('academician-fields');
        const organizationFields = document.getElementById('organization-fields');
        // Hide all category fields first
        document.querySelectorAll('.category-fields').forEach(field => {
            field.style.display = 'none';
        });
        // Show fields based on selected category
        if (selectedCategory === 'academician') {
            academicianFields.style.display = 'block';
        } else if (selectedCategory === 'organization') {
            organizationFields.style.display = 'block';
        }
    }
    // Add event listeners to radio buttons
    document.querySelectorAll('.category-radio').forEach(radio => {
        radio.addEventListener('change', handleCategoryChange);
    });
    // Initial check on page load
    handleCategoryChange();
});

// Custom Modal Functions
function openDeactivateModal() {
    const modal = document.getElementById('deactivateModal');
    const body = document.body;
    
    modal.style.display = 'flex';
    body.classList.add('modal-open');
    
    // Prevent scrolling
    body.style.overflow = 'hidden';
    
    // Focus trap
    modal.focus();
}

function closeDeactivateModal() {
    const modal = document.getElementById('deactivateModal');
    const body = document.body;
    
    modal.style.display = 'none';
    body.classList.remove('modal-open');
    
    // Restore scrolling
    body.style.overflow = '';
}

// Close modal on escape key only
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('deactivateModal');
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.style.display === 'flex') {
            closeDeactivateModal();
        }
    });
});
</script>
@endpush 