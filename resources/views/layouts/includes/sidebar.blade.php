<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    @php
        $isDashboard = request()->routeIs('dashboard');
        $isCategory  = request()->routeIs('categories.*');
        $isCustomer  = request()->routeIs('customers.*');
        $isEmployee  = request()->routeIs('employees.*');
        $isLoan      = request()->routeIs('loans.*');
    @endphp

    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <span class="brand-text fw-bold text-primary">Cash Loan App</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2" aria-label="Main navigation">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" data-accordion="false" id="navigation">
                
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ $isDashboard ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <li class="nav-header">LOAN OPERATIONS</li>

                {{-- Loan Application (Customer) --}}
                <li class="nav-item">
                    <a href="{{ Route::has('loans.apply') ? route('loans.apply') : '#' }}" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-plus"></i>
                        <p>Apply Loan</p>
                    </a>
                </li>

                {{-- Pending Approvals (Loan Officer) --}}
                <li class="nav-item">
                    <a href="{{ Route::has('loans.pending') ? route('loans.pending') : '#' }}" class="nav-link">
                        <i class="nav-icon bi bi-clock-history"></i>
                        <p>Pending Loans</p>
                    </a>
                </li>

                {{-- Repayments (Cashier) --}}
                <li class="nav-item">
                    <a href="{{ Route::has('repayments.create') ? route('repayments.create') : '#' }}" class="nav-link">
                        <i class="nav-icon bi bi-cash-stack"></i>
                        <p>Record Payment</p>
                    </a>
                </li>

                <li class="nav-header">MASTER DATA</li>

                {{-- Categories --}}
                <li class="nav-item">
                    <a href="{{ Route::has('categories.index') ? route('categories.index') : '#' }}" class="nav-link {{ $isCategory ? 'active' : '' }}">
                        <i class="nav-icon bi bi-grid"></i>
                        <p>Categories</p>
                    </a>
                </li>

                {{-- Customers --}}
                <li class="nav-item">
                    <a href="{{ Route::has('customers.index') ? route('customers.index') : '#' }}" class="nav-link {{ $isCustomer ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Customers</p>
                    </a>
                </li>

                {{-- Employees --}}
                <li class="nav-item">
                    <a href="{{ Route::has('employees.index') ? route('employees.index') : '#' }}" class="nav-link {{ $isEmployee ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-badge"></i>
                        <p>Employees</p>
                    </a>
                </li>

            </ul>

            {{-- Real Working Breeze Logout --}}
            <div class="p-3 mt-3 border-top border-secondary border-opacity-25">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </div>

        </nav>
    </div>
</aside>