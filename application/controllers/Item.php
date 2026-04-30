<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Items extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model', 'barang');

        // Cek login
        $is_login = $this->session->userdata('is_login');
        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }
    }

    // ============================================================
    // 🔹 HALAMAN LIST BARANG
    // ============================================================
    public function index($page = null)
    {
        $this->session->unset_userdata('keyword');

        $data['title']            = 'Lixicon - List Barang';
        $data['breadcrumb_title'] = 'List Barang';
        $data['breadcrumb_path']  = 'Pendataan Barang / List Barang';
        $data['content']          = $this->barang->select([
                'barang.id AS id_barang',
                'barang.nama AS nama_barang',
                'barang.qty',
                'barang.image', // ✅ penting agar gambar tampil
                'satuan.nama AS nama_satuan'
            ])
            ->join('satuan')
            ->paginate($page)
            ->get();

        $data['total_rows'] = $this->barang->count();
        $data['pagination'] = $this->barang->makePagination(base_url('items'), 2, $data['total_rows']);
        $data['page']       = 'pages/items/index';

        $this->view($data);
    }

    // ============================================================
    // 🔹 FILTER BERDASARKAN SATUAN
    // ============================================================
    public function unit($id_unit, $page = null)
    {
        $this->session->unset_userdata('keyword');

        $data['title']            = 'Easy WMS - List Barang';
        $data['breadcrumb_title'] = 'List Barang';
        $data['breadcrumb_path']  = 'Pendataan Barang / Tipe / ' . ucfirst(getUnitName($id_unit));
        $data['content']          = $this->barang->select([
                'barang.id AS id_barang',
                'barang.nama AS nama_barang',
                'barang.qty',
                'barang.image',
                'satuan.nama AS nama_satuan'
            ])
            ->join('satuan')
            ->where('barang.id_satuan', $id_unit)
            ->paginate($page)
            ->get();

        $data['total_rows'] = $this->barang->where('barang.id_satuan', $id_unit)->count();
        $data['pagination'] = $this->barang->makePagination(base_url("items/unit/$id_unit"), 4, $data['total_rows']);
        $data['page']       = 'pages/items/index';

        $this->view($data);
    }

    // ============================================================
    // 🔹 FILTER KETERSEDIAAN (ADA / KOSONG)
    // ============================================================
    public function availability($param, $page = null)
    {
        $this->session->unset_userdata('keyword');

        $data['title']            = APP_NAME . ' - List Barang';
        $data['breadcrumb_title'] = 'List Barang';
        $data['breadcrumb_path']  = 'Pendataan Barang / Ketersediaan / ' . ucfirst($param);
        $data['page']             = 'pages/items/index';

        // 🔧 Kondisi stok harus sebelum get()
        if ($param === 'available') {
            $this->barang->where('barang.qty >', 0);
        } else {
            $this->barang->where('barang.qty', 0);
        }

        $data['content'] = $this->barang->select([
                'barang.id AS id_barang',
                'barang.nama AS nama_barang',
                'barang.qty',
                'barang.image',
                'satuan.nama AS nama_satuan'
            ])
            ->join('satuan')
            ->paginate($page)
            ->get();

        $data['total_rows'] = $this->barang->count();
        $data['pagination'] = $this->barang->makePagination(
            base_url("items/availability/$param"),
            4,
            $data['total_rows']
        );

        $this->view($data);
    }

    // ============================================================
    // 🔹 PENCARIAN BARANG
    // ============================================================
    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');
        if (empty($keyword)) redirect(base_url('items'));

        $data['title']            = APP_NAME . ' - List Barang';
        $data['breadcrumb_title'] = 'List Barang';
        $data['breadcrumb_path']  = "Pendataan Barang / Search / $keyword";
        $data['content']          = $this->barang->select([
                'barang.id AS id_barang',
                'barang.nama AS nama_barang',
                'barang.qty',
                'barang.image',
                'satuan.nama AS nama_satuan'
            ])
            ->join('satuan')
            ->like('barang.nama', $keyword)
            ->paginate($page)
            ->get();

        $data['total_rows'] = $this->barang->like('barang.nama', $keyword)->count();
        $data['pagination'] = $this->barang->makePagination(base_url('items/search'), 3, $data['total_rows']);
        $data['page']       = 'pages/items/index';

        $this->view($data);
    }

    // ============================================================
    // 🔹 REGISTER PAGE (FORM TAMBAH BARANG)
    // ============================================================
    public function register()
    {
        $data['title']            = 'Register Barang';
        $data['breadcrumb_title'] = 'Register Barang';
        $data['breadcrumb_path']  = 'Pendataan Barang / Register Barang';
        $data['page']             = 'pages/items/register';
        $data['content']          = null;
        $data['pagination']       = null;
        $this->view($data);
    }

    // ============================================================
    // 🔹 SIMPAN BARANG BARU
    // ============================================================
    public function store()
    {
        $this->load->library('upload');
        $config = [
            'upload_path'   => './uploads/items/',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 2048,
            'encrypt_name'  => true
        ];
        $this->upload->initialize($config);

        $imagePath = 'uploads/items/default.png';

        if (!empty($_FILES['image']['name'])) {
            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $imagePath = 'uploads/items/' . $uploadData['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect(base_url('items/register'));
                return;
            }
        }

        $data = [
            'nama'        => $this->input->post('nama', true),
            'qty'         => $this->input->post('qty', true),
            'id_satuan'   => $this->input->post('id_satuan', true),
            'image'       => $imagePath
        ];

        $this->barang->insert($data);
        $this->session->set_flashdata('success', 'Barang berhasil ditambahkan');
        redirect(base_url('items'));
    }

    // ============================================================
    // 🔹 UPDATE DATA BARANG
    // ============================================================
    public function update($id)
    {
        $barang = $this->barang->getById($id);
        $image_name = $barang->image;

        if (!empty($_FILES['image']['name'])) {
            $config = [
                'upload_path'   => './uploads/items/',
                'allowed_types' => 'jpg|jpeg|png',
                'max_size'      => 2048,
                'encrypt_name'  => true
            ];

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                if (!empty($barang->image) && file_exists('./' . $barang->image)) {
                    unlink('./' . $barang->image);
                }

                $uploadData = $this->upload->data();
                $image_name = 'uploads/items/' . $uploadData['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('items');
                return;
            }
        }

        $data = [
            'nama'        => $this->input->post('nama', true),
            'id_satuan'   => $this->input->post('id_satuan', true),
            'image'       => $image_name
        ];

        $this->barang->update($id, $data);
        $this->session->set_flashdata('success', 'Data barang berhasil diperbarui.');
        redirect('items');
    }
}

/* End of file Items.php */
