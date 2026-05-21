<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['id_user', 'menu_id', 'quantity', 'unit_price', 'status', 'transaction_id', 'payment_method'];

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
