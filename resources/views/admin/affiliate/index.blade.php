@extends('admin.layouts.app')

@section('title', 'Affiliate Management')

@push('styles')
<style>
    .filter-card {
        border-left: 4px solid #0d6efd;
    }
    
    .filter-card .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    
    .btn-filter {
        min-width: 100px;
    }
    
    .results-summary {
        background-color: #f8f9fa;
        border-radius: 0.375rem;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
    }
    
    .badge.bg-info {
        font-size: 0.75em;
    }
    
    .search-highlight {
        background-color: #fff3cd;
        border-color: #ffc107;
    }
    
    .form-control-lg {
        font-size: 1.1rem;
        padding: 0.75rem 1rem;
    }
    
    .search-loading {
        position: relative;
    }
    
    .search-loading::after {
        content: '';
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #0d6efd;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: translateY(-50%) rotate(0deg); }
        100% { transform: translateY(-50%) rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const filterForm = document.querySelector('form[method="GET"]');
    let searchTimeout;
    
    // Auto-submit search after user stops typing (500ms delay)
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            if (searchInput.value.trim().length > 0) {
                filterForm.submit();
            }
        }, 500);
    });
    
    // Submit immediately on Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            clearTimeout(searchTimeout);
            filterForm.submit();
        }
    });
    
    // Clear search when clicking clear button
    document.querySelector('a[href="{{ route("admin.affiliates.index") }}"]').addEventListener('click', function(e) {
        e.preventDefault();
        searchInput.value = '';
        filterForm.submit();
    });
    
    // Add loading state during search
    filterForm.addEventListener('submit', function() {
        searchInput.classList.add('search-loading');
    });
});
</script>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Affiliate Management</h2>
                    <p class="text-muted mb-0">Search and manage affiliate links</p>
                </div>
                <div>
                    <a href="{{ route('admin.affiliates.export') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Export Data
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Filter Form -->
            <div class="card mb-4 filter-card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-filter me-2"></i>Filter Affiliates
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.affiliates.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <label for="search" class="form-label">
                                <i class="fas fa-search me-1"></i>Search Affiliates
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Type any name, email, or code to search..."
                                   autocomplete="off">
                            <div class="form-text">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Search by user name, email, affiliate code, or affiliate name
                                </small>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Examples: "john", "ABC123", "john@email.com", "My Affiliate"
                                </small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="start_date" 
                                   name="start_date" 
                                   value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="end_date" 
                                   name="end_date" 
                                   value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-filter">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.affiliates.index') }}" class="btn btn-outline-secondary btn-filter">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <!-- Results Summary -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">
                                Showing {{ $affiliates->count() }} of {{ $affiliates->total() }} affiliates
                                @if(request()->hasAny(['search', 'status', 'start_date', 'end_date']))
                                    <span class="badge bg-info ms-2">Filtered</span>
                                @endif
                            </h6>
                            @if(request()->hasAny(['search', 'status', 'start_date', 'end_date']))
                                <div class="mt-2">
                                    <small class="text-muted">Active filters:</small>
                                    @if(request('search'))
                                        <span class="badge bg-primary me-1">Search: "{{ request('search') }}"</span>
                                    @endif
                                    @if(request('status'))
                                        <span class="badge bg-success me-1">Status: {{ ucfirst(request('status')) }}</span>
                                    @endif
                                    @if(request('start_date'))
                                        <span class="badge bg-warning me-1">From: {{ request('start_date') }}</span>
                                    @endif
                                    @if(request('end_date'))
                                        <span class="badge bg-warning me-1">To: {{ request('end_date') }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @if($affiliates->count() > 0)
                            <div class="text-muted">
                                <small>Page {{ $affiliates->currentPage() }} of {{ $affiliates->lastPage() }}</small>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Affiliate Code</th>
                                    <th>Name</th>
                                    <th>Clicks</th>
                                    <th>Conversions</th>
                                    <th>Orders</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($affiliates as $affiliate)
                                    <tr>
                                        <td>{{ $affiliate->id }}</td>
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
                                            <span class="badge bg-info">{{ $affiliate->orders_count }}</span>
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
                                                </div>
                                            </form>
                                        </td>
                                        <td>{{ $affiliate->created_at->format('M j, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.affiliates.show', $affiliate) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-4">
                                            <i class="fas fa-link fa-2x text-muted mb-2"></i>
                                            <p class="text-muted mb-0">No affiliate links found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($affiliates->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $affiliates->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
