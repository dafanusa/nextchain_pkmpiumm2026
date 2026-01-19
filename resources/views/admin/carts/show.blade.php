@extends('admin.layout')

@section('title', 'Cart Detail')

@section('content')
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Item Cart</h2>
            <a href="{{ route('admin.carts.index') }}"
               class="px-4 py-2 rounded-full border border-slate-200 text-sm font-semibold hover:border-[var(--brand)] transition">
                Kembali
            </a>
        </div>

        <div class="mt-4 space-y-3">
            @forelse ($cart->items as $item)
                <div class="flex items-center justify-between rounded-2xl border border-slate-100 px-4 py-3">
                    <div>
                        <p class="text-sm font-semibold">{{ $item->product?->name ?? 'Produk' }}</p>
                        <p class="text-xs text-[var(--muted)]">{{ $item->qty }} x Rp {{ number_format($item->price) }}</p>
                    </div>
                    <div class="text-sm font-semibold text-[var(--brand)]">Rp {{ number_format($item->qty * $item->price) }}</div>
                </div>
            @empty
                <div class="text-sm text-[var(--muted)]">Tidak ada item di cart ini.</div>
            @endforelse
        </div>
    </div>
@endsection
