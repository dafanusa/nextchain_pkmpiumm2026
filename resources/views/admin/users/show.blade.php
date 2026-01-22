@extends('admin.layout')

@section('title', 'User Detail')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold">Detail User</h2>
            <p class="text-sm text-[var(--muted)] mt-1">Ringkasan aktivitas akun.</p>
        </div>
        <a href="{{ route('admin.users.index') }}"
           class="px-4 py-2 rounded-full border border-slate-200 text-sm font-semibold hover:border-[var(--brand)] transition">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm text-[var(--muted)]">Nama</p>
                <p class="text-lg font-semibold text-[var(--ink)]">{{ $user->name }}</p>
                <p class="text-sm text-[var(--muted)] mt-1">{{ $user->email }}</p>
            </div>
            <div class="flex flex-wrap gap-3 text-xs">
                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-[var(--ink)] font-semibold">
                    Role: {{ $user->role }}
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-blue-700 font-semibold">
                    Poin: {{ $user->loyalty_points ?? 0 }}
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-[var(--muted)] font-semibold">
                    Terdaftar: {{ $user->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    <div class="mt-6 grid md:grid-cols-2 xl:grid-cols-4 gap-4 text-sm">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Total order</p>
            <p class="mt-2 text-xl font-semibold text-[var(--ink)]">{{ $ordersCount }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Total transaksi</p>
            <p class="mt-2 text-xl font-semibold text-[var(--ink)]">Rp {{ number_format($totalSpend) }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Total negosiasi</p>
            <p class="mt-2 text-xl font-semibold text-[var(--ink)]">{{ $offerSummary['total'] }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Negosiasi diterima</p>
            <p class="mt-2 text-xl font-semibold text-emerald-600">{{ $offerSummary['accepted'] }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Negosiasi pending</p>
            <p class="mt-2 text-xl font-semibold text-amber-600">{{ $offerSummary['pending'] }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Negosiasi ditolak</p>
            <p class="mt-2 text-xl font-semibold text-rose-600">{{ $offerSummary['rejected'] }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Total testimoni</p>
            <p class="mt-2 text-xl font-semibold text-[var(--ink)]">{{ $testimonialsCount }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Produk dibeli</p>
            <p class="mt-2 text-xl font-semibold text-[var(--ink)]">{{ $totalProductsBought }}</p>
        </div>
    </div>

    <div class="mt-6 grid md:grid-cols-2 gap-4 text-sm">
        <div class="rounded-2xl border border-slate-200 bg-white p-4">
            <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Order terakhir</p>
            <p class="mt-2 font-semibold text-[var(--ink)]">{{ $latestOrder?->order_number ?? '-' }}</p>
            <p class="text-xs text-[var(--muted)] mt-1">
                {{ $latestOrder?->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
            </p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4">
            <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Negosiasi terakhir</p>
            <p class="mt-2 font-semibold text-[var(--ink)]">Rp {{ number_format($latestOffer?->price ?? 0) }}</p>
            <p class="text-xs text-[var(--muted)] mt-1">
                Status: {{ $latestOffer?->status ?? '-' }} • {{ $latestOffer?->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
            </p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4">
            <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Testimoni terakhir</p>
            <p class="mt-2 font-semibold text-[var(--ink)]">{{ $latestTestimonial?->rating ? $latestTestimonial->rating.'/5' : '-' }}</p>
            <p class="text-xs text-[var(--muted)] mt-1">
                {{ $latestTestimonial?->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
            </p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4">
            <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Pembayaran terakhir</p>
            <p class="mt-2 font-semibold text-[var(--ink)]">{{ $latestPayment?->status ?? '-' }}</p>
            <p class="text-xs text-[var(--muted)] mt-1">
                {{ $latestPayment?->paid_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? $latestPayment?->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}
            </p>
        </div>
    </div>
@endsection
