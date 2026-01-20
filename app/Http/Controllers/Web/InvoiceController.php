<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\SendInvoiceJob;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function download(Order $order): Response
    {
        $this->authorizeOrder($order);
        $order->ensureInvoiceData();

        return $this->buildPdf($order)->download($this->getFilename($order));
    }

    public function public(string $token): Response
    {
        $order = Order::query()
            ->where('invoice_public_token', $token)
            ->with(['items.product', 'deliverySchedule', 'payments'])
            ->firstOrFail();

        $order->ensureInvoiceData();

        return $this->buildPdf($order)->stream($this->getFilename($order));
    }

    public function publicShort(string $code): Response
    {
        $order = Order::query()
            ->where('invoice_short_code', $code)
            ->with(['items.product', 'deliverySchedule', 'payments'])
            ->firstOrFail();

        $order->ensureInvoiceData();

        return $this->buildPdf($order)->stream($this->getFilename($order));
    }

    public function sendEmail(Order $order): RedirectResponse
    {
        $this->authorizeOrder($order);
        $order->ensureInvoiceData();

        SendInvoiceJob::dispatch($order->id);

        return back()->with('success', 'Nota berhasil dikirim ke email.');
    }

    public function whatsapp(Order $order): RedirectResponse
    {
        $this->authorizeOrder($order);
        $order->ensureInvoiceData();

        return redirect()->away($this->getWhatsappUrl($order));
    }

    public function preview(Order $order): View
    {
        $this->authorizeOrder($order);
        $order->ensureInvoiceData();
        $order->loadMissing(['items.product', 'deliverySchedule', 'payments', 'user']);

        return view('invoices.order', [
            'order' => $order,
            'publicUrl' => route('invoice.short', $order->invoice_short_code),
            'businessName' => 'UD. AdeSaputra Farm',
        ]);
    }

    private function buildPdf(Order $order)
    {
        $order->loadMissing(['items.product', 'deliverySchedule', 'payments', 'user']);

        return Pdf::loadView('invoices.order', [
            'order' => $order,
            'publicUrl' => route('invoice.short', $order->invoice_short_code),
            'businessName' => 'UD. AdeSaputra Farm',
        ])->setPaper('a5', 'portrait');
    }

    private function authorizeOrder(Order $order): void
    {
        $user = auth()->user();
        if (! $user) {
            abort(403);
        }

        if ($user->role === User::ROLE_ADMIN) {
            return;
        }

        if ($order->user_id !== $user->id) {
            abort(403);
        }
    }

    private function getFilename(Order $order): string
    {
        $uid = $order->invoice_uid ?: $order->order_number;

        return Str::slug($uid).'.pdf';
    }

    private function getWhatsappUrl(Order $order): string
    {
        $publicUrl = route('invoice.short', $order->invoice_short_code);
        $message = "Ini nota pembelian {$order->invoice_uid} dari UD. AdeSaputra Farm.\n\nDownload:\n{$publicUrl}";

        return 'https://wa.me/?text='.rawurlencode($message);
    }
}
