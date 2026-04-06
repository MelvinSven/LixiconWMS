<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit Satuan</h4>
                    <form action="<?= base_url("units/edit/$input->id") ?>" method="POST">
                        <?= form_hidden('id', $input->id) ?>
                        <div class="form-body">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-2">Nama Satuan</label>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="inputGroupSelect01"><i class="fas fa-box"></i></label>
                                                    </div>
                                                    <?= form_input('nama', $input->nama, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Huruf kecil semua']) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-12">
                                                <?= form_error('nama') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <div class="row">
                                        <label class="col-lg-2">Satuan</label>
                                        <div class="col-lg-10">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="supplier-options"><i class="fas fa-check-square"></i></label>
                                                        </div>
                                                        <select class="form-control" name="status" id="supplier-options">
                                                            <option value="valid" <?= $input->status == 'valid' ? 'selected' : '' ?>>Valid</option>
                                                            <option value="invalid" <?= $input->status == 'invalid' ? 'selected' : '' ?>>Tidak Valid</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="<?= base_url('units') ?>" class="btn btn-dark">Cancel</a>
                            </div>
                        </div>
                    </form>

                    <!-- Tombol Hapus hanya untuk Admin -->
                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <!-- Form hapus stock hanya untuk admin -->
                        <form action="<?= base_url("units/delete/$input->id") ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus stock ini?');">
                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-danger">Hapus Stock</button>
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
