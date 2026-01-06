<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bed"></i> Data Kamar
                </h3>
                <div class="card-tools">
                    <a href="dashboard.php?menu=addkamar" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Tambah Kamar
                    </a>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#filterModal">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php
                // Filter parameter
                $filter_status = isset($_GET['status']) ? $_GET['status'] : '';
                $filter_tipe = isset($_GET['tipe']) ? $_GET['tipe'] : '';
                
                // Query dasar dengan filter
                $sql = "SELECT * FROM tbl_kamar WHERE 1=1";
                
                if (!empty($filter_status)) {
                    $sql .= " AND status = '$filter_status'";
                }
                
                if (!empty($filter_tipe)) {
                    $sql .= " AND tipe_kamar LIKE '%$filter_tipe%'";
                }
                
                $sql .= " ORDER BY 
                    CASE 
                        WHEN status = 'tersedia' THEN 1
                        WHEN status = 'dibersihkan' THEN 2
                        WHEN status = 'terisi' THEN 3
                        ELSE 4
                    END,
                    harga DESC";
                
                $query = mysqli_query($koneksi, $sql);
                $total_kamar = mysqli_num_rows($query);
                
                // Hitung statistik
                $tersedia = 0;
                $terisi = 0;
                $dibersihkan = 0;
                $total_harga = 0;
                
                while($data = mysqli_fetch_array($query)) {
                    $total_harga += $data['harga'];
                    switch($data['status']) {
                        case 'tersedia': $tersedia++; break;
                        case 'terisi': $terisi++; break;
                        case 'dibersihkan': $dibersihkan++; break;
                    }
                }
                
                // Reset pointer query
                mysqli_data_seek($query, 0);
                ?>
                
                <!-- Statistik Kamar -->
                <div class="row mb-3">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo $total_kamar; ?></h3>
                                <p>Total Kamar</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-door-closed"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                Semua Kamar <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo $tersedia; ?></h3>
                                <p>Tersedia</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-door-open"></i>
                            </div>
                            <a href="dashboard.php?menu=kamar&status=tersedia" class="small-box-footer">
                                Lihat Kamar <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo $terisi; ?></h3>
                                <p>Terisi</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-bed"></i>
                            </div>
                            <a href="dashboard.php?menu=kamar&status=terisi" class="small-box-footer">
                                Lihat Kamar <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3><?php echo $dibersihkan; ?></h3>
                                <p>Dibersihkan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-broom"></i>
                            </div>
                            <a href="dashboard.php?menu=kamar&status=dibersihkan" class="small-box-footer">
                                Lihat Kamar <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <?php if($total_kamar > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="tabelKamar">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">ID Kamar</th>
                                <th width="20%">Tipe Kamar</th>
                                <th width="15%">Harga per Malam</th>
                                <th width="15%">Status</th>
                                <th width="25%">Informasi</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while($data = mysqli_fetch_array($query)) {
                                // Tentukan warna badge berdasarkan status
                                $status_class = '';
                                $status_text = '';
                                $status_icon = '';
                                
                                switch(strtolower($data['status'])) {
                                    case 'tersedia':
                                        $status_class = 'badge bg-success';
                                        $status_text = 'TERSEDIA';
                                        $status_icon = 'fas fa-check-circle';
                                        break;
                                    case 'terisi':
                                        $status_class = 'badge bg-warning';
                                        $status_text = 'TERISI';
                                        $status_icon = 'fas fa-user-friends';
                                        break;
                                    case 'dibersihkan':
                                        $status_class = 'badge bg-secondary';
                                        $status_text = 'DIBERSIHKAN';
                                        $status_icon = 'fas fa-broom';
                                        break;
                                    default:
                                        $status_class = 'badge bg-light text-dark';
                                        $status_text = strtoupper($data['status']);
                                        $status_icon = 'fas fa-question-circle';
                                }
                                
                                // Tentukan icon tipe kamar
                                $tipe_icon = '';
                                $tipe_color = '';
                                switch(strtolower($data['tipe_kamar'])) {
                                    case 'standard':
                                        $tipe_icon = 'fas fa-star';
                                        $tipe_color = 'text-primary';
                                        break;
                                    case 'deluxe':
                                        $tipe_icon = 'fas fa-crown';
                                        $tipe_color = 'text-warning';
                                        break;
                                    case 'superior':
                                        $tipe_icon = 'fas fa-gem';
                                        $tipe_color = 'text-info';
                                        break;
                                    case 'executive suite':
                                        $tipe_icon = 'fas fa-hotel';
                                        $tipe_color = 'text-danger';
                                        break;
                                    case 'family room':
                                        $tipe_icon = 'fas fa-home';
                                        $tipe_color = 'text-success';
                                        break;
                                    default:
                                        $tipe_icon = 'fas fa-bed';
                                        $tipe_color = 'text-secondary';
                                }
                                
                                // Tentukan fasilitas berdasarkan tipe kamar
                                $fasilitas = '';
                                switch(strtolower($data['tipe_kamar'])) {
                                    case 'standard':
                                        $fasilitas = 'AC, TV, Kamar Mandi, WiFi';
                                        break;
                                    case 'deluxe':
                                        $fasilitas = 'AC, TV LED, Kamar Mandi + Bathtub, WiFi, Mini Bar';
                                        break;
                                    case 'superior':
                                        $fasilitas = 'AC, TV LED 32", Kamar Mandi + Bathtub, WiFi Premium, Mini Bar, Balkon';
                                        break;
                                    case 'executive suite':
                                        $fasilitas = 'AC, TV LED 42", Living Room, Kamar Mandi + Jacuzzi, WiFi Premium, Mini Bar, Balkon, Kitchenette';
                                        break;
                                    case 'family room':
                                        $fasilitas = 'AC (2 unit), TV LED 40", 2 Kamar Tidur, Kamar Mandi, WiFi, Ruang Keluarga, Dapur Kecil';
                                        break;
                                    default:
                                        $fasilitas = 'Fasilitas standar';
                                }
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td class="text-center">
                                    <strong>KMR<?php echo str_pad($data['id_kamar'], 3, '0', STR_PAD_LEFT); ?></strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="<?php echo $tipe_icon . ' ' . $tipe_color; ?> fa-2x me-3"></i>
                                        <div>
                                            <strong><?php echo ucwords($data['tipe_kamar']); ?></strong><br>
                                            <small class="text-muted"><?php echo $fasilitas; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <h5 class="mb-0">
                                        <strong>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></strong>
                                    </h5>
                                    <small class="text-muted">per malam</small>
                                </td>
                                <td class="text-center">
                                    <span class="<?php echo $status_class; ?> p-2">
                                        <i class="<?php echo $status_icon; ?> me-1"></i>
                                        <?php echo $status_text; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-6">
                                            <small>
                                                <i class="fas fa-ruler-combined me-1"></i>
                                                Luas: 
                                                <?php 
                                                switch(strtolower($data['tipe_kamar'])) {
                                                    case 'standard': echo '24 m²'; break;
                                                    case 'deluxe': echo '32 m²'; break;
                                                    case 'superior': echo '40 m²'; break;
                                                    case 'executive suite': echo '60 m²'; break;
                                                    case 'family room': echo '75 m²'; break;
                                                    default: echo '20-30 m²';
                                                }
                                                ?>
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <small>
                                                <i class="fas fa-user-friends me-1"></i>
                                                Kapasitas: 
                                                <?php 
                                                switch(strtolower($data['tipe_kamar'])) {
                                                    case 'family room': echo '4-6 orang'; break;
                                                    default: echo '2 orang';
                                                }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12">
                                            <small>
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                Terakhir Update: <?php echo date('d/m/Y'); ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group-vertical btn-group-sm" role="group">
                                        <a href="dashboard.php?menu=editkamar&id=<?php echo $data['id_kamar']; ?>" 
                                           class="btn btn-warning mb-1" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="form/kamar/hapus.php?id=<?php echo $data['id_kamar']; ?>" 
                                           class="btn btn-danger" title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus kamar ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <th colspan="3" class="text-right">TOTAL KAMAR:</th>
                                <th class="text-right">
                                    <strong><?php echo $total_kamar; ?> Kamar</strong>
                                </th>
                                <th colspan="2" class="text-right">RATA-RATA HARGA:</th>
                                <th class="text-right">
                                    <strong>Rp <?php echo number_format($total_harga / ($total_kamar ?: 1), 0, ',', '.'); ?></strong>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Chart Status Kamar -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie"></i> Distribusi Status Kamar
                                </h3>
                            </div>
                            <div class="card-body">
                                <canvas id="statusChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-bar"></i> Harga Kamar per Tipe
                                </h3>
                            </div>
                            <div class="card-body">
                                <canvas id="hargaChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php else: ?>
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-bed fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Tidak ada data kamar</h4>
                        <p class="text-muted">Belum ada kamar yang terdaftar.</p>
                        <a href="dashboard.php?menu=addkamar" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Kamar Pertama
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Total Kamar:</strong> <?php echo $total_kamar; ?> kamar
                        <?php if(!empty($filter_status)): ?>
                        | Filter: <span class="badge bg-info">Status: <?php echo $filter_status; ?></span>
                        <?php endif; ?>
                        <?php if(!empty($filter_tipe)): ?>
                        | <span class="badge bg-info">Tipe: <?php echo $filter_tipe; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="dashboard.php?menu=addkamar" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Kamar Baru
                        </a>
                        <a href="dashboard.php?menu=kamar" class="btn btn-outline-secondary">
                            <i class="fas fa-sync"></i> Refresh
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">
                    <i class="fas fa-filter"></i> Filter Kamar
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="">
                <input type="hidden" name="menu" value="kamar">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="filter_status">Status Kamar</label>
                        <select class="form-control" id="filter_status" name="status">
                            <option value="">Semua Status</option>
                            <option value="tersedia" <?php echo ($filter_status == 'tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                            <option value="terisi" <?php echo ($filter_status == 'terisi') ? 'selected' : ''; ?>>Terisi</option>
                            <option value="dibersihkan" <?php echo ($filter_status == 'dibersihkan') ? 'selected' : ''; ?>>Dibersihkan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filter_tipe">Tipe Kamar</label>
                        <input type="text" class="form-control" id="filter_tipe" name="tipe" 
                               value="<?php echo $filter_tipe; ?>" 
                               placeholder="Contoh: Deluxe, Superior, dll.">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Terapkan Filter
                    </button>
                    <a href="dashboard.php?menu=kamar" class="btn btn-outline-danger">
                        <i class="fas fa-times"></i> Reset Filter
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Quick Status -->
<div class="modal fade" id="quickStatusModal" tabindex="-1" role="dialog" aria-labelledby="quickStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickStatusModalLabel">
                    <i class="fas fa-sync"></i> Update Status Kamar
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="quickStatusForm" method="POST" action="form/kamar/update_status.php">
                <input type="hidden" name="id_kamar" id="quickStatusId">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="quick_status">Status Baru</label>
                        <select class="form-control" id="quick_status" name="status" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="terisi">Terisi</option>
                            <option value="dibersihkan">Dibersihkan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .empty-state {
        padding: 40px;
        background-color: #f8f9fa;
        border-radius: 10px;
        border: 2px dashed #dee2e6;
    }
    .table th {
        background-color: #343a40;
        color: white;
        font-weight: 600;
    }
    .table tbody tr:hover {
        background-color: rgba(0,0,0,.02);
    }
    .btn-group-vertical .btn {
        margin-bottom: 2px;
        border-radius: 4px;
    }
    .small-box {
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .small-box .icon {
        font-size: 70px;
        top: 10px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart.js untuk Status Kamar
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk chart
    var statusData = {
        tersedia: <?php echo $tersedia; ?>,
        terisi: <?php echo $terisi; ?>,
        dibersihkan: <?php echo $dibersihkan; ?>
    };
    
    // Pie Chart - Status Kamar
    var ctxPie = document.getElementById('statusChart').getContext('2d');
    var statusChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Tersedia', 'Terisi', 'Dibersihkan'],
            datasets: [{
                data: [statusData.tersedia, statusData.terisi, statusData.dibersihkan],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(108, 117, 125, 0.8)'
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(108, 117, 125, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
    
    // Bar Chart - Harga Kamar
    <?php
    // Query untuk data harga per tipe
    $harga_query = mysqli_query($koneksi, "
        SELECT tipe_kamar, AVG(harga) as avg_harga, COUNT(*) as jumlah
        FROM tbl_kamar 
        GROUP BY tipe_kamar 
        ORDER BY avg_harga DESC
    ");
    
    $labels = [];
    $data_harga = [];
    $data_jumlah = [];
    
    while($row = mysqli_fetch_array($harga_query)) {
        $labels[] = $row['tipe_kamar'];
        $data_harga[] = $row['avg_harga'];
        $data_jumlah[] = $row['jumlah'];
    }
    ?>
    
    var ctxBar = document.getElementById('hargaChart').getContext('2d');
    var hargaChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Harga Rata-rata',
                data: <?php echo json_encode($data_harga); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                yAxisID: 'y'
            }, {
                label: 'Jumlah Kamar',
                data: <?php echo json_encode($data_jumlah); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
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
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Harga (Rp)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Jumlah Kamar'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });
});

// Fungsi untuk Quick Status Update
function quickStatusUpdate(id_kamar) {
    document.getElementById('quickStatusId').value = id_kamar;
    $('#quickStatusModal').modal('show');
}

// Fungsi untuk Export ke Excel
function exportToExcel() {
    var table = document.getElementById('tabelKamar');
    var html = table.outerHTML;
    
    // Buat blob dengan tipe Excel
    var blob = new Blob([html], { type: 'application/vnd.ms-excel' });
    
    // Buat link download
    var link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'data_kamar_' + new Date().toISOString().slice(0,10) + '.xls';
    link.click();
}

// Auto-hide alerts
setTimeout(function() {
    $('.alert').alert('close');
}, 5000);
</script>