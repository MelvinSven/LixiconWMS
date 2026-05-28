<style>
    /* ── Buat Surat Jalan ──────────────────────────────────────── */
    .surat-jalan-form .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .surat-jalan-form .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .surat-jalan-form .btn-back {
        height: 36px;
        padding: 0 14px;
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

    .surat-jalan-form .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .surat-jalan-form .form-body {
        padding: 24px;
    }

    .surat-jalan-form .section-label {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #94a3b8;
        margin-bottom: 12px;
        margin-top: 0;
    }

    .surat-jalan-form .field-label {
        font-size: 0.82rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
        display: block;
    }

    .surat-jalan-form .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #0f172a;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .surat-jalan-form .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: #fff;
        outline: none;
    }

    .surat-jalan-form .section-divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 24px 0;
    }

    /* Warehouse route */
    .wh-route {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 12px;
        align-items: center;
    }

    .wh-box {
        border-radius: 10px;
        padding: 16px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
    }

    .wh-box.source { border-top: 3px solid #2563eb; }
    .wh-box.dest   { border-top: 3px solid #16a34a; }

    .wh-box .wh-label {
        font-size: 0.68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 8px;
        margin-top: 0;
    }

    .wh-box.source .wh-label { color: #2563eb; }
    .wh-box.dest   .wh-label { color: #16a34a; }

    .wh-box .wh-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0 0 2px;
    }

    .wh-box.source .wh-name { color: #1d4ed8; }
    .wh-box.dest   .wh-name { color: #15803d; }

    .wh-box .wh-sub {
        font-size: 0.72rem;
        color: #94a3b8;
        margin: 0;
    }

    .wh-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
    }

    /* Items table */
    .items-section {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .items-section .items-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.82rem;
        font-weight: 600;
        color: #374151;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .items-table thead th {
        font-size: 0.7rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #94a3b8;
        padding: 10px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .items-table tbody tr {
        border-bottom: 1px solid #f8fafc;
    }

    .items-table tbody tr:last-child { border-bottom: none; }

    .items-table tbody td {
        padding: 12px 14px;
        vertical-align: middle;
        font-size: 0.84rem;
        color: #374151;
    }

    .row-num {
        color: #94a3b8;
        font-size: 0.8rem;
    }

    .qty-field {
        border: 1.5px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.82rem;
        padding: 5px 8px;
        width: 90px;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
        color: #0f172a;
    }

    .qty-field:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        background: #fff;
        outline: none;
    }

    .note-field {
        border: 1.5px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.82rem;
        padding: 5px 10px;
        width: 100%;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
        color: #0f172a;
    }

    .note-field:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        background: #fff;
        outline: none;
    }

    /* Photo upload */
    .upload-zone {
        border: 2px dashed #e2e8f0;
        border-radius: 10px;
        padding: 20px;
        background: #f8fafc;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s;
        position: relative;
    }

    .upload-zone:hover,
    .upload-zone.dragover {
        border-color: #93c5fd;
        background: #eff6ff;
    }

    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .upload-zone .upload-icon {
        font-size: 1.5rem;
        color: #cbd5e1;
        margin-bottom: 8px;
    }

    .upload-zone .upload-text {
        font-size: 0.82rem;
        color: #64748b;
        margin: 0;
    }

    .upload-zone .upload-hint {
        font-size: 0.72rem;
        color: #94a3b8;
        margin: 4px 0 0;
    }

    .upload-preview {
        display: none;
        margin-top: 12px;
        position: relative;
    }

    .upload-preview img {
        max-height: 140px;
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        object-fit: cover;
    }

    .upload-preview .btn-remove-photo {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #ef4444;
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 0.65rem;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    /* Form actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        margin-top: 24px;
    }

    .btn-submit {
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

    .btn-submit:hover { background: #1d4ed8; }

    @media (max-width: 767px) {
        .wh-route {
            grid-template-columns: 1fr;
        }

        .wh-arrow {
            transform: rotate(90deg);
        }
    }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card surat-jalan-form"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- Header -->
                <div class="card-header-custom">
                    <div>
                        <h5 class="page-title">Buat Surat Jalan</h5>
                        <p style="font-size:0.75rem; color:#94a3b8; margin:2px 0 0;"><?= htmlspecialchars($permintaan->kode_permintaan) ?></p>
                    </div>
                    <a href="<?= base_url('preorder/detail/' . $permintaan->id) ?>" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <!-- Form body -->
                <div class="form-body">
                    <form action="<?= base_url('preorder/store_surat_jalan/' . $permintaan->id) ?>"
                        method="POST" enctype="multipart/form-data" id="formSuratJalan">

                        <!-- Delivery info -->
                        <p class="section-label">Info Pengiriman</p>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="field-label">
                                        Nomor Pengiriman <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nomor_pengiriman" class="form-control"
                                        placeholder="Contoh: SJ/2025/001" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="field-label">
                                        Tanggal Pengiriman <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal_pengiriman" class="form-control"
                                        value="<?= date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="field-label">
                                        Foto Surat Jalan
                                        <span style="color:#94a3b8; font-weight:400;">(Opsional)</span>
                                    </label>
                                    <div class="upload-zone" id="uploadZone">
                                        <input type="file" name="foto_surat_jalan" id="fotoInput"
                                            accept="image/jpeg,image/png">
                                        <div class="upload-icon"><i class="fas fa-camera"></i></div>
                                        <p class="upload-text">Klik atau seret foto ke sini</p>
                                        <p class="upload-hint">JPG, PNG &middot; Maks 2 MB</p>
                                    </div>
                                    <div class="upload-preview" id="uploadPreview">
                                        <img id="previewImg" src="" alt="Preview">
                                        <button type="button" class="btn-remove-photo" id="btnRemovePhoto"
                                            title="Hapus foto">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="section-divider">

                        <!-- Warehouse route -->
                        <p class="section-label">Rute Pengiriman</p>
                        <div class="wh-route mb-4">

                            <div class="wh-box source">
                                <p class="wh-label">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Gudang Sumber
                                </p>
                                <p class="wh-name"><?= htmlspecialchars($permintaan->nama_gudang_asal) ?></p>
                                <p class="wh-sub">Gudang pengirim barang</p>
                            </div>

                            <div class="wh-arrow">
                                <i class="fas fa-arrow-right" style="font-size:1.1rem;"></i>
                            </div>

                            <div class="wh-box dest">
                                <p class="wh-label">
                                    <i class="fas fa-sign-in-alt mr-1"></i> Gudang Tujuan
                                </p>
                                <p class="wh-name"><?= htmlspecialchars($permintaan->nama_gudang_tujuan) ?></p>
                                <p class="wh-sub">Gudang penerima barang</p>
                            </div>
                        </div>

                        <hr class="section-divider">

                        <!-- Items -->
                        <p class="section-label">Daftar Barang</p>
                        <div class="items-section">
                            <div class="items-header">
                                <i class="fas fa-boxes" style="color:#94a3b8;"></i>
                                <?= count($details) ?> Barang &middot; Sesuai Permintaan
                            </div>
                            <div style="overflow-x:auto;">
                                <table class="items-table">
                                    <thead>
                                        <tr>
                                            <th style="width:44px;">No</th>
                                            <th>Nama Barang</th>
                                            <th style="width:110px;">Satuan</th>
                                            <th style="width:120px;" class="text-center">Qty Dikirim</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($details as $item): ?>
                                        <tr>
                                            <td class="row-num"><?= $no++ ?></td>
                                            <td>
                                                <span style="font-weight:500;"><?= htmlspecialchars($item->nama_barang ?? '-') ?></span>
                                                <input type="hidden" name="id_barang[]" value="<?= $item->id_barang ?>">
                                            </td>
                                            <td style="color:#64748b;"><?= htmlspecialchars($item->nama_satuan ?? '-') ?></td>
                                            <td class="text-center">
                                                <input type="number" name="qty[]" class="qty-field"
                                                    value="<?= (int)$item->qty ?>" min="1" required>
                                            </td>
                                            <td>
                                                <input type="text" name="keterangan_barang[]" class="note-field"
                                                    value="<?= htmlspecialchars($item->keterangan ?? '') ?>"
                                                    placeholder="Keterangan...">
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="form-actions">
                            <a href="<?= base_url('preorder/detail/' . $permintaan->id) ?>" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Buat Surat Jalan
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fotoInput  = document.getElementById('fotoInput');
    const uploadZone = document.getElementById('uploadZone');
    const preview    = document.getElementById('uploadPreview');
    const previewImg = document.getElementById('previewImg');
    const btnRemove  = document.getElementById('btnRemovePhoto');

    fotoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file tidak boleh melebihi 2 MB.');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            preview.style.display = 'inline-block';
            uploadZone.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    btnRemove.addEventListener('click', function () {
        fotoInput.value = '';
        previewImg.src = '';
        preview.style.display = 'none';
        uploadZone.style.display = 'block';
    });

    ['dragover', 'dragleave', 'drop'].forEach(function (evt) {
        uploadZone.addEventListener(evt, function (e) {
            e.preventDefault();
            uploadZone.classList.toggle('dragover', evt === 'dragover');
        });
    });

    document.getElementById('formSuratJalan').addEventListener('submit', function (e) {
        const rows = document.querySelectorAll('.qty-field');
        let hasError = false;
        rows.forEach(function (input) {
            const val = parseInt(input.value) || 0;
            if (val < 1) {
                hasError = true;
                input.style.borderColor = '#ef4444';
            } else {
                input.style.borderColor = '';
            }
        });
        if (hasError) {
            e.preventDefault();
            alert('Qty harus minimal 1 untuk semua barang.');
        }
    });
});
</script>
