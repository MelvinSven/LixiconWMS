<?php
// Tampilkan hanya item yang belum berstatus "Barang Sesuai"
$pending = array_filter($details, function ($d) {
    return (int) ($d->is_sesuai ?? -1) !== 1;
});
?>
<div class="row">
    <div class="col-12">
        <div class="card mt-4 mx-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-clipboard-check mr-2"></i> Verifikasi Barang — <?= $pr->kode_pr ?>
                </h4>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show"><?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-1"></i>
                    Centang barang yang <strong>diterima sesuai kuantitas</strong>. Jika tidak sesuai, biarkan tidak
                    dicentang
                    lalu isi kuantitas yang diterima dan keterangan ketidaksesuaian. Stok gudang akan langsung
                    diperbarui
                    berdasarkan kuantitas yang diterima.
                </div>

                <?php if (empty($pending)): ?>
                    <div class="alert alert-secondary">Tidak ada barang yang perlu diverifikasi.</div>
                <?php else: ?>
                    <form action="<?= base_url('purchaserequest/store_verifikasi/' . $pr->id) ?>" method="POST"
                        enctype="multipart/form-data" onsubmit="return confirm('Konfirmasi verifikasi barang?')">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tblVerif">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%" class="text-center">
                                            <input type="checkbox" id="checkAll" title="Semua Sesuai">
                                        </th>
                                        <th>Nama Barang</th>
                                        <th width="8%">Kuantitas Barang</th>
                                        <th width="13%">Kuantitas Diterima</th>
                                        <th width="25%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pending as $d): ?>
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" class="sesuai-check" name="barang_sesuai[]"
                                                    value="<?= $d->id ?>" data-qty="<?= (int) $d->qty ?>">
                                            </td>
                                            <td><?= htmlspecialchars($d->nama_barang) ?></td>
                                            <td class="text-right"><?= (int) $d->qty ?></td>
                                            <td>
                                                <input type="number" class="form-control qty-diterima" min="0"
                                                    max="<?= (int) $d->qty ?>" name="qty_diterima[<?= $d->id ?>]"
                                                    value="<?= $d->qty_diterima !== null ? (int) $d->qty_diterima : (int) $d->qty ?>">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control keterangan-input"
                                                    name="keterangan_verifikasi[<?= $d->id ?>]"
                                                    value="<?= htmlspecialchars($d->keterangan_verifikasi ?? '') ?>"
                                                    placeholder="Keterangan jika tidak sesuai...">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="card mt-4 mb-3">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <strong><i class="fas fa-file-pdf mr-1 text-danger"></i> Surat Jalan</strong>
                                <span class="badge badge-secondary"><?= count($surat_jalan_list) ?> file</span>
                            </div>
                            <div class="card-body py-3">
                                <?php if (!empty($surat_jalan_list)): ?>
                                    <table class="table table-sm table-bordered mb-3">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="4%">#</th>
                                                <th>Nama File</th>
                                                <th width="18%">Tanggal Upload</th>
                                                <th width="8%" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($surat_jalan_list as $i => $sj): ?>
                                                <tr>
                                                    <td><?= $i + 1 ?></td>
                                                    <td>
                                                        <i class="fas fa-file-pdf text-danger mr-1"></i>
                                                        <?= htmlspecialchars($sj->nama_file) ?>
                                                    </td>
                                                    <td><?= date('d M Y H:i', strtotime($sj->uploaded_at)) ?></td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url($sj->file_path) ?>" target="_blank"
                                                            class="btn btn-sm btn-outline-danger" title="Unduh">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php endif; ?>
                                <div class="form-group mb-0">
                                    <label for="file_surat_jalan" class="font-weight-bold mb-1">
                                        Tambah Surat Jalan <span class="text-muted font-weight-normal">(opsional, PDF maks.
                                            10 MB)</span>
                                    </label>
                                    <input type="file" name="file_surat_jalan" id="file_surat_jalan"
                                        class="form-control-file" accept="application/pdf,.pdf">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="<?= base_url('purchaserequest/detail/' . $pr->id) ?>" class="btn btn-secondary">
                                <i data-feather="arrow-left" class="feather-sm me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check mr-1"></i> Simpan Verifikasi
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tbl = document.getElementById('tblVerif');
        if (!tbl) return;
        const checkAll = document.getElementById('checkAll');

        function applyRow(tr) {
            const cb = tr.querySelector('.sesuai-check');
            const qtyInput = tr.querySelector('.qty-diterima');
            const ketInput = tr.querySelector('.keterangan-input');
            if (cb.checked) {
                qtyInput.value = cb.dataset.qty;
                qtyInput.readOnly = true;
                ketInput.value = '';
                ketInput.disabled = true;
                tr.classList.add('table-success');
            } else {
                qtyInput.readOnly = false;
                ketInput.disabled = false;
                tr.classList.remove('table-success');
            }
        }

        tbl.querySelectorAll('tbody tr').forEach(function (tr) {
            const cb = tr.querySelector('.sesuai-check');
            cb.addEventListener('change', function () { applyRow(tr); updateAll(); });
            applyRow(tr);
        });

        checkAll.addEventListener('change', function () {
            const isChecked = checkAll.checked;
            tbl.querySelectorAll('.sesuai-check').forEach(cb => {
                cb.checked = isChecked;
                cb.dispatchEvent(new Event('change'));
            });
        });

        function updateAll() {
            const all = tbl.querySelectorAll('.sesuai-check');
            const checked = tbl.querySelectorAll('.sesuai-check:checked');
            checkAll.checked = all.length > 0 && all.length === checked.length;
        }
    });
</script>