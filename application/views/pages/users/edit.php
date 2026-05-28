<style>
    .edit-staff-card .card-header-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .edit-staff-card .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .edit-staff-card .form-label {
        font-size: 0.82rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
        display: block;
    }

    .edit-staff-card .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #0f172a;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
        height: 38px;
        padding: 0 12px;
    }

    .edit-staff-card .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: #fff;
        outline: none;
    }

    .edit-staff-card select.form-control {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-color: #f8fafc;
        padding-right: 32px;
    }

    .edit-staff-card .field-error {
        font-size: 0.75rem;
        color: #dc2626;
        margin-top: 4px;
    }

    .edit-staff-card .field-hint {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 4px;
    }

    .edit-staff-card .section-divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 20px 0;
    }

    .edit-staff-card .section-label {
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #94a3b8;
        margin-bottom: 16px;
    }

    .edit-staff-card .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding-top: 8px;
        border-top: 1px solid #f1f5f9;
        margin-top: 24px;
    }

    .edit-staff-card .btn-back {
        height: 38px;
        padding: 0 16px;
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

    .edit-staff-card .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .edit-staff-card .btn-submit {
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

    .edit-staff-card .btn-submit:hover {
        background: #1d4ed8;
    }

    .edit-staff-card .password-wrapper {
        position: relative;
    }

    .edit-staff-card .password-wrapper .form-control {
        padding-right: 40px;
    }

    .edit-staff-card .btn-toggle-pw {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #94a3b8;
        font-size: 0.85rem;
        padding: 0;
        line-height: 1;
    }

    .edit-staff-card .btn-toggle-pw:hover {
        color: #475569;
    }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card edit-staff-card"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- Card header -->
                <div class="card-header-custom">
                    <h5 class="page-title">Edit Staff — <?= htmlspecialchars($input->nama) ?></h5>
                </div>

                <!-- Form body -->
                <div class="card-body" style="padding:24px;">
                    <form action="<?= base_url("users/edit/$input->id") ?>" method="POST">
                        <?= form_hidden('id', $input->id) ?>

                        <!-- Personal info section -->
                        <p class="section-label">Informasi Akun</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <?= form_input('nama', $input->nama, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Nama lengkap (bukan nama panggilan)']) ?>
                                    <div class="field-error"><?= form_error('nama') ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">E-mail <span class="text-danger">*</span></label>
                                    <?= form_input(['type' => 'email', 'name' => 'email', 'value' => $input->email, 'class' => 'form-control', 'placeholder' => 'Alamat email aktif', 'required' => true]) ?>
                                    <div class="field-error"><?= form_error('email') ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Password Baru</label>
                                    <div class="password-wrapper">
                                        <?= form_password('password', '', ['class' => 'form-control', 'placeholder' => 'Kosongkan jika tidak diubah', 'id' => 'pw-field-edit']) ?>
                                        <button type="button" class="btn-toggle-pw" onclick="togglePwEdit()">
                                            <i class="fas fa-eye" id="pw-eye-edit"></i>
                                        </button>
                                    </div>
                                    <p class="field-hint">Isi hanya jika ingin mengganti password.</p>
                                    <div class="field-error"><?= form_error('password') ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                    <?= form_input('telefon', $input->telefon, ['class' => 'form-control', 'placeholder' => 'Nomor telepon aktif', 'required' => true]) ?>
                                    <div class="field-error"><?= form_error('telefon') ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nomor KTP <span class="text-danger">*</span></label>
                                    <?= form_input('ktp', $input->ktp, ['class' => 'form-control', 'placeholder' => '16 digit nomor KTP', 'required' => true]) ?>
                                    <div class="field-error"><?= form_error('ktp') ?></div>
                                </div>
                            </div>
                        </div>

                        <hr class="section-divider">

                        <!-- Role & access section -->
                        <p class="section-label">Role & Akses</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Role <span class="text-danger">*</span></label>
                                    <select class="form-control" name="role" id="role-options-edit" onchange="handleRoleChangeEdit(this.value)">
                                        <option value="admin" <?= $input->role == 'admin' ? 'selected' : '' ?>>Admin (Super Admin)</option>
                                        <option value="staff" <?= $input->role == 'staff' ? 'selected' : '' ?>>Staff (Project Admin)</option>
                                        <option value="purchasing_admin" <?= $input->role == 'purchasing_admin' ? 'selected' : '' ?>>Purchasing Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="gudang-wrapper-edit">
                                <div class="form-group">
                                    <label class="form-label">Gudang</label>
                                    <select class="form-control" name="id_gudang" id="gudang-options-edit">
                                        <option value="">-- Semua Gudang (Admin) --</option>
                                        <?php foreach (getWarehouses() as $gudang): ?>
                                            <option value="<?= $gudang->id ?>" <?= (isset($input->id_gudang) && $input->id_gudang == $gudang->id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($gudang->nama) ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                    <p class="field-hint">Kosongkan jika Admin (akses semua gudang).</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Status Akun <span class="text-danger">*</span></label>
                                    <select class="form-control" name="status" id="status-options">
                                        <option value="aktif" <?= $input->status == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="non-aktif" <?= $input->status == 'non-aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="form-actions">
                            <a href="<?= base_url('users') ?>" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function togglePwEdit() {
    var field = document.getElementById('pw-field-edit');
    var eye = document.getElementById('pw-eye-edit');
    if (field.type === 'password') {
        field.type = 'text';
        eye.className = 'fas fa-eye-slash';
    } else {
        field.type = 'password';
        eye.className = 'fas fa-eye';
    }
}

function handleRoleChangeEdit(role) {
    var wrapper = document.getElementById('gudang-wrapper-edit');
    var select = document.getElementById('gudang-options-edit');
    if (role === 'admin') {
        select.value = '';
        wrapper.style.opacity = '0.5';
        select.disabled = true;
    } else {
        wrapper.style.opacity = '1';
        select.disabled = false;
    }
}

handleRoleChangeEdit(document.getElementById('role-options-edit').value);
</script>
