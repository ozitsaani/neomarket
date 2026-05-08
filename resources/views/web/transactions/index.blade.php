@extends('web.layouts.app')

@section('content')
    <section class="shop-page-head">
        <div>
            <span class="shop-badge">Transaksi</span>
            <h1>Riwayat Transaksi</h1>
            <p>Daftar transaksi yang pernah dibuat.</p>
        </div>
    </section>

    <section class="shop-transaction-list">
        @forelse($transactions as $transaction)
            <article class="shop-transaction-card">
                <div>
                    <h3>{{ $transaction->invoice_number }}</h3>
                    <p>{{ $transaction->created_at->format('d M Y H:i') }}</p>
                </div>

                <div>
                    <span class="shop-status {{ $transaction->payment_status }}">
                        {{ $transaction->payment_status }}
                    </span>
                    <span class="shop-status order">
                        {{ $transaction->order_status }}
                    </span>
                </div>

                <strong>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</strong>

                <a href="{{ route('transactions.show', $transaction) }}" class="shop-btn secondary">
                    Detail
                </a>
            </article>
        @empty
            <div class="shop-empty">
                Belum ada transaksi.
            </div>
        @endforelse
    </section>

    <div class="shop-pagination">
        {{ $transactions->links() }}
    </div>
@endsection