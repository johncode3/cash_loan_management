@extends('layouts.app')
@section('title', 'Employee List')
@section('main')
        <h1>Employee List</h1>
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="toolbar">
            <a href="{{ route('employees.create') }}" class="btn btn-primary">+ Create New Employee</a>
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
                <label for="gender">Gender</label>
                <select name="gender" id="gender">
                    <option value="">All</option>
                    <option value="male" @selected(request('gender') === 'male')>Male</option>
                    <option value="female" @selected(request('gender') === 'female')>Female</option>
                </select>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('employees.index') }}" class="btn btn-danger">Reset</a>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Hire Date</th>
                    <th>Salary</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
               @forelse ($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($employee->profile_picture)
                            <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Photo" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                        @else
                            <span style="color:#9ca3af">-</span>
                        @endif
                    </td>
                    <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                    <td>{{ $employee->gender }}</td>
                    <td>{{ $employee->position ?? '-' }}</td>
                    <td>{{ $employee->department ?? '-' }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone ?? '-' }}</td>
                    <td>{{ $employee->hiring_date }}</td>
                    <td>{{ number_format($employee->salary, 2) }}</td>
                    <td>
                        @php
                            $badgeClass = match($employee->status) {
                                'Active' => 'badge-active',
                                'Inactive' => 'badge-inactive',
                                'Resigned' => 'badge-resigned',
                                'Terminated' => 'badge-terminated',
                                default => ''
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ ($employee->status) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete {{ $employee->first_name }} {{$employee->last_name}}?')">
                            @csrf
                            @method('DELETE')
                        <button type="submit" class=  "btn btn-danger">Delete</button>
                    </form>
                    </td>
                </tr>
               @empty
                <tr>
                    <td colspan="12" class="text-center">No employees found.</td>
                </tr>
               @endforelse
            </tbody>
        </table>
        @if ($employees instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div style="margin-top: 16px">
                {{ $employees->links() }}
            </div>
        @endif
@endsection