@extends('layouts.app')
@section('title', 'Apply for a Loan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/crud/form.css') }}">
@endpush

@section('content')
<div class="form-container">
    <h1>
        <i class="bi bi-file-earmark-plus" style="color: #2563eb; margin-right: 6px;"></i>
        Apply for a Mini Loan
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

    <form action="{{ route('loans.store') }}" method="POST">
        @csrf

        @if(Auth::user()->role === 'customer' && isset($myCustomer))

            <div class="form-group">
                <label for="customer_name">Applicant (Your Account):</label>
                <input type="text" value="{{ $myCustomer->customer_code }} - {{ $myCustomer->first_name }} {{ $myCustomer->last_name }} ({{ Auth::user()->email }})" readonly style="background-color: #f1f5f9; color: #0f172a; font-weight: 700; cursor: not-allowed;">
                <input type="hidden" name="customer_id" value="{{ $myCustomer->id }}">
                <small style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 4px;">Applying under your registered customer account.</small>
            </div>
        @else

            <div class="form-group">
                <label for="customer_id">Select Customer: <span style="color:#dc2626">*</span></label>
                <select name="customer_id" id="customer_id" required>
                    <option value="">-- Choose Customer --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->customer_code }} - {{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->phone ?? 'No Phone' }})
                        </option>
                    @endforeach
                </select>
                @error('customer_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        @endif

        <div class="form-group">
            <label for="category_id">Loan Product / Category:</label>
            <select name="category_id" id="category_id">
                <option value="">-- Optional: Choose Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="principal_amount">Principal Amount ($): <span style="color:#dc2626">*</span></label>
                <input type="number" step="0.01" name="principal_amount" id="principal_amount" value="{{ old('principal_amount', 1000) }}" placeholder="e.g. 1000.00" min="50" max="50000" required>
                <small style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 4px;">Min: $50 | Max: $50,000</small>
                @error('principal_amount')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="interest_rate">Monthly Interest (%): <span style="color:#dc2626">*</span></label>
                @if(Auth::user()->role === 'customer')
                    <input type="number" step="0.01" name="interest_rate" id="interest_rate" value="2.00" readonly style="background-color: #f1f5f9; color: #0f172a; font-weight: 700; cursor: not-allowed;">
                    <small style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 4px;">Standard Bank Rate: 2.00% / month</small>
                @else

                    <input type="number" step="0.01" name="interest_rate" id="interest_rate" value="{{ old('interest_rate', 2.00) }}" min="0.5" max="10.0" required>
                    <small style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 4px;">Policy range: 0.5% - 10.0% / month</small>
                @endif
                @error('interest_rate')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="term_months">Loan Duration: <span style="color:#dc2626">*</span></label>
            <select name="term_months" id="term_months" required>
                <option value="3" {{ old('term_months') == 3 ? 'selected' : '' }}>3 Months (3 ខែ)</option>
                <option value="6" {{ old('term_months', 6) == 6 ? 'selected' : '' }}>6 Months (6 ខែ - Case Study Default)</option>
                <option value="12" {{ old('term_months') == 12 ? 'selected' : '' }}>12 Months (1 ឆ្នាំ)</option>
                <option value="24" {{ old('term_months') == 24 ? 'selected' : '' }}>24 Months (2 ឆ្នាំ)</option>
            </select>
            @error('term_months')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="action">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send me-1"></i> Submit Loan Application
            </button>
        </div>
    </form>
</div>
@endsection