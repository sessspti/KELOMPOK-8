<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['user_id', 'name', 'price', 'discount', 'stock', 'image'];

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
