<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Stok: ') }} {{ $menu->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
              <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-100">
                    @if($menu->image)
                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-16 h-16 rounded-lg object-cover">
                    @else
                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center text-gray-400">IMG</div>
                    @endif
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $menu->name }}</h3>
                        <p class="text-sm text-gray-500">Harga: Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <form action="{{ route('seller.menus.updateStock', $menu->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stok Baru</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $menu->stock) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none" min="0" required>
                    </div>
                    
                    <div class="flex items-center space-x-3 mt-6">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg shadow-sm transition">
                            Update Stok
                        </button>
                        <a href="{{ route('seller.dashboard') }}" class="text-gray-500 hover:text-gray-700 font-medium py-2 px-4 rounded-lg transition">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
