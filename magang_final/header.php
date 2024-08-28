<?php
session_start(); // Pastikan session dimulai
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');

// Cek apakah pengguna sudah login atau belum
$isLoggedIn = isset($_SESSION['user_id']); // Misalnya, cek apakah session 'user_id' ada

// Tentukan title berdasarkan status login
$title = $isLoggedIn ? "Administrator - Aplikasi Pengacak Nomor Undian" : "Aplikasi Pengacak Nomor Undian";
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title; ?></title> <!-- Gunakan variabel $title di sini -->
  <link href="/magang_kelarlagi/magang_final/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/magang_kelarlagi/magang_final/assets/css/bootstrap-icon.css" rel="stylesheet">
  <link href="/magang_kelarlagi/magang_final/assets/css/datatable-bootstrap5.min.css" rel="stylesheet">
  <script src="/magang_kelarlagi/magang_final/assets/js/jquery.min.js" type="text/javascript"></script>
  <script src="/magang_kelarlagi/magang_final/assets/js/bootstrap.min.js" type="text/javascript"></script>
  <link rel="icon" href="/magang_kelarlagi/magang_final/Dirgahayu Republik Indonesia (1)/logo_ma3.png" type="image/png" sizes="40x40">

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

    /* Responsive styling */
    @media (max-width: 768px) {
        .navbar-brand {
            font-size: 14px;
        }

        .navbar-brand img {
            width: 100px;
            height: auto;
        }

        .navbar-brand span {
            display: none; /* Sembunyikan teks jika terlalu panjang untuk layar kecil */
        }
    }

    @media (max-width: 576px) {
        .navbar-brand {
            font-size: 12px;
        }

        .navbar-brand img {
            width: 80px;
            height: auto;
        }

        .navbar-brand span {
            display: none;
        }
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
        <img src="/magang_kelarlagi/magang_final/Dirgahayu Republik Indonesia (1)/logo_ma1.png" alt="Logo" style="width: 150px; height: auto;">
        <span>Mahkamah Agung Republik Indonesia</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" href="login.php"><i class="bi bi-person"></i> Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</body>


</html>
