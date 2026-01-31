<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Produk - NEXTCHAIN</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');

        :root {
            --ink: #0b1b32;
            --muted: #4b5563;
            --brand: #0f3d91;
            --brand-dark: #0a2d6c;
            --bg: #f6f8fc;
            --accent: #f59e0b;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(900px 400px at 90% -10%, #dbeafe 0%, rgba(219, 234, 254, 0) 60%),
                var(--bg);
        }

        .card-glow:hover {
            box-shadow: 0 30px 60px rgba(15, 61, 145, 0.18);
            transform: translateY(-6px);
        }

        .pulse-dot {
            position: relative;
        }
        .pulse-dot::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: var(--accent);
            transform: translate(-50%, -50%);
            box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4);
            animation: pulse 1.8s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
            70% { box-shadow: 0 0 0 12px rgba(245, 158, 11, 0); }
            100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }
    </style>
</head>

<body>
    @include('loading-overlay')
    <div id="top"></div>
    <header class="sticky top-0 z-50 bg-[var(--brand)] text-white h-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">
                NEXTCHAIN
            </a>
            <nav class="hidden md:flex items-center gap-5 text-sm font-medium text-white/80">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <a href="{{ route('produk') }}" class="text-white border-b-2 border-white/80 pb-0.5">Produk</a>
                <a href="{{ route('negosiasi.list') }}" class="hover:text-white">Negosiasi</a>
                <a href="{{ route('home') }}#tentang" class="hover:text-white">Tentang</a>
                <a href="{{ route('home') }}#galeri" class="hover:text-white">Galeri</a>
                <a href="{{ route('home') }}#testimoni" class="hover:text-white">Testimoni</a>
                <a href="{{ route('home') }}#contact" class="hover:text-white">Contact</a>
            </nav>
            <a href="{{ route('home') }}"
               class="hidden sm:inline-flex items-center px-4 py-2 rounded-full bg-white text-[var(--brand)] text-sm font-semibold hover:bg-slate-100 transition">
                Kembali ke Home
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
            <div>
                <h1 class="text-4xl font-bold">Katalog Telur</h1>
                <p class="text-[var(--muted)] mt-2 max-w-2xl">
                    Produk telur dari UD. Ade Saputra Farm dengan harga real-time dan opsi negosiasi digital.
                    Pilih produk untuk melihat detail dan ajukan tawaran.
                </p>
            </div>
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white shadow text-sm">
                <span class="pulse-dot w-3 h-3"></span>
                Harga diperbarui real-time
            </div>
        </div>

        <section class="mt-10 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $id => $product)
            <div class="bg-white rounded-3xl overflow-hidden shadow-lg card-glow transition">
                <div class="relative">
                    <img src="{{ asset('assets/' . $product['image']) }}"
                         alt="{{ $product['name'] }}"
                         class="h-48 w-full object-cover">
                    <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-[var(--brand)]">
                        Grade {{ $product['grade'] }}
                    </span>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $product['name'] }}</h3>
                        <p class="text-sm text-[var(--muted)]">
                            Mitra: {{ $product['supplier'] }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <p class="text-xs text-[var(--muted)]">Rentang harga</p>
                        <p class="text-xl font-bold text-[var(--brand)]">
                            Rp {{ number_format($product['price_min']) }} - Rp {{ number_format($product['price_max']) }}
                            / {{ $product['unit'] }}
                        </p>
                        <p class="text-xs text-[var(--muted)] mt-2">
                            MOQ: {{ $product['moq'] }} {{ $product['unit'] }} - Stok: {{ $product['stock'] }} {{ $product['unit'] }}
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <a href="{{ route('produk.detail', $id) }}"
                           class="inline-flex items-center justify-center px-3 py-2 rounded-full border border-gray-200 text-sm font-semibold hover:border-[var(--brand)] transition">
                            Detail
                        </a>
                        <a href="{{ route('produk.negosiasi', $id) }}"
                           class="inline-flex items-center justify-center px-3 py-2 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                            Negosiasi
                        </a>
                    </div>
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
                <p class="text-base font-semibold text-white">Menu</p>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                    <a href="{{ route('produk') }}" class="hover:text-white">Produk</a>
                    <a href="{{ route('negosiasi.list') }}" class="hover:text-white">Negosiasi</a>
                    <a href="{{ route('home') }}#contact" class="hover:text-white">Contact</a>
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
    <a href="#top" class="lg:hidden fixed bottom-6 right-6 z-40 inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#0f3d91] text-white shadow-lg shadow-blue-900/30 hover:bg-[#0a2d6c] transition" aria-label="Kembali ke atas">
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 14l6-6 6 6" />
        </svg>
    </a></body>
</html>






