<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $customer->first_name }} {{ $customer->last_name }}</title>
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                padding: 20px;
                background: #f9fafb;
                color: #111827;
                line-height: 1.5;
            }
            h1 {
                margin-bottom: 16px;
            }
            .card {
                max-width: 640px;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                padding: 24px;
                background: #fff;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            }
            .row {
                display: flex;
                gap: 12px;
                margin-bottom: 12px;
                align-items: flex-start;
            }
            .label {
                width: 160px;
                flex-shrink: 0;
                font-weight: 600;
                color: #374151;
                font-size: 0.9rem;
            }
            .value {
                color: #111827;
                font-size: 0.9rem;
            }
            .badge {
                display: inline-block;
                padding: 2px 10px;
                border-radius: 12px;
                font-size: 0.82rem;
                font-weight: 600;
            }
            .badge-active {
                background: #d1fae5;
                color: #065f46;
            }
            .badge-inactive {
                background: #fef3c7;
                color: #92400e;
            }
            .badge-resigned {
                background: #e0e7ff;
                color: #3730a3;
            }
            .badge-terminated {
                background: #fee2e2;
                color: #991b1b;
            }
            .btn {
                display: inline-block;
                padding: 6px 12px;
                border-radius: 4px;
                font-size: 0.85rem;
                text-decoration: none;
                cursor: pointer;
                border: none;
                font-family: inherit;
            }
            .btn-warning {
                background: #d97706;
                color: #fff;
            }
            .btn-secondary {
                background: #6b7280;
                color: #fff;
            }
            .btn:hover {
                opacity: 0.85;
            }
            .actions {
                margin-top: 20px;
                display: flex;
                gap: 8px;
                align-items: center;
            }
            hr {
                border: none;
                border-top: 1px solid #e5e7eb;
                margin: 16px 0;
            }
        </style>
    </head>
    <body>
        <h1>Customer Details</h1>
        <div class="card">
            @if ($customer->profile_picture)
                <div style="margin-bottom: 20px;">
                    <img src="{{ asset('storage/' . $customer->profile_picture) }}" alt="Profile Picture" style="height: 100px; width: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb;">
                </div>
            @endif
            <div class="row">
                <div class="label">Full Name:</div>
                <div class="value">{{ $customer->first_name }} {{ $customer->last_name }}</div>
            </div>
            <div class="row">
                <div class="label">Gender:</div>
                <div class="value">{{ $customer->gender }}</div>
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
        </div>
        <div class="actions">
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back to list</a>
        </div>
    </body>
</html>