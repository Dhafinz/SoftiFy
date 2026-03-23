@extends('app.layout')

@section('content')
<div class="grid gap-4 lg:grid-cols-3">
    <div class="lg:col-span-1 rounded-2xl bg-white border border-slate-200 p-4">
        <h2 class="font-semibold mb-3">Tambah Task</h2>
        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-2">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Tugas</label>
                <input name="title" class="w-full rounded-xl border-slate-300" placeholder="Contoh: Belajar Matematika Bab 1" required>
                <p class="text-xs text-slate-500 mt-1">Isi tugas yang ingin kamu kerjakan hari ini</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Mapel / Kategori</label>
                <input name="subject" class="w-full rounded-xl border-slate-300" placeholder="Contoh: Matematika">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <select name="priority" class="w-full rounded-xl border-slate-300">
                    <option value="low">Prioritas Rendah</option>
                    <option value="medium" selected>Prioritas Sedang</option>
                    <option value="high">Prioritas Tinggi</option>
                </select>
                <input name="estimated_minutes" type="number" min="15" max="300" value="60" class="w-full rounded-xl border-slate-300" placeholder="Estimasi menit">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs text-slate-600 mb-1">Tanggal</label>
                    <input name="due_date" type="date" class="w-full rounded-xl border-slate-300" required>
                </div>
                <div>
                    <label class="block text-xs text-slate-600 mb-1">Jam</label>
                    <input name="time" type="time" class="w-full rounded-xl border-slate-300" required>
                </div>
            </div>
            <select name="status" class="w-full rounded-xl border-slate-300">
                <option value="pending" selected>Pending</option>
                <option value="done">Done</option>
            </select>
            <textarea name="description" class="w-full rounded-xl border-slate-300" placeholder="Deskripsi"></textarea>
            <div class="grid grid-cols-2 gap-2">
                <button type="submit" class="w-full rounded-xl bg-softi-600 text-white py-2">Simpan Task</button>
                <button type="submit" name="quick_add" value="1" class="w-full rounded-xl bg-indigo-600 text-white py-2">+ Tambah Tugas Cepat</button>
            </div>
        </form>
    </div>

    <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200 p-4">
        <h2 class="font-semibold mb-3">Daftar Task</h2>
        <div class="space-y-3">
            @forelse ($tasks as $task)
                <div class="rounded-xl border border-slate-200 p-3">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-medium">{{ $task->title }}</p>
                            <p class="text-xs text-slate-500">{{ $task->subject ?: 'Tanpa kategori' }} • {{ $task->due_date?->format('d M Y') }} • {{ \Carbon\Carbon::parse($task->time ?? '08:00:00')->format('H:i') }} • {{ strtoupper($task->priority ?? 'medium') }} • {{ $task->estimated_minutes ?? 60 }} menit • {{ strtoupper($task->status ?? ($task->is_done ? 'done' : 'pending')) }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                                @csrf
                                @method('PATCH')
                                <button class="text-xs px-3 py-1 rounded-lg {{ $task->is_done ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">{{ $task->is_done ? 'Batalkan Checklist' : 'Checklist' }}</button>
                            </form>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Hapus task ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs px-3 py-1 rounded-lg bg-red-100 text-red-700">Hapus</button>
                            </form>
                        </div>
                    </div>

                    <details class="mt-2">
                        <summary class="cursor-pointer text-xs text-softi-700">Edit task</summary>
                        <form action="{{ route('tasks.update', $task) }}" method="POST" class="grid gap-2 mt-2 sm:grid-cols-2">
                            @csrf
                            @method('PATCH')
                            <input name="title" value="{{ $task->title }}" class="rounded-xl border-slate-300" required>
                            <input name="subject" value="{{ $task->subject }}" class="rounded-xl border-slate-300">
                            <select name="priority" class="rounded-xl border-slate-300">
                                <option value="low" @selected(($task->priority ?? 'medium')==='low')>Prioritas Rendah</option>
                                <option value="medium" @selected(($task->priority ?? 'medium')==='medium')>Prioritas Sedang</option>
                                <option value="high" @selected(($task->priority ?? 'medium')==='high')>Prioritas Tinggi</option>
                            </select>
                            <input name="estimated_minutes" type="number" min="15" max="300" value="{{ $task->estimated_minutes ?? 60 }}" class="rounded-xl border-slate-300">
                            <input name="due_date" type="date" value="{{ $task->due_date?->toDateString() }}" class="rounded-xl border-slate-300" required>
                            <input name="time" type="time" value="{{ $task->time ? \Carbon\Carbon::parse($task->time)->format('H:i') : '08:00' }}" class="rounded-xl border-slate-300" required>
                            <select name="status" class="rounded-xl border-slate-300 sm:col-span-2">
                                <option value="pending" @selected(($task->status ?? ($task->is_done ? 'done' : 'pending')) === 'pending')>Pending</option>
                                <option value="done" @selected(($task->status ?? ($task->is_done ? 'done' : 'pending')) === 'done')>Done</option>
                            </select>
                            <input name="description" value="{{ $task->description }}" class="rounded-xl border-slate-300 sm:col-span-2">
                            <button class="sm:col-span-2 rounded-xl bg-indigo-600 text-white py-2 text-sm">Update Task</button>
                        </form>
                    </details>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada task.</p>
            @endforelse
        </div>

        <div class="mt-4">{{ $tasks->links() }}</div>
    </div>
</div>
@endsection
