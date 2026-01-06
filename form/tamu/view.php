<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Tamu</h3>
                <div class="card-tools">
                    <a href="dashboard.php?menu=addtamu" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Tambah Tamu
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>No Telp</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM tbl_tamu ORDER BY id_tamu DESC");
                            $no = 1;
                            while($data = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?php echo $data['id_tamu']; ?></td>
                                <td><?php echo $data['nama']; ?></td>
                                <td><?php echo $data['no_telp']; ?></td>
                                <td><?php echo $data['alamat']; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="dashboard.php?menu=edittamu&id=<?php echo $data['id_tamu']; ?>" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="form/tamu/hapus.php?id=<?php echo $data['id_tamu']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin hapus data?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                            $no++;
                            } 
                            
                            if(mysqli_num_rows($query) == 0) {
                                echo '<tr><td colspan="5" class="text-center">Tidak ada data tamu</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>