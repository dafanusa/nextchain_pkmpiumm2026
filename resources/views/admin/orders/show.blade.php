@extends('admin.layout')

@section('title', 'Order Detail')

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-6">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Item Order</h2>
            <div class="mt-4 space-y-3">
                @foreach ($order->items as $item)
                    <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-4 py-3">
                        <div>
                            <p class="text-sm font-semibold">{{ $item->product?->name ?? 'Produk' }}</p>
                            <p class="text-xs text-[var(--muted)]">{{ $item->qty }} {{ $item->unit }} x Rp {{ number_format($item->price) }}</p>
                        </div>
                        <div class="text-sm font-semibold text-[var(--brand)]">Rp {{ number_format($item->line_total) }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Status Order</h2>
            <form method="post" action="{{ route('admin.orders.update', $order) }}" class="mt-4 space-y-4">
                @csrf
                @method('put')
                <div>
                    <label class="text-sm font-semibold">Status Order</label>
                    <select name="status" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                        <option value="pending" @selected($order->status === 'pending')>Pending</option>
                        <option value="processing" @selected($order->status === 'processing')>Processing</option>
                        <option value="completed" @selected($order->status === 'completed')>Completed</option>
                        <option value="canceled" @selected($order->status === 'canceled')>Canceled</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold">Status Pembayaran</label>
                    <select name="payment_status" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                        <option value="unpaid" @selected($order->payment_status === 'unpaid')>Unpaid</option>
                        <option value="paid" @selected($order->payment_status === 'paid')>Paid</option>
                        <option value="failed" @selected($order->payment_status === 'failed')>Failed</option>
                        <option value="refunded" @selected($order->payment_status === 'refunded')>Refunded</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                            class="px-5 py-2.5 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                        Update
                    </button>
                    <a href="{{ route('admin.orders.index') }}"
                       class="px-5 py-2.5 rounded-full border border-slate-200 text-sm font-semibold hover:border-[var(--brand)] transition">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
