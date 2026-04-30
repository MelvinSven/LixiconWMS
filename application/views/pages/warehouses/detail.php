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
                        <!-- Filter -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" id="filterNama" class="form-control" placeholder="Cari nama barang...">
                            </div>
                            <div class="col-md-3">
                                <select id="filterStatus" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Stok Rendah">Stok Rendah</option>
                                    <option value="Habis">Habis</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="stokTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Satuan</th>
                                        <th class="text-center">Stok</th>
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
                                        <tr data-nama="<?= strtolower($stock->nama_barang) ?>" data-status="<?= $status ?>">
                                            <td><?= $no++ ?></td>
                                            <td><?= $stock->nama_barang ?></td>
                                            <td><?= $stock->nama_satuan ?></td>
                                            <td class="text-center"><strong><?= number_format($stock->qty) ?></strong></td>
                                            <td class="text-center">
                                                <span class="badge badge-<?= $badge ?>"><?= $status ?></span>
                                            </td>
                                            <?php if ($can_modify): ?>
                                                <td class="text-center">
                                                    <button class="btn btn-primary btn-sm rounded-lg" data-toggle="modal"
                                                        data-target="#updateStokModal<?= $stock->id_barang ?>">
                                                        <i class="fas fa-edit"></i> Update
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
                                        <th colspan="<?= $can_modify ? 2 : 1 ?>"></th>
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
                                    <option value="<?= $item->id ?>"><?= $item->nama . ' (' . $item->nama_satuan . ')' ?>
                                    </option>
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
        <!-- Modal Update Stok -->
        <div class="modal fade" id="updateStokModal<?= $stock->id_barang ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Update Stok Barang</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('warehouse/update_stock') ?>" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id_barang" value="<?= $stock->id_barang ?>">
                            <input type="hidden" name="id_gudang" value="<?= $warehouse->id ?>">

                            <div class="alert alert-info">
                                <strong><?= $stock->nama_barang ?></strong><br>
                                Gudang: <?= $warehouse->nama ?><br>
                                Stok saat ini: <strong><?= number_format($stock->qty) ?></strong> <?= $stock->nama_satuan ?>
                            </div>

                            <div class="form-group">
                                <label><strong>Stok Baru</strong></label>
                                <input type="number" name="qty" min="0" value="<?= $stock->qty ?>" class="form-control"
                                    required>
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
    <?php endforeach ?>
<?php endif ?>

<script>
    (function () {
        var filterNama = document.getElementById('filterNama');
        var filterStatus = document.getElementById('filterStatus');
        if (!filterNama || !filterStatus) return;

        function applyFilter() {
            var nama = filterNama.value.toLowerCase();
            var status = filterStatus.value;
            var rows = document.querySelectorAll('#stokTable tbody tr');
            rows.forEach(function (row) {
                var matchNama = !nama || row.dataset.nama.indexOf(nama) !== -1;
                var matchStatus = !status || row.dataset.status === status;
                row.style.display = (matchNama && matchStatus) ? '' : 'none';
            });
        }

        filterNama.addEventListener('input', applyFilter);
        filterStatus.addEventListener('change', applyFilter);
    })();
</script>