<style>
    .register-card .card-header-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .register-card .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .register-card .form-label {
        font-size: 0.82rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
    }

    .register-card .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #0f172a;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .register-card .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: #fff;
        outline: none;
    }

    .register-card .form-control[readonly] {
        background: #f1f5f9;
        color: #64748b;
    }

    .register-card select.form-control {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
    }

    .register-card .section-divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 24px 0 20px;
    }

    .register-card .field-hint {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 4px;
    }

    .register-card .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding-top: 8px;
        border-top: 1px solid #f1f5f9;
        margin-top: 24px;
    }

    .register-card .btn-back {
        height: 38px;
        padding: 0 16px;
        background: #f1f5f9;
        color: #475569;
        border: none;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }

    .register-card .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .register-card .btn-reset-form {
        height: 38px;
        padding: 0 16px;
        background: #f8fafc;
        color: #475569;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s, border-color 0.15s;
    }

    .register-card .btn-reset-form:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .register-card .btn-submit {
        height: 38px;
        padding: 0 20px;
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }

    .register-card .btn-submit:hover {
        background: #1d4ed8;
    }

    .register-card .file-upload-area {
        border: 1.5px dashed #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .register-card .file-upload-area i {
        color: #94a3b8;
        font-size: 1.2rem;
    }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card register-card"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- Card header -->
                <div class="card-header-custom">
                    <h5 class="page-title">Register Barang Baru</h5>
                </div>

                <!-- Form body -->
                <div class="card-body" style="padding:24px;">
                    <form action="<?= base_url('items/store') ?>" method="POST" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control"
                                        placeholder="Masukkan nama barang" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Kuantitas Awal <span class="text-danger">*</span></label>
                                    <input type="number" name="qty" class="form-control" value="0" min="0"
                                        placeholder="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Satuan <span class="text-danger">*</span></label>
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
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Gudang Awal <span class="text-danger">*</span></label>
                                    <?php if ($user_gudang_id !== null): ?>
                                        <input type="hidden" name="id_gudang" value="<?= $user_gudang_id ?>">
                                        <input type="text" class="form-control"
                                            value="<?= htmlspecialchars(getWarehouseName($user_gudang_id)) ?>" readonly>
                                        <p class="field-hint">Barang akan disimpan di gudang Anda.</p>
                                    <?php else: ?>
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
                                        <p class="field-hint">Pilih gudang penyimpanan awal. Jika belum ada, tambahkan di <a href="<?= base_url('warehouses') ?>">List Gudang</a>.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Letak Barang</label>
                                    <select name="id_lokasi" class="form-control">
                                        <option value="">-- Pilih Lokasi (Opsional) --</option>
                                        <?php
                                        $locations = getLocations();
                                        if (!empty($locations)):
                                            foreach ($locations as $lokasi): ?>
                                                <option value="<?= $lokasi->id_lokasi ?>">
                                                    <?= htmlspecialchars($lokasi->nama_lokasi) ?>
                                                </option>
                                            <?php endforeach;
                                        else: ?>
                                            <option value="" disabled>Belum ada data lokasi</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="3"
                                        placeholder="Deskripsi barang (opsional)"></textarea>
                                </div>
                            </div>
                        </div>

                        <hr class="section-divider">

                        <div class="form-group">
                            <label class="form-label">Upload Gambar Barang</label>
                            <div class="file-upload-area">
                                <i class="fas fa-image"></i>
                                <div>
                                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg">
                                    <p class="field-hint mb-0">Format: JPG, JPEG, PNG. Maksimal 2MB. (Opsional)</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="<?= base_url('items') ?>" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="reset" class="btn-reset-form">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i> Simpan Barang
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
