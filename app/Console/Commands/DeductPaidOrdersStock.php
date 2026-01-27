<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class DeductPaidOrdersStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:deduct-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kurangi stok untuk order yang sudah paid tetapi belum diproses stoknya.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $processed = 0;

        Order::query()
            ->where('payment_status', 'paid')
            ->whereNull('stock_deducted_at')
            ->orderBy('id')
            ->chunkById(100, function ($orders) use (&$processed) {
                foreach ($orders as $order) {
                    $order->deductStockIfNeeded();
                    $processed++;
                }
            });

        $this->info("Selesai. Order diproses: {$processed}");

        return self::SUCCESS;
    }
}
