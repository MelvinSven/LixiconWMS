<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Keranjang Masuk
 */
class Cartin extends MY_Controller
{
    private $id_user;

    public function __construct()
    {
        parent::__construct();

        $is_login = $this->session->userdata('is_login');
        $this->id_user = $this->session->userdata('id_user');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }
    }

    public function index()
    {
        $this->session->unset_userdata('keyword');

        $data['title'] = 'Lixicon - Keranjang Masuk';
        $data['breadcrumb_title'] = "Barang Masuk";
        $data['breadcrumb_path'] = 'Barang masuk ke gudang';
        $data['page'] = 'pages/cartin/index';
        $data['content'] = $this->db->select([
            'barang.id AS id_barang',
            'barang.kode_barang',
            'barang.nama',
            'barang.id_satuan',
            'keranjang_masuk.id AS id',
            'keranjang_masuk.qty AS qty_barang_masuk',
            'keranjang_masuk.id_gudang',
            'gudang.nama AS nama_gudang',
            'supplier.nama AS nama_supplier'
        ])
            ->from('keranjang_masuk')
            ->join('barang', 'keranjang_masuk.id_barang = barang.id', 'left')
            ->join('gudang', 'keranjang_masuk.id_gudang = gudang.id', 'left')
            ->join('supplier', 'barang.id_supplier = supplier.id_supplier', 'left')
            ->where('keranjang_masuk.id_user', $this->id_user)
            ->get()
            ->result();

        $this->view($data);
    }

    /**
     * Menampung barang yang akan ditambah kuantitasnya
     */
    public function add()
    {
        // URL redirect (default ke items, bisa ke warehouse detail)
        $redirect_to = $this->input->post('redirect_to') ?: base_url('items');

        if (!$_POST || $this->input->post('qty_masuk') < 1) {
            $this->session->set_flashdata('error', 'Kuantitas tidak boleh kosong');
            redirect($redirect_to);
            return;
        }

        // Validasi gudang harus dipilih
        if (!$this->input->post('id_gudang')) {
            $this->session->set_flashdata('error', 'Silakan pilih gudang tujuan');
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

        // Mengambil data barang yang dipilih
        $this->cartin->table = 'barang';
        $barang = $this->cartin->where('id', $input->id_barang)->first();

        // Mekanisme penambahan kuantitas
        // Ambil suatu barang di keranjang untuk dicek apakah barang tersebut sudah dimasukan (dengan gudang yang sama)
        $this->cartin->table = 'keranjang_masuk';
        $cart = $this->cartin->where('id_barang', $input->id_barang)
            ->where('id_gudang', $input->id_gudang)
            ->where('id_user', $this->id_user)
            ->first();

        if ($cart) {    // Jika ternyata sudah dimasukan user ke gudang yang sama, maka update cart
            $data = [
                'qty' => $cart->qty + $input->qty_masuk
            ];

            // Update data
            if (
                $this->db->where('id', $cart->id)
                    ->where('id_user', $this->id_user)
                    ->update('keranjang_masuk', $data)
            ) {
                $this->session->set_flashdata('success', 'Barang berhasil ditambahkan ke gudang ' . getWarehouseName($input->id_gudang));
            } else {
                $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
            }

            redirect(base_url('cartin'));
            return;
        }

        // --- Insert cart baru ---
        $data = [
            'id_user' => $this->id_user,
            'id_barang' => $input->id_barang,
            'id_gudang' => $input->id_gudang,
            'qty' => $input->qty_masuk
        ];

        if ($this->cartin->create($data)) {   // Jika insert berhasil
            $this->session->set_flashdata('success', 'Barang berhasil dimasukan ke keranjang (Gudang: ' . getWarehouseName($input->id_gudang) . ')');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('cartin'));
    }

    /**
     * Update kuantitas di keranjang belanja
     */
    public function update()
    {
        if (!$_POST || $this->input->post('qty_barang_masuk') < 1) {
            $this->session->set_flashdata('error', 'Kuantitas tidak boleh kosong');
            redirect(base_url('cartin'));
        }

        $id = $this->input->post('id');
        $id_barang = $this->input->post('id_barang');

        // Mengambil data dari keranjang
        $data['content'] = $this->cartin->where('id_barang', $id_barang)
            ->where('id', $id)
            ->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('cartin'));
        }

        // Mengambil data barang yang dipilih
        $this->cartin->table = 'barang';
        $barang = $this->cartin->where('id', $data['content']->id_barang)->first();

        // Update data
        $data['input'] = (object) $this->input->post(null, true);

        // Update data
        $cart = [
            'qty' => $data['input']->qty_barang_masuk
        ];

        $this->cartin->table = 'keranjang_masuk';
        if (
            $this->db->where('id', $id)
                ->where('id_barang', $id_barang)
                ->where('id_user', $this->id_user)
                ->update('keranjang_masuk', $cart)
        ) {
            // Jika update berhasil
            $this->session->set_flashdata('success', 'Kuantitas berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('cartin'));
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
            redirect(base_url('cartin'));
            return;
        }

        if (!$this->cartin->where('id', $id)->first()) {  // Jika cart tidak ditemukan
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('cartin'));
        }

        if ($this->cartin->where('id', $id)->delete()) {  // Jika penghapusan cart berhasil
            $this->session->set_flashdata('success', '1 Barang berhasil dikeluarkan dari keranjang');
        } else {
            $this->session->set_flashdata('error', 'Oops, terjadi suatu kesalahan');
        }

        redirect(base_url('cartin'));
    }

    /**
     * Menghapus seluruh isi keranjang
     */
    public function drop()
    {
        if ($this->cartin->where('id_user', $this->id_user)->count() < 1) {
            $this->session->set_flashdata('warning', 'Tidak ada barang di dalam keranjang');
            redirect(base_url('cartin'));
        }

        // Hapus seluruh isi keranjang dari user
        $this->cartin->where('id_user', $this->id_user)->delete();

        // Jika tabel keranjang dari seluruh user kosong, reset autoincrement id keranjang
        if ($this->cartin->count() < 1) {
            $this->cartin->resetIndex();
        }

        $this->session->set_flashdata('success', 'Keranjang masuk anda telah dibersihkan');

        redirect(base_url('cartin'));
    }

    /**
     * Fungsi tombol checkout
     * Fungsi ini memasukan informasi pemasukan barang ke tabel 'barang_masuk' 
     * dan memindahkan list keranjang masuk ke tabel 'barang_masuk_detail'
     */
    public function checkout()
    {
        if (!isset($this->id_user)) {
            $this->session->set_flashdata('error', 'Akses checkout ditolak!');
            redirect(base_url('home'));
        }

        // Cek apakah user memiliki barang masukan pending di keranjang
        $inputCartCount = $this->cartin->where('id_user', $this->id_user)->count();

        if (!$inputCartCount) {
            $this->session->set_flashdata('warning', 'Tidak ada barang yang akan dimasukan!');
            redirect(base_url('cartin'));
        }

        // Update kuantitas dari form sebelum proses checkout
        $quantities = $this->input->post('qty');
        if (!empty($quantities) && is_array($quantities)) {
            foreach ($quantities as $cart_id => $qty) {
                $qty = max(1, intval($qty)); // Minimal 1
                $this->db->where('id', $cart_id)
                    ->where('id_user', $this->id_user)
                    ->update('keranjang_masuk', ['qty' => $qty]);
            }
        }

        // Upload bukti foto jika ada
        $bukti_foto = null;
        if (!empty($_FILES['bukti_foto']['name'])) {
            $config['upload_path'] = './uploads/inputs/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;

            // Buat folder jika belum ada
            if (!is_dir('./uploads/inputs/')) {
                mkdir('./uploads/inputs/', 0777, true);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('bukti_foto')) {
                $bukti_foto = 'uploads/inputs/' . $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                redirect(base_url('cartin'));
                return;
            }
        }

        // Menyiapkan insert table barang_masuk
        $data['id_user'] = $this->id_user;
        if ($bukti_foto) {
            $data['bukti_foto'] = $bukti_foto;
        }
        $this->cartin->table = 'barang_masuk';

        // Jika insert barang_masuk berhasil, siapkan insert lagi ke dalam barang_masuk_detail
        if ($id_barang_masuk = $this->cartin->create($data)) {
            // Ambil list keranjang user
            $cart = $this->db->where('id_user', $this->id_user)
                ->get('keranjang_masuk')
                ->result_array();

            // Modifikasi tiap cart
            foreach ($cart as $row) {
                $row['id_barang_masuk'] = $id_barang_masuk;
                unset($row['id'], $row['id_user']);             // Hapus kolom tidak penting
                $this->db->insert('barang_masuk_detail', $row); // Insert ke tabel barang_masuk_detail
            }

            $this->db->delete('keranjang_masuk', ['id_user' => $this->id_user]);    // Hapus cart user sekarang

            $this->session->set_flashdata('success', 'Penambahan stok berhasil');

            $data['title'] = 'Checkout';
            $data['breadcrumb_title'] = "Checkout";
            $data['breadcrumb_path'] = 'Barang Masuk / Keranjang Masuk / Checkout';
            $data['page'] = 'pages/cartin/checkout';

            // Ambil data pemasukan barang untuk ditampilkan di halaman checkout
            $this->table = 'barang_masuk';
            $data['barang_masuk'] = $this->cartin->select([
                'user.id AS id_user',
                'user.nama',
                'barang_masuk.id AS id_barang_masuk',
                'barang_masuk.waktu',
                'barang_masuk.bukti_foto'
            ])
                ->join('user')
                ->where('barang_masuk.id', $id_barang_masuk)
                ->where('barang_masuk.id_user', $this->id_user)
                ->first();

            $this->cartin->table = 'barang_masuk_detail';
            $data['list_barang'] = $this->cartin->select([
                'barang_masuk_detail.qty',
                'barang_masuk_detail.id_gudang',
                'barang.id_satuan',
                'barang.nama',
                'gudang.nama AS nama_gudang',
            ])
                ->join('barang')
                ->join('gudang', 'barang_masuk_detail.id_gudang = gudang.id', 'left')
                ->where('barang_masuk_detail.id_barang_masuk', $id_barang_masuk)
                ->get();

            $this->view($data);

        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
            $this->index();
        }
    }
}

/* End of file Cartin.php */
