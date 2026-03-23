<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Services\AppViewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $tasks = $user->tasks()
            ->orderByDesc('due_date')
            ->orderBy('time')
            ->latest('id')
            ->paginate(12);
        $notifications = $this->appView->notifications($user);
        $title = 'Task Management';

        return view('app.tasks', compact('tasks', 'notifications', 'title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'priority' => ['nullable', 'in:low,medium,high'],
            'estimated_minutes' => ['nullable', 'integer', 'min:15', 'max:300'],
            'due_date' => ['required', 'date'],
            'time' => ['nullable', 'date_format:H:i'],
            'status' => ['nullable', 'in:pending,done'],
        ]);

        $validated['priority'] = $validated['priority'] ?? 'medium';
        $validated['estimated_minutes'] = (int) ($validated['estimated_minutes'] ?? 60);
        $validated['status'] = $validated['status'] ?? 'pending';
        $validated['is_done'] = $validated['status'] === 'done';
        $validated['completed_at'] = $validated['is_done'] ? now() : null;
        $validated['time'] = ($validated['time'] ?? '08:00').':00';

        /** @var User $user */
        $user = Auth::user();
        $user->tasks()->create($validated);

        $successMessage = $request->boolean('quick_add')
            ? 'Task cepat berhasil ditambahkan.'
            : 'Task berhasil ditambahkan.';

        return back()->with('success', $successMessage);
    }

    public function update(Request $request, Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'priority' => ['nullable', 'in:low,medium,high'],
            'estimated_minutes' => ['nullable', 'integer', 'min:15', 'max:300'],
            'due_date' => ['required', 'date'],
            'time' => ['nullable', 'date_format:H:i'],
            'status' => ['nullable', 'in:pending,done'],
        ]);

        $validated['priority'] = $validated['priority'] ?? 'medium';
        $validated['estimated_minutes'] = (int) ($validated['estimated_minutes'] ?? 60);
        $validated['status'] = $validated['status'] ?? 'pending';
        $validated['is_done'] = $validated['status'] === 'done';
        $validated['completed_at'] = $validated['is_done'] ? now() : null;
        $validated['time'] = ($validated['time'] ?? '08:00').':00';

        $task->update($validated);

        return back()->with('success', 'Task berhasil diperbarui.');
    }

    public function toggle(Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);

        $willDone = ! $task->is_done;
        $task->update([
            'is_done' => $willDone,
            'status' => $willDone ? 'done' : 'pending',
            'completed_at' => $willDone ? now() : null,
        ]);

        return back()->with('success', 'Status task berhasil diperbarui.');
    }

    public function destroy(Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);

        $task->delete();

        return back()->with('success', 'Task berhasil dihapus.');
    }
}
