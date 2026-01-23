@extends('admin.layout')

@section('title', 'Update Harga')

@section('content')
    <div class="mb-6">
        <h2 class="text-lg font-semibold">Update Harga Produk</h2>
        <p class="text-sm text-[var(--muted)] mt-1">Pilih produk, lalu ubah harga minimal dan maksimal.</p>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[560px] w-full text-sm">
                <thead class="bg-slate-50 text-[var(--muted)]">
                    <tr>
                        <th class="text-left px-4 py-3">Produk</th>
                        <th class="text-left px-4 py-3">Harga Saat Ini</th>
                        <th class="text-left px-4 py-3">Update Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center text-[10px] text-slate-400">
                                        @if ($product->image)
                                            <img src="{{ str_starts_with($product->image, 'products/') ? asset('storage/' . $product->image) : asset('assets/' . $product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 class="h-full w-full object-cover">
                                        @else
                                            NO IMG
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-[var(--ink)]">{{ $product->name }}</div>
                                        <div class="text-xs text-[var(--muted)]">{{ $product->unit }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[var(--muted)]">Rp {{ number_format($product->price_min) }} - Rp {{ number_format($product->price_max) }}</td>
                            <td class="px-4 py-3">
                                <form method="post" action="{{ route('admin.products.price.update', $product) }}" class="flex flex-wrap items-center gap-2">
                                    @csrf
                                    @method('patch')
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="price_min" min="0" value="{{ old('price_min', $product->price_min) }}"
                                               class="w-28 rounded-full border border-slate-200 px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-200">
                                        <span class="text-xs text-[var(--muted)]">-</span>
                                        <input type="number" name="price_max" min="0" value="{{ old('price_max', $product->price_max) }}"
                                               class="w-28 rounded-full border border-slate-200 px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-200">
                                    </div>
                                    <button type="submit"
                                            class="inline-flex px-3 py-1.5 rounded-full bg-[var(--brand)] text-white text-xs font-semibold hover:bg-[var(--brand-dark)] transition">
                                        Simpan
                                    </button>
                                </form>
                                @error('price_min')
                                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                                @enderror
                                @error('price_max')
                                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endsection

