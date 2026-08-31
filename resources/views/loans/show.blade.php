@extends('layouts.app')
@section('title', 'Loan Details & Statement')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/crud/show.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/crud/index.css') }}">
@endpush

@section('content')
<h1>Loan Details & Account Statement</h1>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="card" style="padding: 18px 22px; border-left: 4px solid #3b82f6;">
        <div class="label" style="font-size: 0.78rem; text-transform: uppercase;">Principal Borrowed</div>
        <div class="value" style="font-size: 1.4rem; font-weight: 700; color: #0f172a; margin-top: 4px;">
            ${{ number_format($totalPrincipal, 2) }}
        </div>
    </div>

    <div class="card" style="padding: 18px 22px; border-left: 4px solid #f59e0b;">
        <div class="label" style="font-size: 0.78rem; text-transform: uppercase;">Total Repayment with Interest</div>
        <div class="value" style="font-size: 1.4rem; font-weight: 700; color: #b45309; margin-top: 4px;">
            ${{ number_format($totalScheduleDue, 2) }}
        </div>
    </div>

    <div class="card" style="padding: 18px 22px; border-left: 4px solid #10b981;">
        <div class="label" style="font-size: 0.78rem; text-transform: uppercase;">Contract Status</div>
        <div class="value" style="margin-top: 6px;">
            @php
                $badgeClass = match($loan->status) {
                    'Disbursed' => 'badge-disbursed',
                    'Approved'  => 'badge-approved',
                    'Pending'   => 'badge-pending',
                    default     => ''
                };
            @endphp
            <span class="badge {{ $badgeClass }}" style="font-size: 0.85rem;">{{ $loan->status }}</span>
        </div>
    </div>
</div>

<div class="card" style="max-width: 100%; margin-bottom: 24px;">
    <h3 style="font-size: 1.05rem; color: #0f172a; margin-top: 0; margin-bottom: 16px; font-weight: 700;">Contract Information</h3>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 12px;">
        <div class="row">
            <div class="label">Customer Name:</div>
            <div class="value">
                <strong>{{ $loan->customer->customer_code }}</strong> - {{ $loan->customer->first_name }} {{ $loan->customer->last_name }}
            </div>
        </div>
        <div class="row">
            <div class="label">Customer Phone:</div>
            <div class="value">{{ $loan->customer->phone ?? 'N/A' }}</div>
        </div>
        <div class="row">
            <div class="label">Loan Category:</div>
            <div class="value">{{ $loan->category->name ?? 'General' }}</div>
        </div>
        <div class="row">
            <div class="label">Interest Rate:</div>
            <div class="value">{{ $loan->interest_rate }}% / month (Reducing Balance)</div>
        </div>
        <div class="row">
            <div class="label">Duration:</div>
            <div class="value">{{ $loan->term_months }} Months</div>
        </div>
        <div class="row">
            <div class="label">Disbursed Date:</div>
            <div class="value">{{ $loan->disbursement_date ? \Carbon\Carbon::parse($loan->disbursement_date)->format('d M Y') : 'Not yet disbursed' }}</div>
        </div>
        <div class="row">
            <div class="label">Created By:</div>
            <div class="value">{{ $loan->creator->name ?? 'System' }}</div>
        </div>
    </div>
</div>

<div class="actions" style="margin-top: 24px;">
    @if($loan->status === 'Disbursed')
        <a href="{{ route('loans.schedule', $loan->id) }}" class="btn btn-danger">
            <i class="bi bi-calendar3 me-1"></i> View Schedule Table
        </a>
    @endif
    <a href="{{ route('loans.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to All Loans
    </a>
</div>
@endsection