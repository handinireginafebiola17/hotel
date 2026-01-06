<?php
// Query untuk mendapatkan data reservasi yang belum memiliki pembayaran atau belum lunas
$reservasi_query = mysqli_query($koneksi, "
    SELECT r.*, t.nama as nama_tamu, k.harga, 
           (k.harga * r.jumlah_malam) as total_harga,
           p.status as status_pembayaran
    FROM tbl_reservasi r
    LEFT JOIN tbl_tamu t ON r.id_tamu = t.id_tamu
    LEFT JOIN tbl_kamar k ON r.id_kamar = k.id_kamar
    LEFT JOIN tbl_pembayaran p ON r.id_reservasi = p.id_reservasi
    WHERE p.id_pembayaran IS NULL OR p.status = 'belum lunas'
    ORDER BY r.tgl_checkin DESC
");
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus-circle"></i> Tambah Pembayaran Baru
                </h3>
            </div>
            <form action="form/pembayaran/simpan.php" method="POST" id="formPembayaran">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_reservasi">Pilih Reservasi *</label>
                                <select class="form-control select2" id="id_reservasi" name="id_reservasi" required 
                                        onchange="loadReservasiDetail()">
                                    <option value="">-- Pilih Reservasi --</option>
                                    <?php while($reservasi = mysqli_fetch_array($reservasi_query)): 
                                        $total_harga = $reservasi['harga'] * $reservasi['jumlah_malam'];
                                        $status_text = empty($reservasi['status_pembayaran']) ? 'BELUM BAYAR' : strtoupper($reservasi['status_pembayaran']);
                                    ?>
                                    <option value="<?php echo $reservasi['id_reservasi']; ?>" 
                                            data-tamu="<?php echo $reservasi['nama_tamu']; ?>"
                                            data-checkin="<?php echo $reservasi['tgl_checkin']; ?>"
                                            data-checkout="<?php echo $reservasi['tgl_checkout']; ?>"
                                            data-jumlah="<?php echo $reservasi['jumlah_malam']; ?>"
                                            data-harga="<?php echo $reservasi['harga']; ?>"
                                            data-total="<?php echo $total_harga; ?>"
                                            data-status="<?php echo $reservasi['status_pembayaran']; ?>">
                                        RSV<?php echo str_pad($reservasi['id_reservasi'], 4, '0', STR_PAD_LEFT); ?> - 
                                        <?php echo $reservasi['nama_tamu']; ?> - 
                                        Rp <?php echo number_format($total_harga, 0, ',', '.'); ?> - 
                                        <span class="badge <?php echo ($status_text == 'BELUM LUNAS' || $status_text == 'BELUM BAYAR') ? 'bg-warning' : 'bg-success'; ?>">
                                            <?php echo $status_text; ?>
                                        </span>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="metode">Metode Pembayaran *</label>
                                <select class="form-control" id="metode" name="metode" required>
                                    <option value="">-- Pilih Metode --</option>
                                    <option value="Transfer Bank">Transfer Bank</option>
                                    <option value="Tunai">Tunai</option>
                                    <option value="Kartu Kredit">Kartu Kredit</option>
                                    <option value="E-Wallet">E-Wallet</option>
                                    <option value="QRIS">QRIS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_bayar">Tanggal Bayar *</label>
                                <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar" 
                                       value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status Pembayaran *</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="belum lunas">Belum Lunas</option>
                                    <option value="lunas">Lunas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Detail Reservasi -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle"></i> Detail Reservasi
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nama Tamu</label>
                                        <input type="text" class="form-control" id="detail_tamu" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Check-in</label>
                                        <input type="text" class="form-control" id="detail_checkin" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Check-out</label>
                                        <input type="text" class="form-control" id="detail_checkout" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Jumlah Malam</label>
                                        <input type="text" class="form-control" id="detail_jumlah" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Harga per Malam</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control" id="detail_harga" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Total Harga Reservasi</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control" id="detail_total" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Catatan:</strong> 
                        <ul>
                            <li>Pilih reservasi yang akan dibayar</li>
                            <li>Satu reservasi bisa memiliki lebih dari satu pembayaran (untuk DP atau cicilan)</li>
                            <li>Status "Lunas" akan menandai reservasi sebagai sudah dibayar penuh</li>
                        </ul>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Pembayaran
                    </button>
                    <a href="dashboard.php?menu=pembayaran" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fungsi untuk load detail reservasi
function loadReservasiDetail() {
    var reservasiSelect = document.getElementById('id_reservasi');
    var selectedOption = reservasiSelect.options[reservasiSelect.selectedIndex];
    
    if (selectedOption.value !== '') {
        // Ambil data dari attribute data-*
        var namaTamu = selectedOption.getAttribute('data-tamu');
        var checkin = selectedOption.getAttribute('data-checkin');
        var checkout = selectedOption.getAttribute('data-checkout');
        var jumlahMalam = selectedOption.getAttribute('data-jumlah');
        var hargaPerMalam = selectedOption.getAttribute('data-harga');
        var totalHarga = selectedOption.getAttribute('data-total');
        var statusPembayaran = selectedOption.getAttribute('data-status');
        
        // Format tanggal
        var formatCheckin = formatTanggal(checkin);
        var formatCheckout = formatTanggal(checkout);
        
        // Set value ke form
        document.getElementById('detail_tamu').value = namaTamu;
        document.getElementById('detail_checkin').value = formatCheckin;
        document.getElementById('detail_checkout').value = formatCheckout;
        document.getElementById('detail_jumlah').value = jumlahMalam + ' malam';
        document.getElementById('detail_harga').value = formatRupiah(hargaPerMalam);
        document.getElementById('detail_total').value = formatRupiah(totalHarga);
        
        // Auto set status jika belum lunas
        if (statusPembayaran === 'lunas') {
            document.getElementById('status').value = 'lunas';
        } else {
            document.getElementById('status').value = 'belum lunas';
        }
    } else {
        // Reset form jika tidak ada pilihan
        resetReservasiDetail();
    }
}

// Fungsi untuk reset detail reservasi
function resetReservasiDetail() {
    document.getElementById('detail_tamu').value = '';
    document.getElementById('detail_checkin').value = '';
    document.getElementById('detail_checkout').value = '';
    document.getElementById('detail_jumlah').value = '';
    document.getElementById('detail_harga').value = '';
    document.getElementById('detail_total').value = '';
}

// Fungsi untuk format tanggal
function formatTanggal(dateString) {
    var date = new Date(dateString);
    var day = date.getDate().toString().padStart(2, '0');
    var month = (date.getMonth() + 1).toString().padStart(2, '0');
    var year = date.getFullYear();
    return day + '/' + month + '/' + year;
}

// Fungsi untuk format Rupiah
function formatRupiah(angka) {
    if (!angka) return '';
    var number_string = angka.toString().replace(/[^,\d]/g, ''),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        var separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah;
}

// Validasi form
document.getElementById('formPembayaran').addEventListener('submit', function(e) {
    var reservasi = document.getElementById('id_reservasi').value;
    var metode = document.getElementById('metode').value;
    var tanggal = document.getElementById('tanggal_bayar').value;
    
    if (!reservasi) {
        e.preventDefault();
        alert('Silahkan pilih reservasi terlebih dahulu!');
        return false;
    }
    
    if (!metode) {
        e.preventDefault();
        alert('Silahkan pilih metode pembayaran!');
        return false;
    }
    
    if (!tanggal) {
        e.preventDefault();
        alert('Silahkan isi tanggal pembayaran!');
        return false;
    }
});

// Initialize Select2
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap4'
    });
});
</script>