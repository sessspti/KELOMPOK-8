<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'user_id',
        'message',
        'sender_role',
        'is_read'
    ];

    /**
     * Relasi balik ke data Keluhan (Complaint)
     */
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    /**
     * Relasi ke User yang mengirim pesan ini
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}