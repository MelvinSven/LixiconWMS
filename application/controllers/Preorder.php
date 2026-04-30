<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Preorder extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Preorder_model', 'preorderModel');
        $this->load->model('Suratjalan_model', 'suratJalanModel');
        $this->load->model('Stokgudang_model', 'stokGudangModel');
        $this->load->model('Gudang_model', 'gudangModel');
        $this->load->model('Barang_model', 'barangModel');
        $this->load->library('form_validation');
    }

    /**
     * Halaman daftar permintaan barang
     */
    public function index()
    {
        $this->session->unset_userdata('preorder_filter_date');
        $currentPage = $this->input->get('page') ?? 1;

        $data = [
            'title' => 'Daftar Permintaan Barang',
            'breadcrumb_title' => 'Permintaan Barang',
            'breadcrumb_path' => 'Preorder / Daftar Permintaan',
            'page' => 'pages/preorder/index',
            'permintaans' => $this->preorderModel->getAllPermintaan($currentPage),
            'totalPermintaan' => $this->preorderModel->countPermintaan(),
            'currentPage' => (int) $currentPage,
            'filter_date' => null,
        ];

        return $this->view($data);
    }

    /**
     * Filter daftar permintaan berdasarkan tanggal
     */
    public function filter_date()
    {
        if ($this->input->post('filter_date')) {
            $this->session->set_userdata('preorder_filter_date', $this->input->post('filter_date'));
        }

        $filter_date = $this->session->userdata('preorder_filter_date');
        if (empty($filter_date)) {
            redirect(base_url('preorder'));
            return;
        }

        $displayDate = date('d-m-Y', strtotime($filter_date));
        $filtered = $this->preorderModel->getPermintaanByDate($filter_date);

        $data = [
            'title' => 'Daftar Permintaan Barang',
            'breadcrumb_title' => 'Permintaan Barang',
            'breadcrumb_path' => "Preorder / Daftar Permintaan / Filter / $displayDate",
            'page' => 'pages/preorder/index',
            'permintaans' => $filtered,
            'totalPermintaan' => count($filtered),
            'currentPage' => 1,
            'filter_date' => $filter_date,
        ];

        return $this->view($data);
    }

    /**
     * Reset filter tanggal permintaan
     */
    public function reset_filter()
    {
        $this->session->unset_userdata('preorder_filter_date');
        redirect(base_url('preorder'));
    }

    /**
     * Halaman form buat permintaan baru (Staff only)
     */
    public function create()
    {
        // Hanya staff yang boleh membuat permintaan
        if ($this->session->userdata('role') != 'staff') {
            $this->session->set_flashdata('error', 'Hanya Staff yang dapat membuat permintaan barang');
            return redirect('preorder');
        }

        // Dapatkan gudang staff yang login (null jika staff memiliki akses semua gudang)
        $user_gudang_id = getUserGudangId();
        $user_gudang = null;
        if ($user_gudang_id) {
            $user_gudang = $this->db->where('id', $user_gudang_id)->get('gudang')->row();
        }

        $data = [
            'title' => 'Buat Permintaan Barang',
            'breadcrumb_title' => 'Permintaan Barang',
            'breadcrumb_path' => 'Preorder / Buat Permintaan',
            'page' => 'pages/preorder/create',
            'warehouses' => $this->gudangModel->getAllWarehouses(),
            'user_gudang' => $user_gudang
        ];

        return $this->view($data);
    }

    /**
     * Simpan permintaan baru
     */
    public function store()
    {
        // Hanya staff yang boleh membuat permintaan
        if ($this->session->userdata('role') != 'staff') {
            $this->session->set_flashdata('error', 'Hanya Staff yang dapat membuat permintaan barang');
            return redirect('preorder');
        }

        // Dapatkan gudang staff sebagai gudang tujuan
        $user_gudang_id = getUserGudangId();

        $this->form_validation->set_rules('tanggal_permintaan', 'Tanggal Permintaan', 'required');
        $this->form_validation->set_rules('id_gudang_asal', 'Gudang Asal', 'required|numeric');
        $this->form_validation->set_rules('id_gudang_tujuan', 'Gudang Tujuan', 'required|numeric');
        $this->form_validation->set_rules('id_barang[]', 'Barang', 'required');
        $this->form_validation->set_rules('qty[]', 'Qty', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('preorder/create');
        }

        $id_gudang_asal = $this->input->post('id_gudang_asal');
        $id_gudang_tujuan = $this->input->post('id_gudang_tujuan');

        // Validasi gudang asal tidak boleh sama dengan gudang tujuan
        if ($id_gudang_asal == $id_gudang_tujuan) {
            $this->session->set_flashdata('error', 'Gudang sumber tidak boleh sama dengan gudang tujuan');
            return redirect('preorder/create');
        }

        $id_barangs = $this->input->post('id_barang');
        $qtys = $this->input->post('qty');
        $keterangans = $this->input->post('keterangan_barang');

        $items = [];
        for ($i = 0; $i < count($id_barangs); $i++) {
            if (empty($id_barangs[$i]) || empty($qtys[$i]))
                continue;

            $items[] = [
                'id_barang' => $id_barangs[$i],
                'qty' => $qtys[$i],
                'keterangan' => isset($keterangans[$i]) ? $keterangans[$i] : null
            ];
        }

        if (empty($items)) {
            $this->session->set_flashdata('error', 'Pilih minimal satu barang untuk diminta');
            return redirect('preorder/create');
        }

        $data = [
            'kode_permintaan' => $this->preorderModel->generateKode(),
            'id_user' => $this->session->userdata('id_user'),
            'id_gudang_asal' => $id_gudang_asal,
            'id_gudang_tujuan' => $id_gudang_tujuan,
            'tanggal_permintaan' => $this->input->post('tanggal_permintaan'),
            'keterangan' => $this->input->post('keterangan'),
            'status' => 'menunggu'
        ];

        $result = $this->preorderModel->createPermintaan($data, $items);

        if ($result) {
            $this->session->set_flashdata('success', 'Permintaan barang berhasil dibuat');
            return redirect('preorder/detail/' . $result);
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat permintaan barang');
            return redirect('preorder/create');
        }
    }

    /**
     * Halaman detail permintaan
     */
    public function detail($id)
    {
        $permintaan = $this->preorderModel->getPermintaanById($id);

        if (!$permintaan) {
            $this->session->set_flashdata('error', 'Data permintaan tidak ditemukan');
            return redirect('preorder');
        }

        // Cek surat jalan jika ada
        $surat_jalan = $this->suratJalanModel->getSuratJalanByPermintaan($id);
        $surat_jalan_details = null;
        $verifikasi_details = null;
        if ($surat_jalan) {
            $surat_jalan_details = $this->suratJalanModel->getSuratJalanDetails($surat_jalan->id);
            // Ambil hasil verifikasi jika status belum_selesai atau selesai
            if (in_array($permintaan->status, ['belum_selesai', 'selesai'])) {
                $verifikasi_details = $this->suratJalanModel->getSuratJalanDetailsWithVerifikasi($surat_jalan->id);
            }
        }

        $data = [
            'title' => 'Detail Permintaan - ' . $permintaan->kode_permintaan,
            'breadcrumb_title' => 'Detail Permintaan',
            'breadcrumb_path' => 'Preorder / Detail / ' . $permintaan->kode_permintaan,
            'page' => 'pages/preorder/detail',
            'permintaan' => $permintaan,
            'details' => $this->preorderModel->getPermintaanDetails($id),
            'surat_jalan' => $surat_jalan,
            'surat_jalan_details' => $surat_jalan_details,
            'verifikasi_details' => $verifikasi_details
        ];

        return $this->view($data);
    }

    /**
     * Approve permintaan (target/source project admin or super-admin)
     */
    public function approve($id)
    {
        $permintaan = $this->preorderModel->getPermintaanById($id);
        if (!$permintaan || $permintaan->status != 'menunggu') {
            $this->session->set_flashdata('error', 'Permintaan tidak valid atau sudah diproses');
            return redirect('preorder');
        }

        if (!$this->canManageSourceWarehouse($permintaan)) {
            $this->session->set_flashdata('error', 'Hanya Project Admin gudang sumber yang dapat menyetujui permintaan ini');
            return redirect('preorder/detail/' . $id);
        }

        $this->preorderModel->updateStatus($id, 'disetujui');
        $this->session->set_flashdata('success', 'Permintaan berhasil disetujui');
        return redirect('preorder/detail/' . $id);
    }

    /**
     * Reject permintaan (target/source project admin or super-admin)
     */
    public function reject($id)
    {
        $permintaan = $this->preorderModel->getPermintaanById($id);
        if (!$permintaan || $permintaan->status != 'menunggu') {
            $this->session->set_flashdata('error', 'Permintaan tidak valid atau sudah diproses');
            return redirect('preorder');
        }

        if (!$this->canManageSourceWarehouse($permintaan)) {
            $this->session->set_flashdata('error', 'Hanya Project Admin gudang sumber yang dapat menolak permintaan ini');
            return redirect('preorder/detail/' . $id);
        }

        $alasan = $this->input->post('alasan_tolak');
        $this->preorderModel->updateStatus($id, 'ditolak', $alasan);
        $this->session->set_flashdata('success', 'Permintaan telah ditolak');
        return redirect('preorder/detail/' . $id);
    }

    /**
     * Halaman form buat surat jalan (target/source project admin or super-admin)
     */
    public function surat_jalan($id)
    {
        $permintaan = $this->preorderModel->getPermintaanById($id);

        if (!$permintaan || $permintaan->status != 'disetujui') {
            $this->session->set_flashdata('error', 'Permintaan tidak valid atau belum disetujui');
            return redirect('preorder');
        }

        if (!$this->canManageSourceWarehouse($permintaan)) {
            $this->session->set_flashdata('error', 'Hanya Project Admin gudang sumber yang dapat membuat surat jalan');
            return redirect('preorder/detail/' . $id);
        }

        $data = [
            'title' => 'Buat Surat Jalan - ' . $permintaan->kode_permintaan,
            'breadcrumb_title' => 'Buat Surat Jalan',
            'breadcrumb_path' => 'Preorder / Surat Jalan / ' . $permintaan->kode_permintaan,
            'page' => 'pages/preorder/surat_jalan',
            'permintaan' => $permintaan,
            'details' => $this->preorderModel->getPermintaanDetails($id)
        ];

        return $this->view($data);
    }

    /**
     * Simpan surat jalan
     */
    public function store_surat_jalan($id)
    {
        $permintaan = $this->preorderModel->getPermintaanById($id);

        if (!$permintaan || $permintaan->status != 'disetujui') {
            $this->session->set_flashdata('error', 'Permintaan tidak valid');
            return redirect('preorder');
        }

        if (!$this->canManageSourceWarehouse($permintaan)) {
            $this->session->set_flashdata('error', 'Hanya Project Admin gudang sumber yang dapat membuat surat jalan');
            return redirect('preorder/detail/' . $id);
        }

        $this->form_validation->set_rules('nomor_pengiriman', 'Nomor Pengiriman', 'required');
        $this->form_validation->set_rules('tanggal_pengiriman', 'Tanggal Pengiriman', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('preorder/surat_jalan/' . $id);
        }

        $id_barangs = $this->input->post('id_barang');
        $qtys = $this->input->post('qty');
        $keterangans = $this->input->post('keterangan_barang');

        $items = [];
        for ($i = 0; $i < count($id_barangs); $i++) {
            $items[] = [
                'id_barang' => $id_barangs[$i],
                'qty' => $qtys[$i],
                'keterangan' => isset($keterangans[$i]) ? $keterangans[$i] : null
            ];
        }

        $foto = null;
        if (!empty($_FILES['foto_surat_jalan']['name'])) {
            $upload_path = './uploads/surat_jalan/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('foto_surat_jalan')) {
                $foto = 'uploads/surat_jalan/' . $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                return redirect('preorder/surat_jalan/' . $id);
            }
        }

        $data = [
            'id_permintaan'    => $id,
            'nomor_pengiriman' => $this->input->post('nomor_pengiriman'),
            'tanggal_pengiriman' => $this->input->post('tanggal_pengiriman'),
            'foto'             => $foto
        ];

        $result = $this->suratJalanModel->createSuratJalan($data, $items);

        if ($result) {
            // Update status permintaan
            $this->preorderModel->updateStatus($id, 'surat_jalan');
            $this->session->set_flashdata('success', 'Surat jalan berhasil dibuat');
            return redirect('preorder/detail/' . $id);
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat surat jalan');
            return redirect('preorder/surat_jalan/' . $id);
        }
    }

    /**
     * Halaman cetak surat jalan
     */
    public function print_surat_jalan($id)
    {
        $permintaan = $this->preorderModel->getPermintaanById($id);

        if (!$permintaan) {
            $this->session->set_flashdata('error', 'Data permintaan tidak ditemukan');
            return redirect('preorder');
        }

        $surat_jalan = $this->suratJalanModel->getSuratJalanByPermintaan($id);
        if (!$surat_jalan) {
            $this->session->set_flashdata('error', 'Surat jalan belum dibuat');
            return redirect('preorder/detail/' . $id);
        }

        $data = [
            'title' => 'Cetak Surat Jalan - ' . $surat_jalan->nomor_pengiriman,
            'breadcrumb_title' => 'Cetak Surat Jalan',
            'breadcrumb_path' => 'Preorder / Cetak Surat Jalan',
            'page' => 'pages/preorder/print_surat_jalan',
            'permintaan' => $permintaan,
            'surat_jalan' => $surat_jalan,
            'details' => $this->suratJalanModel->getSuratJalanDetails($surat_jalan->id)
        ];

        return $this->view($data);
    }

    /**
     * Tandai sedang dikirim (target/source project admin or super-admin)
     */
    public function kirim($id)
    {
        $permintaan = $this->preorderModel->getPermintaanById($id);
        if (!$permintaan || $permintaan->status != 'surat_jalan') {
            $this->session->set_flashdata('error', 'Permintaan tidak valid');
            return redirect('preorder');
        }

        if (!$this->canManageSourceWarehouse($permintaan)) {
            $this->session->set_flashdata('error', 'Hanya Project Admin gudang sumber yang dapat menandai pengiriman');
            return redirect('preorder/detail/' . $id);
        }

        $this->preorderModel->updateStatus($id, 'dikirim');
        $this->session->set_flashdata('success', 'Status berhasil diubah menjadi "Sedang Dikirim"');
        return redirect('preorder/detail/' . $id);
    }

    /**
     * Halaman form verifikasi penerimaan (requesting project admin or super-admin)
     */
    public function verifikasi($id)
    {
        $permintaan = $this->preorderModel->getPermintaanById($id);

        if (!$permintaan || $permintaan->status != 'dikirim') {
            $this->session->set_flashdata('error', 'Permintaan tidak valid atau belum dikirim');
            return redirect('preorder');
        }

        if (!$this->canVerifyAsRequester($permintaan)) {
            $this->session->set_flashdata('error', 'Hanya Project Admin gudang tujuan yang dapat melakukan verifikasi penerimaan');
            return redirect('preorder/detail/' . $id);
        }

        $surat_jalan = $this->suratJalanModel->getSuratJalanByPermintaan($id);
        $surat_jalan_details = $this->suratJalanModel->getSuratJalanDetails($surat_jalan->id);

        $data = [
            'title' => 'Verifikasi Penerimaan - ' . $permintaan->kode_permintaan,
            'breadcrumb_title' => 'Verifikasi Penerimaan',
            'breadcrumb_path' => 'Preorder / Verifikasi / ' . $permintaan->kode_permintaan,
            'page' => 'pages/preorder/verifikasi',
            'permintaan' => $permintaan,
            'surat_jalan' => $surat_jalan,
            'details' => $surat_jalan_details
        ];

        return $this->view($data);
    }

    /**
     * Proses verifikasi penerimaan + update stok (requesting project admin or super-admin)
     */
    public function store_verifikasi($id)
    {
        $permintaan = $this->preorderModel->getPermintaanById($id);

        if (!$permintaan || $permintaan->status != 'dikirim') {
            $this->session->set_flashdata('error', 'Permintaan tidak valid');
            return redirect('preorder');
        }

        if (!$this->canVerifyAsRequester($permintaan)) {
            $this->session->set_flashdata('error', 'Hanya Project Admin gudang tujuan yang dapat melakukan verifikasi penerimaan');
            return redirect('preorder/detail/' . $id);
        }

        $surat_jalan = $this->suratJalanModel->getSuratJalanByPermintaan($id);
        $surat_jalan_details = $this->suratJalanModel->getSuratJalanDetails($surat_jalan->id);

        $barang_sesuai = $this->input->post('barang_sesuai'); // array of id_barang that are checked
        $keterangan_verifikasi = $this->input->post('keterangan_verifikasi'); // array keyed by id_barang
        $qty_diterima_input = $this->input->post('qty_diterima'); // array keyed by id_barang

        if (!is_array($barang_sesuai)) {
            $barang_sesuai = [];
        }
        if (!is_array($keterangan_verifikasi)) {
            $keterangan_verifikasi = [];
        }
        if (!is_array($qty_diterima_input)) {
            $qty_diterima_input = [];
        }

        $semua_sesuai = true;
        $this->db->trans_start();

        foreach ($surat_jalan_details as $item) {
            $is_sesuai = in_array($item->id_barang, $barang_sesuai) ? 1 : 0;
            $ket = isset($keterangan_verifikasi[$item->id_barang]) ? $keterangan_verifikasi[$item->id_barang] : null;

            if ($is_sesuai) {
                // Barang sesuai: transfer full qty, qty_diterima = qty surat jalan
                $qty_terima = $item->qty;

                $this->stokGudangModel->updateStok(
                    $permintaan->id_gudang_asal,
                    $item->id_barang,
                    $qty_terima,
                    'subtract'
                );
                $this->stokGudangModel->updateStok(
                    $permintaan->id_gudang_tujuan,
                    $item->id_barang,
                    $qty_terima,
                    'add'
                );
            } else {
                // Barang tidak sesuai: transfer partial qty based on qty_diterima
                $semua_sesuai = false;
                $qty_terima = isset($qty_diterima_input[$item->id_barang]) ? (int) $qty_diterima_input[$item->id_barang] : 0;

                // Validasi: qty_diterima tidak boleh melebihi qty surat jalan
                if ($qty_terima > $item->qty) {
                    $qty_terima = $item->qty;
                }
                if ($qty_terima < 0) {
                    $qty_terima = 0;
                }

                // Transfer stok jika qty_diterima > 0
                if ($qty_terima > 0) {
                    $this->stokGudangModel->updateStok(
                        $permintaan->id_gudang_asal,
                        $item->id_barang,
                        $qty_terima,
                        'subtract'
                    );
                    $this->stokGudangModel->updateStok(
                        $permintaan->id_gudang_tujuan,
                        $item->id_barang,
                        $qty_terima,
                        'add'
                    );
                }
            }

            // Simpan hasil verifikasi ke surat_jalan_detail
            $this->suratJalanModel->updateVerifikasi(
                $surat_jalan->id,
                $item->id_barang,
                $is_sesuai,
                $ket,
                $qty_terima
            );
        }

        // Update status
        if ($semua_sesuai) {
            $this->preorderModel->updateStatus($id, 'selesai');
            $this->session->set_flashdata('success', 'Semua barang sesuai. Permintaan selesai dan stok telah diperbarui.');
        } else {
            $this->preorderModel->updateStatus($id, 'belum_selesai');
            $this->session->set_flashdata('warning', 'Beberapa barang tidak sesuai. Status permintaan diubah menjadi "Belum Selesai". Stok hanya diperbarui untuk barang yang sesuai.');
        }

        $this->db->trans_complete();

        return redirect('preorder/detail/' . $id);
    }

    /**
     * Hapus permintaan (admin or requester pre-approval)
     */
    public function delete($id)
    {
        $permintaan = $this->preorderModel->getPermintaanById($id);
        if (!$permintaan) {
            $this->session->set_flashdata('error', 'Data permintaan tidak ditemukan');
            return redirect('preorder');
        }

        $role = $this->session->userdata('role');
        $userId = $this->session->userdata('id_user');
        $isAdmin = ($role == 'admin');
        $isRequesterPreApproval = ($permintaan->id_user == $userId && $permintaan->status == 'menunggu');

        if (!$isAdmin && !$isRequesterPreApproval) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus permintaan ini');
            return redirect('preorder');
        }

        $result = $this->preorderModel->deletePermintaan($id);

        if ($result) {
            $this->session->set_flashdata('success', 'Data permintaan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data permintaan');
        }

        return redirect('preorder');
    }

    /**
     * Cetak laporan hasil verifikasi (barang tidak sesuai)
     */
    public function print_verifikasi($id)
    {
        $permintaan = $this->preorderModel->getPermintaanById($id);

        if (!$permintaan || !in_array($permintaan->status, ['belum_selesai', 'selesai'])) {
            $this->session->set_flashdata('error', 'Data tidak valid atau verifikasi belum dilakukan');
            return redirect('preorder');
        }

        $surat_jalan = $this->suratJalanModel->getSuratJalanByPermintaan($id);
        $verifikasi_details = $this->suratJalanModel->getSuratJalanDetailsWithVerifikasi($surat_jalan->id);

        $data = [
            'title' => 'Laporan Verifikasi - ' . $permintaan->kode_permintaan,
            'breadcrumb_title' => 'Laporan Verifikasi',
            'breadcrumb_path' => 'Preorder / Laporan Verifikasi',
            'page' => 'pages/preorder/print_verifikasi',
            'permintaan' => $permintaan,
            'surat_jalan' => $surat_jalan,
            'details' => $verifikasi_details
        ];

        return $this->view($data);
    }

    /**
     * Returns true if the current user can manage the source/target warehouse of a preorder.
     * This covers approve, reject, surat_jalan, and kirim actions.
     * Granted to: super-admin (all warehouses) or the staff assigned to id_gudang_asal.
     */
    private function canManageSourceWarehouse($permintaan)
    {
        $role = $this->session->userdata('role');
        if ($role == 'admin') {
            return true;
        }
        if ($role == 'staff') {
            return getUserGudangId() == $permintaan->id_gudang_asal;
        }
        return false;
    }

    /**
     * Returns true if the current user can verify receipt for a preorder.
     * This covers verifikasi and store_verifikasi actions.
     * Granted to: super-admin (all warehouses) or the staff assigned to id_gudang_tujuan.
     */
    private function canVerifyAsRequester($permintaan)
    {
        $role = $this->session->userdata('role');
        if ($role == 'admin') {
            return true;
        }
        if ($role == 'staff') {
            return getUserGudangId() == $permintaan->id_gudang_tujuan;
        }
        return false;
    }

    /**
     * API: Ambil stok barang berdasarkan gudang (untuk form create)
     */
    public function getStokByGudang($id_gudang)
    {
        $stok = $this->db->select([
            'stok_gudang.id_barang',
            'stok_gudang.qty',
            'barang.nama AS nama_barang',
            'satuan.nama AS nama_satuan'
        ])
            ->from('stok_gudang')
            ->join('barang', 'stok_gudang.id_barang = barang.id', 'left')
            ->join('satuan', 'barang.id_satuan = satuan.id', 'left')
            ->where('stok_gudang.id_gudang', $id_gudang)
            ->where('stok_gudang.qty >', 0)
            ->order_by('barang.nama', 'ASC')
            ->get()
            ->result();

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'data' => $stok]);
    }
}

/* End of file Preorder.php */
