<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-check"></i> Data Reservasi
                </h3>
                <div class="card-tools">
                    <a href="dashboard.php?menu=addreservasi" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Tambah Reservasi
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php
                // Query untuk mengambil data reservasi dengan join ke tabel tamu dan kamar
                $query = mysqli_query($koneksi, "
                    SELECT 
                        r.id_reservasi,
                        r.tgl_checkin,
                        r.tgl_checkout,
                        r.jumlah_malam,
                        r.status,
                        t.nama as nama_tamu,
                        t.no_telp,
                        k.tipe_kamar,
                        k.harga
                    FROM tbl_reservasi r
                    LEFT JOIN tbl_tamu t ON r.id_tamu = t.id_tamu
                    LEFT JOIN tbl_kamar k ON r.id_kamar = k.id_kamar
                    ORDER BY r.tgl_checkin DESC
                ");
                
                $total_reservasi = mysqli_num_rows($query);
                ?>
                
                <?php if($total_reservasi > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">ID Reservasi</th>
                                <th width="15%">Nama Tamu</th>
                                <th width="12%">Tipe Kamar</th>
                                <th width="12%">Check-in</th>
                                <th width="12%">Check-out</th>
                                <th width="10%">Jumlah Malam</th>
                                <th width="10%">Harga/Malam</th>
                                <th width="10%">Total</th>
                                <th width="8%">Status</th>
                                <th width="8%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while($data = mysqli_fetch_array($query)) {
                                // Format tanggal
                                $checkin = date('d/m/Y', strtotime($data['tgl_checkin']));
                                $checkout = date('d/m/Y', strtotime($data['tgl_checkout']));
                                
                                // Hitung total harga
                                $harga_per_malam = $data['harga'];
                                $jumlah_malam = $data['jumlah_malam'];
                                $total_harga = $harga_per_malam * $jumlah_malam;
                                
                                // Tentukan warna badge berdasarkan status
                                $status_class = '';
                                $status_text = '';
                                
                                switch(strtolower($data['status'])) {
                                    case 'confirmed':
                                        $status_class = 'badge bg-success';
                                        $status_text = 'Confirmed';
                                        break;
                                    case 'pending':
                                        $status_class = 'badge bg-warning';
                                        $status_text = 'Pending';
                                        break;
                                    case 'checked_in':
                                        $status_class = 'badge bg-info';
                                        $status_text = 'Check-in';
                                        break;
                                    case 'checked_out':
                                        $status_class = 'badge bg-secondary';
                                        $status_text = 'Check-out';
                                        break;
                                    case 'cancelled':
                                        $status_class = 'badge bg-danger';
                                        $status_text = 'Cancelled';
                                        break;
                                    default:
                                        $status_class = 'badge bg-light text-dark';
                                        $status_text = $data['status'];
                                }
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td class="text-center">
                                    <strong>RSV<?php echo str_pad($data['id_reservasi'], 4, '0', STR_PAD_LEFT); ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo $data['nama_tamu']; ?></strong><br>
                                    <small class="text-muted"><?php echo $data['no_telp']; ?></small>
                                </td>
                                <td><?php echo $data['tipe_kamar']; ?></td>
                                <td class="text-center">
                                    <span class="badge bg-primary"><?php echo $checkin; ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info"><?php echo $checkout; ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary"><?php echo $jumlah_malam; ?> malam</span>
                                </td>
                                <td class="text-right">
                                    Rp <?php echo number_format($harga_per_malam, 0, ',', '.'); ?>
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
                                        <a href="dashboard.php?menu=editreservasi&id=<?php echo $data['id_reservasi']; ?>" 
                                           class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="form/reservasi/hapus.php?id=<?php echo $data['id_reservasi']; ?>" 
                                           class="btn btn-danger" title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus reservasi ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="8" class="text-right">Total Reservasi:</th>
                                <th colspan="3">
                                    <strong><?php echo $total_reservasi; ?> Reservasi</strong>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Tidak ada data reservasi</h4>
                        <p class="text-muted">Belum ada reservasi yang dibuat.</p>
                        <a href="dashboard.php?menu=addreservasi" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Buat Reservasi Pertama
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Total Reservasi:</strong> <?php echo $total_reservasi; ?>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="dashboard.php?menu=addreservasi" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Reservasi Baru
                        </a>
                    </div>
                </div>
            </div>
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
</style>