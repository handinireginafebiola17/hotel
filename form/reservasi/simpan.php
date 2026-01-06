<?php
include "../../koneksi.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_tamu = mysqli_real_escape_string($koneksi, $_POST['id_tamu']);
    $id_kamar = mysqli_real_escape_string($koneksi, $_POST['id_kamar']);
    $tgl_checkin = mysqli_real_escape_string($koneksi, $_POST['tgl_checkin']);
    $tgl_checkout = mysqli_real_escape_string($koneksi, $_POST['tgl_checkout']);
    $jumlah_malam = mysqli_real_escape_string($koneksi, $_POST['jumlah_malam']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    $total_harga = isset($_POST['total_harga']) ? mysqli_real_escape_string($koneksi, $_POST['total_harga']) : 0;
    
    // Validasi data
    if(empty($id_tamu) || empty($id_kamar) || empty($tgl_checkin) || empty($tgl_checkout)) {
        header('location: ../../dashboard.php?menu=addreservasi&error=1');
        exit();
    }
    
    // Cek ketersediaan kamar
    $cek_kamar = mysqli_query($koneksi, "SELECT * FROM tbl_kamar WHERE id_kamar = '$id_kamar' AND status = 'tersedia'");
    
    if(mysqli_num_rows($cek_kamar) == 0) {
        header('location: ../../dashboard.php?menu=addreservasi&error=2');
        exit();
    }
    
    // Insert data reservasi
    $query = "INSERT INTO tbl_reservasi (id_tamu, id_kamar, tgl_checkin, tgl_checkout, jumlah_malam, status) 
              VALUES ('$id_tamu', '$id_kamar', '$tgl_checkin', '$tgl_checkout', '$jumlah_malam', '$status')";
    
    if(mysqli_query($koneksi, $query)) {
        // Update status kamar menjadi terisi
        $update_kamar = mysqli_query($koneksi, "UPDATE tbl_kamar SET status = 'terisi' WHERE id_kamar = '$id_kamar'");
        
        // Dapatkan ID reservasi yang baru dibuat
        $id_reservasi = mysqli_insert_id($koneksi);
        
        // Buat pembayaran otomatis jika status confirmed
        if($status == 'confirmed' && $total_harga > 0) {
            $insert_pembayaran = mysqli_query($koneksi, "
                INSERT INTO tbl_pembayaran (id_reservasi, metode, tanggal_bayar, status) 
                VALUES ('$id_reservasi', 'Belum Dibayar', CURDATE(), 'belum lunas')
            ");
        }
        
        header('location: ../../dashboard.php?menu=reservasi&success=1');
    } else {
        header('location: ../../dashboard.php?menu=addreservasi&error=3');
    }
} else {
    header('location: ../../dashboard.php?menu=reservasi');
}
exit();
?>