<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <!-- Info Gudang -->
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card border-info">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="text-info mb-1">
                                <i class="fas fa-warehouse mr-2"></i><?= $selected_gudang->nama ?>
                            </h4>
                            <p class="mb-0 text-muted">
                                <i class="fas fa-map-marker-alt mr-1"></i><?= $selected_gudang->alamat ?: 'Alamat tidak tersedia' ?>
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="<?= base_url('items') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Semua Barang
                            </a>
                            <a href="<?= base_url('warehouse/detail/' . $selected_gudang->id) ?>" class="btn btn-info">
                                <i class="fas fa-info-circle"></i> Detail Gudang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Gudang -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- Filter Gudang -->
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <h5 class="d-inline text-dark">Filter gudang → </h5>
                            <span>
                                <a href="<?= base_url('items') ?>" class="btn btn-rounded btn-dark mt-1 mb-1">Semua</a>
                                <?php foreach (getWarehouses() as $gudang) : ?>
                                    <a href="<?= base_url('items/warehouse/' . $gudang->id) ?>" 
                                       class="btn btn-rounded btn-<?= $gudang->id == $selected_gudang->id ? 'info' : 'outline-info' ?> mt-1 mb-1">
                                        <i class="fas fa-warehouse mr-1"></i><?= $gudang->nama ?>
                                    </a>
                                <?php endforeach ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- List Barang -->
    <div class="row">
        <?php if (empty($content)) : ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    Tidak ada barang di gudang <strong><?= $selected_gudang->nama ?></strong>
                </div>
            </div>
        <?php else : ?>
            <?php foreach ($content as $row) : ?>
                <?php
                    // Validasi gambar
                    $defaultImg = base_url('uploads/items/default.png');
                    $imgPath = !empty($row->image) ? $row->image : 'uploads/items/default.png';
                    $normalizedLocalPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, FCPATH . $imgPath);
                    $imgUrl = (!empty($row->image) && file_exists($normalizedLocalPath))
                        ? base_url($imgPath)
                        : $defaultImg;
                ?>

                <div class="col-md-6 col-lg-4">
                    <div class="card border-<?= $row->qty > 0 ? 'success' : 'danger' ?> mb-4 shadow-sm">

                        <!-- Header -->
                        <div class="card-header bg-<?= $row->qty > 0 ? 'success' : 'danger' ?> d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 text-white">
                                Stok <?= $row->qty > 0 ? 'Tersedia' : 'Kosong' ?>
                            </h4>
                        </div>

                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Kolom kiri: Detail barang -->
                                <div class="col-md-7">
                                    <h5 class="card-title text-dark mb-1"><?= $row->nama_barang ?></h5>
                                    <p class="card-text mb-1">
                                        <strong class="text-<?= $row->qty > 0 ? 'success' : 'danger' ?>">
                                            Stok: <?= $row->qty ?> <?= $row->nama_satuan ?>
                                        </strong>
                                    </p>
                                    <p class="card-text mb-1">Satuan: <?= $row->nama_satuan ?></p>
                                    <?php if ($row->stok_minimum > 0) : ?>
                                        <p class="card-text mb-1">
                                            <small class="text-muted">
                                                Min. Stok: <?= $row->stok_minimum ?>
                                                <?php if ($row->qty <= $row->stok_minimum) : ?>
                                                    <span class="badge badge-warning">Perlu Restock</span>
                                                <?php endif ?>
                                            </small>
                                        </p>
                                    <?php endif ?>

                                    <?php if ($is_own_warehouse): ?>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <!-- Tombol trigger modal barang masuk -->
                                            <button type="button" class="btn btn-success btn-sm btn-block" data-toggle="modal" data-target="#barangMasukModal<?= $row->id_barang ?>">
                                                <i class="fas fa-arrow-down"></i> Masuk
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Tombol trigger modal barang keluar -->
                                            <button type="button" class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#barangKeluarModal<?= $row->id_barang ?>" <?= $row->qty <= 0 ? 'disabled' : '' ?>>
                                                <i class="fas fa-arrow-up"></i> Keluar
                                            </button>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Kolom kanan: gambar -->
                                <div class="col-md-5 text-center">
                                    <img src="<?= $imgUrl ?>" 
                                         alt="<?= htmlspecialchars($row->nama_barang) ?>"
                                         class="img-fluid rounded shadow-sm border"
                                         style="max-height:100px; object-fit:contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($is_own_warehouse): ?>
                <!-- Modal Barang Masuk ke Gudang Ini -->
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
                                        <strong><?= $row->nama_barang ?></strong><br>
                                        Masuk ke: <strong><?= $selected_gudang->nama ?></strong><br>
                                        Stok saat ini di gudang ini: <?= $row->qty ?> <?= $row->nama_satuan ?>
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

                <!-- Modal Barang Keluar dari Gudang Ini -->
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
                                        <strong><?= $row->nama_barang ?></strong><br>
                                        Keluar dari: <strong><?= $selected_gudang->nama ?></strong><br>
                                        Stok tersedia: <strong><?= $row->qty ?></strong> <?= $row->nama_satuan ?>
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
                <?php endif; ?>

            <?php endforeach; ?>
        <?php endif ?>
    </div>

    <!-- Pagination -->
    <div class="row d-flex justify-content-center">
        <nav aria-label="Page navigation example">
            <?= $pagination ?>
        </nav>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
