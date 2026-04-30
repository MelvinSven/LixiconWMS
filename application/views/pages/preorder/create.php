<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">
                        <i data-feather="clipboard" class="feather-sm me-2"></i>
                        Buat Permintaan Barang
                    </h4>
                    <a href="<?= base_url('preorder') ?>" class="btn btn-secondary">
                        <i data-feather="arrow-left" class="feather-sm me-1"></i> Kembali
                    </a>
                </div>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('preorder/store') ?>" method="POST" id="formPermintaan">
                    <!-- Info Permintaan -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Tanggal Permintaan</strong></label>
                                <input type="date" name="tanggal_permintaan" id="tanggal_permintaan"
                                    class="form-control" value="<?= date('Y-m-d') ?>"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Gudang Selection -->
                    <div class="row mb-4">
                        <div class="col-md-5">
                            <div class="card border border-primary">
                                <div class="card-header bg-primary text-white">
                                    <i data-feather="log-out" class="feather-sm me-1"></i> Dari Gudang (Sumber)
                                </div>
                                <div class="card-body d-flex flex-column align-items-center">
                                    <div class="w-100 mx-auto" style="max-width: 500px;">
                                        <select name="id_gudang_asal" id="id_gudang_asal" class="form-select w-100"
                                            required>
                                            <option value="">Pilih Gudang Sumber</option>
                                            <?php foreach ($warehouses as $wh): ?>
                                                <?php if ($user_gudang && $wh->id == $user_gudang->id): ?>
                                                    <option value="<?= $wh->id ?>" disabled style="color: #999;">
                                                        <?= $wh->nama ?> (Gudang Anda - tidak dapat dipilih)
                                                    </option>
                                                <?php else: ?>
                                                    <option value="<?= $wh->id ?>">
                                                        <?= $wh->nama ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="text-muted d-block mt-1">Gudang dari mana barang akan
                                            diambil</small>
                                    </div>
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
                                    <i data-feather="log-in" class="feather-sm me-1"></i> Gudang Tujuan (Penerima)
                                </div>
                                <div class="card-body">
                                    <?php if ($user_gudang): ?>
                                        <div class="alert alert-success mb-0">
                                            <h5 class="mb-1"><i class="fas fa-warehouse mr-2"></i><?= $user_gudang->nama ?>
                                            </h5>
                                            <small class="text-muted">Gudang Anda yang akan menerima barang</small>
                                        </div>
                                        <input type="hidden" name="id_gudang_tujuan" value="<?= $user_gudang->id ?>">
                                    <?php else: ?>
                                        <select name="id_gudang_tujuan" id="id_gudang_tujuan" class="form-select" required>
                                            <option value="">Pilih Gudang Tujuan</option>
                                            <?php foreach ($warehouses as $wh): ?>
                                                <option value="<?= $wh->id ?>">
                                                    <?= $wh->nama ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="text-muted d-block mt-1">Gudang yang akan menerima barang</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label class="form-label"><strong>Keterangan (Opsional)</strong></label>
                        <textarea name="keterangan" class="form-control" rows="2"
                            placeholder="Masukkan keterangan permintaan..."></textarea>
                    </div>

                    <!-- Daftar Barang di Gudang -->
                    <div class="card border mt-4">
                        <div class="card-header bg-light">
                            <strong><i data-feather="package" class="feather-sm me-1"></i> Daftar Barang di
                                Gudang</strong>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info" id="alertSelectGudang">
                                <i data-feather="info" class="feather-sm me-1"></i>
                                Silakan pilih <strong>Gudang Sumber</strong> terlebih dahulu untuk melihat stok barang
                                yang tersedia.
                            </div>

                            <div class="table-responsive" id="tableContainer" style="display: none;">
                                <table class="table table-bordered table-hover" id="tableItems">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="4%" class="text-center">
                                                <input type="checkbox" id="checkAll" title="Pilih Semua">
                                            </th>
                                            <th width="4%">No</th>
                                            <th width="30%">Nama Barang</th>
                                            <th width="10%">Satuan</th>
                                            <th width="10%" class="text-center">Stok Tersedia</th>
                                            <th width="13%">Qty Permintaan</th>
                                            <th width="25%">Keterangan</th>
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
                            <i data-feather="send" class="feather-sm me-1"></i> Kirim Permintaan
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
        const alertSelectGudang = document.getElementById('alertSelectGudang');
        const tableContainer = document.getElementById('tableContainer');
        const tbodyItems = document.getElementById('tbodyItems');
        const btnSubmit = document.getElementById('btnSubmit');
        const checkAll = document.getElementById('checkAll');

        // Load stok ketika gudang asal dipilih
        gudangAsal.addEventListener('change', function () {
            const id = this.value;
            const idGudangTujuan = document.getElementById('id_gudang_tujuan')?.value || '<?= $user_gudang ? $user_gudang->id : "" ?>';

            if (id && idGudangTujuan && id === idGudangTujuan) {
                alert('Gudang sumber tidak boleh sama dengan gudang tujuan!');
                this.value = '';
                return;
            }

            tbodyItems.innerHTML = '';
            checkAll.checked = false;

            if (!id) {
                alertSelectGudang.style.display = 'block';
                alertSelectGudang.className = 'alert alert-info';
                alertSelectGudang.innerHTML = '<i data-feather="info" class="feather-sm me-1"></i> Silakan pilih <strong>Gudang Sumber</strong> terlebih dahulu untuk melihat stok barang yang tersedia.';
                tableContainer.style.display = 'none';
                btnSubmit.disabled = true;
                feather.replace();
                return;
            }

            fetch('<?= base_url('preorder/getStokByGudang/') ?>' + id)
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
        });

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
                <td>
                    <input type="text" class="form-control keterangan-input" name="keterangan_barang[]" placeholder="Keterangan..." disabled>
                </td>
            `;
                tbodyItems.appendChild(tr);

                const checkbox = tr.querySelector('.item-check');
                const qtyInput = tr.querySelector('.qty-input');
                const hiddenId = tr.querySelector('.hidden-id');
                const hiddenQty = tr.querySelector('.hidden-qty');
                const keteranganInput = tr.querySelector('.keterangan-input');

                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        qtyInput.disabled = false;
                        qtyInput.value = 1;
                        keteranganInput.disabled = false;
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

            btnSubmit.disabled = !hasValid || !gudangAsal.value;
        }

        const tglPermintaan = document.getElementById('tanggal_permintaan');

        // Form validation
        document.getElementById('formPermintaan').addEventListener('submit', function (e) {
            const idGudangAsal = gudangAsal.value;
            const idGudangTujuan = document.getElementById('id_gudang_tujuan')?.value || '<?= $user_gudang ? $user_gudang->id : "" ?>';

            if (idGudangAsal && idGudangTujuan && idGudangAsal === idGudangTujuan) {
                e.preventDefault();
                alert('Gudang sumber tidak boleh sama dengan gudang tujuan!');
                return false;
            }

            if (!idGudangTujuan) {
                e.preventDefault();
                alert('Pilih gudang tujuan!');
                return false;
            }
            const checkedBoxes = tbodyItems.querySelectorAll('.item-check:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu barang untuk diminta!');
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
                alert('Qty tidak boleh melebihi stok yang tersedia atau kurang dari 1!');
                return false;
            }
        });
    });
</script>