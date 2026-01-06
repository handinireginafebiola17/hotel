<?php
include "../../koneksi.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kamar = mysqli_real_escape_string($koneksi, $_POST['id_kamar']);
    $tipe_kamar = mysqli_real_escape_string($koneksi, $_POST['tipe_kamar']);
    $harga = mysqli_real_escape_string($koneksi, str_replace('.', '', $_POST['harga']));
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    
    $query = "UPDATE tbl_kamar SET 
              tipe_kamar = '$tipe_kamar',
              harga = '$harga',
              status = '$status'
              WHERE id_kamar = '$id_kamar'";
    
    if(mysqli_query($koneksi, $query)) {
        header('location: ../../dashboard.php?menu=kamar&success=1');
    } else {
        header('location: ../../dashboard.php?menu=editkamar&id=' . $id_kamar . '&error=1');
    }
} else {
    header('location: ../../dashboard.php?menu=kamar');
}
exit();
?>