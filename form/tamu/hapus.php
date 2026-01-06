<?php
include "../../koneksi.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Cek apakah tamu memiliki reservasi
    $check_reservasi = mysqli_query($koneksi, "SELECT * FROM tbl_reservasi WHERE id_tamu = '$id'");
    
    if(mysqli_num_rows($check_reservasi) > 0) {
        // Jika ada reservasi, jangan hapus
        header('location: ../../dashboard.php?menu=tamu&error=2');
    } else {
        // Hapus data tamu
        $query = "DELETE FROM tbl_tamu WHERE id_tamu = '$id'";
        
        if(mysqli_query($koneksi, $query)) {
            header('location: ../../dashboard.php?menu=tamu&success=2');
        } else {
            header('location: ../../dashboard.php?menu=tamu&error=1');
        }
    }
} else {
    header('location: ../../dashboard.php?menu=tamu');
}
exit();
?>
