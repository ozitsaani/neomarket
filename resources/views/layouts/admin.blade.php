<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'NeoMarket Admin' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="nm-shell">
        <aside class="nm-sidebar">
            <div>
                <div class="nm-brand">
                    <div class="nm-brand-mark">NM</div>
                    <div>
                        <h1>NeoMarket</h1>
                        <p>Admin E-Commerce</p>
                    </div>
                </div>

                <nav class="nm-menu">
                    <a href="{{ route('admin.dashboard') }}" class="nm-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span>▦</span>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.products.index') }}" class="nm-menu-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <span>□</span>
                        Produk
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="nm-menu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <span>◇</span>
                        Kategori
                    </a>

                    <a href="{{ route('admin.transactions.index') }}" class="nm-menu-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                        <span>≡</span>
                        Transaksi
                    </a>

                    <a href="{{ route('store.home') }}" target="_blank" class="nm-menu-link">
                        <span>↗</span>
                        Lihat Toko
                    </a>
                </nav>
            </div>

            <div class="nm-status-card">
                <span>Project Status</span>
                <strong>API Driven</strong>
                <p>Laravel + Sanctum</p>
            </div>
        </aside>

        <section class="nm-main">
            <header class="nm-topbar">
                <div>
                    <span class="nm-eyebrow">Admin Panel</span>
                    <h2>@yield('page-title', 'Dashboard')</h2>
                </div>

                <div class="nm-topbar-actions">

                    <div class="nm-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="nm-logout-form">
                        @csrf
                        <button type="submit" class="nm-logout-btn">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="nm-content">
                @if(session('success'))
                    <div class="admin-alert success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="admin-alert error">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </section>
    </div>
</body>
</html>