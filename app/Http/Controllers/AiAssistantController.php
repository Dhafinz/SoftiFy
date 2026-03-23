<?php

namespace App\Http\Controllers;

use App\Models\AiMessage;
use App\Models\User;
use App\Services\AiAssistantService;
use App\Services\AppViewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AiAssistantController extends Controller
{
    public function __construct(
        private readonly AiAssistantService $assistant,
        private readonly AppViewService $appView
    ) {
    }

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $messages = $user->aiMessages()->latest('id')->limit(30)->get()->reverse()->values();
        $scheduleLimit = $this->assistant->scheduleTaskLimit($user);
        $chatLimit = $this->assistant->chatMessageLimit();
        $chatUsed = $this->assistant->chatUsageInWindow($user);
        $chatRemaining = max(0, $chatLimit - $chatUsed);
        $chatWindowHours = $this->assistant->chatWindowHours();
        $notifications = $this->appView->notifications($user);
        $title = 'AI Assistant';

        return view('app.ai', compact(
            'messages',
            'notifications',
            'title',
            'scheduleLimit',
            'user',
            'chatLimit',
            'chatUsed',
            'chatRemaining',
            'chatWindowHours'
        ));
    }

    public function chat(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        $chatRemaining = $this->assistant->remainingChatMessages($user);
        if ($chatRemaining <= 0) {
            return back()->withErrors([
                'message' => 'Batas chat AI tercapai. Maksimal 20 pesan per 24 jam. Coba lagi setelah beberapa jam.',
            ]);
        }

        $recentMessages = $this->assistant->recentChatMessages($user);

        $question = trim($validated['message']);
        $answer = $this->assistant->answer($user, $question, $recentMessages);

        $user->aiMessages()->create([
            'role' => 'user',
            'message' => $question,
            'mode' => 'chat',
        ]);

        $user->aiMessages()->create([
            'role' => 'assistant',
            'message' => $answer,
            'mode' => 'chat',
        ]);

        $remainingAfterSend = $this->assistant->remainingChatMessages($user);

        return back()->with('success', "Jawaban AI berhasil dibuat. Sisa kuota chat: {$remainingAfterSend}/20.");
    }

    public function generateTodaySchedule()
    {
        /** @var User $user */
        $user = Auth::user();

        $result = $this->assistant->generateTodaySchedule($user);
        $scheduleText = "Jadwal Hari Ini:\n".implode("\n", $result['lines']);

        if ($result['was_limited']) {
            $scheduleText .= "\n\nCatatan: Paket ".strtoupper($result['plan'])." dibatasi {$result['task_limit']} task per hari. Upgrade Premium untuk limit lebih tinggi.";
        }

        $user->aiMessages()->create([
            'role' => 'assistant',
            'message' => $scheduleText,
            'mode' => 'generate-schedule',
        ]);

        $success = "Jadwal hari ini berhasil dibuat dan {$result['saved_count']} task tersimpan ke Task List.";

        if ($result['was_limited']) {
            $success .= " Mode FREE hanya memproses {$result['task_limit']} task.";
        }

        return back()->with('success', $success);
    }

    public function clear()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->aiMessages()->delete();

        return back()->with('success', 'Riwayat chat AI berhasil dibersihkan.');
    }
}
