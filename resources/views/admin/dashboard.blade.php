@extends('admin.layouts.app')

@section('title', 'ADMIN | Dashboard')

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
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">{{ array_sum($soldQuantities) }}</div>
                    <div style="opacity: 0.9; font-size: 0.95rem;">Total Participants</div>
                </div>
                <div style="font-size: 2rem; opacity: 0.8;">
                    <i class="bi bi-person-check"></i>
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
                    <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">{{ $totalUsers }}</div>
                    <div style="opacity: 0.9; font-size: 0.95rem;">Community Members</div>
                </div>
                <div style="font-size: 2rem; opacity: 0.8;">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gender Distribution Chart -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card fade-in">
            <div class="card-header">
                <i class="bi bi-pie-chart-fill me-2"></i>Gender Distribution
            </div>
            <div class="card-body d-flex align-items-center justify-content-center flex-wrap flex-md-nowrap">
                <div style="flex:0 0 180px; max-width:180px;">
                    <canvas id="genderDoughnutChart" height="180" width="180"></canvas>
                </div>
                <div class="ms-md-4 mt-3 mt-md-0" style="flex:1; min-width:180px;">
                    <ul id="genderChartLegend" class="list-unstyled mb-0" style="font-size:0.98rem;"></ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card fade-in">
            <div class="card-header">
                <i class="bi bi-pie-chart-fill me-2"></i>Category Distribution
            </div>
            <div class="card-body d-flex align-items-center justify-content-center flex-wrap flex-md-nowrap">
                <div style="flex:0 0 180px; max-width:180px;">
                    <canvas id="categoryDoughnutChart" height="180" width="180"></canvas>
                </div>
                <div class="ms-md-4 mt-3 mt-md-0" style="flex:1; min-width:180px;">
                    <ul id="categoryChartLegend" class="list-unstyled mb-0" style="font-size:0.98rem;"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Location Statistics -->
<div class="card fade-in mb-4">
    <div class="card-header">
        <i class="bi bi-geo-alt-fill me-2"></i>Client Locations
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-8 mb-4">
                <h5 class="mb-3">Global Distribution</h5>
                <div id="worldMap" style="height: 400px;"></div>
            </div>
            <div class="col-lg-4 mb-4">
                <h5 class="mb-3">Top Cities</h5>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>City</th>
                                <th>Country</th>
                                <th>Clients</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locationStats['cities'] as $city)
                            <tr>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->country }}</td>
                                <td>{{ $city->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
<script src="https://unpkg.com/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"></script>
<script src="https://unpkg.com/jsvectormap@1.5.3/dist/maps/world.js"></script>
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
    // Gender Distribution Doughnut Chart
    var genderCtx = document.getElementById('genderDoughnutChart').getContext('2d');
    var genderColors = ['#2563eb', '#f472b6'];
    var genderData = @json($genderStats);
    var genderLabels = Object.keys(genderData);
    var genderValues = Object.values(genderData);
    
    var genderDoughnutChart = new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: genderLabels,
            datasets: [{
                data: genderValues,
                backgroundColor: genderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: { display: false }
            },
            cutout: '60%'
        }
    });

    // Custom legend for gender chart
    var genderLegendContainer = document.getElementById('genderChartLegend');
    genderLegendContainer.innerHTML = genderLabels.map(function(label, i) {
        var total = genderValues[i];
        var percentage = ((total / genderValues.reduce((a, b) => a + b, 0)) * 100).toFixed(1);
        return `<li class="d-flex align-items-center mb-2">
            <span style="display:inline-block;width:16px;height:16px;background:${genderColors[i]};border-radius:3px;margin-right:10px;"></span>
            ${label} <span class='ms-auto fw-bold'>${total} (${percentage}%)</span>
        </li>`;
    }).join('');

    // Category Distribution Doughnut Chart
    var categoryCtx = document.getElementById('categoryDoughnutChart').getContext('2d');
    var categoryColors = ['#22c55e', '#3b82f6', '#f59e0b'];
    var categoryData = @json($categoryStats);
    var categoryLabels = Object.keys(categoryData);
    var categoryValues = Object.values(categoryData);
    
    var categoryDoughnutChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryValues,
                backgroundColor: categoryColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: { display: false }
            },
            cutout: '60%'
        }
    });

    // Custom legend for category chart
    var categoryLegendContainer = document.getElementById('categoryChartLegend');
    categoryLegendContainer.innerHTML = categoryLabels.map(function(label, i) {
        var total = categoryValues[i];
        var percentage = ((total / categoryValues.reduce((a, b) => a + b, 0)) * 100).toFixed(1);
        return `<li class="d-flex align-items-center mb-2">
            <span style="display:inline-block;width:16px;height:16px;background:${categoryColors[i]};border-radius:3px;margin-right:10px;"></span>
            ${label} <span class='ms-auto fw-bold'>${total} (${percentage}%)</span>
        </li>`;
    }).join('');

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

    // World Map
    const mapData = {};
    const countryData = @json($locationStats['countries']);
    countryData.forEach(item => {
        // Convert country name to ISO code
        const countryMapping = {
            'Malaysia': 'MY',
            'United States': 'US',
            'United Kingdom': 'GB',
            'Indonesia': 'ID',
            'Singapore': 'SG',
            'Thailand': 'TH',
            'Vietnam': 'VN',
            'Philippines': 'PH',
            'China': 'CN',
            'Japan': 'JP',
            'South Korea': 'KR',
            'India': 'IN',
            'Australia': 'AU',
            'New Zealand': 'NZ',
            'Canada': 'CA',
            'Germany': 'DE',
            'France': 'FR',
            'Italy': 'IT',
            'Spain': 'ES',
            'Netherlands': 'NL',
            'Belgium': 'BE',
            'Switzerland': 'CH',
            'Austria': 'AT',
            'Sweden': 'SE',
            'Norway': 'NO',
            'Denmark': 'DK',
            'Finland': 'FI',
            'Russia': 'RU',
            'Brazil': 'BR',
            'Mexico': 'MX',
            'Argentina': 'AR',
            'Chile': 'CL',
            'South Africa': 'ZA',
            'United Arab Emirates': 'AE',
            'Saudi Arabia': 'SA',
            'Turkey': 'TR',
            'Israel': 'IL',
            'Egypt': 'EG'
        };
        
        // Try to get the country code, first check exact match, then try case-insensitive match
        let code = countryMapping[item.country];
        if (!code) {
            const countryLower = item.country.toLowerCase();
            const matchingCountry = Object.keys(countryMapping).find(
                key => key.toLowerCase() === countryLower
            );
            code = matchingCountry ? countryMapping[matchingCountry] : item.country;
        }
        
        if (code) {
            mapData[code] = item.total;
            console.log(`Mapped ${item.country} to ${code} with ${item.total} users`); // Debug log
        }
    });

    const map = new jsVectorMap({
        selector: '#worldMap',
        map: 'world',
        zoomOnScroll: true,
        zoomButtons: true,
        markers: null,
        markerStyle: {
            initial: {
                r: 6,
                fill: '#1e88e5',
                stroke: '#fff',
                strokeWidth: 2,
            }
        },
        series: {
            regions: [{
                values: mapData,
                scale: ['#c8e6ff', '#0d47a1'],
                normalizeFunction: 'polynomial',
                legend: {
                    vertical: true
                }
            }]
        },
        regionStyle: {
            initial: {
                fill: '#e9ecef',
                stroke: '#fff',
                strokeWidth: 0.5,
            },
            hover: {
                fill: '#2563eb',
                cursor: 'pointer'
            }
        },
        onRegionTipShow: function(event, label, code) {
            const total = mapData[code] || 0;
            label.html(
                `<div class="map-tooltip">
                    <strong>${label.html()}</strong><br>
                    <span class="text-info">Total Users: ${total.toLocaleString()}</span>
                </div>`
            );
        },
        backgroundColor: 'transparent',
    });
});
</script>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/jsvectormap@1.5.3/dist/css/jsvectormap.min.css">
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
.jvm-tooltip {
    background-color: rgba(0, 0, 0, 0.8);
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 0.875rem;
    max-width: 200px;
    word-wrap: break-word;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.map-tooltip {
    text-align: center;
}

.map-tooltip strong {
    color: #fff;
    display: block;
    margin-bottom: 4px;
    font-size: 1rem;
}

.map-tooltip .text-info {
    color: #7dd3fc !important;
}
</style>
@endpush