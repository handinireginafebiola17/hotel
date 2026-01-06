<?php
include "../../koneksi.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tamu = $_POST['id_tamu'];
    $nama = $_POST['nama'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    
    $query = "UPDATE tbl_tamu SET 
              nama = '$nama',
              no_telp = '$no_telp',
              alamat = '$alamat'
              WHERE id_tamu = '$id_tamu'";
    
    if(mysqli_query($koneksi, $query)) {
        header('location: ../../dashboard.php?menu=tamu&success=1');
    } else {
        header('location: ../../dashboard.php?menu=edittamu&id=' . $id_tamu . '&error=1');
    }
} else {
    header('location: ../../dashboard.php?menu=tamu');
}
exit();
?>