<style>
    /* ── Buat Purchase Request ─────────────────────────────────── */
    .pr-form .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .pr-form .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .pr-form .btn-back {
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

    .pr-form .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .pr-form .form-body {
        padding: 24px;
    }

    .pr-form .section-label {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #94a3b8;
        margin-bottom: 12px;
        margin-top: 0;
    }

    .pr-form .field-label {
        font-size: 0.82rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
        display: block;
    }

    .pr-form .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #0f172a;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .pr-form .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: #fff;
        outline: none;
    }

    .pr-form select.form-control {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
    }

    .pr-form .section-divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 24px 0;
    }

    /* Items section shared */
    .items-section {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .items-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .items-header-left {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        color: #374151;
    }

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

    .items-table tbody tr:last-child { border-bottom: none; }
    .items-table tbody tr:hover { background: #fafbfd; }
    .items-table tbody tr.selected { background: #eff6ff; }

    .items-table tbody td {
        padding: 11px 14px;
        vertical-align: middle;
        font-size: 0.84rem;
        color: #374151;
    }

    /* Inline inputs */
    .qty-field,
    .note-field,
    .name-field,
    .select-field {
        border: 1.5px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.82rem;
        padding: 5px 8px;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
        color: #0f172a;
    }

    .qty-field  { width: 80px; text-align: center; }
    .note-field { width: 100%; }
    .name-field { width: 100%; }
    .select-field { width: 100%; appearance: none; -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 8px center; padding-right: 24px; }

    .qty-field:focus, .note-field:focus, .name-field:focus, .select-field:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        background: #fff;
        outline: none;
    }

    .qty-field:disabled, .note-field:disabled {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }

    /* Empty state */
    .table-empty {
        padding: 28px 16px;
        text-align: center;
        color: #94a3b8;
        font-size: 0.82rem;
    }

    /* Hint note */
    .section-hint {
        padding: 10px 16px;
        background: #fffbeb;
        border-bottom: 1px solid #fef3c7;
        font-size: 0.78rem;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Btn add row */
    .btn-add-row {
        height: 30px;
        padding: 0 12px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #eff6ff;
        color: #2563eb;
        border: 1.5px solid #bfdbfe;
        transition: background 0.15s, border-color 0.15s;
    }

    .btn-add-row:hover {
        background: #dbeafe;
        border-color: #93c5fd;
    }

    /* Delete row btn */
    .btn-del-row {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: #fff0f0;
        color: #ef4444;
        border: 1.5px solid #fecaca;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        transition: background 0.15s;
    }

    .btn-del-row:hover { background: #fee2e2; }

    /* Catalog checkbox */
    .item-check {
        width: 16px;
        height: 16px;
        accent-color: #2563eb;
        cursor: pointer;
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

    /* Custom file input */
    .file-input-wrapper {
        display: flex;
        align-items: center;
        gap: 0;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .file-input-wrapper:focus-within {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: #fff;
    }

    .file-input-wrapper input[type="file"] {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        pointer-events: none;
    }

    .file-input-btn {
        flex-shrink: 0;
        padding: 0 14px;
        height: 38px;
        background: #e2e8f0;
        color: #374151;
        font-size: 0.8rem;
        font-weight: 500;
        border: none;
        border-right: 1.5px solid #e2e8f0;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
        white-space: nowrap;
    }

    .file-input-btn:hover { background: #cbd5e1; }

    .file-input-name {
        flex: 1;
        padding: 0 12px;
        font-size: 0.82rem;
        color: #94a3b8;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .file-input-name.has-file { color: #0f172a; }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card pr-form"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- Header -->
                <div class="card-header-custom">
                    <h5 class="page-title">Buat Purchase Request</h5>
                    <a href="<?= base_url('purchaserequest') ?>" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="form-body">
                    <form action="<?= base_url('purchaserequest/store') ?>" method="POST"
                        id="formPR" enctype="multipart/form-data">

                        <!-- PR info -->
                        <p class="section-label">Info Purchase Request</p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="field-label">
                                        Tanggal PR <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal_pr" id="tanggal_pr"
                                        class="form-control"
                                        value="<?= date('Y-m-d') ?>"
                                        min="<?= date('Y-m-d') ?>"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="field-label">
                                        Gudang Tujuan <span class="text-danger">*</span>
                                    </label>
                                    <select name="id_gudang" class="form-control" required>
                                        <option value="">Pilih gudang...</option>
                                        <?php foreach ($warehouses as $wh): ?>
                                            <option value="<?= $wh->id ?>"><?= htmlspecialchars($wh->nama) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="field-label">
                                        Foto Purchase Request <span class="text-danger">*</span>
                                    </label>
                                    <div class="file-input-wrapper">
                                        <input type="file" name="foto_pr" id="foto_pr"
                                            accept="image/jpeg,image/png" required>
                                        <button type="button" class="file-input-btn" onclick="document.getElementById('foto_pr').click()">
                                            <i class="fas fa-paperclip"></i> Pilih Foto
                                        </button>
                                        <span class="file-input-name" id="fotoFileName">Belum ada file dipilih</span>
                                    </div>
                                    <small class="text-muted" style="font-size:0.72rem;">JPG, PNG &middot; Maks 2 MB</small>
                                </div>
                            </div>
                        </div>

                        <hr class="section-divider">

                        <!-- Manual items -->
                        <p class="section-label">Barang Manual
                            <span style="font-weight:400; text-transform:none; letter-spacing:0; color:#b0bec5; font-size:0.72rem;">(tidak ada di katalog)</span>
                        </p>
                        <div class="items-section mb-4">
                            <div class="items-header">
                                <div class="items-header-left">
                                    <i class="fas fa-pencil-alt" style="color:#94a3b8;"></i>
                                    Tambah Barang Manual
                                </div>
                                <button type="button" class="btn-add-row" id="btnAddManual">
                                    <i class="fas fa-plus"></i> Tambah Baris
                                </button>
                            </div>
                            <div class="section-hint">
                                <i class="fas fa-exclamation-triangle"></i>
                                Gunakan bagian ini untuk barang yang belum ada di katalog. Stok gudang tidak diperbarui otomatis saat verifikasi item manual.
                            </div>
                            <div style="overflow-x:auto;">
                                <table class="items-table" id="tblManual">
                                    <thead>
                                        <tr>
                                            <th style="width:44px;">No</th>
                                            <th>Nama Barang</th>
                                            <th style="width:160px;">Satuan</th>
                                            <th style="width:90px;" class="text-center">Qty</th>
                                            <th>Keterangan</th>
                                            <th style="width:50px;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyManual">
                                        <tr id="manualEmptyRow">
                                            <td colspan="6" class="table-empty">
                                                <i class="fas fa-inbox" style="font-size:1.2rem; display:block; margin-bottom:6px; color:#e2e8f0;"></i>
                                                Belum ada barang. Klik <strong>Tambah Baris</strong> untuk menambah.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Template for manual row -->
                        <template id="manualRowTemplate">
                            <tr class="manual-row">
                                <td style="color:#94a3b8; font-size:0.8rem;" class="manual-no"></td>
                                <td>
                                    <input type="text" class="name-field manual-nama"
                                        name="manual_nama[]"
                                        placeholder="Nama barang..." maxlength="50" required>
                                </td>
                                <td>
                                    <select class="select-field manual-satuan"
                                        name="manual_id_satuan[]" required>
                                        <option value="">Pilih satuan...</option>
                                        <?php foreach (($units ?? []) as $u): ?>
                                            <option value="<?= $u->id ?>"><?= htmlspecialchars($u->nama) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="qty-field manual-qty"
                                        name="manual_qty[]" min="1" placeholder="0" required>
                                </td>
                                <td>
                                    <input type="text" class="note-field manual-keterangan"
                                        name="manual_keterangan[]" placeholder="Catatan...">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn-del-row btnRemoveManual" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>

                        <!-- Catalog items -->
                        <p class="section-label">Barang Katalog
                            <span style="font-weight:400; text-transform:none; letter-spacing:0; color:#b0bec5; font-size:0.72rem;">(pilih dari stok yang ada)</span>
                        </p>
                        <div class="items-section">
                            <div class="items-header">
                                <div class="items-header-left">
                                    <i class="fas fa-boxes" style="color:#94a3b8;"></i>
                                    Daftar Barang Katalog
                                </div>
                                <?php if (!empty($items)): ?>
                                <label style="display:flex; align-items:center; gap:6px; font-size:0.78rem; color:#64748b; cursor:pointer; margin:0;">
                                    <input type="checkbox" id="checkAll" style="accent-color:#2563eb; width:14px; height:14px;">
                                    Pilih Semua
                                </label>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($items)): ?>
                            <div style="padding:10px 16px; border-bottom:1px solid #e2e8f0; background:#fff;">
                                <div style="position:relative;">
                                    <i class="fas fa-search" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:0.8rem; pointer-events:none;"></i>
                                    <input type="text" id="catalogSearch" placeholder="Cari barang..."
                                        style="width:100%; padding:6px 10px 6px 30px; border:1.5px solid #e2e8f0; border-radius:7px; font-size:0.82rem; background:#f8fafc; color:#0f172a; outline:none; transition:border-color 0.15s, box-shadow 0.15s;"
                                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'; this.style.background='#fff';"
                                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'; this.style.background='#f8fafc';">
                                </div>
                            </div>
                            <?php endif; ?>
                            <div style="overflow-x:auto;">
                                <table class="items-table">
                                    <thead>
                                        <tr>
                                            <th style="width:44px;" class="text-center">Pilih</th>
                                            <th style="width:44px;">No</th>
                                            <th>Nama Barang</th>
                                            <th style="width:120px;">Satuan</th>
                                            <th style="width:110px;" class="text-center">Qty</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyItems">
                                        <?php if (empty($items)): ?>
                                        <tr>
                                            <td colspan="6" class="table-empty">
                                                <i class="fas fa-inbox" style="font-size:1.2rem; display:block; margin-bottom:6px; color:#e2e8f0;"></i>
                                                Belum ada barang di katalog.
                                            </td>
                                        </tr>
                                        <?php else: ?>
                                            <?php foreach ($items as $i => $it): ?>
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" class="item-check"
                                                        data-id="<?= $it->id ?>">
                                                </td>
                                                <td style="color:#94a3b8; font-size:0.8rem;"><?= $i + 1 ?></td>
                                                <td style="font-weight:500;"><?= htmlspecialchars($it->nama) ?></td>
                                                <td style="color:#64748b;"><?= htmlspecialchars($it->nama_satuan ?? '-') ?></td>
                                                <td class="text-center">
                                                    <input type="number" class="qty-field qty-input"
                                                        min="1" placeholder="0" disabled>
                                                    <input type="hidden" class="hidden-id" disabled>
                                                    <input type="hidden" class="hidden-qty" disabled>
                                                </td>
                                                <td>
                                                    <input type="text" class="note-field keterangan-input"
                                                        name="keterangan_barang[]"
                                                        placeholder="Catatan..." disabled>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="form-actions">
                            <a href="<?= base_url('purchaserequest') ?>" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn-submit" id="btnSubmit" disabled>
                                <i class="fas fa-paper-plane"></i> Buat Purchase Request
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
    const tbody     = document.getElementById('tbodyItems');
    const checkAll  = document.getElementById('checkAll');
    const btnSubmit = document.getElementById('btnSubmit');

    /* ── Catalog items ─────────────────────────────────────────── */
    tbody.querySelectorAll('tr').forEach(function (tr) {
        const cb             = tr.querySelector('.item-check');
        if (!cb) return;
        const qtyInput       = tr.querySelector('.qty-input');
        const keteranganInput = tr.querySelector('.keterangan-input');
        const hiddenId       = tr.querySelector('.hidden-id');
        const hiddenQty      = tr.querySelector('.hidden-qty');

        cb.addEventListener('change', function () {
            if (this.checked) {
                qtyInput.disabled        = false;
                qtyInput.value           = 1;
                keteranganInput.disabled = false;
                hiddenId.name            = 'id_barang[]';
                hiddenId.value           = cb.dataset.id;
                hiddenId.disabled        = false;
                hiddenQty.name           = 'qty[]';
                hiddenQty.value          = 1;
                hiddenQty.disabled       = false;
                tr.classList.add('selected');
            } else {
                qtyInput.disabled        = true;
                qtyInput.value           = '';
                keteranganInput.disabled = true;
                keteranganInput.value    = '';
                hiddenId.disabled        = true;
                hiddenId.removeAttribute('name');
                hiddenQty.disabled       = true;
                hiddenQty.removeAttribute('name');
                tr.classList.remove('selected');
            }
            updateCheckAll();
            checkSubmitButton();
        });

        qtyInput.addEventListener('input', function () {
            let val = parseInt(this.value) || 0;
            if (val < 1) val = 1;
            this.value      = val;
            hiddenQty.value = val;
            checkSubmitButton();
        });
    });

    if (checkAll) {
        checkAll.addEventListener('change', function () {
            const wantChecked = checkAll.checked; // snapshot before loop — prevents updateCheckAll() mid-loop from flipping this
            tbody.querySelectorAll('tr:not([style*="display: none"]) .item-check').forEach(function (cb) {
                if (cb.checked !== wantChecked) {
                    cb.checked = wantChecked;
                    cb.dispatchEvent(new Event('change'));
                }
            });
        });
    }

    function updateCheckAll() {
        if (!checkAll) return;
        const visible = Array.from(tbody.querySelectorAll('tr')).filter(function (tr) {
            return tr.style.display !== 'none';
        });
        const all     = visible.reduce(function (acc, tr) { const cb = tr.querySelector('.item-check'); return cb ? acc + 1 : acc; }, 0);
        const checked = visible.reduce(function (acc, tr) { const cb = tr.querySelector('.item-check:checked'); return cb ? acc + 1 : acc; }, 0);
        checkAll.checked = all > 0 && all === checked;
        checkAll.indeterminate = checked > 0 && checked < all;
    }

    /* ── Catalog search ────────────────────────────────────────── */
    const catalogSearch = document.getElementById('catalogSearch');
    if (catalogSearch) {
        catalogSearch.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            tbody.querySelectorAll('tr').forEach(function (tr) {
                const nameCell = tr.querySelector('td:nth-child(3)');
                if (!nameCell) return;
                const match = nameCell.textContent.toLowerCase().includes(q);
                tr.style.display = match ? '' : 'none';
            });
            updateCheckAll();
        });
    }

    function checkSubmitButton() {
        const checkedCatalog = tbody.querySelectorAll('.item-check:checked');
        let valid = false;
        checkedCatalog.forEach(function (cb) {
            const qty = parseInt(cb.closest('tr').querySelector('.qty-input').value) || 0;
            if (qty > 0) valid = true;
        });
        if (!valid) valid = hasValidManualRow();
        btnSubmit.disabled = !valid;
    }

    /* ── Manual items ──────────────────────────────────────────── */
    const tbodyManual    = document.getElementById('tbodyManual');
    const manualEmptyRow = document.getElementById('manualEmptyRow');
    const manualTemplate = document.getElementById('manualRowTemplate');

    function renumberManual() {
        let i = 1;
        tbodyManual.querySelectorAll('.manual-row').forEach(function (tr) {
            tr.querySelector('.manual-no').textContent = i++;
        });
    }

    function hasValidManualRow() {
        for (const tr of tbodyManual.querySelectorAll('.manual-row')) {
            const nama = tr.querySelector('.manual-nama').value.trim();
            const qty  = parseInt(tr.querySelector('.manual-qty').value) || 0;
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
        ['.manual-nama', '.manual-qty', '.manual-satuan', '.manual-keterangan'].forEach(function (sel) {
            clone.querySelector(sel).addEventListener('input', checkSubmitButton);
            clone.querySelector(sel).addEventListener('change', checkSubmitButton);
        });
        manualEmptyRow.style.display = 'none';
        tbodyManual.appendChild(clone);
        renumberManual();
        checkSubmitButton();
        clone.querySelector('.manual-nama').focus();
    }

    document.getElementById('btnAddManual').addEventListener('click', addManualRow);

    /* ── Photo upload — size guard + filename display ──────────── */
    const fotoInput    = document.getElementById('foto_pr');
    const fotoFileName = document.getElementById('fotoFileName');
    fotoInput.addEventListener('change', function () {
        if (this.files[0]) {
            if (this.files[0].size > 2 * 1024 * 1024) {
                alert('Ukuran file tidak boleh melebihi 2 MB.');
                this.value = '';
                fotoFileName.textContent = 'Belum ada file dipilih';
                fotoFileName.classList.remove('has-file');
            } else {
                fotoFileName.textContent = this.files[0].name;
                fotoFileName.classList.add('has-file');
            }
        }
    });

    /* ── Form submit ───────────────────────────────────────────── */
    document.getElementById('formPR').addEventListener('submit', function (e) {
        const checked = tbody.querySelectorAll('.item-check:checked');
        if (checked.length === 0 && !hasValidManualRow()) {
            e.preventDefault();
            alert('Tambahkan minimal satu barang (katalog atau manual).');
            return;
        }
        // Strip incomplete manual rows before submit
        tbodyManual.querySelectorAll('.manual-row').forEach(function (tr) {
            const nama = tr.querySelector('.manual-nama').value.trim();
            const qty  = parseInt(tr.querySelector('.manual-qty').value) || 0;
            if (nama === '' || qty <= 0) tr.remove();
        });
    });
});
</script>
