<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-money-bill-wave"></i> Data Pembayaran
                </h3>
                <div class="card-tools">
                    <a href="dashboard.php?menu=addpembayaran" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Tambah Pembayaran
                    </a>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#filterModal">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php
                // Filter parameter
                $filter_status = isset($_GET['status']) ? $_GET['status'] : '';
                $filter_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
                
                // Query dasar dengan filter
                $sql = "
                    SELECT 
                        p.id_pembayaran,
                        p.metode,
                        p.tanggal_bayar,
                        p.status as status_pembayaran,
                        r.id_reservasi,
                        t.nama as nama_tamu,
                        t.no_telp,
                        k.tipe_kamar,
                        k.harga,
                        r.jumlah_malam,
                        (k.harga * r.jumlah_malam) as total_harga_reservasi
                    FROM tbl_pembayaran p
                    LEFT JOIN tbl_reservasi r ON p.id_reservasi = r.id_reservasi
                    LEFT JOIN tbl_tamu t ON r.id_tamu = t.id_tamu
                    LEFT JOIN tbl_kamar k ON r.id_kamar = k.id_kamar
                    WHERE 1=1
                ";
                
                if (!empty($filter_status)) {
                    $sql .= " AND p.status = '$filter_status'";
                }
                
                if (!empty($filter_bulan)) {
                    $sql .= " AND DATE_FORMAT(p.tanggal_bayar, '%Y-%m') = '$filter_bulan'";
                }
                
                $sql .= " ORDER BY p.tanggal_bayar DESC, p.id_pembayaran DESC";
                
                $query = mysqli_query($koneksi, $sql);
                $total_pembayaran = mysqli_num_rows($query);
                
                // Hitung total pembayaran
                $total_lunas = 0;
                $total_belum = 0;
                $total_semua = 0;
                
                while($data = mysqli_fetch_array($query)) {
                    $total_semua += ($data['harga'] * $data['jumlah_malam']);
                    if($data['status_pembayaran'] == 'lunas') {
                        $total_lunas += ($data['harga'] * $data['jumlah_malam']);
                    } else {
                        $total_belum += ($data['harga'] * $data['jumlah_malam']);
                    }
                }
                
                // Reset pointer query
                mysqli_data_seek($query, 0);
                ?>
                
                <!-- Statistik Pembayaran -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fas fa-wallet"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Pembayaran</span>
                                <span class="info-box-number"><?php echo $total_pembayaran; ?> Transaksi</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Lunas</span>
                                <span class="info-box-number">Rp <?php echo number_format($total_lunas, 0, ',', '.'); ?></span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fas fa-exclamation-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Belum Lunas</span>
                                <span class="info-box-number">Rp <?php echo number_format($total_belum, 0, ',', '.'); ?></span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 30%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if($total_pembayaran > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">ID Pembayaran</th>
                                <th width="12%">ID Reservasi</th>
                                <th width="15%">Nama Tamu</th>
                                <th width="10%">Tipe Kamar</th>
                                <th width="10%">Tanggal Bayar</th>
                                <th width="10%">Metode</th>
                                <th width="12%">Total Reservasi</th>
                                <th width="8%">Status</th>
                                <th width="8%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while($data = mysqli_fetch_array($query)) {
                                // Format tanggal
                                $tanggal_bayar = date('d/m/Y', strtotime($data['tanggal_bayar']));
                                
                                // Hitung total
                                $total_harga = $data['harga'] * $data['jumlah_malam'];
                                
                                // Tentukan warna badge berdasarkan status
                                $status_class = '';
                                $status_text = '';
                                
                                switch(strtolower($data['status_pembayaran'])) {
                                    case 'lunas':
                                        $status_class = 'badge bg-success';
                                        $status_text = 'LUNAS';
                                        break;
                                    case 'belum lunas':
                                        $status_class = 'badge bg-warning';
                                        $status_text = 'BELUM LUNAS';
                                        break;
                                    default:
                                        $status_class = 'badge bg-light text-dark';
                                        $status_text = strtoupper($data['status_pembayaran']);
                                }
                                
                                // Tentukan icon metode pembayaran
                                $metode_icon = '';
                                switch(strtolower($data['metode'])) {
                                    case 'transfer bank':
                                        $metode_icon = 'fas fa-university';
                                        break;
                                    case 'tunai':
                                        $metode_icon = 'fas fa-money-bill-wave';
                                        break;
                                    case 'kartu kredit':
                                        $metode_icon = 'fas fa-credit-card';
                                        break;
                                    default:
                                        $metode_icon = 'fas fa-money-check-alt';
                                }
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td class="text-center">
                                    <strong>PYM<?php echo str_pad($data['id_pembayaran'], 4, '0', STR_PAD_LEFT); ?></strong>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">
                                        RSV<?php echo str_pad($data['id_reservasi'], 4, '0', STR_PAD_LEFT); ?>
                                    </span>
                                </td>
                                <td>
                                    <strong><?php echo $data['nama_tamu']; ?></strong><br>
                                    <small class="text-muted"><?php echo $data['no_telp']; ?></small>
                                </td>
                                <td><?php echo $data['tipe_kamar']; ?></td>
                                <td class="text-center">
                                    <span class="badge bg-info"><?php echo $tanggal_bayar; ?></span>
                                </td>
                                <td class="text-center">
                                    <i class="<?php echo $metode_icon; ?> me-1"></i>
                                    <?php echo $data['metode']; ?>
                                </td>
                                <td class="text-right">
                                    <strong>Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></strong>
                                </td>
                                <td class="text-center">
                                    <span class="<?php echo $status_class; ?>">
                                        <?php echo $status_text; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="dashboard.php?menu=editpembayaran&id=<?php echo $data['id_pembayaran']; ?>" 
                                           class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="form/pembayaran/hapus.php?id=<?php echo $data['id_pembayaran']; ?>" 
                                           class="btn btn-danger" title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus pembayaran ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <?php if($data['status_pembayaran'] == 'belum lunas'): ?>
                                        <a href="form/pembayaran/set_lunas.php?id=<?php echo $data['id_pembayaran']; ?>" 
                                           class="btn btn-success" title="Set Lunas"
                                           onclick="return confirm('Set pembayaran ini sebagai LUNAS?')">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <th colspan="7" class="text-right">TOTAL:</th>
                                <th class="text-right">
                                    <strong>Rp <?php echo number_format($total_semua, 0, ',', '.'); ?></strong>
                                </th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-money-bill-wave fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Tidak ada data pembayaran</h4>
                        <p class="text-muted">Belum ada pembayaran yang tercatat.</p>
                        <a href="dashboard.php?menu=addpembayaran" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Buat Pembayaran Pertama
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Total Pembayaran:</strong> <?php echo $total_pembayaran; ?> transaksi
                        <?php if(!empty($filter_status)): ?>
                        | Filter: <span class="badge bg-info">Status: <?php echo $filter_status; ?></span>
                        <?php endif; ?>
                        <?php if(!empty($filter_bulan)): ?>
                        | <span class="badge bg-info">Bulan: <?php echo date('F Y', strtotime($filter_bulan . '-01')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="dashboard.php?menu=addpembayaran" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Pembayaran Baru
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
                    <i class="fas fa-filter"></i> Filter Pembayaran
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="">
                <input type="hidden" name="menu" value="pembayaran">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="filter_status">Status Pembayaran</label>
                        <select class="form-control" id="filter_status" name="status">
                            <option value="">Semua Status</option>
                            <option value="lunas" <?php echo ($filter_status == 'lunas') ? 'selected' : ''; ?>>Lunas</option>
                            <option value="belum lunas" <?php echo ($filter_status == 'belum lunas') ? 'selected' : ''; ?>>Belum Lunas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filter_bulan">Bulan Pembayaran</label>
                        <input type="month" class="form-control" id="filter_bulan" name="bulan" 
                               value="<?php echo $filter_bulan; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Terapkan Filter
                    </button>
                    <a href="dashboard.php?menu=pembayaran" class="btn btn-outline-danger">
                        <i class="fas fa-times"></i> Reset Filter
                    </a>
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
    .btn-group .btn {
        border-radius: 4px;
        margin: 0 2px;
    }
    .info-box {
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .info-box .info-box-icon {
        border-radius: 8px 0 0 8px;
    }
</style>

<script>
// Auto-hide alerts
setTimeout(function() {
    $('.alert').alert('close');
}, 5000);
</script>