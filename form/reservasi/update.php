<?php
include "../../koneksi.php";

mysqli_query($koneksi,"UPDATE tbl_reservasi SET
id_tamu='$_POST[id_tamu]',
id_kamar='$_POST[id_kamar]',
tgl_checkin='$_POST[tgl_checkin]',
tgl_checkout='$_POST[tgl_checkout]',
jumlah_malam='$_POST[jumlah_malam]',
status='$_POST[status]'
WHERE id_reservasi='$_POST[id_reservasi]'");

header("location:../../dashboard.php?menu=reservasi");
