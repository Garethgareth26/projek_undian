<?php
include '../koneksi.php'; // Koneksi ke database

$kategori_hadiah = $_POST['kategori_hadiah'];
$nama_hadiah = $_POST['nama_hadiah'];
$status = $_POST['status'];

// Cek apakah kategori sudah ada
$cek_kategori = mysqli_query($koneksi, "SELECT id FROM kategori_hadiah WHERE nama_kategori='$kategori_hadiah'");
if(mysqli_num_rows($cek_kategori) > 0) {
    // Jika kategori sudah ada, ambil ID kategori
    $data = mysqli_fetch_assoc($cek_kategori);
    $id_kategori = $data['id'];
} else {
    // Jika kategori belum ada, buat kategori baru
    mysqli_query($koneksi, "INSERT INTO kategori_hadiah (nama_kategori) VALUES ('$kategori_hadiah')");
    $id_kategori = mysqli_insert_id($koneksi); // Ambil ID kategori yang baru ditambahkan
}

// Simpan hadiah ke dalam tabel hadiah_new dengan kategori yang sudah ada atau baru dibuat
mysqli_query($koneksi, "INSERT INTO hadiah_new (id_kategori, nama, status) VALUES ('$id_kategori', '$nama_hadiah', '$status')");

// Redirect ke halaman hadiah setelah menyimpan
header("location: import_data.php");
?>
