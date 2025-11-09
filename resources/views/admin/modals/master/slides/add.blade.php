<!-- Modal Tambah Slide -->
<div class="modal fade" id="addSlideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.master.slides.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <ion-icon name="add-circle-outline" class="align-middle"></ion-icon>
                        Tambah Slide Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Info -->
                    <div class="alert alert-info">
                        <ion-icon name="information-circle"></ion-icon>
                        <strong>Info:</strong> Slide akan ditampilkan sebagai carousel di halaman utama customer.
                        Maksimal 4 slide.
                    </div>

                    <!-- Upload Gambar Slide -->
                    <div class="mb-3">
                        <label for="add_image" class="form-label">
                            Gambar Slide <span class="text-danger">*</span>
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

                    <!-- Pilih Promosi -->
                    <div class="mb-3">
                        <label for="add_promotion_id" class="form-label">
                            Promosi <span class="text-muted">(Opsional)</span>
                        </label>
                        <select class="form-select @error('promotion_id') is-invalid @enderror" id="add_promotion_id"
                            name="promotion_id">
                            <option value="">-- Pilih Promosi --</option>
                            @foreach ($promotions as $promotion)
                                <option value="{{ $promotion->id }}"
                                    {{ old('promotion_id') == $promotion->id ? 'selected' : '' }}>
                                    {{ $promotion->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('promotion_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            Promosi akan ditampilkan sebagai badge di slide (opsional)
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close-outline"></ion-icon> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <ion-icon name="save-outline"></ion-icon> Simpan Slide
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script untuk Preview Gambar -->
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

    function removeAddImage() {
        document.getElementById('add_image').value = '';
        document.getElementById('add_image_preview').src = '';
        document.getElementById('add_image_preview_container').style.display = 'none';
    }
</script>
