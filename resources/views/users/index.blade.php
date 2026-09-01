@extends('layouts.app')
@section('title', 'Users Management')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/crud/index.css') }}">
@endpush

@section('content')
<h1>Users & Roles Management</h1>

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
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i> Create New User
    </a>
    <div style="font-size: 0.9rem; color: #475569;">
        Total Users: <strong>{{ $users->total() }}</strong>
    </div>
</div>

<form action="{{ route('users.index') }}" method="GET" class="filter-bar">
    <div>
        <label for="search">Search User</label>
        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Name or email...">
    </div>
    <div>
        <label for="role">Filter by Role</label>
        <select name="role" id="role">
            <option value="">All Roles</option>
            <option value="admin" @selected(request('role') === 'admin')>Admin</option>
            <option value="loan_officer" @selected(request('role') === 'loan_officer')>Loan Officer</option>
            <option value="cashier" @selected(request('role') === 'cashier')>Cashier</option>
            <option value="customer" @selected(request('role') === 'customer')>Customer</option>
        </select>
    </div>
    <div>
        <label>&nbsp;</label>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-funnel"></i> Filter
        </button>
        <a href="{{ route('users.index') }}" class="btn btn-danger">
            <i class="bi bi-arrow-counterclockwise"></i> Reset
        </a>
    </div>
</form>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email Address</th>
                <th>System Role</th>
                <th>Registered Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
           @forelse ($users as $user)
            <tr>
                <td>{{ $users->firstItem() + $loop->index }}</td>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->email }}</td>
                <td>
                    @php
                        $roleClass = match($user->role) {
                            'admin'        => 'badge-active',
                            'loan_officer' => 'badge-disbursed',
                            'cashier'      => 'badge-inactive',
                            default        => 'badge-resigned'
                        };
                    @endphp
                    <span class="badge {{ $roleClass }}">
                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    <div class="table-actions">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>

                        @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline; margin:0;" onsubmit="return confirm('Delete user {{ $user->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
           @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #64748b; padding: 24px;">No users found.</td>
            </tr>
           @endforelse
        </tbody>
    </table>
</div>

@if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div style="margin-top: 16px">
        {{ $users->links() }}
    </div>
@endif
@endsection