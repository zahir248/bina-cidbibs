@extends('admin.layouts.app')

@section('title', 'ADMIN | Tickets')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tickets</h3>
                    <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Add New Ticket
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
                    <div class="mb-3">
                        <form id="searchForm" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchName" placeholder="Search by Ticket Name">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>SKU</th>
                                    <th>Price (RM)</th>
                                    <th>Stock</th>
                                    <th>Categories</th>
                                    <th>Quantity Discounts</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $index => $ticket)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($ticket->image)
                                            <img src="{{ asset($ticket->image) }}" alt="{{ $ticket->name }}" 
                                                 class="img-thumbnail" style="max-width: 100px;">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->name }}</td>
                                    <td>{{ $ticket->sku }}</td>
                                    <td>{{ number_format($ticket->price, 2) }}</td>
                                    <td>{{ $ticket->stock }}</td>
                                    <td>
                                        @php
                                            $categories = is_string($ticket->categories) ? json_decode($ticket->categories, true) : $ticket->categories;
                                        @endphp
                                        @if(is_array($categories))
                                            @foreach($categories as $category)
                                                <span class="badge bg-info me-1">{{ $category }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No categories</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $discounts = is_string($ticket->quantity_discounts) ? json_decode($ticket->quantity_discounts, true) : $ticket->quantity_discounts;
                                        @endphp
                                        @if(is_array($discounts) && !empty($discounts))
                                            @foreach($discounts as $discount)
                                                @if(isset($discount['min']) && isset($discount['price']))
                                                    <span class="badge bg-success me-1">
                                                        @if(isset($discount['max']))
                                                            {{ $discount['min'] }}-{{ $discount['max'] }}x
                                                        @else
                                                            {{ $discount['min'] }}+x
                                                        @endif
                                                        = RM{{ number_format($discount['price'], 2) }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.tickets.edit', $ticket) }}" 
                                               class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $ticket->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modals -->
@foreach($tickets as $ticket)
<div class="modal fade" id="deleteModal{{ $ticket->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $ticket->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $ticket->id }}">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    Delete Confirmation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this ticket?</p>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">{{ $ticket->name }}</h6>
                        <p class="card-text mb-1">
                            <small class="text-muted">SKU: {{ $ticket->sku }}</small>
                        </p>
                        <p class="card-text mb-1">
                            <small class="text-muted">Price: RM {{ number_format($ticket->price, 2) }}</small>
                        </p>
                        <p class="card-text mb-0">
                            <small class="text-muted">Stock: {{ $ticket->stock }}</small>
                        </p>
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
                <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Delete Ticket
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
            const ticketName = nameCell.textContent.toLowerCase();

            if (ticketName.includes(searchTerm)) {
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