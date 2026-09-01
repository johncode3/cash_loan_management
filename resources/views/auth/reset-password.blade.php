@extends('layouts.guest')
@section('title', 'Reset Password - Cash Loan Management')
@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        
        <div class="brand-header">
            <img src="{{ asset('assets/images/AdminLTELogo.png') }}" alt="Logo">
            <h2>Reset Password</h2>
            <p>Enter your email and choose a new password</p>
        </div>

        @if ($errors->any())
            <div class="auth-alert-error">
                <strong>Please fix the errors below:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
>
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" name="password" id="password" placeholder="Min. 8 characters" required autocomplete="new-password">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repeat new password" required autocomplete="new-password">
                @error('password_confirmation')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-auth">
                <i class="bi bi-key" style="margin-right: 6px;"></i> Reset Password
            </button>
        </form>

        <div class="auth-footer">
            <a href="{{ route('login') }}">Back to login</a>
        </div>

    </div>
</div>
@endsection