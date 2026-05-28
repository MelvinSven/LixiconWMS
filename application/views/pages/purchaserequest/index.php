<style>
    .pr-card .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .pr-card .card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pr-card .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .pr-card .count-badge {
        background: #eff6ff;
        color: #2563eb;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
        letter-spacing: 0.04em;
    }

    .pr-card .btn-add {
        height: 36px;
        padding: 0 14px;
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
        text-decoration: none;
    }

    .pr-card .btn-add:hover { background: #1d4ed8; color: #fff; text-decoration: none; }

    /* Table */
    .pr-table {
        width: 100%;
        border-collapse: collapse;
    }

    .pr-table thead th {
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

    .pr-table tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.1s;
    }

    .pr-table tbody tr:hover { background: #fafbfd; }
    .pr-table tbody tr:last-child { border-bottom: none; }

    .pr-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 0.85rem;
        color: #374151;
    }

    /* Kode pill */
    .kode-pill {
        font-size: 0.75rem;
        font-weight: 600;
        color: #2563eb;
        background: #eff6ff;
        padding: 3px 8px;
        border-radius: 6px;
        letter-spacing: 0.02em;
        white-space: nowrap;
    }

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

    .pr-badge.menunggu      { background: #fef9c3; color: #854d0e; }
    .pr-badge.menunggu .dot { background: #ca8a04; }

    .pr-badge.disetujui      { background: #e0f2fe; color: #0369a1; }
    .pr-badge.disetujui .dot { background: #0284c7; }

    .pr-badge.diproses      { background: #fff7ed; color: #ea580c; }
    .pr-badge.diproses .dot { background: #ea580c; }

    .pr-badge.selesai      { background: #dcfce7; color: #15803d; }
    .pr-badge.selesai .dot { background: #16a34a; }

    .pr-badge.belum_selesai      { background: #f1f5f9; color: #475569; }
    .pr-badge.belum_selesai .dot { background: #64748b; }

    .pr-badge.ditolak      { background: #fee2e2; color: #dc2626; }
    .pr-badge.ditolak .dot { background: #dc2626; }

    /* Action buttons */
    .pr-btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s;
        font-size: 0.8rem;
        text-decoration: none;
    }

    .pr-btn-action:hover { transform: translateY(-1px); text-decoration: none; }

    .pr-btn-action.view   { background: #e0f2fe; color: #0369a1; }
    .pr-btn-action.view:hover  { background: #bae6fd; }

    .pr-btn-action.delete { background: #fff1f2; color: #e11d48; }
    .pr-btn-action.delete:hover { background: #fee2e2; }

    /* Empty state */
    .pr-empty {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .pr-empty i { font-size: 2.5rem; margin-bottom: 12px; opacity: 0.5; }
    .pr-empty p { margin: 0; font-size: 0.875rem; }

    .row-num { color: #94a3b8; font-size: 0.8rem; }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card pr-card"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- Card header -->
                <div class="card-header-custom">
                    <div class="card-header-left">
                        <h5 class="page-title">Daftar Purchase Request</h5>
                        <?php if (isset($totalPR)): ?>
                            <span class="count-badge"><?= $totalPR ?> PR</span>
                        <?php endif ?>
                    </div>
                    <?php if ($this->session->userdata('role') == 'staff'): ?>
                        <a href="<?= base_url('purchaserequest/create') ?>" class="btn-add">
                            <i class="fas fa-plus" style="font-size:0.75rem;"></i> Buat Purchase Request
                        </a>
                    <?php endif ?>
                </div>

                <!-- Table -->
                <?php if (empty($prs)): ?>
                    <div class="pr-empty">
                        <div><i class="fas fa-file-invoice"></i></div>
                        <p>Belum ada Purchase Request.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="pr-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor PR</th>
                                    <th>Project</th>
                                    <th>Tgl PR</th>
                                    <th>Project Admin</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = ($currentPage - 1) * 10 + 1;
                                $statusLabels = [
                                    'menunggu'      => 'Menunggu',
                                    'ditolak'       => 'Ditolak',
                                    'disetujui'     => 'Disetujui',
                                    'diproses'      => 'Diproses',
                                    'selesai'       => 'Selesai',
                                    'belum_selesai' => 'Belum Selesai',
                                ];
                                foreach ($prs as $p):
                                    $canDelete = $this->session->userdata('role') == 'admin'
                                        || ($this->session->userdata('role') == 'staff' && in_array($p->status, ['menunggu', 'ditolak']));
                                ?>
                                    <tr>
                                        <td class="row-num"><?= $no++ ?></td>
                                        <td><span class="kode-pill"><?= htmlspecialchars($p->kode_pr) ?></span></td>
                                        <td><?= htmlspecialchars($p->nama_gudang ?? '-') ?></td>
                                        <td><?= date('d M Y', strtotime($p->tanggal_pr)) ?></td>
                                        <td><?= htmlspecialchars($p->nama_user ?? '-') ?></td>
                                        <td class="text-center">
                                            <span class="pr-badge <?= $p->status ?>">
                                                <span class="dot"></span>
                                                <?= $statusLabels[$p->status] ?? $p->status ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div style="display:flex; gap:6px; justify-content:center;">
                                                <a href="<?= base_url('purchaserequest/detail/' . $p->id) ?>"
                                                    class="pr-btn-action view" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($canDelete): ?>
                                                    <button type="button" class="pr-btn-action delete"
                                                        data-toggle="modal" data-target="#deleteModal<?= $p->id ?>" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                <?php endif ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>

                <!-- Pagination footer -->
                <?php if (!empty($prs) && $totalPR > 10): ?>
                    <?php $totalPages = ceil($totalPR / 10); ?>
                    <div class="wms-pag-footer">
                        <nav aria-label="Navigasi halaman">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= base_url('purchaserequest?page=' . ($currentPage - 1)) ?>">&laquo;</a>
                                </li>
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= base_url('purchaserequest?page=' . $i) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor ?>
                                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= base_url('purchaserequest?page=' . ($currentPage + 1)) ?>">&raquo;</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<?php foreach ($prs as $p):
    $canDelete = $this->session->userdata('role') == 'admin'
        || ($this->session->userdata('role') == 'staff' && in_array($p->status, ['menunggu', 'ditolak']));
?>
    <?php if ($canDelete): ?>
    <div class="modal fade" id="deleteModal<?= $p->id ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius:12px; border:none; box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:20px 24px 16px;">
                    <h5 class="modal-title" style="font-size:0.95rem; font-weight:600; color:#0f172a;">Hapus Purchase Request</h5>
                    <button type="button" class="close" data-dismiss="modal" style="color:#94a3b8;"><span>&times;</span></button>
                </div>
                <div class="modal-body" style="padding:20px 24px;">
                    <p style="font-size:0.875rem; color:#374151; margin-bottom:8px;">
                        Hapus PR <strong><?= htmlspecialchars($p->kode_pr) ?></strong>?
                    </p>
                    <p style="font-size:0.8rem; color:#ef4444; margin:0;">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:16px 24px;">
                    <form action="<?= base_url('purchaserequest/delete/' . $p->id) ?>" method="POST" style="display:inline;">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                            style="border-radius:8px;">Batal</button>
                        <button type="submit" class="btn btn-danger btn-sm"
                            style="border-radius:8px;">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>
<?php endforeach ?>
