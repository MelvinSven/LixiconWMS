<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transfer_model', 'transferModel');
        $this->load->model('Stokgudang_model', 'stokGudangModel');
        $this->load->model('Gudang_model', 'gudangModel');
        $this->load->model('Barang_model', 'barangModel');
        $this->load->library('form_validation');
    }

    /**
     * Halaman daftar transfer (riwayat)
     */
    public function index()
    {
        $this->session->unset_userdata('transfer_filter_date');
        $currentPage = $this->input->get('page') ?? 1;

        $data = [
            'title' => 'Riwayat Transfer Barang',
            'breadcrumb_title' => 'Riwayat Transfer Barang',
            'breadcrumb_path' => 'Transfer / Riwayat',
            'page' => 'pages/transfers/index',
            'transfers' => $this->transferModel->getAllTransfers($currentPage),
            'totalTransfers' => $this->transferModel->countTransfers(),
            'currentPage' => (int) $currentPage,
            'filter_date' => null,
        ];

        return $this->view($data);
    }

    /**
     * Filter riwayat transfer berdasarkan tanggal
     */
    public function filter_date()
    {
        if ($this->input->post('filter_date')) {
            $this->session->set_userdata('transfer_filter_date', $this->input->post('filter_date'));
        }

        $filter_date = $this->session->userdata('transfer_filter_date');
        if (empty($filter_date)) {
            redirect(base_url('transfer'));
            return;
        }

        $displayDate = date('d-m-Y', strtotime($filter_date));
        $data = [
            'title' => 'Riwayat Transfer Barang',
            'breadcrumb_title' => 'Riwayat Transfer Barang',
            'breadcrumb_path' => "Transfer / Riwayat / Filter / $displayDate",
            'page' => 'pages/transfers/index',
            'transfers' => $this->transferModel->getTransfersByDate($filter_date),
            'totalTransfers' => count($this->transferModel->getTransfersByDate($filter_date)),
            'currentPage' => 1,
            'filter_date' => $filter_date,
        ];

        return $this->view($data);
    }

    /**
     * Reset filter tanggal
     */
    public function reset_filter()
    {
        $this->session->unset_userdata('transfer_filter_date');
        redirect(base_url('transfer'));
    }

    /**
     * Halaman form create transfer
     */
    public function create()
    {
        $user_gudang_id = getUserGudangId();

        // For staff, only show their assigned warehouse in Gudang Asal
        if ($user_gudang_id) {
            $gudang_asal_options = $this->db->where('id', $user_gudang_id)->get('gudang')->result();
        } else {
            $gudang_asal_options = $this->gudangModel->getAllWarehouses();
        }

        $data = [
            'title' => 'Transfer Barang',
            'breadcrumb_title' => 'Transfer Barang',
            'breadcrumb_path' => 'Transfer / Tambah Transfer',
            'page' => 'pages/transfers/create',
            'warehouses' => $this->gudangModel->getAllWarehouses(),
            'gudang_asal_options' => $gudang_asal_options,
            'user_gudang_id' => $user_gudang_id,
            'items' => $this->barangModel->get()
        ];

        return $this->view($data);
    }

    /**
     * Simpan transfer baru
     */
    public function store()
    {
        $this->form_validation->set_rules('id_gudang_asal', 'Gudang Asal', 'required|numeric');
        $this->form_validation->set_rules('id_gudang_tujuan', 'Gudang Tujuan', 'required|numeric|differs[id_gudang_asal]');
        $this->form_validation->set_rules('id_barang[]', 'Barang', 'required');
        $this->form_validation->set_rules('qty[]', 'Qty', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('transfer/create');
        }

        $id_gudang_asal = $this->input->post('id_gudang_asal');
        $id_gudang_tujuan = $this->input->post('id_gudang_tujuan');
        $id_barangs = $this->input->post('id_barang');
        $qtys = $this->input->post('qty');
        $keterangan = $this->input->post('keterangan');
        $nama_kurir = trim($this->input->post('nama_kurir', true));

        // Validasi nama kurir
        if (empty($nama_kurir)) {
            $this->session->set_flashdata('error', 'Nama kurir wajib diisi!');
            return redirect('transfer/create');
        }

        // Validasi stok
        $errors = [];
        $items = [];

        for ($i = 0; $i < count($id_barangs); $i++) {
            if (empty($id_barangs[$i]) || empty($qtys[$i]))
                continue;

            $stok = $this->stokGudangModel->getStokByGudangBarang($id_gudang_asal, $id_barangs[$i]);
            $stok_tersedia = $stok ? $stok->qty : 0;

            if ($qtys[$i] > $stok_tersedia) {
                $barang = $this->barangModel->find($id_barangs[$i]);
                $errors[] = "Stok {$barang->nama} tidak cukup. Tersedia: {$stok_tersedia}, Diminta: {$qtys[$i]}";
            } else {
                $items[] = [
                    'id_barang' => $id_barangs[$i],
                    'qty' => $qtys[$i]
                ];
            }
        }

        if (!empty($errors)) {
            $this->session->set_flashdata('error', implode('<br>', $errors));
            return redirect('transfer/create');
        }

        if (empty($items)) {
            $this->session->set_flashdata('error', 'Pilih minimal satu barang untuk ditransfer');
            return redirect('transfer/create');
        }

        // Upload bukti foto jika ada
        $bukti_foto = null;
        if (!empty($_FILES['bukti_foto']['name'])) {
            $config['upload_path'] = './uploads/transfers/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = 'TRF_' . date('YmdHis') . '_' . uniqid();

            // Buat folder jika belum ada
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('bukti_foto')) {
                $bukti_foto = 'uploads/transfers/' . $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                return redirect('transfer/create');
            }
        }

        // Data header transfer
        $data = [
            'kode_transfer' => $this->transferModel->generateKode(),
            'id_gudang_asal' => $id_gudang_asal,
            'id_gudang_tujuan' => $id_gudang_tujuan,
            'id_user' => $this->session->userdata('id_user'),
            'waktu' => date('Y-m-d H:i:s'),
            'keterangan' => $keterangan,
            'bukti_foto' => $bukti_foto,
            'nama_kurir' => $nama_kurir,
            'status' => 'dikirim'
        ];

        $result = $this->transferModel->createTransfer($data, $items);

        if ($result) {
            $this->session->set_flashdata('success', 'Transfer barang berhasil dilakukan');
            return redirect('transfer/detail/' . $result);
        } else {
            $this->session->set_flashdata('error', 'Gagal melakukan transfer barang');
            return redirect('transfer/create');
        }
    }

    /**
     * Halaman detail transfer
     */
    public function detail($id)
    {
        $transfer = $this->transferModel->getTransferById($id);

        if (!$transfer) {
            $this->session->set_flashdata('error', 'Data transfer tidak ditemukan');
            return redirect('transfer');
        }

        $data = [
            'title' => 'Detail Transfer - ' . $transfer->kode_transfer,
            'breadcrumb_title' => 'Detail Transfer',
            'breadcrumb_path' => 'Transfer / Detail / ' . $transfer->kode_transfer,
            'page' => 'pages/transfers/detail',
            'transfer' => $transfer,
            'details' => $this->transferModel->getTransferDetails($id)
        ];

        return $this->view($data);
    }

    /**
     * API: Ambil stok barang berdasarkan gudang
     */
    public function getStokByGudang($id_gudang)
    {
        $stok = $this->stokGudangModel->getStokByGudangWithBarang($id_gudang);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'data' => $stok]);
    }

    /**
     * Hapus transfer (Admin only)
     */
    public function delete($id)
    {
        // Cek apakah user adalah admin
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus data transfer');
            return redirect('transfer');
        }

        // Cek apakah transfer ada
        $transfer = $this->transferModel->getTransferById($id);
        if (!$transfer) {
            $this->session->set_flashdata('error', 'Data transfer tidak ditemukan');
            return redirect('transfer');
        }

        // Hapus transfer beserta detailnya
        $result = $this->transferModel->deleteTransfer($id);

        if ($result) {
            $this->session->set_flashdata('success', 'Data transfer berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data transfer');
        }

        return redirect('transfer');
    }

    /**
     * Update status transfer (dikirim → sampai)
     */
    public function update_status($id)
    {
        $transfer = $this->transferModel->getTransferById($id);
        if (!$transfer) {
            $this->session->set_flashdata('error', 'Data transfer tidak ditemukan');
            return redirect('transfer');
        }

        $new_status = $this->input->post('status');
        if (!in_array($new_status, ['dikirim', 'sampai'])) {
            $this->session->set_flashdata('error', 'Status tidak valid');
            return redirect('transfer');
        }

        $this->db->where('id', $id)->update('transfer_gudang', ['status' => $new_status]);
        $this->session->set_flashdata('success', 'Status berhasil diubah menjadi ' . ucfirst($new_status));
        return redirect('transfer/detail/' . $id);
    }
}

/* End of file Transfer.php */
