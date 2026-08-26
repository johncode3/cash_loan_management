@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="fw-bold text-primary mb-1">
                        Welcome, {{ Auth::user()->name }}! 👋
                    </h3>
                    <p class="text-muted mb-0">
                        Role: <span class="badge bg-primary text-uppercase">{{ Auth::user()->role ?? 'Customer' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Dashboard KPI Cards --}}
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card bg-primary text-white border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold">Active Loans</h6>
                    <h2 class="mb-0 fw-bold">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold">Total Disbursed</h6>
                    <h2 class="mb-0 fw-bold">$0.00</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold">Pending Approval</h6>
                    <h2 class="mb-0 fw-bold">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold">Overdue Loans</h6>
                    <h2 class="mb-0 fw-bold">0</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection