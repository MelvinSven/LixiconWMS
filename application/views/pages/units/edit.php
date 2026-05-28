<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card" style="border-radius:12px;border:1px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4">
                        <div style="width:38px;height:38px;background:#eff6ff;color:#2563eb;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-right:12px;flex-shrink:0;">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div>
                            <h5 style="margin:0;font-size:0.95rem;font-weight:600;color:#0f172a;">Edit Satuan Barang</h5>
                            <p style="margin:0;font-size:0.75rem;color:#94a3b8;">Ubah nama satuan</p>
                        </div>
                    </div>

                    <form action="<?= base_url("units/edit/$input->id") ?>" method="POST">
                        <?= form_hidden('id', $input->id) ?>

                        <div class="form-group mb-4">
                            <label style="font-size:0.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;">Nama Satuan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background:#f8fafc;border-color:#e2e8f0;border-radius:8px 0 0 8px;">
                                        <i class="fas fa-tag" style="color:#94a3b8;font-size:0.8rem;"></i>
                                    </span>
                                </div>
                                <?= form_input('nama', $input->nama, [
                                    'class'       => 'form-control',
                                    'required'    => true,
                                    'placeholder' => 'Nama satuan (huruf kecil)',
                                    'style'       => 'border-color:#e2e8f0;font-size:0.88rem;border-radius:0 8px 8px 0;'
                                ]) ?>
                            </div>
                            <?= form_error('nama', '<p class="text-danger mt-1 mb-0" style="font-size:0.78rem;">', '</p>') ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-2" style="border-top:1px solid #f1f5f9;">
                            <a href="<?= base_url('units') ?>" class="btn btn-light btn-sm" style="border-radius:8px;font-size:0.83rem;border:1px solid #e2e8f0;color:#475569;">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm" style="border-radius:8px;background:#2563eb;border-color:#2563eb;font-size:0.83rem;padding:0.4rem 1.2rem;font-weight:500;">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
