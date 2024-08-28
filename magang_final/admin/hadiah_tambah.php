<?php include 'header.php'; ?>


<style>
    html, body {
        width: 100%;
        margin: 0;
        margin-top: 30px;
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

<div class="container">

  <div class="my-4 border-bottom">
    <h2 class="fw-semibold fs-3">Tambah Hadiah</h2>
  </div>

  <section class="content">
    <div class="row justify-content-center">
      <section class="col-lg-5">       
        <div class="card card-info">
          <div class="card-header d-flex justify-content-between">
            <span class="card-title fw-semibold">Tambah Hadiah</span>
            <a href="import_data.php" class="btn btn-primary btn-sm"><i class="bi bi-reply"></i> &nbsp Kembali</a> 
          </div>
          <div class="card-body">
            <form action="hadiah_tambah_act.php" method="post" enctype="multipart/form-data">
              <div class="form-group mb-2">
                <label class="form-label">Kategori Hadiah</label>
                <input type="text" class="form-control" name="kategori_hadiah" required="required" placeholder="Masukkan Nama Kategori Hadiah ..">
              </div>
              <div class="form-group mb-2">
                <label class="form-label">Nama Hadiah</label>
                <input type="text" class="form-control" name="nama_hadiah" required="required" placeholder="Masukkan Nama Hadiah ..">
              </div>
              <div class="form-group mb-2">
                <label class="form-label">Status Hadiah</label>
                <select class="form-control" name="status" required="required">
                  <option value="0">Tersedia</option>
                  <option value="1">Tidak Tersedia</option>
                </select>
              </div>
              <div class="form-group mb-2">
                <input type="submit" class="btn btn-primary" value="Simpan">
              </div>
            </form>
          </div>

        </div>
      </section>
    </div>
  </section>

</div>
<?php include 'footer.php'; ?>
