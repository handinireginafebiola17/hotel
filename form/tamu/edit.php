<?php
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM tbl_tamu WHERE id_tamu = '$id'");
$data = mysqli_fetch_array($query);
?>

<div class="row">
    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Data Tamu</h3>
            </div>
            <form action="form/tamu/update.php" method="POST">
                <div class="card-body">
                    <input type="hidden" name="id_tamu" value="<?php echo $data['id_tamu']; ?>">
                    <div class="form-group">
                        <label for="nama">Nama Tamu</label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                               value="<?php echo $data['nama']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No Telepon</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp" 
                               value="<?php echo $data['no_telp']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" 
                                  rows="3" required><?php echo $data['alamat']; ?></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="dashboard.php?menu=tamu" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>