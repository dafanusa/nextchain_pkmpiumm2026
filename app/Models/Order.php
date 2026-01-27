<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'payment_status',
        'subtotal',
        'shipping_fee',
        'total',
        'invoice_uid',
        'invoice_public_token',
        'invoice_short_code',
        'buyer_name',
        'buyer_phone',
        'buyer_address',
        'shipping_method',
        'delivery_schedule_id',
        'shipping_date',
        'shipping_time',
        'shipping_status',
        'note',
        'stock_deducted_at',
    ];

    protected $casts = [
        'shipping_date' => 'date',
        'stock_deducted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deliverySchedule(): BelongsTo
    {
        return $this->belongsTo(DeliverySchedule::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function deductStockIfNeeded(): void
    {
        if ($this->stock_deducted_at) {
            return;
        }

        $this->loadMissing('items');
        $qtyByProduct = $this->items
            ->groupBy('product_id')
            ->map(fn ($items) => (int) $items->sum('qty'));

        DB::transaction(function () use ($qtyByProduct) {
            foreach ($qtyByProduct as $productId => $qty) {
                if ($qty <= 0) {
                    continue;
                }

                $product = Product::query()->whereKey($productId)->lockForUpdate()->first();
                if (! $product) {
                    continue;
                }

                $nextStock = max(0, (int) $product->stock - $qty);
                if ($nextStock !== (int) $product->stock) {
                    $product->update(['stock' => $nextStock]);
                }
            }
        });

        $this->forceFill(['stock_deducted_at' => now()])->save();
    }

    public function ensureInvoiceData(): void
    {
        $updated = false;

        if (! $this->invoice_uid) {
            $this->invoice_uid = $this->generateInvoiceUid();
            $updated = true;
        }

        if (! $this->invoice_public_token) {
            $this->invoice_public_token = Str::random(40);
            $updated = true;
        }

        if (! $this->invoice_short_code) {
            $this->invoice_short_code = $this->generateInvoiceShortCode();
            $updated = true;
        }

        if ($updated) {
            $this->save();
        }
    }

    private function generateInvoiceUid(): string
    {
        $prefix = 'INV-'.now()->format('Ymd').'-';

        do {
            $uid = $prefix.Str::upper(Str::random(6));
        } while (self::query()->where('invoice_uid', $uid)->exists());

        return $uid;
    }

    private function generateInvoiceShortCode(): string
    {
        do {
            $code = Str::upper(Str::random(8));
        } while (self::query()->where('invoice_short_code', $code)->exists());

        return $code;
    }
}
