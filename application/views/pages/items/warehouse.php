<style>
    /* Warehouse stock page */
    .wh-info-card {
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }

    .wh-info-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 20px 24px;
    }

    .wh-info-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .wh-icon {
        width: 44px;
        height: 44px;
        background: #eff6ff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .wh-name {
        font-size: 1rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0 0 2px;
    }

    .wh-address {
        font-size: 0.8rem;
        color: #94a3b8;
        margin: 0;
    }

    .wh-actions {
        display: flex;
        gap: 8px;
    }

    .btn-wh-back {
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

    .btn-wh-back:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .btn-wh-detail {
        height: 36px;
        padding: 0 14px;
        background: #eff6ff;
        color: #2563eb;
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

    .btn-wh-detail:hover {
        background: #dbeafe;
        color: #1d4ed8;
        text-decoration: none;
    }

    /* Filter bar */
    .wh-filter-card {
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }

    .wh-filter-body {
        padding: 14px 24px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .wh-filter-label {
        font-size: 0.78rem;
        font-weight: 500;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        white-space: nowrap;
        margin-right: 4px;
    }

    .wh-filter-chip {
        height: 32px;
        padding: 0 14px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
        cursor: pointer;
        transition: background 0.15s, color 0.15s;
    }

    .wh-filter-chip.all {
        background: #1e293b;
        color: #fff;
    }

    .wh-filter-chip.all:hover {
        background: #0f172a;
        color: #fff;
        text-decoration: none;
    }

    .wh-filter-chip.active {
        background: #2563eb;
        color: #fff;
    }

    .wh-filter-chip.active:hover {
        background: #1d4ed8;
        color: #fff;
        text-decoration: none;
    }

    .wh-filter-chip.inactive {
        background: #f1f5f9;
        color: #475569;
    }

    .wh-filter-chip.inactive:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    /* Stock item cards */
    .stock-item-card {
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        background: #fff;
        overflow: hidden;
        height: 100%;
    }

    .stock-item-header {
        padding: 14px 18px 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f8fafc;
    }

    .stock-item-name {
        font-weight: 500;
        color: #0f172a;
        font-size: 0.9rem;
        margin: 0;
    }

    .stock-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .stock-status-badge.tersedia {
        background: #dcfce7;
        color: #15803d;
    }

    .stock-status-badge.kosong {
        background: #fee2e2;
        color: #dc2626;
    }

    .stock-status-badge .dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .stock-status-badge.tersedia .dot { background: #16a34a; }
    .stock-status-badge.kosong .dot   { background: #dc2626; }

    .stock-item-body {
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stock-item-info {
        flex: 1;
    }

    .stock-qty-row {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-bottom: 4px;
    }

    .stock-qty-num {
        font-size: 1.6rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1;
    }

    .stock-qty-unit {
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 400;
    }

    .restock-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #fef9c3;
        color: #854d0e;
        font-size: 0.7rem;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 6px;
        margin-top: 4px;
    }

    .stock-min-text {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 4px;
    }

    .stock-item-image {
        width: 72px;
        height: 72px;
        object-fit: contain;
        border-radius: 8px;
        border: 1px solid #f1f5f9;
        background: #f8fafc;
        flex-shrink: 0;
    }

    .stock-item-actions {
        display: flex;
        gap: 8px;
        padding: 10px 18px 14px;
    }

    .btn-stock-in {
        flex: 1;
        height: 34px;
        background: #dcfce7;
        color: #15803d;
        border: none;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: background 0.15s;
    }

    .btn-stock-in:hover { background: #bbf7d0; }

    .btn-stock-out {
        flex: 1;
        height: 34px;
        background: #fee2e2;
        color: #dc2626;
        border: none;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: background 0.15s;
    }

    .btn-stock-out:hover:not([disabled]) { background: #fecaca; }
    .btn-stock-out[disabled] {
        opacity: 0.45;
        cursor: not-allowed;
    }

    /* Empty state */
    .wh-empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
        background: #fff;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }

    .wh-empty-state i {
        font-size: 2.5rem;
        margin-bottom: 12px;
        opacity: 0.4;
    }

    .wh-empty-state p { margin: 0; font-size: 0.875rem; }

</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <!-- Warehouse info header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card wh-info-card">
                <div class="wh-info-body">
                    <div class="wh-info-left">
                        <div class="wh-icon">
                            <i class="fas fa-warehouse"></i>
                        </div>
                        <div>
                            <h5 class="wh-name"><?= htmlspecialchars($selected_gudang->nama) ?></h5>
                            <p class="wh-address">
                                <i class="fas fa-map-marker-alt" style="margin-right:4px;"></i>
                                <?= $selected_gudang->alamat ?: 'Alamat tidak tersedia' ?>
                            </p>
                        </div>
                    </div>
                    <div class="wh-actions">
                        <a href="<?= base_url('items') ?>" class="btn-wh-back">
                            <i class="fas fa-arrow-left"></i> Semua Barang
                        </a>
                        <a href="<?= base_url('warehouse/detail/' . $selected_gudang->id) ?>" class="btn-wh-detail">
                            <i class="fas fa-info-circle"></i> Detail Gudang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Warehouse filter -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card wh-filter-card">
                <div class="wh-filter-body">
                    <span class="wh-filter-label">Filter Gudang</span>
                    <a href="<?= base_url('items') ?>" class="wh-filter-chip all">
                        Semua
                    </a>
                    <?php foreach (getWarehouses() as $gudang): ?>
                        <a href="<?= base_url('items/warehouse/' . $gudang->id) ?>"
                           class="wh-filter-chip <?= $gudang->id == $selected_gudang->id ? 'active' : 'inactive' ?>">
                            <i class="fas fa-warehouse" style="font-size:0.7rem;"></i>
                            <?= htmlspecialchars($gudang->nama) ?>
                        </a>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock cards grid -->
    <?php if (empty($content)): ?>
        <div class="wh-empty-state">
            <div><i class="fas fa-box-open"></i></div>
            <p>Tidak ada barang di gudang <strong><?= htmlspecialchars($selected_gudang->nama) ?></strong>.</p>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($content as $row):
                $defaultImg          = base_url('uploads/items/default.png');
                $imgPath             = !empty($row->image) ? $row->image : 'uploads/items/default.png';
                $normalizedLocalPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, FCPATH . $imgPath);
                $imgUrl              = (!empty($row->image) && file_exists($normalizedLocalPath))
                    ? base_url($imgPath)
                    : $defaultImg;
                $is_available = $row->qty > 0;
                $needs_restock = isset($row->stok_minimum) && $row->stok_minimum > 0 && $row->qty <= $row->stok_minimum;
            ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="stock-item-card">

                        <!-- Card header: name + status -->
                        <div class="stock-item-header">
                            <h6 class="stock-item-name"><?= htmlspecialchars($row->nama_barang) ?></h6>
                            <?php if ($is_available): ?>
                                <span class="stock-status-badge tersedia">
                                    <span class="dot"></span> Tersedia
                                </span>
                            <?php else: ?>
                                <span class="stock-status-badge kosong">
                                    <span class="dot"></span> Kosong
                                </span>
                            <?php endif ?>
                        </div>

                        <!-- Card body: qty + image -->
                        <div class="stock-item-body">
                            <div class="stock-item-info">
                                <div class="stock-qty-row">
                                    <span class="stock-qty-num"><?= number_format($row->qty) ?></span>
                                    <span class="stock-qty-unit"><?= htmlspecialchars($row->nama_satuan) ?></span>
                                </div>
                                <?php if ($needs_restock): ?>
                                    <div class="restock-badge">
                                        <i class="fas fa-exclamation-triangle" style="font-size:0.65rem;"></i>
                                        Perlu Restock
                                    </div>
                                <?php endif ?>
                                <?php if (isset($row->stok_minimum) && $row->stok_minimum > 0): ?>
                                    <p class="stock-min-text">Min. stok: <?= $row->stok_minimum ?></p>
                                <?php endif ?>
                            </div>
                            <img src="<?= $imgUrl ?>"
                                 alt="<?= htmlspecialchars($row->nama_barang) ?>"
                                 class="stock-item-image">
                        </div>

                        <!-- Action buttons (own warehouse only) -->
                        <?php if ($is_own_warehouse): ?>
                            <div class="stock-item-actions">
                                <button type="button" class="btn-stock-in"
                                    data-toggle="modal" data-target="#barangMasukModal<?= $row->id_barang ?>">
                                    <i class="fas fa-arrow-down"></i> Masuk
                                </button>
                                <button type="button" class="btn-stock-out"
                                    data-toggle="modal" data-target="#barangKeluarModal<?= $row->id_barang ?>"
                                    <?= !$is_available ? 'disabled' : '' ?>>
                                    <i class="fas fa-arrow-up"></i> Keluar
                                </button>
                            </div>
                        <?php endif ?>

                    </div>
                </div>

                <?php if ($is_own_warehouse): ?>
                <!-- Modal Barang Masuk -->
                <div class="modal fade" id="barangMasukModal<?= $row->id_barang ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title"><i class="fas fa-arrow-down mr-2"></i>Barang Masuk</h5>
                                <button type="button" class="close text-white" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('cartin/add') ?>" method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="id_barang" value="<?= $row->id_barang ?>">
                                    <input type="hidden" name="id_gudang" value="<?= $selected_gudang->id ?>">

                                    <div class="alert alert-info">
                                        <strong><?= htmlspecialchars($row->nama_barang) ?></strong><br>
                                        Masuk ke: <strong><?= htmlspecialchars($selected_gudang->nama) ?></strong><br>
                                        Stok saat ini di gudang ini: <?= $row->qty ?> <?= htmlspecialchars($row->nama_satuan) ?>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Jumlah Masuk</strong></label>
                                        <input type="number" name="qty_masuk" min="1" value="1" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Tambah ke Keranjang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Barang Keluar -->
                <div class="modal fade" id="barangKeluarModal<?= $row->id_barang ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title"><i class="fas fa-arrow-up mr-2"></i>Barang Keluar</h5>
                                <button type="button" class="close text-white" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('cartout/add') ?>" method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="id_barang" value="<?= $row->id_barang ?>">
                                    <input type="hidden" name="id_gudang" value="<?= $selected_gudang->id ?>">

                                    <div class="alert alert-warning">
                                        <strong><?= htmlspecialchars($row->nama_barang) ?></strong><br>
                                        Keluar dari: <strong><?= htmlspecialchars($selected_gudang->nama) ?></strong><br>
                                        Stok tersedia: <strong><?= $row->qty ?></strong> <?= htmlspecialchars($row->nama_satuan) ?>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Jumlah Keluar</strong></label>
                                        <input type="number" name="qty_keluar" min="1" max="<?= $row->qty ?>" value="1" class="form-control" required>
                                        <small class="text-muted">Maksimal: <?= $row->qty ?></small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-minus"></i> Tambah ke Keranjang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif ?>

            <?php endforeach ?>
        </div>
    <?php endif ?>

    <!-- Pagination -->
    <?php if (!empty($pagination)): ?>
        <div class="wms-pag-footer">
            <nav aria-label="Navigasi halaman"><?= $pagination ?></nav>
        </div>
    <?php endif ?>

</div>
