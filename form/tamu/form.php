<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tambah Data Tamu</h3>
            </div>
            <form action="form/tamu/simpan.php" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama Tamu</label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                               placeholder="Masukkan nama tamu" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No Telepon</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp" 
                               placeholder="Masukkan nomor telepon" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" 
                                  rows="3" placeholder="Masukkan alamat" required></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="dashboard.php?menu=tamu" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>