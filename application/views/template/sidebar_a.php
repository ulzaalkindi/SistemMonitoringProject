<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-info nav-compat elevation-2">
    <!-- Brand Logo -->
    <a href="<?= base_url('admin'); ?>" class="brand-link navbar-info">
        <img src="<?= base_url('assets/img/'); ?>logo.svg" alt="AdminLTE Logo" class="brand-image img-circle elevation-2" style="opacity: .8">
        <span class="brand-text font-weight-dark text-white">Sitem Monitoring</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?= base_url('admin'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/projectclient'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-university"></i>
                        <p>
                            Project
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/evaluasi'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-archive"></i>
                        <p>
                            Evaluasi
                        </p>
                    </a>
                </li>
                <li class="nav-header">Account</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>
                            Users
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/devel'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-user-secret"></i>
                                <p>
                                    Developer
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/client'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    Client
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">