<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NegotiationMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'negotiation_offer_id',
        'user_id',
        'sender_role',
        'message',
    ];

    public function offer(): BelongsTo
    {
        return $this->belongsTo(NegotiationOffer::class, 'negotiation_offer_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
