<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <!-- Info Gudang -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white mb-0">
                        <i class="fas fa-warehouse mr-2"></i>
                        <?= $warehouse->nama ?>
                    </h4>
                </div>
                <div class="card-body">
                    <p><strong><i class="fas fa-map-marker-alt text-danger mr-2"></i>Alamat:</strong><br>
                        <?= $warehouse->alamat ?: 'Tidak tersedia' ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Jenis Barang</h5>
                            <h2><?= $total_jenis ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-boxes fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Total Kuantitas</h5>
                            <h2><?= number_format($total_qty) ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-cubes fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Tambah Barang ke Gudang -->
    <?php if ($can_modify): ?>
    <div class="row mb-3">
        <div class="col-lg-12">
            <button class="btn btn-success" data-toggle="modal" data-target="#tambahBarangModal">
                <i class="fas fa-plus"></i> Tambah Barang Masuk
            </button>
        </div>
    </div>
    <?php endif ?>

    <!-- List Stok Barang -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list mr-2"></i>Daftar Stok Barang di Gudang Ini
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($stocks)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Belum ada barang di gudang ini
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Satuan</th>
                                        <th class="text-center">Stok</th>
                                        <th class="text-center">Stok Min</th>
                                        <!-- <th class="text-right">Harga</th> -->
                                        <!-- <th class="text-right">Nilai</th> -->
                                        <th class="text-center">Status</th>
                                        <?php if ($can_modify): ?>
                                        <th class="text-center">Aksi</th>
                                        <?php endif ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($stocks as $stock): ?>
                                        <?php
                                        $status = 'Tersedia';
                                        $badge = 'success';
                                        if ($stock->qty <= 0) {
                                            $status = 'Habis';
                                            $badge = 'danger';
                                        } elseif ($stock->qty <= $stock->stok_minimum) {
                                            $status = 'Stok Rendah';
                                            $badge = 'warning';
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $stock->nama_barang ?></td>
                                            <td><?= $stock->nama_satuan ?></td>
                                            <td class="text-center"><strong><?= number_format($stock->qty) ?></strong></td>
                                            <td class="text-center"><?= number_format($stock->stok_minimum) ?></td>


                                            <td class="text-center">
                                                <span class="badge badge-<?= $badge ?>"><?= $status ?></span>
                                            </td>
                                            <?php if ($can_modify): ?>
                                            <td class="text-center">
                                                <button class="btn btn-success btn-sm rounded-lg" data-toggle="modal"
                                                    data-target="#barangMasukModal<?= $stock->id_barang ?>">
                                                    <i class="fas fa-arrow-down"></i> Masuk
                                                </button>
                                                <button class="btn btn-danger btn-sm rounded-lg" data-toggle="modal"
                                                    data-target="#barangKeluarModal<?= $stock->id_barang ?>" <?= $stock->qty <= 0 ? 'disabled' : '' ?>>
                                                    <i class="fas fa-arrow-up"></i> Keluar
                                                </button>
                                            </td>
                                            <?php endif ?>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <th colspan="3" class="text-right">Total:</th>
                                        <th class="text-center"><?= number_format($total_qty) ?></th>
                                        <th colspan="<?= $can_modify ? 3 : 2 ?>"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif ?>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('warehouses') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($can_modify): ?>
<!-- Modal Tambah Barang Masuk (Barang baru ke gudang ini) -->
<div class="modal fade" id="tambahBarangModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-plus mr-2"></i>Tambah Barang Masuk ke <?= $warehouse->nama ?>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="<?= base_url('cartin/add') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_gudang" value="<?= $warehouse->id ?>">
                    <input type="hidden" name="redirect_to"
                        value="<?= base_url('warehouse/detail/' . $warehouse->id) ?>">

                    <div class="form-group">
                        <label><strong>Pilih Barang</strong></label>
                        <select name="id_barang" class="form-control" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php foreach ($all_items as $item): ?>
                                <option value="<?= $item->id ?>"><?= $item->nama . ' (' . $item->nama_satuan . ')' ?></option>
                            <?php endforeach ?>
                        </select>
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

<?php foreach ($stocks as $stock): ?>
    <!-- Modal Barang Masuk -->
    <div class="modal fade" id="barangMasukModal<?= $stock->id_barang ?>" tabindex="-1" role="dialog">
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
                        <input type="hidden" name="id_barang" value="<?= $stock->id_barang ?>">
                        <input type="hidden" name="id_gudang" value="<?= $warehouse->id ?>">
                        <input type="hidden" name="redirect_to"
                            value="<?= base_url('warehouse/detail/' . $warehouse->id) ?>">

                        <div class="alert alert-info">
                            <strong><?= $stock->nama_barang ?></strong><br>
                            Gudang: <?= $warehouse->nama ?><br>
                            Stok saat ini: <?= $stock->qty ?>     <?= $stock->nama_satuan ?>
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
    <div class="modal fade" id="barangKeluarModal<?= $stock->id_barang ?>" tabindex="-1" role="dialog">
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
                        <input type="hidden" name="id_barang" value="<?= $stock->id_barang ?>">
                        <input type="hidden" name="id_gudang" value="<?= $warehouse->id ?>">
                        <input type="hidden" name="redirect_to"
                            value="<?= base_url('warehouse/detail/' . $warehouse->id) ?>">

                        <div class="alert alert-info">
                            <strong><?= $stock->nama_barang ?></strong><br>
                            Gudang: <?= $warehouse->nama ?><br>
                            Stok tersedia: <strong><?= $stock->qty ?></strong> <?= $stock->nama_satuan ?>
                        </div>

                        <div class="form-group">
                            <label><strong>Jumlah Keluar</strong></label>
                            <input type="number" name="qty_keluar" min="1" max="<?= $stock->qty ?>" value="1"
                                class="form-control" required>
                            <small class="text-muted">Maksimal: <?= $stock->qty ?></small>
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
<?php endforeach ?>
<?php endif ?>