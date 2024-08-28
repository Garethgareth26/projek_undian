<?php
include '../koneksi.php';

$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;

$query = "SELECT kode_voucher FROM voucher WHERE status = 0 LIMIT $start, $limit";
$result = mysqli_query($koneksi, $query);

$vouchers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $vouchers[] = $row;
}

echo json_encode($vouchers);
?>
