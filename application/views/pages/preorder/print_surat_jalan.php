<div class="row">
    <div class="col-12">
        <div class="card" id="printArea">
            <div class="card-body">
                <img src="<?= base_url('assets/images/Logo Lixicon.png') ?>" alt="Logo" width="100">
            <hr style="border-top: 3px double #333;">
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td width="45%"><strong>Nomor Pengiriman</strong></td>
                        <td>:
                            <?= $surat_jalan->nomor_pengiriman ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Pengiriman</strong></td>
                        <td>:
                            <?= date('d F Y', strtotime($surat_jalan->tanggal_pengiriman)) ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>No. Permintaan</strong></td>
                        <td>:
                            <?= $permintaan->kode_permintaan ?>
                        </td>
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
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th width="8%" class="text-center">No</th>
                        <th width="35%">Nama Barang</th>
                        <th width="12%" class="text-center">Satuan</th>
                        <th width="15%" class="text-center">Kuantitas</th>
                        <th width="30%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($details as $item): ?>
                        <tr>
                            <td class="text-center">
                                <?= $no++ ?>
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
                            <td>
                                <?= $item->keterangan ?? '-' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <!-- <tfoot>
                            <tr style="background-color: #f0f0f0;">
                                <th colspan="3" class="text-end">Total Item:</th>
                                <th class="text-center" colspan="2">
                                    <?= count($details) ?> jenis barang
                                </th>
                            </tr>
                        </tfoot> -->
            </table>
        </div>
        <div class="row mt-5">
            <div class="col-6 text-center">
                <p class="mb-0"><strong>Penerima</strong></p>
                <p class="text-muted mb-0"><small>(Admin Proyek)</small></p>
                <br><br><br><br>
                <p style="border-top: 1px solid #333; display: inline-block; padding-top: 5px; min-width: 200px;">
                    <?= $permintaan->nama_user ?? '________________' ?>
                </p>
            </div>
            <div class="col-6 text-center">
                <p class="mb-0"><strong>Pengirim</strong></p>
                <p class="text-muted mb-0"><small>(Admin Pusat)</small></p>
                <br><br><br><br>
                <p style="border-top: 1px solid #333; display: inline-block; padding-top: 5px; min-width: 200px;">
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
    <button type="button" class="btn btn-primary" onclick="window.print()">
        <i data-feather="printer" class="feather-sm me-1"></i> Cetak Surat Jalan
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