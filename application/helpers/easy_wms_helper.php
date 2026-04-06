<?php

/**
 * Nama Aplikasi
 */
define('APP_NAME', 'Warehouse Lixicon');

/**
 * Mendapatkan id_gudang user yang sedang login
 * Return null jika admin atau tidak ada pembatasan
 */
function getUserGudangId()
{
    $CI =& get_instance();
    $role = $CI->session->userdata('role');

    // Admin has access to all warehouses
    if ($role == 'admin') {
        return null;
    }

    $id_user = $CI->session->userdata('id_user');
    $user = $CI->db->where('id', $id_user)->get('user')->row();

    return $user ? $user->id_gudang : null;
}

/**
 * Cek apakah user dibatasi ke gudang tertentu
 */
function isWarehouseRestricted()
{
    $CI =& get_instance();
    return $CI->session->userdata('role') != 'admin' && getUserGudangId() != null;
}

/**
 * Mendapatkan jumlah karyawan
 */
function getJumlahStaff()
{
    $CI =& get_instance();
    return $CI->db->get('user')->num_rows();
}

/**
 * Mendapatkan jumlah barang
 */
function getJumlahBarang()
{
    $CI =& get_instance();
    return $CI->db->where('qty !=', 0)->get('barang')->num_rows();
}

/**
 * Mendapatkan jumlah stok
 */
function getJumlahStok()
{
    $CI =& get_instance();
    $CI->db->select_sum('qty');
    $result = $CI->db->get('barang')->row();
    return $result->qty ?? 0;
}

/**
 * Mendapatkan seluruh list satuan barang
 */
function getUnits()
{
    $CI =& get_instance();
    $CI->db->where('status', 'valid');
    return $CI->db->get('satuan')->result();
}

/**
 * Mendapatkan satuan barang berdasarkan id
 */
function getUnitName($id_satuan)
{
    $CI =& get_instance();
    $CI->db->where('id', $id_satuan);
    return $CI->db->get('satuan')->row()->nama;
}

/**
 * Mendapatkan pendapatan bulan ini
 */
function getTodayEarning()
{
    $CI =& get_instance();

    $CI->db->select_sum('total_harga', 'total_harga');
    $CI->db->where('DATE(waktu_penjualan)', date('Y-m-d'));
    return $CI->db->get('penjualan')->row()->total_harga;
}

/**
 * Mendapatkan banyak penjualan hari ini
 */
function getTodayCountSales()
{
    $CI =& get_instance();

    $CI->db->where('DATE(waktu_penjualan)', date('Y-m-d'));
    return $CI->db->get('penjualan')->num_rows();
}

/**
 * Mendapatkan banyak menu yang disediakan
 */
function getCountMenu()
{
    $CI =& get_instance();
    return $CI->db->get('stock_barang')->num_rows();
}

/**
 * Fungsi ini mengembalikan banyak barang dan total penjualan berdasarkan
 * tipe barang (makanan/minuman) dari tabel detail_penjualan
 */
function getSalesInfoByType($type)
{
    $CI =& get_instance();
    $CI->db->select('
        COUNT(detail_penjualan.qty_jual) AS banyak, 
        SUM(detail_penjualan.subtotal_jual) as total
    ');
    $CI->db->from('detail_penjualan');
    $CI->db->join('stock_barang', 'detail_penjualan.id_barang = stock_barang.id_barang');
    $CI->db->where('stock_barang.tipe_barang', $type);
    return $CI->db->get()->row();
}

/**
 * Mengenkripsi input
 */
function hashEncrypt($input)
{
    $hash = password_hash($input, PASSWORD_DEFAULT);
    return $hash;
}

/**
 * Mendecrypt hash password dari table user
 * Mengembalikan true jika plain-text sama
 */
function hashEncryptVerify($input, $hash)
{
    if (password_verify($input, $hash)) {
        return true;
    } else {
        return false;
    }
}

// ============================================
// HELPER FUNCTIONS UNTUK MULTI-GUDANG
// ============================================

/**
 * Mendapatkan semua gudang
 */
function getWarehouses()
{
    $CI =& get_instance();
    return $CI->db->order_by('nama', 'asc')
        ->get('gudang')
        ->result();
}

/**
 * Mendapatkan nama gudang berdasarkan ID
 */
function getWarehouseName($id_gudang)
{
    $CI =& get_instance();
    $result = $CI->db->where('id', $id_gudang)->get('gudang')->row();
    return $result ? $result->nama : 'Tidak Diketahui';
}

/**
 * Mendapatkan jumlah gudang
 */
function getJumlahGudang()
{
    $CI =& get_instance();
    return $CI->db->get('gudang')->num_rows();
}

/**
 * Mendapatkan stok barang di gudang tertentu
 */
function getStokGudang($id_gudang, $id_barang)
{
    $CI =& get_instance();
    $result = $CI->db->where('id_gudang', $id_gudang)
        ->where('id_barang', $id_barang)
        ->get('stok_gudang')
        ->row();
    return $result ? $result->qty : 0;
}

/**
 * Mendapatkan semua stok barang tertentu di berbagai gudang
 */
function getStokBarangAllGudang($id_barang)
{
    $CI =& get_instance();
    return $CI->db->select('stok_gudang.*, gudang.nama AS nama_gudang')
        ->join('gudang', 'stok_gudang.id_gudang = gudang.id', 'left')
        ->where('stok_gudang.id_barang', $id_barang)
        ->get('stok_gudang')
        ->result();
}

/**
 * Mendapatkan total stok di semua gudang
 */
function getTotalStokAllGudang()
{
    $CI =& get_instance();
    $CI->db->select_sum('qty');
    $result = $CI->db->get('stok_gudang')->row();
    return $result->qty ?: 0;
}

/**
 * Mendapatkan seluruh list supplier
 */
function getSuppliers()
{
    $CI =& get_instance();
    return $CI->db->get('supplier')->result();
}

/**
 * Mendapatkan nama supplier berdasarkan id
 */
function getSupplierName($id_supplier)
{
    if (empty($id_supplier))
        return '-';
    $CI =& get_instance();
    $CI->db->where('id_supplier', $id_supplier);
    $result = $CI->db->get('supplier')->row();
    return $result ? $result->nama : '-';
}

/**
 * Mendapatkan ringkasan gudang
 */
function getWarehouseSummary($id_gudang)
{
    $CI =& get_instance();

    // Hitung jumlah jenis barang
    $jenis = $CI->db->where('id_gudang', $id_gudang)
        ->get('stok_gudang')
        ->num_rows();

    // Hitung total qty
    $CI->db->select_sum('qty');
    $CI->db->where('id_gudang', $id_gudang);
    $total_qty = $CI->db->get('stok_gudang')->row()->qty ?: 0;

    return [
        'jenis_barang' => $jenis,
        'total_qty' => $total_qty
    ];
}

/**
 * Mendapatkan seluruh list lokasi barang
 */
function getLocations()
{
    $CI =& get_instance();
    return $CI->db->order_by('nama_lokasi', 'asc')
        ->get('lokasi_barang')
        ->result();
}

/**
 * Mendapatkan nama lokasi berdasarkan id
 */
function getLocationName($id_lokasi)
{
    if (empty($id_lokasi))
        return '-';
    $CI =& get_instance();
    $CI->db->where('id_lokasi', $id_lokasi);
    $result = $CI->db->get('lokasi_barang')->row();
    return $result ? $result->nama_lokasi : '-';
}