<!-- Modal Tambah Banner -->
<div class="modal fade" id="addBannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.master.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <ion-icon name="add-circle-outline" class="align-middle"></ion-icon>
                        Tambah Banner Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Info -->
                    <div class="alert alert-info">
                        <ion-icon name="information-circle"></ion-icon>
                        <strong>Info:</strong> Banner akan ditampilkan di halaman utama customer. Maksimal 2 banner.
                    </div>

                    <!-- Upload Gambar Banner -->
                    <div class="mb-3">
                        <label for="add_image" class="form-label">
                            Gambar Banner <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="add_image"
                            name="image" accept="image/*" required>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            Format: JPEG, PNG, JPG, GIF, SVG. Maksimal 2MB. Rekomendasi ukuran: 1920x600px
                        </div>
                    </div>

                    <!-- Preview Gambar -->
                    <div class="mb-3" id="add_image_preview_container" style="display: none;">
                        <label class="form-label">Preview Gambar</label>
                        <div class="text-center border rounded p-3" style="background: #f8f9fa;">
                            <img id="add_image_preview" src="" alt="Preview" class="img-fluid rounded"
                                style="max-height: 300px;">
                            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeAddImage()">
                                <ion-icon name="trash"></ion-icon> Hapus Gambar
                            </button>
                        </div>
                    </div>

                    <!-- Teks Promosi -->
                    <div class="mb-3">
                        <label for="add_promotion" class="form-label">
                            Teks Promosi <span class="text-muted">(Opsional)</span>
                        </label>
                        <input type="text" class="form-control @error('promotion') is-invalid @enderror"
                            id="add_promotion" name="promotion" placeholder="Contoh: Sale 50% Off! Limited Time Only">
                        @error('promotion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            Teks promosi akan ditampilkan sebagai judul banner (maksimal 255 karakter)
                        </div>
                    </div>

                    <!-- Contoh Teks Promosi -->
                    <div class="mb-3">
                        <label class="form-label">Contoh Teks Promosi:</label>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-success" style="cursor: pointer;"
                                onclick="document.getElementById('add_promotion').value='Sale 50% Off! Limited Time Only'">
                                <ion-icon name="pricetag"></ion-icon> Sale 50%
                            </span>
                            <span class="badge bg-danger" style="cursor: pointer;"
                                onclick="document.getElementById('add_promotion').value='New Arrival Collection 2024'">
                                <ion-icon name="sparkles"></ion-icon> New Arrival
                            </span>
                            <span class="badge bg-warning" style="cursor: pointer;"
                                onclick="document.getElementById('add_promotion').value='Free Shipping for All Orders'">
                                <ion-icon name="rocket"></ion-icon> Free Shipping
                            </span>
                            <span class="badge bg-info" style="cursor: pointer;"
                                onclick="document.getElementById('add_promotion').value='Buy 1 Get 1 Free Today Only!'">
                                <ion-icon name="gift"></ion-icon> Buy 1 Get 1
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
                        <ion-icon name="save-outline"></ion-icon> Simpan Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script untuk Preview Gambar -->
<script>
    // Preview gambar saat dipilih
    document.getElementById('add_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('add_image_preview').src = e.target.result;
                document.getElementById('add_image_preview_container').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Hapus preview gambar
    function removeAddImage() {
        document.getElementById('add_image').value = '';
        document.getElementById('add_image_preview').src = '';
        document.getElementById('add_image_preview_container').style.display = 'none';
    }
</script>
