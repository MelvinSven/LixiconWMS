<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $is_login = $this->session->userdata('is_login');
        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }
    }

    public function index($page = null)
    {
        $this->session->unset_userdata('keyword');

        $data['title']            = 'Lixicon - List Kategori';
        $data['breadcrumb_title'] = 'List Kategori';
        $data['breadcrumb_path']  = 'Manajemen Barang / List Kategori';
        $data['content']          = $this->categories->paginate($page)->get();
        $data['total_rows']       = $this->categories->count();
        $data['pagination']       = $this->categories->makePagination(base_url('categories'), 2, $data['total_rows']);
        $data['page']             = 'pages/categories/index';

        $this->view($data);
    }

    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');
        if (empty($keyword)) {
            redirect(base_url('categories'));
        }

        $data['title']            = APP_NAME . ' - Cari Kategori';
        $data['breadcrumb_title'] = 'Daftar Kategori';
        $data['breadcrumb_path']  = "Daftar Kategori / Cari / $keyword";
        $data['content']          = $this->categories->like('CategoryName', $keyword)
                                                     ->paginate($page)
                                                     ->get();
        $data['total_rows']       = $this->categories->like('CategoryName', $keyword)->count();
        $data['pagination']       = $this->categories->makePagination(base_url('categories/search'), 3, $data['total_rows']);
        $data['page']             = 'pages/categories/index';

        $this->view($data);
    }

    public function create()
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses tambah ditolak!');
            redirect(base_url('categories'));
        }

        $data['input'] = (object) $this->input->post(null, true);

        if (!$this->categories->validate()) {
            $this->session->set_flashdata('error', 'Data tidak valid');
            redirect(base_url('categories'));
        }

        $insert = [
            'CategoryName' => $data['input']->CategoryName
        ];

        if ($this->categories->create($insert)) {
            $this->session->set_flashdata('success', 'Kategori berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('categories'));
    }

    public function edit($id)
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses edit ditolak!');
            redirect(base_url('categories'));
        }

        $data['content'] = $this->categories->getById($id);
        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('categories'));
        }

        if (!$_POST) {
            $data['input'] = $data['content'];
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        if (!$this->categories->validate()) {
            $data['title']            = APP_NAME . ' - Edit Kategori';
            $data['page']             = 'pages/categories/edit';
            $data['breadcrumb_title'] = 'Edit Kategori';
            $data['breadcrumb_path']  = "Manajemen Barang / Edit Kategori / {$data['input']->CategoryName}";

            return $this->view($data);
        }

        $update = [
            'CategoryName' => $data['input']->CategoryName
        ];

        if ($this->categories->updateById($id, $update)) {
            $this->session->set_flashdata('success', 'Kategori berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('categories'));
    }

    public function unique_category()
    {
        $name = $this->input->post('CategoryName');
        $id   = $this->input->post('id_category');
        $cat  = $this->categories->where('CategoryName', $name)->first();

        if ($cat) {
            if ($id == $cat->id_category) return true;
            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_category', '%s sudah digunakan');
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Anda bukan admin.');
            redirect(base_url('categories'));
        }

        $deleted = $this->categories->deleteById($id);

        if ($deleted) {
            $this->session->set_flashdata('success', 'Kategori berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus kategori.');
        }

        redirect(base_url('categories'));
    }
}

/* End of file Categories.php */
