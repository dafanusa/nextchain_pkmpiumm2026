<!doctype html>
<html lang="id" class="overflow-x-hidden">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Negosiasi - {{ $product->name }}</title>

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

<body class="overflow-x-hidden">
    @include('loading-overlay')
    <div id="top"></div>
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-20 -left-24 h-64 w-64 rounded-full bg-orange-200/40 blur-3xl"></div>
        <div class="absolute top-20 right-0 h-72 w-72 rounded-full bg-blue-200/40 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 h-64 w-64 rounded-full bg-emerald-200/30 blur-3xl"></div>
    </div>
    <header class="sticky top-0 z-50 bg-[var(--brand)] text-white h-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
            <a href="{{ route('home') }}" class="text-xl sm:text-2xl font-bold tracking-tight inline-flex items-center gap-2 whitespace-nowrap">
                <span>NEXTCHAIN</span>
                <img src="{{ asset('assets/logoumm.png') }}" alt="Logo UMM" class="h-9 w-9 sm:h-12 sm:w-12 object-contain">
            </a>
            <nav class="hidden xl:flex items-center gap-5 text-sm font-medium text-white/80">
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
    </header>

    <div id="mobileMenu" class="xl:hidden fixed top-16 left-0 right-0 z-40 px-4 sm:px-6 pb-4 space-y-2 text-sm text-white/90 bg-[var(--brand)] mobile-menu transition-all duration-300 ease-out max-h-0 opacity-0 -translate-y-2 pointer-events-none overflow-hidden overflow-y-auto overflow-y-auto">
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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <div class="xl:hidden mb-4">
            <a href="{{ route('produk.detail', $product) }}"
               class="inline-flex items-center text-sm font-semibold text-[var(--brand)]">
                Kembali ke Detail Produk
            </a>
        </div>
        <div class="grid gap-6 sm:gap-8 lg:grid-cols-12">
            <section class="order-1 lg:order-none lg:col-span-4 glass-card rounded-3xl p-6">
                <h1 class="text-2xl font-bold">Negosiasi Harga</h1>
                <p class="text-[var(--muted)] mt-2">
                    {{ $product->name }} - {{ $product->supplier }}
                </p>
                @if ($acceptedOffer)
                    <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                        Tawaran diterima:
                        <span class="font-semibold">
                            {{ $acceptedOffer->user?->name ?? 'User' }}
                            - Rp {{ number_format($acceptedOffer->price) }} / {{ $product->unit }}
                        </span>
                    </div>
                @endif
                <div class="mt-4 bg-white/70 rounded-2xl p-4 accent-ring">
                    <p class="text-xs text-[var(--muted)]">Harga real-time</p>
                    <p id="livePrice" class="text-2xl font-bold text-[var(--brand)] mt-1">
                        Rp {{ number_format($product->price_min) }}
                    </p>
                    <p class="text-xs text-[var(--muted)] mt-2">
                        Rentang: Rp {{ number_format($product->price_min) }} - Rp {{ number_format($product->price_max) }}
                        / {{ $product->unit }}
                    </p>
                </div>
            </section>

            <section class="order-2 lg:order-none lg:col-span-8 glass-card rounded-3xl p-6 flex flex-col">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-[var(--brand)]">Negosiasi Terbuka</h2>
                    <span class="text-xs px-3 py-1 rounded-full chip text-[var(--ink)]">Terlihat oleh semua</span>
                    </div>

                <div class="mt-4 bg-white/70 rounded-2xl p-4 space-y-3">
                    @forelse ($offers as $offer)
                        <div class="bg-white rounded-2xl p-4 border border-white/80 flex items-center justify-between flex-wrap gap-3">
                            <div>
                                <p class="text-sm font-semibold">{{ $offer->user?->name ?? 'User' }}</p>
                                <p class="text-xs text-[var(--muted)]">
                                    {{ $offer->channel === 'bid' ? 'Tawaran cepat' : 'Tawaran chat' }}
                                </p>
                            </div>
                            <div class="text-sm text-[var(--muted)]">
                                Rp {{ number_format($offer->price) }} / {{ $product->unit }} - {{ $offer->qty }} {{ $product->unit }}
                            </div>
                            <div class="text-xs font-semibold
                                @if ($offer->status === 'accepted') text-emerald-600
                                @elseif ($offer->status === 'rejected') text-red-500
                                @else text-[var(--muted)]
                                @endif">
                                {{ ucfirst($offer->status) }}
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-[var(--muted)]">Belum ada tawaran.</div>
                    @endforelse
                </div>
            </section>

            <section class="order-3 lg:order-none lg:col-span-4 glass-card rounded-3xl p-6 space-y-4">
                <div class="space-y-3">
                    <div>
                        <h3 class="text-sm font-semibold text-[var(--brand)]">Negosiasi Instan (Lelang)</h3>
                        <p class="text-xs text-[var(--muted)]">
                            Pilih harga di rentang Rp {{ number_format($product->price_min) }} - Rp {{ number_format($product->price_max) }}.
                        </p>
                    </div>
                    <div>
                        <input id="bidRange" type="range" min="{{ $product->price_min }}" max="{{ $product->price_max }}"
                               value="{{ $product->price_min }}" class="w-full">
                        <div class="flex items-center justify-between text-xs text-[var(--muted)] mt-1">
                            <span>Rp {{ number_format($product->price_min) }}</span>
                    <span>Rp {{ number_format($product->price_max) }}</span>
                    </div>
                    </div>
                    <div class="bg-white/70 rounded-2xl p-4">
                        <p class="text-xs text-[var(--muted)]">Harga pilihan</p>
                        <p id="bidValue" class="text-lg font-semibold text-[var(--ink)]">Rp 0</p>
                    </div>
                    @auth
                        <button id="sendBidBtn"
                                class="w-full bg-[var(--brand)] text-white py-2 rounded-full font-semibold hover:bg-[var(--brand-dark)] transition">
                            Kirim Tawaran Instan
                        </button>
                        <p id="bidStatus" class="text-xs text-[var(--muted)] text-center"></p>
                    @else
                        <div class="rounded-2xl border border-slate-200 bg-white/80 p-3 text-sm text-[var(--muted)]">
                            Login dulu untuk mengajukan tawaran instan.
                            <a href="{{ route('login') }}" class="text-[var(--brand)] font-semibold">Ke halaman login</a>
                        </div>
                    @endauth
                </div>

                <div class="border-t border-dashed border-white/70 pt-4 space-y-4">
                    <h2 class="text-lg font-semibold text-[var(--brand)]">Ajukan Tawaran</h2>

                    <div>
                        <label class="text-sm font-medium">Jumlah ({{ $product->unit }})</label>
                        <input id="qty" type="number" min="{{ $product->moq }}" value="{{ $product->moq }}"
                               class="mt-1 w-full border rounded-xl px-3 py-2">
                        <p class="text-xs text-[var(--muted)] mt-1">
                            MOQ: {{ $product->moq }} {{ $product->unit }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Harga tawaran per {{ $product->unit }}</label>
                        <input id="offerPrice" type="number" value="{{ $product->price_min }}"
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

                    @auth
                        <button id="sendOfferBtn"
                                class="w-full bg-[var(--brand)] text-white py-2 rounded-full font-semibold hover:bg-[var(--brand-dark)] transition">
                            Kirim Tawaran
                        </button>
                    @else
                        <div class="rounded-2xl border border-slate-200 bg-white/80 p-3 text-sm text-[var(--muted)]">
                            Login dulu untuk mengajukan tawaran.
                            <a href="{{ route('login') }}" class="text-[var(--brand)] font-semibold">Ke halaman login</a>
                        </div>
                    @endauth
                </div>
            </section>

            <section class="order-4 lg:order-none lg:col-span-8 glass-card rounded-3xl p-6 flex flex-col">

                <div class="mt-6 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[var(--brand)]">Chat Negosiasi</h3>
                    <span id="negoStatus" class="text-sm text-[var(--muted)]">Menunggu tawaran.</span>
                    </div>

                <div id="chatBox" class="mt-4 flex-1 overflow-y-auto space-y-3 bg-white/70 rounded-2xl p-4">
                    @if (($messages ?? collect())->isEmpty())
                        <div class="text-sm text-[var(--muted)]">
                            Sistem siap menerima negosiasi harga dan distribusi.
                        </div>
                    @else
                        @foreach ($messages as $message)
                            <div class="{{ $message->sender_role === 'buyer' ? 'flex justify-end' : 'flex justify-start' }}">
                                <div class="chat-bubble px-4 py-2 rounded-2xl text-sm {{ $message->sender_role === 'buyer' ? 'bg-[var(--brand)] text-white' : 'bg-white border border-gray-200 text-[var(--ink)]' }}">
                                    {{ $message->message }}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                @auth
                <div class="mt-4 flex flex-col sm:flex-row gap-2">
                    <input id="chatInput" placeholder="Tulis pesan..."
                           class="flex-1 border rounded-full px-4 py-2">
                    <button id="sendMsgBtn"
                            class="w-full sm:w-auto bg-[var(--brand)] text-white px-5 py-2 rounded-full font-semibold hover:bg-[var(--brand-dark)] transition">
                        Kirim
                    </button>
                </div>
                @else
                    <div class="mt-4 rounded-2xl border border-slate-200 bg-white/80 p-3 text-sm text-[var(--muted)]">
                        Login dulu untuk mengirim pesan negosiasi.
                        <a href="{{ route('login') }}" class="text-[var(--brand)] font-semibold">Ke halaman login</a>
                    </div>
                @endauth
            </section>
        </div>
    </main>

    <div id="toast" class="fixed top-6 right-6 z-50 max-w-xs rounded-2xl bg-white px-4 py-3 text-sm text-[var(--ink)] shadow-xl border border-slate-200 opacity-0 -translate-y-3 pointer-events-none transition-all duration-300">
        <div id="toastText"></div>
    </div>

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
        const maxPrice = {{ $product->price_max }};
        const minPrice = {{ $product->price_min }};
        const unit = "{{ $product->unit }}";
        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
        const loginUrl = "{{ route('login') }}";
        let currentOfferStatus = "{{ $userOffer?->status ?? '' }}";

        const livePriceEl = document.getElementById('livePrice');
        const qtyInput = document.getElementById('qty');
        const offerPriceInput = document.getElementById('offerPrice');
        const estimateEl = document.getElementById('estimate');
        const chatBox = document.getElementById('chatBox');
        const negoStatus = document.getElementById('negoStatus');
        const distribution = document.getElementById('distribution');
        const schedule = document.getElementById('schedule');
        const locationInput = document.getElementById('location');
        const bidRange = document.getElementById('bidRange');
        const bidValue = document.getElementById('bidValue');
        const bidStatus = document.getElementById('bidStatus');
        const toast = document.getElementById('toast');
        const toastText = document.getElementById('toastText');
        let toastTimer = null;

        let activeOfferId = {{ $userOffer?->id ?? 'null' }};

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

        function updateBidValue() {
            if (!bidRange || !bidValue) {
                return;
            }
            bidValue.textContent = formatPrice(bidRange.value);
        }

        function updateNegotiationStatus() {
            if (!negoStatus) {
                return;
            }
            if (currentOfferStatus === 'accepted') {
                negoStatus.textContent = 'Tawaran kamu diterima.';
                return;
            }
            if (currentOfferStatus === 'rejected') {
                negoStatus.textContent = 'Tawaran kamu ditolak.';
                return;
            }
            negoStatus.textContent = 'Menunggu respon mitra...';
        }

        function sendOffer() {
            if (!isAuthenticated) {
                window.location.href = loginUrl;
                return;
            }
            const qty = qtyInput.value;
            const price = offerPriceInput.value;
            const dist = distribution.value;
            const sched = schedule.value || 'Belum ditentukan';
            const loc = locationInput.value || 'Belum diisi';

            addMessage('buyer',
                `Saya ajukan harga ${formatPrice(price)} per ${unit} untuk ${qty} ${unit}.
                Distribusi: ${dist}. Jadwal: ${sched}. Lokasi: ${loc}.`
            );

            fetch("{{ route('produk.negosiasi.store', $product->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify({
                    price: Number(price),
                    qty: Number(qty),
                    channel: 'chat',
                    note: `${dist} | ${sched} | ${loc}`,
                }),
            }).then(async (response) => {
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Gagal mengirim tawaran.');
                }
                return data;
            }).then((data) => {
                    if (data.offer_id) {
                        activeOfferId = data.offer_id;
                    }
                    if (data.status) {
                        currentOfferStatus = data.status;
                    }
                    updateNegotiationStatus();
                    showToast('Tawaran berhasil dikirim.');
                }).catch((error) => {
                    negoStatus.textContent = error.message;
                    showToast(error.message);
                });
        }

        function sendBid() {
            if (!isAuthenticated) {
                window.location.href = loginUrl;
                return;
            }
            const price = Number(bidRange.value || 0);
            const qty = Number(qtyInput.value || 0);
            if (!price || !qty) {
                if (bidStatus) {
                    bidStatus.textContent = 'Isi jumlah terlebih dulu.';
                }
                return;
            }
            if (bidStatus) {
                bidStatus.textContent = 'Mengirim tawaran...';
            }
            fetch("{{ route('produk.negosiasi.store', $product->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify({
                    price,
                    qty,
                    channel: 'bid',
                }),
            }).then(async (response) => {
                const contentType = response.headers.get('content-type') || '';
                const data = contentType.includes('application/json')
                    ? await response.json()
                    : { message: 'Gagal mengirim tawaran instan.' };
                if (!response.ok) {
                    throw new Error(data.message || 'Gagal mengirim tawaran instan.');
                }
                return data;
            }).then((data) => {
                    if (data.offer_id) {
                        activeOfferId = data.offer_id;
                    }
                    if (data.status) {
                        currentOfferStatus = data.status;
                    }
                    updateNegotiationStatus();
                    if (bidStatus) {
                        bidStatus.textContent = 'Tawaran instan terkirim.';
                    }
                    showToast('Tawaran instan berhasil dikirim.');
                }).catch((error) => {
                    negoStatus.textContent = error.message;
                    if (bidStatus) {
                        bidStatus.textContent = error.message;
                    }
                    showToast(error.message);
                });
        }

        function sendMessage() {
            const input = document.getElementById('chatInput');
            if (!input.value.trim()) return;
            if (!activeOfferId) {
                negoStatus.textContent = 'Kirim tawaran dulu sebelum chat.';
                return;
            }
            const messageText = input.value;
            addMessage('buyer', messageText);
            input.value = '';
            fetch("{{ route('produk.negosiasi.message', $product->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify({
                    offer_id: activeOfferId,
                    message: messageText,
                }),
            }).then(async (response) => {
                if (!response.ok) {
                    const data = await response.json();
                    throw new Error(data.message || 'Gagal mengirim pesan.');
                }
                updateNegotiationStatus();
                showToast('Pesan terkirim.');
            }).catch((error) => {
                negoStatus.textContent = error.message;
                showToast(error.message);
            });
        }

        const sendOfferBtn = document.getElementById('sendOfferBtn');
        if (sendOfferBtn) {
            sendOfferBtn.addEventListener('click', sendOffer);
        }
        const sendBidBtn = document.getElementById('sendBidBtn');
        if (sendBidBtn) {
            sendBidBtn.addEventListener('click', sendBid);
        }
        const sendMsgBtn = document.getElementById('sendMsgBtn');
        if (sendMsgBtn) {
            sendMsgBtn.addEventListener('click', sendMessage);
        }
        qtyInput.addEventListener('input', updateEstimate);
        offerPriceInput.addEventListener('input', updateEstimate);
        if (bidRange) {
            bidRange.addEventListener('input', updateBidValue);
        }

        updateEstimate();
        updateLivePrice();
        updateBidValue();
        updateNegotiationStatus();
        setInterval(updateLivePrice, 3000);
    </script>

    <footer class="mt-16 border-t border-white/10 bg-[var(--brand)] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 grid md:grid-cols-3 gap-8 text-sm text-white/80">
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
    <a href="#top" class="lg:hidden fixed bottom-6 right-6 z-40 inline-flex h-11 w-11 items-center justify-center rounded-full bg-[#0f3d91] text-white shadow-lg shadow-blue-900/30 hover:bg-[#0a2d6c] transition" aria-label="Kembali ke atas">
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 14l6-6 6 6" />
        </svg>
    </a></body>
</html>
































