@extends('layouts.app')
@section('title', 'Record Customer Repayment')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/crud/form.css') }}">
@endpush
@section('content')
<div class="form-container">
    <h1>
        <i class="bi bi-wallet2" style="color: #2563eb; margin-right: 6px;"></i>
        Record Customer Repayment
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

    <form action="{{ route('repayments.create') }}" method="GET" style="margin-bottom: 20px;">
        <div class="form-group">
            <label for="loan_id_select">Select Active Loan / Customer: <span style="color:#dc2626">*</span></label>
            <select name="loan_id" id="loan_id_select" onchange="this.form.submit()">
                <option value="">-- Choose Loan Contract --</option>
                @foreach($loans as $l)
                    <option value="{{ $l->id }}" {{ (request('loan_id') == $l->id || (isset($selectedLoan) && $selectedLoan->id == $l->id)) ? 'selected' : '' }}>
                        Loan #{{ $l->id }} - {{ $l->customer->customer_code }} ({{ $l->customer->first_name }} {{ $l->customer->last_name }}) - Principal: ${{ number_format($l->principal_amount, 2) }}
                    </option>
                @endforeach
            </select>
            <small style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 4px;">Select a loan to load its next due installment.</small>
        </div>
    </form>

    @if($selectedLoan && $nextSchedule)
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; margin-bottom: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 0.9rem;">
                <div><strong>Customer:</strong> {{ $selectedLoan->customer->first_name }} {{ $selectedLoan->customer->last_name }}</div>
                <div><strong>Phone:</strong> {{ $selectedLoan->customer->phone ?? 'N/A' }}</div>
                <div><strong>Current Installment:</strong> #{{ $nextSchedule->installment_no }} of {{ $selectedLoan->term_months }}</div>
                <div><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($nextSchedule->due_date)->format('d M Y') }}</div>
                <div><strong>Monthly Installment Due:</strong> <span style="color: #2563eb; font-weight: 700;">${{ number_format($nextSchedule->total_due, 2) }}</span></div>
                <div><strong>Status:</strong> <span class="badge {{ $nextSchedule->status === 'Overdue' ? 'badge-overdue' : 'badge-pending' }}">{{ $nextSchedule->status }}</span></div>
            </div>
        </div>

        <form action="{{ route('repayments.store', $selectedLoan->id) }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="amount_paid">Amount to Pay ($): <span style="color:#dc2626">*</span></label>
                    <input type="number" step="0.01" name="amount_paid" id="amount_paid" value="{{ old('amount_paid', $nextSchedule->total_due) }}" required>
                    <small style="color: #64748b; font-size: 0.78rem; display: block; margin-top: 4px;">Overpayments automatically roll over to next months.</small>
                    @error('amount_paid')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="payment_method">Payment Method: <span style="color:#dc2626">*</span></label>
                    <select name="payment_method" id="payment_method" required>
                        <option value="Cash" {{ old('payment_method') === 'Cash' ? 'selected' : '' }}>Cash (សាច់ប្រាក់សុទ្ធ)</option>
                        <option value="ABA / KHQR" {{ old('payment_method') === 'ABA / KHQR' ? 'selected' : '' }}>ABA / KHQR Transfer</option>
                        <option value="Bank Transfer" {{ old('payment_method') === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="Wing / TrueMoney" {{ old('payment_method') === 'Wing / TrueMoney' ? 'selected' : '' }}>Wing / TrueMoney</option>
                    </select>
                    @error('payment_method')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="payment_date">Payment Date: <span style="color:#dc2626">*</span></label>
                <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                @error('payment_date')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="action">
                <a href="{{ route('loans.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary" style="background: #10b981; border-color: #10b981;">
                    <i class="bi bi-check2-circle me-1"></i> Confirm & Collect Payment
                </button>
            </div>
        </form>
    @elseif($selectedLoan && !$nextSchedule)
        <div style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 16px; border-radius: 8px; text-align: center;">
            ✓ All installments for this loan have been fully paid!
        </div>
        <div class="action" style="margin-top: 16px;">
            <a href="{{ route('loans.show', $selectedLoan->id) }}" class="btn btn-primary">View Account Statement</a>
        </div>
    @endif
</div>
@endsection