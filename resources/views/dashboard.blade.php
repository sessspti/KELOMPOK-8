<x-app-layout>
    <!-- Wrapper Utama dengan Flexbox -->
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
        
        <!-- ================= SIDEBAR ================= -->
        <aside class="w-64 flex-shrink-0 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 hidden md:flex flex-col">
            <!-- Logo / Judul -->
            <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
                <span class="text-xl font-bold text-green-600 dark:text-green-400">FoodSavee</span>
            </div>

            <!-- Menu Navigasi -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <!-- Link Dashboard Aktif -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium text-green-700 bg-green-50 rounded-lg dark:bg-green-900/30 dark:text-green-400">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                <!-- Contoh Link ke Fitur CRUD Menu (Belum dibuat route-nya secara lengkap) -->
                <a href="#" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-gray-50 rounded-lg dark:text-gray-400 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Manajemen Menu
                </a>

                <!-- Contoh Link ke Fitur Order -->
                <a href="#" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-green-600 hover:bg-gray-50 rounded-lg dark:text-gray-400 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Pesanan Saya
                </a>
            </nav>
        </aside>

        <!-- ================= KONTEN UTAMA & NAVBAR ================= -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Navbar Tambahan (Bisa digabung dengan navigasi Breeze yang ada) -->
            <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-6">
                <!-- Hamburger menu untuk mobile -->
                <button class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <div class="flex-1"></div> <!-- Spacer -->

                <!-- Profile Dropdown (Menggunakan nama user yang login) -->
                <div class="flex items-center">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">
                        Halo, {{ Auth::user()->name }}
                    </span>
                    <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Area Konten Dinamis -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900 p-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Ringkasan Aktivitas</h3>
                    <p class="text-gray-600 dark:text-gray-400">Selamat datang di dashboard FoodSavee. Pilih menu di sebelah kiri untuk mengelola data aplikasi.</p>
                    
                    <!-- Contoh Grid Card untuk statistik singkat -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-100 dark:border-green-800">
                            <div class="text-sm text-green-600 dark:text-green-400 font-medium">Total Pesanan</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">12</div>
                        </div>
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800">
                            <div class="text-sm text-blue-600 dark:text-blue-400 font-medium">Menu Aktif</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">5</div>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>
</x-app-layout>
