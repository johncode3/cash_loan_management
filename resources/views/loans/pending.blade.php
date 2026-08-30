@extends('layouts.app')
@section('title', 'Pending Loans List')
@section('content')
<h1>Pending Loans List</h1>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-weight: 500;">
        {{ session('error') }}
    </div>
@endif

<div class="toolbar">
    <a href="{{ route('loans.apply') }}" class="btn btn-primary">+ Apply New Loan</a>
</div>
<form action="{{ route('loans.pending') }}" method="GET" class="filter-bar">
    <div>
        <label for="liveSearch">Search loans</label>
        <input type="text" name="search" id="liveSearch" value="{{ request('search') }}" placeholder="Customer name or code...">
    </div>
    <div>
        <label>&nbsp;</label>
        <a href="{{ route('loans.pending') }}" class="btn btn-danger">Clear</a>
    </div>
</form>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Category</th>
                <th>Principal ($)</th>
                <th>Interest Rate</th>
                <th>Term</th>
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
                    <td>{{ $loan->term_months }} Months</td>
                    <td>
                        <span class="badge badge-{{ strtolower($loan->status) }}">{{ ucfirst($loan->status) }}</span>
                    </td>
                    <td>
                        <div class="table-actions">
                            @if($loan->status === 'Pending')
                                <form action="{{ route('loans.approve', $loan->id) }}" method="POST" style="display: inline; margin:0;" onsubmit="return confirm('Approve loan for {{ $loan->customer->first_name }}?');">
                                    @csrf
                                    <button class="btn btn-primary" type="submit" style="background: #10b981; border-color: #10b981;">
                                        ✓ Approve
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #64748b; padding: 24px;">No pending loans found.</td>
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