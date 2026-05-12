<header class="hdr">
    <div class="hdr-inner">
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ asset('images/logo-foodsave.png') }}" alt="FoodSave" class="h-20 w-auto object-contain">
            <span class="ml-2">Food<span class="logo-text-save">Save</span></span>
        </a>
        <div class="hdr-search">
            <svg class="hdr-search-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Cari makanan yang bisa diselamatkan..." x-model="searchQuery">
        </div>
        <div class="hdr-right">
            <span class="pts-pill">✦ 150.000 FP</span>

            {{-- Notifikasi Bell --}}
            <div class="relative ml-2" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = !open" class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-xl transition-all focus:outline-none">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 border-2 border-white rounded-full"></span>
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     class="absolute right-0 mt-2 w-72 bg-white border border-gray-100 rounded-2xl shadow-xl z-[130] py-2 origin-top-right"
                     style="display: none;">
                    
                    <div class="px-4 py-2 border-b border-gray-50 flex justify-between items-center">
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Notifikasi</span>
                        <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-bold">3 Terbaru</span>
                    </div>

                    <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-50">
                        <p class="text-xs font-bold text-gray-800">✅ Pesanan siap diambil!</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">Ayam Geprek Berkah sudah dikemas.</p>
                    </div>
                    <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-50">
                        <p class="text-xs font-bold text-gray-800">🤝 Donasi baru tersedia</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">Lembaga Kasih butuh 5 paket makanan.</p>
                    </div>
                    <div class="px-4 py-3 hover:bg-gray-50">
                        <p class="text-xs font-bold text-gray-800">✨ Poin FP Bertambah</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">Kamu baru saja menyelamatkan bumi!</p>
                    </div>
                </div>
            </div>

            {{-- User Account Dropdown --}}
            <div class="relative ml-3" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false" style="z-index: 110;">
                <div>
                    @auth
                        {{-- Logged in: show user name --}}
                        <button @click="open = ! open" class="flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all focus:outline-none shadow-sm">
                            <div class="w-7 h-7 rounded-lg bg-green-100 border border-green-200 flex items-center justify-center text-green-700 font-extrabold text-xs flex-shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="text-sm font-bold text-gray-700">{{ Auth::user()->name }}</div>
                            <svg class="fill-current h-4 w-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @else
                        {{-- Guest: show login/register buttons --}}
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}"
                               class="px-4 py-2 text-sm font-bold text-green-700 bg-green-50 border border-green-200 rounded-xl hover:bg-green-100 transition-all">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}"
                               class="px-4 py-2 text-sm font-bold text-white bg-green-600 rounded-xl hover:bg-green-700 transition-all shadow-sm">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>

                @auth
                <div x-show="open"
                     class="absolute right-0 z-[120] mt-2 w-52 rounded-2xl shadow-xl bg-white border border-gray-100 py-2 origin-top-right"
                     style="display: none;">
                    <div class="px-4 py-2 text-[10px] text-gray-400 uppercase font-black tracking-widest border-b border-gray-50 mb-1">
                        Pengaturan Akun
                    </div>

                    {{-- Role-aware profile link --}}
                    @php
                        $profileRoute = match(Auth::user()->role) {
                            'seller'         => route('profile.edit'),
                            'lembaga_sosial' => route('profile.edit'),
                            default          => route('profile.edit'),
                        };
                    @endphp
                    <a href="{{ $profileRoute }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors font-medium">
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Edit Profil
                        </div>
                    </a>

                    @if(Auth::user()->role === 'konsumen' || Auth::user()->role === 'lembaga_sosial')
                    <a href="{{ route('transaction.history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors font-medium">
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            {{ Auth::user()->role === 'lembaga_sosial' ? 'Riwayat Klaim' : 'Riwayat Pesanan' }}
                        </div>
                    </a>
                    @endif
                    <div class="border-t border-gray-50 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors font-medium">
                            <div class="flex items-center gap-2">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                {{ __('Keluar') }}
                            </div>
                        </a>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </div>
</header>
