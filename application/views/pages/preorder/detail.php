<style>
    /* ── Detail Permintaan Barang ─────────────────────────────── */
    .detail-preorder .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-preorder .header-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .detail-preorder .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .detail-preorder .kode-pill {
        font-size: 0.75rem;
        font-weight: 600;
        color: #2563eb;
        background: #eff6ff;
        padding: 3px 10px;
        border-radius: 6px;
        letter-spacing: 0.02em;
    }

    .detail-preorder .btn-back {
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

    .detail-preorder .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .detail-preorder .detail-body {
        padding: 24px;
    }

    /* Status badge — reuse pr-badge pattern */
    .pr-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .pr-badge .dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

    .pr-badge.menunggu      { background: #fef9c3; color: #854d0e; }
    .pr-badge.menunggu .dot { background: #ca8a04; }

    .pr-badge.disetujui      { background: #e0f2fe; color: #0369a1; }
    .pr-badge.disetujui .dot { background: #0284c7; }

    .pr-badge.surat_jalan      { background: #eff6ff; color: #2563eb; }
    .pr-badge.surat_jalan .dot { background: #2563eb; }

    .pr-badge.dikirim      { background: #fff7ed; color: #ea580c; }
    .pr-badge.dikirim .dot { background: #ea580c; }

    .pr-badge.selesai      { background: #dcfce7; color: #15803d; }
    .pr-badge.selesai .dot { background: #16a34a; }

    .pr-badge.belum_selesai      { background: #f1f5f9; color: #475569; }
    .pr-badge.belum_selesai .dot { background: #64748b; }

    .pr-badge.ditolak      { background: #fee2e2; color: #dc2626; }
    .pr-badge.ditolak .dot { background: #dc2626; }

    /* Meta info row */
    .meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        padding: 16px 20px;
        background: #f8fafc;
        border-radius: 10px;
        border: 1.5px solid #f1f5f9;
        margin-bottom: 20px;
    }

    .meta-item .meta-label {
        font-size: 0.68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #94a3b8;
        margin-bottom: 4px;
    }

    .meta-item .meta-value {
        font-size: 0.875rem;
        font-weight: 500;
        color: #0f172a;
    }

    /* Rejection box */
    .rejection-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: #fff1f2;
        border: 1.5px solid #fecdd3;
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 20px;
    }

    .rejection-box .rej-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #e11d48;
        margin-bottom: 2px;
    }

    .rejection-box .rej-text {
        font-size: 0.84rem;
        color: #881337;
        margin: 0;
    }

    /* Note box */
    .note-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 20px;
    }

    .note-box .note-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 2px;
    }

    .note-box .note-text {
        font-size: 0.84rem;
        color: #374151;
        margin: 0;
    }

    /* Section divider */
    .section-divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 20px 0;
    }

    .section-label {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #94a3b8;
        margin-bottom: 12px;
        margin-top: 0;
    }

    /* Warehouse route */
    .wh-route {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 12px;
        align-items: start;
        margin-bottom: 20px;
    }

    .wh-box {
        border-radius: 10px;
        padding: 14px 16px;
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
        margin-bottom: 6px;
        margin-top: 0;
    }

    .wh-box.source .wh-label { color: #2563eb; }
    .wh-box.dest   .wh-label { color: #16a34a; }

    .wh-box .wh-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }

    .wh-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 28px;
        color: #cbd5e1;
    }

    /* Tables */
    .detail-table {
        width: 100%;
        border-collapse: collapse;
    }

    .detail-table thead th {
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

    .detail-table tbody tr {
        border-bottom: 1px solid #f8fafc;
    }

    .detail-table tbody tr:last-child { border-bottom: none; }
    .detail-table tbody tr.row-mismatch { background: #fff1f2; }

    .detail-table tbody td {
        padding: 12px 14px;
        vertical-align: middle;
        font-size: 0.84rem;
        color: #374151;
    }

    .detail-table tfoot td,
    .detail-table tfoot th {
        padding: 10px 14px;
        font-size: 0.82rem;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        color: #374151;
    }

    /* Section card */
    .section-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .section-card .section-header {
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

    .section-card .section-header.sj  { border-left: 3px solid #2563eb; }
    .section-card .section-header.ver-ok  { border-left: 3px solid #16a34a; }
    .section-card .section-header.ver-partial { border-left: 3px solid #64748b; }

    /* Surat jalan meta */
    .sj-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .sj-meta .meta-item .meta-label {
        font-size: 0.68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #94a3b8;
        margin-bottom: 3px;
    }

    .sj-meta .meta-item .meta-value {
        font-size: 0.875rem;
        font-weight: 500;
        color: #0f172a;
    }

    /* Verifikasi stats */
    .ver-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .ver-stat-pill {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        padding: 8px 16px;
        border-radius: 8px;
        min-width: 90px;
    }

    .ver-stat-pill .stat-num {
        font-size: 1.1rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .ver-stat-pill .stat-lbl {
        font-size: 0.68rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 2px;
    }

    .ver-stat-pill.total   { background: #eff6ff; color: #2563eb; }
    .ver-stat-pill.ok      { background: #dcfce7; color: #15803d; }
    .ver-stat-pill.nok     { background: #fee2e2; color: #dc2626; }
    .ver-stat-pill.qty     { background: #fff7ed; color: #ea580c; }

    /* Status check badge */
    .check-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 3px 8px;
        border-radius: 20px;
    }

    .check-badge.ok  { background: #dcfce7; color: #15803d; }
    .check-badge.nok { background: #fee2e2; color: #dc2626; }

    /* Action bar */
    .action-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        margin-top: 4px;
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

    .btn-action.approve  { background: #16a34a; color: #fff; }
    .btn-action.reject   { background: #dc2626; color: #fff; }
    .btn-action.sj       { background: #2563eb; color: #fff; }
    .btn-action.kirim    { background: #ea580c; color: #fff; }
    .btn-action.verif    { background: #0891b2; color: #fff; }
    .btn-action.print    { background: #f1f5f9; color: #475569; border: 1.5px solid #e2e8f0; }
    .btn-action.foto     { background: #f1f5f9; color: #475569; border: 1.5px solid #e2e8f0; }

    @media (max-width: 767px) {
        .wh-route {
            grid-template-columns: 1fr;
        }
        .wh-arrow {
            padding-top: 0;
            transform: rotate(90deg);
        }
        .ver-stats { gap: 8px; }
        .ver-stat-pill { min-width: 70px; padding: 6px 12px; }
    }

    @media print {
        .btn-action, .action-bar, .btn-back,
        .sidebar-nav, .topbar, .page-breadcrumb, .left-sidebar {
            display: none !important;
        }
        .card { border: none !important; box-shadow: none !important; }
    }
</style>

<?php
$detailRole       = $this->session->userdata('role');
$detailUserGudang = $this->session->userdata('id_gudang');
$detailUserId     = $this->session->userdata('id_user');
$isSourceAdmin    = ($detailRole == 'admin') || ($detailRole == 'staff' && $detailUserGudang == $permintaan->id_gudang_asal);
$isDestAdmin      = ($detailRole == 'admin') || ($detailRole == 'staff' && $detailUserGudang == $permintaan->id_gudang_tujuan);
$isRequesterPreApproval = ($permintaan->id_user == $detailUserId && $permintaan->status == 'menunggu');

$statusConfig = [
    'menunggu'      => ['label' => 'Menunggu Persetujuan'],
    'disetujui'     => ['label' => 'Disetujui'],
    'ditolak'       => ['label' => 'Ditolak'],
    'surat_jalan'   => ['label' => 'Surat Jalan Dibuat'],
    'dikirim'       => ['label' => 'Sedang Dikirim'],
    'selesai'       => ['label' => 'Selesai'],
    'belum_selesai' => ['label' => 'Belum Selesai'],
];
$sc = $statusConfig[$permintaan->status] ?? ['label' => $permintaan->status];
?>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card detail-preorder"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- Header -->
                <div class="card-header-custom">
                    <div class="header-left">
                        <h5 class="page-title">Detail Permintaan Barang</h5>
                        <span class="kode-pill"><?= htmlspecialchars($permintaan->kode_permintaan) ?></span>
                        <span class="pr-badge <?= $permintaan->status ?>">
                            <span class="dot"></span>
                            <?= $sc['label'] ?>
                        </span>
                    </div>
                    <a href="<?= base_url('preorder') ?>" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <!-- Body -->
                <div class="detail-body">

                    <!-- Meta row -->
                    <div class="meta-row">
                        <div class="meta-item">
                            <p class="meta-label">Tanggal Permintaan</p>
                            <p class="meta-value"><?= date('d F Y', strtotime($permintaan->tanggal_permintaan)) ?></p>
                        </div>
                        <div class="meta-item">
                            <p class="meta-label">Pemohon</p>
                            <p class="meta-value"><?= htmlspecialchars($permintaan->nama_user ?? '-') ?></p>
                        </div>
                        <div class="meta-item">
                            <p class="meta-label">Status</p>
                            <span class="pr-badge <?= $permintaan->status ?>">
                                <span class="dot"></span>
                                <?= $sc['label'] ?>
                            </span>
                        </div>
                    </div>

                    <!-- Rejection reason -->
                    <?php if ($permintaan->status == 'ditolak' && !empty($permintaan->alasan_tolak)): ?>
                        <div class="rejection-box">
                            <i class="fas fa-ban" style="color:#e11d48; margin-top:2px; flex-shrink:0;"></i>
                            <div>
                                <p class="rej-label">Alasan Penolakan</p>
                                <p class="rej-text"><?= htmlspecialchars($permintaan->alasan_tolak) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Keterangan -->
                    <?php if (!empty($permintaan->keterangan)): ?>
                        <div class="note-box">
                            <i class="fas fa-sticky-note" style="color:#94a3b8; margin-top:2px; flex-shrink:0;"></i>
                            <div>
                                <p class="note-label">Keterangan</p>
                                <p class="note-text"><?= htmlspecialchars($permintaan->keterangan) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <hr class="section-divider">

                    <!-- Warehouse route -->
                    <p class="section-label">Rute Permintaan</p>
                    <div class="wh-route">
                        <div class="wh-box source">
                            <p class="wh-label"><i class="fas fa-sign-out-alt mr-1"></i> Gudang Sumber</p>
                            <p class="wh-name"><?= htmlspecialchars($permintaan->nama_gudang_asal ?? '-') ?></p>
                        </div>
                        <div class="wh-arrow">
                            <i class="fas fa-arrow-right" style="font-size:1.1rem;"></i>
                        </div>
                        <div class="wh-box dest">
                            <p class="wh-label"><i class="fas fa-sign-in-alt mr-1"></i> Gudang Tujuan</p>
                            <p class="wh-name"><?= htmlspecialchars($permintaan->nama_gudang_tujuan ?? '-') ?></p>
                        </div>
                    </div>

                    <hr class="section-divider">

                    <!-- Daftar Barang -->
                    <p class="section-label">Daftar Barang yang Diminta</p>
                    <div class="section-card">
                        <div class="section-header">
                            <i class="fas fa-boxes" style="color:#94a3b8;"></i>
                            Barang Diminta
                        </div>
                        <div class="table-responsive">
                            <table class="detail-table">
                                <thead>
                                    <tr>
                                        <th style="width:44px;">No</th>
                                        <th>Nama Barang</th>
                                        <th>Satuan</th>
                                        <th class="text-center" style="width:100px;">Qty</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($details)): ?>
                                        <tr>
                                            <td colspan="5" style="text-align:center; padding:32px; color:#94a3b8; font-size:0.84rem;">
                                                Tidak ada data barang
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1; foreach ($details as $item): ?>
                                            <tr>
                                                <td style="color:#94a3b8; font-size:0.8rem;"><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($item->nama_barang ?? '-') ?></td>
                                                <td style="color:#64748b;"><?= htmlspecialchars($item->nama_satuan ?? '-') ?></td>
                                                <td class="text-center">
                                                    <strong><?= number_format($item->qty) ?></strong>
                                                </td>
                                                <td style="color:#64748b;"><?= htmlspecialchars($item->keterangan ?? '-') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <?php if (!empty($details)): ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" style="text-align:right; color:#94a3b8; font-size:0.78rem; font-weight:500;">
                                                Total item:
                                            </td>
                                            <td style="font-weight:600; color:#0f172a;">
                                                <?= count($details) ?> jenis barang
                                            </td>
                                        </tr>
                                    </tfoot>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>

                    <!-- Surat Jalan -->
                    <?php if ($surat_jalan): ?>
                        <hr class="section-divider">
                        <p class="section-label">Surat Jalan</p>
                        <div class="section-card">
                            <div class="section-header sj">
                                <i class="fas fa-file-alt" style="color:#2563eb;"></i>
                                Informasi Surat Jalan
                            </div>
                            <div class="sj-meta">
                                <div class="meta-item">
                                    <p class="meta-label">Nomor Pengiriman</p>
                                    <p class="meta-value"><?= htmlspecialchars($surat_jalan->nomor_pengiriman) ?></p>
                                </div>
                                <div class="meta-item">
                                    <p class="meta-label">Tanggal Pengiriman</p>
                                    <p class="meta-value"><?= date('d F Y', strtotime($surat_jalan->tanggal_pengiriman)) ?></p>
                                </div>
                            </div>

                            <?php if (!empty($surat_jalan_details)): ?>
                                <div class="table-responsive">
                                    <table class="detail-table">
                                        <thead>
                                            <tr>
                                                <th style="width:44px;">No</th>
                                                <th>Nama Barang</th>
                                                <th class="text-center" style="width:100px;">Qty</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach ($surat_jalan_details as $sjd): ?>
                                                <tr>
                                                    <td style="color:#94a3b8; font-size:0.8rem;"><?= $no++ ?></td>
                                                    <td><?= htmlspecialchars($sjd->nama_barang ?? '-') ?></td>
                                                    <td class="text-center"><strong><?= number_format($sjd->qty) ?></strong></td>
                                                    <td style="color:#64748b;"><?= htmlspecialchars($sjd->keterangan ?? '-') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>

                            <div style="padding:14px 16px; display:flex; gap:8px; flex-wrap:wrap; border-top:1px solid #f1f5f9;">
                                <a href="<?= base_url('preorder/print_surat_jalan/' . $permintaan->id) ?>"
                                    class="btn-action print" target="_blank">
                                    <i class="fas fa-print"></i> Cetak Surat Jalan
                                </a>
                                <?php if (!empty($surat_jalan->foto)): ?>
                                    <a href="<?= base_url($surat_jalan->foto) ?>" target="_blank"
                                        class="btn-action foto">
                                        <i class="fas fa-image"></i> Foto Surat Jalan
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Hasil Verifikasi -->
                    <?php if (!empty($verifikasi_details) && in_array($permintaan->status, ['belum_selesai', 'selesai'])): ?>
                        <?php
                        $totalSesuai = 0;
                        $totalTidakSesuai = 0;
                        $totalQtyKirim = 0;
                        $totalQtyDiterima = 0;
                        foreach ($verifikasi_details as $vd) {
                            if ($vd->is_sesuai == 1) $totalSesuai++;
                            else $totalTidakSesuai++;
                            $totalQtyKirim    += $vd->qty;
                            $totalQtyDiterima += ($vd->qty_diterima !== null ? $vd->qty_diterima : $vd->qty);
                        }
                        $verHeaderClass = ($permintaan->status == 'selesai') ? 'ver-ok' : 'ver-partial';
                        ?>
                        <hr class="section-divider">
                        <p class="section-label">Hasil Verifikasi Penerimaan</p>
                        <div class="section-card">
                            <div class="section-header <?= $verHeaderClass ?>">
                                <i class="fas fa-clipboard-check"
                                    style="color:<?= $permintaan->status == 'selesai' ? '#16a34a' : '#64748b' ?>;"></i>
                                Verifikasi Penerimaan
                            </div>

                            <div class="ver-stats">
                                <div class="ver-stat-pill total">
                                    <span class="stat-num"><?= count($verifikasi_details) ?></span>
                                    <span class="stat-lbl">Total</span>
                                </div>
                                <div class="ver-stat-pill ok">
                                    <span class="stat-num"><?= $totalSesuai ?></span>
                                    <span class="stat-lbl">Sesuai</span>
                                </div>
                                <div class="ver-stat-pill nok">
                                    <span class="stat-num"><?= $totalTidakSesuai ?></span>
                                    <span class="stat-lbl">Tidak Sesuai</span>
                                </div>
                                <div class="ver-stat-pill qty">
                                    <span class="stat-num"><?= number_format($totalQtyDiterima) ?>/<?= number_format($totalQtyKirim) ?></span>
                                    <span class="stat-lbl">Qty Diterima</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="detail-table">
                                    <thead>
                                        <tr>
                                            <th style="width:44px;">No</th>
                                            <th>Nama Barang</th>
                                            <th>Satuan</th>
                                            <th class="text-center" style="width:90px;">Qty Kirim</th>
                                            <th class="text-center" style="width:100px;">Qty Diterima</th>
                                            <th class="text-center" style="width:110px;">Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($verifikasi_details as $vd): ?>
                                            <tr class="<?= $vd->is_sesuai == 0 ? 'row-mismatch' : '' ?>">
                                                <td style="color:#94a3b8; font-size:0.8rem;"><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($vd->nama_barang ?? '-') ?></td>
                                                <td style="color:#64748b;"><?= htmlspecialchars($vd->nama_satuan ?? '-') ?></td>
                                                <td class="text-center">
                                                    <strong><?= number_format($vd->qty) ?></strong>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    $qtyDiterima = $vd->qty_diterima !== null ? $vd->qty_diterima : ($vd->is_sesuai == 1 ? $vd->qty : 0);
                                                    ?>
                                                    <strong style="color:<?= $vd->is_sesuai == 0 ? '#dc2626' : 'inherit' ?>;">
                                                        <?= number_format($qtyDiterima) ?>
                                                    </strong>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($vd->is_sesuai == 1): ?>
                                                        <span class="check-badge ok">
                                                            <i class="fas fa-check"></i> Sesuai
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="check-badge nok">
                                                            <i class="fas fa-times"></i> Tidak Sesuai
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="color:#64748b;"><?= htmlspecialchars($vd->keterangan_verifikasi ?? '-') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Action bar -->
                    <?php
                    $hasActions = ($isSourceAdmin && in_array($permintaan->status, ['menunggu', 'disetujui', 'surat_jalan']))
                               || ($isDestAdmin && $permintaan->status == 'dikirim');
                    ?>
                    <?php if ($hasActions): ?>
                        <div class="action-bar">
                            <?php if ($isSourceAdmin && $permintaan->status == 'menunggu'): ?>
                                <form action="<?= base_url('preorder/approve/' . $permintaan->id) ?>" method="POST"
                                    style="display:inline;">
                                    <button type="submit" class="btn-action approve"
                                        onclick="return confirm('Setujui permintaan ini?')">
                                        <i class="fas fa-check"></i> Setujui Permintaan
                                    </button>
                                </form>
                                <button type="button" class="btn-action reject"
                                    data-toggle="modal" data-target="#rejectModalDetail">
                                    <i class="fas fa-times"></i> Tolak Permintaan
                                </button>
                            <?php endif; ?>

                            <?php if ($isSourceAdmin && $permintaan->status == 'disetujui'): ?>
                                <a href="<?= base_url('preorder/surat_jalan/' . $permintaan->id) ?>"
                                    class="btn-action sj">
                                    <i class="fas fa-file-alt"></i> Buat Surat Jalan
                                </a>
                            <?php endif; ?>

                            <?php if ($isSourceAdmin && $permintaan->status == 'surat_jalan'): ?>
                                <form action="<?= base_url('preorder/kirim/' . $permintaan->id) ?>" method="POST"
                                    style="display:inline;">
                                    <button type="submit" class="btn-action kirim"
                                        onclick="return confirm('Tandai barang sedang dikirim?')">
                                        <i class="fas fa-shipping-fast"></i> Tandai Sedang Dikirim
                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if ($isDestAdmin && $permintaan->status == 'dikirim'): ?>
                                <a href="<?= base_url('preorder/verifikasi/' . $permintaan->id) ?>"
                                    class="btn-action verif">
                                    <i class="fas fa-clipboard-check"></i> Verifikasi Penerimaan
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<?php if ($isSourceAdmin && $permintaan->status == 'menunggu'): ?>
    <div class="modal fade" id="rejectModalDetail" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"
                style="border-radius:12px; border:none; box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                <form action="<?= base_url('preorder/reject/' . $permintaan->id) ?>" method="POST">
                    <div class="modal-header"
                        style="border-bottom:1px solid #f1f5f9; padding:20px 24px 16px;">
                        <h5 class="modal-title"
                            style="font-size:0.95rem; font-weight:600; color:#0f172a;">
                            Tolak Permintaan
                        </h5>
                        <button type="button" class="close" data-dismiss="modal"
                            style="color:#94a3b8;"><span>&times;</span></button>
                    </div>
                    <div class="modal-body" style="padding:20px 24px;">
                        <p style="font-size:0.875rem; color:#374151; margin-bottom:12px;">
                            Tolak permintaan <strong><?= htmlspecialchars($permintaan->kode_permintaan) ?></strong>?
                        </p>
                        <div class="form-group mb-0">
                            <label style="font-size:0.82rem; font-weight:500; color:#374151;">
                                Alasan Penolakan
                            </label>
                            <textarea name="alasan_tolak" class="form-control" rows="3"
                                placeholder="Masukkan alasan penolakan..."
                                style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.85rem; resize:none;"
                                required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer"
                        style="border-top:1px solid #f1f5f9; padding:16px 24px;">
                        <button type="button" class="btn btn-secondary btn-sm"
                            data-dismiss="modal" style="border-radius:8px;">Batal</button>
                        <button type="submit" class="btn btn-danger btn-sm"
                            style="border-radius:8px;">Ya, Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
