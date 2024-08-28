<?php
include '../koneksi.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$file_mimes = array('csv', 'xlsx');

$arr_file = explode('.', $_FILES['berkas']['name']);
$extension = end($arr_file);

if (isset($_FILES['berkas']['name']) && in_array($extension, $file_mimes)) {

    if ($extension == 'csv') {
        $reader = new Csv();
    } else {
        $reader = new Xlsx();
    }

    $spreadsheet = $reader->load($_FILES['berkas']['tmp_name']);
    $sheetData = $spreadsheet->getActiveSheet()->toArray();

    $terimport = 0;
    $duplikat = 0;
    $kategori_baru = 0;

    // Menyimpan kategori dan hadiah
    $kategori_map = [];

    // Memproses data
    for ($i = 1; $i < count($sheetData); $i++) {
        $kategori = mysqli_real_escape_string($koneksi, $sheetData[$i][0]);
        $hadiah = mysqli_real_escape_string($koneksi, $sheetData[$i][1]);

        if ($kategori != "" && $hadiah != "") {
            // Cek kategori
            if (!isset($kategori_map[$kategori])) {
                // Cek apakah kategori sudah ada
                $cek_kategori = mysqli_query($koneksi, "SELECT id FROM kategori_hadiah WHERE nama_kategori='$kategori'");
                if (mysqli_num_rows($cek_kategori) > 0) {
                    $kategori_id = mysqli_fetch_assoc($cek_kategori)['id'];
                } else {
                    // Masukkan kategori baru
                    mysqli_query($koneksi, "INSERT INTO kategori_hadiah (nama_kategori) VALUES ('$kategori')");
                    $kategori_id = mysqli_insert_id($koneksi);
                    $kategori_baru++;
                }
                $kategori_map[$kategori] = $kategori_id; // Memperbarui kategori_map
            } else {
                $kategori_id = $kategori_map[$kategori];
            }

            // Cek hadiah
            $cek_hadiah = mysqli_query($koneksi, "SELECT * FROM hadiah_new WHERE nama='$hadiah' AND id_kategori='$kategori_id'");
            if (mysqli_num_rows($cek_hadiah) > 0) {
                $duplikat++;
            } else {
                // Masukkan hadiah baru
                mysqli_query($koneksi, "INSERT INTO hadiah_new (id_kategori, nama) VALUES ('$kategori_id', '$hadiah')") or die(mysqli_error($koneksi));
                $terimport++;
            }
        }
    }

    session_start();
    $_SESSION['pesan'] = "sukses";
    $_SESSION['pesan_terimport'] = $terimport;
    $_SESSION['pesan_duplikat'] = $duplikat;
    $_SESSION['pesan_kategori_baru'] = $kategori_baru;

    header("location:import_data.php"); 

} else {
    session_start();
    $_SESSION['pesan'] = "gagal";
    header("location:import_data.php"); 
}
?>
