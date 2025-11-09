@if (isset($slide))
    <!-- Modal Edit Slide -->
    <div class="modal fade" id="editSlideModal{{ $slide->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.master.slides.update', $slide->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <ion-icon name="pencil-outline" class="align-middle"></ion-icon>
                            Edit Slide
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Info -->
                        <div class="alert alert-info">
                            <ion-icon name="information-circle"></ion-icon>
                            Anda sedang mengedit slide
                            @if ($slide->promotion)
                                dengan promosi <strong>"{{ $slide->promotion->name }}"</strong>
                            @endif
                        </div>

                        <!-- Gambar Slide Saat Ini -->
                        <div class="mb-3">
                            <label class="form-label">Gambar Slide Saat Ini</label>
                            <div class="text-center border rounded p-3" style="background: #f8f9fa;">
                                <img src="{{ asset('storage/' . $slide->image) }}" alt="Slide"
                                    class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>

                        <!-- Upload Gambar Baru -->
                        <div class="mb-3">
                            <label for="edit_image_{{ $slide->id }}" class="form-label">
                                Ganti Gambar Slide <span class="text-muted">(Opsional)</span>
                            </label>
                            <input type="file" class="form-control" id="edit_image_{{ $slide->id }}"
                                name="image" accept="image/*">
                            <div class="form-text">
                                <ion-icon name="information-circle-outline"></ion-icon>
                                Kosongkan jika tidak ingin mengubah gambar. Format: JPEG, PNG, JPG, GIF, SVG. Maksimal
                                2MB
                            </div>
                        </div>

                        <!-- Preview Gambar Baru -->
                        <div class="mb-3" id="edit_image_preview_container_{{ $slide->id }}"
                            style="display: none;">
                            <label class="form-label">Preview Gambar Baru</label>
                            <div class="text-center border rounded p-3" style="background: #f8f9fa;">
                                <img id="edit_image_preview_{{ $slide->id }}" src="" alt="Preview"
                                    class="img-fluid rounded" style="max-height: 200px;">
                                <button type="button" class="btn btn-sm btn-danger mt-2"
                                    onclick="removeEditImage({{ $slide->id }})">
                                    <ion-icon name="trash"></ion-icon> Hapus Gambar Baru
                                </button>
                            </div>
                        </div>

                        <!-- Pilih Promosi -->
                        <div class="mb-3">
                            <label for="edit_promotion_id_{{ $slide->id }}" class="form-label">
                                Promosi <span class="text-muted">(Opsional)</span>
                            </label>
                            <select class="form-select" id="edit_promotion_id_{{ $slide->id }}" name="promotion_id">
                                <option value="">-- Pilih Promosi --</option>
                                @foreach ($promotions as $promotion)
                                    <option value="{{ $promotion->id }}"
                                        {{ old('promotion_id', $slide->promotion_id) == $promotion->id ? 'selected' : '' }}>
                                        {{ $promotion->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                <ion-icon name="information-circle-outline"></ion-icon>
                                Promosi akan ditampilkan sebagai badge di slide (opsional)
                            </div>
                        </div>

                        <!-- Info Terakhir Diubah -->
                        <div class="text-muted small">
                            <ion-icon name="time-outline"></ion-icon>
                            Terakhir diubah: {{ $slide->updated_at->format('d M Y, H:i') }}
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
        document.getElementById('edit_image_{{ $slide->id }}').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('edit_image_preview_{{ $slide->id }}').src = e.target.result;
                    document.getElementById('edit_image_preview_container_{{ $slide->id }}').style.display =
                        'block';
                };
                reader.readAsDataURL(file);
            }
        });

        function removeEditImage(slideId) {
            document.getElementById('edit_image_' + slideId).value = '';
            document.getElementById('edit_image_preview_' + slideId).src = '';
            document.getElementById('edit_image_preview_container_' + slideId).style.display = 'none';
        }
    </script>
@endif
