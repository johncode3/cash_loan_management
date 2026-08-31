<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    @php
        $isDashboard = request()->routeIs('dashboard');
        $isCategory  = request()->routeIs('categories.*');
        $isCustomer  = request()->routeIs('customers.*');
        $isEmployee  = request()->routeIs('employees.*');
        $isUser      = request()->routeIs('users.*');
        $isApply     = request()->routeIs('loans.apply');
        $isPending   = request()->routeIs('loans.pending');
        $isRepay     = request()->routeIs('repayments.*');
        $isOverdue   = request()->routeIs('dashboard.overdue');
    @endphp

    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/images/CashLogo.png') }}" alt="Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-bold text-primary ms-2">Cash Loan App</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2" aria-label="Main navigation">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" data-accordion="false" id="navigation">
           
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ $isDashboard ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">LOAN MANAGEMENT</li>

                @if(in_array(Auth::user()->role, ['customer', 'loan_officer', 'admin']))
                    <li class="nav-item">
                        <a href="{{ Route::has('loans.apply') ? route('loans.apply') : '#' }}" class="nav-link {{ $isApply ? 'active' : '' }}">
                            <i class="nav-icon bi bi-file-earmark-plus"></i>
                            <p>Apply Loan</p>
                        </a>
                    </li>
                @endif

                @if(in_array(Auth::user()->role, ['admin', 'loan_officer']))
                    <li class="nav-item">
                        <a href="{{ Route::has('loans.pending') ? route('loans.pending') : '#' }}" class="nav-link {{ $isPending ? 'active' : '' }}">
                            <i class="nav-icon bi bi-clock-history"></i>
                            <p>Pending Approvals</p>
                        </a>
                    </li>
                @endif
                
                @if(in_array(Auth::user()->role, ['admin', 'loan_officer', 'cashier']))
                    <li class="nav-item">
                        <a href="{{ route('loans.index') }}" class="nav-link {{ request()->routeIs('loans.index') || request()->routeIs('loans.schedule') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-calendar-check"></i>
                            <p>Loan Schedules</p>
                        </a>
                    </li>
                @endif
                
                @if(in_array(Auth::user()->role, ['admin', 'cashier']))
                    <li class="nav-item">
                        <a href="{{ Route::has('repayments.create') ? route('repayments.create') : '#' }}" class="nav-link {{ $isRepay ? 'active' : '' }}">
                            <i class="nav-icon bi bi-cash-stack"></i>
                            <p>Record Payment</p>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a href="{{ Route::has('dashboard.overdue') ? route('dashboard.overdue') : '#' }}" class="nav-link text-danger {{ $isOverdue ? 'active' : '' }}">
                            <i class="nav-icon bi bi-exclamation-triangle text-danger"></i>
                            <p>Overdue Dashboard</p>
                        </a>
                    </li>
                @endif

                @if(in_array(Auth::user()->role, ['admin', 'loan_officer', 'cashier']))
                    <li class="nav-header">MASTER DATA</li>

                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link {{ $isCategory ? 'active' : '' }}">
                            <i class="nav-icon bi bi-grid"></i>
                            <p>Categories</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('customers.index') }}" class="nav-link {{ $isCustomer ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people"></i>
                            <p>Customers</p>
                        </a>
                    </li>

                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('employees.index') }}" class="nav-link {{ $isEmployee ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-badge"></i>
                                <p>Employees</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ Route::has('users.index') ? route('users.index') : '#' }}" class="nav-link {{ $isUser ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-gear"></i>
                                <p>Users Management</p>
                            </a>
                        </li>
                    @endif
                @endif
            </ul>

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