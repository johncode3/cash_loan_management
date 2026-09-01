@extends('layouts.guest')
@section('title', 'Login - Cash Loan Management')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        
        {{-- Brand Logo & Header --}}
        <div class="brand-header">
            <img src="{{ asset('assets/images/CashLogo.png') }}" alt="Logo">
            <h2>Cash Loan Management</h2>
            <p>Sign in to your account</p>
        </div>

        {{-- Error Alerts --}}
        @if ($errors->any())
            <div class="auth-alert-error">
                <strong>Login Failed:</strong> Please check your email or password.
            </div>
        @endif

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="e.g. admin@loan.com" required autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="••••••••" required autocomplete="current-password">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-row">
                <label for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn-auth">
                <i class="bi bi-box-arrow-in-right" style="margin-right: 6px;"></i> Sign In
            </button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}">Create customer account</a>
        </div>

    </div>
</div>
@endsection