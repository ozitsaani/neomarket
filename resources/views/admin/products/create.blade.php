@extends('layouts.admin')

@section('page-title', 'Tambah Produk')

@section('content')
    <section class="admin-page-head">
        <div>
            <span class="admin-kicker">Produk</span>
            <h1>Tambah Produk</h1>
            <p>Tambahkan produk baru ke katalog NeoMarket.</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="admin-btn">
            Kembali
        </a>
    </section>

    <section class="admin-card">
        <form action="{{ route('admin.products.store') }}" method="POST" class="admin-form">
            @csrf

            <div class="admin-grid-2">
                <div>
                    <label>Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    @error('name') <small>{{ $message }}</small> @enderror
                </div>

                <div>
                    <label>Kategori</label>
                    <select name="category_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <small>{{ $message }}</small> @enderror
                </div>
            </div>

            <label>Deskripsi</label>
            <textarea name="description" rows="4">{{ old('description') }}</textarea>

            <div class="admin-grid-2">
                <div>
                    <label>Harga</label>
                    <input type="number" name="price" value="{{ old('price') }}" min="0" required>
                    @error('price') <small>{{ $message }}</small> @enderror
                </div>

                <div>
                    <label>Stok</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" min="0" required>
                    @error('stock') <small>{{ $message }}</small> @enderror
                </div>
            </div>

            <label>Image URL / Nama File</label>
            <input type="text" name="image" value="{{ old('image') }}" placeholder="Opsional">

            <label class="admin-checkbox">
                <input type="checkbox" name="is_active" value="1" checked>
                Produk aktif
            </label>

            <button type="submit" class="admin-btn primary">
                Simpan Produk
            </button>
        </form>
    </section>
@endsection