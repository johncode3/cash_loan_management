@extends('layouts.app')
@section('title', 'All Loans & Schedules')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/crud/index.css') }}">
@endpush

@section('content')
<h1>All Loans & Schedules</h1>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="toolbar">
    <a href="{{ route('loans.apply') }}" class="btn btn-primary">+ Apply New Loan</a>
    <div style="font-size: 0.9rem; color: #475569;">
        Total Loans: <strong>{{ $loans->total() }}</strong>
    </div>
</div>

<form action="{{ route('loans.index') }}" method="GET" class="filter-bar">
    <div>
        <label for="search">Search Customer</label>
        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Name or customer code...">
    </div>
    <div>
        <label for="status">Loan Status</label>
        <select name="status" id="status">
            <option value="">All Statuses</option>
            <option value="Pending" @selected(request('status') === 'Pending')>Pending</option>
            <option value="Approved" @selected(request('status') === 'Approved')>Approved</option>
            <option value="Disbursed" @selected(request('status') === 'Disbursed')>Disbursed</option>
        </select>
    </div>
    <div>
        <label>&nbsp;</label>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('loans.index') }}" class="btn btn-secondary">Reset</a>
    </div>
</form>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Category</th>
                <th>Principal ($)</th>
                <th>Interest Rate</th>
                <th>Term</th>
                <th>Disbursed Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
           @forelse ($loans as $loan)
            <tr>
                <td>{{ $loans instanceof \Illuminate\Pagination\LengthAwarePaginator ? $loans->firstItem() + $loop->index : $loop->iteration }}</td>
                <td>
                    <strong>{{ $loan->customer->customer_code }}</strong><br>
                    {{ $loan->customer->first_name }} {{ $loan->customer->last_name }}
                </td>
                <td>{{ $loan->category->name ?? 'General' }}</td>
                <td style="font-weight: 700; color: #0f172a;">${{ number_format($loan->principal_amount, 2) }}</td>
                <td>{{ $loan->interest_rate }}% / mo</td>
                <td>{{ $loan->term_months }} Mos</td>
                <td>{{ $loan->disbursement_date ? \Carbon\Carbon::parse($loan->disbursement_date)->format('d M Y') : 'Not Disbursed' }}</td>
                <td>
                    @php
                        $badgeClass = match($loan->status) {
                            'Disbursed' => 'badge-disbursed',
                            'Approved'  => 'badge-approved',
                            'Pending'   => 'badge-pending',
                            default     => ''
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $loan->status }}</span>
                </td>
                <td>
                    <div class="table-actions">

                        @if($loan->status === 'Disbursed')
                            <a href="{{ route('loans.schedule', $loan->id) }}" class="btn btn-info">
                                📅 View Schedule
                            </a>
                        @elseif($loan->status === 'Approved' && Auth::user()->role === 'admin')

                            <form action="{{ route('loans.disburse', $loan->id) }}" method="POST" style="display:inline; margin:0;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="background: #2563eb;">
                                    💵 Disburse
                                </button>
                            </form>
                        @else
                            <a href="{{ route('loans.pending') }}" class="btn btn-secondary">
                                ⏳ Pending Review
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
           @empty
            <tr>
                <td colspan="9" style="text-align: center; color: #64748b; padding: 24px;">No loans found.</td>
            </tr>
           @endforelse
        </tbody>
    </table>
</div>

@if ($loans instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div style="margin-top: 16px">
        {{ $loans->links() }}
    </div>
@endif
@endsection