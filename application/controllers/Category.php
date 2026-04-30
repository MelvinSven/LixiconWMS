<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Kontroller Tambah Kategori
 */
class Category extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $is_login = $this->session->userdata('is_login');
        if (!$is_login) {
            redirect(base_url('login'));
        }
    }

    public function index()
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('warning', 'Anda tidak memiliki akses');
            redirect(base_url('home'));
            return;
        }

        if (!$_POST) {
            $input = (object) $this->category->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->category->validate()) {
            $data['title']            = 'Lixicon - Tambah Kategori';
            $data['input']            = $input;
            $data['page']             = 'pages/category/index';
            $data['breadcrumb_title'] = 'Tambah Kategori';
            $data['breadcrumb_path']  = 'Manajemen Barang / Tambah Kategori';

            return $this->view($data);
        }

        if ($this->category->run($input)) {
            $this->session->set_flashdata('success', 'Kategori berhasil ditambahkan');
            redirect(base_url('category'));
        } else {
            $this->session->set_flashdata('error', 'Oops terjadi suatu kesalahan');
            redirect(base_url('category'));
        }
    }

    public function reset()
    {
        redirect(base_url('category'));
    }
}

/* End of file Category.php */
