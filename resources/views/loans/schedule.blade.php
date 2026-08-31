@extends('layouts.app')
@section('title', 'Loan Repayment Schedule')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/crud/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/crud/show.css') }}">
@endpush

@section('content')
<h1>Loan Repayment Schedule</h1>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="max-width: 100%; margin-bottom: 20px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <div>
            <div class="label">Customer:</div>
            <div class="value"><strong>{{ $loan->customer->customer_code }}</strong> - {{ $loan->customer->first_name }} {{ $loan->customer->last_name }}</div>
        </div>
        <div>
            <div class="label">Principal Borrowed:</div>
            <div class="value" style="font-weight: 700; color: #0f172a;">${{ number_format($loan->principal_amount, 2) }}</div>
        </div>
        <div>
            <div class="label">Interest Rate:</div>
            <div class="value">{{ $loan->interest_rate }}% / month (Reducing Balance)</div>
        </div>
        <div>
            <div class="label">Duration:</div>
            <div class="value">{{ $loan->term_months }} Months</div>
        </div>
        <div>
            <div class="label">Disbursed Date:</div>
            <div class="value">{{ $loan->disbursement_date ? $loan->disbursement_date->format('d M Y') : 'Not yet' }}</div>
        </div>
        <div>
            <div class="label">Overall Status:</div>
            <div class="value">
                <span class="badge badge-disbursed">{{ $loan->status }}</span>
            </div>
        </div>
    </div>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Due Date</th>
                <th>Principal Due ($)</th>
                <th>Interest Due ($)</th>
                <th>Total Payment ($)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPrincipal = 0;
                $totalInterest = 0;
                $grandTotal = 0;
            @endphp
            @forelse ($loan->schedules as $item)
                @php
                    $totalPrincipal += $item->principal_due;
                    $totalInterest += $item->interest_due;
                    $grandTotal += $item->total_due;

                    $statusClass = match($item->status) {
                        'Paid'    => 'badge-paid',
                        'Overdue' => 'badge-overdue',
                        default   => 'badge-pending',
                    };
                @endphp
                <tr>
                    <td><strong>Installment {{ $item->installment_no }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($item->due_date)->format('d M Y') }}</td>
                    <td>${{ number_format($item->principal_due, 2) }}</td>
                    <td>${{ number_format($item->interest_due, 2) }}</td>
                    <td style="font-weight: 700; color: #0f172a;">${{ number_format($item->total_due, 2) }}</td>
                    <td>
                        <span class="badge {{ $statusClass }}">{{ $item->status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #64748b; padding: 24px;">No schedule generated yet.</td>
                </tr>
            @endforelse
        </tbody>
        @if ($loan->schedules->count() > 0)
            <tfoot style="background: #f8fafc; font-weight: 700;">
                <tr>
                    <td colspan="2" style="text-align: right;">Total Repayment Summary:</td>
                    <td>${{ number_format($totalPrincipal, 2) }}</td>
                    <td>${{ number_format($totalInterest, 2) }}</td>
                    <td style="color: #2563eb;">${{ number_format($grandTotal, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>

<div class="actions" style="margin-top: 20px;">
    <a href="{{ route('loans.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Loans
    </a>
</div>
@endsection