@extends('admin.layouts.app')

@section('title', 'ADMIN | Business Matching')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Business Matching</h3>
                    <a href="{{ route('admin.business-matching.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Create Session
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Search Form -->
                    <div class="mb-3">
                        <form id="searchForm" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchName" placeholder="Search by Session Name">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th>Session Name</th>
                                    <th>Event</th>
                                    <th>Date & Time</th>
                                    <th>Bookings</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($businessMatchings as $businessMatching)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="session-name">
                                        <div>
                                            <strong>{{ $businessMatching->name }}</strong>
                                            @if($businessMatching->description)
                                                <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($businessMatching->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $businessMatching->event->title }}</td>
                                    <td>
                                        <div>
                                            <strong>{{ $businessMatching->date->format('d M Y') }}</strong><br>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($businessMatching->start_time)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($businessMatching->end_time)->format('H:i') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $businessMatching->bookings->count() }}</strong> registered<br>
                                            <small class="text-muted">{{ $businessMatching->panels->count() }} panels</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($businessMatching->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.business-matching.show', $businessMatching) }}" 
                                               class="btn btn-sm btn-primary" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.business-matching.edit', $businessMatching) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $businessMatching->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No business matching sessions found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $businessMatchings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modals -->
@foreach($businessMatchings as $businessMatching)
<div class="modal fade" id="deleteModal{{ $businessMatching->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $businessMatching->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $businessMatching->id }}">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    Delete Confirmation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this business matching session?</p>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">{{ $businessMatching->name }}</h6>
                        <p class="card-text mb-1">
                            <small class="text-muted">Event: {{ $businessMatching->event->title }}</small>
                        </p>
                        <p class="card-text mb-1">
                            <small class="text-muted">Date: {{ $businessMatching->date->format('d M Y') }}</small>
                        </p>
                        <p class="card-text mb-0">
                            <small class="text-muted">Bookings: {{ $businessMatching->bookings->count() }} registered</small>
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
                <form action="{{ route('admin.business-matching.destroy', $businessMatching) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Delete Session
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchName');
    const tableRows = document.querySelectorAll('tbody tr');

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const searchTerm = searchInput.value.toLowerCase().trim();

        tableRows.forEach(row => {
            const nameCell = row.querySelector('td:nth-child(2)');
            const sessionName = nameCell.textContent.toLowerCase();

            if (sessionName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Clear search when input is cleared
    searchInput.addEventListener('input', function() {
        if (this.value === '') {
            tableRows.forEach(row => {
                row.style.display = '';
            });
        }
    });
});
</script>
@endpush
