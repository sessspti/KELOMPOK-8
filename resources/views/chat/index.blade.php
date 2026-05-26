<x-app-layout>
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900">Pesan</h2>
        </div>
        
        <div class="divide-y divide-gray-100">
            @forelse($contacts as $contact)
                <a href="{{ route('chat.show', $contact->user->id) }}" class="block p-5 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-mint-100 text-mint-600 flex items-center justify-center font-bold text-lg flex-shrink-0">
                            @if($contact->user->avatar)
                                <img src="{{ asset('storage/' . $contact->user->avatar) }}" alt="" class="w-full h-full object-cover rounded-full">
                            @else
                                {{ strtoupper(substr($contact->user->name, 0, 2)) }}
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-1">
                                <h3 class="font-bold text-gray-900 truncate pr-4">{{ $contact->user->name }}</h3>
                                <span class="text-xs text-gray-400 whitespace-nowrap">{{ $contact->last_message->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex justify-between items-center gap-2">
                                <p class="text-sm truncate {{ $contact->unread_count > 0 ? 'font-bold text-gray-900' : 'text-gray-500' }}">
                                    @if($contact->last_message->sender_id === auth()->id())
                                        <span class="text-gray-400">Anda:</span> 
                                    @endif
                                    {{ $contact->last_message->message }}
                                </p>
                                @if($contact->unread_count > 0)
                                    <span class="bg-mint-500 text-white text-xs font-bold px-2 py-0.5 rounded-full flex-shrink-0">
                                        {{ $contact->unread_count }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">💬</div>
                    <h3 class="text-gray-900 font-bold mb-1">Belum Ada Pesan</h3>
                    <p class="text-gray-500 text-sm">Mulai percakapan dengan seller atau pengguna lain.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
</x-app-layout>
