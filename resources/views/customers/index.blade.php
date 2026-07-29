<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer List</title>
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                padding:20px
            }
            h1 {
                margin-bottom:16px
            }
            .toolbar {
                margin-bottom:14px
            }
            table {
                width:100%;
                border-collapse:collapse
            }
            thead {
                background:#f3f4f6
            }
            th, td {
                padding: 10px 12px;
                border:1px solid #d1d5db;
                text-align:left;
                font-size:0.9rem
            }
            tr:hover td {
                background:#f9fafb
            }
            .badge {
                display:inline-block;
                padding: 2px 8px;
                border-radius: 12px;
                font-size:0.8rem; font-weight:600
            }
            .badge-active {
                background:#d1fae5;
                color:#065f46
            }
            .badge-inactive {
                background: #fef3c7;
                color:#92400e
            }
            .badge-resigned{
                background:#e0e7ff;
                color:#3730a3
            }
            .badge-terminated {
                background:#fee2e2;
                color:#991b1b
            }
            .btn{
                display:inline-block;
                padding: 5px 10px;
                border-radius: 4px;
                font-size:0.82rem;
                text-decoration:none;
                cursor:pointer;
                border: none;
                font-family: inherit
            }
            .btn-primary{
                background:#2563eb;
                color:#fff
            }
            .btn-warning {
                background:#d97706;
                color:#fff
            }
            .btn-info {
                background: #0891b2;
                color:#fff
            }
            .btn-danger {
                background:#dc2626;
                color:#fff
            }
            .btn:hover{
                opacity:0.85
            }
            .filter-bar{
                display: flex;
                flex-wrap:wrap;
                gap:8px;
                align-items:flex-end;
                margin-bottom:14px;
                padding: 12px;
                background: #f9fafb;
                border:1px solid #e5e7eb;
                border-radius:6px
            }
            .filter-bar label{
                font-size:0.78rem;
                color:#374151;
                display:block;
                margin-bottom: 3px
            }
            .filter-bar input,.filter-bar select{
                padding: 5px 8px;
                border:1px solid #d1d5db;
                border-radius: 4px;
                font-size:0.85rem;
                font-family: inherit
            }
            .btn-secondary {
                background:#6b7280;
                color:#fff
            }
            nav .flex.justify-between.flex-1.sm\:hidden, 
            nav p.text-sm.text-gray-700.line-height-7 {
                display: none;
            }

            nav .relative.z-0.inline-flex.rounded-md.shadow-sm {
                display: flex;
                gap: 5px;
            }

            nav a, nav span {
                display: inline-block;
                padding: 6px 12px;
                border: 1px solid #d1d5db;
                border-radius: 4px;
                text-decoration: none;
                color: #374151;
                font-size: 0.85rem;
                background: #fff;
            }

            nav span.z-10 {
                background: #2563eb;
                color: #fff;
                border-color: #2563eb;
            }

            nav a:hover {
                background: #f3f4f6;
            }
            ul.pagination {
                display: flex;
                justify-content: center;
                list-style: none;
                padding: 0;
                margin: 0;
            }
            .alert-success {
                background-color: #d1fae5;
                color: #065f46;
                padding: 10px 15px;
                border-radius: 4px;
                margin-bottom: 16px;
            }
        </style>
    </head>
    <body>
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
                    </td>
                    <td>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete {{ $employee->first_name }}?')">
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
    </body>
</html>