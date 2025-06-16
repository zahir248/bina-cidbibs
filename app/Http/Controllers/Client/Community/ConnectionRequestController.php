<?php

namespace App\Http\Controllers\Client\Community;

use App\Http\Controllers\Controller;
use App\Models\ConnectionRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConnectionRequestController extends Controller
{
    public function index(): View
    {
        return view('client.community.profile-matching.connections');
    }

    public function send(Request $request): JsonResponse
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id'
        ]);

        $existingRequest = ConnectionRequest::where('sender_id', auth()->id())
            ->where('receiver_id', $request->receiver_id)
            ->first();

        if ($existingRequest) {
            if ($existingRequest->status === 'pending') {
                $existingRequest->delete();
                return response()->json(['status' => 'removed']);
            }
            return response()->json(['status' => 'exists']);
        }

        ConnectionRequest::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'status' => 'pending'
        ]);

        return response()->json(['status' => 'sent']);
    }

    public function getStatus(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $authUserId = auth()->id();
        $connectionRequest = ConnectionRequest::where(function($query) use ($request, $authUserId) {
                $query->where(function($q) use ($request, $authUserId) {
                    $q->where('sender_id', '=', $authUserId)
                      ->where('receiver_id', '=', $request->user_id);
                })->orWhere(function($q) use ($request, $authUserId) {
                    $q->where('sender_id', '=', $request->user_id)
                      ->where('receiver_id', '=', $authUserId);
                });
            })
            ->latest()
            ->first();

        // If there's no connection request, return none
        if (!$connectionRequest) {
            return response()->json(['status' => 'none']);
        }

        // Cast IDs to strings for comparison
        $senderId = (string) $connectionRequest->sender_id;
        $receiverId = (string) $connectionRequest->receiver_id;
        $currentUserId = (string) $authUserId;

        // If status is pending
        if ($connectionRequest->status === 'pending') {
            // If current user is the sender, show pending (allowing them to cancel)
            if ($senderId === $currentUserId) {
                return response()->json(['status' => 'pending']);
            }
            // If current user is the receiver, show none (they'll see it in their pending requests)
            return response()->json(['status' => 'none']);
        }

        // For rejected status, only show it to the sender
        if ($connectionRequest->status === 'rejected') {
            // If current user is the sender, show rejected
            if ($senderId === $currentUserId) {
                return response()->json(['status' => 'rejected']);
            }
            // If current user is the receiver, show none (allowing them to send new request)
            return response()->json(['status' => 'none']);
        }

        // For accepted status, show it to both users
        if ($connectionRequest->status === 'accepted') {
            return response()->json(['status' => 'accepted']);
        }

        // Default fallback
        return response()->json(['status' => 'none']);
    }

    public function accept(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'sender_id' => 'required|exists:users,id'
            ]);

            $connectionRequest = ConnectionRequest::where('sender_id', $request->sender_id)
                ->where('receiver_id', auth()->id())
                ->where('status', 'pending')
                ->firstOrFail();

            $connectionRequest->update(['status' => 'accepted']);

            return response()->json([
                'status' => 'success',
                'message' => 'Connection request accepted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to accept connection request'
            ], 500);
        }
    }

    public function reject(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'sender_id' => 'required|exists:users,id'
            ]);

            $connectionRequest = ConnectionRequest::where('sender_id', $request->sender_id)
                ->where('receiver_id', auth()->id())
                ->where('status', 'pending')
                ->firstOrFail();

            $connectionRequest->update(['status' => 'rejected']);

            return response()->json([
                'status' => 'success',
                'message' => 'Connection request rejected successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to reject connection request'
            ], 500);
        }
    }
} 