<?php
include('../koneksi.php');
set_time_limit(0); // Menghapus batas waktu eksekusi

if (isset($_POST['start_number']) && isset($_POST['end_number'])) {
    $start_number = intval($_POST['start_number']);
    $end_number = intval($_POST['end_number']);

    if ($start_number > $end_number) {
        echo "<script>alert('Angka awal tidak boleh lebih besar dari angka akhir.'); window.location.href='generate_voucher_form.php';</script>";
        exit();
    }

    for ($i = $start_number; $i <= $end_number; $i++) {
        $kode_voucher = str_pad($i, 6, '0', STR_PAD_LEFT);

        $check = mysqli_query($koneksi, "SELECT * FROM voucher WHERE kode_voucher = '$kode_voucher'");
        if (mysqli_num_rows($check) == 0) {
            $query = "INSERT INTO voucher (kode_voucher, status) VALUES ('$kode_voucher', 0)";
            mysqli_query($koneksi, $query);
        }
    }

    echo "<script>alert('Vouchers berhasil digenerate.'); window.location.href='import_data.php';</script>";
} else {
    echo "<script>alert('Angka awal dan akhir harus diisi.'); window.location.href='generate_voucher_form.php';</script>";
}
?>