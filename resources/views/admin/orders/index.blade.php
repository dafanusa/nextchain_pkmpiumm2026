@extends('admin.layout')

@section('title', 'Orders')

@section('content')
    <h2 class="text-lg font-semibold mb-6">Daftar Order</h2>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-[var(--muted)]">
                <tr>
                    <th class="text-left px-4 py-3">Order</th>
                    <th class="text-left px-4 py-3">User</th>
                    <th class="text-left px-4 py-3">Total</th>
                    <th class="text-left px-4 py-3">Status</th>
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
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="inline-flex px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold hover:border-[var(--brand)] transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada order.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
@endsection
