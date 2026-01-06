<?php
// profile.php
include "koneksi.php";
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <!-- Profile Card -->
                    <div class="card card-primary">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" 
                                     src="./dist/assets/img/user-avatar.jpeg" 
                                     alt="User profile picture">
                            </div>
                            
                            <h3 class="profile-username text-center"><?php echo $nama_user; ?></h3>
                            <p class="text-muted text-center">
                                <span class="badge bg-<?php echo ($role_user == 'admin') ? 'danger' : 'primary'; ?>">
                                    <?php echo ucfirst($role_user); ?>
                                </span>
                            </p>
                            
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Username</b>
                                    <a class="float-end"><?php echo $_SESSION['username']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Login Terakhir</b>
                                    <a class="float-end"><?php echo date('d/m/Y H:i:s'); ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>IP Address</b>
                                    <a class="float-end"><?php echo $_SERVER['REMOTE_ADDR']; ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <!-- Edit Profile Form -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Profile</h3>
                        </div>
                        <div class="card-body">
                            <form action="dashboard.php?menu=update_profile" method="POST">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" 
                                           value="<?php echo $nama_user; ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" 
                                           placeholder="Masukkan email">
                                </div>
                                
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" class="form-control" name="telepon" 
                                           placeholder="Masukkan nomor telepon">
                                </div>
                                
                                <div class="form-group">
                                    <label>Password Baru (kosongkan jika tidak ingin diubah)</label>
                                    <input type="password" class="form-control" name="password" 
                                           placeholder="Password baru">
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Update Profile
                                </button>
                                <a href="?menu=dashboard" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>