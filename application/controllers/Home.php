<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Dashboard
 */
class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Preorder_model', 'preorderModel');
        $this->load->model('Transfer_model', 'transferModel');

        $is_login = $this->session->userdata('is_login');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }
    }

    public function index()
    {
        $nama = $this->session->userdata('nama');

        // Check for date filter
        $filter_date = $this->session->userdata('dashboard_date');

        // Pre-calculate all statistics to avoid multiple function calls
        $jumlah_staff = $this->db->count_all('user');
        $jumlah_barang = $this->db->where('qty !=', 0)->count_all_results('barang');

        // Filter valid warehouse count
        $user_gudang = getUserGudangId();
        if ($user_gudang) {
            $this->db->where('id', $user_gudang);
        }
        $jumlah_gudang = $this->db->count_all_results('gudang');

        // Total stok
        $this->db->select_sum('qty');
        $jumlah_stok = $this->db->get('barang')->row()->qty ?? 0;

        // Jumlah barang masuk (filtered by date if set)
        if (!empty($filter_date)) {
            $date_formatted = date('Y-m-d', strtotime($filter_date));
            $this->db->like('DATE(waktu)', $date_formatted, 'none');
        }
        if ($user_gudang) {
            $this->db->where('id_user', $this->session->userdata('id_user'));
        }
        $jumlah_barang_masuk = $this->db->count_all_results('barang_masuk');

        // Jumlah barang keluar (filtered by date if set)
        if (!empty($filter_date)) {
            $this->db->like('DATE(waktu)', $date_formatted, 'none');
        }
        if ($user_gudang) {
            $this->db->where('id_user', $this->session->userdata('id_user'));
        }
        $jumlah_barang_keluar = $this->db->count_all_results('barang_keluar');

        // Total barang (semua jenis barang)
        $total_barang = $this->db->count_all('barang');

        $data['title'] = 'Lixicon - Dashboard';
        $data['breadcrumb_title'] = "Hallo $nama 😊";
        $data['breadcrumb_path'] = 'Home / Dashboard';
        $data['filter_date'] = $filter_date;

        // Statistics data
        $data['jumlah_staff'] = $jumlah_staff;
        $data['jumlah_barang'] = $jumlah_barang;
        $data['jumlah_gudang'] = $jumlah_gudang;
        $data['jumlah_stok'] = $jumlah_stok;
        $data['jumlah_barang_masuk'] = $jumlah_barang_masuk;
        $data['jumlah_barang_keluar'] = $jumlah_barang_keluar;
        $data['total_barang'] = $total_barang;

        // Recent activities - barang masuk
        $this->db->select([
            'barang_masuk.id',
            'user.nama',
            'barang_masuk.waktu'
        ]);
        $this->db->from('barang_masuk');
        $this->db->join('user', 'barang_masuk.id_user = user.id', 'left');
        if (!empty($filter_date)) {
            $this->db->like('DATE(barang_masuk.waktu)', $date_formatted, 'none');
        }
        if ($user_gudang) {
            $this->db->where('barang_masuk.id_user', $this->session->userdata('id_user'));
        }
        $this->db->order_by('barang_masuk.waktu', 'DESC');
        $this->db->limit(5);
        $data['barang_masuk'] = $this->db->get()->result();

        // Recent activities - barang keluar
        $this->db->select([
            'barang_keluar.id',
            'user.nama',
            'barang_keluar.waktu'
        ]);
        $this->db->from('barang_keluar');
        $this->db->join('user', 'barang_keluar.id_user = user.id', 'left');
        if (!empty($filter_date)) {
            $this->db->like('DATE(barang_keluar.waktu)', $date_formatted, 'none');
        }
        if ($user_gudang) {
            $this->db->where('barang_keluar.id_user', $this->session->userdata('id_user'));
        }
        $this->db->order_by('barang_keluar.waktu', 'DESC');
        $this->db->limit(5);
        $data['barang_keluar'] = $this->db->get()->result();

        // Preorder dashboard tables — client-side JS handles pagination (5 rows/page)
        $data['dashboard_permintaan_aktif'] = $this->preorderModel->getDashboardPermintaan('active', 50, $filter_date);
        $data['dashboard_riwayat_permintaan'] = $this->preorderModel->getDashboardPermintaan('history', 50, $filter_date);

        // Transfer history for dashboard — fetch up to 50 records, JS paginates at 5/page
        if (!empty($filter_date)) {
            $data['dashboard_transfers'] = $this->transferModel->getTransfersByDate($filter_date);
        } else {
            $data['dashboard_transfers'] = $this->transferModel->getAllTransfers();
        }

        $data['page'] = 'pages/home/index';

        $this->view($data);
    }

    /**
     * Filter dashboard by date
     */
    public function filter_date()
    {
        $date = $this->input->post('dashboard_date');
        if (!empty($date)) {
            $this->session->set_userdata('dashboard_date', $date);
        } else {
            $this->session->unset_userdata('dashboard_date');
        }
        redirect(base_url('home'));
    }

    /**
     * Reset dashboard date filter
     */
    public function reset_filter()
    {
        $this->session->unset_userdata('dashboard_date');
        redirect(base_url('home'));
    }
}

/* End of file Home.php */
