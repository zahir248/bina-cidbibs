@if(isset($receiver))
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100 chat-interface-card">
        <div class="card-header py-3" style="background-color: #1B1F31;">
            <div class="d-flex align-items-center">
                <i class="fas fa-comments text-white fs-4 me-2"></i>
                <h5 class="card-title mb-0 text-white">Chat with {{ $receiver->profile ? $receiver->profile->first_name . ' ' . $receiver->profile->last_name : $receiver->name }}</h5>
            </div>
        </div>
        <div class="card-body d-flex flex-column chat-interface-body" style="height: 600px;">
            <!-- Active chat user info -->
            <div class="border-bottom pb-3 mb-3">
                <div class="d-flex align-items-center">
                    <div class="position-relative">
                        @php
                            $avatarUrl = $receiver->avatar 
                                ? (filter_var($receiver->avatar, FILTER_VALIDATE_URL)
                                    ? $receiver->avatar
                                    : route('avatar.show', $receiver->avatar))
                                : asset('images/default-avatar.png');
                        @endphp
                        <img src="{{ $avatarUrl }}" 
                             class="rounded-circle border border-2 border-white shadow-sm" 
                             style="width: 40px; height: 40px; object-fit: cover;"
                             alt="{{ $receiver->profile ? $receiver->profile->first_name . ' ' . $receiver->profile->last_name : $receiver->name }}">
                    </div>
                    <div class="ms-2">
                        <h6 class="mb-0">{{ $receiver->profile ? $receiver->profile->first_name . ' ' . $receiver->profile->last_name : $receiver->name }}</h6>
                        @if($receiver->profile)
                        <p class="text-muted small mb-0">{{ $receiver->profile->job_title ?? 'No title specified' }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Chat messages area -->
            <div id="chat-messages" class="flex-grow-1 overflow-auto mb-3 p-3">
                <!-- Loading animation -->
                <div id="loading-messages" class="loading-wrapper">
                    <div class="loading-dots">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>
                
                <!-- Messages will be inserted here -->
                <div id="messages-container"></div>
                
                <!-- Empty state for no messages -->
                <div id="no-messages" class="text-center py-5">
                    <i class="fas fa-comments text-muted fs-1 mb-3 d-block"></i>
                    <p class="text-muted mb-0">No messages yet. Start the conversation!</p>
                </div>
            </div>

            <!-- Message input -->
            <form method="POST" 
                  id="message-form" 
                  class="mt-auto"
                  action="{{ route('client.community.profile-matching.messages.send') }}"
                  onsubmit="return false;">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="receiver-id" value="{{ $receiver->id }}">
                <div class="input-group">
                    <input type="text" 
                           id="message-input" 
                           name="message" 
                           class="form-control" 
                           placeholder="Type your message..."
                           autocomplete="off"
                           required>
                    <button class="btn btn-orange" 
                            type="button" 
                            id="send-message">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <style>
    .chat-interface-card {
        height: calc(100vh - 200px) !important;
        max-height: 800px;
    }
    
    .chat-interface-body {
        height: 100% !important;
        overflow: hidden;
    }

    #chat-messages {
        overflow-y: auto !important;
        scrollbar-width: thin;
        scrollbar-color: rgba(155, 155, 155, 0.5) transparent;
    }

    #chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    #chat-messages::-webkit-scrollbar-track {
        background: transparent;
    }

    #chat-messages::-webkit-scrollbar-thumb {
        background-color: rgba(155, 155, 155, 0.5);
        border-radius: 20px;
        border: transparent;
    }
    </style>
    @endpush

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatInterface = document.querySelector('.chat-interface-card');
        const chatMessages = document.getElementById('chat-messages');

        if (chatInterface && chatMessages) {
            chatInterface.addEventListener('wheel', function(event) {
                event.preventDefault();
                event.stopPropagation();
                
                // Only scroll the chat messages area
                chatMessages.scrollTop += event.deltaY;
            }, { passive: false });

            // Prevent touch scrolling on mobile
            chatInterface.addEventListener('touchmove', function(event) {
                const target = event.target;
                // Allow scrolling only if we're in the chat messages area
                if (!chatMessages.contains(target)) {
                    event.preventDefault();
                }
            }, { passive: false });
        }
    });
    </script>
    @endpush
@else
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100">
        <div class="card-header py-3" style="background-color: #1B1F31;">
            <div class="d-flex align-items-center">
                <i class="fas fa-comments text-white fs-4 me-2"></i>
                <h5 class="card-title mb-0 text-white">Chat</h5>
            </div>
        </div>
        <div class="card-body d-flex flex-column" style="height: 600px;">
            <!-- Select a chat prompt -->
            <div class="text-center my-auto">
                <i class="fas fa-comments text-orange-light fs-1 mb-3"></i>
                <p class="text-muted">Select a connection to start chatting</p>
            </div>
        </div>
    </div>
@endif 