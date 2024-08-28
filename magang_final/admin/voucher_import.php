<?php include 'header.php'; ?>

<div class="container mt-5">

  <div class="my-4 border-bottom mt-4">
    <h2 class="fw-semibold fs-3 ">Anggota</h2>
  </div>

  <section class="content">
    <div class="row justify-content-center">
      <section class="col-lg-5">       
        <div class="card card-info">
          <div class="card-header d-flex justify-content-between">
            <span class="card-title fw-semibold">Import Kode Voucher</span>
            <a href="import_data.php" class="btn btn-primary btn-sm"><i class="bi bi-reply"></i> &nbsp Kembali</a> 
          </div>
          <div class="card-body">

            <div class="alert alert-success text-center mb-4">
              Pastikan anda mengimport menggunakan format data yang sesuai.
              <br>
              Download format import file <b><a href="../import_voucher.xlsx" target="_blank">di sini</a></b>. 
            </div>

            <form action="voucher_import_act.php" method="post" enctype="multipart/form-data">

              <div class="form-group mb-4">
                <label>Upload File Excel (.xlsx)</label>
                <input type="file" class="form-control" name="berkas" required="required">
              </div>

              <div class="form-group d-grid">
                <input type="submit" class="btn btn-success" value="IMPORT KODE VOUCHER">
              </div>

            </form>

          </div>

        </div>
      </section>
    </div>
  </section>

</div>
<?php include 'footer.php'; ?>