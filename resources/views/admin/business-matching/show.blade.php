@extends('admin.layouts.app')

@section('title', 'Business Matching Session Details')

@section('styles')
<style>
.time-slot-row {
    cursor: pointer !important;
    transition: background-color 0.2s ease;
}

.time-slot-row:hover {
    background-color: #f8f9fa !important;
}

.time-slot-row:active {
    background-color: #e9ecef !important;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0 text-white">{{ $businessMatching->name }}</h3>
                            <p class="text-white mb-0">{{ $businessMatching->event->title }} • {{ $businessMatching->date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.business-matching.index') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Sessions
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title">{{ $stats['total_panels'] }}</h4>
                                            <p class="card-text">Total Panels</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="bi bi-people fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title">{{ $stats['total_bookings'] }}</h4>
                                            <p class="card-text">Total Bookings</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="bi bi-calendar-check fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title">{{ number_format($stats['capacity_utilization'], 1) }}%</h4>
                                            <p class="card-text">Capacity Used</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="bi bi-pie-chart fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card bg-{{ $businessMatching->is_active ? 'success' : 'secondary' }} text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title">{{ $businessMatching->is_active ? 'Active' : 'Inactive' }}</h4>
                                            <p class="card-text">Status</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="bi bi-{{ $businessMatching->is_active ? 'check-circle' : 'pause-circle' }} fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Session Details -->
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Session Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold">Basic Information</h6>
                                            <p><strong>Name:</strong> {{ $businessMatching->name }}</p>
                                            <p><strong>Event:</strong> {{ $businessMatching->event->title }}</p>
                                            <p><strong>Date:</strong> {{ $businessMatching->date->format('M d, Y') }}</p>
                                            <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($businessMatching->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($businessMatching->end_time)->format('H:i') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="fw-bold">Description</h6>
                                            <p>{{ $businessMatching->description ?: 'No description provided.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panels -->
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Panels ({{ $businessMatching->panels->count() }})</h5>
                                    <a href="{{ route('admin.business-matching.panels', $businessMatching) }}" class="btn btn-primary">
                                        <i class="bi bi-people me-2"></i>Manage Panels
                                    </a>
                                </div>
                                <div class="card-body">
                                    @if($businessMatching->panels->count() > 0)
                                        <div class="row">
                                            @foreach($businessMatching->panels as $panel)
                                                <div class="col-md-6 mb-3">
                                                    <div class="border rounded p-3">
                                                        <h6 class="fw-bold mb-2">
                                                            <i class="bi bi-circle-fill text-primary me-2"></i>
                                                            {{ $panel->name }}
                                                        </h6>
                                                        @if($panel->description)
                                                            <p class="text-muted mb-0">{{ $panel->description }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No panels configured yet.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Time Slots -->
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Time Slots ({{ $businessMatching->timeSlots->count() }})</h5>
                                    <a href="{{ route('admin.business-matching.time-slots', $businessMatching) }}" class="btn btn-primary">
                                        <i class="bi bi-clock me-2"></i>Manage Time Slots
                                    </a>
                                </div>
                                <div class="card-body">
                                    @if($businessMatching->timeSlots->count() > 0)
                                        <div class="row">
                                            @foreach($businessMatching->timeSlots as $timeSlot)
                                                <div class="col-md-6 mb-3">
                                                    <div class="border rounded p-3 time-slot-row" 
                                                         data-bs-toggle="modal" 
                                                         data-bs-target="#timeSlotModal{{ $timeSlot->id }}"
                                                         style="cursor: pointer;">
                                                        <h6 class="fw-bold mb-2">
                                                            <i class="bi bi-clock text-primary me-2"></i>
                                                            {{ $timeSlot->getFormattedTimeRange() }}
                                                        </h6>
                                                        <small class="text-muted">
                                                            Capacity: {{ $timeSlot->getCurrentParticipantsCount() }}/3 participants
                                                        </small>
                                                        @if($timeSlot->getCurrentParticipantsCount() > 0)
                                                            <br><small class="text-success">
                                                                <i class="bi bi-people me-1"></i>{{ $timeSlot->getCurrentParticipantsCount() }} participant(s) registered
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No time slots configured yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Quick Actions -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.business-matching.bookings', $businessMatching) }}" class="btn btn-primary">
                                            <i class="bi bi-list me-2"></i>View Bookings
                                        </a>
                                        <a href="{{ route('admin.business-matching.panels', $businessMatching) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-people me-2"></i>Manage Panels
                                        </a>
                                        <a href="{{ route('admin.business-matching.time-slots', $businessMatching) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-clock me-2"></i>Manage Time Slots
                                        </a>
                                        <form action="{{ route('admin.business-matching.toggle-status', $businessMatching) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-{{ $businessMatching->is_active ? 'secondary' : 'success' }} w-100">
                                                <i class="bi bi-{{ $businessMatching->is_active ? 'pause' : 'play' }} me-2"></i>
                                                {{ $businessMatching->is_active ? 'Deactivate' : 'Activate' }} Session
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Bookings -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Recent Bookings</h5>
                                </div>
                                <div class="card-body">
                                    @if($businessMatching->bookings->count() > 0)
                                        @foreach($businessMatching->bookings->take(5) as $booking)
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-person text-muted"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">{{ $booking->participant_name }}</h6>
                                                    <small class="text-muted">{{ $booking->company_name ?: 'No company' }}</small>
                                                    <br>
                                                    <span class="badge bg-success">
                                                        Registered
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($businessMatching->bookings->count() > 5)
                                            <div class="text-center">
                                                <a href="{{ route('admin.business-matching.bookings', $businessMatching) }}" class="btn btn-sm btn-outline-primary">
                                                    View All Bookings
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-muted">No bookings yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Time Slot Participants Modals -->
@foreach($businessMatching->timeSlots as $timeSlot)
<div class="modal fade" id="timeSlotModal{{ $timeSlot->id }}" tabindex="-1" aria-labelledby="timeSlotModalLabel{{ $timeSlot->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timeSlotModalLabel{{ $timeSlot->id }}">
                    <i class="bi bi-clock me-2"></i>Time Slot: {{ $timeSlot->getFormattedTimeRange() }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Time Slot Details</h6>
                        <p class="mb-1"><strong>Time:</strong> {{ $timeSlot->getFormattedTimeRange() }}</p>
                        <p class="mb-1"><strong>Capacity:</strong> {{ $timeSlot->getCurrentParticipantsCount() }}/3 participants</p>
                        <p class="mb-0"><strong>Status:</strong> 
                            @if($timeSlot->getCurrentParticipantsCount() >= 3)
                                <span class="badge bg-danger">Full</span>
                            @elseif($timeSlot->getCurrentParticipantsCount() > 0)
                                <span class="badge bg-warning">Partially Filled</span>
                            @else
                                <span class="badge bg-success">Available</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Registration Progress</h6>
                        <div class="progress mb-2">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: {{ ($timeSlot->getCurrentParticipantsCount() / 3) * 100 }}%"
                                 aria-valuenow="{{ $timeSlot->getCurrentParticipantsCount() }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="3">
                                {{ $timeSlot->getCurrentParticipantsCount() }}/3
                            </div>
                        </div>
                    </div>
                </div>

                @if($timeSlot->bookings->count() > 0)
                    <h6 class="fw-bold mb-3">Registered Participants ({{ $timeSlot->bookings->count() }})</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Business Type</th>
                                    <th>Phone</th>
                                    <th>Registration Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($timeSlot->bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>{{ $booking->participant_name }}</strong>
                                        @if($booking->user)
                                            <br><small class="text-muted">User: {{ $booking->user->name }}</small>
                                        @else
                                            <br><small class="text-muted">Guest User</small>
                                        @endif
                                    </td>
                                    <td>{{ $booking->company_name ?: '-' }}</td>
                                    <td>{{ $booking->business_type ?: '-' }}</td>
                                    <td>{{ $booking->participant_phone ?: '-' }}</td>
                                    <td>{{ $booking->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-people fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">No participants registered for this time slot</h6>
                        <p class="text-muted">This time slot is available for registration.</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                @if($timeSlot->bookings->count() > 0)
                    <a href="{{ route('admin.business-matching.export-time-slot-bookings', ['businessMatching' => $businessMatching, 'timeSlot' => $timeSlot]) }}" class="btn btn-success">
                        <i class="bi bi-download me-2"></i>Download Excel
                    </a>
                @endif
                <a href="{{ route('admin.business-matching.time-slots', $businessMatching) }}" class="btn btn-primary">
                    <i class="bi bi-gear me-2"></i>Manage Time Slots
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Add hover effect to clickable time slots
    document.addEventListener('DOMContentLoaded', function() {
        const clickableRows = document.querySelectorAll('.time-slot-row');
        clickableRows.forEach(function(row) {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    });
</script>
@endsection
