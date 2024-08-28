<?php include 'header.php'; ?>

<div class="container mt-5">

  <div class="my-4 border-bottom mt-5">
    <h2 class="fw-semibold fs-3">Ganti Password</h2>
  </div>

  <section class="content">
    <div class="row justify-content-center">
      <section class="col-lg-5">

        <?php 
        if(isset($_GET['alert'])){
          if($_GET['alert'] == "sukses"){
            echo "<div class='alert alert-success'>Password berhasil diganti!</div>";
          }
        }
        ?>

        <div class="card card-info">

          <div class="card-header">
            <span class="card-title fw-semibold">Ganti Password</span>
          </div>
          <div class="card-body">
            <form action="gantipassword_act.php" method="post">
              <div class="form-group mb-2">
                <label class="form-label">Masukkan Password Baru</label>
                <input type="password" class="form-control" placeholder="Masukkan Password Baru .." name="password" required="required" min="5">
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
<br>
<br><br>
</div>
<?php include 'footer.php'; ?>