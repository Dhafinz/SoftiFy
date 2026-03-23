@extends('app.layout')

@section('content')
<div class="rounded-2xl bg-white border border-slate-200 p-4">
    <h2 class="font-semibold mb-3">Leaderboard SoftiFY</h2>
    <p class="text-sm text-slate-500 mb-4">Ranking berdasarkan task selesai, streak, dan progress target.</p>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-500 border-b">
                    <th class="py-2">Rank</th>
                    <th class="py-2">Nama</th>
                    <th class="py-2">Task Selesai</th>
                    <th class="py-2">Streak</th>
                    <th class="py-2">Progress Target</th>
                    <th class="py-2">Skor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $idx => $row)
                    <tr class="border-b {{ $row['id'] === $viewerId ? 'bg-softi-50' : '' }}">
                        <td class="py-2 font-semibold">#{{ $idx + 1 }}</td>
                        <td class="py-2">{{ $row['name'] }} <span class="text-xs text-slate-500">{{ $row['class_level'] ?: '' }}</span></td>
                        <td class="py-2">{{ $row['done_tasks'] }}</td>
                        <td class="py-2">🔥 {{ $row['streak'] }}</td>
                        <td class="py-2">{{ $row['target_progress'] }}%</td>
                        <td class="py-2 font-semibold text-softi-700">{{ $row['score'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
