@extends('web.layouts.app')

@section('content')
    <section class="shop-page-head">
        <div>
            <span class="shop-badge">Checkout</span>
            <h1>Checkout Pesanan</h1>
            <p>Isi alamat pengiriman untuk membuat transaksi.</p>
        </div>
    </section>

    <section class="shop-checkout-layout">
        <form action="{{ route('checkout.store') }}" method="POST" class="shop-checkout-form">
            @csrf

            <label>Alamat Pengiriman</label>
            <textarea name="shipping_address" rows="5" required>{{ old('shipping_address') }}</textarea>
            @error('shipping_address') <small>{{ $message }}</small> @enderror

            <label>Catatan</label>
            <textarea name="note" rows="3">{{ old('note') }}</textarea>

            <button type="submit" class="shop-btn primary">Buat Transaksi</button>
        </form>

        <aside class="shop-summary">
            <h3>Ringkasan Cart</h3>

            @foreach($carts as $cart)
                <div class="shop-summary-row">
                    <span>{{ $cart->product->name }} x {{ $cart->quantity }}</span>
                    <strong>Rp{{ number_format($cart->subtotal, 0, ',', '.') }}</strong>
                </div>
            @endforeach

            <div class="shop-summary-total">
                <span>Total</span>
                <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong>
            </div>
        </aside>
    </section>
@endsection