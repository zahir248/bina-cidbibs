@extends('client.layouts.app')

@section('title', 'BINA | Ticket Detail')

@push('styles')
<style>
    :root {
        --primary-blue: #2563eb;
        --primary-dark: #1e40af;
        --bg-light-gray: #f8fafc;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --mobile-vh: 100vh;
    }
    /* Enhanced Hero Section for Better Mobile Support */
    .hero-section-store {
        min-height: 100vh;
        min-height: 100svh;
        min-height: 100dvh;
        height: 100vh;
        height: 100svh;
        height: 100dvh;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('images/hero-hero-section.png') }}') no-repeat center center;
        background-size: cover;
        background-attachment: scroll;
        text-align: center;
        position: relative;
        padding: 0 1.5rem;
        box-sizing: border-box;
        margin: 0;
        z-index: 1;
        overflow: hidden;
    }
    @supports (-webkit-touch-callout: none) {
        .hero-section-store {
            min-height: -webkit-fill-available;
            height: -webkit-fill-available;
        }
    }
    .hero-title-store {
        font-size: clamp(2rem, 8vw, 4rem);
        font-weight: 800;
        color: #fff;
        margin-bottom: 1rem;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        min-font-size: 1.75rem;
    }
    .breadcrumb-store {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        color: #fff;
        font-size: clamp(1rem, 3vw, 1.25rem);
        font-weight: 500;
        flex-wrap: wrap;
        min-font-size: 0.9rem;
    }
    .breadcrumb-store a {
        color: #fff;
        text-decoration: none;
        opacity: 0.85;
        transition: opacity 0.2s;
    }
    .breadcrumb-store a:hover {
        opacity: 1;
        text-decoration: underline;
    }
    .breadcrumb-separator {
        color: #fff;
        opacity: 0.7;
        font-size: 1.2em;
    }
    @media screen and (max-width: 992px) {
        .hero-section-store {
            min-height: 100vh;
            min-height: 100svh;
            height: 100vh;
            padding: 0 1rem;
        }
    }
    @media screen and (max-width: 768px) {
        .hero-section-store {
            min-height: 100vh;
            min-height: 100svh;
            min-height: 100dvh;
            height: 100vh;
            height: 100svh;
            height: 100dvh;
            padding: 0 1rem;
        }
        .hero-title-store {
            max-width: 90vw;
            word-wrap: break-word;
        }
    }
    @media screen and (max-width: 576px) {
        .hero-section-store {
            min-height: 100vh;
            min-height: 100svh;
            min-height: 100dvh;
            height: 100vh;
            height: 100svh;
            height: 100dvh;
            padding: 0 0.75rem;
            padding-top: env(safe-area-inset-top, 0);
            padding-bottom: env(safe-area-inset-bottom, 0);
            padding-left: max(0.75rem, env(safe-area-inset-left));
            padding-right: max(0.75rem, env(safe-area-inset-right));
        }
    }
    @media screen and (max-width: 375px) {
        .hero-section-store {
            padding: 0 0.5rem;
            min-height: 100vh;
            height: 100vh;
        }
        .hero-title-store {
            font-size: 1.75rem;
            line-height: 1.2;
        }
        .breadcrumb-store {
            font-size: 0.9rem;
        }
    }
    @media screen and (max-height: 500px) and (orientation: landscape) {
        .hero-section-store {
            min-height: 100vh;
            height: 100vh;
            padding: 1rem;
            justify-content: center;
        }
        .hero-title-store {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .breadcrumb-store {
            font-size: 1rem;
        }
    }
    @media screen and (max-width: 768px) {
        .hero-section-store {
            position: relative;
        }
        .hero-section-store.js-mobile-vh {
            height: var(--vh, 100vh);
            min-height: var(--vh, 100vh);
        }
    }
    body {
        margin: 0;
        padding: 0;
    }
    .hero-section-store {
        margin-top: 0;
        position: relative;
        top: 0;
    }
    .btn-zoom {
        background: #ff9800;
        border: none;
        color: #fff;
        font-size: 1.2rem;
        padding: 0.5rem 1.2rem;
        border-radius: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: background 0.2s;
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 2;
    }
    .btn-zoom:hover {
        background: #ffb84d;
        color: #fff;
    }
    .nav-tabs .nav-link.active {
        border-bottom: 2px solid #111;
        font-weight: bold;
        color: #111;
    }
    .nav-tabs .nav-link {
        border: none;
        color: #888;
        background: none;
    }
    .ticket-detail-img {
        width: 100%;
        max-width: 100%;
        height: 300px;
        display: block;
        object-fit: cover;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    @media (max-width: 768px) {
        .ticket-detail-img {
            height: 250px;
        }
    }
    .quantity-selector {
        display: inline-flex;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid #eee;
        margin-right: 1rem;
        vertical-align: middle;
    }
    .quantity-btn {
        background: #ff9800;
        color: #111;
        border: none;
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
    }
    .quantity-btn:active {
        background: #ffb84d;
    }
    .quantity-input {
        width: 48px;
        height: 40px;
        border: none;
        text-align: center;
        font-size: 1.1rem;
        font-weight: 500;
        background: #fff;
        color: #111;
        outline: none;
    }
</style>
@endpush

@section('content')
<!-- Hero Section for Ticket Detail Page (same as store page) -->
<div class="hero-section-store" id="heroSection">
    <h1 class="hero-title-store">Ticket Detail</h1>
    <div class="breadcrumb-store">
        <a href="/">Home</a>
        <span class="breadcrumb-separator">&gt;</span>
        <a href="{{ route('client.store') }}">Store</a>
        <span class="breadcrumb-separator">&gt;</span>
        <span>{{ $ticket->name }}</span>
    </div>
</div>

<div class="container py-5">
    <div class="row align-items-start">
        <!-- Image Column -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="position-relative">
                <img src="{{ asset($ticket->image) }}" alt="Product" class="ticket-detail-img">
            </div>
        </div>
        <!-- Info Column -->
        <div class="col-md-6">
            <h2 class="fw-bold mb-2" style="text-transform:uppercase;">{{ $ticket->name }}</h2>
            <div class="h3 fw-bold mb-3">
                RM {{ number_format($ticket->price, 2) }}
                <span class="badge {{ $ticket->isInStock() ? 'bg-success' : 'bg-danger' }} ms-2">
                    {{ $ticket->isInStock() ? 'In Stock' : 'Out of Stock' }}
                </span>
            </div>
            @if(!empty($ticket->quantity_discounts))
                <h5 class="fw-bold mt-4 mb-2" style="letter-spacing:1px;">QUANTITY DISCOUNTS</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle mb-0" style="min-width:320px;">
                        <thead style="background:#fff;">
                            <tr>
                                <th style="font-weight:700;font-size:1.1rem;">Quantity</th>
                                <th style="font-weight:700;font-size:1.1rem;">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($ticket->quantity_discounts as $discount)
                            <tr>
                                <td style="font-weight:500;">
                                    @if(isset($discount['max']) && $discount['max'])
                                        {{ $discount['min'] }} - {{ $discount['max'] }}
                                    @else
                                        {{ $discount['min'] }}+
                                    @endif
                                </td>
                                <td style="font-weight:500;">RM {{ number_format($discount['price'], 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if(session('success'))
                <div class="alert" style="background:#fff3cd;border:1px solid #ff9800;color:#b26a00;">{{ session('success') }}</div>
            @endif
            @if($ticket->can_select_quantity)
            <form action="{{ route('client.cart.add') }}" method="POST" class="d-flex align-items-center mb-4">
                @csrf
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <div class="quantity-selector">
                    <button type="button" class="quantity-btn" id="qty-minus" {{ !$ticket->isInStock() ? 'disabled' : '' }}>-</button>
                    <input type="text" id="qty-input" class="quantity-input" name="quantity" value="1" min="1" max="{{ $ticket->stock }}" {{ !$ticket->isInStock() ? 'disabled' : '' }} readonly />
                    <button type="button" class="quantity-btn" id="qty-plus" {{ !$ticket->isInStock() ? 'disabled' : '' }}>+</button>
                </div>
                <button type="submit" class="btn btn-dark btn-lg ms-2" {{ !$ticket->isInStock() ? 'disabled' : '' }}>ADD TO CART</button>
                <a href="{{ route('client.cart.index') }}" class="btn btn-warning btn-lg ms-2" title="View Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="fw-bold ms-2">RM {{ number_format($cartTotal ?? 0, 2) }}</span>
                </a>
            </form>
            @else
            <form action="{{ route('client.cart.add') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-dark btn-lg mb-4" {{ !$ticket->isInStock() ? 'disabled' : '' }}>ADD TO CART</button>
                <a href="{{ route('client.cart.index') }}" class="btn btn-warning btn-lg ms-2 mb-4" title="View Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="fw-bold ms-2">RM {{ number_format($cartTotal ?? 0, 2) }}</span>
                </a>
            </form>
            @endif
            <div class="mb-2"><span class="fw-bold">SKU:</span> <span class="text-muted">{{ $ticket->sku }}</span></div>
            <div class="mb-2"><span class="fw-bold">Categories:</span> <span class="text-muted">{{ implode(', ', $ticket->categories) }}</span></div>
        </div>
    </div>
    <hr class="my-5">
    @if($ticket->additional_info)
        <ul class="nav nav-tabs mb-3" id="ticketTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab" aria-controls="desc" aria-selected="true">
                    Description
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="addinfo-tab" data-bs-toggle="tab" data-bs-target="#addinfo" type="button" role="tab" aria-controls="addinfo" aria-selected="false">
                    Additional information
                </button>
            </li>
        </ul>
        <div class="tab-content" id="ticketTabContent">
            <div class="tab-pane fade show active" id="desc" role="tabpanel" aria-labelledby="desc-tab">
                <div>{!! $ticket->description !!}</div>
            </div>
            <div class="tab-pane fade" id="addinfo" role="tabpanel" aria-labelledby="addinfo-tab">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" style="min-width:350px;">
                        <tbody>
                        @foreach(explode("\n", $ticket->additional_info) as $row)
                            @php
                                $cols = explode("\t", $row, 2);
                            @endphp
                            @if(trim($row) !== '')
                            <tr>
                                <td class="fw-semibold" style="background:#fafafa;">{{ $cols[0] ?? '' }}</td>
                                <td>{{ $cols[1] ?? '' }}</td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <h5 class="fw-bold mb-3">Description</h5>
        <div>{!! $ticket->description !!}</div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const minusBtn = document.getElementById('qty-minus');
    const plusBtn = document.getElementById('qty-plus');
    const qtyInput = document.getElementById('qty-input');
    const maxStock = {{ $ticket->stock }};
    
    if (minusBtn && plusBtn && qtyInput) {
        minusBtn.addEventListener('click', function() {
            let val = parseInt(qtyInput.value, 10);
            if (val > 1) qtyInput.value = val - 1;
        });
        
        plusBtn.addEventListener('click', function() {
            let val = parseInt(qtyInput.value, 10);
            if (val < maxStock) qtyInput.value = val + 1;
        });
    }
});
</script>
@endpush 