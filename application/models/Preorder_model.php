<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Preorder_model extends MY_Model
{
    public $table = 'permintaan_barang';
    protected $perPage = 10;

    /**
     * Generate kode permintaan otomatis
     * Format: PO-YYYYMMDD-XXXX
     */
    public function generateKode()
    {
        $date = date('Ymd');
        $lastKode = $this->db->select('kode_permintaan')
            ->like('kode_permintaan', 'PO-' . $date)
            ->order_by('id', 'desc')
            ->limit(1)
            ->get('permintaan_barang')
            ->row();

        if ($lastKode) {
            $num = (int) substr($lastKode->kode_permintaan, -4) + 1;
            return 'PO-' . $date . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);
        }

        return 'PO-' . $date . '-0001';
    }

    /**
     * Ambil semua permintaan dengan join
     */
    public function getAllPermintaan($page = null)
    {
        $this->db->select([
            'permintaan_barang.*',
            'ga.nama AS nama_gudang_asal',
            'gt.nama AS nama_gudang_tujuan',
            'user.nama AS nama_user'
        ]);
        $this->db->from('permintaan_barang');
        $this->db->join('gudang ga', 'permintaan_barang.id_gudang_asal = ga.id', 'left');
        $this->db->join('gudang gt', 'permintaan_barang.id_gudang_tujuan = gt.id', 'left');
        $this->db->join('user', 'permintaan_barang.id_user = user.id', 'left');
        $this->db->order_by('permintaan_barang.created_at', 'DESC');

        if ($page !== null) {
            $this->db->limit($this->perPage, $this->calculateRealOffset($page));
        }

        return $this->db->get()->result();
    }

    /**
     * Ambil detail permintaan by ID
     */
    public function getPermintaanById($id)
    {
        return $this->db->select([
            'permintaan_barang.*',
            'ga.nama AS nama_gudang_asal',
            'gt.nama AS nama_gudang_tujuan',
            'user.nama AS nama_user'
        ])
            ->from('permintaan_barang')
            ->join('gudang ga', 'permintaan_barang.id_gudang_asal = ga.id', 'left')
            ->join('gudang gt', 'permintaan_barang.id_gudang_tujuan = gt.id', 'left')
            ->join('user', 'permintaan_barang.id_user = user.id', 'left')
            ->where('permintaan_barang.id', $id)
            ->get()
            ->row();
    }

    /**
     * Ambil detail barang yang diminta
     */
    public function getPermintaanDetails($id_permintaan)
    {
        return $this->db->select([
            'permintaan_barang_detail.*',
            'barang.kode_barang',
            'barang.nama AS nama_barang',
            'satuan.nama AS nama_satuan'
        ])
            ->from('permintaan_barang_detail')
            ->join('barang', 'permintaan_barang_detail.id_barang = barang.id', 'left')
            ->join('satuan', 'barang.id_satuan = satuan.id', 'left')
            ->where('permintaan_barang_detail.id_permintaan', $id_permintaan)
            ->get()
            ->result();
    }

    /**
     * Simpan permintaan baru (header + detail)
     */
    public function createPermintaan($data, $items)
    {
        $this->db->trans_start();

        // Insert header
        $this->db->insert('permintaan_barang', $data);
        $id_permintaan = $this->db->insert_id();

        // Insert detail items
        foreach ($items as $item) {
            $this->db->insert('permintaan_barang_detail', [
                'id_permintaan' => $id_permintaan,
                'id_barang' => $item['id_barang'],
                'qty' => $item['qty'],
                'keterangan' => isset($item['keterangan']) ? $item['keterangan'] : null
            ]);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $id_permintaan : false;
    }

    /**
     * Update status permintaan
     */
    public function updateStatus($id, $status, $alasan_tolak = null)
    {
        $data = ['status' => $status];
        if ($alasan_tolak !== null) {
            $data['alasan_tolak'] = $alasan_tolak;
        }
        return $this->db->where('id', $id)->update('permintaan_barang', $data);
    }

    /**
     * Hitung total permintaan
     */
    public function countPermintaan()
    {
        return $this->db->count_all('permintaan_barang');
    }

    /**
     * Ambil permintaan berdasarkan tanggal
     */
    public function getPermintaanByDate($date)
    {
        $this->db->select([
            'permintaan_barang.*',
            'ga.nama AS nama_gudang_asal',
            'gt.nama AS nama_gudang_tujuan',
            'user.nama AS nama_user'
        ]);
        $this->db->from('permintaan_barang');
        $this->db->join('gudang ga', 'permintaan_barang.id_gudang_asal = ga.id', 'left');
        $this->db->join('gudang gt', 'permintaan_barang.id_gudang_tujuan = gt.id', 'left');
        $this->db->join('user', 'permintaan_barang.id_user = user.id', 'left');
        $this->db->where('DATE(permintaan_barang.tanggal_permintaan)', date('Y-m-d', strtotime($date)));
        $this->db->order_by('permintaan_barang.created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Ambil permintaan untuk Dashboard
     * $type = 'active'  → menunggu, disetujui, surat_jalan, dikirim
     * $type = 'history' → selesai, belum_selesai, ditolak
     */
    public function getDashboardPermintaan($type = 'active', $limit = 10, $filterDate = null)
    {
        $activeStatuses = ['menunggu', 'disetujui', 'surat_jalan', 'dikirim'];
        $historyStatuses = ['selesai', 'belum_selesai', 'ditolak'];

        $this->db->select([
            'permintaan_barang.*',
            'ga.nama AS nama_gudang_asal',
            'gt.nama AS nama_gudang_tujuan',
            'user.nama AS nama_user'
        ]);
        $this->db->from('permintaan_barang');
        $this->db->join('gudang ga', 'permintaan_barang.id_gudang_asal = ga.id', 'left');
        $this->db->join('gudang gt', 'permintaan_barang.id_gudang_tujuan = gt.id', 'left');
        $this->db->join('user', 'permintaan_barang.id_user = user.id', 'left');
        $this->db->where_in('permintaan_barang.status', $type === 'history' ? $historyStatuses : $activeStatuses);
        if (!empty($filterDate)) {
            $this->db->where('DATE(permintaan_barang.tanggal_permintaan)', date('Y-m-d', strtotime($filterDate)));
        }
        $this->db->order_by('permintaan_barang.created_at', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result();
    }

    /**
     * Hapus permintaan beserta detailnya
     */
    public function deletePermintaan($id)
    {
        $this->db->trans_start();

        // Hapus surat jalan detail (jika ada)
        $surat_jalan = $this->db->where('id_permintaan', $id)->get('surat_jalan')->row();
        if ($surat_jalan) {
            $this->db->where('id_surat_jalan', $surat_jalan->id)->delete('surat_jalan_detail');
            $this->db->where('id', $surat_jalan->id)->delete('surat_jalan');
        }

        // Hapus detail permintaan
        $this->db->where('id_permintaan', $id)->delete('permintaan_barang_detail');

        // Hapus header permintaan
        $this->db->where('id', $id)->delete('permintaan_barang');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}

/* End of file Preorder_model.php */
