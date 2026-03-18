<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreManualPaymentProofRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductCheckoutPaymentController extends Controller
{
    public function storeManualPaymentProof(StoreManualPaymentProofRequest $request, Product $product): RedirectResponse
    {
        $orderNumber = $request->input('order_number');
        $order = Order::query()
            ->where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->whereHas('items', fn ($query) => $query->where('product_id', $product->id))
            ->with('payments')
            ->firstOrFail();

        if ($order->payment_status === 'paid') {
            return redirect()
                ->route('checkout.payment', $product)
                ->with('success', 'Pembayaran sudah diverifikasi.');
        }

        if ($this->expireOrderIfNeeded($order)) {
            return redirect()
                ->route('checkout.payment', $product)
                ->withErrors(['payment_proof' => 'Batas waktu pembayaran sudah lewat. Pesanan dibatalkan.']);
        }

        $proofFile = $request->file('payment_proof');
        $proofPath = $proofFile->store('payments', 'public');

        $existingPayment = $order->payments
            ->where('provider', 'manual')
            ->where('status', 'pending')
            ->sortByDesc('id')
            ->first();

        if ($existingPayment) {
            if ($existingPayment->proof_path && Storage::disk('public')->exists($existingPayment->proof_path)) {
                Storage::disk('public')->delete($existingPayment->proof_path);
            }

            $existingPayment->update([
                'method' => $request->input('method'),
                'proof_path' => $proofPath,
            ]);
        } else {
            Payment::query()->create([
                'order_id' => $order->id,
                'provider' => 'manual',
                'method' => $request->input('method'),
                'status' => 'pending',
                'proof_path' => $proofPath,
            ]);
        }

        return redirect()
            ->route('checkout.payment', $product)
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }

    private function expireOrderIfNeeded(Order $order): bool
    {
        if ($order->payment_status !== 'unpaid' || $order->status === 'canceled') {
            return false;
        }

        if (! $order->payment_expires_at) {
            return false;
        }

        if (now('Asia/Jakarta')->lte($order->payment_expires_at)) {
            return false;
        }

        $order->update([
            'status' => 'canceled',
            'payment_status' => 'failed',
        ]);

        $order->payments()
            ->where('status', 'pending')
            ->update(['status' => 'failed']);

        return true;
    }
}
