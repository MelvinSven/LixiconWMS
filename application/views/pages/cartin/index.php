<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    
    <?php $this->load->view('layouts/_alert') ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-arrow-down mr-2"></i>Penambahan Barang (Barang Masuk)
                </div>
                <div class="card-body">
                    <?php if (empty($content)) : ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>Keranjang masuk kosong. 
                            <a href="<?= base_url('warehouses') ?>">Klik di sini</a> untuk menambah barang.
                        </div>
                    <?php else : ?>
                    <form action="<?= base_url('cartin/checkout') ?>" method="POST" id="formCheckout" enctype="multipart/form-data">
                    <table class="table table-responsive w-100 d-block d-md-table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Supplier</th>
                                <th class="text-center">Gudang Tujuan</th>
                                <th class="text-center">Jumlah</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($content as $row) : ?>
                                <tr>
                                    <td><code><?= isset($row->kode_barang) && $row->kode_barang ? $row->kode_barang : '-' ?></code></td>
                                    <td>
                                        <strong><?= $row->nama ?></strong><br>
                                        <small class="text-muted"><?= ucfirst(getUnitName($row->id_satuan)) ?></small>
                                    </td>
                                    <td><?= isset($row->nama_supplier) && $row->nama_supplier ? $row->nama_supplier : '-' ?></td>
                                    <td class="text-center">
                                        <span class="badge badge-info">
                                            <i class="fas fa-warehouse mr-1"></i>
                                            <?= $row->nama_gudang ?? 'Belum dipilih' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" name="qty[<?= $row->id ?>]" class="form-control form-control-sm text-center" value="<?= $row->qty_barang_masuk ?>" min="1" style="width: 80px;">
                                    </td>
                                    <td>
                                        <a href="<?= base_url('cartin/delete/' . $row->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus dari keranjang?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    </form>
                    <?php endif ?>
                </div>
                <?php if (!empty($content)) : ?>
                <div class="card-body border-top pt-3 pb-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label class="font-weight-bold mb-2"><i class="fas fa-camera mr-1"></i> Bukti Foto Masuk</label>
                            <input type="file" name="bukti_foto" form="formCheckout" class="form-control" accept="image/*" onchange="previewBuktiFoto(this)">
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                        </div>
                        <div class="col-md-6">
                            <div id="previewBuktiFotoContainer" class="mt-2 mt-md-0" style="display:none;">
                                <img id="previewBuktiFoto" src="" alt="Preview" class="img-thumbnail" style="max-height:120px;">
                                <button type="button" class="btn btn-sm btn-danger ml-2" onclick="removeBuktiFoto()" title="Hapus foto"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mb-2">
                            <a href="<?= base_url('warehouses') ?>" class="btn btn-warning btn-rounded text-white">
                                <i class="fas fa-angle-left"></i> List gudang
                            </a>
                            <?php if (!empty($content)) : ?>
                            <a href="<?= base_url('cartin/drop') ?>" class="btn btn-outline-danger btn-rounded ml-2" onclick="return confirm('Yakin kosongkan keranjang?')">
                                <i class="fas fa-trash"></i> Kosongkan
                            </a>
                            <?php endif ?>
                        </div>
                        <?php if (!empty($content)) : ?>
                        <div class="mb-2">
                            <button type="submit" form="formCheckout" class="btn btn-success btn-rounded">
                                <i class="fas fa-check-circle"></i> Proses Masuk <i class="fas fa-angle-right ml-1"></i>
                            </button>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function previewBuktiFoto(input) {
    var container = document.getElementById('previewBuktiFotoContainer');
    var img = document.getElementById('previewBuktiFoto');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            container.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        container.style.display = 'none';
        img.src = '';
    }
}
function removeBuktiFoto() {
    var input = document.querySelector('input[name="bukti_foto"]');
    input.value = '';
    document.getElementById('previewBuktiFotoContainer').style.display = 'none';
    document.getElementById('previewBuktiFoto').src = '';
}
</script>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->


