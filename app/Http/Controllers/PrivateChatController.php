<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Services\AppViewService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateChatController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $friends = $user->friendsQuery()->orderBy('name')->get(['id', 'name', 'email', 'updated_at']);
        $friendIds = $friends->pluck('id')->all();

        $latestByFriend = Message::query()
            ->where(function ($query) use ($user, $friendIds): void {
                $query->where('sender_id', $user->id)
                    ->whereIn('receiver_id', $friendIds);
            })
            ->orWhere(function ($query) use ($user, $friendIds): void {
                $query->whereIn('sender_id', $friendIds)
                    ->where('receiver_id', $user->id);
            })
            ->latest('id')
            ->get(['id', 'sender_id', 'receiver_id', 'message', 'created_at']);

        $lastMessageByFriend = [];
        foreach ($latestByFriend as $message) {
            $counterpartId = (int) ($message->sender_id === $user->id ? $message->receiver_id : $message->sender_id);
            if (! isset($lastMessageByFriend[$counterpartId])) {
                $lastMessageByFriend[$counterpartId] = $message;
            }
        }

        $friends = $friends
            ->map(function (User $friend) use ($lastMessageByFriend): User {
                $last = $lastMessageByFriend[$friend->id] ?? null;
                $preview = $last?->message ? mb_substr($last->message, 0, 40) : '';
                if ($preview !== '' && mb_strlen($last->message) > 40) {
                    $preview .= '...';
                }

                $friend->setAttribute('last_message_preview', $preview);
                $friend->setAttribute('last_message_at', $last?->created_at);

                return $friend;
            })
            ->sortByDesc(fn (User $friend) => $friend->getAttribute('last_message_at')?->timestamp ?? 0)
            ->values();

        $friendId = (int) $request->query('friend_id', 0);
        $activeFriend = $friends->firstWhere('id', $friendId) ?? $friends->first();

        $notifications = $this->appView->notifications($user);
        $unreadByFriend = Message::query()
            ->selectRaw('sender_id, COUNT(*) as total')
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->groupBy('sender_id')
            ->pluck('total', 'sender_id');

        $title = 'Chat Teman';

        return view('app.chat', compact('notifications', 'friends', 'activeFriend', 'unreadByFriend', 'title'));
    }

    public function fetch(Request $request, User $friend): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $afterId = (int) $request->integer('after_id', 0);

        abort_unless($user->friendsQuery()->where('id', $friend->id)->exists(), 403);

        $messages = Message::query()
            ->where(function ($builder) use ($user, $friend): void {
                $builder->where('sender_id', $user->id)
                    ->where('receiver_id', $friend->id);
            })
            ->orWhere(function ($builder) use ($user, $friend): void {
                $builder->where('sender_id', $friend->id)
                    ->where('receiver_id', $user->id);
            })
            ->where('id', '>', $afterId)
            ->orderBy('id')
            ->limit(200)
            ->get()
            ->map(fn (Message $message): array => [
                'id' => $message->id,
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'message' => $message->message,
                'created_at' => $message->created_at?->format('H:i'),
            ]);

        Message::query()
            ->where('sender_id', $friend->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['messages' => $messages]);
    }

    public function store(Request $request, User $friend): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $cleanMessage = trim($validated['message']);

        abort_unless($user->friendsQuery()->where('id', $friend->id)->exists(), 403);

        Log::info('Private chat incoming message', [
            'sender_id' => $user->id,
            'receiver_id' => $friend->id,
            'message_preview' => mb_substr($cleanMessage, 0, 80),
        ]);

        $isDuplicate = Message::query()
            ->where('sender_id', $user->id)
            ->where('receiver_id', $friend->id)
            ->where('message', $cleanMessage)
            ->where('created_at', '>=', now()->subSecond())
            ->exists();

        if ($isDuplicate) {
            Log::warning('Private chat duplicate blocked', [
                'sender_id' => $user->id,
                'receiver_id' => $friend->id,
                'message_preview' => mb_substr($cleanMessage, 0, 80),
            ]);

            return response()->json([
                'ok' => false,
                'status' => 'duplicate blocked',
                'duplicate' => true,
                'message' => null,
            ]);
        }

        $message = Message::query()->create([
            'sender_id' => $user->id,
            'receiver_id' => $friend->id,
            'message' => $cleanMessage,
        ]);

        Log::info('Private chat stored message', [
            'message_id' => $message->id,
            'sender_id' => $user->id,
            'receiver_id' => $friend->id,
            'broadcast_mode' => 'polling',
        ]);

        return response()->json([
            'ok' => true,
            'message' => [
                'id' => $message->id,
                'sender_id' => $user->id,
                'receiver_id' => $friend->id,
                'message' => $message->message,
                'created_at' => $message->created_at?->format('H:i'),
            ],
        ]);
    }
}
