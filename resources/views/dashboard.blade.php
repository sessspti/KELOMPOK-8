<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-3xl text-green-900 leading-tight">
                {{ __('Halaman Utama') }}
            </h2>
            <div class="flex items-center space-x-2 bg-white px-4 py-2 rounded-full shadow-sm border">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-sm font-medium text-gray-700">Status: Aktif Membantu Bumi</span>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <div class="relative overflow-hidden bg-gradient-to-br from-green-600 via-green-500 to-yellow-400 rounded-3xl shadow-xl p-10 transform hover:scale-[1.01] transition-all duration-300">
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <div class="md:col-span-2 text-white">
                        <span class="inline-block bg-white text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase mb-3">Misi Hari Ini 🌿</span>
                        <h3 class="text-3xl font-extrabold tracking-tight mb-3">Ayo Capai Target 'Zero Waste'!</h3>
                        <p class="text-green-50 opacity-90 text-base max-w-xl">Setiap porsi makanan yang kamu selamatkan bukan hanya menghemat uang, tapi juga melindungi air dan mengurangi emisi. Kamu adalah pahlawan lingkungan!</p>
                        <a href="#" class="inline-block mt-6 bg-yellow-400 text-yellow-950 px-6 py-3 rounded-full text-sm font-bold shadow hover:bg-white transition">Lihat Cara Kerja</a>
                    </div>
                    <div class="hidden md:flex justify-center items-center">
                        <svg class="w-40 h-40 text-green-300 opacity-60" fill="currentColor" viewBox="0 0 24 24"><path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L7.31,20.14C9.31,18.79 11.41,18 13.82,18C15.82,18 17.27,18.61 18.69,19.38C19.44,19.8 20.2,20.17 21,20.17A1,1 0 0,0 22,19.17A1,1 0 0,0 21.27,18.33C19.74,16.79 17.61,16.71 15.6,15.71C17.61,14.71 19.74,14.63 21.27,13.09A1,1 0 0,0 22,12.25A1,1 0 0,0 21,11.25C20.2,11.25 19.44,11.62 18.69,12.04C17.27,12.81 15.82,13.42 13.82,13.42C11.41,13.42 9.31,12.63 7.31,11.28L8.1,10.36C10.1,10.63 12.19,10.1 14.19,8.81C16.19,7.5 18.19,5.5 19,3C19.4,2.3 19.36,1.43 18.9,0.83C18.43,0.23 17.61,0 16.82,0C15,0 12.19,1.1 9.81,3.12C7.43,5.15 5.5,7.5 4,10H3A1,1 0 0,0 2,11A1,1 0 0,0 3,12H4.14C4.19,12.09 4.24,12.18 4.3,12.28C4.78,13.1 5.34,13.84 6,14.47L5.05,15.58C4.38,15.06 3.79,14.41 3.32,13.62A3,3 0 0,1 1,12V11A3,3 0 0,1 4,8H5C6.5,5.5 8.43,3.15 10.81,1.12C13.19,-0.9 16,-2 17.82,2C18.61,2 19.43,2.23 19.9,2.83C20.36,3.43 20.4,4.3 20,5C19.19,7.5 17.19,9.5 15.19,10.81C13.19,12.1 11.1,12.63 9.1,12.36L8.84,12.66C10.84,14.01 12.94,14.8 15.35,14.8C17.35,14.8 18.8,14.19 20.22,13.42C20.97,13 21.73,12.63 22.53,12.63A2,2 0 0,1 24.53,13.63A2,2 0 0,1 23.8,15.33C22.27,16.87 20.14,16.95 18.13,17.95C20.14,18.95 22.27,19.03 23.8,20.57A2,2 0 0,1 24.53,22.27A2,2 0 0,1 23.53,24.27C22.73,24.27 21.97,23.9 21.22,23.48C19.8,22.71 18.35,22.1 16.35,22.1C13.94,22.1 11.84,22.89 9.84,24.24L8.24,26.1L6.35,25.44C8.43,20.27 11.5,16 16.5,14"></path></svg>
                    </div>
                </div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-green-700 rounded-full opacity-50"></div>
                <div class="absolute top-10 right-1/4 w-10 h-10 bg-yellow-300 rounded-full animate-pulse"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 transform hover:shadow-lg transition-shadow">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-green-950 font-extrabold text-lg flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Jejak Kebaikan Lingkunganmu
                        </h4>
                        <span class="text-xs bg-green-100 text-green-800 px-3 py-1 rounded-full font-semibold">Bulan Ini</span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-green-50 p-6 rounded-2xl border border-green-100 relative overflow-hidden group">
                            <div class="absolute -right-5 -bottom-5 text-8xl text-green-100 group-hover:scale-110 transition-transform">🍎</div>
                            <span class="text-xs text-green-700 font-bold uppercase tracking-wider">Total Diselamatkan</span>
                            <div class="mt-2 flex items-baseline">
                                <span class="text-5xl font-black text-green-900">12.5</span>
                                <span class="text-xl font-bold text-green-700 ml-1">Kg</span>
                            </div>
                            <div class="w-full bg-green-200 rounded-full h-2 mt-4">
                                <div class="bg-green-600 h-2 rounded-full" style="w-full: 65%"></div>
                            </div>
                            <p class="text-xs text-green-600 mt-1">Hampir mencapai target mingguan!</p>
                        </div>
                        
                        <div class="bg-yellow-50 p-6 rounded-2xl border border-yellow-100 relative overflow-hidden group">
                            <div class="absolute -right-5 -bottom-5 text-8xl text-yellow-100 group-hover:scale-110 transition-transform">☁️</div>
                            <span class="text-xs text-yellow-700 font-bold uppercase tracking-wider">CO2 Dikurangi (Est)</span>
                            <div class="mt-2 flex items-baseline">
                                <span class="text-5xl font-black text-yellow-900">3.2</span>
                                <span class="text-xl font-bold text-yellow-700 ml-1">Kg</span>
                            </div>
                            <div class="w-full bg-yellow-200 rounded-full h-2 mt-4">
                                <div class="bg-yellow-500 h-2 rounded-full" style="w-full: 40%"></div>
                            </div>
                            <p class="text-xs text-yellow-600 mt-1">Setara dengan menanam 1 pohon kecil.</p>
                        </div>
                    </div>
                    <p class="mt-6 text-sm text-gray-500 text-center italic border-t pt-4">Data ini memvisualisasikan kontribusi nyata kamu bagi bumi setiap hari.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between transform hover:shadow-lg transition-shadow">
                    <div>
                        <h4 class="text-gray-900 font-extrabold text-lg mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            Dompet FoodSavee
                        </h4>
                        
                        <div class="bg-gradient-to-br from-yellow-400 to-yellow-300 text-yellow-950 p-5 rounded-xl shadow-inner mb-6">
                            <span class="text-xs font-bold uppercase tracking-wider">Saldo FoodPoint</span>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-4xl font-black">150.000</span>
                                <span class="text-lg font-bold">FP</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border">
                                <span class="text-gray-600 text-sm font-medium">Pesanan Aktif</span>
                                <span class="font-black text-xl text-green-700">2</span>
                            </div>
                            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border">
                                <span class="text-gray-600 text-sm font-medium">Favoritmu</span>
                                <span class="font-black text-xl text-green-700">5</span>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="block w-full text-center py-4 bg-green-600 text-white rounded-xl text-base font-bold shadow hover:bg-green-700 transition transform hover:-translate-y-1 mt-6 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari Makanan
                    </a>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 transform hover:shadow-lg transition-shadow">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h4 class="text-green-950 font-extrabold text-lg flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        Update Terbaru
                    </h4>
                    <span class="text-sm text-green-600 font-bold hover:text-green-800 cursor-pointer transition">Lihat Semua →</span>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center p-5 bg-gray-50 rounded-2xl border-l-4 border-green-500 hover:bg-white hover:shadow-md transition">
                        <div class="flex-shrink-0 bg-green-100 p-3 rounded-xl text-green-600 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-5 flex-grow">
                            <p class="text-base font-bold text-gray-900">Pesanan Nasgor Siap!</p>
                            <p class="text-sm text-gray-600">Merchant 'Sari Rasa' sudah menyiapkan pesananmu. Segera ambil ya!</p>
                        </div>
                        <div class="text-xs text-gray-400 font-medium ml-4">5 Menit Lalu</div>
                    </div>
                    
                    <div class="flex items-center p-5 bg-gray-50 rounded-2xl border-l-4 border-yellow-400 hover:bg-white hover:shadow-md transition">
                        <div class="flex-shrink-0 bg-yellow-100 p-3 rounded-xl text-yellow-600 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div class="ml-5 flex-grow">
                            <p class="text-base font-bold text-gray-900">Paket Donasi Baru</p>
                            <p class="text-sm text-gray-600">Lembaga Sosial 'Amanah' membuka donasi roti segar.</p>
                        </div>
                        <div class="text-xs text-gray-400 font-medium ml-4">1 Jam Lalu</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>