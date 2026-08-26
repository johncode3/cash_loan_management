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
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <img
                src="../assets/images/profilePic.jpg"
                class="user-image rounded-circle shadow"
                alt="Alexander Pierce"
            />
            <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'User' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <li class="user-header text-bg-primary">
                <img
                src="../assets/images/profilePic.jpg"
                class="rounded-circle shadow"
                alt="Alexander Pierce"
                />
                <p>
                {{ Auth::user()->name ?? 'User' }}
                <small>Me and Computer is Peace.</small>
                </p>
            </li>
            <li class="user-footer">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">Profile</a>
                <a href="{{ route('logout') }}" class="btn btn-outline-danger float-end">Sign out</a>
            </li>
            </ul>
        </li>
        </ul>
    </div> 
</nav>