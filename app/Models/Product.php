<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'supplier',
        'grade',
        'unit',
        'price_min',
        'price_max',
        'moq',
        'stock',
        'stock_updated_at',
        'image',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'stock_updated_at' => 'datetime',
    ];

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

    public function negotiationOffers(): HasMany
    {
        return $this->hasMany(NegotiationOffer::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function priceHistories(): HasMany
    {
        return $this->hasMany(PriceHistory::class);
    }
}
