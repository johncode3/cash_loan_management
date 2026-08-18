@extends('layouts.app')
@section('content')
@section('title', 'Customer List')
@section('main')
        <h1>Customer List</h1>
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="toolbar">
            <a href="{{ route('customers.create') }}" class="btn btn-primary">+ Create New Customer</a>
            <div style="margin-top: 8px; font-size: 0.9rem; color: #374151;">
                Total Customers: <strong>{{ $totalCount }}</strong> | Active Customers: <strong>{{ $activeCount }}</strong>
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
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('customers.index') }}" class="btn btn-danger">Reset</a>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
               @forelse ($customers as $customer)
                <tr>
                    <td>{{ $customers->firstItem() + $loop->index }}</td>
                    <td>{{ $customer->customer_code}}</td>
                    <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                    <td>{{ $customer->gender }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone ?? '-' }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->city }}</td>
                    <td>
                        @php
                            $badgeClass = match($customer->status) {
                                'Active' => 'badge-active',
                                'Inactive' => 'badge-inactive',
                                default => ''
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ ($customer->status) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete {{ $customer->first_name }} {{ $customer->last_name }}?')">
                            @csrf
                            @method('DELETE')
                        <button type="submit" class=  "btn btn-danger">Delete</button>
                    </form>
                    </td>
                </tr>
               @empty
                <tr>
                    <td colspan="12" class="text-center">No customers found.</td>
                </tr>
               @endforelse
            </tbody>
        </table>
        @if ($customers instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div style="margin-top: 16px">
                {{ $customers->links() }}
            </div>
        @endif
@endsection