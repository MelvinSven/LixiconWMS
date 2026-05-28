<style>
    /* ── Create Permintaan Barang ─────────────────────────────── */
    .create-preorder .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .create-preorder .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .create-preorder .btn-back {
        height: 36px;
        padding: 0 14px;
        background: #f1f5f9;
        color: #475569;
        border: none;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }

    .create-preorder .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .create-preorder .form-body {
        padding: 24px;
    }

    .create-preorder .section-label {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #94a3b8;
        margin-bottom: 12px;
        margin-top: 0;
    }

    .create-preorder .field-label {
        font-size: 0.82rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
        display: block;
    }

    .create-preorder .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #0f172a;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .create-preorder .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: #fff;
        outline: none;
    }

    .create-preorder select.form-control {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
    }

    .create-preorder textarea.form-control {
        height: auto;
        resize: none;
    }

    /* Section divider */
    .create-preorder .section-divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 24px 0;
    }

    /* Warehouse route */
    .wh-route {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 12px;
        align-items: start;
    }

    .wh-box {
        border-radius: 10px;
        padding: 16px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
    }

    .wh-box.source { border-top: 3px solid #2563eb; }
    .wh-box.dest   { border-top: 3px solid #16a34a; }

    .wh-box .wh-label {
        font-size: 0.68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 10px;
        margin-top: 0;
    }

    .wh-box.source .wh-label { color: #2563eb; }
    .wh-box.dest   .wh-label { color: #16a34a; }

    .wh-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 34px;
        color: #cbd5e1;
    }

    .wh-dest-fixed {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #dcfce7;
        border-radius: 8px;
        padding: 10px 12px;
    }

    .wh-dest-fixed .wh-name {
        font-size: 0.88rem;
        font-weight: 600;
        color: #15803d;
        margin: 0;
    }

    .wh-dest-fixed .wh-sub {
        font-size: 0.72rem;
        color: #16a34a;
        margin: 2px 0 0;
    }

    /* Items section */
    .items-section {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .items-section .items-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.82rem;
        font-weight: 600;
        color: #374151;
    }

    .items-alert {
        padding: 20px 16px;
    }

    /* Items table */
    .items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .items-table thead th {
        font-size: 0.7rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #94a3b8;
        padding: 10px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .items-table tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.1s;
    }

    .items-table tbody tr:hover { background: #fafbfd; }
    .items-table tbody tr:last-child { border-bottom: none; }
    .items-table tbody tr.selected { background: #eff6ff; }

    .items-table tbody td {
        padding: 12px 14px;
        vertical-align: middle;
        font-size: 0.84rem;
        color: #374151;
    }

    .items-table .check-col { text-align: center; width: 44px; }

    .stok-badge {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 600;
        color: #059669;
        background: #d1fae5;
        padding: 2px 8px;
        border-radius: 20px;
    }

    .stok-badge.low {
        color: #d97706;
        background: #fef3c7;
    }

    /* Inline table inputs */
    .qty-field {
        border: 1.5px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.82rem;
        padding: 5px 8px;
        width: 80px;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
        color: #0f172a;
    }

    .qty-field:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        background: #fff;
        outline: none;
    }

    .qty-field:disabled {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .note-field {
        border: 1.5px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.82rem;
        padding: 5px 10px;
        width: 100%;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
        color: #0f172a;
    }

    .note-field:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        background: #fff;
        outline: none;
    }

    .note-field:disabled {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }

    /* Form actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        margin-top: 24px;
    }

    .btn-submit {
        height: 38px;
        padding: 0 20px;
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }

    .btn-submit:hover:not(:disabled) { background: #1d4ed8; }

    .btn-submit:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    @media (max-width: 767px) {
        .wh-route {
            grid-template-columns: 1fr;
        }

        .wh-arrow {
            padding-top: 0;
            transform: rotate(90deg);
        }
    }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card create-preorder"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- Header -->
                <div class="card-header-custom">
                    <h5 class="page-title">Buat Permintaan Barang</h5>
                    <a href="<?= base_url('preorder') ?>" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <!-- Form body -->
                <div class="form-body">
                    <form action="<?= base_url('preorder/store') ?>" method="POST" id="formPermintaan">

                        <!-- Date + Notes -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="field-label">
                                        Tanggal Permintaan <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal_permintaan" id="tanggal_permintaan"
                                        class="form-control" value="<?= date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="field-label">
                                        Keterangan
                                        <span style="color:#94a3b8; font-weight:400;">(Opsional)</span>
                                    </label>
                                    <textarea name="keterangan" class="form-control" rows="2"
                                        placeholder="Masukkan keterangan permintaan..."></textarea>
                                </div>
                            </div>
                        </div>

                        <hr class="section-divider">

                        <!-- Warehouse route -->
                        <p class="section-label">Rute Permintaan</p>
                        <div class="wh-route mb-4">

                            <!-- Source -->
                            <div class="wh-box source">
                                <p class="wh-label">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Gudang Sumber
                                </p>
                                <select name="id_gudang_asal" id="id_gudang_asal"
                                    class="form-control" required>
                                    <option value="">Pilih gudang sumber...</option>
                                    <?php foreach ($warehouses as $wh): ?>
                                        <?php if ($user_gudang && $wh->id == $user_gudang->id): ?>
                                            <option value="<?= $wh->id ?>" disabled style="color:#94a3b8;">
                                                <?= htmlspecialchars($wh->nama) ?> (gudang Anda)
                                            </option>
                                        <?php else: ?>
                                            <option value="<?= $wh->id ?>">
                                                <?= htmlspecialchars($wh->nama) ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <p style="font-size:0.72rem; color:#94a3b8; margin-top:6px; margin-bottom:0;">
                                    Gudang dari mana barang akan diambil
                                </p>
                            </div>

                            <!-- Arrow -->
                            <div class="wh-arrow">
                                <i class="fas fa-arrow-right" style="font-size:1.1rem;"></i>
                            </div>

                            <!-- Destination -->
                            <div class="wh-box dest">
                                <p class="wh-label">
                                    <i class="fas fa-sign-in-alt mr-1"></i> Gudang Tujuan
                                </p>
                                <?php if ($user_gudang): ?>
                                    <div class="wh-dest-fixed">
                                        <i class="fas fa-warehouse" style="color:#16a34a; font-size:1rem;"></i>
                                        <div>
                                            <p class="wh-name"><?= htmlspecialchars($user_gudang->nama) ?></p>
                                            <p class="wh-sub">Gudang Anda · akan menerima barang</p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id_gudang_tujuan" value="<?= $user_gudang->id ?>">
                                <?php else: ?>
                                    <select name="id_gudang_tujuan" id="id_gudang_tujuan"
                                        class="form-control" required>
                                        <option value="">Pilih gudang tujuan...</option>
                                        <?php foreach ($warehouses as $wh): ?>
                                            <option value="<?= $wh->id ?>">
                                                <?= htmlspecialchars($wh->nama) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p style="font-size:0.72rem; color:#94a3b8; margin-top:6px; margin-bottom:0;">
                                        Gudang yang akan menerima barang
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <hr class="section-divider">

                        <!-- Items section -->
                        <p class="section-label">Pilih Barang</p>
                        <div class="items-section">
                            <div class="items-header">
                                <i class="fas fa-boxes" style="color:#94a3b8;"></i>
                                Stok Barang di Gudang Sumber
                            </div>

                            <div class="items-alert" id="alertSelectGudang">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <i class="fas fa-info-circle" style="color:#93c5fd; font-size:0.95rem;"></i>
                                    <span style="font-size:0.84rem; color:#64748b;">
                                        Pilih <strong>Gudang Sumber</strong> untuk melihat stok barang yang tersedia.
                                    </span>
                                </div>
                            </div>

                            <div id="tableContainer" style="display:none; overflow-x:auto;">
                                <table class="items-table" id="tableItems">
                                    <thead>
                                        <tr>
                                            <th class="check-col">
                                                <input type="checkbox" id="checkAll" title="Pilih Semua">
                                            </th>
                                            <th style="width:40px;">No</th>
                                            <th>Nama Barang</th>
                                            <th>Satuan</th>
                                            <th class="text-center">Stok</th>
                                            <th style="width:110px;">Qty Permintaan</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyItems">
                                        <!-- Dynamic rows -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="form-actions">
                            <a href="<?= base_url('preorder') ?>" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn-submit" id="btnSubmit" disabled>
                                <i class="fas fa-paper-plane"></i> Kirim Permintaan
                            </button>
                        </div>

                    </form>
                </div>

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
                alertSelectGudang.innerHTML = `
                    <div style="display:flex; align-items:center; gap:10px;">
                        <i class="fas fa-info-circle" style="color:#93c5fd; font-size:0.95rem;"></i>
                        <span style="font-size:0.84rem; color:#64748b;">
                            Pilih <strong>Gudang Sumber</strong> untuk melihat stok barang yang tersedia.
                        </span>
                    </div>`;
                tableContainer.style.display = 'none';
                btnSubmit.disabled = true;
                return;
            }

            fetch('<?= base_url('preorder/getStokByGudang/') ?>' + id)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.data.length === 0) {
                            alertSelectGudang.innerHTML = `
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <i class="fas fa-exclamation-circle" style="color:#fbbf24; font-size:0.95rem;"></i>
                                    <span style="font-size:0.84rem; color:#64748b;">Tidak ada stok barang di gudang ini.</span>
                                </div>`;
                            alertSelectGudang.style.display = 'block';
                            tableContainer.style.display = 'none';
                        } else {
                            alertSelectGudang.style.display = 'none';
                            tableContainer.style.display = 'block';
                            renderItems(data.data);
                        }
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alertSelectGudang.innerHTML = `
                        <div style="display:flex; align-items:center; gap:10px;">
                            <i class="fas fa-exclamation-triangle" style="color:#f87171; font-size:0.95rem;"></i>
                            <span style="font-size:0.84rem; color:#64748b;">Gagal memuat data stok.</span>
                        </div>`;
                    alertSelectGudang.style.display = 'block';
                });
        });

        function renderItems(items) {
            tbodyItems.innerHTML = '';

            items.forEach((item, index) => {
                const tr = document.createElement('tr');
                const isLow = item.qty <= 5;
                tr.innerHTML = `
                    <td class="check-col">
                        <input type="checkbox" class="item-check" data-id="${item.id_barang}" data-stok="${item.qty}">
                    </td>
                    <td style="color:#94a3b8; font-size:0.8rem;">${index + 1}</td>
                    <td>${item.nama_barang}</td>
                    <td style="color:#64748b;">${item.nama_satuan}</td>
                    <td class="text-center">
                        <span class="stok-badge ${isLow ? 'low' : ''}">${item.qty}</span>
                    </td>
                    <td>
                        <input type="number" class="qty-field qty-input" min="1" max="${item.qty}" placeholder="0" disabled>
                        <input type="hidden" class="hidden-id" disabled>
                        <input type="hidden" class="hidden-qty" disabled>
                    </td>
                    <td>
                        <input type="text" class="note-field keterangan-input" name="keterangan_barang[]" placeholder="Keterangan..." disabled>
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
                        tr.classList.add('selected');
                    } else {
                        qtyInput.disabled = true;
                        qtyInput.value = '';
                        keteranganInput.disabled = true;
                        keteranganInput.value = '';
                        hiddenId.disabled = true;
                        hiddenId.removeAttribute('name');
                        hiddenQty.disabled = true;
                        hiddenQty.removeAttribute('name');
                        tr.classList.remove('selected');
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
