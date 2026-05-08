@extends('layouts.admin')

@section('page-title', 'Transaksi')

@section('content')
    <section class="admin-page-head">
        <div>
            <span class="admin-kicker">Order</span>
            <h1>Transaksi</h1>
            <p>Kelola dan pantau transaksi customer.</p>
        </div>
    </section>

    <section class="admin-card">
        <form action="{{ route('admin.transactions.index') }}" method="GET" class="admin-filter">
            <input type="text" name="search" placeholder="Cari invoice..." value="{{ request('search') }}">
            <button type="submit" class="admin-btn">Cari</button>
        </form>

        <div class="admin-desktop-table">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Order</th>
                    <th>Tanggal</th>
                    <th class="admin-table-action">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td><strong>{{ $transaction->invoice_number }}</strong></td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="admin-badge {{ $transaction->payment_status }}">
                                {{ $transaction->payment_status }}
                            </span>
                        </td>
                        <td>
                            <span class="admin-badge order">
                                {{ $transaction->order_status }}
                            </span>
                        </td>
                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.transactions.show', $transaction) }}" class="admin-btn small">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="admin-mobile-list">
    @forelse($transactions as $transaction)
        <article class="admin-mobile-card">
            <div class="admin-mobile-card-head">
                <div>
                    <h3>{{ $transaction->invoice_number }}</h3>
                    <p>{{ $transaction->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <div class="admin-mobile-info">
                <div class="admin-mobile-info-row">
                    <span>Customer</span>
                    <strong>{{ $transaction->user->name }}</strong>
                </div>

                <div class="admin-mobile-info-row">
                    <span>Total</span>
                    <strong>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
                </div>

                <div class="admin-mobile-info-row">
                    <span>Payment</span>
                    <strong>
                        <span class="admin-badge {{ $transaction->payment_status }}">
                            {{ $transaction->payment_status }}
                        </span>
                    </strong>
                </div>

                <div class="admin-mobile-info-row">
                    <span>Order</span>
                    <strong>
                        <span class="admin-badge order">
                            {{ $transaction->order_status }}
                        </span>
                    </strong>
                </div>
            </div>

            <div class="admin-mobile-actions">
                <a href="{{ route('admin.transactions.show', $transaction) }}" class="admin-btn small">
                    Detail
                </a>
            </div>
        </article>
    @empty
        <div class="admin-mobile-card">
            <p>Belum ada transaksi.</p>
        </div>
    @endforelse
</div>
    </section>
@endsection