<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <!-- List Barang Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white mb-0"><i class="fas fa-boxes mr-2"></i>Daftar Barang</h4>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form action="<?= base_url('items/search') ?>" method="POST" class="mb-4">
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label><strong>Nama Barang</strong></label>
                                <input type="text" name="nama_barang" class="form-control"
                                    placeholder="Cari nama barang..."
                                    value="<?= isset($search_params['nama_barang']) ? $search_params['nama_barang'] : '' ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label><strong>Letak Barang</strong></label>
                                <select name="lokasi" class="form-control">
                                    <option value="">-- Semua Lokasi --</option>
                                    <?php foreach (getLocations() as $lokasi): ?>
                                        <option value="<?= $lokasi->id_lokasi ?>" <?= (isset($search_params['lokasi']) && $search_params['lokasi'] == $lokasi->id_lokasi) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($lokasi->nama_lokasi) ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label><strong>Deskripsi</strong></label>
                                <input type="text" name="deskripsi" class="form-control" placeholder="Cari deskripsi..."
                                    value="<?= isset($search_params['deskripsi']) ? $search_params['deskripsi'] : '' ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>
                                        Cari</button>
                                    <a href="<?= base_url('items') ?>" class="btn btn-secondary"><i
                                            class="fas fa-times"></i> Reset</a>
                                </div>
                            </div>
                        </div>


                    </form>
                    <!-- End Search Form -->

                    <?php if (empty($content)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>Tidak ada data barang
                        </div>
                        <a href="<?= base_url('items') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i>
                            Kembali</a>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Nama Barang</th>
                                        <th width="15%">Deskripsi</th>
                                        <th width="8%" class="text-center">Kuantitas</th>
                                        <th width="7%" class="text-center">Satuan</th>
                                        <th width="8%" class="text-center">Status</th>
                                        <th width="12%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = isset($start) ? $start + 1 : 1;
                                    foreach ($content as $row): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><strong><?= $row->nama_barang ?></strong></td>
                                            <td><?= isset($row->deskripsi) && $row->deskripsi ? htmlspecialchars($row->deskripsi) : '<span class="text-muted">-</span>' ?>
                                            </td>
                                            <td class="text-center"><?= number_format($row->qty) ?></td>
                                            <td class="text-center"><?= ucfirst($row->nama_satuan) ?></td>
                                            <td class="text-center">
                                                <?php if ($row->qty > 0): ?>
                                                    <span class="badge badge-success">Tersedia</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Kosong</span>
                                                <?php endif ?>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-secondary btn-sm rounded-lg"
                                                    data-toggle="modal" data-target="#imageModal<?= $row->id_barang ?>"
                                                    title="Lihat Gambar">
                                                    <i class="fas fa-image"></i>
                                                </button>
                                                <button type="button" class="btn btn-info btn-sm rounded-lg" data-toggle="modal"
                                                    data-target="#stokGudangModal<?= $row->id_barang ?>">
                                                    <i class="fas fa-warehouse"></i>
                                                </button>
                                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                                    <button class="btn btn-warning btn-sm rounded-lg" data-toggle="modal"
                                                        data-target="#editModal<?= $row->id_barang ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                <?php endif ?>
                                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                                    <button class="btn btn-danger btn-sm rounded-lg" data-toggle="modal"
                                                        data-target="#deleteModal<?= $row->id_barang ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                <?php endif; ?>
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

<!-- Modals -->
<?php
// Cache data untuk menghindari query berulang dalam loop
$cachedUnits = getUnits();
$cachedLocations = getLocations();
?>
<?php foreach ($content as $row): ?>
    <?php
    // Validasi gambar untuk modal edit
    $defaultImg = base_url('uploads/items/default.png');
    $imgPath = !empty($row->image) ? $row->image : 'uploads/items/default.png';
    $normalizedLocalPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, FCPATH . $imgPath);
    $imgUrl = (!empty($row->image) && file_exists($normalizedLocalPath))
        ? base_url($imgPath)
        : $defaultImg;
    ?>

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
                    <h5 class="modal-title"><i class="fas fa-warehouse mr-2"></i>Stok <?= $row->nama_barang ?> per Gudang
                    </h5>
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
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->