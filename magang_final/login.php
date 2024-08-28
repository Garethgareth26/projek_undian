<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Pengacak Nomor Undian</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/bootstrap-icon.css" rel="stylesheet">
  <link href="assets/css/datatable-bootstrap5.min.css" rel="stylesheet">
  <link rel="icon" href="../Dirgahayu Republik Indonesia (1)/logo_ma1.png" type="image/png">
  <style>
    .gambar_awal {
      width: 280px;
      height: auto;
      left: 15px;
    }
  </style>

</head>

<body class="bg-success bg-opacity-50">

  <div class="container">
    <br><br><br>

    <div class="row justify-content-center">
      <div class="col-lg-3">
        <div class="card mt-3">
          <div class="card-body text-center">

            <!-- Image logo -->
            <div class="gambar_awal mb-3">
              <img src="./Dirgahayu Republik Indonesia (1)/logo_ma1.png" alt="Logo MA" class="img-fluid">
            </div>

            <!-- Title -->
            <h4 class="fw-semibold my-3">Aplikasi Pengacak Nomor Undian</h4>

            <!-- Alert Messages -->
            <?php
            if (isset($_GET['alert'])) {
              if ($_GET['alert'] == "gagal") {
                echo '<div class="alert alert-danger text-center fw-semibold">Username & Password salah</div>';
              } else if ($_GET['alert'] == "belum_login") {
                echo '<div class="alert alert-warning text-center fw-semibold">Silahkan login terlebih dulu</div>';
              } else if ($_GET['alert'] == "logout") {
                echo '<div class="alert alert-success text-center fw-semibold">Anda telah logout</div>';
              }
            }
            ?>

            <!-- Login Form -->
            <form method="post" action="periksa_login.php">
              <div class="form-group mb-2">
                <label class="form-label mb-2 fw-semibold">Username</label>
                <input type="text" required="required" name="username" class="form-control" placeholder="Username"
                  autocomplete="off">
              </div>

              <div class="form-group mb-2">
                <label class="form-label mb-2 fw-semibold">Password</label>
                <input type="password" required="required" name="password" class="form-control"
                  placeholder="************">
              </div>

              <div class="d-grid gap-2 my-3">
                <button type="submit" class="btn btn-primary fw-semibold"><i class="bi bi-lock"></i> LOGIN</button>
                <a href="signup.php" class="btn btn-danger fw-semibold"><i class="bi bi-person-plus"></i> SIGN UP</a>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.datatables.min.js"></script>
  <script src="assets/js/datatables-bootstrap5.min.js"></script>
  <script src="assets/js/chart.js"></script>

</body>

</html>