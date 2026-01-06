<?php
// form/laporan/tamu.php
// Tambahkan kode ini DI ATAS kode HTML yang sudah ada
?>

<!-- Tambahkan library yang diperlukan DI HEADER atau SEBELUM SCRIPT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-money-bill-wave"></i> Laporan Pembayaran
                </h3>
                <div class="card-tools">
    <button type="button" class="btn btn-success btn-sm" onclick="printLaporanTamu()">
        <i class="fas fa-print"></i> Print
    </button>
    <button type="button" class="btn btn-info btn-sm" onclick="exportToExcelTamu()">
    <i class="fas fa-file-excel"></i> Excel
</button>

</div>

            </div>
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
                                    <input type="hidden" name="menu" value="laporan_tamu">
                                    
                                    <div class="form-group mr-3 mb-2">
                                        <label for="filter_tanggal" class="mr-2">Tanggal Registrasi:</label>
                                        <input type="date" class="form-control" id="filter_tanggal" name="tanggal"
                                               value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : ''; ?>">
                                    </div>
                                    
                                    <div class="form-group mr-3 mb-2">
                                        <label for="filter_bulan" class="mr-2">Bulan:</label>
                                        <input type="month" class="form-control" id="filter_bulan" name="bulan"
                                               value="<?php echo isset($_GET['bulan']) ? $_GET['bulan'] : ''; ?>">
                                    </div>
                                    
                                    <div class="form-group mr-3 mb-2">
                                        <label for="filter_tahun" class="mr-2">Tahun:</label>
                                        <select class="form-control" id="filter_tahun" name="tahun">
                                            <option value="">Semua Tahun</option>
                                            <?php
                                            $current_year = date('Y');
                                            for ($year = $current_year; $year >= $current_year - 5; $year--) {
                                                $selected = (isset($_GET['tahun']) && $_GET['tahun'] == $year) ? 'selected' : '';
                                                echo "<option value='$year' $selected>$year</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary mb-2">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <a href="dashboard.php?menu=laporan_tamu" class="btn btn-secondary mb-2 ml-2">
                                        <i class="fas fa-redo"></i> Reset
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statistik Tamu -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <?php
                                $query_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tbl_tamu");
                                $total_tamu = mysqli_fetch_array($query_total)['total'];
                                ?>
                                <h3><?php echo $total_tamu; ?></h3>
                                <p>Total Tamu</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <?php
                                $query_aktif = mysqli_query($koneksi, "
                                    SELECT COUNT(DISTINCT r.id_tamu) as aktif 
                                    FROM tbl_reservasi r 
                                    WHERE r.status = 'confirmed' 
                                    AND r.tgl_checkout >= CURDATE()
                                ");
                                $tamu_aktif = mysqli_fetch_array($query_aktif)['aktif'];
                                ?>
                                <h3><?php echo $tamu_aktif; ?></h3>
                                <p>Tamu Aktif</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <?php
                                $query_bulan = mysqli_query($koneksi, "
                                    SELECT COUNT(*) as bulan_ini 
                                    FROM tbl_tamu 
                                    WHERE MONTH(CURDATE()) = MONTH(CURDATE())
                                    AND YEAR(CURDATE()) = YEAR(CURDATE())
                                ");
                                $tamu_bulan_ini = mysqli_fetch_array($query_bulan)['bulan_ini'];
                                ?>
                                <h3><?php echo $tamu_bulan_ini; ?></h3>
                                <p>Tamu Bulan Ini</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <?php
                                $query_reservasi = mysqli_query($koneksi, "
                                    SELECT COUNT(DISTINCT id_tamu) as pernah_reservasi 
                                    FROM tbl_reservasi
                                ");
                                $tamu_reservasi = mysqli_fetch_array($query_reservasi)['pernah_reservasi'];
                                ?>
                                <h3><?php echo $tamu_reservasi; ?></h3>
                                <p>Tamu Pernah Reservasi</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tabel Laporan -->
                <div class="table-responsive" id="tabelLaporanTamu">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">ID Tamu</th>
                                <th width="20%">Nama Lengkap</th>
                                <th width="15%">No Telepon</th>
                                <th width="25%">Alamat</th>
                                <th width="10%">Total Reservasi</th>
                                <th width="15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Build filter query
                            $filter_sql = "";
                            $title_filter = "SEMUA TAMU";
                            
                            if (isset($_GET['tanggal']) && !empty($_GET['tanggal'])) {
                                // Tidak bisa filter tanggal karena tidak ada kolom tanggal_registrasi
                                // Untuk sementara kita anggap semua data
                            }
                            
                            if (isset($_GET['bulan']) && !empty($_GET['bulan'])) {
                                $title_filter = "BULAN " . date('F Y', strtotime($_GET['bulan'] . '-01'));
                            }
                            
                            if (isset($_GET['tahun']) && !empty($_GET['tahun'])) {
                                $title_filter = "TAHUN " . $_GET['tahun'];
                            }
                            
                            $sql = "
                                SELECT 
                                    t.*,
                                    COUNT(r.id_reservasi) as jumlah_reservasi,
                                    MAX(r.tgl_checkout) as terakhir_checkout,
                                    CASE 
                                        WHEN MAX(r.tgl_checkout) >= CURDATE() AND r.status = 'confirmed' THEN 'Aktif'
                                        ELSE 'Tidak Aktif'
                                    END as status_tamu
                                FROM tbl_tamu t
                                LEFT JOIN tbl_reservasi r ON t.id_tamu = r.id_tamu
                                GROUP BY t.id_tamu
                                ORDER BY t.id_tamu DESC
                            ";
                            
                            $query = mysqli_query($koneksi, $sql);
                            $no = 1;
                            
                            while($data = mysqli_fetch_array($query)) {
                                $status_class = ($data['status_tamu'] == 'Aktif') ? 'badge bg-success' : 'badge bg-secondary';
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td class="text-center">
                                    <strong>TAMU<?php echo str_pad($data['id_tamu'], 4, '0', STR_PAD_LEFT); ?></strong>
                                </td>
                                <td><?php echo $data['nama']; ?></td>
                                <td><?php echo $data['no_telp']; ?></td>
                                <td><?php echo $data['alamat']; ?></td>
                                <td class="text-center">
                                    <span class="badge bg-info">
                                        <?php echo $data['jumlah_reservasi']; ?> kali
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="<?php echo $status_class; ?>">
                                        <?php echo $data['status_tamu']; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <th colspan="5" class="text-right">TOTAL TAMU:</th>
                                <th colspan="2" class="text-center">
                                    <strong><?php echo mysqli_num_rows($query); ?> Orang</strong>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                


<!-- Untuk Print -->
<div id="printAreaTamu" style="display: none;">
    <div style="padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2>LAPORAN DATA TAMU</h2>
            <h4>HOTEL MANAGEMENT SYSTEM</h4>
            <p>Periode: <?php echo $title_filter; ?></p>
        </div>
        <div id="printContentTamu"></div>
        <div style="margin-top: 50px;">
            <div style="float: right; text-align: center; width: 200px;">
                <p>Mengetahui,</p>
                <br><br><br>
                <p><strong>Manager Hotel</strong></p>
            </div>
            <div style="clear: both;"></div>
        </div>
        <div style="position: fixed; bottom: 10px; width: 100%; text-align: center; font-size: 12px;">
            Dicetak pada: <?php echo date('d/m/Y H:i:s'); ?>
        </div>
    </div>
</div>

<script>
function printLaporanTamu() {
    var printContent = document.getElementById('tabelLaporanTamu').innerHTML;

    var printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Laporan Data Tamu</title>
            <style>
                body { font-family: Arial; margin: 20px; }
                h2, h4 { text-align: center; }
                table { width: 100%; border-collapse: collapse; font-size: 11px; }
                th, td { border: 1px solid #000; padding: 6px; }
                th { background: #333; color: #fff; }
                .text-center { text-align: center; }
            </style>
        </head>
        <body>
            <h2>LAPORAN DATA TAMU</h2>
            <h4>HOTEL MANAGEMENT SYSTEM</h4>
            <p><strong>Periode:</strong> <?php echo $title_filter; ?></p>
            ${printContent}
            <br><br>
            <p>Dicetak pada: <?php echo date('d/m/Y H:i:s'); ?></p>

            <script>
                window.onload = function() {
                    window.print();
                    setTimeout(() => window.close(), 500);
                }
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}
</script>


    <?php
    // Query untuk grafik tamu per bulan (misalnya)
    $grafik_query = mysqli_query($koneksi, "
        SELECT 
            MONTH(CURDATE()) as bulan,
            COUNT(*) as jumlah
        FROM tbl_tamu 
        WHERE YEAR(CURDATE()) = YEAR(CURDATE())
        GROUP BY MONTH(CURDATE())
        ORDER BY bulan
    ");
    
    $bulan_labels = [];
    $bulan_data = [];
    
    // Default data untuk 12 bulan
    for ($i = 1; $i <= 12; $i++) {
        $bulan_labels[] = date('F', mktime(0, 0, 0, $i, 1));
        $bulan_data[] = 0;
    }
    
    while($row = mysqli_fetch_array($grafik_query)) {
        $bulan_index = $row['bulan'] - 1;
        if (isset($bulan_data[$bulan_index])) {
            $bulan_data[$bulan_index] = $row['jumlah'];
        }
    }
    ?>
    


<script>
function exportToExcelTamu() {
    var table = document.getElementById("tabelLaporanTamu");

    if (!table) {
        alert("Tabel tamu tidak ditemukan");
        return;
    }

    var html = table.outerHTML;
    var blob = new Blob([html], {
        type: "application/vnd.ms-excel"
    });

    var link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "Laporan_Tamu_<?php echo date('Y-m-d'); ?>.xls";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>


</script>

