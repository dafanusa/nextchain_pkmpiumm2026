<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Negosiasi - {{ $product['name'] }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');

        :root {
            --ink: #0b1b32;
            --muted: #4b5563;
            --brand: #0f3d91;
            --brand-dark: #0a2d6c;
            --accent: #f59e0b;
            --bg: #f6f8fc;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(1200px 600px at 10% -10%, rgba(255, 237, 213, 0.75) 0%, rgba(255, 237, 213, 0) 60%),
                radial-gradient(900px 500px at 90% -5%, rgba(219, 234, 254, 0.9) 0%, rgba(219, 234, 254, 0) 55%),
                linear-gradient(180deg, #f8fbff 0%, #eef3fb 100%);
        }

        .chat-bubble {
            max-width: 75%;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(15, 61, 145, 0.08);
            box-shadow: 0 24px 60px rgba(15, 61, 145, 0.08);
            backdrop-filter: blur(10px);
        }

        .accent-ring {
            box-shadow: 0 0 0 1px rgba(209, 31, 31, 0.35), 0 16px 40px rgba(209, 31, 31, 0.15);
        }

        .chip {
            background: rgba(15, 61, 145, 0.08);
        }
    </style>
</head>

<body>
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-20 -left-24 h-64 w-64 rounded-full bg-orange-200/40 blur-3xl"></div>
        <div class="absolute top-20 right-0 h-72 w-72 rounded-full bg-blue-200/40 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 h-64 w-64 rounded-full bg-emerald-200/30 blur-3xl"></div>
    </div>
    <header class="sticky top-0 z-50 bg-[var(--brand)] text-white">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">
                NEXTCHAIN
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
                <a href="{{ route('produk.detail', request()->route('id')) }}"
                   class="hidden sm:inline-flex items-center px-4 py-2 rounded-full bg-white text-[var(--brand)] text-sm font-semibold hover:bg-slate-100 transition">
                    Detail Produk
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
        <div class="md:hidden mb-4">
            <a href="{{ route('produk.detail', request()->route('id')) }}"
               class="inline-flex items-center text-sm font-semibold text-[var(--brand)]">
                Kembali ke Detail Produk
            </a>
        </div>
        <div class="grid gap-8 lg:grid-cols-12">
            <section class="order-1 lg:order-none lg:col-span-4 glass-card rounded-3xl p-6">
                <h1 class="text-2xl font-bold">Negosiasi Harga</h1>
                <p class="text-[var(--muted)] mt-2">
                    {{ $product['name'] }} - {{ $product['supplier'] }}
                </p>
                <div class="mt-4 bg-white/70 rounded-2xl p-4 accent-ring">
                    <p class="text-xs text-[var(--muted)]">Harga real-time</p>
                    <p id="livePrice" class="text-2xl font-bold text-[var(--brand)] mt-1">
                        Rp {{ number_format($product['price_min']) }}
                    </p>
                    <p class="text-xs text-[var(--muted)] mt-2">
                        Rentang: Rp {{ number_format($product['price_min']) }} - Rp {{ number_format($product['price_max']) }}
                        / {{ $product['unit'] }}
                    </p>
                </div>
            </section>

            <section class="order-2 lg:order-none lg:col-span-8 glass-card rounded-3xl p-6 flex flex-col">
                @php
                    $publicOffers = [
                        ['user' => 'User A', 'price' => 25500, 'qty' => 80, 'unit' => $product['unit'], 'time' => '2 menit lalu'],
                        ['user' => 'User B', 'price' => 26500, 'qty' => 120, 'unit' => $product['unit'], 'time' => '7 menit lalu'],
                        ['user' => 'User C', 'price' => 25000, 'qty' => 60, 'unit' => $product['unit'], 'time' => '12 menit lalu'],
                    ];
                @endphp

                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-[var(--brand)]">Negosiasi Terbuka</h2>
                    <span class="text-xs px-3 py-1 rounded-full chip text-[var(--ink)]">Terlihat oleh semua</span>
                </div>

                <div class="mt-4 bg-white/70 rounded-2xl p-4 space-y-3">
                    @foreach ($publicOffers as $offer)
                        <div class="bg-white rounded-2xl p-4 border border-white/80 flex items-center justify-between flex-wrap gap-3">
                            <div>
                                <p class="text-sm font-semibold">{{ $offer['user'] }}</p>
                                <p class="text-xs text-[var(--muted)]">Mengajukan tawaran baru</p>
                            </div>
                            <div class="text-sm text-[var(--muted)]">
                                Rp {{ number_format($offer['price']) }} / {{ $offer['unit'] }} - {{ $offer['qty'] }} {{ $offer['unit'] }}
                            </div>
                            <div class="text-xs text-[var(--muted)]">{{ $offer['time'] }}</div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="order-3 lg:order-none lg:col-span-4 glass-card rounded-3xl p-6 space-y-4">
                <h2 class="text-lg font-semibold text-[var(--brand)]">Ajukan Tawaran</h2>

                <div>
                    <label class="text-sm font-medium">Jumlah ({{ $product['unit'] }})</label>
                    <input id="qty" type="number" min="{{ $product['moq'] }}" value="{{ $product['moq'] }}"
                           class="mt-1 w-full border rounded-xl px-3 py-2">
                    <p class="text-xs text-[var(--muted)] mt-1">
                        MOQ: {{ $product['moq'] }} {{ $product['unit'] }}
                    </p>
                </div>

                <div>
                    <label class="text-sm font-medium">Harga tawaran per {{ $product['unit'] }}</label>
                    <input id="offerPrice" type="number" value="{{ $product['price_min'] }}"
                           class="mt-1 w-full border rounded-xl px-3 py-2">
                </div>

                <div>
                    <label class="text-sm font-medium">Mekanisme distribusi</label>
                    <select id="distribution" class="mt-1 w-full border rounded-xl px-3 py-2">
                        <option>Pickup di farm</option>
                        <option>Pengiriman terjadwal</option>
                        <option>Pengiriman harian</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Jadwal distribusi</label>
                    <input id="schedule" type="date" class="mt-1 w-full border rounded-xl px-3 py-2">
                </div>

                <div>
                    <label class="text-sm font-medium">Lokasi tujuan</label>
                    <input id="location" type="text" placeholder="Contoh: Pasar Induk, Jakarta"
                           class="mt-1 w-full border rounded-xl px-3 py-2">
                </div>

                <div class="bg-white/70 rounded-2xl p-4">
                    <p class="text-xs text-[var(--muted)]">Estimasi total</p>
                    <p id="estimate" class="text-lg font-semibold text-[var(--ink)]">Rp 0</p>
                </div>

                <button id="sendOfferBtn"
                        class="w-full bg-[var(--brand)] text-white py-2 rounded-full font-semibold hover:bg-[var(--brand-dark)] transition">
                    Kirim Tawaran
                </button>
            </section>

            <section class="order-4 lg:order-none lg:col-span-8 glass-card rounded-3xl p-6 flex flex-col">

                <div class="mt-6 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[var(--brand)]">Chat Negosiasi</h3>
                    <span id="negoStatus" class="text-sm text-[var(--muted)]">Menunggu tawaran.</span>
                </div>

                <div id="chatBox" class="mt-4 flex-1 overflow-y-auto space-y-3 bg-white/70 rounded-2xl p-4">
                    <div class="text-sm text-[var(--muted)]">
                        Sistem siap menerima negosiasi harga dan distribusi.
                    </div>
                </div>

                <div id="adminAction" class="mt-4 hidden gap-2">
                    <button id="acceptBtn"
                            class="bg-green-600 text-white px-4 py-2 rounded-full text-sm font-semibold">
                        Terima Tawaran
                    </button>
                    <button id="rejectBtn"
                            class="bg-red-600 text-white px-4 py-2 rounded-full text-sm font-semibold">
                        Tolak Tawaran
                    </button>
                </div>

                <div class="mt-4 flex gap-2">
                    <input id="chatInput" placeholder="Tulis pesan..."
                           class="flex-1 border rounded-full px-4 py-2">
                    <button id="sendMsgBtn"
                            class="bg-[var(--brand)] text-white px-5 py-2 rounded-full font-semibold hover:bg-[var(--brand-dark)] transition">
                        Kirim
                    </button>
                </div>
            </section>
        </div>
    </main>

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
        const maxPrice = {{ $product['price_max'] }};
        const unit = "{{ $product['unit'] }}";

        const livePriceEl = document.getElementById('livePrice');
        const qtyInput = document.getElementById('qty');
        const offerPriceInput = document.getElementById('offerPrice');
        const estimateEl = document.getElementById('estimate');
        const chatBox = document.getElementById('chatBox');
        const negoStatus = document.getElementById('negoStatus');
        const adminAction = document.getElementById('adminAction');
        const distribution = document.getElementById('distribution');
        const schedule = document.getElementById('schedule');
        const locationInput = document.getElementById('location');

        let lastOffer = null;

        function formatPrice(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        function updateLivePrice() {
            const next = Math.floor(Math.random() * (maxPrice - minPrice + 1)) + minPrice;
            livePriceEl.textContent = formatPrice(next);
        }

        function updateEstimate() {
            const qty = Number(qtyInput.value || 0);
            const price = Number(offerPriceInput.value || 0);
            estimateEl.textContent = formatPrice(qty * price);
        }

        function addMessage(sender, text) {
            const msg = document.createElement('div');
            msg.className = sender === 'buyer' ? 'flex justify-end' : 'flex justify-start';
            msg.innerHTML = `
                <div class="chat-bubble px-4 py-2 rounded-2xl text-sm ${
                    sender === 'buyer'
                        ? 'bg-[var(--brand)] text-white'
                        : 'bg-white border border-gray-200 text-[var(--ink)]'
                }">${text}</div>
            `;
            chatBox.appendChild(msg);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function sendOffer() {
            const qty = qtyInput.value;
            const price = offerPriceInput.value;
            const dist = distribution.value;
            const sched = schedule.value || 'Belum ditentukan';
            const loc = locationInput.value || 'Belum diisi';

            lastOffer = { qty, price, dist, sched, loc };

            addMessage('buyer',
                `Saya ajukan harga ${formatPrice(price)} per ${unit} untuk ${qty} ${unit}.
                Distribusi: ${dist}. Jadwal: ${sched}. Lokasi: ${loc}.`
            );

            negoStatus.textContent = 'Menunggu respon mitra...';
            adminAction.classList.remove('hidden');
        }

        function acceptOffer() {
            adminAction.classList.add('hidden');
            negoStatus.textContent = 'Tawaran diterima. Tim akan menghubungi Anda.';
            addMessage('supplier', 'Tawaran disetujui. Tim distribusi akan menghubungi Anda.');
        }

        function rejectOffer() {
            adminAction.classList.add('hidden');
            negoStatus.textContent = 'Tawaran ditolak. Silakan ajukan ulang.';
            addMessage('supplier', 'Tawaran ditolak. Silakan ajukan harga baru.');
        }

        function sendMessage() {
            const input = document.getElementById('chatInput');
            if (!input.value.trim()) return;
            addMessage('buyer', input.value);
            input.value = '';
            setTimeout(() => {
                addMessage('supplier', 'Baik, kami tanggapi.');
            }, 800);
        }

        document.getElementById('sendOfferBtn').addEventListener('click', sendOffer);
        document.getElementById('acceptBtn').addEventListener('click', acceptOffer);
        document.getElementById('rejectBtn').addEventListener('click', rejectOffer);
        document.getElementById('sendMsgBtn').addEventListener('click', sendMessage);
        qtyInput.addEventListener('input', updateEstimate);
        offerPriceInput.addEventListener('input', updateEstimate);

        updateEstimate();
        updateLivePrice();
        setInterval(updateLivePrice, 3000);
    </script>

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
</body>
</html>




