@extends('web.layouts.app')

@section('content')
    <section class="shop-page-head">
        <div>
            <span class="shop-badge">Invoice</span>
            <h1>{{ $transaction->invoice_number }}</h1>
            <p>Detail transaksi dan pembayaran dummy.</p>
        </div>

        <div class="shop-status-group">
            <span class="shop-status {{ $transaction->payment_status }}">
                {{ $transaction->payment_status }}
            </span>

            <span class="shop-status order">
                {{ $transaction->order_status }}
            </span>
        </div>
    </section>

    <section class="shop-invoice-layout">
        <div class="shop-invoice-card">
            <h3>Item Transaksi</h3>

            @foreach($transaction->items as $item)
                <div class="shop-invoice-item">
                    <div>
                        <strong>{{ $item->product_name }}</strong>
                        <p>
                            Rp{{ number_format($item->price, 0, ',', '.') }}
                            x {{ $item->quantity }}
                        </p>
                    </div>

                    <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <aside class="shop-summary">
            <h3>Ringkasan Pembayaran</h3>

            <div>
                <span>Total</span>
                <strong>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
            </div>

            <div class="shop-address">
                <span>Alamat</span>
                <p>{{ $transaction->shipping_address }}</p>
            </div>

            @if($transaction->note)
                <div class="shop-address">
                    <span>Catatan</span>
                    <p>{{ $transaction->note }}</p>
                </div>
            @endif

            @if($transaction->payment_status === 'pending')
                <form action="{{ route('transactions.pay', $transaction) }}" method="POST">
                    @csrf
                    <button type="submit" class="shop-btn primary full">
                        Bayar Dummy
                    </button>
                </form>

                <form action="{{ route('transactions.fail', $transaction) }}" method="POST">
                    @csrf
                    <button type="submit" class="shop-btn danger full">
                        Simulasi Gagal
                    </button>
                </form>
            @endif
        </aside>
    </section>
@endsection