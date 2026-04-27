<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'price', 'stock', 'image'];

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
}
