<?php

namespace App\Jobs;

use App\Mail\InvoiceMail;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendInvoiceJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private int $orderId) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::query()
            ->with(['items.product', 'deliverySchedule', 'payments', 'user'])
            ->find($this->orderId);

        if (! $order || ! $order->user?->email) {
            return;
        }

        $order->ensureInvoiceData();

        $pdf = Pdf::loadView('invoices.order', [
            'order' => $order,
            'publicUrl' => route('invoice.short', $order->invoice_short_code),
            'businessName' => 'UD. AdeSaputra Farm',
        ])->setPaper('a5', 'portrait');

        Mail::to($order->user->email)->send(new InvoiceMail($order, $pdf->output()));
    }
}
