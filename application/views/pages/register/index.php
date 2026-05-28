<style>
    .reg-staff-card .card-header-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .reg-staff-card .page-title {
        font-size: 1.05rem;
        font-weight: 500;
        color: #0f172a;
        margin: 0;
    }

    .reg-staff-card .form-label {
        font-size: 0.82rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
        display: block;
    }

    .reg-staff-card .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #0f172a;
        background: #f8fafc;
        transition: border-color 0.15s, box-shadow 0.15s;
        height: 38px;
        padding: 0 12px;
    }

    .reg-staff-card textarea.form-control {
        height: auto;
        padding: 10px 12px;
    }

    .reg-staff-card .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: #fff;
        outline: none;
    }

    .reg-staff-card select.form-control {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-color: #f8fafc;
        padding-right: 32px;
    }

    .reg-staff-card .field-error {
        font-size: 0.75rem;
        color: #dc2626;
        margin-top: 4px;
    }

    .reg-staff-card .field-hint {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 4px;
    }

    .reg-staff-card .section-divider {
        border: none;
        border-top: 1px solid #f1f5f9;
        margin: 20px 0;
    }

    .reg-staff-card .section-label {
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #94a3b8;
        margin-bottom: 16px;
    }

    .reg-staff-card .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding-top: 8px;
        border-top: 1px solid #f1f5f9;
        margin-top: 24px;
    }

    .reg-staff-card .btn-back {
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

    .reg-staff-card .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
        text-decoration: none;
    }

    .reg-staff-card .btn-reset-form {
        height: 38px;
        padding: 0 16px;
        background: #f8fafc;
        color: #475569;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s, border-color 0.15s;
        text-decoration: none;
    }

    .reg-staff-card .btn-reset-form:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        text-decoration: none;
        color: #475569;
    }

    .reg-staff-card .btn-submit {
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

    .reg-staff-card .btn-submit:hover {
        background: #1d4ed8;
    }

    .reg-staff-card .password-wrapper {
        position: relative;
    }

    .reg-staff-card .password-wrapper .form-control {
        padding-right: 40px;
    }

    .reg-staff-card .btn-toggle-pw {
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

    .reg-staff-card .btn-toggle-pw:hover {
        color: #475569;
    }
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-12">
            <div class="card reg-staff-card"
                style="border-radius:12px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                <!-- Card header -->
                <div class="card-header-custom">
                    <h5 class="page-title">Tambah Staff Baru</h5>
                </div>

                <!-- Form body -->
                <div class="card-body" style="padding:24px;">
                    <form action="<?= base_url('register') ?>" method="POST">

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
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="password-wrapper">
                                        <?= form_password('password', '', ['class' => 'form-control', 'placeholder' => 'Minimal 4 karakter', 'required' => true, 'id' => 'pw-field']) ?>
                                        <button type="button" class="btn-toggle-pw" onclick="togglePw()">
                                            <i class="fas fa-eye" id="pw-eye"></i>
                                        </button>
                                    </div>
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

                        <!-- Role & warehouse section -->
                        <p class="section-label">Role & Akses Gudang</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Role <span class="text-danger">*</span></label>
                                    <?php $selectedRole = isset($input->role) && $input->role ? $input->role : 'staff'; ?>
                                    <select class="form-control" name="role" id="role-options" required onchange="handleRoleChange(this.value)">
                                        <option value="staff" <?= $selectedRole == 'staff' ? 'selected' : '' ?>>Staff (Project Admin)</option>
                                        <option value="purchasing_admin" <?= $selectedRole == 'purchasing_admin' ? 'selected' : '' ?>>Purchasing Admin</option>
                                        <option value="admin" <?= $selectedRole == 'admin' ? 'selected' : '' ?>>Admin (Super Admin)</option>
                                    </select>
                                    <p class="field-hint">Staff = akses gudang tertentu. Admin = akses semua gudang.</p>
                                    <div class="field-error"><?= form_error('role') ?></div>
                                </div>
                            </div>
                            <div class="col-md-6" id="gudang-wrapper">
                                <div class="form-group">
                                    <label class="form-label">Gudang</label>
                                    <select class="form-control" name="id_gudang" id="gudang-options">
                                        <option value="">-- Semua Gudang (Admin) --</option>
                                        <?php foreach (getWarehouses() as $gudang): ?>
                                            <option value="<?= $gudang->id ?>"
                                                <?= $input->id_gudang == $gudang->id ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($gudang->nama) ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                    <p class="field-hint">Kosongkan jika Admin (akses semua gudang).</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="form-actions">
                            <a href="<?= base_url('users') ?>" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="<?= base_url('register/reset') ?>" class="btn-reset-form">
                                <i class="fas fa-undo"></i> Reset
                            </a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-user-plus"></i> Daftarkan Staff
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function togglePw() {
    var field = document.getElementById('pw-field');
    var eye = document.getElementById('pw-eye');
    if (field.type === 'password') {
        field.type = 'text';
        eye.className = 'fas fa-eye-slash';
    } else {
        field.type = 'password';
        eye.className = 'fas fa-eye';
    }
}

function handleRoleChange(role) {
    var wrapper = document.getElementById('gudang-wrapper');
    var select = document.getElementById('gudang-options');
    if (role === 'admin') {
        select.value = '';
        wrapper.style.opacity = '0.5';
        select.disabled = true;
    } else {
        wrapper.style.opacity = '1';
        select.disabled = false;
    }
}

// Init on page load
handleRoleChange(document.getElementById('role-options').value);
</script>
