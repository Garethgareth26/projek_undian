<?php
include '../koneksi.php';

if (isset($_POST['pemenang_id']) && isset($_POST['nama']) && isset($_POST['bagian']) && isset($_POST['no_hp'])) {
    $id = $_POST['pemenang_id'];
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $no_hp = $_POST['no_hp'];

    // Debugging - lihat data yang diterima
    error_log("ID: $id, Nama: $nama, Bagian: $bagian, No HP: $no_hp");

    // Update data pemenang di database
    $query = "UPDATE pemenang SET nama = '$nama', bagian = '$bagian', no_hp = '$no_hp' WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        error_log("Data berhasil diupdate");
        echo json_encode(['success' => true]);
    } else {
        error_log("Gagal memperbarui data: " . mysqli_error($koneksi));
        echo json_encode(['success' => false, 'error_message' => 'Gagal memperbarui data pemenang.']);
    }
} else {
    error_log("Data tidak lengkap: " . print_r($_POST, true));
    echo json_encode(['success' => false, 'error_message' => 'Data tidak lengkap.']);
}
?>
