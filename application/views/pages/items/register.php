<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Register Barang Baru</h4>

            <form action="<?= base_url('items/store') ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" name="kode_barang" class="form-control"
                                placeholder="Masukkan kode barang" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama barang"
                                required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kuantitas Awal <span class="text-danger">*</span></label>
                            <input type="number" name="qty" class="form-control" value="0" min="0" placeholder="0"
                                required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Satuan <span class="text-danger">*</span></label>
                            <select name="id_satuan" class="form-control" required>
                                <option value="">-- Pilih Satuan --</option>
                                <?php
                                $units = getUnits();
                                if (!empty($units)):
                                    foreach ($units as $unit): ?>
                                        <option value="<?= $unit->id ?>"><?= ucfirst($unit->nama) ?></option>
                                    <?php endforeach;
                                else: ?>
                                    <option value="" disabled>Belum ada data satuan</option>
                                <?php endif; ?>
                            </select>
                            <small class="text-muted">Jika satuan belum ada, tambahkan di menu <a
                                    href="<?= base_url('unit') ?>">Tambah Satuan</a></small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gudang Awal <span class="text-danger">*</span></label>
                            <select name="id_gudang" class="form-control" required>
                                <option value="">-- Pilih Gudang --</option>
                                <?php
                                $warehouses = getWarehouses();
                                if (!empty($warehouses)):
                                    foreach ($warehouses as $gudang): ?>
                                        <option value="<?= $gudang->id ?>"><?= $gudang->nama ?></option>
                                    <?php endforeach;
                                else: ?>
                                    <option value="" disabled>Belum ada data gudang</option>
                                <?php endif; ?>
                            </select>
                            <small class="text-muted">Pilih gudang tempat barang ini akan disimpan pertama kali. Jika
                                gudang belum ada, tambahkan di menu <a href="<?= base_url('warehouses') ?>">List
                                    Gudang</a></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Supplier</label>
                            <select name="id_supplier" class="form-control">
                                <option value="">-- Pilih Supplier (Opsional) --</option>
                                <?php
                                $suppliers = getSuppliers();
                                if (!empty($suppliers)):
                                    foreach ($suppliers as $supplier): ?>
                                        <option value="<?= $supplier->id_supplier ?>"><?= $supplier->nama ?></option>
                                    <?php endforeach;
                                else: ?>
                                    <option value="" disabled>Belum ada data supplier</option>
                                <?php endif; ?>
                            </select>
                            <small class="text-muted">Jika supplier belum ada, tambahkan di menu <a
                                    href="<?= base_url('suppliers') ?>">List Supplier</a></small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Letak Barang</label>
                            <select name="id_lokasi" class="form-control">
                                <option value="">-- Pilih Lokasi (Opsional) --</option>
                                <?php
                                $locations = getLocations();
                                if (!empty($locations)):
                                    foreach ($locations as $lokasi): ?>
                                        <option value="<?= $lokasi->id_lokasi ?>"><?= htmlspecialchars($lokasi->nama_lokasi) ?>
                                        </option>
                                    <?php endforeach;
                                else: ?>
                                    <option value="" disabled>Belum ada data lokasi</option>
                                <?php endif; ?>
                            </select>
                            <small class="text-muted">Jika lokasi belum ada, tambahkan di menu <a
                                    href="<?= base_url('locations') ?>">List Letak Barang</a></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"
                                placeholder="Deskripsi barang (opsional)"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Upload Gambar Barang</label>
                    <input type="file" name="image" class="form-control-file" accept="image/jpeg,image/png,image/jpg">
                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB. (Opsional)</small>
                </div>

                <hr>

                <div class="form-group text-right">
                    <a href="<?= base_url('items') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="reset" class="btn btn-dark">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>