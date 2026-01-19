<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NegotiationOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'price',
        'qty',
        'channel',
        'status',
        'accepted_at',
        'note',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(NegotiationMessage::class);
    }
}
