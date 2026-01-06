<!-- settings.php -->
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-dark"> <!-- TAMBAH text-dark -->
                        <i class="bi bi-gear me-2"></i> System Settings
                    </h3>
                </div>
                <div class="card-body">
                    <form action="dashboard.php?menu=update_settings" method="POST">
                        <div class="row">
                            <!-- General Settings -->
                            <div class="col-md-6">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h5 class="card-title text-dark"> <!-- TAMBAH text-dark -->
                                            <i class="bi bi-sliders me-2"></i> General Settings
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="text-dark">Nama Hotel</label> <!-- TAMBAH text-dark -->
                                            <input type="text" class="form-control" name="nama_hotel" 
                                                   value="Luxury Hotel" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-dark">Timezone</label> <!-- TAMBAH text-dark -->
                                            <select class="form-control" name="timezone">
                                                <option value="Asia/Jakarta">Asia/Jakarta (GMT+7)</option>
                                                <option value="Asia/Makassar">Asia/Makassar (GMT+8)</option>
                                                <option value="Asia/Jayapura" selected>Asia/Jayapura (GMT+9)</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="save_general" class="btn btn-primary">
                                            Save General Settings
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Notification Settings -->
                            <div class="col-md-6">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h5 class="card-title text-dark"> <!-- TAMBAH text-dark -->
                                            <i class="bi bi-bell me-2"></i> Notification Settings
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="email_notif" checked>
                                            <label class="form-check-label text-dark">Email Notification</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sms_notif" checked>
                                            <label class="form-check-label text-dark">SMS Notification</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="push_notif">
                                            <label class="form-check-label text-dark">Push Notification</label>
                                        </div>
                                        <button type="submit" name="save_notif" class="btn btn-success mt-3">
                                            Save Notification Settings
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <div class="row mt-3">
                        <!-- Backup & Restore -->
                        <div class="col-md-6">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h5 class="card-title text-dark"> <!-- TAMBAH text-dark -->
                                        <i class="bi bi-download me-2"></i> Backup Database
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-dark">Backup seluruh data sistem</p> <!-- TAMBAH text-dark -->
                                    <a href="dashboard.php?menu=backup" class="btn btn-warning">
                                        <i class="bi bi-database me-1"></i> Backup Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- System Info -->
                        <div class="col-md-6">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h5 class="card-title text-dark"> <!-- TAMBAH text-dark -->
                                        <i class="bi bi-info-circle me-2"></i> System Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-dark"><strong>Version:</strong> Hotel Management System v1.0</p>
                                    <p class="text-dark"><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
                                    <p class="text-dark"><strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
                                    <p class="text-dark"><strong>Last Update:</strong> <?php echo date('d/m/Y'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="?menu=dashboard" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>