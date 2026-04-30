<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Kontroller list user
 */
class Users extends MY_Controller
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

        $data['title'] = 'Lixicon - Daftar Staff';
        $data['breadcrumb_title'] = 'Daftar Staff';
        $data['breadcrumb_path'] = 'Manajemen Staff / Daftar Staff';
        $data['total_rows'] = $this->users->count();

        $this->db->select('user.*, gudang.nama AS nama_gudang');
        $this->db->from('user');
        $this->db->join('gudang', 'user.id_gudang = gudang.id', 'left');
        $this->db->limit($this->users->getPerPage(), $this->users->calculateRealOffset($page));
        $data['content'] = $this->db->get()->result();

        $data['pagination'] = $this->users->makePagination(base_url('users'), 2, $data['total_rows']);
        $data['page'] = 'pages/users/index';

        $this->view($data);
    }

    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('users'));
        }

        $data['title'] = APP_NAME . ' - Cari Staff';
        $data['breadcrumb_title'] = "Daftar Staff";
        $data['breadcrumb_path'] = "Daftar Staff / Cari / $keyword";

        $this->db->select('user.*, gudang.nama AS nama_gudang');
        $this->db->from('user');
        $this->db->join('gudang', 'user.id_gudang = gudang.id', 'left');
        $this->db->group_start();
        $this->db->like('user.nama', $keyword);
        $this->db->or_like('user.ktp', $keyword);
        $this->db->or_like('user.email', $keyword);
        $this->db->group_end();
        $this->db->limit($this->users->getPerPage(), $this->users->calculateRealOffset($page));
        $data['content'] = $this->db->get()->result();

        $data['total_rows'] = $this->users->like('nama', $keyword)
            ->orLike('ktp', $keyword)
            ->orLike('email', $keyword)
            ->count();
        $data['pagination'] = $this->users->makePagination(base_url('users/search'), 3, $data['total_rows']);
        $data['page'] = 'pages/users/index';

        $this->view($data);
    }

    /**
     * Edit data user oleh admin
     */
    public function edit($id)
    {
        if ($this->session->userdata('id_user') != $id && $this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses edit ditolak!');
            redirect(base_url('home'));
            return;
        }

        $data['content'] = $this->users->where('id', $id)->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('users'));
        }

        if (!$_POST) {
            $data['input'] = $data['content'];
        } else {
            $data['input'] = (object) $this->input->post(null, true);

            if ($data['input']->password !== '') {
                $data['input']->password = hashEncrypt($data['input']->password);
            } else {
                $data['input']->password = $data['content']->password;
            }

            if ($data['input']->id_gudang === '') {
                $data['input']->id_gudang = null;
            }
        }

        if (!$this->users->validate()) {
            $data['title'] = APP_NAME . ' - Edit Staff';
            $data['page'] = 'pages/users/edit';
            $data['breadcrumb_title'] = 'Edit Data Staff';
            $data['breadcrumb_path'] = "Manajemen Staff / Edit Data Staff / " . $data['input']->nama;

            return $this->view($data);
        }

        if ($this->users->update($id, $data['input'])) {   // Update data
            $this->session->set_flashdata('success', 'Data berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi suatu kesalahan');
        }

        redirect(base_url('users'));
    }

    public function unique_email()
    {
        $email = $this->input->post('email');
        $id = $this->input->post('id');
        $user = $this->users->where('email', $email)->first(); // Akan terisi jika terdapat email yang sama

        if ($user) {
            if ($id == $user->id) {  // Keperluan edit tidak perlu ganti email, jadi tidak masalah
                return true;
            }

            // Jika terdapat suatu nilai pada $user, berikan pesan error pertanda email sudah ada di db
            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_email', '%s sudah digunakan');
            return false;
        }

        return true;
    }

    public function unique_ktp()
    {
        $ktp = $this->input->post('ktp');
        $id = $this->input->post('id');
        $user = $this->users->where('ktp', $ktp)->first();

        if ($user) {
            if ($id == $user->id) {  // Keperluan edit tidak perlu ganti ktp, jadi tidak masalah
                return true;
            }

            // Jika terdapat suatu nilai pada $user, berikan pesan error pertanda ktp sudah ada di db
            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_ktp', '%s sudah digunakan');
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak!');
            redirect(base_url('home'));
            return;
        }

        if ($this->session->userdata('id_user') == $id) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun sendiri!');
            redirect(base_url('users'));
            return;
        }

        $user = $this->users->where('id', $id)->first();

        if (!$user) {
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('users'));
            return;
        }

        if ($this->users->delete($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user');
        }

        redirect(base_url('users'));
    }
}

/* End of file Users.php */
