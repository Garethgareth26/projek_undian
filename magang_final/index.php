<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'fetch_data') {
    $search = isset($_POST['search']) ? $_POST['search'] : '';

    try {
        $sql = "SELECT undian.undian_id, undian.kode_voucher, undian.status_klaim, hadiah_new.nama AS nama_hadiah
                FROM undian
                JOIN hadiah_new ON undian.hadiah_id = hadiah_new.id
                WHERE undian.kode_voucher LIKE :search
                OR hadiah_new.nama LIKE :search";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['search' => "%$search%"]);
        $undianData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $output = '';
        foreach ($undianData as $index => $data) {
            $status = $data['status_klaim'] == 0 ? 'Belum Diterima' : 'Sudah Diterima';
            $output .= "<tr>
                            <td>".($index + 1)."</td>
                            <td>".htmlspecialchars($data['kode_voucher'])."</td>
                            <td>".htmlspecialchars($status)."</td>
                            <td>".htmlspecialchars($data['nama_hadiah'])."</td>
                        </tr>";
        }
        
        echo json_encode([
            'html' => $output,
            'newDataCount' => count($undianData)
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'error' => "Query failed: " . $e->getMessage()
        ]);
    }
    exit;
}
?>

<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Undian</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            width: 100%;
            margin: 0;
            margin-top: 45px;
            padding: 0;
            background: linear-gradient(#6bb24d, white);
            background-size: cover;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Prevent manual scrolling */
        }

        .undian-page {
            flex: 1;
            padding-top: 50px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            .table th, .table td {
                font-size: 12px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<section class="undian-page">
    <div class="container">
        <div class="my-4 border-bottom">
            <h2 class="fw-semibold fs-3">Pemenang Undian</h2>
        </div>

        <div class="card card-info">
            <div class="card-header d-flex justify-content-between">
                <span class="card-title fw-semibold">Data Pemenang Undian</span>
            </div>

            <div class="card-body" id="kuy-gas">
                <div class="mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari di sini...">
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table-datatable">
                        <thead>
                            <tr>
                                <th width="1%">NO</th>
                                <th>KODE VOUCHER</th>
                                <th>STATUS KLAIM</th>
                                <th>HADIAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data pemenang akan dimuat di sini -->
                        </tbody>
                    </table>
                    <!-- Penanda posisi di bagian bawah tabel -->
                    <div id="table-end-marker"></div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
$(document).ready(function(){
    var scrollSpeed = 3; // Kecepatan scroll (semakin kecil, semakin lambat)
    var scrollPaused = false;
    var direction = 'down';

    function scrollContent() {
        var scrollTop = $(window).scrollTop();
        var documentHeight = $(document).height();
        var windowHeight = $(window).height();

        if (direction === 'down') {
            if (scrollTop + windowHeight >= documentHeight) {
                // Jika sudah sampai di bawah, ubah arah scroll ke atas
                direction = 'up';
                setTimeout(scrollContent, 4000); // Jeda 4 detik sebelum scroll ke atas
            } else {
                $(window).scrollTop(scrollTop + scrollSpeed);
                requestAnimationFrame(scrollContent);
            }
        } else {
            if (scrollTop <= 0) {
                // Jika sudah sampai di atas, ubah arah scroll ke bawah
                direction = 'down';
                setTimeout(scrollContent, 4000); // Jeda 4 detik sebelum scroll ke bawah
            } else {
                $(window).scrollTop(scrollTop - scrollSpeed);
                requestAnimationFrame(scrollContent);
            }
        }
    }

    // Mulai scroll otomatis
    requestAnimationFrame(scrollContent);

    // Load initial data
    function loadTable(searchTerm) {
        $.ajax({
            url: '', // Gunakan file yang sama untuk menangani permintaan AJAX
            method: 'POST',
            data: { action: 'fetch_data', search: searchTerm },
            success: function(response) {
                var data = JSON.parse(response);
                $('#table-datatable tbody').html(data.html);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }

    loadTable('');

    // Event handler for search input
    $("#searchInput").on("keyup", function() {
        var value = $(this).val();
        loadTable(value);
    });

    // Polling to update the table every 8 seconds
    setInterval(function(){
        loadTable($("#searchInput").val()); // Refresh table with current search term
    }, 8000); // Polling interval in milliseconds (8000ms = 8 seconds)
});
</script>

</body>
</html>

<?php include 'footer.php'; ?>

