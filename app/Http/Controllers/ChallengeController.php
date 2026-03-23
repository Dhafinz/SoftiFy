<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AppViewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $notifications = $this->appView->notifications($user);
        $recentSessions = $user->studySessions()->where('source', 'challenge')->latest('id')->limit(10)->get();
        $title = 'Challenge Timer';

        return view('app.challenge', compact('notifications', 'recentSessions', 'title'));
    }

    public function storeSession(Request $request)
    {
        $validated = $request->validate([
            'minutes' => ['required', 'integer', 'min:1', 'max:600'],
            'topic' => ['required', 'string', 'max:255'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->studySessions()->create([
            'study_date' => now()->toDateString(),
            'minutes' => $validated['minutes'],
            'topic' => trim($validated['topic']),
            'source' => 'challenge',
        ]);

        return back()->with('success', 'Sesi challenge berhasil disimpan dan terhubung ke streak.');
    }
}
