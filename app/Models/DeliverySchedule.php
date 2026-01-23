<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliverySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination',
        'delivery_date',
        'delivery_time',
        'schedule_type',
        'is_active',
    ];

    protected $casts = [
        'delivery_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
