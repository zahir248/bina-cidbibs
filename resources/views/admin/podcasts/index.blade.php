@extends('admin.layouts.app')

@section('title', 'ADMIN | Podcasts')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Podcasts</h3>
                    <a href="{{ route('admin.podcasts.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Add New Podcast
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Search Form -->
                    <div class="mb-4">
                        <form id="searchForm" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchName" placeholder="Search by Podcast Name" style="border-radius:0.5rem 0 0 0.5rem;border-color:#e5e7eb;padding:0.625rem 1rem;">
                                    <button class="btn text-white d-flex align-items-center gap-2" type="submit" style="background:#3b82f6;border-radius:0 0.5rem 0.5rem 0;padding:0.625rem 1.5rem;">
                                        <i class="fas fa-search"></i>
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- BINA Podcasts Table -->
                    <div class="mb-4">
                        <h4 class="mb-3" style="color:#1e293b;font-weight:600;">BINA Podcasts</h4>
                        <div class="table-responsive" style="background:white;border-radius:0.5rem;overflow:hidden;">
                            <table class="table mb-0">
                                <thead style="background:#3b82f6;">
                                    <tr>
                                        <th class="text-white" style="padding:1rem;font-weight:500;">No</th>
                                        <th class="text-white" style="padding:1rem;font-weight:500;">Image</th>
                                        <th class="text-white" style="padding:1rem;font-weight:500;">Topic</th>
                                        <th class="text-white" style="padding:1rem;font-weight:500;">Episode</th>
                                        <th class="text-white" style="padding:1rem;font-weight:500;">Status</th>
                                        <th class="text-white" style="padding:1rem;font-weight:500;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($binaPodcasts as $index => $podcast)
                                    <tr>
                                        <td style="padding:1rem;vertical-align:middle;">{{ $index + 1 }}</td>
                                        <td style="padding:1rem;vertical-align:middle;">
                                            @if($podcast->image)
                                                <img src="{{ $podcast->formatted_image_url }}" alt="Podcast Image" style="width:80px;height:60px;object-fit:cover;border-radius:0.25rem;">
                                            @else
                                                <div style="width:80px;height:60px;background:#f8fafc;border-radius:0.25rem;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-podcast text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td style="padding:1rem;vertical-align:middle;">
                                            <div style="font-weight:500;">{!! $podcast->formatted_title !!}</div>
                                            @if($podcast->is_live_streaming)
                                                <div class="text-muted small">
                                                    <i class="fas fa-broadcast-tower"></i> {{ $podcast->live_streaming_event }}
                                                </div>
                                            @endif
                                        </td>
                                        <td style="padding:1rem;vertical-align:middle;">
                                            @if($podcast->is_special)
                                                <span style="font-weight:500;">Special Edition</span>
                                            @else
                                                Episode {{ $podcast->episode_number }}
                                            @endif
                                        </td>
                                        <td style="padding:1rem;vertical-align:middle;">
                                            @if($podcast->is_coming_soon)
                                                <span class="badge" style="background:#fee2e2;color:#991b1b;padding:0.25rem 0.75rem;border-radius:9999px;font-size:0.75rem;font-weight:500;">Coming Soon</span>
                                            @else
                                                <span class="badge" style="background:#dcfce7;color:#166534;padding:0.25rem 0.75rem;border-radius:9999px;font-size:0.75rem;font-weight:500;">Published</span>
                                            @endif
                                        </td>
                                        <td style="padding:1rem;vertical-align:middle;">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.podcasts.edit', $podcast) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal{{ $podcast->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-muted mb-0">No BINA podcasts found.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- FM Podcasts Table -->
                    <div>
                        <h4 class="mb-3" style="color:#1e293b;font-weight:600;">FM Podcasts</h4>
                        <div class="table-responsive" style="background:white;border-radius:0.5rem;overflow:hidden;">
                            <table class="table mb-0">
                                <thead style="background:#3b82f6;">
                                    <tr>
                                        <th class="text-white" style="padding:1rem;font-weight:500;">No</th>
                                        <th class="text-white" style="padding:1rem;font-weight:500;">Image</th>
                                        <th class="text-white" style="padding:1rem;font-weight:500;">Name</th>
                                        <th class="text-white" style="padding:1rem;font-weight:500;">Episode</th>
                                        <th class="text-white" style="padding:1rem;font-weight:500;">Status</th>
                                        <th class="text-white" style="padding:1rem;font-weight:500;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($fmPodcasts as $index => $podcast)
                                    <tr>
                                        <td style="padding:1rem;vertical-align:middle;">{{ $index + 1 }}</td>
                                        <td style="padding:1rem;vertical-align:middle;">
                                            @if($podcast->image)
                                                <img src="{{ $podcast->formatted_image_url }}" alt="Podcast Image" style="width:80px;height:60px;object-fit:cover;border-radius:0.25rem;">
                                            @else
                                                <div style="width:80px;height:60px;background:#f8fafc;border-radius:0.25rem;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-podcast text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td style="padding:1rem;vertical-align:middle;">
                                            <div style="font-weight:500;">{!! $podcast->formatted_title !!}</div>
                                            @if($podcast->is_live_streaming)
                                                <div class="text-muted small">
                                                    <i class="fas fa-broadcast-tower"></i> {{ $podcast->live_streaming_event }}
                                                </div>
                                            @endif
                                        </td>
                                        <td style="padding:1rem;vertical-align:middle;">
                                            @if($podcast->is_special)
                                                <span style="font-weight:500;">Special Edition</span>
                                            @else
                                                Episode {{ $podcast->episode_number }}
                                            @endif
                                        </td>
                                        <td style="padding:1rem;vertical-align:middle;">
                                            @if($podcast->is_coming_soon)
                                                <span class="badge" style="background:#fee2e2;color:#991b1b;padding:0.25rem 0.75rem;border-radius:9999px;font-size:0.75rem;font-weight:500;">Coming Soon</span>
                                            @else
                                                <span class="badge" style="background:#dcfce7;color:#166534;padding:0.25rem 0.75rem;border-radius:9999px;font-size:0.75rem;font-weight:500;">Published</span>
                                            @endif
                                        </td>
                                        <td style="padding:1rem;vertical-align:middle;">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.podcasts.edit', $podcast) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal{{ $podcast->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-muted mb-0">No FM podcasts found.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modals -->
@foreach($binaPodcasts->merge($fmPodcasts) as $podcast)
<div class="modal fade" id="deleteModal{{ $podcast->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $podcast->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $podcast->id }}">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    Delete Confirmation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this podcast?</p>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">{{ $podcast->title }}</h6>
                        <p class="card-text mb-1">
                            <small class="text-muted">Episode: {{ $podcast->episode_number }}</small>
                        </p>
                        <p class="card-text mb-1">
                            <small class="text-muted">Type: {{ ucfirst($podcast->type) }} Podcast</small>
                        </p>
                        @if($podcast->is_live_streaming)
                        <p class="card-text mb-0">
                            <small class="text-muted">Live Streaming: {{ $podcast->live_streaming_event }}</small>
                        </p>
                        @endif
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
                <form action="{{ route('admin.podcasts.destroy', $podcast) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Delete Podcast
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
            const nameCell = row.querySelector('td:nth-child(3)');
            const podcastName = nameCell.textContent.toLowerCase();

            if (podcastName.includes(searchTerm)) {
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