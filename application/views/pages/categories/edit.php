<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit Kategori</h4>
                    <form action="<?= base_url("categories/edit/$input->id_category") ?>" method="POST">
                        <?= form_hidden('id_category', $input->id_category) ?>
                        <div class="form-body">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2">Nama Kategori</label>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text"><i class="fas fa-tags"></i></label>
                                                    </div>
                                                    <?= form_input('CategoryName', $input->CategoryName, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Nama kategori']) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-12">
                                                <?= form_error('CategoryName') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="<?= base_url('categories') ?>" class="btn btn-dark">Cancel</a>
                            </div>
                        </div>
                    </form>

                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <form action="<?= base_url("categories/delete/$input->id_category") ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-danger">Hapus Kategori</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
