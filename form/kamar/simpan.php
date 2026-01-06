<?php
include "../../koneksi.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $tipe_kamar = mysqli_real_escape_string($koneksi, $_POST['tipe_kamar']);
    $harga = mysqli_real_escape_string($koneksi, str_replace('.', '', $_POST['harga']));
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    $nomor_kamar = isset($_POST['nomor_kamar']) ? mysqli_real_escape_string($koneksi, $_POST['nomor_kamar']) : '';
    $luas_kamar = isset($_POST['luas_kamar']) ? mysqli_real_escape_string($koneksi, $_POST['luas_kamar']) : '0';
    $kapasitas = isset($_POST['kapasitas']) ? mysqli_real_escape_string($koneksi, $_POST['kapasitas']) : '2';
    $keterangan = isset($_POST['keterangan']) ? mysqli_real_escape_string($koneksi, $_POST['keterangan']) : '';
    
    // Proses fasilitas
    $fasilitas_array = isset($_POST['fasilitas']) ? $_POST['fasilitas'] : [];
    $fasilitas_lainnya = isset($_POST['fasilitas_lainnya']) ? mysqli_real_escape_string($koneksi, $_POST['fasilitas_lainnya']) : '';
    
    // Gabungkan fasilitas
    $fasilitas = implode(', ', $fasilitas_array);
    if ($fasilitas_lainnya) {
        $fasilitas .= ($fasilitas ? ', ' : '') . $fasilitas_lainnya;
    }
    
    // Validasi data
    if(empty($tipe_kamar) || empty($harga) || empty($status)) {
        header('location: ../../dashboard.php?menu=addkamar&error=1');
        exit();
    }
    
    // Insert data kamar
    $query = "INSERT INTO tbl_kamar (tipe_kamar, harga, status) 
              VALUES ('$tipe_kamar', '$harga', '$status')";
    
    if(mysqli_query($koneksi, $query)) {
        // Dapatkan ID kamar yang baru dibuat
        $id_kamar = mysqli_insert_id($koneksi);
        
        // Jika ada nomor kamar custom, bisa disimpan di tabel lain
        // Atau bisa ditambahkan kolom nomor_kamar di tabel tbl_kamar
        // Untuk sekarang kita hanya simpan di tabel utama dengan field yang ada
        
        header('location: ../../dashboard.php?menu=kamar&success=1');
    } else {
        header('location: ../../dashboard.php?menu=addkamar&error=3');
    }
} else {
    header('location: ../../dashboard.php?menu=kamar');
}
exit();
?>