<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Checkout - NEXTCHAIN</title>

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
            --accent: #f59e0b;
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

        .stepper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 0.35rem;
        }

        .step {
            text-align: center;
            font-size: 12px;
            padding: 0.35rem 0.5rem;
            border-radius: 999px;
            color: var(--muted);
            font-weight: 600;
        }

        .step.active {
            background: var(--brand);
            color: #ffffff;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.7rem;
            border-radius: 999px;
            font-size: 12px;
            color: var(--brand);
            background: rgba(15, 61, 145, 0.08);
            border: 1px solid rgba(15, 61, 145, 0.18);
        }

        @media (max-width: 640px) {
            .stepper {
                grid-template-columns: 1fr;
                border-radius: 18px;
            }

            .step {
                font-size: 11px;
                padding: 0.45rem 0.5rem;
            }
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

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-[var(--muted)]">Checkout</p>
                <h1 class="text-4xl font-bold mt-2">Konfirmasi Pesanan</h1>
                <p class="text-[var(--muted)] mt-2 max-w-2xl">
                    Lengkapi data pembeli dan jumlah pesanan. Ini adalah flow simulasi sebelum payment gateway.
                </p>
            </div>
            <div class="stepper w-full max-w-md">
                <div class="step active">1. Checkout</div>
                <div class="step">2. Pembayaran</div>
                <div class="step">3. Selesai</div>
            </div>
        </div>

        <div class="mt-8 grid lg:grid-cols-[1.2fr_0.8fr] gap-6 items-start">
            <div class="glass-card rounded-3xl p-6 space-y-6">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/' . $product['image']) }}"
                         alt="{{ $product['name'] }}"
                         class="h-20 w-28 rounded-2xl object-cover">
                    <div>
                        <h2 class="text-xl font-semibold">{{ $product['name'] }}</h2>
                        <p class="text-sm text-[var(--muted)]">Mitra: {{ $product['supplier'] }}</p>
                        <p class="text-xs text-[var(--muted)] mt-1">Order ID: {{ $orderId }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    <span class="chip">Harga realtime</span>
                    <span class="chip">Stok siap</span>
                    <span class="chip">Mitra resmi</span>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <p class="text-xs uppercase tracking-wide text-[var(--muted)]">Harga perkiraan</p>
                        <p class="text-lg font-semibold text-[var(--brand)] mt-1">
                            Rp {{ number_format($unitPrice) }} / {{ $product['unit'] }}
                        </p>
                        <p class="text-xs text-[var(--muted)] mt-2">Rentang asli: Rp {{ number_format($product['price_min']) }} - Rp {{ number_format($product['price_max']) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <p class="text-xs uppercase tracking-wide text-[var(--muted)]">MOQ & stok</p>
                        <p class="text-lg font-semibold text-[var(--ink)] mt-1">
                            MOQ {{ $product['moq'] }} {{ $product['unit'] }}
                        </p>
                        <p class="text-xs text-[var(--muted)] mt-2">Stok {{ $product['stock'] }} {{ $product['unit'] }}</p>
                    </div>
                </div>

                <form action="{{ route('checkout.payment', request()->route('id')) }}" method="get" class="grid gap-4" id="checkoutForm">
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
                            <label class="text-sm font-semibold">Jumlah Pesanan</label>
                            <input type="number" name="qty" min="{{ $product['moq'] }}" value="{{ $qty }}"
                                   class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                            <p class="text-xs text-[var(--muted)] mt-1">Min: {{ $product['moq'] }} {{ $product['unit'] }}</p>
                        </div>
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
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold">Tanggal Pengiriman</label>
                            <input type="date" name="shipping_date" required
                                   class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>
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
                    </div>
                    <div>
                        <label class="text-sm font-semibold">Catatan</label>
                        <input type="text" name="note" placeholder="Contoh: kirim pagi hari"
                               class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit" id="checkoutSubmit"
                                class="px-6 py-3 rounded-full bg-[var(--brand)] text-white font-semibold hover:bg-[var(--brand-dark)] transition">
                            Lanjut ke Pembayaran
                        </button>
                        <a href="{{ route('produk.detail', request()->route('id')) }}"
                           class="px-6 py-3 rounded-full border border-gray-200 font-semibold text-[var(--ink)] hover:border-[var(--brand)] transition">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>

            <div class="glass-card rounded-3xl p-6 space-y-4 lg:sticky lg:top-28" id="orderSummary">
                <h2 class="text-lg font-semibold">Ringkasan Pesanan</h2>
                <div class="flex justify-between text-sm text-[var(--muted)]">
                    <span>Harga per {{ $product['unit'] }}</span>
                    <span id="summaryUnitPrice">Rp {{ number_format($unitPrice) }}</span>
                </div>
                <div class="flex justify-between text-sm text-[var(--muted)]">
                    <span>Jumlah</span>
                    <span id="summaryQty">{{ $qty }} {{ $product['unit'] }}</span>
                </div>
                <div class="flex justify-between text-sm text-[var(--muted)]">
                    <span>Subtotal</span>
                    <span id="summarySubtotal">Rp {{ number_format($subtotal) }}</span>
                </div>
                <div class="flex justify-between text-sm text-[var(--muted)]">
                    <span>Biaya layanan</span>
                    <span>Rp 0</span>
                </div>
                <div class="flex justify-between text-sm text-[var(--muted)]">
                    <span>Estimasi ongkir</span>
                    <span id="summaryShipping">Rp {{ number_format($shipping) }}</span>
                </div>
                <div class="border-t border-dashed border-slate-200 pt-4 flex justify-between text-base font-semibold">
                    <span>Total</span>
                    <span class="text-[var(--brand)]" id="summaryTotal">Rp {{ number_format($total) }}</span>
                </div>
                <p class="text-xs text-[var(--muted)]">
                    Total bisa berubah jika ada negosiasi atau update harga realtime.
                </p>
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 text-xs text-[var(--muted)]">
                    Pembayaran aman melalui gateway resmi, notifikasi status dikirim ke WhatsApp.
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

        const qtyInput = document.querySelector('input[name="qty"]');
        const summaryQty = document.getElementById('summaryQty');
        const summarySubtotal = document.getElementById('summarySubtotal');
        const summaryTotal = document.getElementById('summaryTotal');
        const checkoutForm = document.getElementById('checkoutForm');
        const checkoutSubmit = document.getElementById('checkoutSubmit');

        const unitPrice = {{ $unitPrice }};
        const shipping = {{ $shipping }};
        const unit = "{{ $product['unit'] }}";

        function formatPrice(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        function updateSummary() {
            const qty = Number(qtyInput.value || 0);
            const subtotal = qty * unitPrice;
            const total = subtotal + shipping;
            summaryQty.textContent = `${qty} ${unit}`;
            summarySubtotal.textContent = formatPrice(subtotal);
            summaryTotal.textContent = formatPrice(total);
        }

        function checkValidity() {
            if (checkoutForm.checkValidity()) {
                checkoutSubmit.disabled = false;
                checkoutSubmit.classList.remove('opacity-70', 'cursor-not-allowed');
                return;
            }
            checkoutSubmit.disabled = true;
            checkoutSubmit.classList.add('opacity-70', 'cursor-not-allowed');
        }

        qtyInput.addEventListener('input', updateSummary);
        checkoutForm.addEventListener('input', checkValidity);
        checkoutForm.addEventListener('change', checkValidity);
        checkValidity();
        updateSummary();
    </script>
</body>
</html>






