@extends('layouts.admin')

@section('page-title', 'Edit Kategori')

@section('content')
    <section class="admin-page-head">
        <div>
            <span class="admin-kicker">Kategori</span>
            <h1>Edit Kategori</h1>
            <p>Perbarui data kategori produk.</p>
        </div>

        <a href="{{ route('admin.categories.index') }}" class="admin-btn">
            Kembali
        </a>
    </section>

    <section class="admin-card">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')

            <label>Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
            @error('name') <small>{{ $message }}</small> @enderror

            <label>Deskripsi</label>
            <textarea name="description" rows="4">{{ old('description', $category->description) }}</textarea>
            @error('description') <small>{{ $message }}</small> @enderror

            <button type="submit" class="admin-btn primary">
                Update Kategori
            </button>
        </form>
    </section>
@endsection