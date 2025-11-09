<!-- Modal Tambah Nomor Resi -->
<div class="modal fade" id="addResiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <ion-icon name="cube-outline" class="align-middle"></ion-icon>
                    Tambah Nomor Resi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="addResiTransactionId">

                <div class="mb-3">
                    <label for="resiNumber" class="form-label">Nomor Resi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="resiNumber" placeholder="Contoh: JNE123456789"
                        required>
                    <div class="form-text">Masukkan nomor resi dari kurir pengiriman</div>
                </div>

                <div class="alert alert-warning">
                    <ion-icon name="warning-outline"></ion-icon>
                    <strong>Otomatis:</strong> Menambah resi akan otomatis mengubah status menjadi "Dikirim"
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <ion-icon name="close-outline"></ion-icon> Batal
                </button>
                <button type="button" class="btn btn-success" id="submitResiUpdate" onclick="submitResiUpdate()">
                    <ion-icon name="cube-outline"></ion-icon> Simpan Resi
                </button>
            </div>
        </div>
    </div>
</div>
