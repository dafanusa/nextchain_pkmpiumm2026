<!doctype html>
<html lang="id" class="overflow-x-hidden">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>NEXTCHAIN | UD. Ade Saputra Farm</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');

        :root {
            --ink: #0b1b32;
            --muted: #4b5563;
            --brand: #0f3d91;
            --brand-dark: #0a2d6c;
            --accent: #f59e0b;
            --mint: #10b981;
            --bg: #f6f8fc;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(1200px 600px at 85% -15%, #e0f2fe 0%, rgba(224, 242, 254, 0) 60%),
                radial-gradient(900px 450px at -10% 20%, #f1f5f9 0%, rgba(241, 245, 249, 0) 55%),
                var(--bg);
        }

        .fade-up {
            animation: fadeUp 0.8s ease both;
        }

        .float-slow {
            animation: float 6s ease-in-out infinite;
        }

        .card-glow:hover {
            box-shadow: 0 30px 60px rgba(15, 61, 145, 0.18);
            transform: translateY(-6px);
        }

        .soft-panel {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(15, 61, 145, 0.08);
        }

        .stat-card {
            border: 1px solid rgba(15, 61, 145, 0.1);
        }

        .reveal {
            animation: fadeUp 0.9s ease both;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

        .gallery-card {
            transition: transform 0.45s ease, box-shadow 0.45s ease;
        }

        .gallery-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 24px 50px rgba(15, 61, 145, 0.2);
        }

        .gallery-strip {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding: 0.5rem 0 1.5rem;
            cursor: grab;
            scrollbar-width: none;
        }

        .gallery-strip:active {
            cursor: grabbing;
        }

        .gallery-strip::-webkit-scrollbar {
            display: none;
        }

        .gallery-item {
            flex: 0 0 280px;
            scroll-snap-align: center;
            transition: transform 0.4s ease, box-shadow 0.4s ease, border-color 0.4s ease;
        }

        .gallery-item.is-active {
            transform: scale(1.06);
            border: 3px solid #d11f1f;
            box-shadow: 0 24px 60px rgba(209, 31, 31, 0.2);
        }

        .gallery-dot {
            height: 0.5rem;
            width: 0.5rem;
            border-radius: 999px;
            background: #cbd5f5;
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .gallery-dot.is-active {
            background: #d11f1f;
            transform: scale(1.2);
        }

        .testi-card {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
        }

        .testi-slab {
            background: radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.2), transparent 50%),
                linear-gradient(135deg, #e2e8f0 0%, #f8fafc 45%, #eef2ff 100%);
            border: 1px solid rgba(148, 163, 184, 0.3);
        }

        .quote-card {
            border: 1px solid rgba(148, 163, 184, 0.25);
            background: #ffffff;
            box-shadow: 0 18px 40px rgba(15, 61, 145, 0.08);
        }

        .quote-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 26px 60px rgba(15, 61, 145, 0.16);
        }

        .quote-mark {
            font-size: 40px;
            line-height: 1;
        }

        .dev-card {
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .dev-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 36px rgba(15, 61, 145, 0.35);
        }

        .dev-card:active,
        .dev-card.is-pressed {
            transform: translateY(0) scale(0.98);
            box-shadow: 0 10px 22px rgba(15, 61, 145, 0.28);
        }

        .form-shell {
            background: #0f3d91;
            color: #ffffff;
        }

        .form-shell select option {
            background: #0f3d91;
            color: #ffffff;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0); }
        }
    </style>
</head>

<body class="overflow-x-hidden">
    @include('loading-overlay')
    <div id="top"></div>
    <header class="sticky top-0 z-50 bg-[var(--brand)] text-white h-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
            <a href="{{ route('home') }}" class="text-xl sm:text-2xl font-bold tracking-tight inline-flex items-center gap-2 whitespace-nowrap">
                <span>NEXTCHAIN</span>
                <img src="{{ asset('assets/logoumm.png') }}" alt="Logo UMM" class="h-9 w-9 sm:h-12 sm:w-12 object-contain">
            </a>

            <nav class="hidden xl:flex items-center gap-5 text-sm font-medium text-white/80">
                <a href="#home" class="nav-link text-white border-b-2 border-white/80 pb-0.5">Home</a>
                <a href="{{ route('produk') }}" class="hover:text-white">Produk</a>
                <a href="{{ route('negosiasi.list') }}" class="hover:text-white">Negosiasi</a>
                <a href="#tentang" class="nav-link hover:text-white">Tentang</a>
                <a href="#galeri" class="nav-link hover:text-white">Galeri</a>
                <a href="#testimoni" class="nav-link hover:text-white">Testimoni</a>
                <a href="#contact" class="nav-link hover:text-white">Contact</a>
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
                        class="xl:hidden px-3 py-1.5 rounded-full border border-white/40 text-sm font-semibold text-white">
    <span class="sr-only">Menu</span>
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="4" y1="6" x2="20" y2="6"></line>
        <line x1="4" y1="12" x2="20" y2="12"></line>
        <line x1="4" y1="18" x2="20" y2="18"></line>
    </svg></button>
            </div>
        </div>

        <div id="mobileMenu" class="xl:hidden fixed top-16 left-0 right-0 z-40 px-4 sm:px-6 pb-4 space-y-2 text-sm text-white/90 bg-[var(--brand)] mobile-menu transition-all duration-300 ease-out max-h-0 opacity-0 -translate-y-2 pointer-events-none overflow-hidden overflow-y-auto overflow-y-auto">
            <a href="#home" class="block">Home</a>
            <a href="{{ route('produk') }}" class="block">Produk</a>
            <a href="{{ route('cart') }}" class="block">Keranjang</a>
            <a href="{{ route('negosiasi.list') }}" class="block">Negosiasi</a>
            <a href="#tentang" class="block">Tentang</a>
            <a href="#galeri" class="block">Galeri</a>
            <a href="#testimoni" class="block">Testimoni</a>
            <a href="#contact" class="block">Contact</a>
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
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6">
        <section class="pt-10 sm:pt-14 pb-12 sm:pb-16" id="home">
            <div class="relative overflow-hidden rounded-[2rem] sm:rounded-[2.5rem] bg-[var(--brand)] text-white shadow-[0_30px_70px_rgba(15,61,145,0.28)]">
                <img src="{{ asset('assets/home.jpg') }}" alt="UD. Ade Saputra Farm" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-r from-[#0b214f]/90 via-[#0b214f]/70 to-[#0b214f]/20"></div>
                <div class="absolute -left-20 -top-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -bottom-24 -right-20 h-64 w-64 rounded-full bg-emerald-300/10 blur-3xl"></div>

                <div class="relative px-6 py-10 sm:px-10 lg:px-16 lg:py-16">
                    <div class="max-w-3xl space-y-6">
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white/90">
                            UD. Ade Saputra Farm
                        </span>
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold leading-tight max-w-4xl">
                            Telur segar, Harga jujur, dan Negosiasi mudah.
                        </h1>
                        <p class="text-white/80 text-base sm:text-lg max-w-md">
                            Lihat katalog, ajukan penawaran terbaik,<br>dan atur distribusi dengan cepat.
                        </p>
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('produk') }}"
                               class="group inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-amber-500 via-yellow-300 to-amber-300 text-slate-900 font-semibold ring-1 ring-white/40 shadow-[0_16px_34px_rgba(245,158,11,0.5)] hover:-translate-y-0.5 hover:shadow-[0_20px_44px_rgba(245,158,11,0.6)] transition">
                                Jelajahi Produk
                                <svg viewBox="0 0 24 24" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14"/>
                                    <path d="M13 6l6 6-6 6"/>
                                </svg>
                            </a>
                            <a href="{{ route('negosiasi.list') }}"
                               class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-white/40 bg-[#0b214f]/90 text-white font-semibold shadow-[0_12px_28px_rgba(11,33,79,0.6)] hover:bg-[#0b214f] hover:border-white/60 transition">
                                Ajukan Penawaran
                                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M7 17l10-10"/>
                                    <path d="M7 7h10v10"/>
                                </svg>
                            </a>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-4 text-sm text-white/80 max-w-md">
                            <div class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3">
                                <p class="text-[11px] uppercase tracking-wider text-white/60">Harga Update</p>
                                <p class="mt-1 text-base font-semibold">Setiap 3 menit</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3">
                                <p class="text-[11px] uppercase tracking-wider text-white/60">Distribusi</p>
                                <p class="mt-1 text-base font-semibold">Terjadwal & fleksibel</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-14 sm:py-16 border-t border-slate-200/80 bg-white/60 w-full" id="tentang">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-8 sm:gap-10 items-center">
                <div class="space-y-6">
                    <span class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-white/80 text-sm font-semibold text-[var(--brand)] shadow-sm border border-slate-200/60">
                        <span class="h-2.5 w-2.5 rounded-full bg-[var(--brand)]"></span>
                    Profil UMKM
                    </span>
                    <h2 class="text-4xl sm:text-5xl font-bold">UD. Ade Saputra Farm</h2>
                    <p class="text-[var(--muted)] text-lg sm:text-xl">
                        UMKM peternakan telur yang fokus pada kualitas produksi dan keterbukaan harga.
                        NEXTCHAIN membantu pembeli berinteraksi langsung dengan peternak tanpa perantara.
                    </p>
                    <div class="grid sm:grid-cols-2 gap-5 pt-2 text-sm text-[var(--muted)]">
                        <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4 shadow-sm">
                            <p class="uppercase text-xs tracking-wider text-[var(--brand)]">Fokus</p>
                            <p class="mt-2 text-lg font-semibold text-[var(--ink)]">Telur segar berkualitas</p>
                            <p class="mt-1">Produksi diawasi setiap hari.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4 shadow-sm">
                            <p class="uppercase text-xs tracking-wider text-[var(--brand)]">Transparansi</p>
                            <p class="mt-2 text-lg font-semibold text-[var(--ink)]">Harga terbuka</p>
                            <p class="mt-1">Penawaran bisa dilihat bersama.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4 shadow-sm">
                            <p class="uppercase text-xs tracking-wider text-[var(--brand)]">Distribusi</p>
                            <p class="mt-2 text-lg font-semibold text-[var(--ink)]">Terjadwal dan fleksibel</p>
                            <p class="mt-1">Pickup farm atau pengiriman.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-4 shadow-sm">
                            <p class="uppercase text-xs tracking-wider text-[var(--brand)]">Kapasitas</p>
                            <p class="mt-2 text-lg font-semibold text-[var(--ink)]">Skala UMKM</p>
                            <p class="mt-1">Siap untuk kebutuhan grosir.</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -top-8 -left-8 h-28 w-28 rounded-full bg-[var(--accent)]/20 blur-2xl"></div>
                    <div class="absolute -bottom-10 -right-8 h-36 w-36 rounded-full bg-[var(--mint)]/20 blur-2xl"></div>
                    <div class="grid grid-cols-2 gap-4">
                        <img src="{{ asset('assets/ternakayam.jpg') }}" alt="Produksi telur"
                             class="rounded-3xl aspect-[4/3] w-full object-cover">
                        <img src="{{ asset('assets/ternakayam1.jpg') }}" alt="Kualitas telur"
                             class="rounded-3xl aspect-[4/3] w-full object-cover">
                        <div class="col-span-2 bg-gradient-to-r from-[#0f3d91] to-[#1d5bbf] rounded-3xl p-6 text-white">
                            <p class="text-xs text-white/70">Harga hari ini</p>
                            <p class="text-2xl font-semibold mt-2">
                                Rp {{ number_format($heroPriceMin) }} - Rp {{ number_format($heroPriceMax) }}/{{ $heroUnit }}
                            </p>
                            <p class="text-xs text-white/70 mt-1">Grade {{ $heroGrade }}, update real-time</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 border-t border-slate-200/80 w-full" id="produk-unggulan">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <h2 class="text-3xl font-bold">Produk Unggulan UMKM</h2>
                <a href="{{ route('produk') }}" class="text-sm font-semibold text-[var(--brand)]">Lihat semua produk</a>
            </div>
            <div class="mt-6 divide-y divide-slate-200">
                @forelse ($featuredProducts ?? [] as $product)
                    <div class="py-6 grid md:grid-cols-5 gap-6 items-center">
                        <img src="{{ $product->image_url }}"
                             alt="{{ $product->name }}"
                             class="rounded-3xl h-36 w-full object-cover md:col-span-2">
                        <div class="md:col-span-3 space-y-2">
                            <h3 class="text-2xl font-semibold">{{ $product->name }}</h3>
                            <p class="text-[var(--muted)]">
                                Rp {{ number_format($product->price_min) }} - Rp {{ number_format($product->price_max) }}/{{ $product->unit }}
                                @if (!empty($product->grade))
                                    - Grade {{ $product->grade }}
                                @endif
                            </p>
                            <a href="{{ route('produk.detail', $product) }}" class="text-sm font-semibold text-[var(--brand)]">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-sm text-[var(--muted)]">
                        Belum ada produk ditampilkan.
                    </div>
                @endforelse
            </div>
            </div>
        </section>

        <section class="py-14 border-t border-slate-200/80 bg-white/60 w-full" id="galeri">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 reveal">
                <h2 class="text-3xl sm:text-4xl font-bold mt-3">Gallery</h2>
                <p class="text-[var(--muted)] mt-2 text-lg">
                    Aktivitas harian dan kualitas telur UD. Ade Saputra Farm.
                </p>

                <div class="mt-8">
                    <div class="gallery-strip" id="galleryStrip">
                        <div class="gallery-item rounded-2xl overflow-hidden bg-white/60">
                            <img src="{{ asset('assets/ternakayam.jpg') }}" alt="Proses harian"
                                 class="h-56 w-full object-cover">
                        </div>
                        <div class="gallery-item rounded-2xl overflow-hidden bg-white/60">
                            <img src="{{ asset('assets/ternakayam1.jpg') }}" alt="Kualitas telur"
                                 class="h-56 w-full object-cover">
                        </div>
                        <div class="gallery-item rounded-2xl overflow-hidden bg-white/60">
                            <img src="{{ asset('assets/hero.jpg') }}" alt="Area farm"
                                 class="h-56 w-full object-cover">
                        </div>
                        <div class="gallery-item rounded-2xl overflow-hidden bg-white/60">
                            <img src="{{ asset('assets/ternakayam2.jpg') }}" alt="Penyortiran"
                                 class="h-56 w-full object-cover">
                        </div>
                        <div class="gallery-item rounded-2xl overflow-hidden bg-white/60">
                            <img src="{{ asset('assets/ternakayam3.jpg') }}" alt="Pengemasan"
                                 class="h-56 w-full object-cover">
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex justify-center gap-2" id="galleryDots">
                    <button type="button" class="gallery-dot" aria-label="Gallery 1"></button>
                    <button type="button" class="gallery-dot" aria-label="Gallery 2"></button>
                    <button type="button" class="gallery-dot" aria-label="Gallery 3"></button>
                    <button type="button" class="gallery-dot" aria-label="Gallery 4"></button>
                    <button type="button" class="gallery-dot" aria-label="Gallery 5"></button>
                </div>
            </div>
        </section>


        <section id="profil" class="py-16 border-t border-slate-200/80 w-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-10 items-center">
            <div class="space-y-4">
                <h2 class="text-3xl font-bold">Kenapa beli langsung di sini?</h2>
                <p class="text-[var(--muted)] text-lg">
                    Pembeli mendapatkan akses harga terkini, negosiasi terbuka, dan pengaturan distribusi
                    yang disesuaikan dengan kebutuhan.
                </p>
                <div class="grid gap-4 text-sm text-[var(--muted)]">
                    <div class="border-b border-slate-200 pb-4">
                        <p class="text-base font-semibold text-[var(--ink)]">Harga transparan</p>
                        <p class="mt-1">Semua penawaran bisa dilihat bersama.</p>
                    </div>
                    <div class="border-b border-slate-200 pb-4">
                        <p class="text-base font-semibold text-[var(--ink)]">Negosiasi cepat</p>
                        <p class="mt-1">Langsung di halaman negosiasi.</p>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-[var(--ink)]">Distribusi jelas</p>
                        <p class="mt-1">Jadwal dan lokasi tercatat rapi.</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-[#0f3d91] to-[#1d5bbf] rounded-3xl p-8 text-white">
                <h3 class="text-xl font-semibold">Profil Usaha</h3>
                <p class="text-white/80 mt-3">
                    UD. Ade Saputra Farm adalah UMKM peternakan telur yang berfokus pada kualitas produksi,
                    ketepatan distribusi, serta keterbukaan data harga untuk konsumen akhir.
                </p>
                <a href="{{ route('produk') }}"
                   class="inline-flex mt-6 px-5 py-2 rounded-full bg-white text-[var(--brand)] font-semibold hover:bg-white/90 transition">
                    Lihat Katalog Telur
                </a>
            </div>
            </div>
        </section>

        <section class="py-16 border-t border-slate-200/80 w-full" id="testimoni">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="testi-slab rounded-[2.5rem] px-8 py-10 lg:px-12 lg:py-14">
                    <div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-10 items-start">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between flex-wrap gap-3">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.35em] text-[var(--muted)]">Testimoni</p>
                                    <h2 class="text-3xl sm:text-4xl font-bold mt-2">Suara pembeli tentang UD. Ade Saputra Farm</h2>
                                </div>
                                @php
                                    $testimonialRatings = collect($testimonials ?? [])->pluck('rating')->filter()->map(fn ($value) => (int) $value);
                                    $testimonialCount = $testimonialRatings->count();
                                    $averageRating = $testimonialCount > 0 ? round($testimonialRatings->avg(), 1) : 0;
                                @endphp
                                <div class="flex items-center gap-3 text-sm text-[var(--muted)]">
                                    <span class="inline-flex items-center gap-2 rounded-full bg-white/80 border border-slate-200 px-3 py-1.5">
                                        <span class="text-base font-semibold text-[var(--brand)]">{{ number_format($averageRating, 1) }}</span>
                    Rata-rata
                                    </span>
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/80 border border-slate-200 px-3 py-1.5">
                                        <span class="text-base font-semibold text-[var(--brand)]">{{ $testimonialCount }}</span>
                    Total testimoni
                                    </span>
                    </div>
                            </div>
                            <div class="grid md:grid-cols-2 gap-6">
                                @forelse ($testimonials ?? [] as $t)
                                <div class="quote-card rounded-3xl p-6 transition">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-xs uppercase tracking-widest text-[var(--muted)]">{{ $t->role ?? 'Pembeli' }}</p>
                                            <p class="text-lg font-semibold mt-2 text-[var(--ink)]">{{ $t->name }}</p>
                                            @php
                                                $rating = (int) ($t->rating ?? 0);
                                            @endphp
                                            <div class="mt-2 flex items-center gap-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg viewBox="0 0 20 20"
                                                         class="h-4 w-4 {{ $i <= $rating ? 'text-amber-400' : 'text-slate-200' }}"
                                                         fill="currentColor"
                                                         aria-hidden="true">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.1 3.388a1 1 0 0 0 .95.69h3.565c.969 0 1.371 1.24.588 1.81l-2.884 2.095a1 1 0 0 0-.364 1.118l1.1 3.388c.3.921-.755 1.688-1.54 1.118l-2.884-2.095a1 1 0 0 0-1.175 0l-2.884 2.095c-.784.57-1.838-.197-1.539-1.118l1.1-3.388a1 1 0 0 0-.364-1.118L2.35 8.815c-.783-.57-.38-1.81.588-1.81h3.566a1 1 0 0 0 .95-.69l1.1-3.388Z"/>
                                                    </svg>
                                                @endfor
                                                <span class="text-xs text-[var(--muted)] ml-1">{{ $rating }}/5</span>
                    </div>
                                        </div>
                                        <div class="quote-mark text-[var(--brand)]" aria-hidden="true">&ldquo;</div>
                                    </div>
                                    <p class="text-sm text-[var(--muted)] mt-3 leading-relaxed">{{ $t->message }}</p>
                                </div>
                                @empty
                                <div class="quote-card rounded-3xl p-6 transition">
                                    <p class="text-sm text-[var(--muted)]">Belum ada testimoni yang ditampilkan.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="form-shell rounded-3xl p-6 shadow-xl">
                            <p class="text-xs uppercase tracking-[0.3em] text-white/70">Tulis Testimoni</p>
                            <h3 class="text-2xl font-semibold mt-2">Bagikan pengalamanmu</h3>
                            <p class="text-sm text-white/70 mt-2">
                                Isi form berikut agar testimoni kamu bisa tampil di halaman ini.
                            </p>
                            @if (session('success'))
                                <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs text-emerald-700">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @auth
                                <form class="mt-6 grid gap-4" method="post" action="{{ route('testimonials.store') }}">
                                    @csrf
                                    <div>
                                        <label class="text-xs font-semibold text-white/80">Peran/Usaha</label>
                                        <input type="text" name="role" value="{{ old('role') }}" placeholder="Contoh: Warung Makan"
                                               class="mt-2 w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30">
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-white/80">Rating</label>
                                        <select name="rating" class="mt-2 w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white/30">
                                            <option value="5" @selected(old('rating') == 5)>5 - Sangat puas</option>
                                            <option value="4" @selected(old('rating') == 4)>4 - Puas</option>
                                            <option value="3" @selected(old('rating') == 3)>3 - Cukup</option>
                                            <option value="2" @selected(old('rating') == 2)>2 - Kurang</option>
                                            <option value="1" @selected(old('rating') == 1)>1 - Kecewa</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-white/80">Testimoni</label>
                                        <textarea rows="4" name="message" placeholder="Tulis pengalamanmu di sini..."
                                                  class="mt-2 w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30">{{ old('message') }}</textarea>
                                    </div>
                                    <button type="submit"
                                            class="w-full rounded-full bg-white text-[var(--brand)] px-5 py-3 text-sm font-semibold hover:bg-white/90 transition">
                                        Kirim Testimoni
                                    </button>
                                    <p class="text-xs text-white/60">
                                        Testimoni akan tampil setelah disetujui admin.
                                    </p>
                                </form>
                            @else
                                <div class="mt-6 rounded-2xl border border-white/15 bg-white/10 px-4 py-4 text-sm text-white/80">
                                    Login dulu untuk mengisi testimoni.
                                    <a href="{{ route('login') }}" class="text-white underline font-semibold">Login di sini</a>.
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 border-t border-slate-200/80 bg-white/60 w-full" id="contact">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="text-center space-y-3">
                    <h2 class="text-3xl sm:text-4xl font-bold">Contact</h2>
                </div>

                <div class="mt-10">
                <div class="rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/70 bg-white">
                    <div class="aspect-[16/7] w-full">
                        <iframe
                            title="Google Maps UD. Ade Saputra Farm"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4878.781846080625!2d112.7805477!3d-7.849893400000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd62d0050889509%3A0xaa5fd49b6d349a35!2sUD.ADESAputra%20farm!5e1!3m2!1sid!2sid!4v1769071772478!5m2!1sid!2sid"
                            class="h-full w-full"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <div class="mt-10 grid md:grid-cols-2 gap-6">
                    <div class="flex items-center gap-4 border border-slate-200 rounded-2xl p-5 bg-white/80">
                        <div class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center text-[var(--brand)]">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 21s6-5.25 6-10a6 6 0 1 0-12 0c0 4.75 6 10 6 10Z"/>
                                <circle cx="12" cy="11" r="2.25"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-[var(--muted)]">Address</p>
                            <p class="font-semibold text-[var(--ink)]">
                                Jl. Dusun Rojopasang, Juranglondo, Gerbo, Kec. Purwodadi, Kab. Pasuruan, Prov. Jawa Timur.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 border border-slate-200 rounded-2xl p-5 bg-white/80">
                        <div class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center text-[var(--brand)]">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M4 5h16a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H9l-5 4v-4H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-[var(--muted)]">WhatsApp</p>
                            <a href="https://wa.me/6281230384757" class="font-semibold text-[var(--brand)]">
                                0812-3038-4757                                                                                                                                                       
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 border border-slate-200 rounded-2xl p-5 bg-white/80">
                        <div class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center text-[var(--brand)]">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="8"/>
                                <path d="M12 8v4l3 2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-[var(--muted)]">Opening Hours</p>
                            <p class="font-semibold text-[var(--ink)]">07.00 - 20.00</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 border border-slate-200 rounded-2xl p-5 bg-white/80">
                        <div class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center text-[var(--brand)]">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M7 17L17 7"/>
                                <path d="M7 7h10v10"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-[var(--muted)]">Directions</p>
                            <a href="https://maps.app.goo.gl/ewZdyMyoPFn3VgRk7"
                               target="_blank"
                               class="font-semibold text-[var(--brand)]">
                                Lihat rute terbaik
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="https://maps.app.goo.gl/ewZdyMyoPFn3VgRk7"
                       target="_blank"
                       class="px-6 py-3 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                        Buka Google Maps
                    </a>
                    <a href="https://wa.me/6281230384757"
                       class="px-6 py-3 rounded-full bg-emerald-500 text-white text-sm font-semibold hover:bg-emerald-600 transition">
                        Chat WhatsApp
                    </a>
                </div>
                </div>
            </div>
        </section>

        <section class="py-14 sm:py-16 border-t border-slate-200/80 w-full" id="developer">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="relative overflow-hidden rounded-[3rem] bg-gradient-to-br from-[#0f3d91] via-[#1d4ed8] to-[#0b244f] text-white shadow-[0_40px_80px_rgba(15,61,145,0.35)]">
                    <div class="absolute -top-24 -right-24 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="absolute -bottom-24 -left-20 h-72 w-72 rounded-full bg-emerald-200/10 blur-3xl"></div>
                    <div class="relative grid lg:grid-cols-[0.95fr_1.05fr] gap-6 p-8 lg:p-12 items-start">
                        <div class="space-y-6">
                            <p class="text-xs uppercase tracking-[0.35em] text-white/70">DEVELOPER NEXTCHAIN</p>
                            <h2 class="text-3xl sm:text-4xl font-bold">Tim Pengembang NEXTCHAIN</h2>
                            <p class="text-sm text-white/80 max-w-md leading-relaxed">
                                Mahasiswa Universitas Muhammadiyah Malang menghadirkan NEXTCHAIN untuk UD. Ade Saputra Farm :
                                platform digital generasi baru yang menyatukan katalog produk, negosiasi harga, dan alur transaksi
                                terintegrasi agar pemesanan lebih cepat, transparan, dan memangkas rantai distribusi antara peternak
                                dengan konsumen.
                            </p>
                            <div class="inline-flex items-center gap-3 rounded-full bg-white/10 border border-white/20 px-4 py-2 text-xs">
                                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    PKM-PI Universitas Muhammadiyah Malang 2026
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2 max-w-2xl lg:max-w-none">
                            <div class="dev-card w-full rounded-2xl bg-white/10 p-5 backdrop-blur">
                                <div class="flex items-center gap-4">
                                    <div class="relative h-14 w-14 shrink-0">
                                        <div class="absolute inset-0 rounded-full bg-white/15 ring-1 ring-white/20"></div>
                                        <img src="{{ asset('assets/dospempkm.jpg') }}" alt="Nama Developer 1" class="h-14 w-14 rounded-full object-cover ring-1 ring-white/30" onerror="this.remove();">
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold leading-snug">Rinaldy Achmad Roberth Fathoni S.AB., M.M</p>
                                        <p class="text-xs text-white/70">Dosen Pembimbing</p>
                                    </div>
                                </div>
                            </div>
                            <div class="dev-card w-full rounded-2xl bg-white/10 p-5 backdrop-blur">
                                <div class="flex items-center gap-4">
                                    <div class="relative h-14 w-14 shrink-0">
                                        <div class="absolute inset-0 rounded-full bg-white/15 ring-1 ring-white/20"></div>
                                        <img src="{{ asset('assets/wahyu.jpg') }}" alt="Nama Developer 2" class="h-14 w-14 rounded-full object-cover ring-1 ring-white/30" onerror="this.remove();">
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold leading-snug">Wahyu Firmansyah</p>
                                        <p class="text-xs text-white/70">Ketua Tim</p>
                                    </div>
                                </div>
                            </div>
                            <div class="dev-card w-full rounded-2xl bg-white/10 p-5 backdrop-blur">
                                <div class="flex items-center gap-4">
                                    <div class="relative h-14 w-14 shrink-0">
                                        <div class="absolute inset-0 rounded-full bg-white/15 ring-1 ring-white/20"></div>
                                        <img src="{{ asset('assets/aisyah.jpg') }}" alt="Nama Developer 3" class="h-14 w-14 rounded-full object-cover ring-1 ring-white/30" onerror="this.remove();">
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold leading-snug">Aisyah Putri Permata Sari</p>
                                        <p class="text-xs text-white/70">Anggota Tim</p>
                                    </div>
                                </div>
                            </div>
                            <div class="dev-card w-full rounded-2xl bg-white/10 p-5 backdrop-blur">
                                <div class="flex items-center gap-4">
                                    <div class="relative h-14 w-14 shrink-0">
                                        <div class="absolute inset-0 rounded-full bg-white/15 ring-1 ring-white/20"></div>
                                        <img src="{{ asset('assets/amel.jpg') }}" alt="Nama Developer 4" class="h-14 w-14 rounded-full object-cover ring-1 ring-white/30" onerror="this.remove();">
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold leading-snug">Azhubah Rizki Amalia</p>
                                        <p class="text-xs text-white/70">Anggota Tim</p>
                                    </div>
                                </div>
                            </div>
                            <div class="dev-card w-full rounded-2xl bg-white/10 p-5 backdrop-blur">
                                <div class="flex items-center gap-4">
                                    <div class="relative h-14 w-14 shrink-0">
                                        <div class="absolute inset-0 rounded-full bg-white/15 ring-1 ring-white/20"></div>
                                        <img src="{{ asset('assets/dafa.jpg') }}" alt="Nama Developer 5" class="h-14 w-14 rounded-full object-cover ring-1 ring-white/30" onerror="this.remove();">
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold leading-snug">Rizqullah Atsir Dafa Childyasa Nusa</p>
                                        <p class="text-xs text-white/70">Anggota Tim</p>
                                    </div>
                                </div>
                            </div>
                            <div class="dev-card w-full rounded-2xl bg-white/10 p-5 backdrop-blur">
                                <div class="flex items-center gap-4">
                                    <div class="relative h-14 w-14 shrink-0">
                                        <div class="absolute inset-0 rounded-full bg-white/15 ring-1 ring-white/20"></div>
                                        <img src="{{ asset('assets/arum.jpg') }}" alt="Nama Developer 6" class="h-14 w-14 rounded-full object-cover ring-1 ring-white/30" onerror="this.remove();">
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold leading-snug">Ayesha Fahrelia Ningrum</p>
                                        <p class="text-xs text-white/70">Anggota Tim</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="mt-16 border-t border-white/10 bg-[var(--brand)] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 grid md:grid-cols-3 gap-8 text-sm text-white/80">
            <div class="space-y-3">
                <p class="text-lg font-semibold text-white">NEXTCHAIN</p>
                <p>
                    UMKM peternakan telur UD. Ade Saputra Farm dengan negosiasi terbuka dan distribusi jelas.
                </p>
            </div>
            <div class="space-y-3">
                <p class="text-base font-semibold text-white">Menu</p>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                    <a href="{{ route('produk') }}" class="hover:text-white">Produk</a>
                    <a href="{{ route('negosiasi.list') }}" class="hover:text-white">Negosiasi</a>
                    <a href="#contact" class="hover:text-white">Contact</a>
                </div>
            </div>
            <div class="space-y-3">
                <p class="text-base font-semibold text-white">Kontak</p>
                <p>Jl. Dusun Rojopasang, Juranglondo, Gerbo, Kec. Purwodadi, Kab. Pasuruan, Prov. Jawa Timur.</p>
                <a href="https://wa.me/6281230384757" class="hover:text-white">WhatsApp: 0812-3038-4757</a>
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

        const navLinks = Array.from(document.querySelectorAll('nav .nav-link'));
        const sectionTargets = navLinks
            .map((link) => document.querySelector(link.getAttribute('href')))
            .filter(Boolean);

        function setActiveLink(activeId) {
            navLinks.forEach((link) => {
                const isActive = link.getAttribute('href') === `#${activeId}`;
                link.classList.toggle('border-b-2', isActive);
                link.classList.toggle('border-white/80', isActive);
                link.classList.toggle('pb-0.5', isActive);
            });
        }

        let ticking = false;
        function updateActiveOnScroll() {
            if (!sectionTargets.length) return;
            const offset = 120;
            let currentId = sectionTargets[0].id;

            sectionTargets.forEach((section) => {
                const rect = section.getBoundingClientRect();
                if (rect.top - offset <= 0) {
                    currentId = section.id;
                }
            });

            setActiveLink(currentId);
            ticking = false;
        }

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(updateActiveOnScroll);
                ticking = true;
            }
        });

        updateActiveOnScroll();

        const galleryStrip = document.getElementById('galleryStrip');
        const galleryItems = Array.from(galleryStrip.querySelectorAll('.gallery-item'));
        const galleryDots = Array.from(document.getElementById('galleryDots').children);
        let isDragging = false;
        let startX = 0;
        let scrollLeft = 0;
        let dragged = false;

        function setActiveGallery(index) {
            galleryItems.forEach((item, i) => item.classList.toggle('is-active', i === index));
            galleryDots.forEach((dot, i) => dot.classList.toggle('is-active', i === index));
        }

        galleryDots.forEach((dot, index) => {
            dot.addEventListener('click', (event) => {
                event.preventDefault();
                const target = galleryItems[index];
                const offset = target.offsetLeft - (galleryStrip.clientWidth / 2) + (target.clientWidth / 2);
                galleryStrip.scrollTo({ left: offset, behavior: 'smooth' });
                setActiveGallery(index);
            });
        });

        galleryStrip.addEventListener('scroll', () => {
            const stripRect = galleryStrip.getBoundingClientRect();
            const center = stripRect.left + stripRect.width / 2;
            let activeIndex = 0;
            let closest = Infinity;

            galleryItems.forEach((item, i) => {
                const rect = item.getBoundingClientRect();
                const itemCenter = rect.left + rect.width / 2;
                const distance = Math.abs(center - itemCenter);
                if (distance < closest) {
                    closest = distance;
                    activeIndex = i;
                }
            });

            setActiveGallery(activeIndex);
        });

        setActiveGallery(0);

        galleryStrip.addEventListener('pointerdown', (event) => {
            isDragging = true;
            startX = event.clientX;
            scrollLeft = galleryStrip.scrollLeft;
            dragged = false;
            galleryStrip.setPointerCapture(event.pointerId);
        });

        galleryStrip.addEventListener('pointermove', (event) => {
            if (!isDragging) return;
            const walk = startX - event.clientX;
            if (Math.abs(walk) > 10) dragged = true;
            galleryStrip.scrollLeft = scrollLeft + walk;
        });

        galleryStrip.addEventListener('pointerup', (event) => {
            isDragging = false;
            galleryStrip.releasePointerCapture(event.pointerId);

            if (!dragged) {
                const item = event.target.closest('.gallery-item');
                if (!item) return;
                const index = galleryItems.indexOf(item);
                const offset = item.offsetLeft - (galleryStrip.clientWidth / 2) + (item.clientWidth / 2);
                galleryStrip.scrollTo({ left: offset, behavior: 'smooth' });
                setActiveGallery(index);
            }
        });

        galleryStrip.addEventListener('pointerleave', () => {
            isDragging = false;
        });

        galleryItems.forEach((item) => {
            item.addEventListener('click', (event) => {
                event.preventDefault();
            });
        });

        const devCards = Array.from(document.querySelectorAll('.dev-card'));
        devCards.forEach((card) => {
            card.addEventListener('click', () => {
                card.classList.add('is-pressed');
                setTimeout(() => card.classList.remove('is-pressed'), 180);
            });
        });
    </script>
    <a href="#top" class="lg:hidden fixed bottom-6 right-6 z-40 inline-flex h-11 w-11 items-center justify-center rounded-full bg-[#0f3d91] text-white shadow-lg shadow-blue-900/30 hover:bg-[#0a2d6c] transition" aria-label="Kembali ke atas">
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 14l6-6 6 6" />
        </svg>
    </a></body>
</html>





























