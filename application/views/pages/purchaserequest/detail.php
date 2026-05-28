<style>
    /* ── Detail Purchase Request ─────────────────────────────── */
    .detail-pr .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-pr .header-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .detail-pr .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .detail-pr .kode-pill {
        font-size: 0.75rem;
        font-weight: 600;
        color: #2563eb;
        background: #eff6ff;
        padding: 3px 10px;
        border-radius: 6px;
        letter-spacing: 0.02em;
    }

    .detail-pr .btn-back {
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

    .detail-pr .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .detail-pr .detail-body { padding: 24px; }

    /* Status badge */
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

    .pr-badge.menunggu       { background: #fef9c3; color: #854d0e; }
    .pr-badge.menunggu .dot  { background: #ca8a04; }

    .pr-badge.disetujui       { background: #e0f2fe; color: #0369a1; }
    .pr-badge.disetujui .dot  { background: #0284c7; }

    .pr-badge.diproses       { background: #fff7ed; color: #c2410c; }
    .pr-badge.diproses .dot  { background: #ea580c; }

    .pr-badge.selesai       { background: #dcfce7; color: #15803d; }
    .pr-badge.selesai .dot  { background: #16a34a; }

    .pr-badge.belum_selesai       { background: #f1f5f9; color: #475569; }
    .pr-badge.belum_selesai .dot  { background: #64748b; }

    .pr-badge.ditolak       { background: #fee2e2; color: #dc2626; }
    .pr-badge.ditolak .dot  { background: #dc2626; }

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
        margin: 0;
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

    .section-card .section-header.items    { border-left: 3px solid #2563eb; }
    .section-card .section-header.delivery { border-left: 3px solid #ea580c; }
    .section-card .section-header.sj       { border-left: 3px solid #7c3aed; }

    /* Detail table */
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

    .detail-table tbody tr { border-bottom: 1px solid #f8fafc; }
    .detail-table tbody tr:last-child { border-bottom: none; }

    .detail-table tbody td {
        padding: 12px 14px;
        vertical-align: middle;
        font-size: 0.84rem;
        color: #374151;
    }

    /* Item status badges */
    .item-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.7rem;
        font-weight: 500;
        padding: 3px 8px;
        border-radius: 20px;
    }

    .item-badge.sesuai   { background: #dcfce7; color: #15803d; }
    .item-badge.belum    { background: #f1f5f9; color: #475569; }
    .item-badge.pending  { background: #fef9c3; color: #854d0e; }

    /* Verification stats pills */
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

    .ver-stat-pill .stat-num { font-size: 1.1rem; font-weight: 700; line-height: 1.2; }
    .ver-stat-pill .stat-lbl {
        font-size: 0.68rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 2px;
    }

    .ver-stat-pill.total  { background: #eff6ff; color: #2563eb; }
    .ver-stat-pill.ok     { background: #dcfce7; color: #15803d; }
    .ver-stat-pill.nok    { background: #fee2e2; color: #dc2626; }
    .ver-stat-pill.pend   { background: #fef9c3; color: #854d0e; }

    /* Delivery tracker per item */
    .delivery-item {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .delivery-item:last-child { border-bottom: none; }

    .delivery-item-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .delivery-item-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #0f172a;
    }

    .delivery-item-qty {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .step-track {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .step-node {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 0 0 auto;
        min-width: 72px;
    }

    .step-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }

    .step-circle.active-final { background: #16a34a; color: #fff; }
    .step-circle.active       { background: #2563eb; color: #fff; }
    .step-circle.inactive     { background: #f1f5f9; color: #94a3b8; border: 1.5px solid #e2e8f0; }

    .step-label {
        font-size: 0.68rem;
        font-weight: 500;
        margin-top: 4px;
        text-align: center;
    }

    .step-label.active-final { color: #15803d; font-weight: 600; }
    .step-label.active       { color: #2563eb; font-weight: 600; }
    .step-label.inactive     { color: #94a3b8; }

    .step-line {
        flex: 1;
        height: 3px;
        margin-bottom: 18px;
    }

    .step-line.done   { background: #2563eb; }
    .step-line.undone { background: #e2e8f0; }

    .delivery-actions { display: flex; gap: 6px; flex-wrap: wrap; }

    /* Surat Jalan table */
    .sj-file-row td { vertical-align: middle; }

    /* Action bar */
    .action-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        margin-top: 4px;
        justify-content: space-between;
        align-items: center;
    }

    .action-bar-right { display: flex; gap: 8px; flex-wrap: wrap; }

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

    .btn-action.back    { background: #f1f5f9; color: #475569; }
    .btn-action.approve { background: #16a34a; color: #fff; }
    .btn-action.reject  { background: #dc2626; color: #fff; }
    .btn-action.verif   { background: #0891b2; color: #fff; }
    .btn-action.foto    { background: #f1f5f9; color: #475569; border: 1.5px solid #e2e8f0; }

    @media (max-width: 767px) {
        .action-bar { flex-direction: column; }
        .action-bar-right { width: 100%; }
        .ver-stat-pill { min-width: 70px; padding: 6px 12px; }
    }
</style>

<?php
$statusConfig = [
    'menunggu'     => ['class' => 'menunggu',     'icon' => 'fas fa-clock',             'label' => 'Menunggu'],
    'ditolak'      => ['class' => 'ditolak',      'icon' => 'fas fa-times-circle',      'label' => 'Ditolak'],
    'disetujui'    => ['class' => 'disetujui',    'icon' => 'fas fa-check',             'label' => 'Disetujui'],
    'diproses'     => ['class' => 'diproses',     'icon' => 'fas fa-cog',               'label' => 'Diproses'],
    'selesai'      => ['class' => 'selesai',      'icon' => 'fas fa-check-circle',      'label' => 'Selesai'],
    'belum_selesai'=> ['class' => 'belum_selesai','icon' => 'fas fa-exclamation-circle','label' => 'Belum Selesai'],
];
$itemStatusConfig = [
    'sesuai'  => ['class' => 'sesuai',  'icon' => 'fas fa-check', 'label' => 'Sesuai'],
    'belum'   => ['class' => 'belum',   'icon' => 'fas fa-minus', 'label' => 'Belum Selesai'],
    'pending' => ['class' => 'pending', 'icon' => 'fas fa-clock', 'label' => 'Belum Diverifikasi'],
];
$sc          = $statusConfig[$pr->status] ?? ['class' => 'menunggu', 'icon' => 'fas fa-question', 'label' => $pr->status];
$role        = $this->session->userdata('role');
$canVerify   = ($role == 'staff' && in_array($pr->status, ['disetujui', 'belum_selesai']));
$showDelivery= in_array($pr->status, ['disetujui', 'belum_selesai', 'selesai']);
$canEditDelivery = in_array($role, ['purchasing_admin', 'admin']) && in_array($pr->status, ['disetujui', 'belum_selesai']);
$hasUnverified   = false;
foreach ($details as $d) {
    if ((int) ($d->is_sesuai ?? -1) !== 1) { $hasUnverified = true; break; }
}

$stateOrder  = ['diproses' => 0, 'dikirim' => 1, 'sampai' => 2];
$stateLabels = ['diproses' => 'Diproses', 'dikirim' => 'Dikirim', 'sampai' => 'Sampai'];
$stateIcons  = ['diproses' => 'fas fa-shopping-cart', 'dikirim' => 'fas fa-truck', 'sampai' => 'fas fa-check-circle'];
?>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card detail-pr"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- ── Header ─────────────────────────────────────── -->
                <div class="card-header-custom">
                    <div class="header-left">
                        <h5 class="page-title">Detail Purchase Request</h5>
                        <span class="kode-pill"><?= htmlspecialchars($pr->kode_pr) ?></span>
                        <span class="pr-badge <?= $sc['class'] ?>">
                            <span class="dot"></span>
                            <?= $sc['label'] ?>
                        </span>
                    </div>
                    <a href="<?= base_url('purchaserequest') ?>" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <!-- ── Body ───────────────────────────────────────── -->
                <div class="detail-body">

                    <!-- Flash messages -->
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            <?= $this->session->flashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                            <?= $this->session->flashdata('error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('warning')): ?>
                        <div class="alert alert-warning alert-dismissible fade show mb-4">
                            <?= $this->session->flashdata('warning') ?>
                        </div>
                    <?php endif; ?>

                    <!-- Meta row -->
                    <div class="meta-row">
                        <div class="meta-item">
                            <p class="meta-label">Project Admin</p>
                            <p class="meta-value"><?= htmlspecialchars($pr->nama_user ?? '-') ?></p>
                        </div>
                        <div class="meta-item">
                            <p class="meta-label">Project</p>
                            <p class="meta-value"><?= htmlspecialchars($pr->nama_gudang ?? '-') ?></p>
                        </div>
                        <div class="meta-item">
                            <p class="meta-label">Tanggal PR</p>
                            <p class="meta-value">
                                <?= date('d F Y', strtotime($pr->tanggal_pr)) ?>
                                <?= $pr->created_at ? '<span style="color:#94a3b8;">'.date('H:i', strtotime($pr->created_at)).'</span>' : '' ?>
                            </p>
                        </div>
                        <div class="meta-item">
                            <p class="meta-label">Status</p>
                            <span class="pr-badge <?= $sc['class'] ?>">
                                <span class="dot"></span>
                                <?= $sc['label'] ?>
                            </span>
                        </div>
                        <?php if (!empty($pr->nama_responder)): ?>
                        <div class="meta-item">
                            <p class="meta-label">Direspon Oleh</p>
                            <p class="meta-value"><?= htmlspecialchars($pr->nama_responder) ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($pr->tanggal_respon)): ?>
                        <div class="meta-item">
                            <p class="meta-label">Tanggal Respon</p>
                            <p class="meta-value"><?= date('d F Y H:i', strtotime($pr->tanggal_respon)) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Rejection reason -->
                    <?php if ($pr->status == 'ditolak' && !empty($pr->alasan_tolak)): ?>
                        <div class="rejection-box">
                            <i class="fas fa-ban" style="color:#e11d48; margin-top:2px; flex-shrink:0;"></i>
                            <div>
                                <p class="rej-label">Alasan Penolakan</p>
                                <p class="rej-text"><?= nl2br(htmlspecialchars($pr->alasan_tolak)) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- PR Photo -->
                    <?php if (!empty($pr->foto_pr)): ?>
                        <div class="mb-4">
                            <button type="button" class="btn-action foto" data-toggle="modal" data-target="#fotoModal">
                                <i class="fas fa-image"></i> Lihat Foto PR
                            </button>
                        </div>
                    <?php endif; ?>

                    <hr class="section-divider">

                    <!-- ── Daftar Barang ───────────────────────────── -->
                    <p class="section-label">Daftar Barang</p>
                    <div class="section-card">
                        <div class="section-header items">
                            <i class="fas fa-boxes" style="color:#2563eb;"></i>
                            Barang yang Diminta
                        </div>
                        <div class="table-responsive">
                            <table class="detail-table">
                                <thead>
                                    <tr>
                                        <th style="width:44px;">No</th>
                                        <th>Nama Barang</th>
                                        <th style="width:100px;">Satuan</th>
                                        <th class="text-center" style="width:80px;">Qty</th>
                                        <th class="text-center" style="width:100px;">Diterima</th>
                                        <th class="text-center" style="width:140px;">Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($details)): ?>
                                        <tr>
                                            <td colspan="6" style="text-align:center; padding:32px; color:#94a3b8; font-size:0.84rem;">
                                                Tidak ada item.
                                            </td>
                                        </tr>
                                    <?php else:
                                        foreach ($details as $i => $it):
                                            if ($it->is_sesuai === null) {
                                                $isc = $itemStatusConfig['pending'];
                                            } elseif ((int) $it->is_sesuai === 1) {
                                                $isc = $itemStatusConfig['sesuai'];
                                            } else {
                                                $isc = $itemStatusConfig['belum'];
                                            }
                                    ?>
                                        <tr>
                                            <td style="color:#94a3b8; font-size:0.8rem;"><?= $i + 1 ?></td>
                                            <td style="font-weight:500;"><?= htmlspecialchars($it->nama_barang) ?></td>
                                            <td style="color:#64748b;"><?= htmlspecialchars($it->nama_satuan ?? '-') ?></td>
                                            <td class="text-center"><strong><?= (int) $it->qty ?></strong></td>
                                            <td class="text-center">
                                                <?php if ($it->qty_diterima !== null): ?>
                                                    <strong><?= (int) $it->qty_diterima ?></strong>
                                                <?php else: ?>
                                                    <span style="color:#94a3b8;">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="item-badge <?= $isc['class'] ?>">
                                                    <i class="<?= $isc['icon'] ?>"></i>
                                                    <?= $isc['label'] ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                                <?php if (!empty($details)): ?>
                                    <tfoot>
                                        <tr style="background:#f8fafc; border-top:1px solid #f1f5f9;">
                                            <td colspan="5" style="text-align:right; color:#94a3b8; font-size:0.78rem; font-weight:500; padding:10px 14px;">
                                                Total item:
                                            </td>
                                            <td style="padding:10px 14px; font-weight:600; color:#0f172a; font-size:0.82rem;">
                                                <?= count($details) ?> jenis
                                            </td>
                                        </tr>
                                    </tfoot>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>

                    <!-- ── Verification Progress ───────────────────── -->
                    <?php if (!empty($progress) && $progress['total'] > 0): ?>
                        <div class="ver-stats" style="background:#f8fafc; border-radius:10px; border:1.5px solid #f1f5f9; margin-bottom:20px;">
                            <div class="ver-stat-pill total">
                                <span class="stat-num"><?= $progress['total'] ?></span>
                                <span class="stat-lbl">Total</span>
                            </div>
                            <div class="ver-stat-pill ok">
                                <span class="stat-num"><?= $progress['sesuai'] ?></span>
                                <span class="stat-lbl">Sesuai</span>
                            </div>
                            <div class="ver-stat-pill" style="background:#fee2e2; color:#dc2626;">
                                <span class="stat-num"><?= $progress['belum_sesuai'] ?></span>
                                <span class="stat-lbl">Belum Sesuai</span>
                            </div>
                            <div class="ver-stat-pill pend">
                                <span class="stat-num"><?= $progress['belum_diverifikasi'] ?></span>
                                <span class="stat-lbl">Belum Diverifikasi</span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- ── Status Pengiriman ───────────────────────── -->
                    <?php if ($showDelivery && !empty($details)): ?>
                        <hr class="section-divider">
                        <p class="section-label">Status Pengiriman Barang</p>
                        <div class="section-card">
                            <div class="section-header delivery">
                                <i class="fas fa-shipping-fast" style="color:#ea580c;"></i>
                                Pengiriman Per Item
                            </div>
                            <?php foreach ($details as $it):
                                $state = $it->status_pengiriman ?? 'diproses';
                                $step  = $stateOrder[$state] ?? 0;
                            ?>
                                <div class="delivery-item">
                                    <div class="delivery-item-title">
                                        <span class="delivery-item-name"><?= htmlspecialchars($it->nama_barang) ?></span>
                                        <span class="delivery-item-qty">Qty: <?= (int) $it->qty ?></span>
                                    </div>

                                    <div class="step-track">
                                        <?php foreach (['diproses', 'dikirim', 'sampai'] as $idx => $s):
                                            $active  = ($step >= $idx);
                                            $isFinal = ($s === 'sampai' && $step === 2);
                                            $circleClass = $isFinal ? 'active-final' : ($active ? 'active' : 'inactive');
                                            $labelClass  = $isFinal ? 'active-final' : ($active ? 'active' : 'inactive');
                                        ?>
                                            <div class="step-node">
                                                <div class="step-circle <?= $circleClass ?>">
                                                    <i class="<?= $stateIcons[$s] ?>"></i>
                                                </div>
                                                <span class="step-label <?= $labelClass ?>"><?= $stateLabels[$s] ?></span>
                                            </div>
                                            <?php if ($s !== 'sampai'): ?>
                                                <div class="step-line <?= ($step > $idx) ? 'done' : 'undone' ?>"></div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php if ($canEditDelivery): ?>
                                        <div class="delivery-actions mt-2">
                                            <?php foreach (['diproses', 'dikirim', 'sampai'] as $s):
                                                if ($s === $state) continue;
                                                $btnMap = [
                                                    'diproses' => ['cls' => 'btn btn-outline-secondary btn-sm', 'ico' => 'fas fa-undo'],
                                                    'dikirim'  => ['cls' => 'btn btn-outline-info btn-sm',      'ico' => 'fas fa-truck'],
                                                    'sampai'   => ['cls' => 'btn btn-outline-success btn-sm',   'ico' => 'fas fa-check'],
                                                ];
                                                $bm = $btnMap[$s];
                                            ?>
                                                <form action="<?= base_url('purchaserequest/update_status_pengiriman/' . $it->id) ?>"
                                                    method="POST" style="display:inline;">
                                                    <input type="hidden" name="new_state" value="<?= $s ?>">
                                                    <button type="submit" class="<?= $bm['cls'] ?>"
                                                        onclick="return confirm('Set status pengiriman menjadi &quot;<?= $stateLabels[$s] ?>&quot;?')">
                                                        <i class="<?= $bm['ico'] ?> mr-1"></i><?= $stateLabels[$s] ?>
                                                    </button>
                                                </form>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- ── Surat Jalan ─────────────────────────────── -->
                    <?php if (!empty($surat_jalan_list)): ?>
                        <hr class="section-divider">
                        <p class="section-label">Surat Jalan</p>
                        <div class="section-card">
                            <div class="section-header sj">
                                <i class="fas fa-file-pdf" style="color:#7c3aed;"></i>
                                Dokumen Surat Jalan
                            </div>
                            <div class="table-responsive">
                                <table class="detail-table">
                                    <thead>
                                        <tr>
                                            <th style="width:44px;">#</th>
                                            <th>Nama File</th>
                                            <th style="width:180px;">Tanggal Upload</th>
                                            <th class="text-center" style="width:80px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($surat_jalan_list as $i => $sj): ?>
                                            <tr class="sj-file-row">
                                                <td style="color:#94a3b8; font-size:0.8rem;"><?= $i + 1 ?></td>
                                                <td>
                                                    <i class="fas fa-file-pdf" style="color:#7c3aed; margin-right:6px;"></i>
                                                    <?= htmlspecialchars($sj->nama_file) ?>
                                                </td>
                                                <td style="color:#64748b; font-size:0.82rem;">
                                                    <?= date('d F Y H:i', strtotime($sj->uploaded_at)) ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= base_url($sj->file_path) ?>" target="_blank"
                                                        class="btn btn-sm btn-outline-secondary" title="Unduh"
                                                        style="border-radius:6px;">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- ── Action bar ──────────────────────────────── -->
                    <div class="action-bar">
                        <a href="<?= base_url('purchaserequest') ?>" class="btn-action back">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div class="action-bar-right">
                            <?php if ($role == 'purchasing_admin' && $pr->status == 'menunggu'): ?>
                                <form action="<?= base_url('purchaserequest/accept/' . $pr->id) ?>" method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Setujui Purchase Request ini?')">
                                    <button type="submit" class="btn-action approve">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>
                                <button type="button" class="btn-action reject"
                                    data-toggle="modal" data-target="#rejectModal">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            <?php endif; ?>
                            <?php if ($canVerify && $hasUnverified): ?>
                                <a href="<?= base_url('purchaserequest/verifikasi/' . $pr->id) ?>" class="btn-action verif">
                                    <i class="fas fa-clipboard-check"></i> Verifikasi Barang
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── Modal: Reject ─────────────────────────────────────────────── -->
<?php if ($role == 'purchasing_admin' && $pr->status == 'menunggu'): ?>
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"
                style="border-radius:12px; border:none; box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                <form action="<?= base_url('purchaserequest/reject/' . $pr->id) ?>" method="POST">
                    <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:20px 24px 16px;">
                        <h5 class="modal-title" style="font-size:0.95rem; font-weight:600; color:#0f172a;">
                            Tolak Purchase Request
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" style="color:#94a3b8;">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:20px 24px;">
                        <p style="font-size:0.875rem; color:#374151; margin-bottom:12px;">
                            Tolak PR <strong><?= htmlspecialchars($pr->kode_pr) ?></strong>?
                        </p>
                        <div class="form-group mb-0">
                            <label style="font-size:0.82rem; font-weight:500; color:#374151;">Alasan Penolakan</label>
                            <textarea name="alasan_tolak" class="form-control" rows="3"
                                placeholder="Berikan alasan agar Project Admin dapat merevisi..."
                                style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.85rem; resize:none;"
                                required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:16px 24px;">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                            style="border-radius:8px;">Batal</button>
                        <button type="submit" class="btn btn-danger btn-sm"
                            style="border-radius:8px;">Ya, Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- ── Modal: Qty per item ───────────────────────────────────────── -->
<?php if ($role == 'staff' && $pr->status == 'belum_selesai'):
    foreach ($details as $it):
        if ((int) ($it->is_sesuai ?? -1) !== 0) continue;
        $qd = (int) ($it->qty_diterima ?? 0);
?>
    <div class="modal fade" id="qtyModal<?= $it->id ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius:12px; border:none; box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                <form action="<?= base_url('purchaserequest/update_qty/' . $it->id) ?>" method="POST">
                    <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:20px 24px 16px;">
                        <h5 class="modal-title" style="font-size:0.95rem; font-weight:600; color:#0f172a;">
                            Ubah Qty — <?= htmlspecialchars($it->nama_barang) ?>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" style="color:#94a3b8;">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:20px 24px;">
                        <p style="font-size:0.84rem; color:#374151; margin-bottom:8px;">
                            Qty diminta: <strong><?= (int) $it->qty ?></strong> &mdash; Qty diterima: <strong><?= $qd ?></strong>
                        </p>
                        <p style="font-size:0.78rem; color:#94a3b8; margin-bottom:12px;">
                            Ubah Qty menjadi <strong><?= $qd ?></strong> agar item ini berstatus "Sesuai".
                        </p>
                        <div class="form-group mb-0">
                            <label style="font-size:0.82rem; font-weight:500; color:#374151;">Qty Baru</label>
                            <input type="number" name="qty" class="form-control" min="<?= $qd ?>" value="<?= $qd ?>"
                                style="border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.85rem;"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:16px 24px;">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                            style="border-radius:8px;">Batal</button>
                        <button type="submit" class="btn btn-warning btn-sm"
                            style="border-radius:8px;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; endif; ?>

<!-- ── Modal: Foto PR ────────────────────────────────────────────── -->
<?php if (!empty($pr->foto_pr)): ?>
    <div class="modal fade" id="fotoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius:12px; border:none; box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:20px 24px 16px;">
                    <h5 class="modal-title" style="font-size:0.95rem; font-weight:600; color:#0f172a;">
                        <i class="fas fa-image mr-2" style="color:#2563eb;"></i>
                        Foto PR — <?= htmlspecialchars($pr->kode_pr) ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" style="color:#94a3b8;">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center" style="padding:20px 24px;">
                    <img src="<?= base_url($pr->foto_pr) ?>" alt="Foto PR" class="img-fluid"
                        style="border-radius:8px; max-height:70vh; object-fit:contain;">
                </div>
                <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:16px 24px;">
                    <a href="<?= base_url($pr->foto_pr) ?>" target="_blank"
                        class="btn btn-outline-secondary btn-sm" style="border-radius:8px;">
                        <i class="fas fa-external-link-alt mr-1"></i> Buka di Tab Baru
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                        style="border-radius:8px;">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
