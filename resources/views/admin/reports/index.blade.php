@extends('admin.layouts.app')

@section('title', 'ADMIN | Reports')

@section('content')
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Reports</h3>
                        <div class="d-flex gap-2">
                            <select class="form-select" id="eventFilter" style="width: auto;">
                                <option value="all" {{ $event === 'all' ? 'selected' : '' }}>All Events</option>
                                <option value="bina" {{ $event === 'bina' ? 'selected' : '' }}>BINA Events</option>
                                <option value="industry" {{ $event === 'industry' ? 'selected' : '' }}>Sarawak Facility Management Engagement Day</option>
                            </select>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="downloadDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Download {{ $event === 'all' ? 'All Events' : ($event === 'bina' ? 'BINA Events' : 'Sarawak FM Day') }} Report
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="downloadDropdown">
                                    <li>
                                        <form action="{{ route('admin.reports.download') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type" value="all">
                                            <input type="hidden" name="event" value="{{ $event }}">
                                            <button type="submit" class="dropdown-item">Download as PDF</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.reports.download-excel') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type" value="all">
                                            <input type="hidden" name="event" value="{{ $event }}">
                                            <button type="submit" class="dropdown-item">Download as Excel</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Ticket Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-gradient-primary text-white h-100">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase mb-1">Total Stock</h6>
                                        <h2 class="mb-0">{{ $ticketStats['total_stock'] }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-gradient-success text-white h-100">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase mb-1">Total Sold</h6>
                                        <h2 class="mb-0">{{ $ticketStats['total_sold'] }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-gradient-info text-white h-100">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase mb-1">Total Sales</h6>
                                        <h2 class="mb-0">RM {{ number_format($ticketStats['total_revenue'], 2) }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .bg-gradient-primary {
                            background: linear-gradient(45deg, #4e73df, #224abe);
                        }
                        .bg-gradient-success {
                            background: linear-gradient(45deg, #1cc88a, #13855c);
                        }
                        .bg-gradient-info {
                            background: linear-gradient(45deg, #36b9cc, #258391);
                        }
                        .icon-circle {
                            width: 60px;
                            height: 60px;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }
                        .card {
                            border: none;
                            border-radius: 15px;
                            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
                            transition: transform 0.2s ease-in-out;
                        }

                        .card:hover {
                            transform: translateY(-3px);
                        }
                    </style>

                    <!-- Ticket Type Statistics -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Ticket Type Statistics</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ticket Type</th>
                                        <th>Stock</th>
                                        <th>Sold</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ticketStats['ticket_types'] as $ticket)
                                    <tr>
                                        <td>{{ $ticket['name'] }}</td>
                                        <td>{{ $ticket['stock'] }}</td>
                                        <td>{{ $ticket['sold'] }}</td>
                                        <td>RM {{ number_format($ticket['total_sales'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-secondary font-weight-bold">
                                        <td colspan="3" class="text-end">Total:</td>
                                        <td>RM {{ number_format(collect($ticketStats['ticket_types'])->sum('total_sales'), 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Monthly Sales -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Monthly Sales</h3>
                        </div>
                        <div class="card-body">
                            @if(isset($ticketStats['monthly_sales']) && !empty($ticketStats['monthly_sales']))
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ticketStats['monthly_sales'] as $sale)
                                                <tr>
                                                    <td>{{ $sale['date'] }}</td>
                                                    <td>RM {{ number_format($sale['total'], 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const eventFilter = document.getElementById('eventFilter');
    
    eventFilter.addEventListener('change', function() {
        window.location.href = `{{ route('admin.reports.index') }}?event=${this.value}`;
    });
});
</script>
@endpush

@endsection 