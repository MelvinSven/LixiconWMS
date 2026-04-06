<?php
$db = new mysqli('localhost', 'root', '', 'easy_wms_test');
if ($db->connect_error) {
    echo 'Connection failed: ' . $db->connect_error . PHP_EOL;
    exit(1);
}

$sql = "ALTER TABLE `barang_keluar` ADD COLUMN `nama_kurir` VARCHAR(100) NULL DEFAULT NULL AFTER `bukti_foto`";
if ($db->query($sql)) {
    echo 'Migration berhasil: kolom nama_kurir ditambahkan ke tabel barang_keluar' . PHP_EOL;
} else {
    echo 'Error: ' . $db->error . PHP_EOL;
}
$db->close();
