<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voucher_id = $_POST['voucher_id'];

    if (!empty($voucher_id)) {
        $query = "UPDATE voucher SET status = 2 WHERE kode_voucher = '$voucher_id'";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error_message' => 'Gagal mengubah status voucher.']);
        }
    } else {
        echo json_encode(['success' => false, 'error_message' => 'Voucher ID tidak valid.']);
    }
} else {
    echo json_encode(['success' => false, 'error_message' => 'Metode request tidak valid.']);
}
?>