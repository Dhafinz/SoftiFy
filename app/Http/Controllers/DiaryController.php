<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use App\Models\User;
use App\Services\AppViewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
        ]);

        $search = trim((string) $request->query('search', ''));
        $date = trim((string) $request->query('date', ''));

        $diaries = $user->diaries()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($date !== '', function ($query) use ($date) {
                $query->whereDate('created_at', $date);
            })
            ->latest('created_at')
            ->latest('id')
            ->paginate(9)
            ->withQueryString();

        $notifications = $this->appView->notifications($user);
        $title = 'Diary Harian';
        $moodLabels = $this->moodOptions();

        return view('app.diary.index', compact('diaries', 'notifications', 'title', 'search', 'date', 'moodLabels'));
    }

    public function create()
    {
        /** @var User $user */
        $user = Auth::user();

        $notifications = $this->appView->notifications($user);
        $title = 'Tulis Diary Baru';
        $moodOptions = $this->moodOptions();

        return view('app.diary.create', compact('notifications', 'title', 'moodOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
            'mood' => ['nullable', 'in:'.implode(',', Diary::MOOD_OPTIONS)],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->diaries()->create($validated);

        return redirect()->route('diary.index')->with('success', 'Diary berhasil ditambahkan.');
    }

    public function show(Diary $diary)
    {
        $diary = $this->ownedDiary($diary);

        /** @var User $user */
        $user = Auth::user();
        $notifications = $this->appView->notifications($user);
        $title = 'Detail Diary';
        $moodLabels = $this->moodOptions();

        return view('app.diary.show', compact('diary', 'notifications', 'title', 'moodLabels'));
    }

    public function edit(Diary $diary)
    {
        $diary = $this->ownedDiary($diary);

        /** @var User $user */
        $user = Auth::user();
        $notifications = $this->appView->notifications($user);
        $title = 'Edit Diary';
        $moodOptions = $this->moodOptions();

        return view('app.diary.edit', compact('diary', 'notifications', 'title', 'moodOptions'));
    }

    public function update(Request $request, Diary $diary)
    {
        $diary = $this->ownedDiary($diary);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
            'mood' => ['nullable', 'in:'.implode(',', Diary::MOOD_OPTIONS)],
        ]);

        $diary->update($validated);

        return redirect()->route('diary.show', $diary)->with('success', 'Diary berhasil diperbarui.');
    }

    public function destroy(Diary $diary)
    {
        $diary = $this->ownedDiary($diary);
        $diary->delete();

        return redirect()->route('diary.index')->with('success', 'Diary berhasil dihapus.');
    }

    private function ownedDiary(Diary $diary): Diary
    {
        abort_unless($diary->user_id === Auth::id(), 403);

        return $diary;
    }

    private function moodOptions(): array
    {
        return [
            Diary::MOOD_HAPPY => 'happy 😊',
            Diary::MOOD_SAD => 'sad 😢',
            Diary::MOOD_PRODUCTIVE => 'productive 💪',
            Diary::MOOD_TIRED => 'tired 😴',
        ];
    }
}
