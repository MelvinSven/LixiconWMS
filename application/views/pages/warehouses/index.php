<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <!-- List Gudang Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                    <h4 class="text-white mb-0"><i class="fas fa-warehouse mr-2"></i>Daftar Gudang</h4>
                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Gudang
                        </button>
                    <?php endif ?>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form action="<?= base_url('warehouses/search') ?>" method="POST" class="mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="input-group">
                                    <input type="text" name="keyword" class="form-control"
                                        placeholder="Cari nama gudang atau alamat..."
                                        value="<?= $this->session->userdata('keyword') ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="<?= base_url('warehouses') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                    <!-- End Search Form -->

                    <?php if (empty($content)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>Tidak ada data gudang
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Nama Gudang</th>
                                        <th width="35%">Alamat</th>
                                        <th width="15%" class="text-center">Jumlah Barang</th>
                                        <th width="20%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = isset($start) ? $start + 1 : 1;
                                    foreach ($content as $row):
                                        // Hitung jumlah jenis barang di gudang ini
                                        $jumlah_barang = $this->db->where('id_gudang', $row->id)->count_all_results('stok_gudang');
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><i class="fas fa-warehouse text-primary mr-1"></i>
                                                    <?= $row->nama ?></strong>
                                            </td>
                                            <td>
                                                <?php if ($row->alamat): ?>
                                                    <i class="fas fa-map-marker-alt text-danger mr-1"></i>  <?= $row->alamat ?>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-info"><?= $jumlah_barang ?> item</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('warehouse/detail/' . $row->id) ?>"
                                                    class="btn btn-info btn-sm rounded-lg" title="Lihat Stok">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                                    <button class="btn btn-warning btn-sm rounded-lg" data-toggle="modal"
                                                        data-target="#editModal<?= $row->id ?>" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm rounded-lg" data-toggle="modal"
                                                        data-target="#deleteModal<?= $row->id ?>" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif ?>
                </div>

                <!-- Pagination -->
                <?php if (!empty($pagination)): ?>
                    <div class="card-footer">
                        <nav aria-label="Page navigation">
                            <?= $pagination ?>
                        </nav>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<!-- Modals for Edit & Delete -->
<?php if (!empty($content)): ?>
    <?php foreach ($content as $row): ?>
        <!-- Modal Edit -->
        <div class="modal fade" id="editModal<?= $row->id ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-white">Edit Gudang</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('warehouse/update') ?>" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?= $row->id ?>">
                            <div class="form-group">
                                <label>Nama Gudang</label>
                                <input type="text" name="nama" class="form-control" value="<?= $row->nama ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3"><?= $row->alamat ?></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div class="modal fade" id="deleteModal<?= $row->id ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">Hapus Gudang</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus gudang <strong><?= $row->nama ?></strong>?</p>
                        <p class="text-danger"><small>Gudang dengan stok barang tidak dapat dihapus.</small></p>
                    </div>
                    <div class="modal-footer">
                        <form action="<?= base_url('warehouse/delete') ?>" method="POST">
                            <input type="hidden" name="id" value="<?= $row->id ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>

<!-- Modal Tambah Gudang -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah Gudang Baru</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="<?= base_url('warehouse/add') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Gudang</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Gudang Utama" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3"
                            placeholder="Alamat lengkap gudang"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>