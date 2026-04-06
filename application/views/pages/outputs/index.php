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
                    <form action="<?= base_url('outputs/search_time') ?>" method="POST"
                        class="d-flex align-items-center flex-wrap">
                        <label class="font-weight-semibold mb-0 mr-3"><i class="fas fa-filter mr-1"></i> Filter
                            Tanggal:</label>
                        <input type="date" name="time" class="form-control mr-2" style="max-width: 220px;"
                            value="<?= $this->session->userdata('time') ? date('Y-m-d', strtotime($this->session->userdata('time'))) : '' ?>">
                        <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search"></i> Filter</button>
                        <?php if ($this->session->userdata('time')): ?>
                            <a href="<?= base_url('outputs') ?>" class="btn btn-secondary mr-3"><i class="fas fa-times"></i>
                                Reset</a>
                            <span class="badge badge-info py-2 px-3 font-weight-normal" style="font-size: 0.9rem;">
                                <i class="fas fa-calendar-check mr-1"></i> Menampilkan data tanggal:
                                <?= date('d-m-Y', strtotime($this->session->userdata('time'))) ?>
                            </span>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white mb-0"><i class="fas fa-sign-out-alt mr-2"></i>List Pengeluaran Barang</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nama Staff</th>
                                    <th class="text-center">Gudang</th>
                                    <th class="text-center">Waktu Pengeluaran</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($content)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                            Tidak ada data pengeluaran barang ditemukan
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($content as $row): ?>
                                        <tr>
                                            <!-- <td><?= $row->id ?></td> -->
                                            <td><?= $row->nama ?></td>
                                            <td class="text-center">
                                                <?php if (!empty($row->nama_gudang)): ?>
                                                    <span class="badge badge-light border">
                                                        <i class="fas fa-warehouse mr-1 text-secondary"></i><?= $row->nama_gudang ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif ?>
                                            </td>
                                            <td class="text-center"><?= date('d-m-Y H:i:s', strtotime($row->waktu)) ?></td>
                                            <td class="text-center">
                                                <?php if (isset($row->status) && $row->status == 'sampai'): ?>
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
                                                    <a href="<?= base_url("outputs/detail/$row->id") ?>"
                                                        class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                    <?php if (isset($row->status) && $row->status == 'sampai'): ?>
                                                        <button type="button" class="btn btn-secondary btn-sm" disabled><i
                                                                class="fas fa-check-circle"></i> Sampai</button>
                                                    <?php elseif ($this->session->userdata('role') == 'admin' || $row->id_user == $this->session->userdata('id_user')): ?>
                                                        <form action="<?= base_url('outputs/update_status/' . $row->id) ?>"
                                                            method="POST" style="display:inline;">
                                                            <input type="hidden" name="status" value="sampai">
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                onclick="return confirm('Ubah status menjadi Sampai?')"><i
                                                                    class="fas fa-check"></i> Tandai Sampai</button>
                                                        </form>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-secondary btn-sm" disabled
                                                            title="Hanya staff pemilik yang bisa mengubah status"><i
                                                                class="fas fa-shipping-fast"></i> Dikirim</button>
                                                    <?php endif ?>
                                                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                                                        <form action="<?= base_url("outputs/delete/$row->id") ?>" method="POST"
                                                            style="display:inline;"
                                                            onsubmit="return confirm('Yakin ingin menghapus data pengeluaran ini?')">
                                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                                    class="fas fa-trash"></i> </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($this->uri->segment(2)): ?>
                    <div class="card-footer bg-white">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-2">
                                <a href="<?= base_url('outputs') ?>" class="btn btn-primary btn-rounded text-white"><i
                                        class="fas fa-angle-left"></i> List Pengeluaran</a>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2 d-flex justify-content-center">
                                <div class="row d-flex justify-content-center">
                                    <nav aria-label="Page navigation example">
                                        <?= $pagination ?>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            <?= $pagination ?>
                        </nav>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->