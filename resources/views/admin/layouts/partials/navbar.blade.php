<!-- Top Navbar -->
<nav class="navbar navbar-custom navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <button class="navbar-toggler mobile-toggle d-lg-none" type="button" id="sidebarToggle">
            <i class="bi bi-list text-white"></i>
        </button>
        
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/bina-logo.png') }}" alt="BINA Logo" height="40">
        </a>

        <div class="ms-auto d-flex align-items-center">
            <!-- Notifications -->
            <!-- <div class="dropdown me-3">
                <button class="btn position-relative" style="background: rgba(255, 255, 255, 0.1); border: none; border-radius: 50%; width: 45px; height: 45px;" data-bs-toggle="dropdown">
                    <i class="bi bi-bell text-white fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7rem;">
                        3
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="width: 300px;">
                    <li><h6 class="dropdown-header">Notifications</h6></li>
                    <li><a class="dropdown-item" href="#">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-person-check text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold">New user registered</div>
                                <div class="small text-muted">2 minutes ago</div>
                            </div>
                        </div>
                    </a></li>
                    <li><a class="dropdown-item" href="#">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-cart-check text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold">New order received</div>
                                <div class="small text-muted">5 minutes ago</div>
                            </div>
                        </div>
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-center" href="#">View all notifications</a></li>
                </ul>
            </div> -->

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <button class="btn profile-dropdown dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2"></i>
                    {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="#">
                        <i class="bi bi-person me-2"></i>Profile
                    </a></li>
                    <!-- <li><a class="dropdown-item" href="#">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a></li> -->
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>