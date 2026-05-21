# Design Document

## Overview

Dokumen ini mendefisikan desain teknis untuk fitur status toko dan visibilitas produk di dashboard konsumen dan lembaga. Implementasi akan menambahkan logika baru tanpa mengubah kode yang sudah ada.

## Architecture

### Current Architecture
- Laravel MVC application dengan role-based access (seller, consumer, institution)
- Product/Menu management melalui Menu model
- Store status kemungkinan tersimpan di User model atau tabel terpisah

### Proposed Changes
1. Menambahkan scope/accessor pada model untuk filter visibilitas
2. Menambahkan service/repository method untuk query terpusat
3. Menambahkan event listener untuk perubahan stok dan status

## Data Models

### Current Schema (from migrations)
- `users` table: id, name, email, role, address, phone, avatar
- `menus` table: id, name, price, image, user_id (seller_id), stock, discount

### Proposed Additions
Tidak diperlukan perubahan schema. Status toko dan stock sudah ada di schema yang ada.

## Components and Interfaces

### 1. Product Model (Menu)

#### New Scopes
```php
// Scope untuk produk dengan stok > 0
public function scopeAvailable($query)
{
    return $query->where('stock', '>', 0);
}

// Scope untuk produk dari toko yang buka
public function scopeFromOpenStore($query)
{
    return $query->whereHas('seller', function ($q) {
        $q->where('store_status', 'Buka');
    });
}

// Scope untuk produk yang visible di consumer/lembaga dashboard
public function scopeVisibleForPublic($query)
{
    return $query->available()->fromOpenStore();
}
```

#### New Accessors
```php
// Accessor untuk status tampilan produk
public function getDisplayStatusAttribute()
{
    if ($this->stock <= 0) {
        return 'Habis';
    }
    
    if ($this->seller->store_status === 'Tutup') {
        return 'Tutup';
    }
    
    return 'Tersedia';
}

// Accessor untuk visibility di dashboard publik
public function getIsVisibleAttribute()
{
    return $this->stock > 0 && $this->seller->store_status === 'Buka';
}
```

### 2. Seller Model (User dengan role seller)

#### New Accessors
```php
// Accessor untuk status toko yang readable
public function getStoreStatusDisplayAttribute()
{
    return $this->store_status === 'Buka' ? 'Buka' : 'Tutup';
}

// Check apakah toko terbuka
public function getIsStoreOpenAttribute()
{
    return $this->store_status === 'Buka';
}
```

### 3. Product Repository / Service

#### New Methods
```php
<?php

namespace App\Services;

use App\Models\Menu;

class ProductVisibilityService
{
    /**
     * Get products visible for consumer dashboard
     */
    public function getVisibleProductsForConsumer()
    {
        return Menu::visibleForPublic()
            ->with('seller:id,name,store_status')
            ->get();
    }
    
    /**
     * Get products visible for institution dashboard
     */
    public function getVisibleProductsForInstitution()
    {
        return Menu::visibleForPublic()
            ->with('seller:id,name,store_status')
            ->get();
    }
    
    /**
     * Get all products for seller dashboard (including out-of-stock)
     */
    public function getAllProductsForSeller($sellerId)
    {
        return Menu::where('user_id', $sellerId)
            ->with('seller:id,name,store_status')
            ->get();
    }
    
    /**
     * Check and update product visibility after stock change
     */
    public function checkVisibilityAfterStockChange(Menu $product)
    {
        // Can be used for caching or notification logic
        return $product->is_visible;
    }
}
```

### 4. Event Listeners

#### StockChangeListener
```php
<?php

namespace App\Listeners;

use App\Models\Menu;
use Illuminate\Support\Facades\Log;

class StockChangeListener
{
    public function handle($event)
    {
        $product = $event->product ?? $event->menu ?? null;
        
        if (!$product) {
            return;
        }
        
        // Log untuk debugging
        Log::info('Stock changed', [
            'product_id' => $product->id,
            'new_stock' => $product->stock,
            'is_visible' => $product->is_visible
        ]);
        
        // Can add notification logic here if needed
    }
}
```

### 5. Event Service Provider

```php
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'eloquent.updating: App\Models\Menu' => [
            'App\Listeners\StockChangeListener@handle',
        ],
        'eloquent.created: App\Models\Menu' => [
            'App\Listeners\StockChangeListener@handle',
        ],
    ];
    
    // ... existing code
}
```

## Controller Integration

### Consumer Dashboard Controller
```php
use App\Services\ProductVisibilityService;

public function index(ProductVisibilityService $visibilityService)
{
    $products = $visibilityService->getVisibleProductsForConsumer();
    return view('consumer.dashboard', compact('products'));
}
```

### Institution Dashboard Controller
```php
use App\Services\ProductVisibilityService;

public function index(ProductVisibilityService $visibilityService)
{
    $products = $visibilityService->getVisibleProductsForInstitution();
    return view('institution.dashboard', compact('products'));
}
```

### Seller Dashboard Controller (existing, tidak diubah)
```php
// Tidak perlu diubah - seller tetap melihat semua produk termasuk yang stoknya 0
public function index()
{
    $menus = Menu::where('user_id', auth()->id())->get();
    return view('seller.dashboard', compact('menus'));
}
```

## View Updates (Non-Destructive)

### Consumer/Institution Product Card
Tambahkan atribut data untuk status:
```blade
{{-- Contoh implementasi di view --}}
<div class="product-card" 
     data-status="{{ $product->display_status }}"
     data-visible="{{ $product->is_visible ? 'true' : 'false' }}">
    {{-- Existing product display code --}}
</div>
```

### Status Badge Display
```blade
{{-- Tambahkan badge status --}}
@if($product->display_status === 'Tutup')
    <span class="badge bg-secondary">Tutup</span>
@elseif($product->display_status === 'Habis')
    <span class="badge bg-danger">Habis</span>
@else
    <span class="badge bg-success">Tersedia</span>
@endif
```

## Implementation Strategy

### Phase 1: Model Extensions
1. Tambahkan scope dan accessor pada Menu model
2. Tambahkan accessor pada User model untuk seller
3. Test dengan tinker

### Phase 2: Service Layer
1. Buat ProductVisibilityService
2. Buat event listener untuk stock change
3. Update EventServiceProvider

### Phase 3: Controller Integration
1. Update Consumer dashboard controller
2. Update Institution dashboard controller
3. Test end-to-end

### Phase 4: View Updates
1. Tambahkan status badge pada product card
2. Test tampilan di semua dashboard

## Testing Strategy

### Unit Tests
```php
// Tests for scopeAvailable
Menu::factory()->create(['stock' => 10]);
Menu::factory()->create(['stock' => 0]);

$available = Menu::available()->get();
assert($available->count() === 1);
assert($available->first()->stock === 10);

// Tests for scopeFromOpenStore
$openSeller = User::factory()->create(['role' => 'seller', 'store_status' => 'Buka']);
$closedSeller = User::factory()->create(['role' => 'seller', 'store_status' => 'Tutup']);

Menu::factory()->create(['user_id' => $openSeller->id]);
Menu::factory()->create(['user_id' => $closedSeller->id]);

$fromOpenStore = Menu::fromOpenStore()->get();
assert($fromOpenStore->count() === 1);
```

### Integration Tests
1. Test perubahan stok menyembunyikan produk
2. Test perubahan status toko mengubah tampilan
3. Test seller tetap melihat semua produk

## Security Considerations

1. **No direct database access** - Semua query melalui Eloquent ORM
2. **Authorization** - Seller hanya bisa mengubah produknya sendiri
3. **Input validation** - Stock tidak boleh negatif

## Performance Considerations

1. **Indexing** - Pastikan ada index pada `stock` dan `user_id`
2. **Caching** - Bisa ditambahkan cache untuk produk visible jika diperlukan
3. **Eager loading** - Selalu gunakan `with('seller')` untuk menghindari N+1 query

## Rollback Plan

1. Jika ada masalah, revert perubahan di model dan service
2. Controller tetap menggunakan query lama (tidak diubah)
3. View tetap kompatibel karena hanya menambah atribut, tidak mengubah struktur

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: Available products have positive stock
*For any* Menu product, if the product is available (via `scopeAvailable`), then its stock value must be greater than zero.

**Validates: Requirements 3.1, 3.2, 3.3, 3.4, 6.2, 6.5**

### Property 2: Products from open stores have open store status
*For any* Menu product, if the product is returned by `scopeFromOpenStore`, then the associated seller must have `store_status` equal to 'Buka'.

**Validates: Requirements 1.1, 1.2, 1.3, 1.4, 1.5, 7.1, 7.2**

### Property 3: Visible products are available and from open stores
*For any* Menu product, if the product is visible for public (via `scopeVisibleForPublic`), then the product must satisfy both the available scope and fromOpenStore scope conditions.

**Validates: Requirements 4.5, 4.7, 4.8, 5.4, 5.5**

### Property 4: Display status reflects stock and store state
*For any* Menu product, the `display_status` accessor must return:
- 'Habis' when stock is less than or equal to zero
- 'Tutup' when stock is greater than zero but the seller store status is 'Tutup'
- 'Tersedia' when stock is greater than zero and seller store status is 'Buka'

**Validates: Requirements 1.6, 1.9, 2.3, 2.4, 3.1, 3.2, 7.3, 7.4**

### Property 5: Visibility is true only for available products from open stores
*For any* Menu product, the `is_visible` accessor must return true if and only if the product has stock greater than zero AND the seller has store_status equal to 'Buka'.

**Validates: Requirements 3.1, 3.2, 3.6, 3.7, 4.5, 6.2, 6.5**

## Error Handling

### Model-Level Error Handling

1. **Null Seller Handling**: When accessing seller relationship on a Menu product, Eloquent will return null if the seller doesn't exist. The accessors should handle this gracefully by checking if the seller relationship exists before accessing `store_status`.

2. **Negative Stock Prevention**: Stock values should be validated at the application level to prevent negative stock values. This can be done in the model or in form requests.

### Service-Level Error Handling

1. **Product Not Found**: The `ProductVisibilityService` methods should handle cases where products are not found by returning empty collections rather than throwing exceptions.

2. **Relationship Loading Failures**: When using `with('seller')`, if the seller relationship fails to load, the service should continue to work but the seller information may be missing from the results.

### Event Listener Error Handling

1. **Invalid Event Data**: The `StockChangeListener` should check if the event contains valid product data before attempting to process it. If the product is null or invalid, the listener should return early without throwing an exception.

2. **Logging Failures**: If logging fails, it should not prevent the main application flow from continuing.

### Controller-Level Error Handling

1. **Service Exceptions**: Controllers should catch any exceptions thrown by the `ProductVisibilityService` and handle them appropriately (e.g., redirect with error message or return empty view).

2. **Authentication Errors**: Controllers should ensure that the user is authenticated before accessing visibility service methods.

### Database-Level Error Handling

1. **Transaction Safety**: When updating stock values, operations should be wrapped in database transactions to ensure data consistency.

2. **Concurrency Issues**: For high-traffic scenarios, consider using optimistic locking or database transactions to handle concurrent stock updates.