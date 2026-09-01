@extends('layouts.app')
@section('title', 'Dashboard')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/crud/dashboard.css') }}">
@endpush
@section('content')

@if (session('success'))
    <div class="alert-success" style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; display: flex; align-items: center; gap: 8px;">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert-danger" style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; display: flex; align-items: center; gap: 8px;">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    </div>
@endif

<div class="welcome-banner">
    <div class="welcome-text">
        <h2>Welcome back, {{ Auth::user()->name }}! 👋</h2>
        <p>Logged in as: <span class="role-badge">{{ Auth::user()->role ?? 'Customer' }}</span></p>
    </div>

    @if(Auth::user()->role === 'customer')
        <a href="{{ route('loans.apply') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Apply for a Loan
        </a>
    @endif
</div>

@if(Auth::user()->role === 'customer')
    <div class="kpi-grid">
        <div class="kpi-card accent-blue">
            <div class="kpi-label">My Active Loan</div>
            <div class="kpi-value">
                ${{ $activeLoan ? number_format($activeLoan->principal_amount, 2) : '0.00' }}
            </div>
            <div class="kpi-subtext">Principal Borrowed</div>
        </div>

        <div class="kpi-card accent-amber">
            <div class="kpi-label">Next Payment Due</div>
            <div class="kpi-value" style="font-size: 1.35rem;">
                {{ $nextPayment ? \Carbon\Carbon::parse($nextPayment->due_date)->format('d M Y') : 'No Due Payment' }}
            </div>
            <div class="kpi-subtext">
                {{ $nextPayment ? 'Installment #' . $nextPayment->installment_no . ' ($' . number_format($nextPayment->total_due, 2) . ')' : 'All caught up' }}
            </div>
        </div>

        <div class="kpi-card accent-emerald">
            <div class="kpi-label">Remaining Balance</div>
            <div class="kpi-value" style="color: #15803d;">
                ${{ number_format($remainingBalance, 2) }}
            </div>
            <div class="kpi-subtext">Total remaining with interest</div>
        </div>
    </div>

@else
    <div class="kpi-grid">
        <div class="kpi-card accent-blue">
            <div class="kpi-label">Total Cash Disbursed</div>
            <div class="kpi-value">${{ number_format($totalDisbursed, 2) }}</div>
            <div class="kpi-subtext">Active loan portfolio</div>
        </div>

        <div class="kpi-card accent-amber">
            <div class="kpi-label">Pending Approvals</div>
            <div class="kpi-value">{{ $pendingLoansCount }}</div>
            <div class="kpi-subtext">Awaiting Loan Officer review</div>
        </div>

        <div class="kpi-card accent-rose">
            <div class="kpi-label">Overdue Loans</div>
            <div class="kpi-value" style="color: #dc2626;">{{ $overdueLoansCount }}</div>
            <div class="kpi-subtext">Late payment installments</div>
        </div>

        <div class="kpi-card accent-emerald">
            <div class="kpi-label">Total Repayments Collected</div>
            <div class="kpi-value" style="color: #15803d;">${{ number_format($totalCollected, 2) }}</div>
            <div class="kpi-subtext">Revenue received by cashiers</div>
        </div>
    </div>

    <div class="section-card">
        <h3 style="font-size: 1.05rem; color: #0f172a; margin-top: 0; margin-bottom: 14px; font-weight: 700;">Quick Operations</h3>
        <div class="quick-actions-list">
            @if(in_array(Auth::user()->role, ['admin', 'loan_officer']))
                <a href="{{ route('loans.pending') }}" class="btn btn-outline">
                    <i class="bi bi-clock-history"></i> Review Pending Loans
                </a>
            @endif

            @if(in_array(Auth::user()->role, ['admin', 'cashier']))
                <a href="{{ route('repayments.create') }}" class="btn btn-outline">
                    <i class="bi bi-wallet2"></i> Record Repayment
                </a>
            @endif

            <a href="{{ route('loans.index') }}" class="btn btn-outline">
                <i class="bi bi-calendar-check"></i> All Loan Schedules
            </a>

            <a href="{{ route('customers.create') }}" class="btn btn-outline">
                <i class="bi bi-person-plus"></i> Add Customer
            </a>

            @if(Auth::user()->role === 'admin')
                <a href="{{ route('dashboard.overdue') }}" class="btn btn-outline" style="color: #dc2626; border-color: #fecaca;">
                    <i class="bi bi-exclamation-triangle"></i> Overdue Dashboard
                </a>
            @endif
        </div>
    </div>
@endif

@endsection