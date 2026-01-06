<!-- Tambahkan class sidebar-3d ke sidebar utama -->
<div class="sidebar sidebar-3d">
  <!-- ... kode sidebar yang sudah ada ... -->
</div>

<ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
              <li class="nav-item menu-open">
                <a href="dashboard.php" class="nav-link active">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Dashboard
                  </p>
                </a>           
              <li class="nav-item">
              <a href="dashboard.php?menu=tamu" class="nav-link">
                 <i class="nav-icon bi bi-people-fill"></i>
                 <p>Data Tamu</p>
              </a>
              </li>

          <li class="nav-item">
    <a href="dashboard.php?menu=kamar" class="nav-link"> 
        <i class="nav-icon bi bi-check"></i>
        <p>Kamar</p>
    </a>
</li>
              

<li class="nav-item">
  <a href="dashboard.php?menu=reservasi" class="nav-link">
    <i class="nav-icon bi bi-journal-check"></i>
    <p>Reservasi</p>
  </a>
</li>



<li class="nav-item">
  <a href="dashboard.php?menu=pembayaran" class="nav-link">
    <i class="nav-icon bi bi-cash-stack"></i>
    <p>Pembayaran</p>
  </a>
</li>

<!-- Laporan -->
<li class="nav-item has-treeview <?php echo (in_array($menu, ['laporan_tamu', 'laporan_reservasi', 'laporan_pembayaran'])) ? 'menu-open' : ''; ?>">
    <a href="#" class="nav-link <?php echo (in_array($menu, ['laporan_tamu', 'laporan_reservasi', 'laporan_pembayaran'])) ? 'active' : ''; ?>">
      <i class="nav-icon bi bi-list"></i>
        <p>Laporan</p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="dashboard.php?menu=laporan_tamu" class="nav-link <?php echo ($menu == 'laporan_tamu') ? 'active' : ''; ?>">
                <i class="fa-credit-card"></i>
                <p>Laporan Tamu</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="dashboard.php?menu=laporan_reservasi" class="nav-link <?php echo ($menu == 'laporan_reservasi') ? 'active' : ''; ?>">
                <i class="fas fa-calendar-check"></i>
                <p>Laporan Reservasi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="dashboard.php?menu=laporan_pembayaran" class="nav-link <?php echo ($menu == 'laporan_pembayaran') ? 'active' : ''; ?>">
            <i class="fa-credit-card"></i>
                <p>Laporan Pembayaran</p>
            </a>
        </li>
    </ul>
</li>


                  </li>
                </ul>
              </li>
            </ul>
            <!--end::Sidebar Menu-->