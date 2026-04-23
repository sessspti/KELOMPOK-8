<div class="card">
    <div class="card-body">
        <h2>{{ $menu->name }}</h2>
        <p>Harga: Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
        
        <!-- Pengecekan Kondisional (Requirement 2) -->
        @if($menu->isOutOfStock())
            <span class="badge bg-danger">Habis</span>
            <p class="text-danger mt-2">Maaf, menu ini sudah habis terjual atau masa diskon expired telah berakhir.</p>
            
            <!-- Tombol Beli di-disable -->
            <button class="btn btn-secondary mt-2" disabled>Add to Cart</button>
        @else
            <span class="badge bg-success">Stok Tersedia: {{ $menu->stock }}</span>
            
            <form action="/cart/add" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                <button type="submit" class="btn btn-success">Add to Cart / Beli</button>
            </form>
        @endif
    </div>
</div>
