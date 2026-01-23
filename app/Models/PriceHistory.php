<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceHistory extends Model
{
    protected $fillable = [
        'product_id',
        'price_date',
        'price_min',
        'price_max',
        'source',
    ];

    protected function casts(): array
    {
        return [
            'price_date' => 'date',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
