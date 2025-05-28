<!-- Sidebar -->
<div class="sidebar d-lg-block" id="sidebar">
    <div class="pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house-door"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">
                    <i class="bi bi-calendar-event"></i>
                    Events
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <i class="bi bi-cart"></i>
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                    <i class="bi bi-file-earmark-text"></i>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.tickets.index') ? 'active' : '' }}" href="{{ route('admin.tickets.index') }}">
                    <i class="bi bi-ticket-perforated"></i>
                    Tickets
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i>
                    Users
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('analytics.*') ? 'active' : '' }}" href="#">
                    <i class="bi bi-bar-chart"></i>
                    Analytics
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="#">
                    <i class="bi bi-chat-dots"></i>
                    Messages
                    @if(isset($unreadMessages) && $unreadMessages > 0)
                        <span class="badge bg-danger ms-auto">{{ $unreadMessages }}</span>
                    @endif
                </a>
            </li> -->
            
            <!-- Dropdown Menu Example -->
            <!-- <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#settingsCollapse" role="button" aria-expanded="false">
                    <i class="bi bi-gear"></i>
                    Settings
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="settingsCollapse">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('settings.general') ? 'active' : '' }}" href="#">
                                <i class="bi bi-sliders"></i>
                                General
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('settings.security') ? 'active' : '' }}" href="#">
                                <i class="bi bi-shield-lock"></i>
                                Security
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('settings.notifications') ? 'active' : '' }}" href="#">
                                <i class="bi bi-bell"></i>
                                Notifications
                            </a>
                        </li>
                    </ul>
                </div>
            </li> -->
        </ul>
    </div>
</div>