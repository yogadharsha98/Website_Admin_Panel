<!-- Sidebar Navigation -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/home') }}">
                <i class="fas fa-tachometer-alt menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

          <!-- Customer List -->
          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/customer') }}">
                <i class="fas fa-tachometer-alt menu-icon"></i>
                <span class="menu-title">Customers</span>
            </a>
        </li>

        <!-- Category Management -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#category" aria-expanded="false"
                aria-controls="category">
                <i class="mdi mdi-account-key menu-icon"></i>
                <span class="menu-title">Category Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="category">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/category') }}">
                            <i class="mdi mdi-account menu-icon"></i>
                            Category List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/sub-category') }}">
                            <i class="mdi mdi-lock menu-icon"></i>
                            Sub-Cayegory List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/custom-field') }}">
                            <i class="mdi mdi-lock menu-icon"></i>
                            Custom Fields
                        </a>
                    </li>
                </ul>
            </div>
        </li>



        <!-- User Management -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#roles-permissions" aria-expanded="false"
                aria-controls="roles-permissions">
                <i class="mdi mdi-account-key menu-icon"></i>
                <span class="menu-title">User Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="roles-permissions">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="mdi mdi-account menu-icon"></i>
                            User List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('permissions.index') }}">
                            <i class="mdi mdi-lock menu-icon"></i>
                            Permissions List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}">
                            <i class="mdi mdi-account-group menu-icon"></i>
                            Roles List
                        </a>
                    </li>
                </ul>
            </div>
        </li>

    </ul>
</nav>
