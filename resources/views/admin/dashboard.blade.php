@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm relative overflow-hidden">
        <div class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-blue-100/70 blur-2xl"></div>
        <div class="absolute -left-10 -bottom-10 h-32 w-32 rounded-full bg-emerald-100/70 blur-2xl"></div>
        <div class="relative flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-[var(--muted)]">Admin Panel</p>
                <h2 class="text-2xl font-semibold mt-2">Dashboard Ringkasan</h2>
                <p class="text-sm text-[var(--muted)] mt-1">Pantau performa harian dan status negosiasi terbaru.</p>
            </div>
            <div class="flex flex-wrap gap-3 text-xs">
                <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-blue-700 font-semibold">Live Data</span>
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-emerald-700 font-semibold">Auto Update</span>
            </div>
        </div>
    </div>

    <div class="mt-6 grid md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="rounded-3xl border border-blue-100 bg-blue-50 p-6 shadow-sm">
            <p class="text-xs text-blue-600 font-semibold">Total Users</p>
            <p class="text-3xl font-semibold mt-2 text-blue-900">{{ $stats['users'] }}</p>
            <p class="text-xs text-blue-500 mt-2">Akun terdaftar</p>
        </div>
        <div class="rounded-3xl border border-emerald-100 bg-emerald-50 p-6 shadow-sm">
            <p class="text-xs text-emerald-600 font-semibold">Produk Aktif</p>
            <p class="text-3xl font-semibold mt-2 text-emerald-900">{{ $stats['products'] }}</p>
            <p class="text-xs text-emerald-500 mt-2">Siap dipasarkan</p>
        </div>
        <div class="rounded-3xl border border-amber-100 bg-amber-50 p-6 shadow-sm">
            <p class="text-xs text-amber-600 font-semibold">Order Masuk</p>
            <p class="text-3xl font-semibold mt-2 text-amber-900">{{ $stats['orders'] }}</p>
            <p class="text-xs text-amber-500 mt-2">Semua transaksi</p>
        </div>
        <div class="rounded-3xl border border-rose-100 bg-rose-50 p-6 shadow-sm">
            <p class="text-xs text-rose-600 font-semibold">Testimoni Pending</p>
            <p class="text-3xl font-semibold mt-2 text-rose-900">{{ $stats['testimonials'] }}</p>
            <p class="text-xs text-rose-500 mt-2">Menunggu approval</p>
        </div>
    </div>

    <div class="mt-8 grid lg:grid-cols-[1.4fr_1fr] gap-6">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Order 6 Bulan Terakhir</h2>
                <span class="text-xs text-[var(--muted)]">Total {{ array_sum($stats['order_chart']['values']) }}</span>
            </div>
            @php
                $maxOrders = max($stats['order_chart']['values'] ?: [1]);
                $chartValues = $stats['order_chart']['values'];
                $chartPoints = [];
                $countPoints = count($chartValues);
                $width = 500;
                $height = 160;
                foreach ($chartValues as $i => $val) {
                    $x = $countPoints > 1 ? (int) round(($i / ($countPoints - 1)) * $width) : 0;
                    $y = $maxOrders > 0 ? (int) round($height - (($val / $maxOrders) * $height)) : $height;
                    $chartPoints[] = $x.','.$y;
                }
            @endphp
            <div class="mt-6 rounded-2xl bg-slate-50 p-4">
                <svg viewBox="0 0 {{ $width }} {{ $height }}" class="w-full h-40">
                    <polyline
                        fill="none"
                        stroke="rgba(15,61,145,0.35)"
                        stroke-width="6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        points="{{ implode(' ', $chartPoints) }}"
                    />
                    <polyline
                        fill="none"
                        stroke="rgba(15,61,145,0.9)"
                        stroke-width="3"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        points="{{ implode(' ', $chartPoints) }}"
                    />
                </svg>
                <div class="mt-4 grid grid-cols-6 text-xs text-[var(--muted)]">
                    @foreach ($stats['order_chart']['labels'] as $label)
                        <span class="text-center">{{ $label }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Status Negosiasi</h2>
            @php
                $offerTotal = array_sum($stats['offer_status']);
                $offerTotal = $offerTotal > 0 ? $offerTotal : 1;
            @endphp
            <div class="mt-6 space-y-4 text-sm">
                <div>
                    <div class="flex items-center justify-between text-[var(--muted)]">
                        <span>Pending</span>
                        <span class="text-[var(--ink)] font-semibold">{{ $stats['offer_status']['pending'] }}</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-2 bg-amber-400" style="width: {{ ($stats['offer_status']['pending'] / $offerTotal) * 100 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between text-[var(--muted)]">
                        <span>Accepted</span>
                        <span class="text-[var(--ink)] font-semibold">{{ $stats['offer_status']['accepted'] }}</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-2 bg-emerald-500" style="width: {{ ($stats['offer_status']['accepted'] / $offerTotal) * 100 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between text-[var(--muted)]">
                        <span>Rejected</span>
                        <span class="text-[var(--ink)] font-semibold">{{ $stats['offer_status']['rejected'] }}</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-2 bg-rose-500" style="width: {{ ($stats['offer_status']['rejected'] / $offerTotal) * 100 }}%"></div>
                    </div>
                </div>
            </div>
            <div class="mt-6 rounded-2xl border border-slate-200 p-4 text-sm text-[var(--muted)]">
                <div class="flex items-center justify-between">
                    <span>Order terakhir</span>
                    <span class="font-semibold text-[var(--ink)]">{{ $stats['latest_order'] ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span>User terbaru</span>
                    <span class="font-semibold text-[var(--ink)]">{{ $stats['latest_user'] ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span>Testimoni terbaru</span>
                    <span class="font-semibold text-[var(--ink)]">{{ $stats['latest_testimonial'] ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Aksi Cepat</h2>
            <div class="mt-4 grid sm:grid-cols-2 gap-3 text-sm">
                <a href="{{ route('admin.products.create') }}"
                   class="px-4 py-2 rounded-full bg-[var(--brand)] text-white font-semibold text-center hover:bg-[var(--brand-dark)] transition">
                    Tambah Produk
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 rounded-full bg-emerald-500 text-white font-semibold text-center hover:bg-emerald-600 transition">
                    Kelola Users
                </a>
                <a href="{{ route('admin.offers.index') }}"
                   class="px-4 py-2 rounded-full bg-amber-500 text-white font-semibold text-center hover:bg-amber-600 transition">
                    Negosiasi
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="px-4 py-2 rounded-full bg-rose-500 text-white font-semibold text-center hover:bg-rose-600 transition">
                    Lihat Order
                </a>
            </div>
        </div>
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Aktivitas Terbaru</h2>
            <div class="mt-4 space-y-3 text-sm text-[var(--muted)]">
                <div class="flex items-center justify-between">
                    <span>User baru</span>
                    <span>{{ $stats['latest_user'] ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Order terakhir</span>
                    <span>{{ $stats['latest_order'] ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Testimoni terbaru</span>
                    <span>{{ $stats['latest_testimonial'] ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    @php
        $orderValues = $stats['order_chart']['values'];
        $orderLabels = $stats['order_chart']['labels'];
        $orderTotal = array_sum($orderValues);
        $orderAvg = count($orderValues) > 0 ? round($orderTotal / count($orderValues), 1) : 0;
        $orderMax = max($orderValues ?: [0]);
        $orderMaxIndex = $orderMax > 0 ? array_search($orderMax, $orderValues, true) : null;
        $chartWidth = 500;
        $chartHeight = 120;
        $points = [];
        $countPoints = count($orderValues);
        foreach ($orderValues as $i => $val) {
            $x = $countPoints > 1 ? (int) round(($i / ($countPoints - 1)) * $chartWidth) : 0;
            $y = $orderMax > 0 ? (int) round($chartHeight - (($val / $orderMax) * $chartHeight)) : $chartHeight;
            $points[] = $x.','.$y;
        }
        $sortedOrders = $orderValues;
        rsort($sortedOrders);
        $topOrders = array_slice($sortedOrders, 0, 3);
    @endphp
    <div class="mt-8 grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Kesehatan Produk</h2>
                <span class="text-xs text-[var(--muted)]">Total stok {{ number_format($stats['total_stock']) }}</span>
            </div>
            <div class="mt-5 grid grid-cols-3 gap-3 text-xs">
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-3 py-3">
                    <p class="text-emerald-600">Produk Aktif</p>
                    <p class="text-sm font-semibold text-emerald-900">{{ $stats['active_products'] }}</p>
                </div>
                <div class="rounded-2xl border border-amber-100 bg-amber-50 px-3 py-3">
                    <p class="text-amber-600">Stok Menipis</p>
                    <p class="text-sm font-semibold text-amber-900">
                        {{ $stats['low_stock'] > 0 ? $stats['low_stock'] : 'Aman' }}
                    </p>
                    <p class="text-[11px] text-amber-600/80 mt-1">
                        {{ $stats['low_stock'] > 0 ? 'Butuh restock' : 'Tidak ada stok kritis' }}
                    </p>
                </div>
                <div class="rounded-2xl border border-blue-100 bg-blue-50 px-3 py-3">
                    <p class="text-blue-600">Total Produk</p>
                    <p class="text-sm font-semibold text-blue-900">{{ $stats['products'] }}</p>
                </div>
            </div>
            <div class="mt-6 rounded-2xl border border-slate-200 p-4">
                <p class="text-xs text-[var(--muted)] font-semibold">Top 3 Stok Tertinggi</p>
                <div class="mt-4 space-y-3 text-sm">
                    @php
                        $maxTopStock = $stats['top_products']->max('stock') ?: 1;
                    @endphp
                    @foreach ($stats['top_products'] as $product)
                        <div class="flex items-center justify-between">
                            <span class="text-[var(--ink)] font-semibold">{{ $product->name }}</span>
                            <span class="text-[var(--muted)]">{{ number_format($product->stock) }} {{ $product->unit }}</span>
                        </div>
                        <div class="h-3 rounded-full bg-slate-100 overflow-hidden">
                            @php
                                $ratio = $maxTopStock > 0 ? ($product->stock / $maxTopStock) * 100 : 0;
                            @endphp
                            <div class="h-3 bg-[var(--brand)]/80" style="width: {{ max(8, $ratio) }}%"></div>
                        </div>
                    @endforeach
                    @if ($stats['top_products']->isEmpty())
                        <div class="text-xs text-[var(--muted)]">Belum ada data stok.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Highlight Bulan</h2>
                <span class="text-xs text-[var(--muted)]">Top 3</span>
            </div>
            <div class="mt-6 space-y-4 text-sm">
                @foreach ($topOrders as $rank => $value)
                    @php
                        $monthIndex = array_search($value, $orderValues, true);
                        $label = $monthIndex !== false ? ($orderLabels[$monthIndex] ?? '-') : '-';
                    @endphp
                    <div class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3">
                        <div>
                            <p class="text-xs text-[var(--muted)]">Peringkat {{ $rank + 1 }}</p>
                            <p class="text-sm font-semibold text-[var(--ink)]">{{ $label }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-[var(--muted)]">Order</p>
                            <p class="text-base font-semibold text-[var(--brand)]">{{ $value }}</p>
                        </div>
                    </div>
                @endforeach
                <div class="rounded-2xl bg-blue-50 border border-blue-100 p-4 text-xs text-blue-700">
                    Fokus di bulan dengan order tertinggi untuk promo dan stok.
                </div>
            </div>
        </div>
    </div>
@endsection




