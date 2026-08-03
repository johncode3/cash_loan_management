<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="./index.html" class="brand-link">
        <img
            src="../assets/images/AdminLTELogo.png"
            alt="Logo"
            class="brand-image opacity-75 shadow"
        />
        <span class="brand-text fw-light">Cash Loan Management</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2" aria-label="Main navigation">
        <ul
            class="nav sidebar-menu flex-column"
            data-lte-toggle="treeview"
            data-accordion="false"
            id="navigation"
        >
            <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon bi bi-speedometer"></i>
                <p>
                Dashboard
                <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="./index.html" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Dashboard v1</p>
                </a>
                </li>
            </ul>
            </li>
            <li class="nav-item">
            <a href="{{route('categories.index')}}" class="nav-link">
                <i class="nav-icon bi bi-file-earmark"></i>
                <p>Category</p>
            </a>

            </li>
            <li class="nav-item">
            <a href="{{route('customers.index')}}" class="nav-link">
                <i class="nav-icon bi bi-file-earmark"></i>
                <p>Customer</p>
            </a>
            </li>

            <li class="nav-item">
            <a href="{{route('employees.index')}}" class="nav-link">
                <i class="nav-icon bi bi-file-earmark"></i>
                <p>Employee</p>
            </a>
            </li>


            <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon bi bi-clipboard-fill"></i>
                <p>
                Layout Options
                <span class="nav-badge badge text-bg-secondary me-3">7</span>
                <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">

                <li class="nav-item">
                <a href="./layout/layout-custom-area.html" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Layout <small>+ Custom Area </small></p>
                </a>
                </li>
            </ul>
            </li>
            <li class="nav-header">MULTI LEVEL EXAMPLE</li>
            <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon bi bi-circle-fill"></i>
                <p>Level 1</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon bi bi-circle-fill"></i>
                <p>
                Level 1
                <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Level 2</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>
                    Level 2
                    <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-record-circle-fill"></i>
                        <p>Level 3</p>
                    </a>
                    </li>
                </ul>
                </li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Level 2</p>
                </a>
                </li>
            </ul>
            </li>
        </ul>
        <div class="p-3 mt-3 border-top border-secondary border-opacity-25">
            <a
            href="./docs/introduction.html"
            class="btn btn-sm btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2"
            >
            <i class="bi bi-lock" aria-hidden="true"></i>
            Logout
            </a>
        </div>
        </nav>
    </div>
</aside>