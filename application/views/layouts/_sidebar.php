<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- Submemu Dashboard -->
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('home') ?>" aria-expanded="false">
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <li class="nav-small-cap"><span class="hide-menu">Manajemen Barang</span></li>

                <?php if ($this->session->userdata('role') != 'purchasing_admin'): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?= base_url('items/register') ?>" aria-expanded="false">
                            <i data-feather="clipboard" class="feather-icon"></i>
                            <span class="hide-menu">Register Barang</span>
                        </a>
                    </li>
                <?php endif ?>

                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('items') ?>" aria-expanded="false">
                        <i data-feather="package" class="feather-icon"></i>
                        <span class="hide-menu">Daftar Barang</span>
                    </a>
                </li>
                <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?= base_url('unit') ?>" aria-expanded="false">
                            <i data-feather="plus-square" class="feather-icon"></i>
                            <span class="hide-menu">Tambah Satuan</span>
                        </a>
                    </li>
                <?php endif ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= base_url('units') ?>" aria-expanded="false">
                        <i data-feather="layers" class="feather-icon"></i>
                        <span class="hide-menu">Daftar Satuan</span>
                    </a>
                </li>

                <!-- <?php if ($this->session->userdata('role') == 'admin'): ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= base_url('category') ?>" aria-expanded="false">
                        <i data-feather="plus-square" class="feather-icon"></i>
                        <span class="hide-menu">Tambah Kategori</span>
                    </a>
                </li>
                <?php endif ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= base_url('categories') ?>" aria-expanded="false">
                        <i class="fas fa-tags"></i>
                        <span class="hide-menu">List Kategori</span>
                    </a>
                </li> -->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= base_url('locations') ?>" aria-expanded="false">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="hide-menu">Daftar Letak Barang</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <!-- Submenu Manajemen Supplier -->
                <!-- <li class="nav-small-cap"><span class="hide-menu">Manajemen Supplier</span></li> -->
                <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <!-- <li class="sidebar-item">
                        <a class="sidebar-link" href="<?= base_url('suppliers/add') ?>" aria-expanded="false">
                            <i data-feather="user-plus" class="feather-icon"></i>
                            <span class="hide-menu">Tambah Supplier</span>
                        </a>
                    </li> -->
                <?php endif ?>
                <!-- <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= base_url('suppliers') ?>" aria-expanded="false">
                        <i data-feather="truck" class="feather-icon"></i>
                        <span class="hide-menu">List Supplier</span>
                    </a>
                </li> -->

                <!-- <li class="list-divider"></li> -->

                <!-- Submemu Manajemen Gudang -->

                <li class="nav-small-cap"><span class="hide-menu">Manajemen Gudang</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('warehouses') ?>" aria-expanded="false">
                        <i class="fas fa-warehouse"></i>
                        <span class="hide-menu">Gudang</span>
                    </a>
                </li>
                <?php if ($this->session->userdata('role') != 'purchasing_admin'): ?>
                    <li class="list-divider"></li>
                    <!-- Submemu Barang -->
                    <li class="nav-small-cap"><span class="hide-menu">Barang Masuk</span></li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?= base_url('cartin') ?>" aria-expanded="false">
                            <i data-feather="log-in" class="feather-icon"></i>
                            <span class="hide-menu">Barang Masuk</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link sidebar-link" href="<?= base_url('inputs') ?>" aria-expanded="false">
                            <i data-feather="file-text" class="feather-icon"></i>
                            <span class="hide-menu">Catatan Masuk</span>
                        </a>
                    </li>
                <?php endif ?>
                <li class="list-divider"></li>
                <?php if ($this->session->userdata('role') != 'purchasing_admin'): ?>
                    <!-- Submemu Manajemen Inventory -->
                    <li class="nav-small-cap"><span class="hide-menu">Barang Keluar</span></li>
                    <li class="sidebar-item">
                        <a class="sidebar-link sidebar-link" href="<?= base_url('cartout') ?>" aria-expanded="false">
                            <i data-feather="log-out" class="feather-icon"></i>
                            <span class="hide-menu">Barang Keluar</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link sidebar-link" href="<?= base_url('outputs') ?>" aria-expanded="false">
                            <i data-feather="file-text" class="feather-icon"></i>
                            <span class="hide-menu">Catatan Keluar</span>
                        </a>
                    </li>
                    <li class="list-divider"></li>
                <?php endif ?>
                <?php if ($this->session->userdata('role') != 'purchasing_admin'): ?>
                    <!-- Submenu Transfer Barang -->
                    <li class="nav-small-cap"><span class="hide-menu">Pemindahan Barang</span></li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?= base_url('transfer/create') ?>" aria-expanded="false">
                            <i data-feather="repeat" class="feather-icon"></i>
                            <span class="hide-menu">Pemindahan Barang</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link sidebar-link" href="<?= base_url('transfer') ?>" aria-expanded="false">
                            <i data-feather="list" class="feather-icon"></i>
                            <span class="hide-menu">Riwayat Pemindahan</span>
                        </a>
                    </li>
                    <li class="list-divider"></li>
                <?php endif ?>

                <!-- Submenu Permintaan Barang -->
                <?php if ($this->session->userdata('role') != 'purchasing_admin'): ?>
                    <li class="nav-small-cap"><span class="hide-menu">Permintaan Barang</span></li>
                    <?php if ($this->session->userdata('role') == 'staff'): ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?= base_url('preorder/create') ?>" aria-expanded="false">
                                <i data-feather="plus-circle" class="feather-icon"></i>
                                <span class="hide-menu">Buat Permintaan</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?= base_url('preorder') ?>" aria-expanded="false">
                            <i data-feather="clipboard" class="feather-icon"></i>
                            <span class="hide-menu">Daftar Permintaan</span>
                        </a>
                    </li>
                    <li class="list-divider"></li>
                <?php endif ?>

                <!-- Submenu Purchasing -->
                <li class="nav-small-cap"><span class="hide-menu">Purchasing</span></li>
                <?php if ($this->session->userdata('role') == 'staff'): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?= base_url('purchaserequest/create') ?>" aria-expanded="false">
                            <i data-feather="plus-circle" class="feather-icon"></i>
                            <span class="hide-menu">Buat Purchase Request</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= base_url('purchaserequest') ?>" aria-expanded="false">
                        <i data-feather="file-text" class="feather-icon"></i>
                        <span class="hide-menu">Purchase Requests</span>
                    </a>
                </li>
                <li class="list-divider"></li>

                <!-- Submemu Manajemen Karyawan -->
                <li class="nav-small-cap"><span class="hide-menu">Manajemen Staff</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('users') ?>" aria-expanded="false">
                        <i data-feather="users" class="feather-icon"></i>
                        <span class="hide-menu">List Staff</span>
                    </a>
                </li>
                <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link sidebar-link" href="<?= base_url('register') ?>" aria-expanded="false">
                            <i data-feather="user-plus" class="feather-icon"></i>
                            <span class="hide-menu">Register Staff</span>
                        </a>
                    </li>
                <?php endif ?>

                <!-- <li class="list-divider"></li> -->

                <!-- Submemu Extra -->
                <!-- <li class="nav-small-cap"><span class="hide-menu">Extra</span></li> -->
                <!-- <li class="sidebar-item"> 
                    <a class="sidebar-link sidebar-link" href="https://github.com/muhammadrafidd?tab=repositories" aria-expanded="false">
                        <i data-feather="github" class="feather-icon"></i>
                        <span class="hide-menu">Repository</span>
                    </a>
                </li> -->
                <!-- <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('about') ?>" aria-expanded="false">
                        <i data-feather="info" class="feather-icon"></i>
                        <span class="hide-menu">About us</span>
                    </a>
                </li> -->
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->