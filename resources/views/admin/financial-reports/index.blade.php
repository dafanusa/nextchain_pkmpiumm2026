@extends('admin.layout')

@section('title', 'Laporan Pemasukan')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold">Laporan Pemasukan</h2>
            <p class="text-sm text-[var(--muted)]">Pilih order, simpan laporan, lalu unduh CSV atau PDF.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Total Order</p>
            <p class="mt-2 text-2xl font-semibold text-[var(--ink)]">{{ $summaryOrders }}</p>
            <p class="mt-1 text-xs text-[var(--muted)]">Berdasarkan filter saat ini</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Total Pendapatan</p>
            <p class="mt-2 text-2xl font-semibold text-[var(--ink)]">Rp {{ number_format($summaryTotal) }}</p>
            <p class="mt-1 text-xs text-[var(--muted)]">Akumulasi semua order terpilih</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Sudah Dibayar</p>
            <p class="mt-2 text-2xl font-semibold text-[var(--ink)]">Rp {{ number_format($summaryPaid) }}</p>
            <p class="mt-1 text-xs text-[var(--muted)]">Hanya status paid</p>
        </div>
    </div>

    <form method="get" action="{{ route('admin.financial-reports.index') }}" class="mt-8 flex flex-wrap items-end gap-3">
        <div class="space-y-1">
            <label for="date-from" class="text-xs font-semibold text-[var(--muted)]">Tanggal Awal</label>
            <input id="date-from" type="date" name="date_from" value="{{ $dateFrom }}"
                   class="rounded-full bg-amber-100 px-4 py-2 text-sm text-amber-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-300">
        </div>
        <div class="space-y-1">
            <label for="date-to" class="text-xs font-semibold text-[var(--muted)]">Tanggal Akhir</label>
            <input id="date-to" type="date" name="date_to" value="{{ $dateTo }}"
                   class="rounded-full bg-amber-100 px-4 py-2 text-sm text-amber-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-300">
        </div>
        <button type="submit"
                class="inline-flex items-center justify-center rounded-full bg-[var(--brand)] px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[var(--brand-dark)] transition">
            Tampilkan
        </button>
        <a href="{{ route('admin.financial-reports.index') }}"
           class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition">
            Semua
        </a>
    </form>

    <form method="post" action="{{ route('admin.financial-reports.store') }}" class="mt-6 space-y-4">
        @csrf
        <input type="hidden" name="date_from" value="{{ $dateFrom }}">
        <input type="hidden" name="date_to" value="{{ $dateTo }}">

        <div class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[220px]">
                <label for="report-name" class="text-xs font-semibold text-[var(--muted)]">Nama Laporan (opsional)</label>
                <input id="report-name" type="text" name="report_name" value="{{ old('report_name') }}"
                       class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:border-[var(--brand)] focus:outline-none"
                       placeholder="Contoh: Laporan Januari 2026">
            </div>
            <div class="flex items-center gap-2 pt-6">
                <input id="select-all-orders" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-[var(--brand)]">
                <label for="select-all-orders" class="text-sm text-[var(--muted)]">Pilih semua order</label>
            </div>
            <button type="submit"
                    class="ml-auto inline-flex items-center justify-center rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition">
                Simpan Laporan
            </button>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[760px] w-full text-sm">
                    <thead class="bg-slate-50 text-[var(--muted)]">
                        <tr>
                            <th class="text-left px-4 py-3">Pilih</th>
                            <th class="text-left px-4 py-3">Order</th>
                            <th class="text-left px-4 py-3">User</th>
                            <th class="text-left px-4 py-3">Total</th>
                            <th class="text-left px-4 py-3">Status</th>
                            <th class="text-left px-4 py-3">Pembayaran</th>
                            <th class="text-left px-4 py-3">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            @php
                                $payment = $order->payments->sortByDesc('paid_at')->first()
                                    ?? $order->payments->sortByDesc('created_at')->first();
                            @endphp
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3">
                                    <input type="checkbox" name="order_ids[]" value="{{ $order->id }}"
                                           class="order-checkbox h-4 w-4 rounded border-slate-300 text-[var(--brand)]">
                                </td>
                                <td class="px-4 py-3 font-semibold text-[var(--ink)]">{{ $order->order_number }}</td>
                                <td class="px-4 py-3 text-[var(--muted)]">{{ $order->user?->name ?? $order->buyer_name ?? 'Guest' }}</td>
                                <td class="px-4 py-3 text-[var(--muted)]">Rp {{ number_format($order->total) }}</td>
                                <td class="px-4 py-3 text-[var(--muted)]">{{ $order->status }}</td>
                                <td class="px-4 py-3 text-[var(--muted)]">
                                    {{ $order->payment_status }}{{ $payment?->method ? ' · '.$payment->method : '' }}
                                </td>
                                <td class="px-4 py-3 text-[var(--muted)]">
                                    {{ $order->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada order.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <p class="text-xs text-[var(--muted)]">Catatan: yang tersimpan hanya order yang dipilih.</p>
    </form>

    <div class="mt-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-base font-semibold">Riwayat Laporan</h3>
                <p class="text-xs text-[var(--muted)]">Periode = rentang tanggal yang dipakai saat filter (tanggal awal - akhir).</p>
            </div>
        </div>
        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[720px] w-full text-sm">
                    <thead class="bg-slate-50 text-[var(--muted)]">
                        <tr>
                            <th class="text-left px-4 py-3">Laporan</th>
                            <th class="text-left px-4 py-3">Periode</th>
                            <th class="text-left px-4 py-3">Total Order</th>
                            <th class="text-left px-4 py-3">Total Pendapatan</th>
                            <th class="text-left px-4 py-3">Dibuat</th>
                            <th class="text-right px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 font-semibold text-[var(--ink)]">
                                    {{ $report->report_name ?? 'Laporan Pemasukan' }}
                                </td>
                                <td class="px-4 py-3 text-[var(--muted)]">
                                    @if ($report->date_from && $report->date_to)
                                        {{ $report->date_from->format('d M Y') }} - {{ $report->date_to->format('d M Y') }}
                                    @else
                                        Semua tanggal
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-[var(--muted)]">{{ $report->total_orders }}</td>
                                <td class="px-4 py-3 text-[var(--muted)]">Rp {{ number_format($report->total_amount) }}</td>
                                <td class="px-4 py-3 text-[var(--muted)]">
                                    {{ $report->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
                                    <div class="text-xs text-slate-400">
                                        {{ $report->creator?->name ?? 'Admin' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('admin.financial-reports.download', $report) }}"
                                       class="inline-flex whitespace-nowrap px-3 py-1.5 rounded-full border border-blue-200 bg-blue-50 text-xs font-semibold text-blue-700 hover:border-blue-300 hover:bg-blue-100 transition">
                                        Cetak PDF
                                    </a>
                                    <a href="{{ route('admin.financial-reports.csv', $report) }}"
                                       class="inline-flex whitespace-nowrap px-3 py-1.5 rounded-full border border-emerald-200 bg-emerald-50 text-xs font-semibold text-emerald-700 hover:border-emerald-300 hover:bg-emerald-100 transition">
                                        Download CSV
                                    </a>
                                    <form method="post" action="{{ route('admin.financial-reports.destroy', $report) }}" class="inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                                onclick="return confirm('Hapus laporan ini?')"
                                                class="inline-flex whitespace-nowrap px-3 py-1.5 rounded-full border border-red-200 bg-red-50 text-xs font-semibold text-red-700 hover:border-red-300 hover:bg-red-100 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada laporan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    </div>

    <script>
        const selectAllOrders = document.getElementById('select-all-orders');
        const orderCheckboxes = Array.from(document.querySelectorAll('.order-checkbox'));

        if (selectAllOrders) {
            selectAllOrders.addEventListener('change', () => {
                orderCheckboxes.forEach((checkbox) => {
                    checkbox.checked = selectAllOrders.checked;
                });
            });
        }
    </script>
@endsection

