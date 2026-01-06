<?php
session_start();

// Cek apakah sudah login
if(!isset($_SESSION['username'])){
    header('location: ./index.php?error=2');
    exit;
}

// Include koneksi
include "koneksi.php";

// Set default menu
$menu = isset($_GET['menu']) ? $_GET['menu'] : 'dashboard';

// Dapatkan data user dari session
$nama_user = $_SESSION['nama'];
$role_user = $_SESSION['role'];
?>
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE v4 | Dashboard</title>

    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant"
    />
    <!--end::Primary Meta Tags-->

    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="./dist/css/adminlte.css" as="style" />
    <!--end::Accessibility Features-->

    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <!--end::Fonts-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="./dist/css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->

    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />

    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
        <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    

  <style>
/* ========== TEMA HOTEL LUXURY ========== */
:root {
    --hotel-primary: #8B4513; /* Coklat elegan */
    --hotel-secondary: #D4AF37; /* Emas */
    --hotel-accent: #2E8B57; /* Hijau segar */
    --hotel-light: #F5F5F5;
    --hotel-dark: #333333;
}

/* Background utama dengan gradien hotel */
.bg-body-tertiary {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
}

/* Header dengan tema hotel */
.app-header.navbar {
    background: linear-gradient(to right, var(--hotel-primary), #A0522D) !important;
    border-bottom: 3px solid var(--hotel-secondary);
}

.app-header .nav-link {
    color: white !important;
}

.app-header .nav-link:hover {
    color: var(--hotel-secondary) !important;
}

/* Sidebar dengan tema hotel mewah */
.app-sidebar {
    background: linear-gradient(to bottom, #8B4513, #A0522D) !important; /* Warna sama dengan header */
    border-right: 3px solid var(--hotel-secondary);
}

/* Small box dengan tema hotel */
.small-box {
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    display: block;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    border: none;
}

.small-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.small-box .inner {
    padding: 15px;
    color: white;
}

.small-box .icon {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 0;
    font-size: 70px;
    color: rgba(255, 255, 255, 0.2);
    transition: all 0.3s linear;
}

.small-box .small-box-footer {
    position: relative;
    text-align: center;
    padding: 8px 0;
    color: rgba(255, 255, 255, 0.9);
    display: block;
    z-index: 10;
    background: rgba(0, 0, 0, 0.15);
    text-decoration: none;
    font-weight: 500;
}

.small-box .small-box-footer:hover {
    color: #fff;
    background: rgba(0, 0, 0, 0.25);
}

/* Warna khusus untuk hotel */
.bg-info {
    background: linear-gradient(135deg, #17a2b8, #138496) !important;
}
.bg-success {
    background: linear-gradient(135deg, #28a745, #1e7e34) !important;
}
.bg-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800) !important;
}
.bg-danger {
    background: linear-gradient(135deg, #dc3545, #c82333) !important;
}

/* Card dengan tema hotel */
.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s, box-shadow 0.3s;
    background: white;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
}

.card-header {
    background: linear-gradient(to right, #f8f9fa, #e9ecef);
    border-bottom: 2px solid var(--hotel-secondary);
    color: var(--hotel-dark);
    font-weight: 600;
    border-radius: 10px 10px 0 0 !important;
}

/* Tabel styling */
.table {
    border-radius: 8px;
    overflow: hidden;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(139, 69, 19, 0.05);
}

/* Button hotel style */
.btn-primary {
    background: linear-gradient(to right, var(--hotel-primary), #A0522D);
    border: none;
    border-radius: 5px;
}


/* Footer */
.app-footer {
    background: var(--hotel-dark);
    color: white;
    border-top: 3px solid var(--hotel-secondary);
}

/* Modal contact */
.modal-content {
    border-radius: 15px;
    border: 3px solid var(--hotel-secondary);
}
/* Responsive */
@media (max-width: 768px) {
    .small-box {
        margin-bottom: 15px;
    }
    
    .small-box .icon {
        font-size: 50px;
    }
    
    .card-body canvas {
        max-height: 200px;
    }
}

/* Animasi */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.dropdown-menu {
    animation: fadeIn 0.2s ease-in-out;
}

/* Loading animation untuk grafik */
.chart-loading {
    min-height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
}
/* ========== END TEMA HOTEL ========== */
</style>
</style>
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block">
    <a href="?menu=dashboard" class="nav-link">Home</a>
</li>
<li class="nav-item d-none d-md-block">
    <a href="#contactModal" class="nav-link" data-bs-toggle="modal">Contact</a>
</li>
          </ul>
          <!--end::Start Navbar Links-->

          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
           <!--begin::Navbar Search-->

            <!--begin::Messages Dropdown Menu-->
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-chat-text"></i>
                <span class="navbar-badge badge text-bg-danger">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <a href="#" class="dropdown-item">
                  <!--begin::Message-->
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        src="./dist/assets/img/user1-128x128.jpg"
                        alt="User Avatar"
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        Brad Diesel
                        <span class="float-end fs-7 text-danger"
                          ><i class="bi bi-star-fill"></i
                        ></span>
                      </h3>
                      <p class="fs-7">Call me whenever you can...</p>
                      <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                      </p>
                    </div>
                  </div>
                  <!--end::Message-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <!--begin::Message-->
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        src="./dist/assets/img/user8-128x128.jpg"
                        alt="User Avatar"
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        John Pierce
                        <span class="float-end fs-7 text-secondary">
                          <i class="bi bi-star-fill"></i>
                        </span>
                      </h3>
                      <p class="fs-7">I got your message bro</p>
                      <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                      </p>
                    </div>
                  </div>
                  <!--end::Message-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <!--begin::Message-->
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img
                        src="./assets/img/user3-128x128
                        alt="User Avatar"
                        class="img-size-50 rounded-circle me-3"
                      />
                    </div>
                    <div class="flex-grow-1">
                      <h3 class="dropdown-item-title">
                        Nora Silvester
                        <span class="float-end fs-7 text-warning">
                          <i class="bi bi-star-fill"></i>
                        </span>
                      </h3>
                      <p class="fs-7">The subject goes here</p>
                      <p class="fs-7 text-secondary">
                        <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                      </p>
                    </div>
                  </div>
                  <!--end::Message-->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
            </li>
            <!--end::Messages Dropdown Menu-->

            <!--begin::Notifications Dropdown Menu-->
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#">
                <i class="bi bi-bell-fill"></i>
                <span class="navbar-badge badge text-bg-warning">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-envelope me-2"></i> 4 new messages
                  <span class="float-end text-secondary fs-7">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-people-fill me-2"></i> 8 friend requests
                  <span class="float-end text-secondary fs-7">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                  <span class="float-end text-secondary fs-7">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
              </div>
            </li>
            <!--end::Notifications Dropdown Menu-->

            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->
            
<!--begin::User Menu Dropdown-->
<li class="nav-item dropdown user-menu">
  <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
    <img
      src="./dist/assets/img/user-avatar.jpeg"
      class="user-image rounded-circle shadow"
  alt="User Image"
  style="width: 40px; height: 40px;"
/>
    <span class="d-none d-md-inline"><?php echo $nama_user; ?></span>
  </a>
  <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
    
  <!--begin::User Image-->
    <li class="user-header text-bg-primary">
      <img
        src="./dist/assets/img/user-avatar.jpeg"
        class="rounded-circle shadow"
        alt="User Image"
      />
      <p>
        <?php echo $nama_user; ?>
        <small>Role: <?php echo ucfirst($role_user); ?></small>
        <small>Login: <?php echo date('d/m/Y H:i'); ?></small>
      </p>
    </li>
    <!--end::User Image-->
    
    <!-- Menu Dropdown Items -->
    <li>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="?menu=profile">
        <i class="bi bi-person-circle me-2"></i> My Profile
      </a>
      <a class="dropdown-item" href="?menu=settings">
        <i class="bi bi-gear me-2"></i> Settings
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item text-danger" href="logout.php">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
      </a>
    </li>
  </ul>
</li>
<!--end::User Menu Dropdown-->

          <!--end::End Navbar Links-->
        </div>
        
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.php" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="./dist/assets/img/hotel-logo.jpeg"
             class="user-image rounded-circle shadow"
             alt="User Image"
            style="width: 40px; height: 40px;"
            /> 

            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">HOTEL</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <?php include "menu.php"; ?>
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      
      <!--begin::App Main-->
      <?php
      if (!isset($_GET['menu']) || $_GET['menu'] == 'dashboard') {
      ?>
<!--begin::Content-->
<main class="app-main">
    <!--begin::Container-->
    <div class="container-fluid mt-3">
        <!--begin::Row-->
        <div class="row">
            
            <!-- STATISTIK CEPAT -->
<div class="col-lg-3 col-6">
    <div class="small-box bg-info">
        <div class="inner">
            <?php
            // Query dengan error handling
            $query_kamar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kamar WHERE status='Tersedia'");
            
            if ($query_kamar) {
                $data_kamar = mysqli_fetch_assoc($query_kamar);
                $total_kamar = $data_kamar['total'];
            } else {
                // Jika query error
                $total_kamar = 0;
                echo '<!-- Error: ' . mysqli_error($koneksi) . ' -->';
            }
            ?>
            <h3><?php echo $total_kamar; ?></h3>
            <p>Kamar Tersedia</p>
        </div>
        <div class="icon">
            <i class="bi bi-door-closed"></i>
        </div>
        <a href="?menu=kamar" class="small-box-footer">Lihat Detail <i class="bi bi-arrow-right"></i></a>
    </div>
</div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <?php
                        $today = date('Y-m-d');
                        $query_checkin = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM reservasi WHERE tgl_checkin='$today' AND status='Confirmed'");
                        
                        if ($query_checkin) {
                            $data_checkin = mysqli_fetch_assoc($query_checkin);
                            $total_checkin = $data_checkin['total'];
                        } else {
                            $total_checkin = 0;
                            echo '<!-- Error: ' . mysqli_error($koneksi) . ' -->';
                        }
                        ?>
                        <h3><?php echo $total_checkin; ?></h3>
                        <p>Check-in Hari Ini</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>
                    <a href="?menu=reservasi" class="small-box-footer">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <?php
                        $query_checkout = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM reservasi WHERE tgl_checkout='$today' AND status='Checked In'");
                        
                        if ($query_checkout) {
                            $data_checkout = mysqli_fetch_assoc($query_checkout);
                            $total_checkout = $data_checkout['total'];
                        } else {
                            $total_checkout = 0;
                            echo '<!-- Error: ' . mysqli_error($koneksi) . ' -->';
                        }
                        ?>
                        <h3><?php echo $total_checkout; ?></h3>
                        <p>Check-out Hari Ini</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-box-arrow-left"></i>
                    </div>
                    <a href="?menu=reservasi" class="small-box-footer">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <?php
                        $month = date('Y-m');
                        $query_pendapatan = mysqli_query($koneksi, 
                            "SELECT SUM(total_bayar) as total FROM pembayaran 
                             WHERE DATE(tgl_bayar) LIKE '$month%' AND status='Lunas'");
                        
                        if ($query_pendapatan) {
                            $data_pendapatan = mysqli_fetch_assoc($query_pendapatan);
                            $total = $data_pendapatan['total'] ? $data_pendapatan['total'] : 0;
                        } else {
                            $total = 0;
                            echo '<!-- Error: ' . mysqli_error($koneksi) . ' -->';
                        }
                        ?>
                        <h3>Rp <?php echo number_format($total, 0, ',', '.'); ?></h3>
                        <p>Pendapatan Bulan Ini</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <a href="?menu=pembayaran" class="small-box-footer">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            
        </div>
        <!--end::Row-->
        
        <!--begin::Row-->
        <div class="row mt-3">
            
            <!-- GRAFIK HUNIAN -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tingkat Hunian 7 Hari Terakhir</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="occupancyChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- DISTRIBUSI TIPE KAMAR -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Distribusi Tipe Kamar</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="roomTypeChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            
        </div>
        <!--end::Row-->
        
        <!--begin::Row-->
        <div class="row mt-3">
            
            <!-- RESERVASI BARU -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reservasi Terbaru</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Tamu</th>
                                    <th>Check-in</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query_reservasi = mysqli_query($koneksi, 
                                    "SELECT r.*, t.nama_tamu 
                                     FROM reservasi r 
                                     JOIN tamu t ON r.id_tamu = t.id_tamu 
                                     ORDER BY r.tgl_reservasi DESC 
                                     LIMIT 5");
                                
                                if ($query_reservasi && mysqli_num_rows($query_reservasi) > 0) {
                                    while($row = mysqli_fetch_assoc($query_reservasi)):
                                ?>
                                <tr>
                                    <td><?php echo $row['kode_reservasi']; ?></td>
                                    <td><?php echo $row['nama_tamu']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($row['tgl_checkin'])); ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            switch($row['status']){
                                                case 'Confirmed': echo 'success'; break;
                                                case 'Pending': echo 'warning'; break;
                                                case 'Checked In': echo 'primary'; break;
                                                default: echo 'secondary';
                                            }
                                        ?>">
                                            <?php echo $row['status']; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile;
                                } else {
                                    echo '<tr><td colspan="4" class="text-center">Tidak ada data reservasi</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- KAMAR YANG PERLU DIPERHATIKAN -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kamar Perlu Dibersihkan</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No. Kamar</th>
                                    <th>Tipe</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query_kamar_dirty = mysqli_query($koneksi, 
                                    "SELECT * FROM kamar 
                                     WHERE status='Perlu Dibersihkan' 
                                     LIMIT 5");
                                
                                if ($query_kamar_dirty && mysqli_num_rows($query_kamar_dirty) > 0) {
                                    while($row = mysqli_fetch_assoc($query_kamar_dirty)):
                                ?>
                                <tr>
                                    <td><?php echo $row['no_kamar']; ?></td>
                                    <td><?php echo $row['tipe_kamar']; ?></td>
                                    <td>
                                        <span class="badge bg-warning"><?php echo $row['status']; ?></span>
                                    </td>
                                    <td>
                                        <a href="?menu=editkamar&id=<?php echo $row['id_kamar']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile;
                                } else {
                                    echo '<tr><td colspan="4" class="text-center">Semua kamar sudah bersih</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
        <!--end::Row-->
        
    </div>
    <!--end::Container-->
</main>
<!--end::Content-->
      <!--end::Content-->
      <?php } else { ?>
        <!-- Tampilkan menu lainnya -->
        <?php
        if (isset($_GET['menu'])) {
            switch ($_GET['menu']) {
                case 'tamu':
                    include "form/tamu/view.php";
                    break;
                case 'addtamu':
                    include "form/tamu/form.php";
                    break;
                case 'edittamu':
                    include "form/tamu/edit.php";
                    break;
                case 'kamar':
                    include "form/kamar/view.php";
                    break;
                case 'addkamar':
                    include "form/kamar/form.php";
                    break;
                case 'editkamar':
                    include "form/kamar/edit.php";
                    break;
                case 'hapuskamar':
                    include "form/kamar/proses_kamar.php";
                    break;
                case 'reservasi':
                    include "form/reservasi/view.php";
                    break;
                case 'addreservasi':
                    include "form/reservasi/form.php";
                    break;
                case 'editreservasi':
                    include "form/reservasi/edit.php";
                    break;
                case 'pembayaran':
                    include "form/pembayaran/view.php";
                    break;
                case 'addpembayaran':
                    include "form/pembayaran/form.php";
                    break;
                case 'editpembayaran':
                    include "form/pembayaran/edit.php";
                    break;
                case 'laporan_tamu':
                    include "form/laporan/tamu.php";
                    break;
                case 'laporan_reservasi':
                    include "form/laporan/reservasi.php";
                    break;
                case 'laporan_pembayaran':
                    include "form/laporan/pembayaran.php";
                    break;
case 'update_settings':
    // Handle settings update
    if (isset($_POST['save_general'])) {
        echo '<script>alert("General settings saved!"); window.location.href = "?menu=settings";</script>';
    } elseif (isset($_POST['save_notif'])) {
        echo '<script>alert("Notification settings saved!"); window.location.href = "?menu=settings";</script>';
    }
    break;

case 'backup':
    // Simple backup message
    echo '<script>alert("Backup feature is under development!"); window.location.href = "?menu=settings";</script>';
    break;
                    // ===== PROFILE ===== (SUDAH ADA)
        case 'profile':
    include "profile.php";  // Akan include file profile.php
    break;

case 'settings':
    include "settings.php";  // Akan include file settings.php
    break;

    case 'update_profile':
    // Handle update profile
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = $_POST['nama'];
        $username = $_SESSION['username'];
        
        // Update database
        $query = "UPDATE users SET nama = '$nama' WHERE username = '$username'";
        mysqli_query($koneksi, $query);
        
        // Update session
        $_SESSION['nama'] = $nama;
        
        // Redirect ke profile dengan pesan sukses
        echo '<script>alert("Profile berhasil diupdate!"); window.location.href = "?menu=profile";</script>';
        exit;
    }
    break;

                    ?>
                    <main class="app-main">
                        <div class="container-fluid mt-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="bi bi-person-circle me-2"></i>Profile Picture
                                            </h3>
                                        </div>
                                        <div class="card-body text-center">
                                            <img src="./dist/assets/img/user-avatar.jpeg" 
                                                class="user-image rounded-circle shadow"
  alt="User Image"
  style="width: 40px; height: 40px;"
/>>
                                            <h4><?php echo htmlspecialchars($nama_user); ?></h4>
                                            <p class="text-muted">
                                                <span class="badge bg-<?php echo ($role_user == 'admin') ? 'danger' : 'primary'; ?> fs-6 p-2">
                                                    <?php echo ucfirst($role_user); ?>
                                                </span>
                                            </p>
                                            <button class="btn btn-outline-primary btn-sm mt-2">
                                                <i class="bi bi-camera me-1"></i> Change Photo
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="bi bi-info-circle me-2"></i>Profile Information
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="30%" class="bg-light">Full Name</th>
                                                    <td><?php echo htmlspecialchars($nama_user); ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Username</th>
                                                    <td><?php echo htmlspecialchars($_SESSION['username']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Role</th>
                                                    <td>
                                                        <span class="badge bg-<?php echo ($role_user == 'admin') ? 'danger' : 'primary'; ?>">
                                                            <?php echo ucfirst($role_user); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Last Login</th>
                                                    <td><?php echo date('l, d F Y H:i:s'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">IP Address</th>
                                                    <td><?php echo $_SERVER['REMOTE_ADDR']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Session Started</th>
                                                    <td><?php echo date('H:i:s', $_SESSION['login_time'] ?? time()); ?></td>
                                                </tr>
                                            </table>
                                            
                                            <div class="mt-4">
                                                <h5><i class="bi bi-shield-lock me-2"></i>Account Security</h5>
                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <div class="card border-primary">
                                                            <div class="card-body">
                                                                <h6><i class="bi bi-key me-2"></i>Change Password</h6>
                                                                <p class="text-muted small">Update your account password regularly</p>
                                                                <a href="#" class="btn btn-sm btn-outline-primary">Change Password</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card border-info">
                                                            <div class="card-body">
                                                                <h6><i class="bi bi-envelope me-2"></i>Email Settings</h6>
                                                                <p class="text-muted small">Manage email notifications</p>
                                                                <a href="#" class="btn btn-sm btn-outline-info">Email Settings</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-4">
                                                <a href="?menu=dashboard" class="btn btn-primary">
                                                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                                                </a>
                                                <a href="?menu=settings" class="btn btn-outline-secondary ms-2">
                                                    <i class="bi bi-gear me-1"></i> Account Settings
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                    <?php
                    break;

                                case 'settings':
                    ?>
                    <main class="app-main">
                        <div class="container-fluid mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="bi bi-gear me-2"></i>System Settings
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="list-group" id="settingsTab" role="tablist">
                                                <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#general" role="tab">
                                                    <i class="bi bi-sliders me-2"></i> General
                                                </a>
                                                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#notifications" role="tab">
                                                    <i class="bi bi-bell me-2"></i> Notifications
                                                </a>
                                                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#appearance" role="tab">
                                                    <i class="bi bi-palette me-2"></i> Appearance
                                                </a>
                                                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#security" role="tab">
                                                    <i class="bi bi-shield-lock me-2"></i> Security
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-9">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="general" role="tabpanel">
                                                    <h5>General Settings</h5>
                                                    <p class="text-muted">Configure general system settings</p>
                                                    <div class="alert alert-info">
                                                        <i class="bi bi-info-circle me-2"></i>
                                                        General settings panel is under development.
                                                    </div>
                                                </div>
                                                
                                                <div class="tab-pane fade" id="notifications" role="tabpanel">
                                                    <h5>Notification Settings</h5>
                                                    <p class="text-muted">Configure how you receive notifications</p>
                                                    <div class="alert alert-info">
                                                        <i class="bi bi-info-circle me-2"></i>
                                                        Notification settings panel is under development.
                                                    </div>
                                                </div>
                                                
                                                <div class="tab-pane fade" id="appearance" role="tabpanel">
                                                    <h5>Appearance Settings</h5>
                                                    <p class="text-muted">Customize the look and feel</p>
                                                    <div class="alert alert-info">
                                                        <i class="bi bi-info-circle me-2"></i>
                                                        Appearance settings panel is under development.
                                                    </div>
                                                </div>
                                                
                                                <div class="tab-pane fade" id="security" role="tabpanel">
                                                    <h5>Security Settings</h5>
                                                    <p class="text-muted">Manage security preferences</p>
                                                    <div class="alert alert-info">
                                                        <i class="bi bi-info-circle me-2"></i>
                                                        Security settings panel is under development.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <a href="?menu=dashboard" class="btn btn-primary">
                                            <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                                        </a>
                                        <a href="?menu=profile" class="btn btn-outline-secondary ms-2">
                                            <i class="bi bi-person me-1"></i> View Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                    <?php
                    break; 
      
                default:
                    // Jika menu tidak dikenali, tampilkan dashboard
                    echo '<script>window.location.href = "?menu=dashboard";</script>';
                    break;
            }
        }
        ?>
      <?php } ?>
      <!-- Modal untuk Contact -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Contact Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="bi bi-building fs-1 text-primary"></i>
                    <h4>Hotel Management System</h4>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-geo-alt me-2"></i> Address</h6>
                                <p class="mb-0">Jl. Contoh No. 123<br>Jakarta, Indonesia</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-telephone me-2"></i> Phone</h6>
                                <p class="mb-0">+62 21 1234 5678<br>+62 812 3456 7890</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-envelope me-2"></i> Email</h6>
                                <p class="mb-0">info@hotel.com<br>reservation@hotel.com</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-clock me-2"></i> Operating Hours</h6>
                                <p class="mb-0">24/7 Reception<br>Check-in: 14:00<br>Check-out: 12:00</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <h6>Emergency Contact:</h6>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        For emergency: Call <strong>+62 21 9999 8888</strong>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="mailto:info@hotel.com" class="btn btn-primary">
                    <i class="bi bi-envelope me-1"></i> Send Email
                </a>
            </div>
        </div>
    </div>
</div>
      <!--end::App Main-->
      
        <!--end::App Main-->
      
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">
          <strong>Hotel Management System v1.0</strong>
        </div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2024&nbsp;
          <a href="#" class="text-decoration-none">Luxury Hotel</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    
    <!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)-->
    
    <!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)-->
    
    <!--begin::Required Plugin(AdminLTE)-->
    <script src="./dist/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)-->
    
    <!--end::OverlayScrollbars Configure-->
    
    <!-- Custom JavaScript -->
    <script>
    // Fungsi untuk waktu real-time
function updateDateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit',
        second: '2-digit',
        hour12: false 
    });
    const dateString = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    const timeElement = document.getElementById('current-time');
    if (timeElement) {
        timeElement.innerHTML = timeString + '<br><small>' + dateString + '</small>';
    }
}

// Update waktu setiap detik
setInterval(updateDateTime, 1000);
updateDateTime(); // Jalankan pertama kali

    // Fungsi pencarian
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk toggle navbar search
        const navbarSearchToggles = document.querySelectorAll('[data-lte-toggle="navbar-search"]');
        navbarSearchToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const navbarSearchBlock = document.querySelector('.navbar-search-block');
                if (navbarSearchBlock) {
                    navbarSearchBlock.classList.toggle('show');
                    if (navbarSearchBlock.classList.contains('show')) {
                        const searchInput = document.querySelector('.navbar-search-block input');
                        if (searchInput) searchInput.focus();
                    }
                }
            });
        });
        
        // Submit form pencarian
        const searchForm = document.querySelector('.navbar-search-block form');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchInput = document.querySelector('.navbar-search-block input');
                if (searchInput) {
                    const searchTerm = searchInput.value.trim();
                    if (searchTerm) {
                        window.location.href = '?menu=search&q=' + encodeURIComponent(searchTerm);
                    }
                }
            });
        }
        
        // Inisialisasi grafik hanya jika ada di dashboard
        if (document.getElementById('occupancyChart')) {
            // Grafik Tingkat Hunian
            const occupancyChart = document.getElementById('occupancyChart');
            if (occupancyChart) {
                const occupancyCtx = occupancyChart.getContext('2d');
                new Chart(occupancyCtx, {
                    type: 'line',
                    data: {
                        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                        datasets: [{
                            label: 'Tingkat Hunian (%)',
                            data: [65, 70, 80, 75, 85, 95, 90],
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
                            tension: 0.4,
                            fill: true,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        }
                    }
                });
            }
            
            // Pie Chart Tipe Kamar
            const roomTypeChart = document.getElementById('roomTypeChart');
            if (roomTypeChart) {
                const roomTypeCtx = roomTypeChart.getContext('2d');
                new Chart(roomTypeCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Standard', 'Deluxe', 'Suite', 'Executive'],
                        datasets: [{
                            data: [40, 30, 20, 10],
                            backgroundColor: [
                                '#007bff',
                                '#28a745',
                                '#ffc107',
                                '#dc3545'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} kamar (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    });
    
    // Fungsi helper untuk format Rupiah
    function formatRupiah(angka) {
        if (!angka) return '0';
        var number_string = angka.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/g);
    
        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
    
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return 'Rp ' + rupiah;
    }
    </script>
  </body>
  <!--end::Body-->
</html>