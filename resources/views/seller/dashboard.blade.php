<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dasbor Penjual - FoodSave') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
              <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Daftar Produk -->
            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Daftar Menu Makanan</h3>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm border-b border-gray-100">
                                <th class="p-4 font-semibold">Produk</th>
                                <th class="p-4 font-semibold">Harga</th>
                                <th class="p-4 font-semibold">Stok</th>
                                <th class="p-4 font-semibold">Status</th>
                                <th class="p-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($menus ?? [] as $menu)
                            <tr class="border-b border-gray-50 {{ $menu->stock <= 0 ? 'bg-red-50/30 opacity-70' : 'hover:bg-gray-50 transition' }}">
                                <td class="p-4 flex items-center space-x-3">
                                    @if($menu->image)
                                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center text-gray-400">IMG</div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $menu->name }}</p>
                                        <p class="text-xs text-gray-500 truncate w-48">{{ $menu->description }}</p>
                                    </div>
                                </td>
                                <td class="p-4 text-gray-700 font-medium">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                <td class="p-4 {{ $menu->stock <= 0 ? 'text-red-600 font-bold' : 'text-gray-700' }}">{{ $menu->stock }} Porsi</td>
                                <td class="p-4">
                                    @if($menu->stock > 0)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Tersedia</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Habis</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <a href="{{ route('seller.menus.editStock', $menu->id) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Update Stok</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">Belum ada produk yang ditambahkan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form Tambah Produk -->
            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-4 mt-8">Tambah Listing Menu Baru</h3>
                <form action="{{ route('seller.menus.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Menu -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Menu <span class="text-red-500">*</span></label>
                            <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition" required placeholder="Contoh: Nasi Goreng Sisa Katering">
                        </div>
                        
                        <!-- Harga -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none" required>
                        </div>

                        <!-- Stok Awal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none" required>
                        </div>

                        <!-- Foto Produk -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                    <div class="text-sm text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500">
                                            <span>Unggah file</span>
                                            <input id="file-upload" name="image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk</label>
                            <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg shadow-sm transition">Simpan Produk</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>
