<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Get all conversations for the authenticated user.
     */
    public function index(): JsonResponse
    {
        $userId = (int) Auth::id();

        $conversations = Conversation::with(['userOne', 'userTwo', 'latestMessage'])
            ->where(function ($query) use ($userId) {
                $query->where('user_one_id', $userId)
                      ->orWhere('user_two_id', $userId);
            })
            ->orderByDesc('last_message_at')
            ->get()
            ->map(function ($conv) use ($userId) {
                /** @var Conversation $conv */
                $otherUser = $conv->getOtherUser($userId);
                $unreadCount = Message::where('conversation_id', $conv->id)
                    ->where('sender_id', '!=', $userId)
                    ->whereNull('read_at')
                    ->count();

                return [
                    'id' => $conv->id,
                    'last_message_at' => $conv->last_message_at,
                    'latest_message' => $conv->latestMessage ? [
                        'content' => $conv->latestMessage->content,
                        'created_at' => $conv->latestMessage->created_at,
                        'sender_id' => $conv->latestMessage->sender_id,
                    ] : null,
                    'unread_count' => $unreadCount,
                    'other_user' => $otherUser ? [
                        'id' => $otherUser->id,
                        'name' => $otherUser->name,
                        'avatar_url' => $otherUser->avatar_url,
                        'role' => $otherUser->role,
                    ] : null,
                ];
            });

        return response()->json(['data' => $conversations]);
    }

    /**
     * Get messages for a specific conversation.
     */
    public function messages(Request $request, int $id): JsonResponse
    {
        $userId = (int) Auth::id();

        $conversation = Conversation::with(['userOne', 'userTwo'])
            ->where('id', $id)
            ->where(function ($query) use ($userId) {
                $query->where('user_one_id', $userId)
                      ->orWhere('user_two_id', $userId);
            })
            ->firstOrFail();

        // Mark unread messages sent by other user as read
        Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $limit = min((int) $request->query('limit', 50), 100);
        $messages = Message::where('conversation_id', $conversation->id)
            ->latest('id')
            ->take($limit)
            ->get()
            ->reverse()
            ->values();

        return response()->json([
            'conversation' => [
                'id' => $conversation->id,
                'other_user' => $conversation->getOtherUser($userId),
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * Send a new message.
     */
    public function sendMessage(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:3000',
        ]);

        $userId = (int) Auth::id();

        $conversation = Conversation::where('id', $id)
            ->where(function ($query) use ($userId) {
                $query->where('user_one_id', $userId)
                      ->orWhere('user_two_id', $userId);
            })
            ->firstOrFail();

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'content' => $validated['content'],
        ]);

        $conversation->update(['last_message_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ], 201);
    }

    /**
     * Start or retrieve a conversation with a specific user.
     */
    public function startConversation(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|different:' . Auth::id(),
        ]);

        $currentUserId = (int) Auth::id();
        $targetUserId = (int) $validated['user_id'];

        // Normalize order to satisfy unique constraint
        $userOneId = min($currentUserId, $targetUserId);
        $userTwoId = max($currentUserId, $targetUserId);

        $conversation = Conversation::firstOrCreate(
            ['user_one_id' => $userOneId, 'user_two_id' => $userTwoId],
            ['last_message_at' => now()]
        );

        return response()->json([
            'id' => $conversation->id,
            'other_user' => $conversation->getOtherUser($currentUserId),
        ]);
    }
}

