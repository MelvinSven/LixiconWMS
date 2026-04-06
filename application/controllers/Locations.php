<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Locations extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

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

        $data['title'] = APP_NAME . ' - List Letak Barang';
        $data['breadcrumb_title'] = 'List Letak Barang';
        $data['breadcrumb_path'] = 'Manajemen Barang / List Letak Barang';
        $data['content'] = $this->locations->paginate($page)->get();
        $data['total_rows'] = $this->locations->count();
        $data['pagination'] = $this->locations->makePagination(base_url('locations'), 2, $data['total_rows']);
        $data['page'] = 'pages/locations/index';

        $this->view($data);
    }

    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');
        if (empty($keyword)) {
            redirect(base_url('locations'));
        }

        $data['title'] = APP_NAME . ' - Cari Letak Barang';
        $data['breadcrumb_title'] = 'Daftar Letak Barang';
        $data['breadcrumb_path'] = "Daftar Letak Barang / Cari / $keyword";
        $data['content'] = $this->locations->like('nama_lokasi', $keyword)
            ->paginate($page)
            ->get();
        $data['total_rows'] = $this->locations->like('nama_lokasi', $keyword)->count();
        $data['pagination'] = $this->locations->makePagination(base_url('locations/search'), 3, $data['total_rows']);
        $data['page'] = 'pages/locations/index';

        $this->view($data);
    }

    public function create()
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses tambah ditolak!');
            redirect(base_url('locations'));
        }

        $data['input'] = (object) $this->input->post(null, true);

        if (!$this->locations->validate()) {
            $this->session->set_flashdata('error', 'Data tidak valid');
            redirect(base_url('locations'));
        }

        $insert = [
            'nama_lokasi' => $data['input']->nama_lokasi
        ];

        if ($this->locations->create($insert)) {
            $this->session->set_flashdata('success', 'Letak Barang berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('locations'));
    }

    public function edit($id)
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses edit ditolak!');
            redirect(base_url('locations'));
        }

        $data['content'] = $this->locations->getById($id);
        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('locations'));
        }

        if (!$_POST) {
            $data['input'] = $data['content'];
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        if (!$this->locations->validate()) {
            $data['title'] = APP_NAME . ' - Edit Letak Barang';
            $data['page'] = 'pages/locations/edit';
            $data['breadcrumb_title'] = 'Edit Letak Barang';
            $data['breadcrumb_path'] = "Manajemen Barang / Edit Letak Barang / {$data['input']->nama_lokasi}";

            return $this->view($data);
        }

        $update = [
            'nama_lokasi' => $data['input']->nama_lokasi
        ];

        if ($this->locations->updateById($id, $update)) {
            $this->session->set_flashdata('success', 'Letak Barang berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('locations'));
    }

    public function unique_location()
    {
        $name = $this->input->post('nama_lokasi');
        $id = $this->input->post('id_lokasi');
        $loc = $this->locations->where('nama_lokasi', $name)->first();

        if ($loc) {
            if ($id == $loc->id_lokasi)
                return true;
            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_location', '%s sudah digunakan');
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Anda bukan admin.');
            redirect(base_url('locations'));
        }

        $deleted = $this->locations->deleteById($id);

        if ($deleted) {
            $this->session->set_flashdata('success', 'Letak Barang berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus Letak Barang.');
        }

        redirect(base_url('locations'));
    }
}

/* End of file Locations.php */
