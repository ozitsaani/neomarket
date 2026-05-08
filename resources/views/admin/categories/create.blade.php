@extends('layouts.admin')

@section('page-title', 'Tambah Kategori')

@section('content')
    <section class="admin-page-head">
        <div>
            <span class="admin-kicker">Kategori</span>
            <h1>Tambah Kategori</h1>
            <p>Buat kategori baru untuk produk NeoMarket.</p>
        </div>

        <a href="{{ route('admin.categories.index') }}" class="admin-btn">
            Kembali
        </a>
    </section>

    <section class="admin-card">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="admin-form">
            @csrf

            <label>Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name') <small>{{ $message }}</small> @enderror

            <label>Deskripsi</label>
            <textarea name="description" rows="4">{{ old('description') }}</textarea>
            @error('description') <small>{{ $message }}</small> @enderror

            <button type="submit" class="admin-btn primary">
                Simpan Kategori
            </button>
        </form>
    </section>
@endsection