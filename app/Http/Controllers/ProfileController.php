<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AppViewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $notifications = $this->appView->notifications($user);
        $title = 'Profile User';

        return view('app.profile', compact('user', 'notifications', 'title'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'class_level' => ['nullable', 'string', 'max:50'],
            'learning_goal' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update([
            'name' => $validated['name'],
            'class_level' => $validated['class_level'] ?? null,
            'learning_goal' => $validated['learning_goal'] ?? null,
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            ['bio' => $validated['bio'] ?? null]
        );

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
