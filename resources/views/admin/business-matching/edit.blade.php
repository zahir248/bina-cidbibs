@extends('admin.layouts.app')

@section('title', 'Edit Business Matching Session')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Business Matching Session</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
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

                    <form action="{{ route('admin.business-matching.update', $businessMatching) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="event_id" class="form-label">Event</label>
                                    <select class="form-select @error('event_id') is-invalid @enderror" 
                                            id="event_id" name="event_id" required>
                                        <option value="">Select Event</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event->id }}" {{ old('event_id', $businessMatching->event_id) == $event->id ? 'selected' : '' }}>
                                                {{ $event->title }} ({{ $event->start_date->format('M d, Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('event_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Session Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $businessMatching->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                           id="date" name="date" value="{{ old('date', $businessMatching->date->format('Y-m-d')) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="start_time" class="form-label">Start Time</label>
                                            <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                                   id="start_time" name="start_time" value="{{ old('start_time', $businessMatching->start_time->format('H:i')) }}" required>
                                            @error('start_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="end_time" class="form-label">End Time</label>
                                            <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                                   id="end_time" name="end_time" value="{{ old('end_time', $businessMatching->end_time->format('H:i')) }}" required>
                                            @error('end_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4">{{ old('description', $businessMatching->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                               {{ old('is_active', $businessMatching->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Active Session</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i>
                                    Update Session
                                </button>
                                <a href="{{ route('admin.business-matching.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i>
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
