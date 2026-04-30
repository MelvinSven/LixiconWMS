<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Kontroller list user
 */
class Units extends MY_Controller 
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
        
        $data['title']              = 'Lixicon - List Satuan';
        $data['breadcrumb_title']   = 'List Satuan';
        $data['breadcrumb_path']    = 'Manajemen Barang / List Satuan';
        $data['content']            = $this->units->paginate($page)->get();
        $data['total_rows']         = $this->units->count();
        $data['pagination']         = $this->units->makePagination(base_url('units'), 2, $data['total_rows']);
        $data['page']               = 'pages/units/index';
        
        $this->view($data);
    }

    /**
     * Mencari berdasarkan nama satuan
     */
    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('units'));
        }

        $keyword = $this->session->userdata('keyword');

        $data['title']              = APP_NAME . ' - Cari Satuan';
        $data['breadcrumb_title']   = "Daftar Staff";
        $data['breadcrumb_path']    = "Daftar Staff / Cari / $keyword";
        $data['content']            = $this->units->like('nama', $keyword)
                                        ->paginate($page)
                                        ->get();
        $data['total_rows']         = $this->units->like('nama', $keyword)
                                        ->count();
        $data['pagination']         = $this->units->makePagination(base_url('units/search'), 3, $data['total_rows']);
        $data['page']               = 'pages/units/index';

        $this->view($data);
    }

    /**
     * Edit data satuan oleh admin
     */
    public function edit($id)
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses edit ditolak!');
            redirect(base_url('home'));
        }

        $data['content'] = $this->units->where('id', $id)->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('units'));
        }

        if (!$_POST) {
            $data['input'] = $data['content'];
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        if (!$this->units->validate()) {
            $data['title']              = APP_NAME . ' - Edit Satuan Barang';
            $data['page']               = 'pages/units/edit';
            $data['breadcrumb_title']   = 'Edit Satuan Barang';
            $data['breadcrumb_path']    = "Manajemen Barang / Edit Satuan Barang / " . $data['input']->nama;

            return $this->view($data);
        }

        $updateData = [
            'nama' => $data['input']->nama
        ];

        if ($this->units->update($id, $updateData)) {   // Update data
            $this->session->set_flashdata('success', 'Data satuan berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi suatu kesalahan');
        }

        redirect(base_url('units'));
    }

    public function unique_satuan()
    {
        $nama = $this->input->post('nama');
        $id   = $this->input->post('id');
        $unit = $this->units->where('nama', $nama)->first();

        if ($unit) {
            if ($id == $unit->id) return true;
            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_satuan', '%s sudah digunakan');
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        // Periksa apakah pengguna adalah admin
        if ($this->session->userdata('role') != 'admin') {
            // Jika bukan admin, redirect ke halaman units atau halaman yang sesuai
            $this->session->set_flashdata('error', 'Akses ditolak! Anda bukan admin.');
            redirect(base_url('units'));
        }

        // Memuat model yang diperlukan untuk menghapus data
        $this->load->model('Unit_model');
        
        // Menghapus data unit berdasarkan ID
        $deleted = $this->units->where('id', $id)->delete();

        if ($deleted) {
            // Jika berhasil dihapus, beri flash message sukses dan redirect ke halaman units
            $this->session->set_flashdata('success', 'Stock berhasil dihapus.');
        } else {
            // Jika gagal, beri flash message error dan redirect ke halaman units
            $this->session->set_flashdata('error', 'Gagal menghapus stock.');
        }

        redirect(base_url('units'));
    }

}

/* End of file Units.php */
