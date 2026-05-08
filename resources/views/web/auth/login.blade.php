@extends('web.layouts.app')

@section('content')
    <section class="shop-auth-wrap">
        <div class="shop-auth-card">
            <span class="shop-badge">Login</span>
            <h1>Masuk ke NeoMarket</h1>
            <p>Login untuk mengakses cart, checkout, dan transaksi.</p>

            <form action="{{ route('login.store') }}" method="POST" class="shop-form">
                @csrf

                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>

                @error('email')
                    <small>{{ $message }}</small>
                @enderror

                <label>Password</label>
                <input type="password" name="password" required>

                @error('password')
                    <small>{{ $message }}</small>
                @enderror

                <button type="submit" class="shop-btn primary">Login</button>
            </form>

            <p class="shop-auth-note">
                Belum punya akun?
                <a href="{{ route('register') }}">Register</a>
            </p>
        </div>
    </section>
@endsection