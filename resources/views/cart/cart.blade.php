<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Keranjang - NEXTCHAIN</title>

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

        html {
            background: var(--brand);
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(900px 400px at 90% -10%, #dbeafe 0%, rgba(219, 234, 254, 0) 60%),
                var(--bg);
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <header class="sticky top-0 z-50 bg-[var(--brand)] text-white">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight inline-flex items-center gap-2">
                NEXTCHAIN
                <img src="{{ asset('assets/logoumm.png') }}" alt="Logo UMM" class="h-12 w-12 object-contain">
            </a>
            <nav class="hidden md:flex items-center gap-5 text-sm font-medium text-white/80">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <a href="{{ route('produk') }}" class="hover:text-white">Produk</a>
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
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="4" y1="6" x2="20" y2="6"></line>
                        <line x1="4" y1="12" x2="20" y2="12"></line>
                        <line x1="4" y1="18" x2="20" y2="18"></line>
                    </svg>
                </button>
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
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-[var(--muted)]">Keranjang</p>
                <h1 class="text-4xl font-bold mt-2">Produk di Keranjang</h1>
                <p class="text-[var(--muted)] mt-2 max-w-2xl">
                    Kelola produk yang ingin kamu checkout. Jumlah dan total otomatis dihitung.
                </p>
            </div>
        </div>

        <div class="mt-8 grid lg:grid-cols-[1.2fr_0.8fr] gap-6 items-start">
            <div class="bg-white/90 border border-slate-200 rounded-3xl p-6 shadow-lg">
                <div id="cartItems" class="space-y-4"></div>
                <div id="cartEmpty" class="text-center text-[var(--muted)] py-10 hidden">
                    Keranjang masih kosong.
                </div>
                <div id="loginRequired" class="text-center text-[var(--muted)] py-10 hidden">
                    Login dulu untuk mengelola keranjang.
                    <div class="mt-4">
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center px-4 py-2 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                            Ke Login
                        </a>
                    </div>
                </div>
            </div>
            <div class="bg-white/90 border border-slate-200 rounded-3xl p-6 shadow-lg space-y-4 lg:sticky lg:top-28">
                <h2 class="text-lg font-semibold">Ringkasan Keranjang</h2>
                <div class="flex justify-between text-sm text-[var(--muted)]">
                    <span>Total item</span>
                    <span id="cartSummaryCount">0</span>
                    </div>
                <div class="flex justify-between text-sm text-[var(--muted)]">
                    <span>Subtotal</span>
                    <span id="cartSummarySubtotal">Rp 0</span>
                    </div>
                <div class="border-t border-dashed border-slate-200 pt-4 flex justify-between text-base font-semibold">
                    <span>Total</span>
                    <span class="text-[var(--brand)]" id="cartSummaryTotal">Rp 0</span>
                    </div>
                <p class="text-xs text-[var(--muted)]">Checklist produk yang ingin di-checkout.</p>
                <button type="button" id="checkoutSelectedBtn"
                        class="w-full px-4 py-3 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition disabled:opacity-60 disabled:cursor-not-allowed">
                    Checkout Terpilih
                </button>
            </div>
        </div>

        <section class="mt-10">
            <div class="relative overflow-hidden rounded-3xl border border-slate-200 bg-white/90 p-6 shadow-lg">
                <div class="absolute -top-24 -right-16 h-48 w-48 rounded-full bg-blue-100/70 blur-3xl"></div>
                <div class="absolute -bottom-24 -left-16 h-52 w-52 rounded-full bg-emerald-100/60 blur-3xl"></div>
                <div class="relative flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-[var(--muted)]">Riwayat Pesanan</p>
                        <h2 class="text-2xl font-semibold mt-2">Transaksi terakhir kamu</h2>
                        <p class="text-sm text-[var(--muted)] mt-1">Ringkasan pesanan terbaru lengkap dengan status pembayaran.</p>
                    </div>
                    <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 text-xs text-[var(--muted)] shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    Update otomatis
                    </span>
                    </div>

                @if (session('success'))
                    <div class="mt-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @auth
                    <div class="mt-6 grid gap-4">
                        @forelse ($orderHistory ?? [] as $order)
                            <div class="rounded-2xl border border-slate-200 bg-white/95 p-5 shadow-sm">
                                <div class="flex flex-wrap items-start justify-between gap-6">
                                    <div class="space-y-1">
                                        <p class="text-base font-semibold text-[var(--ink)]">{{ $order->order_number }}</p>
                                        <p class="text-xs text-[var(--muted)]">
                                            {{ optional($order->created_at)->format('d M Y, H:i') }}
                                        </p>
                                        <div class="mt-4 grid gap-2 text-sm text-[var(--muted)]">
                                            @foreach ($order->items->take(3) as $item)
                                                <div class="flex items-center justify-between gap-3">
                                                    <span class="truncate">{{ $item->product?->name ?? 'Produk' }}</span>
                    <span class="font-semibold text-[var(--ink)]">{{ $item->qty }} {{ $item->unit }}</span>
                    </div>
                                            @endforeach
                                            @if ($order->items->count() > 3)
                                                <span class="text-xs text-[var(--muted)]">
                                                    +{{ $order->items->count() - 3 }} item lainnya
                                                </span>
                    @endif
                                        </div>
                                    </div>
                                    <div class="text-right space-y-2">
                                        <p class="text-lg font-semibold text-[var(--brand)]">Rp {{ number_format($order->total) }}</p>
                                        <div class="flex flex-wrap justify-end gap-2 text-xs font-semibold">
                                            <span class="rounded-full bg-blue-50 px-3 py-1 text-blue-700">{{ $order->status }}</span>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-emerald-700">{{ $order->payment_status }}</span>
                    </div>
                                        @if ($order->payment_status === 'paid')
                                            <div class="grid grid-cols-3 gap-2 pt-3 text-[11px] font-semibold sm:flex sm:flex-wrap sm:justify-end">
                                                <a href="{{ route('invoice.download', $order) }}"
                                                   class="inline-flex items-center justify-center px-2.5 py-2 rounded-full bg-amber-600 text-white font-semibold whitespace-nowrap hover:bg-amber-700 transition">
                                                    Cetak Nota
                                                </a>
                                                <a href="{{ route('invoice.whatsapp', $order) }}"
                                                   class="inline-flex items-center justify-center px-2.5 py-2 rounded-full bg-emerald-600 text-white font-semibold whitespace-nowrap hover:bg-emerald-700 transition">
                                                    Kirim WA
                                                </a>
                                                <form method="post" action="{{ route('invoice.email', $order) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex w-full items-center justify-center px-2.5 py-2 rounded-full bg-blue-700 text-white font-semibold whitespace-nowrap hover:bg-blue-800 transition">
                                                        Kirim Email
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 bg-white px-4 py-6 text-sm text-[var(--muted)]">
                                Belum ada riwayat pesanan.
                            </div>
                        @endforelse
                    </div>
                @else
                    <div class="mt-6 rounded-2xl border border-dashed border-slate-200 bg-white px-4 py-6 text-sm text-[var(--muted)]">
                        Login dulu untuk melihat riwayat pesanan.
                        <div class="mt-4">
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center px-4 py-2 rounded-full bg-[var(--brand)] text-white text-sm font-semibold hover:bg-[var(--brand-dark)] transition">
                                Ke Login
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
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
        const cartItemsEl = document.getElementById('cartItems');
        const cartEmptyEl = document.getElementById('cartEmpty');
        const loginRequiredEl = document.getElementById('loginRequired');
        const cartSummaryCount = document.getElementById('cartSummaryCount');
        const cartSummarySubtotal = document.getElementById('cartSummarySubtotal');
        const cartSummaryTotal = document.getElementById('cartSummaryTotal');
        const checkoutSelectedBtn = document.getElementById('checkoutSelectedBtn');
        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
        const initialCartItems = @json($cartItems ?? []);
        const defaultImageUrl = "{{ asset('assets/ternakayam.jpg') }}";
        let cartItemsState = initialCartItems;

        function formatPrice(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        function updateCartBadge() {
            const count = (isAuthenticated ? cartItemsState : []).reduce((sum, item) => sum + Number(item.qty || 0), 0);
            cartCounts.forEach((badge) => {
                badge.textContent = count;
                badge.classList.toggle('hidden', count === 0);
            });
        }

        function renderCart() {
            const items = isAuthenticated ? cartItemsState : [];
            cartItemsEl.innerHTML = '';
            cartEmptyEl.classList.toggle('hidden', items.length !== 0 || !isAuthenticated);
            loginRequiredEl.classList.toggle('hidden', isAuthenticated);

            let totalQty = 0;
            let subtotal = 0;

            items.forEach((item) => {
                const qty = Number(item.qty || 0);
                const price = Number(item.price || 0);
                const imageUrl = item.image_url || defaultImageUrl;
                if (item.selected) {
                    totalQty += qty;
                    subtotal += qty * price;
                }

                const card = document.createElement('div');
                card.className = 'flex flex-col sm:flex-row sm:items-center gap-4 border border-slate-200 rounded-2xl p-4';
                card.innerHTML = `
                    <img src="${imageUrl}" alt="${item.name}" class="h-20 w-28 rounded-xl object-cover">
                    <div class="flex-1 space-y-1">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" class="item-check h-4 w-4 accent-[var(--brand)]" ${item.selected ? 'checked' : ''}>
                            <p class="text-base font-semibold">${item.name}</p>
                        </div>
                        <p class="text-xs text-[var(--muted)]">Rp ${price.toLocaleString('id-ID')} / ${item.unit}</p>
                        <div class="flex items-center gap-2 text-sm text-[var(--muted)]">
                            <span>Qty</span>
                    <div class="inline-flex items-center rounded-full border border-slate-200 bg-white overflow-hidden">
                                <button type="button" class="qty-minus px-3 py-1 text-[var(--brand)] font-semibold">-</button>
                                <span class="px-3 text-sm text-[var(--ink)] qty-value">${qty}</span>
                    <button type="button" class="qty-plus px-3 py-1 text-[var(--brand)] font-semibold">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="text-right space-y-2">
                        <p class="text-sm font-semibold text-[var(--brand)]">${formatPrice(qty * price)}</p>
                        <a href="/checkout/${item.product_id}?qty=${qty}"
                           class="inline-flex items-center justify-center px-3 py-2 rounded-full bg-[var(--brand)] text-white text-xs font-semibold hover:bg-[var(--brand-dark)] transition">
                            Checkout
                        </a>
                        <button class="inline-flex items-center justify-center px-3 py-1.5 rounded-full bg-red-500 text-white text-xs font-semibold hover:bg-red-600 transition remove-btn">
                            Hapus
                        </button>
                    </div>
                `;

                const checkbox = card.querySelector('.item-check');
                checkbox.addEventListener('change', () => {
                    fetch(`{{ url('/keranjang/items') }}/${item.id}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({ selected: checkbox.checked }),
                    }).then(() => {
                        item.selected = checkbox.checked;
                        renderCart();
                    });
                });

                const qtyValue = card.querySelector('.qty-value');
                const minusBtn = card.querySelector('.qty-minus');
                const plusBtn = card.querySelector('.qty-plus');
                const imageEl = card.querySelector('img');
                if (imageEl) {
                    imageEl.addEventListener('error', () => {
                        imageEl.src = defaultImageUrl;
                    });
                }
                minusBtn.addEventListener('click', () => {
                    const nextQty = Math.max(1, Number(item.qty || 1) - 1);
                    fetch(`{{ url('/keranjang/items') }}/${item.id}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({ qty: nextQty }),
                    }).then(() => {
                        item.qty = nextQty;
                        renderCart();
                    });
                });
                plusBtn.addEventListener('click', () => {
                    const nextQty = Number(item.qty || 1) + 1;
                    fetch(`{{ url('/keranjang/items') }}/${item.id}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({ qty: nextQty }),
                    }).then(() => {
                        item.qty = nextQty;
                        renderCart();
                    });
                });

                card.querySelector('.remove-btn').addEventListener('click', () => {
                    fetch(`{{ url('/keranjang/items') }}/${item.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                    }).then(() => {
                        cartItemsState = cartItemsState.filter((row) => row.id !== item.id);
                        renderCart();
                    });
                });

                cartItemsEl.appendChild(card);
            });

            cartSummaryCount.textContent = `${totalQty} item`;
            cartSummarySubtotal.textContent = formatPrice(subtotal);
            cartSummaryTotal.textContent = formatPrice(subtotal);

            const hasSelected = totalQty > 0;
            if (checkoutSelectedBtn) {
                checkoutSelectedBtn.disabled = !hasSelected;
            }
            updateCartBadge();
        }

        if (checkoutSelectedBtn) {
            checkoutSelectedBtn.addEventListener('click', () => {
                if (!isAuthenticated) {
                    return;
                }
                if (!cartItemsState.some((row) => row.selected)) {
                    return;
                }
                window.location.href = "{{ route('checkout.cart') }}";
            });
        }

        renderCart();
    </script>
</body>
</html>













