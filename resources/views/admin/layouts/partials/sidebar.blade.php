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
                <a class="nav-link {{ request()->routeIs('admin.documentation.*') ? 'active' : '' }}" href="{{ route('admin.documentation.index') }}">
                    <i class="bi bi-book"></i>
                    Documentation
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
                <a class="nav-link {{ request()->routeIs('admin.podcasts.*') ? 'active' : '' }}" href="{{ route('admin.podcasts.index') }}">
                    <i class="bi bi-broadcast"></i>
                    Podcasts
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                    <i class="bi bi-file-earmark-text"></i>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}" href="{{ route('admin.schedules.index') }}">
                    <i class="bi bi-clock"></i>
                    Schedules
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
        </ul>
    </div>
</div>