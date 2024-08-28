<?php
include '../koneksi.php';

if (isset($_POST['id_kategori'])) {
    $id_kategori = $_POST['id_kategori'];

    // Mengambil hadiah yang tersedia (status = 0) berdasarkan kategori yang dipilih
    $query = mysqli_query($koneksi, "SELECT id, nama FROM hadiah_new WHERE id_kategori = '$id_kategori' AND status = 0");

    // Debugging: Tampilkan query dan data
    if (!$query) {
        echo "Error in query: " . mysqli_error($koneksi);
        exit;
    }

    echo '<option value="">Pilih hadiah ..</option>';
    while ($row = mysqli_fetch_array($query)) {
        echo "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
    }
} else {
    echo '<option value="">Pilih hadiah ..</option>';
}
?>
