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
    </style>
</head>

<body>
    <main class="min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-5xl grid lg:grid-cols-[0.9fr_1.1fr] gap-8 items-stretch">
            <div class="glass rounded-[2.5rem] p-8">
                <div class="space-y-2">
                    <h2 class="text-2xl font-semibold">Login</h2>
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

            <div class="rounded-[2.5rem] bg-[var(--brand)] text-white p-10 flex flex-col justify-between">
                <div class="space-y-4">
                    <p class="text-xs uppercase tracking-[0.4em] text-white/70">NEXTCHAIN</p>
                    <h1 class="text-4xl font-bold leading-tight">Login untuk akses penawaran dan checkout lebih cepat.</h1>
                    <p class="text-white/75 text-base">
                        Pantau status negosiasi dan riwayat pesanan langsung dari akunmu.
                    </p>
                </div>
                <div class="flex items-center justify-between text-sm text-white/70">
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
</body>
</html>
