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
<div class="row align-items-stretch mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-stat-card text-white fade-in" style="background: linear-gradient(135deg, #2563eb, #3b82f6);">
            <div class="card-body d-flex justify-content-between align-items-center w-100">
                <div>
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">{{ $totalUsers }}</div>
                    <div style="opacity: 0.9; font-size: 0.95rem;">Total Users</div>
                </div>
                <div style="font-size: 2rem; opacity: 0.8;">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-stat-card bg-success text-white fade-in" style="border-radius: 20px;">
            <div class="card-body d-flex justify-content-between align-items-center w-100">
                <div>
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">{{ $totalOrders }}</div>
                    <div style="opacity: 0.9; font-size: 0.95rem;">Total Orders</div>
                </div>
                <div style="font-size: 2rem; opacity: 0.8;">
                    <i class="bi bi-cart-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-stat-card bg-warning text-white fade-in" style="border-radius: 20px;">
            <div class="card-body d-flex justify-content-between align-items-center w-100">
                <div>
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">RM {{ number_format($totalRevenue, 2) }}</div>
                    <div style="opacity: 0.9; font-size: 0.95rem;">Total Revenue</div>
                </div>
                <div style="font-size: 2rem; opacity: 0.8;">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-stat-card bg-info text-white fade-in" style="border-radius: 20px;">
            <div class="card-body d-flex justify-content-between align-items-center w-100">
                <div>
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">{{ number_format($successRate, 1) }}%</div>
                    <div style="opacity: 0.9; font-size: 0.95rem;">Success Rate</div>
                </div>
                <div style="font-size: 2rem; opacity: 0.8;">
                    <i class="bi bi-graph-up"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card fade-in mb-4">
    <div class="card-header">
        <i class="bi bi-bar-chart-fill me-2"></i>Ticket Sales (Quantity Sold)
    </div>
    <div class="card-body">
        <canvas id="ticketsBarChart" height="100"></canvas>
    </div>
</div>

<div class="card fade-in mb-4">
    <div class="card-header">
        <i class="bi bi-pie-chart-fill me-2"></i>Revenue Breakdown by Ticket
    </div>
    <div class="card-body d-flex align-items-center justify-content-center flex-wrap flex-md-nowrap">
        <div style="flex:0 0 180px; max-width:180px;">
            <canvas id="ticketsPieChart" height="180" width="180"></canvas>
        </div>
        <div class="ms-md-4 mt-3 mt-md-0" style="flex:1; min-width:180px;">
            <ul id="pieChartLegend" class="list-unstyled mb-0" style="font-size:0.98rem;"></ul>
        </div>
    </div>
</div>

<!-- Main Content Cards -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card fade-in">
            <div class="card-header">
                <i class="bi bi-bar-chart me-2"></i>Recent Orders
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order->reference_number }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                        <strong>{{ $order->billingDetail->first_name ?? 'N/A' }}</strong>
                                    </div>
                                </td>
                                <td>RM {{ number_format($order->total_amount, 2) }}</td>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status === 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No recent orders found</td>
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
                    <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Add New Ticket
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-cart me-2"></i>View All Orders
                    </a>
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-ticket-perforated me-2"></i>Manage Tickets
                    </a>
                    <a href="{{ route('admin.orders.index') }}?download=pdf" class="btn btn-outline-primary">
                        <i class="bi bi-download me-2"></i>Download Orders Report
                    </a>
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
                <i class="bi bi-ticket-perforated me-2"></i>Ticket Statistics
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3 text-center">
                            <h6 class="text-muted mb-2">Total Tickets</h6>
                            <h3 class="mb-0">{{ $totalTickets }}</h3>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3 text-center">
                            <h6 class="text-muted mb-2">Low Stock</h6>
                            <h3 class="mb-0">{{ $lowStockTickets }}</h3>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-primary">View All Tickets</a>
                    <a href="{{ route('admin.tickets.create') }}" class="btn btn-outline-primary">Add Ticket</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card fade-in">
            <div class="card-header">
                <i class="bi bi-graph-up me-2"></i>Revenue Overview
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3 text-center">
                            <h6 class="text-muted mb-2">Today's Revenue</h6>
                            <h3 class="mb-0">RM {{ number_format($todayRevenue, 2) }}</h3>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3 text-center">
                            <h6 class="text-muted mb-2">This Month</h6>
                            <h3 class="mb-0">RM {{ number_format($monthlyRevenue, 2) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">View Orders</a>
                    <a href="{{ route('admin.orders.index') }}?download=pdf" class="btn btn-outline-primary">Download Report</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('ticketsBarChart').getContext('2d');
    var ticketsBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($ticketNames),
            datasets: [{
                label: 'Sold Quantity',
                data: @json($soldQuantities),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    var pieCtx = document.getElementById('ticketsPieChart').getContext('2d');
    var pieColors = [
        '#2563eb', '#22c55e', '#facc15', '#f87171', '#38bdf8', '#a78bfa', '#f472b6', '#fb7185', '#34d399', '#fbbf24'
    ];
    var ticketsPieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: @json($ticketNames),
            datasets: [{
                data: @json($ticketRevenues),
                backgroundColor: pieColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Custom legend on the right
    var legendContainer = document.getElementById('pieChartLegend');
    var labels = @json($ticketNames);
    var revenues = @json($ticketRevenues);
    legendContainer.innerHTML = labels.map(function(label, i) {
        return `<li class="d-flex align-items-center mb-2"><span style="display:inline-block;width:16px;height:16px;background:${pieColors[i % pieColors.length]};border-radius:3px;margin-right:10px;"></span>${label} <span class='ms-auto fw-bold'>RM ${revenues[i].toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2})}</span></li>`;
    }).join('');
});
</script>
@endpush

@push('styles')
<style>
.dashboard-stat-card {
    min-width: 240px;
    max-width: 260px;
    min-height: 140px;
    height: 100%;
    display: flex;
    align-items: center;
    border-radius: 20px;
    margin: 0 auto;
    box-sizing: border-box;
}
@media (max-width: 991px) {
    .dashboard-stat-card {
        min-width: 100%;
        max-width: 100%;
    }
}
</style>
@endpush