<?php
include 'header.php';
?>

<style>
    html, body {
        width: 100%;
        margin: 0;
        padding: 0;
        background: linear-gradient(#6bb24d, white);
        background-size: 1530px auto;
        background-repeat: no-repeat;
        height: auto;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .content {
        flex: 1; /* Mengisi ruang yang tersisa */
    }

    .footer {
        background-color: #343a40;
        color: #fff;
        text-align: center;
        padding: 15px 0;
    }
</style>

<div class="content">
    <div class="container mt-4">
        <div class="my-4 border-bottom mt-5">
            <h2 class="fw-semibold fs-3">Daftar Pemenang Undian</h2>
        </div>

        <div class="mb-3">
            <a href="export_excel.php" class="btn btn-success">Export to Excel</a>
        </div>

        <div id="pemenang-table-container">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-datatable-pemenang">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Voucher</th>
                            <th>Nama</th>
                            <th>Bagian</th>
                            <th>No HP</th>
                            <th>Hadiah</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $data = mysqli_query($koneksi, "SELECT pemenang.*, hadiah_new.nama AS nama_hadiah FROM pemenang JOIN hadiah_new ON pemenang.hadiah_id = hadiah_new.id ORDER BY pemenang.id ASC");
                        while ($d = mysqli_fetch_array($data)) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $d['kode_voucher']; ?></td>
                                <td><?php echo $d['nama']; ?></td>
                                <td><?php echo $d['bagian']; ?></td>
                                <td><?php echo $d['no_hp']; ?></td>
                                <td><?php echo $d['nama_hadiah']; ?></td>
                                <td>
                                    <a href="data_pdf.php?id=<?php echo $d['id']; ?>" target="_blank" class="btn btn-outline-success">
                                        <i class="fa fa-file-pdf-o"></i> Cetak PDF
                                    </a>
                                    <?php if (empty($d['bagian']) || empty($d['no_hp'])) { ?>
                                        <button class="btn btn-outline-primary isi-data-btn" data-id="<?php echo $d['id']; ?>" data-bs-toggle="modal" data-bs-target="#isiDataModal">
                                            Isi Data
                                        </button>
                                    <?php } else { ?>
                                        <button class="btn btn-outline-secondary" disabled>Data Diisi</button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal placeholder -->
<div id="modal-placeholder"></div>

<script>
    let isSubmitting = false;
    let updateTableInterval;

    function startTableUpdate() {
        console.log('Starting table update interval');
        updateTableInterval = setInterval(function () {
            if (!isSubmitting) {
                console.log('Table update triggered');
                loadPemenangTable();
            }
        }, 5000);
    }

    function stopTableUpdate() {
        console.log('Stopping table update interval');
        clearInterval(updateTableInterval);
    }

    function loadPemenangTable() {
        console.log("Attempting to load table data...");

        $.ajax({
            url: 'data_pemenang_update.php',
            type: 'GET',
            success: function (html) {
                console.log("Table data loaded successfully.");
                $('#table-datatable-pemenang tbody').html(html);
            },
            error: function (xhr, status, error) {
                console.error('Error loading table:', error);
            }
        });
    }

    function loadModalContent() {
        $.get('modal_content.php', function (data) {
            $('#modal-placeholder').html(data);
        });
    }

    $(document).ready(function () {
        loadModalContent(); // Load modal content on page load
        startTableUpdate();

        $(document).on('click', '.isi-data-btn', function () {
            var pemenangId = $(this).data('id');

            $.ajax({
                url: 'get_pemenang_data.php',
                type: 'GET',
                data: { id: pemenangId },
                success: function (response) {
                    var data = JSON.parse(response);

                    $('#pemenang_id').val(data.id);
                    $('#nomor').val(data.kode_voucher);
                    $('#nama').val(data.nama);
                    $('#bagian').val(data.bagian);
                    $('#no_hp').val(data.no_hp);

                    $('#isiDataModal').modal('show');
                }
            });
        });

        $(document).on('submit', '#isiDataForm', function (e) {
            e.preventDefault();

            if (isSubmitting) return; // Menghindari pengiriman data ganda
            isSubmitting = true;
            stopTableUpdate(); // Hentikan update tabel selama proses submit

            $.ajax({
                url: 'pemenang_update.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        alert('Data berhasil disimpan.');
                        $('#isiDataModal').modal('hide'); // Tutup modal
                        loadPemenangTable(); // Muat ulang tabel setelah update
                    } else {
                        alert('Gagal menyimpan data: ' + result.error_message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Terjadi kesalahan saat mengirim data');
                },
                complete: function () {
                    isSubmitting = false;
                    location.reload();
                    startTableUpdate(); // Mulai kembali update tabel setelah submit selesai

                    // Paksa penghapusan modal dan backdrop
                    $('#isiDataModal').modal('hide');
                    $('.modal-backdrop').remove(); // Hapus backdrop jika masih ada
                    $('body').removeClass('modal-open'); // Hapus class modal-open jika masih ada

                    // Hapus modal dari DOM
                    $('#isiDataModal').remove();

                    // Muat ulang modal
                    loadModalContent(); // Load modal content again

                    // Hapus elemen dengan z-index tinggi jika masih ada
                    $('div').each(function () {
                        var zIndex = $(this).css('z-index');
                        if (zIndex > 1000) {
                            console.log("Removing high z-index element:", $(this));
                            $(this).remove();
                        }
                    });
                }
            });
        });

        // Event listener untuk memastikan tidak ada elemen tersisa setelah modal ditutup
        $(document).on('hidden.bs.modal', '#isiDataModal', function () {
            console.log("Modal hidden, removing backdrop and resetting...");
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove(); // Pastikan backdrop juga dihapus
        });
    });
</script>

<!-- Footer -->
<div class="footer mt-5 bg-dark text-light p-3 text-center">
    <p class="m-0">Aplikasi Pengacak Nomor Undian</p>
</div>

<!--  -->
</body>
</html>
