<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $product['name'] }} - Detail NEXTCHAIN</title>

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
        .btn-checkout {
            background: #f97316;
            color: #fff;
            box-shadow: 0 12px 26px rgba(249, 115, 22, 0.32);
        }
        .btn-checkout:hover {
            background: #ea580c;
            box-shadow: 0 16px 32px rgba(249, 115, 22, 0.4);
        }
        .btn-cart {
            background: #7c3aed;
            color: #fff;
            box-shadow: 0 12px 26px rgba(124, 58, 237, 0.3);
        }
        .btn-cart:hover {
            background: #6d28d9;
            box-shadow: 0 16px 32px rgba(124, 58, 237, 0.4);
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
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <a href="{{ route('produk') }}" class="text-white border-b-2 border-white/80 pb-0.5">Produk</a>
                <a href="{{ route('negosiasi.list') }}" class="hover:text-white">Negosiasi</a>
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
                <a href="{{ route('produk') }}"
                   class="hidden sm:inline-flex items-center px-4 py-2 rounded-full bg-white text-[var(--brand)] text-sm font-semibold hover:bg-slate-100 transition">
                    Kembali ke Produk
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
    </header>

    <div id="mobileMenu" class="md:hidden fixed top-16 left-0 right-0 z-40 px-6 pb-4 space-y-2 text-sm text-white/90 bg-[var(--brand)] mobile-menu transition-all duration-300 ease-out max-h-0 opacity-0 -translate-y-2 pointer-events-none overflow-hidden">
        <a href="{{ route('home') }}" class="block">Home</a>
        <a href="{{ route('produk') }}" class="block">Produk</a>
        <a href="{{ route('cart') }}" class="block">Keranjang</a>
        <a href="{{ route('negosiasi.list') }}" class="block">Negosiasi</a>
        <a href="{{ route('home') }}#tentang" class="block">Tentang</a>
        <a href="{{ route('home') }}#galeri" class="block">Galeri</a>
        <a href="{{ route('home') }}#testimoni" class="block">Testimoni</a>
        <a href="{{ route('home') }}#contact" class="block">Contact</a>
    </div>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <a href="{{ route('produk') }}" class="text-sm text-[var(--muted)] hover:text-[var(--ink)]">
            Kembali ke katalog
        </a>

        <div class="mt-6 grid lg:grid-cols-2 gap-10 items-start">
            <div class="bg-white rounded-3xl p-4 shadow-lg">
                <img src="{{ asset('assets/' . $product['images'][0]) }}"
                     id="mainImage"
                     alt="{{ $product['name'] }}"
                     class="w-full h-80 object-cover rounded-2xl">

                @if(!empty($product['images']))
                <div class="grid grid-cols-4 gap-3 mt-4">
                    @foreach ($product['images'] as $img)
                        <img src="{{ asset('assets/' . $img) }}"
                             alt="Thumbnail {{ $product['name'] }}"
                             onclick="document.getElementById('mainImage').src='{{ asset('assets/' . $img) }}'"
                             class="h-20 w-full object-cover rounded-xl cursor-pointer border border-transparent hover:border-[var(--brand)] transition">
                    @endforeach
                </div>
                @endif
            </div>

            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold">{{ $product['name'] }}</h1>
                    <p class="text-[var(--muted)] mt-2">
                        Mitra: {{ $product['supplier'] }} - Grade {{ $product['grade'] }}
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-lg">
                    <p class="text-xs text-[var(--muted)]">Harga real-time</p>
                    <p class="text-3xl font-bold text-[var(--brand)] mt-2">
                        Rp {{ number_format($product['price_min']) }} - Rp {{ number_format($product['price_max']) }}
                        / {{ $product['unit'] }}
                    </p>
                    <div class="grid grid-cols-2 gap-4 mt-4 text-sm text-[var(--muted)]">
                        <div>
                            <p class="text-xs uppercase tracking-wide">MOQ</p>
                            <p class="text-base font-semibold text-[var(--ink)]">
                                {{ $product['moq'] }} {{ $product['unit'] }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide">Stok siap</p>
                            <p class="text-base font-semibold text-[var(--ink)]">
                                {{ $product['stock'] }} {{ $product['unit'] }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-lg">
                    <h2 class="text-lg font-semibold">Deskripsi Produk</h2>
                    <p class="text-[var(--muted)] mt-2 leading-relaxed">
                        {{ $product['description'] ?? 'Deskripsi produk belum tersedia.' }}
                    </p>
                    <div class="mt-4 grid sm:grid-cols-2 gap-4 text-sm text-[var(--muted)]">
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs uppercase tracking-wide">Distribusi</p>
                            <p class="text-base font-semibold text-[var(--ink)] mt-2">
                                Pickup farm atau pengiriman terjadwal
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-xs uppercase tracking-wide">Kemasan</p>
                            <p class="text-base font-semibold text-[var(--ink)] mt-2">
                                Sesuai kebutuhan volume
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 sm:gap-3">
                    <a href="{{ route('produk.negosiasi', request()->route('id')) }}"
                       class="inline-flex items-center justify-center w-full px-4 py-2.5 sm:px-6 sm:py-3 text-[12px] sm:text-sm action-btn btn-nego">
                        Mulai Negosiasi
                    </a>
                    <a href="{{ route('checkout', request()->route('id')) }}"
                       class="inline-flex items-center justify-center w-full px-4 py-2.5 sm:px-6 sm:py-3 text-[12px] sm:text-sm action-btn btn-checkout">
                        Checkout
                    </a>
                    <button type="button"
                            class="inline-flex items-center justify-center w-full px-4 py-2.5 sm:px-6 sm:py-3 text-[12px] sm:text-sm action-btn btn-cart"
                            id="addToCartBtn"
                            data-id="{{ request()->route('id') }}"
                            data-name="{{ $product['name'] }}"
                            data-price="{{ $product['price_min'] }}"
                            data-unit="{{ $product['unit'] }}"
                            data-image="{{ $product['image'] }}">
                        Keranjang
                    </button>
                    <a href="{{ route('produk') }}"
                       class="inline-flex items-center justify-center w-full px-4 py-2.5 sm:px-6 sm:py-3 text-[12px] sm:text-sm action-btn btn-detail">
                        Lihat Produk Lain
                    </a>
                </div>
            </div>
        </div>
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
        function addToCart(item) {
            const items = getCartItems();
            const existing = items.find((row) => row.id === item.id);
            if (existing) {
                existing.qty += 1;
            } else {
                items.push({ ...item, qty: 1 });
            }
            localStorage.setItem(cartKey, JSON.stringify(items));
            updateCartBadge();
        }

        const addBtn = document.getElementById('addToCartBtn');
        if (addBtn) {
            addBtn.addEventListener('click', () => {
                addToCart({
                    id: addBtn.dataset.id,
                    name: addBtn.dataset.name,
                    price: Number(addBtn.dataset.price),
                    unit: addBtn.dataset.unit,
                    image: addBtn.dataset.image,
                });
            });
        }

        updateCartBadge();
        window.addEventListener('storage', updateCartBadge);
    </script>
</body>
</html>




