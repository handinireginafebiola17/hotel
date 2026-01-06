<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];
    
    // Cek apakah email ada di database
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_login WHERE email = '$email'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        
        // Verifikasi password
        if (password_verify($password, $data['password'])) {
            // Set session
            $_SESSION['id'] = $data['id'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['role'] = $data['role'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['username'] = $data['email'];
            
            // Redirect ke dashboard
            header('location: dashboard.php');
            exit();
        } else {
            // Password salah
            header('location: index.php?error=1');
            exit();
        }
    } else {
        // Email tidak ditemukan
        header('location: index.php?error=1');
        exit();
    }
} else {
    // Bukan POST request
    header('location: index.php');
    exit();
}
?>