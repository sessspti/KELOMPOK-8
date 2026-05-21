<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['user_id', 'name', 'price', 'discount', 'stock', 'image', 'expiry_date'];
    protected $appends = ['final_price', 'image_url', 'formatted_expiry_date', 'store'];

    protected static function booted()
    {
        static::deleting(function ($menu) {
            // Hapus semua order yang terkait dengan menu ini
            $menu->orders()->delete();
        });
    }

    // Accessor untuk Nama Toko
    public function getStoreAttribute()
    {
        return $this->user ? $this->user->name : 'Toko FoodSave';
    }

    // Accessor untuk URL foto
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    // Accessor untuk Tanggal Expired terformat
    public function getFormattedExpiryDateAttribute()
    {
        return $this->expiry_date ? \Carbon\Carbon::parse($this->expiry_date)->format('d M Y') : '-';
    }

    // Hitung harga setelah diskon
    public function getFinalPriceAttribute(): float
    {
        return $this->price - ($this->price * ($this->discount / 100));
    }

    // Accessor untuk status tampilan produk
    public function getDisplayStatusAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'Habis';
        }

        if ($this->user && $this->user->is_open == 0) {
            return 'Tutup';
        }

        return 'Tersedia';
    }

    // Helper untuk cek apakah stok habis
    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }

    // Accessor untuk visibility di dashboard publik
    // Products are visible if they have stock > 0, regardless of store status
    public function getIsVisibleAttribute(): bool
    {
        return $this->stock > 0;
    }

    // Scope untuk produk yang belum expired
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expiry_date')
              ->orWhere('expiry_date', '>=', now()->toDateString());
        });
    }

    // Scope untuk produk dengan stok > 0
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    // Relasi ke tabel Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi ke User (Seller)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk produk dari toko yang buka
    public function scopeFromOpenStore($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('is_open', 1);
        });
    }

    // Scope untuk produk yang visible di consumer/lembaga dashboard
    // Products with stock > 0 are visible regardless of store status
    // Products from closed stores will show "Tutup" status but remain visible
    public function scopeVisibleForPublic($query)
    {
        return $query->available()->notExpired();
    }
}
