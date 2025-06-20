// Cross-browser compatibility wrapper
(function() {
    'use strict';

function initializeChat() {
        var isLoadingMessages = false;
        var lastMessageId = 0;
        var messageCheckInterval = null;

    function debug(message) {
            if (window.console && console.log) {
        console.log(message);
            }
        }

        function getCSRFToken() {
            var metaToken = document.querySelector('meta[name="csrf-token"]');
            var inputToken = document.querySelector('input[name="_token"]');
            return (metaToken && metaToken.getAttribute('content')) || 
                   (inputToken && inputToken.value) || '';
    }

    function showLoading() {
            var loadingElement = document.getElementById('loading-messages');
        if (loadingElement) {
            loadingElement.style.display = 'flex';
        }
    }

    function hideLoading() {
            var loadingElement = document.getElementById('loading-messages');
        if (loadingElement) {
            loadingElement.style.display = 'none';
        }
    }

        function scrollToBottom(element) {
            if (element) {
                element.scrollTop = element.scrollHeight;
            }
        }

        function updateMessagesDisplay(messages) {
            var chatMessages = document.getElementById('chat-messages');
            var messagesContainer = document.getElementById('messages-container');
            var noMessages = document.getElementById('no-messages');
            
            if (!chatMessages || !messagesContainer || !noMessages) return;

            if (!messages || !messages.length) {
                messagesContainer.innerHTML = '';
                messagesContainer.style.display = 'none';
                noMessages.style.display = 'block';
                return;
            }

            messagesContainer.style.display = 'block';
            noMessages.style.display = 'none';
                
            // Create a copy of messages array for sorting
            var sortedMessages = messages.slice().sort(function(a, b) {
                var timeA = new Date(a.time).getTime();
                var timeB = new Date(b.time).getTime();
                if (timeA === timeB) {
                    return a.id - b.id;
                }
                return timeA - timeB;
            });
            
            messagesContainer.innerHTML = '';
            
            sortedMessages.forEach(message => {
                var messageElement = document.createElement('div');
                var isSent = message.is_sent === true; // Ensure boolean comparison
                debug('Message ' + message.id + ' is_sent: ' + isSent);
                messageElement.className = 'message ' + (isSent ? 'message-sent' : 'message-received');
                messageElement.setAttribute('data-message-id', message.id);
                messageElement.setAttribute('data-timestamp', message.time);
                messageElement.setAttribute('data-is-sent', isSent);
                messageElement.innerHTML = 
                    '<div class="message-wrapper">' + 
                    (message.content || '').replace(/</g, '&lt;').replace(/>/g, '&gt;') + 
                    '</div>' +
                    '<div class="message-time">' + 
                    (message.display_time || '') + 
                    '</div>';
                messagesContainer.appendChild(messageElement);
                lastMessageId = Math.max(lastMessageId, message.id);
            });

            scrollToBottom(chatMessages);
    }

    function sendMessage() {
        debug('Sending message');
        
            var input = document.getElementById('message-input');
            var receiverIdElement = document.getElementById('receiver-id');
            
            if (!input || !receiverIdElement) return;
            
            var receiverId = receiverIdElement.value;
            var message = (input.value || '').trim();
        
        if (!message || !receiverId) {
            debug('No message or no receiver ID');
            return;
        }

            var sendButton = document.getElementById('send-message');
        
            if (sendButton) sendButton.disabled = true;
        input.disabled = true;

            var token = getCSRFToken();

        debug('Sending fetch request');

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/community/profile-matching/messages/send', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
            xhr.setRequestHeader('Accept', 'application/json');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        debug('Message sent successfully');
                        var data = JSON.parse(xhr.responseText);
                        
                        var noMessages = document.getElementById('no-messages');
                        var messagesContainer = document.getElementById('messages-container');
                        
                        if (noMessages && messagesContainer) {
                            noMessages.style.display = 'none';
                            messagesContainer.style.display = 'block';
                        }

                        var messageElement = document.createElement('div');
                        messageElement.className = 'message message-sent';
                        messageElement.setAttribute('data-message-id', data.message.id);
                        messageElement.setAttribute('data-timestamp', data.message.time);
                        messageElement.innerHTML = 
                            '<div class="message-wrapper">' + 
                            (data.message.content || '').replace(/</g, '&lt;').replace(/>/g, '&gt;') + 
                            '</div>' +
                            '<div class="message-time">' + 
                            (data.message.display_time || '') + 
                            '</div>';
                        
                        if (messagesContainer) {
                            messagesContainer.appendChild(messageElement);
                        }

                        lastMessageId = Math.max(lastMessageId, data.message.id);
                        input.value = '';

                        var chatMessages = document.getElementById('chat-messages');
                        scrollToBottom(chatMessages);
                    } else {
                        debug('Error sending message: ' + xhr.status);
                        window.alert('Failed to send message. Please try again.');
                    }
                    
                    if (sendButton) sendButton.disabled = false;
                    input.disabled = false;
                    input.focus();
                }
            };

            xhr.send(JSON.stringify({
                receiver_id: receiverId,
                content: message,
                _token: token
            }));
        }

        function fetchMessages(url, callback) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', getCSRFToken());

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        var data = JSON.parse(xhr.responseText);
                        callback(null, data);
                    } else {
                        callback(new Error('HTTP error! status: ' + xhr.status));
                    }
                }
            };

            xhr.send();
    }

    function fetchInitialMessages() {
        if (isLoadingMessages) return;

            var receiverIdElement = document.getElementById('receiver-id');
            if (!receiverIdElement) return;

            var receiverId = receiverIdElement.value;
        if (!receiverId) return;

        isLoadingMessages = true;
        showLoading();
        debug('Fetching initial messages');
        
            fetchMessages('/community/profile-matching/messages/' + receiverId + '/chat', 
                function(error, data) {
                    hideLoading();
                    isLoadingMessages = false;

                    if (error) {
                        debug('Error fetching initial messages: ' + error);
                        var messagesContainer = document.getElementById('messages-container');
                        var noMessages = document.getElementById('no-messages');
                        if (messagesContainer && noMessages) {
                            messagesContainer.style.display = 'none';
                            noMessages.style.display = 'block';
                        }
                        return;
                    }

                debug('Initial messages fetched successfully');
                    updateMessagesDisplay(data.messages);
                }
            );
    }

    function fetchNewMessages() {
        if (isLoadingMessages) return;

            var receiverIdElement = document.getElementById('receiver-id');
            if (!receiverIdElement) return;

            var receiverId = receiverIdElement.value;
        if (!receiverId) return;

            fetchMessages('/community/profile-matching/messages/' + receiverId + '/chat?after_id=' + lastMessageId,
                function(error, data) {
                    if (error) {
                        debug('Error fetching new messages: ' + error);
                        return;
                    }

                if (data.messages && data.messages.length > 0) {
                    debug('New messages found');
                        var chatMessages = document.getElementById('chat-messages');
                        var messagesContainer = document.getElementById('messages-container');
                        var noMessages = document.getElementById('no-messages');
                    
                    if (noMessages) {
                        noMessages.style.display = 'none';
                    }
                        if (messagesContainer) {
                            messagesContainer.style.display = 'block';
                        }

                        data.messages.forEach(message => {
                            if (message.id > lastMessageId) {
                                var messageElement = document.createElement('div');
                                var isSent = message.is_sent === true; // Ensure boolean comparison
                                debug('New message ' + message.id + ' is_sent: ' + isSent);
                                messageElement.className = 'message ' + (isSent ? 'message-sent' : 'message-received');
                                messageElement.setAttribute('data-message-id', message.id);
                                messageElement.setAttribute('data-timestamp', message.time);
                                messageElement.setAttribute('data-is-sent', isSent);
                                messageElement.innerHTML = 
                                    '<div class="message-wrapper">' + 
                                    (message.content || '').replace(/</g, '&lt;').replace(/>/g, '&gt;') + 
                                    '</div>' +
                                    '<div class="message-time">' + 
                                    (message.display_time || '') + 
                                    '</div>';
                                messagesContainer.appendChild(messageElement);
                                lastMessageId = Math.max(lastMessageId, message.id);
                            }
                        });

                        scrollToBottom(chatMessages);
                    }
                }
            );
        }

        // Initialize event listeners
        var receiverIdElement = document.getElementById('receiver-id');
        if (receiverIdElement && receiverIdElement.value) {
            fetchInitialMessages();
            messageCheckInterval = window.setInterval(fetchNewMessages, 1000);
        }

        var messageInput = document.getElementById('message-input');
        var sendButton = document.getElementById('send-message');
        
        if (messageInput) {
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    sendMessage();
                }
            });
        }

        if (sendButton) {
            sendButton.addEventListener('click', function(e) {
                e.preventDefault();
                sendMessage();
            });
    }
}

// Initialize chat when DOM is loaded
    if (document.readyState === 'loading') {
document.addEventListener('DOMContentLoaded', initializeChat);
    } else {
        initializeChat();
    }
})();
