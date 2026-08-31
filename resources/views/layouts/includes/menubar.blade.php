<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a
            class="nav-link"
            data-lte-toggle="sidebar"
            href="#"
            role="button"
            aria-label="Toggle sidebar"
            >
            <i class="bi bi-list"></i>
            </a>
        </li>
        </ul>
        <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
            <form class="d-flex" role="search">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-navbar" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </li>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('assets/images/CashLogo.png') }}" class="user-image rounded-circle shadow" alt="System Logo" style="width: 32px; height: 32px; object-fit: contain; background: #fff; padding: 2px;">
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            </a>
            
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <li class="user-header text-bg-primary">
                    <img src="{{ asset('assets/images/CashLogo.png') }}" class="rounded-circle shadow" alt="System Logo" style="width: 60px; height: 60px; object-fit: contain; background: #fff; padding: 4px; margin-bottom: 8px;">
                    <p>
                        {{ Auth::user()->name }}
                        <small>{{ ucfirst(Auth::user()->role) }} • Cash Loan Management</small>
                    </p>
                </li>
                
                <li class="user-footer">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">Profile</a>
                        <button type="submit" class="btn btn-outline-danger float-end">Sign out</button>
                    </form>
                </li>
            </ul>
        </li>
        </ul>
    </div> 
</nav>