<style>
    .preorder-card .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .preorder-card .card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .preorder-card .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .preorder-card .count-badge {
        background: #eff6ff;
        color: #2563eb;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
        letter-spacing: 0.04em;
    }

    .preorder-card .search-form {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .preorder-card .filter-date-input {
        height: 36px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: 0 10px;
        font-size: 0.82rem;
        color: #0f172a;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .preorder-card .filter-date-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background-color: #fff;
    }

    .preorder-card .btn-search {
        height: 36px;
        padding: 0 14px;
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.15s;
    }

    .preorder-card .btn-search:hover { background: #1d4ed8; }

    .preorder-card .btn-reset {
        height: 36px;
        padding: 0 14px;
        background: #f1f5f9;
        color: #475569;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background 0.15s;
    }

    .preorder-card .btn-reset:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .preorder-card .btn-add {
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

    .preorder-card .btn-add:hover { background: #1d4ed8; color: #fff; text-decoration: none; }

    /* Table */
    .preorder-table {
        width: 100%;
        border-collapse: collapse;
    }

    .preorder-table thead th {
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

    .preorder-table tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.1s;
    }

    .preorder-table tbody tr:hover { background: #fafbfd; }
    .preorder-table tbody tr:last-child { border-bottom: none; }

    .preorder-table tbody td {
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

    .pr-btn-action.view    { background: #e0f2fe; color: #0369a1; }
    .pr-btn-action.view:hover   { background: #bae6fd; }

    .pr-btn-action.approve { background: #dcfce7; color: #15803d; }
    .pr-btn-action.approve:hover { background: #bbf7d0; }

    .pr-btn-action.reject  { background: #fff1f2; color: #e11d48; }
    .pr-btn-action.reject:hover  { background: #fee2e2; }

    .pr-btn-action.delete  { background: #fff1f2; color: #e11d48; }
    .pr-btn-action.delete:hover  { background: #fee2e2; }

    /* Empty state */
    .preorder-empty {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .preorder-empty i { font-size: 2.5rem; margin-bottom: 12px; opacity: 0.5; }
    .preorder-empty p { margin: 0; font-size: 0.875rem; }

    .row-num { color: #94a3b8; font-size: 0.8rem; }

    /* Active filter badge */
    .filter-active-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
    }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card preorder-card"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- Card header -->
                <div class="card-header-custom">
                    <div class="card-header-left">
                        <h5 class="page-title">Daftar Permintaan Barang</h5>
                        <?php if (isset($totalPermintaan)): ?>
                            <span class="count-badge"><?= $totalPermintaan ?> Permintaan</span>
                        <?php endif ?>
                    </div>
                    <div class="d-flex align-items-center" style="gap:10px; flex-wrap:wrap;">
                        <form action="<?= base_url('preorder/filter_date') ?>" method="POST" class="search-form">
                            <input type="date" name="filter_date" class="filter-date-input"
                                value="<?= isset($filter_date) && $filter_date ? date('Y-m-d', strtotime($filter_date)) : '' ?>">
                            <button type="submit" class="btn-search">
                                <i class="fas fa-search" style="font-size:0.75rem; margin-right:4px;"></i> Filter
                            </button>
                        </form>
                        <?php if (isset($filter_date) && $filter_date): ?>
                            <span class="filter-active-badge">
                                <i class="fas fa-calendar-check" style="font-size:0.7rem;"></i>
                                <?= date('d M Y', strtotime($filter_date)) ?>
                            </span>
                            <a href="<?= base_url('preorder/reset_filter') ?>" class="btn-reset">
                                <i class="fas fa-times" style="font-size:0.7rem; margin-right:5px;"></i> Reset
                            </a>
                        <?php endif ?>
                        <?php if ($this->session->userdata('role') == 'staff'): ?>
                            <a href="<?= base_url('preorder/create') ?>" class="btn-add">
                                <i class="fas fa-plus" style="font-size:0.75rem;"></i> Buat Permintaan
                            </a>
                        <?php endif ?>
                    </div>
                </div>

                <!-- Table -->
                <?php if (empty($permintaans)): ?>
                    <div class="preorder-empty">
                        <div><i class="fas fa-clipboard-list"></i></div>
                        <p>Belum ada data permintaan barang.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="preorder-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Permintaan</th>
                                    <th>Dari Gudang</th>
                                    <th>Gudang Tujuan</th>
                                    <th>Tgl Permintaan</th>
                                    <th>Pemohon</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $idxRole      = $this->session->userdata('role');
                                $idxUserGudang = $this->session->userdata('id_gudang');
                                $idxUserId    = $this->session->userdata('id_user');
                                $no = ($currentPage - 1) * 10 + 1;
                                foreach ($permintaans as $p):
                                    $rowIsSourceAdmin = ($idxRole == 'admin') || ($idxRole == 'staff' && $idxUserGudang == $p->id_gudang_asal);
                                    $rowCanDelete     = ($idxRole == 'admin') || ($p->id_user == $idxUserId && $p->status == 'menunggu');
                                ?>
                                    <tr>
                                        <td class="row-num"><?= $no++ ?></td>
                                        <td><span class="kode-pill"><?= htmlspecialchars($p->kode_permintaan) ?></span></td>
                                        <td><?= htmlspecialchars($p->nama_gudang_asal ?? '-') ?></td>
                                        <td><?= htmlspecialchars($p->nama_gudang_tujuan ?? '-') ?></td>
                                        <td><?= date('d M Y', strtotime($p->tanggal_permintaan)) ?></td>
                                        <td><?= htmlspecialchars($p->nama_user ?? '-') ?></td>
                                        <td class="text-center">
                                            <span class="pr-badge <?= $p->status ?>">
                                                <span class="dot"></span>
                                                <?php
                                                $statusLabels = [
                                                    'menunggu'      => 'Menunggu',
                                                    'disetujui'     => 'Disetujui',
                                                    'ditolak'       => 'Ditolak',
                                                    'surat_jalan'   => 'Surat Jalan',
                                                    'dikirim'       => 'Dikirim',
                                                    'selesai'       => 'Selesai',
                                                    'belum_selesai' => 'Belum Selesai',
                                                ];
                                                echo $statusLabels[$p->status] ?? $p->status;
                                                ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div style="display:flex; gap:6px; justify-content:center;">
                                                <a href="<?= base_url('preorder/detail/' . $p->id) ?>"
                                                    class="pr-btn-action view" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($rowIsSourceAdmin && $p->status == 'menunggu'): ?>
                                                    <form action="<?= base_url('preorder/approve/' . $p->id) ?>" method="POST"
                                                        style="display:inline;" onsubmit="return confirm('Setujui permintaan ini?')">
                                                        <button type="submit" class="pr-btn-action approve" title="Setujui">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="pr-btn-action reject"
                                                        data-toggle="modal" data-target="#rejectModal<?= $p->id ?>" title="Tolak">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                <?php endif ?>
                                                <?php if ($rowCanDelete): ?>
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
                <?php if (!empty($permintaans) && $totalPermintaan > 10): ?>
                    <?php $totalPages = ceil($totalPermintaan / 10); ?>
                    <div class="wms-pag-footer">
                        <nav aria-label="Navigasi halaman">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= base_url('preorder?page=' . ($currentPage - 1)) ?>">&laquo;</a>
                                </li>
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= base_url('preorder?page=' . $i) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor ?>
                                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= base_url('preorder?page=' . ($currentPage + 1)) ?>">&raquo;</a>
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
<?php
$idxRole       = $this->session->userdata('role');
$idxUserGudang = $this->session->userdata('id_gudang');
$idxUserId     = $this->session->userdata('id_user');
foreach ($permintaans as $p):
    $rowIsSourceAdmin = ($idxRole == 'admin') || ($idxRole == 'staff' && $idxUserGudang == $p->id_gudang_asal);
    $rowCanDelete     = ($idxRole == 'admin') || ($p->id_user == $idxUserId && $p->status == 'menunggu');
?>

    <?php if ($rowIsSourceAdmin && $p->status == 'menunggu'): ?>
    <!-- Modal Tolak -->
    <div class="modal fade" id="rejectModal<?= $p->id ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius:12px; border:none; box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                <form action="<?= base_url('preorder/reject/' . $p->id) ?>" method="POST">
                    <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:20px 24px 16px;">
                        <h5 class="modal-title" style="font-size:0.95rem; font-weight:600; color:#0f172a;">Tolak Permintaan</h5>
                        <button type="button" class="close" data-dismiss="modal" style="color:#94a3b8;"><span>&times;</span></button>
                    </div>
                    <div class="modal-body" style="padding:20px 24px;">
                        <p style="font-size:0.875rem; color:#374151; margin-bottom:12px;">
                            Tolak permintaan <strong><?= htmlspecialchars($p->kode_permintaan) ?></strong>?
                        </p>
                        <div class="form-group mb-0">
                            <label style="font-size:0.82rem; font-weight:500; color:#374151;">Alasan Penolakan</label>
                            <textarea name="alasan_tolak" class="form-control" rows="3"
                                placeholder="Masukkan alasan penolakan..."
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
    <?php endif ?>

    <?php if ($rowCanDelete): ?>
    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteModal<?= $p->id ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius:12px; border:none; box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:20px 24px 16px;">
                    <h5 class="modal-title" style="font-size:0.95rem; font-weight:600; color:#0f172a;">Hapus Permintaan</h5>
                    <button type="button" class="close" data-dismiss="modal" style="color:#94a3b8;"><span>&times;</span></button>
                </div>
                <div class="modal-body" style="padding:20px 24px;">
                    <p style="font-size:0.875rem; color:#374151; margin-bottom:8px;">
                        Hapus permintaan <strong><?= htmlspecialchars($p->kode_permintaan) ?></strong>?
                    </p>
                    <p style="font-size:0.8rem; color:#ef4444; margin:0;">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:16px 24px;">
                    <form action="<?= base_url('preorder/delete/' . $p->id) ?>" method="POST" style="display:inline;">
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
