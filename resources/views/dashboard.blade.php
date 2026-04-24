<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-black text-3xl text-green-900 leading-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-sm text-green-700 font-medium tracking-wide">Siap menyelamatkan makanan lezat hari ini?</p>
            </div>
            <div class="relative w-full md:w-96">
                <input type="text" placeholder="Cari nasi box, roti, atau resto..." class="w-full pl-10 pr-4 py-3 rounded-2xl border-none shadow-sm focus:ring-2 focus:ring-yellow-400 transition">
                <div class="absolute left-3 top-3.5 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-green-100 overflow-hidden relative">
                <div class="flex items-center space-x-2 mb-6">
                    <span class="p-2 bg-green-100 rounded-lg text-green-600">🌿</span>
                    <h3 class="font-bold text-gray-800">Kontribusi Lingkunganmu</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center p-4 bg-green-50 rounded-2xl border border-green-200">
                        <div class="text-4xl mr-4">🍎</div>
                        <div>
                            <span class="block text-2xl font-black text-green-800">12.5 Kg</span>
                            <span class="text-xs text-green-600 uppercase font-bold tracking-tighter">Makanan Diselamatkan</span>
                        </div>
                    </div>
                    <div class="flex items-center p-4 bg-yellow-50 rounded-2xl border border-yellow-200">
                        <div class="text-4xl mr-4">☁️</div>
                        <div>
                            <span class="block text-2xl font-black text-yellow-800">3.2 Kg</span>
                            <span class="text-xs text-yellow-600 uppercase font-bold tracking-tighter">Emisi CO2 Dikurangi</span>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <div class="flex justify-between text-xs font-bold text-gray-500 mb-1 uppercase">
                        <span>Progress Level: Penyelamat Pemula</span>
                        <span>75%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3">
                        <div class="bg-gradient-to-r from-green-500 to-yellow-400 h-3 rounded-full" style="width: 75%"></div>
                    </div>
                </div>
            </div>

            <div class="flex space-x-4 overflow-x-auto pb-2 scrollbar-hide">
                @foreach(['Semua', 'Nasi Box', 'Roti & Kue', 'Minuman', 'Buah & Sayur'] as $cat)
                <button class="flex-shrink-0 px-6 py-2 rounded-full bg-white border border-gray-200 text-sm font-bold hover:bg-green-600 hover:text-white transition-all shadow-sm">
                    {{ $cat }}
                </button>
                @endforeach
            </div>

            <div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-black text-xl text-gray-900">Makanan Disekitarmu</h3>
                    <a href="#" class="text-sm font-bold text-green-600">Lihat Semua</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 group hover:shadow-md transition">
                        <div class="relative h-40 bg-gray-200">
                            <img src="https://via.placeholder.com/300x200" class="w-full h-full object-cover">
                            <span class="absolute top-3 left-3 bg-yellow-400 text-yellow-950 text-[10px] font-black px-2 py-1 rounded-lg uppercase shadow-sm">Sisa 5</span>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-gray-800 truncate">Nasi Goreng Spesial</h4>
                            <p class="text-[10px] text-gray-500 flex items-center mb-2">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                                Resto Sari Rasa (0.5km)
                            </p>
                            <div class="flex items-center justify-between mt-3">
                                <div>
                                    <span class="text-xs text-gray-400 line-through">Rp 25k</span>
                                    <span class="block font-black text-green-700">Rp 12.5k</span>
                                </div>
                                <button class="p-2 bg-yellow-400 rounded-xl hover:bg-yellow-500 transition shadow-sm">
                                    <svg class="w-5 h-5 text-yellow-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>

            <div class="bg-green-900 rounded-3xl p-8 text-white relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="max-w-md">
                        <h4 class="text-2xl font-black mb-2 text-yellow-400">Pahami Food Waste</h4>
                        <p class="text-sm text-green-100 opacity-80 mb-4">Baca artikel terbaru dari tim ahli kami tentang cara menyimpan makanan agar tahan lebih lama.</p>
                        <a href="#" class="inline-block px-6 py-2 bg-white text-green-900 font-bold rounded-full text-sm">Buka Artikel</a>
                    </div>
                    <div class="text-8xl opacity-20">📖</div>
                </div>
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-green-800 rounded-full"></div>
            </div>

        </div>
    </div>
</x-app-layout>