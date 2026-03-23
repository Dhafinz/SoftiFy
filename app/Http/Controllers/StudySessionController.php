<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudySessionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'minutes' => ['required', 'integer', 'min:5', 'max:600'],
            'topic' => ['nullable', 'string', 'max:255'],
            'study_date' => ['required', 'date'],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->studySessions()->create($validated + ['source' => 'manual']);

        return back()->with('success', 'Sesi belajar berhasil ditambahkan.');
    }
}
