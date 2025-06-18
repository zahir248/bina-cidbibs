<?php

namespace App\Http\Controllers\Client\Community;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Message;
use App\Models\ConnectionRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MessagesController extends Controller
{
    public function index(Request $request): View
    {
        // Get all accepted connections for the current user
        $authUserId = auth()->id();
        $connections = ConnectionRequest::with(['sender.profile', 'receiver.profile'])
            ->where(function($query) use ($authUserId) {
                $query->where('sender_id', '=', $authUserId)
                    ->orWhere('receiver_id', '=', $authUserId);
            })
            ->where('status', '=', 'accepted')
            ->get()
            ->map(function($request) use ($authUserId) {
                // Get the other user in the connection
                $senderId = (string) $request->sender_id;
                $currentUserId = (string) $authUserId;
                
                return $senderId === $currentUserId
                    ? $request->receiver
                    : $request->sender;
            });

        // Get selected user if user_id is provided
        $receiver = null;
        if ($request->has('user_id')) {
            $userId = $request->user_id;
            
            // Check if there's a connection between users
            $connection = ConnectionRequest::where('status', 'accepted')
                ->where(function($query) use ($userId) {
                    $query->where(function($q) use ($userId) {
                        $q->where('sender_id', auth()->id())
                            ->where('receiver_id', $userId);
                    })->orWhere(function($q) use ($userId) {
                        $q->where('sender_id', $userId)
                            ->where('receiver_id', auth()->id());
                    });
                })
                ->first();

            if ($connection) {
                $receiver = User::with('profile')->find($userId);
            }
        }

        return view('client.community.profile-matching.messages', compact('connections', 'receiver'));
    }

    public function getMessages(Request $request, User $user): JsonResponse
    {
        $authUserId = auth()->id();
        $afterId = $request->query('after_id', 0);

        // Mark messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $authUserId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Get messages between the two users
        $messages = Message::with(['sender', 'receiver'])
            ->where(function($query) use ($authUserId, $user) {
                $query->where(function($q) use ($authUserId, $user) {
                    $q->where('sender_id', $authUserId)
                        ->where('receiver_id', $user->id);
                })->orWhere(function($q) use ($authUserId, $user) {
                    $q->where('sender_id', $user->id)
                        ->where('receiver_id', $authUserId);
                });
            })
            ->when($afterId > 0, function($query) use ($afterId) {
                $query->where('id', '>', $afterId);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($message) use ($authUserId) {
                // Cast IDs to strings for safe comparison
                $senderId = (string) $message->sender_id;
                $currentUserId = (string) $authUserId;
                
                return [
                    'id' => $message->id,
                    'content' => $message->content,
                    'is_sent' => $senderId === $currentUserId,
                    'time' => $message->created_at->setTimezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
                    'display_time' => $message->created_at->setTimezone('Asia/Kuala_Lumpur')->format('M j, Y g:i A'),
                    'is_read' => $message->is_read,
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000'
        ]);

        try {
            // Check if there's a connection between users
            $connection = ConnectionRequest::where('status', 'accepted')
                ->where(function($query) use ($request) {
                    $query->where(function($q) use ($request) {
                        $q->where('sender_id', auth()->id())
                            ->where('receiver_id', $request->receiver_id);
                    })->orWhere(function($q) use ($request) {
                        $q->where('sender_id', $request->receiver_id)
                            ->where('receiver_id', auth()->id());
                    });
                })
                ->first();

            if (!$connection) {
                return response()->json([
                    'message' => 'You must be connected with this user to send messages.'
                ], 403);
            }

            $authUserId = auth()->id();
            $message = Message::create([
                'sender_id' => $authUserId,
                'receiver_id' => $request->receiver_id,
                'content' => $request->content,
            ]);

            // Cast IDs to strings for safe comparison
            $senderId = (string) $message->sender_id;
            $currentUserId = (string) $authUserId;

            return response()->json([
                'message' => [
                    'id' => $message->id,
                    'content' => $message->content,
                    'is_sent' => $senderId === $currentUserId,
                    'time' => $message->created_at->setTimezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
                    'display_time' => $message->created_at->setTimezone('Asia/Kuala_Lumpur')->format('M j, Y g:i A'),
                    'is_read' => false,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send message.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUnreadCount(): JsonResponse
    {
        $count = Message::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function chat($userId)
    {
        // Get the receiver user with their profile
        $receiver = User::with('profile')->findOrFail($userId);

        // Check if there's a connection between users
        $connection = ConnectionRequest::where('status', 'accepted')
            ->where(function($query) use ($userId) {
                $query->where(function($q) use ($userId) {
                    $q->where('sender_id', auth()->id())
                        ->where('receiver_id', $userId);
                })->orWhere(function($q) use ($userId) {
                    $q->where('sender_id', $userId)
                        ->where('receiver_id', auth()->id());
                });
            })
            ->first();

        if (!$connection) {
            return redirect()->route('client.community.profile-matching.messages')
                ->with('error', 'You must be connected with this user to send messages.');
        }

        return view('client.community.profile-matching.chat', compact('receiver'));
    }
} 