@extends('layouts.app')
@section('title', 'Dashboard')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/bladeStyle/dashboard.css') }}">
@endpush
@section('content')
@if (session('success'))
    <div class="alert-success" style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; display: flex; align-items: center; gap: 8px;">
        <span>✓</span> {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert-danger" style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; display: flex; align-items: center; gap: 8px;">
        <span>⚠</span> {{ session('error') }}
    </div>
@endif
<div class="welcome-banner">
    <div class="welcome-text">
        <h2>Welcome back, {{ Auth::user()->name }}! 👋</h2>
        <p>Logged in as: <span class="role-badge">{{ Auth::user()->role ?? 'Customer' }}</span></p>
    </div>

    @if(Auth::user()->role === 'customer')
        <a href="{{ Route::has('loans.apply') ? route('loans.apply') : '#' }}" class="btn btn-primary">
            <i class="bi bi-file-earmark-plus"></i> Apply for a Loan
        </a>
    @endif
</div>

@if(Auth::user()->role === 'customer')
    <div class="kpi-grid">
        <div class="kpi-card accent-blue">
            <div class="kpi-label">Active Loan Amount</div>
            <div class="kpi-value">$1,000.00</div>
            <div class="kpi-subtext">Principal Borrowed</div>
        </div>

        <div class="kpi-card accent-amber">
            <div class="kpi-label">Next Payment Due</div>
            <div class="kpi-value" style="font-size: 1.4rem;">15 Sep 2026</div>
            <div class="kpi-subtext">Installment #1 of 6</div>
        </div>

        <div class="kpi-card accent-emerald">
            <div class="kpi-label">Remaining Balance</div>
            <div class="kpi-value">$850.00</div>
            <div class="kpi-subtext">Current Outstanding</div>
        </div>
    </div>

@else
    <div class="kpi-grid">
        <div class="kpi-card accent-blue">
            <div class="kpi-label">Total Cash Disbursed</div>
            <div class="kpi-value">$25,000.00</div>
            <div class="kpi-subtext">Active loan portfolio</div>
        </div>

        <div class="kpi-card accent-amber">
            <div class="kpi-label">Pending Approvals</div>
            <div class="kpi-value">3</div>
            <div class="kpi-subtext">Awaiting Loan Officer review</div>
        </div>

        <div class="kpi-card accent-rose">
            <div class="kpi-label">Overdue Loans</div>
            <div class="kpi-value">2</div>
            <div class="kpi-subtext">Late payment installments</div>
        </div>

        <div class="kpi-card accent-emerald">
            <div class="kpi-label">Total Collected</div>
            <div class="kpi-value">$18,400.00</div>
            <div class="kpi-subtext">Total repayments received</div>
        </div>
    </div>

    <div class="section-card">
        <h3>Quick Operations</h3>
        {{-- In resources/views/dashboard.blade.php --}}
        <div class="quick-actions-list">
            @if(in_array(Auth::user()->role, ['admin', 'loan_officer']))
                <a href="{{ Route::has('loans.pending') ? route('loans.pending') : '#' }}" class="btn btn-outline">
                    <i class="bi bi-clock-history"></i> Review Pending Loans
                </a>
            @endif

            @if(in_array(Auth::user()->role, ['admin', 'cashier']))
                <a href="{{ Route::has('repayments.create') ? route('repayments.create') : '#' }}" class="btn btn-outline">
                    <i class="bi bi-wallet2"></i> Record Repayment
                </a>
            @endif

            <a href="{{ route('customers.create') }}" class="btn btn-outline">
                <i class="bi bi-person-plus"></i> Add New Customer
            </a>

            <a href="{{ route('categories.index') }}" class="btn btn-outline">
                <i class="bi bi-tags"></i> Manage Categories
            </a>
        </div>
    </div>
@endif

@endsection