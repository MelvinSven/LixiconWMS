<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk CRUD Gudang (Single)
 */
class Warehouse extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Warehouse_model', 'warehouse');
        $this->load->model('Stokgudang_model', 'stokgudang');

        $is_login = $this->session->userdata('is_login');

        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }
    }

    /**
     * Tambah gudang baru
     */
    public function add()
    {
        if (!$_POST) {
            $this->session->set_flashdata('error', 'Akses tidak diizinkan');
            redirect(base_url('warehouses'));
            return;
        }

        // Validasi
        if (!$this->warehouse->validate()) {
            $this->session->set_flashdata('error', 'Validasi gagal, periksa kembali input Anda');
            redirect(base_url('warehouses'));
            return;
        }

        $data = [
            'nama' => $this->input->post('nama', true),
            'alamat' => $this->input->post('alamat', true)
        ];

        if ($this->warehouse->create($data)) {
            $this->session->set_flashdata('success', 'Gudang berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan gudang');
        }

        redirect(base_url('warehouses'));
    }

    /**
     * Update gudang
     */
    public function update()
    {
        if (!$_POST) {
            $this->session->set_flashdata('error', 'Akses tidak diizinkan');
            redirect(base_url('warehouses'));
            return;
        }

        $id = $this->input->post('id');

        // Validasi
        if (!$this->warehouse->validate()) {
            $this->session->set_flashdata('error', 'Validasi gagal, periksa kembali input Anda');
            redirect(base_url('warehouses'));
            return;
        }

        $data = [
            'nama' => $this->input->post('nama', true),
            'alamat' => $this->input->post('alamat', true)
        ];

        if ($this->warehouse->update($id, $data)) {
            $this->session->set_flashdata('success', 'Gudang berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui gudang');
        }

        redirect(base_url('warehouses'));
    }

    /**
     * Hapus gudang
     */
    public function delete()
    {
        if (!$_POST) {
            $this->session->set_flashdata('error', 'Akses tidak diizinkan');
            redirect(base_url('warehouses'));
            return;
        }

        $id = $this->input->post('id');

        // ── Guard 1: stok barang di gudang ini ────────────────────────────────
        $stok = $this->stokgudang->where('id_gudang', $id)->where('qty >', 0)->first();
        if ($stok) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus gudang yang masih memiliki stok barang');
            redirect(base_url('warehouses'));
            return;
        }

        // ── Guard 2: permintaan barang (preorder) yang belum selesai ──────────
        $preorder = $this->db
            ->group_start()
            ->where('id_gudang_asal', $id)
            ->or_where('id_gudang_tujuan', $id)
            ->group_end()
            ->where('status !=', 'selesai')
            ->count_all_results('permintaan_barang');
        if ($preorder > 0) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus gudang yang masih memiliki permintaan barang yang belum selesai');
            redirect(base_url('warehouses'));
            return;
        }

        // ── Guard 3: riwayat transfer yang belum sampai ───────────────────────
        $transfer = $this->db
            ->group_start()
            ->where('id_gudang_asal', $id)
            ->or_where('id_gudang_tujuan', $id)
            ->group_end()
            ->where('status !=', 'sampai')
            ->count_all_results('transfer_gudang');
        if ($transfer > 0) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus gudang yang masih memiliki pemindahan barang yang belum sampai');
            redirect(base_url('warehouses'));
            return;
        }

        // ── Guard 4: staff yang di-assign ke gudang ini ───────────────────────
        $staff = $this->db
            ->where('id_gudang', $id)
            ->count_all_results('user');
        if ($staff > 0) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus gudang yang masih memiliki staff yang di-assign');
            redirect(base_url('warehouses'));
            return;
        }

        // ── Guard 5: detail barang masuk / keluar / keranjang ─────────────────
        $detail_masuk = $this->db->where('id_gudang', $id)->count_all_results('barang_masuk_detail');
        if ($detail_masuk > 0) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus gudang yang masih memiliki riwayat barang masuk');
            redirect(base_url('warehouses'));
            return;
        }

        $detail_keluar = $this->db->where('id_gudang', $id)->count_all_results('barang_keluar_detail');
        if ($detail_keluar > 0) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus gudang yang masih memiliki riwayat barang keluar');
            redirect(base_url('warehouses'));
            return;
        }

        // ── Safe to delete — clean up FK references in completed records ─────
        $this->db->trans_start();

        // Nullify completed preorder references
        $this->db->where('id_gudang_asal', $id)->where('status', 'selesai')
            ->update('permintaan_barang', ['id_gudang_asal' => null]);
        $this->db->where('id_gudang_tujuan', $id)->where('status', 'selesai')
            ->update('permintaan_barang', ['id_gudang_tujuan' => null]);

        // Nullify completed transfer references
        $this->db->where('id_gudang_asal', $id)->where('status', 'sampai')
            ->update('transfer_gudang', ['id_gudang_asal' => null]);
        $this->db->where('id_gudang_tujuan', $id)->where('status', 'sampai')
            ->update('transfer_gudang', ['id_gudang_tujuan' => null]);

        // Clean up zero-qty stok records
        $this->db->where('id_gudang', $id)->delete('stok_gudang');

        // Delete the warehouse
        $this->warehouse->where('id', $id)->delete();

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('success', 'Gudang berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus gudang');
        }

        redirect(base_url('warehouses'));
    }

    /**
     * Update stok barang di gudang secara langsung (koreksi stok)
     */
    public function update_stock()
    {
        if (!$_POST) {
            $this->session->set_flashdata('error', 'Akses tidak diizinkan');
            redirect(base_url('warehouses'));
            return;
        }

        $id_gudang = (int) $this->input->post('id_gudang');
        $id_barang = (int) $this->input->post('id_barang');
        $new_qty   = (int) $this->input->post('qty');

        if ($new_qty < 0) {
            $this->session->set_flashdata('error', 'Stok tidak boleh negatif');
            redirect(base_url('warehouse/detail/' . $id_gudang));
            return;
        }

        // Access control
        $user_gudang = getUserGudangId();
        if ($user_gudang !== null && (int) $user_gudang !== $id_gudang) {
            $this->session->set_flashdata('error', 'Akses tidak diizinkan');
            redirect(base_url('warehouses'));
            return;
        }

        $existing = $this->stokgudang->getStokByGudangBarang($id_gudang, $id_barang);
        $old_qty   = $existing ? (int) $existing->qty : 0;
        $delta     = $new_qty - $old_qty;

        $this->db->trans_start();

        if ($existing) {
            $this->db->where('id_gudang', $id_gudang)
                     ->where('id_barang', $id_barang)
                     ->update('stok_gudang', ['qty' => $new_qty]);
        } else {
            $this->db->insert('stok_gudang', [
                'id_gudang' => $id_gudang,
                'id_barang' => $id_barang,
                'qty'       => $new_qty,
            ]);
        }

        // Keep global barang.qty in sync
        if ($delta !== 0) {
            $this->db->set('qty', 'qty + ' . $delta, false)
                     ->where('id', $id_barang)
                     ->update('barang');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('success', 'Stok barang berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui stok barang');
        }

        $redirect_to = $this->input->post('redirect_to') ?: base_url('warehouse/detail/' . $id_gudang);
        redirect($redirect_to);
    }

    /**
     * Lihat detail gudang dan stok barang di dalamnya
     */
    public function detail($id)
    {
        $this->load->model('Barang_model', 'barang');

        $data['title'] = 'Lixicon - Detail Gudang';
        $data['breadcrumb_title'] = "Detail Gudang";
        $data['breadcrumb_path'] = 'Manajemen Gudang / Detail';
        $data['page'] = 'pages/warehouses/detail';

        // Data gudang
        $data['warehouse'] = $this->warehouse->where('id', $id)->first();

        if (!$data['warehouse']) {
            $this->session->set_flashdata('error', 'Gudang tidak ditemukan');
            redirect(base_url('warehouses'));
            return;
        }

        // Data stok di gudang ini
        $data['stocks'] = $this->stokgudang->getStokByGudang($id);

        // Data semua barang untuk dropdown tambah barang
        $data['all_items'] = $this->db->select('barang.id, barang.nama, satuan.nama AS nama_satuan')
            ->join('satuan', 'barang.id_satuan = satuan.id', 'left')
            ->get('barang')
            ->result();

        // Statistik
        $data['total_jenis'] = count($data['stocks']);
        $data['total_qty'] = array_sum(array_column($data['stocks'], 'qty'));

        // Determine if current user can modify this warehouse's stock
        $user_gudang = getUserGudangId();
        $data['can_modify'] = ($user_gudang === null) || ((int)$user_gudang === (int)$id);

        $this->view($data);
    }
}

/* End of file Warehouse.php */
