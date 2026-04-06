<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <!-- Date Filter -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body py-3">
                    <form action="<?= base_url('home/filter_date') ?>" method="POST"
                        class="d-flex align-items-center flex-wrap">
                        <label class="font-weight-semibold mb-0 mr-3"><i class="fas fa-filter mr-1"></i> Filter
                            Tanggal:</label>
                        <input type="date" name="dashboard_date" class="form-control mr-2" style="max-width: 220px;"
                            value="<?= !empty($filter_date) ? date('Y-m-d', strtotime($filter_date)) : '' ?>">
                        <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search"></i> Filter</button>
                        <?php if (!empty($filter_date)): ?>
                            <a href="<?= base_url('home/reset_filter') ?>" class="btn btn-secondary mr-3"><i
                                    class="fas fa-times"></i> Reset</a>
                            <span class="badge badge-info py-2 px-3 font-weight-normal" style="font-size: 0.9rem;">
                                <i class="fas fa-calendar-check mr-1"></i> Menampilkan data tanggal:
                                <?= date('d-m-Y', strtotime($filter_date)) ?>
                            </span>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Card Row 1 -->
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="card border-left-primary shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium"><?= $jumlah_staff ?></h2>
                            <a href="<?= base_url('users') ?>">
                                <h5 class="text-muted font-weight-normal mb-0">Staff</h5>
                            </a>
                        </div>
                        <div class="ml-auto">
                            <span class="text-primary"><i class="fas fa-users fa-2x"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-left-success shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium"><?= $total_barang ?></h2>
                            <a href="<?= base_url('items') ?>">
                                <h5 class="text-muted font-weight-normal mb-0">Total Barang</h5>
                            </a>
                        </div>
                        <div class="ml-auto">
                            <span class="text-success"><i class="fas fa-boxes fa-2x"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-left-info shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium"><?= $jumlah_gudang ?></h2>
                            <a href="<?= base_url('warehouses') ?>">
                                <h5 class="text-muted font-weight-normal mb-0">Gudang</h5>
                            </a>
                        </div>
                        <div class="ml-auto">
                            <span class="text-info"><i class="fas fa-warehouse fa-2x"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-left-warning shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium"><?= number_format($jumlah_stok) ?></h2>
                            <a href="<?= base_url('items') ?>">
                                <h5 class="text-muted font-weight-normal mb-0">Total Stok</h5>
                            </a>
                        </div>
                        <div class="ml-auto">
                            <span class="text-warning"><i class="fas fa-cubes fa-2x"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Card Row 2 - Barang Masuk & Keluar -->
    <div class="row">
        <div class="col-md-6 col-lg-4">
            <div class="card bg-success text-white shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-white mb-1 font-weight-medium"><?= $jumlah_barang_masuk ?></h2>
                            <a href="<?= base_url('inputs') ?>" class="text-white">
                                <h5 class="text-white font-weight-normal mb-0">
                                    Barang
                                    Masuk<?= !empty($filter_date) ? ' (' . date('d/m/Y', strtotime($filter_date)) . ')' : '' ?>
                                </h5>
                            </a>
                        </div>
                        <div class="ml-auto">
                            <i class="fas fa-arrow-down fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card bg-danger text-white shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-white mb-1 font-weight-medium"><?= $jumlah_barang_keluar ?></h2>
                            <a href="<?= base_url('outputs') ?>" class="text-white">
                                <h5 class="text-white font-weight-normal mb-0">
                                    Barang
                                    Keluar<?= !empty($filter_date) ? ' (' . date('d/m/Y', strtotime($filter_date)) . ')' : '' ?>
                                </h5>
                            </a>
                        </div>
                        <div class="ml-auto">
                            <i class="fas fa-arrow-up fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-4">
            <div class="card bg-primary text-white shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-white mb-1 font-weight-medium"><?= $jumlah_barang ?></h2>
                            <a href="<?= base_url('items') ?>" class="text-white">
                                <h5 class="text-white font-weight-normal mb-0">Barang Tersedia (Stok > 0)</h5>
                            </a>
                        </div>
                        <div class="ml-auto">
                            <i class="fas fa-box-open fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Statistik -->
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4">Grafik Total Data (Bar Chart)</h4>
                    <canvas id="barChart" height="180"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4">Distribusi Data (Pie Chart)</h4>
                    <div style="position: relative; min-height: 280px;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Permintaan Aktif -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark      d-flex justify-content-between align-items-center">
                    <h5 class="text-white mb-0">
                        <i class="fas fa-clipboard-list mr-2"></i> Daftar Permintaan
                    </h5>
                    <a href="<?= base_url('preorder') ?>" class="btn btn-light btn-sm">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered mb-0" id="tblPermintaanAktif">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="14%">Kode Permintaan</th>
                                    <th width="14%">Dari Gudang</th>
                                    <th width="14%">Gudang Tujuan</th>
                                    <th width="12%">Tgl Permintaan</th>
                                    <th width="12%">Diperlukan</th>
                                    <th width="13%">Pemohon</th>
                                    <th width="16%" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($dashboard_permintaan_aktif)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                            Tidak ada permintaan aktif
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($dashboard_permintaan_aktif as $p): ?>
                                        <?php
                                        $statusConfig = [
                                            'menunggu' => ['badge' => 'badge-secondary', 'icon' => 'fas fa-clock', 'label' => 'Menunggu'],
                                            'disetujui' => ['badge' => 'badge-info', 'icon' => 'fas fa-check', 'label' => 'Disetujui'],
                                            'surat_jalan' => ['badge' => 'badge-primary', 'icon' => 'fas fa-file-alt', 'label' => 'Surat Jalan'],
                                            'dikirim' => ['badge' => 'badge-warning', 'icon' => 'fas fa-shipping-fast', 'label' => 'Dikirim'],
                                        ];
                                        $sc = $statusConfig[$p->status] ?? ['badge' => 'badge-secondary', 'icon' => 'fas fa-question', 'label' => $p->status];
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><strong><?= $p->kode_permintaan ?></strong></td>
                                            <td><?= $p->nama_gudang_asal ?? '-' ?></td>
                                            <td><?= $p->nama_gudang_tujuan ?? '-' ?></td>
                                            <td><?= date('d M Y', strtotime($p->tanggal_permintaan)) ?></td>
                                            <td><?= date('d M Y', strtotime($p->tanggal_diperlukan)) ?></td>
                                            <td><?= $p->nama_user ?? '-' ?></td>
                                            <td class="text-center">
                                                <span class="badge <?= $sc['badge'] ?>">
                                                    <i class="<?= $sc['icon'] ?> mr-1"></i><?= $sc['label'] ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-2" id="paginationPermintaanAktif"></div>
            </div>
        </div>
    </div>

    <!-- Riwayat Permintaan -->
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h5 class="text-white mb-0">
                        <i class="fas fa-history mr-2"></i> Riwayat Permintaan
                    </h5>
                    <a href="<?= base_url('preorder') ?>" class="btn btn-light btn-sm">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered mb-0" id="tblRiwayatPermintaan">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="14%">Kode Permintaan</th>
                                    <th width="14%">Dari Gudang</th>
                                    <th width="14%">Gudang Tujuan</th>
                                    <th width="12%">Tgl Permintaan</th>
                                    <th width="12%">Diperlukan</th>
                                    <th width="13%">Pemohon</th>
                                    <th width="16%" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($dashboard_riwayat_permintaan)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                            Belum ada riwayat permintaan
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($dashboard_riwayat_permintaan as $p): ?>
                                        <?php
                                        $statusConfig = [
                                            'selesai' => ['badge' => 'badge-success', 'icon' => 'fas fa-check-circle', 'label' => 'Selesai'],
                                            'belum_selesai' => ['badge' => 'badge-dark', 'icon' => 'fas fa-exclamation-triangle', 'label' => 'Belum Selesai'],
                                            'ditolak' => ['badge' => 'badge-danger', 'icon' => 'fas fa-times', 'label' => 'Ditolak'],
                                        ];
                                        $sc = $statusConfig[$p->status] ?? ['badge' => 'badge-secondary', 'icon' => 'fas fa-question', 'label' => $p->status];
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><strong><?= $p->kode_permintaan ?></strong></td>
                                            <td><?= $p->nama_gudang_asal ?? '-' ?></td>
                                            <td><?= $p->nama_gudang_tujuan ?? '-' ?></td>
                                            <td><?= date('d M Y', strtotime($p->tanggal_permintaan)) ?></td>
                                            <td><?= date('d M Y', strtotime($p->tanggal_diperlukan)) ?></td>
                                            <td><?= $p->nama_user ?? '-' ?></td>
                                            <td class="text-center">
                                                <span class="badge <?= $sc['badge'] ?>">
                                                    <i class="<?= $sc['icon'] ?> mr-1"></i><?= $sc['label'] ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-2" id="paginationRiwayatPermintaan"></div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pemindahan Barang -->
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h5 class="text-white mb-0">
                        <i class="fas fa-exchange-alt mr-2"></i> Riwayat Pemindahan Barang
                    </h5>
                    <a href="<?= base_url('transfer') ?>" class="btn btn-light btn-sm">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered mb-0" id="tblRiwayatTransfer">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="18%">Kode Pemindahan</th>
                                    <th width="18%">Gudang Asal</th>
                                    <th width="18%">Gudang Tujuan</th>
                                    <th width="16%">Waktu</th>
                                    <th width="12%">User</th>
                                    <th width="13%" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($dashboard_transfers)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                            Belum ada data pemindahan barang
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($dashboard_transfers as $transfer): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><strong><?= $transfer->kode_transfer ?></strong></td>
                                            <td><?= $transfer->nama_gudang_asal ?? '-' ?></td>
                                            <td><?= $transfer->nama_gudang_tujuan ?? '-' ?></td>
                                            <td><?= date('d M Y H:i', strtotime($transfer->waktu)) ?></td>
                                            <td><?= $transfer->nama_user ?? '-' ?></td>
                                            <td class="text-center">
                                                <?php if ($transfer->status == 'sampai'): ?>
                                                    <span class="badge badge-success"><i
                                                            class="fas fa-check-circle mr-1"></i>Sampai</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning"><i
                                                            class="fas fa-shipping-fast mr-1"></i>Dikirim</span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-2" id="paginationRiwayatTransfer"></div>
            </div>
        </div>
    </div>

</div>

<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

<!-- Client-side Table Pagination -->
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
                if (pages <= 1) { pagEl.innerHTML = ''; return; }
                var s = (cur - 1) * perPage + 1, e = Math.min(cur * perPage, total);
                var h = '<div class="d-flex align-items-center justify-content-between flex-wrap">';
                h += '<small class="text-muted">Menampilkan <strong>' + s + '\u2013' + e + '</strong> dari <strong>' + total + '</strong> data</small>';
                h += '<nav><ul class="pagination pagination-sm mb-0">';
                h += '<li class="page-item' + (cur === 1 ? ' disabled' : '') + '"><a class="page-link" href="#" data-p="' + (cur - 1) + '">&laquo;</a></li>';
                for (var i = 1; i <= pages; i++) h += '<li class="page-item' + (i === cur ? ' active' : '') + '"><a class="page-link" href="#" data-p="' + i + '">' + i + '</a></li>';
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
        initPagination('tblPermintaanAktif', 'paginationPermintaanAktif', 5);
        initPagination('tblRiwayatPermintaan', 'paginationRiwayatPermintaan', 5);
        initPagination('tblRiwayatTransfer', 'paginationRiwayatTransfer', 5);
    });
</script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const staff = <?= $jumlah_staff ?>;
        const barang = <?= $total_barang ?>;
        const gudang = <?= $jumlah_gudang ?>;
        const stok = <?= $jumlah_stok ?>;
        const barangMasuk = <?= $jumlah_barang_masuk ?>;
        const barangKeluar = <?= $jumlah_barang_keluar ?>;

        // Bar Chart
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Staff', 'Barang', 'Gudang', 'Stok', 'Masuk', 'Keluar'],
                datasets: [{
                    label: 'Jumlah',
                    data: [staff, barang, gudang, stok, barangMasuk, barangKeluar],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(40, 167, 69, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Total Data Gudang' }
                },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Pie Chart
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Staff', 'Barang', 'Gudang', 'Masuk', 'Keluar'],
                datasets: [{
                    data: [staff, barang, gudang, barangMasuk, barangKeluar],
                    backgroundColor: [
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#28a745',
                        '#dc3545'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: { display: true, text: 'Distribusi Data Gudang' },
                    legend: {
                        position: 'bottom',
                        labels: { padding: 16, boxWidth: 14 }
                    }
                }
            }
        });
    });
</script>