<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'seller_id', 'reason', 'status', 'admin_reply'];

    // Relasi ke konsumen (Pelapor)
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke seller (Terlapor)
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // Relasi ke pesan chat keluhan
    public function messages()
    {
        return $this->hasMany(ComplaintMessage::class)->orderBy('created_at', 'asc');
    }

    // Scope status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}