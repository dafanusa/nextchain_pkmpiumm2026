<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil - NEXTCHAIN</title>

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
                radial-gradient(900px 400px at 90% -10%, #e0f2fe 0%, rgba(224, 242, 254, 0) 60%),
                radial-gradient(800px 400px at 0% 10%, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0)),
                var(--bg);
        }

        .glass {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 24px 50px rgba(15, 61, 145, 0.12);
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
                <a href="{{ route('cart') }}" class="hover:text-white">Keranjang</a>
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
                <span class="hidden sm:inline-flex items-center px-4 py-2 rounded-full border border-white/40 text-sm font-semibold text-white">
                    Hai, {{ strtok($user->name, ' ') }}
                </span>
                <a href="{{ route('profile.show') }}"
                   class="hidden sm:inline-flex items-center justify-center h-9 w-9 rounded-full border border-white/40 text-white hover:bg-white/10 transition"
                   aria-label="Profil">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 21a8 8 0 0 0-16 0"></path>
                        <circle cx="12" cy="9" r="4"></circle>
                    </svg>
                </a>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="hidden sm:inline-flex items-center px-4 py-2 rounded-full bg-white text-[var(--brand)] text-sm font-semibold hover:bg-slate-100 transition">
                        Logout
                    </button>
                </form>
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
        <div id="mobileMenu"
             class="md:hidden fixed top-16 left-0 right-0 z-40 px-6 pb-4 space-y-2 text-sm text-white/90 bg-[var(--brand)] transition-all duration-300 ease-out max-h-0 opacity-0 -translate-y-2 pointer-events-none overflow-hidden">
            <a href="{{ route('home') }}" class="block">Home</a>
            <a href="{{ route('produk') }}" class="block">Produk</a>
            <a href="{{ route('negosiasi.list') }}" class="block">Negosiasi</a>
            <a href="{{ route('cart') }}" class="block">Keranjang</a>
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left text-sm font-semibold text-white">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-[var(--muted)]">Profil</p>
                <h1 class="text-3xl sm:text-4xl font-bold mt-2">Akun kamu</h1>
                <p class="text-[var(--muted)] mt-2 max-w-2xl">
                    Kelola data profil, foto, dan ringkasan aktivitas akunmu.
                </p>
            </div>
        </div>

        @if (session('success'))
            <div class="mt-6 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mt-6 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-8 grid lg:grid-cols-[0.75fr_1.25fr] gap-6 items-stretch">
            <div class="glass rounded-3xl p-6 space-y-6 h-full">
                <div class="flex items-center gap-4">
                    <div class="h-20 w-20 rounded-3xl bg-slate-100 overflow-hidden flex items-center justify-center text-2xl font-semibold text-[var(--brand)]">
                        @if ($profilePhotoUrl)
                            <img src="{{ $profilePhotoUrl }}" alt="Foto Profil" class="h-full w-full object-cover">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <p class="text-lg font-semibold">{{ $user->name }}</p>
                        <p class="text-sm text-[var(--muted)]">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-blue-50 to-white p-4 transition hover:-translate-y-1 hover:shadow-[0_12px_24px_rgba(15,61,145,0.12)]">
                        <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Riwayat order</p>
                        <p class="mt-2 text-xl font-semibold text-blue-700">{{ $ordersCount }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-indigo-50 to-white p-4 transition hover:-translate-y-1 hover:shadow-[0_12px_24px_rgba(15,61,145,0.12)]">
                        <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Total negosiasi</p>
                        <p class="mt-2 text-xl font-semibold text-indigo-700">{{ $offerSummary['total'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-amber-50 to-white p-4 transition hover:-translate-y-1 hover:shadow-[0_12px_24px_rgba(15,61,145,0.12)]">
                        <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Produk dibeli</p>
                        <p class="mt-2 text-xl font-semibold text-amber-700">{{ $totalProductsBought }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-emerald-50 to-white p-4 transition hover:-translate-y-1 hover:shadow-[0_12px_24px_rgba(15,61,145,0.12)]">
                        <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Loyalty points</p>
                        <p class="mt-2 text-xl font-semibold text-emerald-700">{{ $user->loyalty_points ?? 0 }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-emerald-50 to-white p-4 transition hover:-translate-y-1 hover:shadow-[0_12px_24px_rgba(15,61,145,0.12)]">
                        <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Negosiasi diterima</p>
                        <p class="mt-2 text-xl font-semibold text-emerald-600">{{ $offerSummary['accepted'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-amber-50 to-white p-4 transition hover:-translate-y-1 hover:shadow-[0_12px_24px_rgba(15,61,145,0.12)]">
                        <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Negosiasi pending</p>
                        <p class="mt-2 text-xl font-semibold text-amber-600">{{ $offerSummary['pending'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-rose-50 to-white p-4 transition hover:-translate-y-1 hover:shadow-[0_12px_24px_rgba(15,61,145,0.12)]">
                        <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Negosiasi ditolak</p>
                        <p class="mt-2 text-xl font-semibold text-rose-600">{{ $offerSummary['rejected'] }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-sky-50 to-white p-4 transition hover:-translate-y-1 hover:shadow-[0_12px_24px_rgba(15,61,145,0.12)]">
                        <p class="text-xs uppercase tracking-wider text-[var(--muted)]">Testimoni</p>
                        <p class="mt-2 text-xl font-semibold text-sky-700">{{ $testimonialsCount }}</p>
                    </div>
                </div>
            </div>

            <div class="glass rounded-3xl p-6 h-full flex flex-col">
                <h2 class="text-lg font-semibold">Edit Profil</h2>
                <p class="text-sm text-[var(--muted)] mt-1">
                    Email tidak bisa diubah. Jika ingin mengganti password, isi field di bawah.
                </p>

                <form class="mt-6 space-y-4 flex-1" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="text-sm font-semibold">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}"
                                   class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="text-sm font-semibold">Email</label>
                            <input type="email" value="{{ $user->email }}" disabled
                                   class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500">
                        </div>
                        <div>
                            <label class="text-sm font-semibold">Foto Profil</label>
                            <input type="file" name="profile_photo" accept="image/*"
                                   class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm bg-white">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-semibold">Password Baru</label>
                                <label class="inline-flex items-center gap-2 text-xs text-[var(--muted)]">
                                    <input type="checkbox" id="changePasswordToggle" class="rounded border-slate-300">
                                    Ubah password
                                </label>
                            </div>
                            <div class="mt-2 relative">
                                <input type="password" name="password" id="passwordField" disabled
                                       class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                                <button type="button" id="togglePassword"
                                        class="absolute inset-y-0 right-3 my-auto h-9 w-9 rounded-full border border-slate-200 text-slate-500 hover:text-slate-700 transition"
                                        aria-label="Tampilkan password">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5 mx-auto" fill="none" stroke="currentColor" stroke-width="1.8"
                                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-[var(--muted)]">Biarkan kosong jika tidak ingin mengganti.</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold">Konfirmasi Password</label>
                            <div class="mt-2 relative">
                                <input type="password" name="password_confirmation" id="passwordConfirmationField" disabled
                                       class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                                <button type="button" id="togglePasswordConfirm"
                                        class="absolute inset-y-0 right-3 my-auto h-9 w-9 rounded-full border border-slate-200 text-slate-500 hover:text-slate-700 transition"
                                        aria-label="Tampilkan konfirmasi password">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5 mx-auto" fill="none" stroke="currentColor" stroke-width="1.8"
                                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <button type="submit"
                                class="px-6 py-3 rounded-full bg-[var(--brand)] text-white font-semibold hover:bg-[var(--brand-dark)] transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
                @if ($profilePhotoUrl)
                    <form method="post" action="{{ route('profile.photo.destroy') }}" class="mt-4">
                        @csrf
                        @method('delete')
                        <button type="submit"
                                class="px-6 py-3 rounded-full border border-red-200 text-red-600 font-semibold hover:border-red-300 transition">
                            Hapus Foto Profil
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </main>

    <footer class="mt-16 border-t border-white/10 bg-[var(--brand)] text-white">
        <div class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-8 text-sm text-white/80">
            <div class="space-y-3">
                <p class="text-lg font-semibold text-white">NEXTCHAIN</p>
                <p>
                    Ringkas aktivitas akunmu, pantau negosiasi, dan kelola profil dengan cepat.
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
        const initialCartCount = {{ $cartCount ?? 0 }};
        function updateCartBadge(count) {
            cartCounts.forEach((badge) => {
                const nextCount = Number(count || 0);
                badge.textContent = nextCount;
                badge.classList.toggle('hidden', nextCount === 0);
            });
        }
        updateCartBadge(initialCartCount);

        const passwordField = document.getElementById('passwordField');
        const passwordConfirmField = document.getElementById('passwordConfirmationField');
        const togglePassword = document.getElementById('togglePassword');
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const changePasswordToggle = document.getElementById('changePasswordToggle');

        if (togglePassword && passwordField) {
            togglePassword.addEventListener('click', () => {
                passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
            });
        }

        if (togglePasswordConfirm && passwordConfirmField) {
            togglePasswordConfirm.addEventListener('click', () => {
                passwordConfirmField.type = passwordConfirmField.type === 'password' ? 'text' : 'password';
            });
        }

        if (changePasswordToggle && passwordField && passwordConfirmField) {
            changePasswordToggle.addEventListener('change', () => {
                const enabled = changePasswordToggle.checked;
                passwordField.disabled = !enabled;
                passwordConfirmField.disabled = !enabled;
                passwordField.classList.toggle('bg-slate-100', !enabled);
                passwordConfirmField.classList.toggle('bg-slate-100', !enabled);
                if (!enabled) {
                    passwordField.value = '';
                    passwordConfirmField.value = '';
                    passwordField.type = 'password';
                    passwordConfirmField.type = 'password';
                }
            });
        }
    </script>
</body>
</html>


