<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">List Letak Barang</h4>
                    </div>

                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <form action="<?= base_url('locations/create') ?>" method="POST" class="mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text"><i class="fas fa-map-marker-alt"></i></label>
                                </div>
                                <input type="text" name="nama_lokasi" class="form-control"
                                    placeholder="Tambah letak barang baru" required>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i>
                                        Tambah</button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center px-2">Nama
                                        Lokasi</th>
                                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                                        <th class="border-0 font-14 font-weight-medium text-muted text-center">Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($content as $row): ?>
                                    <tr>
                                        <td class="border-top-0 px-2 py-4 text-center">
                                            <?= htmlspecialchars($row->nama_lokasi) ?>
                                        </td>
                                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                                            <td class="border-top-0 text-center text-muted px-2 py-4">
                                                <a href="<?= base_url("locations/edit/$row->id_lokasi") ?>" class="btn btn-sm">
                                                    <i class="fas fa-edit text-info"></i>
                                                </a>
                                                <form action="<?= base_url("locations/delete/$row->id_lokasi") ?>"
                                                    method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin
                                            ingin menghapus lokasi ini?');">
                                                    <button type="submit" class="btn btn-sm">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if (!empty($pagination)): ?>
                    <div class="wms-pag-footer <?= ($this->uri->segment(2) == 'search') ? 'wms-pag-split' : '' ?>">
                        <?php if ($this->uri->segment(2) == 'search'): ?>
                            <a href="<?= base_url('locations') ?>" class="btn-reset">
                                <i class="fas fa-angle-left"></i> Daftar Letak Barang
                            </a>
                        <?php endif ?>
                        <nav aria-label="Navigasi halaman"><?= $pagination ?></nav>
                    </div>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->