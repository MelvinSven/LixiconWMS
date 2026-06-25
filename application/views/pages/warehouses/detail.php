<style>
    /* Warehouse header */
    .wh-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 20px 24px 18px;
        border-bottom: 1px solid #f1f5f9;
    }

    .wh-header-left { display: flex; align-items: center; gap: 14px; }

    .wh-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .wh-title { font-size: 1.05rem; font-weight: 600; color: #0f172a; margin: 0 0 4px; }
    .wh-addr { font-size: 0.8rem; color: #64748b; margin: 0; }

    .wh-back-btn {
        height: 36px;
        padding: 0 14px;
        background: #f1f5f9;
        color: #475569;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }

    .wh-back-btn:hover { background: #e2e8f0; color: #1e293b; text-decoration: none; }

    /* Stat cards */
    .stat-card {
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .stat-icon.blue  { background: #eff6ff; color: #2563eb; }
    .stat-icon.green { background: #f0fdf4; color: #16a34a; }

    .stat-label { font-size: 0.75rem; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 4px; }
    .stat-value { font-size: 1.5rem; font-weight: 700; color: #0f172a; margin: 0; }

    /* Stock table card */
    .stock-card {
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }

    .stock-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        padding: 18px 24px 14px;
        border-bottom: 1px solid #f1f5f9;
    }

    .stock-card-title { font-size: 0.9rem; font-weight: 500; color: #0f172a; margin: 0; }

    .stock-filter-form {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .stock-search-input {
        height: 34px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 0 10px 0 32px;
        font-size: 0.8rem;
        color: #0f172a;
        background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 9px center;
        min-width: 180px;
        transition: border-color 0.15s;
    }

    .stock-search-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        background-color: #fff;
    }

    .stock-filter-select {
        height: 34px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 0 28px 0 10px;
        font-size: 0.8rem;
        color: #0f172a;
        background: #f8fafc;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 8px center;
        cursor: pointer;
        transition: border-color 0.15s;
    }

    .stock-filter-select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    .btn-tambah-masuk {
        height: 34px;
        padding: 0 14px;
        background: #f0fdf4;
        color: #15803d;
        border: 1.5px solid #bbf7d0;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }

    .btn-tambah-masuk:hover { background: #dcfce7; }

    /* Stock table */
    .stock-table {
        width: 100%;
        border-collapse: collapse;
    }

    .stock-table thead th {
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

    .stock-table tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.1s;
    }

    .stock-table tbody tr:hover { background: #fafbfd; }
    .stock-table tbody tr:last-child { border-bottom: none; }

    .stock-table tbody td {
        padding: 13px 16px;
        vertical-align: middle;
        font-size: 0.85rem;
        color: #374151;
    }

    .stock-table tfoot td {
        padding: 12px 16px;
        font-size: 0.85rem;
        border-top: 2px solid #f1f5f9;
        background: #f8fafc;
        font-weight: 600;
        color: #0f172a;
    }

    /* Status badges */
    .stok-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.73rem;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .stok-badge .dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

    .stok-badge.tersedia { background: #dcfce7; color: #15803d; }
    .stok-badge.tersedia .dot { background: #16a34a; }

    .stok-badge.rendah { background: #fef9c3; color: #854d0e; }
    .stok-badge.rendah .dot { background: #ca8a04; }

    .stok-badge.habis { background: #fee2e2; color: #dc2626; }
    .stok-badge.habis .dot { background: #dc2626; }

    /* Update button */
    .btn-update-stok {
        height: 30px;
        padding: 0 12px;
        background: #eff6ff;
        color: #2563eb;
        border: none;
        border-radius: 7px;
        font-size: 0.77rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: background 0.15s;
    }

    .btn-update-stok:hover { background: #dbeafe; }

    /* Empty state */
    .stock-empty {
        text-align: center;
        padding: 50px 20px;
        color: #94a3b8;
    }

    .stock-empty i { font-size: 2rem; margin-bottom: 10px; opacity: 0.4; }
    .stock-empty p { margin: 0; font-size: 0.875rem; }

    .row-num { color: #94a3b8; font-size: 0.8rem; }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <!-- Warehouse Header Card -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card" style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">
                <div class="wh-header">
                    <div class="wh-header-left">
                        <div class="wh-icon">
                            <i class="fas fa-warehouse"></i>
                        </div>
                        <div>
                            <p class="wh-title"><?= htmlspecialchars($warehouse->nama) ?></p>
                            <?php if ($warehouse->alamat): ?>
                                <p class="wh-addr">
                                    <i class="fas fa-map-marker-alt" style="color:#f87171; margin-right:4px;"></i>
                                    <?= htmlspecialchars($warehouse->alamat) ?>
                                </p>
                            <?php else: ?>
                                <p class="wh-addr" style="color:#cbd5e1;">Alamat belum diset</p>
                            <?php endif ?>
                        </div>
                    </div>
                    <a href="<?= base_url('warehouses') ?>" class="wh-back-btn">
                        <i class="fas fa-arrow-left" style="font-size:0.75rem;"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row mb-3">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-boxes"></i>
                </div>
                <div>
                    <p class="stat-label">Jenis Barang</p>
                    <p class="stat-value"><?= number_format($total_jenis) ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-cubes"></i>
                </div>
                <div>
                    <p class="stat-label">Total Kuantitas</p>
                    <p class="stat-value"><?= number_format($total_qty) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Table -->
    <?php
    // Update Stok (koreksi stok gudang sendiri): admin + staff gudang ini. Purchasing hanya melihat.
    $can_update_stock = $can_modify && $this->session->userdata('role') != 'purchasing_admin';
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card stock-card">
                <div class="stock-card-header">
                    <h5 class="stock-card-title">Stok Barang di Gudang Ini</h5>
                    <div class="d-flex align-items-center" style="gap:8px; flex-wrap:wrap;">
                        <?php if (!empty($stocks)): ?>
                            <div class="stock-filter-form">
                                <input type="text" id="filterNama" class="stock-search-input"
                                    placeholder="Cari nama barang...">
                                <select id="filterStatus" class="stock-filter-select">
                                    <option value="">Semua Status</option>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Stok Rendah">Stok Rendah</option>
                                    <option value="Habis">Habis</option>
                                </select>
                            </div>
                        <?php endif ?>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                            <button class="btn-tambah-masuk" data-toggle="modal" data-target="#tambahBarangModal">
                                <i class="fas fa-plus" style="font-size:0.75rem;"></i> Tambah Barang Masuk
                            </button>
                        <?php endif ?>
                    </div>
                </div>

                <?php if (empty($stocks)): ?>
                    <div class="stock-empty">
                        <div><i class="fas fa-box-open"></i></div>
                        <p>Belum ada barang di gudang ini.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="stock-table" id="stokTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Satuan</th>
                                    <th class="text-center">Stok</th>
                                    <th class="text-center">Status</th>
                                    <?php if ($can_update_stock): ?>
                                        <th class="text-center">Aksi</th>
                                    <?php endif ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($stocks as $stock):
                                    if ($stock->qty <= 0) {
                                        $status = 'Habis'; $cls = 'habis';
                                    } elseif ($stock->qty <= $stock->stok_minimum) {
                                        $status = 'Stok Rendah'; $cls = 'rendah';
                                    } else {
                                        $status = 'Tersedia'; $cls = 'tersedia';
                                    }
                                ?>
                                    <tr data-nama="<?= strtolower($stock->nama_barang) ?>" data-status="<?= $status ?>">
                                        <td class="row-num"><?= $no++ ?></td>
                                        <td style="font-weight:500; color:#0f172a;"><?= htmlspecialchars($stock->nama_barang) ?></td>
                                        <td>
                                            <span style="background:#f1f5f9; color:#475569; font-size:0.72rem; font-weight:500; padding:3px 8px; border-radius:6px;">
                                                <?= ucfirst($stock->nama_satuan) ?>
                                            </span>
                                        </td>
                                        <td class="text-center" style="font-weight:700; color:#0f172a;">
                                            <?= number_format($stock->qty) ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="stok-badge <?= $cls ?>">
                                                <span class="dot"></span> <?= $status ?>
                                            </span>
                                        </td>
                                        <?php if ($can_update_stock): ?>
                                            <td class="text-center">
                                                <button class="btn-update-stok" data-toggle="modal"
                                                    data-target="#updateStokModal<?= $stock->id_barang ?>">
                                                    <i class="fas fa-edit"></i> Update
                                                </button>
                                            </td>
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align:right; color:#64748b; font-weight:500;">Total Keseluruhan</td>
                                    <td class="text-center"><?= number_format($total_qty) ?></td>
                                    <td colspan="<?= $can_update_stock ? 2 : 1 ?>"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->userdata('role') == 'admin'): ?>
    <!-- Modal Tambah Barang Masuk -->
    <div class="modal fade" id="tambahBarangModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius:12px; border:none; box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:20px 24px 16px;">
                    <h5 class="modal-title" style="font-size:0.95rem; font-weight:600; color:#0f172a;">
                        <i class="fas fa-plus mr-2" style="color:#16a34a;"></i>Tambah Barang Masuk — <?= htmlspecialchars($warehouse->nama) ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" style="color:#94a3b8;">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('cartin/add') ?>" method="POST">
                    <div class="modal-body" style="padding:20px 24px;">
                        <input type="hidden" name="id_gudang" value="<?= $warehouse->id ?>">
                        <input type="hidden" name="redirect_to" value="<?= base_url('warehouse/detail/' . $warehouse->id) ?>">
                        <div class="form-group">
                            <label style="font-size:0.82rem; font-weight:500; color:#374151;">Pilih Barang</label>
                            <select name="id_barang" class="form-control"
                                style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.85rem;" required>
                                <option value="">-- Pilih Barang --</option>
                                <?php foreach ($all_items as $item): ?>
                                    <option value="<?= $item->id ?>"><?= htmlspecialchars($item->nama) ?> (<?= $item->nama_satuan ?>)</option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label style="font-size:0.82rem; font-weight:500; color:#374151;">Jumlah Masuk</label>
                            <input type="number" name="qty_masuk" min="1" value="1" class="form-control"
                                style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.85rem;" required>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:16px 24px;">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                            style="border-radius:8px;">Batal</button>
                        <button type="submit" class="btn btn-success btn-sm" style="border-radius:8px;">
                            <i class="fas fa-plus mr-1"></i> Tambah ke Keranjang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if ($can_update_stock): ?>
    <?php foreach ($stocks as $stock): ?>
        <div class="modal fade" id="updateStokModal<?= $stock->id_barang ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:12px; border:none; box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                    <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:20px 24px 16px;">
                        <h5 class="modal-title" style="font-size:0.95rem; font-weight:600; color:#0f172a;">Update Stok</h5>
                        <button type="button" class="close" data-dismiss="modal" style="color:#94a3b8;">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('warehouse/update_stock') ?>" method="POST">
                        <div class="modal-body" style="padding:20px 24px;">
                            <input type="hidden" name="id_barang" value="<?= $stock->id_barang ?>">
                            <input type="hidden" name="id_gudang" value="<?= $warehouse->id ?>">

                            <div style="background:#f8fafc; border:1px solid #f1f5f9; border-radius:8px; padding:12px 14px; margin-bottom:16px;">
                                <div style="font-size:0.85rem; font-weight:600; color:#0f172a;"><?= htmlspecialchars($stock->nama_barang) ?></div>
                                <div style="font-size:0.78rem; color:#64748b; margin-top:3px;">
                                    <?= htmlspecialchars($warehouse->nama) ?> &bull;
                                    Stok saat ini: <strong><?= number_format($stock->qty) ?></strong> <?= $stock->nama_satuan ?>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <label style="font-size:0.82rem; font-weight:500; color:#374151;">Stok Baru</label>
                                <input type="number" name="qty" min="0" value="<?= $stock->qty ?>" class="form-control"
                                    style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.85rem;" required>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:16px 24px;">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                                style="border-radius:8px;">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm"
                                style="border-radius:8px; background:#2563eb; border:none;">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>

<script>
(function () {
    var filterNama   = document.getElementById('filterNama');
    var filterStatus = document.getElementById('filterStatus');
    if (!filterNama || !filterStatus) return;

    function applyFilter() {
        var nama   = filterNama.value.toLowerCase();
        var status = filterStatus.value;
        document.querySelectorAll('#stokTable tbody tr').forEach(function (row) {
            var matchNama   = !nama   || row.dataset.nama.indexOf(nama) !== -1;
            var matchStatus = !status || row.dataset.status === status;
            row.style.display = (matchNama && matchStatus) ? '' : 'none';
        });
    }

    filterNama.addEventListener('input', applyFilter);
    filterStatus.addEventListener('change', applyFilter);
})();
</script>
