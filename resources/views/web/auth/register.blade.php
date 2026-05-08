@extends('web.layouts.app')

@section('content')
    <section class="shop-auth-wrap">
        <div class="shop-auth-card">
            <span class="shop-badge">Register</span>
            <h1>Buat Akun Customer</h1>
            <p>Daftar untuk mulai belanja di NeoMarket.</p>

            <form action="{{ route('register.store') }}" method="POST" class="shop-form">
                @csrf

                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @error('name') <small>{{ $message }}</small> @enderror

                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <small>{{ $message }}</small> @enderror

                <label>Password</label>
                <input type="password" name="password" required>
                @error('password') <small>{{ $message }}</small> @enderror

                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>

                <button type="submit" class="shop-btn primary">Register</button>
            </form>

            <p class="shop-auth-note">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login</a>
            </p>
        </div>
    </section>
@endsection