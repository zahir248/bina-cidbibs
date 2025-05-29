@extends('admin.layouts.app')

@section('title', 'ADMIN | Schedules')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Schedules</h3>
                    <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Add New Schedule
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Search and Filter Form -->
                    <div class="mb-3">
                        <form id="searchForm" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchTitle" placeholder="Search by Title">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="filterEventType">
                                    <option value="">All Event Types</option>
                                    <option value="facility_management">Facility Management</option>
                                    <option value="modular_asia">Modular Asia</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Time</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Session</th>
                                    <th>Event Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $index => $schedule)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $schedule->formatted_time ?: '-' }}</td>
                                    <td>{{ $schedule->title ?: '-' }}</td>
                                    <td>{{ $schedule->description ? Str::limit($schedule->description, 100) : '-' }}</td>
                                    <td>{{ $schedule->session ?: '-' }}</td>
                                    <td>{{ $schedule->event_type ? ucfirst(str_replace('_', ' ', $schedule->event_type)) : '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $schedule->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modals -->
@foreach($schedules as $schedule)
<div class="modal fade" id="deleteModal{{ $schedule->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $schedule->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $schedule->id }}">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    Delete Confirmation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this schedule?</p>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">{{ $schedule->title }}</h6>
                        <p class="card-text mb-1">
                            <small class="text-muted">Time: {{ $schedule->formatted_time }}</small>
                        </p>
                        <p class="card-text mb-1">
                            <small class="text-muted">Session: {{ $schedule->session }}</small>
                        </p>
                        <p class="card-text mb-0">
                            <small class="text-muted">Event Type: {{ ucfirst(str_replace('_', ' ', $schedule->event_type)) }}</small>
                        </p>
                    </div>
                </div>
                <div class="alert alert-danger mb-0">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    This action cannot be undone. All associated data will be permanently deleted.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>
                    Cancel
                </button>
                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Delete Schedule
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search and filter functionality
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchTitle');
    const filterEventType = document.getElementById('filterEventType');
    const tableRows = document.querySelectorAll('tbody tr');

    function filterRows() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const eventType = filterEventType.value;

        tableRows.forEach(row => {
            const titleCell = row.querySelector('td:nth-child(3)');
            const eventTypeCell = row.querySelector('td:nth-child(6)');
            const scheduleTitle = titleCell.textContent.toLowerCase();
            const scheduleEventType = eventTypeCell.textContent.trim().toLowerCase().replace(/ /g, '_');

            const matchesTitle = scheduleTitle.includes(searchTerm);
            const matchesEventType = !eventType || scheduleEventType === eventType;

            if (matchesTitle && matchesEventType) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        filterRows();
    });

    filterEventType.addEventListener('change', function() {
        filterRows();
    });
});
</script>
@endpush
@endsection 