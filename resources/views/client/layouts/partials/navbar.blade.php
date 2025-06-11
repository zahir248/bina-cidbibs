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
                    <a class="nav-link {{ request()->is('about') || request()->is('terms') || request()->is('login') || request()->is('register') ? 'active' : '' }} d-flex align-items-center gap-1" href="{{ route('client.about') }}" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>About</span>
                        <span style="font-size:1rem;line-height:1;display:inline-block;vertical-align:middle;color:#fff;">
                            <i class="fas fa-angle-down"></i>
                        </span>
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
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.calendar') ? 'active' : '' }}" href="{{ route('client.calendar') }}">Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.facility-management') ? 'active' : '' }}" href="{{ route('client.facility-management') }}">Facility Management Engagement Day</a>
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
                <a class="sidebar-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#aboutSidebarSubmenu" role="button" aria-expanded="false" aria-controls="aboutSidebarSubmenu">
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
                </ul>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->routeIs('client.calendar') ? 'active' : '' }}" href="{{ route('client.calendar') }}">Calendar</a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->routeIs('client.facility-management') ? 'active' : '' }}" href="{{ route('client.facility-management') }}">Facility Management Engagement Day</a>
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
    transition: all 0.3s ease;
    padding: 1rem 0;
    transform: translateY(0);
    z-index: 1030;
}

#mainNav.navbar-transparent {
    background: transparent !important;
    box-shadow: none !important;
}

#mainNav.navbar-transparent .navbar-brand,
#mainNav.navbar-transparent .nav-link {
    color: white !important;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}

#mainNav.navbar-transparent .navbar-brand span {
    color: white !important;
}

#mainNav.navbar-transparent .navbar-toggler {
    border: none;
    padding: 0;
}

#mainNav.navbar-transparent .navbar-toggler:focus {
    box-shadow: none;
}

#mainNav.navbar-transparent .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

#mainNav.navbar-scrolled {
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

#mainNav.navbar-scrolled .navbar-brand,
#mainNav.navbar-scrolled .nav-link {
    color: var(--primary-blue) !important;
}

#mainNav.navbar-scrolled .navbar-brand span {
    color: #1a1a1a !important;
}

#mainNav .nav-link {
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

#mainNav .nav-link:hover {
    color: #ff9800 !important;
}

#mainNav .nav-link.active {
    color: #ff9800 !important;
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
        color: white;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    #mainNav.navbar-scrolled .nav-link {
        color: var(--primary-blue);
    }
    
    #mainNav .nav-link:hover,
    #mainNav .nav-link.active {
        color: #ff9800 !important;
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
    transition: all 0.3s ease;
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainNav = document.getElementById('mainNav');
    const isHomePage = window.location.pathname === '/' || window.location.pathname === '/home';
    let lastScrollTop = 0;
    
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
    
    // Apply transparent navbar to all pages
    mainNav.classList.add('navbar-transparent');
    
    // Handle scroll behavior for all pages
    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Always hide navbar when scrolling down
        if (scrollTop > lastScrollTop) {
            mainNav.style.transform = 'translateY(-100%)';
        } 
        // Show navbar only when scrolling up AND at the top of the screen
        else if (scrollTop <= 0) {
            mainNav.style.transform = 'translateY(0)';
            mainNav.classList.add('navbar-transparent');
            mainNav.classList.remove('navbar-scrolled');
        }
        
        lastScrollTop = scrollTop;
    });

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
</script>