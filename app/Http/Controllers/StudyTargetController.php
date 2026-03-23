<?php

namespace App\Http\Controllers;

use App\Models\StudyTarget;
use App\Models\User;
use App\Services\AppViewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyTargetController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $targets = $user->studyTargets()->latest('deadline')->latest('id')->paginate(12);
        $notifications = $this->appView->notifications($user);
        $title = 'Target System';

        return view('app.targets', compact('targets', 'notifications', 'title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'period_type' => ['required', 'in:daily,weekly,monthly'],
            'target_hours' => ['required', 'integer', 'min:1', 'max:2000'],
            'current_hours' => ['nullable', 'integer', 'min:0', 'max:2000'],
            'deadline' => ['nullable', 'date'],
        ]);

        $currentHours = (int) ($validated['current_hours'] ?? 0);
        $targetHours = (int) $validated['target_hours'];

        /** @var User $user */
        $user = Auth::user();

        $user->studyTargets()->create([
            'title' => $validated['title'],
            'period_type' => $validated['period_type'],
            'target_hours' => $targetHours,
            'current_hours' => min($currentHours, $targetHours),
            'deadline' => $validated['deadline'] ?? null,
            'is_completed' => $currentHours >= $targetHours,
        ]);

        return back()->with('success', 'Target belajar berhasil ditambahkan.');
    }

    public function update(Request $request, StudyTarget $target)
    {
        abort_unless($target->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'period_type' => ['required', 'in:daily,weekly,monthly'],
            'target_hours' => ['required', 'integer', 'min:1', 'max:2000'],
            'current_hours' => ['required', 'integer', 'min:0', 'max:2000'],
            'deadline' => ['nullable', 'date'],
        ]);

        $current = min((int) $validated['current_hours'], (int) $validated['target_hours']);

        $target->update([
            'title' => $validated['title'],
            'period_type' => $validated['period_type'],
            'target_hours' => (int) $validated['target_hours'],
            'current_hours' => $current,
            'deadline' => $validated['deadline'] ?? null,
            'is_completed' => $current >= (int) $validated['target_hours'],
        ]);

        return back()->with('success', 'Target berhasil diperbarui.');
    }

    public function updateProgress(Request $request, StudyTarget $target)
    {
        abort_unless($target->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'current_hours' => ['required', 'integer', 'min:0', 'max:2000'],
        ]);

        $current = min((int) $validated['current_hours'], $target->target_hours);
        $target->update([
            'current_hours' => $current,
            'is_completed' => $current >= $target->target_hours,
        ]);

        return back()->with('success', 'Progress target berhasil diperbarui.');
    }

    public function destroy(StudyTarget $target)
    {
        abort_unless($target->user_id === Auth::id(), 403);

        $target->delete();

        return back()->with('success', 'Target belajar berhasil dihapus.');
    }
}
