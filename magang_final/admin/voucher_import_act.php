<?php
include '../koneksi.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$file_mimes = array('csv','xlsx');

$arr_file = explode('.', $_FILES['berkas']['name']);
$extension = end($arr_file);

if(isset($_FILES['berkas']['name']) && in_array($extension, $file_mimes)) {

  if($extension == 'csv') {
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
  }else{
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
  }

  $spreadsheet = $reader->load($_FILES['berkas']['tmp_name']);

  $sheetData = $spreadsheet->getActiveSheet()->toArray();

  $terimport = 0;
  $duplikat = 0;
  $tidak_ditemukan = 0;

  for($i = 1;$i < count($sheetData);$i++){
    $nomor = mysqli_real_escape_string($koneksi,$sheetData[$i]['0']);
    $nama = mysqli_real_escape_string($koneksi,$sheetData[$i]['1']);
    $bagian = mysqli_real_escape_string($koneksi,$sheetData[$i]['2']);
    $no_hp = mysqli_real_escape_string($koneksi,$sheetData[$i]['3']);    
    $status = "biasa";    

    // Jika nomor tidak kosong, lakukan insert
    if($nomor != ""){
      
      // Jika status "biasa" atau "utusan", lanjutkan
      if($status == "biasa" || $status == "utusan" || $status == ""){

        $cek2 = mysqli_query($koneksi,"select * from pegawai where pegawai_nomor='$nomor'");
        if(mysqli_num_rows($cek2) > 0){
          $duplikat++;
        }else{
          mysqli_query($koneksi, "insert into pegawai values (NULL,'$nomor','$nama','$bagian','$no_hp','$status')")or die(mysqli_error($koneksi));
          $terimport++;
        }

      } else {
        $tidak_ditemukan++;
      }

    }

  }

  session_start();
  $_SESSION['pesan'] = "sukses";
  $_SESSION['pesan_terimport'] = $terimport;
  $_SESSION['pesan_duplikat'] = $duplikat;
  $_SESSION['pesan_tidak_ditemukan'] = $tidak_ditemukan;

  header("location:import_data.php"); 

}else{
  session_start();
  $_SESSION['pesan'] = "gagal";

  header("location:import_data.php"); 
}
?>
