@extends('admin.layout')

@section('title', 'Negotiations')

@section('content')
    <h2 class="text-lg font-semibold mb-6">Daftar Tawaran</h2>

    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <form method="get" action="{{ route('admin.offers.index') }}" class="mb-6 flex flex-wrap items-end gap-3">
        <div class="space-y-1">
            <label for="offer-date" class="text-xs font-semibold text-[var(--muted)]">Tanggal</label>
            <input id="offer-date" type="date" name="date" value="{{ request('date') }}"
                   class="rounded-full bg-amber-100 px-4 py-2 text-sm text-amber-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-300">
        </div>
        <button type="submit"
                class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition">
            Tampilkan
        </button>
        <a href="{{ route('admin.offers.index') }}"
           class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition">
            Semua
        </a>
    </form>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[720px] w-full text-sm">
                <thead class="bg-slate-50 text-[var(--muted)]">
                    <tr>
                        <th class="text-left px-4 py-3">Produk</th>
                        <th class="text-left px-4 py-3">User</th>
                        <th class="text-left px-4 py-3">Harga</th>
                        <th class="text-left px-4 py-3">Qty</th>
                        <th class="text-left px-4 py-3">Channel</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Waktu</th>
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
                            <td class="px-4 py-3 text-[var(--muted)]">
                                {{ $offer->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex flex-col items-end gap-2">
                                    @if ($offer->status === 'pending')
                                        <div class="flex flex-nowrap justify-end gap-2">
                                            <form action="{{ route('admin.offers.approve', $offer) }}" method="post" class="inline">
                                                @csrf
                                                @method('patch')
                                                <button type="submit"
                                                        class="inline-flex shrink-0 px-2.5 py-1 rounded-full border border-emerald-200 text-[11px] font-semibold text-emerald-700 hover:border-emerald-300 transition whitespace-nowrap">
                                                    Accept
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.offers.reject', $offer) }}" method="post" class="inline">
                                                @csrf
                                                @method('patch')
                                                <button type="submit"
                                                        class="inline-flex shrink-0 px-2.5 py-1 rounded-full border border-red-200 text-[11px] font-semibold text-red-600 hover:border-red-300 transition whitespace-nowrap">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                    <div class="flex flex-nowrap justify-end gap-2">
                                        <a href="{{ route('admin.offers.edit', $offer) }}"
                                           class="inline-flex shrink-0 px-2.5 py-1 rounded-full border border-slate-200 text-[11px] font-semibold hover:border-[var(--brand)] transition whitespace-nowrap">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.offers.destroy', $offer) }}" method="post" class="inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                    onclick="return confirm('Hapus tawaran ini?')"
                                                    class="inline-flex shrink-0 px-2.5 py-1 rounded-full border border-red-200 text-[11px] font-semibold text-red-600 hover:border-red-300 transition whitespace-nowrap">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada tawaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $offers->links() }}
    </div>
@endsection



