<x-app-layout>
    <div class="bg-[#F9FAFB] min-h-screen font-sans antialiased text-slate-900">
        
        <header class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Halo, {{ Auth::user()->name }}</h1>
                    <p class="text-slate-500 text-sm">Selamat datang di FoodSavee. Mari buat perubahan hari ini.</p>
                </div>
                
                <div class="relative w-full md:w-80 group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-green-500/20 focus:border-green-500 sm:text-sm transition-all" placeholder="Cari makanan terdekat...">
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-10">
            
            <section>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200 p-8 shadow-sm flex flex-col justify-between">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 mb-4">Lingkungan</span>
                            <h2 class="text-xl font-bold text-slate-900 mb-2">Dampak Sosial Anda</h2>
                            <p class="text-slate-500 text-sm mb-6">Ringkasan kontribusi Anda dalam mengurangi limbah makanan bulan ini.</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <p class="text-sm text-slate-400 font-medium mb-1 uppercase tracking-wider">Makanan Diselamatkan</p>
                                <div class="flex items-baseline space-x-2">
                                    <span class="text-4xl font-black text-slate-900">12.5</span>
                                    <span class="text-lg font-bold text-green-600">kg</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-slate-400 font-medium mb-1 uppercase tracking-wider">Reduksi Emisi CO2</p>
                                <div class="flex items-baseline space-x-2">
                                    <span class="text-4xl font-black text-slate-900">3.2</span>
                                    <span class="text-lg font-bold text-yellow-500">kg</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-2xl p-8 text-white shadow-xl flex flex-col justify-between overflow-hidden relative">
                        <div class="relative z-10">
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">FoodPoint Anda</p>
                            <h3 class="text-3xl font-black italic">150.000 <span class="text-sm font-normal text-slate-400">FP</span></h3>
                        </div>
                        <div class="relative z-10 mt-8">
                            <button class="w-full py-3 bg-green-500 hover:bg-green-400 text-slate-900 font-bold rounded-xl transition-all shadow-lg shadow-green-500/20">Cari Promo</button>
                        </div>
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-green-500/20 rounded-full blur-3xl"></div>
                    </div>
                </div>
            </section>

            <section class="flex space-x-3 overflow-x-auto pb-2 scrollbar-hide">
                @foreach(['Semua', 'Populer', 'Roti', 'Nasi Box', 'Lembaga'] as $category)
                <button class="px-5 py-2 text-sm font-semibold rounded-full bg-white border border-slate-200 text-slate-600 hover:border-green-500 hover:text-green-600 transition-all whitespace-nowrap shadow-sm">
                    {{ $category }}
                </button>
                @endforeach
            </section>

            <section>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Penawaran Disekitar Anda</h3>
                    <button class="text-sm font-semibold text-green-600 hover:text-green-700">Lihat Semua</button>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:border-green-500/30 transition-all duration-300">
                        <div class="aspect-w-16 aspect-h-9 relative bg-slate-100 h-44">
                            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=500" class="w-full h-full object-cover">
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-2 py-1 rounded-lg shadow-sm">
                                <span class="text-[10px] font-bold text-orange-600">Sisa 3 Porsi</span>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-bold text-slate-900 truncate">Salad Sehat Berkah</h4>
                                <span class="text-xs font-medium text-slate-400">0.8 km</span>
                            </div>
                            <p class="text-xs text-slate-500 mb-4 font-medium italic">Restoran Hijau Daun</p>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] text-slate-400 line-through">Rp 45.000</p>
                                    <p class="text-lg font-black text-slate-900">Rp 15.000</p>
                                </div>
                                <button class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 group-hover:bg-green-600 group-hover:text-white transition-all">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    </div>
            </section>

        </main>
    </div>
</x-app-layout>