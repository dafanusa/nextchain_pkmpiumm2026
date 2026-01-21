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

        .admin-menu-link {
            transition: transform 0.15s ease, background-color 0.15s ease;
        }

        .admin-menu-link:active {
            transform: translateX(6px);
            background-color: rgba(255, 255, 255, 0.12);
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex overflow-x-hidden">
        <aside class="w-72 hidden lg:flex flex-col bg-[var(--brand)] text-white px-6 py-8 fixed top-0 left-0 h-screen">
            <div class="flex items-center justify-between">
                <span class="text-xl font-bold">NEXTCHAIN</span>
                <span class="text-xs uppercase tracking-[0.3em] text-white/70">Admin</span>
            </div>
            <nav class="mt-10 space-y-2 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="block px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.users.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    Users
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="block px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.products.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    Products
                </a>
                <a href="{{ route('admin.delivery-schedules.index') }}"
                   class="block px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.delivery-schedules.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    Delivery Schedules
                </a>
                <a href="{{ route('admin.offers.index') }}"
                   class="block px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.offers.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    Negotiations
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="block px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.orders.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    Orders
                </a>
                <a href="{{ route('admin.payments.index') }}"
                   class="block px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.payments.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    Payments
                </a>
                <a href="{{ route('admin.testimonials.index') }}"
                   class="block px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.testimonials.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    Testimonials
                </a>
                <a href="{{ route('admin.carts.index') }}"
                   class="block px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.carts.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    Carts
                </a>
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

        <div class="flex-1 min-w-0 lg:ml-72">
            <header class="bg-[var(--brand)] border-b border-[var(--brand-dark)] px-6 py-4 flex flex-wrap items-center justify-between gap-3 text-white">
                <div>
                    <h1 class="text-2xl font-semibold">Admin Panel</h1>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-white/80">Hai, {{ strtok(auth()->user()->name, ' ') }}</span>
                    <button id="adminMenuBtn"
                            class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-full border border-white/30 text-white hover:bg-white/10 transition"
                            aria-label="Menu admin">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="4" y1="6" x2="20" y2="6"></line>
                            <line x1="4" y1="12" x2="20" y2="12"></line>
                            <line x1="4" y1="18" x2="20" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </header>

            <div id="adminMobileMenu"
                 class="md:hidden fixed top-16 left-0 right-0 z-40 px-6 pb-4 space-y-2 text-sm text-white/90 bg-[var(--brand)] transition-all duration-300 ease-out max-h-0 opacity-0 -translate-y-2 pointer-events-none overflow-hidden">
                <a href="{{ route('admin.dashboard') }}" class="admin-menu-link block rounded-lg px-2 py-1">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="admin-menu-link block rounded-lg px-2 py-1">Users</a>
                <a href="{{ route('admin.products.index') }}" class="admin-menu-link block rounded-lg px-2 py-1">Products</a>
                <a href="{{ route('admin.delivery-schedules.index') }}" class="admin-menu-link block rounded-lg px-2 py-1">Delivery Schedules</a>
                <a href="{{ route('admin.offers.index') }}" class="admin-menu-link block rounded-lg px-2 py-1">Negotiations</a>
                <a href="{{ route('admin.orders.index') }}" class="admin-menu-link block rounded-lg px-2 py-1">Orders</a>
                <a href="{{ route('admin.payments.index') }}" class="admin-menu-link block rounded-lg px-2 py-1">Payments</a>
                <a href="{{ route('admin.testimonials.index') }}" class="admin-menu-link block rounded-lg px-2 py-1">Testimonials</a>
                <a href="{{ route('admin.carts.index') }}" class="admin-menu-link block rounded-lg px-2 py-1">Carts</a>
                <div class="pt-2 border-t border-white/10">
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-sm font-semibold text-white">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <main class="p-6 max-w-full overflow-x-auto">
                @yield('content')
            </main>
        </div>
    </div>
    <script>
        const adminMenuBtn = document.getElementById('adminMenuBtn');
        const adminMobileMenu = document.getElementById('adminMobileMenu');
        if (adminMenuBtn && adminMobileMenu) {
            adminMenuBtn.addEventListener('click', () => {
                adminMobileMenu.classList.toggle('max-h-0');
                adminMobileMenu.classList.toggle('opacity-0');
                adminMobileMenu.classList.toggle('-translate-y-2');
                adminMobileMenu.classList.toggle('pointer-events-none');
                adminMobileMenu.classList.toggle('max-h-[32rem]');
                adminMobileMenu.classList.toggle('opacity-100');
                adminMobileMenu.classList.toggle('translate-y-0');
                adminMobileMenu.classList.toggle('pointer-events-auto');
            });
        }
    </script>
</body>
</html>


