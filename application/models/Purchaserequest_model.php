<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchaserequest_model extends MY_Model
{
    public $table = 'purchase_request';
    protected $perPage = 10;

    /**
     * Generate kode Purchase Request otomatis
     * Format: PR-YYYYMMDD-XXXX
     */
    public function generateKode()
    {
        $date = date('Ymd');
        $last = $this->db->select('kode_pr')
            ->like('kode_pr', 'PR-' . $date)
            ->order_by('id', 'desc')
            ->limit(1)
            ->get('purchase_request')
            ->row();

        if ($last) {
            $num = (int) substr($last->kode_pr, -4) + 1;
            return 'PR-' . $date . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);
        }

        return 'PR-' . $date . '-0001';
    }

    /**
     * Ambil semua Purchase Request dengan pagination.
     * Jika $id_gudang diisi, hanya tampilkan PR milik gudang tersebut.
     */
    public function getAllPR($page = null, $id_gudang = null)
    {
        $this->db->select([
            'purchase_request.*',
            'gudang.nama AS nama_gudang',
            'user.nama AS nama_user',
            'responder.nama AS nama_responder'
        ]);
        $this->db->from('purchase_request');
        $this->db->join('gudang', 'purchase_request.id_gudang = gudang.id', 'left');
        $this->db->join('user', 'purchase_request.id_user = user.id', 'left');
        $this->db->join('user AS responder', 'purchase_request.id_user_respon = responder.id', 'left');

        if ($id_gudang !== null) {
            $this->db->where('purchase_request.id_gudang', $id_gudang);
        }

        $this->db->order_by('purchase_request.created_at', 'DESC');

        if ($page !== null) {
            $this->db->limit($this->perPage, $this->calculateRealOffset($page));
        }

        return $this->db->get()->result();
    }

    /**
     * Ambil PR berdasarkan ID (dengan join)
     */
    public function getPRById($id)
    {
        return $this->db->select([
            'purchase_request.*',
            'gudang.nama AS nama_gudang',
            'user.nama AS nama_user',
            'responder.nama AS nama_responder'
        ])
            ->from('purchase_request')
            ->join('gudang', 'purchase_request.id_gudang = gudang.id', 'left')
            ->join('user', 'purchase_request.id_user = user.id', 'left')
            ->join('user AS responder', 'purchase_request.id_user_respon = responder.id', 'left')
            ->where('purchase_request.id', $id)
            ->get()
            ->row();
    }

    /**
     * Detail barang pada PR (termasuk kolom verifikasi).
     * Item manual (id_barang NULL) memakai nama_barang_manual + id_satuan_manual.
     */
    public function getPRDetails($id_pr)
    {
        return $this->db->select([
            'purchase_request_detail.*',
            'COALESCE(barang.nama, purchase_request_detail.nama_barang_manual) AS nama_barang',
            'COALESCE(satuan.nama, satuan_manual.nama) AS nama_satuan',
            '(purchase_request_detail.id_barang IS NULL) AS is_manual'
        ], false)
            ->from('purchase_request_detail')
            ->join('barang', 'purchase_request_detail.id_barang = barang.id', 'left')
            ->join('satuan', 'barang.id_satuan = satuan.id', 'left')
            ->join('satuan AS satuan_manual', 'purchase_request_detail.id_satuan_manual = satuan_manual.id', 'left')
            ->where('purchase_request_detail.id_pr', $id_pr)
            ->order_by('nama_barang', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Ambil satu baris detail PR (untuk aksi update qty per item)
     */
    public function getDetailById($id_detail)
    {
        return $this->db->where('id', $id_detail)
            ->get('purchase_request_detail')
            ->row();
    }

    /**
     * Simpan PR baru (header + detail) dalam satu transaksi
     */
    public function createPR($data, $items)
    {
        $this->db->trans_start();

        $this->db->insert('purchase_request', $data);
        $id_pr = $this->db->insert_id();

        foreach ($items as $item) {
            $this->db->insert('purchase_request_detail', [
                'id_pr' => $id_pr,
                'id_barang' => $item['id_barang'] ?? null,
                'nama_barang_manual' => $item['nama_barang_manual'] ?? null,
                'id_satuan_manual' => $item['id_satuan_manual'] ?? null,
                'qty' => $item['qty'],
                'keterangan' => isset($item['keterangan']) ? $item['keterangan'] : null
            ]);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $id_pr : false;
    }

    /**
     * Update status PR
     */
    public function updateStatus($id, $status, $extra = [])
    {
        $data = array_merge(['status' => $status], $extra);
        return $this->db->where('id', $id)->update('purchase_request', $data);
    }

    /**
     * Hitung total PR.
     * Jika $id_gudang diisi, hanya hitung PR milik gudang tersebut.
     */
    public function countPR($id_gudang = null)
    {
        if ($id_gudang !== null) {
            $this->db->where('id_gudang', $id_gudang);
        }
        return $this->db->count_all_results('purchase_request');
    }

    /**
     * Hapus PR beserta detailnya
     */
    public function deletePR($id)
    {
        $this->db->trans_start();
        $this->db->where('id_pr', $id)->delete('purchase_request_detail');
        $this->db->where('id', $id)->delete('purchase_request');
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Promosikan item manual menjadi barang katalog.
     * Insert baris baru ke `barang`, lalu repoint detail PR ke id_barang baru
     * dan kosongkan kolom manual. Return id_barang baru (int) atau false.
     */
    public function promoteManualToItem($id_detail, $nama, $id_satuan)
    {
        $this->db->insert('barang', [
            'id_supplier' => null,
            'id_lokasi'   => null,
            'nama'        => $nama,
            'deskripsi'   => null,
            'qty'         => 0,
            'id_satuan'   => $id_satuan,
            'image'       => 'uploads/items/default.png',
        ]);
        $id_barang = (int) $this->db->insert_id();
        if ($id_barang <= 0) {
            return false;
        }

        $this->db->where('id', $id_detail)->update('purchase_request_detail', [
            'id_barang'          => $id_barang,
            'nama_barang_manual' => null,
            'id_satuan_manual'   => null,
        ]);

        return $id_barang;
    }

    /**
     * Simpan hasil verifikasi per item (Project Admin)
     */
    public function updateItemVerifikasi($id_detail, $is_sesuai, $qty_diterima, $keterangan_verifikasi = null)
    {
        return $this->db->where('id', $id_detail)->update('purchase_request_detail', [
            'is_sesuai' => $is_sesuai,
            'qty_diterima' => $qty_diterima,
            'keterangan_verifikasi' => $keterangan_verifikasi,
        ]);
    }

    /**
     * Update qty item (dipakai Project Admin untuk menyesuaikan qty
     * pada item "Belum Selesai" agar statusnya menjadi "Barang Sesuai")
     */
    public function updateItemQty($id_detail, $qty, $is_sesuai = null)
    {
        $data = ['qty' => $qty];
        if ($is_sesuai !== null) {
            $data['is_sesuai'] = $is_sesuai;
        }
        return $this->db->where('id', $id_detail)->update('purchase_request_detail', $data);
    }

    /**
     * Simpan satu entri Surat Jalan untuk sebuah PR.
     */
    public function saveSuratJalan($id_pr, $nama_file, $file_path)
    {
        return $this->db->insert('surat_jalan_pr', [
            'id_pr'     => $id_pr,
            'nama_file' => $nama_file,
            'file_path' => $file_path,
        ]);
    }

    /**
     * Ambil semua Surat Jalan milik sebuah PR, urut terlama ke terbaru.
     */
    public function getSuratJalanList($id_pr)
    {
        return $this->db->where('id_pr', $id_pr)
            ->order_by('uploaded_at', 'ASC')
            ->get('surat_jalan_pr')
            ->result();
    }

    /**
     * Ringkasan status verifikasi per item pada sebuah PR.
     * return: ['total', 'sesuai', 'belum_sesuai', 'belum_diverifikasi']
     */
    public function getVerifikasiProgress($id_pr)
    {
        $details = $this->db->where('id_pr', $id_pr)
            ->get('purchase_request_detail')
            ->result();

        $stats = ['total' => 0, 'sesuai' => 0, 'belum_sesuai' => 0, 'belum_diverifikasi' => 0];
        foreach ($details as $d) {
            $stats['total']++;
            if ($d->is_sesuai === null) {
                $stats['belum_diverifikasi']++;
            } elseif ((int) $d->is_sesuai === 1) {
                $stats['sesuai']++;
            } else {
                $stats['belum_sesuai']++;
            }
        }
        return $stats;
    }
}

/* End of file Purchaserequest_model.php */
