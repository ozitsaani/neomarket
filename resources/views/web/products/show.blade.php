@extends('web.layouts.app')

@section('content')
    <section class="shop-detail">
        <div class="shop-detail-image">
            <span>{{ strtoupper(substr($product->name, 0, 2)) }}</span>
        </div>

        <div class="shop-detail-info">
            <span class="shop-badge">{{ $product->category->name }}</span>
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->description }}</p>

            <div class="shop-detail-price">
                Rp{{ number_format($product->price, 0, ',', '.') }}
            </div>

            <div class="shop-detail-stock">
                Stok tersedia: <strong>{{ $product->stock }}</strong>
            </div>

            @auth
                @if(auth()->user()->role === 'customer')
                    <form action="{{ route('cart.store') }}" method="POST" class="shop-form-inline">
                        @csrf

                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}">

                        <button type="submit" class="shop-btn primary">Tambah ke Cart</button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="shop-btn primary">Login untuk Beli</a>
            @endauth
        </div>
    </section>

    @if($relatedProducts->isNotEmpty())
        <section class="shop-section-head">
            <h2>Produk Terkait</h2>
        </section>

        <section class="shop-product-grid small">
            @foreach($relatedProducts as $related)
                <article class="shop-product-card">
                    <div class="shop-product-image">
                        <span>{{ strtoupper(substr($related->name, 0, 2)) }}</span>
                    </div>

                    <div class="shop-product-info">
                        <span class="shop-product-category">{{ $related->category->name }}</span>
                        <h3>{{ $related->name }}</h3>
                        <div class="shop-product-meta">
                            <strong>Rp{{ number_format($related->price, 0, ',', '.') }}</strong>
                        </div>
                        <a href="{{ route('store.products.show', $related) }}" class="shop-btn secondary">Detail</a>
                    </div>
                </article>
            @endforeach
        </section>
    @endif
@endsection