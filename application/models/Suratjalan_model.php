<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Suratjalan_model extends MY_Model
{
    public $table = 'surat_jalan';

    /**
     * Simpan surat jalan baru (header + detail)
     */
    public function createSuratJalan($data, $items)
    {
        $this->db->trans_start();

        // Insert header surat jalan
        $this->db->insert('surat_jalan', $data);
        $id_surat_jalan = $this->db->insert_id();

        // Insert detail items
        foreach ($items as $item) {
            $this->db->insert('surat_jalan_detail', [
                'id_surat_jalan' => $id_surat_jalan,
                'id_barang' => $item['id_barang'],
                'qty' => $item['qty'],
                'keterangan' => isset($item['keterangan']) ? $item['keterangan'] : null
            ]);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $id_surat_jalan : false;
    }

    /**
     * Ambil surat jalan berdasarkan id_permintaan
     */
    public function getSuratJalanByPermintaan($id_permintaan)
    {
        return $this->db->where('id_permintaan', $id_permintaan)
            ->get('surat_jalan')
            ->row();
    }

    /**
     * Ambil detail surat jalan
     */
    public function getSuratJalanDetails($id_surat_jalan)
    {
        return $this->db->select([
            'surat_jalan_detail.*',
            'barang.kode_barang',
            'barang.nama AS nama_barang',
            'satuan.nama AS nama_satuan'
        ])
            ->from('surat_jalan_detail')
            ->join('barang', 'surat_jalan_detail.id_barang = barang.id', 'left')
            ->join('satuan', 'barang.id_satuan = satuan.id', 'left')
            ->where('surat_jalan_detail.id_surat_jalan', $id_surat_jalan)
            ->get()
            ->result();
    }

    /**
     * Update hasil verifikasi per item
     */
    public function updateVerifikasi($id_surat_jalan, $id_barang, $is_sesuai, $keterangan_verifikasi = null, $qty_diterima = null)
    {
        return $this->db->where('id_surat_jalan', $id_surat_jalan)
            ->where('id_barang', $id_barang)
            ->update('surat_jalan_detail', [
                'is_sesuai' => $is_sesuai,
                'keterangan_verifikasi' => $keterangan_verifikasi,
                'qty_diterima' => $qty_diterima
            ]);
    }

    /**
     * Ambil detail surat jalan beserta hasil verifikasi
     */
    public function getSuratJalanDetailsWithVerifikasi($id_surat_jalan)
    {
        return $this->db->select([
            'surat_jalan_detail.*',
            'barang.kode_barang',
            'barang.nama AS nama_barang',
            'satuan.nama AS nama_satuan'
        ])
            ->from('surat_jalan_detail')
            ->join('barang', 'surat_jalan_detail.id_barang = barang.id', 'left')
            ->join('satuan', 'barang.id_satuan = satuan.id', 'left')
            ->where('surat_jalan_detail.id_surat_jalan', $id_surat_jalan)
            ->get()
            ->result();
    }
}

/* End of file Suratjalan_model.php */
