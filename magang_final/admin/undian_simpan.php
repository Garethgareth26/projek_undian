<?php
include '../koneksi.php';

if (isset($_POST['voucher_id']) && isset($_POST['hadiah_id'])) {
    $voucher_id = $_POST['voucher_id'];
    $hadiah_id = $_POST['hadiah_id'];

    // Update tabel undian untuk menyimpan data voucher yang terpilih
    $query = "INSERT INTO undian (kode_voucher, hadiah_id, status_klaim) VALUES ('$voucher_id', '$hadiah_id', 0)";
    if (mysqli_query($koneksi, $query)) {
        // Jika penyimpanan undian berhasil, update status hadiah_new menjadi 1
        $updateHadiah = "UPDATE hadiah_new SET status = 1 WHERE id = '$hadiah_id'";
        $updateVoucher = "UPDATE voucher SET status = 1 WHERE kode_voucher = '$voucher_id'";

        if (mysqli_query($koneksi, $updateHadiah) && mysqli_query($koneksi, $updateVoucher)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error_message' => 'Gagal memperbarui status hadiah atau voucher.']);
        }
    } else {
        echo json_encode(['success' => false, 'error_message' => 'Gagal menyimpan undian.']);
    }
} else {
    echo json_encode(['success' => false, 'error_message' => 'Data tidak valid.']);
}
