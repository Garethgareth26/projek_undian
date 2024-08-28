<!-- modal_content.php -->
<div class="modal fade" id="isiDataModal" tabindex="-1" aria-labelledby="isiDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="isiDataModalLabel">Form Pengisian Biodata Pemenang Undian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="isiDataForm" action="pemenang_update.php" method="post">
                    <input type="hidden" id="pemenang_id" name="pemenang_id">

                    <div class="form-group mb-2">
                        <label class="form-label">Nomor</label>
                        <input type="number" class="form-control" id="nomor" name="nomor" readonly>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">Bagian</label>
                        <input type="text" class="form-control" id="bagian" name="bagian" required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label">No HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                    </div>

                    <div class="form-group mb-2">
                        <input type="submit" class="btn btn-primary" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
