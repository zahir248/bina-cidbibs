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
        margin-bottom: 0.5rem;
    }
    .category-select .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
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

    /* Deactivate Account Styles */
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

    #deactivateModal .modal-content {
        border-radius: 15px;
        border: none;
    }

    #deactivateModal .modal-title {
        font-weight: 600;
    }

    #deactivateModal .alert-warning {
        background-color: #fff3cd;
        border-color: #ffecb5;
        color: #664d03;
        border-radius: 8px;
    }

    #deactivateModal .text-muted {
        color: #6c757d !important;
    }

    #deactivateModal .modal-footer .btn {
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
    }

    #deactivateModal .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    #deactivateModal .btn-danger:hover {
        background-color: #bb2d3b;
        border-color: #b02a37;
        transform: translateY(-1px);
    }

    /* Modal Backdrop and Positioning */
    .modal-backdrop {
        opacity: 0.7 !important;
        background-color: #1a1a1a;
    }

    #deactivateModal {
        background: rgba(0, 0, 0, 0.7);
    }

    #deactivateModal .modal-dialog {
        margin: 1.75rem auto;
        max-width: 500px;
        width: calc(100% - 2rem);
    }

    #deactivateModal.show {
        display: flex !important;
        align-items: center;
        padding: 0 !important;
    }

    /* Prevent content shift when modal opens */
    body.modal-open {
        padding-right: 0 !important;
        overflow: hidden;
    }

    /* Ensure modal content is scrollable if needed */
    #deactivateModal .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
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
    @if(session('success'))
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
        <div class="modal" id="photoOptionsModal" tabindex="-1" aria-labelledby="photoOptionsModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="photoOptionsModalLabel">Profile Photo Options</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center pb-4">
                        <form id="avatarForm" action="{{ route('client.profile.update.avatar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="d-grid gap-3">
                                <label class="btn btn-primary btn-lg upload-btn">
                                    <i class="bi bi-camera me-2"></i>
                                    Upload New Photo
                                    <input type="file" 
                                           id="avatar" 
                                           name="avatar" 
                                           class="d-none" 
                                           accept="image/*"
                                           onchange="submitPhotoForm(this)">
                                </label>
                                @if(Auth::user()->avatar)
                                    <button type="button" class="btn btn-outline-danger btn-lg remove-btn" onclick="removePhoto()">
                                        <i class="bi bi-trash me-2"></i>
                                        Remove Photo
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('client.profile.update') }}" method="POST">
            @csrf
            
            <div class="profile-section">
                <h2 class="section-title">Personal Information</h2>
                <!-- Category Selection -->
                <div class="category-select">
                    <label class="form-label fw-bold mb-3">Select your category:</label>
                    <div class="form-check">
                        <input class="form-check-input @error('category') is-invalid @enderror" 
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
                        <input class="form-check-input @error('category') is-invalid @enderror" 
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
                        <input class="form-check-input @error('category') is-invalid @enderror" 
                               type="radio" 
                               name="category" 
                               id="category-org" 
                               value="organization"
                               {{ old('category', $profile->category ?? '') == 'organization' ? 'checked' : '' }}>
                        <label class="form-check-label" for="category-org">
                            Organization
                        </label>
                    </div>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- All Fields -->
                <div class="all-fields">
                    <!-- Individual Fields -->
                    <div class="individual-section">
                        <div class="row">
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
                    </div>

                    <!-- Academic Fields -->
                    <div class="academician-section">
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

                    <!-- Organization Fields -->
                    <div class="organization-section">
                        <div class="row">
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

                    <div class="form-group">
                        <label class="form-label">About Me</label>
                        <textarea class="form-control" name="about_me" rows="4">{{ $profile->about_me ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="profile-section">
                <h2 class="section-title">Address Information</h2>
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

            <div class="profile-section">
                <h2 class="section-title">Social Media Links</h2>
                <div class="social-links">
                    <h5>Social Media & Website Links</h5>
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

            <div class="text-end">
                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                    <i class="bi bi-exclamation-triangle"></i> Deactivate Account
                </button>
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check2"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Deactivate Account Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger" id="deactivateModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Deactivate Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone.
                </div>
                <p>Are you sure you want to deactivate your account? This will:</p>
                <ul class="text-muted">
                    <li>Delete all your personal information</li>
                    <li>Remove your profile data</li>
                    <li>Delete your account permanently</li>
                </ul>
                <p class="mb-0">Please confirm if you wish to proceed with account deactivation.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>
                    Cancel
                </button>
                <form action="{{ route('client.user.deactivate') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
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
                <h3 class="fw-bold mb-3">Complete Your Profile</h3>
                <p class="text-muted mb-4">Your profile is incomplete. A complete profile helps you:</p>
                <ul class="list-unstyled text-start mb-4">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Get matched with relevant opportunities</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Connect with like-minded professionals</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Showcase your skills and experience</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Stand out in the community</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
    const avatarPreview = document.getElementById('avatarPreview');
    const defaultAvatar = document.getElementById('defaultAvatar');

    if (avatarInput) {
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (avatarPreview) {
                        avatarPreview.src = e.target.result;
                        avatarPreview.style.display = 'block';
                        if (defaultAvatar) {
                            defaultAvatar.style.display = 'none';
                        }
                    }
                    // Submit the form automatically when a file is selected
                    avatarForm.submit();
                };
                
                reader.readAsDataURL(this.files[0]);
            }
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
});
</script>
@endpush 