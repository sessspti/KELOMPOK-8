<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'description', 'price', 'stock'];

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
