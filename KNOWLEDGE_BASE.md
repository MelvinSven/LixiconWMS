# Lixicon Warehouse Management System — Knowledge Base

## 1. Overview

Lixicon Warehouse Management System (WMS) adalah aplikasi web untuk mengelola inventori barang di satu atau banyak gudang. Fitur utamanya meliputi pencatatan barang masuk & keluar, pemindahan antar-gudang, permintaan barang (preorder), dan manajemen stok real-time.

**Tech Stack:** PHP (CodeIgniter 3), MySQL, Bootstrap 4, jQuery, Feather Icons, Font Awesome, SweetAlert.

---

## 2. User Roles & Access Control

Terdapat 3 role:

| DB `role` | Persona (PRD) | Deskripsi |
|---|---|---|
| `admin` | Super-admin | Akses penuh ke semua fitur dan semua gudang. Satu-satunya role yang bisa register user baru. |
| `staff` | Project Admin | Buat Purchase Request dan Preorder; operasi barang masuk/keluar/transfer; akses semua gudang (sejak migration `migration_staff_all_warehouses.sql` yang men-set `id_gudang = NULL`). |
| `purchasing_admin` | Purchasing Admin | Kelola Purchase Request → Purchase Order → Goods Receipt. **Tidak** bisa akses barang masuk/keluar/transfer/preorder. |

> **Mapping penting:** `admin` di DB ≠ "Project Admin" di PRD. Ketika PRD menyebut "Project Admin", role DB-nya adalah `staff`.

| Fitur | admin | staff | purchasing_admin |
|-------|:-----:|:-----:|:----------------:|
| Login / Logout | ✅ | ✅ | ✅ |
| Dashboard | ✅ | ✅ | ✅ |
| Register Barang | ✅ | ❌ | ❌ |
| List/Lihat Barang | ✅ | ✅ | ✅ |
| Edit/Hapus Barang | ✅ | ❌ | ❌ |
| Tambah/Edit/Hapus Satuan | ✅ | ❌ | ❌ |
| Tambah/Edit/Hapus Gudang | ✅ | ❌ | ❌ |
| Lihat Gudang & Detail Stok | ✅ | ✅ | ✅ |
| Barang Masuk (Keranjang + Checkout) | ✅ | ✅ | ❌ |
| Barang Keluar (Keranjang + Checkout) | ✅ | ✅ | ❌ |
| Hapus Catatan Masuk/Keluar | ✅ | ❌ | ❌ |
| Transfer/Pemindahan Antar-Gudang | ✅ | ✅ | ❌ |
| Hapus Transfer | ✅ | ❌ | ❌ |
| Update Status Transfer (Sampai) | ✅ / Pembuat | ✅ (pembuat saja) | ❌ |
| Buat Permintaan Barang (Preorder) | ❌ | ✅ | ❌ |
| Approve/Tolak Permintaan (Preorder) | ✅ | ❌ | ❌ |
| Buat Surat Jalan (Preorder) | ✅ | ✅ | ❌ |
| Tandai Kirim (Preorder) | ✅ | ❌ | ❌ |
| Verifikasi Penerimaan (Preorder) | ✅ | ✅ | ❌ |
| Hapus Permintaan (Preorder) | ✅ | ❌ | ❌ |
| Buat Purchase Request (PR) | ❌ | ✅ | ✅ (lihat saja) |
| Accept/Decline PR | ❌ | ❌ | ✅ |
| Buat Purchase Order (PO) | ❌ | ❌ | ✅ |
| Goods Receipt / Verifikasi PR | ❌ | ✅ (pemohon) | ❌ |
| Hapus PR | ✅ (status apapun) | ✅ (menunggu/ditolak) | ❌ |
| Register Staff Baru | ✅ | ❌ | ❌ |
| List/Edit Staff | ✅ | ❌ | ❌ |
| Edit Profil Sendiri | ✅ | ✅ | ✅ |

**Catatan:** `staff` sebelumnya terikat ke satu gudang via `id_gudang`. Sejak `migration_staff_all_warehouses.sql` (2026-04-06), `id_gudang` di-set `NULL` untuk semua staff — artinya staff kini bisa akses semua gudang. Sidebar tetap menyembunyikan menu `purchasing_admin`-only dan sebaliknya.

---

## 3. Authentication

### 3.1 Login (`/login`)
- Form field: **Email** dan **Password**
- Validasi: email harus terdaftar dan password cocok (hashed dengan bcrypt)
- Akun harus berstatus **aktif** untuk bisa login
- Setelah login berhasil, data user disimpan di session (id_user, nama, email, role, id_gudang, dll)
- Jika sudah login, otomatis redirect ke Dashboard

### 3.2 Register Staff (`/register`) — Admin only
- Field: Nama, Email, Password, No. Telepon, No. KTP, Role (admin/staff)
- Validasi: email dan KTP harus unik
- Password di-hash sebelum disimpan

### 3.3 Logout (`/logout`)
- Menghapus semua session data dan redirect ke halaman login

---

## 4. Dashboard (`/home`)

Dashboard menampilkan ringkasan statistik dan aktivitas terbaru:

### 4.1 Statistik Overview (Cards)
- **Total Staff** — jumlah semua user terdaftar
- **Jenis Barang** (yang qty-nya > 0) — barang yang masih tersedia
- **Jumlah Gudang** — total gudang (staff hanya melihat gudang sendiri)
- **Total Stok** — akumulasi qty semua barang
- **Barang Masuk** — jumlah transaksi masuk (hari ini atau tanggal tertentu)
- **Barang Keluar** — jumlah transaksi keluar
- **Total Barang** — jumlah semua jenis barang terdaftar

### 4.2 Filter Tanggal
- User bisa memfilter statistik & aktivitas berdasarkan tanggal tertentu
- Ada tombol reset untuk menghapus filter

### 4.3 Aktivitas Terbaru
- 5 transaksi **Barang Masuk** terbaru (nama staff + waktu)
- 5 transaksi **Barang Keluar** terbaru (nama staff + waktu)

### 4.4 Tabel Permintaan Barang (Preorder)
- **Daftar Permintaan Aktif** — preorder yang sedang berjalan (status: menunggu, disetujui, surat_jalan, dikirim)
- **Riwayat Permintaan** — preorder yang sudah selesai atau ditolak (status: selesai, belum_selesai, ditolak)

---

## 5. Manajemen Barang

### 5.1 Register Barang (`/items/register`) — Admin only
- Mendaftarkan barang baru ke sistem
- Field: **Nama Barang**, **Satuan** (dropdown), **Lokasi** (dropdown), **Gambar** (upload, opsional)
- Field `id_supplier` dan `kode_barang` sudah dihapus dari tabel `barang` (lihat `migration_remove_supplier_from_barang.sql` dan `migration_remove_kode_barang.sql`)
- Gambar disimpan di folder `uploads/items/`, jika tidak diupload menggunakan `default.png`
- Qty awal otomatis 0 (stok ditambah melalui proses barang masuk)

### 5.2 List Barang (`/items`)
- Menampilkan semua barang dengan informasi: Nama, Satuan, Lokasi, Qty, Gambar
- Qty ditampilkan dari `SUM(stok_gudang.qty)` — bukan dari `barang.qty` langsung
- **Paginasi** — data ditampilkan per halaman
- **Pencarian** — cari berdasarkan nama atau satuan
- **Filter** yang tersedia:
  - Berdasarkan **Satuan** — klik link satuan untuk melihat barang dengan satuan tertentu
  - Berdasarkan **Ketersediaan** — available (qty > 0) atau empty (qty = 0)
  - Berdasarkan **Gudang** — melihat stok barang di gudang tertentu

### 5.3 Edit Barang (`/items/update/{id}`) — Admin only
- Ubah nama, satuan, supplier, dan gambar barang
- Gambar lama dihapus jika gambar baru diupload (kecuali jika gambar lama = default.png)

### 5.4 Hapus Barang (`/items/delete/{id}`) — Admin only
- Menghapus barang dari sistem
- Gambar ikut dihapus dari server (kecuali default.png)

---

## 6. Manajemen Satuan (Units)

### 6.1 List Satuan (`/units`)
- Menampilkan semua satuan barang (contoh: Pcs, Item, Mili meter)
- Pencarian berdasarkan nama satuan

### 6.2 Tambah Satuan (`/unit`) — Admin only
- Menambah satuan baru
- Validasi: nama satuan harus unik

### 6.3 Edit Satuan (`/units/edit/{id}`) — Admin only
- Mengubah nama satuan

### 6.4 Hapus Satuan (`/units/delete/{id}`) — Admin only
- Menghapus satuan dari sistem

---

## 7. Manajemen Kategori (Categories)

### 7.1 List Kategori (`/categories`)
- Menampilkan semua kategori barang
- Pencarian berdasarkan nama kategori

### 7.2 Tambah Kategori — Admin only
- Menambah kategori baru via form inline
- Validasi: nama kategori harus unik

### 7.3 Edit Kategori (`/categories/edit/{id}`) — Admin only
- Mengubah nama kategori

### 7.4 Hapus Kategori (`/categories/delete/{id}`) — Admin only
- Menghapus kategori dari sistem

---

## 8. Manajemen Letak Barang (Locations)

### 8.1 List Letak Barang (`/locations`)
- Menampilkan semua lokasi penyimpanan barang di gudang
- Pencarian berdasarkan nama lokasi

### 8.2 Tambah Letak Barang — Admin only
- Menambah lokasi baru
- Validasi: nama lokasi harus unik

### 8.3 Edit Letak Barang (`/locations/edit/{id}`) — Admin only
- Mengubah nama lokasi

### 8.4 Hapus Letak Barang (`/locations/delete/{id}`) — Admin only
- Menghapus lokasi dari sistem

---

## 9. Manajemen Supplier

### 9.1 List Supplier (`/suppliers`)
- Menampilkan semua supplier terdaftar
- Pencarian berdasarkan nama supplier

### 9.2 Tambah Supplier (`/suppliers/add`) — Admin only
- Field: Nama Supplier
- Validasi: nama harus unik

### 9.3 Edit Supplier (`/suppliers/edit/{id}`) — Admin only
- Mengubah data supplier

### 9.4 Hapus Supplier (`/suppliers/delete/{id}`) — Admin only
- Tidak bisa dihapus jika masih digunakan oleh barang (ada proteksi referensi)

---

## 10. Manajemen Gudang (Warehouses)

### 10.1 List Gudang (`/warehouses`)
- Menampilkan semua gudang yang terdaftar
- Staff hanya melihat gudang yang ditugaskan kepadanya
- Pencarian berdasarkan nama atau alamat gudang

### 10.2 Tambah Gudang (`/warehouse/add`) — Admin only
- Field: Nama Gudang, Alamat

### 10.3 Edit Gudang (`/warehouse/update`) — Admin only
- Mengubah nama dan alamat gudang

### 10.4 Hapus Gudang (`/warehouse/delete`) — Admin only
- Tidak bisa dihapus jika masih memiliki stok barang di dalamnya (ada proteksi)

### 10.5 Detail Gudang (`/warehouse/detail/{id}`)
- Menampilkan informasi lengkap gudang dan stok barang di dalamnya
- Statistik: total jenis barang, total qty
- Admin bisa menambah, mengedit qty, dan menghapus stok barang langsung dari halaman ini

---

## 11. Barang Masuk (Inbound)

Proses barang masuk menggunakan pola **keranjang (cart) → checkout**:

### 11.1 Keranjang Masuk (`/cartin`)
- Halaman untuk menambahkan barang yang akan dicatat masuk
- Menampilkan daftar barang yang sudah ditambah ke keranjang beserta qty-nya
- **Pilih gudang** tempat barang akan masuk
- **Click tombol aksi Masuk** untuk barang yang ingin dimasukkan ke keranjang
- **Tambah ke Keranjang** — pilih barang dari tabel, set qty, tambahkan
- **Update Qty** — ubah qty barang yang sudah ada di keranjang
- **Hapus Item** — hapus satu item dari keranjang
- **Kosongkan Keranjang** — hapus semua item dari keranjang
- Keranjang bersifat per-user (menggunakan tabel `keranjang_masuk`)

### 11.2 Checkout
- Menyimpan data pemasukan ke tabel `barang_masuk` (header) dan `barang_masuk_detail` (item)
- Stok barang otomatis bertambah melalui **database trigger** (`tambah_barang`)
- Bisa upload **bukti foto** saat checkout
- Setelah checkout, keranjang dikosongkan

### 11.3 Catatan Masuk (`/inputs`)
- Daftar riwayat semua transaksi barang masuk
- Pencarian berdasarkan ID transaksi atau nama staff
- Pencarian berdasarkan tanggal/waktu
- **Detail Catatan** (`/inputs/detail/{id}`) — lihat detail item yang masuk beserta qty dan bukti foto
- **Hapus Catatan** — Admin only

---

## 12. Barang Keluar (Outbound)

Proses barang keluar juga menggunakan pola **keranjang → checkout**:

### 12.1 Keranjang Keluar (`/cartout`)
- Sama seperti keranjang masuk, tapi untuk barang keluar
- Validasi: qty keluar tidak boleh melebihi stok yang tersedia
- Bisa menambahkan **nama kurir** saat checkout
- Bisa menambahkan **keterangan** (catatan) saat checkout
- Bisa upload **bukti foto**

### 12.2 Checkout
- Menyimpan data pengeluaran ke tabel `barang_keluar` (header) dan `barang_keluar_detail` (item)
- Stok barang otomatis berkurang melalui **database trigger** (`kurangi_barang`)
- Setelah checkout, keranjang dikosongkan

### 12.3 Catatan Keluar (`/outputs`)
- Daftar riwayat semua transaksi barang keluar
- Pencarian berdasarkan ID transaksi atau nama staff
- Pencarian berdasarkan tanggal/waktu
- **Detail Catatan** (`/outputs/detail/{id}`) — lihat detail item keluar, qty, keterangan, bukti foto, kurir, dan status pengiriman
- **Hapus Catatan** — Admin only

### 12.4 Status Pengiriman
- Setiap transaksi barang keluar memiliki status pengiriman: `dikirim` (default) atau `sampai`
- Hanya **pembuat catatan** atau **admin** yang bisa menandai status sebagai "Sampai"
- Tombol "Tandai Sampai" tersedia di halaman detail catatan keluar

---

## 13. Pemindahan Barang Antar-Gudang (Transfer)

### 13.1 Buat Transfer (`/transfer/create`)
- Form untuk membuat pemindahan barang antar-gudang
- Field: **Gudang Asal**, **Gudang Tujuan**, **Daftar Barang** (tambah banyak item), **Nama Kurir** (opsional), **Bukti Foto** (upload, opsional)
- Saat memilih gudang asal, sistem otomatis memuat daftar stok barang yang tersedia di gudang tersebut via API (`/transfer/getStokByGudang/{id}`)
- Validasi: qty transfer tidak boleh melebihi stok yang tersedia
- User bisa menambah banyak item sekaligus dalam satu transfer

### 13.2 Penyimpanan Transfer
- Data disimpan ke tabel `transfer_barang` (header) dan `transfer_barang_detail` (item)
- Stok otomatis dikurangi dari gudang asal dan ditambah ke gudang tujuan saat transfer dibuat
- Status awal: `dikirim`

### 13.3 Riwayat Transfer (`/transfer`)
- Daftar semua transfer yang pernah dilakukan
- Informasi: nomor transfer, gudang asal/tujuan, kurir, waktu, status

### 13.4 Detail Transfer (`/transfer/detail/{id}`)
- Detail lengkap transfer: daftar barang, qty, gudang asal/tujuan, kurir, bukti foto, status

### 13.5 Update Status (`/transfer/update_status/{id}`)
- Mengubah status dari `dikirim` menjadi `sampai`
- Hanya pembuat transfer atau admin yang bisa melakukan ini

### 13.6 Hapus Transfer (`/transfer/delete/{id}`) — Admin only
- Menghapus data transfer

---

## 14. Permintaan Barang / Preorder

Fitur preorder memungkinkan staff di gudang tujuan meminta barang dari gudang pusat (gudang asal). Prosesnya berlangsung dalam beberapa tahap:

### 14.1 Alur Lengkap (Lifecycle)

```
Staff buat permintaan → Admin approve/reject → Buat Surat Jalan → Admin tandai "Kirim" → Staff verifikasi penerimaan → Selesai/Belum Selesai
```

Status permintaan: `menunggu` → `disetujui` → `surat_jalan` → `dikirim` → `selesai` / `belum_selesai` / `ditolak`

### 14.2 Buat Permintaan (`/preorder/create`) — Staff only
- Field: **Gudang Asal** (pilih dari dropdown), **Gudang Tujuan** (otomatis sesuai gudang staff), **Tanggal Diperlukan**, **Keterangan**
- Tambah item: pilih barang dari stok gudang asal, set qty yang diminta
- Stok gudang asal dimuat dinamis via API (`/preorder/getStokByGudang/{id}`)
- Kode permintaan digenerate otomatis: `PB-YYYYMMDD-XXX`

### 14.3 Daftar Permintaan (`/preorder`)
- Menampilkan semua permintaan barang
- Informasi: kode permintaan, pemohon, gudang asal/tujuan, tanggal, status, aksi

### 14.4 Detail Permintaan (`/preorder/detail/{id}`)
- Informasi lengkap permintaan, daftar barang yang diminta, surat jalan (jika ada), dan hasil verifikasi (jika ada)
- Tombol aksi menyesuaikan status:
  - `menunggu` → Approve / Tolak (admin)
  - `disetujui` → Buat Surat Jalan
  - `surat_jalan` → Tandai Kirim (admin)
  - `dikirim` → Verifikasi Penerimaan

### 14.5 Approve Permintaan (`/preorder/approve/{id}`) — Admin only
- Mengubah status dari `menunggu` ke `disetujui`

### 14.6 Tolak Permintaan (`/preorder/reject/{id}`) — Admin only
- Mengubah status menjadi `ditolak`
- Harus menyertakan **alasan penolakan**

### 14.7 Buat Surat Jalan (`/preorder/surat_jalan/{id}`)
- Form untuk membuat surat jalan (delivery order) berdasarkan permintaan yang sudah disetujui
- Field: **Nomor Pengiriman**, **Tanggal Pengiriman**, **Detail Barang** (nama, qty — otomatis dari permintaan)
- Menyimpan ke tabel `surat_jalan` (header) dan `surat_jalan_detail` (item)
- Status permintaan berubah menjadi `surat_jalan`

### 14.8 Cetak Surat Jalan (`/preorder/print_surat_jalan/{id}`)
- Halaman cetak surat jalan dalam format laporan resmi
- Menampilkan info pengiriman, daftar barang, dan tanda tangan

### 14.9 Tandai Kirim (`/preorder/kirim/{id}`) — Admin only
- Mengubah status dari `surat_jalan` menjadi `dikirim`

### 14.10 Verifikasi Penerimaan (`/preorder/verifikasi/{id}`)
- Form verifikasi yang diisi oleh staff penerima setelah barang tiba
- Setiap item ditampilkan dengan:
  - **Checkbox "Sesuai"** — centang jika barang sesuai surat jalan
  - **Input "Qty Diterima"** — muncul saat barang di-uncheck (tidak sesuai), user mengisi jumlah yang benar-benar diterima (min=0, max=qty surat jalan)
  - **Input "Keterangan"** — catatan untuk barang yang tidak sesuai
- Tombol "Centang Semua" dan "Hapus Semua" tersedia

### 14.11 Proses Verifikasi (`/preorder/store_verifikasi/{id}`)
- **Barang sesuai (dicentang):** stok dipindahkan penuh dari gudang asal ke gudang tujuan
- **Barang tidak sesuai (di-uncheck):** stok dipindahkan sebanyak qty_diterima yang diisi
  - Jika qty_diterima = 0 → stok tidak dipindahkan
  - Jika qty_diterima > 0 → stok dipindahkan sebanyak qty_diterima
- Semua data verifikasi disimpan ke `surat_jalan_detail` (kolom: `is_sesuai`, `qty_diterima`, `keterangan_verifikasi`)
- Status akhir:
  - Jika **semua** barang sesuai → `selesai`
  - Jika ada barang **tidak sesuai** → `belum_selesai`

### 14.12 Cetak Laporan Verifikasi (`/preorder/print_verifikasi/{id}`)
- Laporan cetak hasil verifikasi
- Dua tabel: Barang Tidak Sesuai (header merah) dan Barang Sesuai (header hijau)
- Menampilkan Qty Kirim, Qty Diterima, dan keterangan

### 14.13 Hapus Permintaan (`/preorder/delete/{id}`) — Admin only
- Menghapus permintaan beserta surat jalan dan detailnya

---

## 15. Manajemen Staff

### 15.1 List Staff (`/users`)
- Menampilkan semua staff terdaftar beserta gudang yang ditugaskan
- Pencarian berdasarkan nama, KTP, atau email

### 15.2 Edit Staff (`/users/edit/{id}`) — Admin only
- Mengubah data staff: nama, email, password, telepon, KTP
- Jika password dikosongkan saat edit, password lama tetap dipertahankan
- Validasi: email dan KTP harus unik

### 15.3 Profil Saya (`/user`)
- Lihat data profil user yang sedang login
- Edit profil sendiri: nama, email, password
- Hanya bisa mengedit profil sendiri, tidak bisa edit profil orang lain

---

## 16. Database Schema

### 16.1 Tabel Utama

| Tabel | Keterangan |
|-------|------------|
| `user` | Data pengguna — id, nama, email, password, telefon, ktp, role (`admin`/`staff`/`purchasing_admin`), status, id_gudang (NULL = semua gudang) |
| `supplier` | Data supplier — id_supplier, nama. Digunakan oleh Purchase Order, tidak lagi terikat ke `barang`. |
| `satuan` | Satuan barang — id, nama, status |
| `barang` | Data master barang — id, nama, qty, id_satuan, id_lokasi, image. Kolom `id_supplier` dan `kode_barang` sudah dihapus. |
| `gudang` | Data gudang — id, nama, alamat |
| `stok_gudang` | Stok barang per gudang — id, id_gudang, id_barang, qty |

### 16.2 Tabel Transaksi Masuk

| Tabel | Keterangan |
|-------|------------|
| `keranjang_masuk` | Keranjang sementara untuk barang masuk — id, id_user, id_barang, qty |
| `barang_masuk` | Header transaksi masuk — id, id_user, waktu, bukti_foto |
| `barang_masuk_detail` | Detail item masuk — id, id_barang_masuk, id_barang, qty |

### 16.3 Tabel Transaksi Keluar

| Tabel | Keterangan |
|-------|------------|
| `keranjang_keluar` | Keranjang sementara untuk barang keluar — id, id_user, id_barang, qty |
| `barang_keluar` | Header transaksi keluar — id, id_user, waktu, keterangan, bukti_foto, nama_kurir, status_pengiriman |
| `barang_keluar_detail` | Detail item keluar — id, id_barang_keluar, id_barang, qty |

### 16.4 Tabel Transfer

| Tabel | Keterangan |
|-------|------------|
| `transfer_barang` | Header transfer — id, id_gudang_asal, id_gudang_tujuan, id_user, nama_kurir, bukti_foto, waktu, status |
| `transfer_barang_detail` | Detail item transfer — id, id_transfer, id_barang, qty |

### 16.5 Tabel Preorder

| Tabel | Keterangan |
|-------|------------|
| `permintaan_barang` | Header permintaan — id, kode_permintaan, id_user, id_gudang_asal, id_gudang_tujuan, tanggal_permintaan, status, keterangan, alasan_tolak |
| `permintaan_barang_detail` | Detail barang yang diminta — id, id_permintaan, id_barang, qty, keterangan |
| `surat_jalan` | Header surat jalan — id, id_permintaan, nomor_pengiriman, tanggal_pengiriman |
| `surat_jalan_detail` | Detail surat jalan — id, id_surat_jalan, id_barang, qty, qty_diterima, keterangan, is_sesuai, keterangan_verifikasi |

### 16.6 Tabel Purchase Request & Purchase Order

| Tabel | Keterangan |
|-------|------------|
| `purchase_request` | Header PR — id, kode_pr, id_user, id_gudang, tanggal_pr, keterangan, status (`menunggu`/`disetujui`/`ditolak`/`diproses`/`selesai`/`belum_selesai`), alasan_tolak, id_user_respon, tanggal_respon, foto_pr |
| `purchase_request_detail` | Detail item PR — id, id_pr, id_barang (nullable untuk manual item), qty, keterangan, nama_barang_manual, id_satuan_manual |
| `purchase_order` | Header PO — id, kode_po, id_pr, id_supplier, id_user, tanggal_po, tanggal_estimasi, total_harga, keterangan, file_po, status (`dibuat`/`diterima`/`selesai`/`belum_selesai`) |
| `purchase_order_detail` | Detail item PO — id, id_po, id_barang, qty, harga_satuan, subtotal |
| `surat_jalan_pr` | Upload Surat Jalan per PR — id, id_pr, nama_file, file_path, uploaded_at. Multiple per PR, tidak pernah di-overwrite. |

**Catatan:** `purchase_request_detail.id_barang` bisa NULL untuk **manual item** (item belum ada di katalog). Saat verifikasi dengan `qty_diterima > 0`, manual item dipromosikan ke tabel `barang` dan `id_barang` di-update.

### 16.7 Database Triggers

| Trigger | Tabel | Aksi |
|---------|-------|------|
| `tambah_barang` | `barang_masuk_detail` (AFTER INSERT) | Otomatis menambah `barang.qty` sesuai qty yang dimasukkan |
| `kurangi_barang` | `barang_keluar_detail` (BEFORE INSERT) | Otomatis mengurangi `barang.qty` sesuai qty yang dikeluarkan |

**Catatan:** Untuk transfer, preorder, dan Purchase Request Goods Receipt, update stok dilakukan manual via kode PHP (tidak menggunakan trigger), karena stok yang diperbarui ada di tabel `stok_gudang` per-gudang, bukan di tabel `barang` global.

---

## 15b. Purchase Request (PR) → Purchase Order (PO) → Goods Receipt

Fitur pengadaan eksternal: staff meminta barang ke supplier melalui Purchasing Admin.

### Alur (Lifecycle)

```
Staff buat PR → Purchasing Admin accept/decline → (Declined: staff bisa delete)
              → Purchasing Admin buat PO → PO status: Pending → Sent → Shipped → Delivered
              → Staff verifikasi Goods Receipt → Full Match (selesai) / Partial (belum_selesai)
```

Status PR: `menunggu` → `disetujui` / `ditolak` → `diproses` → `selesai` / `belum_selesai`

### 15b.1 Buat PR (`/purchaserequest/create`) — Staff only
- Field: **Gudang Tujuan** (otomatis dari id_gudang staff), **Tanggal PR**, **Keterangan**, **Foto PR** (upload JPG/PNG, opsional)
- Tambah item: pilih barang dari katalog (atau input manual jika barang belum ada di sistem)
- Kode PR digenerate otomatis: `PR-YYYYMMDD-XXX`
- **Manual item:** isi Nama Barang + Satuan tanpa memilih dari dropdown `barang`. Disimpan di `purchase_request_detail` dengan `id_barang = NULL`, `nama_barang_manual`, `id_satuan_manual`.

### 15b.2 Daftar PR (`/purchaserequest`) — semua role
- Informasi: kode PR, pemohon, gudang, tanggal, status, aksi
- Tombol **Hapus** muncul di kolom Aksi:
  - Admin: status apapun
  - Staff (pemohon): hanya status `menunggu` atau `ditolak`

### 15b.3 Detail PR (`/purchaserequest/detail/{id}`)
- Informasi lengkap PR, daftar item, foto PR, list Surat Jalan yang diupload
- Tombol aksi sesuai status dan role:
  - `menunggu` → Accept / Decline (purchasing_admin)
  - `disetujui` → Buat PO (purchasing_admin) — belum diimplementasikan penuh
  - `diproses` → Verifikasi (staff pemohon)

### 15b.4 Accept/Decline (`/purchaserequest/accept/{id}`, `/purchaserequest/reject/{id}`) — Purchasing Admin only
- Accept: status `menunggu` → `disetujui`
- Decline: wajib isi alasan penolakan; status → `ditolak`

### 15b.5 Verifikasi / Goods Receipt (`/purchaserequest/verifikasi/{id}`) — Staff pemohon
- Form per item: **Qty Diterima**, **Keterangan** (catatan ketidaksesuaian)
- Upload **Surat Jalan PDF** (opsional, max 10 MB) — disimpan ke `uploads/surat_jalan/` dan dicatat di `surat_jalan_pr`. Multiple upload didukung; file lama tidak dihapus.
- Hasil:
  - Semua item `qty_diterima = qty` → status `selesai`; stok ditambahkan via `barang_masuk` + `barang_masuk_detail` (trigger `tambah_barang` aktif) + update `stok_gudang`
  - Ada item `qty_diterima < qty` → status `belum_selesai`
  - Manual item dengan `qty_diterima > 0` → dipromosikan ke tabel `barang` (insert baru) + `stok_gudang` di-update

### 15b.6 Hapus PR (`/purchaserequest/delete/{id}`)
- Menghapus PR beserta detail-nya (cascade)

---

## 17. Navigasi Sidebar

Menu sidebar tersusun dalam kelompok-kelompok berikut (gating per role):

1. **Dashboard** — semua role
2. **Manajemen Barang**
   - Register Barang (disembunyikan untuk `purchasing_admin`)
   - Daftar Barang
   - Tambah Satuan (admin only)
   - Daftar Satuan
   - ~~Tambah/List Kategori~~ — dikomentari di sidebar, tidak aktif
   - ~~List Letak Barang~~ — dikomentari di sidebar, tidak aktif
3. ~~**Manajemen Supplier**~~ — dikomentari di sidebar, tidak aktif
4. **Manajemen Gudang** — semua role
   - Gudang (list + tambah + detail)
5. **Barang Masuk** — disembunyikan untuk `purchasing_admin`
   - Barang Masuk (keranjang)
   - Catatan Masuk (riwayat)
6. **Barang Keluar** — disembunyikan untuk `purchasing_admin`
   - Barang Keluar (keranjang)
   - Catatan Keluar (riwayat)
7. **Pemindahan Barang** — disembunyikan untuk `purchasing_admin`
   - Pemindahan Barang (buat baru)
   - Riwayat Pemindahan
8. **Permintaan Barang (Preorder)** — disembunyikan untuk `purchasing_admin`
   - Buat Permintaan (staff only)
   - Daftar Permintaan
9. **Purchasing**
   - Buat Purchase Request (staff only)
   - Purchase Requests (semua role)
10. **Manajemen Staff**
    - Daftar Staff
    - Register Staff (admin only)

---

## 18. Fitur Pendukung

### 18.1 Pencarian Global
- Hampir semua halaman list memiliki fitur pencarian (search bar)
- Pencarian menggunakan keyword yang disimpan di session agar tetap ada saat berpindah halaman paginasi

### 18.2 Paginasi
- Semua halaman list menggunakan paginasi server-side
- Default 5 item per halaman

### 18.3 Flash Messages
- Notifikasi sukses/error/warning ditampilkan sebagai alert Bootstrap
- Otomatis hilang setelah 3 detik

### 18.4 Upload Foto
- Barang masuk, barang keluar, dan transfer mendukung upload foto bukti
- Item barang mendukung upload gambar produk
- Format yang didukung: jpg, jpeg, png, gif
- Ukuran maksimal: 2 MB
- Disimpan di folder `uploads/`

### 18.5 Validasi Form
- Semua form menggunakan validasi server-side via CodeIgniter Form Validation
- Validasi uniqueness untuk email, KTP, nama satuan, nama kategori, nama lokasi, nama supplier
- Error ditampilkan di bawah field yang salah

---

## 19. URL Routes

| URL | Fungsi |
|-----|--------|
| `/login` | Halaman login |
| `/logout` | Proses logout |
| `/home` | Dashboard |
| `/items` | List barang |
| `/items/register` | Form register barang baru |
| `/items/store` | Simpan barang baru |
| `/items/warehouse/{id}` | Barang berdasarkan gudang |
| `/units` | List satuan |
| `/unit` | Form tambah satuan |
| `/categories` | List kategori |
| `/category` | Form tambah kategori |
| `/locations` | List letak barang |
| `/suppliers` | List supplier |
| `/suppliers/add` | Form tambah supplier |
| `/warehouses` | List gudang |
| `/warehouse/add` | Tambah gudang |
| `/warehouse/detail/{id}` | Detail gudang + stok |
| `/cartin` | Keranjang masuk |
| `/inputs` | Catatan masuk |
| `/inputs/detail/{id}` | Detail catatan masuk |
| `/cartout` | Keranjang keluar |
| `/outputs` | Catatan keluar |
| `/outputs/detail/{id}` | Detail catatan keluar |
| `/transfer` | Riwayat transfer |
| `/transfer/create` | Form buat transfer |
| `/transfer/detail/{id}` | Detail transfer |
| `/preorder` | Daftar permintaan |
| `/preorder/create` | Buat permintaan baru |
| `/preorder/detail/{id}` | Detail permintaan |
| `/preorder/approve/{id}` | Approve permintaan |
| `/preorder/reject/{id}` | Tolak permintaan |
| `/preorder/surat_jalan/{id}` | Form surat jalan |
| `/preorder/print_surat_jalan/{id}` | Cetak surat jalan |
| `/preorder/kirim/{id}` | Tandai kirim |
| `/preorder/verifikasi/{id}` | Form verifikasi penerimaan |
| `/preorder/print_verifikasi/{id}` | Cetak laporan verifikasi |
| `/users` | List staff |
| `/register` | Register staff baru |
| `/user` | Profil sendiri |
| `/purchaserequest` | Daftar Purchase Request |
| `/purchaserequest/create` | Buat PR baru (staff) |
| `/purchaserequest/detail/{id}` | Detail PR |
| `/purchaserequest/accept/{id}` | Terima PR (purchasing_admin) |
| `/purchaserequest/reject/{id}` | Tolak PR dengan alasan (purchasing_admin) |
| `/purchaserequest/verifikasi/{id}` | Form Goods Receipt (staff pemohon) |
| `/purchaserequest/store_verifikasi/{id}` | Simpan hasil verifikasi |
| `/purchaserequest/update_qty/{id}` | Update qty item PR |
| `/purchaserequest/delete/{id}` | Hapus PR |

---

## 20. Glossary (Istilah)

| Istilah | Arti |
|---------|------|
| **Barang** | Item/produk yang dikelola di gudang |
| **Satuan** | Unit ukuran barang (contoh: Pcs, Item, Kg) |
| **Kategori** | Klasifikasi jenis barang |
| **Letak Barang** | Lokasi penyimpanan fisik di dalam gudang |
| **Supplier** | Pemasok/vendor barang |
| **Gudang** | Warehouse/tempat penyimpanan |
| **Stok Gudang** | Jumlah barang yang tersedia di gudang tertentu |
| **Barang Masuk** | Transaksi penerimaan barang ke gudang |
| **Barang Keluar** | Transaksi pengeluaran barang dari gudang |
| **Keranjang** | Cart sementara sebelum checkout barang masuk/keluar |
| **Transfer** | Pemindahan barang antar-gudang |
| **Permintaan Barang / Preorder** | Proses permintaan pengiriman barang dari satu gudang ke gudang lain |
| **Surat Jalan** | Dokumen pengiriman (delivery order) |
| **Verifikasi** | Proses pengecekan kesesuaian barang yang diterima vs surat jalan |
| **Qty Diterima** | Jumlah barang yang benar-benar diterima saat verifikasi |
| **Sesuai** | Barang diterima sesuai qty surat jalan |
| **Tidak Sesuai** | Barang diterima tidak sesuai (qty berbeda, rusak, dll) |
| **Belum Selesai** | Status permintaan jika ada barang yang tidak sesuai |
| **Admin** | Super user (`role='admin'`) yang dapat mengelola semua fitur |
| **Staff** | Project Admin (`role='staff'`) — buat PR & Preorder, operasi stok di semua gudang |
| **Purchasing Admin** | `role='purchasing_admin'` — accept/reject PR, buat PO, kelola supplier |
| **Purchase Request (PR)** | Permintaan pengadaan barang dari supplier, dibuat oleh staff |
| **Purchase Order (PO)** | Pesanan resmi ke supplier, dibuat oleh Purchasing Admin dari PR yang disetujui |
| **Goods Receipt** | Proses verifikasi barang yang diterima dari supplier; menambah stok jika sesuai |
| **Manual Item** | Item PR yang belum ada di katalog `barang`; dipromosikan ke katalog saat verifikasi jika qty > 0 |
| **Surat Jalan PR** | PDF dokumen pengiriman supplier yang diupload saat Goods Receipt; multiple per PR |
