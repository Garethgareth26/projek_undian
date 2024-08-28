<?php include 'header.php'; ?>

<style>
    html, body {
        width: 100%;
        margin: 0;
        padding: 0;
        background: linear-gradient(#6bb24d, white);
        background-size: 1530px 750px;
        background-repeat: no-repeat;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .content {
        flex: 1; /* Membuat konten utama fleksibel mengisi ruang yang tersedia */
    }

    .footer {
        background-color: #343a40;
        color: #fff;
        text-align: center;
        padding: 15px 0;
        position: relative;
        z-index: 1;
    }
</style>

<div class="container mt-5 content"> <!-- Tambahkan kelas .content -->
    <div class="my-4 border-bottom mt-5">
        <h2 class="fw-semibold fs-3">Import Hadiah</h2>
    </div>

    <section class="content">
        <div class="row justify-content-center">
            <section class="col-lg-5">
                <div class="card card-info">
                    <div class="card-header d-flex justify-content-between">
                        <span class="card-title fw-semibold">Import Data Hadiah</span>
                        <a href="hadiah.php" class="btn btn-primary btn-sm"><i class="bi bi-reply"></i> &nbsp Kembali</a>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success text-center mb-4">
                            Pastikan anda mengimport menggunakan format data yang sesuai.
                            <br>
                            Download format import file <b><a href="../import_hadiah.xlsx" target="_blank">di sini</a></b>.
                        </div>

                        <form action="hadiah_import_act.php" method="post" enctype="multipart/form-data">
                            <div class="form-group mb-4">
                                <label>Upload File Excel (.xlsx)</label>
                                <input type="file" class="form-control" name="berkas" required="required">
                            </div>
                            <div class="form-group d-grid">
                                <input type="submit" class="btn btn-success" value="IMPORT DATA HADIAH">
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>

<div class="footer">
    <p class="m-0">Aplikasi Pengacak Nomor Undian</p>
</div>

<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/jquery.datatables.min.js"></script>
<script src="../assets/js/datatables-bootstrap5.min.js"></script>
<script src="../assets/js/chart.js"></script>
</body>
</html>
