@extends('admin.layout')

@section('title', 'Payments')

@section('content')
    <h2 class="text-lg font-semibold mb-6">Daftar Pembayaran</h2>

    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <form method="get" action="{{ route('admin.payments.index') }}" class="mb-6 flex flex-wrap items-end gap-3">
        <div class="space-y-1">
            <label for="payment-date" class="text-xs font-semibold text-[var(--muted)]">Tanggal</label>
            <input id="payment-date" type="date" name="date" value="{{ request('date') }}"
                   class="rounded-full bg-amber-100 px-4 py-2 text-sm text-amber-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-300">
        </div>
        <button type="submit"
                class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition">
            Tampilkan
        </button>
        <a href="{{ route('admin.payments.index') }}"
           class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition">
            Semua
        </a>
    </form>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[560px] w-full text-sm">
                <thead class="bg-slate-50 text-[var(--muted)]">
                    <tr>
                        <th class="text-left px-4 py-3">Order</th>
                        <th class="text-left px-4 py-3">Metode</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Waktu</th>
                        <th class="text-right px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 font-semibold text-[var(--ink)]">{{ $payment->order?->order_number ?? '-' }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $payment->method ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 rounded-full text-xs bg-slate-100 text-[var(--ink)]">{{ $payment->status }}</span>
                            </td>
                            <td class="px-4 py-3 text-[var(--muted)]">
                                {{ $payment->paid_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? $payment->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.payments.edit', $payment) }}"
                                   class="inline-flex px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold hover:border-[var(--brand)] transition">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $payments->links() }}
    </div>
@endsection



