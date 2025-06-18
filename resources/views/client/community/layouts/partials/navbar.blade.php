<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('client.community') }}">
            <img src="{{ asset('images/bina-logo.png') }}" alt="BINA2025 Logo" class="navbar-logo" style="height: 35px; width: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.community') ? 'fw-bold' : '' }}" 
                       href="{{ route('client.community') }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('client.community.profile-matching*') ? 'fw-bold' : '' }}" 
                       href="#" id="profileMatchingDropdown" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Profile Matching
                    </a>
                    <ul class="dropdown-menu shadow-none border-0" aria-labelledby="profileMatchingDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('client.community.profile-matching') ? 'fw-bold' : '' }}" 
                               href="{{ route('client.community.profile-matching') }}">
                                Find Matches
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('client.community.profile-matching.connections') ? 'fw-bold' : '' }}" 
                               href="{{ route('client.community.profile-matching.connections') }}">
                                Connections
                                @php
                                    $pendingRequests = \App\Models\ConnectionRequest::where('receiver_id', auth()->id())
                                        ->where('status', 'pending')
                                        ->count();
                                @endphp
                                @if($pendingRequests > 0)
                                    <span class="badge bg-danger rounded-pill ms-2">{{ $pendingRequests }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('client.community.profile-matching.messages') ? 'fw-bold' : '' }}" 
                               href="{{ route('client.community.profile-matching.messages') }}">
                                Messages
                                @php
                                    // We'll implement unread messages count later
                                    $unreadMessages = 0;
                                @endphp
                                @if($unreadMessages > 0)
                                    <span class="badge bg-danger rounded-pill ms-2">{{ $unreadMessages }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('client.home') }}">Portal</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@push('styles')
<style>
.nav-link,
.nav-link:focus,
.nav-link:active,
.nav-link:hover {
    background: transparent !important;
    color: #333 !important;
    box-shadow: none !important;
}

.dropdown-item,
.dropdown-item:focus,
.dropdown-item:active,
.dropdown-item:hover {
    background: transparent !important;
    color: #333 !important;
    box-shadow: none !important;
}

.fw-bold {
    font-weight: bold !important;
    color: #ff9900 !important;
}

/* Navbar visibility styles */
#mainNavbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1030;
    transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    opacity: 0;
    visibility: hidden;
}

#mainNavbar.navbar-visible {
    opacity: 1;
    visibility: visible;
}

/* Add padding to body to prevent content from hiding under navbar */
body {
    padding-top: 76px; /* Adjust this value based on your navbar height */
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('mainNavbar');
    
    function handleScroll() {
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        
        // Only show navbar when at the very top (scroll position is 0)
        if (currentScroll <= 0) {
            navbar.classList.add('navbar-visible');
        } else {
            navbar.classList.remove('navbar-visible');
        }
    }

    // Initial check
    handleScroll();
    
    // Add scroll event listener with passive option for better performance
    window.addEventListener('scroll', handleScroll, { passive: true });
});
</script>
@endpush 