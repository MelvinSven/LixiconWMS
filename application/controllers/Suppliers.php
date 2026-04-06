<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller List Supplier
 */
class Suppliers extends MY_Controller
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

        $data['title']              = APP_NAME . ' - List Supplier';
        $data['breadcrumb_title']   = 'List Supplier';
        $data['breadcrumb_path']    = 'Manajemen Supplier / List Supplier';
        $data['content']            = $this->suppliers->orderBy('id_supplier', 'desc')->paginate($page)->get();
        $data['total_rows']         = $this->suppliers->count();
        $data['pagination']         = $this->suppliers->makePagination(base_url('suppliers'), 2, $data['total_rows']);
        $data['page']               = 'pages/suppliers/index';

        $this->view($data);
    }

    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('suppliers'));
        }

        $data['title']              = APP_NAME . ' - Cari Supplier';
        $data['breadcrumb_title']   = "List Supplier";
        $data['breadcrumb_path']    = "List Supplier / Cari / $keyword";
        $data['content']            = $this->suppliers->like('nama', $keyword)
                                        ->orderBy('id_supplier', 'desc')
                                        ->paginate($page)
                                        ->get();
        $data['total_rows']         = $this->suppliers->like('nama', $keyword)->count();
        $data['pagination']         = $this->suppliers->makePagination(base_url('suppliers/search'), 3, $data['total_rows']);
        $data['page']               = 'pages/suppliers/index';

        $this->view($data);
    }

    /**
     * Edit data supplier
     */
    public function edit($id)
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses edit ditolak!');
            redirect(base_url('suppliers'));
            return;
        }

        $data['content'] = $this->suppliers->where('id_supplier', $id)->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('suppliers'));
            return;
        }

        if (!$_POST) {
            $data['input'] = $data['content'];
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        if (!$this->suppliers->validate()) {
            $data['title']              = APP_NAME . ' - Edit Supplier';
            $data['page']               = 'pages/suppliers/edit';
            $data['breadcrumb_title']   = 'Edit Data Supplier';
            $data['breadcrumb_path']    = "Manajemen Supplier / Edit Data Supplier / " . $data['input']->nama;

            return $this->view($data);
        }

        // Update data
        $updateData = ['nama' => $this->input->post('nama', true)];
        $this->db->where('id_supplier', $id)->update('supplier', $updateData);
        
        $this->session->set_flashdata('success', 'Data berhasil diubah');
        redirect(base_url('suppliers'));
    }

    public function unique_supplier()
    {
        $nama = $this->input->post('nama');
        $id = $this->input->post('id_supplier');
        $supplier = $this->suppliers->where('nama', $nama)->first();

        if ($supplier) {
            if (!empty($id) && (int) $id === (int) $supplier->id_supplier) {
                return true;
            }

            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_supplier', '%s sudah digunakan.');
            return false;
        }

        return true;
    }

    /**
     * Halaman tambah supplier baru
     */
    public function add()
    {
        // Cek apakah user adalah admin
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menambah supplier');
            redirect(base_url('suppliers'));
            return;
        }

        if (!$_POST) {
            $data['input'] = (object) $this->suppliers->getDefaultValues();
        } else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        $data['title']              = APP_NAME . ' - Tambah Supplier';
        $data['breadcrumb_title']   = 'Tambah Supplier';
        $data['breadcrumb_path']    = 'Manajemen Supplier / Tambah Supplier';
        $data['page']               = 'pages/suppliers/add';

        $this->view($data);
    }

    /**
     * Simpan data supplier baru
     */
    public function store()
    {
        // Cek apakah user adalah admin
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menambah supplier');
            redirect(base_url('suppliers'));
            return;
        }

        if (!$this->suppliers->validate()) {
            $this->session->set_flashdata('error', 'Validasi gagal. Silakan periksa kembali input Anda.');
            redirect(base_url('suppliers/add'));
            return;
        }

        $nama = $this->input->post('nama', true);

        $existingSupplier = $this->suppliers->where('nama', $nama)->first();
        if ($existingSupplier) {
            $this->session->set_flashdata('error', 'Nama supplier sudah terdaftar.');
            redirect(base_url('suppliers/add'));
            return;
        }

        $data = [
            'nama' => $nama
        ];

        if ($this->suppliers->create($data)) {
            $this->session->set_flashdata('success', 'Supplier berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan supplier');
        }

        redirect(base_url('suppliers'));
    }

    /**
     * Hapus data supplier (Admin only)
     */
    public function delete($id)
    {
        // Cek apakah user adalah admin
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus supplier');
            redirect(base_url('suppliers'));
            return;
        }

        // Cek apakah data ada
        $supplier = $this->suppliers->where('id_supplier', $id)->first();
        if (!$supplier) {
            $this->session->set_flashdata('error', 'Data supplier tidak ditemukan');
            redirect(base_url('suppliers'));
            return;
        }

        // Cek apakah supplier masih digunakan oleh barang
        $barang_count = $this->db->where('id_supplier', $id)->count_all_results('barang');
        if ($barang_count > 0) {
            $this->session->set_flashdata('error', 'Supplier tidak dapat dihapus karena masih digunakan oleh ' . $barang_count . ' barang');
            redirect(base_url('suppliers'));
            return;
        }

        // Hapus data supplier
        if ($this->db->where('id_supplier', $id)->delete('supplier')) {
            $this->session->set_flashdata('success', 'Supplier berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus supplier');
        }

        redirect(base_url('suppliers'));
    }
}
    
/* End of file Suppliers.php */
