<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Keranjang Keluar
 */
class Cartout extends MY_Controller
{
    private $id_user;

    public function __construct()
    {
        parent::__construct();

        $is_login = $this->session->userdata('is_login');
        $this->id_user = $this->session->userdata('id_user');

        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }
    }

    public function index()
    {
        $this->session->unset_userdata('keyword');

        $data['title'] = 'Lixicon - Keranjang Keluar';
        $data['breadcrumb_title'] = "Barang Keluar";
        $data['breadcrumb_path'] = 'Barang keluar dari gudang';
        $data['page'] = 'pages/cartout/index';
        $data['content'] = $this->db->select([
            'barang.id AS id_barang',
            'barang.nama',
            'barang.id_satuan',
            'keranjang_keluar.id AS id',
            'keranjang_keluar.qty AS qty_barang_keluar',
            'keranjang_keluar.id_gudang',
            'gudang.nama AS nama_gudang'
        ])
            ->from('keranjang_keluar')
            ->join('barang', 'keranjang_keluar.id_barang = barang.id', 'left')
            ->join('gudang', 'keranjang_keluar.id_gudang = gudang.id', 'left')
            ->where('keranjang_keluar.id_user', $this->id_user)
            ->get()
            ->result();

        $this->view($data);
    }

    /**
     * Menampung barang yang akan dikurangi kuantitasnya
     */
    public function add()
    {
        // URL redirect (default ke items, bisa ke warehouse detail)
        $redirect_to = $this->input->post('redirect_to') ?: base_url('items');

        if (!$_POST || $this->input->post('qty_keluar') < 1) {
            $this->session->set_flashdata('error', 'Kuantitas tidak boleh kosong');
            redirect($redirect_to);
            return;
        }

        // Validasi gudang harus dipilih
        if (!$this->input->post('id_gudang')) {
            $this->session->set_flashdata('error', 'Silakan pilih gudang asal');
            redirect($redirect_to);
            return;
        }

        $input = (object) $this->input->post(null, true);

        // Cek akses gudang untuk staff
        $user_gudang = getUserGudangId();
        if ($user_gudang !== null && $user_gudang != $input->id_gudang) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke gudang ini.');
            redirect($redirect_to);
            return;
        }

        // Cek stok di gudang yang dipilih
        $stok_gudang = getStokGudang($input->id_gudang, $input->id_barang);
        if ($stok_gudang < $input->qty_keluar) {
            $this->session->set_flashdata('error', 'Stok di gudang ' . getWarehouseName($input->id_gudang) . ' tidak mencukupi (tersedia: ' . $stok_gudang . ')');
            redirect($redirect_to);
            return;
        }

        // Mekanisme penambahan kuantitas
        // Ambil suatu barang di keranjang untuk dicek apakah barang tersebut sudah dimasukan (dengan gudang yang sama)
        $this->cartout->table = 'keranjang_keluar';
        $cart = $this->cartout->where('id_barang', $input->id_barang)
            ->where('id_gudang', $input->id_gudang)
            ->where('id_user', $this->id_user)
            ->first();

        if ($cart) {    // Jika ternyata sudah dimasukan user dari gudang yang sama, maka update cart
            // Validasi total qty tidak melebihi stok gudang
            $new_qty = $cart->qty + $input->qty_keluar;
            if ($new_qty > $stok_gudang) {
                $this->session->set_flashdata('error', 'Total kuantitas di keranjang melebihi stok gudang (maks: ' . $stok_gudang . ')');
                redirect(base_url('cartout'));
                return;
            }

            $data = ['qty' => $new_qty];

            // Update data
            if (
                $this->db->where('id', $cart->id)
                    ->where('id_user', $this->id_user)
                    ->update('keranjang_keluar', $data)
            ) {
                $this->session->set_flashdata('success', 'Kuantitas berhasil diubah dari gudang ' . getWarehouseName($input->id_gudang));
            } else {
                $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
            }

            redirect(base_url('cartout'));
            return;
        }

        // --- Insert cart baru ---
        $data = [
            'id_user' => $this->id_user,
            'id_barang' => $input->id_barang,
            'id_gudang' => $input->id_gudang,
            'qty' => $input->qty_keluar
        ];

        if ($this->cartout->create($data)) {   // Jika insert berhasil
            $this->session->set_flashdata('success', 'Barang berhasil dimasukan ke keranjang (dari Gudang: ' . getWarehouseName($input->id_gudang) . ')');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('cartout'));
    }

    /**
     * Update kuantitas di keranjang belanja
     */
    public function update()
    {
        if (!$_POST || $this->input->post('qty_barang_keluar') < 1) {
            $this->session->set_flashdata('error', 'Kuantitas tidak boleh kosong');
            redirect(base_url('cartout'));
        }

        $id = $this->input->post('id');
        $id_barang = $this->input->post('id_barang');

        // Mengambil data dari keranjang
        $data['content'] = $this->cartout->where('id_barang', $id_barang)
            ->where('id', $id)
            ->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('cartout'));
        }

        $data['input'] = (object) $this->input->post(null, true);

        // Update kuantitas
        $cart = ['qty' => $data['input']->qty_barang_keluar];

        if (
            $this->db->where('id', $id)
                ->where('id_barang', $id_barang)
                ->where('id_user', $this->id_user)
                ->update('keranjang_keluar', $cart)
        ) {
            // Jika update berhasil
            $this->session->set_flashdata('success', 'Kuantitas berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('cartout'));
    }

    /**
     * Delete suatu cart di halaman cart
     */
    public function delete($id = null)
    {
        // Support both POST and GET (URL parameter)
        if (!$id) {
            $id = $this->input->post('id');
        }

        if (!$id) {
            $this->session->set_flashdata('error', 'Akses pengeluaran barang dari keranjang ditolak!');
            redirect(base_url('cartout'));
            return;
        }

        if (!$this->cartout->where('id', $id)->first()) {  // Jika cart tidak ditemukan
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('cartout'));
        }

        if ($this->cartout->where('id', $id)->delete()) {  // Jika penghapusan cart berhasil
            $this->session->set_flashdata('success', '1 Barang berhasil dikeluarkan dari keranjang');
        } else {
            $this->session->set_flashdata('error', 'Oops, terjadi suatu kesalahan');
        }

        redirect(base_url('cartout'));
    }

    /**
     * Menghapus seluruh isi keranjang
     */
    public function drop()
    {
        if ($this->cartout->where('id_user', $this->id_user)->count() < 1) {
            $this->session->set_flashdata('warning', 'Tidak ada barang di dalam keranjang');
            redirect(base_url('cartout'));
        }

        // Hapus seluruh isi keranjang dari user
        $this->cartout->where('id_user', $this->id_user)->delete();

        // Jika tabel keranjang dari seluruh user kosong, reset autoincrement id keranjang
        if ($this->cartout->count() < 1) {
            $this->cartout->resetIndex();
        }

        $this->session->set_flashdata('success', 'Keranjang keluar anda telah dibersihkan');

        redirect(base_url('cartout'));
    }

    /**
     * Fungsi tombol checkout
     * Fungsi ini memasukan informasi pengeluaran barang ke tabel 'barang_keluar' 
     * dan memindahkan list keranjang keluar ke tabel 'barang_keluar_detail'
     */
    public function checkout()
    {
        if (!isset($this->id_user)) {
            $this->session->set_flashdata('error', 'Akses checkout ditolak!');
            redirect(base_url('home'));
        }

        // Cek apakah user memiliki barang keluar yang pending di keranjang
        $outputCartCount = $this->cartout->where('id_user', $this->id_user)->count();

        if (!$outputCartCount) {
            $this->session->set_flashdata('warning', 'Tidak ada barang yang akan dikeluarkan!');
            redirect(base_url('cartout'));
        }

        // Update kuantitas dari form sebelum proses checkout
        $quantities = $this->input->post('qty');
        if (!empty($quantities) && is_array($quantities)) {
            foreach ($quantities as $cart_id => $qty) {
                $qty = max(1, intval($qty)); // Minimal 1
                $this->db->where('id', $cart_id)
                    ->where('id_user', $this->id_user)
                    ->update('keranjang_keluar', ['qty' => $qty]);
            }
        }

        if (!$this->cartout->validateStock()) { // Valdasi stok
            return $this->index();
        }

        // Validasi nama kurir
        $nama_kurir = trim($this->input->post('nama_kurir', true));
        if (empty($nama_kurir)) {
            $this->session->set_flashdata('error', 'Nama kurir wajib diisi!');
            redirect(base_url('cartout'));
            return;
        }

        // Validasi keterangan
        $keterangan = trim($this->input->post('keterangan', true));
        if (empty($keterangan)) {
            $this->session->set_flashdata('error', 'Keterangan wajib diisi sebelum proses keluar!');
            redirect(base_url('cartout'));
            return;
        }

        // Upload bukti foto jika ada
        $bukti_foto = null;
        if (!empty($_FILES['bukti_foto']['name'])) {
            $config['upload_path'] = './uploads/outputs/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;

            // Buat folder jika belum ada
            if (!is_dir('./uploads/outputs/')) {
                mkdir('./uploads/outputs/', 0777, true);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('bukti_foto')) {
                $bukti_foto = 'uploads/outputs/' . $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                redirect(base_url('cartout'));
                return;
            }
        }

        // Menyiapkan insert table barang_keluar
        $data['id_user'] = $this->id_user;
        $data['status'] = 'dikirim';
        $data['nama_kurir'] = $nama_kurir;
        $data['keterangan'] = $keterangan;
        if ($bukti_foto) {
            $data['bukti_foto'] = $bukti_foto;
        }
        $this->cartout->table = 'barang_keluar';

        // Jika insert barang_keluar berhasil, siapkan insert lagi ke dalam barang_keluar_detail
        if ($id_barang_keluar = $this->cartout->create($data)) {
            // Ambil list keranjang user
            $cart = $this->db->where('id_user', $this->id_user)
                ->get('keranjang_keluar')
                ->result_array();

            // Modifikasi tiap cart
            foreach ($cart as $row) {
                $row['id_barang_keluar'] = $id_barang_keluar;
                unset($row['id'], $row['id_user']);                 // Hapus kolom tidak penting
                $this->db->insert('barang_keluar_detail', $row);    // Insert ke tabel barang_keluar_detail
                // Stok dikurangi otomatis oleh trigger `kurangi_barang_gudang` pada tabel barang_keluar_detail
            }

            $this->db->delete('keranjang_keluar', ['id_user' => $this->id_user]);    // Hapus cart user sekarang

            $this->session->set_flashdata('success', 'Pengeluaran barang berhasil');

            $data['title'] = 'Checkout';
            $data['breadcrumb_title'] = "Checkout";
            $data['breadcrumb_path'] = 'Barang Keluar / Keranjang Keluar / Checkout';
            $data['page'] = 'pages/cartout/checkout';

            // Ambil data pengeluaran barang untuk ditampilkan di halaman checkout
            $this->table = 'barang_keluar';
            $data['barang_keluar'] = $this->cartout->select([
                'user.id AS id_user',
                'user.nama',
                'barang_keluar.id AS id_barang_keluar',
                'barang_keluar.waktu',
                'barang_keluar.bukti_foto',
                'barang_keluar.nama_kurir',
                'barang_keluar.keterangan',
                'barang_keluar.status'
            ])
                ->join('user')
                ->where('barang_keluar.id', $id_barang_keluar)
                ->where('barang_keluar.id_user', $this->id_user)
                ->first();

            $this->cartout->table = 'barang_keluar_detail';
            $data['list_barang'] = $this->cartout->select([
                'barang_keluar_detail.qty',
                'barang.id_satuan',
                'barang.nama',
            ])
                ->join('barang')
                ->where('barang_keluar_detail.id_barang_keluar', $id_barang_keluar)
                ->get();

            $this->view($data);
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
            $this->index();
        }
    }
}

/* End of file Cartout.php */
