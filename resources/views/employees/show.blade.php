@extends('layouts.app')
@section('title', 'Employee Details')
@section('content')
        <h1>Employee Details</h1>

        <div class="card">
            @if ($employee->profile_picture)
                <div style="margin-bottom: 20px;">
                    <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Profile Picture" style="height: 100px; width: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb;">
                </div>
            @endif
            <div class="row">
                <div class="label">Full Name: </div>
                <div class="value">{{ $employee->first_name }} {{ $employee->last_name }}</div>
            </div>
            <div class="row">
                <div class="label">Gender:</div>
                <div class="value">{{ $employee->gender }}</div>
            </div>
            <div class="row">
                <div class="label">Date of Birth:</div>
                <div class="value">{{ $employee->date_of_birth }}</div>
            </div>
            <div class="row">
                <div class="label">Email:</div>
                <div class="value">{{ $employee->email }}</div>
            </div>
            <div class="row">
                <div class="label">Phone:</div>
                <div class="value">{{ $employee->phone }}</div>
            </div>
            <div class="row">
                <div class="label">Address:</div>
                <div class="value">{{ $employee->address }}</div>
            </div>
            <div class="row">
                <div class="label">Position:</div>
                <div class="value">{{ $employee->position }}</div>
            </div>
            <div class="row">
                <div class="label">Department:</div>
                <div class="value">{{ $employee->department }}</div>
            </div>
            <div class="row">
                <div class="label">Hire Date:</div>
                <div class="value">{{ $employee->hiring_date }}</div>
            </div>
            <div class="row">
                <div class="label">Salary:</div>
                <div class="value">${{ number_format($employee->salary, 2) }}</div>
            </div>
            <div class="row">
                <div class="label">Status:</div>
                <div class="value">
                    @php
                        $badgeClass = match($employee->status) {
                            'Active' => 'badge-active',
                            'Inactive' => 'badge-inactive',
                            'Resigned' => 'badge-resigned',
                            'Terminated' => 'badge-terminated',
                            default => '',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $employee->status }}</span>
                </div>
            </div>
        </div>
        <div class="actions">
            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back to list</a>
        </div>
@endsection