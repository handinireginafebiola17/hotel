<?php
include "../../koneksi.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    
    $query = "INSERT INTO tbl_tamu (nama, no_telp, alamat) 
              VALUES ('$nama', '$no_telp', '$alamat')";
    
    if(mysqli_query($koneksi, $query)) {
        header('location: ../../dashboard.php?menu=tamu&success=1');
    } else {
        header('location: ../../dashboard.php?menu=addtamu&error=1');
    }
} else {
    header('location: ../../dashboard.php?menu=tamu');
}
exit();
?>