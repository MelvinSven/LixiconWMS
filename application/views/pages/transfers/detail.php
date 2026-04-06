<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">
                        <i data-feather="file-text" class="feather-sm me-2"></i>
                        Detail Transfer
                    </h4>
                    <a href="<?= base_url('transfer') ?>" class="btn btn-secondary">
                        <i data-feather="arrow-left" class="feather-sm me-1"></i> Kembali
                    </a>
                </div>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success') ?>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                    </div>
                <?php endif; ?>

                <!-- Info Transfer -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    <i data-feather="hash" class="feather-sm me-1"></i>
                                    <?= $transfer->kode_transfer ?>
                                </h5>
                                <hr>
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td width="40%"><strong>Waktu Transfer</strong></td>
                                        <td>: <?= date('d F Y H:i', strtotime($transfer->waktu)) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diproses Oleh</strong></td>
                                        <td>: <?= $transfer->nama_user ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>:
                                            <?php if ($transfer->status == 'sampai'): ?>
                                                <span class="badge badge-success"><i
                                                        class="fas fa-check-circle mr-1"></i>Sampai</span>
                                            <?php else: ?>
                                                <span class="badge badge-warning"><i
                                                        class="fas fa-shipping-fast mr-1"></i>Dikirim</span>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <?php if (!empty($transfer->nama_kurir)): ?>
                                        <tr>
                                            <td><strong>Nama Kurir</strong></td>
                                            <td>: <i class="fas fa-truck mr-1"></i><?= $transfer->nama_kurir ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if (!empty($transfer->keterangan)): ?>
                                        <tr>
                                            <td><strong>Keterangan</strong></td>
                                            <td>: <?= $transfer->keterangan ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="text-center p-3 bg-light rounded">
                                            <i data-feather="log-out" class="text-primary mb-2"
                                                style="width: 32px; height: 32px;"></i>
                                            <h6 class="text-muted mb-1">Gudang Asal</h6>
                                            <strong class="text-dark"><?= $transfer->nama_gudang_asal ?? '-' ?></strong>
                                        </div>
                                    </div>
                                    <div class="col-2 d-flex align-items-center justify-content-center">
                                        <i data-feather="arrow-right" class="text-success"
                                            style="width: 32px; height: 32px;"></i>
                                    </div>
                                    <div class="col-5">
                                        <div class="text-center p-3 bg-light rounded">
                                            <i data-feather="log-in" class="text-success mb-2"
                                                style="width: 32px; height: 32px;"></i>
                                            <h6 class="text-muted mb-1">Gudang Tujuan</h6>
                                            <strong
                                                class="text-dark"><?= $transfer->nama_gudang_tujuan ?? '-' ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Barang -->
                <div class="card border">
                    <div class="card-header bg-light">
                        <strong><i data-feather="package" class="feather-sm me-1"></i> Daftar Barang yang
                            Ditransfer</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">No</th>
                                        <th width="60%">Nama Barang</th>
                                        <th width="15%">Qty</th>
                                        <th width="15%">Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($details)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data barang</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($details as $item): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $item->nama_barang ?? '-' ?></td>
                                                <td><strong><?= number_format($item->qty) ?></strong></td>
                                                <td><?= $item->nama_satuan ?? '-' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <?php if (!empty($details)): ?>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="2" class="text-end">Total Item:</th>
                                            <th colspan="2"><?= count($details) ?> jenis barang</th>
                                        </tr>
                                    </tfoot>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Bukti Foto -->
                <?php if (!empty($transfer->bukti_foto)): ?>
                    <div class="card border mt-4">
                        <div class="card-header bg-light">
                            <strong><i data-feather="camera" class="feather-sm me-1"></i> Bukti Foto Pengiriman</strong>
                        </div>
                        <div class="card-body text-center">
                            <img src="<?= base_url($transfer->bukti_foto) ?>" alt="Bukti Foto" class="img-fluid rounded"
                                style="max-height: 400px; cursor: pointer;" onclick="window.open(this.src, '_blank')">
                            <p class="text-muted mt-2 mb-0"><small>Klik gambar untuk memperbesar</small></p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Print Button -->
                <div class="mt-4 text-end">
                    <button type="button" class="btn btn-outline-primary" onclick="window.print()">
                        <i data-feather="printer" class="feather-sm me-1"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {

        .btn,
        .sidebar-nav,
        .topbar,
        .page-breadcrumb,
        .left-sidebar {
            display: none !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>