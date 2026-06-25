<style>
    /* ── Stat cards ── */
    .db-stat-card {
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        text-decoration: none;
        transition: box-shadow 0.15s, transform 0.1s;
        background: #fff;
    }

    .db-stat-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        transform: translateY(-1px);
        text-decoration: none;
    }

    .db-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    .db-stat-icon.blue   { background: #eff6ff; color: #2563eb; }
    .db-stat-icon.green  { background: #f0fdf4; color: #16a34a; }
    .db-stat-icon.sky    { background: #f0f9ff; color: #0284c7; }
    .db-stat-icon.amber  { background: #fffbeb; color: #d97706; }
    .db-stat-icon.orange { background: #fff7ed; color: #ea580c; }
    .db-stat-icon.red    { background: #fff1f2; color: #e11d48; }
    .db-stat-icon.violet { background: #f5f3ff; color: #7c3aed; }
    .db-stat-icon.slate  { background: #f8fafc; color: #475569; }

    .db-stat-label {
        font-size: 0.72rem;
        font-weight: 500;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0 0 4px;
    }

    .db-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        line-height: 1;
    }

    /* ── Table cards ── */
    .db-table-card {
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .db-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px 14px;
        border-bottom: 1px solid #f1f5f9;
    }

    .db-table-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }

    .db-view-all {
        font-size: 0.78rem;
        color: #2563eb;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 12px;
        border-radius: 7px;
        background: #eff6ff;
        transition: background 0.15s;
    }

    .db-view-all:hover { background: #dbeafe; text-decoration: none; color: #1d4ed8; }

    .db-table {
        width: 100%;
        border-collapse: collapse;
    }

    .db-table thead th {
        font-size: 0.7rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #94a3b8;
        padding: 9px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .db-table tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.1s;
    }

    .db-table tbody tr:hover { background: #fafbfd; }
    .db-table tbody tr:last-child { border-bottom: none; }

    .db-table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        font-size: 0.83rem;
        color: #374151;
    }

    .db-table tfoot td {
        padding: 10px 16px;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
    }

    /* code/kode badge */
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

    /* Status badges */
    .db-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.72rem;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .db-badge .dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

    .db-badge.menunggu       { background: #fef9c3; color: #854d0e; }
    .db-badge.menunggu .dot  { background: #ca8a04; }

    .db-badge.disetujui      { background: #e0f2fe; color: #0369a1; }
    .db-badge.disetujui .dot { background: #0284c7; }

    .db-badge.surat_jalan      { background: #eff6ff; color: #2563eb; }
    .db-badge.surat_jalan .dot { background: #2563eb; }

    .db-badge.dikirim      { background: #fff7ed; color: #ea580c; }
    .db-badge.dikirim .dot { background: #ea580c; }

    .db-badge.selesai      { background: #dcfce7; color: #15803d; }
    .db-badge.selesai .dot { background: #16a34a; }

    .db-badge.belum_selesai      { background: #f1f5f9; color: #475569; }
    .db-badge.belum_selesai .dot { background: #64748b; }

    .db-badge.ditolak      { background: #fee2e2; color: #dc2626; }
    .db-badge.ditolak .dot { background: #dc2626; }

    .db-badge.sampai      { background: #dcfce7; color: #15803d; }
    .db-badge.sampai .dot { background: #16a34a; }

    /* Empty state inside table */
    .db-table-empty {
        text-align: center;
        padding: 36px 20px;
        color: #cbd5e1;
    }

    .db-table-empty i { font-size: 1.6rem; margin-bottom: 8px; }
    .db-table-empty p { margin: 0; font-size: 0.82rem; }

    /* Pagination container — extends .wms-pag-footer from theme.css */
    .db-pagination {
        justify-content: space-between;
    }

    .row-num { color: #94a3b8; font-size: 0.78rem; }

    .stat-row { margin-left: -6px; margin-right: -6px; }
    .stat-row > [class*="col-"] { padding-left: 6px; padding-right: 6px; }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <!-- ── Stat Cards Row 1 ── -->
    <div class="row stat-row mb-2">
        <?php if ($this->session->userdata('role') == 'admin'): ?>
        <div class="col-12 col-md-4 mb-2">
            <a href="<?= base_url('users') ?>" class="db-stat-card">
                <div class="db-stat-icon blue"><i class="fas fa-users"></i></div>
                <div>
                    <p class="db-stat-label">Staff</p>
                    <p class="db-stat-value"><?= $jumlah_staff ?></p>
                </div>
            </a>
        </div>
        <?php endif ?>
        <div class="col-12 col-md-4 mb-2">
            <a href="<?= base_url('items') ?>" class="db-stat-card">
                <div class="db-stat-icon violet"><i class="fas fa-boxes"></i></div>
                <div>
                    <p class="db-stat-label">Total Barang</p>
                    <p class="db-stat-value"><?= $total_barang ?></p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4 mb-2">
            <a href="<?= base_url('warehouses') ?>" class="db-stat-card">
                <div class="db-stat-icon sky"><i class="fas fa-warehouse"></i></div>
                <div>
                    <p class="db-stat-label">Gudang</p>
                    <p class="db-stat-value"><?= $jumlah_gudang ?></p>
                </div>
            </a>
        </div>
    </div>

    <!-- ── Stat Cards Row 2 (role-conditional) ── -->
    <?php if ($this->session->userdata('role') === 'purchasing_admin'): ?>
        <div class="row stat-row mb-2">
            <div class="col-12 col-md-3 mb-2">
                <a href="<?= base_url('purchaserequest') ?>" class="db-stat-card">
                    <div class="db-stat-icon amber"><i class="fas fa-clock"></i></div>
                    <div>
                        <p class="db-stat-label">PR Menunggu</p>
                        <p class="db-stat-value"><?= $pr_menunggu ?></p>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-3 mb-2">
                <a href="<?= base_url('purchaserequest') ?>" class="db-stat-card">
                    <div class="db-stat-icon sky"><i class="fas fa-check"></i></div>
                    <div>
                        <p class="db-stat-label">PR Disetujui</p>
                        <p class="db-stat-value"><?= $pr_disetujui ?></p>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-3 mb-2">
                <a href="<?= base_url('purchaserequest') ?>" class="db-stat-card">
                    <div class="db-stat-icon green"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <p class="db-stat-label">PR Selesai</p>
                        <p class="db-stat-value"><?= $pr_selesai ?></p>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-3 mb-2">
                <a href="<?= base_url('purchaserequest') ?>" class="db-stat-card">
                    <div class="db-stat-icon slate"><i class="fas fa-exclamation-triangle"></i></div>
                    <div>
                        <p class="db-stat-label">PR Belum Selesai</p>
                        <p class="db-stat-value"><?= $pr_belum_selesai ?></p>
                    </div>
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row stat-row mb-2">
            <div class="col-12 col-md-6 mb-2">
                <a href="<?= base_url('items') ?>" class="db-stat-card">
                    <div class="db-stat-icon blue"><i class="fas fa-box-open"></i></div>
                    <div>
                        <p class="db-stat-label">Barang Tersedia</p>
                        <p class="db-stat-value"><?= $jumlah_barang ?></p>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-6 mb-2">
                <a href="<?= base_url('items') ?>" class="db-stat-card">
                    <div class="db-stat-icon amber"><i class="fas fa-cubes"></i></div>
                    <div>
                        <p class="db-stat-label">Total Stok</p>
                        <p class="db-stat-value"><?= number_format($jumlah_stok) ?></p>
                    </div>
                </a>
            </div>
        </div>
    <?php endif ?>

    <!-- ── Tables ── -->
    <?php if ($this->session->userdata('role') === 'purchasing_admin'): ?>

        <!-- PR Terbaru -->
        <div class="row mb-4">
            <div class="col-12 col-md-8">
                <div class="db-table-card">
                    <div class="db-table-header">
                        <h5 class="db-table-title"><i class="fas fa-file-invoice" style="color:#2563eb; margin-right:8px;"></i>Purchase Request Terbaru</h5>
                        <a href="<?= base_url('purchaserequest') ?>" class="db-view-all">
                            Lihat Semua <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="db-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal PR</th>
                                    <th>Gudang</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($newest_prs)): ?>
                                    <tr>
                                        <td colspan="5">
                                            <div class="db-table-empty">
                                                <div><i class="fas fa-inbox"></i></div>
                                                <p>Belum ada Purchase Request</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php
                                    $prLabels = [
                                        'menunggu'      => 'Menunggu',
                                        'disetujui'     => 'Disetujui',
                                        'ditolak'       => 'Ditolak',
                                        'belum_selesai' => 'Belum Selesai',
                                        'selesai'       => 'Selesai',
                                    ];
                                    $no = 1;
                                    foreach ($newest_prs as $pr):
                                        $prStatus = $pr->status;
                                        $prLabel  = $prLabels[$prStatus] ?? $prStatus;
                                    ?>
                                        <tr>
                                            <td class="row-num"><?= $no++ ?></td>
                                            <td><?= date('d M Y', strtotime($pr->tanggal_pr)) ?></td>
                                            <td><?= htmlspecialchars($pr->nama_gudang ?? '-') ?></td>
                                            <td class="text-center">
                                                <span class="db-badge <?= $prStatus ?>">
                                                    <span class="dot"></span><?= $prLabel ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('purchaserequest/detail/' . $pr->id) ?>"
                                                    style="color:#2563eb; font-size:0.85rem;">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>

        <!-- Permintaan Aktif -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="db-table-card">
                    <div class="db-table-header">
                        <h5 class="db-table-title"><i class="fas fa-clipboard-list" style="color:#2563eb; margin-right:8px;"></i>Daftar Permintaan Aktif</h5>
                        <a href="<?= base_url('preorder') ?>" class="db-view-all">
                            Lihat Semua <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="db-table" id="tblPermintaanAktif">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Dari Gudang</th>
                                    <th>Gudang Tujuan</th>
                                    <th>Tanggal</th>
                                    <th>Pemohon</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($dashboard_permintaan_aktif)): ?>
                                    <tr>
                                        <td colspan="7">
                                            <div class="db-table-empty">
                                                <div><i class="fas fa-inbox"></i></div>
                                                <p>Tidak ada permintaan aktif</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php
                                    $aktifLabels = [
                                        'menunggu'    => 'Menunggu',
                                        'disetujui'   => 'Disetujui',
                                        'surat_jalan' => 'Surat Jalan',
                                        'dikirim'     => 'Dikirim',
                                    ];
                                    $no = 1;
                                    foreach ($dashboard_permintaan_aktif as $p):
                                        $st = $p->status;
                                        $lbl = $aktifLabels[$st] ?? $st;
                                    ?>
                                        <tr>
                                            <td class="row-num"><?= $no++ ?></td>
                                            <td><span class="kode-pill"><?= $p->kode_permintaan ?></span></td>
                                            <td><?= htmlspecialchars($p->nama_gudang_asal ?? '-') ?></td>
                                            <td><?= htmlspecialchars($p->nama_gudang_tujuan ?? '-') ?></td>
                                            <td><?= date('d M Y', strtotime($p->tanggal_permintaan)) ?></td>
                                            <td><?= htmlspecialchars($p->nama_user ?? '-') ?></td>
                                            <td class="text-center">
                                                <span class="db-badge <?= $st ?>">
                                                    <span class="dot"></span><?= $lbl ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="db-pagination" id="paginationPermintaanAktif"></div>
                </div>
            </div>
        </div>

        <!-- Riwayat Permintaan -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="db-table-card">
                    <div class="db-table-header">
                        <h5 class="db-table-title"><i class="fas fa-history" style="color:#7c3aed; margin-right:8px;"></i>Riwayat Permintaan</h5>
                        <a href="<?= base_url('preorder') ?>" class="db-view-all">
                            Lihat Semua <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="db-table" id="tblRiwayatPermintaan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Dari Gudang</th>
                                    <th>Gudang Tujuan</th>
                                    <th>Tanggal</th>
                                    <th>Pemohon</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($dashboard_riwayat_permintaan)): ?>
                                    <tr>
                                        <td colspan="7">
                                            <div class="db-table-empty">
                                                <div><i class="fas fa-inbox"></i></div>
                                                <p>Belum ada riwayat permintaan</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php
                                    $riwayatLabels = [
                                        'selesai'       => 'Selesai',
                                        'belum_selesai' => 'Belum Selesai',
                                        'ditolak'       => 'Ditolak',
                                    ];
                                    $no = 1;
                                    foreach ($dashboard_riwayat_permintaan as $p):
                                        $st = $p->status;
                                        $lbl = $riwayatLabels[$st] ?? $st;
                                    ?>
                                        <tr>
                                            <td class="row-num"><?= $no++ ?></td>
                                            <td><span class="kode-pill"><?= $p->kode_permintaan ?></span></td>
                                            <td><?= htmlspecialchars($p->nama_gudang_asal ?? '-') ?></td>
                                            <td><?= htmlspecialchars($p->nama_gudang_tujuan ?? '-') ?></td>
                                            <td><?= date('d M Y', strtotime($p->tanggal_permintaan)) ?></td>
                                            <td><?= htmlspecialchars($p->nama_user ?? '-') ?></td>
                                            <td class="text-center">
                                                <span class="db-badge <?= $st ?>">
                                                    <span class="dot"></span><?= $lbl ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="db-pagination" id="paginationRiwayatPermintaan"></div>
                </div>
            </div>
        </div>

    <?php endif ?>
</div>

<!-- Client-side table pagination -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    function initPagination(tableId, pagId, perPage) {
        var table = document.getElementById(tableId);
        var pagEl = document.getElementById(pagId);
        if (!table || !pagEl) return;
        var tbody = table.querySelector('tbody');
        if (!tbody) return;
        var rows = Array.from(tbody.querySelectorAll('tr'));
        if (rows.length <= 1 && rows[0] && rows[0].querySelector('td[colspan]')) return;
        var total = rows.length;
        var pages = Math.ceil(total / perPage);
        var cur = 1;

        function show(p) {
            cur = p;
            var s = (p - 1) * perPage, e = s + perPage;
            rows.forEach(function (r, i) { r.style.display = (i >= s && i < e) ? '' : 'none'; });
            render();
        }

        function render() {
            if (pages <= 1) { pagEl.innerHTML = ''; pagEl.style.display = 'none'; return; }
            pagEl.style.display = '';
            var s = (cur - 1) * perPage + 1, e = Math.min(cur * perPage, total);
            var h = '<div class="wms-pag-split d-flex p-3 align-items-center flex-wrap" style="gap:8px;">';
            h += '<small style="font-size:0.78rem; color:#94a3b8;">Menampilkan <strong style="color:#374151;">' + s + '–' + e + '</strong> dari <strong style="color:#374151;">' + total + '</strong></small>';
            h += '<nav><ul class="pagination pagination-sm mb-0">';
            h += '<li class="page-item' + (cur === 1 ? ' disabled' : '') + '"><a class="page-link" href="#" data-p="' + (cur - 1) + '">&laquo;</a></li>';
            for (var i = 1; i <= pages; i++) {
                h += '<li class="page-item' + (i === cur ? ' active' : '') + '"><a class="page-link" href="#" data-p="' + i + '">' + i + '</a></li>';
            }
            h += '<li class="page-item' + (cur === pages ? ' disabled' : '') + '"><a class="page-link" href="#" data-p="' + (cur + 1) + '">&raquo;</a></li>';
            h += '</ul></nav></div>';
            pagEl.innerHTML = h;
            pagEl.querySelectorAll('a.page-link[data-p]').forEach(function (a) {
                a.addEventListener('click', function (ev) {
                    ev.preventDefault();
                    var pg = parseInt(this.getAttribute('data-p'));
                    if (pg >= 1 && pg <= pages) show(pg);
                });
            });
        }
        show(1);
    }

    initPagination('tblPermintaanAktif',    'paginationPermintaanAktif',    5);
    initPagination('tblRiwayatPermintaan',   'paginationRiwayatPermintaan',  5);
});
</script>
