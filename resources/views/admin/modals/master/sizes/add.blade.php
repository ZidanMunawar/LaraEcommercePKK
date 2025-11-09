<!-- Modal Tambah Ukuran -->
<div class="modal fade" id="addSizeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.master.sizes.store') }}" method="POST">
                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <ion-icon name="add-circle-outline" class="align-middle"></ion-icon>
                        Tambah Ukuran Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Ukuran -->
                    <div class="mb-3">
                        <label for="sizeName" class="form-label">
                            Ukuran <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="sizeName" name="size"
                            placeholder="Contoh: S, M, L, XL, XXL" required style="text-transform: uppercase;">
                        <div class="form-text">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            Masukkan ukuran produk (akan diubah ke huruf besar otomatis)
                        </div>
                    </div>

                    <!-- Contoh Ukuran Umum -->
                    <div class="mb-3">
                        <label class="form-label">Contoh Ukuran Umum:</label>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-secondary" style="cursor: pointer;"
                                onclick="document.getElementById('sizeName').value='S'">S</span>
                            <span class="badge bg-secondary" style="cursor: pointer;"
                                onclick="document.getElementById('sizeName').value='M'">M</span>
                            <span class="badge bg-secondary" style="cursor: pointer;"
                                onclick="document.getElementById('sizeName').value='L'">L</span>
                            <span class="badge bg-secondary" style="cursor: pointer;"
                                onclick="document.getElementById('sizeName').value='XL'">XL</span>
                            <span class="badge bg-secondary" style="cursor: pointer;"
                                onclick="document.getElementById('sizeName').value='XXL'">XXL</span>
                            <span class="badge bg-secondary" style="cursor: pointer;"
                                onclick="document.getElementById('sizeName').value='XXXL'">XXXL</span>
                        </div>
                        <small class="text-muted">Klik untuk mengisi cepat</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close-outline"></ion-icon> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <ion-icon name="save-outline"></ion-icon> Simpan Ukuran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
