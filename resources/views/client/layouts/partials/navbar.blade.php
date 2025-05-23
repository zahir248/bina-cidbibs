<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#" style="color: var(--primary-blue);">
            My<span class="text-dark">Site</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('features') ? 'active' : '' }}" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('testimonials') ? 'active' : '' }}" href="#">Testimonials</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>