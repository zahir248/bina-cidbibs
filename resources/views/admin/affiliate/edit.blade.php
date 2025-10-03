@extends('admin.layouts.app')

@section('title', 'ADMIN | Edit Affiliate')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit Affiliate</h3>
                    <a href="{{ route('admin.affiliates.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Back to List
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

                    <form action="{{ route('admin.affiliates.update', $affiliate) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Affiliate Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $affiliate->name) }}" 
                                           placeholder="Enter affiliate name"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        This name will be used to identify your affiliate link
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              placeholder="Enter affiliate description (optional)">{{ old('description', $affiliate->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Optional description for your affiliate link
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active', $affiliate->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_active">
                                            Active Status
                                        </label>
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Toggle to activate or deactivate this affiliate link
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Affiliate Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Created By</label>
                                            <p class="form-control-plaintext">
                                                <strong>{{ $affiliate->user->name ?? 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $affiliate->user->email ?? 'N/A' }}</small>
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Affiliate Code</label>
                                            <p class="form-control-plaintext">
                                                <code class="text-primary">{{ $affiliate->affiliate_code }}</code>
                                                <small class="text-muted d-block">8-character unique code</small>
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Current Stats</label>
                                            <p class="form-control-plaintext">
                                                <span class="badge bg-primary me-1">{{ $affiliate->total_clicks }} Clicks</span>
                                                <span class="badge bg-success me-1">{{ $affiliate->total_conversions }} Conversions</span>
                                                <small class="text-muted d-block">Current performance metrics</small>
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Created Date</label>
                                            <p class="form-control-plaintext">
                                                {{ $affiliate->created_at->format('d M Y, H:i') }}
                                                <small class="text-muted d-block">When this affiliate was created</small>
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Affiliate Link</label>
                                            <div class="input-group">
                                                <input type="text" 
                                                       class="form-control form-control-sm" 
                                                       value="{{ $affiliate->affiliate_link }}" 
                                                       readonly>
                                                <button class="btn btn-outline-secondary btn-sm" 
                                                        type="button" 
                                                        onclick="copyToClipboard('{{ $affiliate->affiliate_link }}')">
                                                    <i class="bi bi-copy"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">Click to copy the affiliate link</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.affiliates.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Update Affiliate
                                    </button>
                                </div>
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
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="bi bi-check"></i>';
        button.classList.remove('btn-outline-secondary');
        button.classList.add('btn-success');
        
        setTimeout(function() {
            button.innerHTML = originalHTML;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Failed to copy link to clipboard');
    });
}
</script>
@endpush
