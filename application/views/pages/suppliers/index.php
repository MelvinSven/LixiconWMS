<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="card-title mb-0">List Supplier</h4>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                            <a href="<?= base_url('suppliers/add') ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Supplier
                            </a>
                        <?php endif ?>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">No</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Nama Supplier</th>
                                    <!-- Hanya admin yang boleh edit -->
                                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                                        <th class="border-0 font-14 font-weight-medium text-muted text-center">Aksi</th>
                                    <?php endif ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($content as $row): ?>
                                    <tr>
                                        <td class="border-top-0 px-2 py-4"><?= $no++ ?></td>
                                        <td class="border-top-0 px-2 py-4"><?= $row->nama ?></td>

                                        <!-- Hanya admin yang boleh melakukan aksi pada data -->
                                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                                            <td class="border-top-0 text-center text-muted px-2 py-4">
                                                <a href="<?= base_url("suppliers/edit/$row->id_supplier") ?>"
                                                    class="btn btn-sm btn-warning rounded-lg">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger rounded-lg" data-toggle="modal"
                                                    data-target="#deleteModal<?= $row->id_supplier ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($this->uri->segment(2) == 'search'): ?>
                    <div class="card-footer bg-white">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-2">
                                <a href="<?= base_url('suppliers') ?>" class="btn btn-primary btn-rounded text-white"><i
                                        class="fas fa-angle-left"></i> Daftar Supplier</a>
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

<!-- Modal Delete Supplier -->
<?php foreach ($content as $row): ?>
    <div class="modal fade" id="deleteModal<?= $row->id_supplier ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Hapus Supplier</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus supplier <strong><?= $row->nama ?></strong>?</p>
                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan!</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="<?= base_url('suppliers/delete/' . $row->id_supplier) ?>" class="btn btn-danger">Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->