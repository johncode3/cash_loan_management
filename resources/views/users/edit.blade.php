@extends('layouts.app')
@section('title', 'Edit User')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/crud/form.css') }}">
@endpush

@section('content')
<div class="form-container">
    <h1>
        <i class="bi bi-pencil-square" style="color: #d97706; margin-right: 6px;"></i>
        Edit User: {{ $user->name }}
    </h1>

    @if ($errors->any())
        <div style="border:1px solid #fecaca; background:#fee2e2; padding:12px; margin-bottom:18px; border-radius:6px">
            <strong style="color: #991b1b">Please fix the following errors:</strong>
            <ul style="margin: 8px 0 0 20px; color: #991b1b">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Full Name: <span style="color:#dc2626">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="email">Email Address: <span style="color:#dc2626">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Role: <span style="color:#dc2626">*</span></label>
                <select name="role" id="role" required>
                    <option value="loan_officer" {{ old('role', $user->role) === 'loan_officer' ? 'selected' : '' }}>Loan Officer (មន្ត្រីឥណទាន)</option>
                    <option value="cashier" {{ old('role', $user->role) === 'cashier' ? 'selected' : '' }}>Cashier (បេឡាធិការ)</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>System Admin (អ្នកគ្រប់គ្រង)</option>
                    <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer (អតិថិជន)</option>
                </select>
                @error('role')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="password">New Password (Leave blank to keep current):</label>
            <input type="password" name="password" id="password" placeholder="Leave empty if not changing">
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="action">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2-circle me-1"></i> Update User
            </button>
        </div>
    </form>
</div>
@endsection