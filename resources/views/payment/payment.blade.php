<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pembayaran - NEXTCHAIN</title>

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

        .pay-card {
            border: 1px solid rgba(148, 163, 184, 0.35);
            border-radius: 18px;
            padding: 1rem;
            transition: 0.2s ease;
            background: #ffffff;
        }

        .pay-card:hover {
            border-color: rgba(15, 61, 145, 0.4);
            box-shadow: 0 16px 30px rgba(15, 61, 145, 0.12);
        }

        .pay-select {
            appearance: none;
            background-image: linear-gradient(45deg, transparent 50%, #0f3d91 50%),
                linear-gradient(135deg, #0f3d91 50%, transparent 50%),
                linear-gradient(to right, transparent, transparent);
            background-position: calc(100% - 20px) calc(1em + 2px),
                calc(100% - 15px) calc(1em + 2px),
                calc(100% - 2.5em) 0.5em;
            background-size: 5px 5px, 5px 5px, 1px 1.5em;
            background-repeat: no-repeat;
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
    <div id="top"></div>
    <header class="sticky top-0 z-50 bg-[var(--brand)] text-white h-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight inline-flex items-center gap-2">
                NEXTCHAIN                <img src="{{ asset('assets/logoumm.png') }}" alt="Logo UMM" class="h-12 w-12 object-contain">
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
    </div>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-[var(--muted)]">Pembayaran</p>
                <h1 class="text-4xl font-bold mt-2">Pilih Metode Pembayaran</h1>
                <p class="text-[var(--muted)] mt-2 max-w-2xl">
                    Pilih metode pembayaran untuk menyelesaikan transaksi. Ini masih simulasi flow.
                </p>
            </div>
            <div class="stepper w-full max-w-md">
                <div class="step">1. Checkout</div>
                <div class="step active">2. Pembayaran</div>
                <div class="step">3. Selesai</div>
            </div>
        </div>

        <div class="mt-8 grid lg:grid-cols-[1.2fr_0.8fr] gap-6 items-start">
            <div class="glass-card rounded-3xl p-6 space-y-6">
                <div class="space-y-3">
                    <label class="text-sm font-semibold">Pilih Metode Pembayaran</label>
                    <select id="paymentMethod"
                            class="pay-select w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option value="all">Semua metode (rekomendasi)</option>
                        <option value="qris">QRIS</option>
                        <option value="gopay">GoPay</option>
                        <option value="shopeepay">ShopeePay</option>
                        <option value="bca_va">VA BCA</option>
                        <option value="bri_va">VA BRI</option>
                        <option value="bni_va">VA BNI</option>
                        <option value="mandiri_va">VA Mandiri</option>
                        <option value="permata_va">VA Permata</option>
                        <option value="bank_transfer">Transfer Bank</option>
                    </select>
                    <p class="text-xs text-[var(--muted)]">
                        Setelah memilih metode, klik Bayar Sekarang untuk membuka payment gateway Midtrans.
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <p class="text-xs uppercase tracking-wide text-[var(--muted)]">Status</p>
                        <p class="text-sm font-semibold text-[var(--ink)] mt-2">Menunggu pembayaran</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <p class="text-xs uppercase tracking-wide text-[var(--muted)]">Batas waktu</p>
                        <p class="text-sm font-semibold text-[var(--ink)] mt-2">24 jam</p>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 text-sm text-[var(--muted)]">
                    Pembayaran diproses aman melalui Midtrans. Status akan tampil otomatis setelah transaksi selesai.
                </div>
            </div>

            <div class="glass-card rounded-3xl p-6 space-y-4 lg:sticky lg:top-28">
                <h2 class="text-lg font-semibold">Ringkasan Pembayaran</h2>
                <div class="flex items-center gap-3">
                    <img src="{{ $product->image_url }}"
                         alt="{{ $product->name }}"
                         class="h-16 w-20 rounded-2xl object-cover">
                    <div>
                        <p class="text-sm font-semibold">{{ $product->name }}</p>
                        <p class="text-xs text-[var(--muted)]">{{ $qty }} {{ $product->unit }}</p>
                        <p class="text-xs text-[var(--muted)]">Order ID: {{ $orderId }}</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-2xl p-4 text-xs text-[var(--muted)] space-y-1">
                    <p><span class="font-semibold text-[var(--ink)]">Nama:</span>
                    {{ $buyer['name'] ?: '-' }}</p>
                    <p><span class="font-semibold text-[var(--ink)]">WA:</span>
                    {{ $buyer['phone'] ?: '-' }}</p>
                    <p><span class="font-semibold text-[var(--ink)]">Alamat:</span>
                    {{ $buyer['address'] ?: '-' }}</p>
                    <p><span class="font-semibold text-[var(--ink)]">Pengiriman:</span>
                    {{ $buyer['shipping_method'] ?: '-' }}</p>
                    @if (!empty($buyer['delivery_destination']))
                        <p><span class="font-semibold text-[var(--ink)]">Tujuan terjadwal:</span>
                    {{ $buyer['delivery_destination'] }}</p>
                    @endif
                    <p><span class="font-semibold text-[var(--ink)]">Jadwal:</span>
                    {{ $buyer['shipping_date'] ?: '-' }} {{ $buyer['shipping_time'] ?: '' }}</p>
                    @if (!empty($buyer['note']))
                        <p><span class="font-semibold text-[var(--ink)]">Catatan:</span>
                    {{ $buyer['note'] }}</p>
                    @endif
                </div>
                <div class="flex justify-between text-sm text-[var(--muted)]">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($subtotal) }}</span>
                    </div>
                <div class="flex justify-between text-sm text-[var(--muted)]">
                    <span>Estimasi ongkir</span>
                    <span>Rp {{ number_format($shipping) }}</span>
                    </div>
                <div class="border-t border-dashed border-slate-200 pt-4 flex justify-between text-base font-semibold">
                    <span>Total</span>
                    <span class="text-[var(--brand)]">Rp {{ number_format($total) }}</span>
                    </div>
                <div class="flex flex-wrap gap-3 pt-2">
                    <button id="payNowBtn"
                            class="px-6 py-3 rounded-full bg-[var(--brand)] text-white font-semibold hover:bg-[var(--brand-dark)] transition">
                        Bayar Sekarang
                    </button>
                    <a href="{{ route('checkout', $product) }}?qty={{ $qty }}"
                       class="px-6 py-3 rounded-full border border-gray-200 font-semibold text-[var(--ink)] hover:border-[var(--brand)] transition">
                        Kembali
                    </a>
                </div>
                <p id="payStatus" class="text-xs text-[var(--muted)]"></p>
            </div>
        </div>
    </main>

    <div id="simModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-6">
        <div class="glass-card w-full max-w-lg rounded-3xl p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-[var(--muted)]">Simulasi Pembayaran</p>
                    <h2 id="simTitle" class="text-2xl font-semibold mt-2">Pembayaran</h2>
                </div>
                <button id="simClose" class="rounded-full border border-slate-200 px-3 py-1 text-sm font-semibold">
                    Tutup
                </button>
            </div>
            <div id="simBody" class="mt-4 space-y-4 text-sm text-[var(--muted)]"></div>
            <div class="mt-6 flex flex-wrap gap-3">
                <button id="simConfirm"
                        class="px-5 py-2 rounded-full bg-[var(--brand)] text-white font-semibold hover:bg-[var(--brand-dark)] transition">
                    Konfirmasi Pembayaran
                </button>
                <button id="simPending"
                        class="px-5 py-2 rounded-full border border-gray-200 font-semibold text-[var(--ink)] hover:border-[var(--brand)] transition">
                    Simulasikan Pending
                </button>
            </div>
        </div>
    </div>

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

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $midtransClientKey }}"></script>
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

        const payNowBtn = document.getElementById('payNowBtn');
        const paymentMethod = document.getElementById('paymentMethod');
        const payStatus = document.getElementById('payStatus');
        const simModal = document.getElementById('simModal');
        const simTitle = document.getElementById('simTitle');
        const simBody = document.getElementById('simBody');
        const simClose = document.getElementById('simClose');
        const simConfirm = document.getElementById('simConfirm');
        const simPending = document.getElementById('simPending');
        const midtransKey = "{{ $midtransClientKey }}";
        const qrisLogoUrl = "{{ asset('assets/qris.png') }}";

        async function requestSnapToken() {
            const method = paymentMethod.value;
            const url = new URL("{{ route('checkout.midtrans', $product) }}", window.location.origin);
            url.searchParams.set('qty', "{{ $qty }}");
            url.searchParams.set('method', method);
            url.searchParams.set('name', "{{ $buyer['name'] }}");
            url.searchParams.set('phone', "{{ $buyer['phone'] }}");
            url.searchParams.set('address', "{{ $buyer['address'] }}");

            payStatus.textContent = 'Menyiapkan pembayaran...';
            payNowBtn.disabled = true;
            payNowBtn.classList.add('opacity-70');

            const response = await fetch(url.toString(), { method: 'GET' });
            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.error || 'Gagal membuat token pembayaran.');
            }
            return data.token;
        }

        function openSimModal(method) {
            const methodLabel = paymentMethod.options[paymentMethod.selectedIndex].text;
            simTitle.textContent = methodLabel;

            const instructions = {
                qris: `
                    <div class="bg-white rounded-2xl p-4 border border-slate-200 text-center">
                        <img src="${qrisLogoUrl}" alt="QRIS" class="mx-auto h-40 w-40 rounded-xl object-contain border border-slate-200 bg-white">
                        <p class="mt-3 text-xs text-[var(--muted)]">Scan QRIS di atas dengan aplikasi bank atau e-wallet.</p>
                    </div>
                `,
                gopay: '<p>Gunakan GoPay untuk menyelesaikan pembayaran. Simulasi: buka aplikasi dan konfirmasi.</p>',
                shopeepay: '<p>Gunakan ShopeePay. Simulasi: buka aplikasi dan konfirmasi.</p>',
                bca_va: '<p>Virtual Account BCA: <strong>1234 5678 9012</strong></p>',
                bri_va: '<p>Virtual Account BRI: <strong>9876 5432 1098</strong></p>',
                bni_va: '<p>Virtual Account BNI: <strong>8800 1122 3344</strong></p>',
                mandiri_va: '<p>Virtual Account Mandiri: <strong>7000 8899 1100</strong></p>',
                permata_va: '<p>Virtual Account Permata: <strong>8800 5544 3322</strong></p>',
                bank_transfer: '<p>Transfer Bank: <strong>BRI 1234567890 a.n. UD. Ade Saputra Farm</strong></p>',
                all: '<p>Pilih metode di dropdown, lalu klik Bayar Sekarang.</p>',
            };

            simBody.innerHTML = instructions[method] || instructions.all;
            simModal.classList.remove('hidden');
            simModal.classList.add('flex');
        }

        function closeSimModal() {
            simModal.classList.add('hidden');
            simModal.classList.remove('flex');
        }

        simClose.addEventListener('click', closeSimModal);

        simConfirm.addEventListener('click', () => {
            const method = paymentMethod.value;
            window.location.href = "{{ route('checkout.success', $product) }}?orderId={{ $orderId }}&method=" + encodeURIComponent(method);
        });

        simPending.addEventListener('click', () => {
            payStatus.textContent = 'Pembayaran pending. Silakan selesaikan pembayaran.';
            closeSimModal();
        });

        payNowBtn.addEventListener('click', async () => {
            try {
                if (!midtransKey) {
                    openSimModal(paymentMethod.value);
                    return;
                }
                const token = await requestSnapToken();
                payStatus.textContent = '';
                window.snap.pay(token, {
                    onSuccess: () => {
                        const method = paymentMethod.value;
                        window.location.href = "{{ route('checkout.success', $product) }}?orderId={{ $orderId }}&method=" + encodeURIComponent(method);
                    },
                    onPending: () => {
                        payStatus.textContent = 'Pembayaran pending. Silakan selesaikan pembayaran.';
                    },
                    onError: () => {
                        payStatus.textContent = 'Pembayaran gagal. Coba lagi.';
                    },
                    onClose: () => {
                        payStatus.textContent = 'Popup pembayaran ditutup.';
                    }
                });
            } catch (error) {
                payStatus.textContent = '';
                openSimModal(paymentMethod.value);
            } finally {
                payNowBtn.disabled = false;
                payNowBtn.classList.remove('opacity-70');
            }
        });
    </script>
    <a href="#top" class="lg:hidden fixed bottom-6 right-6 z-40 inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#0f3d91] text-white shadow-lg shadow-blue-900/30 hover:bg-[#0a2d6c] transition" aria-label="Kembali ke atas">
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 14l6-6 6 6" />
        </svg>
    </a></body>
</html>





















