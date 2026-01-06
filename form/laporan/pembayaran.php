<?php
// form/laporan/pembayaran.php
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
                    <button type="button" class="btn btn-success btn-sm" onclick="printLaporanPembayaran()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="exportToExcelPembayaran()">
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
                                    <input type="hidden" name="menu" value="laporan_pembayaran">
                                    
                                    <div class="form-group mr-3 mb-2">
                                        <label for="filter_tanggal_mulai" class="mr-2">Tanggal Mulai:</label>
                                        <input type="date" class="form-control" id="filter_tanggal_mulai" name="tanggal_mulai"
                                               value="<?php echo isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : ''; ?>">
                                    </div>
                                    
                                    <div class="form-group mr-3 mb-2">
                                        <label for="filter_tanggal_selesai" class="mr-2">Tanggal Selesai:</label>
                                        <input type="date" class="form-control" id="filter_tanggal_selesai" name="tanggal_selesai"
                                               value="<?php echo isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : ''; ?>">
                                    </div>
                                    
                                    <div class="form-group mr-3 mb-2">
                                        <label for="filter_status" class="mr-2">Status:</label>
                                        <select class="form-control" id="filter_status" name="status">
                                            <option value="">Semua Status</option>
                                            <option value="lunas" <?php echo (isset($_GET['status']) && $_GET['status'] == 'lunas') ? 'selected' : ''; ?>>Lunas</option>
                                            <option value="belum lunas" <?php echo (isset($_GET['status']) && $_GET['status'] == 'belum lunas') ? 'selected' : ''; ?>>Belum Lunas</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group mr-3 mb-2">
                                        <label for="filter_metode" class="mr-2">Metode:</label>
                                        <select class="form-control" id="filter_metode" name="metode">
                                            <option value="">Semua Metode</option>
                                            <option value="Transfer Bank" <?php echo (isset($_GET['metode']) && $_GET['metode'] == 'Transfer Bank') ? 'selected' : ''; ?>>Transfer Bank</option>
                                            <option value="Tunai" <?php echo (isset($_GET['metode']) && $_GET['metode'] == 'Tunai') ? 'selected' : ''; ?>>Tunai</option>
                                            <option value="Kartu Kredit" <?php echo (isset($_GET['metode']) && $_GET['metode'] == 'Kartu Kredit') ? 'selected' : ''; ?>>Kartu Kredit</option>
                                        </select>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary mb-2">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <a href="dashboard.php?menu=laporan_pembayaran" class="btn btn-secondary mb-2 ml-2">
                                        <i class="fas fa-redo"></i> Reset
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statistik Pembayaran -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <?php
                                $query_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tbl_pembayaran");
                                $total_pembayaran = mysqli_fetch_array($query_total)['total'];
                                ?>
                                <h3><?php echo $total_pembayaran; ?></h3>
                                <p>Total Pembayaran</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-bill"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <?php
                                $query_lunas = mysqli_query($koneksi, "
                                    SELECT COUNT(*) as lunas 
                                    FROM tbl_pembayaran 
                                    WHERE status = 'lunas'
                                ");
                                $pembayaran_lunas = mysqli_fetch_array($query_lunas)['lunas'];
                                ?>
                                <h3><?php echo $pembayaran_lunas; ?></h3>
                                <p>Pembayaran Lunas</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <?php
                                $query_belum = mysqli_query($koneksi, "
                                    SELECT COUNT(*) as belum 
                                    FROM tbl_pembayaran 
                                    WHERE status = 'belum lunas'
                                ");
                                $pembayaran_belum = mysqli_fetch_array($query_belum)['belum'];
                                ?>
                                <h3><?php echo $pembayaran_belum; ?></h3>
                                <p>Belum Lunas</p>
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
                                    FROM tbl_pembayaran 
                                    WHERE MONTH(tanggal_bayar) = MONTH(CURDATE())
                                    AND YEAR(tanggal_bayar) = YEAR(CURDATE())
                                ");
                                $pembayaran_bulan = mysqli_fetch_array($query_bulan)['bulan_ini'];
                                ?>
                                <h3><?php echo $pembayaran_bulan; ?></h3>
                                <p>Bulan Ini</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tabel Laporan -->
                <div class="table-responsive" id="tabelLaporanPembayaran">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">ID Pembayaran</th>
                                <th width="10%">ID Reservasi</th>
                                <th width="15%">Nama Tamu</th>
                                <th width="10%">Tanggal Bayar</th>
                                <th width="10%">Metode</th>
                                <th width="12%">Total Reservasi</th>
                                <th width="8%">Status</th>
                                <th width="10%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Build filter query
                            $filter_sql = "";
                            $title_filter = "SEMUA PEMBAYARAN";
                            
                            if (isset($_GET['tanggal_mulai']) && !empty($_GET['tanggal_mulai'])) {
                                $filter_sql .= " AND p.tanggal_bayar >= '" . $_GET['tanggal_mulai'] . "'";
                                $title_filter = "DARI " . date('d/m/Y', strtotime($_GET['tanggal_mulai']));
                            }
                            
                            if (isset($_GET['tanggal_selesai']) && !empty($_GET['tanggal_selesai'])) {
                                $filter_sql .= " AND p.tanggal_bayar <= '" . $_GET['tanggal_selesai'] . "'";
                                $title_filter .= " SAMPAI " . date('d/m/Y', strtotime($_GET['tanggal_selesai']));
                            }
                            
                            if (isset($_GET['status']) && !empty($_GET['status'])) {
                                $filter_sql .= " AND p.status = '" . $_GET['status'] . "'";
                                $title_filter .= " - STATUS: " . strtoupper($_GET['status']);
                            }
                            
                            if (isset($_GET['metode']) && !empty($_GET['metode'])) {
                                $filter_sql .= " AND p.metode = '" . $_GET['metode'] . "'";
                                $title_filter .= " - METODE: " . $_GET['metode'];
                            }
                            
                            $sql = "
                                SELECT 
                                    p.id_pembayaran,
                                    p.metode,
                                    p.tanggal_bayar,
                                    p.status,
                                    r.id_reservasi,
                                    t.nama as nama_tamu,
                                    k.harga,
                                    r.jumlah_malam,
                                    (k.harga * r.jumlah_malam) as total_reservasi
                                FROM tbl_pembayaran p
                                LEFT JOIN tbl_reservasi r ON p.id_reservasi = r.id_reservasi
                                LEFT JOIN tbl_tamu t ON r.id_tamu = t.id_tamu
                                LEFT JOIN tbl_kamar k ON r.id_kamar = k.id_kamar
                                WHERE 1=1 $filter_sql
                                ORDER BY p.tanggal_bayar DESC
                            ";
                            
                            $query = mysqli_query($koneksi, $sql);
                            $no = 1;
                            $total_pembayaran = 0;
                            $total_lunas = 0;
                            $total_belum = 0;
                            
                            while($data = mysqli_fetch_array($query)) {
                                $total_pembayaran += $data['total_reservasi'];
                                if ($data['status'] == 'lunas') {
                                    $total_lunas += $data['total_reservasi'];
                                } else {
                                    $total_belum += $data['total_reservasi'];
                                }
                                
                                $status_class = ($data['status'] == 'lunas') ? 'badge bg-success' : 'badge bg-warning';
                                $keterangan = ($data['status'] == 'lunas') ? 'LUNAS' : 'BELUM LUNAS';
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td class="text-center">
                                    <strong>PYM<?php echo str_pad($data['id_pembayaran'], 4, '0', STR_PAD_LEFT); ?></strong>
                                </td>
                                <td class="text-center">
                                    RSV<?php echo str_pad($data['id_reservasi'], 4, '0', STR_PAD_LEFT); ?>
                                </td>
                                <td><?php echo $data['nama_tamu']; ?></td>
                                <td class="text-center">
                                    <?php echo date('d/m/Y', strtotime($data['tanggal_bayar'])); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $data['metode']; ?>
                                </td>
                                <td class="text-right">
                                    <strong>Rp <?php echo number_format($data['total_reservasi'], 0, ',', '.'); ?></strong>
                                </td>
                                <td class="text-center">
                                    <span class="<?php echo $status_class; ?>">
                                        <?php echo strtoupper($data['status']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <small><?php echo $keterangan; ?></small>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <th colspan="6" class="text-right">TOTAL PEMBAYARAN:</th>
                                <th class="text-right">
                                    <strong>Rp <?php echo number_format($total_pembayaran, 0, ',', '.'); ?></strong>
                                </th>
                                <th colspan="2" class="text-center">
                                    <strong><?php echo mysqli_num_rows($query); ?> Transaksi</strong>
                                </th>
                            </tr>
                            <tr class="bg-success text-white">
                                <th colspan="6" class="text-right">TOTAL LUNAS:</th>
                                <th class="text-right">
                                    <strong>Rp <?php echo number_format($total_lunas, 0, ',', '.'); ?></strong>
                                </th>
                                <th colspan="2" class="text-center">
                                    <i class="fas fa-check-circle"></i> Lunas
                                </th>
                            </tr>
                            <tr class="bg-warning">
                                <th colspan="6" class="text-right">TOTAL BELUM LUNAS:</th>
                                <th class="text-right">
                                    <strong>Rp <?php echo number_format($total_belum, 0, ',', '.'); ?></strong>
                                </th>
                                <th colspan="2" class="text-center">
                                    <i class="fas fa-clock"></i> Belum Lunas
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Grafik Laporan -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-bar"></i> Pembayaran per Bulan
                                </h3>
                            </div>
                            <div class="card-body">
                                <canvas id="grafikPembayaranBulanan" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie"></i> Metode Pembayaran
                                </h3>
                            </div>
                            <div class="card-body">
                                <canvas id="grafikMetodePembayaran" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Laporan:</strong> <?php echo $title_filter; ?>
                        | <strong>Total Data:</strong> <?php echo mysqli_num_rows($query); ?> transaksi
                        | <strong>Total Nilai:</strong> Rp <?php echo number_format($total_pembayaran, 0, ',', '.'); ?>
                    </div>
                    <div class="col-md-6 text-right">
                        <small class="text-muted">
                            Dicetak pada: <?php echo date('d/m/Y H:i:s'); ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Data untuk grafik pembayaran
document.addEventListener('DOMContentLoaded', function() {
    <?php
    // Query untuk grafik pembayaran per bulan
    $grafik_query = mysqli_query($koneksi, "
        SELECT 
            MONTH(tanggal_bayar) as bulan,
            COUNT(*) as jumlah_transaksi,
            SUM(k.harga * r.jumlah_malam) as total_nilai
        FROM tbl_pembayaran p
        LEFT JOIN tbl_reservasi r ON p.id_reservasi = r.id_reservasi
        LEFT JOIN tbl_kamar k ON r.id_kamar = k.id_kamar
        WHERE YEAR(tanggal_bayar) = YEAR(CURDATE())
        AND p.status = 'lunas'
        GROUP BY MONTH(tanggal_bayar)
        ORDER BY bulan
    ");
    
    $bulan_labels = [];
    $transaksi_data = [];
    $nilai_data = [];
    
    // Default data untuk 12 bulan
    for ($i = 1; $i <= 12; $i++) {
        $bulan_labels[] = date('F', mktime(0, 0, 0, $i, 1));
        $transaksi_data[] = 0;
        $nilai_data[] = 0;
    }
    
    while($row = mysqli_fetch_array($grafik_query)) {
        $bulan_index = $row['bulan'] - 1;
        if (isset($transaksi_data[$bulan_index])) {
            $transaksi_data[$bulan_index] = $row['jumlah_transaksi'];
            $nilai_data[$bulan_index] = $row['total_nilai'];
        }
    }
    ?>
    
    // Grafik Pembayaran Bulanan
    var ctxBar = document.getElementById('grafikPembayaranBulanan').getContext('2d');
    var grafikPembayaranBulanan = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($bulan_labels); ?>,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: <?php echo json_encode($transaksi_data); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                yAxisID: 'y'
            }, {
                label: 'Nilai (juta Rp)',
                data: <?php echo json_encode(array_map(function($val) { return $val / 1000000; }, $nilai_data)); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                type: 'line',
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Jumlah Transaksi'
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Nilai (juta Rp)'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });
    
    <?php
    // Query untuk metode pembayaran
    $metode_query = mysqli_query($koneksi, "
        SELECT 
            metode,
            COUNT(*) as jumlah,
            SUM(k.harga * r.jumlah_malam) as total_nilai
        FROM tbl_pembayaran p
        LEFT JOIN tbl_reservasi r ON p.id_reservasi = r.id_reservasi
        LEFT JOIN tbl_kamar k ON r.id_kamar = k.id_kamar
        WHERE p.status = 'lunas'
        GROUP BY metode
    ");
    
    $metode_labels = [];
    $metode_data = [];
    $metode_colors = ['#28a745', '#ffc107', '#dc3545', '#17a2b8'];
    
    while($row = mysqli_fetch_array($metode_query)) {
        $metode_labels[] = $row['metode'];
        $metode_data[] = $row['jumlah'];
    }
    ?>
    
    // Grafik Metode Pembayaran
    var ctxPie = document.getElementById('grafikMetodePembayaran').getContext('2d');
    var grafikMetodePembayaran = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($metode_labels); ?>,
            datasets: [{
                data: <?php echo json_encode($metode_data); ?>,
                backgroundColor: <?php echo json_encode($metode_colors); ?>,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});

// Fungsi untuk Print Laporan Pembayaran
function printLaporanPembayaran() {
    var printContent = document.getElementById('tabelLaporanPembayaran').innerHTML;
    var printTitle = "LAPORAN PEMBAYARAN - <?php echo $title_filter; ?>";
    var totalNilai = "Rp <?php echo number_format($total_pembayaran, 0, ',', '.'); ?>";
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>${printTitle}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h2 { text-align: center; color: #333; }
                h4 { text-align: center; color: #666; margin-bottom: 30px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 11px; }
                th { background-color: #343a40; color: white; padding: 8px; text-align: left; }
                td { padding: 6px; border: 1px solid #ddd; }
                .text-right { text-align: right; }
                .text-center { text-align: center; }
                .footer { margin-top: 50px; }
                .bg-success { background-color: #d4edda !important; }
                .bg-warning { background-color: #fff3cd !important; }
                @media print {
                    body { margin: 0; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <h2>LAPORAN PEMBAYARAN</h2>
            <h4>HOTEL MANAGEMENT SYSTEM</h4>
            <p><strong>Periode:</strong> <?php echo $title_filter; ?></p>
            <p><strong>Total Nilai:</strong> ${totalNilai}</p>
            ${printContent}
            <div class="footer">
                <p>Total Data: <?php echo mysqli_num_rows($query); ?> transaksi</p>
                <p>Dicetak pada: <?php echo date('d/m/Y H:i:s'); ?></p>
            </div>
            <div style="margin-top: 100px;">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="width: 50%;"></td>
                        <td style="text-align: center;">
                            <p>Mengetahui,</p>
                            <br><br><br>
                            <p><strong>Manager Hotel</strong></p>
                        </td>
                    </tr>
                </table>
            </div>
            <script>
                window.onload = function() {
                    window.print();
                    setTimeout(function() {
                        window.close();
                    }, 1000);
                }
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}

// Fungsi untuk Export ke Excel
function exportToExcelPembayaran() {
    var table = document.getElementById('tabelLaporanPembayaran');
    var html = table.outerHTML;
    
    var blob = new Blob([html], { type: 'application/vnd.ms-excel' });
    var link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'Laporan_Pembayaran_<?php echo date('Y-m-d'); ?>.xls';
    link.click();
}

// Fungsi untuk Export ke PDF
function exportToPDFPembayaran() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'pt', 'a4'); // landscape mode
    
    // Header
    doc.setFontSize(16);
    doc.text('LAPORAN PEMBAYARAN', 40, 40);
    doc.setFontSize(12);
    doc.text('HOTEL MANAGEMENT SYSTEM', 40, 60);
    doc.text('Periode: <?php echo $title_filter; ?>', 40, 80);
    doc.text('Total Nilai: Rp <?php echo number_format($total_pembayaran, 0, ",", "."); ?>', 40, 100);
    
    // Tabel
    doc.autoTable({
        html: '#tabelLaporanPembayaran',
        startY: 120,
        theme: 'grid',
        styles: {
            fontSize: 8,
            cellPadding: 2
        },
        headStyles: {
            fillColor: [52, 58, 64]
        }
    });
    
    // Footer
    const finalY = doc.lastAutoTable.finalY + 20;
    doc.text(`Total Data: <?php echo mysqli_num_rows($query); ?> transaksi`, 40, finalY);
    doc.text(`Dicetak pada: <?php echo date('d/m/Y H:i:s'); ?>`, 40, finalY + 20);
    
    // Summary
    doc.setFillColor(211, 237, 218);
    doc.rect(40, finalY + 40, 500, 20, 'F');
    doc.text('Total Lunas: Rp <?php echo number_format($total_lunas, 0, ",", "."); ?>', 45, finalY + 55);
    
    doc.setFillColor(255, 243, 205);
    doc.rect(40, finalY + 70, 500, 20, 'F');
    doc.text('Total Belum Lunas: Rp <?php echo number_format($total_belum, 0, ",", "."); ?>', 45, finalY + 85);
    
    // Tanda tangan
    doc.text('Mengetahui,', 500, finalY + 120);
    doc.text('________________________', 500, finalY + 160);
    doc.text('Manager Hotel', 500, finalY + 180);
    
    doc.save('Laporan_Pembayaran_<?php echo date('Y-m-d'); ?>.pdf');
}
</script>