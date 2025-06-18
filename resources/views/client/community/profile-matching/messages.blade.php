@extends('client.community.layouts.app')

@section('title', 'Messages | BINA Community')

@section('styles')
<link href="{{ asset('css/chat.css') }}" rel="stylesheet">
<style>
.connection-item {
    transition: background-color 0.2s ease;
}

.connection-item:hover {
    background-color: rgba(0, 0, 0, 0.05) !important;
}

.connection-item.active {
    background-color: rgba(0, 0, 0, 0.05) !important;
    color: inherit !important;
}

.connection-item.active h6,
.connection-item.active p {
    color: inherit !important;
}

.connection-item.active .text-muted {
    color: #6c757d !important;
}
</style>
@endsection

@section('content')
<div class="container py-4 chat-container">
    <div class="row">
        <div class="col-12">
            <div class="section-title text-center mb-5">
                <h2 class="display-5 fw-bold" style="color: #1B1F31;">Messages</h2>
                <p class="text-muted lead">Chat with your connections</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Connections List -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header py-3" style="background-color: #1B1F31;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-users text-white fs-4 me-2"></i>
                        <h5 class="card-title mb-0 text-white">Your Connections</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($connections->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-user-friends text-orange-light fs-1 mb-3"></i>
                            <p class="text-muted mb-0">You haven't connected with anyone yet.</p>
                            <a href="{{ route('client.community.profile-matching') }}" class="btn btn-orange mt-3">
                                <i class="fas fa-search me-1"></i>Find Connections
                            </a>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($connections as $connection)
                                <a href="{{ route('client.community.profile-matching.messages', ['user_id' => $connection->id]) }}" 
                                   class="connection-item list-group-item list-group-item-action border-0 d-flex align-items-center p-3 {{ request()->query('user_id') == $connection->id ? 'active' : '' }}">
                                    <div class="position-relative">
                                        @php
                                            $avatarUrl = $connection->avatar 
                                                ? (filter_var($connection->avatar, FILTER_VALIDATE_URL)
                                                    ? $connection->avatar
                                                    : route('avatar.show', $connection->avatar))
                                                : asset('images/default-avatar.png');
                                        @endphp
                                        <img src="{{ $avatarUrl }}" 
                                             class="rounded-circle border border-2 border-white shadow-sm" 
                                             style="width: 48px; height: 48px; object-fit: cover;"
                                             alt="{{ $connection->profile->first_name }} {{ $connection->profile->last_name }}">
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">{{ $connection->profile->first_name }} {{ $connection->profile->last_name }}</h6>
                                        <p class="text-muted small mb-0">
                                            <i class="fas fa-briefcase me-1"></i>
                                            {{ $connection->profile->job_title ?? 'No title specified' }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-md-8">
            @include('client.community.profile-matching.partials.chat-interface')
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/chat.js') }}"></script>
@endsection 
