<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('client.home') }}">
            <img src="{{ asset('images/bina-logo.png') }}" alt="BINA2025 Logo" class="navbar-logo">
        </a>
        <button class="navbar-toggler" type="button" id="sidebarToggle">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Desktop Menu -->
        <div class="navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.home') ? 'active' : '' }}" href="{{ route('client.home') }}">Home</a>
                </li>
                <!-- About Dropdown (Desktop) -->
                <li class="nav-item dropdown position-relative">
                    <a class="nav-link {{ request()->routeIs('client.about') || request()->routeIs('client.terms') || request()->routeIs('client.login') || request()->routeIs('client.register') || request()->routeIs('client.profile') || request()->routeIs('client.purchased-tickets') || request()->routeIs('client.community') ? 'active' : '' }} d-inline-flex align-items-center" href="{{ route('client.about') }}" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        About <i class="fas fa-angle-down" style="margin-left:3px;"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                        <li><a class="dropdown-item {{ request()->is('about') ? 'active' : '' }}" href="{{ route('client.about') }}">About</a></li>
                        <li><a class="dropdown-item {{ request()->is('terms') ? 'active' : '' }}" href="{{ route('client.terms') }}">Terms of Service</a></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle d-flex align-items-center gap-1" href="#">
                                <span>Account</span>
                            </a>
                            <ul class="dropdown-menu">
                                @guest
                                    <li><a class="dropdown-item" href="{{ route('client.login') }}">Login</a></li>
                                    <li><a class="dropdown-item" href="{{ route('client.register') }}">Register</a></li>
                                @endguest
                                @auth
                                    <li><a class="dropdown-item" href="{{ route('client.profile') }}">Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('client.purchased-tickets') }}">Purchased Tickets</a></li>
                                    <li>
                                        <form method="POST" action="{{ route('client.logout') }}">
                                            @csrf
                                            <a class="dropdown-item" href="{{ route('client.logout') }}"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                                                Logout
                                            </a>
                                        </form>
                                    </li>
                                @endauth
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('client.community') }}" onclick="showLoginRequiredModal(event)">
                                BINA Community
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.calendar') ? 'active' : '' }}" href="{{ route('client.calendar') }}">Calendar</a>
                </li>
                <li class="nav-item dropdown position-relative">
                    <a class="nav-link {{ request()->routeIs('client.facility-management') || request()->routeIs('client.facility-industry-management') ? 'active' : '' }} d-inline-flex align-items-center" href="#" id="facilityDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Facility Management Engagement Day <i class="fas fa-angle-down" style="margin-left:3px;"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="facilityDropdown">
                        <li><a class="dropdown-item {{ request()->routeIs('client.facility-industry-management') ? 'active' : '' }}" href="{{ route('client.facility-industry-management') }}">Sarawak Facility Management Industry Engagement Day</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('client.facility-management') ? 'active' : '' }}" href="{{ route('client.facility-management') }}">BINA-ICW Kuala Lumpur Facility Management Engagement Day</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.modular-asia') ? 'active' : '' }}" href="{{ route('client.modular-asia') }}">Modular Asia Forum & Exhibition</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.career-spotlight') ? 'active' : '' }}" href="{{ route('client.career-spotlight') }}">Career Spotlight @ Bina</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.ibs-home') ? 'active' : '' }}" href="{{ route('client.ibs-home') }}">IBS Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.nextgen') ? 'active' : '' }}" href="{{ route('client.nextgen') }}">NextGen @ Bina</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.podcast') ? 'active' : '' }}" href="{{ route('client.podcast') }}">Podcast</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Mobile Sidebar -->
<div class="mobile-sidebar" id="mobileSidebar">
    <div class="sidebar-header">
        <a class="sidebar-brand" href="{{ route('client.home') }}">
            <img src="{{ asset('images/bina-logo.png') }}" alt="BINA2025 Logo" class="sidebar-logo">
        </a>
        <button class="sidebar-close" id="sidebarClose">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="sidebar-content">
        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->routeIs('client.home') ? 'active' : '' }}" href="{{ route('client.home') }}">Home</a>
            </li>
            <!-- About with collapsible submenu (Mobile) -->
            <li class="sidebar-item">
                <a class="sidebar-link d-flex justify-content-between align-items-center {{ request()->routeIs('client.about') || request()->routeIs('client.terms') || request()->routeIs('client.login') || request()->routeIs('client.register') || request()->routeIs('client.profile') || request()->routeIs('client.purchased-tickets') || request()->routeIs('client.community') ? 'active' : '' }}" data-bs-toggle="collapse" href="#aboutSidebarSubmenu" role="button" aria-expanded="false" aria-controls="aboutSidebarSubmenu">
                    <span>About</span>
                    <span class="chevron"><i class="fas fa-chevron-down"></i></span>
                </a>
                <ul class="collapse sidebar-submenu" id="aboutSidebarSubmenu">
                    <li><a class="sidebar-link" href="{{ route('client.about') }}">Go to About</a></li>
                    <li><a class="sidebar-link" href="{{ route('client.terms') }}">Terms of Service</a></li>
                    <li>
                        <a class="sidebar-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#accountSidebarSubmenu" role="button" aria-expanded="false" aria-controls="accountSidebarSubmenu">
                            <span>Account</span>
                            <span class="chevron"><i class="fas fa-chevron-down"></i></span>
                        </a>
                        <ul class="collapse sidebar-submenu" id="accountSidebarSubmenu">
                            @guest
                                <li><a class="sidebar-link" href="{{ route('client.login') }}">Login</a></li>
                                <li><a class="sidebar-link" href="{{ route('client.register') }}">Register</a></li>
                            @endguest
                            @auth
                                <li><a class="sidebar-link" href="{{ route('client.profile') }}">Profile</a></li>
                                <li><a class="sidebar-link" href="{{ route('client.purchased-tickets') }}">Purchased Tickets</a></li>
                                <li>
                                    <form method="POST" action="{{ route('client.logout') }}">
                                        @csrf
                                        <a class="sidebar-link" href="{{ route('client.logout') }}"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                                            Logout
                                        </a>
                                    </form>
                                </li>
                            @endauth
                        </ul>
                    </li>
                    <li>
                        <a class="sidebar-link" href="{{ route('client.community') }}" onclick="showLoginRequiredModal(event)">
                            BINA Community
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->routeIs('client.calendar') ? 'active' : '' }}" href="{{ route('client.calendar') }}">Calendar</a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link d-flex justify-content-between align-items-center {{ request()->routeIs('client.facility-management') || request()->routeIs('client.facility-industry-management') ? 'active' : '' }}" data-bs-toggle="collapse" href="#facilitySidebarSubmenu" role="button" aria-expanded="false" aria-controls="facilitySidebarSubmenu">
                    <span>Facility Management Engagement Day</span>
                    <span class="chevron"><i class="fas fa-chevron-down"></i></span>
                </a>
                <ul class="collapse sidebar-submenu" id="facilitySidebarSubmenu">
                    <li><a class="sidebar-link {{ request()->routeIs('client.facility-industry-management') ? 'active' : '' }}" href="{{ route('client.facility-industry-management') }}">Sarawak Facility Management Industry Engagement Day</a></li>
                    <li><a class="sidebar-link" href="{{ route('client.facility-management') }}">BINA-ICW Kuala Lumpur Facility Management Engagement Day</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->routeIs('client.modular-asia') ? 'active' : '' }}" href="{{ route('client.modular-asia') }}">Modular Asia Forum & Exhibition</a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->routeIs('client.career-spotlight') ? 'active' : '' }}" href="{{ route('client.career-spotlight') }}">Career Spotlight @ Bina</a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->routeIs('client.ibs-home') ? 'active' : '' }}" href="{{ route('client.ibs-home') }}">IBS Home</a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->routeIs('client.nextgen') ? 'active' : '' }}" href="{{ route('client.nextgen') }}">NextGen @ Bina</a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->routeIs('client.podcast') ? 'active' : '' }}" href="{{ route('client.podcast') }}">Podcast</a>
            </li>
        </ul>
    </div>
</div>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
#mainNav {
    transition: transform 0.3s ease;
    padding: 1rem 0;
    transform: translateY(0);
    z-index: 1030;
    -webkit-transform: translateY(0);
    -webkit-transition: -webkit-transform 0.3s ease;
    will-change: transform;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    background: transparent;
    box-shadow: none;
    border: none;
}

#mainNav .container {
    background: transparent;
    box-shadow: none;
    border: none;
}

#mainNav .navbar-collapse {
    background: transparent;
    border: none;
    box-shadow: none;
}

#mainNav .navbar-brand,
#mainNav .nav-link {
    color: white !important;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}

#mainNav .navbar-brand span {
    color: white !important;
}

#mainNav .navbar-toggler {
    border: none;
    padding: 0;
    background: transparent;
}

#mainNav .navbar-toggler:focus {
    box-shadow: none;
    outline: none;
}

#mainNav .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

#mainNav.navbar-scrolled {
    visibility: hidden;
}

#mainNav .nav-link {
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: opacity 0.3s ease;
    background: transparent;
}

#mainNav .nav-link:hover {
    color: #ff9800 !important;
    opacity: 0.9;
    background: transparent;
}

#mainNav .nav-link.active {
    color: #ff9800 !important;
    background: transparent;
}

/* Mobile Sidebar Styles */
.mobile-sidebar {
    position: fixed;
    top: 0;
    right: -300px;
    width: 300px;
    height: 100vh;
    background: white;
    z-index: 1040;
    transition: right 0.3s ease;
    box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
}

.mobile-sidebar.active {
    right: 0;
}

.sidebar-header {
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #eee;
    background-color: orange;
}

.sidebar-brand {
    font-size: 1.5rem;
    color: var(--primary-blue);
    text-decoration: none;
}

.sidebar-brand span {
    color: #1a1a1a;
}

.sidebar-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #666;
    cursor: pointer;
    padding: 0;
    transition: color 0.3s ease;
}

.sidebar-close:hover {
    color: #ff9800;
}

.sidebar-content {
    padding: 1.5rem;
}

.sidebar-nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-item {
    margin-bottom: 0.5rem;
}

.sidebar-link {
    display: block;
    padding: 0.75rem 1rem;
    color: #333;
    text-decoration: none;
    font-weight: 500;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.sidebar-link:hover,
.sidebar-link.active {
    background: #f8f9fa;
    color: #ff9800;
}

.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1035;
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.sidebar-overlay.active {
    display: block;
    opacity: 1;
}

/* Hide desktop menu on mobile */
@media (max-width: 991.98px) {
    #mainNav .navbar-collapse {
        display: none;
    }
}

/* Show desktop menu on larger screens */
@media (min-width: 992px) {
    #mainNav .navbar-collapse {
        display: flex !important;
    }
    
    #mainNav .navbar-toggler {
        display: none;
    }
    
    #mainNav .nav-link {
        color: white !important;
        padding: 0.5rem 1rem;
        font-weight: 500;
        background: transparent;
    }
    
    #mainNav.navbar-scrolled .nav-link {
        color: var(--primary-blue);
    }
    
    #mainNav .nav-link:hover,
    #mainNav .nav-link.active {
        color: #ff9800 !important;
        background: transparent;
    }
    
    #mainNav .nav-link .fa-angle-down {
        color: #fff !important;
    }

    /* Multi-level dropdown: show Account submenu to the right */
    .dropdown-submenu {
        position: relative;
    }
    .dropdown-submenu > .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -0.25rem;
        margin-left: 0.1rem;
        border-radius: 0.5rem;
        min-width: 180px;
        display: none;
        position: absolute;
    }
    .dropdown-submenu:hover > .dropdown-menu,
    .dropdown-submenu:focus-within > .dropdown-menu {
        display: block;
    }
}

/* Hide mobile sidebar on desktop */
@media (min-width: 992px) {
    .mobile-sidebar,
    .sidebar-overlay {
        display: none;
    }
}

/* Logo Styles */
.navbar-logo {
    height: 35px;
    width: auto;
    transition: opacity 0.3s ease;
    filter: brightness(0) invert(1); /* Makes the logo white */
}

.sidebar-logo {
    height: 25px;
    width: auto;
}

#mainNav.navbar-transparent .navbar-logo {
    filter: brightness(0) invert(1); /* Makes the logo white */
}

#mainNav.navbar-scrolled .navbar-logo {
    filter: none; /* Returns to original color */
}

/* Updated Menu Styles */
.nav-link, .sidebar-link {
    white-space: normal;
    font-size: 0.95rem;
    line-height: 1.3;
    max-width: 200px;
    text-align: left;
}

@media (max-width: 991.98px) {
    .sidebar-link {
        font-size: 1rem;
        padding: 0.8rem 1rem;
        max-width: none;
    }
    
    .sidebar-item {
        margin-bottom: 0.3rem;
    }
}

@media (min-width: 992px) {
    .nav-link {
        padding: 0.5rem 0.8rem;
        max-width: 180px;
    }
    
    .nav-item {
        margin: 0 0.2rem;
    }
    
    /* Add hover effect for desktop menu */
    .nav-link:hover {
        transform: translateY(-1px);
    }
}

/* Ensure proper alignment for multi-line items */
.navbar-nav {
    align-items: center;
}

.nav-item {
    display: flex;
    align-items: center;
}

#mainNav .dropdown-menu .dropdown-item.active,
#mainNav .dropdown-menu .dropdown-item:active {
    color: #fff !important;
    background-color: #ff9800 !important;
}
#mainNav .dropdown-menu .dropdown-item:hover {
    color: #ff9800 !important;
    background-color: #f8f9fa !important;
}

#mainNav .nav-link.active .fa-angle-down,
#mainNav .nav-link:hover .fa-angle-down {
    color: #ff9800 !important;
}

/* Dropdown styles */
#mainNav .dropdown-menu {
    background: white !important;
    backdrop-filter: none;
    -webkit-backdrop-filter: none;
    border: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

#mainNav .dropdown-item {
    color: #333 !important;
    transition: all 0.3s ease;
    background: transparent;
}

#mainNav .dropdown-item:hover,
#mainNav .dropdown-item:focus {
    background: #f8f9fa !important;
    color: #ff9800 !important;
}

#mainNav .dropdown-item.active {
    background: rgba(255, 152, 0, 0.1) !important;
    color: #ff9800 !important;
}

#mainNav .fa-angle-down {
    color: white !important;
}

/* Remove any Bootstrap default backgrounds */
.bg-light {
    background: transparent !important;
}

.navbar {
    background: transparent !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainNav = document.getElementById('mainNav');
    const isHomePage = window.location.pathname === '/' || window.location.pathname === '/home';
    let lastScrollTop = 0;
    let isScrolling = false;
    
    // Sidebar functionality
    const sidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    
    function openSidebar() {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeSidebar() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    sidebarToggle.addEventListener('click', openSidebar);
    sidebarClose.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);
    
    // Apply transparent navbar initially only if at top
    if (window.pageYOffset <= 0) {
        mainNav.classList.add('navbar-transparent');
        mainNav.style.transform = 'translateY(0)';
    } else {
        mainNav.style.transform = 'translateY(-100%)';
    }
    
    // Debounced scroll handler for better performance
    function handleScroll() {
        if (!isScrolling) {
            window.requestAnimationFrame(() => {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                // Only show navbar when at the very top
                if (scrollTop <= 0) {
                    mainNav.style.transform = 'translateY(0)';
                    mainNav.classList.add('navbar-transparent');
                    mainNav.classList.remove('navbar-scrolled');
                } else {
                    mainNav.style.transform = 'translateY(-100%)';
                    mainNav.classList.remove('navbar-transparent');
                    mainNav.classList.add('navbar-scrolled');
                }
                
                lastScrollTop = scrollTop;
                isScrolling = false;
            });
        }
        isScrolling = true;
    }

    // Add scroll event listener with passive flag for better performance
    window.addEventListener('scroll', handleScroll, { passive: true });
    
    // Initial check
    handleScroll();

    // Enable hover for Account submenu in desktop navbar
    if (window.innerWidth >= 992) {
        document.querySelectorAll('.dropdown-submenu').forEach(function (submenu) {
            submenu.addEventListener('mouseenter', function () {
                const subMenuDropdown = submenu.querySelector('.dropdown-menu');
                if (subMenuDropdown) {
                    subMenuDropdown.classList.add('show');
                }
            });
            submenu.addEventListener('mouseleave', function () {
                const subMenuDropdown = submenu.querySelector('.dropdown-menu');
                if (subMenuDropdown) {
                    subMenuDropdown.classList.remove('show');
                }
            });
        });
    }
});

function showLoginRequiredModal(event) {
    if (!{{ auth()->check() ? 'true' : 'false' }}) {
        event.preventDefault();
        var loginModal = new bootstrap.Modal(document.getElementById('loginRequiredModal'));
        loginModal.show();
    }
}

// Add this to your existing JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // For desktop menu
    const desktopCommunityLink = document.querySelector('.dropdown-menu .dropdown-item[href="{{ route('client.community') }}"]');
    if (desktopCommunityLink) {
        desktopCommunityLink.onclick = showLoginRequiredModal;
    }

    // For mobile menu
    const mobileCommunityLink = document.querySelector('.sidebar-link[href="{{ route('client.community') }}"]');
    if (mobileCommunityLink) {
        mobileCommunityLink.onclick = showLoginRequiredModal;
    }
});
</script>

<!-- Login Required Modal -->
<div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white" style="background: linear-gradient(45deg, #ff9900, #ffb84d) !important;">
                <h5 class="modal-title" id="loginRequiredModalLabel">Login Required</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <i class="fas fa-lock fa-3x text-warning mb-3"></i>
                    <h4 class="mb-3">Please Login to Continue</h4>
                    <p class="text-muted">To access BINA Community and its features, please log in to your account.</p>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ route('client.login') }}" class="btn btn-primary btn-lg" style="background: linear-gradient(45deg, #ff9900, #ffb84d); border: none;">
                        Login Now
                    </a>
                    <button type="button" class="btn btn-light btn-lg" data-bs-dismiss="modal">
                        Maybe Later
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modal Animation */
.modal.fade .modal-dialog {
    transform: scale(0.8);
    transition: transform 0.3s ease-in-out;
}

.modal.show .modal-dialog {
    transform: scale(1);
}

/* Button Hover Effects */
.modal .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 153, 0, 0.3);
    transition: all 0.3s ease;
}

.modal .btn-light:hover {
    background-color: #f8f9fa;
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

/* Close Button Hover */
.modal .btn-close:hover {
    transform: rotate(90deg);
    transition: transform 0.3s ease;
}
</style>