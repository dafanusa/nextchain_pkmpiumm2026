<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - NEXTCHAIN</title>

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
                radial-gradient(1000px 500px at 90% -10%, #e0f2fe 0%, rgba(224, 242, 254, 0) 60%),
                radial-gradient(900px 400px at 0% 0%, rgba(59, 130, 246, 0.12), rgba(59, 130, 246, 0)),
                var(--bg);
        }

        .glass {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 24px 50px rgba(15, 61, 145, 0.12);
        }

        .panel {
            background: linear-gradient(135deg, rgba(15, 61, 145, 0.98), rgba(10, 45, 108, 0.96));
        }
    </style>
</head>

<body>
    @include('loading-overlay')
    <div id="top"></div>
    <main class="min-h-screen flex items-center justify-center px-6 py-12 relative overflow-hidden">
        <div class="pointer-events-none absolute -top-24 -left-24 h-64 w-64 rounded-full bg-blue-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-32 h-72 w-72 rounded-full bg-emerald-200/30 blur-3xl"></div>
        <div class="w-full max-w-5xl grid lg:grid-cols-[0.9fr_1.1fr] gap-8 items-stretch">
            <div class="glass rounded-[2.5rem] p-8">
                <div class="flex items-center justify-between">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                        <span class="text-lg font-semibold tracking-wide">NEXTCHAIN</span>                <img src="{{ asset('assets/Nextchainumm.png') }}" alt="Logo Nextchain" class="h-16 w-16 sm:h-16 sm:w-16 object-contain">
                    </a>
                    <span class="text-xs uppercase tracking-[0.35em] text-[var(--muted)]">Login</span>
                </div>
                <div class="space-y-2">
                    <h2 class="text-2xl font-semibold mt-6">Login</h2>
                    <p class="text-[var(--muted)] text-sm">
                        Masuk untuk melanjutkan transaksi dan negosiasi.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="mt-6 space-y-4" method="post" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label class="text-sm font-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="text-sm font-semibold">Password</label>
                        <input type="password" name="password" required
                               class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                    <label class="inline-flex items-center gap-2 text-sm text-[var(--muted)]">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-[var(--brand)] focus:ring-[var(--brand)]">
                        Ingat saya
                    </label>
                    <button type="submit"
                            class="w-full rounded-full bg-[var(--brand)] px-5 py-3 text-sm font-semibold text-white hover:bg-[var(--brand-dark)] transition">
                        Login
                    </button>
                </form>

                <div class="mt-6 text-sm text-[var(--muted)] hidden lg:block">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-[var(--brand)] font-semibold hover:text-[var(--brand-dark)]">
                        Daftar sekarang
                    </a>
                </div>
            </div>

            <div class="panel rounded-[2.5rem] text-white p-10 flex flex-col justify-between relative overflow-hidden">
                <img src="{{ asset('assets/ternakayam.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-20" aria-hidden="true">
                <div class="absolute inset-0 bg-gradient-to-b from-[#0f3d91]/70 via-[#0f3d91]/80 to-[#0a2d6c]/90"></div>
                <div class="relative space-y-6">
                    <div class="flex items-center gap-3 text-xs uppercase tracking-[0.4em] text-white/80">
                        <span>Nextchain</span>
                        <span class="h-1 w-1 rounded-full bg-white/70"></span>
                        <span>UMM</span>
                    </div>
                    <div class="flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold text-white/90">                <img src="{{ asset('assets/logoumm.png') }}" alt="Logo UMM" class="h-7 w-7 object-contain">
                        Universitas Muhammadiyah Malang
                    </div>
                    <h1 class="text-4xl font-bold leading-tight">Login untuk akses penawaran dan checkout lebih cepat.</h1>
                    <p class="text-white/80 text-base">
                        Pantau status negosiasi, riwayat pesanan, dan update harga langsung dari akunmu.
                    </p>
                </div>
                <div class="relative flex items-center justify-between text-sm text-white/80">
                    <span>UD. Ade Saputra Farm</span>
                    <a href="{{ route('home') }}" class="text-white hover:text-white/90 font-semibold">Kembali ke Home</a>
                </div>
            </div>

            <div class="lg:hidden text-center text-sm text-[var(--muted)]">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-[var(--brand)] font-semibold hover:text-[var(--brand-dark)]">
                    Daftar sekarang
                </a>
            </div>
        </div>
    </main>
    <a href="#top" class="lg:hidden fixed bottom-6 right-6 z-40 inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#0f3d91] text-white shadow-lg shadow-blue-900/30 hover:bg-[#0a2d6c] transition" aria-label="Kembali ke atas">
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 14l6-6 6 6" />
        </svg>
    </a></body>
</html>












