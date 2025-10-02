@extends('admin.layouts.app')

@section('title', 'ADMIN | Affiliates')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Affiliates</h3>
                    <div>
                        <a href="{{ route('admin.affiliates.export') }}" class="btn btn-success me-2">
                            <i class="bi bi-download me-1"></i>
                            Export Data
                        </a>
                    </div>
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
                        <form id="searchForm" class="row g-3" method="GET" action="{{ route('admin.affiliates.index') }}">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search by User Name, Email, or Code" value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="status">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}" placeholder="Start Date">
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}" placeholder="End Date">
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.affiliates.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Clear
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th>User</th>
                                    <th>Affiliate Code</th>
                                    <th>Name</th>
                                    <th>Clicks</th>
                                    <th>Conversions</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($affiliates as $affiliate)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <div>
                                            <strong>{{ $affiliate->user->name ?? 'N/A' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $affiliate->user->email ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <code>{{ $affiliate->affiliate_code }}</code>
                                    </td>
                                    <td>{{ $affiliate->name ?: 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $affiliate->total_clicks }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $affiliate->total_conversions }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.affiliates.update-status', $affiliate) }}" method="POST" class="d-inline">
                                            @csrf
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="is_active"
                                                       value="1"
                                                       {{ $affiliate->is_active ? 'checked' : '' }}
                                                       onchange="this.form.submit()">
                                                <label class="form-check-label">
                                                    @if($affiliate->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-warning">Inactive</span>
                                                    @endif
                                                </label>
                                            </div>
                                        </form>
                                    </td>
                                    <td>{{ $affiliate->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.affiliates.show', $affiliate) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No affiliates found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $affiliates->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('search');
    const statusSelect = document.querySelector('select[name="status"]');
    const startDateInput = document.querySelector('input[name="start_date"]');
    const endDateInput = document.querySelector('input[name="end_date"]');

    // Auto-submit form when status or date filters change
    statusSelect.addEventListener('change', function() {
        searchForm.submit();
    });

    startDateInput.addEventListener('change', function() {
        searchForm.submit();
    });

    endDateInput.addEventListener('change', function() {
        searchForm.submit();
    });

    // Handle search input with debouncing
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            if (searchInput.value.trim().length > 0) {
                searchForm.submit();
            }
        }, 500);
    });

    // Submit immediately on Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            clearTimeout(searchTimeout);
            searchForm.submit();
        }
    });
});
</script>
@endpush
