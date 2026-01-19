<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Checkout Keranjang - NEXTCHAIN</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');

        :root {
            --ink: #0b1b32;
            --muted: #4b5563;
            --brand: #0f3d91;
            --brand-dark: #0a2d6c;
            --bg: #f6f8fc;
            --card: rgba(255, 255, 255, 0.92);
            --line: rgba(148, 163, 184, 0.3);
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(900px 400px at 90% -10%, #dbeafe 0%, rgba(219, 234, 254, 0) 60%),
                radial-gradient(800px 400px at 0% 10%, rgba(59, 130, 246, 0.12), rgba(59, 130, 246, 0)),
                var(--bg);
        }

        .glass-card {
            background: var(--card);
            border: 1px solid var(--line);
            box-shadow: 0 24px 50px rgba(15, 61, 145, 0.12);
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
    </div>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-[var(--muted)]">Checkout</p>
                <h1 class="text-4xl font-bold mt-2">Checkout Keranjang</h1>
                <p class="text-[var(--muted)] mt-2 max-w-2xl">
                    Daftar produk yang kamu pilih dari keranjang akan otomatis tampil di sini.
                </p>
            </div>
        </div>

        <div class="mt-8 grid lg:grid-cols-[1.2fr_0.8fr] gap-6 items-start">
            <div class="glass-card rounded-3xl p-6 space-y-6">
                <div>
                    <h2 class="text-lg font-semibold">Produk Terpilih</h2>
                    <p class="text-xs text-[var(--muted)]">Diambil dari checklist keranjang.</p>
                </div>
                <div id="checkoutItems" class="space-y-4"></div>
                <div id="checkoutEmpty" class="text-center text-[var(--muted)] py-8 hidden">
                    Belum ada produk yang dipilih.
                </div>

                <form id="buyerForm" class="grid gap-4" method="post" action="{{ route('checkout.cart.payment.store') }}">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold">Nama Pemesan</label>
                            <input type="text" name="name" placeholder="Nama lengkap" required
                                   class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="text-sm font-semibold">Nomor WhatsApp</label>
                            <input type="text" name="phone" placeholder="08xx-xxxx-xxxx" required
                                   class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-semibold">Alamat Pengiriman</label>
                        <textarea rows="3" name="address" placeholder="Alamat lengkap penerima" required
                                  class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"></textarea>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold">Metode Pengiriman</label>
                            <select name="shipping_method" required
                                    class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                                <option value="" disabled selected>Pilih metode</option>
                                <option>Pickup di farm</option>
                                <option>Pengiriman terjadwal</option>
                                <option>Kurir UMKM</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-semibold">Tanggal Pengiriman</label>
                            <input type="date" name="shipping_date" required
                                   class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold">Jam Pengiriman</label>
                            <select name="shipping_time" required
                                    class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                                <option value="" disabled selected>Pilih jam</option>
                                <option>Pagi (08.00 - 11.00)</option>
                                <option>Siang (11.00 - 14.00)</option>
                                <option>Sore (14.00 - 17.00)</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-semibold">Catatan</label>
                            <input type="text" name="note" placeholder="Contoh: kirim pagi hari"
                                   class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit" id="submitCartCheckout"
                                class="px-6 py-3 rounded-full bg-[var(--brand)] text-white font-semibold hover:bg-[var(--brand-dark)] transition disabled:opacity-60 disabled:cursor-not-allowed">
                            Lanjut ke Pembayaran
                        </button>
                        <a href="{{ route('cart') }}"
                           class="px-6 py-3 rounded-full border border-gray-200 font-semibold text-[var(--ink)] hover:border-[var(--brand)] transition">
                            Kembali ke Keranjang
                        </a>
                    </div>
                </form>
            </div>

            <div class="glass-card rounded-3xl p-6 space-y-4 lg:sticky lg:top-28" id="orderSummary">
                <h2 class="text-lg font-semibold">Ringkasan Pesanan</h2>
                <div class="flex justify-between text-sm text-[var(--muted)]">
                    <span>Total item</span>
                    <span id="summaryCount">0</span>
                </div>
                <div class="flex justify-between text-sm text-[var(--muted)]">
                    <span>Subtotal</span>
                    <span id="summarySubtotal">Rp 0</span>
                </div>
                <div class="flex justify-between text-sm text-[var(--muted)]">
                    <span>Estimasi ongkir</span>
                    <span id="summaryShipping">Rp 0</span>
                </div>
                <div class="border-t border-dashed border-slate-200 pt-4 flex justify-between text-base font-semibold">
                    <span>Total</span>
                    <span class="text-[var(--brand)]" id="summaryTotal">Rp 0</span>
                </div>
                <p class="text-xs text-[var(--muted)]">
                    Simulasi checkout dari produk yang kamu checklist di keranjang.
                </p>
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

        const cartCounts = Array.from(document.querySelectorAll('.cart-count'));
        const checkoutItemsEl = document.getElementById('checkoutItems');
        const checkoutEmptyEl = document.getElementById('checkoutEmpty');
        const summaryCount = document.getElementById('summaryCount');
        const summarySubtotal = document.getElementById('summarySubtotal');
        const summaryShipping = document.getElementById('summaryShipping');
        const summaryTotal = document.getElementById('summaryTotal');
        const submitBtn = document.getElementById('submitCartCheckout');
        const shippingFee = 25000;
        const initialCartItems = @json($cartItems ?? []);
        const initialCartCount = {{ $cartCount ?? 0 }};

        function formatPrice(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        function updateCartBadge(count) {
            cartCounts.forEach((badge) => {
                const nextCount = Number(count || 0);
                badge.textContent = nextCount;
                badge.classList.toggle('hidden', nextCount === 0);
            });
        }

        function renderCheckout() {
            const selectedItems = initialCartItems.filter((item) => item.selected);

            checkoutItemsEl.innerHTML = '';
            checkoutEmptyEl.classList.toggle('hidden', selectedItems.length !== 0);

            let totalQty = 0;
            let subtotal = 0;

            selectedItems.forEach((item) => {
                const qty = Number(item.qty || 0);
                const price = Number(item.price || 0);
                totalQty += qty;
                subtotal += qty * price;

                const row = document.createElement('div');
                row.className = 'flex flex-col sm:flex-row sm:items-center gap-4 border border-slate-200 rounded-2xl p-4';
                row.innerHTML = `
                    <img src="${item.image_url || '{{ asset('assets') }}/'}${item.image || ''}" alt="${item.name}" class="h-20 w-28 rounded-xl object-cover">
                    <div class="flex-1 space-y-1">
                        <p class="text-base font-semibold">${item.name}</p>
                        <p class="text-xs text-[var(--muted)]">Rp ${price.toLocaleString('id-ID')} / ${item.unit}</p>
                        <p class="text-xs text-[var(--muted)]">Qty ${qty} ${item.unit}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-[var(--brand)]">${formatPrice(qty * price)}</p>
                    </div>
                `;
                checkoutItemsEl.appendChild(row);
            });

            const hasSelected = selectedItems.length > 0;
            summaryCount.textContent = `${totalQty} item`;
            summarySubtotal.textContent = formatPrice(subtotal);
            summaryShipping.textContent = formatPrice(hasSelected ? shippingFee : 0);
            summaryTotal.textContent = formatPrice(subtotal + (hasSelected ? shippingFee : 0));
            submitBtn.disabled = !hasSelected;
            updateCartBadge(initialCartCount);
        }

        renderCheckout();
    </script>
</body>
</html>


