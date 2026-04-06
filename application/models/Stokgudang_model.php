<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stokgudang_model extends MY_Model 
{
    public $table = 'stok_gudang';

    /**
     * Ambil stok barang di gudang tertentu
     */
    public function getStokByGudang($id_gudang)
    {
        return $this->db->select([
                'stok_gudang.id',
                'stok_gudang.qty',
                'stok_gudang.stok_minimum',
                'barang.id AS id_barang',
                'barang.kode_barang',
                'barang.nama AS nama_barang',
                'barang.image',
                'satuan.nama AS nama_satuan',
                'gudang.nama AS nama_gudang',
                'supplier.nama AS nama_supplier'
            ])
            ->join('barang', 'stok_gudang.id_barang = barang.id')
            ->join('satuan', 'barang.id_satuan = satuan.id', 'left')
            ->join('gudang', 'stok_gudang.id_gudang = gudang.id', 'left')
            ->join('supplier', 'barang.id_supplier = supplier.id_supplier', 'left')
            ->where('stok_gudang.id_gudang', $id_gudang)
            ->get('stok_gudang')
            ->result();
    }

    /**
     * Ambil stok barang tertentu di semua gudang
     */
    public function getStokByBarang($id_barang)
    {
        return $this->db->select([
                'stok_gudang.id',
                'stok_gudang.qty',
                'stok_gudang.stok_minimum',
                'gudang.id AS id_gudang',
                'gudang.nama AS nama_gudang'
            ])
            ->join('gudang', 'stok_gudang.id_gudang = gudang.id', 'left')
            ->where('stok_gudang.id_barang', $id_barang)
            ->get('stok_gudang')
            ->result();
    }

    /**
     * Cek ketersediaan stok di gudang tertentu
     */
    public function cekStok($id_gudang, $id_barang)
    {
        $result = $this->db->select('qty')
                           ->where('id_gudang', $id_gudang)
                           ->where('id_barang', $id_barang)
                           ->get('stok_gudang')
                           ->row();
        
        return $result ? $result->qty : 0;
    }

    /**
     * Ambil stok barang tertentu di gudang tertentu
     */
    public function getStokByGudangBarang($id_gudang, $id_barang)
    {
        return $this->db->where('id_gudang', $id_gudang)
                        ->where('id_barang', $id_barang)
                        ->get('stok_gudang')
                        ->row();
    }

    /**
     * Ambil stok barang di gudang tertentu dengan detail barang (untuk API)
     */
    public function getStokByGudangWithBarang($id_gudang)
    {
        return $this->db->select([
                'stok_gudang.id',
                'stok_gudang.qty',
                'barang.id AS id_barang',
                'barang.nama AS nama_barang',
                'satuan.nama AS nama_satuan'
            ])
            ->join('barang', 'stok_gudang.id_barang = barang.id', 'left')
            ->join('satuan', 'barang.id_satuan = satuan.id', 'left')
            ->where('stok_gudang.id_gudang', $id_gudang)
            ->where('stok_gudang.qty >', 0)
            ->get('stok_gudang')
            ->result();
    }

    /**
     * Update atau insert stok
     */
    public function updateStok($id_gudang, $id_barang, $qty, $operasi = 'add')
    {
        $existing = $this->db->where('id_gudang', $id_gudang)
                             ->where('id_barang', $id_barang)
                             ->get('stok_gudang')
                             ->row();
        
        if ($existing) {
            $newQty = ($operasi == 'add') ? $existing->qty + $qty : $existing->qty - $qty;
            return $this->db->where('id', $existing->id)
                            ->update('stok_gudang', ['qty' => $newQty]);
        } else {
            return $this->db->insert('stok_gudang', [
                'id_gudang' => $id_gudang,
                'id_barang' => $id_barang,
                'qty' => $qty
            ]);
        }
    }
}

/* End of file Stokgudang_model.php */
