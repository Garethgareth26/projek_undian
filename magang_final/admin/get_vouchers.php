<?php
include '../koneksi.php';

$no = 1;
$data = mysqli_query($koneksi, "SELECT * FROM voucher");
while ($d = mysqli_fetch_array($data)) {
    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . $d['kode_voucher'] . "</td>";
    echo "<td>";
    if ($d['status'] == 0) {
        echo "Tersedia";
    } elseif ($d['status'] == 1) {
        echo "Sudah Keluar";
    } else {
        echo "Hangus";
    }
    echo "</td>";
    echo "<td><a class='btn btn-warning btn-sm' href='voucher_edit.php?id=" . $d['id'] . "'><i class='bi bi-gear'></i></a></td>";
    echo "</tr>";
}
?>
