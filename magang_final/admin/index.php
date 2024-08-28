<?php include 'header.php'; ?>

<style>
  /* Tambahkan animasi fade-in */
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Tambahkan animasi slide-in untuk tombol */
  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateX(-100%);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  html,
  body {
    width: 100%;
    margin: 0;
    padding: 0;
    margin-top: 40px;
    background-image: url("../Dirgahayu Republik Indonesia (1)/background_new.png");
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
    animation: fadeIn 1s ease-in-out;
  }

  .overlay {
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
    animation: fadeIn 1.5s ease-in-out;
  }

  #nomor_acak {
    font-size: 15rem;
  }

  .undian-page {
    position: relative;
    background: linear-gradient(#6bb24d, white);
    width: 100%;
    height: 120vh;
    animation: fadeIn 2s ease-in-out;
  }

  .menu_pilih {
    display: flex;
    justify-content: center;
    gap: 50px;
    margin-left: 200px;
    animation: slideIn 1s ease-in-out;
  }

  .button_main {
    margin-left: 215px;
    animation: slideIn 1.5s ease-in-out;
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

  #loading-indicator {
    text-align: center;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 15px;
    border-radius: 5px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 18px;
  }

  .dropdown-menu {
    z-index: 1050 !important;
}
.background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1; /* Tempatkan di belakang semua elemen */
    overflow: hidden; /* Pastikan gambar tidak meluber */
}

.container {
    position: relative; /* Supaya konten tidak bergerak */
    z-index: 1; /* Pastikan berada di depan background */
    padding-top: 60px; /* Sesuaikan padding atas sesuai tinggi navbar */
}
</style>

<audio id="drumroll" src="soundefek2.mp3"></audio>

<div class="overlay">
  <section class="overlay-container">
    <div class="container">
      <div class="menu_pilih">
        <label for="kategori_hadiah">Pilih Kategori Hadiah:</label>
        <select name="kategori_hadiah" id="kategori_hadiah" class="btn btn-dark dropdown-toggle dropdown-toggle-split"
          title="Pilih Kategori Hadiah">
          <option value="">Pilih kategori hadiah ..</option>
          <?php
          // Mengisi dropdown kategori dari database
          include 'koneksi.php';
          $kategori = mysqli_query($koneksi, "SELECT * FROM kategori_hadiah");
          while ($row = mysqli_fetch_array($kategori)) {
            echo "<option value='" . $row['id'] . "'>" . $row['nama_kategori'] . "</option>";
          }
          ?>
        </select>

        <label for="hadiah_new">Pilih Hadiah:</label>
        <select name="hadiah_new" id="hadiah_new" class="btn btn-dark dropdown-toggle dropdown-toggle-split"
          title="Pilih Hadiah">
          <option value="">Pilih hadiah ..</option>
        </select>
      </div>

      <div class="">
        <input type="hidden" id="nomor_key">
        <h1 id="nomor_acak">000000</h1>
      </div>

      <div id="loading-indicator" style="display: none;">
        <p>Sedang memuat kode voucher, harap tunggu...</p>
      </div>

      <div class="button_main">
        <div class="row d-flex justify-content-center">
          <div class="text-center">
            <button onclick="acak()" class="btn btn-success tombol-start" disabled>UNDI NOMOR</button>
            <button onclick="simpan()" class="btn btn-primary tombol-simpan" disabled>SIMPAN</button>
            <button onclick="hangus()" class="btn btn-danger tombol-hangus" disabled>HANGUS</button>
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
                  <th>KODE VOUCHER</th>
                  <th>STATUS KLAIM</th>
                  <th>HADIAH</th>
                  <th width="1%">OPSI</th>
                </tr>
              </thead>
              <tbody>
                <!-- Data pemenang akan dimuat disini -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  let pegawai = []; // Array global untuk menyimpan data voucher
  let MyVar;
  let totalLoaded = 0;
  let startIndex = 0;
  let chunkSize = 100; // Ukuran chunk, misalnya 100
  let totalVouchers = 1000000; // Total voucher yang ingin dimuat

  function loadVoucherChunk(startIndex, callback) {
    // Tampilkan indikator loading
    $("#loading-indicator").show();

    $.ajax({
      url: 'load_voucher_chunk.php',
      type: 'GET',
      data: { start: startIndex, limit: 1000 }, // Muat dalam chunk besar (1000 atau lebih)
      success: function (response) {
        let chunk = JSON.parse(response);
        pegawai = pegawai.concat(chunk);

        if (chunk.length === 1000) {
          // Jika masih ada data, lanjutkan pemuatan
          loadVoucherChunk(startIndex + 1000, callback);
        } else {
          console.log('Semua voucher berhasil dimuat:', pegawai.length);
          // Sembunyikan indikator loading setelah selesai memuat semua voucher
          $("#loading-indicator").hide();
          if (callback) callback();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error loading vouchers:", error);
        // Sembunyikan indikator loading jika terjadi error
        $("#loading-indicator").hide();
      }
    });
  }

  $(document).ready(function () {
    // Nonaktifkan tombol undian hingga semua voucher selesai dimuat
    $(".tombol-start").attr('disabled', 'disabled');

    // Muat semua voucher sebelum memulai pengundian
    loadVoucherChunk(0, function () {
      // Setelah semua voucher dimuat, tombol undian dapat digunakan
      $(".tombol-start").removeAttr('disabled');
    });
  });

  function acak() {
    if (pegawai.length === 0) {
      alert("Voucher belum sepenuhnya dimuat. Harap tunggu dan coba lagi.");
      return;
    }

    var hadiah = $("#hadiah_new").val();
    if (hadiah.length === 0) {
      alert("Hadiah belum diisi");
      return;
    }

    // Disable tombol dan elemen yang tidak diperlukan selama pengundian
    $(".tombol-start").attr('disabled', 'disabled');
    $(".tombol-simpan").attr('disabled', 'disabled');
    $(".info").hide();
    $("#hadiah_new").attr('disabled', 'disabled');

    var drumroll = document.getElementById('drumroll');
    drumroll.play();  // Mulai drumroll

    var intervalTime = 50;
    var MyVar = setInterval(bolakbalik, intervalTime);

    // Pengaturan interval pengacakan yang lebih lambat
    setTimeout(function () {
      clearInterval(MyVar);
      intervalTime = 100;
      MyVar = setInterval(bolakbalik, intervalTime);
    }, 3000);

    setTimeout(function () {
      clearInterval(MyVar);
      intervalTime = 200;
      MyVar = setInterval(bolakbalik, intervalTime);
    }, 4500);

    // Akhiri pengacakan dan tampilkan hasil
    setTimeout(function () {
      clearInterval(MyVar);

      $(".tombol-hangus").removeAttr('disabled');
      $(".tombol-start").removeAttr('disabled');
      $(".tombol-simpan").removeAttr('disabled');
      $("#hadiah_new").removeAttr('disabled');

      var key = $("#nomor_key").val();
      if (pegawai[key]) {
        $(".info_nama").text(pegawai[key]['nama']);
        $(".info_bagian").text(pegawai[key]['bagian']);
        $(".info_lokasi").text(pegawai[key]['lokasi']);
        $(".info_status").text(pegawai[key]['status']);
        $(".info").show();
      } else {
        alert("Terjadi kesalahan, voucher tidak ditemukan.");
      }
    }, 6000);

    // Biarkan drumroll berakhir dengan sendirinya
  }


  function bolakbalik() {
    var ranNum = Math.floor(Math.random() * pegawai.length);
    var nomor = pegawai[ranNum]['kode_voucher'];
    var key = ranNum;
    document.getElementById("nomor_acak").innerHTML = nomor;
    $("#nomor_key").val(key);
  }

  function simpan() {
    var key = $("#nomor_key").val();
    var hadiah = $("#hadiah_new").val();
    var nomor = $("#nomor_acak").text();

    var selectedVoucher = pegawai[key];

    pegawai.splice(key, 1);

    var data = {
      voucher_id: selectedVoucher['kode_voucher'],
      hadiah_id: hadiah,
      status: 1
    };

    $.ajax({
      type: "POST",
      url: "undian_simpan.php",
      data: data,
      success: function (response) {
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
    var key = $("#nomor_key").val();
    var nomor = $("#nomor_acak").text();
    var selectedVoucher = pegawai[key];

    pegawai.splice(key, 1);

    var data = {
      voucher_id: selectedVoucher['kode_voucher']
    };

    $.ajax({
      type: "POST",
      url: "undian_hangus.php",
      data: data,
      success: function (response) {
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
      url: "get_hadiah.php",
      success: function (response) {
        var hadiahData = JSON.parse(response);
        var dropdown = $("#hadiah_new");

        dropdown.empty();

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
        // Hancurkan DataTables jika sudah diinisialisasi
        if ($.fn.DataTable.isDataTable('#table-datatable')) {
          $('#table-datatable').DataTable().clear().destroy();
        }

        // Ganti isi <tbody> dengan data baru
        $('#table-datatable tbody').html(response);

        // Inisialisasi ulang DataTables
        $('#table-datatable').DataTable({
          'paging': true,
          'lengthChange': false,
          'searching': false,
          'ordering': true,
          'info': true,
          'autoWidth': false,
          "pageLength": 10
        });
      }
    });
  }

  $(document).ready(function () {
    updateTable(); // Memuat data tabel saat halaman dimuat

    // Event delegation untuk tombol klaim
    $(document).on('click', '.klaim-btn', function (e) {
      e.preventDefault();
      var undianId = $(this).data('id');

      $.ajax({
        type: 'POST',
        url: 'klaim_hadiah.php', // Endpoint untuk klaim hadiah
        data: { id: undianId },
        success: function (response) {
          var hasil = JSON.parse(response);
          if (hasil.success) {
            alert('Hadiah berhasil diklaim!');
            updateTable(); // Perbarui tabel pemenang setelah klaim berhasil
          } else {
            alert('Gagal klaim hadiah: ' + hasil.error_message);
          }
        },
        error: function (xhr, status, error) {
          console.error('Request error:', error);
          alert('Terjadi kesalahan saat mengklaim hadiah');
        }
      });
    });

    $("#kategori_hadiah").change(function () {
      var kategori_id = $(this).val();

      if (kategori_id) {
        $.ajax({
          type: 'POST',
          url: 'get_hadiah.php',
          data: { id_kategori: kategori_id },
          success: function (response) {
            $("#hadiah_new").html(response);
          },
          error: function (xhr, status, error) {
            console.log("Terjadi kesalahan: " + xhr.statusText);
          }
        });
      } else {
        $("#hadiah_new").html('<option value="">Pilih hadiah ..</option>');
      }
    });
  });
</script>

<?php include 'footer.php'; ?>