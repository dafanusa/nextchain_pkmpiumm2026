@extends('admin.layout')

@section('title', 'Negotiations')

@section('content')
    <h2 class="text-lg font-semibold mb-6">Daftar Tawaran</h2>

    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-[var(--muted)]">
                <tr>
                    <th class="text-left px-4 py-3">Produk</th>
                    <th class="text-left px-4 py-3">User</th>
                    <th class="text-left px-4 py-3">Harga</th>
                    <th class="text-left px-4 py-3">Qty</th>
                    <th class="text-left px-4 py-3">Channel</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-right px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($offers as $offer)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3 font-semibold text-[var(--ink)]">{{ $offer->product?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-[var(--muted)]">{{ $offer->user?->name ?? 'Guest' }}</td>
                        <td class="px-4 py-3 text-[var(--muted)]">Rp {{ number_format($offer->price) }}</td>
                        <td class="px-4 py-3 text-[var(--muted)]">{{ $offer->qty }}</td>
                        <td class="px-4 py-3 text-[var(--muted)]">{{ $offer->channel ?? 'chat' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2 py-1 rounded-full text-xs
                                @if ($offer->status === 'accepted') bg-emerald-100 text-emerald-700
                                @elseif ($offer->status === 'rejected') bg-red-100 text-red-600
                                @else bg-slate-100 text-[var(--ink)]
                                @endif">
                                {{ $offer->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right flex flex-wrap justify-end gap-2">
                            @if ($offer->status === 'pending')
                                <form action="{{ route('admin.offers.approve', $offer) }}" method="post" class="inline">
                                    @csrf
                                    @method('patch')
                                    <button type="submit"
                                            class="inline-flex px-3 py-1.5 rounded-full border border-emerald-200 text-xs font-semibold text-emerald-700 hover:border-emerald-300 transition">
                                        Accept
                                    </button>
                                </form>
                                <form action="{{ route('admin.offers.reject', $offer) }}" method="post" class="inline">
                                    @csrf
                                    @method('patch')
                                    <button type="submit"
                                            class="inline-flex px-3 py-1.5 rounded-full border border-red-200 text-xs font-semibold text-red-600 hover:border-red-300 transition">
                                        Reject
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.offers.edit', $offer) }}"
                               class="inline-flex px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold hover:border-[var(--brand)] transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.offers.destroy', $offer) }}" method="post" class="inline">
                                @csrf
                                @method('delete')
                                <button type="submit"
                                        onclick="return confirm('Hapus tawaran ini?')"
                                        class="inline-flex px-3 py-1.5 rounded-full border border-red-200 text-xs font-semibold text-red-600 hover:border-red-300 transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada tawaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $offers->links() }}
    </div>
@endsection
