<div class="row">
    <div class="col-12">
        <div class="card mt-4 mx-4">
            <div class="card-header bg-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="text-white mb-0">
                        <i class="fas fa-file-invoice mr-2"></i>Daftar Purchase Request
                    </h4>
                    <?php if ($this->session->userdata('role') == 'staff'): ?>
                        <a href="<?= base_url('purchaserequest/create') ?>" class="btn btn-light">
                            <i data-feather="plus" class="feather-sm me-1"></i> Buat Purchase Request
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
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

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="14%">Nomor PR</th>
                                <th width="14%">Gudang Tujuan</th>
                                <th width="14%">Tgl PR</th>
                                <th width="14%">Project Admin</th>
                                <th width="14%" class="text-center">Status</th>
                                <th width="13%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($prs)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Belum ada Purchase Request
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = ($currentPage - 1) * 10 + 1; ?>
                                <?php foreach ($prs as $p): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= $p->kode_pr ?></strong></td>
                                        <td><?= $p->nama_gudang ?? '-' ?></td>
                                        <td><?= date('d M Y', strtotime($p->tanggal_pr)) ?></td>
                                        <td><?= $p->nama_user ?? '-' ?></td>
                                        <td class="text-center">
                                            <?php
                                            $statusConfig = [
                                                'menunggu' => ['badge' => 'badge-secondary', 'icon' => 'fas fa-clock', 'label' => 'Menunggu'],
                                                'ditolak' => ['badge' => 'badge-danger', 'icon' => 'fas fa-times', 'label' => 'Ditolak'],
                                                'diproses' => ['badge' => 'badge-warning', 'icon' => 'fas fa-cog', 'label' => 'Diproses'],
                                                'selesai' => ['badge' => 'badge-success', 'icon' => 'fas fa-check-circle', 'label' => 'Selesai'],
                                                'belum_selesai' => ['badge' => 'badge-dark', 'icon' => 'fas fa-exclamation-triangle', 'label' => 'Belum Selesai'],
                                            ];
                                            $sc = $statusConfig[$p->status] ?? ['badge' => 'badge-secondary', 'icon' => 'fas fa-question', 'label' => $p->status];
                                            ?>
                                            <span class="badge <?= $sc['badge'] ?>">
                                                <i class="<?= $sc['icon'] ?> mr-1"></i><?= $sc['label'] ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-row justify-content-center align-items-center"
                                                style="gap: 0.5rem;">
                                                <a href="<?= base_url('purchaserequest/detail/' . $p->id) ?>"
                                                    class="btn btn-info btn-sm rounded-lg" title="Detail">
                                                    <i data-feather="eye" class="feather-sm"></i>
                                                </a>
                                                <?php
                                                $canDelete = $this->session->userdata('role') == 'admin'
                                                    || ($this->session->userdata('role') == 'staff' && in_array($p->status, ['menunggu', 'ditolak']));
                                                ?>
                                                <?php if ($canDelete): ?>
                                                    <button type="button" class="btn btn-danger btn-sm rounded-lg"
                                                        data-toggle="modal" data-target="#deleteModal<?= $p->id ?>" title="Hapus">
                                                        <i data-feather="trash-2" class="feather-sm"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php if ($canDelete): ?>
                                        <div class="modal fade" id="deleteModal<?= $p->id ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Hapus Purchase Request</h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Hapus PR <strong><?= $p->kode_pr ?></strong>?</p>
                                                        <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <form action="<?= base_url('purchaserequest/delete/' . $p->id) ?>"
                                                            method="POST" style="display:inline;">
                                                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (!empty($prs) && $totalPR > 10): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php $totalPages = ceil($totalPR / 10);
                            for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= base_url('purchaserequest?page=' . $i) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>