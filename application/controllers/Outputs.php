<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Catatan keluar
 */
class Outputs extends MY_Controller
{
    private $id_user;

    public function __construct()
    {
        parent::__construct();

        $this->id_user = $this->session->userdata('id_user');
        $is_login = $this->session->userdata('is_login');

        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }
    }

    public function index($page = null)
    {
        $this->session->unset_userdata('keyword');
        $this->session->unset_userdata('time');

        $data['title'] = APP_NAME . ' - List Barang Keluar';
        $data['breadcrumb_title'] = 'List Barang Keluar';
        $data['breadcrumb_path'] = 'Barang Keluar / List Barang Keluar';

        // Warehouse restriction for staff
        $user_gudang = getUserGudangId();
        if ($user_gudang) {
            $this->outputs->where('barang_keluar.id_user', $this->session->userdata('id_user'));
        }

        $data['content'] = $this->outputs->select([
            'barang_keluar.id',
            'barang_keluar.id_user',
            'user.nama',
            'barang_keluar.waktu',
            'barang_keluar.status',
            'GROUP_CONCAT(DISTINCT gudang.nama ORDER BY gudang.nama SEPARATOR ", ") AS nama_gudang'
        ])
            ->join('user')
            ->join('barang_keluar_detail', 'barang_keluar_detail.id_barang_keluar = barang_keluar.id', 'left')
            ->join('gudang', 'gudang.id = barang_keluar_detail.id_gudang', 'left')
            ->orderBy('barang_keluar.id', 'DESC')
            ->groupBy('barang_keluar.id')
            ->paginate($page)
            ->get();

        if ($user_gudang) {
            $this->outputs->where('barang_keluar.id_user', $this->session->userdata('id_user'));
        }
        $data['total_rows'] = $this->outputs->count();
        $data['pagination'] = $this->outputs->makePagination(base_url('outputs'), 2, $data['total_rows']);
        $data['page'] = 'pages/outputs/index';

        $this->view($data);
    }

    /**
     * Fungsi search berdasarkan id_barang_keluar / nama staff
     */
    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $this->session->unset_userdata('time');
        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('outputs'));
        }

        $data['title'] = APP_NAME . ' - List Barang Keluar';
        $data['breadcrumb_title'] = 'List Barang Keluar';
        $data['breadcrumb_path'] = "Barang Keluar / List Barang Keluar / Cari / $keyword";

        // Warehouse restriction for staff
        $user_gudang = getUserGudangId();
        if ($user_gudang) {
            $this->outputs->where('barang_keluar.id_user', $this->session->userdata('id_user'));
        }

        $data['content'] = $this->outputs->select([
            'barang_keluar.id',
            'barang_keluar.id_user',
            'user.nama',
            'barang_keluar.waktu',
            'barang_keluar.status',
            'GROUP_CONCAT(DISTINCT gudang.nama ORDER BY gudang.nama SEPARATOR ", ") AS nama_gudang'
        ])
            ->join('user')
            ->join('barang_keluar_detail', 'barang_keluar_detail.id_barang_keluar = barang_keluar.id', 'left')
            ->join('gudang', 'gudang.id = barang_keluar_detail.id_gudang', 'left')
            ->like('barang_keluar.id', $keyword)
            ->orLike('user.nama', $keyword)
            ->groupBy('barang_keluar.id')
            ->paginate($page)
            ->get();

        if ($user_gudang) {
            $this->outputs->where('barang_keluar.id_user', $this->session->userdata('id_user'));
        }
        $data['total_rows'] = $this->outputs->join('user')
            ->like('barang_keluar.id', $keyword)
            ->orLike('user.nama', $keyword)
            ->count();
        $data['pagination'] = $this->outputs->makePagination(base_url('outputs/search'), 3, $data['total_rows']);
        $data['page'] = 'pages/outputs/index';

        $this->view($data);
    }

    /**
     * Fungsi search berdasarkan waktu
     */
    public function search_time($page = null)
    {
        if (isset($_POST['time'])) {
            $this->session->set_userdata('time', $this->input->post('time'));
        }

        $this->session->unset_userdata('keyword');
        $time = $this->session->userdata('time');

        if (empty($time)) {
            redirect(base_url('outputs'));
        }

        $displayTime = date('d-m-Y', strtotime($time));
        $data['title'] = APP_NAME . ' - List Barang Keluar';
        $data['breadcrumb_title'] = 'List Barang Keluar';
        $data['breadcrumb_path'] = "Barang Keluar / List Barang Keluar / Filter / $displayTime";

        // Warehouse restriction for staff
        $user_gudang = getUserGudangId();
        if ($user_gudang) {
            $this->outputs->where('barang_keluar.id_user', $this->session->userdata('id_user'));
        }

        $data['content'] = $this->outputs->select([
            'barang_keluar.id',
            'barang_keluar.id_user',
            'user.nama',
            'barang_keluar.waktu',
            'barang_keluar.status',
            'GROUP_CONCAT(DISTINCT gudang.nama ORDER BY gudang.nama SEPARATOR ", ") AS nama_gudang'
        ])
            ->join('user')
            ->join('barang_keluar_detail', 'barang_keluar_detail.id_barang_keluar = barang_keluar.id', 'left')
            ->join('gudang', 'gudang.id = barang_keluar_detail.id_gudang', 'left')
            ->like('DATE(barang_keluar.waktu)', date('Y-m-d', strtotime($time)))
            ->groupBy('barang_keluar.id')
            ->paginate($page)
            ->get();

        if ($user_gudang) {
            $this->outputs->where('barang_keluar.id_user', $this->session->userdata('id_user'));
        }
        $data['total_rows'] = $this->outputs->join('user')
            ->like('DATE(barang_keluar.waktu)', date('Y-m-d', strtotime($time)))
            ->count();
        $data['pagination'] = $this->outputs->makePagination(base_url('outputs/search_time'), 3, $data['total_rows']);
        $data['page'] = 'pages/outputs/index';

        $this->view($data);
    }

    public function detail($id_barang_keluar)
    {
        $data['title'] = APP_NAME . ' - List Barang Keluar';
        $data['breadcrumb_title'] = 'List Barang Keluar';
        $data['breadcrumb_path'] = "Barang Keluar / List Barang Keluar / Detail / $id_barang_keluar";
        $data['page'] = 'pages/outputs/detail';

        // Admin bisa lihat semua, user biasa hanya bisa lihat miliknya
        $this->outputs->select([
            'user.id AS id_user',
            'user.nama',
            'barang_keluar.id AS id_barang_keluar',
            'barang_keluar.waktu',
            'barang_keluar.bukti_foto',
            'barang_keluar.nama_kurir',
            'barang_keluar.keterangan',
            'barang_keluar.status',
            'GROUP_CONCAT(DISTINCT gudang.nama ORDER BY gudang.nama SEPARATOR ", ") AS nama_gudang'
        ])
            ->join('user')
            ->join('barang_keluar_detail', 'barang_keluar_detail.id_barang_keluar = barang_keluar.id', 'left')
            ->join('gudang', 'gudang.id = barang_keluar_detail.id_gudang', 'left')
            ->where('barang_keluar.id', $id_barang_keluar)
            ->groupBy('barang_keluar.id');

        // Jika bukan admin, filter berdasarkan user yang login
        if ($this->session->userdata('role') != 'admin') {
            $this->outputs->where('barang_keluar.id_user', $this->id_user);
        }

        $data['barang_keluar'] = $this->outputs->first();

        // Jika data tidak ditemukan, redirect dengan pesan error
        if (!$data['barang_keluar']) {
            $this->session->set_flashdata('error', 'Data barang keluar tidak ditemukan atau Anda tidak memiliki akses');
            redirect(base_url('outputs'));
            return;
        }

        $this->outputs->table = 'barang_keluar_detail';
        $data['list_barang'] = $this->outputs->select([
            'barang_keluar_detail.qty',
            'barang.id_satuan',
            'barang.nama',
        ])
            ->join('barang')
            ->where('barang_keluar_detail.id_barang_keluar', $id_barang_keluar)
            ->get();

        $this->view($data);
    }

    /**
     * Hapus data pengeluaran barang (Admin only)
     */
    public function delete($id)
    {
        // Cek apakah user adalah admin
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus data');
            redirect(base_url('outputs'));
            return;
        }

        // Cek apakah data ada
        $barang_keluar = $this->outputs->where('id', $id)->first();
        if (!$barang_keluar) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(base_url('outputs'));
            return;
        }

        // Hapus detail terlebih dahulu (akan terhapus otomatis karena CASCADE, tapi untuk keamanan)
        $this->db->where('id_barang_keluar', $id)->delete('barang_keluar_detail');

        // Hapus data utama
        if ($this->outputs->where('id', $id)->delete()) {
            $this->session->set_flashdata('success', 'Data pengeluaran barang berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data');
        }

        redirect(base_url('outputs'));
    }

    /**
     * Update status pengiriman barang keluar
     */
    public function update_status($id)
    {
        $barang_keluar = $this->db->where('id', $id)->get('barang_keluar')->row();
        if (!$barang_keluar) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(base_url('outputs'));
            return;
        }

        // Validasi kepemilikan: hanya pemilik atau admin yang boleh update status
        if ($this->session->userdata('role') != 'admin' && $barang_keluar->id_user != $this->id_user) {
            $this->session->set_flashdata('error', 'Gagal! Data barang keluar tidak ditemukan atau Anda tidak memiliki akses');
            redirect(base_url('outputs'));
            return;
        }

        $new_status = $this->input->post('status');
        if (!in_array($new_status, ['dikirim', 'sampai'])) {
            $this->session->set_flashdata('error', 'Status tidak valid');
            redirect(base_url('outputs'));
            return;
        }

        $this->db->where('id', $id)->update('barang_keluar', ['status' => $new_status]);
        $this->session->set_flashdata('success', 'Status berhasil diubah menjadi ' . ucfirst($new_status));
        redirect(base_url('outputs/detail/' . $id));
    }
}

/* End of file Ouputs.php */
