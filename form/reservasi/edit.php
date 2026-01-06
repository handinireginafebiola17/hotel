<?php
$id = $_GET['id'];
$query = mysqli_query($koneksi, "
    SELECT r.*, t.nama as nama_tamu, k.tipe_kamar, k.harga 
    FROM tbl_reservasi r
    LEFT JOIN tbl_tamu t ON r.id_tamu = t.id_tamu
    LEFT JOIN tbl_kamar k ON r.id_kamar = k.id_kamar
    WHERE r.id_reservasi = '$id'
");

if(mysqli_num_rows($query) == 0) {
    echo '<div class="alert alert-danger">Data reservasi tidak ditemukan!</div>';
    exit();
}

$data = mysqli_fetch_array($query);

// Query untuk dropdown
$tamu_query = mysqli_query($koneksi, "SELECT * FROM tbl_tamu ORDER BY nama");
$kamar_query = mysqli_query($koneksi, "SELECT * FROM tbl_kamar ORDER BY tipe_kamar");
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> Edit Reservasi
                </h3>
            </div>
            <form action="form/reservasi/update.php" method="POST">
                <input type="hidden" name="id_reservasi" value="<?php echo $data['id_reservasi']; ?>">
                <input type="hidden" name="old_kamar_id" value="<?php echo $data['id_kamar']; ?>">
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_tamu">Pilih Tamu</label>
                                <select class="form-control" id="id_tamu" name="id_tamu" required>
                                    <option value="">-- Pilih Tamu --</option>
                                    <?php while($tamu = mysqli_fetch_array($tamu_query)): ?>
                                    <option value="<?php echo $tamu['id_tamu']; ?>" 
                                        <?php echo ($tamu['id_tamu'] == $data['id_tamu']) ? 'selected' : ''; ?>>
                                        <?php echo $tamu['nama']; ?> - <?php echo $tamu['no_telp']; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_kamar">Pilih Kamar</label>
                                <select class="form-control" id="id_kamar" name="id_kamar" required>
                                    <option value="">-- Pilih Kamar --</option>
                                    <?php 
                                    mysqli_data_seek($kamar_query, 0);
                                    while($kamar = mysqli_fetch_array($kamar_query)): 
                                    ?>
                                    <option value="<?php echo $kamar['id_kamar']; ?>" 
                                        <?php echo ($kamar['id_kamar'] == $data['id_kamar']) ? 'selected' : ''; ?>>
                                        <?php echo $kamar['tipe_kamar']; ?> - 
                                        Rp <?php echo number_format($kamar['harga'], 0, ',', '.'); ?>/malam
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tgl_checkin">Tanggal Check-in</label>
                                <input type="date" class="form-control" id="tgl_checkin" name="tgl_checkin" 
                                       value="<?php echo $data['tgl_checkin']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tgl_checkout">Tanggal Check-out</label>
                                <input type="date" class="form-control" id="tgl_checkout" name="tgl_checkout" 
                                       value="<?php echo $data['tgl_checkout']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah_malam">Jumlah Malam</label>
                                <input type="number" class="form-control" id="jumlah_malam" name="jumlah_malam" 
                                       value="<?php echo $data['jumlah_malam']; ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status Reservasi</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="pending" <?php echo ($data['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="confirmed" <?php echo ($data['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Informasi Kamar</label>
                                <div class="alert alert-info p-2">
                                    <small>
                                        <i class="fas fa-info-circle"></i>
                                        Tipe: <strong><?php echo $data['tipe_kamar']; ?></strong><br>
                                        Harga: <strong>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?>/malam</strong>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update Reservasi
                    </button>
                    <a href="dashboard.php?menu=reservasi" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>