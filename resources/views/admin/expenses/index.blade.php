@extends('admin.layout')

@section('title', 'Laporan Pengeluaran')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold">Laporan Pengeluaran</h2>
            <p class="text-sm text-[var(--muted)]">Input pengeluaran, lihat total harian/mingguan/bulanan, lalu unduh CSV atau PDF.</p>
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
            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Total Pengeluaran</p>
            <p class="mt-2 text-2xl font-semibold text-[var(--ink)]">Rp {{ number_format($summaryTotal) }}</p>
            <p class="mt-1 text-xs text-[var(--muted)]">Berdasarkan filter saat ini</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Jumlah Transaksi</p>
            <p class="mt-2 text-2xl font-semibold text-[var(--ink)]">{{ $summaryCount }}</p>
            <p class="mt-1 text-xs text-[var(--muted)]">Total item pengeluaran</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Rata-rata</p>
            <p class="mt-2 text-2xl font-semibold text-[var(--ink)]">
                Rp {{ number_format($summaryCount > 0 ? (int) round($summaryTotal / $summaryCount) : 0) }}
            </p>
            <p class="mt-1 text-xs text-[var(--muted)]">Rata-rata per transaksi</p>
        </div>
    </div>

    <form method="get" action="{{ route('admin.expenses.index') }}" class="mt-8 flex flex-wrap items-end gap-3">
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
        <div class="space-y-1">
            <label for="group-by" class="text-xs font-semibold text-[var(--muted)]">Kelompokkan</label>
            <select id="group-by" name="group_by"
                    class="rounded-full bg-amber-100 px-4 py-2 text-sm text-amber-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-300">
                <option value="daily" @selected($groupBy === 'daily')>Harian</option>
                <option value="weekly" @selected($groupBy === 'weekly')>Mingguan</option>
                <option value="monthly" @selected($groupBy === 'monthly')>Bulanan</option>
            </select>
        </div>
        <button type="submit"
                class="inline-flex items-center justify-center rounded-full bg-[var(--brand)] px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[var(--brand-dark)] transition">
            Tampilkan
        </button>
        <a href="{{ route('admin.expenses.index') }}"
           class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition">
            Semua
        </a>
        <div class="ml-auto flex flex-wrap gap-2">
            <a href="{{ route('admin.expenses.download', request()->query()) }}"
               class="inline-flex items-center justify-center rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-xs font-semibold text-blue-700 hover:border-blue-300 hover:bg-blue-100 transition">
                Cetak PDF
            </a>
            <a href="{{ route('admin.expenses.csv', request()->query()) }}"
               class="inline-flex items-center justify-center rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-semibold text-emerald-700 hover:border-emerald-300 hover:bg-emerald-100 transition">
                Download CSV
            </a>
        </div>
    </form>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold">Tambah Pengeluaran</h3>
            <form method="post" action="{{ route('admin.expenses.store') }}" class="mt-4 grid gap-4">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="expense-date" class="text-xs font-semibold text-[var(--muted)]">Tanggal</label>
                        <input id="expense-date" type="date" name="expense_date" value="{{ old('expense_date', now()->format('Y-m-d')) }}"
                               class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:border-[var(--brand)] focus:outline-none">
                    </div>
                    <div>
                        <label for="expense-category" class="text-xs font-semibold text-[var(--muted)]">Kategori</label>
                        <input id="expense-category" type="text" name="category" value="{{ old('category') }}"
                               class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:border-[var(--brand)] focus:outline-none"
                               placeholder="Contoh: Pakan, Listrik, Transport">
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="expense-amount" class="text-xs font-semibold text-[var(--muted)]">Jumlah (Rp)</label>
                        <input id="expense-amount" type="number" name="amount" min="1" value="{{ old('amount') }}"
                               class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:border-[var(--brand)] focus:outline-none"
                               placeholder="Contoh: 50000">
                    </div>
                    <div>
                        <label for="expense-description" class="text-xs font-semibold text-[var(--muted)]">Catatan (opsional)</label>
                        <input id="expense-description" type="text" name="description" value="{{ old('description') }}"
                               class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:border-[var(--brand)] focus:outline-none"
                               placeholder="Contoh: Ongkir supplier">
                    </div>
                </div>
                <div class="flex items-center justify-end">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition">
                        Simpan Pengeluaran
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold">Ringkasan {{ ucfirst($groupBy) }}</h3>
            <p class="mt-1 text-xs text-[var(--muted)]">Total pengeluaran per periode.</p>
            <div class="mt-4 space-y-3 text-sm text-[var(--muted)]">
                @forelse ($grouped as $row)
                    <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <span class="font-semibold text-[var(--ink)]">{{ $row['label'] }}</span>
                        <span>Rp {{ number_format($row['total']) }}</span>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-200 px-4 py-6 text-center text-sm text-[var(--muted)]">
                        Belum ada pengeluaran pada periode ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[760px] w-full text-sm">
                <thead class="bg-slate-50 text-[var(--muted)]">
                    <tr>
                        <th class="text-left px-4 py-3">Tanggal</th>
                        <th class="text-left px-4 py-3">Kategori</th>
                        <th class="text-left px-4 py-3">Jumlah</th>
                        <th class="text-left px-4 py-3">Catatan</th>
                        <th class="text-left px-4 py-3">Admin</th>
                        <th class="text-right px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($expenses as $expense)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $expense->expense_date?->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $expense->category }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">Rp {{ number_format($expense->amount) }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $expense->description ?? '-' }}</td>
                            <td class="px-4 py-3 text-[var(--muted)]">{{ $expense->creator?->name ?? 'Admin' }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="post" action="{{ route('admin.expenses.destroy', $expense) }}" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                            onclick="return confirm('Hapus pengeluaran ini?')"
                                            class="inline-flex whitespace-nowrap px-3 py-1.5 rounded-full border border-red-200 bg-red-50 text-xs font-semibold text-red-700 hover:border-red-300 hover:bg-red-100 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-[var(--muted)]">Belum ada pengeluaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
