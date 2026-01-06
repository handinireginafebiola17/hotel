<?php
include "../../koneksi.php";

mysqli_query($koneksi,"UPDATE tbl_pembayaran SET
id_reservasi='$_POST[id_reservasi]',
metode='$_POST[metode]',
tanggal_bayar='$_POST[tanggal_bayar]',
status='$_POST[status]'
WHERE id_pembayaran='$_POST[id_pembayaran]'");

header("location:../../dashboard.php?menu=pembayaran");
