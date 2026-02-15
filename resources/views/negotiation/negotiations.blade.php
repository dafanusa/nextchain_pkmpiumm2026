<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Negosiasi - NEXTCHAIN</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');

        :root {
            --ink: #0b1b32;
            --muted: #4b5563;
            --brand: #0f3d91;
            --brand-dark: #0a2d6c;
            --bg: #f6f8fc;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(900px 400px at 90% -10%, #dbeafe 0%, rgba(219, 234, 254, 0) 60%),
                var(--bg);
        }

        .action-btn {
            position: relative;
            overflow: hidden;
            border-radius: 999px;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease, color 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }
        .action-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.35), rgba(255, 255, 255, 0));
            transform: translateX(-120%);
            transition: transform 0.45s ease;
        }
        .action-btn:hover::after {
            transform: translateX(120%);
        }
        .action-btn:hover {
            transform: translateY(-1px);
        }
        .btn-detail {
            background: #1e3a8a;
            border: 1px solid #1e40af;
            color: #fff;
        }
        .btn-detail:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #fff;
            box-shadow: 0 10px 24px rgba(30, 64, 175, 0.35);
        }
        .btn-nego {
            background: #22c55e;
            color: #fff;
            box-shadow: 0 12px 26px rgba(34, 197, 94, 0.3);
        }
        .btn-nego:hover {
            background: #16a34a;
            box-shadow: 0 16px 32px rgba(34, 197, 94, 0.38);
        }

        .chart-wrap {
            display: grid;
            gap: 1rem;
        }

        .chart-panel {
            background: #f8fbff;
            border: 1px solid #e5edf9;
            border-radius: 24px;
            padding: 1.25rem;
        }

        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 12px;
            color: var(--muted);
            align-items: center;
        }

        .legend-swatch {
            width: 10px;
            height: 10px;
            border-radius: 999px;
        }

        .bar-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .bar-group {
            display: grid;
            gap: 0.6rem;
            text-align: center;
        }

        .bar-stack {
            height: 160px;
            border-radius: 18px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.9), rgba(248, 251, 255, 0.7)),
                repeating-linear-gradient(
                    to top,
                    rgba(15, 61, 145, 0.1),
                    rgba(15, 61, 145, 0.1) 1px,
                    transparent 1px,
                    transparent 26px
                );
            border: 1px solid rgba(148, 163, 184, 0.35);
            padding: 0.65rem;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
            align-items: end;
        }

        .bar-item {
            position: relative;
            height: 100%;
            padding-top: 1.4rem;
        }

        .bar {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            border-radius: 0;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.15);
        }

        .bar-item:focus-within .bar-tooltip,
        .bar-item:hover .bar-tooltip {
            opacity: 1;
            transform: translate(-50%, -6px);
            pointer-events: auto;
        }

        .bar-tooltip {
            position: absolute;
            top: -6px;
            left: 50%;
            transform: translate(-50%, 6px);
            padding: 0.35rem 0.6rem;
            font-size: 11px;
            color: #0b1b32;
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, 0.4);
            border-radius: 10px;
            box-shadow: 0 10px 24px rgba(15, 61, 145, 0.18);
            opacity: 0;
            pointer-events: none;
            transition: all 0.2s ease;
            white-space: nowrap;
            z-index: 2;
        }

        .bar-min {
            background: linear-gradient(180deg, #3b82f6 0%, #1d4ed8 100%);
            box-shadow: 0 10px 18px rgba(29, 78, 216, 0.25);
        }

        .bar-max {
            background: linear-gradient(180deg, #fb923c 0%, #f97316 100%);
            box-shadow: 0 10px 18px rgba(249, 115, 22, 0.25);
        }

        .bar-users {
            background: linear-gradient(180deg, #10b981 0%, #059669 100%);
            box-shadow: 0 10px 18px rgba(16, 185, 129, 0.25);
        }

        .bar-avg {
            background: linear-gradient(180deg, #facc15 0%, #f59e0b 100%);
            box-shadow: 0 10px 18px rgba(245, 158, 11, 0.25);
        }

        .bar-avg-vol {
            background: linear-gradient(180deg, #a855f7 0%, #7c3aed 100%);
            box-shadow: 0 10px 18px rgba(124, 58, 237, 0.25);
        }

        .bar-meta {
            display: grid;
            gap: 0.2rem;
            font-size: 11px;
            color: var(--muted);
        }

        .chart-scale {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem 1rem;
            font-size: 11px;
            color: var(--muted);
        }

        .scale-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            background: #eef2ff;
            border: 1px solid #dbe4ff;
            color: #1e3a8a;
        }

        @media (max-width: 640px) {
            .chart-panel {
                padding: 1rem;
            }

            .bar-grid {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
                gap: 0.75rem;
            }

            .bar-stack {
                height: 135px;
                padding: 0.55rem;
            }

            .bar-group {
                gap: 0.45rem;
            }

            .bar-meta {
                font-size: 10px;
            }

            .chart-scale {
                font-size: 10px;
                gap: 0.4rem 0.6rem;
            }

        }

        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 12px;
            color: var(--muted);
            align-items: center;
        }

        .chart-legend span {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .legend-swatch {
            width: 10px;
            height: 10px;
            border-radius: 999px;
        }

        .price-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.45rem 0.9rem;
            border-radius: 999px;
            background: #e8f5ff;
            color: #0f3d91;
            font-size: 13px;
            font-weight: 700;
        }

        .price-dot {
            height: 6px;
            width: 6px;
            border-radius: 999px;
            background: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
            position: relative;
        }

        .price-dot::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 999px;
            border: 2px solid rgba(16, 185, 129, 0.35);
            animation: pulse 1.8s ease-out infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.6); opacity: 1; }
            100% { transform: scale(1.4); opacity: 0; }
        }

        .card-glow {
            box-shadow: 0 18px 40px rgba(15, 61, 145, 0.08);
        }
    </style>
</head>

<body>
    @include('loading-overlay')
    <div id="top"></div>
    <header class="sticky top-0 z-50 bg-[var(--brand)] text-white h-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight inline-flex items-center gap-2">
                NEXTCHAIN                <img src="{{ asset('assets/Nextchainumm.png') }}" alt="Logo Nextchain" class="h-16 w-16 sm:h-16 sm:w-16 object-contain">
            </a>
            <nav class="hidden md:flex items-center gap-5 text-sm font-medium text-white/80">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <a href="{{ route('produk') }}" class="hover:text-white">Produk</a>
                <a href="{{ route('negosiasi.list') }}" class="text-white border-b-2 border-white/80 pb-0.5">Negosiasi</a>
                <a href="{{ route('home') }}#tentang" class="hover:text-white">Tentang</a>
                <a href="{{ route('home') }}#galeri" class="hover:text-white">Galeri</a>
                <a href="{{ route('home') }}#testimoni" class="hover:text-white">Testimoni</a>
                <a href="{{ route('home') }}#contact" class="hover:text-white">Contact</a>
            </nav>
            <div class="flex items-center gap-3">
                <a href="{{ route('cart') }}"
                   class="relative inline-flex items-center justify-center h-9 w-9 rounded-full border border-white/40 text-white hover:bg-white/10 transition"
                   aria-label="Keranjang">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="9" cy="20" r="1.5"></circle>
                        <circle cx="17" cy="20" r="1.5"></circle>
                        <path d="M3 4h2l2.2 10.5a2 2 0 0 0 2 1.5h7.5a2 2 0 0 0 2-1.6L21 8H7.2"></path>
                    </svg>
                    <span class="cart-count absolute -top-1 -right-1 h-4 min-w-[1rem] px-1 rounded-full bg-amber-400 text-[10px] font-semibold text-white flex items-center justify-center">0</span>
                    </a>
                @auth
                    <span class="hidden sm:inline-flex items-center px-4 py-2 rounded-full border border-white/40 text-sm font-semibold text-white">
                        Hai, {{ strtok(auth()->user()->name, ' ') }}
                    </span>
                    <a href="{{ route('profile.show') }}"
                       class="hidden sm:inline-flex items-center justify-center h-9 w-9 rounded-full border border-white/40 text-white hover:bg-white/10 transition"
                       aria-label="Profil">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 21a8 8 0 0 0-16 0" />
                            <circle cx="12" cy="9" r="4" />
                        </svg>
                    </a>
                    <span class="hidden sm:inline-flex items-center gap-2 rounded-full bg-emerald-400/20 text-emerald-50 border border-emerald-200/30 px-3 py-1.5 text-xs font-semibold shadow-[0_0_12px_rgba(16,185,129,0.25)]">
                        <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                    Poin
                        <span class="rounded-full bg-emerald-500/40 px-2 py-0.5 text-white">{{ auth()->user()->loyalty_points ?? 0 }}</span>
                    </span>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="hidden sm:inline-flex items-center px-4 py-2 rounded-full bg-white text-[var(--brand)] text-sm font-semibold hover:bg-slate-100 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden sm:inline-flex items-center px-4 py-2 rounded-full border border-white/40 text-sm font-semibold text-white hover:bg-white/10 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="hidden sm:inline-flex items-center px-4 py-2 rounded-full bg-white text-[var(--brand)] text-sm font-semibold hover:bg-slate-100 transition">
                        Register
                    </a>
                @endauth
                <button id="menuBtn"
                        class="md:hidden px-3 py-1.5 rounded-full border border-white/40 text-sm font-semibold text-white">
    <span class="sr-only">Menu</span>
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="4" y1="6" x2="20" y2="6"></line>
        <line x1="4" y1="12" x2="20" y2="12"></line>
        <line x1="4" y1="18" x2="20" y2="18"></line>
    </svg></button>
            </div>
        </div>
    </header>

    <div id="mobileMenu" class="md:hidden fixed top-16 left-0 right-0 z-40 px-6 pb-4 space-y-2 text-sm text-white/90 bg-[var(--brand)] mobile-menu transition-all duration-300 ease-out max-h-0 opacity-0 -translate-y-2 pointer-events-none overflow-hidden overflow-y-auto">
        <a href="{{ route('home') }}" class="block">Home</a>
        <a href="{{ route('produk') }}" class="block">Produk</a>
        <a href="{{ route('cart') }}" class="block">Keranjang</a>
        <a href="{{ route('negosiasi.list') }}" class="block">Negosiasi</a>
        <a href="{{ route('home') }}#tentang" class="block">Tentang</a>
        <a href="{{ route('home') }}#galeri" class="block">Galeri</a>
        <a href="{{ route('home') }}#testimoni" class="block">Testimoni</a>
        <a href="{{ route('home') }}#contact" class="block">Contact</a>
        <div class="pt-2 border-t border-white/10 space-y-2">
            @auth
                <span class="block text-xs text-white/70">Hai, {{ strtok(auth()->user()->name, ' ') }}</span>
                <a href="{{ route('profile.show') }}" class="block text-sm font-semibold text-white">Profil</a>
                    <span class="mt-2 inline-flex items-center gap-2 rounded-full bg-emerald-400/20 text-emerald-50 border border-emerald-200/30 px-3 py-1 text-[11px] font-semibold">
                    <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                    Poin
                    <span class="rounded-full bg-emerald-500/40 px-2 py-0.5 text-white">{{ auth()->user()->loyalty_points ?? 0 }}</span>
                    </span>
                    <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-sm font-semibold text-white">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-sm font-semibold text-white">Login</a>
                <a href="{{ route('register') }}" class="block text-sm font-semibold text-white">Register</a>
            @endauth
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-6 py-12">
        @php
            $chartData = collect($products)->map(function ($product, $id) use ($offersByProduct) {
                $offers = $offersByProduct[$id] ?? [];
                $count = count($offers);
                $totalQty = collect($offers)->sum('qty');
                $avgPrice = $count ? round(collect($offers)->avg('price')) : $product['price_min'];
                return [
                    'name' => $product['name'],
                    'count' => $count,
                    'total_qty' => $totalQty,
                    'avg_price' => $avgPrice,
                    'has_offers' => $count > 0,
                    'unit' => $product['unit'],
                ];
            })->values();
            $maxCount = max(1, $chartData->max('count'));
            $maxQty = max(1, $chartData->max('total_qty'));
            $maxAvg = max(1, $chartData->max('avg_price'));
            $maxAvgVol = max(1, $chartData->max(function ($row) {
                return $row['count'] ? ($row['total_qty'] / $row['count']) : 0;
            }));
        @endphp

        <div class="bg-white/80 border border-slate-200 rounded-3xl p-8 lg:p-10 shadow-lg">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <p class="text-xs uppercase tracking-[0.35em] text-[var(--muted)]">Negosiasi</p>
                    <h1 class="text-4xl font-bold mt-2">Daftar Negosiasi</h1>
                    <p class="text-[var(--muted)] mt-2 max-w-2xl">
                        Ringkasan negosiasi dari seluruh produk. Klik produk untuk melihat detail atau lanjutkan negosiasi.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('produk') }}"
                       class="px-5 py-2 rounded-full border border-gray-200 text-sm font-semibold hover:border-[var(--brand)] transition">
                        Lihat Produk
                    </a>
                    <a href="{{ route('home') }}#contact"
                       class="px-5 py-2 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                        Hubungi
                    </a>
                </div>
            </div>

            <div class="mt-8 chart-wrap">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="space-y-1">
                        <h2 class="text-base font-semibold text-[var(--ink)]">Grafik Ringkasan Negosiasi</h2>
                        <p class="text-xs text-[var(--muted)]">Jumlah penawar aktif dan total volume tawaran per produk.</p>
                    </div>
                    <div class="chart-legend">
                        <span><span class="legend-swatch" style="background:#1d4ed8"></span>
                    Jumlah Penawar</span>
                    <span><span class="legend-swatch" style="background:#10b981"></span>
                    Total Volume</span>
                    <span><span class="legend-swatch" style="background:#f59e0b"></span>
                    Rata-rata Harga</span>
                    <span><span class="legend-swatch" style="background:#7c3aed"></span>
                    Rata-rata Volume/User</span>
                    </div>
                </div>
                <div class="chart-panel mt-4">
                    <div class="bar-grid">
                        @foreach ($chartData as $row)
                            @php
                                $countHeight = intval(($row['count'] / $maxCount) * 100);
                                $qtyHeight = intval(($row['total_qty'] / $maxQty) * 100);
                                $avgHeight = intval(($row['avg_price'] / $maxAvg) * 100);
                                $avgVol = $row['count'] ? ($row['total_qty'] / $row['count']) : 0;
                                $avgVolHeight = intval(($avgVol / $maxAvgVol) * 100);
                            @endphp
                            <div class="bar-group">
                                <div class="text-sm font-medium text-[var(--ink)]">{{ $row['name'] }}</div>
                                <div class="bar-stack">
                                    <div class="bar-item" tabindex="0">
                                        <div class="bar bar-min" style="height: {{ max(12, $countHeight) }}%"></div>
                                        <div class="bar-tooltip">Penawar: {{ $row['count'] }} orang</div>
                                    </div>
                                    <div class="bar-item" tabindex="0">
                                        <div class="bar bar-users" style="height: {{ max(12, $qtyHeight) }}%"></div>
                                        <div class="bar-tooltip">Total volume: {{ number_format($row['total_qty']) }} {{ $row['unit'] }}</div>
                                    </div>
                                    <div class="bar-item" tabindex="0">
                                        <div class="bar bar-avg" style="height: {{ max(12, $avgHeight) }}%"></div>
                                        <div class="bar-tooltip">Rata-rata: Rp {{ number_format($row['avg_price']) }}</div>
                                    </div>
                                    <div class="bar-item" tabindex="0">
                                        <div class="bar bar-avg-vol" style="height: {{ max(12, $avgVolHeight) }}%"></div>
                                        <div class="bar-tooltip">Rata-rata volume: {{ number_format($avgVol, 1) }} {{ $row['unit'] }}</div>
                                    </div>
                                </div>
                                <div class="bar-meta">
                                    <span>Penawar aktif: {{ $row['count'] }} orang</span>
                    <span>Total volume: {{ number_format($row['total_qty']) }} {{ $row['unit'] }}</span>
                    <span>Rata-rata: Rp {{ number_format($row['avg_price']) }} / {{ $row['unit'] }}</span>
                    <span>Rata-rata volume: {{ number_format($avgVol, 1) }} {{ $row['unit'] }}/user</span>
                    </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-10 grid md:grid-cols-2 gap-6 items-stretch">
            @foreach ($products as $id => $product)
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-lg card-glow flex flex-col h-full">
                <div class="space-y-4">
                    <img src="{{ $product['image_url'] ?? asset('assets/' . $product['image']) }}"
                         alt="{{ $product['name'] }}"
                         class="h-44 w-full rounded-2xl object-cover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs uppercase tracking-[0.2em] text-[var(--muted)]">Produk</span>
                    <span class="text-xs font-semibold text-emerald-600">
                            {{ isset($offersByProduct[$id]) ? count($offersByProduct[$id]) : 0 }} tawaran aktif
                        </span>
                    </div>
                    <div class="space-y-1">
                        <h2 class="text-2xl font-semibold">{{ $product['name'] }}</h2>
                        <p class="text-sm text-[var(--muted)]">
                            Mitra: {{ $product['supplier'] }} - Grade {{ $product['grade'] }}
                        </p>
                        <div class="price-pill" data-min="{{ $product['price_min'] }}" data-max="{{ $product['price_max'] }}" data-unit="{{ $product['unit'] }}">
                            <span class="price-dot"></span>
                    Harga realtime
                            <span class="live-price">Rp {{ number_format($product['price_min']) }} / {{ $product['unit'] }}</span>
                    </div>
                    </div>
                </div>

                <div class="mt-6 grid md:grid-cols-2 gap-4">
                    @forelse ($offersByProduct[$id] ?? [] as $offer)
                        <div class="relative bg-gray-50 rounded-2xl p-4 border border-gray-100">
                            <span class="absolute left-0 top-4 h-8 w-1 rounded-full bg-[var(--brand)]"></span>
                    <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold">{{ $offer['user'] }}</p>
                                <span class="text-xs font-semibold
                                    @if (($offer['status'] ?? '') === 'accepted') text-emerald-600
                                    @elseif (($offer['status'] ?? '') === 'rejected') text-red-500
                                    @else text-[var(--muted)]
                                    @endif">
                                    {{ ucfirst($offer['status'] ?? 'pending') }}
                                </span>
                    </div>
                            <p class="text-base font-semibold text-[var(--ink)] mt-2">
                                Rp {{ number_format($offer['price']) }} / {{ $product['unit'] }}
                            </p>
                            <p class="text-xs text-[var(--muted)] mt-1">
                                Volume {{ $offer['qty'] }} {{ $product['unit'] }}
                            </p>
                            <p class="text-xs text-[var(--muted)] mt-1">{{ $offer['time'] }}</p>
                        </div>
                    @empty
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 text-sm text-[var(--muted)]">
                            Belum ada negosiasi untuk produk ini.
                        </div>
                    @endforelse
                </div>

                <div class="mt-auto pt-6 flex flex-wrap gap-3">
                    <a href="{{ route('produk.detail', $id) }}"
                       class="inline-flex items-center justify-center px-4 py-2 text-sm action-btn btn-detail">
                        Detail Produk
                    </a>
                    <a href="{{ route('produk.negosiasi', $id) }}"
                       class="inline-flex items-center justify-center px-4 py-2 text-sm action-btn btn-nego">
                        Mulai Negosiasi
                    </a>
                </div>
            </div>
            @endforeach
        </section>
    </main>

    <footer class="mt-16 border-t border-white/10 bg-[var(--brand)] text-white">
        <div class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-8 text-sm text-white/80">
            <div class="space-y-3">
                <p class="text-lg font-semibold text-white">NEXTCHAIN</p>
                <p>
                    UMKM peternakan telur UD. Ade Saputra Farm dengan negosiasi terbuka dan distribusi jelas.
                </p>
            </div>
            <div class="space-y-3">
                <p class="text-base font-semibold text-white">Kontak</p>
                <p class="max-w-xs">Jl. Dusun Rojopasang, Juranglondo, Gerbo, Kec. Purwodadi, Kab. Pasuruan, Prov. Jawa Timur.</p>
                <a href="https://wa.me/6281230384757" class="hover:text-white">WhatsApp: 0812-3038-4757</a>
            </div>
            <div class="space-y-3">
                <p class="text-base font-semibold text-white">Tim Pengembang NEXTCHAIN</p>
                <div class="grid gap-1 text-xs text-white/80">
                    <span>Rinaldy Achmad Roberth Fathoni S.AB., M.M</span>
                    <span>Wahyu Firmansyah</span>
                    <span>Azhubah Rizki Amalia</span>
                    <span>Aisyah Putri Permata Sari</span>
                    <span>Rizqullah Atsir Dafa Childyasa Nusa</span>
                    <span>Ayesha Fahrelia Ningrum</span>
                    </div>
            </div>
        </div>
        <div class="border-t border-white/10 py-4 text-center text-xs text-white/70">
            (c) 2026 NEXTCHAIN - PKM-PI UMM 2026
        </div>
    </footer>

    <script>
                const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (menuBtn && mobileMenu) {
            let isMenuOpen = false;
            let allowScrollClose = false;

            const openMenu = () => {
                mobileMenu.classList.remove('max-h-0', 'opacity-0', '-translate-y-2', 'pointer-events-none');
                mobileMenu.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                mobileMenu.style.maxHeight = 'calc(100vh - 4rem)';
                isMenuOpen = true;
                allowScrollClose = false;
                setTimeout(() => {
                    allowScrollClose = true;
                }, 150);
            };

            const closeMenu = () => {
                mobileMenu.classList.add('max-h-0', 'opacity-0', '-translate-y-2', 'pointer-events-none');
                mobileMenu.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                mobileMenu.style.maxHeight = '0px';
                isMenuOpen = false;
            };

            menuBtn.addEventListener('click', (event) => {
                event.preventDefault();
                if (isMenuOpen) {
                    closeMenu();
                    return;
                }
                openMenu();
            });

            window.addEventListener('scroll', () => {
                if (isMenuOpen && allowScrollClose) {
                    closeMenu();
                }
            }, { passive: true });
            window.addEventListener('resize', closeMenu);
            mobileMenu.querySelectorAll('a, button').forEach((item) => {
                item.addEventListener('click', closeMenu);
            });
        }


        const cartCounts = Array.from(document.querySelectorAll('.cart-count'));
        const initialCartCount = {{ $cartCount ?? 0 }};
        function updateCartBadge(count) {
            cartCounts.forEach((badge) => {
                const nextCount = Number(count || 0);
                badge.textContent = nextCount;
                badge.classList.toggle('hidden', nextCount === 0);
            });
        }
        updateCartBadge(initialCartCount);
        updateLivePrices();
        setInterval(updateLivePrices, 4000);
    </script>
    <a href="#top" class="lg:hidden fixed bottom-6 right-6 z-40 inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#0f3d91] text-white shadow-lg shadow-blue-900/30 hover:bg-[#0a2d6c] transition" aria-label="Kembali ke atas">
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 14l6-6 6 6" />
        </svg>
    </a></body>
</html>





























