@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Schedule</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-2">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $schedule->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $schedule->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="start_time">Start Time</label>
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time', $schedule->start_time->format('H:i')) }}" required>
                                    @error('start_time')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="end_time">End Time (Optional)</label>
                                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time', $schedule->end_time ? $schedule->end_time->format('H:i') : '') }}">
                                    @error('end_time')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label for="session">Session (Optional)</label>
                            <input type="text" class="form-control @error('session') is-invalid @enderror" id="session" name="session" value="{{ old('session', $schedule->session) }}" placeholder="e.g., 1, 2">
                            @error('session')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="event_type">Event Type</label>
                            <select class="form-control @error('event_type') is-invalid @enderror" id="event_type" name="event_type" required>
                                <option value="">Select Event Type</option>
                                <option value="facility_management" {{ old('event_type', $schedule->event_type) == 'facility_management' ? 'selected' : '' }}>Facility Management</option>
                                <option value="modular_asia" {{ old('event_type', $schedule->event_type) == 'modular_asia' ? 'selected' : '' }}>Modular Asia</option>
                            </select>
                            @error('event_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Schedule</button>
                            <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 