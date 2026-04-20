<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cartout_model extends MY_Model 
{
    public $table = 'keranjang_keluar';

    /**
     * Validasi Stok; untuk membandingkan kuantitas barang yang ada di 
     * tabel keranjang_keluar dengan kuantitas barang yang ada di tabel barang
     * Ini dilakukan agar user tidak mengurangi barang hingga minus
     */
    public function validateStock()
    {
        $valid   = true;
        $id_user = $this->session->userdata('id_user');
        $this->table = 'keranjang_keluar';
        $cart    = $this->where('id_user', $id_user)->get();

        foreach ($cart as $row) {
            // Check per-warehouse stock in stok_gudang, not the global barang.qty
            $stok_result = $this->db->where('id_gudang', $row->id_gudang)
                ->where('id_barang', $row->id_barang)
                ->get('stok_gudang')
                ->row();

            $stok = $stok_result ? $stok_result->qty : 0;

            if ($stok < $row->qty) {
                $this->session->set_flashdata("qty_cartout_$row->id", "Stok di gudang hanya ada $stok");
                $valid = false;
            }
        }

        $this->table = 'keranjang_keluar';
        return $valid;
    }
}

/* End of file Cartout_model.php */
