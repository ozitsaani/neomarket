@extends('layouts.admin')

@section('page-title', 'Edit Produk')

@section('content')
    <section class="admin-page-head">
        <div>
            <span class="admin-kicker">Produk</span>
            <h1>Edit Produk</h1>
            <p>Perbarui data produk.</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="admin-btn">
            Kembali
        </a>
    </section>

    <section class="admin-card">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')

            <div class="admin-grid-2">
                <div>
                    <label>Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name') <small>{{ $message }}</small> @enderror
                </div>

                <div>
                    <label>Kategori</label>
                    <select name="category_id" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <small>{{ $message }}</small> @enderror
                </div>
            </div>

            <label>Deskripsi</label>
            <textarea name="description" rows="4">{{ old('description', $product->description) }}</textarea>

            <div class="admin-grid-2">
                <div>
                    <label>Harga</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" required>
                </div>

                <div>
                    <label>Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
                </div>
            </div>

            <label>Image URL / Nama File</label>
            <input type="text" name="image" value="{{ old('image', $product->image) }}" placeholder="Opsional">

            <label class="admin-checkbox">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))>
                Produk aktif
            </label>

            <button type="submit" class="admin-btn primary">
                Update Produk
            </button>
        </form>
    </section>
@endsection