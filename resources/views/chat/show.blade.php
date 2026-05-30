<x-app-layout>
<div class="max-w-4xl mx-auto py-8 px-4 h-[calc(100vh-80px)] flex flex-col">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
        
        {{-- Chat Header --}}
        <div class="p-4 border-b border-gray-100 bg-white flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('chat.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-500 transition-colors" title="Kembali ke Daftar Chat">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-bold flex-shrink-0">
                    @if($otherUser->avatar)
                        <img src="{{ asset('storage/' . $otherUser->avatar) }}" alt="" class="w-full h-full object-cover rounded-full">
                    @else
                        {{ strtoupper(substr($otherUser->name, 0, 2)) }}
                    @endif
                </div>
                <div>
                    <h2 class="font-bold text-gray-900">{{ $otherUser->name }}</h2>
                    <p class="text-xs text-gray-500 capitalize">{{ str_replace('_', ' ', $otherUser->role) }}</p>
                </div>
            </div>

            {{-- Tombol Kembali ke Dashboard (Disesuaikan berdasarkan Role) --}}
            @php
                $dashboardRoute = match(auth()->user()->role) {
                    'admin' => route('admin.dashboard'),
                    'seller' => route('seller.dashboard'),
                    'lembaga_sosial' => route('sosial.dashboard'),
                    default => route('dashboard'), // Konsumen
                };
            @endphp
            <a href="{{ $dashboardRoute }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-colors flex items-center gap-2">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
        </div>
        
        {{-- Messages Area --}}
        <div class="flex-1 p-6 overflow-y-auto bg-gray-50 flex flex-col gap-4" id="messagesBox">
            @forelse($messages as $msg)
                @if($msg->sender_id === auth()->id())
                    {{-- My Message (Right) --}}
                    <div class="self-end max-w-[80%] md:max-w-[60%]">
                        {{-- MENGGUNAKAN bg-green-500 AGAR PASTI MUNCUL --}}
                        <div class="bg-green-500 text-white p-3 rounded-2xl rounded-tr-sm shadow-sm text-sm whitespace-pre-wrap">{{ $msg->message }}</div>
                        <div class="text-[10px] text-gray-400 mt-1 text-right">{{ $msg->created_at->format('H:i') }} • {{ $msg->is_read ? 'Dibaca' : 'Terkirim' }}</div>
                    </div>
                @else
                    {{-- Other's Message (Left) --}}
                    <div class="self-start max-w-[80%] md:max-w-[60%]">
                        <div class="bg-white border border-gray-200 text-gray-800 p-3 rounded-2xl rounded-tl-sm shadow-sm text-sm whitespace-pre-wrap">{{ $msg->message }}</div>
                        <div class="text-[10px] text-gray-400 mt-1">{{ $msg->created_at->format('H:i') }}</div>
                    </div>
                @endif
            @empty
                <div class="m-auto text-center">
                    <p class="text-gray-400 text-sm">Mulai percakapan dengan {{ $otherUser->name }}</p>
                </div>
            @endforelse
        </div>
        
        {{-- Input Area --}}
        <div class="p-4 bg-white border-t border-gray-100 flex-shrink-0">
            <form action="{{ route('chat.store', $otherUser->id) }}" method="POST" class="flex gap-2">
                @csrf
                <textarea name="message" rows="1" class="flex-1 resize-none border border-gray-200 rounded-xl py-3 px-4 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Ketik pesan..." required></textarea>
                
                {{-- MENGGUNAKAN bg-green-500 AGAR TOMBOL KIRIM TERLIHAT --}}
                <button type="submit" class="bg-green-500 text-white rounded-xl px-5 flex items-center justify-center hover:bg-green-600 transition-colors shadow-sm shadow-green-200">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transform: rotate(45deg); margin-left: -2px; margin-bottom: 2px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
        </div>
        
    </div>
</div>

<script>
    // Auto-scroll to bottom
    const box = document.getElementById('messagesBox');
    if (box) {
        box.scrollTop = box.scrollHeight;
    }
</script>
</x-app-layout>