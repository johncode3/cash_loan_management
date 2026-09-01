@extends('layouts.app')
@section('title', 'Create User')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/crud/form.css') }}">
@endpush

@section('content')
<div class="form-container">
    <h1>
        <i class="bi bi-person-plus" style="color: #2563eb; margin-right: 6px;"></i>
        Create User Account
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

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Full Name: <span style="color:#dc2626">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g. Sokha Loan Officer" required>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="email">Email Address (Login): <span style="color:#dc2626">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="user@loan.com" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">System Role / Permissions: <span style="color:#dc2626">*</span></label>
                <select name="role" id="role" required>
                    <option value="">-- Select Role --</option>
                    <option value="loan_officer" {{ old('role') === 'loan_officer' ? 'selected' : '' }}>Loan Officer (មន្ត្រីឥណទាន)</option>
                    <option value="cashier" {{ old('role') === 'cashier' ? 'selected' : '' }}>Cashier (បេឡាធិការ)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>System Admin (អ្នកគ្រប់គ្រង)</option>
                    <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer (អតិថិជន)</option>
                </select>
                @error('role')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="password">Initial Password: <span style="color:#dc2626">*</span></label>
            <input type="password" name="password" id="password" placeholder="Minimum 6 characters" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="action">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2-circle me-1"></i> Create User
            </button>
        </div>
    </form>
</div>
@endsection