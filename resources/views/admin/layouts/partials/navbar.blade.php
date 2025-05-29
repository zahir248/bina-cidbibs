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
                    <li><a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                        <i class="bi bi-person me-2"></i>Profile
                    </a></li>
                    <!-- <li><a class="dropdown-item" href="#">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a></li> -->
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    Logout Confirmation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to logout?</p>
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    You will need to login again to access the admin panel.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>
                    Cancel
                </button>
                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>