<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Console\Command;

class CancelExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batalkan order unpaid yang melewati batas waktu pembayaran.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = now('Asia/Jakarta');
        $expiredOrders = Order::query()
            ->where('payment_status', 'unpaid')
            ->where('status', 'pending')
            ->whereNotNull('payment_expires_at')
            ->where('payment_expires_at', '<=', $now)
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('Tidak ada order expired.');

            return self::SUCCESS;
        }

        foreach ($expiredOrders as $order) {
            $order->update([
                'status' => 'canceled',
                'payment_status' => 'failed',
            ]);

            Payment::query()
                ->where('order_id', $order->id)
                ->where('status', 'pending')
                ->update(['status' => 'failed']);
        }

        $this->info("Order dibatalkan: {$expiredOrders->count()}");

        return self::SUCCESS;
    }
}
