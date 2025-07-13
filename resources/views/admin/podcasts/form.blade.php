@extends('admin.layouts.app')

@section('title', isset($podcast) ? 'Edit Podcast' : 'Create Podcast')

@push('styles')
<style>
    .form-label {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        border-color: #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.625rem 1rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
    }
    .btn-primary {
        background: #2563eb;
        border-color: #2563eb;
        border-radius: 0.5rem;
        padding: 0.625rem 1.25rem;
        font-weight: 600;
    }
    .btn-primary:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
    }
    .btn-secondary {
        background: #64748b;
        border-color: #64748b;
        border-radius: 0.5rem;
        padding: 0.625rem 1.25rem;
        font-weight: 600;
    }
    .btn-secondary:hover {
        background: #475569;
        border-color: #475569;
    }
    .card {
        border: none;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-radius: 0.75rem;
    }
    .card-header {
        background: #f8f9fa;
        border-bottom: 1px solid #e5e7eb;
        border-radius: 0.75rem 0.75rem 0 0 !important;
        padding: 1rem 1.25rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .image-preview {
        width: 200px;
        height: 150px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 2px solid #e5e7eb;
    }
    .panelist-card {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .remove-panelist {
        color: #ef4444;
        cursor: pointer;
        transition: all 0.2s;
    }
    .remove-panelist:hover {
        color: #dc2626;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center" style="background:#3b82f6;padding:1.5rem;border-radius:0.5rem;">
                    <h3 class="card-title text-white mb-0" style="font-size:1.75rem;font-weight:600;">{{ isset($podcast) ? 'Edit Podcast' : 'Create New Podcast' }}</h3>
                </div>

                <div class="card-body">
                    <form action="{{ isset($podcast) ? route('admin.podcasts.update', $podcast) : route('admin.podcasts.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @if(isset($podcast))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Topic</label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $podcast->title ?? '') }}" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" 
                                               class="form-check-input @error('is_special') is-invalid @enderror" 
                                               id="is_special" 
                                               name="is_special" 
                                               value="1" 
                                               {{ old('is_special', $podcast->is_special ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_special">Special Episode</label>
                                        @error('is_special')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="special-position-field" style="display: none;">
                                        <label for="special_position" class="form-label">Position Relative to Episode</label>
                                        <select class="form-select @error('special_position') is-invalid @enderror" 
                                                id="special_position" 
                                                name="special_position">
                                            <option value="">Select Position</option>
                                            <option value="above" {{ old('special_position', $podcast->special_position ?? '') === 'above' ? 'selected' : '' }}>Above</option>
                                            <option value="below" {{ old('special_position', $podcast->special_position ?? '') === 'below' ? 'selected' : '' }}>Below</option>
                                        </select>
                                        @error('special_position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="episode_number" class="form-label">Episode Number</label>
                                    <input type="number" 
                                           class="form-control @error('episode_number') is-invalid @enderror" 
                                           id="episode_number" 
                                           name="episode_number" 
                                           value="{{ old('episode_number', $podcast->episode_number ?? '') }}" 
                                           required>
                                    @error('episode_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-select @error('type') is-invalid @enderror" 
                                            id="type" 
                                            name="type" 
                                            required>
                                        <option value="">Select Type</option>
                                        <option value="bina" {{ old('type', $podcast->type ?? '') === 'bina' ? 'selected' : '' }}>BINA Podcast</option>
                                        <option value="fm" {{ old('type', $podcast->type ?? '') === 'fm' ? 'selected' : '' }}>FM Podcast</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="youtube_url" class="form-label">YouTube URL (Optional)</label>
                                    <input type="url" 
                                           class="form-control @error('youtube_url') is-invalid @enderror" 
                                           id="youtube_url" 
                                           name="youtube_url" 
                                           value="{{ old('youtube_url', $podcast->youtube_url ?? '') }}" 
                                           placeholder="https://www.youtube.com/watch?v=...">
                                    @error('youtube_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description (Optional)</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4">{{ old('description', $podcast->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="panelists" class="form-label">Panelists (one per line)</label>
                                    <textarea class="form-control @error('panelists') is-invalid @enderror" 
                                              id="panelists" 
                                              name="panelists" 
                                              rows="4"
                                              placeholder="Dr. John Doe - AI Researcher
Jane Smith - Industry Expert
Prof. Sarah Johnson - Data Scientist
Michael Brown - Tech Lead">{{ old('panelists', isset($podcast) && is_array($podcast->panelists) ? implode("\n", $podcast->panelists) : '') }}</textarea>
                                    <small class="form-text text-muted">
                                        Enter each panelist on a new line. You can include their title/role after their name using a hyphen (-).
                                        <br>
                                        Examples:
                                        <ul class="mt-1 mb-0">
                                            <li>Dr. John Doe - AI Researcher</li>
                                            <li>Jane Smith - Industry Expert</li>
                                            <li>Prof. Sarah Johnson - Data Scientist</li>
                                        </ul>
                                    </small>
                                    @error('panelists')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="hidden" name="is_coming_soon" value="0">
                                        <input type="checkbox" 
                                               class="form-check-input @error('is_coming_soon') is-invalid @enderror" 
                                               id="is_coming_soon" 
                                               name="is_coming_soon" 
                                               value="1" 
                                               {{ old('is_coming_soon', $podcast->is_coming_soon ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_coming_soon">Mark as Coming Soon</label>
                                        @error('is_coming_soon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               class="form-check-input @error('is_live_streaming') is-invalid @enderror" 
                                               id="is_live_streaming" 
                                               name="is_live_streaming" 
                                               value="1" 
                                               {{ old('is_live_streaming', $podcast->is_live_streaming ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_live_streaming">Enable Live Streaming</label>
                                        @error('is_live_streaming')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 live-streaming-fields" style="display: none;">
                                    <label for="live_streaming_event" class="form-label">Live Streaming Event Name</label>
                                    <input type="text" 
                                           class="form-control @error('live_streaming_event') is-invalid @enderror" 
                                           id="live_streaming_event" 
                                           name="live_streaming_event" 
                                           value="{{ old('live_streaming_event', $podcast->live_streaming_event ?? '') }}">
                                    @error('live_streaming_event')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image URL (Optional)</label>
                                    <input type="url" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           value="{{ old('image', $podcast->image ?? '') }}"
                                           placeholder="https://drive.google.com/file/d/YOUR_FILE_ID/view?usp=drive_link">
                                    <small class="form-text text-muted">Enter the Google Drive sharing link (e.g., https://drive.google.com/file/d/YOUR_FILE_ID/view?usp=drive_link). The system will automatically convert it to the correct format for display.</small>
                                    @if(isset($podcast) && $podcast->image)
                                        <div class="mt-2">
                                            <img src="{{ $podcast->formatted_image_url }}" 
                                                 alt="Current Image" 
                                                 class="img-thumbnail" 
                                                 style="max-width: 200px;">
                                        </div>
                                    @endif
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    {{ isset($podcast) ? 'Update Podcast' : 'Create Podcast' }}
                                </button>
                                <a href="{{ route('admin.podcasts.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const liveStreamingCheckbox = document.getElementById('is_live_streaming');
    const liveStreamingFields = document.querySelector('.live-streaming-fields');
    const isSpecialCheckbox = document.getElementById('is_special');
    const specialPositionField = document.querySelector('.special-position-field');

    function toggleLiveStreamingFields() {
        liveStreamingFields.style.display = liveStreamingCheckbox.checked ? 'block' : 'none';
    }

    function toggleSpecialPositionField() {
        specialPositionField.style.display = isSpecialCheckbox.checked ? 'block' : 'none';
        if (!isSpecialCheckbox.checked) {
            document.getElementById('special_position').value = '';
        }
    }

    liveStreamingCheckbox.addEventListener('change', toggleLiveStreamingFields);
    isSpecialCheckbox.addEventListener('change', toggleSpecialPositionField);
    
    toggleLiveStreamingFields(); // Initial state
    toggleSpecialPositionField(); // Initial state
});
</script>
@endpush 