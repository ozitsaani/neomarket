@extends('web.layouts.app')

@section('content')
    <section class="shop-page-head">
        <div>
            <span class="shop-badge">Cart</span>
            <h1>Keranjang Belanja</h1>
            <p>Kelola produk sebelum checkout.</p>
        </div>

        @if($carts->isNotEmpty())
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="shop-btn danger" type="submit">Kosongkan Cart</button>
            </form>
        @endif
    </section>

    @if($carts->isEmpty())
        <div class="shop-empty">
            Cart masih kosong.
            <br>
            <a href="{{ route('store.home') }}">Mulai belanja</a>
        </div>
    @else
        <section class="shop-cart-layout">
            <div class="shop-cart-list">
                @foreach($carts as $cart)
                    <article class="shop-cart-item">
                        <div class="shop-cart-thumb">
                            {{ strtoupper(substr($cart->product->name, 0, 2)) }}
                        </div>

                        <div class="shop-cart-info">
                            <h3>{{ $cart->product->name }}</h3>
                            <p>{{ $cart->product->category->name }}</p>
                            <strong>Rp{{ number_format($cart->product->price, 0, ',', '.') }}</strong>
                        </div>

                        <form action="{{ route('cart.update', $cart) }}" method="POST" class="shop-cart-qty">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1">
                            <button type="submit">Update</button>
                        </form>

                        <div class="shop-cart-subtotal">
                            Rp{{ number_format($cart->subtotal, 0, ',', '.') }}
                        </div>

                        <form action="{{ route('cart.destroy', $cart) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="shop-icon-danger" type="submit">×</button>
                        </form>
                    </article>
                @endforeach
            </div>

            <aside class="shop-summary">
                <h3>Ringkasan</h3>

                <div>
                    <span>Total</span>
                    <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong>
                </div>

                <a href="{{ route('checkout.index') }}" class="shop-btn primary full">
                    Lanjut Checkout
                </a>
            </aside>
        </section>
    @endif
@endsection