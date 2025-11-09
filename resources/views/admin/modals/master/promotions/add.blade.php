<!-- Modal Tambah Promosi -->
<div class="modal fade" id="addPromotionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.master.promotions') }}" method="POST">
                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <ion-icon name="add-circle-outline" class="align-middle"></ion-icon>
                        Tambah Promosi Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Info -->
                    <div class="alert alert-info">
                        <ion-icon name="information-circle"></ion-icon>
                        <strong>Info:</strong> Promosi digunakan untuk menandai produk atau slide (contoh: Flash Sale,
                        New Arrival).
                    </div>

                    <!-- Nama Promosi -->
                    <div class="mb-3">
                        <label for="promotionName" class="form-label">
                            Nama Promosi <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="promotionName" name="name"
                            placeholder="Contoh: Flash Sale, New Arrival" required>
                        <div class="form-text">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            Masukkan nama promosi yang mudah dipahami (maksimal 100 karakter)
                        </div>
                    </div>

                    <!-- Contoh Promosi Populer -->
                    <div class="mb-3">
                        <label class="form-label">Contoh Promosi Populer:</label>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-danger" style="cursor: pointer;"
                                onclick="document.getElementById('promotionName').value='Flash Sale'">
                                <ion-icon name="flash"></ion-icon> Flash Sale
                            </span>
                            <span class="badge bg-success" style="cursor: pointer;"
                                onclick="document.getElementById('promotionName').value='New Arrival'">
                                <ion-icon name="sparkles"></ion-icon> New Arrival
                            </span>
                            <span class="badge bg-warning" style="cursor: pointer;"
                                onclick="document.getElementById('promotionName').value='Limited Edition'">
                                <ion-icon name="star"></ion-icon> Limited Edition
                            </span>
                            <span class="badge bg-info" style="cursor: pointer;"
                                onclick="document.getElementById('promotionName').value='Hot Deal'">
                                <ion-icon name="flame"></ion-icon> Hot Deal
                            </span>
                            <span class="badge bg-secondary" style="cursor: pointer;"
                                onclick="document.getElementById('promotionName').value='Clearance Sale'">
                                <ion-icon name="pricetag"></ion-icon> Clearance Sale
                            </span>
                        </div>
                        <small class="text-muted">Klik untuk mengisi cepat</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close-outline"></ion-icon> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <ion-icon name="save-outline"></ion-icon> Simpan Promosi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
