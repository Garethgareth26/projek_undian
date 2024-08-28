<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administrator - Aplikasi Pengacak Nomor Undian</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/bootstrap-icon.css" rel="stylesheet">
  <link href="../assets/css/datatable-bootstrap5.min.css" rel="stylesheet">
  <script src="../assets/js/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="design.css">
  <link rel="icon" href="../Dirgahayu Republik Indonesia (1)/logo_ma3.png" type="image/png" sizes="40x40">

  <?php
  include '../koneksi.php';
  date_default_timezone_set('Asia/Jakarta');
  session_start();
  if ($_SESSION['status'] != "administrator_logedin") {
    header("location:../index.php?alert=belum_login");
  }

  $id_user = $_SESSION['id'];
  $profil = mysqli_query($koneksi, "SELECT * FROM user WHERE user_id='$id_user'");
  $profil = mysqli_fetch_assoc($profil);
  $user_level = $profil['level'];
  ?>

  <style>
    /* Navbar default appearance */
    .navbar {
      background-color: #000; /* Warna hitam pekat */
      transition: transform 0.3s ease-in-out;
      transform: translateY(0);
      top: 0;
      width: 100%;
      z-index: 1000;
      position: fixed;
    }

    /* Navbar menghilang saat scroll ke bawah */
    .navbar.hidden {
      transform: translateY(-100%);
    }

    /* Hover effect untuk item navbar */
    .navbar-nav .nav-link {
      transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    .navbar-nav .nav-link:hover {
      color: #ffc107;
      transform: scale(1.2);
    }
  </style>

  <script>
    $(document).ready(function () {
      var previousScroll = 0;

      $(window).scroll(function () {
        var currentScroll = $(this).scrollTop();

        if (currentScroll > previousScroll) {
          // Scroll ke bawah, tetap tampilkan navbar
          $('.navbar').removeClass('hidden');
        } else if (currentScroll < previousScroll) {
          // Scroll ke atas, tampilkan navbar dengan animasi dari atas
          $('.navbar').removeClass('hidden').addClass('visible');
        }

        previousScroll = currentScroll;
      });
    });
  </script>

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="../Dirgahayu Republik Indonesia (1)/logo_ma1.png" alt="Logo" style="width: 150px; height: auto;">
        Mahkamah Agung Republik Indonesia
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php"><i class="bi bi-list-ol"></i> Undian</a>
          </li>
          <?php if ($user_level == 1) { // Jika user adalah admin ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="import_data.php"><i class="bi bi-arrow-repeat"></i>
                Kode Voucher</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="data_pemenang.php"><i class="bi bi-trophy"></i> Data
                Pemenang</a>
            </li>
          <?php } ?>
        </ul>

        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="bi bi-person"></i> <span> Halo, <?php echo $profil['user_nama']; ?></span>
            </a>
            <ul class="dropdown-menu shadow-sm dropdown-menu-end mt-2">
              <li><a class="dropdown-item" href="gantipassword.php"><i class="bi bi-lock"></i> Password</a></li>
              <?php if ($user_level == 1) { // Jika user adalah admin ?>
                <li><a class="dropdown-item" href="edit_user.php"><i class="bi bi-pencil"></i> Edit User</a></li>
              <?php } ?>
              <li><a class="dropdown-item" href="logout.php"><i class="bi bi-power"></i> Log Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</body>

</html>
