<?php
include "../../koneksi.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_reservasi = mysqli_real_escape_string($koneksi, $_POST['id_reservasi']);
    $metode = mysqli_real_escape_string($koneksi, $_POST['metode']);
    $tanggal_bayar = mysqli_real_escape_string($koneksi, $_POST['tanggal_bayar']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    
    // Validasi data
    if(empty($id_reservasi) || empty($metode) || empty($tanggal_bayar) || empty($status)) {
        header('location: ../../dashboard.php?menu=addpembayaran&error=1');
        exit();
    }
    
    // Cek apakah reservasi ada
    $cek_reservasi = mysqli_query($koneksi, "SELECT * FROM tbl_reservasi WHERE id_reservasi = '$id_reservasi'");
    
    if(mysqli_num_rows($cek_reservasi) == 0) {
        header('location: ../../dashboard.php?menu=addpembayaran&error=2');
        exit();
    }
    
    // Insert data pembayaran
    $query = "INSERT INTO tbl_pembayaran (id_reservasi, metode, tanggal_bayar, status) 
              VALUES ('$id_reservasi', '$metode', '$tanggal_bayar', '$status')";
    
    if(mysqli_query($koneksi, $query)) {
        // Jika status lunas, update status reservasi
        if($status == 'lunas') {
            $update_reservasi = mysqli_query($koneksi, 
                "UPDATE tbl_reservasi SET status = 'confirmed' WHERE id_reservasi = '$id_reservasi'");
        }
        
        header('location: ../../dashboard.php?menu=pembayaran&success=1');
    } else {
        header('location: ../../dashboard.php?menu=addpembayaran&error=3');
    }
} else {
    header('location: ../../dashboard.php?menu=pembayaran');
}
exit();
?>