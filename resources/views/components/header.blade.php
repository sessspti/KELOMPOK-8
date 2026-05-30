<header class="hdr">
    <div class="hdr-inner">
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ asset('images/logo-foodsave.png') }}" alt="FoodSave" class="h-14 w-auto object-contain">
            <span class="ml-2">Food<span class="logo-text-save">Save</span></span>
        </a>
        <div class="hdr-search">
            <svg class="hdr-search-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Cari makanan yang bisa diselamatkan..." x-model="searchQuery">
        </div>
        <div class="hdr-right">
            <!-- Form Filter Kota Konsumen/Lembaga -->
            <form method="GET" action="{{ url()->current() }}" class="inline-flex items-center mr-2">
                <select name="kota" onchange="this.form.submit()" class="flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-200 rounded-full hover:bg-gray-50 hover:border-gray-300 transition-all focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm text-sm font-semibold text-gray-700 appearance-none pl-4 pr-10 cursor-pointer bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%208l5%205%205-5%22%20stroke%3D%22%239CA3AF%22%20stroke-width%3D%222%22%20fill%3D%22none%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[position:right_0.75rem_center]">
                    <option value="" {{ request('kota') == '' ? 'selected' : '' }}>🌍 Semua Kota</option>
                    <option value="jakarta" {{ request('kota') == 'jakarta' ? 'selected' : '' }}>🏢 Jakarta</option>
                    <option value="tangerang" {{ request('kota') == 'tangerang' ? 'selected' : '' }}>🌆 Tangerang</option>
                    <option value="purwakarta" {{ request('kota') == 'purwakarta' ? 'selected' : '' }}>🏭 Purwakarta</option>
                </select>
            </form>
            
            {{-- Notifikasi Bell --}}
            @auth
            <div class="relative ml-2" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = !open" class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-xl transition-all focus:outline-none">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-full border-2 border-white shadow-sm">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     class="absolute right-0 mt-2 w-72 bg-white border border-gray-100 rounded-2xl shadow-xl z-[130] py-2 origin-top-right"
                     style="display: none;">
                    
                    <div class="px-4 py-2 border-b border-gray-50 flex justify-between items-center">
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Notifikasi</span>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] text-green-600 hover:text-green-700 font-bold">Tandai semua dibaca</button>
                            </form>
                        @endif
                    </div>

                    <div class="max-h-80 overflow-y-auto">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-50 relative group">
                                <div class="flex gap-3">
                                    <div class="text-lg flex-shrink-0">{{ $notification->data['icon'] ?? '🔔' }}</div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-800">{{ $notification->data['title'] }}</p>
                                        <p class="text-[10px] text-gray-500 mt-0.5">{{ $notification->data['message'] }}</p>
                                        <p class="text-[9px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    <button type="submit" title="Tandai dibaca" class="text-gray-400 hover:text-green-600">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="px-4 py-8 text-center">
                                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg width="20" height="20" class="text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                </div>
                                <p class="text-xs text-gray-400 font-medium">Tidak ada notifikasi baru</p>
                            </div>
                        @endforelse
                    </div>

                    @if(auth()->user()->notifications->count() > 0)
                        <div class="px-4 py-2 border-t border-gray-50 text-center">
                            <a href="#" class="text-[10px] text-gray-400 hover:text-gray-600 font-bold uppercase tracking-wider">Lihat Semua</a>
                        </div>
                    @endif
                </div>
            </div>
            @endauth

            {{-- User Account Dropdown --}}
            <div class="relative ml-3" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false" style="z-index: 110;">
                <div>
                    @auth
                        {{-- Logged in: show user name --}}
                        <button @click="open = ! open" class="flex items-center gap-2.5 px-2.5 py-1.5 bg-white border border-gray-100 rounded-2xl hover:bg-green-50 hover:border-green-200 transition-all focus:outline-none shadow-sm hover:shadow-md group">
                            {{-- Avatar Foto Profil --}}
                            <div class="relative flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-100 to-green-200 border-2 border-green-300 flex items-center justify-center text-green-700 font-extrabold text-sm overflow-hidden shadow-sm transition-all duration-300 group-hover:border-green-400 group-hover:scale-105 group-hover:shadow-[0_0_0_3px_rgba(74,222,128,0.25)]">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                {{-- Online dot --}}
                                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 border-2 border-white rounded-full"></span>
                            </div>
                            {{-- Nama User --}}
                            <div class="text-sm font-bold text-gray-700 max-w-[100px] truncate">{{ Auth::user()->name }}</div>
                            <svg class="fill-current h-3.5 w-3.5 text-gray-400 transition-transform duration-200 flex-shrink-0" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95 translate-y-1"
                     x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                     class="absolute right-0 z-[120] mt-2 w-64 rounded-2xl shadow-xl bg-white border border-gray-100 overflow-hidden origin-top-right"
                     style="display: none;">

                    {{-- Profile Card Header --}}
                    <div class="px-4 py-4 bg-gradient-to-br from-green-50 to-emerald-50 border-b border-green-100">
                        <div class="flex items-center gap-3">
                            {{-- Foto Profil Besar --}}
                            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-green-200 to-emerald-300 border-3 border-white shadow-md flex items-center justify-center text-green-700 font-black text-lg overflow-hidden flex-shrink-0" style="border-width: 3px;">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-black text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                <span class="inline-flex items-center gap-1 mt-0.5 text-[9px] font-bold text-green-700 uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="py-1">

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
                    <div class="border-t border-gray-100 my-1"></div>
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
                    </div>{{-- end py-1 --}}
                </div>{{-- end dropdown --}}
                @endauth
            </div>
        </div>
    </div>
</header>
