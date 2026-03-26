@extends('app.layout')

@section('content')
<div class="rounded-2xl bg-white border border-slate-200 p-4">
    <h2 class="font-semibold mb-3">Leaderboard SoftiFY</h2>
    <p class="text-sm text-slate-500 mb-4">Ranking berdasarkan task selesai, streak, dan progress target.</p>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[620px] text-xs sm:text-sm">
            <thead>
                <tr class="text-left text-slate-500 border-b">
                    <th class="py-2 pr-2">Rank</th>
                    <th class="py-2 pr-2">Nama</th>
                    <th class="py-2 pr-2 text-center">Task</th>
                    <th class="py-2 pr-2 text-center">Streak</th>
                    <th class="py-2 pr-2 text-center">Progress</th>
                    <th class="py-2 text-right">Skor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $idx => $row)
                    <tr class="border-b {{ $row['id'] === $viewerId ? 'bg-softi-50' : '' }}">
                        <td class="py-2 pr-2 font-semibold">#{{ $idx + 1 }}</td>
                        <td class="py-2 pr-2">
                            <p class="font-medium text-slate-800 whitespace-nowrap">{{ $row['name'] }}</p>
                            <p class="text-[11px] text-slate-500 whitespace-nowrap">{{ $row['class_level'] ?: '-' }}</p>
                        </td>
                        <td class="py-2 pr-2 text-center">{{ $row['done_tasks'] }}</td>
                        <td class="py-2 pr-2 text-center">🔥 {{ $row['streak'] }}</td>
                        <td class="py-2 pr-2 text-center">{{ $row['target_progress'] }}%</td>
                        <td class="py-2 text-right font-semibold text-softi-700">{{ $row['score'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
