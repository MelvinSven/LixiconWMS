<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body py-3">
                <form action="<?= base_url('preorder/filter_date') ?>" method="POST"
                    class="d-flex align-items-center flex-wrap">
                    <label class="font-weight-semibold mb-0 mr-3"><i class="fas fa-filter mr-1"></i> Filter
                        Tanggal:</label>
                    <input type="date" name="filter_date" class="form-control mr-2" style="max-width: 220px;"
                        value="<?= isset($filter_date) && $filter_date ? date('Y-m-d', strtotime($filter_date)) : '' ?>">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search"></i> Filter</button>
                    <?php if (isset($filter_date) && $filter_date): ?>
                        <a href="<?= base_url('preorder/reset_filter') ?>" class="btn btn-secondary mr-3"><i
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

<div class="row">
    <div class="col-12">
        <div class="card mt-2 mx-4">
            <div class="card-header bg-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="text-white mb-0"><i class="fas fa-clipboard-list mr-2"></i>Daftar Permintaan Barang</h4>
                    <?php if ($this->session->userdata('role') == 'staff'): ?>
                        <a href="<?= base_url('preorder/create') ?>" class="btn btn-light">
                            <i data-feather="plus" class="feather-sm me-1"></i> Buat Permintaan
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
                                <th width="12%">Kode Permintaan</th>
                                <th width="12%">Dari Gudang</th>
                                <th width="12%">Gudang Tujuan</th>
                                <th width="10%">Tgl Permintaan</th>
                                <th width="10%">Diperlukan</th>
                                <th width="10%">Pemohon</th>
                                <th width="12%" class="text-center">Status</th>
                                <th width="17%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($permintaans)): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Belum ada data permintaan barang
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = ($currentPage - 1) * 10 + 1; ?>
                                <?php foreach ($permintaans as $p): ?>
                                    <tr>
                                        <td>
                                            <?= $no++ ?>
                                        </td>
                                        <td><strong>
                                                <?= $p->kode_permintaan ?>
                                            </strong></td>
                                        <td>
                                            <?= $p->nama_gudang_asal ?? '-' ?>
                                        </td>
                                        <td>
                                            <?= $p->nama_gudang_tujuan ?? '-' ?>
                                        </td>
                                        <td>
                                            <?= date('d M Y', strtotime($p->tanggal_permintaan)) ?>
                                        </td>
                                        <td>
                                            <?= date('d M Y', strtotime($p->tanggal_diperlukan)) ?>
                                        </td>
                                        <td>
                                            <?= $p->nama_user ?? '-' ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $statusConfig = [
                                                'menunggu' => ['badge' => 'badge-secondary', 'icon' => 'fas fa-clock', 'label' => 'Menunggu'],
                                                'disetujui' => ['badge' => 'badge-info', 'icon' => 'fas fa-check', 'label' => 'Disetujui'],
                                                'ditolak' => ['badge' => 'badge-danger', 'icon' => 'fas fa-times', 'label' => 'Ditolak'],
                                                'surat_jalan' => ['badge' => 'badge-primary', 'icon' => 'fas fa-file-alt', 'label' => 'Surat Jalan'],
                                                'dikirim' => ['badge' => 'badge-warning', 'icon' => 'fas fa-shipping-fast', 'label' => 'Dikirim'],
                                                'selesai' => ['badge' => 'badge-success', 'icon' => 'fas fa-check-circle', 'label' => 'Selesai'],
                                                'belum_selesai' => ['badge' => 'badge-dark', 'icon' => 'fas fa-exclamation-triangle', 'label' => 'Belum Selesai'],
                                            ];
                                            $sc = $statusConfig[$p->status] ?? ['badge' => 'badge-secondary', 'icon' => 'fas fa-question', 'label' => $p->status];
                                            ?>
                                            <span class="badge <?= $sc['badge'] ?>"><i class="<?= $sc['icon'] ?> mr-1"></i>
                                                <?= $sc['label'] ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $idxRole = $this->session->userdata('role');
                                            $idxUserGudang = $this->session->userdata('id_gudang');
                                            $idxUserId = $this->session->userdata('id_user');
                                            $rowIsSourceAdmin = ($idxRole == 'admin') || ($idxRole == 'staff' && $idxUserGudang == $p->id_gudang_asal);
                                            $rowCanDelete = ($idxRole == 'admin') || ($p->id_user == $idxUserId && $p->status == 'menunggu');
                                            ?>
                                            <div class="d-flex flex-row gap-1 justify-content-center align-items-center"
                                                style="gap: 0.5rem;">
                                                <a href="<?= base_url('preorder/detail/' . $p->id) ?>"
                                                    class="btn btn-info btn-sm rounded-lg" title="Detail">
                                                    <i data-feather="eye" class="feather-sm"></i>
                                                </a>
                                                <?php if ($rowIsSourceAdmin && $p->status == 'menunggu'): ?>
                                                    <form action="<?= base_url('preorder/approve/' . $p->id) ?>" method="POST"
                                                        style="display:inline;">
                                                        <button type="submit" class="btn btn-success btn-sm rounded-lg"
                                                            onclick="return confirm('Setujui permintaan ini?')" title="Setujui">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-danger btn-sm rounded-lg"
                                                        data-toggle="modal" data-target="#rejectModal<?= $p->id ?>" title="Tolak">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <?php if ($rowCanDelete): ?>
                                                    <button type="button" class="btn btn-danger btn-sm rounded-lg"
                                                        data-toggle="modal" data-target="#deleteModal<?= $p->id ?>" title="Hapus">
                                                        <i data-feather="trash-2" class="feather-sm"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Reject -->
                                    <?php if ($rowIsSourceAdmin && $p->status == 'menunggu'): ?>
                                        <div class="modal fade" id="rejectModal<?= $p->id ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="<?= base_url('preorder/reject/' . $p->id) ?>" method="POST">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title">Tolak Permintaan</h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Tolak permintaan <strong>
                                                                    <?= $p->kode_permintaan ?>
                                                                </strong>?</p>
                                                            <div class="form-group">
                                                                <label for="alasan_tolak">Alasan Penolakan</label>
                                                                <textarea name="alasan_tolak" class="form-control" rows="3"
                                                                    placeholder="Masukkan alasan penolakan..." required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Modal Delete -->
                                    <?php if ($rowCanDelete): ?>
                                        <div class="modal fade" id="deleteModal<?= $p->id ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Hapus Permintaan</h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus permintaan <strong>
                                                                <?= $p->kode_permintaan ?>
                                                            </strong>?</p>
                                                        <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan!</small>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <form action="<?= base_url('preorder/delete/' . $p->id) ?>" method="POST"
                                                            style="display:inline;">
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

                <?php if (!empty($permintaans) && $totalPermintaan > 10): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php
                            $totalPages = ceil($totalPermintaan / 10);
                            for ($i = 1; $i <= $totalPages; $i++):
                                ?>
                                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= base_url('preorder?page=' . $i) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>