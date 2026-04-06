<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body py-3">
                <form action="<?= base_url('transfer/filter_date') ?>" method="POST"
                    class="d-flex align-items-center flex-wrap">
                    <label class="font-weight-semibold mb-0 mr-3"><i class="fas fa-filter mr-1"></i> Filter
                        Tanggal:</label>
                    <input type="date" name="filter_date" class="form-control mr-2" style="max-width: 220px;"
                        value="<?= isset($filter_date) && $filter_date ? date('Y-m-d', strtotime($filter_date)) : '' ?>">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search"></i> Filter</button>
                    <?php if (isset($filter_date) && $filter_date): ?>
                        <a href="<?= base_url('transfer/reset_filter') ?>" class="btn btn-secondary mr-3"><i
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
                    <h4 class="text-white mb-0"><i class="fas fa-exchange-alt mr-2"></i>Riwayat Pemindahan Barang</h4>
                    <a href="<?= base_url('transfer/create') ?>" class="btn btn-light">
                        <i data-feather="plus" class="feather-sm me-1"></i> Pemindahan Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success') ?>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Kode Pemindahan</th>
                                <th width="15%">Gudang Asal</th>
                                <th width="15%">Gudang Tujuan</th>
                                <th width="15%">Waktu</th>
                                <th width="10%">User</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($transfers)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Belum ada data transfer
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = ($currentPage - 1) * 10 + 1; ?>
                                <?php foreach ($transfers as $transfer): ?>
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
                                        <td class="text-center">
                                            <div class="d-flex flex-row gap-1 justify-content-center align-items-center"
                                                style="gap: 0.5rem;">
                                                <a href="<?= base_url('transfer/detail/' . $transfer->id) ?>"
                                                    class="btn btn-info btn-sm">
                                                    <i data-feather="eye" class="feather-sm"></i>
                                                </a>
                                                <?php if ($transfer->status == 'sampai'): ?>
                                                    <button type="button" class="btn btn-secondary btn-sm" disabled><i
                                                            class="fas fa-check-circle"></i>Sampai</button>
                                                <?php else: ?>
                                                    <form action="<?= base_url('transfer/update_status/' . $transfer->id) ?>"
                                                        method="POST" style="display:inline;">
                                                        <input type="hidden" name="status" value="sampai">
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            onclick="return confirm('Ubah status menjadi Sampai?')"><i
                                                                class="fas fa-check"></i> Tandai Sampai</button>
                                                    </form>
                                                <?php endif ?>
                                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteModal<?= $transfer->id ?>">
                                                        <i data-feather="trash-2" class="feather-sm"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Delete (Admin Only) -->
                                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                                        <div class="modal fade" id="deleteModal<?= $transfer->id ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Hapus Transfer</h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus transfer
                                                            <strong><?= $transfer->kode_transfer ?></strong>?
                                                        </p>
                                                        <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan!</small>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <form action="<?= base_url('transfer/delete/' . $transfer->id) ?>"
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

                <?php if (!empty($transfers) && $totalTransfers > 10): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php
                            $totalPages = ceil($totalTransfers / 10);
                            for ($i = 1; $i <= $totalPages; $i++):
                                ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= base_url('transfer?page=' . $i) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>