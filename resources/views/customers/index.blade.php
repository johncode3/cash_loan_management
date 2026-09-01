@extends('layouts.app')
@section('content')
@section('title', 'Customer List')
<h1>Customer List</h1>
@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="toolbar">
    <a href="{{ route('customers.create') }}" class="btn btn-primary"><i class="bi bi-person-plus"></i> Create New Customer</a>
    <div style="margin-top: 8px; font-size: 1rem; color: #303242;">
        Total Customers: <strong style="color: #091d8f;">{{ $totalCount }}</strong> | Active Customers: <strong style="color: #1c9b42;">{{ $activeCount }}</strong>
    </div>
</div>

<form action="{{route('customers.index')}}" method="GET" class="filter-bar">
    <div>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" value="{{ request('first_name') }}" placeholder="Search...">
    </div>
    <div>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" value="{{ request('last_name') }}" placeholder="Search...">
    </div>
    <div>
        <label for="phone">Phone Number</label>
        <input type="text" name="phone" id="phone" value="{{ request('phone') }}" placeholder="Search...">
    </div>
    <div>
        <label for="city">City</label>
        <select name="city" id="city">
            <option value="">All Cities</option>
            @foreach ($cities as $city)
                <option value="{{ $city }}" @selected(request('city') === $city)>{{ $city }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="">All</option>
            <option value="Active" @selected(request('status') === 'Active')>Active</option>
            <option value="Inactive" @selected(request('status') === 'Inactive')>Inactive</option>
        </select>
    </div>
    <div>
        <label>&nbsp;</label>
        <button type="submit" class="btn btn-primary"> <i class="bi bi-funnel"></i> Filter</button>
        <a href="{{ route('customers.index') }}" class="btn btn-danger"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
    </div>
</form>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Full Name</th>
                <th>Phone</th>
                <th>City / Province</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($customers as $customer)
            <tr>
                <td>{{ $customers->firstItem() + $loop->index }}</td>
                <td><strong>{{ $customer->customer_code }}</strong></td>
                <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                <td>{{ $customer->phone ?? '-' }}</td>
                <td>{{ $customer->city ?? '-' }}</td>
                <td>
                    @php
                        $badgeClass = match($customer->status) {
                            'Active' => 'badge-active',
                            'Inactive' => 'badge-inactive',
                            default => ''
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $customer->status }}</span>
                </td>
                <td>
                    <div class="table-actions">
                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline; margin:0;" onsubmit="return confirm('Delete customer {{ $customer->first_name }} {{ $customer->last_name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #64748b; padding: 24px;">No customers found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@if ($customers instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div style="margin-top: 16px">
        {{ $customers->links() }}
    </div>
@endif
@endsection