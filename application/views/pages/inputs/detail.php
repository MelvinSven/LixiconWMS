<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <div class="row" id="printBukti">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    Detail Pemasukan Barang
                </div>
                <div class="card-body">
                    <table class="table-responsive mb-3 no-wrap">
                        <tr>
                            <td>Nomor pemasukan</td>
                            <td>:</td>
                            <td><?= $barang_masuk->id_barang_masuk ?></td>
                        </tr>
                        <tr>
                            <td>NIP Staff</td>
                            <td>:</td>
                            <td><?= $barang_masuk->id_user ?></td>
                        </tr>
                        <tr>
                            <td>Nama Staff</td>
                            <td>:</td>
                            <td><?= $barang_masuk->nama ?></td>
                        </tr>
                        <tr>
                            <td>Waktu</td>
                            <td>:</td>
                            <td><?= date('d/m/Y H:i:s', strtotime($barang_masuk->waktu)) ?></td>
                        </tr>
                        <?php if (!empty($barang_masuk->bukti_foto)): ?>
                            <tr>
                                <td>Bukti Foto</td>
                                <td>:</td>
                                <td>
                                    <a href="<?= base_url($barang_masuk->bukti_foto) ?>" target="_blank">
                                        <img src="<?= base_url($barang_masuk->bukti_foto) ?>" alt="Bukti Foto Masuk"
                                            class="img-thumbnail" style="max-height: 200px;">
                                    </a>
                                </td>
                            </tr>
                        <?php endif ?>
                    </table>
                    <table class="table table-responsive w-100 d-block d-md-table">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-center">Supplier</th>
                                <th class="text-center">Tujuan Gudang</th>
                                <th class="text-center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list_barang as $barang): ?>
                                <tr>
                                    <td>
                                        <strong><?= $barang->nama ?></strong>
                                    </td>
                                    <td class="text-center">
                                        <small><?= ucfirst(getUnitName($barang->id_satuan)) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <small><?= ucfirst(getSupplierName($barang->id_supplier)) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info">
                                            <i class="fas fa-warehouse mr-1"></i>
                                            <?= isset($barang->nama_gudang) ? $barang->nama_gudang : '-' ?>
                                        </span>
                                    </td>
                                    <td class="text-center"><?= $barang->qty ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-2">
                            <a href="<?= base_url('inputs') ?>" class="btn btn-primary btn-rounded text-white"><i
                                    class="fas fa-angle-left"></i> List pemasukan barang</a>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-2">
                            <button class="btn btn-success btn-rounded float-right"
                                onclick="printDiv('printBukti')">Cetak Bukti <i class="fas fa-angle-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>