<style>
.units-card {
    border-radius: 12px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    overflow: hidden;
    background: #fff;
}
.units-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px 14px;
    border-bottom: 1px solid #f1f5f9;
    flex-wrap: wrap;
    gap: 12px;
}
.units-card-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.units-table { width: 100%; border-collapse: collapse; }
.units-table thead th {
    font-size: 0.7rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #94a3b8;
    padding: 9px 16px;
    background: #f8fafc;
    border-bottom: 1px solid #f1f5f9;
    white-space: nowrap;
}
.units-table tbody tr {
    border-bottom: 1px solid #f8fafc;
    transition: background 0.1s;
}
.units-table tbody tr:hover { background: #fafbfd; }
.units-table tbody tr:last-child { border-bottom: none; }
.units-table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
    font-size: 0.83rem;
    color: #374151;
}
.unit-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.83rem;
    font-weight: 500;
    color: #374151;
}
.unit-pill-icon {
    width: 28px;
    height: 28px;
    background: #eff6ff;
    color: #2563eb;
    border-radius: 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    flex-shrink: 0;
}
.units-empty {
    text-align: center;
    padding: 40px 20px;
    color: #cbd5e1;
}
.units-empty i { font-size: 1.8rem; margin-bottom: 10px; display: block; }
.units-empty p { margin: 0; font-size: 0.82rem; }
.row-num { color: #94a3b8; font-size: 0.78rem; }
.unit-btn-action {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: background 0.15s, transform 0.1s;
    font-size: 0.8rem;
    text-decoration: none;
}
.unit-btn-action:hover { transform: translateY(-1px); text-decoration: none; }
.unit-btn-action.edit   { background: #fef9c3; color: #854d0e; }
.unit-btn-action.edit:hover  { background: #fef08a; }
.unit-btn-action.delete { background: #fff1f2; color: #e11d48; }
.unit-btn-action.delete:hover { background: #fee2e2; }
.add-unit-form .input-group-prepend .input-group-text {
    background: #f8fafc;
    border-color: #e2e8f0;
    color: #94a3b8;
    border-radius: 8px 0 0 8px;
    font-size: 0.83rem;
}
.add-unit-form .form-control {
    border-color: #e2e8f0;
    font-size: 0.83rem;
    border-radius: 0;
}
.add-unit-form .form-control:focus {
    border-color: #93c5fd;
    box-shadow: none;
}
.add-unit-form .btn-primary {
    background: #2563eb;
    border-color: #2563eb;
    border-radius: 0 8px 8px 0;
    font-size: 0.83rem;
    padding: 0.375rem 1rem;
    font-weight: 500;
}
.add-unit-form .btn-primary:hover {
    background: #1d4ed8;
    border-color: #1d4ed8;
}
</style>

<div class="container-fluid">
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row">
        <div class="col-md-12">
            <div class="units-card">
                <div class="units-card-header">
                    <h5 class="units-card-title">
                        <i class="fas fa-balance-scale" style="color:#2563eb;"></i>
                        Daftar Satuan Barang
                    </h5>
                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                        <form action="<?= base_url('units/create') ?>" method="POST" class="add-unit-form mb-0">
                            <div class="input-group" style="min-width:280px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-plus"></i></span>
                                </div>
                                <input type="text" name="nama" class="form-control" placeholder="Nama satuan baru..." required>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </div>
                        </form>
                    <?php endif ?>
                </div>

                <div class="table-responsive">
                    <table class="units-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">No</th>
                                <th>Nama Satuan</th>
                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                    <th class="text-center" style="width:100px;">Aksi</th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($content)): ?>
                                <tr>
                                    <td colspan="<?= $this->session->userdata('role') == 'admin' ? 3 : 2 ?>">
                                        <div class="units-empty">
                                            <i class="fas fa-balance-scale"></i>
                                            <p>Belum ada satuan barang</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($content as $row): ?>
                                    <tr>
                                        <td class="row-num"><?= $no++ ?></td>
                                        <td>
                                            <span class="unit-pill">
                                                <span class="unit-pill-icon"><i class="fas fa-tag"></i></span>
                                                <?= ucfirst(htmlspecialchars($row->nama)) ?>
                                            </span>
                                        </td>
                                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                                            <td class="text-center">
                                                <a href="<?= base_url("units/edit/$row->id") ?>" class="unit-btn-action edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="unit-btn-action delete" data-toggle="modal" data-target="#deleteModal<?= $row->id ?>" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>

                <?php if (!empty($pagination)): ?>
                    <div class="wms-pag-footer <?= ($this->uri->segment(2) == 'search') ? 'wms-pag-split' : '' ?>">
                        <?php if ($this->uri->segment(2) == 'search'): ?>
                            <a href="<?= base_url('units') ?>" class="btn-reset">
                                <i class="fas fa-angle-left"></i> Daftar Satuan
                            </a>
                        <?php endif ?>
                        <nav aria-label="Navigasi halaman"><?= $pagination ?></nav>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($content)): ?>
    <?php foreach ($content as $row): ?>
        <div class="modal fade" id="deleteModal<?= $row->id ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title"><i class="fas fa-trash mr-2"></i>Hapus Satuan</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Hapus satuan <strong><?= ucfirst(htmlspecialchars($row->nama)) ?></strong>?</p>
                        <p class="text-danger mb-0"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                        <a href="<?= base_url('units/delete/' . $row->id) ?>" class="btn btn-danger btn-sm">Ya, Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
