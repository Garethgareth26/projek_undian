<?php include 'header.php'; ?>

<!-- <script src="./assets/js/jquery.min.js" type="text/javascript"></script> -->


<style>
  html,
  body {
    width: 100%;
    margin: 0;
    padding: 0;
    margin-top: 40px;
    background-image: url("../Dirgahayu Republik Indonesia (1)/background_4.png");
    background-size: 1530px 750px;
    background-repeat: no-repeat;
  }

  .overlay-container {
    position: absolute;
    margin-top: 0px;
    left: 350px;
    width: 550px;
    height: 70vh;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 999;
  }

  .overlay {
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
  }

  #nomor_acak {
    font-size: 15rem;
  }

  .undian-page {
    position: relative;
    background: linear-gradient(#ffd3d3, white);
    width: 100%;
    height: 80vh;
  }

  .undian-page-background {
    position: absolute;
    top: 10px;
    left: 0;
    width: 100%;
    height: 100%;
    background-position: center;
  }

  .menu_pilih {
    display: flex;
    justify-content: center;
    gap: 50px;
    margin-left: 200px;
  }

  .button_main {
    margin-left: 215px;
  }

  .nomor {
    margin-left: 0;
  }

  #kategori_hadiah,
  #hadiah_new {
    width: 200px;
    padding: 8px;
  }

  #loading {
    display: none;
  }
</style>

<div class="overlay">
  <section class="overlay-container">
    <div class="container">
      <div class="menu_pilih">

        <select name="kategori_hadiah" id="kategori_hadiah" class="btn btn-dark dropdown-toggle dropdown-toggle-split"
          data-bs-toggle="dropdown" aria-expanded="false">
          <option value="">Pilih kategori hadiah ..</option>
          <?php
          $kategori = mysqli_query($koneksi, "SELECT * FROM kategori_hadiah");
          while ($row = mysqli_fetch_array($kategori)) {
            echo "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
          }
          ?>
        </select>

        <select name="hadiah_new" id="hadiah_new" class="btn btn-dark dropdown-toggle dropdown-toggle-split"
          data-bs-toggle="dropdown" aria-expanded="false">
          <option value="">Pilih hadiah ..</option>
        </select>


      </div>

      <div class="">
        <input type="hidden" id="nomor_key">
        <h1 id="nomor_acak">000000</h1>
      </div>

      <div class="button_main">
        <div class="row d-flex justify-content-center">
          <div class="text-center">
            <button onclick="acak()" class="btn btn-success tombol-start">UNDI NOMOR</button>
            <button onclick="simpan()" class="btn btn-primary tombol-simpan" disabled>SIMPAN</button>
            <button onclick="hangus()" class="btn btn-danger tombol-hangus" disabled>HANGUS</button>
            <!-- <button type="button" class="btn btn-warning me-1" id="hangusBtn" disabled>Hangus</button> -->
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<section class="undian-page">
  <div class="undian-page-background">
    <div class="container">
      <div class="my-4 border-bottom">
        <h2 class="fw-semibold fs-3">Pemenang Undian</h2>
      </div>

      <div class="card card-info">
        <div class="card-header d-flex justify-content-between">
          <span class="card-title fw-semibold">Data Pemenang Undian</span>
          <div>
            <a onclick="return confirm('Apakah anda yakin ingin mereset semua data undian?')" href="undian_reset.php"
              class="btn btn-danger btn-sm"><i class="bi bi-x"></i> Reset</a>
          </div>
        </div>

        <div class="card-body" id="kuy-gas">
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="table-datatable">
              <thead>
                <tr>
                  <th width="1%">NO</th>
                  <th>NOMOR</th>
                  <th>NAMA</th>
                  <th>STATUS</th>
                  <th>HADIAH</th>
                  <th width="1%">OPSI</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT pegawai.*, undian.*, hadiah_new.nama AS nama_hadiah FROM pegawai JOIN undian ON pegawai.pegawai_id = undian.undian_pegawai JOIN hadiah_new ON undian.undian_hadiah = hadiah_new.id");
                while ($d = mysqli_fetch_array($data)) {
                  ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $d['pegawai_nomor']; ?></td>
                    <td><?php echo $d['pegawai_nama']; ?></td>
                    <td><?php echo ($d['pegawai_status'] == 'biasa') ? 'Belum Diterima' : 'Diterima'; ?></td>
                    <td><?php echo $d['nama_hadiah']; ?></td>
                    <td>
                      <a class="btn btn-success btn-sm <?php echo ($d['pegawai_status'] == 'Diterima') ? 'disabled' : ''; ?>"
                        href="klaim_hadiah.php?id=<?php echo $d['pegawai_id']; ?>">
                        <i>Klaim</i></a>
                    </td>
                  </tr>
                  <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
$arr = array();
if (isset($_GET['status'])) {
  if ($_GET['status'] == "utusan") {
    $pegawai = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE pegawai_status='utusan' AND pegawai_id NOT IN (SELECT undian_pegawai FROM undian)");
  } else {
    $pegawai = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE pegawai_id NOT IN (SELECT undian_pegawai FROM undian)");
  }
} else {
  $pegawai = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE pegawai_id NOT IN (SELECT undian_pegawai FROM undian)");
}
while ($p = mysqli_fetch_array($pegawai)) {
  $x = array(
    'id' => $p['pegawai_id'],
    'nomor' => $p['pegawai_nomor'],
  );
  array_push($arr, $x);
}
?>

<script>
  var pegawai = <?php echo json_encode($arr); ?>;
  var MyVar;

  function acak() {
    if (pegawai.length > 0) {
      var hadiah = $("#hadiah_new").val();
      if (hadiah.length == 0) {
        alert("Hadiah belum diisi");
      } else {
        $(".tombol-start").attr('disabled', 'disabled');
        $(".tombol-simpan").attr('disabled', 'disabled');
        $(".info").hide();
        $("#hadiah_new").attr('disabled', 'disabled');

        MyVar = setInterval(bolakbalik, 2);

        setTimeout(function () {
          clearInterval(MyVar);
          $(".tombol-hangus").removeAttr('disabled');
          $(".tombol-start").removeAttr('disabled');
          $(".tombol-simpan").removeAttr('disabled');
          $("#hadiah_new").removeAttr('disabled');

          var key = $("#nomor_key").val();
          $(".info_nama").text(pegawai[key]['nama']);
          $(".info_bagian").text(pegawai[key]['bagian']);
          $(".info_lokasi").text(pegawai[key]['lokasi']);
          $(".info_status").text(pegawai[key]['status']);
          $(".info").show();

          // Hapus pegawai yang sudah dipilih
        }, 2000);
      }
    } else {
      alert("Tidak ada kode voucher");
    }
  }

  function bolakbalik() {
    var ranNum = Math.floor(0 + Math.random() * pegawai.length);
    var nomor = pegawai[ranNum]['nomor'];
    var key = ranNum;
    document.getElementById("nomor_acak").innerHTML = nomor;
    $("#nomor_key").val(key);
  }

  function simpan() {
    var key = $("#nomor_key").val(); // Key dari pegawai yang dipilih
    var hadiah = $("#hadiah_new").val();
    var nomor = $("#nomor_acak").text();

    // Ambil data pegawai yang dipilih sebelum melakukan slice
    var selectedPegawai = pegawai[key];

    // Hapus pegawai dari array
    pegawai.splice(key, 1);

    // Kirim data pegawai yang terpilih ke server
    var data = "pegawai=" + selectedPegawai['id'] + "&hadiah=" + hadiah;

    $.ajax({
      type: "POST",
      url: "undian_simpan.php",
      data: data,
      success: function (response) {
        console.log("Raw response:", response);

        try {
          var hasil = JSON.parse(response);
          if (hasil.success) {
            alert("Data berhasil disimpan");
            updateDropdown();
            updateTable();
            $("#kategori_hadiah").val('');
            $("#hadiah_new").html('<option value="">Pilih hadiah ..</option>');
          } else {
            alert("Data gagal disimpan: " + hasil.error_message);
          }
        } catch (error) {
          console.error("JSON parsing error:", error.message);
          alert("Terjadi kesalahan dalam memproses respons dari server.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Request error:", error);
        alert("Terjadi kesalahan saat menyimpan data");
      }
    });
  }

  function hangus() {
    var key = $("#nomor_key").val(); // Key dari pegawai yang dipilih
    var nomor = $("#nomor_acak").text();

    // Ambil data pegawai yang dipilih sebelum melakukan slice
    var selectedPegawai = pegawai[key];

    // Hapus pegawai dari array
    pegawai.splice(key, 1);

    // Kirim data ke server untuk mengubah status pegawai menjadi "Hangus"
    var data = "pegawai=" + selectedPegawai['id'] + "&status=Hangus";

    $.ajax({
      type: "POST",
      url: "undian_hangus.php", // Buat file PHP untuk menangani update status ke "Hangus"
      data: data,
      success: function (response) {
        console.log("Raw response:", response);

        try {
          var hasil = JSON.parse(response);
          if (hasil.success) {
            alert("Nomor telah dihanguskan.");
            updateDropdown();
            updateTable();
            $(".tombol-hangus").attr('disabled', 'disabled');
            $(".tombol-simpan").attr('disabled', 'disabled');
            $("#kategori_hadiah").val('');
            $("#hadiah_new").html('<option value="">Pilih hadiah ..</option>');
            $("#nomor_acak").text('000000');
          } else {
            alert("Gagal menghanguskan nomor: " + hasil.error_message);
          }
        } catch (error) {
          console.error("JSON parsing error:", error.message);
          alert("Terjadi kesalahan dalam memproses respons dari server.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Request error:", error);
        alert("Terjadi kesalahan saat menghanguskan nomor");
      }
    });
  }


  function updateDropdown() {
    $.ajax({
      type: "GET",
      url: "get_hadiah.php", // Buat file PHP untuk mengambil data hadiah yang tersedia
      success: function (response) {
        var hadiahData = JSON.parse(response);
        var dropdown = $("#hadiah_new");

        dropdown.empty(); // Kosongkan dropdown sebelum diisi ulang

        $.each(hadiahData, function (index, hadiah) {
          dropdown.append($('<option>', {
            value: hadiah.id,
            text: hadiah.nama
          }));
        });
      },
      error: function (xhr, status, error) {
        console.error("Request error:", error);
        alert("Gagal memperbarui dropdown hadiah");
      }
    });
  }

  function updateTable() {
    $.ajax({
      url: 'undian_tabel.php',
      type: 'GET',
      success: function (response) {
        $("tbody").html(response); // Ganti isi tbody dengan data terbaru
      }
    });
  }

  $(document).ready(function () {
    $("#kategori_hadiah").change(function () {
      var kategori_id = $(this).val();
      if (kategori_id) {
        $.ajax({
          type: 'POST',
          url: 'get_hadiah.php',
          data: { id_kategori: kategori_id }, // Pastikan data dikirim dengan benar
          success: function (response) {
            console.log(response); // Debug: Tampilkan respons dari server
            $("#hadiah_new").html(response);
          },
          error: function (xhr, status, error) {
            console.error(xhr.responseText); // Tampilkan error di console
            alert("Error: " + xhr.statusText); // Tampilkan alert dengan pesan error
          }
        });
      } else {
        $("#hadiah_new").html('<option value="">Pilih hadiah ..</option>');
      }
    });
  });


</script>