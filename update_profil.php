<?php
// update_profile.php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $username = $_SESSION['username'];
    
    // Update nama di database
    $query = "UPDATE users SET nama = '$nama' WHERE username = '$username'";
    mysqli_query($koneksi, $query);
    
    // Update session
    $_SESSION['nama'] = $nama;
    
    // Redirect ke profile dengan pesan sukses
    header('Location: dashboard.php?menu=profile&success=1');
    exit;
}
?>