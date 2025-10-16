@extends('admin.layouts.app')

@section('title', 'Business Matching Bookings - ' . $businessMatching->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0 text-white">Business Matching Bookings</h3>
                            <p class="text-white mb-0">{{ $businessMatching->name }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.business-matching.show', $businessMatching) }}" class="btn btn-primary me-2">
                                <i class="bi bi-arrow-left me-2"></i>Back to Session
                            </a>
                            <a href="{{ route('admin.business-matching.export-bookings', $businessMatching) }}" class="btn btn-success">
                                <i class="bi bi-download me-2"></i>Export Bookings
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

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Search and Filters -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.business-matching.bookings', $businessMatching) }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="search" class="form-label">Search Bookings</label>
                                            <input type="text" class="form-control" id="search" name="search" 
                                                   value="{{ request('search') }}" 
                                                   placeholder="Search by name, email, or company...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="time_slot" class="form-label">Filter by Time Slot</label>
                                            <select class="form-select" id="time_slot" name="time_slot">
                                                <option value="">All Time Slots</option>
                                                @foreach($timeSlots as $timeSlot)
                                                    <option value="{{ $timeSlot->id }}" 
                                                            {{ request('time_slot') == $timeSlot->id ? 'selected' : '' }}>
                                                        {{ $timeSlot->getFormattedTimeRange() }}
                                                        ({{ $timeSlot->getCurrentParticipantsCount() }}/2 participants)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">&nbsp;</label>
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-search me-2"></i>Search
                                                </button>
                                                @if(request('search') || request('time_slot'))
                                                    <a href="{{ route('admin.business-matching.bookings', $businessMatching) }}" class="btn btn-outline-secondary">
                                                        <i class="bi bi-x-circle me-2"></i>Clear Filters
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Bookings Table -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-people me-2"></i>Bookings ({{ $bookings->total() }} total)
                                </h5>
                                @if(request('time_slot'))
                                    @php
                                        $selectedTimeSlot = $timeSlots->where('id', request('time_slot'))->first();
                                    @endphp
                                    @if($selectedTimeSlot)
                                        <span class="badge bg-info">
                                            <i class="bi bi-clock me-1"></i>Filtered by: {{ $selectedTimeSlot->getFormattedTimeRange() }}
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                    @if($bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Participant</th>
                                        <th>Contact</th>
                                        <th>Company</th>
                                        <th>Time Slot</th>
                                        <th>Business Type</th>
                                        <th>Registered</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">{{ $booking->getReferenceNumber() }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $booking->participant_name }}</strong>
                                                    @if($booking->identity_number)
                                                        <br><small class="text-muted">ID: {{ $booking->identity_number }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div>{{ $booking->participant_email }}</div>
                                                    @if($booking->participant_phone)
                                                        <small class="text-muted">{{ $booking->participant_phone }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($booking->company_name)
                                                    {{ $booking->company_name }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $booking->timeSlot->getFormattedTimeRange() }}</span>
                                            </td>
                                            <td>
                                                @if($booking->business_type)
                                                    <span class="badge bg-secondary">{{ $booking->business_type }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $booking->created_at->format('M d, Y H:i') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-info btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#bookingModal{{ $booking->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <a href="{{ route('client.business-matching.download', $booking) }}" 
                                                       class="btn btn-outline-success btn-sm" target="_blank">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $bookings->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-people fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No Bookings Found</h4>
                            <p class="text-muted">
                                @if(request('search'))
                                    No bookings found matching your search criteria.
                                @else
                                    No bookings have been registered for this business matching session yet.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Booking Details Modals -->
@foreach($bookings as $booking)
<div class="modal fade" id="bookingModal{{ $booking->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Booking Details - {{ $booking->getReferenceNumber() }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Participant Information</h6>
                        <p><strong>Name:</strong> {{ $booking->participant_name }}</p>
                        <p><strong>Email:</strong> {{ $booking->participant_email }}</p>
                        @if($booking->participant_phone)
                            <p><strong>Phone:</strong> {{ $booking->participant_phone }}</p>
                        @endif
                        @if($booking->identity_number)
                            <p><strong>Identity Number:</strong> {{ $booking->identity_number }}</p>
                        @endif
                        @if($booking->company_name)
                            <p><strong>Company:</strong> {{ $booking->company_name }}</p>
                        @endif
                        @if($booking->business_type)
                            <p><strong>Business Type:</strong> {{ $booking->business_type }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Session Information</h6>
                        <p><strong>Time Slot:</strong> {{ $booking->timeSlot->getFormattedTimeRange() }}</p>
                        <p><strong>Panel:</strong> <span class="text-muted">Auto-assigned</span></p>
                        <p><strong>Registered:</strong> {{ $booking->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Reference:</strong> {{ $booking->getReferenceNumber() }}</p>
                    </div>
                </div>
                
                @if($booking->interests && count($booking->interests) > 0)
                    <div class="mt-3">
                        <h6 class="fw-bold">Areas of Interest</h6>
                        <div>
                            @foreach($booking->interests as $interest)
                                <span class="badge bg-light text-dark me-1 mb-1">{{ $interest }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('client.business-matching.download', $booking) }}" 
                   class="btn btn-success" target="_blank">
                    <i class="bi bi-download me-2"></i>Download PDF
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
</script>
@endsection
