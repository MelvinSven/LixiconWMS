<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Catatan Masuk
 */
class Inputs extends MY_Controller
{
    private $id_user;

    public function __construct()
    {
        parent::__construct();

        $this->id_user = $this->session->userdata('id_user');
        $is_login = $this->session->userdata('is_login');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }
    }

    public function index($page = null)
    {
        $this->session->unset_userdata('keyword');
        $this->session->unset_userdata('time');

        $data['title'] = 'Lixicon - List Barang Masuk';
        $data['breadcrumb_title'] = 'List Barang Masuk';
        $data['breadcrumb_path'] = 'Barang Masuk / List Barang Masuk';
        // Warehouse restriction for staff
        $user_gudang = getUserGudangId();

        $this->db->select('GROUP_CONCAT(DISTINCT gudang.nama SEPARATOR ", ") AS nama_gudang', FALSE);

        if ($user_gudang) {
            $this->inputs->where('barang_masuk.id_user', $this->session->userdata('id_user'));
        }

        $data['content'] = $this->inputs->select([
            'barang_masuk.id',
            'user.nama',
            'barang_masuk.waktu'
        ])
            ->join('user')
            ->join('barang_masuk_detail', 'barang_masuk_detail.id_barang_masuk = barang_masuk.id', 'left')
            ->join('gudang', 'barang_masuk_detail.id_gudang = gudang.id', 'left')
            ->groupBy('barang_masuk.id')
            ->orderBy('barang_masuk.id', 'DESC')
            ->paginate($page)
            ->get();

        if ($user_gudang) {
            $this->inputs->where('barang_masuk.id_user', $this->session->userdata('id_user'));
        }
        $data['total_rows'] = $this->inputs->count();
        $data['pagination'] = $this->inputs->makePagination(base_url('inputs'), 2, $data['total_rows']);
        $data['page'] = 'pages/inputs/index';

        $this->view($data);
    }

    /**
     * Fungsi search berdasarkan id_barang_masuk / nama staff
     */
    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $this->session->unset_userdata('time');
        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('inputs'));
        }

        $data['title'] = 'Easy WMS - List Barang Masuk';
        $data['breadcrumb_title'] = "List Barang Masuk";
        $data['breadcrumb_path'] = "Barang Masuk / List Penjualan / Cari / $keyword";
        // Warehouse restriction for staff
        $user_gudang = getUserGudangId();

        $this->db->select('GROUP_CONCAT(DISTINCT gudang.nama SEPARATOR ", ") AS nama_gudang', FALSE);

        if ($user_gudang) {
            $this->inputs->where('barang_masuk.id_user', $this->session->userdata('id_user'));
        }

        $data['content'] = $this->inputs->select([
            'barang_masuk.id',
            'user.nama',
            'barang_masuk.waktu'
        ])
            ->join('user')
            ->join('barang_masuk_detail', 'barang_masuk_detail.id_barang_masuk = barang_masuk.id', 'left')
            ->join('gudang', 'barang_masuk_detail.id_gudang = gudang.id', 'left')
            ->like('barang_masuk.id', $keyword)
            ->orLike('user.nama', $keyword)
            ->groupBy('barang_masuk.id')
            ->paginate($page)
            ->get();

        if ($user_gudang) {
            $this->inputs->where('barang_masuk.id_user', $this->session->userdata('id_user'));
        }
        $data['total_rows'] = $this->inputs->join('user')
            ->like('barang_masuk.id', $keyword)
            ->orLike('user.nama', $keyword)
            ->count();
        $data['pagination'] = $this->inputs->makePagination(base_url('inputs/search'), 3, $data['total_rows']);
        $data['page'] = 'pages/inputs/index';

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
            redirect(base_url('inputs'));
        }

        $displayTime = date('d-m-Y', strtotime($time));
        $data['title'] = 'Easy WMS - List Barang Masuk';
        $data['breadcrumb_title'] = "List Barang Masuk";
        $data['breadcrumb_path'] = "Barang Masuk / List Barang Masuk / Filter / $displayTime";
        // Warehouse restriction for staff
        $user_gudang = getUserGudangId();

        $this->db->select('GROUP_CONCAT(DISTINCT gudang.nama SEPARATOR ", ") AS nama_gudang', FALSE);

        if ($user_gudang) {
            $this->inputs->where('barang_masuk.id_user', $this->session->userdata('id_user'));
        }

        $data['content'] = $this->inputs->select([
            'barang_masuk.id',
            'user.nama',
            'barang_masuk.waktu'
        ])
            ->join('user')
            ->join('barang_masuk_detail', 'barang_masuk_detail.id_barang_masuk = barang_masuk.id', 'left')
            ->join('gudang', 'barang_masuk_detail.id_gudang = gudang.id', 'left')
            ->like('DATE(barang_masuk.waktu)', date('Y-m-d', strtotime($time)))
            ->groupBy('barang_masuk.id')
            ->paginate($page)
            ->get();

        if ($user_gudang) {
            $this->inputs->where('barang_masuk.id_user', $this->session->userdata('id_user'));
        }
        $data['total_rows'] = $this->inputs->join('user')
            ->like('DATE(barang_masuk.waktu)', date('Y-m-d', strtotime($time)))
            ->count();
        $data['pagination'] = $this->inputs->makePagination(base_url('inputs/search_time'), 3, $data['total_rows']);
        $data['page'] = 'pages/inputs/index';

        $this->view($data);
    }

    public function detail($id_barang_masuk)
    {
        $data['title'] = APP_NAME . ' - Detail Barang Masuk';
        $data['breadcrumb_title'] = "Detail Barang Masuk";
        $data['breadcrumb_path'] = "Barang Masuk / List Barang Masuk / Detail Barang Masuk / $id_barang_masuk";
        $data['page'] = 'pages/inputs/detail';

        // Admin bisa lihat semua, user biasa hanya bisa lihat miliknya
        $this->inputs->select([
            'user.id AS id_user',
            'user.nama',
            'barang_masuk.id AS id_barang_masuk',
            'barang_masuk.waktu',
            'barang_masuk.bukti_foto'
        ])
            ->join('user')
            ->where('barang_masuk.id', $id_barang_masuk);

        // Jika bukan admin, filter berdasarkan user yang login
        if ($this->session->userdata('role') != 'admin') {
            $this->inputs->where('barang_masuk.id_user', $this->id_user);
        }

        $data['barang_masuk'] = $this->inputs->first();

        // Jika data tidak ditemukan, redirect dengan pesan error
        if (!$data['barang_masuk']) {
            $this->session->set_flashdata('error', 'Data barang masuk tidak ditemukan atau Anda tidak memiliki akses');
            redirect(base_url('inputs'));
            return;
        }

        $this->inputs->table = 'barang_masuk_detail';
        $data['list_barang'] = $this->inputs->select([
            'barang_masuk_detail.qty',
            'barang_masuk_detail.id_gudang',
            'barang.id_satuan',
            'barang.nama',
            'gudang.nama AS nama_gudang',
        ])
            ->join('barang')
            ->join('gudang', 'barang_masuk_detail.id_gudang = gudang.id', 'left')
            ->where('barang_masuk_detail.id_barang_masuk', $id_barang_masuk)
            ->get();

        $this->view($data);
    }

    /**
     * Hapus data pemasukan barang (Admin only)
     */
    public function delete($id)
    {
        // Cek apakah user adalah admin
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus data');
            redirect(base_url('inputs'));
            return;
        }

        // Cek apakah data ada
        $barang_masuk = $this->inputs->where('id', $id)->first();
        if (!$barang_masuk) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(base_url('inputs'));
            return;
        }

        // Hapus detail terlebih dahulu (akan terhapus otomatis karena CASCADE, tapi untuk keamanan)
        $this->db->where('id_barang_masuk', $id)->delete('barang_masuk_detail');

        // Hapus data utama
        if ($this->inputs->where('id', $id)->delete()) {
            $this->session->set_flashdata('success', 'Data pemasukan barang berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data');
        }

        redirect(base_url('inputs'));
    }
}

/* End of file Inputs.php */
