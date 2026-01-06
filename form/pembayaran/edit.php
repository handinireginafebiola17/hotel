<?php
$id = $_GET['id'];
$query = mysqli_query($koneksi, "
    SELECT p.*, r.*, t.nama as nama_tamu, k.harga, 
           (k.harga * r.jumlah_malam) as total_harga
    FROM tbl_pembayaran p
    LEFT JOIN tbl_reservasi r ON p.id_reservasi = r.id_reservasi
    LEFT JOIN tbl_tamu t ON r.id_tamu = t.id_tamu
    LEFT JOIN tbl_kamar k ON r.id_kamar = k.id_kamar
    WHERE p.id_pembayaran = '$id'
");

if(mysqli_num_rows($query) == 0) {
    echo '<div class="alert alert-danger">Data pembayaran tidak ditemukan!</div>';
    exit();
}

$data = mysqli_fetch_array($query);

// Query untuk dropdown reservasi
$reservasi_query = mysqli_query($koneksi, "
    SELECT r.*, t.nama as nama_tamu, k.harga, 
           (k.harga * r.jumlah_malam) as total_harga,
           p.status as status_pembayaran
    FROM tbl_reservasi r
    LEFT JOIN tbl_tamu t ON r.id_tamu = t.id_tamu
    LEFT JOIN tbl_kamar k ON r.id_kamar = k.id_kamar
    LEFT JOIN tbl_pembayaran p ON r.id_reservasi = p.id_reservasi
    WHERE r.id_reservasi = '" . $data['id_reservasi'] . "' 
       OR (p.id_pembayaran IS NULL OR p.status = 'belum lunas')
    ORDER BY r.tgl_checkin DESC
");
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> Edit Pembayaran
                </h3>
            </div>
            <form action="form/pembayaran/update.php" method="POST">
                <input type="hidden" name="id_pembayaran" value="<?php echo $data['id_pembayaran']; ?>">
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_reservasi">Reservasi</label>
                                <select class="form-control" id="id_reservasi" name="id_reservasi" required>
                                    <option value="">-- Pilih Reservasi --</option>
                                    <?php while($reservasi = mysqli_fetch_array($reservasi_query)): 
                                        $total_harga = $reservasi['harga'] * $reservasi['jumlah_malam'];
                                        $status_text = empty($reservasi['status_pembayaran']) ? 'BELUM BAYAR' : strtoupper($reservasi['status_pembayaran']);
                                    ?>
                                    <option value="<?php echo $reservasi['id_reservasi']; ?>" 
                                        <?php echo ($reservasi['id_reservasi'] == $data['id_reservasi']) ? 'selected' : ''; ?>>
                                        RSV<?php echo str_pad($reservasi['id_reservasi'], 4, '0', STR_PAD_LEFT); ?> - 
                                        <?php echo $reservasi['nama_tamu']; ?> - 
                                        Rp <?php echo number_format($total_harga, 0, ',', '.'); ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="metode">Metode Pembayaran</label>
                                <select class="form-control" id="metode" name="metode" required>
                                    <option value="">-- Pilih Metode --</option>
                                    <option value="Transfer Bank" <?php echo ($data['metode'] == 'Transfer Bank') ? 'selected' : ''; ?>>Transfer Bank</option>
                                    <option value="Tunai" <?php echo ($data['metode'] == 'Tunai') ? 'selected' : ''; ?>>Tunai</option>
                                    <option value="Kartu Kredit" <?php echo ($data['metode'] == 'Kartu Kredit') ? 'selected' : ''; ?>>Kartu Kredit</option>
                                    <option value="E-Wallet" <?php echo ($data['metode'] == 'E-Wallet') ? 'selected' : ''; ?>>E-Wallet</option>
                                    <option value="QRIS" <?php echo ($data['metode'] == 'QRIS') ? 'selected' : ''; ?>>QRIS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_bayar">Tanggal Bayar</label>
                                <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar" 
                                       value="<?php echo $data['tanggal_bayar']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status Pembayaran</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="belum lunas" <?php echo ($data['status'] == 'belum lunas') ? 'selected' : ''; ?>>Belum Lunas</option>
                                    <option value="lunas" <?php echo ($data['status'] == '