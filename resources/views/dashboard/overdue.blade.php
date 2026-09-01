@extends('layouts.app')
@section('title', 'Overdue Loans Dashboard')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/crud/index.css') }}">
@endpush
@section('content')
<h1>
    <i class="bi bi-exclamation-triangle" style="color: #dc2626; margin-right: 6px;"></i>
    Overdue Loans Dashboard
</h1>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="toolbar">
    <div style="display: flex; gap: 20px; flex-wrap: wrap; font-size: 0.95rem;">
        <div>Total Overdue Installments: <strong style="color: #dc2626;">{{ $overdueSchedules->total() }}</strong></div>
        <div>Total Default Amount at Risk: <strong style="color: #dc2626;">${{ number_format($totalOverdueAmount, 2) }}</strong></div>
    </div>
</div>

<form action="{{ route('dashboard.overdue') }}" method="GET" class="filter-bar">
    <div>
        <label for="search">Search Overdue Customer</label>
        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Name, code, or phone...">
    </div>
    <div>
        <label>&nbsp;</label>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-funnel"></i> Filter
        </button>
        <a href="{{ route('dashboard.overdue') }}" class="btn btn-danger">
            <i class="bi bi-arrow-counterclockwise"></i> Reset
        </a>
    </div>
</form>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Loan #</th>
                <th>Installment</th>
                <th>Original Due Date</th>
                <th>Days Late</th>
                <th>Amount Due ($)</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
           @forelse ($overdueSchedules as $item)
            @php
                $dueDate = \Carbon\Carbon::parse($item->due_date);
                $daysLate = (int) $dueDate->diffInDays(now());
            @endphp
            <tr>
                <td>{{ $overdueSchedules->firstItem() + $loop->index }}</td>
                <td>
                    <strong>{{ $item->loan->customer->customer_code }}</strong><br>
                    {{ $item->loan->customer->first_name }} {{ $item->loan->customer->last_name }}
                </td>
                <td>{{ $item->loan->customer->phone ?? 'N/A' }}</td>
                <td>Loan #{{ $item->loan_id }}</td>
                <td><strong>Installment {{ $item->installment_no }}</strong></td>
                <td>{{ $dueDate->format('d M Y') }}</td>
                <td>
                    <span style="color: #dc2626; font-weight: 700;">
                        {{ $daysLate }} days
                    </span>
                </td>
                <td style="font-weight: 700; color: #dc2626;">
                    ${{ number_format($item->total_due, 2) }}
                </td>
                <td>
                    <span class="badge badge-overdue">Overdue</span>
                </td>
                <td>
                    <div class="table-actions">
                        <a href="{{ route('loans.show', $item->loan_id) }}" class="btn btn-info">
                            <i class="bi bi-eye me-1"></i> Statement
                        </a>

                        <a href="{{ route('repayments.create', ['loan_id' => $item->loan_id]) }}" class="btn btn-primary" style="background: #10b981; border-color: #10b981;">
                            <i class="bi bi-wallet2 me-1"></i> Collect
                        </a>
                    </div>
                </td>
            </tr>
           @empty
            <tr>
                <td colspan="10" style="text-align: center; color: #059669; padding: 28px; background: #ecfdf5;">
                    <i class="bi bi-check-circle-fill me-1"></i> Great news! There are currently no overdue loans in the system.
                </td>
            </tr>
           @endforelse
        </tbody>
    </table>
</div>

@if ($overdueSchedules instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div style="margin-top: 16px">
        {{ $overdueSchedules->links() }}
    </div>
@endif
@endsection