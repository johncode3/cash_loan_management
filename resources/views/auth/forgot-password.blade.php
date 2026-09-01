@extends('layouts.guest')
@section('title', 'Forgot Password - Cash Loan Management')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        
        {{-- Brand Header --}}
        <div class="brand-header">
            <img src="{{ asset('assets/images/CashLogo.png') }}" alt="Logo">
            <h2>Forgot Password?</h2>
            <p>Enter your email address and we will send you a password reset link.</p>
        </div>

        {{-- Session Status --}}
        @if (session('status'))
            <div style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; padding:10px 14px; margin-bottom:18px; border-radius:6px; font-size:0.85rem;">
                {{ session('status') }}
            </div>
        @endif

        {{-- Errors --}}
        @if ($errors->any())
            <div class="auth-alert-error">
                <strong>Error:</strong> Please enter a valid registered email address.
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Registered Email Address:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="e.g. user@loan.com" required autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-auth">
                <i class="bi bi-envelope-check" style="margin-right: 6px;"></i> Send Password Reset Link
            </button>
        </form>

        <div class="auth-footer">
            Remembered your password? <a href="{{ route('login') }}">Back to login</a>
        </div>

    </div>
</div>
@endsection