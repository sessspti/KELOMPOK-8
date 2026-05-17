<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['user_id', 'name', 'price', 'discount', 'stock', 'image', 'expiry_date'];
    protected $appends = ['final_price', 'image_url', 'formatted_expiry_date', 'store'];

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

    // Helper untuk cek apakah stok habis
    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }

    // Scope untuk produk yang belum expired
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expiry_date')
              ->orWhere('expiry_date', '>=', now()->toDateString());
        });
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
}
