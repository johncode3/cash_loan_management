@extends('layouts.app')
@section('title', 'Employee List')

@section('content')
<h1>Employee List</h1>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="toolbar">
    <a href="{{ route('employees.create') }}" class="btn btn-primary"><i class="bi bi-person-plus"></i>Create New Employee</a>
</div>

<form action="{{route('employees.index')}}" method="GET" class="filter-bar">
    <div>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" value="{{ request('first_name') }}" placeholder="Search...">
    </div>
    <div>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" value="{{ request('last_name') }}" placeholder="Search...">
    </div>
        <div>
        <label for="department">Department</label>
        <select name="department" id="department">
            <option value="">All Departments</option>
            <option value="Credit & Lending" @selected(request('department') === 'Credit & Lending')>Credit & Lending</option>
            <option value="Finance & Accounting" @selected(request('department') === 'Finance & Accounting')>Finance & Accounting</option>
            <option value="Operations & Cashier" @selected(request('department') === 'Operations & Cashier')>Operations & Cashier</option>
            <option value="Administration & HR" @selected(request('department') === 'Administration & HR')>Administration & HR</option>
            <option value="Information Technology" @selected(request('department') === 'Information Technology')>IT</option>
        </select>
    </div>
    <div>
        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="">All Statuses</option>
            <option value="Active" @selected(request('status') === 'Active')>Active</option>
            <option value="Inactive" @selected(request('status') === 'Inactive')>Inactive</option>
            <option value="Resigned" @selected(request('status') === 'Resigned')>Resigned</option>
            <option value="Terminated" @selected(request('status') === 'Terminated')>Terminated</option>
        </select>
    </div>
    <div>
        <label>&nbsp;</label>
        <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
        <a href="{{ route('employees.index') }}" class="btn btn-danger"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
    </div>
</form>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Full Name</th>
                <th>Position</th>
                <th>Department</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
           @forelse ($employees as $employee)
            <tr>
                <td>{{ $employees instanceof \Illuminate\Pagination\LengthAwarePaginator ? $employees->firstItem() + $loop->index : $loop->iteration }}</td>
                <td style="text-align: center; width: 60px;">
                    @if ($employee->profile_picture)
                        <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Photo" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; border: 1px solid #cbd5e1;">
                    @else
                        <span style="color: #94a3b8; font-size: 0.8rem;">No Photo</span>
                    @endif
                </td>

                <td><strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong></td>
                <td>{{ $employee->position ?? '-' }}</td>
                <td>{{ $employee->department ?? '-' }}</td>
                <td>{{ $employee->phone ?? '-' }}</td>

                <td>
                    @php
                        $badgeClass = match($employee->status) {
                            'Active'     => 'badge-active',
                            'Inactive'   => 'badge-inactive',
                            'Resigned'   => 'badge-resigned',
                            'Terminated' => 'badge-terminated',
                            default      => ''
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $employee->status }}</span>
                </td>

                <td>
                    <div class="table-actions">
                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline; margin:0;" onsubmit="return confirm('Delete employee {{ $employee->first_name }} {{ $employee->last_name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
           @empty
            <tr>
                <td colspan="8" style="text-align: center; color: #64748b; padding: 24px;">No employees found.</td>
            </tr>
           @endforelse
        </tbody>
    </table>
</div>

@if ($employees instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div style="margin-top: 16px">
        {{ $employees->links() }}
    </div>
@endif
@endsection