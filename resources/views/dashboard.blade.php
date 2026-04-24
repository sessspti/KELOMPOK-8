<x-app-layout>
    <div class="bg-gray-50 min-h-screen pb-20">
        <div class="fixed bottom-10 right-10 z-50">
            <a href="#" class="flex items-center bg-green-600 text-white px-6 py-4 rounded-full shadow-2xl hover:bg-green-700 transform hover:scale-110 transition-all duration-300">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="font-bold">Keranjang (3)</span>
            </a>
        </div>

        <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <h2 class="text-xl font-black text-green-800 tracking-tighter uppercase">FoodSave</h2>
                    <div class="relative flex-grow md:w-96 hidden md:block">
                        <input type="text" placeholder="Cari makanan yang bisa diselamatkan..." class="w-full bg-gray-100 border-none rounded-xl py-2 px-10 text-sm focus:ring-2 focus:ring-green-500">
                        <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-bold text-yellow-600 bg-yellow-50 px-3 py-1 rounded-lg">150.000 FP</span>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 space-y-12">
            
            <section class="bg-gradient-to-br from-green-900 to-green-800 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl">
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div>
                        <span class="text-yellow-400 text-xs font-black uppercase tracking-[0.2em] mb-2 block">Dampak Lingkunganmu</span>
                        <h3 class="text-3xl font-bold mb-4 italic text-white leading-tight font-serif">"Langkah kecilmu, nafas baru untuk bumi."</h3>
                        <div class="flex gap-6 mt-6">
                            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 w-32">
                                <span class="block text-2xl font-black">12.5 <small class="text-xs">Kg</small></span>
                                <span class="text-[10px] uppercase opacity-70">Food Saved</span>
                            </div>
                            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 w-32">
                                <span class="block text-2xl font-black">3.2 <small class="text-xs">Kg</small></span>
                                <span class="text-[10px] uppercase opacity-70">CO2 Reduced</span>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-full h-32 bg-yellow-400/20 rounded-3xl border-2 border-dashed border-yellow-400 flex items-center justify-center">
                            <span class="text-yellow-400 font-bold">Visual Impact Tracker Soon</span>
                        </div>
                    </div>
                </div>
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-64 h-64 bg-green-500 rounded-full blur-[100px] opacity-20"></div>
            </section>

            <section>
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight">Rescue Deals Hari Ini</h3>
                        <p class="text-gray-500 text-sm">Makanan berkualitas dengan harga penyelamat.</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="p-2 bg-white border rounded-lg hover:bg-gray-50 text-gray-400">←</button>
                        <button class="p-2 bg-white border rounded-lg hover:bg-gray-50 text-gray-400">→</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @for ($i = 0; $i < 4; $i++)
                    <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500 group">
                        <div class="relative h-56 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=500" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full shadow-sm">
                                <span class="text-[10px] font-black text-green-700 uppercase">0.5 km</span>
                            </div>
                            <div class="absolute bottom-4 right-4 bg-orange-500 text-white px-3 py-1 rounded-lg shadow-lg">
                                <span class="text-xs font-bold italic">Sisa 2!</span>
                            </div>
                        </div>
                        <div class="p-6 text-left">
                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-1 tracking-widest">Resto Ayam Berkah</p>
                            <h4 class="text-lg font-bold text-gray-900 mb-4 truncate">Paket Ayam Geprek Surplus</h4>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-gray-400 line-through">Rp 25.000</span>
                                    <span class="block text-xl font-black text-green-700">Rp 12.500</span>
                                </div>
                                <button class="bg-yellow-400 hover:bg-yellow-500 text-yellow-950 p-3 rounded-2xl transition-all shadow-lg shadow-yellow-400/30">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </section>

            <section class="py-12 border-t border-gray-200">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-gray-900 tracking-tight italic">Edukasi & Lingkungan</h3>
                    <a href="#" class="text-sm font-bold text-green-700 border-b-2 border-green-700">Lihat Semua Artikel</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="flex flex-col space-y-4">
                        <div class="h-48 bg-gray-200 rounded-[2rem] overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=500" class="w-full h-full object-cover">
                        </div>
                        <span class="text-[10px] font-black text-green-600 uppercase">Tips Penyimpanan</span>
                        <h4 class="text-lg font-bold leading-tight hover:text-green-700 cursor-pointer transition">5 Cara Agar Sayuran Tetap Segar Selama Seminggu</h4>
                        <p class="text-sm text-gray-500 line-clamp-2">Admin FoodSave membagikan tips rahasia menyimpan bahan makanan agar tidak cepat terbuang...</p>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <div class="h-48 bg-gray-200 rounded-[2rem] overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=500" class="w-full h-full object-cover">
                        </div>
                        <span class="text-[10px] font-black text-green-600 uppercase">Global Issue</span>
                        <h4 class="text-lg font-bold leading-tight hover:text-green-700 cursor-pointer transition">Dampak Mengerikan Food Waste bagi Perubahan Iklim</h4>
                        <p class="text-sm text-gray-500 line-clamp-2">Mengetahui seberapa besar pengaruh sisa makanan terhadap lapisan ozon bumi kita.</p>
                    </div>
                    <div class="border-2 border-dashed border-gray-200 rounded-[2rem] flex items-center justify-center p-8 text-center">
                        <p class="text-sm text-gray-400 italic font-medium">Artikel lainnya sedang disiapkan oleh Admin kami...</p>
                    </div>
                </div>
            </section>

        </main>
    </div>
</x-app-layout>