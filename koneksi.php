<?php
$host  = "localhost";
$user  = "root";
$pass  = "";
$dbase = "db_hotel";
$port  = 3307;

// Buat koneksi
$koneksi = mysqli_connect($host, $user, $pass, $dbase, $port);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($koneksi, "utf8");

// Timezone
date_default_timezone_set('Asia/Jakarta');
?>