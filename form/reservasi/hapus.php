<?php
include "../../koneksi.php";
mysqli_query($koneksi,"DELETE FROM tbl_reservasi WHERE id_reservasi='$_GET[id]'");
header("location:../../dashboard.php?menu=reservasi");
