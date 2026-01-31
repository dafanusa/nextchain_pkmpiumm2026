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

        .admin-mobile-open {
            max-height: calc(100vh - 4rem);
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .page-loading-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(900px 450px at 15% 10%, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0) 60%),
                linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
            backdrop-filter: blur(3px);
            opacity: 0;
            visibility: hidden;
            transition: opacity 180ms ease, visibility 180ms ease;
        }

        .page-loading-overlay.is-active {
            opacity: 1;
            visibility: visible;
        }

        .page-loading-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            transform: translateY(16px) scale(0.98);
            opacity: 0;
            transition: transform 320ms ease, opacity 320ms ease;
        }

        .page-loading-overlay.is-active .page-loading-content {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .page-loading-spinner {
            width: 86px;
            height: 86px;
            border-radius: 9999px;
            border: 5px solid rgba(255, 255, 255, 0.25);
            border-top-color: #ffffff;
            border-right-color: rgba(255, 255, 255, 0.85);
            box-shadow:
                0 0 0 6px rgba(255, 255, 255, 0.08),
                0 20px 45px rgba(10, 45, 108, 0.45);
            animation: page-loading-spin 0.9s linear infinite;
        }

        .page-loading-text {
            font-size: clamp(2.6rem, 6vw, 4.25rem);
            font-weight: 800;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: #ffffff;
            text-shadow:
                0 12px 30px rgba(10, 45, 108, 0.55),
                0 0 18px rgba(255, 255, 255, 0.18);
            animation: page-loading-text-enter 620ms cubic-bezier(0.2, 0.7, 0.2, 1) both;
        }

        @keyframes page-loading-spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes page-loading-text-enter {
            from {
                transform: translateY(18px) scale(0.96);
                opacity: 0;
                filter: blur(4px);
            }
            to {
                transform: translateY(0) scale(1);
                opacity: 1;
                filter: blur(0);
            }
        }
    </style>
</head>
<body data-disable-loading="true">
    <div id="pageLoadingOverlay" class="page-loading-overlay" role="status" aria-live="polite" aria-label="Loading">
        <div class="page-loading-content">
            <div class="page-loading-spinner" aria-hidden="true"></div>
            <div class="page-loading-text">NEXTCHAIN</div>
        </div>
    </div>
    <div class="min-h-screen flex items-start overflow-x-hidden">
        <aside class="w-72 hidden lg:flex flex-col bg-[var(--brand)] text-white px-6 py-8 fixed top-0 left-0 h-screen overflow-y-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-xl font-bold">NEXTCHAIN</span>
                </div>
                <span class="text-xs uppercase tracking-[0.3em] text-white/70">Admin</span>
            </div>
            <nav class="mt-10 space-y-2 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 13h7V3H3zM14 21h7v-8h-7zM14 3h7v6h-7zM3 21h7v-6H3z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <div class="rounded-3xl {{ request()->routeIs('admin.users.*') ? 'bg-white/10 border border-white/10' : '' }}" data-admin-submenu-wrap="users">
                <button type="button"
                            class="w-full flex items-center justify-between px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.users.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}"
                            data-admin-submenu="users">
                        <span class="flex items-center gap-3">
                            <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M20 21a8 8 0 0 0-16 0"></path>
                                <circle cx="12" cy="9" r="4"></circle>
                            </svg>
                            <span>Users</span>
                        </span>
                        <svg data-admin-submenu-caret viewBox="0 0 24 24" class="h-4 w-4 transition-transform {{ request()->routeIs('admin.users.*') ? 'rotate-180' : '' }}"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M6 9l6 6 6-6"></path>
                        </svg>
                    </button>
                    <div class="pl-4 pr-2 pb-3 space-y-1 {{ request()->routeIs('admin.users.*') ? '' : 'hidden' }}" data-admin-submenu-panel="users">
                        <a href="{{ route('admin.users.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-full text-xs hover:bg-white/10 {{ request()->routeIs('admin.users.index') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                            <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                                <path d="M8 9h8M8 13h6"></path>
                            </svg>
                            Users List
                        </a>
                        <a href="{{ route('admin.users.detail') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-full text-xs hover:bg-white/10 {{ request()->routeIs('admin.users.detail') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                            <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="4" y="3" width="16" height="18" rx="3"></rect>
                                <path d="M9 9h6M9 13h6M9 17h4"></path>
                            </svg>
                            Detail User
                        </a>
                    </div>
                </div>
                <div class="rounded-3xl {{ (request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.price')) || request()->routeIs('admin.carts.*') ? 'bg-white/10 border border-white/10' : '' }}" data-admin-submenu-wrap="products">
                    <button type="button"
                            class="w-full flex items-center justify-between px-4 py-2 rounded-full hover:bg-white/10 {{ (request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.price')) || request()->routeIs('admin.carts.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}"
                            data-admin-submenu="products">
                        <span class="flex items-center gap-3">
                            <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M20 7H4l8-4 8 4z"></path>
                                <path d="M4 7h16v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"></path>
                                <path d="M12 7v12"></path>
                            </svg>
                            <span>Products</span>
                        </span>
                        <svg data-admin-submenu-caret viewBox="0 0 24 24" class="h-4 w-4 transition-transform {{ (request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.price')) || request()->routeIs('admin.carts.*') ? 'rotate-180' : '' }}"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M6 9l6 6 6-6"></path>
                        </svg>
                    </button>
                    <div class="pl-4 pr-2 pb-3 space-y-1 {{ (request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.price')) || request()->routeIs('admin.carts.*') ? '' : 'hidden' }}" data-admin-submenu-panel="products">
                        <a href="{{ route('admin.products.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-full text-xs hover:bg-white/10 {{ request()->routeIs('admin.products.index') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                            <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M20 7H4l8-4 8 4z"></path>
                                <path d="M4 7h16v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"></path>
                            </svg>
                            List Produk
                        </a>
                        <a href="{{ route('admin.carts.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-full text-xs hover:bg-white/10 {{ request()->routeIs('admin.carts.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                            <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="9" cy="20" r="1.5"></circle>
                                <circle cx="17" cy="20" r="1.5"></circle>
                                <path d="M3 4h2l2.2 10.5a2 2 0 0 0 2 1.5h7.5a2 2 0 0 0 2-1.6L21 8H7.2"></path>
                            </svg>
                            List Carts
                        </a>
                    </div>
                </div>
                <div class="rounded-3xl {{ request()->routeIs('admin.products.price') || request()->routeIs('admin.price-histories.*') ? 'bg-white/10 border border-white/10' : '' }}" data-admin-submenu-wrap="prices">
                    <button type="button"
                            class="w-full flex items-center justify-between px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.products.price') || request()->routeIs('admin.price-histories.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}"
                            data-admin-submenu="prices">
                        <span class="flex items-center gap-3">
                            <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 1.5v21"></path>
                                <path d="M16 6.5c0-2-1.8-3.5-4-3.5s-4 1.5-4 3.5 1.8 3.5 4 3.5 4 1.5 4 3.5-1.8 3.5-4 3.5-4-1.5-4-3.5"></path>
                            </svg>
                            <span>Harga</span>
                        </span>
                        <svg data-admin-submenu-caret viewBox="0 0 24 24" class="h-4 w-4 transition-transform {{ request()->routeIs('admin.products.price') || request()->routeIs('admin.price-histories.*') ? 'rotate-180' : '' }}"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M6 9l6 6 6-6"></path>
                        </svg>
                    </button>
                    <div class="pl-4 pr-2 pb-3 space-y-1 {{ request()->routeIs('admin.products.price') || request()->routeIs('admin.price-histories.*') ? '' : 'hidden' }}" data-admin-submenu-panel="prices">
                        <a href="{{ route('admin.products.price') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-full text-xs hover:bg-white/10 {{ request()->routeIs('admin.products.price') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                            <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 6v12"></path>
                                <path d="M9 9l3-3 3 3"></path>
                            </svg>
                            Update Harga
                        </a>
                        <a href="{{ route('admin.price-histories.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-full text-xs hover:bg-white/10 {{ request()->routeIs('admin.price-histories.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                            <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M7 4v16"></path>
                                <path d="M11 8h8"></path>
                                <path d="M11 12h8"></path>
                                <path d="M11 16h6"></path>
                            </svg>
                            Riwayat Harga
                        </a>
                    </div>
                </div>
                <div class="rounded-3xl {{ request()->routeIs('admin.financial-reports.*') || request()->routeIs('admin.expenses.*') ? 'bg-white/10 border border-white/10' : '' }}" data-admin-submenu-wrap="reports">
                    <button type="button"
                            class="w-full flex items-center justify-between px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.financial-reports.*') || request()->routeIs('admin.expenses.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}"
                            data-admin-submenu="reports">
                        <span class="flex items-center gap-3">
                            <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M4 19h16"></path>
                                <path d="M7 16V8"></path>
                                <path d="M12 16V5"></path>
                                <path d="M17 16v-3"></path>
                            </svg>
                            <span>Laporan Keuangan</span>
                        </span>
                        <svg data-admin-submenu-caret viewBox="0 0 24 24" class="h-4 w-4 transition-transform {{ request()->routeIs('admin.financial-reports.*') || request()->routeIs('admin.expenses.*') ? 'rotate-180' : '' }}"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M6 9l6 6 6-6"></path>
                        </svg>
                    </button>
                    <div class="pl-4 pr-2 pb-3 space-y-1 {{ request()->routeIs('admin.financial-reports.*') || request()->routeIs('admin.expenses.*') ? '' : 'hidden' }}" data-admin-submenu-panel="reports">
                        <a href="{{ route('admin.financial-reports.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-full text-xs hover:bg-white/10 {{ request()->routeIs('admin.financial-reports.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                            <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 19V5"></path>
                                <path d="M8 9l4-4 4 4"></path>
                                <path d="M6 19h12"></path>
                            </svg>
                            Laporan Pemasukan
                        </a>
                        <a href="{{ route('admin.expenses.index') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-full text-xs hover:bg-white/10 {{ request()->routeIs('admin.expenses.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                            <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 5v14"></path>
                                <path d="M8 15l4 4 4-4"></path>
                                <path d="M6 5h12"></path>
                            </svg>
                            Laporan Pengeluaran
                        </a>
                    </div>
                </div>
                <a href="{{ route('admin.delivery-schedules.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.delivery-schedules.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                        <path d="M16 2v4M8 2v4M3 10h18"></path>
                    </svg>
                    Delivery Schedules
                </a>
                <a href="{{ route('admin.offers.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.offers.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 5h16a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H9l-5 4v-4H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"></path>
                    </svg>
                    Negotiations
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.orders.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 4h12l2 4H4l2-4z"></path>
                        <path d="M4 8h16v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"></path>
                    </svg>
                    Orders
                </a>
                <a href="{{ route('admin.payments.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.payments.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                        <path d="M3 10h18"></path>
                        <path d="M7 15h4"></path>
                    </svg>
                    Payments
                </a>
                <a href="{{ route('admin.testimonials.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-white/10 {{ request()->routeIs('admin.testimonials.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 15a4 4 0 0 1-4 4H7l-4 3v-3a4 4 0 0 1-4-4V6a4 4 0 0 1 4-4h14a4 4 0 0 1 4 4z"></path>
                        <path d="M8 10h8M8 14h6"></path>
                    </svg>
                    Testimonials
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

        <div class="flex-1 min-w-0 lg:pl-72">
            <header class="sticky top-0 z-50 bg-[var(--brand)] border-b border-[var(--brand-dark)] px-4 sm:px-6 h-16 flex flex-wrap items-center justify-between gap-3 text-white relative shadow-sm">
                <div>
                    <h1 class="text-2xl font-semibold">Admin Panel</h1>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-white/80">Hai, {{ strtok(auth()->user()->name, ' ') }}</span>
                    <button id="adminMenuBtn"
                            class="lg:hidden inline-flex items-center justify-center h-9 w-9 rounded-full border border-white/30 text-white hover:bg-white/10 transition"
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
                 class="lg:hidden fixed top-16 left-0 right-0 z-40 px-6 pb-4 space-y-2 text-sm text-white/90 bg-[var(--brand)] transition-all duration-300 ease-out max-h-0 opacity-0 -translate-y-2 pointer-events-none overflow-hidden overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 13h7V3H3zM14 21h7v-8h-7zM14 3h7v6h-7zM3 21h7v-6H3z"></path>
                    </svg>
                    Dashboard
                </a>
                <button type="button"
                        class="admin-menu-link flex w-full items-center justify-between rounded-lg px-2 py-1"
                        data-admin-submenu="users-mobile">
                    <span class="flex items-center gap-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 21a8 8 0 0 0-16 0"></path>
                            <circle cx="12" cy="9" r="4"></circle>
                        </svg>
                        Users
                    </span>
                    <svg data-admin-submenu-caret viewBox="0 0 24 24" class="h-4 w-4 transition-transform {{ request()->routeIs('admin.users.*') ? 'rotate-180' : '' }}"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 9l6 6 6-6"></path>
                    </svg>
                </button>
                <div class="pl-2 space-y-1 {{ request()->routeIs('admin.users.*') ? '' : 'hidden' }}" data-admin-submenu-panel="users-mobile">
                    <a href="{{ route('admin.users.index') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1 text-xs">
                        <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                            <path d="M8 9h8M8 13h6"></path>
                        </svg>
                        Users List
                    </a>
                    <a href="{{ route('admin.users.detail') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1 text-xs">
                        <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="4" y="3" width="16" height="18" rx="3"></rect>
                            <path d="M9 9h6M9 13h6M9 17h4"></path>
                        </svg>
                        Detail User
                    </a>
                </div>
                <button type="button"
                        class="admin-menu-link flex w-full items-center justify-between rounded-lg px-2 py-1 {{ (request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.price')) || request()->routeIs('admin.carts.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}"
                        data-admin-submenu="products-mobile">
                    <span class="flex items-center gap-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 7H4l8-4 8 4z"></path>
                            <path d="M4 7h16v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"></path>
                            <path d="M12 7v12"></path>
                        </svg>
                        Products
                    </span>
                    <svg data-admin-submenu-caret viewBox="0 0 24 24" class="h-4 w-4 transition-transform {{ (request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.price')) || request()->routeIs('admin.carts.*') ? 'rotate-180' : '' }}"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 9l6 6 6-6"></path>
                    </svg>
                </button>
                <div class="pl-2 space-y-1 {{ (request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.price')) || request()->routeIs('admin.carts.*') ? '' : 'hidden' }}" data-admin-submenu-panel="products-mobile">
                    <a href="{{ route('admin.products.index') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1 text-xs {{ request()->routeIs('admin.products.index') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                        <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 7H4l8-4 8 4z"></path>
                            <path d="M4 7h16v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"></path>
                        </svg>
                        List Produk
                    </a>
                    <a href="{{ route('admin.carts.index') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1 text-xs {{ request()->routeIs('admin.carts.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                        <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="9" cy="20" r="1.5"></circle>
                            <circle cx="17" cy="20" r="1.5"></circle>
                            <path d="M3 4h2l2.2 10.5a2 2 0 0 0 2 1.5h7.5a2 2 0 0 0 2-1.6L21 8H7.2"></path>
                        </svg>
                        List Carts
                    </a>
                </div>
                <button type="button"
                        class="admin-menu-link flex w-full items-center justify-between rounded-lg px-2 py-1"
                        data-admin-submenu="prices-mobile">
                    <span class="flex items-center gap-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 1.5v21"></path>
                            <path d="M16 6.5c0-2-1.8-3.5-4-3.5s-4 1.5-4 3.5 1.8 3.5 4 3.5 4 1.5 4 3.5-1.8 3.5-4 3.5-4-1.5-4-3.5"></path>
                        </svg>
                        Harga
                    </span>
                    <svg data-admin-submenu-caret viewBox="0 0 24 24" class="h-4 w-4 transition-transform"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 9l6 6 6-6"></path>
                    </svg>
                </button>
                <div class="pl-2 space-y-1 hidden" data-admin-submenu-panel="prices-mobile">
                    <a href="{{ route('admin.products.price') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1 text-xs {{ request()->routeIs('admin.products.price') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                        <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 6v12"></path>
                            <path d="M9 9l3-3 3 3"></path>
                        </svg>
                        Update Harga
                    </a>
                    <a href="{{ route('admin.price-histories.index') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1 text-xs {{ request()->routeIs('admin.price-histories.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                        <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M7 4v16"></path>
                            <path d="M11 8h8"></path>
                            <path d="M11 12h8"></path>
                            <path d="M11 16h6"></path>
                        </svg>
                        Riwayat Harga
                    </a>
                </div>
                <button type="button"
                        class="admin-menu-link flex w-full items-center justify-between rounded-lg px-2 py-1"
                        data-admin-submenu="reports-mobile">
                    <span class="flex items-center gap-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 19h16"></path>
                            <path d="M7 16V8"></path>
                            <path d="M12 16V5"></path>
                            <path d="M17 16v-3"></path>
                        </svg>
                        Laporan Keuangan
                    </span>
                    <svg data-admin-submenu-caret viewBox="0 0 24 24" class="h-4 w-4 transition-transform {{ request()->routeIs('admin.financial-reports.*') || request()->routeIs('admin.expenses.*') ? 'rotate-180' : '' }}"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 9l6 6 6-6"></path>
                    </svg>
                </button>
                <div class="pl-2 space-y-1 {{ request()->routeIs('admin.financial-reports.*') || request()->routeIs('admin.expenses.*') ? '' : 'hidden' }}" data-admin-submenu-panel="reports-mobile">
                    <a href="{{ route('admin.financial-reports.index') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1 text-xs {{ request()->routeIs('admin.financial-reports.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                        <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 19V5"></path>
                            <path d="M8 9l4-4 4 4"></path>
                            <path d="M6 19h12"></path>
                        </svg>
                        Laporan Pemasukan
                    </a>
                    <a href="{{ route('admin.expenses.index') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1 text-xs {{ request()->routeIs('admin.expenses.*') ? 'bg-white/15 ring-1 ring-white/30' : '' }}">
                        <svg viewBox="0 0 24 24" class="h-3 w-3 text-white/70" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 5v14"></path>
                            <path d="M8 15l4 4 4-4"></path>
                            <path d="M6 5h12"></path>
                        </svg>
                        Laporan Pengeluaran
                    </a>
                </div>
                <a href="{{ route('admin.delivery-schedules.index') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                        <path d="M16 2v4M8 2v4M3 10h18"></path>
                    </svg>
                    Delivery Schedules
                </a>
                <a href="{{ route('admin.offers.index') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 5h16a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H9l-5 4v-4H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"></path>
                    </svg>
                    Negotiations
                </a>
                <a href="{{ route('admin.orders.index') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 4h12l2 4H4l2-4z"></path>
                        <path d="M4 8h16v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"></path>
                    </svg>
                    Orders
                </a>
                <a href="{{ route('admin.payments.index') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                        <path d="M3 10h18"></path>
                        <path d="M7 15h4"></path>
                    </svg>
                    Payments
                </a>
                <a href="{{ route('admin.testimonials.index') }}" class="admin-menu-link flex items-center gap-2 rounded-lg px-2 py-1">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 15a4 4 0 0 1-4 4H7l-4 3v-3a4 4 0 0 1-4-4V6a4 4 0 0 1 4-4h14a4 4 0 0 1 4 4z"></path>
                        <path d="M8 10h8M8 14h6"></path>
                    </svg>
                    Testimonials
                </a>
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
        const pageLoadingOverlay = document.getElementById('pageLoadingOverlay');
        const loadingDisabled = document.body?.dataset?.disableLoading === 'true';

        if (loadingDisabled && pageLoadingOverlay) {
            pageLoadingOverlay.classList.remove('is-active');
        }

        const showPageLoadingOverlay = () => {
            if (loadingDisabled || !pageLoadingOverlay) {
                return;
            }
            pageLoadingOverlay.classList.add('is-active');
        };

        const hidePageLoadingOverlay = () => {
            if (loadingDisabled || !pageLoadingOverlay) {
                return;
            }
            pageLoadingOverlay.classList.remove('is-active');
        };

        if (!loadingDisabled) {
            window.addEventListener('pageshow', hidePageLoadingOverlay);
            window.addEventListener('load', hidePageLoadingOverlay);

            document.addEventListener('click', (event) => {
                const target = event.target;
                if (!(target instanceof Element)) {
                    return;
                }

                const link = target.closest('a[href]');
                if (!link) {
                    return;
                }

                const href = link.getAttribute('href');
                if (!href || href.startsWith('#') || href.startsWith('javascript:')) {
                    return;
                }

                const url = new URL(link.href, window.location.origin);
                const isSameOrigin = url.origin === window.location.origin;
                const isSamePage = url.pathname === window.location.pathname && url.search === window.location.search;
                const opensNewTab = link.getAttribute('target') === '_blank';
                const isDownload = link.hasAttribute('download');
                const hasBypass = link.hasAttribute('data-no-loading');
                const hasModifierKey = event.metaKey || event.ctrlKey || event.shiftKey || event.altKey;

                if (!isSameOrigin || isSamePage || opensNewTab || isDownload || hasBypass || hasModifierKey) {
                    return;
                }

                showPageLoadingOverlay();
            }, { capture: true });
        }

        const adminMenuBtn = document.getElementById('adminMenuBtn');
const adminMobileMenu = document.getElementById('adminMobileMenu');
if (adminMenuBtn && adminMobileMenu) {
    let isMenuOpen = false;
    let allowScrollClose = false;

    const openAdminMenu = () => {
        adminMobileMenu.classList.remove('max-h-0', 'opacity-0', '-translate-y-2', 'pointer-events-none');
        adminMobileMenu.classList.add('admin-mobile-open');
        isMenuOpen = true;
        allowScrollClose = false;
        setTimeout(() => {
            allowScrollClose = true;
        }, 150);
    };

    const closeAdminMenu = () => {
        adminMobileMenu.classList.add('max-h-0', 'opacity-0', '-translate-y-2', 'pointer-events-none');
        adminMobileMenu.classList.remove('admin-mobile-open');
        isMenuOpen = false;
    };

    adminMenuBtn.addEventListener('click', (event) => {
        event.preventDefault();
        if (isMenuOpen) {
            closeAdminMenu();
            return;
        }
        openAdminMenu();
    });

    window.addEventListener('scroll', () => {
        if (isMenuOpen && allowScrollClose) {
            closeAdminMenu();
        }
    }, { passive: true });
    window.addEventListener('resize', closeAdminMenu);
    adminMobileMenu.querySelectorAll('a').forEach((item) => {
        item.addEventListener('click', closeAdminMenu);
    });
}

        const submenuButtons = document.querySelectorAll('[data-admin-submenu]');
        submenuButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const key = button.getAttribute('data-admin-submenu');
                const panel = document.querySelector(`[data-admin-submenu-panel="${key}"]`);
                const wrapper = document.querySelector(`[data-admin-submenu-wrap="${key}"]`);
                if (!panel) {
                    return;
                }

                panel.classList.toggle('hidden');
                const icon = button.querySelector('[data-admin-submenu-caret]');
                if (icon) {
                    icon.classList.toggle('rotate-180');
                }
                if (wrapper) {
                    wrapper.classList.toggle('bg-white/10');
                    wrapper.classList.toggle('border');
                    wrapper.classList.toggle('border-white/10');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>








