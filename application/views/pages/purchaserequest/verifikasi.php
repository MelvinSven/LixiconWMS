<style>
    /* ── Verifikasi Barang ─────────────────────────────────────── */
    .verif-pr .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .verif-pr .header-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .verif-pr .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .verif-pr .kode-pill {
        font-size: 0.75rem;
        font-weight: 600;
        color: #2563eb;
        background: #eff6ff;
        padding: 3px 10px;
        border-radius: 6px;
        letter-spacing: 0.02em;
    }

    .verif-pr .btn-back {
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

    .verif-pr .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .verif-pr .detail-body { padding: 24px; }

    /* Info instruction box */
    .verif-info-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: #f0f9ff;
        border: 1.5px solid #bae6fd;
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 20px;
    }

    .verif-info-box .info-text {
        font-size: 0.84rem;
        color: #0c4a6e;
        margin: 0;
        line-height: 1.5;
    }

    /* Section card */
    .verif-section-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .verif-section-card .section-header {
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

    .verif-section-card .section-header.items { border-left: 3px solid #2563eb; }
    .verif-section-card .section-header.sj    { border-left: 3px solid #7c3aed; }

    .verif-section-card .section-header .header-count {
        margin-left: auto;
        font-size: 0.72rem;
        font-weight: 500;
        color: #94a3b8;
    }

    /* Table */
    .verif-table {
        width: 100%;
        border-collapse: collapse;
    }

    .verif-table thead th {
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

    .verif-table tbody tr { border-bottom: 1px solid #f8fafc; }
    .verif-table tbody tr:last-child { border-bottom: none; }

    .verif-table tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        font-size: 0.84rem;
        color: #374151;
    }

    .verif-table tbody tr.row-sesuai { background: #f0fdf4; }
    .verif-table tbody tr.row-sesuai td { color: #166534; }

    /* Checkbox */
    .check-cell { text-align: center; width: 44px; }
    .custom-check { width: 17px; height: 17px; cursor: pointer; accent-color: #16a34a; }

    /* Form controls in table */
    .verif-table .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.82rem;
        padding: 5px 10px;
        height: auto;
        transition: border-color 0.15s;
    }

    .verif-table .form-control:focus {
        border-color: #2563eb;
        box-shadow: none;
    }

    .verif-table .form-control:disabled,
    .verif-table .form-control[readonly] {
        background: #f1f5f9;
        color: #94a3b8;
        border-color: #f1f5f9;
    }

    /* Upload area */
    .upload-area { padding: 14px 16px; }

    .upload-label {
        font-size: 0.82rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
        display: block;
    }

    .upload-hint { font-size: 0.75rem; color: #94a3b8; font-weight: 400; }

    /* Empty state */
    .verif-empty {
        text-align: center;
        padding: 40px 24px;
        color: #94a3b8;
        font-size: 0.875rem;
    }

    .verif-empty i { font-size: 2rem; margin-bottom: 10px; display: block; }

    /* Action bar */
    .action-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        justify-content: space-between;
        align-items: center;
    }

    .btn-action {
        height: 38px;
        padding: 0 16px;
        border: none;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: background 0.15s, opacity 0.15s;
    }

    .btn-action:hover { text-decoration: none; opacity: 0.88; }
    .btn-action.back  { background: #f1f5f9; color: #475569; }
    .btn-action.save  { background: #16a34a; color: #fff; }

    @media (max-width: 767px) {
        .action-bar { flex-direction: column; }
        .verif-table .keterangan-col { display: none; }
    }
</style>

<?php
$pending      = array_filter($details, function ($d) {
    return (int) ($d->is_sesuai ?? -1) !== 1;
});
$pendingCount = count($pending);
?>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card verif-pr mt-4 mx-4"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- ── Header ─────────────────────────────────────── -->
                <div class="card-header-custom">
                    <div class="header-left">
                        <h5 class="page-title">Verifikasi Barang</h5>
                        <span class="kode-pill"><?= htmlspecialchars($pr->kode_pr) ?></span>
                    </div>
                    <a href="<?= base_url('purchaserequest/detail/' . $pr->id) ?>" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>

                <!-- ── Body ───────────────────────────────────────── -->
                <div class="detail-body">

                    <?php if (empty($pending)): ?>
                        <div class="verif-empty">
                            <i class="fas fa-check-circle" style="color:#16a34a;"></i>
                            Tidak ada barang yang perlu diverifikasi.
                        </div>
                    <?php else: ?>

                        <div class="verif-info-box">
                            <i class="fas fa-info-circle" style="color:#0284c7; margin-top:2px; flex-shrink:0;"></i>
                            <p class="info-text">
                                Centang barang yang <strong>diterima sesuai kuantitas</strong>. Jika tidak sesuai,
                                biarkan tidak dicentang lalu isi kuantitas yang diterima dan keterangan
                                ketidaksesuaian. Stok gudang akan langsung diperbarui berdasarkan kuantitas yang
                                diterima.
                            </p>
                        </div>

                        <form action="<?= base_url('purchaserequest/store_verifikasi/' . $pr->id) ?>"
                            method="POST" enctype="multipart/form-data" id="verifForm">

                            <!-- ── Daftar Barang ──────────────────────── -->
                            <div class="verif-section-card">
                                <div class="section-header items">
                                    <i class="fas fa-clipboard-check" style="color:#2563eb;"></i>
                                    Daftar Barang
                                    <span class="header-count"><?= $pendingCount ?> item perlu diverifikasi</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="verif-table" id="tblVerif">
                                        <thead>
                                            <tr>
                                                <th class="check-cell">
                                                    <input type="checkbox" class="custom-check" id="checkAll"
                                                        title="Semua Sesuai">
                                                </th>
                                                <th>Nama Barang</th>
                                                <th style="width:90px; text-align:center;">Qty Barang</th>
                                                <th style="width:140px;">Qty Diterima</th>
                                                <th class="keterangan-col" style="width:240px;">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($pending as $d): ?>
                                                <tr>
                                                    <td class="check-cell">
                                                        <input type="checkbox" class="custom-check sesuai-check"
                                                            name="barang_sesuai[]" value="<?= $d->id ?>"
                                                            data-qty="<?= (int) $d->qty ?>">
                                                    </td>
                                                    <td style="font-weight:500;"><?= htmlspecialchars($d->nama_barang) ?></td>
                                                    <td style="text-align:center; font-weight:600; color:#0f172a;"><?= (int) $d->qty ?></td>
                                                    <td>
                                                        <input type="number" class="form-control qty-diterima"
                                                            min="0" max="<?= (int) $d->qty ?>"
                                                            name="qty_diterima[<?= $d->id ?>]"
                                                            value="<?= $d->qty_diterima !== null ? (int) $d->qty_diterima : (int) $d->qty ?>">
                                                    </td>
                                                    <td class="keterangan-col">
                                                        <input type="text" class="form-control keterangan-input"
                                                            name="keterangan_verifikasi[<?= $d->id ?>]"
                                                            value="<?= htmlspecialchars($d->keterangan_verifikasi ?? '') ?>"
                                                            placeholder="Keterangan jika tidak sesuai...">
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- ── Surat Jalan ────────────────────────── -->
                            <div class="verif-section-card">
                                <div class="section-header sj">
                                    <i class="fas fa-file-pdf" style="color:#7c3aed;"></i>
                                    Surat Jalan
                                    <?php if (!empty($surat_jalan_list)): ?>
                                        <span class="header-count"><?= count($surat_jalan_list) ?> file</span>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($surat_jalan_list)): ?>
                                    <div class="table-responsive">
                                        <table class="verif-table">
                                            <thead>
                                                <tr>
                                                    <th style="width:44px;">#</th>
                                                    <th>Nama File</th>
                                                    <th style="width:180px;">Tanggal Upload</th>
                                                    <th style="width:80px; text-align:center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($surat_jalan_list as $i => $sj): ?>
                                                    <tr>
                                                        <td style="color:#94a3b8; font-size:0.8rem;"><?= $i + 1 ?></td>
                                                        <td>
                                                            <i class="fas fa-file-pdf" style="color:#7c3aed; margin-right:6px;"></i>
                                                            <?= htmlspecialchars($sj->nama_file) ?>
                                                        </td>
                                                        <td style="color:#64748b; font-size:0.82rem;">
                                                            <?= date('d F Y H:i', strtotime($sj->uploaded_at)) ?>
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <a href="<?= base_url($sj->file_path) ?>" target="_blank"
                                                                class="btn btn-sm btn-outline-secondary"
                                                                style="border-radius:6px;" title="Unduh">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="height:1px; background:#f1f5f9;"></div>
                                <?php endif; ?>

                                <div class="upload-area">
                                    <label for="file_surat_jalan" class="upload-label">
                                        Tambah Surat Jalan
                                        <span class="upload-hint">(opsional, PDF maks. 10 MB)</span>
                                    </label>
                                    <input type="file" name="file_surat_jalan" id="file_surat_jalan"
                                        class="form-control-file" accept="application/pdf,.pdf">
                                </div>
                            </div>

                            <!-- ── Action bar ─────────────────────────── -->
                            <div class="action-bar">
                                <a href="<?= base_url('purchaserequest/detail/' . $pr->id) ?>" class="btn-action back">
                                    <i class="fas fa-arrow-left"></i> Batal
                                </a>
                                <button type="submit" class="btn-action save">
                                    <i class="fas fa-check"></i> Simpan Verifikasi
                                </button>
                            </div>

                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tbl = document.getElementById('tblVerif');
        if (!tbl) return;
        const checkAll = document.getElementById('checkAll');

        function applyRow(tr) {
            const cb = tr.querySelector('.sesuai-check');
            const qtyInput = tr.querySelector('.qty-diterima');
            const ketInput = tr.querySelector('.keterangan-input');
            if (cb.checked) {
                qtyInput.value = cb.dataset.qty;
                qtyInput.readOnly = true;
                if (ketInput) { ketInput.value = ''; ketInput.disabled = true; }
                tr.classList.add('row-sesuai');
            } else {
                qtyInput.readOnly = false;
                if (ketInput) ketInput.disabled = false;
                tr.classList.remove('row-sesuai');
            }
        }

        tbl.querySelectorAll('tbody tr').forEach(function (tr) {
            const cb = tr.querySelector('.sesuai-check');
            cb.addEventListener('change', function () { applyRow(tr); syncCheckAll(); });
            applyRow(tr);
        });

        checkAll.addEventListener('change', function () {
            tbl.querySelectorAll('.sesuai-check').forEach(cb => {
                cb.checked = checkAll.checked;
                cb.dispatchEvent(new Event('change'));
            });
        });

        function syncCheckAll() {
            const all     = tbl.querySelectorAll('.sesuai-check');
            const checked = tbl.querySelectorAll('.sesuai-check:checked');
            checkAll.checked = all.length > 0 && all.length === checked.length;
        }

        document.getElementById('verifForm').addEventListener('submit', function (e) {
            if (!confirm('Konfirmasi verifikasi barang?')) e.preventDefault();
        });
    });
</script>
