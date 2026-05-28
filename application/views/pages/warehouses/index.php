<style>
    .gudang-card .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .gudang-card .card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .gudang-card .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .gudang-card .count-badge {
        background: #eff6ff;
        color: #2563eb;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
        letter-spacing: 0.04em;
    }

    .gudang-card .search-form {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .gudang-card .search-input {
        height: 36px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 0 12px 0 34px;
        font-size: 0.82rem;
        color: #0f172a;
        background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 10px center;
        min-width: 220px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .gudang-card .search-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        background-color: #fff;
    }

    .gudang-card .btn-search {
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

    .gudang-card .btn-search:hover { background: #1d4ed8; }

    .gudang-card .btn-reset {
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

    .gudang-card .btn-reset:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .gudang-card .btn-add {
        height: 36px;
        padding: 0 14px;
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }

    .gudang-card .btn-add:hover { background: #1d4ed8; color: #fff; text-decoration: none; }

    /* Table */
    .gudang-table {
        width: 100%;
        border-collapse: collapse;
    }

    .gudang-table thead th {
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

    .gudang-table tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.1s;
    }

    .gudang-table tbody tr:hover { background: #fafbfd; }
    .gudang-table tbody tr:last-child { border-bottom: none; }

    .gudang-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 0.85rem;
        color: #374151;
    }

    .gudang-avatar {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .gudang-name-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .gudang-name { font-weight: 500; color: #0f172a; font-size: 0.875rem; }

    .addr-text { color: #64748b; font-size: 0.82rem; }

    .item-count-badge {
        background: #f1f5f9;
        color: #475569;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
        display: inline-block;
    }

    /* Action buttons */
    .gudang-btn {
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

    .gudang-btn:hover { transform: translateY(-1px); text-decoration: none; }

    .gudang-btn.view   { background: #e0f2fe; color: #0369a1; }
    .gudang-btn.view:hover  { background: #bae6fd; }

    .gudang-btn.edit   { background: #fef9c3; color: #854d0e; }
    .gudang-btn.edit:hover  { background: #fef08a; }

    .gudang-btn.delete { background: #fff1f2; color: #e11d48; }
    .gudang-btn.delete:hover { background: #fee2e2; }

    /* Empty state */
    .gudang-empty {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .gudang-empty i { font-size: 2.5rem; margin-bottom: 12px; opacity: 0.5; }
    .gudang-empty p { margin: 0; font-size: 0.875rem; }

    .row-num { color: #94a3b8; font-size: 0.8rem; }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card gudang-card"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- Header -->
                <div class="card-header-custom">
                    <div class="card-header-left">
                        <h5 class="page-title">Daftar Gudang</h5>
                        <?php if (!empty($content)): ?>
                            <span class="count-badge"><?= count($content) ?> Gudang</span>
                        <?php endif ?>
                    </div>
                    <div class="d-flex align-items-center" style="gap:10px; flex-wrap:wrap;">
                        <form action="<?= base_url('warehouses/search') ?>" method="POST" class="search-form">
                            <input type="text" name="keyword" class="search-input"
                                placeholder="Cari nama atau alamat gudang..."
                                value="<?= $this->session->userdata('keyword') ?>">
                            <button type="submit" class="btn-search">Cari</button>
                        </form>
                        <?php if ($this->session->userdata('keyword')): ?>
                            <a href="<?= base_url('warehouses') ?>" class="btn-reset">
                                <i class="fas fa-times" style="font-size:0.7rem; margin-right:5px;"></i> Reset
                            </a>
                        <?php endif ?>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                            <button class="btn-add" data-toggle="modal" data-target="#addModal">
                                <i class="fas fa-plus" style="font-size:0.75rem;"></i> Tambah Gudang
                            </button>
                        <?php endif ?>
                    </div>
                </div>

                <!-- Table -->
                <?php if (empty($content)): ?>
                    <div class="gudang-empty">
                        <div><i class="fas fa-warehouse"></i></div>
                        <p>Tidak ada data gudang ditemukan.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="gudang-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Gudang</th>
                                    <th>Alamat</th>
                                    <th class="text-center">Jenis Barang</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = isset($start) ? $start + 1 : 1;
                                foreach ($content as $row):
                                    $jumlah_barang = $this->db->where('id_gudang', $row->id)->count_all_results('stok_gudang');
                                ?>
                                    <tr>
                                        <td class="row-num"><?= $no++ ?></td>
                                        <td>
                                            <div class="gudang-name-cell">
                                                <div class="gudang-avatar">
                                                    <i class="fas fa-warehouse"></i>
                                                </div>
                                                <span class="gudang-name"><?= htmlspecialchars($row->nama) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($row->alamat): ?>
                                                <span class="addr-text">
                                                    <i class="fas fa-map-marker-alt" style="color:#f87171; margin-right:4px; font-size:0.75rem;"></i>
                                                    <?= htmlspecialchars($row->alamat) ?>
                                                </span>
                                            <?php else: ?>
                                                <span style="color:#cbd5e1;">—</span>
                                            <?php endif ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="item-count-badge"><?= $jumlah_barang ?> item</span>
                                        </td>
                                        <td class="text-center">
                                            <div style="display:flex; gap:6px; justify-content:center;">
                                                <a href="<?= base_url('warehouse/detail/' . $row->id) ?>"
                                                    class="gudang-btn view" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                                    <button class="gudang-btn edit" data-toggle="modal"
                                                        data-target="#editModal<?= $row->id ?>" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="gudang-btn delete" data-toggle="modal"
                                                        data-target="#deleteModal<?= $row->id ?>" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                <?php endif ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>

                <!-- Pagination -->
                <?php if (!empty($pagination)): ?>
                    <div class="wms-pag-footer">
                        <nav aria-label="Navigasi halaman"><?= $pagination ?></nav>
                    </div>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>

<!-- Modals Edit & Delete -->
<?php if (!empty($content)): ?>
    <?php foreach ($content as $row): ?>
        <div class="modal fade" id="editModal<?= $row->id ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:12px; border:none; box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                    <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:20px 24px 16px;">
                        <h5 class="modal-title" style="font-size:0.95rem; font-weight:600; color:#0f172a;">Edit Gudang</h5>
                        <button type="button" class="close" data-dismiss="modal" style="color:#94a3b8;">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('warehouse/update') ?>" method="POST">
                        <div class="modal-body" style="padding:20px 24px;">
                            <input type="hidden" name="id" value="<?= $row->id ?>">
                            <div class="form-group">
                                <label style="font-size:0.82rem; font-weight:500; color:#374151;">Nama Gudang</label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row->nama) ?>"
                                    style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.85rem;" required>
                            </div>
                            <div class="form-group mb-0">
                                <label style="font-size:0.82rem; font-weight:500; color:#374151;">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3"
                                    style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.85rem; resize:none;"><?= htmlspecialchars($row->alamat) ?></textarea>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:16px 24px;">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                                style="border-radius:8px;">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm"
                                style="border-radius:8px; background:#2563eb; border:none;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal<?= $row->id ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:12px; border:none; box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                    <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:20px 24px 16px;">
                        <h5 class="modal-title" style="font-size:0.95rem; font-weight:600; color:#0f172a;">Hapus Gudang</h5>
                        <button type="button" class="close" data-dismiss="modal" style="color:#94a3b8;">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:20px 24px;">
                        <p style="font-size:0.875rem; color:#374151; margin-bottom:8px;">
                            Hapus gudang <strong><?= htmlspecialchars($row->nama) ?></strong>?
                        </p>
                        <p style="font-size:0.8rem; color:#ef4444; margin:0;">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Gudang dengan stok barang tidak dapat dihapus.
                        </p>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:16px 24px;">
                        <form action="<?= base_url('warehouse/delete') ?>" method="POST">
                            <input type="hidden" name="id" value="<?= $row->id ?>">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                                style="border-radius:8px;">Batal</button>
                            <button type="submit" class="btn btn-danger btn-sm"
                                style="border-radius:8px;">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>

<!-- Modal Tambah Gudang -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:12px; border:none; box-shadow:0 8px 32px rgba(0,0,0,0.12);">
            <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:20px 24px 16px;">
                <h5 class="modal-title" style="font-size:0.95rem; font-weight:600; color:#0f172a;">Tambah Gudang Baru</h5>
                <button type="button" class="close" data-dismiss="modal" style="color:#94a3b8;">
                    <span>&times;</span>
                </button>
            </div>
            <form action="<?= base_url('warehouse/add') ?>" method="POST">
                <div class="modal-body" style="padding:20px 24px;">
                    <div class="form-group">
                        <label style="font-size:0.82rem; font-weight:500; color:#374151;">Nama Gudang</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Gudang Utama"
                            style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.85rem;" required>
                    </div>
                    <div class="form-group mb-0">
                        <label style="font-size:0.82rem; font-weight:500; color:#374151;">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3"
                            placeholder="Alamat lengkap gudang"
                            style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.85rem; resize:none;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:16px 24px;">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                        style="border-radius:8px;">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm"
                        style="border-radius:8px; background:#2563eb; border:none;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
