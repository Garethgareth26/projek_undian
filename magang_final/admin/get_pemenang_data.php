<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data pemenang dari database
    $query = "SELECT * FROM pemenang WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(['success' => false, 'error_message' => 'Gagal mengambil data pemenang.']);
    }
} else {
    echo json_encode(['success' => false, 'error_message' => 'ID tidak valid.']);
}
?>
