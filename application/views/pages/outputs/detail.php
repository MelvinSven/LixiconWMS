<div class="container-fluid">

    <?php $this->load->view('layouts/_alert') ?>

    <div class="row" id="printBukti">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    Detail Pengeluaran Barang
                </div>
                <div class="card-body">
                    <table class="table-responsive mb-3 no-wrap">
                        <tr>
                            <td>Nomor Pengeluaran</td>
                            <td>:</td>
                            <td><?= $barang_keluar->id_barang_keluar ?></td>
                        </tr>
                        <tr>
                            <td>NIP Staff</td>
                            <td>:</td>
                            <td><?= $barang_keluar->id_user ?></td>
                        </tr>
                        <tr>
                            <td>Nama Staff</td>
                            <td>:</td>
                            <td><?= $barang_keluar->nama ?></td>
                        </tr>
                        <tr>
                            <td>Waktu</td>
                            <td>:</td>
                            <td><?= date('d/m/Y H:i:s', strtotime($barang_keluar->waktu)) ?></td>
                        </tr>
                        <tr>
                            <td>Gudang</td>
                            <td>:</td>
                            <td>
                                <?php if (!empty($barang_keluar->nama_gudang)): ?>
                                    <i class="fas fa-warehouse mr-1 text-secondary"></i><?= $barang_keluar->nama_gudang ?>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php if (!empty($barang_keluar->nama_kurir)): ?>
                            <tr>
                                <td>Nama Kurir</td>
                                <td>:</td>
                                <td><?= $barang_keluar->nama_kurir ?></td>
                            </tr>
                        <?php endif ?>
                        <?php if (!empty($barang_keluar->keterangan)): ?>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><?= $barang_keluar->keterangan ?></td>
                            </tr>
                        <?php endif ?>
                        <?php if (!empty($barang_keluar->bukti_foto)): ?>
                            <tr>
                                <td>Bukti Foto</td>
                                <td>:</td>
                                <td>
                                    <a href="<?= base_url($barang_keluar->bukti_foto) ?>" target="_blank">
                                        <img src="<?= base_url($barang_keluar->bukti_foto) ?>" alt="Bukti Foto Keluar"
                                            class="img-thumbnail" style="max-height: 200px;">
                                    </a>
                                </td>
                            </tr>
                        <?php endif ?>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>
                                <?php if (isset($barang_keluar->status) && $barang_keluar->status == 'sampai'): ?>
                                    <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i>Sampai</span>
                                <?php else: ?>
                                    <span class="badge badge-warning"><i
                                            class="fas fa-shipping-fast mr-1"></i>Dikirim</span>
                                <?php endif ?>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-responsive w-100 d-block d-md-table">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th class="text-center">Satuan</th>
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
                                        <?= $barang->qty ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-2">
                            <a href="<?= base_url('outputs') ?>" class="btn btn-primary btn-rounded text-white"><i
                                    class="fas fa-angle-left"></i> List Pengeluaran barang</a>
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