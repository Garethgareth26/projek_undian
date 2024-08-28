<?php
include('../koneksi.php');

if (isset($_POST['pemenang_id']) && isset($_POST['bagian']) && isset($_POST['no_hp'])) {
    $pemenang_id = $_POST['pemenang_id'];
    $bagian = $_POST['bagian'];
    $no_hp = $_POST['no_hp'];

    // Update data pemenang di database
    $query = "UPDATE pemenang SET bagian = '$bagian', no_hp = '$no_hp' WHERE id = '$pemenang_id'";
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error_message' => 'Gagal memperbarui data pemenang.']);
    }
} else {
    echo json_encode(['success' => false, 'error_message' => 'Data tidak lengkap.']);
}
?>