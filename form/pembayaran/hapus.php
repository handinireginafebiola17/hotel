<?php
include "../../koneksi.php";
mysqli_query($koneksi,"DELETE FROM tbl_pembayaran WHERE id_pembayaran='$_GET[id]'");
header("location:../../dashboard.php?menu=pembayaran");
