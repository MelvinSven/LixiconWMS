<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Pemindahan Barang Antar Gudang</h4>
                    <a href="<?= base_url('transfer') ?>" class="btn btn-secondary">
                        <i data-feather="arrow-left" class="feather-sm me-1"></i> Kembali
                    </a>
                </div>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('transfer/store') ?>" method="POST" id="formTransfer"
                    enctype="multipart/form-data">
                    <div class="row mb-4">
                        <div class="col-md-5">
                            <div class="card border border-primary">
                                <div class="card-header bg-primary text-white">
                                    <i data-feather="log-out" class="feather-sm me-1"></i> Gudang Asal
                                </div>
                                <div class="card-body">
                                    <?php if ($user_gudang_id): ?>
                                        <?php $assigned_wh = !empty($gudang_asal_options) ? $gudang_asal_options[0] : null; ?>
                                        <select name="_id_gudang_asal_display" id="id_gudang_asal" class="form-select"
                                            disabled>
                                            <?php if ($assigned_wh): ?>
                                                <option value="<?= $assigned_wh->id ?>" selected><?= $assigned_wh->nama ?>
                                                </option>
                                            <?php else: ?>
                                                <option value="">-- Tidak ada gudang yang ditetapkan --</option>
                                            <?php endif; ?>
                                        </select>
                                        <?php if ($assigned_wh): ?>
                                            <input type="hidden" name="id_gudang_asal" value="<?= $assigned_wh->id ?>">
                                        <?php endif; ?>
                                        <small class="text-muted mt-1 d-block">Gudang asal
                                            ditentukan berdasarkan gudang yang ditetapkan untuk anda</small>
                                    <?php else: ?>
                                        <select name="id_gudang_asal" id="id_gudang_asal" class="form-select" required>
                                            <option value="">-- Pilih Gudang Asal --</option>
                                            <?php foreach ($gudang_asal_options as $wh): ?>
                                                <option value="<?= $wh->id ?>"><?= $wh->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <i data-feather="arrow-right" class="text-primary"
                                    style="width: 48px; height: 48px;"></i>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card border border-success">
                                <div class="card-header bg-success text-white">
                                    <i data-feather="log-in" class="feather-sm me-1"></i> Gudang Tujuan
                                </div>
                                <div class="card-body">
                                    <select name="id_gudang_tujuan" id="id_gudang_tujuan" class="form-select" required>
                                        <option value="">-- Pilih Gudang Tujuan --</option>
                                        <?php foreach ($warehouses as $wh): ?>
                                            <option value="<?= $wh->id ?>"><?= $wh->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="2"
                            placeholder="Masukkan keterangan..."></textarea>
                    </div>

                    <div class="card border mt-3">
                        <div class="card-header bg-light">
                            <strong><i data-feather="camera" class="feather-sm me-1"></i> Bukti Foto Pengiriman</strong>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <input type="file" name="bukti_foto" id="bukti_foto" class="form-control"
                                        accept="image/*">
                                    <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                                </div>
                                <div class="col-md-6">
                                    <div id="previewContainer" style="display: none;">
                                        <img id="previewImage" src="" alt="Preview" class="img-thumbnail"
                                            style="max-height: 150px;">
                                        <button type="button" class="btn btn-sm btn-danger ms-2" id="btnRemovePhoto"
                                            title="Hapus foto">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border mt-3">
                        <div class="card-header bg-light">
                            <strong><i data-feather="truck" class="feather-sm me-1"></i> Nama Kurir</strong>
                        </div>
                        <div class="card-body">
                            <input type="text" name="nama_kurir" id="nama_kurir" class="form-control"
                                placeholder="Masukkan nama kurir..." maxlength="100" required>
                            <small class="text-muted">Wajib diisi sebelum proses transfer</small>
                        </div>
                    </div>

                    <div class="card border mt-4">
                        <div class="card-header bg-light">
                            <strong><i data-feather="package" class="feather-sm me-1"></i> Daftar Barang di
                                Gudang</strong>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info" id="alertSelectGudang">
                                <i data-feather="info" class="feather-sm me-1"></i>
                                Silakan pilih <strong>Gudang Asal</strong> terlebih dahulu untuk melihat stok barang
                                yang tersedia.
                            </div>

                            <div class="table-responsive" id="tableContainer" style="display: none;">
                                <table class="table table-bordered table-hover" id="tableItems">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%" class="text-center">
                                                <input type="checkbox" id="checkAll" title="Pilih Semua">
                                            </th>
                                            <th width="5%">No</th>
                                            <th width="30%">Nama Barang</th>
                                            <th width="15%">Satuan</th>
                                            <th width="15%" class="text-center">Stok Tersedia</th>
                                            <th width="20%">Qty Transfer</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyItems">
                                        <!-- Dynamic rows -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary btn-lg" id="btnSubmit" disabled>
                            <i data-feather="send" class="feather-sm me-1"></i> Proses
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const gudangAsal = document.getElementById('id_gudang_asal');
        const gudangTujuan = document.getElementById('id_gudang_tujuan');
        const alertSelectGudang = document.getElementById('alertSelectGudang');
        const tableContainer = document.getElementById('tableContainer');
        const tbodyItems = document.getElementById('tbodyItems');
        const btnSubmit = document.getElementById('btnSubmit');
        const checkAll = document.getElementById('checkAll');

        // Load stok ketika gudang asal dipilih
        function loadStokByGudang(id) {
            tbodyItems.innerHTML = '';
            checkAll.checked = false;

            if (!id) {
                alertSelectGudang.style.display = 'block';
                alertSelectGudang.className = 'alert alert-info';
                alertSelectGudang.innerHTML = '<i data-feather="info" class="feather-sm me-1"></i> Silakan pilih <strong>Gudang Asal</strong> terlebih dahulu untuk melihat stok barang yang tersedia.';
                tableContainer.style.display = 'none';
                btnSubmit.disabled = true;
                feather.replace();
                return;
            }

            fetch('<?= base_url('transfer/getStokByGudang/') ?>' + id)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.data.length === 0) {
                            alertSelectGudang.innerHTML = '<i data-feather="alert-circle" class="feather-sm me-1"></i> Tidak ada stok barang di gudang ini.';
                            alertSelectGudang.className = 'alert alert-warning';
                            alertSelectGudang.style.display = 'block';
                            tableContainer.style.display = 'none';
                            feather.replace();
                        } else {
                            alertSelectGudang.style.display = 'none';
                            tableContainer.style.display = 'block';
                            renderItems(data.data);
                        }
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alertSelectGudang.innerHTML = '<i data-feather="alert-triangle" class="feather-sm me-1"></i> Gagal memuat data stok.';
                    alertSelectGudang.className = 'alert alert-danger';
                    alertSelectGudang.style.display = 'block';
                    feather.replace();
                });
        }

        gudangAsal.addEventListener('change', function () {
            loadStokByGudang(this.value);
        });

        // Auto-load stok jika gudang asal sudah dipilih (untuk staff dengan gudang yang ditetapkan)
        if (gudangAsal.value) {
            loadStokByGudang(gudangAsal.value);
        }


        function renderItems(items) {
            tbodyItems.innerHTML = '';

            items.forEach((item, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td class="text-center">
                    <input type="checkbox" class="item-check" data-id="${item.id_barang}" data-stok="${item.qty}">
                </td>
                <td>${index + 1}</td>
                <td>${item.nama_barang}</td>
                <td>${item.nama_satuan}</td>
                <td class="text-center"><span>${item.qty}</span></td>
                <td>
                    <input type="number" class="form-control qty-input" min="1" max="${item.qty}" placeholder="0" disabled>
                    <input type="hidden" class="hidden-id" disabled>
                    <input type="hidden" class="hidden-qty" disabled>
                </td>
            `;
                tbodyItems.appendChild(tr);

                const checkbox = tr.querySelector('.item-check');
                const qtyInput = tr.querySelector('.qty-input');
                const hiddenId = tr.querySelector('.hidden-id');
                const hiddenQty = tr.querySelector('.hidden-qty');

                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        qtyInput.disabled = false;
                        qtyInput.value = 1;
                        hiddenId.name = 'id_barang[]';
                        hiddenId.value = item.id_barang;
                        hiddenId.disabled = false;
                        hiddenQty.name = 'qty[]';
                        hiddenQty.value = 1;
                        hiddenQty.disabled = false;
                        tr.classList.add('table-primary');
                    } else {
                        qtyInput.disabled = true;
                        qtyInput.value = '';
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
                    let max = parseInt(this.max) || 0;
                    if (val > max) {
                        this.value = max;
                        val = max;
                    }
                    hiddenQty.value = val;
                    checkSubmitButton();
                });

                qtyInput.addEventListener('blur', function () {
                    let val = parseInt(this.value) || 0;
                    if (val < 1 && !this.disabled) {
                        this.value = 1;
                        hiddenQty.value = 1;
                        checkSubmitButton();
                    }
                });
            });

            checkSubmitButton();
        }

        // Check All
        checkAll.addEventListener('change', function () {
            const isChecked = checkAll.checked;
            const checkboxes = tbodyItems.querySelectorAll('.item-check');
            checkboxes.forEach(cb => {
                if (cb.checked !== isChecked) {
                    cb.checked = isChecked;
                    cb.dispatchEvent(new Event('change'));
                }
            });
            checkAll.checked = isChecked;
        });

        function updateCheckAll() {
            const checkboxes = tbodyItems.querySelectorAll('.item-check');
            const checkedBoxes = tbodyItems.querySelectorAll('.item-check:checked');
            checkAll.checked = checkboxes.length > 0 && checkboxes.length === checkedBoxes.length;
        }

        function checkSubmitButton() {
            const checkedBoxes = tbodyItems.querySelectorAll('.item-check:checked');
            let hasValid = false;

            checkedBoxes.forEach(cb => {
                const row = cb.closest('tr');
                const qtyInput = row.querySelector('.qty-input');
                const val = parseInt(qtyInput.value) || 0;
                if (val > 0) hasValid = true;
            });

            btnSubmit.disabled = !hasValid || !gudangAsal.value || !gudangTujuan.value || gudangAsal.value === gudangTujuan.value;
        }

        gudangTujuan.addEventListener('change', checkSubmitButton);

        // Form validation
        document.getElementById('formTransfer').addEventListener('submit', function (e) {
            if (gudangAsal.value === gudangTujuan.value) {
                e.preventDefault();
                alert('Gudang asal dan tujuan tidak boleh sama!');
                return false;
            }

            const checkedBoxes = tbodyItems.querySelectorAll('.item-check:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu barang untuk ditransfer!');
                return false;
            }

            let hasError = false;
            checkedBoxes.forEach(cb => {
                const row = cb.closest('tr');
                const qtyInput = row.querySelector('.qty-input');
                const val = parseInt(qtyInput.value) || 0;
                const max = parseInt(qtyInput.max) || 0;

                if (val > max || val < 1) {
                    hasError = true;
                    qtyInput.classList.add('is-invalid');
                } else {
                    qtyInput.classList.remove('is-invalid');
                }
            });

            if (hasError) {
                e.preventDefault();
                alert('Qty tidak boleh melebihi stok yang tersedia!');
                return false;
            }
        });

        // Photo preview
        const buktiFoto = document.getElementById('bukti_foto');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        const btnRemovePhoto = document.getElementById('btnRemovePhoto');

        buktiFoto.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB!');
                    this.value = '';
                    previewContainer.style.display = 'none';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'inline-block';
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });

        btnRemovePhoto.addEventListener('click', function () {
            buktiFoto.value = '';
            previewContainer.style.display = 'none';
            previewImage.src = '';
        });
    });
</script>