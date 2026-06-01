<x-app-layout>
    @php
        $backRoute = route('guest.dashboard'); // Default (guest)
        if (auth()->check()) {
            $role = auth()->user()->role;
            if ($role === 'seller') $backRoute = route('seller.dashboard');
            elseif ($role === 'lembaga_sosial') $backRoute = route('sosial.dashboard');
            elseif ($role === 'konsumen') $backRoute = route('dashboard');
        }
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
         x-data="{
             showModal: false,
             article: { title: '', category: '', image: '', content: '' },
             openModal(data) {
                 this.article = data;
                 this.showModal = true;
                 document.body.style.overflow = 'hidden';
             },
             closeModal() {
                 this.showModal = false;
                 document.body.style.overflow = '';
                 setTimeout(() => { this.article = { title: '', category: '', image: '', content: '' } }, 300);
             }
         }">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Edukasi & Lingkungan</h1>
        <p class="text-gray-500 mt-1">Temukan wawasan, tips, dan inspirasi seputar lingkungan dan food waste.</p>
    </div>

    <a href="{{ $backRoute }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100 text-sm font-semibold text-green-700 hover:text-green-800 hover:bg-green-50 transition-colors whitespace-nowrap self-start md:self-auto">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Dashboard
    </a>
</div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($articles as $article)
                <div @click="openModal({
                        title: '{{ addslashes($article->title) }}',
                        category: '{{ addslashes($article->category) }}',
                        image: '{{ $article->image ? asset('storage/' . $article->image) : 'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=500' }}',
                        content: `{{ addslashes($article->content) }}`
                    })" 
                    class="cursor-pointer bg-white shadow-sm rounded-xl overflow-hidden hover:-translate-y-1 hover:shadow-lg transition-all duration-300 border border-gray-100 flex flex-col h-full group">
                    <div class="w-full aspect-video relative overflow-hidden bg-gray-50">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=500" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-green-100 text-green-800 mb-3 w-max">
                            {{ $article->category }}
                        </span>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 leading-snug group-hover:text-green-700 transition-colors">{{ $article->title }}</h3>
                        <p class="text-sm text-gray-500 line-clamp-2 flex-grow">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-3 lg:col-span-4 bg-green-50 shadow-sm rounded-xl overflow-hidden border border-green-200 border-dashed flex flex-col items-center justify-center p-12 text-center text-green-700 min-h-[300px]">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" height="48" class="mb-4 opacity-50"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    <p class="font-medium text-lg">Belum Ada Artikel</p>
                    <p class="text-sm mt-2 opacity-80">Artikel sedang disiapkan oleh Admin kami...</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $articles->links() }}
        </div>

        {{-- MODAL ARTIKEL LENGKAP --}}
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-[600] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                {{-- Background overlay --}}
                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" @click="closeModal()"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- Modal panel --}}
                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full">
                    
                    {{-- Header Gambar --}}
                    <div class="relative w-full aspect-[21/9] bg-gray-100">
                        <img :src="article.image" alt="Article Cover" class="w-full h-full object-cover">
                        <button @click="closeModal()" class="absolute top-4 right-4 bg-black bg-opacity-50 hover:bg-opacity-70 text-white rounded-full p-2 transition-colors">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    {{-- Konten Artikel --}}
                    <div class="px-6 py-8 sm:px-10 sm:py-10">
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-green-100 text-green-800 mb-4" x-text="article.category"></span>
                        <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 leading-tight" x-text="article.title" style="font-family: 'Space Grotesk', sans-serif;"></h3>
                        
                        {{-- Gunakan x-html agar tag HTML (jika ada) ter-render --}}
                        <div class="prose prose-green max-w-none text-gray-600 leading-relaxed text-base sm:text-lg" style="white-space: pre-wrap;" x-html="article.content"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
