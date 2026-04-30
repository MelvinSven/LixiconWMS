<style>
    /* Staff list page overrides */
    .staff-card .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .staff-card .card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .staff-card .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .staff-card .count-badge {
        background: #eff6ff;
        color: #2563eb;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
        letter-spacing: 0.04em;
    }

    .staff-card .search-form {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .staff-card .search-input {
        height: 36px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 0 12px 0 34px;
        font-size: 0.82rem;
        color: #0f172a;
        background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 10px center;
        min-width: 200px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .staff-card .search-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background-color: #fff;
    }

    .staff-card .btn-search {
        height: 36px;
        padding: 0 14px;
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.15s;
    }

    .staff-card .btn-search:hover {
        background: #1d4ed8;
    }

    .staff-card .btn-reset {
        height: 36px;
        padding: 0 14px;
        background: #f1f5f9;
        color: #475569;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background 0.15s;
    }

    .staff-card .btn-reset:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    /* Table */
    .staff-table {
        width: 100%;
        border-collapse: collapse;
    }

    .staff-table thead th {
        font-size: 0.72rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #94a3b8;
        padding: 10px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .staff-table tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.1s;
    }

    .staff-table tbody tr:hover {
        background: #fafbfd;
    }

    .staff-table tbody tr:last-child {
        border-bottom: none;
    }

    .staff-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 0.85rem;
        color: #374151;
    }

    /* Avatar */
    .staff-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }

    .staff-name-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .staff-name-info .name {
        font-weight: 500;
        color: #0f172a;
        font-size: 0.875rem;
        line-height: 1.3;
    }

    /* Role badge */
    .role-badge {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 20px;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-top: 2px;
    }

    .role-badge.admin {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .role-badge.staff {
        background: #dcfce7;
        color: #15803d;
    }

    .role-badge.purchasing {
        background: #f3e8ff;
        color: #7c3aed;
    }

    /* Status badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .status-badge.aktif {
        background: #dcfce7;
        color: #15803d;
    }

    .status-badge.nonaktif {
        background: #fee2e2;
        color: #dc2626;
    }

    .status-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .status-badge.aktif .dot {
        background: #16a34a;
    }

    .status-badge.nonaktif .dot {
        background: #dc2626;
    }

    /* Gudang badge */
    .gudang-badge {
        background: #f1f5f9;
        color: #475569;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 6px;
        display: inline-block;
    }

    /* Action buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s;
        font-size: 0.8rem;
        text-decoration: none;
    }

    .btn-action:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-action.edit {
        background: #eff6ff;
        color: #2563eb;
    }

    .btn-action.edit:hover {
        background: #dbeafe;
    }

    .btn-action.delete {
        background: #fff1f2;
        color: #e11d48;
    }

    .btn-action.delete:hover {
        background: #fee2e2;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 12px;
        opacity: 0.5;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.875rem;
    }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card staff-card"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- Card header -->
                <div class="card-header-custom">
                    <div class="card-header-left">
                        <h5 class="page-title">Daftar Staff</h5>
                        <span class="count-badge"><?= $total_rows ?> Pengguna</span>
                    </div>
                    <div class="d-flex align-items-center" style="gap:10px; flex-wrap:wrap;">
                        <!-- Search -->
                        <form action="<?= base_url('users/search') ?>" method="POST" class="search-form">
                            <input type="text" name="keyword" class="search-input"
                                placeholder="Cari nama, email, KTP..."
                                value="<?= htmlspecialchars($this->session->userdata('keyword') ?? '') ?>">
                            <button type="submit" class="btn-search">Cari</button>
                        </form>
                        <?php if ($this->uri->segment(2) == 'search'): ?>
                            <a href="<?= base_url('users') ?>" class="btn-reset">
                                <i class="fas fa-times" style="font-size:0.7rem; margin-right:5px;"></i> Reset
                            </a>
                        <?php endif ?>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="staff-table">
                        <thead>
                            <tr>
                                <th>Staff</th>
                                <th>Email</th>
                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                    <th>No. KTP</th>
                                <?php endif ?>
                                <th>Status</th>
                                <th>Telepon</th>
                                <th>Gudang</th>
                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                    <th style="text-align:center;">Aksi</th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($content)): ?>
                                <tr>
                                    <td colspan="<?= $this->session->userdata('role') == 'admin' ? 7 : 4 ?>">
                                        <div class="empty-state">
                                            <div><i class="fas fa-users"></i></div>
                                            <p>Tidak ada data staff ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php
                                $avatar_colors = ['#2563eb', '#7c3aed', '#0891b2', '#0d9488', '#059669', '#d97706', '#dc2626', '#db2777'];
                                foreach ($content as $i => $row):
                                    $color = $avatar_colors[$i % count($avatar_colors)];
                                    $initial = strtoupper(mb_substr($row->nama, 0, 1));
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="staff-name-cell">
                                                <div class="staff-avatar" style="background:<?= $color ?>;"><?= $initial ?>
                                                </div>
                                                <div class="staff-name-info">
                                                    <div class="name"><?= htmlspecialchars($row->nama) ?></div>
                                                    <?php if ($row->role == 'admin'): ?>
                                                        <span class="role-badge admin">Admin</span>
                                                    <?php elseif ($row->role == 'purchasing_admin'): ?>
                                                        <span class="role-badge purchasing">Purchasing</span>
                                                    <?php else: ?>
                                                        <span class="role-badge staff">Staff</span>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="color:#64748b;"><?= htmlspecialchars($row->email) ?></td>
                                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                                            <td style="color:#64748b; font-family:monospace; font-size:0.8rem;">
                                                <?= htmlspecialchars($row->ktp) ?>
                                            </td>
                                        <?php endif ?>
                                        <td>
                                            <?php if ($row->status == 'aktif'): ?>
                                                <span class="status-badge aktif">
                                                    <span class="dot"></span> Aktif
                                                </span>
                                            <?php else: ?>
                                                <span class="status-badge nonaktif">
                                                    <span class="dot"></span> Non-Aktif
                                                </span>
                                            <?php endif ?>
                                        </td>
                                        <td style="color:#64748b;"><?= htmlspecialchars($row->telefon) ?></td>
                                        <td>
                                            <?php if (isset($row->nama_gudang) && $row->nama_gudang): ?>
                                                <span class="gudang-badge"><?= htmlspecialchars($row->nama_gudang) ?></span>
                                            <?php else: ?>
                                                <span style="color:#cbd5e1; font-size:0.8rem;">—</span>
                                            <?php endif ?>
                                        </td>
                                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                                            <td style="text-align:center;">
                                                <div style="display:flex; gap:6px; justify-content:center;">
                                                    <a href="<?= base_url("users/edit/$row->id") ?>" class="btn-action edit"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <?php if ($row->id != $this->session->userdata('id_user')): ?>
                                                        <a href="<?= base_url("users/delete/$row->id") ?>" class="btn-action delete"
                                                            title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    <?php endif ?>
                                                </div>
                                            </td>
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination footer -->
                <div
                    style="padding:16px 20px; border-top:1px solid #f1f5f9; display:flex; align-items:center; justify-content:<?= $this->uri->segment(2) == 'search' ? 'space-between' : 'center' ?>; flex-wrap:wrap; gap:10px;">
                    <?php if ($this->uri->segment(2) == 'search'): ?>
                        <a href="<?= base_url('users') ?>" class="btn-reset">
                            <i class="fas fa-angle-left" style="margin-right:5px;"></i> Semua Staff
                        </a>
                    <?php endif ?>
                    <nav aria-label="Navigasi halaman">
                        <?= $pagination ?>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>