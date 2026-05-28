<style>
    /* === Verifikasi Penerimaan Barang === */

    /* ── Card wrapper ─────────────────── */
    .vf-card {
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        background: #fff;
        overflow: hidden;
    }

    /* ── Card header ──────────────────── */
    .vf-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .vf-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .vf-page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .vf-kode-pill {
        font-size: 0.75rem;
        font-weight: 600;
        color: #2563eb;
        background: #eff6ff;
        padding: 3px 10px;
        border-radius: 6px;
        letter-spacing: 0.02em;
        font-family: monospace;
    }

    .vf-btn-back {
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
        white-space: nowrap;
        flex-shrink: 0;
    }

    .vf-btn-back:hover { background: #e2e8f0; color: #1e293b; text-decoration: none; }

    /* ── Card body ────────────────────── */
    .vf-card-body { padding: 20px 24px; }

    /* ── Info strip ───────────────────── */
    .vf-info {
        display: flex;
        flex-wrap: wrap;
        gap: 0;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .vf-info-item {
        flex: 1;
        min-width: 140px;
        padding: 12px 16px;
        border-right: 1px solid #f1f5f9;
    }

    .vf-info-item:last-child { border-right: none; }

    .vf-info-label {
        font-size: 0.63rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: #94a3b8;
        margin: 0 0 4px;
    }

    .vf-info-val {
        font-size: 0.875rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }

    .vf-info-item.blue .vf-info-val  { color: #2563eb; }
    .vf-info-item.green .vf-info-val { color: #16a34a; }

    /* ── Progress ─────────────────────── */
    .vf-progress {
        margin-bottom: 16px;
    }

    .vf-progress-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 10px;
    }

    .vf-progress-label {
        font-size: 0.82rem;
        font-weight: 500;
        color: #374151;
        margin: 0;
    }

    .vf-progress-label span { color: #94a3b8; }

    .vf-stat-row { display: flex; gap: 6px; flex-wrap: wrap; }

    .vf-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .vf-chip .cdot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

    .vf-chip.pending { background: #f1f5f9; color: #64748b; }
    .vf-chip.pending .cdot { background: #94a3b8; }
    .vf-chip.ok      { background: #dcfce7; color: #15803d; }
    .vf-chip.ok .cdot { background: #16a34a; }
    .vf-chip.nok     { background: #fee2e2; color: #b91c1c; }
    .vf-chip.nok .cdot { background: #dc2626; }

    .vf-bar-track {
        height: 5px;
        background: #f1f5f9;
        border-radius: 99px;
        overflow: hidden;
        display: flex;
    }

    .vf-bar-ok  { height: 100%; background: #22c55e; transition: width 0.25s; }
    .vf-bar-nok { height: 100%; background: #f87171; transition: width 0.25s; }

    /* ── Instruction ──────────────────── */
    .vf-instr {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        border-left: 3px solid #2563eb;
        background: #eff6ff;
        padding: 10px 14px;
        border-radius: 0 8px 8px 0;
        margin-bottom: 20px;
    }

    .vf-instr-icon { color: #2563eb; font-size: 0.875rem; margin-top: 1px; flex-shrink: 0; }

    .vf-instr-steps { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 3px; }

    .vf-instr-steps li {
        font-size: 0.79rem;
        color: #1e40af;
        display: flex;
        align-items: flex-start;
        gap: 6px;
        line-height: 1.45;
    }

    .vf-instr-steps .sn {
        font-size: 0.63rem;
        font-weight: 700;
        background: #bfdbfe;
        color: #1d4ed8;
        border-radius: 50%;
        width: 15px; height: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* ── List toolbar ─────────────────── */
    .vf-list-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 0;
    }

    .vf-list-count {
        font-size: 0.82rem;
        font-weight: 500;
        color: #374151;
    }

    .vf-bulk-actions { display: flex; gap: 6px; }

    .vf-btn-bulk {
        height: 32px;
        padding: 0 12px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: 1.5px solid;
        background: transparent;
        transition: background 0.15s;
    }

    .vf-btn-bulk.all-ok    { color: #15803d; border-color: #bbf7d0; }
    .vf-btn-bulk.all-ok:hover { background: #f0fdf4; }
    .vf-btn-bulk.all-reset { color: #475569; border-color: #e2e8f0; }
    .vf-btn-bulk.all-reset:hover { background: #f8fafc; }

    /* ── Table ────────────────────────── */
    .vf-table {
        width: 100%;
        border-collapse: collapse;
    }

    .vf-table thead th {
        font-size: 0.72rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #94a3b8;
        padding: 10px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .vf-table thead th.center { text-align: center; }

    .vf-table tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.1s, box-shadow 0.2s;
    }

    .vf-table tbody tr:last-child { border-bottom: none; }
    .vf-table tbody tr:hover { background: #fafbfd; }

    .vf-table tbody tr.state-ok  { background: #f0fdf4; box-shadow: inset 3px 0 0 #22c55e; }
    .vf-table tbody tr.state-nok { background: #fef2f2; box-shadow: inset 3px 0 0 #f87171; }
    .vf-table tbody tr.state-ok:hover  { background: #e7faf0; }
    .vf-table tbody tr.state-nok:hover { background: #fdeaea; }

    .vf-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 0.85rem;
        color: #374151;
    }

    .vf-row-num { color: #94a3b8; font-size: 0.8rem; }

    .vf-row-name {
        font-size: 0.875rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0 0 2px;
    }

    .vf-row-unit {
        font-size: 0.75rem;
        color: #94a3b8;
        margin: 0;
    }

    .vf-row-qty {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        text-align: center;
    }

    .vf-row-status { text-align: center; }

    /* Status badges matching pr-badge pattern */
    .vf-spill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .vf-spill .sdot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

    .vf-spill.ok      { background: #dcfce7; color: #15803d; }
    .vf-spill.ok .sdot { background: #16a34a; }
    .vf-spill.nok     { background: #fee2e2; color: #b91c1c; }
    .vf-spill.nok .sdot { background: #dc2626; }
    .vf-spill.pending { background: #f1f5f9; color: #64748b; }
    .vf-spill.pending .sdot { background: #94a3b8; }

    /* ── Toggle ───────────────────────── */
    .vf-toggle-wrap { display: flex; justify-content: center; }

    .vf-toggle {
        position: relative;
        width: 40px;
        height: 22px;
        cursor: pointer;
    }

    .vf-toggle input { opacity: 0; width: 0; height: 0; position: absolute; }

    .vf-toggle-track {
        position: absolute;
        inset: 0;
        background: #e2e8f0;
        border-radius: 11px;
        transition: background 0.2s;
    }

    .vf-toggle-track::after {
        content: '';
        position: absolute;
        left: 3px; top: 3px;
        width: 16px; height: 16px;
        background: #fff;
        border-radius: 50%;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .vf-toggle input:checked + .vf-toggle-track { background: #22c55e; }
    .vf-toggle input:checked + .vf-toggle-track::after { transform: translateX(18px); }

    /* ── Mismatch row ─────────────────── */
    .vf-mismatch-row { display: none; }
    .vf-mismatch-row.visible { display: table-row; }

    .vf-mismatch-cell {
        padding: 0 16px 14px 48px !important;
        background: #fef2f2;
    }

    .vf-mismatch-inner {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        animation: vfSlide 0.16s ease-out;
    }

    @keyframes vfSlide {
        from { opacity: 0; transform: translateY(-4px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .vf-field { display: flex; flex-direction: column; gap: 4px; }

    .vf-field-label {
        font-size: 0.63rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
    }

    .vf-qty-input {
        border: 1.5px solid #fca5a5;
        border-radius: 8px;
        font-size: 0.84rem;
        padding: 6px 10px;
        width: 90px;
        text-align: center;
        background: #fff;
        color: #0f172a;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .vf-qty-input:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
        outline: none;
    }

    .vf-note-input {
        border: 1.5px solid #fca5a5;
        border-radius: 8px;
        font-size: 0.84rem;
        padding: 6px 12px;
        width: 280px;
        max-width: 100%;
        background: #fff;
        color: #0f172a;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .vf-note-input:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
        outline: none;
    }

    .vf-note-input.required-err { border-color: #dc2626; background: #fff1f2; }

    /* ── Card footer (sticky) ─────────── */
    .vf-card-footer {
        position: sticky;
        bottom: 0;
        background: #fff;
        border-top: 1px solid #f0f0f0;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        z-index: 10;
        border-radius: 0 0 12px 12px;
    }

    .vf-footer-status {
        font-size: 0.82rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .vf-footer-status strong { color: #0f172a; }

    .vf-footer-actions { display: flex; gap: 8px; }

    .vf-btn-cancel {
        height: 36px;
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
        cursor: pointer;
        transition: background 0.15s;
    }

    .vf-btn-cancel:hover { background: #e2e8f0; color: #1e293b; text-decoration: none; }

    .vf-btn-submit {
        height: 36px;
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
        transition: background 0.15s, opacity 0.15s;
    }

    .vf-btn-submit:hover { background: #1d4ed8; }
    .vf-btn-submit:disabled { opacity: 0.5; cursor: not-allowed; }

    /* ── Responsive ───────────────────── */
    @media (max-width: 767px) {
        .vf-card-body { padding: 16px; }
        .vf-card-header { padding: 16px 16px 12px; }
        .vf-card-footer { padding: 12px 16px; }

        .vf-info-item { min-width: 120px; padding: 10px 12px; }

        .vf-table thead th:nth-child(4) { display: none; }
        .vf-table tbody td:nth-child(4) { display: none; }

        .vf-mismatch-cell { padding-left: 16px !important; }
        .vf-note-input { width: 100%; }
    }

    @media (max-width: 575px) {
        .vf-info { flex-direction: column; }
        .vf-info-item { border-right: none; border-bottom: 1px solid #f1f5f9; }
        .vf-info-item:last-child { border-bottom: none; }
        .vf-stat-row { gap: 4px; }
    }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="vf-card">

                <!-- Card Header -->
                <div class="vf-card-header">
                    <div class="vf-header-left">
                        <h5 class="vf-page-title">Verifikasi Penerimaan Barang</h5>
                        <span class="vf-kode-pill"><?= htmlspecialchars($permintaan->kode_permintaan) ?></span>
                    </div>
                    <a href="<?= base_url('preorder/detail/' . $permintaan->id) ?>" class="vf-btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <!-- Card Body -->
                <div class="vf-card-body">

                    <!-- Info Strip -->
                    <div class="vf-info">
                        <div class="vf-info-item">
                            <p class="vf-info-label">No. Surat Jalan</p>
                            <p class="vf-info-val"><?= htmlspecialchars($surat_jalan->nomor_pengiriman) ?></p>
                        </div>
                        <div class="vf-info-item">
                            <p class="vf-info-label">Tanggal Pengiriman</p>
                            <p class="vf-info-val"><?= date('d M Y', strtotime($surat_jalan->tanggal_pengiriman)) ?></p>
                        </div>
                        <div class="vf-info-item blue">
                            <p class="vf-info-label">Gudang Sumber</p>
                            <p class="vf-info-val"><?= htmlspecialchars($permintaan->nama_gudang_asal) ?></p>
                        </div>
                        <div class="vf-info-item green">
                            <p class="vf-info-label">Gudang Tujuan</p>
                            <p class="vf-info-val"><?= htmlspecialchars($permintaan->nama_gudang_tujuan) ?></p>
                        </div>
                    </div>

                    <!-- Progress -->
                    <div class="vf-progress">
                        <div class="vf-progress-top">
                            <p class="vf-progress-label">
                                Progress &mdash; <span id="progText">0 / <?= count($details) ?> diverifikasi</span>
                            </p>
                            <div class="vf-stat-row">
                                <span class="vf-chip pending">
                                    <span class="cdot"></span>
                                    <span id="countPending"><?= count($details) ?></span> Belum
                                </span>
                                <span class="vf-chip ok">
                                    <span class="cdot"></span>
                                    <span id="countOk">0</span> Sesuai
                                </span>
                                <span class="vf-chip nok">
                                    <span class="cdot"></span>
                                    <span id="countNok">0</span> Tidak Sesuai
                                </span>
                            </div>
                        </div>
                        <div class="vf-bar-track">
                            <div class="vf-bar-ok"  id="barOk"  style="width:0%"></div>
                            <div class="vf-bar-nok" id="barNok" style="width:0%"></div>
                        </div>
                    </div>

                    <!-- Instruction -->
                    <div class="vf-instr">
                        <i class="fas fa-info-circle vf-instr-icon"></i>
                        <ul class="vf-instr-steps">
                            <li>
                                <span class="sn">1</span>
                                <span>Aktifkan toggle <strong>Sesuai</strong> untuk barang yang diterima sesuai surat jalan.</span>
                            </li>
                            <li>
                                <span class="sn">2</span>
                                <span>Untuk barang <strong>tidak sesuai</strong>, matikan toggle lalu isi <strong>Qty Diterima</strong> dan <strong>Keterangan</strong>.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Form -->
                    <form action="<?= base_url('preorder/store_verifikasi/' . $permintaan->id) ?>"
                          method="POST" id="formVerifikasi">

                        <!-- List toolbar -->
                        <div class="vf-list-head">
                            <span class="vf-list-count">
                                <i class="fas fa-boxes" style="color:#94a3b8; margin-right:5px;"></i><?= count($details) ?> Barang
                            </span>
                            <div class="vf-bulk-actions">
                                <button type="button" class="vf-btn-bulk all-ok" id="btnCheckAll">
                                    <i class="fas fa-check-double"></i> Semua Sesuai
                                </button>
                                <button type="button" class="vf-btn-bulk all-reset" id="btnUncheckAll">
                                    <i class="fas fa-redo-alt"></i> Reset
                                </button>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="vf-table">
                                <thead>
                                    <tr>
                                        <th style="width:44px;">No</th>
                                        <th>Barang</th>
                                        <th class="center" style="width:80px;">Qty</th>
                                        <th class="center" style="width:120px;">Status</th>
                                        <th class="center" style="width:60px;">Cek</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($details as $item): ?>

                                    <tr class="vf-item-row" id="row-<?= $item->id_barang ?>" data-id="<?= $item->id_barang ?>">
                                        <td class="vf-row-num text-center"><?= $no++ ?></td>

                                        <td>
                                            <p class="vf-row-name"><?= htmlspecialchars($item->nama_barang ?? '-') ?></p>
                                            <p class="vf-row-unit"><?= htmlspecialchars($item->nama_satuan ?? '-') ?></p>
                                        </td>

                                        <td class="vf-row-qty"><?= number_format($item->qty) ?></td>

                                        <td class="vf-row-status text-center">
                                            <span class="vf-spill pending status-pill-display">
                                                <span class="sdot"></span> Belum
                                            </span>
                                        </td>

                                        <td class="vf-toggle-wrap">
                                            <label class="vf-toggle" title="Tandai sesuai">
                                                <input type="checkbox"
                                                       name="barang_sesuai[]"
                                                       value="<?= $item->id_barang ?>"
                                                       class="toggle-sesuai"
                                                       data-id="<?= $item->id_barang ?>"
                                                       data-qty="<?= (int)$item->qty ?>">
                                                <span class="vf-toggle-track"></span>
                                            </label>
                                        </td>
                                    </tr>

                                    <!-- Mismatch row -->
                                    <tr class="vf-mismatch-row" id="mismatch-<?= $item->id_barang ?>">
                                        <td colspan="5" class="vf-mismatch-cell">
                                            <div class="vf-mismatch-inner">
                                                <div class="vf-field">
                                                    <span class="vf-field-label">Qty Diterima</span>
                                                    <input type="number"
                                                           name="qty_diterima[<?= $item->id_barang ?>]"
                                                           class="vf-qty-input qty-recv-input"
                                                           value="0"
                                                           min="0"
                                                           max="<?= (int)$item->qty ?>"
                                                           placeholder="0"
                                                           disabled>
                                                </div>
                                                <div class="vf-field" style="flex:1;">
                                                    <span class="vf-field-label">Keterangan <span style="color:#ef4444;">*</span></span>
                                                    <input type="text"
                                                           name="keterangan_verifikasi[<?= $item->id_barang ?>]"
                                                           class="vf-note-input note-input"
                                                           placeholder="Jelaskan ketidaksesuaian..."
                                                           disabled>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </form>

                </div><!-- /.vf-card-body -->

                <!-- Sticky Footer -->
                <div class="vf-card-footer">
                    <div class="vf-footer-status">
                        <i class="fas fa-clipboard-list" style="color:#94a3b8;"></i>
                        <span><strong id="footerVerified">0</strong> / <?= count($details) ?> barang diverifikasi</span>
                    </div>
                    <div class="vf-footer-actions">
                        <a href="<?= base_url('preorder/detail/' . $permintaan->id) ?>" class="vf-btn-cancel">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" form="formVerifikasi" class="vf-btn-submit" id="btnSubmit">
                            <i class="fas fa-clipboard-check"></i> Simpan Verifikasi
                        </button>
                    </div>
                </div>

            </div><!-- /.vf-card -->
        </div>
    </div>
</div>

<script>
(function () {
    const TOTAL = <?= count($details) ?>;
    let stateMap = {};

    document.querySelectorAll('.toggle-sesuai').forEach(function (cb) {
        stateMap[cb.dataset.id] = 'pending';
    });

    function updateProgress() {
        let ok = 0, nok = 0, pending = 0;
        Object.values(stateMap).forEach(function (s) {
            if (s === 'ok') ok++;
            else if (s === 'nok') nok++;
            else pending++;
        });

        const verified = ok + nok;
        document.getElementById('countPending').textContent   = pending;
        document.getElementById('countOk').textContent        = ok;
        document.getElementById('countNok').textContent       = nok;
        document.getElementById('progText').textContent       = verified + ' / ' + TOTAL + ' diverifikasi';
        document.getElementById('footerVerified').textContent = verified;

        const denom  = TOTAL || 1;
        const okPct  = (ok  / denom * 100).toFixed(1);
        const nokPct = (nok / denom * 100).toFixed(1);
        document.getElementById('barOk').style.width  = okPct  + '%';
        document.getElementById('barNok').style.width = nokPct + '%';
    }

    function applyState(cb) {
        const id        = cb.dataset.id;
        const row       = document.getElementById('row-' + id);
        const panel     = document.getElementById('mismatch-' + id);
        const pill      = row.querySelector('.status-pill-display');
        const noteInput = panel.querySelector('.note-input');
        const qtyInput  = panel.querySelector('.qty-recv-input');

        if (cb.checked) {
            stateMap[id] = 'ok';
            row.className = 'vf-item-row state-ok';
            pill.className = 'vf-spill ok status-pill-display';
            pill.innerHTML = '<span class="sdot"></span> Sesuai';

            panel.classList.remove('visible');
            qtyInput.disabled = true;
            noteInput.disabled = true;
            noteInput.value = '';
            noteInput.classList.remove('required-err');
            qtyInput.value = qtyInput.max;
        } else {
            stateMap[id] = 'nok';
            row.className = 'vf-item-row state-nok';
            pill.className = 'vf-spill nok status-pill-display';
            pill.innerHTML = '<span class="sdot"></span> Tidak Sesuai';

            panel.classList.add('visible');
            qtyInput.disabled = false;
            noteInput.disabled = false;
            qtyInput.value = 0;
            setTimeout(function () { qtyInput.focus(); }, 50);
        }

        updateProgress();
    }

    document.querySelectorAll('.toggle-sesuai').forEach(function (cb) {
        cb.addEventListener('change', function () { applyState(this); });
    });

    document.getElementById('btnCheckAll').addEventListener('click', function () {
        document.querySelectorAll('.toggle-sesuai').forEach(function (cb) {
            cb.checked = true;
            applyState(cb);
        });
    });

    document.getElementById('btnUncheckAll').addEventListener('click', function () {
        document.querySelectorAll('.toggle-sesuai').forEach(function (cb) {
            cb.checked = false;
            const id        = cb.dataset.id;
            const row       = document.getElementById('row-' + id);
            const panel     = document.getElementById('mismatch-' + id);
            const pill      = row.querySelector('.status-pill-display');
            const noteInput = panel.querySelector('.note-input');
            const qtyInput  = panel.querySelector('.qty-recv-input');

            stateMap[id] = 'pending';
            row.className = 'vf-item-row';
            pill.className = 'vf-spill pending status-pill-display';
            pill.innerHTML = '<span class="sdot"></span> Belum';

            panel.classList.remove('visible');
            qtyInput.disabled = true;
            noteInput.disabled = true;
            noteInput.value = '';
            noteInput.classList.remove('required-err');
            qtyInput.value = 0;
        });
        updateProgress();
    });

    document.getElementById('formVerifikasi').addEventListener('submit', function (e) {
        const pendingItems = Object.values(stateMap).filter(function (s) { return s === 'pending'; });
        let hasNoteErr = false;

        document.querySelectorAll('.toggle-sesuai').forEach(function (cb) {
            if (!cb.checked) {
                const panel = document.getElementById('mismatch-' + cb.dataset.id);
                const note  = panel.querySelector('.note-input');
                if (!note.value.trim()) {
                    note.classList.add('required-err');
                    hasNoteErr = true;
                } else {
                    note.classList.remove('required-err');
                }
            }
        });

        if (pendingItems.length > 0 || hasNoteErr) {
            e.preventDefault();

            let msg = '';
            if (pendingItems.length > 0) msg += pendingItems.length + ' barang belum diverifikasi. ';
            if (hasNoteErr)              msg += 'Isi keterangan untuk setiap barang yang tidak sesuai.';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Verifikasi Belum Lengkap',
                    text: msg.trim(),
                    confirmButtonColor: '#2563eb',
                    confirmButtonText: 'OK'
                });
            } else {
                alert(msg.trim());
            }
            return false;
        }
    });
})();
</script>
