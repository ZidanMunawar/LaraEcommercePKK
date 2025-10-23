<!-- Add Banner Modal -->
<div class="modal fade" id="addBannerModal" tabindex="-1" aria-labelledby="addBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.master.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addBannerModalLabel">Tambah Banner Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="add_image" class="form-label">Gambar Banner <span
                                class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="add_image"
                            name="image" accept="image/*" required>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPEG, PNG, JPG, GIF, SVG. Maksimal 2MB.</small>
                    </div>

                    <!-- Image Preview -->
                    <div class="mb-3" id="add_image_preview_container" style="display: none;">
                        <label class="form-label">Preview Gambar</label>
                        <div class="text-center">
                            <img id="add_image_preview" src="" alt="Preview" class="img-fluid rounded"
                                style="max-height: 200px;">
                        </div>
                    </div>

                    <!-- Promotion Text -->
                    <div class="mb-3">
                        <label for="add_promotion" class="form-label">Teks Promosi</label>
                        <input type="text" class="form-control @error('promotion') is-invalid @enderror"
                            id="add_promotion" name="promotion" placeholder="Masukkan teks promosi">
                        @error('promotion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Opsional. Maksimal 255 karakter.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close"></ion-icon> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <ion-icon name="save"></ion-icon> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script for Image Preview -->
<script>
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
</script>
