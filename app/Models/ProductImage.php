<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image',
        'sort_order',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageUrlAttribute(): string
    {
        $image = $this->image;
        if (! $image) {
            return asset('assets/ternakayam.jpg');
        }

        return str_starts_with($image, 'products/')
            ? asset('storage/'.$image)
            : asset('assets/'.$image);
    }
}
