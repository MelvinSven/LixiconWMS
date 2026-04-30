<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Buat Surat Jalan -
                        <?= $permintaan->kode_permintaan ?>
                    </h4>
                    <a href="<?= base_url('preorder/detail/' . $permintaan->id) ?>" class="btn btn-secondary">
                        <i data-feather="arrow-left" class="feather-sm me-1"></i> Kembali
                    </a>
                </div>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('preorder/store_surat_jalan/' . $permintaan->id) ?>" method="POST" enctype="multipart/form-data">
                    <!-- Info Surat Jalan -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Nomor Pengiriman</strong></label>
                                <input type="text" name="nomor_pengiriman" class="form-control"
                                    placeholder="Masukkan nomor pengiriman..." required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Tanggal Pengiriman</strong></label>
                                <input type="date" name="tanggal_pengiriman" class="form-control"
                                    value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label><strong>Foto Surat Jalan <span class="text-muted font-weight-normal">(Opsional)</span></strong></label>
                                <input type="file" name="foto_surat_jalan" id="foto_surat_jalan"
                                    class="form-control-file" accept="image/jpeg,image/png">
                                <small class="text-muted">Format: JPG, PNG. Maks 2MB.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Info Gudang -->
                    <div class="alert alert-info">
                        <strong>Dari Gudang:</strong>
                        <?= $permintaan->nama_gudang_asal ?>
                        <i class="fas fa-arrow-right mx-2"></i>
                        <strong>Gudang Tujuan:</strong>
                        <?= $permintaan->nama_gudang_tujuan ?>
                    </div>

                    <!-- Daftar Barang -->
                    <div class="card border mt-3">
                        <div class="card-header bg-light">
                            <strong><i data-feather="package" class="feather-sm me-1"></i> Daftar Barang</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="8%">No</th>
                                            <th width="30%">Nama Barang</th>
                                            <th width="12%">Satuan</th>
                                            <th width="15%">Kuantitas</th>
                                            <th width="35%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($details as $item): ?>
                                            <tr>
                                                <td>
                                                    <?= $no++ ?>
                                                </td>
                                                <td>
                                                    <?= $item->nama_barang ?? '-' ?>
                                                    <input type="hidden" name="id_barang[]" value="<?= $item->id_barang ?>">
                                                </td>
                                                <td>
                                                    <?= $item->nama_satuan ?? '-' ?>
                                                </td>
                                                <td>
                                                    <input type="number" name="qty[]" class="form-control"
                                                        value="<?= $item->qty ?>" min="1" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="keterangan_barang[]" class="form-control"
                                                        value="<?= $item->keterangan ?? '' ?>" placeholder="Keterangan...">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary btn-lg"
                            onclick="return confirm('Buat surat jalan ini?')">
                            <i class="fas fa-save mr-1"></i> Simpan Surat Jalan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>