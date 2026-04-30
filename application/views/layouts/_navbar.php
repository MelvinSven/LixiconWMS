<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-brand">
                <!-- Logo icon -->
                <a href="<?= base_url('home') ?>">
                    <b class="logo-icon">
                        <!-- Dark Logo icon -->
                        <img src="<?= base_url('assets/images/Logo Lixicon.png') ?>" height="40" alt="homepage"
                            class="dark-logo" />
                        <!-- Light Logo icon -->
                        <!-- <img src="<?= base_url('assets/images/Brown.png') ?>" height="40" alt="homepage" class="light-logo" /> -->
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text ml-2">
                        <!-- dark Logo text -->
                        <img src="<?= base_url('assets/images/Brown.png') ?>" height="30" width="100" alt="homepage"
                            class="dark-logo" />
                        <!-- Light Logo text -->
                        <img src="<?= base_url('assets/images/Brown.png') ?>" class="light-logo" height="30" width="100"
                            alt="homepage" />
                    </span>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link" href="javascript:void(0)">
                        <button type="button" class="btn rounded-lg btn-light"><i class="fas fa-user mr-1"></i>
                            &nbsp;Anda
                            sebagai
                            <?= $this->session->userdata('role') ?></button>
                    </a>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-right">
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="<?= $this->session->userdata('role') == 'admin' ? base_url('assets/images/navbar/admin.png') : base_url('assets/images/navbar/user.png') ?>"
                            alt="user" class="rounded-circle" width="40">
                        <span class="ml-2 d-none d-lg-inline-block">
                            <span>Hallo,</span>
                            <span class="text-dark"><?= $this->session->userdata('nama') ?></span>
                            <i data-feather="chevron-down" class="svg-icon"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <a class="dropdown-item" href="<?= base_url("user") ?>">
                            <i data-feather="user" class="svg-icon mr-2 ml-1"></i>My Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"
                            href="<?= base_url("user/edit/" . $this->session->userdata('id_user')) ?>">
                            <i data-feather="settings" class="svg-icon mr-2 ml-1"></i>Account Setting
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= base_url('logout') ?>">
                            <i data-feather="power" class="svg-icon mr-2 ml-1"></i>Logout
                        </a>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->