<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title></title>
  <!-- Google Fonts -->
  <!-- <link href="https://fonts.gstatic.com" rel="preconnect" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" /> -->

  <!-- Vendor CSS Files -->
  <link href="css/bootstrap5/bootstrap.min.css" rel="stylesheet" />
  <link href="css/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar" style="background-color: #354586; background-image: linear-gradient(45deg, #15a4a4, #0e4ab0)">
    <div style="background: #f5f5f5">
      <img src="src/bcas.png"" height=" 36"alt="Logo" style="text-align: center; margin:
        15px;" />
    </div>
    <ul class="sidebar-nav" id="sidebar-nav">
      <!-- End Dashboard Nav -->
      <div class="menu" style="padding: 10px">
        <li class="nav-item">
          <div class="title-app" style="
                color: black;
                text-align: center;
                font-size: 22px;
                margin-top: 10px;
                margin-bottom: 20px;
              ">
            <a href="kk_koneks1.php" target="mainFrame" style="text-decoration: none">
              <h5 style="color: white;">Aplikasi Kas Kecil</h5>
            </a>
          </div>
          <a class="nav-link" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-table"></i><span>Table</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="kk_pcmst.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Kas Kecil</span> </a>
            </li>
            <li>
              <a href="kk_trtbl.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Kode Transaksi</span> </a>
            </li>
            <li>
              <a href="kk_rftbl.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Kode Referensi</span> </a>
            </li>
            <li>
              <a href="kk_usrtbl.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>User Pengguna</span> </a>
            </li>
            <li>
              <a href="kk_gltbl3.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Buku Besar</span> </a>
            </li>
          </ul>
        </li>
        <!-- End Components Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-journal-text"></i><span>Transaksi</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
            
          <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
              <a href="kk_kasbondriver.php" target="mainFrame">
                <i class="bi bi-circle-fill"></i><span>Data Pegawai Kasbon</span>
              </a>
            </li>
          <li>
          <li>
              <a href="kk_kasbondriver.php" target="mainFrame">
                <i class="bi bi-circle-fill"></i><span>Pengeluaran Driver</span>
              </a>
            </li>
          <li>
            <li>
              <a href="kk_inptrs.php" target="mainFrame">
                <i class="bi bi-circle-fill"></i><span>Pemasukan Data</span>
              </a>
            </li>
            <li>
              <a href="kk_inquiry.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Inquiry</span> </a>
            </li>
            <li>
              <a href="kk_trsotor.php" target="mainFrame">
                <i class="bi bi-circle-fill"></i><span>Otorisasi</span>
              </a>
            </li>
          </ul>
        </li>
        <!-- End Forms Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-layout-text-window-reverse"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="kk_trshar.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Daftar Transaksi Harian</span> </a>
            </li>
            <li>
              <a href="kk_rkptrs.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Rekap Transaksi Harian</span> </a>
            </li>
            <li>
              <a href="kk_trsref.php" target="mainFrame">
                <i class="bi bi-circle-fill"></i><span>Daftar Transaksi Referensi</span>
              </a>
            </li>
            <li>
              <a href="kk_trskode.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Daftar Transaksi Perkode</span> </a>
            </li>
            <li>
              <a href="kk_bukukas.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Buku Kas Kecil</span> </a>
            </li>
            <li>
              <a href="kk_bukubonCoba.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Buku Kas Bon</span> </a>
            </li>
            <li>
              <a href="kk_daftjo.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Daftar Jurnal Otomatis</span> </a>
            </li>
          </ul>
        </li>
        <!-- End Tables Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-menu-up"></i><span>Utilisasi</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="charts-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="kk_gantipas.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Ganti Password</span> </a>
            </li>
            <li>
              <a href="kk_bukasts.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Buka Status</span> </a>
            </li>
            <li>
              <a href="kk_tutupsts.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Tutup Status</span> </a>
            </li>
            <li>
              <a href="kk_filejo.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Jurnal Otomatis</span> </a>
            </li>
          </ul>
        </li>
        <!-- End Charts Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-eye"></i><span>Audit Trail</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="icons-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="kk_audtrs.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Transaksi</span> </a>
            </li>
            <li>
              <a href="kk_audlog.php" target="mainFrame"> <i class="bi bi-circle-fill"></i><span>Activity Log</span> </a>
            </li>
          </ul>
        </li>
        <!-- End Icons Nav -->

        <li class="nav-item">
          <a href="kk_logout.php" target="mainFrame" class="nav-link collapsed">
            <i class="bi bi-door-closed"></i>
            <span>Logout</span>
          </a>
        </li>
      </div>
    </ul>
  </aside>
  <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>