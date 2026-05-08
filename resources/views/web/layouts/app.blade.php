<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'NeoMarket' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="shop-body">
    <nav class="shop-navbar">
        <a href="{{ route('store.home') }}" class="shop-logo">
            <span>NM</span>
            <strong>NeoMarket</strong>
        </a>

        <div class="shop-nav-links">
            <a href="{{ route('store.home') }}">Produk</a>

            @auth
                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('cart.index') }}">Cart</a>
                    <a href="{{ route('transactions.index') }}">Transaksi</a>
                @endif

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}" class="shop-nav-cta">Register</a>
            @endauth
        </div>
    </nav>

    <main class="shop-container">
        @if(session('success'))
            <div class="shop-alert success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="shop-alert error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>