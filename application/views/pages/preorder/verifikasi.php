<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-clipboard-check me-2"></i>
                        Verifikasi Penerimaan Barang -
                        <?= $permintaan->kode_permintaan ?>
                    </h4>
                    <a href="<?= base_url('preorder/detail/' . $permintaan->id) ?>" class="btn btn-secondary">
                        <i data-feather="arrow-left" class="feather-sm me-1"></i> Kembali
                    </a>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-1"></i>
                    Centang barang yang <strong>sesuai</strong> dengan surat jalan.
                    Barang yang tidak dicentang akan dianggap <strong>tidak sesuai</strong>.
                    Masukkan <strong>jumlah yang diterima</strong> dan berikan keterangan untuk barang yang tidak
                    sesuai.
                </div>

                <!-- Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td width="40%"><strong>No. Surat Jalan</strong></td>
                                <td>:
                                    <?= $surat_jalan->nomor_pengiriman ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Dari Gudang</strong></td>
                                <td>:
                                    <?= $permintaan->nama_gudang_asal ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td width="40%"><strong>Tgl Pengiriman</strong></td>
                                <td>:
                                    <?= date('d F Y', strtotime($surat_jalan->tanggal_pengiriman)) ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Gudang Tujuan</strong></td>
                                <td>:
                                    <?= $permintaan->nama_gudang_tujuan ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <form action="<?= base_url('preorder/store_verifikasi/' . $permintaan->id) ?>" method="POST"
                    id="formVerifikasi">
                    <div class="card border">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <strong><i data-feather="package" class="feather-sm me-1"></i> Daftar Barang</strong>
                            <div>
                                <button type="button" class="btn btn-sm btn-success" id="btnCheckAll">
                                    <i class="fas fa-check-double mr-1"></i> Centang Semua
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btnUncheckAll">
                                    <i class="fas fa-times mr-1"></i> Hapus Semua
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="7%" class="text-center">Sesuai</th>
                                            <th width="4%">No</th>
                                            <th width="22%">Nama Barang</th>
                                            <th width="8%">Satuan</th>
                                            <th width="9%" class="text-center">Qty Kirim</th>
                                            <th width="12%" class="text-center">Qty Diterima</th>
                                            <th width="10%" class="text-center">Status</th>
                                            <th width="28%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($details as $item): ?>
                                            <tr id="row-<?= $item->id_barang ?>">
                                                <td class="text-center">
                                                    <input type="checkbox" name="barang_sesuai[]"
                                                        value="<?= $item->id_barang ?>" class="check-sesuai" checked
                                                        style="width:20px;height:20px;">
                                                </td>
                                                <td>
                                                    <?= $no++ ?>
                                                </td>
                                                <td>
                                                    <?= $item->nama_barang ?? '-' ?>
                                                </td>
                                                <td>
                                                    <?= $item->nama_satuan ?? '-' ?>
                                                </td>
                                                <td class="text-center"><strong>
                                                        <?= number_format($item->qty) ?>
                                                    </strong></td>
                                                <td class="text-center qty-diterima-cell">
                                                    <input type="number" name="qty_diterima[<?= $item->id_barang ?>]"
                                                        class="form-control form-control-sm text-center qty-diterima-input"
                                                        value="<?= $item->qty ?>" min="0" max="<?= $item->qty ?>" disabled>
                                                </td>
                                                <td class="text-center status-cell">
                                                    <span class="badge badge-success"><i
                                                            class="fas fa-check mr-1"></i>Sesuai</span>
                                                </td>
                                                <td>
                                                    <input type="text" name="keterangan_verifikasi[<?= $item->id_barang ?>]"
                                                        class="form-control keterangan-input" placeholder="Keterangan..."
                                                        disabled>
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
                            onclick="return confirm('Proses verifikasi penerimaan barang?')">
                            <i class="fas fa-save mr-1"></i> Simpan Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.check-sesuai');

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const row = this.closest('tr');
                const statusCell = row.querySelector('.status-cell');
                const ketInput = row.querySelector('.keterangan-input');
                const qtyInput = row.querySelector('.qty-diterima-input');

                if (this.checked) {
                    statusCell.innerHTML = '<span class="badge badge-success"><i class="fas fa-check mr-1"></i>Sesuai</span>';
                    ketInput.disabled = true;
                    ketInput.value = '';
                    qtyInput.disabled = true;
                    qtyInput.value = qtyInput.max; // Reset to full qty
                    row.classList.remove('table-danger');
                } else {
                    statusCell.innerHTML = '<span class="badge badge-danger"><i class="fas fa-times mr-1"></i>Tidak Sesuai</span>';
                    ketInput.disabled = false;
                    qtyInput.disabled = false;
                    qtyInput.value = 0; // Default to 0 when unchecked
                    qtyInput.focus();
                    row.classList.add('table-danger');
                }
            });
        });

        document.getElementById('btnCheckAll').addEventListener('click', function () {
            checkboxes.forEach(cb => { cb.checked = true; cb.dispatchEvent(new Event('change')); });
        });

        document.getElementById('btnUncheckAll').addEventListener('click', function () {
            checkboxes.forEach(cb => { cb.checked = false; cb.dispatchEvent(new Event('change')); });
        });
    });
</script>