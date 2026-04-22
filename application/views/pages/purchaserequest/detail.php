<style>
    @media (min-width: 768px) {
        .w-md-50 {
            width: 50% !important;
        }
    }
</style>
<?php
$statusConfig = [
    'menunggu' => ['badge' => 'badge-secondary', 'icon' => 'fas fa-clock', 'label' => 'Menunggu'],
    'ditolak' => ['badge' => 'badge-danger', 'icon' => 'fas fa-times', 'label' => 'Ditolak'],
    'disetujui' => ['badge' => 'badge-info', 'icon' => 'fas fa-check', 'label' => 'Disetujui'],
    'diproses' => ['badge' => 'badge-warning', 'icon' => 'fas fa-cog', 'label' => 'Diproses'],
    'selesai' => ['badge' => 'badge-success', 'icon' => 'fas fa-check-circle', 'label' => 'Selesai'],
    'belum_selesai' => ['badge' => 'badge-dark', 'icon' => 'fas fa-exclamation-triangle', 'label' => 'Belum Selesai'],
];
$itemStatusConfig = [
    'sesuai' => ['badge' => 'badge-success', 'label' => 'Barang Sesuai'],
    'belum' => ['badge' => 'badge-dark', 'label' => 'Belum Selesai'],
    'pending' => ['badge' => 'badge-secondary', 'label' => 'Belum Diverifikasi'],
];
$sc = $statusConfig[$pr->status] ?? ['badge' => 'badge-secondary', 'icon' => 'fas fa-question', 'label' => $pr->status];
$role = $this->session->userdata('role');
$canVerify = ($role == 'staff' && in_array($pr->status, ['disetujui', 'belum_selesai']));
$showDelivery = in_array($pr->status, ['disetujui', 'belum_selesai', 'selesai']);
$canEditDelivery = in_array($role, ['purchasing_admin', 'admin']) && in_array($pr->status, ['disetujui', 'belum_selesai']);
$hasUnverified = false;
foreach ($details as $d) {
    if ((int) ($d->is_sesuai ?? -1) !== 1) {
        $hasUnverified = true;
        break;
    }
}
?>

<div class="row">
    <div class="col-12">
        <div class="card mt-4 mx-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-file-invoice mr-2"></i> PR <?= $pr->kode_pr ?></h4>
                <span class="badge badge-light"><i class="<?= $sc['icon'] ?> mr-1"></i><?= $sc['label'] ?></span>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show"><?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show"><?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('warning')): ?>
                    <div class="alert alert-warning alert-dismissible fade show"><?= $this->session->flashdata('warning') ?>
                    </div>
                <?php endif; ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th width="35%">Project Admin</th>
                                <td><?= htmlspecialchars($pr->nama_user ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Gudang Tujuan</th>
                                <td><?= htmlspecialchars($pr->nama_gudang ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal PR</th>
                                <td><?= date('d M Y', strtotime($pr->tanggal_pr)) ?>
                                    <?= $pr->created_at ? date('H:i', strtotime($pr->created_at)) : '' ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th width="35%">Status</th>
                                <td><span class="badge <?= $sc['badge'] ?>"><?= $sc['label'] ?></span></td>
                            </tr>
                            <tr>
                                <th>Direspon Oleh</th>
                                <td><?= htmlspecialchars($pr->nama_responder ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Respon</th>
                                <td><?= $pr->tanggal_respon ? date('d M Y H:i', strtotime($pr->tanggal_respon)) : '-' ?>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>

                <?php if ($pr->status == 'ditolak' && !empty($pr->alasan_tolak)): ?>
                    <div class="alert alert-danger">
                        <strong><i class="fas fa-times-circle mr-1"></i> Alasan Penolakan:</strong>
                        <div><?= nl2br(htmlspecialchars($pr->alasan_tolak)) ?></div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($pr->foto_pr)): ?>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2 mb-3" data-toggle="modal"
                        data-target="#fotoModal">
                        <i class="fas fa-image mr-1"></i> Lihat Foto PR
                    </button>
                <?php endif; ?>

                <h3 class="mt-4 mb-2 "><i class="fas fa-boxes mr-2"></i>Daftar Barang</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th width="4%">No</th>
                                <th>Nama Barang</th>
                                <th width="7%">Satuan</th>
                                <th width="6%" class="text-right">Qty</th>
                                <th width="8%" class="text-right">Diterima</th>
                                <th width="13%" class="text-center">Status Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($details)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-3 text-muted">Tidak ada item.</td>
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
                                        <td><?= $i + 1 ?></td>
                                        <td><?= htmlspecialchars($it->nama_barang) ?></td>
                                        <td><?= htmlspecialchars($it->nama_satuan ?? '-') ?></td>
                                        <td class="text-right"><?= (int) $it->qty ?></td>
                                        <td class="text-right"><?= $it->qty_diterima !== null ? (int) $it->qty_diterima : '-' ?>
                                        </td>
                                        <td class="text-center"><span
                                                class="badge <?= $isc['badge'] ?>"><?= $isc['label'] ?></span></td>
                                    </tr>
                                <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($showDelivery && !empty($details)): ?>
                    <h3 class="mt-4 mb-2"><i class="fas fa-shipping-fast mr-2"></i>Status Pengiriman Barang</h3>
                    <?php
                    $stateOrder = ['diproses' => 0, 'dikirim' => 1, 'sampai' => 2];
                    $stateLabels = ['diproses' => 'Diproses', 'dikirim' => 'Dikirim', 'sampai' => 'Sampai'];
                    $stateIcons = ['diproses' => 'fas fa-shopping-cart', 'dikirim' => 'fas fa-truck', 'sampai' => 'fas fa-check-circle'];
                    foreach ($details as $it):
                        $state = $it->status_pengiriman ?? 'diproses';
                        $step = $stateOrder[$state] ?? 0;
                        ?>
                        <div class="border rounded mb-3 p-3 w-100 w-md-50">
                            <div class="d-flex justify-content-between mb-2">
                                <strong><?= htmlspecialchars($it->nama_barang) ?></strong>
                                <small class="text-muted">Qty: <?= (int) $it->qty ?></small>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <?php foreach (['diproses', 'dikirim', 'sampai'] as $idx => $s):
                                    $active = ($step >= $idx);
                                    $isLast = ($s === 'sampai');
                                    $circleClass = $active ? ($isLast && $step === 2 ? 'bg-success text-white' : 'bg-primary text-white') : 'bg-light border text-muted';
                                    $labelClass = $active ? ($isLast && $step === 2 ? 'text-success font-weight-bold' : 'text-primary font-weight-bold') : 'text-muted';
                                    ?>
                                    <div class="text-center" style="flex: 0 0 auto; min-width: 64px;">
                                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center <?= $circleClass ?>"
                                            style="width:36px;height:36px;">
                                            <i class="<?= $stateIcons[$s] ?> fa-sm"></i>
                                        </div>
                                        <div class="small mt-1 <?= $labelClass ?>"><?= $stateLabels[$s] ?></div>
                                    </div>
                                    <?php if (!$isLast): ?>
                                        <div style="flex:1; height:3px; background:<?= ($step > $idx) ? '#007bff' : '#dee2e6' ?>;">
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <?php if ($canEditDelivery): ?>
                                <div class="mt-2">
                                    <?php foreach (['diproses', 'dikirim', 'sampai'] as $s):
                                        if ($s === $state)
                                            continue;
                                        $btnClass = ['diproses' => 'btn-outline-secondary', 'dikirim' => 'btn-outline-info', 'sampai' => 'btn-outline-success'][$s];
                                        $btnIcon = ['diproses' => 'fas fa-undo', 'dikirim' => 'fas fa-truck', 'sampai' => 'fas fa-check'][$s];
                                        ?>
                                        <form action="<?= base_url('purchaserequest/update_status_pengiriman/' . $it->id) ?>"
                                            method="POST" style="display:inline;" class="mr-1">
                                            <input type="hidden" name="new_state" value="<?= $s ?>">
                                            <button type="submit" class="btn <?= $btnClass ?> btn-sm"
                                                onclick="return confirm('Set status pengiriman menjadi &quot;<?= $stateLabels[$s] ?>&quot;?')">
                                                <i class="<?= $btnIcon ?> mr-1"></i><?= $stateLabels[$s] ?>
                                            </button>
                                        </form>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($surat_jalan_list)): ?>
                    <h5 class="mt-4 mb-2"><i class="fas fa-file-pdf text-danger mr-2"></i>Surat Jalan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="4%">#</th>
                                    <th>Nama File</th>
                                    <th width="18%">Tanggal Upload</th>
                                    <th width="8%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($surat_jalan_list as $i => $sj): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td>
                                            <i class="fas fa-file-pdf text-danger mr-1"></i>
                                            <?= htmlspecialchars($sj->nama_file) ?>
                                        </td>
                                        <td><?= date('d M Y H:i', strtotime($sj->uploaded_at)) ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url($sj->file_path) ?>" target="_blank"
                                                class="btn btn-sm btn-outline-danger" title="Unduh">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if (!empty($progress) && $progress['total'] > 0): ?>
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        Progress Verifikasi: <strong><?= $progress['sesuai'] ?></strong> sesuai,
                        <strong><?= $progress['belum_sesuai'] ?></strong> belum sesuai,
                        <strong><?= $progress['belum_diverifikasi'] ?></strong> belum diverifikasi
                        (total <?= $progress['total'] ?>).
                    </div>
                <?php endif; ?>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="<?= base_url('purchaserequest') ?>" class="btn btn-secondary">
                        <i data-feather="arrow-left" class="feather-sm me-1"></i> Kembali
                    </a>
                    <div>
                        <?php if ($role == 'purchasing_admin' && $pr->status == 'menunggu'): ?>
                            <form action="<?= base_url('purchaserequest/accept/' . $pr->id) ?>" method="POST"
                                style="display:inline;" onsubmit="return confirm('Setujui Purchase Request ini?')">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check mr-1"></i> Accept
                                </button>
                            </form>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
                                <i class="fas fa-times mr-1"></i> Decline
                            </button>
                        <?php endif; ?>
                        <?php if ($canVerify && $hasUnverified): ?>
                            <a href="<?= base_url('purchaserequest/verifikasi/' . $pr->id) ?>" class="btn btn-primary">
                                <i class="fas fa-clipboard-check mr-1"></i> Verifikasi Barang
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($role == 'purchasing_admin' && $pr->status == 'menunggu'): ?>
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url('purchaserequest/reject/' . $pr->id) ?>" method="POST">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Tolak Purchase Request</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Tolak PR <strong><?= $pr->kode_pr ?></strong>?</p>
                        <div class="form-group">
                            <label>Alasan Penolakan</label>
                            <textarea name="alasan_tolak" class="form-control" rows="3"
                                placeholder="Berikan alasan agar Project Admin dapat merevisi..." required></textarea>
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

<?php if ($role == 'staff' && $pr->status == 'belum_selesai'):
    foreach ($details as $it):
        if ((int) ($it->is_sesuai ?? -1) !== 0)
            continue;
        $qd = (int) ($it->qty_diterima ?? 0);
        ?>
        <div class="modal fade" id="qtyModal<?= $it->id ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="<?= base_url('purchaserequest/update_qty/' . $it->id) ?>" method="POST">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title">Ubah Qty — <?= htmlspecialchars($it->nama_barang) ?></h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-2">Qty saat ini: <strong><?= (int) $it->qty ?></strong> — Qty diterima:
                                <strong><?= $qd ?></strong>
                            </p>
                            <p class="text-muted"><small>Ubah Qty menjadi <strong><?= $qd ?></strong> agar item ini berstatus
                                    "Barang Sesuai".</small></p>
                            <div class="form-group">
                                <label>Qty Baru</label>
                                <input type="number" name="qty" class="form-control" min="<?= $qd ?>" value="<?= $qd ?>"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; endif; ?>

<?php if (!empty($pr->foto_pr)): ?>
    <div class="modal fade" id="fotoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-image mr-2"></i>Foto Purchase Request —
                        <?= htmlspecialchars($pr->kode_pr) ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <img src="<?= base_url($pr->foto_pr) ?>" alt="Foto PR" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <a href="<?= base_url($pr->foto_pr) ?>" target="_blank" class="btn btn-outline-secondary">
                        <i class="fas fa-external-link-alt mr-1"></i> Buka di Tab Baru
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>