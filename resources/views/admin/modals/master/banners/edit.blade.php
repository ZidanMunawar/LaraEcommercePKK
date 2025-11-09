@if (isset($banner))
    <!-- Modal Edit Banner -->
    <div class="modal fade" id="editBannerModal{{ $banner->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.master.banners.update', $banner->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <ion-icon name="pencil-outline" class="align-middle"></ion-icon>
                            Edit Banner
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Info -->
                        <div class="alert alert-info">
                            <ion-icon name="information-circle"></ion-icon>
                            Anda sedang mengedit banner
                            @if ($banner->promotion)
                                <strong>"{{ $banner->promotion }}"</strong>
                            @endif
                        </div>

                        <!-- Gambar Banner Saat Ini -->
                        <div class="mb-3">
                            <label class="form-label">Gambar Banner Saat Ini</label>
                            <div class="text-center border rounded p-3" style="background: #f8f9fa;">
                                <img src="{{ asset('storage/' . $banner->image) }}"
                                    alt="{{ $banner->promotion ?? 'Banner' }}" class="img-fluid rounded"
                                    style="max-height: 250px;">
                            </div>
                        </div>

                        <!-- Upload Gambar Baru -->
                        <div class="mb-3">
                            <label for="edit_image_{{ $banner->id }}" class="form-label">
                                Ganti Gambar Banner <span class="text-muted">(Opsional)</span>
                            </label>
                            <input type="file" class="form-control" id="edit_image_{{ $banner->id }}"
                                name="image" accept="image/*">
                            <div class="form-text">
                                <ion-icon name="information-circle-outline"></ion-icon>
                                Kosongkan jika tidak ingin mengubah gambar. Format: JPEG, PNG, JPG, GIF, SVG. Maksimal
                                2MB
                            </div>
                        </div>

                        <!-- Preview Gambar Baru -->
                        <div class="mb-3" id="edit_image_preview_container_{{ $banner->id }}"
                            style="display: none;">
                            <label class="form-label">Preview Gambar Baru</label>
                            <div class="text-center border rounded p-3" style="background: #f8f9fa;">
                                <img id="edit_image_preview_{{ $banner->id }}" src="" alt="Preview"
                                    class="img-fluid rounded" style="max-height: 250px;">
                                <button type="button" class="btn btn-sm btn-danger mt-2"
                                    onclick="removeEditImage({{ $banner->id }})">
                                    <ion-icon name="trash"></ion-icon> Hapus Gambar Baru
                                </button>
                            </div>
                        </div>

                        <!-- Teks Promosi -->
                        <div class="mb-3">
                            <label for="edit_promotion_{{ $banner->id }}" class="form-label">
                                Teks Promosi <span class="text-muted">(Opsional)</span>
                            </label>
                            <input type="text" class="form-control" id="edit_promotion_{{ $banner->id }}"
                                name="promotion" value="{{ old('promotion', $banner->promotion) }}"
                                placeholder="Masukkan teks promosi">
                            <div class="form-text">
                                <ion-icon name="information-circle-outline"></ion-icon>
                                Teks promosi akan ditampilkan sebagai judul banner (maksimal 255 karakter)
                            </div>
                        </div>

                        <!-- Info Terakhir Diubah -->
                        <div class="text-muted small">
                            <ion-icon name="time-outline"></ion-icon>
                            Terakhir diubah: {{ $banner->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <ion-icon name="save-outline"></ion-icon> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script untuk Edit Modal -->
    <script>
        // Preview gambar edit
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

        // Hapus preview gambar edit
        function removeEditImage(bannerId) {
            document.getElementById('edit_image_' + bannerId).value = '';
            document.getElementById('edit_image_preview_' + bannerId).src = '';
            document.getElementById('edit_image_preview_container_' + bannerId).style.display = 'none';
        }
    </script>
@endif
