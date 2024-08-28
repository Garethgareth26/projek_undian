<?php
include '../koneksi.php';

if (isset($_POST['id'])) {
    $undian_id = $_POST['id'];

    // Ambil data dari tabel undian berdasarkan undian_id
    $query = "SELECT undian.kode_voucher, undian.hadiah_id, hadiah_new.nama AS nama_hadiah
              FROM undian
              JOIN hadiah_new ON undian.hadiah_id = hadiah_new.id
              WHERE undian.undian_id = '$undian_id'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $kode_voucher = $row['kode_voucher'];
        $hadiah_id = $row['hadiah_id'];

        // Update status klaim di tabel undian
        $updateQuery = "UPDATE undian SET status_klaim = 1 WHERE undian_id = '$undian_id'";
        if (mysqli_query($koneksi, $updateQuery)) {
            // Masukkan data ke tabel pemenang tanpa mengisi kolom nama, bagian, dan no_hp
            $insertPemenang = "INSERT INTO pemenang (kode_voucher, hadiah_id, nama, bagian, no_hp)
                               VALUES ('$kode_voucher', '$hadiah_id', '', '', '')";
            if (mysqli_query($koneksi, $insertPemenang)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error_message' => 'Gagal menyimpan data ke tabel pemenang.']);
            }
        } else {
            echo json_encode(['success' => false, 'error_message' => 'Gagal memperbarui status klaim.']);
        }
    } else {
        echo json_encode(['success' => false, 'error_message' => 'Data undian tidak ditemukan.']);
    }
} else {
    echo json_encode(['success' => false, 'error_message' => 'ID tidak valid.']);
}
?>
