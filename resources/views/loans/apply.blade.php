@extends('layouts.app')
@section('title', 'Apply for a Loan')
@section('content')
<div class="form-container">
    <h1>Apply for a Mini Loan</h1>

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
                <input type="number" step="0.01" name="principal_amount" id="principal_amount" value="{{ old('principal_amount', 1000) }}" placeholder="e.g. 1000.00" required>
                @error('principal_amount')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="interest_rate">Monthly Interest (%): <span style="color:#dc2626">*</span></label>
                <input type="number" step="0.01" name="interest_rate" id="interest_rate" value="{{ old('interest_rate', 2.00) }}" placeholder="e.g. 2.00" required>
                @error('interest_rate')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="term_months">Loan Duration (Months): <span style="color:#dc2626">*</span></label>
            <input type="number" name="term_months" id="term_months" value="{{ old('term_months', 6) }}" placeholder="e.g. 6" min="1" max="60" required>
            <small style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 4px;">Case Study default: 6 Months</small>
            @error('term_months')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="action">
            <a href="{{ route('loans.pending') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                Submit Loan Application
            </button>
        </div>
    </form>
</div>
@endsection