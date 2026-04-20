<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchaserequest extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_login')) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }

        $this->load->model('Purchaserequest_model', 'prModel');
        $this->load->model('Gudang_model', 'gudangModel');
        $this->load->model('Stokgudang_model', 'stokGudangModel');
        $this->load->library('form_validation');
    }

    /**
     * Daftar Purchase Request
     * Staff (Project Admin) hanya melihat PR milik gudangnya sendiri.
     */
    public function index()
    {
        $currentPage = $this->input->get('page') ?? 1;

        $id_gudang = $this->session->userdata('role') === 'staff'
            ? getUserGudangId()
            : null;

        $data = [
            'title' => 'Daftar Purchase Request',
            'breadcrumb_title' => 'Purchase Request',
            'breadcrumb_path' => 'Purchase Request / Daftar',
            'page' => 'pages/purchaserequest/index',
            'prs' => $this->prModel->getAllPR($currentPage, $id_gudang),
            'totalPR' => $this->prModel->countPR($id_gudang),
            'currentPage' => (int) $currentPage,
        ];

        return $this->view($data);
    }

    /**
     * Form buat PR baru (Project Admin only)
     */
    public function create()
    {
        if ($this->session->userdata('role') != 'staff') {
            $this->session->set_flashdata('error', 'Hanya Project Admin yang dapat membuat Purchase Request');
            return redirect('purchaserequest');
        }

        $data = [
            'title' => 'Buat Purchase Request',
            'breadcrumb_title' => 'Purchase Request',
            'breadcrumb_path' => 'Purchase Request / Buat',
            'page' => 'pages/purchaserequest/create',
            'warehouses' => $this->gudangModel->getAllWarehouses(),
            'items' => $this->db->select('barang.id, barang.nama, satuan.nama AS nama_satuan')
                ->from('barang')
                ->join('satuan', 'barang.id_satuan = satuan.id', 'left')
                ->order_by('barang.nama', 'ASC')
                ->get()
                ->result(),
            'units' => getUnits(),
        ];

        return $this->view($data);
    }

    /**
     * Simpan PR baru
     */
    public function store()
    {
        if ($this->session->userdata('role') != 'staff') {
            $this->session->set_flashdata('error', 'Hanya Project Admin yang dapat membuat Purchase Request');
            return redirect('purchaserequest');
        }

        $this->form_validation->set_rules('tanggal_pr', 'Tanggal PR', 'required');
        $this->form_validation->set_rules('id_gudang', 'Gudang Tujuan', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('purchaserequest/create');
        }

        // Handle optional PR image upload (JPG/PNG)
        $foto_pr = null;
        if (!empty($_FILES['foto_pr']['name'])) {
            $upload_path = FCPATH . 'uploads/purchaserequests/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }
            $this->load->library('upload', [
                'upload_path'   => $upload_path,
                'allowed_types' => 'jpg|jpeg|png',
                'max_size'      => 2048, // 2 MB
                'encrypt_name'  => true,
            ]);
            if ($this->upload->do_upload('foto_pr')) {
                $foto_pr = 'uploads/purchaserequests/' . $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengunggah foto PR: ' . $this->upload->display_errors('', ''));
                return redirect('purchaserequest/create');
            }
        }

        $id_barangs = $this->input->post('id_barang') ?: [];
        $qtys = $this->input->post('qty') ?: [];
        $keterangans = $this->input->post('keterangan_barang') ?: [];

        $items = [];
        for ($i = 0; $i < count($id_barangs); $i++) {
            if (empty($id_barangs[$i]) || empty($qtys[$i])) {
                continue;
            }
            $items[] = [
                'id_barang' => $id_barangs[$i],
                'qty' => (int) $qtys[$i],
                'keterangan' => isset($keterangans[$i]) ? $keterangans[$i] : null
            ];
        }

        // Item manual (di luar katalog barang)
        $manual_namas = $this->input->post('manual_nama') ?: [];
        $manual_satuans = $this->input->post('manual_id_satuan') ?: [];
        $manual_qtys = $this->input->post('manual_qty') ?: [];
        $manual_keterangans = $this->input->post('manual_keterangan') ?: [];

        for ($i = 0; $i < count($manual_namas); $i++) {
            $nama = trim((string) $manual_namas[$i]);
            $qty = (int) ($manual_qtys[$i] ?? 0);
            if ($nama === '' || $qty <= 0) {
                continue;
            }
            $id_satuan = !empty($manual_satuans[$i]) ? (int) $manual_satuans[$i] : null;
            $items[] = [
                'id_barang' => null,
                'nama_barang_manual' => $nama,
                'id_satuan_manual' => $id_satuan,
                'qty' => $qty,
                'keterangan' => isset($manual_keterangans[$i]) ? $manual_keterangans[$i] : null
            ];
        }

        if (empty($items)) {
            $this->session->set_flashdata('error', 'Tambahkan minimal satu barang ke Purchase Request');
            return redirect('purchaserequest/create');
        }

        $data = [
            'kode_pr' => $this->prModel->generateKode(),
            'id_user' => $this->session->userdata('id_user'),
            'id_gudang' => $this->input->post('id_gudang'),
            'tanggal_pr' => $this->input->post('tanggal_pr'),
            'keterangan' => $this->input->post('keterangan'),
            'foto_pr' => $foto_pr,
            'status' => 'menunggu'
        ];

        $result = $this->prModel->createPR($data, $items);

        if ($result) {
            $this->session->set_flashdata('success', 'Purchase Request berhasil dibuat');
            return redirect('purchaserequest/detail/' . $result);
        }

        $this->session->set_flashdata('error', 'Gagal membuat Purchase Request');
        return redirect('purchaserequest/create');
    }

    /**
     * Detail PR
     */
    public function detail($id)
    {
        $pr = $this->prModel->getPRById($id);
        if (!$pr) {
            $this->session->set_flashdata('error', 'Data Purchase Request tidak ditemukan');
            return redirect('purchaserequest');
        }

        if ($this->session->userdata('role') === 'staff'
            && $pr->id_gudang != getUserGudangId()) {
            $this->session->set_flashdata('error', 'Anda hanya dapat mengakses PR gudang Anda sendiri');
            return redirect('purchaserequest');
        }

        $data = [
            'title' => 'Detail PR - ' . $pr->kode_pr,
            'breadcrumb_title' => 'Detail Purchase Request',
            'breadcrumb_path' => 'Purchase Request / Detail / ' . $pr->kode_pr,
            'page' => 'pages/purchaserequest/detail',
            'pr' => $pr,
            'details' => $this->prModel->getPRDetails($id),
            'progress' => $this->prModel->getVerifikasiProgress($id),
            'surat_jalan_list' => $this->prModel->getSuratJalanList($id),
        ];

        return $this->view($data);
    }

    /**
     * Accept PR (Purchasing Admin only) — langsung jadi "diproses"
     */
    public function accept($id)
    {
        if ($this->session->userdata('role') != 'purchasing_admin') {
            $this->session->set_flashdata('error', 'Hanya Purchasing Admin yang dapat menyetujui PR');
            return redirect('purchaserequest');
        }

        $pr = $this->prModel->getPRById($id);
        if (!$pr || $pr->status != 'menunggu') {
            $this->session->set_flashdata('error', 'PR tidak valid atau sudah diproses');
            return redirect('purchaserequest');
        }

        $this->prModel->updateStatus($id, 'diproses', [
            'id_user_respon' => $this->session->userdata('id_user'),
            'tanggal_respon' => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Purchase Request disetujui dan berstatus "Diproses".');
        return redirect('purchaserequest/detail/' . $id);
    }

    /**
     * Reject PR (Purchasing Admin only)
     */
    public function reject($id)
    {
        if ($this->session->userdata('role') != 'purchasing_admin') {
            $this->session->set_flashdata('error', 'Hanya Purchasing Admin yang dapat menolak PR');
            return redirect('purchaserequest');
        }

        $pr = $this->prModel->getPRById($id);
        if (!$pr || $pr->status != 'menunggu') {
            $this->session->set_flashdata('error', 'PR tidak valid atau sudah diproses');
            return redirect('purchaserequest');
        }

        $alasan = trim($this->input->post('alasan_tolak'));
        if (empty($alasan)) {
            $this->session->set_flashdata('error', 'Alasan penolakan wajib diisi');
            return redirect('purchaserequest/detail/' . $id);
        }

        $this->prModel->updateStatus($id, 'ditolak', [
            'alasan_tolak' => $alasan,
            'id_user_respon' => $this->session->userdata('id_user'),
            'tanggal_respon' => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Purchase Request telah ditolak');
        return redirect('purchaserequest/detail/' . $id);
    }

    /**
     * Form verifikasi per item (Project Admin)
     */
    public function verifikasi($id)
    {
        if ($this->session->userdata('role') != 'staff') {
            $this->session->set_flashdata('error', 'Hanya Project Admin yang dapat memverifikasi barang');
            return redirect('purchaserequest/detail/' . $id);
        }

        $pr = $this->prModel->getPRById($id);
        if (!$pr || !in_array($pr->status, ['diproses', 'belum_selesai'])) {
            $this->session->set_flashdata('error', 'PR tidak valid atau belum disetujui');
            return redirect('purchaserequest/detail/' . $id);
        }

        if ($pr->id_gudang != getUserGudangId()) {
            $this->session->set_flashdata('error', 'Anda hanya dapat memverifikasi PR gudang Anda sendiri');
            return redirect('purchaserequest');
        }

        $data = [
            'title' => 'Verifikasi Barang - ' . $pr->kode_pr,
            'breadcrumb_title' => 'Verifikasi Barang',
            'breadcrumb_path' => 'Purchase Request / Verifikasi / ' . $pr->kode_pr,
            'page' => 'pages/purchaserequest/verifikasi',
            'pr' => $pr,
            'details' => $this->prModel->getPRDetails($id),
            'surat_jalan_list' => $this->prModel->getSuratJalanList($id),
        ];

        return $this->view($data);
    }

    /**
     * Proses verifikasi per item + update stok gudang
     * Item yang sudah "Barang Sesuai" tidak diverifikasi ulang di sini.
     */
    public function store_verifikasi($id)
    {
        if ($this->session->userdata('role') != 'staff') {
            $this->session->set_flashdata('error', 'Hanya Project Admin yang dapat memverifikasi barang');
            return redirect('purchaserequest/detail/' . $id);
        }

        $pr = $this->prModel->getPRById($id);
        if (!$pr || !in_array($pr->status, ['diproses', 'belum_selesai'])) {
            $this->session->set_flashdata('error', 'PR tidak valid');
            return redirect('purchaserequest');
        }

        if ($pr->id_gudang != getUserGudangId()) {
            $this->session->set_flashdata('error', 'Anda hanya dapat memverifikasi PR gudang Anda sendiri');
            return redirect('purchaserequest');
        }

        $details = $this->prModel->getPRDetails($id);

        // Handle optional Surat Jalan PDF upload — append to list, never overwrite
        $new_surat_jalan = null; // ['nama_file' => ..., 'file_path' => ...]
        if (!empty($_FILES['file_surat_jalan']['name'])) {
            $upload_path = FCPATH . 'uploads/surat_jalan/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }
            $this->load->library('upload', [
                'upload_path'   => $upload_path,
                'allowed_types' => 'pdf',
                'max_size'      => 10240, // 10 MB
                'overwrite'     => false, // keep original name; CI appends counter on collision
                'encrypt_name'  => false,
            ]);
            if ($this->upload->do_upload('file_surat_jalan')) {
                $upload_data = $this->upload->data();
                $new_surat_jalan = [
                    'nama_file' => $upload_data['orig_name'],   // original filename from uploader
                    'file_path' => 'uploads/surat_jalan/' . $upload_data['file_name'],
                ];
            } else {
                $this->session->set_flashdata('error', 'Gagal mengunggah Surat Jalan: ' . $this->upload->display_errors('', ''));
                return redirect('purchaserequest/verifikasi/' . $id);
            }
        }

        $sesuai_ids = $this->input->post('barang_sesuai') ?: [];
        $keterangan_input = $this->input->post('keterangan_verifikasi') ?: [];
        $qty_diterima_input = $this->input->post('qty_diterima') ?: [];
        if (!is_array($sesuai_ids)) $sesuai_ids = [];
        if (!is_array($keterangan_input)) $keterangan_input = [];
        if (!is_array($qty_diterima_input)) $qty_diterima_input = [];

        $this->db->trans_start();

        foreach ($details as $item) {
            // Item yang sudah Barang Sesuai tidak diproses ulang (hindari double-add stok)
            if ((int) $item->is_sesuai === 1) continue;

            $qty_req = (int) $item->qty;
            $is_sesuai = in_array($item->id, $sesuai_ids) ? 1 : 0;
            $ket = isset($keterangan_input[$item->id]) ? $keterangan_input[$item->id] : null;

            if ($is_sesuai) {
                $qty_terima = $qty_req;
            } else {
                $qty_terima = isset($qty_diterima_input[$item->id]) ? (int) $qty_diterima_input[$item->id] : 0;
                if ($qty_terima > $qty_req) $qty_terima = $qty_req;
                if ($qty_terima < 0) $qty_terima = 0;
            }

            // Delta terhadap qty_diterima sebelumnya (untuk kasus re-verifikasi dari belum_selesai)
            $prev = (int) ($item->qty_diterima ?? 0);
            $delta = $qty_terima - $prev;

            // Item manual yang diterima (>0) dipromosikan menjadi barang katalog
            // agar muncul di Daftar Barang dan stok gudang dapat diperbarui.
            $id_barang_stok = $item->id_barang;
            if (empty($id_barang_stok) && $qty_terima > 0 && !empty($item->nama_barang_manual) && !empty($item->id_satuan_manual)) {
                $new_id = $this->prModel->promoteManualToItem(
                    $item->id,
                    $item->nama_barang_manual,
                    (int) $item->id_satuan_manual
                );
                if ($new_id) {
                    $id_barang_stok = $new_id;
                }
            }

            if ($delta != 0 && !empty($id_barang_stok)) {
                $operasi = $delta > 0 ? 'add' : 'subtract';
                $this->stokGudangModel->updateStok(
                    $pr->id_gudang,
                    $id_barang_stok,
                    abs($delta),
                    $operasi
                );

                // Keep barang.qty (global aggregate) in sync.
                // The DB triggers only fire on barang_masuk/keluar_detail inserts,
                // which this flow never touches, so we update directly here.
                $qty_expr = $delta > 0
                    ? 'qty + ' . abs($delta)
                    : 'GREATEST(0, qty - ' . abs($delta) . ')';
                $this->db->set('qty', $qty_expr, FALSE)
                         ->where('id', $id_barang_stok)
                         ->update('barang');
            }

            $this->prModel->updateItemVerifikasi(
                $item->id,
                $is_sesuai,
                $qty_terima,
                $is_sesuai ? null : $ket
            );
        }

        // Hitung ulang status PR dari seluruh item
        $progress = $this->prModel->getVerifikasiProgress($id);
        $new_status = ($progress['belum_sesuai'] === 0 && $progress['belum_diverifikasi'] === 0)
            ? 'selesai'
            : 'belum_selesai';

        $this->prModel->updateStatus($id, $new_status);

        if ($new_surat_jalan !== null) {
            $this->prModel->saveSuratJalan($id, $new_surat_jalan['nama_file'], $new_surat_jalan['file_path']);
        }

        $this->db->trans_complete();

        if ($new_status === 'selesai') {
            $this->session->set_flashdata('success', 'Semua barang sesuai. Stok gudang telah diperbarui.');
        } else {
            $this->session->set_flashdata('warning', 'Sebagian barang belum sesuai. Status PR diubah menjadi "Belum Selesai".');
        }

        return redirect('purchaserequest/detail/' . $id);
    }

    /**
     * Ubah qty item pada PR yang statusnya "Belum Selesai".
     * Jika qty baru == qty_diterima → item menjadi "Barang Sesuai".
     */
    public function update_qty($id_detail)
    {
        if ($this->session->userdata('role') != 'staff') {
            $this->session->set_flashdata('error', 'Hanya Project Admin yang dapat mengubah qty');
            return redirect('purchaserequest');
        }

        $detail = $this->prModel->getDetailById($id_detail);
        if (!$detail) {
            $this->session->set_flashdata('error', 'Item tidak ditemukan');
            return redirect('purchaserequest');
        }

        $pr = $this->prModel->getPRById($detail->id_pr);
        if (!$pr || $pr->status != 'belum_selesai') {
            $this->session->set_flashdata('error', 'Qty hanya dapat diubah saat PR berstatus "Belum Selesai"');
            return redirect('purchaserequest/detail/' . $detail->id_pr);
        }

        if ($pr->id_gudang != getUserGudangId()) {
            $this->session->set_flashdata('error', 'Anda hanya dapat mengubah qty PR gudang Anda sendiri');
            return redirect('purchaserequest');
        }

        if ((int) $detail->is_sesuai === 1) {
            $this->session->set_flashdata('error', 'Item ini sudah berstatus "Barang Sesuai"');
            return redirect('purchaserequest/detail/' . $detail->id_pr);
        }

        $new_qty = (int) $this->input->post('qty');
        $qty_diterima = (int) ($detail->qty_diterima ?? 0);

        if ($new_qty < $qty_diterima) {
            $this->session->set_flashdata('error', 'Qty baru tidak boleh kurang dari qty diterima (' . $qty_diterima . ')');
            return redirect('purchaserequest/detail/' . $detail->id_pr);
        }

        $is_sesuai = ($new_qty === $qty_diterima) ? 1 : 0;
        $this->prModel->updateItemQty($id_detail, $new_qty, $is_sesuai);

        // Refresh status PR berdasarkan seluruh item
        $progress = $this->prModel->getVerifikasiProgress($detail->id_pr);
        $new_status = ($progress['belum_sesuai'] === 0 && $progress['belum_diverifikasi'] === 0)
            ? 'selesai'
            : 'belum_selesai';
        $this->prModel->updateStatus($detail->id_pr, $new_status);

        if ($is_sesuai) {
            $this->session->set_flashdata('success', 'Qty diperbarui. Item kini berstatus "Barang Sesuai".');
        } else {
            $this->session->set_flashdata('warning', 'Qty diperbarui tetapi masih belum sesuai dengan qty diterima.');
        }

        return redirect('purchaserequest/detail/' . $detail->id_pr);
    }

    /**
     * Hapus PR (Project Admin atau Admin, hanya sebelum diproses)
     */
    public function delete($id)
    {
        $role = $this->session->userdata('role');
        if (!in_array($role, ['staff', 'admin'])) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus PR');
            return redirect('purchaserequest');
        }

        $pr = $this->prModel->getPRById($id);
        if (!$pr) {
            $this->session->set_flashdata('error', 'Data PR tidak ditemukan');
            return redirect('purchaserequest');
        }

        if ($role === 'staff' && $pr->id_gudang != getUserGudangId()) {
            $this->session->set_flashdata('error', 'Anda hanya dapat menghapus PR gudang Anda sendiri');
            return redirect('purchaserequest');
        }

        if ($role != 'admin' && !in_array($pr->status, ['menunggu', 'ditolak'])) {
            $this->session->set_flashdata('error', 'PR yang sudah diproses tidak dapat dihapus');
            return redirect('purchaserequest/detail/' . $id);
        }

        if ($this->prModel->deletePR($id)) {
            $this->session->set_flashdata('success', 'Purchase Request berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus Purchase Request');
        }

        return redirect('purchaserequest');
    }
}

/* End of file Purchaserequest.php */
