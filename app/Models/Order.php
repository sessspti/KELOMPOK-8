<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // TAMBAHAN AC 4: tambah 'pickup_method' agar data self-pickup tersimpan  
    // TAMBAHAN AC 5: tambah 'picked_up_at' untuk log pengambilan self-pickup
    // TAMBAHAN AC 2: tambah 'pickup_schedule' untuk menyimpan jadwal pengambilan self-pickup
    protected $fillable = ['id_user', 'menu_id', 'quantity', 'unit_price', 'status', 'transaction_id', 'payment_method', 'pickup_method', 'pickup_schedule', 'picked_up_at'];

    // TAMBAHAN AC 5: cast picked_up_at sebagai datetime agar bisa memanggil ->format()
    protected $casts = [
        'picked_up_at' => 'datetime',
    ];

    public function getLineTotalAttribute(): int
    {
        $unitPrice = $this->unit_price ?? ($this->menu ? (int) round($this->menu->final_price) : 0);

        if ($this->user && $this->user->role === 'lembaga_sosial') {
            return 0;
        }

        return $unitPrice * $this->quantity;
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
