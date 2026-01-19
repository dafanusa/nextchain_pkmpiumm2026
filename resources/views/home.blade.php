<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>NEXTCHAIN - Home</title>

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

<body>
    <header class="sticky top-0 z-50 bg-[var(--brand)] text-white">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">
                NEXTCHAIN
            </a>

            <nav class="hidden md:flex items-center gap-5 text-sm font-medium text-white/80">
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
                <a href="{{ route('produk') }}"
                   class="hidden sm:inline-flex items-center px-4 py-2 rounded-full bg-white text-[var(--brand)] text-sm font-semibold hover:bg-slate-100 transition">
                    Lihat Produk
                </a>
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

        <div id="mobileMenu" class="md:hidden fixed top-16 left-0 right-0 z-40 px-6 pb-4 space-y-2 text-sm text-white/90 bg-[var(--brand)] mobile-menu transition-all duration-300 ease-out max-h-0 opacity-0 -translate-y-2 pointer-events-none overflow-hidden">
            <a href="#home" class="block">Home</a>
            <a href="{{ route('produk') }}" class="block">Produk</a>
            <a href="{{ route('cart') }}" class="block">Keranjang</a>
            <a href="{{ route('negosiasi.list') }}" class="block">Negosiasi</a>
            <a href="#tentang" class="block">Tentang</a>
            <a href="#galeri" class="block">Galeri</a>
            <a href="#testimoni" class="block">Testimoni</a>
            <a href="#contact" class="block">Contact</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6">
        <section class="pt-14 pb-16 grid lg:grid-cols-2 gap-10 items-center" id="home">
            <div class="space-y-6 fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full soft-panel text-xs font-semibold text-[var(--brand)]">
                    UMKM Peternakan Telur - UD. AdeSaputra Farm
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
                    Telur segar langsung dari farm, harga lebih terbuka dan mudah dinegosiasikan.
                </h1>
                <p class="text-[var(--muted)] text-lg max-w-xl">
                    Semua produk di website ini milik UD. AdeSaputra Farm. Pembeli bisa melihat katalog,
                    melihat penawaran terbuka, dan menyepakati distribusi tanpa perantara.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('produk') }}"
                       class="px-6 py-3 rounded-full bg-[var(--brand)] text-white font-semibold hover:bg-[var(--brand-dark)] transition">
                        Lihat Produk UMKM
                    </a>
                    <a href="{{ route('negosiasi.list') }}"
                       class="px-6 py-3 rounded-full border border-gray-200 font-semibold text-[var(--ink)] hover:border-[var(--brand)] transition">
                        Daftar Negosiasi
                    </a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 pt-6">
                    <div class="bg-white rounded-2xl p-4 stat-card shadow-sm">
                        <p class="text-xs text-[var(--muted)]">Stok Harian</p>
                        <p class="text-xl font-semibold">1.000+ kg</p>
                    </div>
                    <div class="bg-white rounded-2xl p-4 stat-card shadow-sm">
                        <p class="text-xs text-[var(--muted)]">Harga Update</p>
                        <p class="text-xl font-semibold">Setiap 3 menit</p>
                    </div>
                    <div class="bg-white rounded-2xl p-4 stat-card shadow-sm">
                        <p class="text-xs text-[var(--muted)]">Distribusi</p>
                        <p class="text-xl font-semibold">Fleksibel</p>
                    </div>
                </div>
            </div>

            <div class="relative fade-up">
                <div class="absolute -top-6 -left-6 w-24 h-24 rounded-2xl bg-[var(--accent)]/20 blur-xl"></div>
                <div class="absolute -bottom-8 -right-6 w-32 h-32 rounded-full bg-[var(--mint)]/20 blur-2xl"></div>
                <div class="grid gap-4">
                    <div class="bg-white rounded-[2rem] p-4 shadow-2xl float-slow">
                        <img src="{{ asset('assets/hero.jpg') }}" alt="UD. AdeSaputra Farm" class="rounded-[1.5rem] w-full object-cover">
                    </div>
                    <div class="soft-panel rounded-[2rem] p-5 shadow-lg flex items-center justify-between">
                        <div>
                            <p class="text-xs text-[var(--muted)]">Harga hari ini</p>
                            <p class="text-2xl font-bold text-[var(--brand)]">Rp 26.000 - Rp 28.000/kg</p>
                            <p class="text-xs text-[var(--muted)] mt-1">Grade A - update real-time</p>
                        </div>
                        <img src="{{ asset('assets/ternakayam.jpg') }}" alt="Telur segar"
                             class="w-20 h-20 rounded-2xl object-cover border border-white">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 border-t border-slate-200/80 bg-white/60 w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw]" id="tentang">
            <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-10 items-center">
                <div class="space-y-6">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 text-xs font-semibold text-[var(--brand)]">
                        Profil UMKM
                    </span>
                    <h2 class="text-4xl font-bold">UD. AdeSaputra Farm</h2>
                    <p class="text-[var(--muted)] text-lg">
                        UMKM peternakan telur yang fokus pada kualitas produksi dan keterbukaan harga.
                        NEXTCHAIN membantu pembeli berinteraksi langsung dengan peternak tanpa perantara.
                    </p>
                    <div class="grid sm:grid-cols-2 gap-5 pt-2 text-sm text-[var(--muted)]">
                        <div>
                            <p class="uppercase text-xs tracking-wider text-[var(--brand)]">Fokus</p>
                            <p class="mt-2 text-base font-semibold text-[var(--ink)]">Telur segar berkualitas</p>
                            <p class="mt-1">Produksi diawasi setiap hari.</p>
                        </div>
                        <div>
                            <p class="uppercase text-xs tracking-wider text-[var(--brand)]">Transparansi</p>
                            <p class="mt-2 text-base font-semibold text-[var(--ink)]">Harga terbuka</p>
                            <p class="mt-1">Penawaran bisa dilihat bersama.</p>
                        </div>
                        <div>
                            <p class="uppercase text-xs tracking-wider text-[var(--brand)]">Distribusi</p>
                            <p class="mt-2 text-base font-semibold text-[var(--ink)]">Terjadwal dan fleksibel</p>
                            <p class="mt-1">Pickup farm atau pengiriman.</p>
                        </div>
                        <div>
                            <p class="uppercase text-xs tracking-wider text-[var(--brand)]">Kapasitas</p>
                            <p class="mt-2 text-base font-semibold text-[var(--ink)]">Skala UMKM</p>
                            <p class="mt-1">Siap untuk kebutuhan grosir.</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -top-8 -left-8 h-28 w-28 rounded-full bg-[var(--accent)]/20 blur-2xl"></div>
                    <div class="absolute -bottom-10 -right-8 h-36 w-36 rounded-full bg-[var(--mint)]/20 blur-2xl"></div>
                    <div class="grid grid-cols-2 gap-4">
                        <img src="{{ asset('assets/ternakayam.jpg') }}" alt="Produksi telur"
                             class="rounded-3xl h-56 w-full object-cover">
                        <img src="{{ asset('assets/ternakayam1.jpg') }}" alt="Kualitas telur"
                             class="rounded-3xl h-56 w-full object-cover mt-8">
                        <div class="col-span-2 bg-gradient-to-r from-[#0f3d91] to-[#1d5bbf] rounded-3xl p-6 text-white">
                            <p class="text-xs text-white/70">Harga hari ini</p>
                            <p class="text-2xl font-semibold mt-2">Rp 26.000 - Rp 28.000/kg</p>
                            <p class="text-xs text-white/70 mt-1">Grade A, update real-time</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 border-t border-slate-200/80 w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw]" id="produk-unggulan">
            <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <h2 class="text-3xl font-bold">Produk Unggulan UMKM</h2>
                <a href="{{ route('produk') }}" class="text-sm font-semibold text-[var(--brand)]">Lihat semua produk</a>
            </div>
            <div class="mt-6 divide-y divide-slate-200">
                <div class="py-6 grid md:grid-cols-5 gap-6 items-center">
                    <img src="{{ asset('assets/ternakayam.jpg') }}" alt="Telur Grade A" class="rounded-3xl h-36 w-full object-cover md:col-span-2">
                    <div class="md:col-span-3 space-y-2">
                        <h3 class="text-2xl font-semibold">Telur Ayam Ras Grade A</h3>
                        <p class="text-[var(--muted)]">Rp 26.000 - Rp 28.000/kg - kualitas premium.</p>
                        <a href="{{ route('produk.detail', 1) }}" class="text-sm font-semibold text-[var(--brand)]">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                <div class="py-6 grid md:grid-cols-5 gap-6 items-center">
                    <img src="{{ asset('assets/ternakayam1.jpg') }}" alt="Telur Grade B" class="rounded-3xl h-36 w-full object-cover md:col-span-2">
                    <div class="md:col-span-3 space-y-2">
                        <h3 class="text-2xl font-semibold">Telur Ayam Ras Grade B</h3>
                        <p class="text-[var(--muted)]">Rp 23.000 - Rp 25.000/kg - ideal untuk volume besar.</p>
                        <a href="{{ route('produk.detail', 2) }}" class="text-sm font-semibold text-[var(--brand)]">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                <div class="py-6 grid md:grid-cols-5 gap-6 items-center">
                    <img src="{{ asset('assets/ternakayam2.jpg') }}" alt="Telur Omega" class="rounded-3xl h-36 w-full object-cover md:col-span-2">
                    <div class="md:col-span-3 space-y-2">
                        <h3 class="text-2xl font-semibold">Telur Omega</h3>
                        <p class="text-[var(--muted)]">Rp 30.000 - Rp 33.000/kg - nutrisi lebih tinggi.</p>
                        <a href="{{ route('produk.detail', 3) }}" class="text-sm font-semibold text-[var(--brand)]">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </section>

        <section class="py-14 border-t border-slate-200/80 bg-white/60 w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw]" id="galeri">
            <div class="max-w-7xl mx-auto px-6 reveal">
                <h2 class="text-3xl sm:text-4xl font-bold mt-3">Gallery</h2>
                <p class="text-[var(--muted)] mt-2 text-lg">
                    Aktivitas harian dan kualitas telur UD. AdeSaputra Farm.
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


        <section id="profil" class="py-16 border-t border-slate-200/80 w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw]">
            <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-10 items-center">
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
                    UD. AdeSaputra Farm adalah UMKM peternakan telur yang berfokus pada kualitas produksi,
                    ketepatan distribusi, serta keterbukaan data harga untuk konsumen akhir.
                </p>
                <a href="{{ route('produk') }}"
                   class="inline-flex mt-6 px-5 py-2 rounded-full bg-white text-[var(--brand)] font-semibold hover:bg-white/90 transition">
                    Lihat Katalog Telur
                </a>
            </div>
            </div>
        </section>

        <section class="py-16 border-t border-slate-200/80 w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw]" id="testimoni">
            <div class="max-w-7xl mx-auto px-6">
                <div class="testi-slab rounded-[2.5rem] px-8 py-10 lg:px-12 lg:py-14">
                    <div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-10 items-start">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between flex-wrap gap-3">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.35em] text-[var(--muted)]">Testimoni</p>
                                    <h2 class="text-3xl sm:text-4xl font-bold mt-2">Suara pembeli tentang UD. AdeSaputra Farm</h2>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-[var(--muted)]">
                                    <span class="inline-flex items-center gap-2 rounded-full bg-white/80 border border-slate-200 px-3 py-1.5">
                                        <span class="text-base font-semibold text-[var(--brand)]">4.9</span>
                                        Rata-rata
                                    </span>
                                    <span class="inline-flex items-center gap-2 rounded-full bg-white/80 border border-slate-200 px-3 py-1.5">
                                        <span class="text-base font-semibold text-[var(--brand)]">78%</span>
                                        Order ulang
                                    </span>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 gap-6">
                                @foreach ([
                                    ['name' => 'Hadi', 'role' => 'Warung Makan', 'text' => 'Harga jelas, nego cepat, pengiriman tepat waktu.'],
                                    ['name' => 'Alya', 'role' => 'Reseller Telur', 'text' => 'Stok konsisten dan kualitasnya rapi.'],
                                    ['name' => 'Rizki', 'role' => 'Katering', 'text' => 'Negosiasi mudah, jadwal distribusi fleksibel.'],
                                    ['name' => 'Salsa', 'role' => 'Toko Sembako', 'text' => 'Transparan, harga update real-time, respon cepat.'],
                                ] as $t)
                                <div class="quote-card rounded-3xl p-6 transition">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-xs uppercase tracking-widest text-[var(--muted)]">{{ $t['role'] }}</p>
                                            <p class="text-lg font-semibold mt-2 text-[var(--ink)]">{{ $t['name'] }}</p>
                                        </div>
                                        <div class="quote-mark text-[var(--brand)]">“</div>
                                    </div>
                                    <p class="text-sm text-[var(--muted)] mt-3 leading-relaxed">{{ $t['text'] }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-shell rounded-3xl p-6 shadow-xl">
                            <p class="text-xs uppercase tracking-[0.3em] text-white/70">Tulis Testimoni</p>
                            <h3 class="text-2xl font-semibold mt-2">Bagikan pengalamanmu</h3>
                            <p class="text-sm text-white/70 mt-2">
                                Isi form berikut agar testimoni kamu bisa tampil di halaman ini.
                            </p>
                            <form class="mt-6 grid gap-4" onsubmit="return false;">
                                <div>
                                    <label class="text-xs font-semibold text-white/80">Nama</label>
                                    <input type="text" placeholder="Nama lengkap"
                                           class="mt-2 w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-white/80">Peran/Usaha</label>
                                    <input type="text" placeholder="Contoh: Warung Makan"
                                           class="mt-2 w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-white/80">Rating</label>
                                    <select class="mt-2 w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white/30">
                                        <option value="5">5 - Sangat puas</option>
                                        <option value="4">4 - Puas</option>
                                        <option value="3">3 - Cukup</option>
                                        <option value="2">2 - Kurang</option>
                                        <option value="1">1 - Kecewa</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-white/80">Testimoni</label>
                                    <textarea rows="4" placeholder="Tulis pengalamanmu di sini..."
                                              class="mt-2 w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30"></textarea>
                                </div>
                                <button type="submit"
                                        class="w-full rounded-full bg-white text-[var(--brand)] px-5 py-3 text-sm font-semibold hover:bg-white/90 transition">
                                    Kirim Testimoni
                                </button>
                                <p class="text-xs text-white/60">
                                    Form ini simulasi. Data belum tersimpan ke database.
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 border-t border-slate-200/80 bg-white/60 w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw]" id="contact">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center space-y-3">
                    <h2 class="text-3xl sm:text-4xl font-bold">Contact</h2>
                </div>

                <div class="mt-10">
                <div class="rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/70 bg-white">
                    <div class="aspect-[16/7] w-full">
                        <iframe
                            title="Google Maps UD. AdeSaputra Farm"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.099997818247!2d112.597003!3d-7.9217!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78827c2b7c2e4b%3A0x9f3c5f3a9b4c3a6a!2sUniversitas%20Muhammadiyah%20Malang!5e0!3m2!1sen!2sid!4v1710000000000"
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
                        <div class="h-12 w-12 rounded-full bg-red-50 flex items-center justify-center text-red-500 font-bold">
                            📍
                        </div>
                        <div>
                            <p class="text-sm text-[var(--muted)]">Address</p>
                            <p class="font-semibold text-[var(--ink)]">
                                Pasuruan Jl. Delima Desa Pakukerto, Kec. KarangPlosos, Kab. Pasuruan
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 border border-slate-200 rounded-2xl p-5 bg-white/80">
                        <div class="h-12 w-12 rounded-full bg-green-50 flex items-center justify-center text-green-600 font-bold">
                            WA
                        </div>
                        <div>
                            <p class="text-sm text-[var(--muted)]">WhatsApp</p>
                            <a href="https://wa.me/6281247889969" class="font-semibold text-[var(--brand)]">
                                0812-4788-9969
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 border border-slate-200 rounded-2xl p-5 bg-white/80">
                        <div class="h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold">
                            ⏰
                        </div>
                        <div>
                            <p class="text-sm text-[var(--muted)]">Opening Hours</p>
                            <p class="font-semibold text-[var(--ink)]">07.00 - 20.00</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 border border-slate-200 rounded-2xl p-5 bg-white/80">
                        <div class="h-12 w-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 font-bold">
                            ⇢
                        </div>
                        <div>
                            <p class="text-sm text-[var(--muted)]">Directions</p>
                            <a href="https://maps.google.com/?q=Universitas+Muhammadiyah+Malang"
                               target="_blank"
                               class="font-semibold text-[var(--brand)]">
                                Lihat rute terbaik
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="https://maps.google.com/?q=Universitas+Muhammadiyah+Malang"
                       target="_blank"
                       class="px-6 py-3 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                        Buka Google Maps
                    </a>
                    <a href="https://wa.me/6281247889969"
                       class="px-6 py-3 rounded-full border border-gray-200 text-sm font-semibold hover:border-[var(--brand)] transition">
                        Chat WhatsApp
                    </a>
                </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="mt-16 border-t border-white/10 bg-[var(--brand)] text-white">
        <div class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-8 text-sm text-white/80">
            <div class="space-y-3">
                <p class="text-lg font-semibold text-white">NEXTCHAIN</p>
                <p>
                    UMKM peternakan telur UD. AdeSaputra Farm dengan negosiasi terbuka dan distribusi jelas.
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
                <p>Pasuruan Jl. Delima Desa Pakukerto, Kec. KarangPlosos, Kab. Pasuruan</p>
                <a href="https://wa.me/6281247889969" class="hover:text-white">WhatsApp: 0812-4788-9969</a>
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
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('max-h-0');
                mobileMenu.classList.toggle('opacity-0');
                mobileMenu.classList.toggle('-translate-y-2');
                mobileMenu.classList.toggle('pointer-events-none');
                mobileMenu.classList.toggle('max-h-96');
                mobileMenu.classList.toggle('opacity-100');
                mobileMenu.classList.toggle('translate-y-0');
                mobileMenu.classList.toggle('pointer-events-auto');
            });
        }

        const cartKey = 'nextchain_cart';
        const cartCounts = Array.from(document.querySelectorAll('.cart-count'));
        function getCartItems() {
            try {
                return JSON.parse(localStorage.getItem(cartKey)) || [];
            } catch {
                return [];
            }
        }
        function updateCartBadge() {
            const count = getCartItems().reduce((sum, item) => sum + Number(item.qty || 0), 0);
            cartCounts.forEach((badge) => {
                badge.textContent = count;
                badge.classList.toggle('hidden', count === 0);
            });
        }
        updateCartBadge();
        window.addEventListener('storage', updateCartBadge);

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
    </script>
</body>
</html>




