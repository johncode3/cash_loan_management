@extends('layouts.app')
@section('content')
@section('title', 'Show Customer')
        <h1>Customer Details</h1>
        <div class="card">
            <div class="row">
                <div class="label">Customer Code:</div>
                <div class="value">{{ $customer->customer_code }}</div>
            </div>
            <div class="row">
                <div class="label">Full Name:</div>
                <div class="value">{{ $customer->first_name }} {{ $customer->last_name }}</div>
            </div>
            <div class="row">
                <div class="label">Gender:</div>
                <div class="value">{{ ucfirst ($customer->gender) }}</div>
            </div>
            <div class="row">
                <div class="label">Date of Birth:</div>
                <div class="value">{{ $customer->date_of_birth }}</div>
            </div>
            <div class="row">
                <div class="label">Email:</div>
                <div class="value">{{ $customer->email }}</div>
            </div>
            <div class="row">
                <div class="label">Phone:</div>
                <div class="value">{{ $customer->phone }}</div>
            </div>
            <div class="row">
                <div class="label">Address:</div>
                <div class="value">{{ $customer->address }}</div>
            </div>
            <div class="row">
                <div class="label">City:</div>
                <div class="value">{{ $customer->city }}</div>
            </div>
            <div class="row">
                <div class="label">Status:</div>
                <div class="value">
                    @php
                        $badgeClass = match($customer->status) {
                            'Active' => 'badge-active',
                            'Inactive' => 'badge-inactive',
                            default => '',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $customer->status }}</span>
                </div>
            </div>
            <div class="actions">
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back to list</a>
            </div>
        </div>

@endsection