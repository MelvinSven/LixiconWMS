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

        $is_staff = $this->session->userdata('role') == 'staff';
        $id_gudang = $is_staff ? (int)getUserGudangId() : null;

        if ($is_staff) {
            $qty_select = 'stok_gudang.qty';
            $data['total_rows'] = $this->db->where('id_gudang', $id_gudang)->count_all_results('stok_gudang');
        } else {
            $qty_select = '(SELECT COALESCE(SUM(sg.qty), 0) FROM stok_gudang sg WHERE sg.id_barang = barang.id) AS qty';
            $data['total_rows'] = $this->items->count();
        }

        $this->db->select([
            'barang.id AS id_barang',
            'barang.nama AS nama_barang',
            'barang.deskripsi',
            $qty_select,
            'barang.image',
            'barang.id_lokasi',
            'satuan.nama AS nama_satuan',
            'lokasi_barang.nama_lokasi'
        ]);
        $this->db->from('barang');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->join('lokasi_barang', 'barang.id_lokasi = lokasi_barang.id_lokasi', 'left');
        if ($is_staff) {
            $this->db->join('stok_gudang', 'stok_gudang.id_barang = barang.id AND stok_gudang.id_gudang = ' . $id_gudang, 'inner');
        }
        $this->db->limit($this->barang->getPerPage(), $this->barang->calculateRealOffset($page));
        $data['content'] = $this->db->get()->result();

        $data['pagination'] = $this->items->makePagination(base_url('items'), 2, $data['total_rows']);
        $data['start'] = $this->barang->calculateRealOffset($page);
        $data['page'] = 'pages/items/index';
        $data['is_staff'] = $is_staff;
        $data['user_gudang_id'] = $id_gudang;

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

        $is_staff = $this->session->userdata('role') == 'staff';
        $id_gudang = $is_staff ? (int)getUserGudangId() : null;

        if ($is_staff) {
            $qty_select = 'stok_gudang.qty';
            $data['total_rows'] = $this->db
                ->from('stok_gudang')
                ->join('barang', 'barang.id = stok_gudang.id_barang', 'inner')
                ->where('stok_gudang.id_gudang', $id_gudang)
                ->where('barang.id_satuan', $id_unit)
                ->count_all_results();
        } else {
            $qty_select = '(SELECT COALESCE(SUM(sg.qty), 0) FROM stok_gudang sg WHERE sg.id_barang = barang.id) AS qty';
            $data['total_rows'] = $this->items->where('id_satuan', $id_unit)->count();
        }

        $this->db->select([
            'barang.id AS id_barang',
            'barang.nama AS nama_barang',
            'barang.deskripsi',
            $qty_select,
            'barang.image',
            'barang.id_lokasi',
            'satuan.nama AS nama_satuan',
            'lokasi_barang.nama_lokasi'
        ]);
        $this->db->from('barang');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->join('lokasi_barang', 'barang.id_lokasi = lokasi_barang.id_lokasi', 'left');
        $this->db->where('barang.id_satuan', $id_unit);
        if ($is_staff) {
            $this->db->join('stok_gudang', 'stok_gudang.id_barang = barang.id AND stok_gudang.id_gudang = ' . $id_gudang, 'inner');
        }
        $this->db->limit($this->barang->getPerPage(), $this->barang->calculateRealOffset($page));
        $data['content'] = $this->db->get()->result();

        $data['pagination'] = $this->items->makePagination(
            base_url("items/unit/$id_unit"),
            4,
            $data['total_rows']
        );
        $data['start'] = $this->barang->calculateRealOffset($page);
        $data['page'] = 'pages/items/index';
        $data['is_staff'] = $is_staff;
        $data['user_gudang_id'] = $id_gudang;

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

        $is_staff = $this->session->userdata('role') == 'staff';
        $id_gudang = $is_staff ? (int)getUserGudangId() : null;

        if ($is_staff) {
            $qty_select = 'stok_gudang.qty';
            $qty_col = 'stok_gudang.qty';
        } else {
            $qty_select = '(SELECT COALESCE(SUM(sg.qty), 0) FROM stok_gudang sg WHERE sg.id_barang = barang.id) AS qty';
            $qty_col = 'barang.qty';
        }

        $qty_op = ($param === 'available') ? '>' : '=';
        $qty_val = ($param === 'available') ? 0 : 0;

        if ($is_staff) {
            $data['total_rows'] = $this->db
                ->from('stok_gudang')
                ->where('id_gudang', $id_gudang)
                ->where('qty ' . $qty_op, $qty_val)
                ->count_all_results();
        } else {
            $data['total_rows'] = ($param === 'available')
                ? $this->items->where('qty >', 0)->count()
                : $this->items->where('qty', 0)->count();
        }

        $this->db->select([
            'barang.id AS id_barang',
            'barang.nama AS nama_barang',
            'barang.deskripsi',
            $qty_select,
            'barang.image',
            'barang.id_lokasi',
            'satuan.nama AS nama_satuan',
            'lokasi_barang.nama_lokasi'
        ]);
        $this->db->from('barang');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->join('lokasi_barang', 'barang.id_lokasi = lokasi_barang.id_lokasi', 'left');
        if ($is_staff) {
            $this->db->join('stok_gudang', 'stok_gudang.id_barang = barang.id AND stok_gudang.id_gudang = ' . $id_gudang, 'inner');
        }
        $this->db->where($qty_col . ' ' . $qty_op, $qty_val);
        $this->db->limit($this->barang->getPerPage(), $this->barang->calculateRealOffset($page));
        $data['content'] = $this->db->get()->result();

        $data['pagination'] = $this->items->makePagination(
            base_url("items/availability/$param"),
            4,
            $data['total_rows']
        );
        $data['start'] = $this->barang->calculateRealOffset($page);
        $data['is_staff'] = $is_staff;
        $data['user_gudang_id'] = $id_gudang;

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
                'nama_barang' => $this->input->post('nama_barang'),
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

        $is_staff = $this->session->userdata('role') == 'staff';
        $id_gudang = $is_staff ? (int)getUserGudangId() : null;
        $qty_col = $is_staff ? 'stok_gudang.qty' : 'barang.qty';
        $allowed_qty_ops = ['>', '<', '>=', '<=', '=', '!='];

        // Build base query untuk count
        $this->db->from('barang');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->join('lokasi_barang', 'barang.id_lokasi = lokasi_barang.id_lokasi', 'left');
        if ($is_staff) {
            $this->db->join('stok_gudang', 'stok_gudang.id_barang = barang.id AND stok_gudang.id_gudang = ' . $id_gudang, 'inner');
        }

        // Apply filters untuk count
        if (!empty($search_params['nama_barang'])) {
            $this->db->like('barang.nama', $search_params['nama_barang']);
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
            $this->db->where($qty_col . ' ' . $search_params['qty_operator'], (int) $search_params['qty_value']);
        }
        if (!empty($search_params['status'])) {
            if ($search_params['status'] == 'tersedia') {
                $this->db->where($qty_col . ' >', 0);
            } else {
                $this->db->where($qty_col, 0);
            }
        }

        $data['total_rows'] = $this->db->count_all_results();

        $qty_select = $is_staff
            ? 'stok_gudang.qty'
            : '(SELECT COALESCE(SUM(sg.qty), 0) FROM stok_gudang sg WHERE sg.id_barang = barang.id) AS qty';

        // Build query untuk data
        $this->db->select([
            'barang.id AS id_barang',
            'barang.nama AS nama_barang',
            'barang.deskripsi',
            $qty_select,
            'barang.image',
            'barang.id_lokasi',
            'satuan.nama AS nama_satuan',
            'lokasi_barang.nama_lokasi'
        ]);
        $this->db->from('barang');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->join('lokasi_barang', 'barang.id_lokasi = lokasi_barang.id_lokasi', 'left');
        if ($is_staff) {
            $this->db->join('stok_gudang', 'stok_gudang.id_barang = barang.id AND stok_gudang.id_gudang = ' . $id_gudang, 'inner');
        }

        // Apply filters lagi untuk data
        if (!empty($search_params['nama_barang'])) {
            $this->db->like('barang.nama', $search_params['nama_barang']);
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
            $this->db->where($qty_col . ' ' . $search_params['qty_operator'], (int) $search_params['qty_value']);
        }
        if (!empty($search_params['status'])) {
            if ($search_params['status'] == 'tersedia') {
                $this->db->where($qty_col . ' >', 0);
            } else {
                $this->db->where($qty_col, 0);
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
        $data['is_staff'] = $is_staff;
        $data['user_gudang_id'] = $id_gudang;

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
        $user_gudang = getUserGudangId();
        $id_gudang = ($user_gudang !== null) ? $user_gudang : $this->input->post('id_gudang');
        $nama = $this->input->post('nama');

        // Validasi duplikasi: cek apakah barang dengan nama yang sama sudah ada
        $existing = $this->db->where('nama', $nama)->get('barang')->row();

        if ($existing) {
            $this->session->set_flashdata('error', 'Barang dengan nama "' . $nama . '" sudah terdaftar.');
            redirect(base_url('items/register'));
            return;
        }

        // Simpan ke database barang
        $id_lokasi = $this->input->post('id_lokasi');
        $data = [
            'nama' => $nama,
            'deskripsi' => $this->input->post('deskripsi'),
            'qty' => $qty,
            'id_satuan' => $this->input->post('id_satuan'),
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
        $data['content'] = [];
        $data['pagination'] = '';
        $data['user_role'] = $this->session->userdata('role');
        $data['user_gudang_id'] = getUserGudangId();

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
        $id_lokasi = $this->input->post('id_lokasi', true);
        $nama = $this->input->post('nama', true);

        // Validasi duplikasi: cek apakah barang dengan nama yang sama sudah ada (selain barang ini sendiri)
        $existing = $this->db->where('nama', $nama)->where('id !=', $id)->get('barang')->row();

        if ($existing) {
            $this->session->set_flashdata('error', 'Barang dengan nama "' . $nama . '" sudah terdaftar.');
            redirect('items');
            return;
        }

        $data = [
            'nama' => $nama,
            'deskripsi' => $this->input->post('deskripsi', true),
            'id_satuan' => $this->input->post('id_satuan', true),
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

        // Block deletion if item is referenced by any non-finished purchase request
        $active_pr_count = $this->db
            ->select('COUNT(*) as cnt')
            ->from('purchase_request_detail prd')
            ->join('purchase_request pr', 'prd.id_pr = pr.id')
            ->where('prd.id_barang', $id)
            ->where('pr.status !=', 'selesai')
            ->get()->row()->cnt;

        if ($active_pr_count > 0) {
            $this->session->set_flashdata('error', 'Barang tidak dapat dihapus karena masih terdapat dalam Purchase Request yang belum selesai.');
            redirect(base_url('items'));
            return;
        }

        // Preserve item name in PR/PO detail rows before nullifying via FK ON DELETE SET NULL
        $this->db->where('id_barang', $id)->where('nama_barang_manual IS NULL', null, false)
            ->update('purchase_request_detail', ['nama_barang_manual' => $barang->nama]);

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
