@extends('admin.layouts.app')

@section('title', 'ADMIN | Documentation')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 fw-bold text-primary mb-2">System Documentation</h1>
            <p class="text-muted">Access and download user manuals for both administrators and clients.</p>
        </div>
    </div>

    <div class="row">
        <!-- Admin Manual -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-lock me-2"></i>
                        Administrator Manual
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Comprehensive guide for system administrators on managing the ticketing system, users, and generating reports.</p>
                    <div class="d-flex gap-2">
                        <a href="#admin-manual" class="btn btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#admin-manual" role="button" aria-expanded="false" aria-controls="admin-manual">
                            <i class="bi bi-eye me-2"></i>View
                        </a>
                        <a href="{{ route('admin.documentation.download', 'admin') }}" class="btn btn-primary">
                            <i class="bi bi-download me-2"></i>Download
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Client Manual -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person me-2"></i>
                        Client Manual
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Step-by-step guide for clients on how to register, browse events, purchase tickets, and manage their profile.</p>
                    <div class="d-flex gap-2">
                        <a href="#client-manual" class="btn btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#client-manual" role="button" aria-expanded="false" aria-controls="client-manual">
                            <i class="bi bi-eye me-2"></i>View
                        </a>
                        <a href="{{ route('admin.documentation.download', 'client') }}" class="btn btn-primary">
                            <i class="bi bi-download me-2"></i>Download
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Documentation -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-diagram-3 me-2"></i>
                        System Documentation
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Technical documentation covering system architecture, database design, and implementation details for developers.</p>
                    <div class="d-flex gap-2">
                        <a href="#system-manual" class="btn btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#system-manual" role="button" aria-expanded="false" aria-controls="system-manual">
                            <i class="bi bi-eye me-2"></i>View
                        </a>
                        <a href="{{ route('admin.documentation.download', 'system') }}" class="btn btn-primary">
                            <i class="bi bi-download me-2"></i>Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Manuals Accordion -->
    <div class="accordion" id="manualsAccordion">
        <!-- Admin Manual Content -->
        <div class="accordion-item">
            <div class="collapse" id="admin-manual" data-bs-parent="#manualsAccordion">
                <div class="card card-body mb-4">
                    @include('admin.documentation.admin-manual')
                </div>
            </div>
        </div>

        <!-- Client Manual Content -->
        <div class="accordion-item">
            <div class="collapse" id="client-manual" data-bs-parent="#manualsAccordion">
                <div class="card card-body mb-4">
                    @include('admin.documentation.client-manual')
                </div>
            </div>
        </div>

        <!-- System Documentation Content -->
        <div class="accordion-item">
            <div class="collapse" id="system-manual" data-bs-parent="#manualsAccordion">
                <div class="card card-body mb-4">
                    @include('admin.documentation.system-manual')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 