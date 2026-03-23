<?php

namespace App\Http\Controllers;

use App\Models\StudyTarget;
use App\Models\User;
use App\Services\AppViewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TargetController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        StudyTarget::syncStatusesForUser($user);

        $targets = $user->studyTargets()
            ->with(['logs' => fn ($query) => $query->latest('date')->latest('id')])
            ->orderByRaw("CASE status WHEN 'active' THEN 0 WHEN 'expired' THEN 1 ELSE 2 END")
            ->orderBy('end_date')
            ->latest('id')
            ->paginate(12);

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
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        $target = $user->studyTargets()->create([
            'title' => $validated['title'],
            'period_type' => $validated['period_type'],
            'target_hours' => (int) $validated['target_hours'],
            'current_hours' => 0,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => StudyTarget::STATUS_ACTIVE,
            'deadline' => $validated['end_date'],
            'is_completed' => false,
        ]);

        $target->syncStatus();

        return back()->with('success', 'Target belajar berhasil ditambahkan.');
    }

    public function update(Request $request, StudyTarget $target)
    {
        abort_unless($target->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'period_type' => ['required', 'in:daily,weekly,monthly'],
            'target_hours' => ['required', 'integer', 'min:1', 'max:2000'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $targetHours = (int) $validated['target_hours'];
        $current = min((int) $target->current_hours, $targetHours);

        $target->update([
            'title' => $validated['title'],
            'period_type' => $validated['period_type'],
            'target_hours' => $targetHours,
            'current_hours' => $current,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'deadline' => $validated['end_date'],
        ]);

        $target->syncStatus();

        return back()->with('success', 'Target berhasil diperbarui.');
    }

    public function destroy(StudyTarget $target)
    {
        abort_unless($target->user_id === Auth::id(), 403);

        $target->delete();

        return back()->with('success', 'Target belajar berhasil dihapus.');
    }
}
