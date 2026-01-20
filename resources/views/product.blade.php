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
                @auth
                    <span class="hidden sm:inline-flex items-center px-4 py-2 rounded-full border border-white/40 text-sm font-semibold text-white">
                        Hai, {{ strtok(auth()->user()->name, ' ') }}
                    </span>
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

    <div id="mobileMenu" class="md:hidden fixed top-16 left-0 right-0 z-40 px-6 pb-4 space-y-2 text-sm text-white/90 bg-[var(--brand)] mobile-menu transition-all duration-300 ease-out max-h-0 opacity-0 -translate-y-2 pointer-events-none overflow-hidden">
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
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
            <div>
                <h1 class="text-4xl font-bold">Katalog Telur</h1>
                <p class="text-[var(--muted)] mt-2 max-w-2xl">
                    Produk telur dari UD. AdeSaputra Farm dengan harga real-time dan opsi negosiasi digital.
                    Pilih produk untuk melihat detail dan ajukan tawaran.
                </p>
            </div>
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white shadow text-sm">
                <span class="pulse-dot w-3 h-3"></span>
                Harga diperbarui real-time
            </div>
        </div>

        <section class="mt-10 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $product)
            <div class="bg-white rounded-3xl overflow-hidden shadow-lg card-glow transition">
                <div class="relative">
                    <img src="{{ $product->image_url }}"
                         alt="{{ $product->name }}"
                         class="h-48 w-full object-cover">
                    <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-white/90 text-xs font-semibold text-[var(--brand)]">
                        Grade {{ $product->grade ?? '-' }}
                    </span>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p class="text-sm text-[var(--muted)]">
                            Mitra: {{ $product->supplier }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <p class="text-xs text-[var(--muted)]">Rentang harga</p>
                        <p class="text-xl font-bold text-[var(--brand)]">
                            Rp {{ number_format($product->price_min) }} - Rp {{ number_format($product->price_max) }}
                            / {{ $product->unit }}
                        </p>
                        <p class="text-xs text-[var(--muted)] mt-2">
                            MOQ: {{ $product->moq }} {{ $product->unit }} - Stok: {{ $product->stock }} {{ $product->unit }}
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <a href="{{ route('produk.detail', $product) }}"
                           class="inline-flex items-center justify-center px-3 py-2 text-sm action-btn btn-detail">
                            Detail
                        </a>
                        <a href="{{ route('produk.negosiasi', $product) }}"
                           class="inline-flex items-center justify-center px-3 py-2 text-sm action-btn btn-nego">
                            Negosiasi
                        </a>
                        <a href="{{ route('checkout', $product) }}"
                           class="inline-flex items-center justify-center px-3 py-2 text-sm action-btn btn-checkout"
                           data-requires-auth="true">
                            Checkout
                        </a>
                        <button type="button"
                                class="inline-flex items-center justify-center px-3 py-2 text-sm action-btn btn-cart add-to-cart"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->price_min }}"
                                data-unit="{{ $product->unit }}"
                                data-image="{{ $product->image }}">
                            Keranjang
                        </button>
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

    <div id="toast" class="fixed top-6 right-6 z-50 max-w-xs rounded-2xl bg-white px-4 py-3 text-sm text-[var(--ink)] shadow-xl border border-slate-200 opacity-0 -translate-y-3 pointer-events-none transition-all duration-300">
        <div id="toastText"></div>
    </div>

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

        const cartCounts = Array.from(document.querySelectorAll('.cart-count'));
        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
        const loginUrl = "{{ route('login') }}";
        const initialCartCount = {{ $cartCount ?? 0 }};
        const toast = document.getElementById('toast');
        const toastText = document.getElementById('toastText');
        let toastTimer = null;
        function getCurrentCartCount() {
            const firstBadge = cartCounts[0];
            if (!firstBadge) {
                return 0;
            }
            return Number(firstBadge.textContent || 0);
        }

        function updateCartBadge(count) {
            cartCounts.forEach((badge) => {
                const nextCount = Number(count || 0);
                badge.textContent = nextCount;
                badge.classList.toggle('hidden', nextCount === 0);
            });
        }

        function showToast(message) {
            if (!toast || !toastText) {
                return;
            }
            toastText.textContent = message;
            toast.classList.remove('opacity-0', '-translate-y-3', 'pointer-events-none');
            toast.classList.add('opacity-100', 'translate-y-0');
            if (toastTimer) {
                clearTimeout(toastTimer);
            }
            toastTimer = setTimeout(() => {
                toast.classList.add('opacity-0', '-translate-y-3', 'pointer-events-none');
                toast.classList.remove('opacity-100', 'translate-y-0');
            }, 2600);
        }

        function showLoginPrompt() {
            const promptEl = document.getElementById('authPrompt');
            if (!promptEl) {
                window.location.href = loginUrl;
                return;
            }
            promptEl.classList.remove('hidden');
        }

        document.querySelectorAll('[data-requires-auth="true"]').forEach((el) => {
            el.addEventListener('click', (event) => {
                if (!isAuthenticated) {
                    event.preventDefault();
                    showLoginPrompt();
                }
            });
        });

        document.querySelectorAll('.add-to-cart').forEach((btn) => {
            btn.addEventListener('click', () => {
                if (!isAuthenticated) {
                    showLoginPrompt();
                    return;
                }
                fetch("{{ route('cart.items.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({ product_id: btn.dataset.id, qty: 1 }),
                }).then(async (response) => {
                    const data = await response.json();
                    if (!response.ok) {
                        throw new Error(data.message || 'Gagal menambahkan ke keranjang.');
                    }
                    return data;
                }).then((data) => {
                        if (typeof data.count === 'number') {
                            updateCartBadge(data.count);
                        } else {
                            updateCartBadge(getCurrentCartCount() + 1);
                        }
                        showToast('Produk ditambahkan ke keranjang.');
                    }).catch((error) => {
                        showToast(error.message);
                    });
            });
        });

        updateCartBadge(initialCartCount);
    </script>

    <div id="authPrompt" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-6">
        <div class="bg-white rounded-3xl p-6 max-w-sm w-full text-center space-y-4">
            <h3 class="text-lg font-semibold">Login dulu ya</h3>
            <p class="text-sm text-[var(--muted)]">Untuk checkout atau menambah keranjang, kamu harus login.</p>
            <div class="flex justify-center gap-3">
                <a href="{{ route('login') }}"
                   class="px-4 py-2 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                    Ke Login
                </a>
                <button type="button" id="authCloseBtn"
                        class="px-4 py-2 rounded-full border border-slate-200 text-sm font-semibold hover:border-[var(--brand)] transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        const authCloseBtn = document.getElementById('authCloseBtn');
        const authPrompt = document.getElementById('authPrompt');
        if (authCloseBtn && authPrompt) {
            authCloseBtn.addEventListener('click', () => authPrompt.classList.add('hidden'));
        }
    </script>
</body>
</html>








