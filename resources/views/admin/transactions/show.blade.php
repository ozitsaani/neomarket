@extends('layouts.admin')

@section('page-title', 'Detail Transaksi')

@section('content')
    <section class="admin-page-head">
        <div>
            <span class="admin-kicker">Invoice</span>
            <h1>{{ $transaction->invoice_number }}</h1>
            <p>Detail transaksi customer.</p>
        </div>

        <a href="{{ route('admin.transactions.index') }}" class="admin-btn">
            Kembali
        </a>
    </section>

    <section class="admin-detail-grid">
        <div class="admin-card">
            <h3>Item Transaksi</h3>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transaction->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <aside class="admin-card">
            <h3>Informasi Order</h3>

            <div class="admin-info-list">
                <div>
                    <span>Customer</span>
                    <strong>{{ $transaction->user->name }}</strong>
                </div>

                <div>
                    <span>Total</span>
                    <strong>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
                </div>

                <div>
                    <span>Payment Status</span>
                    <strong>{{ $transaction->payment_status }}</strong>
                </div>

                <div>
                    <span>Order Status</span>
                    <strong>{{ $transaction->order_status }}</strong>
                </div>

                <div>
                    <span>Alamat</span>
                    <p>{{ $transaction->shipping_address }}</p>
                </div>

                @if($transaction->note)
                    <div>
                        <span>Catatan</span>
                        <p>{{ $transaction->note }}</p>
                    </div>
                @endif
            </div>

            <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST" class="admin-form compact">
                @csrf
                @method('PUT')

                <label>Ubah Status Order</label>
                <select name="order_status">
                    <option value="pending" @selected($transaction->order_status === 'pending')>Pending</option>
                    <option value="processed" @selected($transaction->order_status === 'processed')>Processed</option>
                    <option value="completed" @selected($transaction->order_status === 'completed')>Completed</option>
                    <option value="cancelled" @selected($transaction->order_status === 'cancelled')>Cancelled</option>
                </select>

                <button type="submit" class="admin-btn primary full">
                    Update Status
                </button>
            </form>
        </aside>
    </section>
@endsection