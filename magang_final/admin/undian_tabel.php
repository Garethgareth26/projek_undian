<?php
include '../koneksi.php';

// Mengambil data dari tabel undian, voucher, dan hadiah_new
$query = "SELECT undian.undian_id, voucher.kode_voucher, hadiah_new.nama AS nama_hadiah, undian.status_klaim
          FROM undian
          JOIN voucher ON undian.kode_voucher = voucher.kode_voucher
          JOIN hadiah_new ON undian.hadiah_id = hadiah_new.id";

$result = mysqli_query($koneksi, $query);

if (!$result) {
  die("Query Error: " . mysqli_error($koneksi));
}

// Inisialisasi variabel penghitung
$no = 1;

// Menampilkan hasil dalam bentuk tabel
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>" . $no++ . "</td>"; // Menampilkan nomor urut, dimulai dari 1
  echo "<td>" . $row['kode_voucher'] . "</td>";
  echo "<td>" . ($row['status_klaim'] == 1 ? 'Diterima' : 'Belum Diterima') . "</td>";
  echo "<td>" . $row['nama_hadiah'] . "</td>";
  echo "<td>";
  if ($row['status_klaim'] == 0) {
    echo "<a class='btn btn-success btn-sm klaim-btn' data-id='" . $row['undian_id'] . "'>Klaim</a>";
  } else {
    echo "<span class='btn btn-secondary btn-sm disabled'>Sudah Diterima</span>";
  }
  echo "</td>";
  echo "</tr>";
}
?>
