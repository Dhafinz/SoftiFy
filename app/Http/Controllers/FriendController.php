<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use App\Services\AppViewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $query = trim((string) $request->query('q', ''));

        $notifications = $this->appView->notifications($user);
        $friends = $user->friendsQuery()->orderBy('name')->get(['id', 'name', 'email', 'updated_at']);

        $incomingRequests = Friend::query()
            ->with('requester:id,name,email,updated_at')
            ->where('friend_id', $user->id)
            ->where('status', Friend::STATUS_PENDING)
            ->latest('id')
            ->get();

        $searchResults = collect();
        if ($query !== '') {
            $searchResults = User::query()
                ->where('id', '!=', $user->id)
                ->where(function ($builder) use ($query): void {
                    $builder->where('name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                })
                ->limit(20)
                ->get(['id', 'name', 'email', 'updated_at'])
                ->map(function (User $candidate) use ($user): User {
                    $relation = Friend::query()
                        ->where(function ($builder) use ($user, $candidate): void {
                            $builder->where('user_id', $user->id)
                                ->where('friend_id', $candidate->id);
                        })
                        ->orWhere(function ($builder) use ($user, $candidate): void {
                            $builder->where('user_id', $candidate->id)
                                ->where('friend_id', $user->id);
                        })
                        ->latest('id')
                        ->first();

                    $candidate->setAttribute('friend_relation_status', $relation?->status);
                    $candidate->setAttribute('friend_relation_direction', $relation?->user_id === $user->id ? 'outgoing' : 'incoming');
                    return $candidate;
                });
        }

        $title = 'Teman';

        return view('app.friends', compact(
            'notifications',
            'friends',
            'incomingRequests',
            'searchResults',
            'query',
            'title'
        ));
    }

    public function sendRequest(Request $request)
    {
        $validated = $request->validate([
            'friend_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $friendId = (int) $validated['friend_id'];

        if ($friendId === $user->id) {
            return back()->withErrors(['Tidak bisa menambahkan diri sendiri.']);
        }

        $existing = Friend::query()
            ->where(function ($builder) use ($user, $friendId): void {
                $builder->where('user_id', $user->id)->where('friend_id', $friendId);
            })
            ->orWhere(function ($builder) use ($user, $friendId): void {
                $builder->where('user_id', $friendId)->where('friend_id', $user->id);
            })
            ->latest('id')
            ->first();

        if ($existing && $existing->status === Friend::STATUS_ACCEPTED) {
            return back()->with('success', 'Kalian sudah berteman.');
        }

        if ($existing && $existing->status === Friend::STATUS_PENDING) {
            return back()->with('success', 'Request pertemanan sudah terkirim atau menunggu respon.');
        }

        if ($existing && $existing->status === Friend::STATUS_REJECTED) {
            $existing->update([
                'user_id' => $user->id,
                'friend_id' => $friendId,
                'status' => Friend::STATUS_PENDING,
            ]);
            return back()->with('success', 'Request pertemanan dikirim ulang.');
        }

        Friend::query()->create([
            'user_id' => $user->id,
            'friend_id' => $friendId,
            'status' => Friend::STATUS_PENDING,
        ]);

        return back()->with('success', 'Request pertemanan berhasil dikirim.');
    }

    public function accept(Friend $friend)
    {
        /** @var User $user */
        $user = Auth::user();

        abort_unless($friend->friend_id === $user->id, 403);
        abort_unless($friend->status === Friend::STATUS_PENDING, 422);

        $friend->update(['status' => Friend::STATUS_ACCEPTED]);

        return back()->with('success', 'Request pertemanan diterima.');
    }

    public function reject(Friend $friend)
    {
        /** @var User $user */
        $user = Auth::user();

        abort_unless($friend->friend_id === $user->id, 403);
        abort_unless($friend->status === Friend::STATUS_PENDING, 422);

        $friend->update(['status' => Friend::STATUS_REJECTED]);

        return back()->with('success', 'Request pertemanan ditolak.');
    }
}
