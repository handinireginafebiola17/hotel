<?php
include "../../koneksi.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Cek apakah kamar memiliki reservasi aktif
    $check_reservasi = mysqli_query($koneksi, "
        SELECT * FROM tbl_reservasi 
        WHERE id_kamar = '$id' AND status = 'confirmed'
    ");
    
    if(mysqli_num_rows($check_reservasi) > 0) {
        // Jika ada reservasi aktif, jangan hapus
        header('location: ../../dashboard.php?menu=kamar&error=2');
    } else {
        // Hapus data kamar
        $query = "DELETE FROM tbl_kamar WHERE id_kamar = '$id'";
        
        if(mysqli_query($koneksi, $query)) {
            header('location: ../../dashboard.php?menu=kamar&success=2');
        } else {
            header('location: ../../dashboard.php?menu=kamar&error=1');
        }
    }
} else {
    header('location: ../../dashboard.php?menu=kamar');
}
exit();
?>