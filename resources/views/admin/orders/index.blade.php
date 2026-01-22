@extends('admin.layout')

@section('title', 'Orders')

@section('content')
    <h2 class="text-lg font-semibold mb-6">Daftar Order</h2>

    <form method="get" action="{{ route('admin.orders.index') }}" class="mb-6 flex flex-wrap items-end gap-3">
        <div class="space-y-1">
            <label for="order-date" class="text-xs font-semibold text-[var(--muted)]">Tanggal</label>
            <input id="order-date" type="date" name="date" value="{{ request('date') }}"
                   class="rounded-full bg-amber-100 px-4 py-2 text-sm text-amber-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-300">
        </div>
        <button type="submit"
                class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition">
            Tampilkan
        </button>
        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition">
            Semua
        </a>
    </form>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[640px] w-full text-sm">
                <thead class="bg-slate-50 text-[var(--muted)]">
                    <tr>
                        <th class="text-left px-4 py-3">Order</th>
                        <th class="text-left px-4 py-3">User</th>
                        <th class="text-left px-4 py-3">Total</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Waktu</th>
                        <th class="text-right px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 font-semibold text-[var(--ink)]">{{ $order->order_number }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $order->user?->name ?? 'Guest' }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">Rp {{ number_format($order->total) }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-1 rounded-full text-xs bg-slate-100 text-[var(--ink)]">{{ $order->status }}</span>
                            </td>
                            <td class="px-4 py-3 text-[var(--muted)]">
                                {{ $order->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex flex-nowrap items-center gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="inline-flex whitespace-nowrap px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold hover:border-[var(--brand)] transition">
                                    Detail
                                </a>
                                <a href="{{ route('invoice.download', $order) }}"
                                   class="inline-flex whitespace-nowrap px-3 py-1.5 rounded-full border border-blue-200 bg-blue-50 text-xs font-semibold text-blue-700 hover:border-blue-300 hover:bg-blue-100 transition">
                                    Cetak Nota
                                </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada order.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
@endsection



