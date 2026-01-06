<?php
// Query untuk mendapatkan data tamu dan kamar
$tamu_query = mysqli_query($koneksi, "SELECT * FROM tbl_tamu ORDER BY nama");
$kamar_query = mysqli_query($koneksi, "SELECT * FROM tbl_kamar WHERE status = 'tersedia' ORDER BY tipe_kamar");
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus-circle"></i> Tambah Reservasi Baru
                </h3>
            </div>
            <form action="form/reservasi/simpan.php" method="POST" id="formReservasi">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_tamu">Pilih Tamu *</label>
                                <select class="form-control select2" id="id_tamu" name="id_tamu" required>
                                    <option value="">-- Pilih Tamu --</option>
                                    <?php while($tamu = mysqli_fetch_array($tamu_query)): ?>
                                    <option value="<?php echo $tamu['id_tamu']; ?>">
                                        <?php echo $tamu['nama']; ?> - <?php echo $tamu['no_telp']; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_kamar">Pilih Kamar *</label>
                                <select class="form-control select2" id="id_kamar" name="id_kamar" required 
                                        onchange="updateHarga()">
                                    <option value="">-- Pilih Kamar --</option>
                                    <?php 
                                    mysqli_data_seek($kamar_query, 0); // Reset pointer query
                                    while($kamar = mysqli_fetch_array($kamar_query)): 
                                    ?>
                                    <option value="<?php echo $kamar['id_kamar']; ?>" 
                                            data-harga="<?php echo $kamar['harga']; ?>"
                                            data-tipe="<?php echo $kamar['tipe_kamar']; ?>">
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
                                <label for="tgl_checkin">Tanggal Check-in *</label>
                                <input type="date" class="form-control" id="tgl_checkin" name="tgl_checkin" 
                                       required min="<?php echo date('Y-m-d'); ?>"
                                       onchange="hitungJumlahMalam()">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tgl_checkout">Tanggal Check-out *</label>
                                <input type="date" class="form-control" id="tgl_checkout" name="tgl_checkout" 
                                       required onchange="hitungJumlahMalam()">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jumlah_malam">Jumlah Malam</label>
                                <input type="number" class="form-control" id="jumlah_malam" name="jumlah_malam" 
                                       readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga_per_malam">Harga per Malam</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control" id="harga_per_malam" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_harga">Total Harga</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control" id="total_harga" readonly>
                                    <input type="hidden" name="total_harga" id="total_harga_hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status Reservasi</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Catatan:</strong> Pastikan semua data diisi dengan benar. 
                        Setelah reservasi dibuat, status kamar akan otomatis berubah.
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Reservasi
                    </button>
                    <a href="dashboard.php?menu=reservasi" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fungsi untuk update harga kamar
function updateHarga() {
    var kamarSelect = document.getElementById('id_kamar');
    var hargaInput = document.getElementById('harga_per_malam');
    var selectedOption = kamarSelect.options[kamarSelect.selectedIndex];
    
    if (selectedOption.value !== '') {
        var harga = selectedOption.getAttribute('data-harga');
        hargaInput.value = formatRupiah(harga);
        hitungTotalHarga();
    } else {
        hargaInput.value = '';
        document.getElementById('total_harga').value = '';
        document.getElementById('total_harga_hidden').value = '';
    }
}

// Fungsi untuk hitung jumlah malam
function hitungJumlahMalam() {
    var checkin = document.getElementById('tgl_checkin').value;
    var checkout = document.getElementById('tgl_checkout').value;
    var jumlahMalamInput = document.getElementById('jumlah_malam');
    
    if (checkin && checkout) {
        var date1 = new Date(checkin);
        var date2 = new Date(checkout);
        
        // Hitung selisih hari
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
        
        jumlahMalamInput.value = diffDays;
        hitungTotalHarga();
    } else {
        jumlahMalamInput.value = '';
    }
}

// Fungsi untuk hitung total harga
function hitungTotalHarga() {
    var jumlahMalam = document.getElementById('jumlah_malam').value;
    var kamarSelect = document.getElementById('id_kamar');
    var selectedOption = kamarSelect.options[kamarSelect.selectedIndex];
    var totalHargaInput = document.getElementById('total_harga');
    var totalHargaHidden = document.getElementById('total_harga_hidden');
    
    if (jumlahMalam && selectedOption.value !== '') {
        var hargaPerMalam = selectedOption.getAttribute('data-harga');
        var total = parseInt(hargaPerMalam) * parseInt(jumlahMalam);
        
        totalHargaInput.value = formatRupiah(total.toString());
        totalHargaHidden.value = total;
    } else {
        totalHargaInput.value = '';
        totalHargaHidden.value = '';
    }
}

// Fungsi untuk format Rupiah
function formatRupiah(angka) {
    var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    return ribuan;
}

// Validasi tanggal check-out harus setelah check-in
document.getElementById('formReservasi').addEventListener('submit', function(e) {
    var checkin = new Date(document.getElementById('tgl_checkin').value);
    var checkout = new Date(document.getElementById('tgl_checkout').value);
    
    if (checkout <= checkin) {
        e.preventDefault();
        alert('Tanggal check-out harus setelah tanggal check-in!');
        return false;
    }
    
    if (!document.getElementById('id_tamu').value) {
        e.preventDefault();
        alert('Silahkan pilih tamu terlebih dahulu!');
        return false;
    }
    
    if (!document.getElementById('id_kamar').value) {
        e.preventDefault();
        alert('Silahkan pilih kamar terlebih dahulu!');
        return false;
    }
});
</script>