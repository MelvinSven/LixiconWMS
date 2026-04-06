<div class="row">
    <div class="col-12">
        <div class="card" id="printArea">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h3 class="font-weight-bold mb-1">LAPORAN VERIFIKASI PENERIMAAN BARANG</h3>
                    <hr style="border-top: 3px double #333;">
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td width="45%"><strong>No. Permintaan</strong></td>
                                <td>:
                                    <?= $permintaan->kode_permintaan ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>No. Surat Jalan</strong></td>
                                <td>:
                                    <?= $surat_jalan->nomor_pengiriman ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>: <strong class="text-danger">Belum Selesai</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-6">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td width="40%"><strong>Dari Gudang</strong></td>
                                <td>:
                                    <?= $permintaan->nama_gudang_asal ?? '-' ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tujuan</strong></td>
                                <td>:
                                    <?= $permintaan->nama_gudang_tujuan ?? '-' ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Pemohon</strong></td>
                                <td>:
                                    <?= $permintaan->nama_user ?? '-' ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Barang Tidak Sesuai -->
                <h5 class="font-weight-bold text-danger mb-3">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Daftar Barang Tidak Sesuai
                </h5>
                <div class="table-responsive">
                    <table class="table table-bordered mb-4">
                        <thead>
                            <tr style="background-color: #f8d7da;">
                                <th width="5%" class="text-center">No</th>
                                <th width="13%">Kode Barang</th>
                                <th width="25%">Nama Barang</th>
                                <th width="8%" class="text-center">Satuan</th>
                                <th width="9%" class="text-center">Qty Kirim</th>
                                <th width="10%" class="text-center">Qty Diterima</th>
                                <th width="30%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($details as $item): ?>
                                <?php if ($item->is_sesuai == 0): ?>
                                    <tr>
                                        <td class="text-center">
                                            <?= $no++ ?>
                                        </td>
                                        <td>
                                            <?= $item->kode_barang ?? '-' ?>
                                        </td>
                                        <td>
                                            <?= $item->nama_barang ?? '-' ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $item->nama_satuan ?? '-' ?>
                                        </td>
                                        <td class="text-center"><strong>
                                                <?= number_format($item->qty) ?>
                                            </strong></td>
                                        <td class="text-center"><strong class="text-danger">
                                                <?= number_format($item->qty_diterima !== null ? $item->qty_diterima : 0) ?>
                                            </strong></td>
                                        <td>
                                            <?= $item->keterangan_verifikasi ?? '-' ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Barang Sesuai -->
                <h5 class="font-weight-bold text-success mb-3">
                    <i class="fas fa-check-circle mr-1"></i> Daftar Barang Sesuai
                </h5>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr style="background-color: #d4edda;">
                                <th width="5%" class="text-center">No</th>
                                <th width="13%">Kode Barang</th>
                                <th width="25%">Nama Barang</th>
                                <th width="8%" class="text-center">Satuan</th>
                                <th width="9%" class="text-center">Qty Kirim</th>
                                <th width="10%" class="text-center">Qty Diterima</th>
                                <th width="30%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no2 = 1;
                            foreach ($details as $item): ?>
                                <?php if ($item->is_sesuai == 1): ?>
                                    <tr>
                                        <td class="text-center">
                                            <?= $no2++ ?>
                                        </td>
                                        <td>
                                            <?= $item->kode_barang ?? '-' ?>
                                        </td>
                                        <td>
                                            <?= $item->nama_barang ?? '-' ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $item->nama_satuan ?? '-' ?>
                                        </td>
                                        <td class="text-center"><strong>
                                                <?= number_format($item->qty) ?>
                                            </strong></td>
                                        <td class="text-center"><strong>
                                                <?= number_format($item->qty_diterima !== null ? $item->qty_diterima : $item->qty) ?>
                                            </strong></td>
                                        <td>
                                            <?= $item->keterangan_verifikasi ?? '-' ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tanda Tangan -->
                <div class="row mt-5">
                    <div class="col-6 text-center">
                        <p class="mb-0"><strong>Penerima</strong></p>
                        <p class="text-muted mb-0"><small>(Admin Proyek)</small></p>
                        <br><br><br><br>
                        <p
                            style="border-top: 1px solid #333; display: inline-block; padding-top: 5px; min-width: 200px;">
                            <?= $permintaan->nama_user ?? '________________' ?>
                        </p>
                    </div>
                    <div class="col-6 text-center">
                        <p class="mb-0"><strong>Mengetahui</strong></p>
                        <p class="text-muted mb-0"><small>(Admin Pusat)</small></p>
                        <br><br><br><br>
                        <p
                            style="border-top: 1px solid #333; display: inline-block; padding-top: 5px; min-width: 200px;">
                            ________________
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-between no-print">
            <a href="<?= base_url('preorder/detail/' . $permintaan->id) ?>" class="btn btn-secondary">
                <i data-feather="arrow-left" class="feather-sm me-1"></i> Kembali
            </a>
            <button type="button" class="btn btn-danger" onclick="window.print()">
                <i data-feather="printer" class="feather-sm me-1"></i> Cetak Laporan
            </button>
        </div>
    </div>
</div>

<style>
    @media print {

        .no-print,
        .sidebar-nav,
        .topbar,
        .page-breadcrumb,
        .left-sidebar {
            display: none !important;
        }

        .page-wrapper {
            margin-left: 0 !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }

        body {
            font-size: 12pt;
        }

        .table th,
        .table td {
            padding: 6px 8px !important;
        }
    }
</style>