@extends('web.layouts.app')

@section('content')
    <section class="shop-hero">
        <div>
            <span class="shop-badge">Clean Neobrutalism Storefront</span>
            <h1>Belanja Produk Pilihan di NeoMarket.</h1>
            <p>
                Website e-commerce sederhana dengan produk, kategori, cart,
                checkout, transaksi, dan payment dummy.
            </p>

            <form action="{{ route('store.home') }}" method="GET" class="shop-search-form">
                <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">

                <select name="category_id">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit">Cari</button>
            </form>
        </div>

        <div class="shop-hero-card">
            <span>Total Produk</span>
            <strong>{{ $products->total() }}</strong>
            <p>Produk aktif tersedia</p>
        </div>
    </section>

    <section class="shop-category-row">
        <a href="{{ route('store.home') }}" class="shop-category-chip {{ request('category_id') ? '' : 'active' }}">
            Semua
        </a>

        @foreach($categories as $category)
            <a
                href="{{ route('store.home', ['category_id' => $category->id]) }}"
                class="shop-category-chip {{ request('category_id') == $category->id ? 'active' : '' }}"
            >
                {{ $category->name }}
            </a>
        @endforeach
    </section>

    <section class="shop-product-grid">
        @forelse($products as $product)
            <article class="shop-product-card">
                <div class="shop-product-image">
                    <span>{{ strtoupper(substr($product->name, 0, 2)) }}</span>
                </div>

                <div class="shop-product-info">
                    <span class="shop-product-category">{{ $product->category->name }}</span>
                    <h3>{{ $product->name }}</h3>
                    <p>{{ Str::limit($product->description, 80) }}</p>

                    <div class="shop-product-meta">
                        <strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong>
                        <span>Stok: {{ $product->stock }}</span>
                    </div>

                    <div class="shop-product-actions">
                        <a href="{{ route('store.products.show', $product) }}" class="shop-btn secondary">
                            Detail
                        </a>

                        @auth
                            @if(auth()->user()->role === 'customer')
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="shop-btn primary">+ Cart</button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="shop-btn primary">+ Cart</a>
                        @endauth
                    </div>
                </div>
            </article>
        @empty
            <div class="shop-empty">
                Produk tidak ditemukan.
            </div>
        @endforelse
    </section>

    <div class="shop-pagination">
        {{ $products->links() }}
    </div>
@endsection