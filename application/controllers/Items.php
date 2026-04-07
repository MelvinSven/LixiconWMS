<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller List Barang
 */
class Items extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // ✅ Tambahkan baris ini
        $this->load->model('Barang_model', 'barang');
        $this->load->model('Items_model', 'items'); // jika kamu pakai model items juga

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
        $this->session->unset_userdata('search_params');

        $data['title'] = APP_NAME . ' - List Barang';
        $data['breadcrumb_title'] = "List Barang";
        $data['breadcrumb_path'] = 'Pendataan Barang / List Barang';
        $data['search_params'] = [];

        // Query dengan raw DB untuk handle LEFT JOIN supplier dengan benar
        $this->db->select([
            'barang.id AS id_barang',
            'barang.kode_barang',
            'barang.nama AS nama_barang',
            'barang.deskripsi',
            'barang.qty',
            'barang.image',
            'barang.id_supplier',
            'barang.id_lokasi',
            'satuan.nama AS nama_satuan',
            'supplier.nama AS nama_supplier',
            'lokasi_barang.nama_lokasi'
        ]);
        $this->db->from('barang');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->join('supplier', 'barang.id_supplier = supplier.id_supplier', 'left');
        $this->db->join('lokasi_barang', 'barang.id_lokasi = lokasi_barang.id_lokasi', 'left');
        $this->db->limit($this->barang->getPerPage(), $this->barang->calculateRealOffset($page));
        $data['content'] = $this->db->get()->result();

        $data['total_rows'] = $this->items->count();
        $data['pagination'] = $this->items->makePagination(base_url('items'), 2, $data['total_rows']);
        $data['start'] = $this->barang->calculateRealOffset($page);
        $data['page'] = 'pages/items/index';

        // print_r(getUnitName(1)); exit;

        $this->view($data);
    }

    /**
     * Klasifikasi berdasarkan satuan barang
     * Param 1: id satuan barang
     * Param 2: nilai pagination
     */
    public function unit($id_unit, $page = null)
    {
        $this->session->unset_userdata('keyword');
        $this->session->unset_userdata('search_params');

        $data['title'] = 'Easy WMS - List Barang';
        $data['breadcrumb_title'] = "List Barang";
        $data['breadcrumb_path'] = 'Pendataan Barang / Tipe / ' . ucfirst(getUnitName($id_unit));
        $data['search_params'] = [];

        // Query dengan raw DB untuk handle LEFT JOIN supplier dengan benar
        $this->db->select([
            'barang.id AS id_barang',
            'barang.kode_barang',
            'barang.nama AS nama_barang',
            'barang.deskripsi',
            'barang.qty',
            'barang.image',
            'barang.id_supplier',
            'barang.id_lokasi',
            'satuan.nama AS nama_satuan',
            'supplier.nama AS nama_supplier',
            'lokasi_barang.nama_lokasi'
        ]);
        $this->db->from('barang');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->join('supplier', 'barang.id_supplier = supplier.id_supplier', 'left');
        $this->db->join('lokasi_barang', 'barang.id_lokasi = lokasi_barang.id_lokasi', 'left');
        $this->db->where('barang.id_satuan', $id_unit);
        $this->db->limit($this->barang->getPerPage(), $this->barang->calculateRealOffset($page));
        $data['content'] = $this->db->get()->result();

        $data['total_rows'] = $this->items->where('id_satuan', $id_unit)->count();
        $data['pagination'] = $this->items->makePagination(
            base_url("items/unit/$id_unit"),
            4,
            $data['total_rows']
        );
        $data['start'] = $this->barang->calculateRealOffset($page);
        $data['page'] = 'pages/items/index';

        $this->view($data);
    }

    /**
     * Menampilkan barang berdasarkan ketersediannya ada/kosong
     * Param 1: string 'available' / 'empty'
     * Param 2: nilai pagination
     */
    public function availability($param, $page = null)
    {
        $this->session->unset_userdata('keyword');
        $this->session->unset_userdata('search_params');

        $data['title'] = 'Easy WMS - List Barang';
        $data['breadcrumb_title'] = "List Barang";
        $data['breadcrumb_path'] = 'Pendataan Barang / Ketersediaan / ' . ucfirst($param);
        $data['page'] = 'pages/items/index';
        $data['search_params'] = [];

        if ($param === 'available') {
            $data['total_rows'] = $this->items->where('qty >', 0)->count();

            $this->db->select([
                'barang.id AS id_barang',
                'barang.kode_barang',
                'barang.nama AS nama_barang',
                'barang.deskripsi',
                'barang.qty',
                'barang.image',
                'barang.id_supplier',
                'barang.id_lokasi',
                'satuan.nama AS nama_satuan',
                'supplier.nama AS nama_supplier',
                'lokasi_barang.nama_lokasi'
            ]);
            $this->db->from('barang');
            $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
            $this->db->join('supplier', 'barang.id_supplier = supplier.id_supplier', 'left');
            $this->db->join('lokasi_barang', 'barang.id_lokasi = lokasi_barang.id_lokasi', 'left');
            $this->db->where('barang.qty >', 0);
            $this->db->limit($this->barang->getPerPage(), $this->barang->calculateRealOffset($page));
            $data['content'] = $this->db->get()->result();

        } else {
            $data['total_rows'] = $this->items->where('qty', 0)->count();

            $this->db->select([
                'barang.id AS id_barang',
                'barang.kode_barang',
                'barang.nama AS nama_barang',
                'barang.deskripsi',
                'barang.qty',
                'barang.image',
                'barang.id_supplier',
                'barang.id_lokasi',
                'satuan.nama AS nama_satuan',
                'supplier.nama AS nama_supplier',
                'lokasi_barang.nama_lokasi'
            ]);
            $this->db->from('barang');
            $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
            $this->db->join('supplier', 'barang.id_supplier = supplier.id_supplier', 'left');
            $this->db->join('lokasi_barang', 'barang.id_lokasi = lokasi_barang.id_lokasi', 'left');
            $this->db->where('barang.qty', 0);
            $this->db->limit($this->barang->getPerPage(), $this->barang->calculateRealOffset($page));
            $data['content'] = $this->db->get()->result();
        }

        $data['pagination'] = $this->items->makePagination(
            base_url("items/availability/$param"),
            4,
            $data['total_rows']
        );
        $data['start'] = $this->barang->calculateRealOffset($page);

        $this->view($data);
    }

    /**
     * Menampilkan barang berdasarkan gudang
     * Param 1: id gudang
     * Param 2: nilai pagination
     */
    public function warehouse($id_gudang, $page = null)
    {
        $this->session->unset_userdata('keyword');

        // Load model yang diperlukan
        $this->load->model('Stokgudang_model', 'stokgudang');

        // Ambil data gudang
        $gudang = $this->db->where('id', $id_gudang)->get('gudang')->row();

        if (!$gudang) {
            $this->session->set_flashdata('error', 'Gudang tidak ditemukan');
            redirect(base_url('items'));
            return;
        }

        $data['title'] = APP_NAME . ' - Stok Gudang ' . $gudang->nama;
        $data['breadcrumb_title'] = "Stok per Gudang";
        $data['breadcrumb_path'] = 'Pendataan Barang / Gudang / ' . $gudang->nama;
        $data['selected_gudang'] = $gudang;

        $user_gudang = getUserGudangId();
        $data['is_own_warehouse'] = ($user_gudang === null || $user_gudang == $id_gudang);

        // Ambil stok barang di gudang ini
        $data['content'] = $this->db->select([
            'barang.id AS id_barang',
            'barang.nama AS nama_barang',
            'stok_gudang.qty',
            'barang.image',
            'satuan.nama AS nama_satuan',
            'stok_gudang.stok_minimum'
        ])
            ->from('stok_gudang')
            ->join('barang', 'stok_gudang.id_barang = barang.id', 'left')
            ->join('satuan', 'barang.id_satuan = satuan.id', 'left')
            ->where('stok_gudang.id_gudang', $id_gudang)
            ->limit($this->items->getPerPage(), $this->items->calculateRealOffset($page))
            ->get()
            ->result();

        $data['total_rows'] = $this->db->where('id_gudang', $id_gudang)->count_all_results('stok_gudang');
        $data['pagination'] = $this->items->makePagination(
            base_url("items/warehouse/$id_gudang"),
            4,
            $data['total_rows']
        );
        $data['page'] = 'pages/items/warehouse';

        $this->view($data);
    }

    /**
     * Pencarian barang berdasarkan berbagai kriteria
     * 
     * Param berupa keyword yang diambil dari POST 
     * setelah keyword diambil dari POST, keyword tersebut diset ke dalam session
     */
    public function search($page = null)
    {
        // Simpan parameter pencarian ke session jika ada POST
        if ($_POST) {
            $search_params = [
                'kode_barang' => $this->input->post('kode_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'supplier' => $this->input->post('supplier'),
                'deskripsi' => $this->input->post('deskripsi'),
                'lokasi' => $this->input->post('lokasi'),
                'satuan' => $this->input->post('satuan'),
                'qty_operator' => $this->input->post('qty_operator'),
                'qty_value' => $this->input->post('qty_value'),
                'status' => $this->input->post('status')
            ];
            $this->session->set_userdata('search_params', $search_params);
        }

        $search_params = $this->session->userdata('search_params');

        // Cek apakah ada parameter pencarian
        $has_search = false;
        if ($search_params) {
            foreach ($search_params as $val) {
                if (!empty($val)) {
                    $has_search = true;
                    break;
                }
            }
        }

        if (!$has_search) {
            redirect(base_url('items'));
        }

        $data['title'] = APP_NAME . ' - List Barang';
        $data['breadcrumb_title'] = "List Barang";
        $data['breadcrumb_path'] = "Pendataan Barang / Hasil Pencarian";
        $data['search_params'] = $search_params;

        // Build base query untuk count
        $this->db->from('barang');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->join('supplier', 'barang.id_supplier = supplier.id_supplier', 'left');
        $this->db->join('lokasi_barang', 'barang.id_lokasi = lokasi_barang.id_lokasi', 'left');

        // Apply filters untuk count
        if (!empty($search_params['kode_barang'])) {
            $this->db->like('barang.kode_barang', $search_params['kode_barang']);
        }
        if (!empty($search_params['nama_barang'])) {
            $this->db->like('barang.nama', $search_params['nama_barang']);
        }
        if (!empty($search_params['supplier'])) {
            $this->db->where('barang.id_supplier', $search_params['supplier']);
        }
        if (!empty($search_params['deskripsi'])) {
            $this->db->like('barang.deskripsi', $search_params['deskripsi']);
        }
        if (!empty($search_params['lokasi'])) {
            $this->db->where('barang.id_lokasi', $search_params['lokasi']);
        }
        if (!empty($search_params['satuan'])) {
            $this->db->where('barang.id_satuan', $search_params['satuan']);
        }
        $allowed_qty_ops = ['>', '<', '>=', '<=', '=', '!='];
        if (!empty($search_params['qty_operator']) && $search_params['qty_value'] !== '' && in_array($search_params['qty_operator'], $allowed_qty_ops)) {
            $this->db->where('barang.qty ' . $search_params['qty_operator'], (int) $search_params['qty_value']);
        }
        if (!empty($search_params['status'])) {
            if ($search_params['status'] == 'tersedia') {
                $this->db->where('barang.qty >', 0);
            } else {
                $this->db->where('barang.qty', 0);
            }
        }

        $data['total_rows'] = $this->db->count_all_results();

        // Build query untuk data
        $this->db->select([
            'barang.id AS id_barang',
            'barang.kode_barang',
            'barang.nama AS nama_barang',
            'barang.deskripsi',
            'barang.qty',
            'barang.image',
            'barang.id_supplier',
            'barang.id_lokasi',
            'satuan.nama AS nama_satuan',
            'supplier.nama AS nama_supplier',
            'lokasi_barang.nama_lokasi'
        ]);
        $this->db->from('barang');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->join('supplier', 'barang.id_supplier = supplier.id_supplier', 'left');
        $this->db->join('lokasi_barang', 'barang.id_lokasi = lokasi_barang.id_lokasi', 'left');

        // Apply filters lagi untuk data
        if (!empty($search_params['kode_barang'])) {
            $this->db->like('barang.kode_barang', $search_params['kode_barang']);
        }
        if (!empty($search_params['nama_barang'])) {
            $this->db->like('barang.nama', $search_params['nama_barang']);
        }
        if (!empty($search_params['supplier'])) {
            $this->db->where('barang.id_supplier', $search_params['supplier']);
        }
        if (!empty($search_params['deskripsi'])) {
            $this->db->like('barang.deskripsi', $search_params['deskripsi']);
        }
        if (!empty($search_params['lokasi'])) {
            $this->db->where('barang.id_lokasi', $search_params['lokasi']);
        }
        if (!empty($search_params['satuan'])) {
            $this->db->where('barang.id_satuan', $search_params['satuan']);
        }
        if (!empty($search_params['qty_operator']) && $search_params['qty_value'] !== '' && in_array($search_params['qty_operator'], $allowed_qty_ops)) {
            $this->db->where('barang.qty ' . $search_params['qty_operator'], (int) $search_params['qty_value']);
        }
        if (!empty($search_params['status'])) {
            if ($search_params['status'] == 'tersedia') {
                $this->db->where('barang.qty >', 0);
            } else {
                $this->db->where('barang.qty', 0);
            }
        }

        $this->db->limit($this->barang->getPerPage(), $this->barang->calculateRealOffset($page));
        $data['content'] = $this->db->get()->result();

        $data['pagination'] = $this->items->makePagination(
            base_url('items/search'),
            3,
            $data['total_rows']
        );
        $data['start'] = $this->barang->calculateRealOffset($page);
        $data['page'] = 'pages/items/index';

        $this->view($data);
    }

    public function store()
    {
        // Load library upload
        $this->load->library('upload');
        $this->load->model('Stokgudang_model', 'stokgudang');

        // Konfigurasi upload file
        $config['upload_path'] = './uploads/items/'; // folder penyimpanan
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE; // biar nama file random, aman

        $this->upload->initialize($config);

        // Default path gambar
        $imagePath = null;

        // Proses upload jika ada file dipilih
        if (!empty($_FILES['image']['name'])) {
            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $imagePath = 'uploads/items/' . $uploadData['file_name'];
            } else {
                // Kalau gagal upload, tampilkan pesan error
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect(base_url('items/register'));
                return;
            }
        }

        // Ambil data dari form
        $qty = $this->input->post('qty');
        $id_gudang = $this->input->post('id_gudang');
        $id_supplier = $this->input->post('id_supplier');
        $nama = $this->input->post('nama');
        $kode_barang = $this->input->post('kode_barang');

        // Validasi duplikasi: cek apakah barang dengan nama dan supplier yang sama sudah ada
        $this->db->where('nama', $nama);
        if (!empty($id_supplier)) {
            $this->db->where('id_supplier', $id_supplier);
        } else {
            $this->db->where('id_supplier IS NULL', null, false);
        }
        $existing = $this->db->get('barang')->row();

        if ($existing) {
            $this->session->set_flashdata('error', 'Barang dengan nama "' . $nama . '" dan supplier yang sama sudah terdaftar.');
            redirect(base_url('items/register'));
            return;
        }

        // Simpan ke database barang
        $id_lokasi = $this->input->post('id_lokasi');
        $data = [
            'kode_barang' => $kode_barang,
            'nama' => $nama,
            'deskripsi' => $this->input->post('deskripsi'),
            'qty' => $qty,
            'id_satuan' => $this->input->post('id_satuan'),
            'id_supplier' => !empty($id_supplier) ? $id_supplier : null,
            'id_lokasi' => !empty($id_lokasi) ? $id_lokasi : null,
            'image' => $imagePath // Simpan path ke DB
        ];

        $this->load->model('Barang_model', 'barang');
        $this->db->insert('barang', $data);
        $id_barang = $this->db->insert_id();

        // Simpan stok ke gudang yang dipilih
        if ($id_gudang && $qty > 0) {
            $stok_data = [
                'id_gudang' => $id_gudang,
                'id_barang' => $id_barang,
                'qty' => $qty,
                'stok_minimum' => 0
            ];
            $this->db->insert('stok_gudang', $stok_data);
        }

        $this->session->set_flashdata('success', 'Barang berhasil ditambahkan ke List Barang dan Gudang ' . getWarehouseName($id_gudang));
        redirect(base_url('items'));
    }

    public function register()
    {
        $data['title'] = 'Register Barang';
        $data['breadcrumb_title'] = 'Register Barang';
        $data['breadcrumb_path'] = 'Pendataan Barang / Register Barang';
        $data['page'] = 'pages/items/register';

        // ✅ Tambahkan variabel kosong biar tidak error di layout utama
        $data['content'] = [];
        $data['pagination'] = '';

        $this->view($data);
    }


    public function update($id)
    {
        // Ambil data lama dari database
        $barang = $this->barang->getById($id);
        $image_name = $barang->image; // default pakai gambar lama

        // Jika user upload gambar baru
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/items/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE; // biar aman dan random

            // Pastikan folder upload ada
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                // Hapus gambar lama (jika bukan default)
                if (!empty($barang->image) && $barang->image != 'uploads/items/default.png') {
                    $oldPath = FCPATH . $barang->image; // path absolut
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                // Gambar baru → simpan full path ke DB
                $uploadData = $this->upload->data();
                $image_name = 'uploads/items/' . $uploadData['file_name'];

            } else {
                // Jika gagal upload
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('items');
                return;
            }
        }

        // Update data ke database
        $id_supplier = $this->input->post('id_supplier', true);
        $id_lokasi = $this->input->post('id_lokasi', true);
        $nama = $this->input->post('nama', true);

        // Validasi duplikasi: cek apakah barang dengan nama dan supplier yang sama sudah ada (selain barang ini sendiri)
        $this->db->where('nama', $nama);
        $this->db->where('id !=', $id);
        if (!empty($id_supplier)) {
            $this->db->where('id_supplier', $id_supplier);
        } else {
            $this->db->where('id_supplier IS NULL', null, false);
        }
        $existing = $this->db->get('barang')->row();

        if ($existing) {
            $this->session->set_flashdata('error', 'Barang dengan nama "' . $nama . '" dan supplier yang sama sudah terdaftar.');
            redirect('items');
            return;
        }

        $data = [
            'kode_barang' => $this->input->post('kode_barang', true),
            'nama' => $nama,
            'deskripsi' => $this->input->post('deskripsi', true),
            'id_satuan' => $this->input->post('id_satuan', true),
            'id_supplier' => !empty($id_supplier) ? $id_supplier : null,
            'id_lokasi' => !empty($id_lokasi) ? $id_lokasi : null,
            'image' => $image_name
        ];

        $this->barang->update($id, $data);
        $this->session->set_flashdata('success', 'Data barang berhasil diperbarui.');
        redirect('items');
    }

    public function delete($id)
    {
        // 🔒 Hanya admin yang boleh menghapus
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Anda bukan admin.');
            redirect(base_url('items'));
        }

        // 🧩 Cek apakah data barang ada
        $barang = $this->db->get_where('barang', ['id' => $id])->row();
        if (!$barang) {
            $this->session->set_flashdata('error', 'Data barang tidak ditemukan.');
            redirect(base_url('items'));
            return;
        }

        // 🗑️ Hapus gambar fisik jika bukan default
        if (!empty($barang->image) && $barang->image != 'uploads/items/default.png') {
            $oldPath = FCPATH . $barang->image;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // 🚀 Hapus stok gudang terkait
        $this->db->where('id_barang', $id)->delete('stok_gudang');

        // 🚀 Hapus data dari database
        $deleted = $this->db->where('id', $id)->delete('barang');

        if ($deleted) {
            $this->session->set_flashdata('success', 'Stok berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus stok.');
        }

        redirect(base_url('items'));
    }

}

/* End of file Items.php */
