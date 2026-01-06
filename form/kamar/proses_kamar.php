<?php
include "../../koneksi.php";

// PROSES SIMPAN (TAMBAH)
if(isset($_POST['simpan'])) {
    $tipe_kamar = $_POST['tipe_kamar'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    
    $query = "INSERT INTO tbl_kamar (tipe_kamar, harga, status) VALUES ('$tipe_kamar', '$harga', '$status')";
    
    if(mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil disimpan!'); window.location='../../dashboard.php?menu=kamar';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data!'); window.history.back();</script>";
    }
}

// PROSES UPDATE (EDIT)
if(isset($_POST['update'])) {
    $id_kamar = $_POST['id_kamar'];
    $tipe_kamar = $_POST['tipe_kamar'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    
    $query = "UPDATE tbl_kamar SET tipe_kamar='$tipe_kamar', harga='$harga', status='$status' WHERE id_kamar='$id_kamar'";
    
    if(mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='../../dashboard.php?menu=kamar';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data!'); window.history.back();</script>";
    }
}

// PROSES HAPUS
if(isset($_GET['menu']) && $_GET['menu'] == 'hapuskamar') {
    $id = $_GET['id'];
    
    $query = "DELETE FROM tbl_kamar WHERE id_kamar='$id'";
    
    if(mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='../../dashboard.php?menu=kamar';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.history.back();</script>";
    }
}
?>