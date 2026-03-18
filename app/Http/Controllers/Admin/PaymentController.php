<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DateFilterRequest;
use App\Jobs\SendInvoiceJob;
use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(DateFilterRequest $request): View
    {
        $date = $request->validated()['date'] ?? null;

        $paymentsQuery = Payment::query()->with('order')->orderByDesc('id');

        if ($date) {
            $paymentsQuery->where(function ($query) use ($date) {
                $query->whereDate('paid_at', $date)
                    ->orWhere(function ($nested) use ($date) {
                        $nested->whereNull('paid_at')
                            ->whereDate('created_at', $date);
                    });
            });
        }

        $payments = $paymentsQuery->paginate(20)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function edit(Payment $payment): View
    {
        return view('admin.payments.form', compact('payment'));
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,failed,refunded'],
            'method' => ['nullable', 'string', 'max:40'],
        ]);

        $payment->update($validated);

        if ($payment->status === 'paid' && ! $payment->paid_at) {
            $payment->update(['paid_at' => now()]);
        }

        $order = $payment->order;
        if ($order) {
            $statusMap = [
                'pending' => 'unpaid',
                'paid' => 'paid',
                'failed' => 'failed',
                'refunded' => 'refunded',
            ];

            $order->update([
                'payment_status' => $statusMap[$payment->status],
            ]);

            if ($payment->status === 'paid') {
                $order->deductStockIfNeeded();
                $order->ensureInvoiceData();
                SendInvoiceJob::dispatch($order->id);
            }
        }

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran diperbarui.');
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran dihapus.');
    }
}
