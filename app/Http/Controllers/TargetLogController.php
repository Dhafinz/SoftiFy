<?php

namespace App\Http\Controllers;

use App\Models\StudyTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TargetLogController extends Controller
{
    public function store(Request $request, StudyTarget $target)
    {
        abort_unless($target->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'added_hours' => ['required', 'integer', 'min:1', 'max:2000'],
            'note' => ['nullable', 'string', 'max:2000'],
            'date' => ['nullable', 'date'],
        ]);

        $today = now()->startOfDay();
        $status = $target->resolveStatus($today);

        if ($status !== StudyTarget::STATUS_ACTIVE) {
            $target->status = $status;
            $target->save();

            throw ValidationException::withMessages([
                'added_hours' => 'Target sudah selesai atau kedaluwarsa, progress tidak bisa ditambahkan.',
            ]);
        }

        $addedHours = (int) $validated['added_hours'];

        DB::transaction(function () use ($target, $addedHours, $validated): void {
            $lockedTarget = StudyTarget::query()
                ->whereKey($target->id)
                ->lockForUpdate()
                ->firstOrFail();

            $lockedTarget->refresh();
            $lockedTarget->syncStatus();

            if ($lockedTarget->status !== StudyTarget::STATUS_ACTIVE) {
                throw ValidationException::withMessages([
                    'added_hours' => 'Target sudah selesai atau kedaluwarsa, progress tidak bisa ditambahkan.',
                ]);
            }

            $remaining = max(0, (int) $lockedTarget->target_hours - (int) $lockedTarget->current_hours);

            if ($addedHours > $remaining) {
                throw ValidationException::withMessages([
                    'added_hours' => 'Jam yang ditambahkan melebihi sisa target.',
                ]);
            }

            $lockedTarget->increment('current_hours', $addedHours);

            $lockedTarget->logs()->create([
                'added_hours' => $addedHours,
                'note' => trim((string) ($validated['note'] ?? '')) ?: null,
                'date' => $validated['date'] ?? now()->toDateString(),
            ]);

            $lockedTarget->refresh();
            $lockedTarget->syncStatus();
        });

        return back()->with('success', 'Progress target berhasil ditambahkan.');
    }
}
