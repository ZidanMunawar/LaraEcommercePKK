@if ($banner)
    <!-- Edit Banner Modal -->
    <div class="modal fade" id="editBannerModal{{ $banner->id }}" tabindex="-1"
        aria-labelledby="editBannerModalLabel{{ $banner->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.master.banners.update', $banner->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBannerModalLabel{{ $banner->id }}">Edit Banner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Current Image -->
                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->promotion }}"
                                    class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>

                        <!-- New Image Upload -->
                        <div class="mb-3">
                            <label for="edit_image_{{ $banner->id }}" class="form-label">
                                Ganti Gambar Banner <span class="text-muted">(Opsional)</span>
                            </label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="edit_image_{{ $banner->id }}" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPEG, PNG, JPG, GIF, SVG. Maksimal 2MB.</small>
                        </div>

                        <!-- New Image Preview -->
                        <div class="mb-3" id="edit_image_preview_container_{{ $banner->id }}"
                            style="display: none;">
                            <label class="form-label">Preview Gambar Baru</label>
                            <div class="text-center">
                                <img id="edit_image_preview_{{ $banner->id }}" src="" alt="Preview"
                                    class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>

                        <!-- Promotion Text -->
                        <div class="mb-3">
                            <label for="edit_promotion_{{ $banner->id }}" class="form-label">Teks Promosi</label>
                            <input type="text" class="form-control @error('promotion') is-invalid @enderror"
                                id="edit_promotion_{{ $banner->id }}" name="promotion"
                                value="{{ old('promotion', $banner->promotion) }}" placeholder="Masukkan teks promosi">
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
                        <button type="submit" class="btn btn-primary">
                            <ion-icon name="save"></ion-icon> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script for Image Preview -->
    <script>
        document.getElementById('edit_image_{{ $banner->id }}').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('edit_image_preview_{{ $banner->id }}').src = e.target.result;
                    document.getElementById('edit_image_preview_container_{{ $banner->id }}').style.display =
                        'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endif
