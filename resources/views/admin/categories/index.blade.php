@extends('layouts.admin')

@section('page-title', 'Kategori')

@section('content')
    <section class="admin-page-head">
        <div>
            <span class="admin-kicker">Data Master</span>
            <h1>Kategori Produk</h1>
            <p>Kelola kategori produk untuk katalog NeoMarket.</p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="admin-btn primary">
            + Tambah Kategori
        </a>
    </section>

    <section class="admin-card">
        <div class="admin-desktop-table">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Jumlah Produk</th>
                    <th>Deskripsi</th>
                    <th class="admin-table-action">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->description ?? '-' }}</td>
                        <td>
                            <div class="admin-row-actions">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="admin-btn small">
                                    Edit
                                </a>

                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn small danger" onclick="return confirm('Hapus kategori ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="admin-mobile-list">
    @forelse($categories as $category)
        <article class="admin-mobile-card">
            <div class="admin-mobile-card-head">
                <div>
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>
            </div>

            <div class="admin-mobile-info">
                <div class="admin-mobile-info-row">
                    <span>Slug</span>
                    <strong>{{ $category->slug }}</strong>
                </div>

                <div class="admin-mobile-info-row">
                    <span>Jumlah Produk</span>
                    <strong>{{ $category->products_count }}</strong>
                </div>
            </div>

            <div class="admin-mobile-actions">
                <a href="{{ route('admin.categories.edit', $category) }}" class="admin-btn small">
                    Edit
                </a>

                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn small danger" onclick="return confirm('Hapus kategori ini?')">
                        Hapus
                    </button>
                </form>
            </div>
        </article>
    @empty
        <div class="admin-mobile-card">
            <p>Belum ada kategori.</p>
        </div>
    @endforelse
</div>
    </section>
@endsection