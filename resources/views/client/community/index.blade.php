@extends('client.community.layouts.app')

@section('title', 'Home | BINA Community')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1 class="display-4 fw-bold">BINA COMMUNITY</h1>
        <p class="lead">Connecting talents and opportunities within the local community.</p>
    </div>
</section>

<!-- Demo Content Section -->
<section class="content-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2 class="text-center mb-4">About Our Community</h2>
                <p>Bina Community is a platform designed to connect local talents with opportunities in their area. Whether you're looking for work, seeking to hire, or wanting to collaborate on projects, our community brings people together.</p>
                <p>Our advanced profile matching system helps you find the perfect connections based on skills, interests, and location. Join thousands of community members who have already found success through our platform.</p>
                <div class="text-center mt-4">
                    <a href="{{ route('client.community.profile-matching') }}" class="btn btn-orange">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
.hero {
    height: 100vh;
    min-height: 100vh;
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("{{ asset('images/hero-section.png') }}") no-repeat center center;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    margin-top: -76px;
}

.hero h1,
.hero .lead {
    color: #ffffff;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.content-section {
    padding: 80px 0;
    background-color: #f8f9fa;
}

@media (max-width: 768px) {
    .hero {
        min-height: 100vh;
        min-height: 100dvh;
        padding: 80px 15px 20px;
    }
    
    .hero h1 {
        font-size: 2.5rem;
    }
    
    .hero .lead {
        font-size: 1.1rem;
    }
}
</style>
@endsection