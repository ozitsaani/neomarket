@extends('layouts.admin')

@section('page-title', 'Produk')

@section('content')
    <section class="admin-page-head">
        <div>
            <span class="admin-kicker">Data Master</span>
            <h1>Produk</h1>
            <p>Kelola produk yang tampil di katalog customer.</p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="admin-btn primary">
            + Tambah Produk
        </a>
    </section>

    <section class="admin-card">
        <form action="{{ route('admin.products.index') }}" method="GET" class="admin-filter">
            <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">

            <select name="category_id">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="admin-btn">
                Filter
            </button>
        </form>

        <div class="admin-desktop-table">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th class="admin-table-action">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            <br>
                            <span>{{ Str::limit($product->description, 45) }}</span>
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if($product->is_active)
                                <span class="admin-badge success">Aktif</span>
                            @else
                                <span class="admin-badge danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="admin-row-actions">
                                <a href="{{ route('admin.products.edit', $product) }}" class="admin-btn small">
                                    Edit
                                </a>

                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn small danger" onclick="return confirm('Hapus produk ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="admin-mobile-list">
    @forelse($products as $product)
        <article class="admin-mobile-card">
            <div class="admin-mobile-card-head">
                <div>
                    <h3>{{ $product->name }}</h3>
                    <p>{{ Str::limit($product->description, 80) }}</p>
                </div>

                @if($product->is_active)
                    <span class="admin-badge success">Aktif</span>
                @else
                    <span class="admin-badge danger">Nonaktif</span>
                @endif
            </div>

            <div class="admin-mobile-info">
                <div class="admin-mobile-info-row">
                    <span>Kategori</span>
                    <strong>{{ $product->category->name }}</strong>
                </div>

                <div class="admin-mobile-info-row">
                    <span>Harga</span>
                    <strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong>
                </div>

                <div class="admin-mobile-info-row">
                    <span>Stok</span>
                    <strong>{{ $product->stock }}</strong>
                </div>
            </div>

            <div class="admin-mobile-actions">
                <a href="{{ route('admin.products.edit', $product) }}" class="admin-btn small">
                    Edit
                </a>

                <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn small danger" onclick="return confirm('Hapus produk ini?')">
                        Hapus
                    </button>
                </form>
            </div>
        </article>
    @empty
        <div class="admin-mobile-card">
            <p>Belum ada produk.</p>
        </div>
    @endforelse
</div>
    </section>
@endsection