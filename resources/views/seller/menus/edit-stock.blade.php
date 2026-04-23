<div class="container">
    <h3>Update Stok Manual: {{ $menu->name }}</h3>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('seller.menus.updateStock', $menu->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="stock">Jumlah Stok Saat Ini:</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $menu->stock) }}" class="form-control" min="0" required>
        </div>
        
        <button type="submit" class="btn btn-primary mt-2">Update Stok</button>
    </form>
</div>
