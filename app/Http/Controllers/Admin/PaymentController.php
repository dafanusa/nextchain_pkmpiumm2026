<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order')->orderByDesc('id')->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function edit(Payment $payment)
    {
        return view('admin.payments.form', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,failed,refunded'],
            'method' => ['nullable', 'string', 'max:40'],
        ]);

        $payment->update($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran diperbarui.');
    }
}
