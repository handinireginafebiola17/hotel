<?php
// form/laporan/reservasi.php
?>

<!-- Tambahkan library yang diperlukan DI HEADER atau SEBELUM SCRIPT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-check"></i> Laporan Reservasi
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success btn-sm" onclick="printLaporanReservasi()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="exportToExcelReservasi()">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Filter Laporan -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-filter"></i> Filter Laporan
                                </h3>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="" class="form-inline">
                                    <input type="hidden" name="menu" value="laporan_reservasi">
                                    
                                    <div class="form-group mr-3 mb-2">
                                        <label for="filter_tanggal_mulai" class="mr-2">Check-in Dari:</label>
                                        <input type="date" class="form-control" id="filter_tanggal_mulai" name="tanggal_mulai"
                                               value="<?php echo isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : ''; ?>">
                                    </div>
                                    
                                    <div class="form-group mr-3 mb-2">
                                        <label for="filter_tanggal_selesai" class="mr-2">Sampai:</label>
                                        <input type="date" class="form-control" id="filter_tanggal_selesai" name="tanggal_selesai"
                                               value="<?php echo isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : ''; ?>">
                                    </div>
                                    
                                    <div class="form-group mr-3 mb-2">
                                        <label for="filter_status" class="mr-2">Status:</label>
                                        <select class="form-control" id="filter_status" name="status">
                                            <option value="">Semua Status</option>
                                            <option value="pending" <?php echo (isset($_GET['status']) && $_GET['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="confirmed" <?php echo (isset($_GET['status']) && $_GET['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                            <option value="cancelled" <?php echo (isset($_GET['status']) && $_GET['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group mr-3 mb-2">
                                        <label for="filter_tipe_kamar" class="mr-2">Tipe Kamar:</label>
                                        <select class="form-control" id="filter_tipe_kamar" name="tipe_kamar">
                                            <option value="">Semua Tipe</option>
                                            <?php
                                            $query_tipe = mysqli_query($koneksi, "SELECT DISTINCT tipe_kamar FROM tbl_kamar ORDER BY tipe_kamar");
                                            while($tipe = mysqli_fetch_array($query_tipe)) {
                                                $selected = (isset($_GET['tipe_kamar']) && $_GET['tipe_kamar'] == $tipe['tipe_kamar']) ? 'selected' : '';
                                                echo '<option value="'.$tipe['tipe_kamar'].'" '.$selected.'>'.$tipe['tipe_kamar'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary mb-2">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <a href="dashboard.php?menu=laporan_reservasi" class="btn btn-secondary mb-2 ml-2">
                                        <i class="fas fa-redo"></i> Reset
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statistik Reservasi -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <?php
                                $query_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tbl_reservasi");
                                $total_reservasi = mysqli_fetch_array($query_total)['total'];
                                ?>
                                <h3><?php echo $total_reservasi; ?></h3>
                                <p>Total Reservasi</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <?php
                                $query_aktif = mysqli_query($koneksi, "
                                    SELECT COUNT(*) as aktif 
                                    FROM tbl_reservasi 
                                    WHERE status = 'confirmed' 
                                    AND tgl_checkout >= CURDATE()
                                ");
                                $reservasi_aktif = mysqli_fetch_array($query_aktif)['aktif'];
                                ?>
                                <h3><?php echo $reservasi_aktif; ?></h3>
                                <p>Reservasi Aktif</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <?php
                                $query_pending = mysqli_query($koneksi, "
                                    SELECT COUNT(*) as pending 
                                    FROM tbl_reservasi 
                                    WHERE status = 'pending'
                                ");
                                $reservasi_pending = mysqli_fetch_array($query_pending)['pending'];
                                ?>
                                <h3><?php echo $reservasi_pending; ?></h3>
                                <p>Reservasi Pending</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <?php
                                $query_bulan = mysqli_query($koneksi, "
                                    SELECT COUNT(*) as bulan_ini 
                                    FROM tbl_reservasi 
                                    WHERE MONTH(tgl_checkin) = MONTH(CURDATE())
                                    AND YEAR(tgl_checkin) = YEAR(CURDATE())
                                ");
                                $reservasi_bulan = mysqli_fetch_array($query_bulan)['bulan_ini'];
                                ?>
                                <h3><?php echo $reservasi_bulan; ?></h3>
                                <p>Reservasi Bulan Ini</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tabel Laporan -->
                <div class="table-responsive" id="tabelLaporanReservasi">
                    <table class="table table-bordered table-striped" id="tableReservasi">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">ID Reservasi</th>
                                <th width="15%">Nama Tamu</th>
                                <th width="12%">Tipe Kamar</th>
                                <th width="10%">Check-in</th>
                                <th width="10%">Check-out</th>
                                <th width="8%">Malam</th>
                                <th width="12%">Harga/Malam</th>
                                <th width="12%">Total</th>
                                <th width="6%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Build filter query
                            $filter_sql = "";
                            $title_filter = "SEMUA RESERVASI";
                            
                            if (isset($_GET['tanggal_mulai']) && !empty($_GET['tanggal_mulai'])) {
                                $filter_sql .= " AND r.tgl_checkin >= '" . $_GET['tanggal_mulai'] . "'";
                                $title_filter = "RESERVASI DARI " . date('d/m/Y', strtotime($_GET['tanggal_mulai']));
                            }
                            
                            if (isset($_GET['tanggal_selesai']) && !empty($_GET['tanggal_selesai'])) {
                                $filter_sql .= " AND r.tgl_checkin <= '" . $_GET['tanggal_selesai'] . "'";
                                $title_filter .= " SAMPAI " . date('d/m/Y', strtotime($_GET['tanggal_selesai']));
                            }
                            
                            if (isset($_GET['status']) && !empty($_GET['status'])) {
                                $filter_sql .= " AND r.status = '" . $_GET['status'] . "'";
                                $title_filter .= " - STATUS: " . strtoupper($_GET['status']);
                            }
                            
                            if (isset($_GET['tipe_kamar']) && !empty($_GET['tipe_kamar'])) {
                                $filter_sql .= " AND k.tipe_kamar = '" . $_GET['tipe_kamar'] . "'";
                                $title_filter .= " - TIPE: " . $_GET['tipe_kamar'];
                            }
                            
                            $sql = "
                                SELECT 
                                    r.id_reservasi,
                                    r.tgl_checkin,
                                    r.tgl_checkout,
                                    r.jumlah_malam,
                                    r.status,
                                    t.nama as nama_tamu,
                                    k.tipe_kamar,
                                    k.harga,
                                    (k.harga * r.jumlah_malam) as total_harga
                                FROM tbl_reservasi r
                                LEFT JOIN tbl_tamu t ON r.id_tamu = t.id_tamu
                                LEFT JOIN tbl_kamar k ON r.id_kamar = k.id_kamar
                                WHERE 1=1 $filter_sql
                                ORDER BY r.tgl_checkin DESC
                            ";
                            
                            $query = mysqli_query($koneksi, $sql);
                            $no = 1;
                            $total_pendapatan = 0;
                            $confirmed_count = 0;
                            $pending_count = 0;
                            $cancelled_count = 0;
                            
                            while($data = mysqli_fetch_array($query)) {
                                $total_pendapatan += $data['total_harga'];
                                
                                // Hitung status
                                switch($data['status']) {
                                    case 'confirmed': $confirmed_count++; break;
                                    case 'pending': $pending_count++; break;
                                    case 'cancelled': $cancelled_count++; break;
                                }
                                
                                $status_class = '';
                                switch($data['status']) {
                                    case 'confirmed': $status_class = 'badge bg-success'; break;
                                    case 'pending': $status_class = 'badge bg-warning'; break;
                                    case 'cancelled': $status_class = 'badge bg-danger'; break;
                                }
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td class="text-center">
                                    <strong>RSV<?php echo str_pad($data['id_reservasi'], 4, '0', STR_PAD_LEFT); ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo $data['nama_tamu']; ?></strong>
                                </td>
                                <td><?php echo $data['tipe_kamar']; ?></td>
                                <td class="text-center">
                                    <?php echo date('d/m/Y', strtotime($data['tgl_checkin'])); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo date('d/m/Y', strtotime($data['tgl_checkout'])); ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info"><?php echo $data['jumlah_malam']; ?> malam</span>
                                </td>
                                <td class="text-right">
                                    Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?>
                                </td>
                                <td class="text-right">
                                    <strong>Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?></strong>
                                </td>
                                <td class="text-center">
                                    <span class="<?php echo $status_class; ?>">
                                        <?php echo strtoupper($data['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <th colspan="8" class="text-right">TOTAL RESERVASI:</th>
                                <th class="text-right">
                                    <strong>Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></strong>
                                </th>
                                <th class="text-center">
                                    <strong><?php echo mysqli_num_rows($query); ?> Data</strong>
                                </th>
                            </tr>
                            <tr class="bg-success text-white">
                                <th colspan="8" class="text-right">CONFIRMED:</th>
                                <th class="text-right">
                                    <?php
                                    $total_confirmed = 0;
                                    // Hitung total confirmed
                                    $sql_confirmed = str_replace("WHERE 1=1", "WHERE r.status = 'confirmed'", $sql);
                                    $query_confirmed = mysqli_query($koneksi, $sql_confirmed);
                                    while($row = mysqli_fetch_array($query_confirmed)) {
                                        $total_confirmed += $row['total_harga'];
                                    }
                                    ?>
                                    <strong>Rp <?php echo number_format($total_confirmed, 0, ',', '.'); ?></strong>
                                </th>
                                <th class="text-center">
                                    <strong><?php echo $confirmed_count; ?> Reservasi</strong>
                                </th>
                            </tr>
                            <tr class="bg-warning">
                                <th colspan="8" class="text-right">PENDING:</th>
                                <th class="text-right">
                                    <?php
                                    $total_pending = 0;
                                    // Hitung total pending
                                    $sql_pending = str_replace("WHERE 1=1", "WHERE r.status = 'pending'", $sql);
                                    $query_pending = mysqli_query($koneksi, $sql_pending);
                                    while($row = mysqli_fetch_array($query_pending)) {
                                        $total_pending += $row['total_harga'];
                                    }
                                    ?>
                                    <strong>Rp <?php echo number_format($total_pending, 0, ',', '.'); ?></strong>
                                </th>
                                <th class="text-center">
                                    <strong><?php echo $pending_count; ?> Reservasi</strong>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <script>
function printLaporanReservasi() {
    var printContents = document.getElementById('tabelLaporanReservasi').innerHTML;
    var win = window.open('', '', 'height=700,width=900');

    win.document.write('<html><head><title>Laporan Reservasi</title>');
    win.document.write(`
        <style>
            table { width:100%; border-collapse: collapse; }
            table, th, td { border:1px solid #000; }
            th, td { padding:8px; font-size:12px; }
            th { background:#f2f2f2; }
        </style>
    `);
    win.document.write('</head><body>');
    win.document.write('<h3 style="text-align:center">LAPORAN RESERVASI</h3>');
    win.document.write(printContents);
    win.document.write('</body></html>');

    win.document.close();
    win.print();
}


function exportToExcelReservasi() {
    if (typeof XLSX === 'undefined') {
        alert('Library Excel belum termuat!');
        return;
    }

    var table = document.getElementById('tableReservasi');
    if (!table) {
        alert('Tabel tidak ditemukan');
        return;
    }

    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.table_to_sheet(table);

    XLSX.utils.book_append_sheet(wb, ws, 'Laporan Reservasi');
    XLSX.writeFile(wb, 'laporan_reservasi.xlsx');
}

</script>
