<div class="row">
    <div class="col-12">
        <div class="card mt-4 mx-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-file-invoice mr-2"></i> Buat Purchase Request
                    </h4>
                    <a href="<?= base_url('purchaserequest') ?>" class="btn btn-secondary">
                        <i data-feather="arrow-left" class="feather-sm me-1"></i> Kembali
                    </a>
                </div>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('purchaserequest/store') ?>" method="POST" id="formPR"
                    enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Tanggal PR</strong></label>
                                <input type="date" name="tanggal_pr" id="tanggal_pr" class="form-control"
                                    value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Gudang Tujuan</strong></label>
                                <select name="id_gudang" class="form-control" required>
                                    <option value="">-- Pilih Gudang --</option>
                                    <?php foreach ($warehouses as $wh): ?>
                                        <option value="<?= $wh->id ?>"><?= htmlspecialchars($wh->nama) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label><strong>Foto Purchase Request</strong> <span
                                class="text-muted font-weight-normal">(opsional, JPG/PNG, maks. 2 MB)</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="foto_pr" name="foto_pr"
                                accept="image/jpeg,image/png">
                            <label class="custom-file-label" for="foto_pr">Pilih gambar...</label>
                        </div>
                        <div id="fotoPreviewWrap" class="mt-2" style="display:none;">
                            <img id="fotoPreview" src="" alt="Preview" class="img-thumbnail" style="max-height:200px;">
                        </div>
                    </div>

                    <!-- <div class="form-group mb-4">
                        <label><strong>Justifikasi / Keterangan PR</strong></label>
                        <textarea name="keterangan" class="form-control" rows="2"
                            placeholder="Alasan pengadaan barang ini..."></textarea>
                    </div> -->

                    <div class="card border">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <strong><i class="feather-sm me-1"></i>Daftar Barang</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="4%" class="text-center">
                                                <input type="checkbox" id="checkAll" title="Pilih Semua">
                                            </th>
                                            <th width="4%">No</th>
                                            <th width="30%">Nama Barang</th>
                                            <th width="10%">Satuan</th>
                                            <th width="10%">Qty</th>
                                            <th width="23%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyItems">
                                        <?php if (empty($items)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-3">Belum ada barang di
                                                    katalog.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($items as $i => $it): ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="checkbox" class="item-check" data-id="<?= $it->id ?>">
                                                    </td>
                                                    <td><?= $i + 1 ?></td>
                                                    <td><?= htmlspecialchars($it->nama) ?></td>
                                                    <td><?= htmlspecialchars($it->nama_satuan ?? '-') ?></td>
                                                    <td>
                                                        <input type="number" class="form-control qty-input" min="1"
                                                            placeholder="0" disabled>
                                                        <input type="hidden" class="hidden-id" disabled>
                                                        <input type="hidden" class="hidden-qty" disabled>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control keterangan-input"
                                                            name="keterangan_barang[]" placeholder="Catatan..." disabled>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card border mt-3">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <strong><i class="fas fa-edit mr-1"></i>Tambah Barang</strong>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="btnAddManual">
                                <i class="fas fa-plus mr-1"></i> Tambah Barang
                            </button>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-2">
                                Gunakan bagian ini untuk mengajukan barang yang belum terdaftar di katalog.
                                Stok gudang tidak akan diperbarui otomatis saat verifikasi item manual.
                            </p>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tblManual">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="4%">No</th>
                                            <th width="32%">Nama Barang</th>
                                            <th width="15%">Satuan</th>
                                            <th width="10%">Qty</th>
                                            <th width="30%">Keterangan</th>
                                            <th width="6%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyManual">
                                        <tr id="manualEmptyRow">
                                            <td colspan="6" class="text-center text-muted py-3">
                                                Belum ada barang. Klik tombol "Tambah Barang" untuk menambah.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <template id="manualRowTemplate">
                        <tr class="manual-row">
                            <td class="manual-no"></td>
                            <td>
                                <input type="text" class="form-control manual-nama" name="manual_nama[]"
                                    placeholder="Nama barang..." maxlength="50" required>
                            </td>
                            <td>
                                <select class="form-control manual-satuan" name="manual_id_satuan[]" required>
                                    <option value="">-- Pilih Satuan --</option>
                                    <?php foreach (($units ?? []) as $u): ?>
                                        <option value="<?= $u->id ?>"><?= htmlspecialchars($u->nama) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control manual-qty" name="manual_qty[]" min="1"
                                    placeholder="0" required>
                            </td>
                            <td>
                                <input type="text" class="form-control manual-keterangan" name="manual_keterangan[]"
                                    placeholder="Catatan...">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-danger btnRemoveManual"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </template>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary btn-lg" id="btnSubmit" disabled>
                            <i class="fas fa-paper-plane me-1"></i> Buat Purchase Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tbody = document.getElementById('tbodyItems');
        const checkAll = document.getElementById('checkAll');
        const btnSubmit = document.getElementById('btnSubmit');

        tbody.querySelectorAll('tr').forEach(function (tr) {
            const cb = tr.querySelector('.item-check');
            if (!cb) return;
            const qtyInput = tr.querySelector('.qty-input');
            const keteranganInput = tr.querySelector('.keterangan-input');
            const hiddenId = tr.querySelector('.hidden-id');
            const hiddenQty = tr.querySelector('.hidden-qty');

            cb.addEventListener('change', function () {
                if (this.checked) {
                    qtyInput.disabled = false;
                    qtyInput.value = 1;
                    keteranganInput.disabled = false;
                    hiddenId.name = 'id_barang[]';
                    hiddenId.value = cb.dataset.id;
                    hiddenId.disabled = false;
                    hiddenQty.name = 'qty[]';
                    hiddenQty.value = 1;
                    hiddenQty.disabled = false;
                    tr.classList.add('table-primary');
                } else {
                    qtyInput.disabled = true;
                    qtyInput.value = '';
                    keteranganInput.disabled = true;
                    keteranganInput.value = '';
                    hiddenId.disabled = true;
                    hiddenId.removeAttribute('name');
                    hiddenQty.disabled = true;
                    hiddenQty.removeAttribute('name');
                    tr.classList.remove('table-primary');
                }
                updateCheckAll();
                checkSubmitButton();
            });

            qtyInput.addEventListener('input', function () {
                let val = parseInt(this.value) || 0;
                if (val < 1) val = 1;
                this.value = val;
                hiddenQty.value = val;
                checkSubmitButton();
            });
        });

        checkAll.addEventListener('change', function () {
            const isChecked = checkAll.checked;
            tbody.querySelectorAll('.item-check').forEach(cb => {
                if (cb.checked !== isChecked) {
                    cb.checked = isChecked;
                    cb.dispatchEvent(new Event('change'));
                }
            });
        });

        function updateCheckAll() {
            const all = tbody.querySelectorAll('.item-check');
            const checked = tbody.querySelectorAll('.item-check:checked');
            checkAll.checked = all.length > 0 && all.length === checked.length;
        }

        function checkSubmitButton() {
            const checked = tbody.querySelectorAll('.item-check:checked');
            let valid = false;
            checked.forEach(cb => {
                const qty = parseInt(cb.closest('tr').querySelector('.qty-input').value) || 0;
                if (qty > 0) valid = true;
            });
            if (!valid) {
                valid = hasValidManualRow();
            }
            btnSubmit.disabled = !valid;
        }

        // --- Manual items ---
        const tbodyManual = document.getElementById('tbodyManual');
        const manualEmptyRow = document.getElementById('manualEmptyRow');
        const manualTemplate = document.getElementById('manualRowTemplate');

        function renumberManual() {
            let i = 1;
            tbodyManual.querySelectorAll('.manual-row').forEach(tr => {
                tr.querySelector('.manual-no').textContent = i++;
            });
        }

        function hasValidManualRow() {
            const rows = tbodyManual.querySelectorAll('.manual-row');
            for (const tr of rows) {
                const nama = tr.querySelector('.manual-nama').value.trim();
                const qty = parseInt(tr.querySelector('.manual-qty').value) || 0;
                if (nama !== '' && qty > 0) return true;
            }
            return false;
        }

        function addManualRow() {
            const clone = manualTemplate.content.firstElementChild.cloneNode(true);
            clone.querySelector('.btnRemoveManual').addEventListener('click', function () {
                clone.remove();
                if (tbodyManual.querySelectorAll('.manual-row').length === 0) {
                    manualEmptyRow.style.display = '';
                }
                renumberManual();
                checkSubmitButton();
            });
            ['.manual-nama', '.manual-qty', '.manual-satuan', '.manual-keterangan'].forEach(sel => {
                clone.querySelector(sel).addEventListener('input', checkSubmitButton);
                clone.querySelector(sel).addEventListener('change', checkSubmitButton);
            });
            manualEmptyRow.style.display = 'none';
            tbodyManual.appendChild(clone);
            renumberManual();
            checkSubmitButton();
        }

        document.getElementById('btnAddManual').addEventListener('click', addManualRow);

        // Foto PR — update label + show preview
        const fotoInput = document.getElementById('foto_pr');
        fotoInput.addEventListener('change', function () {
            const label = this.closest('.custom-file').querySelector('.custom-file-label');
            const previewWrap = document.getElementById('fotoPreviewWrap');
            const preview = document.getElementById('fotoPreview');
            if (this.files && this.files[0]) {
                label.textContent = this.files[0].name;
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    previewWrap.style.display = '';
                };
                reader.readAsDataURL(this.files[0]);
            } else {
                label.textContent = 'Pilih gambar...';
                previewWrap.style.display = 'none';
                preview.src = '';
            }
        });

        document.getElementById('formPR').addEventListener('submit', function (e) {
            const checked = tbody.querySelectorAll('.item-check:checked');
            if (checked.length === 0 && !hasValidManualRow()) {
                e.preventDefault();
                alert('Tambahkan minimal satu barang (katalog atau manual).');
                return;
            }
            // Buang baris manual yang tidak lengkap agar tidak ikut terkirim
            tbodyManual.querySelectorAll('.manual-row').forEach(tr => {
                const nama = tr.querySelector('.manual-nama').value.trim();
                const qty = parseInt(tr.querySelector('.manual-qty').value) || 0;
                if (nama === '' || qty <= 0) tr.remove();
            });
        });
    });
</script>