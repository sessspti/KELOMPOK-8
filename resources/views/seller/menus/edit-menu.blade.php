<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Menu: ') }} {{ $menu->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-yellow-50/30 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
              <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md sm:rounded-2xl border-t-4 border-t-green-500 border-x border-b border-gray-100 p-8">
                <div class="flex items-center space-x-6 mb-8 pb-6 border-b border-green-100">
                    @if($menu->image)
                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-24 h-24 rounded-xl object-cover shadow-sm border border-green-50">
                    @else
                        <div class="w-24 h-24 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600 font-semibold shadow-sm">IMG</div>
                    @endif
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $menu->name }}</h3>
                        <p class="text-md text-gray-600 mt-1">Harga: <span class="font-semibold text-green-700">Rp {{ number_format($menu->price, 0, ',', '.') }}</span></p>
                    </div>
                </div>

                <form action="{{ route('seller.menus.updateMenu', $menu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Menu -->
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Menu <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition shadow-sm bg-yellow-50/10" required>
                        </div>

                        <!-- Harga -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" id="price" value="{{ old('price', $menu->price) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition shadow-sm bg-yellow-50/10" min="0" required>
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $menu->stock) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition shadow-sm bg-yellow-50/10" min="0" required>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                            <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition shadow-sm bg-yellow-50/10">{{ old('description', $menu->description) }}</textarea>
                        </div>

                        <!-- Foto Produk -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Foto Produk (Opsional)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-yellow-300 border-dashed rounded-xl hover:bg-yellow-50 transition cursor-pointer bg-white">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-green-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                    <div class="text-sm text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer bg-transparent rounded-md font-medium text-green-600 hover:text-green-500">
                                            <span>Unggah file baru</span>
                                            <input id="file-upload" name="image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG, WEBP hingga 2MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('seller.tambah-menu') }}" class="text-gray-500 hover:text-gray-700 font-medium py-2.5 px-5 rounded-xl transition border border-transparent hover:border-gray-200">
                            Batal
                        </a>
                        <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2.5 px-8 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            Update Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
