<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer_model extends MY_Model
{
    public $table = 'transfer_gudang';
    protected $perPage = 10;

    /**
     * Generate kode transfer otomatis
     */
    public function generateKode()
    {
        $date = date('Ymd');
        $lastKode = $this->db->select('kode_transfer')
            ->like('kode_transfer', 'TRF-' . $date)
            ->order_by('id', 'desc')
            ->limit(1)
            ->get('transfer_gudang')
            ->row();

        if ($lastKode) {
            $num = (int) substr($lastKode->kode_transfer, -4) + 1;
            return 'TRF-' . $date . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);
        }

        return 'TRF-' . $date . '-0001';
    }

    /**
     * Ambil semua transfer dengan join
     */
    public function getAllTransfers($page = null)
    {
        $this->db->select([
            'transfer_gudang.*',
            'ga.nama AS nama_gudang_asal',
            'gt.nama AS nama_gudang_tujuan',
            'user.nama AS nama_user'
        ]);
        $this->db->from('transfer_gudang');
        $this->db->join('gudang ga', 'transfer_gudang.id_gudang_asal = ga.id', 'left');
        $this->db->join('gudang gt', 'transfer_gudang.id_gudang_tujuan = gt.id', 'left');
        $this->db->join('user', 'transfer_gudang.id_user = user.id', 'left');
        $this->db->order_by('transfer_gudang.waktu', 'DESC');

        if ($page !== null) {
            $this->db->limit($this->perPage, $this->calculateRealOffset($page));
        }

        return $this->db->get()->result();
    }

    /**
     * Ambil detail transfer by ID
     */
    public function getTransferById($id)
    {
        return $this->db->select([
            'transfer_gudang.*',
            'ga.nama AS nama_gudang_asal',
            'gt.nama AS nama_gudang_tujuan',
            'user.nama AS nama_user'
        ])
            ->from('transfer_gudang')
            ->join('gudang ga', 'transfer_gudang.id_gudang_asal = ga.id', 'left')
            ->join('gudang gt', 'transfer_gudang.id_gudang_tujuan = gt.id', 'left')
            ->join('user', 'transfer_gudang.id_user = user.id', 'left')
            ->where('transfer_gudang.id', $id)
            ->get()
            ->row();
    }

    /**
     * Ambil detail barang yang ditransfer
     */
    public function getTransferDetails($id_transfer)
    {
        return $this->db->select([
            'transfer_gudang_detail.*',
            'barang.nama AS nama_barang',
            'satuan.nama AS nama_satuan'
        ])
            ->from('transfer_gudang_detail')
            ->join('barang', 'transfer_gudang_detail.id_barang = barang.id', 'left')
            ->join('satuan', 'barang.id_satuan = satuan.id', 'left')
            ->where('transfer_gudang_detail.id_transfer', $id_transfer)
            ->get()
            ->result();
    }

    /**
     * Simpan transfer baru
     */
    public function createTransfer($data, $items)
    {
        $this->db->trans_start();

        // Insert header transfer
        $this->db->insert('transfer_gudang', $data);
        $id_transfer = $this->db->insert_id();

        // Insert detail items
        foreach ($items as $item) {
            $this->db->insert('transfer_gudang_detail', [
                'id_transfer' => $id_transfer,
                'id_barang' => $item['id_barang'],
                'qty' => $item['qty']
            ]);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $id_transfer : false;
    }

    /**
     * Hitung total transfer
     */
    public function countTransfers()
    {
        return $this->db->count_all('transfer_gudang');
    }

    /**
     * Ambil transfer berdasarkan tanggal
     */
    public function getTransfersByDate($date)
    {
        $this->db->select([
            'transfer_gudang.*',
            'ga.nama AS nama_gudang_asal',
            'gt.nama AS nama_gudang_tujuan',
            'user.nama AS nama_user'
        ]);
        $this->db->from('transfer_gudang');
        $this->db->join('gudang ga', 'transfer_gudang.id_gudang_asal = ga.id', 'left');
        $this->db->join('gudang gt', 'transfer_gudang.id_gudang_tujuan = gt.id', 'left');
        $this->db->join('user', 'transfer_gudang.id_user = user.id', 'left');
        $this->db->where('DATE(transfer_gudang.waktu)', date('Y-m-d', strtotime($date)));
        $this->db->order_by('transfer_gudang.waktu', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Calculate offset for pagination
     */
    public function calculateRealOffset($page)
    {
        return (is_null($page) || empty($page)) ? 0 : ($page - 1) * $this->perPage;
    }

    /**
     * Hapus transfer beserta detailnya
     */
    public function deleteTransfer($id)
    {
        $this->db->trans_start();

        // Hapus detail transfer terlebih dahulu
        $this->db->where('id_transfer', $id)->delete('transfer_gudang_detail');

        // Hapus header transfer
        $this->db->where('id', $id)->delete('transfer_gudang');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}

/* End of file Transfer_model.php */
