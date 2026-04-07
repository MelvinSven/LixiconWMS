<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk Manajemen Gudang (List)
 */
class Warehouses extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Warehouses_model', 'warehouses');

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

        $data['title'] = 'Lixicon - List Gudang';
        $data['breadcrumb_title'] = "List Gudang";
        $data['breadcrumb_path'] = 'Manajemen Gudang / List Gudang';
        $data['page'] = 'pages/warehouses/index';

        $data['content'] = $this->warehouses->paginate($page)->get();
        $data['total_rows'] = $this->warehouses->count();
        $data['pagination'] = $this->warehouses->makePagination(base_url('warehouses'), 2, $data['total_rows']);
        $data['start'] = $this->warehouses->calculateRealOffset($page);

        $this->view($data);
    }

    /**
     * Pencarian gudang
     */
    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('warehouses'));
        }

        $data['title'] = 'Lixicon - Pencarian Gudang';
        $data['breadcrumb_title'] = "Pencarian Gudang";
        $data['breadcrumb_path'] = 'Manajemen Gudang / Pencarian / ' . $keyword;
        $data['page'] = 'pages/warehouses/index';

        // Filter by user's warehouse if restricted
        $user_gudang = getUserGudangId();
        if ($user_gudang) {
            $this->warehouses->where('id', $user_gudang);
        }

        $data['content'] = $this->warehouses->paginate($page)
            ->like('nama', $keyword)
            ->orLike('alamat', $keyword)
            ->get();

        if ($user_gudang) {
            $this->warehouses->where('id', $user_gudang);
        }
        $data['total_rows'] = $this->warehouses->like('nama', $keyword)
            ->orLike('alamat', $keyword)
            ->count();

        $data['pagination'] = $this->warehouses->makePagination(base_url('warehouses/search'), 3, $data['total_rows']);
        $data['start'] = $this->warehouses->calculateRealOffset($page);

        $this->view($data);
    }
}

/* End of file Warehouses.php */
