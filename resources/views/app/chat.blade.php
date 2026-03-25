@extends('app.layout')

@section('content')
<div class="grid gap-4 lg:grid-cols-4">
    <aside class="lg:col-span-1 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900">Chat Teman</h2>
        <p class="mt-1 text-xs text-slate-500">Pilih teman untuk mulai percakapan 1 lawan 1.</p>

        <div class="mt-3 space-y-2">
            @forelse ($friends as $friend)
                @php
                    $isActive = $activeFriend && $activeFriend->id === $friend->id;
                    $isOnline = optional($friend->updated_at)->gt(now()->subMinutes(5));
                    $friendUnread = (int) ($unreadByFriend[$friend->id] ?? 0);
                @endphp
                <a href="{{ route('chat.index', ['friend_id' => $friend->id]) }}" class="flex items-center justify-between rounded-xl border px-3 py-2.5 transition {{ $isActive ? 'border-softi-200 bg-softi-50' : 'border-slate-200 bg-slate-50 hover:bg-white' }}">
                    <div>
                        <p class="text-sm font-semibold text-slate-800">{{ $friend->name }}</p>
                        <p class="text-[11px] {{ $isOnline ? 'text-emerald-700' : 'text-slate-500' }}">{{ $isOnline ? 'Online' : 'Offline' }}</p>
                        @if (!empty($friend->last_message_preview))
                            <p class="mt-0.5 max-w-[180px] truncate text-[11px] text-slate-500">{{ $friend->last_message_preview }}</p>
                        @endif
                    </div>
                    @if ($friendUnread > 0)
                        <span class="inline-flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white">{{ $friendUnread }}</span>
                    @endif
                </a>
            @empty
                <p class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-600">Belum ada teman. Tambah teman dulu untuk mulai chat.</p>
            @endforelse
        </div>
    </aside>

    <section class="lg:col-span-3 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        @if (!$activeFriend)
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-8 text-center">
                <h3 class="text-lg font-bold text-slate-800">Belum ada percakapan</h3>
                <p class="mt-1 text-sm text-slate-600">Pilih teman dari sidebar untuk membuka chat.</p>
            </div>
        @else
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">{{ $activeFriend->name }}</h3>
                    @php $activeOnline = optional($activeFriend->updated_at)->gt(now()->subMinutes(5)); @endphp
                    <p class="text-xs {{ $activeOnline ? 'text-emerald-700' : 'text-slate-500' }}">{{ $activeOnline ? 'Online' : 'Offline' }}</p>
                </div>
                <span class="rounded-full bg-softi-50 px-3 py-1 text-xs font-semibold text-softi-700">PRIVATE</span>
            </div>

            <div id="privateChatBox" class="h-[430px] overflow-y-auto rounded-2xl border border-slate-200 bg-slate-50 p-3 space-y-3"></div>

            <form id="privateChatForm" class="mt-4 flex items-center gap-2">
                @csrf
                <input
                    id="privateMessageInput"
                    type="text"
                    class="flex-1 rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-softi-500 focus:outline-none focus:ring-2 focus:ring-softi-100"
                    placeholder="Ketik pesan..."
                    maxlength="2000"
                    required
                >
                <button id="privateSendBtn" type="submit" class="rounded-xl bg-gradient-to-r from-softi-600 to-cyan-600 px-4 py-2.5 text-sm font-semibold text-white">Kirim</button>
            </form>
            <p id="privateSendingIndicator" class="mt-2 text-xs text-softi-700 hidden">sending...</p>
            <p id="privateChatError" class="mt-2 text-xs text-red-600 hidden"></p>
        @endif
    </section>
</div>

@if ($activeFriend)
<script>
(() => {
    if (window.__privateChatMounted) {
        return;
    }
    window.__privateChatMounted = true;

    const chatBox = document.getElementById('privateChatBox');
    const chatForm = document.getElementById('privateChatForm');
    const input = document.getElementById('privateMessageInput');
    const sendBtn = document.getElementById('privateSendBtn');
    const sendingIndicator = document.getElementById('privateSendingIndicator');
    const errorText = document.getElementById('privateChatError');
    const currentUserId = {{ (int) auth()->id() }};
    const friendId = {{ (int) $activeFriend->id }};

    let lastMessageId = 0;
    if (typeof window.__privateChatIsSending !== 'boolean') {
        window.__privateChatIsSending = false;
    }
    let unlockTimer = null;
    const renderedMessageIds = new Set();

    if (!chatForm || chatForm.dataset.bound === 'true') {
        return;
    }
    chatForm.dataset.bound = 'true';
    console.log('event mounted');

    function escapeHtml(value) {
        return value
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function messageMarkup(item) {
        const mine = Number(item.sender_id) === Number(currentUserId);
        const alignClass = mine ? 'items-end' : 'items-start';
        const bubbleClass = mine
            ? 'bg-gradient-to-r from-softi-600 to-cyan-600 text-white'
            : 'bg-white border border-slate-200 text-slate-800';

        return `
            <div class="flex ${alignClass}">
                <div class="max-w-[80%] rounded-2xl px-3 py-2 ${bubbleClass}">
                    <p class="text-[11px] ${mine ? 'text-cyan-100' : 'text-slate-500'}">${mine ? 'Kamu' : '{{ addslashes($activeFriend->name) }}'} • ${escapeHtml(item.created_at || '-')}</p>
                    <p class="mt-1 whitespace-pre-wrap break-words text-sm">${escapeHtml(item.message)}</p>
                </div>
            </div>
        `;
    }

    function appendMessages(messages) {
        if (!Array.isArray(messages) || messages.length === 0) {
            return;
        }

        const wasNearBottom = chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight < 120;

        messages.forEach((item) => {
            const messageId = Number(item.id || 0);
            if (messageId > 0 && renderedMessageIds.has(messageId)) {
                return;
            }

            chatBox.insertAdjacentHTML('beforeend', messageMarkup(item));
            if (messageId > 0) {
                renderedMessageIds.add(messageId);
                lastMessageId = Math.max(lastMessageId, messageId);
            }
            console.log('RECEIVE');
        });

        if (wasNearBottom) {
            scrollToBottom();
        }
    }

    async function fetchMessages() {
        const response = await fetch(`{{ route('chat.fetch', $activeFriend) }}?after_id=${lastMessageId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        if (!response.ok) {
            return;
        }

        const data = await response.json();
        appendMessages(data.messages || []);
    }

    async function sendMessage() {
        console.log('SEND');
        errorText.classList.add('hidden');

        if (window.__privateChatIsSending) {
            return;
        }

        const text = (input.value || '').trim();
        if (!text) {
            errorText.textContent = 'Pesan tidak boleh kosong.';
            errorText.classList.remove('hidden');
            return;
        }

        window.__privateChatIsSending = true;
        sendBtn.disabled = true;
        input.disabled = true;
        sendingIndicator.classList.remove('hidden');

        try {
            const response = await fetch(`{{ route('chat.store', $activeFriend) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    friend_id: friendId,
                    message: text,
                }),
            });

            if (!response.ok) {
                errorText.textContent = 'Gagal mengirim pesan. Coba lagi.';
                errorText.classList.remove('hidden');
                return;
            }

            const payload = await response.json();
            if (payload.message) {
                appendMessages([payload.message]);
                input.value = '';
                input.focus();
                scrollToBottom();
                return;
            }

            if (payload.duplicate) {
                console.log('Duplicate message blocked');
                return;
            }

            errorText.textContent = 'Pesan tidak diproses.';
            errorText.classList.remove('hidden');
        } finally {
            if (unlockTimer) {
                clearTimeout(unlockTimer);
            }

            unlockTimer = setTimeout(() => {
                window.__privateChatIsSending = false;
                sendBtn.disabled = false;
                input.disabled = false;
                sendingIndicator.classList.add('hidden');
                unlockTimer = null;
            }, 500);
        }
    }

    chatForm.addEventListener('submit', (event) => {
        event.preventDefault();
        sendMessage();
    });

    fetchMessages();
    if (window.privateChatPollIntervalId) {
        clearInterval(window.privateChatPollIntervalId);
    }
    window.privateChatPollIntervalId = setInterval(fetchMessages, 2000);
})();
</script>
@endif
@endsection
