@extends('admin.layout')

@section('title', 'Products')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold">Daftar Produk</h2>
        <a href="{{ route('admin.products.create') }}"
           class="px-4 py-2 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
            Tambah Produk
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[760px] w-full text-sm">
                <thead class="bg-slate-50 text-[var(--muted)]">
                    <tr>
                        <th class="text-left px-4 py-3">Produk</th>
                        <th class="text-left px-4 py-3">Supplier</th>
                        <th class="text-left px-4 py-3">Harga</th>
                        <th class="text-left px-4 py-3">Stok</th>
                        <th class="text-right px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-16 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center text-[10px] text-slate-400">
                                        @if ($product->image)
                                            <img src="{{ str_starts_with($product->image, 'products/') ? asset('storage/' . $product->image) : asset('assets/' . $product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 class="h-full w-full object-cover">
                                        @else
                                            NO IMG
                                        @endif
                                    </div>
                                    <div class="font-semibold text-[var(--ink)]">{{ $product->name }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $product->supplier }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">Rp {{ number_format($product->price_min) }} - Rp {{ number_format($product->price_max) }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $product->stock }} {{ $product->unit }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="inline-flex px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold hover:border-[var(--brand)] transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="post" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                            onclick="return confirm('Hapus produk ini?')"
                                            class="inline-flex px-3 py-1.5 rounded-full border border-red-200 text-xs font-semibold text-red-600 hover:border-red-300 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada produk.</td>
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

