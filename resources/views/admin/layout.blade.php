<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Admin') - NEXTCHAIN</title>

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
                radial-gradient(1000px 500px at 85% -10%, #e0f2fe 0%, rgba(224, 242, 254, 0) 60%),
                var(--bg);
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex">
        <aside class="w-72 hidden lg:flex flex-col bg-[var(--brand)] text-white px-6 py-8 sticky top-0 h-screen">
            <div class="flex items-center justify-between">
                <span class="text-xl font-bold">NEXTCHAIN</span>
                <span class="text-xs uppercase tracking-[0.3em] text-white/70">Admin</span>
            </div>
            <nav class="mt-10 space-y-2 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-full hover:bg-white/10">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded-full hover:bg-white/10">Users</a>
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 rounded-full hover:bg-white/10">Products</a>
                <a href="{{ route('admin.delivery-schedules.index') }}" class="block px-4 py-2 rounded-full hover:bg-white/10">Delivery Schedules</a>
                <a href="{{ route('admin.offers.index') }}" class="block px-4 py-2 rounded-full hover:bg-white/10">Negotiations</a>
                <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 rounded-full hover:bg-white/10">Orders</a>
                <a href="{{ route('admin.payments.index') }}" class="block px-4 py-2 rounded-full hover:bg-white/10">Payments</a>
                <a href="{{ route('admin.testimonials.index') }}" class="block px-4 py-2 rounded-full hover:bg-white/10">Testimonials</a>
                <a href="{{ route('admin.carts.index') }}" class="block px-4 py-2 rounded-full hover:bg-white/10">Carts</a>
            </nav>
            <div class="mt-auto pt-6 space-y-3">
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2 rounded-full bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
                <div class="text-[11px] text-white/60 tracking-wide">
                    (c) 2026 NEXTCHAIN - PKM-PI UMM 2026
                </div>
            </div>
        </aside>

        <div class="flex-1">
            <header class="bg-white/80 border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-[var(--muted)]">Admin Panel</p>
                    <h1 class="text-2xl font-semibold">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-[var(--muted)]">Hai, {{ strtok(auth()->user()->name, ' ') }}</span>
                </div>
            </header>

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>


