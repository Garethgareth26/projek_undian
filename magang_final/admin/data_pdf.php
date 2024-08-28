<?php
include('../koneksi.php');
require_once('../vendor/autoload.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query tabel untuk mendapatkan data pemenang dan hadiah
    $query = "SELECT pemenang.*, hadiah_new.nama AS hadiah_nama, hadiah_new.id AS hadiah_nomor 
              FROM pemenang
              JOIN undian ON pemenang.kode_voucher = undian.kode_voucher
              JOIN hadiah_new ON undian.hadiah_id = hadiah_new.id
              WHERE pemenang.id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $voucher = $row['kode_voucher'];
        $nama = $row['nama'];
        $satuan = $row['bagian'];
        $nomor = $row['no_hp'];
        $hadiah = $row['hadiah_nama'];
        $hadiah_nomor = $row['hadiah_nomor'];
    } else {
        echo "Data not found!";
        exit;
    }
} else {
    echo "Invalid Request!";
    exit;
}

// Buat dokumen PDF menggunakan TCPDF
class CustomPDF extends TCPDF {
    // Header
    public function Header() {
        $this->SetFont('times', 'B', 16);

        // File path dari logo
        $imageFilePath = '../Dirgahayu Republik Indonesia (1)/logo_ma1.png'; 
        $this->Image($imageFilePath, 0, 10, 45, 0, 'PNG', '', 'T', true, 300, '', false, false, 0, false, false, false);
        
        // Header judul
        $this->SetY(10);
        $this->Cell(0, 10, 'MAHKAMAH AGUNG RI', 0, 1, 'C'); 
        
        $this->SetFont('times', 'B', 14);
        $this->Cell(0, 10, 'BADAN URUSAN ADMINISTRASI', 0, 1, 'C'); 
        
        // Alamat dan kontak
        $this->SetFont('times', '', 10);
        $this->Cell(0, 5, 'JL. MEDAN MERDEKA UTARA N0. 9-13 JAKARTA 10110 TROMOL POS NOMOR 1020', 0, 1, 'C');
        $this->Cell(0, 5, 'TELP.(021) 3843348, 3810350, 3457661 FAKSIMILE 3810361', 0, 1, 'C');

        // Spacing
        $this->Ln(4);
        
        // Garis header
        $this->SetLineWidth(0.5);
        $this->Line(10, 40, 200, 40); // Koordinat garis

        $this->SetFont('times', 'B', 14);
        $this->Cell(0, 10, 'TANDA TERIMA HADIAH', 0, 1, 'C');
        $this->Ln(7);
    }

    // Footer
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('times', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->getNumPages(), 0, 0, 'C');
    }
}

// Membuat instance dari TCPDF
$pdf = new CustomPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetTitle('Tanda Terima Hadiah Pemenang');

$pdf->SetMargins(15, 30, 15); // Kiri, atas, kanan
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);

$pdf->SetAutoPageBreak(TRUE, 10);

$pdf->AddPage();

$pdf->SetFont('times', '', 12);

// Set Y position untuk menghindari overlap dengan header
$pdf->SetY(60); 

// Fungsi menyesuaikan waktu lokal Indonesia
setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian_indonesia.1252');

// Fungsi pemanggil tanggal
$currentDate = strftime('%d %B %Y');

$html = <<<EOD
<p>Telah diterima <u><i>$hadiah</i></u> dengan nomor  <u><i>$hadiah_nomor</i></u> dan dokumen kelengkapannya sebagai hadiah dalam acara Hari Ulang Tahun Mahkamah Agung RI ke-79.</p>
<p>Nomor Undian  : $voucher</p>
<p>Nama          : $nama</p>
<p>Satuan Kerja  : $satuan</p>
<p>No. Handphone : $nomor</p>
<p>Catatan       : </p>
EOD;

// Output isi HTML
$pdf->writeHTML($html, true, false, true, false, '');

// Set posisi untuk tabel
$pdf->Ln(30); 

$table = <<<EOD
<table width="100%">
    <tr>
        <td width="50%" align="left">Yang Menyerahkan,</td>
        <td width="50%" align="right">Jakarta, $currentDate</td>
    </tr>
    <tr>
        <td width="50%" align="left"><br /><br /><br /><br /><br /><br />(....................................)</td>
        <td width="50%" align="right">Diterima oleh,<br /><br /><br /><br /><br /></td>
    </tr>
    <tr>
        <td width="50%" align="left"><br /><br /><br /></td>
        <td width="50%" align="right">(....................................)</td>
    </tr>
    <tr>
        <td width="27%" align="left"><br /><br /></td>
        <td width="50%" align="center">Saksi,</td>
    </tr>
    <tr>
        <td width="27%" align="left"><br /><br /></td>
        <td width="50%" align="center"><br /><br /><br /><br />(....................................)</td>
    </tr>
</table>
<br /><br />
<br /><br />
<p style="text-align:right; margin: right 50px;">Contact Person : ________________ </p>
<p style="text-align:right; margin: right 52px;">________________  </p>
EOD;

$pdf->writeHTML($table, true, false, true, false, '');

// Nama file yang dinamis berdasarkan kode voucher
$pdfFileName = 'tanda_terima_hadiah_' . $voucher . '.pdf';

// Output PDF ke browser dengan nama file yang dinamis
$pdf->Output($pdfFileName, 'I'); 
?>
