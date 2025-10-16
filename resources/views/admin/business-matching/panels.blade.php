@extends('admin.layouts.app')

@section('title', 'Manage Panels')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0 text-white">Manage Panels - {{ $businessMatching->name }}</h3>
                            <p class="text-white mb-0">{{ $businessMatching->event->title }} • {{ $businessMatching->date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.business-matching.show', $businessMatching) }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Session
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

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Add Panel Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Add New Panel</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.business-matching.panels.store', $businessMatching) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Panel Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="order" class="form-label">Order</label>
                                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                                   id="order" name="order" value="{{ old('order', $panels->count() + 1) }}" min="1" required>
                                            @error('order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Active Panel</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus me-1"></i>Add Panel
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Existing Panels -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Existing Panels ({{ $panels->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @if($panels->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($panels as $panel)
                                                <tr>
                                                    <td>{{ $panel->order }}</td>
                                                    <td>{{ $panel->name }}</td>
                                                    <td>{{ $panel->description ?: 'No description' }}</td>
                                                    <td>
                                                        @if($panel->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-sm btn-warning" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#editPanelModal{{ $panel->id }}">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-danger" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#deletePanelModal{{ $panel->id }}">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No panels configured yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Panel Modals -->
@foreach($panels as $panel)
<div class="modal fade" id="editPanelModal{{ $panel->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Panel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.business-matching.panels.update', $panel) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name_{{ $panel->id }}" class="form-label">Panel Name</label>
                        <input type="text" class="form-control" id="edit_name_{{ $panel->id }}" 
                               name="name" value="{{ $panel->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_order_{{ $panel->id }}" class="form-label">Order</label>
                        <input type="number" class="form-control" id="edit_order_{{ $panel->id }}" 
                               name="order" value="{{ $panel->order }}" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description_{{ $panel->id }}" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description_{{ $panel->id }}" 
                                  name="description" rows="3">{{ $panel->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="edit_is_active_{{ $panel->id }}" 
                                   name="is_active" value="1" {{ $panel->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="edit_is_active_{{ $panel->id }}">Active Panel</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Panel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Panel Modal -->
<div class="modal fade" id="deletePanelModal{{ $panel->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Panel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the panel "<strong>{{ $panel->name }}</strong>"?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.business-matching.panels.delete', $panel) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Panel</button>
                </form>
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
