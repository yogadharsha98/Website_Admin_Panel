<!-- Sidebar Navigation -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/home') }}">
                <i class="fas fa-tachometer-alt menu-icon" style="color:#007bff;"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- Customer List -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/customer') }}">
                <i class="fas fa-users menu-icon" style="color:#28a745;"></i>
                <span class="menu-title">Customers</span>
            </a>
        </li>

        <!-- Category Management -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#category" aria-expanded="false"
                aria-controls="category">
                <i class="mdi mdi-shape-outline menu-icon" style="color:#fd7e14;"></i>
                <span class="menu-title">Category Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="category">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/category') }}">
                            <i class="mdi mdi-format-list-bulleted menu-icon" style="color:#20c997;"></i>
                            Category List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/sub-category') }}">
                            <i class="mdi mdi-subdirectory-arrow-right menu-icon" style="color:#ffc107;"></i>
                            Sub-Category List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/custom-field') }}">
                            <i class="mdi mdi-playlist-plus menu-icon" style="color:#6f42c1;"></i>
                            Custom Fields
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Sliders List -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/slider') }}">
                <i class="fas fa-images menu-icon" style="color:#e83e8c;"></i>
                <span class="menu-title">Sliders</span>
            </a>
        </li>

        <!-- User Management -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#roles-permissions" aria-expanded="false"
                aria-controls="roles-permissions">
                <i class="mdi mdi-account-key menu-icon" style="color:#6610f2;"></i>
                <span class="menu-title">User Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="roles-permissions">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="mdi mdi-account menu-icon" style="color:#17a2b8;"></i>
                            User List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('permissions.index') }}">
                            <i class="mdi mdi-lock menu-icon" style="color:#dc3545;"></i>
                            Permissions List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}">
                            <i class="mdi mdi-account-group menu-icon" style="color:#20c997;"></i>
                            Roles List
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Website Settings -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/website_settings') }}">
                <i class="fas fa-cogs menu-icon" style="color:#fd7e14;"></i>
                <span class="menu-title">Website Settings</span>
            </a>
        </li>
    </ul>
</nav>
