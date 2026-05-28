<style>
    .items-card .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .items-card .card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .items-card .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .items-card .count-badge {
        background: #eff6ff;
        color: #2563eb;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
        letter-spacing: 0.04em;
    }

    .items-card .search-form {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .items-card .search-input {
        height: 36px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 0 12px 0 34px;
        font-size: 0.82rem;
        color: #0f172a;
        background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 10px center;
        min-width: 190px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .items-card .search-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background-color: #fff;
    }

    .items-card .filter-select {
        height: 36px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 0 28px 0 10px;
        font-size: 0.82rem;
        color: #0f172a;
        background: #f8fafc;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 8px center;
        cursor: pointer;
        min-width: 130px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .items-card .filter-select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background-color: #fff;
    }

    .items-card .btn-search {
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

    .items-card .btn-search:hover {
        background: #1d4ed8;
    }

    .items-card .btn-reset {
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

    .items-card .btn-reset:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    /* Table */
    .items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .items-table thead th {
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

    .items-table tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.1s;
    }

    .items-table tbody tr:hover {
        background: #fafbfd;
    }

    .items-table tbody tr:last-child {
        border-bottom: none;
    }

    .items-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 0.85rem;
        color: #374151;
    }

    /* Item avatar */
    .item-avatar {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }

    .item-name-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .item-name-info .name {
        font-weight: 500;
        color: #0f172a;
        font-size: 0.875rem;
    }

    /* Unit badge */
    .unit-badge {
        background: #f1f5f9;
        color: #475569;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 3px 8px;
        border-radius: 6px;
        display: inline-block;
        text-transform: capitalize;
    }

    /* Status badge */
    .item-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .item-status-badge.tersedia {
        background: #dcfce7;
        color: #15803d;
    }

    .item-status-badge.kosong {
        background: #fee2e2;
        color: #dc2626;
    }

    .item-status-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .item-status-badge.tersedia .dot { background: #16a34a; }
    .item-status-badge.kosong .dot  { background: #dc2626; }

    /* Action buttons */
    .item-btn-action {
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

    .item-btn-action:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }

    .item-btn-action.view     { background: #f1f5f9; color: #475569; }
    .item-btn-action.view:hover    { background: #e2e8f0; color: #1e293b; }

    .item-btn-action.stock    { background: #dcfce7; color: #15803d; }
    .item-btn-action.stock:hover   { background: #bbf7d0; }

    .item-btn-action.warehouse { background: #e0f2fe; color: #0369a1; }
    .item-btn-action.warehouse:hover { background: #bae6fd; }

    .item-btn-action.edit     { background: #fef9c3; color: #854d0e; }
    .item-btn-action.edit:hover    { background: #fef08a; }

    .item-btn-action.delete   { background: #fff1f2; color: #e11d48; }
    .item-btn-action.delete:hover  { background: #fee2e2; }

    /* Empty state */
    .items-empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .items-empty-state i {
        font-size: 2.5rem;
        margin-bottom: 12px;
        opacity: 0.5;
    }

    .items-empty-state p {
        margin: 0;
        font-size: 0.875rem;
    }

    .row-num { color: #94a3b8; font-size: 0.8rem; }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card items-card"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- Card header -->
                <div class="card-header-custom">
                    <div class="card-header-left">
                        <h5 class="page-title">Daftar Barang</h5>
                        <?php if (isset($total_rows)): ?>
                            <span class="count-badge"><?= $total_rows ?> Barang</span>
                        <?php endif ?>
                    </div>
                    <div class="d-flex align-items-center" style="gap:10px; flex-wrap:wrap;">
                        <form action="<?= base_url('items/search') ?>" method="POST" class="search-form">
                            <input type="text" name="nama_barang" class="search-input"
                                placeholder="Cari nama barang..."
                                value="<?= isset($search_params['nama_barang']) ? htmlspecialchars($search_params['nama_barang']) : '' ?>">
                            <select name="status" class="filter-select">
                                <option value="">Semua Status</option>
                                <option value="tersedia" <?= (isset($search_params['status']) && $search_params['status'] == 'tersedia') ? 'selected' : '' ?>>Tersedia</option>
                                <option value="kosong"   <?= (isset($search_params['status']) && $search_params['status'] == 'kosong')   ? 'selected' : '' ?>>Kosong</option>
                            </select>
                            <button type="submit" class="btn-search">Cari</button>
                        </form>
                        <?php if (!empty($search_params) && array_filter($search_params)): ?>
                            <a href="<?= base_url('items') ?>" class="btn-reset">
                                <i class="fas fa-times" style="font-size:0.7rem; margin-right:5px;"></i> Reset
                            </a>
                        <?php endif ?>
                    </div>
                </div>

                <!-- Table -->
                <?php if (empty($content)): ?>
                    <div class="items-empty-state">
                        <div><i class="fas fa-boxes"></i></div>
                        <p>Tidak ada data barang ditemukan.</p>
                        <?php if (!empty($search_params) && array_filter($search_params)): ?>
                            <a href="<?= base_url('items') ?>" class="btn-reset" style="margin-top:12px; display:inline-flex;">
                                <i class="fas fa-angle-left" style="margin-right:5px;"></i> Semua Barang
                            </a>
                        <?php endif ?>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-center">Status</th>
                                    <th style="text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $item_colors = ['#2563eb', '#7c3aed', '#0891b2', '#0d9488', '#059669', '#d97706', '#dc2626', '#db2777'];
                                $no = isset($start) ? $start + 1 : 1;
                                foreach ($content as $i => $row):
                                    $color   = $item_colors[$i % count($item_colors)];
                                    $initial = strtoupper(mb_substr($row->nama_barang, 0, 1));
                                ?>
                                    <tr>
                                        <td class="row-num"><?= $no++ ?></td>
                                        <td>
                                            <div class="item-name-cell">
                                                <!-- <div class="item-avatar" style="background:<?= $color ?>;"><?= $initial ?></div> -->
                                                <div class="item-name-info">
                                                    <div class="name"><?= htmlspecialchars($row->nama_barang) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="color:#64748b;">
                                            <?= isset($row->deskripsi) && $row->deskripsi ? htmlspecialchars($row->deskripsi) : '<span style="color:#cbd5e1;">—</span>' ?>
                                        </td>
                                        <td class="text-center" style="font-weight:600; color:#0f172a;"><?= number_format($row->qty) ?></td>
                                        <td class="text-center">
                                            <span class="unit-badge"><?= ucfirst($row->nama_satuan) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($row->qty > 0): ?>
                                                <span class="item-status-badge tersedia">
                                                    <span class="dot"></span> Tersedia
                                                </span>
                                            <?php else: ?>
                                                <span class="item-status-badge kosong">
                                                    <span class="dot"></span> Kosong
                                                </span>
                                            <?php endif ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <div style="display:flex; gap:6px; justify-content:center;">
                                                <button type="button" class="item-btn-action view"
                                                    data-toggle="modal" data-target="#imageModal<?= $row->id_barang ?>"
                                                    title="Lihat Gambar">
                                                    <i class="fas fa-image"></i>
                                                </button>
                                                <?php if (!empty($is_staff)): ?>
                                                    <button type="button" class="item-btn-action stock"
                                                        data-toggle="modal" data-target="#updateStokModal<?= $row->id_barang ?>"
                                                        title="Update Stok">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" class="item-btn-action warehouse"
                                                        data-toggle="modal" data-target="#stokGudangModal<?= $row->id_barang ?>"
                                                        title="Lihat Stok per Gudang">
                                                        <i class="fas fa-warehouse"></i>
                                                    </button>
                                                <?php endif ?>
                                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                                    <button class="item-btn-action edit"
                                                        data-toggle="modal" data-target="#editModal<?= $row->id_barang ?>"
                                                        title="Edit Barang">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="item-btn-action delete"
                                                        data-toggle="modal" data-target="#deleteModal<?= $row->id_barang ?>"
                                                        title="Hapus Barang">
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

                <!-- Pagination footer -->
                <?php if (!empty($pagination)): ?>
                    <div class="wms-pag-footer <?= (!empty($search_params) && array_filter($search_params)) ? 'wms-pag-split' : '' ?>">
                        <?php if (!empty($search_params) && array_filter($search_params)): ?>
                            <a href="<?= base_url('items') ?>" class="btn-reset">
                                <i class="fas fa-angle-left"></i> Semua Barang
                            </a>
                        <?php endif ?>
                        <nav aria-label="Navigasi halaman"><?= $pagination ?></nav>
                    </div>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<?php
$cachedUnits     = getUnits();
$cachedLocations = getLocations();
?>
<?php foreach ($content as $row): ?>
    <?php
    $defaultImg          = base_url('uploads/items/default.png');
    $imgPath             = !empty($row->image) ? $row->image : 'uploads/items/default.png';
    $normalizedLocalPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, FCPATH . $imgPath);
    $imgUrl              = (!empty($row->image) && file_exists($normalizedLocalPath))
        ? base_url($imgPath)
        : $defaultImg;
    ?>

    <?php if (!empty($is_staff)): ?>
    <!-- Modal Update Stok (Staff) -->
    <div class="modal fade" id="updateStokModal<?= $row->id_barang ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Update Stok Barang</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="<?= base_url('warehouse/update_stock') ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_barang" value="<?= $row->id_barang ?>">
                        <input type="hidden" name="id_gudang" value="<?= $user_gudang_id ?>">
                        <input type="hidden" name="redirect_to" value="<?= current_url() ?>">

                        <div class="alert alert-info">
                            <strong><?= htmlspecialchars($row->nama_barang) ?></strong><br>
                            Gudang: <?= getWarehouseName($user_gudang_id) ?><br>
                            Stok saat ini: <strong><?= number_format($row->qty) ?></strong> <?= $row->nama_satuan ?>
                        </div>

                        <div class="form-group mb-0">
                            <label><strong>Stok Baru</strong></label>
                            <input type="number" name="qty" min="0" value="<?= $row->qty ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif ?>

    <!-- Modal Lihat Gambar -->
    <div class="modal fade" id="imageModal<?= $row->id_barang ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title"><i class="fas fa-image mr-2"></i><?= $row->nama_barang ?></h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center p-3">
                    <img src="<?= $imgUrl ?>" alt="<?= $row->nama_barang ?>" class="img-fluid rounded"
                        style="max-height: 400px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Stok per Gudang -->
    <div class="modal fade" id="stokGudangModal<?= $row->id_barang ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-warehouse mr-2"></i>Stok <?= $row->nama_barang ?> per Gudang</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $stokList = getStokBarangAllGudang($row->id_barang); ?>
                    <?php if (empty($stokList)): ?>
                        <div class="alert alert-warning">Barang ini belum tersedia di gudang manapun</div>
                    <?php else: ?>
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Gudang</th>
                                    <th class="text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stokList as $stok): ?>
                                    <?php if ($stok->qty > 0): ?>
                                        <tr>
                                            <td><?= $stok->nama_gudang ?></td>
                                            <td class="text-center">
                                                <span class="badge badge-success">
                                                    <?= $stok->qty ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php endif ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Barang -->
    <div class="modal fade" id="editModal<?= $row->id_barang ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="<?= base_url('items/update/' . $row->id_barang) ?>" method="POST"
                    enctype="multipart/form-data">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-white">Edit Barang - <?= $row->nama_barang ?></h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input type="text" name="nama" class="form-control" value="<?= $row->nama_barang ?>"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Satuan</label>
                            <select name="id_satuan" class="form-control">
                                <?php foreach ($cachedUnits as $unit): ?>
                                    <option value="<?= $unit->id ?>" <?= $unit->nama == $row->nama_satuan ? 'selected' : '' ?>>
                                        <?= ucfirst($unit->nama) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="2"
                                placeholder="Deskripsi barang (opsional)"><?= isset($row->deskripsi) ? htmlspecialchars($row->deskripsi) : '' ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Letak Barang</label>
                                    <select name="id_lokasi" class="form-control">
                                        <option value="">-- Pilih Lokasi (Opsional) --</option>
                                        <?php foreach ($cachedLocations as $lokasi): ?>
                                            <option value="<?= $lokasi->id_lokasi ?>" <?= (isset($row->id_lokasi) && $row->id_lokasi == $lokasi->id_lokasi) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($lokasi->nama_lokasi) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ganti Gambar (PNG/JPG)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete Barang (Admin Only) -->
    <?php if ($this->session->userdata('role') == 'admin'): ?>
        <div class="modal fade" id="deleteModal<?= $row->id_barang ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Hapus Barang</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus barang <strong><?= $row->nama_barang ?></strong>?</p>
                        <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan!</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="<?= base_url('items/delete/' . $row->id_barang) ?>" method="POST" style="display:inline;">
                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
