@extends('layouts.guest')
@section('title', 'Customer Registration')
@section('content')
<div class="auth-wrapper">
    <div class="auth-card register-card">
        <div class="brand-header">
            <img src="{{ asset('assets/images/CashLogo.png') }}" alt="Logo">
            <h2>Customer Registration</h2>
            <p>Create a borrower account with Cash Loan App</p>
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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name: <span style="color:#dc2626">*</span></label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="e.g. Dara" required autofocus>
                    @error('first_name') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name: <span style="color:#dc2626">*</span></label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="e.g. Sok" required>
                    @error('last_name') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="gender">Gender: <span style="color:#dc2626">*</span></label>
                    <select name="gender" id="gender" required>
                        <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male (ប្រុស)</option>
                        <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female (ស្រី)</option>
                    </select>
                    @error('gender') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number: <span style="color:#dc2626">*</span></label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="012345678" required>
                    @error('phone') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="city">City / Province: <span style="color:#dc2626">*</span></label>
                    <select name="city" id="city" required>
                        <option value="Phnom Penh" {{ old('city') === 'Phnom Penh' ? 'selected' : '' }}>Phnom Penh</option>
                        <option value="Kandal" {{ old('city') === 'Kandal' ? 'selected' : '' }}>Kandal</option>
                        <option value="Siem Reap" {{ old('city') === 'Siem Reap' ? 'selected' : '' }}>Siem Reap</option>
                        <option value="Battambang" {{ old('city') === 'Battambang' ? 'selected' : '' }}>Battambang</option>
                        <option value="Kampong Cham" {{ old('city') === 'Kampong Cham' ? 'selected' : '' }}>Kampong Cham</option>
                        <option value="Kampot" {{ old('city') === 'Kampot' ? 'selected' : '' }}>Kampot</option>
                    </select>
                    @error('city') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Date of Birth:</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address (Login): <span style="color:#dc2626">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="dara.sok@gmail.com" required>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password: <span style="color:#dc2626">*</span></label>
                    <input type="password" name="password" id="password" placeholder="Min. 8 characters" required autocomplete="new-password">
                    @error('password') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password: <span style="color:#dc2626">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repeat password" required autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="btn-auth">
                <i class="bi bi-person-check" style="margin-right: 6px;"></i> Register Account
            </button>
        </form>

        <div class="auth-footer">
            Already registered? <a href="{{ route('login') }}">Sign in here</a>
        </div>

    </div>
</div>
@endsection