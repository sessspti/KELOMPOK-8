<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-green-800 leading-tight">
            {{ __('Beranda FoodSavee') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="bg-gradient-to-r from-green-500 to-yellow-400 rounded-2xl p-6 text-white shadow-lg flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold italic">Tahukah Kamu?</h3>
                    <p class="text-sm opacity-90 max-w-md">Membuang 1 porsi nasi sama dengan membuang air sebanyak 125 liter. Yuk, terus selamatkan makanan!</p>
                </div>
                <div class="hidden md:block">
                    <span class="text-5xl">🌿</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow-sm border-l-8 border-green-500">
                    <h4 class="text-gray-600 font-bold mb-4 uppercase text-xs tracking-widest">Dampak Lingkunganmu</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-green-50 p-4 rounded-xl text-center">
                            <span class="text-3xl block mb-1">🍎</span>
                            <span class="text-2xl font-black text-green-700">12.5 Kg</span>
                            <p class="text-xs text-gray-500">Makanan Diselamatkan</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-xl text-center">
                            <span class="text-3xl block mb-1">☁️</span>
                            <span class="text-2xl font-black text-yellow-700">3.2 Kg</span>
                            <p class="text-xs text-gray-500">CO2 Dikurangi (Estimasi)</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-gray-400 italic text-center">*Visualisasi ini membantu mengurangi food waste dunia.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-yellow-400">
                    <h4 class="text-gray-600 font-bold mb-4 uppercase text-xs tracking-widest">Ringkasan Akun</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-gray-500 text-sm">Pesanan Aktif</span>
                            <span class="font-bold text-green-600">2</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-gray-500 text-sm">Saldo FoodPoint</span>
                            <span class="font-bold text-yellow-600">150.000</span>
                        </div>
                        <a href="#" class="block text-center py-2 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition">
                            Cari Makanan Favorit
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-gray-600 font-bold uppercase text-xs tracking-widest">Notifikasi Terbaru</h4>
                    <span class="text-xs text-green-600 font-semibold cursor-pointer">Lihat Semua</span>
                </div>
                <div class="space-y-3">
                    <div class="flex items-start p-3 hover:bg-gray-50 rounded-lg transition border-l-4 border-green-500">
                        <div class="bg-green-100 p-2 rounded-full mr-3 text-green-600">📍</div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Pesanan Siap Diambil!</p>
                            <p class="text-xs text-gray-500">Nasgor dari Merchant 'Sari Rasa' sudah siap dikemas.</p>
                        </div>
                    </div>
                    <div class="flex items-start p-3 hover:bg-gray-50 rounded-lg transition border-l-4 border-yellow-400">
                        <div class="bg-yellow-100 p-2 rounded-full mr-3 text-yellow-600">🎁</div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Donasi Baru Tersedia</p>
                            <p class="text-xs text-gray-500">Lembaga Sosial 'Amanah' membagikan paket roti.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>