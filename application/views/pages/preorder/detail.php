<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">
                        <i data-feather="file-text" class="feather-sm me-2"></i>
                        Detail Permintaan Barang
                    </h4>
                    <a href="<?= base_url('preorder') ?>" class="btn btn-secondary">
                        <i data-feather="arrow-left" class="feather-sm me-1"></i> Kembali
                    </a>
                </div>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('warning')): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('warning') ?>
                    </div>
                <?php endif; ?>

                <!-- Info Permintaan -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    <i data-feather="hash" class="feather-sm me-1"></i>
                                    <?= $permintaan->kode_permintaan ?>
                                </h5>
                                <hr>
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td width="40%"><strong>Tanggal Permintaan</strong></td>
                                        <td>:
                                            <?= date('d F Y', strtotime($permintaan->tanggal_permintaan)) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pemohon</strong></td>
                                        <td>:
                                            <?= $permintaan->nama_user ?? '-' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>:
                                            <?php
                                            $statusConfig = [
                                                'menunggu' => ['badge' => 'badge-secondary', 'icon' => 'fas fa-clock', 'label' => 'Menunggu Persetujuan'],
                                                'disetujui' => ['badge' => 'badge-info', 'icon' => 'fas fa-check', 'label' => 'Disetujui'],
                                                'ditolak' => ['badge' => 'badge-danger', 'icon' => 'fas fa-times', 'label' => 'Ditolak'],
                                                'surat_jalan' => ['badge' => 'badge-primary', 'icon' => 'fas fa-file-alt', 'label' => 'Surat Jalan Dibuat'],
                                                'dikirim' => ['badge' => 'badge-warning', 'icon' => 'fas fa-shipping-fast', 'label' => 'Sedang Dikirim'],
                                                'selesai' => ['badge' => 'badge-success', 'icon' => 'fas fa-check-circle', 'label' => 'Selesai'],
                                                'belum_selesai' => ['badge' => 'badge-dark', 'icon' => 'fas fa-exclamation-triangle', 'label' => 'Belum Selesai'],
                                            ];
                                            $sc = $statusConfig[$permintaan->status] ?? ['badge' => 'badge-secondary', 'icon' => 'fas fa-question', 'label' => $permintaan->status];
                                            ?>
                                            <span class="badge <?= $sc['badge'] ?>"><i
                                                    class="<?= $sc['icon'] ?> mr-1"></i>
                                                <?= $sc['label'] ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php if (!empty($permintaan->keterangan)): ?>
                                        <tr>
                                            <td><strong>Keterangan</strong></td>
                                            <td>:
                                                <?= $permintaan->keterangan ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if ($permintaan->status == 'ditolak' && !empty($permintaan->alasan_tolak)): ?>
                                        <tr>
                                            <td><strong>Alasan Penolakan</strong></td>
                                            <td>: <span class="text-danger">
                                                    <?= $permintaan->alasan_tolak ?>
                                                </span></td>
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
                                            <h6 class="text-muted mb-1">Dari Gudang</h6>
                                            <strong class="text-dark">
                                                <?= $permintaan->nama_gudang_asal ?? '-' ?>
                                            </strong>
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
                                            <strong class="text-dark">
                                                <?= $permintaan->nama_gudang_tujuan ?? '-' ?>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Barang yang Diminta -->
                <div class="card border">
                    <div class="card-header bg-light">
                        <strong><i data-feather="package" class="feather-sm me-1"></i> Daftar Barang yang
                            Diminta</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="8%">No</th>
                                        <th width="40%">Nama Barang</th>
                                        <th width="12%">Satuan</th>
                                        <th width="12%">Qty</th>
                                        <th width="23%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($details)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data barang</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($details as $item): ?>
                                            <tr>
                                                <td>
                                                    <?= $no++ ?>
                                                </td>
                                                <td>
                                                    <?= $item->nama_barang ?? '-' ?>
                                                </td>
                                                <td>
                                                    <?= $item->nama_satuan ?? '-' ?>
                                                </td>
                                                <td><strong>
                                                        <?= number_format($item->qty) ?>
                                                    </strong></td>
                                                <td>
                                                    <?= $item->keterangan ?? '-' ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <?php if (!empty($details)): ?>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="4" class="text-end">Total Item:</th>
                                            <th colspan="2">
                                                <?= count($details) ?> jenis barang
                                            </th>
                                        </tr>
                                    </tfoot>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Surat Jalan Info (jika ada) -->
                <?php if ($surat_jalan): ?>
                    <div class="card border mt-4">
                        <div class="card-header bg-primary text-white">
                            <strong><i class="fas fa-file-alt mr-1"></i> Surat Jalan</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm mb-3">
                                <tr>
                                    <td width="30%"><strong>Nomor Pengiriman</strong></td>
                                    <td>:
                                        <?= $surat_jalan->nomor_pengiriman ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Pengiriman</strong></td>
                                    <td>:
                                        <?= date('d F Y', strtotime($surat_jalan->tanggal_pengiriman)) ?>
                                    </td>
                                </tr>
                            </table>

                            <?php if (!empty($surat_jalan_details)): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="8%">No</th>
                                                <th width="35%">Nama Barang</th>
                                                <th width="15%">Qty</th>
                                                <th width="42%">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($surat_jalan_details as $sjd): ?>
                                                <tr>
                                                    <td>
                                                        <?= $no++ ?>
                                                    </td>
                                                    <td>
                                                        <?= $sjd->nama_barang ?? '-' ?>
                                                    </td>
                                                    <td><strong>
                                                            <?= number_format($sjd->qty) ?>
                                                        </strong></td>
                                                    <td>
                                                        <?= $sjd->keterangan ?? '-' ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>

                            <div class="mt-3 d-flex flex-wrap" style="gap: 0.5rem;">
                                <a href="<?= base_url('preorder/print_surat_jalan/' . $permintaan->id) ?>"
                                    class="btn btn-outline-primary" target="_blank">
                                    <i data-feather="printer" class="feather-sm me-1"></i> Cetak Surat Jalan
                                </a>
                                <?php if (!empty($surat_jalan->foto)): ?>
                                    <a href="<?= base_url($surat_jalan->foto) ?>" target="_blank"
                                        class="btn btn-outline-secondary" title="Lihat Foto Surat Jalan">
                                        <i data-feather="image" class="feather-sm me-1"></i> Foto Surat Jalan
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Hasil Verifikasi (jika status belum_selesai atau selesai) -->
                <?php if (!empty($verifikasi_details) && in_array($permintaan->status, ['belum_selesai', 'selesai'])): ?>
                    <div class="card border mt-4">
                        <div
                            class="card-header <?= $permintaan->status == 'selesai' ? 'bg-success' : 'bg-dark' ?> text-white">
                            <strong>
                                <i class="fas fa-clipboard-check mr-1"></i> Hasil Verifikasi Penerimaan
                            </strong>
                        </div>
                        <div class="card-body">
                            <?php
                            $totalSesuai = 0;
                            $totalTidakSesuai = 0;
                            $totalQtyKirim = 0;
                            $totalQtyDiterima = 0;
                            foreach ($verifikasi_details as $vd) {
                                if ($vd->is_sesuai == 1)
                                    $totalSesuai++;
                                else
                                    $totalTidakSesuai++;
                                $totalQtyKirim += $vd->qty;
                                $totalQtyDiterima += ($vd->qty_diterima !== null ? $vd->qty_diterima : $vd->qty);
                            }
                            ?>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="alert alert-info mb-0 text-center">
                                        <strong>Total Barang:</strong> <?= count($verifikasi_details) ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="alert alert-success mb-0 text-center">
                                        <strong>Sesuai:</strong> <?= $totalSesuai ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="alert alert-danger mb-0 text-center">
                                        <strong>Tidak Sesuai:</strong> <?= $totalTidakSesuai ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="alert alert-warning mb-0 text-center">
                                        <strong>Diterima:</strong> <?= number_format($totalQtyDiterima) ?> /
                                        <?= number_format($totalQtyKirim) ?>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="28%">Nama Barang</th>
                                            <th width="8%">Satuan</th>
                                            <th width="8%" class="text-center">Qty Kirim</th>
                                            <th width="10%" class="text-center">Qty Diterima</th>
                                            <th width="12%" class="text-center">Status</th>
                                            <th width="25%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($verifikasi_details as $vd): ?>
                                            <tr class="<?= $vd->is_sesuai == 0 ? 'table-danger' : '' ?>">
                                                <td><?= $no++ ?></td>
                                                <td><?= $vd->nama_barang ?? '-' ?></td>
                                                <td><?= $vd->nama_satuan ?? '-' ?></td>
                                                <td class="text-center"><strong><?= number_format($vd->qty) ?></strong></td>
                                                <td class="text-center">
                                                    <?php if ($vd->is_sesuai == 1): ?>
                                                        <strong><?= number_format($vd->qty_diterima !== null ? $vd->qty_diterima : $vd->qty) ?></strong>
                                                    <?php else: ?>
                                                        <strong
                                                            class="text-danger"><?= number_format($vd->qty_diterima !== null ? $vd->qty_diterima : 0) ?></strong>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($vd->is_sesuai == 1): ?>
                                                        <span class="badge badge-success"><i
                                                                class="fas fa-check mr-1"></i>Sesuai</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger"><i class="fas fa-times mr-1"></i>Tidak
                                                            Sesuai</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $vd->keterangan_verifikasi ?? '-' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if ($totalTidakSesuai > 0): ?>
                                <div class="mt-3">
                                    <!-- <a href="<?= base_url('preorder/print_verifikasi/' . $permintaan->id) ?>"
                                        class="btn btn-outline-danger" target="_blank">
                                        <i data-feather="printer" class="feather-sm me-1"></i> Cetak Laporan Barang Tidak Sesuai
                                    </a> -->
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <?php
                $detailRole = $this->session->userdata('role');
                $detailUserGudang = $this->session->userdata('id_gudang');
                $detailUserId = $this->session->userdata('id_user');
                // Source warehouse admin: can approve/reject/surat_jalan/kirim
                $isSourceAdmin = ($detailRole == 'admin') || ($detailRole == 'staff' && $detailUserGudang == $permintaan->id_gudang_asal);
                // Destination warehouse admin: can verifikasi
                $isDestAdmin = ($detailRole == 'admin') || ($detailRole == 'staff' && $detailUserGudang == $permintaan->id_gudang_tujuan);
                // Requester who can delete their own pending preorder
                $isRequesterPreApproval = ($permintaan->id_user == $detailUserId && $permintaan->status == 'menunggu');
                ?>
                <div class="mt-4 d-flex flex-wrap" style="gap: 0.5rem;">
                    <?php if ($isSourceAdmin && $permintaan->status == 'menunggu'): ?>
                        <form action="<?= base_url('preorder/approve/' . $permintaan->id) ?>" method="POST"
                            style="display:inline;">
                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Setujui permintaan ini?')">
                                <i class="fas fa-check mr-1"></i> Setujui Permintaan
                            </button>
                        </form>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModalDetail">
                            <i class="fas fa-times mr-1"></i> Tolak Permintaan
                        </button>
                    <?php endif; ?>

                    <?php if ($isSourceAdmin && $permintaan->status == 'disetujui'): ?>
                        <a href="<?= base_url('preorder/surat_jalan/' . $permintaan->id) ?>" class="btn btn-primary">
                            <i class="fas fa-file-alt mr-1"></i> Buat Surat Jalan
                        </a>
                    <?php endif; ?>

                    <?php if ($isSourceAdmin && $permintaan->status == 'surat_jalan'): ?>
                        <form action="<?= base_url('preorder/kirim/' . $permintaan->id) ?>" method="POST"
                            style="display:inline;">
                            <button type="submit" class="btn btn-warning"
                                onclick="return confirm('Tandai barang sedang dikirim?')">
                                <i class="fas fa-shipping-fast mr-1"></i> Tandai Sedang Dikirim
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if ($isDestAdmin && $permintaan->status == 'dikirim'): ?>
                        <a href="<?= base_url('preorder/verifikasi/' . $permintaan->id) ?>" class="btn btn-info">
                            <i class="fas fa-clipboard-check mr-1"></i> Verifikasi Penerimaan
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<?php if ($isSourceAdmin && $permintaan->status == 'menunggu'): ?>
    <div class="modal fade" id="rejectModalDetail" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url('preorder/reject/' . $permintaan->id) ?>" method="POST">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Tolak Permintaan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Tolak permintaan <strong>
                                <?= $permintaan->kode_permintaan ?>
                            </strong>?</p>
                        <div class="form-group">
                            <label for="alasan_tolak">Alasan Penolakan</label>
                            <textarea name="alasan_tolak" class="form-control" rows="3"
                                placeholder="Masukkan alasan penolakan..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

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