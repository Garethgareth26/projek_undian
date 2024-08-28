<?php include 'header.php'; ?>

<style>
  html,
  body {
    margin: 0;
    padding: 0;
  }

  body::before {
    content: "";
    position: fixed;
    top: 60px;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(#6bb24d, white);
    z-index: -1;
  }

  .search-pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
  }

  .search-pagination-container .input-group {
    width: auto;
    max-width: 300px; /* Atur lebar maksimal input search */
  }

  .pagination {
    margin-top: 0;
    margin-bottom: 10px; /* Tambahkan jarak bawah ke form Go to Page */
  }

  .go-to-page-form {
    display: flex;
    justify-content: center;
    margin-top: 20px; /* Tambahkan jarak atas */
  }

  .go-to-page-form .input-group {
    width: auto;
    max-width: 200px; /* Lebarkan form Go to Page */
  }

  .dropdown-menu {
    z-index: 1050 !important;
}

</style>

<div class="container mt-4">

  <!-- Bagian Voucher -->
  <div class="my-4 border-bottom mt-5">
    <h2 class="fw-semibold fs-3">Vouchers</h2>
  </div>

  <!-- Card Baru untuk Generate Voucher -->
  <div class="card card-info mb-4">
    <div class="card-header">
      <h5 class="card-title fw-semibold">Generate Kode Vouchers</h5>
    </div>
    <div class="card-body">
      <form action="generate_vouchers.php" method="POST">
        <div class="form-group">
          <label for="start_number">Angka Awal Voucher</label>
          <input type="number" class="form-control" id="start_number" name="start_number" required>
        </div>
        <div class="form-group mt-3">
          <label for="end_number">Angka Akhir Voucher</label>
          <input type="number" class="form-control" id="end_number" name="end_number" required>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Generate Vouchers</button>
      </form>
    </div>
  </div>

  <!-- Card untuk Data Vouchers -->
  <div class="card card-info">
    <div class="card-header d-flex justify-content-between">
      <span class="card-title fw-semibold">Data Vouchers</span>
    </div>

    <div class="card-body">
      <!-- Search Bar -->
      <div class="search-pagination-container">
        <!-- Form untuk Pencarian -->
        <form method="get" action="" class="form-inline">
          <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit">Search</button>
            </div>
          </div>
        </form>
      </div>

      <!-- Data Vouchers -->
      <div class="table-responsive">
        <table class="table table-bordered table-striped" id="table-datatable">
          <thead>
            <tr>
              <th width="1%">NO</th>
              <th>KODE VOUCHER</th>
              <th>STATUS</th>
            </tr>
          </thead>
          <tbody>
            <?php

            // Tentukan jumlah data per halaman
            $limit = 100;

            // Dapatkan halaman saat ini dari URL, jika tidak ada, set ke halaman 1
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $start = ($page > 1) ? ($page * $limit) - $limit : 0;

            // Jika ada pencarian, tambahkan filter
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $query = "SELECT * FROM voucher WHERE kode_voucher LIKE '%$search%' LIMIT $start, $limit";
            $result = mysqli_query($koneksi, $query);

            // Hitung total data untuk pagination
            $total = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM voucher WHERE kode_voucher LIKE '%$search%'");
            $total_data = mysqli_fetch_assoc($total)['total'];
            $total_pages = ceil($total_data / $limit);

            $no = $start + 1;
            while ($d = mysqli_fetch_array($result)) {
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['kode_voucher']; ?></td>
                <td>
                  <?php
                  if ($d['status'] == 0) {
                    echo "Tersedia";
                  } elseif ($d['status'] == 1) {
                    echo "Sudah Keluar";
                  } else {
                    echo "Hangus";
                  }
                  ?>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <nav>
        <ul class="pagination justify-content-center">
          <?php if ($page > 1): ?>
            <li class="page-item">
              <a class="page-link" href="?page=1<?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">First</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="?page=<?= $page - 1; ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">&laquo;</a>
            </li>
          <?php endif; ?>

          <?php
          $range = 2; // Menampilkan 2 halaman di sebelah kiri dan kanan halaman saat ini
          $start_page = max(1, $page - $range);
          $end_page = min($total_pages, $page + $range);

          for ($i = $start_page; $i <= $end_page; $i++): ?>
            <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
              <a class="page-link" href="?page=<?= $i; ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>"><?= $i; ?></a>
            </li>
          <?php endfor; ?>

          <?php if ($page < $total_pages): ?>
            <li class="page-item">
              <a class="page-link" href="?page=<?= $page + 1; ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">&raquo;</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="?page=<?= $total_pages; ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">Last</a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>

      <!-- Form Go to Page -->
      <form method="get" action="" class="go-to-page-form">
        <div class="input-group">
          <input type="number" name="page" class="form-control" placeholder="Go to page..." min="1" max="<?= $total_pages; ?>" required>
          <input type="hidden" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>"> <!-- Tambahkan input hidden untuk search -->
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">Go</button>
          </div>
        </div>
      </form>

    </div>
  </div>

  <!-- Tabel Hadiah -->
  <div class="my-4 border-bottom mt-5">
    <h2 class="fw-semibold fs-3">Hadiah</h2>
  </div>

  <div class="card card-info">
    <div class="card-header d-flex justify-content-between">
      <span class="card-title fw-semibold">Data Hadiah</span>
      <div>
        <a href="hadiah_import.php" class="btn btn-success btn-sm"><i class="bi bi-file-excel"></i> &nbsp Import Data Hadiah</a>
        <a href="hadiah_tambah.php" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> &nbsp Tambah Hadiah</a>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped" id="table-hadiah">
          <thead>
            <tr>
              <th width="1%">NO</th>
              <th>NAMA HADIAH</th>
              <th>KATEGORI HADIAH</th>
              <th>STATUS</th>
              <th width="1%">OPSI</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $hadiah = mysqli_query($koneksi, "SELECT hadiah_new.id, hadiah_new.nama AS hadiah_nama, kategori_hadiah.nama_kategori AS kategori_nama, hadiah_new.status 
                                  FROM hadiah_new 
                                  JOIN kategori_hadiah ON hadiah_new.id_kategori = kategori_hadiah.id
                                  ORDER BY 
                                    CASE 
                                      WHEN kategori_hadiah.id = 1 THEN 0 
                                      ELSE 1 
                                    END, 
                                    kategori_hadiah.nama_kategori ASC");
            while ($h = mysqli_fetch_array($hadiah)) {
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $h['hadiah_nama']; ?></td>
                <td><?php echo $h['kategori_nama']; ?></td>
                <td>
                  <?php
                  if ($h['status'] == 1) {
                    echo "Tidak Tersedia";
                  } else {
                    echo "Tersedia";
                  }
                  ?>
                </td>
                <td>
                  <a class="btn btn-warning btn-sm" href="hadiah_edit.php?id=<?php echo $h['id'] ?>"><i
                      class="bi bi-gear"></i></a>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<?php include 'footer.php'; ?>
