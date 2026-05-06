<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            {{-- Tombol Kembali Dinamis Berdasarkan Role --}}
            @php
                $userRole = Auth::user()->role ?? 'konsumen';
                if ($userRole === 'seller') {
                    $backRoute = route('seller.dashboard');
                    $backLabel = 'Kembali ke Seller Dashboard';
                    $backIcon  = 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2';
                } elseif ($userRole === 'lembaga_sosial') {
                    $backRoute = route('sosial.dashboard');
                    $backLabel = 'Kembali ke Dashboard Sosial';
                    $backIcon  = 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6';
                } else {
                    $backRoute = route('dashboard');
                    $backLabel = 'Kembali ke Beranda';
                    $backIcon  = 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6';
                }
            @endphp

            <div class="flex items-center gap-3">
                {{-- Back Button --}}
                <a href="{{ $backRoute }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                          bg-white border border-green-100 text-green-700 text-sm font-semibold
                          shadow-sm hover:bg-green-50 hover:border-green-300 hover:shadow-md
                          transition-all duration-200 group">
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-1"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ $backLabel }}
                </a>

                {{-- Page Title --}}
                <h2 class="font-bold text-2xl text-green-800 leading-tight tracking-tight">
                    {{ __('Profil Saya') }}
                </h2>
            </div>

            <div class="text-sm text-gray-500 bg-green-50 px-3 py-1 rounded-full border border-green-100 inline-flex items-center gap-1.5">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Kelola informasi akun dan pengaturan keamanan
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-green-50/50 to-yellow-50/30">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- Role Badge --}}
            @php
                $roleBadges = [
                    'seller'        => ['label' => '🏪 Seller',          'class' => 'bg-green-100 text-green-800 border-green-200'],
                    'lembaga_sosial'=> ['label' => '🏛 Lembaga Sosial',  'class' => 'bg-sky-100 text-sky-800 border-sky-200'],
                    'konsumen'      => ['label' => '🛒 Konsumen',         'class' => 'bg-amber-100 text-amber-800 border-amber-200'],
                    'admin'         => ['label' => '⚙️ Admin',            'class' => 'bg-purple-100 text-purple-800 border-purple-200'],
                ];
                $badge = $roleBadges[$userRole] ?? ['label' => ucfirst($userRole), 'class' => 'bg-gray-100 text-gray-700 border-gray-200'];
            @endphp

            <div class="flex items-center gap-3 px-1">
                <div class="w-12 h-12 rounded-2xl bg-green-100 border-2 border-green-200 flex items-center justify-center font-extrabold text-green-700 text-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div>
                    <p class="text-lg font-bold text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                    <span class="inline-flex items-center text-xs font-bold tracking-wider uppercase px-2.5 py-0.5 rounded-full border {{ $badge['class'] }}">
                        {{ $badge['label'] }}
                    </span>
                </div>
            </div>

            <!-- Profile Info Card -->
            <div class="p-6 sm:p-10 bg-white shadow-xl shadow-green-900/5 border border-green-50 rounded-3xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-green-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 transform translate-x-1/2 -translate-y-1/2"></div>
                <div class="relative z-10 max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-6 sm:p-10 bg-white shadow-xl shadow-green-900/5 border border-green-50 rounded-3xl relative overflow-hidden">
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-yellow-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 transform translate-x-1/3 translate-y-1/3"></div>
                <div class="relative z-10 max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User Card -->
            <div class="p-6 sm:p-10 bg-red-50/30 shadow-xl shadow-red-900/5 border border-red-100 rounded-3xl relative overflow-hidden">
                <div class="absolute top-1/2 right-0 w-64 h-64 bg-red-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 transform translate-x-1/2 -translate-y-1/2"></div>
                <div class="relative z-10 max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            {{-- Bottom: another back button for UX --}}
            <div class="flex justify-center pt-2 pb-8">
                <a href="{{ $backRoute }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl
                          bg-green-600 text-white text-sm font-bold
                          shadow-lg shadow-green-600/30 hover:bg-green-700
                          hover:shadow-xl hover:shadow-green-700/35
                          transition-all duration-200 group">
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-1"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ $backLabel }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
