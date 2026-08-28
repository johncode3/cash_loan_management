@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Welcome Banner for Everyone --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold text-primary mb-1">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-muted mb-0">Role: <span class="badge bg-primary text-uppercase">{{ Auth::user()->role }}</span></p>
                    </div>

                    {{-- Customer Quick Action --}}
                    @if(Auth::user()->role === 'customer')
                        <a href="{{ route('loans.apply') }}" class="btn btn-success fw-bold px-4 py-2">
                            <i class="bi bi-plus-circle me-1"></i> Apply for a Loan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->role === 'customer')
        {{-- ================= CUSTOMER VIEW ================= --}}
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase">My Active Loan</h6>
                        <h3 class="fw-bold text-dark mb-0">$1,000.00</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase">Next Due Date</h6>
                        <h3 class="fw-bold text-primary mb-0">15 Sep 2026</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase">Remaining Balance</h6>
                        <h3 class="fw-bold text-success mb-0">$850.00</h3>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- ================= STAFF / ADMIN VIEW ================= --}}
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-uppercase fw-semibold">Total Disbursed</h6>
                        <h2 class="mb-0 fw-bold">$25,000</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-uppercase fw-semibold">Pending Approval</h6>
                        <h2 class="mb-0 fw-bold">3</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-uppercase fw-semibold">Overdue Loans</h6>
                        <h2 class="mb-0 fw-bold">2</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-uppercase fw-semibold">Total Collected</h6>
                        <h2 class="mb-0 fw-bold">$18,400</h2>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection