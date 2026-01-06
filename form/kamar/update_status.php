<?php
include "../../koneksi.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kamar = mysqli_real_escape_string($koneksi, $_POST['id_kamar']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    
    $query = "UPDATE tbl_kamar SET status = '$status' WHERE id_kamar = '$id_kamar'";
    
    if(mysqli_query($koneksi, $query)) {
        echo json_encode(['success' => true, 'message' => 'Status berhasil diupdate!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal update status!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request!']);
}
exit();
?>