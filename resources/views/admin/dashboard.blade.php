@extends('admin.layouts.app')

@section('title', 'Dashboard - Admin Panel')

@section('content')
<!-- Welcome Header -->
<div class="row mb-4 fade-in">
    <div class="col-12">
        <h1 class="display-6 fw-bold text-primary mb-2">Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</h1>
        <p class="text-muted fs-5">Here's what's happening with your dashboard today.</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card text-white fade-in" style="background: linear-gradient(135deg, #2563eb, #3b82f6); border-radius: 20px;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">{{ $totalUsers ?? '2,543' }}</div>
                    <div style="opacity: 0.9; font-size: 0.95rem;">Total Users</div>
                </div>
                <div style="font-size: 2rem; opacity: 0.8;">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-success text-white fade-in" style="border-radius: 20px;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">{{ $totalOrders ?? '1,247' }}</div>
                    <div style="opacity: 0.9; font-size: 0.95rem;">Orders</div>
                </div>
                <div style="font-size: 2rem; opacity: 0.8;">
                    <i class="bi bi-cart-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-warning text-white fade-in" style="border-radius: 20px;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">${{ number_format($totalRevenue ?? 12847) }}</div>
                    <div style="opacity: 0.9; font-size: 0.95rem;">Revenue</div>
                </div>
                <div style="font-size: 2rem; opacity: 0.8;">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-info text-white fade-in" style="border-radius: 20px;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">{{ $performance ?? '94.2' }}%</div>
                    <div style="opacity: 0.9; font-size: 0.95rem;">Performance</div>
                </div>
                <div style="font-size: 2rem; opacity: 0.8;">
                    <i class="bi bi-graph-up"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Cards -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card fade-in">
            <div class="card-header">
                <i class="bi bi-bar-chart me-2"></i>Recent Activity
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities ?? [] as $activity)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                        <strong>{{ $activity['user'] }}</strong>
                                    </div>
                                </td>
                                <td>{{ $activity['action'] }}</td>
                                <td>{{ $activity['date'] }}</td>
                                <td>
                                    <span class="badge bg-{{ $activity['status_color'] }}">
                                        {{ $activity['status'] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <!-- Default data when no activities -->
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                        <strong>John Doe</strong>
                                    </div>
                                </td>
                                <td>Created new order</td>
                                <td>2 hours ago</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                        <strong>Jane Smith</strong>
                                    </div>
                                </td>
                                <td>Updated profile</td>
                                <td>5 hours ago</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card fade-in h-100">
            <div class="card-header">
                <i class="bi bi-bell me-2"></i>Quick Actions
            </div>
            <div class="card-body d-flex flex-column">
                <div class="d-grid gap-3">
                    <a href="#" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Add New User
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-plus me-2"></i>Generate Report
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="bi bi-gear me-2"></i>System Settings
                    </a>
                    <button class="btn btn-outline-primary" onclick="exportData()">
                        <i class="bi bi-download me-2"></i>Export Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Content Row -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card fade-in">
            <div class="card-header">
                <i class="bi bi-people me-2"></i>User Management
            </div>
            <div class="card-body">
                <p class="card-text">Manage user accounts, permissions, and access levels.</p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="#" class="btn btn-primary">View All Users</a>
                    <a href="#" class="btn btn-outline-primary">Add User</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card fade-in">
            <div class="card-header">
                <i class="bi bi-graph-up me-2"></i>Analytics & Reports
            </div>
            <div class="card-body">
                <p class="card-text">View detailed analytics and generate comprehensive reports.</p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="#" class="btn btn-primary">View Analytics</a>
                    <a href="#" class="btn btn-outline-primary">Download Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Animate cards on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all fade-in elements
document.querySelectorAll('.fade-in').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});

// Export data function
function exportData() {
    // Add your export logic here
    alert('Export functionality would be implemented here');
}
</script>
@endpush