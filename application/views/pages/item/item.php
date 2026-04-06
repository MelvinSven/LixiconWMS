<!-- ============================================== -->
<!-- Form Register Barang -->
<!-- ============================================== -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Register Barang Baru</h4>

        <!-- Tambahkan enctype untuk upload file -->
        <form action="<?= base_url('items/store') ?>" method="POST" enctype="multipart/form-data">
            
            <!-- Nama Barang -->
            <div class="form-group">
                <label>Nama Barang</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-box"></i></span>
                    </div>
                    <input type="text" name="nama" class="form-control" placeholder="Nama barang baru" required>
                </div>
            </div>

            <!-- Kuantitas -->
            <div class="form-group">
                <label>Kuantitas</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                    </div>
                    <input type="number" name="qty" class="form-control" value="0" min="0" required>
                </div>
            </div>

            <!-- Satuan -->
            <div class="form-group">
                <label>Satuan</label>
                <select name="id_satuan" class="form-control" required>
                    <option value="">-- Pilih Satuan --</option>
                    <?php foreach (getUnits() as $unit) : ?>
                        <option value="<?= $unit->id ?>"><?= ucfirst($unit->nama) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- 🔽 BAGIAN BARU: Upload Gambar -->
            <div class="form-group">
                <label>Upload Gambar Barang</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-image"></i></span>
                    </div>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <small class="form-text text-muted">
                    Format diperbolehkan: JPG, PNG, JPEG. Maksimal 2MB.
                </small>
            </div>
            <!-- 🔼 END BAGIAN BARU -->

            <!-- Tombol -->
            <div class="form-group text-right mt-4">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-dark">Reset</button>
            </div>
        </form>
    </div>
</div>
