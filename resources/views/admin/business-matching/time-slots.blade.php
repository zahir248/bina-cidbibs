@extends('admin.layouts.app')

@section('title', 'Manage Time Slots')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0 text-white">Manage Time Slots - {{ $businessMatching->name }}</h3>
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

                    <!-- Add Time Slot Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Add New Time Slot</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.business-matching.time-slots.store', $businessMatching) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="start_time" class="form-label">Start Time</label>
                                            <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                                   id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                            @error('start_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="end_time" class="form-label">End Time</label>
                                            <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                                   id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                                            @error('end_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="order" class="form-label">Order</label>
                                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                                   id="order" name="order" value="{{ old('order', $timeSlots->count() + 1) }}" min="1" required>
                                            @error('order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Active Time Slot</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus me-1"></i>Add Time Slot
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Existing Time Slots -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Existing Time Slots ({{ $timeSlots->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @if($timeSlots->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Time Range</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Capacity</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($timeSlots as $timeSlot)
                                                <tr>
                                                    <td>{{ $timeSlot->order }}</td>
                                                    <td>
                                                        <strong>{{ $timeSlot->getFormattedTimeRange() }}</strong>
                                                        @if($timeSlot->getCurrentParticipantsCount() > 0)
                                                            <br><small class="text-success">{{ $timeSlot->getCurrentParticipantsCount() }} participant(s) registered</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $timeSlot->start_time->format('H:i') }}</td>
                                                    <td>{{ $timeSlot->end_time->format('H:i') }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $timeSlot->isFull() ? 'danger' : 'success' }}">
                                                            {{ $timeSlot->getCurrentParticipantsCount() }}/2
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($timeSlot->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-sm btn-warning" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#editTimeSlotModal{{ $timeSlot->id }}">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-danger" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#deleteTimeSlotModal{{ $timeSlot->id }}">
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
                                <p class="text-muted">No time slots configured yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Time Slot Modals -->
@foreach($timeSlots as $timeSlot)
<div class="modal fade" id="editTimeSlotModal{{ $timeSlot->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Time Slot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.business-matching.time-slots.update', $timeSlot) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_start_time_{{ $timeSlot->id }}" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="edit_start_time_{{ $timeSlot->id }}" 
                                       name="start_time" value="{{ $timeSlot->start_time->format('H:i') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_end_time_{{ $timeSlot->id }}" class="form-label">End Time</label>
                                <input type="time" class="form-control" id="edit_end_time_{{ $timeSlot->id }}" 
                                       name="end_time" value="{{ $timeSlot->end_time->format('H:i') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_order_{{ $timeSlot->id }}" class="form-label">Order</label>
                        <input type="number" class="form-control" id="edit_order_{{ $timeSlot->id }}" 
                               name="order" value="{{ $timeSlot->order }}" min="1" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="edit_is_active_{{ $timeSlot->id }}" 
                                   name="is_active" value="1" {{ $timeSlot->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="edit_is_active_{{ $timeSlot->id }}">Active Time Slot</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Time Slot</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Time Slot Modal -->
<div class="modal fade" id="deleteTimeSlotModal{{ $timeSlot->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Time Slot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the time slot "<strong>{{ $timeSlot->getFormattedTimeRange() }}</strong>"?</p>
                <p class="text-danger">This action cannot be undone.</p>
                @if($timeSlot->getCurrentParticipantsCount() > 0)
                    <div class="alert alert-warning">
                        <strong>Warning:</strong> This time slot has {{ $timeSlot->getCurrentParticipantsCount() }} participant(s). Deleting it will affect existing bookings.
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.business-matching.time-slots.delete', $timeSlot) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Time Slot</button>
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
