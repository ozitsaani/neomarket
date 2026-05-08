@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
    <section class="nm-hero">
        <div class="nm-hero-copy">
            <span class="nm-chip light">API Driven E-Commerce</span>

            <h1>Kelola Backend E-Commerce dengan Rapi.</h1>

            <p>
                Dashboard admin NeoMarket untuk memantau produk, kategori, customer,
                transaksi, checkout, dan payment dummy dalam satu tampilan.
            </p>

            <div class="nm-hero-actions">
                <a href="{{ route('admin.products.index') }}" class="nm-btn primary">
    Lihat Produk
    <span>→</span>
</a>

<a href="{{ route('admin.categories.index') }}" class="nm-btn secondary">
    Lihat Kategori
</a>
            </div>
        </div>

        <div class="nm-hero-summary">
            <span>Project</span>
            <strong>NeoMarket</strong>
            <p>Laravel REST API</p>
        </div>
    </section>

    <section class="nm-stats">
        <article class="nm-stat-card">
            <div class="nm-stat-head">
                <span class="nm-stat-icon coral">□</span>
                <span class="nm-chip small">API</span>
            </div>

            <p>Total Produk</p>
            <h3>{{ $totalProducts }}</h3>
        </article>

        <article class="nm-stat-card">
            <div class="nm-stat-head">
                <span class="nm-stat-icon yellow">◇</span>
                <span class="nm-chip small">CRUD</span>
            </div>

            <p>Total Kategori</p>
            <h3>{{ $totalCategories }}</h3>
        </article>

        <article class="nm-stat-card">
            <div class="nm-stat-head">
                <span class="nm-stat-icon mint">▣</span>
                <span class="nm-chip small">Order</span>
            </div>

            <p>Total Transaksi</p>
            <h3>{{ $totalTransactions }}</h3>
        </article>

        <article class="nm-stat-card">
            <div class="nm-stat-head">
                <span class="nm-stat-icon pink">👤</span>
                <span class="nm-chip small">User</span>
            </div>

            <p>Total Customer</p>
            <h3>{{ $totalCustomers }}</h3>
        </article>
    </section>

    <section class="nm-dashboard-grid">
        <article class="nm-panel nm-transaction-panel">
            <div class="nm-panel-header">
                <div>
                    <h3>Ringkasan Transaksi</h3>
                    <p>Status pembayaran pada sistem NeoMarket.</p>
                </div>

                <span class="nm-chip soft">Payment Dummy</span>
            </div>

            <div class="nm-progress-group">
                <div class="nm-progress-item">
                    <div class="nm-progress-label">
                        <strong>Pending</strong>
                        <span>{{ $pendingTransactions }}</span>
                    </div>
                    <div class="nm-progress-track">
                        <div class="nm-progress-fill yellow" style="width: {{ $pendingTransactions > 0 ? min(100, $pendingTransactions * 25) : 5 }}%"></div>
                    </div>
                </div>

                <div class="nm-progress-item">
                    <div class="nm-progress-label">
                        <strong>Paid</strong>
                        <span>{{ $paidTransactions }}</span>
                    </div>
                    <div class="nm-progress-track">
                        <div class="nm-progress-fill mint" style="width: {{ $paidTransactions > 0 ? min(100, $paidTransactions * 25) : 5 }}%"></div>
                    </div>
                </div>

                <div class="nm-progress-item">
                    <div class="nm-progress-label">
                        <strong>Total Transaksi</strong>
                        <span>{{ $totalTransactions }}</span>
                    </div>
                    <div class="nm-progress-track">
                        <div class="nm-progress-fill coral" style="width: {{ $totalTransactions > 0 ? min(100, $totalTransactions * 20) : 5 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="nm-mini-chart">
                <div style="height: 36px"></div>
                <div style="height: 58px"></div>
                <div style="height: 45px"></div>
                <div style="height: 74px"></div>
                <div style="height: 62px"></div>
                <div style="height: 88px"></div>
                <div style="height: 68px"></div>
            </div>
        </article>

        <article class="nm-panel">
            <div class="nm-panel-header">
                <div>
                    <h3>Aktivitas Sistem</h3>
                    <p>Fitur utama yang sudah aktif.</p>
                </div>

                <span class="nm-chip soft">Ready</span>
            </div>

            <div class="nm-activity-list">
                <div class="nm-activity-item">
                    <span class="nm-activity-icon mint">✓</span>
                    <div>
                        <strong>Authentication aktif</strong>
                        <p>Register, login, profile, dan logout menggunakan token Sanctum.</p>
                    </div>
                </div>

                <div class="nm-activity-item">
                    <span class="nm-activity-icon yellow">✓</span>
                    <div>
                        <strong>Produk & kategori</strong>
                        <p>Admin dapat melakukan CRUD produk dan kategori.</p>
                    </div>
                </div>

                <div class="nm-activity-item">
                    <span class="nm-activity-icon coral">✓</span>
                    <div>
                        <strong>Cart & checkout</strong>
                        <p>Customer dapat menambahkan produk dan membuat transaksi.</p>
                    </div>
                </div>

                <div class="nm-activity-item">
                    <span class="nm-activity-icon pink">✓</span>
                    <div>
                        <strong>Payment dummy</strong>
                        <p>Status pembayaran dapat berubah menjadi paid atau failed.</p>
                    </div>
                </div>
            </div>
        </article>
    </section>

    <section class="nm-feature-card">
        <div>
            <h3>Fitur NeoMarket</h3>
            <p>Fitur yang sudah dibuat sesuai kebutuhan project e-commerce API driven.</p>
        </div>

        <div class="nm-feature-tags">
            <span>Produk</span>
            <span>Kategori</span>
            <span>Cart</span>
            <span>Checkout</span>
            <span>Transaksi</span>
            <span>Payment Dummy</span>
            <span>RESTful API</span>
            <span>Sanctum</span>
        </div>
    </section>
@endsection