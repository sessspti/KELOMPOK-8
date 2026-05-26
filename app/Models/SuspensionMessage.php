<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuspensionMessage extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'sender'
    ];

    /**
     * Get the user that owns the message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
