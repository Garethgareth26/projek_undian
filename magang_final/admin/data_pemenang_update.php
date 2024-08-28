<?php
ob_start();
include '../koneksi.php';

$no = 1;
$data = mysqli_query($koneksi, "SELECT pemenang.*, hadiah_new.nama AS nama_hadiah FROM pemenang JOIN hadiah_new ON pemenang.hadiah_id = hadiah_new.id ORDER BY pemenang.id ASC");

while ($d = mysqli_fetch_array($data)) {
    echo "<tr>
            <td>" . $no++ . "</td>
            <td>{$d['kode_voucher']}</td>
            <td>{$d['nama']}</td>
            <td>{$d['bagian']}</td>
            <td>{$d['no_hp']}</td>
            <td>{$d['nama_hadiah']}</td>
            <td>
                <a href='data_pdf.php?id={$d['id']}' target='_blank' class='btn btn-outline-success'>
                    <i class='fa fa-file-pdf-o'></i> Cetak PDF
                </a>";
    if (empty($d['bagian']) || empty($d['no_hp'])) {
        echo "<button class='btn btn-outline-primary isi-data-btn' data-id='{$d['id']}' data-bs-toggle='modal' data-bs-target='#isiDataModal'>
                Isi Data
              </button>";
    } else {
        echo "<button class='btn btn-outline-secondary' disabled>Data Diisi</button>";
    }
    echo "</td></tr>";
}

$content = ob_get_clean();
echo $content;
?>