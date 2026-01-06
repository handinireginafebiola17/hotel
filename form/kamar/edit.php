<?php
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM tbl_kamar WHERE id_kamar = '$id'");

if(mysqli_num_rows($query) == 0) {
    echo '<div class="alert alert-danger">Data kamar tidak ditemukan!</div>';
    exit();
}

$data = mysqli_fetch_array($query);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> Edit Kamar
                </h3>
            </div>
            <form action="form/kamar/update.php" method="POST">
                <input type="hidden" name="id_kamar" value="<?php echo $data['id_kamar']; ?>">
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipe_kamar">Tipe Kamar</label>
                                <select class="form-control select2" id="tipe_kamar" name="tipe_kamar" required>
                                    <option value="">-- Pilih Tipe Kamar --</option>
                                    <option value="Standard" <?php echo ($data['tipe_kamar'] == 'Standard') ? 'selected' : ''; ?>>Standard</option>
                                    <option value="Deluxe" <?php echo ($data['tipe_kamar'] == 'Deluxe') ? 'selected' : ''; ?>>Deluxe</option>
                                    <option value="Superior" <?php echo ($data['tipe_kamar'] == 'Superior') ? 'selected' : ''; ?>>Superior</option>
                                    <option value="Executive Suite" <?php echo ($data['tipe_kamar'] == 'Executive Suite') ? 'selected' : ''; ?>>Executive Suite</option>
                                    <option value="Family Room" <?php echo ($data['tipe_kamar'] == 'Family Room') ? 'selected' : ''; ?>>Family Room</option>
                                    <option value="Ekonomi" <?php echo ($data['tipe_kamar'] == 'Ekonomi') ? 'selected' : ''; ?>>Ekonomi</option>
                                    <option value="Bisnis" <?php echo ($data['tipe_kamar'] == 'Bisnis') ? 'selected' : ''; ?>>Bisnis</option>
                                    <option value="VIP" <?php echo ($data['tipe_kamar'] == 'VIP') ? 'selected' : ''; ?>>VIP</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga">Harga per Malam (Rp)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control" id="harga" name="harga" 
                                           value="<?php echo number_format($data['harga'], 0, ',', '.'); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status Kamar</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="tersedia" <?php echo ($data['status'] == 'tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                                    <option value="terisi" <?php echo ($data['status'] == 'terisi') ? 'selected' : ''; ?>>Terisi</option>
                                    <option value="dibersihkan" <?php echo ($data['status'] == 'dibersihkan') ? 'selected' : ''; ?>>Dibersihkan</option>
                                    <option value="maintenance" <?php echo ($data['status'] == 'maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h5><i class="fas fa-info-circle"></i> Informasi Kamar</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <td width="30%"><strong>ID Kamar:</strong></td>
                                        <td>KMR<?php echo str_pad($data['id_kamar'], 3, '0', STR_PAD_LEFT); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tipe Kamar:</strong></td>
                                        <td><?php echo $data['tipe_kamar']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Harga saat ini:</strong></td>
                                        <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?> per malam</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status saat ini:</strong></td>
                                        <td>
                                            <?php 
                                            $status_class = '';
                                            $status_text = '';
                                            switch(strtolower($data['status'])) {
                                                case 'tersedia':
                                                    $status_class = 'badge bg-success';
                                                    $status_text = 'TERSEDIA';
                                                    break;
                                                case 'terisi':
                                                    $status_class = 'badge bg-warning';
                                                    $status_text = 'TERISI';
                                                    break;
                                                case 'dibersihkan':
                                                    $status_class = 'badge bg-secondary';
                                                    $status_text = 'DIBERSIHKAN';
                                                    break;
                                                default:
                                                    $status_class = 'badge bg-info';
                                                    $status_text = strtoupper($data['status']);
                                            }
                                            ?>
                                            <span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update Kamar
                    </button>
                    <a href="dashboard.php?menu=kamar" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Format harga input
document.getElementById('harga').addEventListener('input', function(e) {
    var value = e.target.value;
    value = value.replace(/\D/g, '');
    if (value) {
        e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
});

// Initialize Select2
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap4'
    });
});
</script>