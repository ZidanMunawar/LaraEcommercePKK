@if (isset($category))
    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.master.categories.update', $category->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <ion-icon name="pencil" class="align-middle"></ion-icon>
                            Edit Kategori - {{ $category->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Info kategori yang diedit -->
                        <div class="alert alert-info">
                            <ion-icon name="information-circle"></ion-icon>
                            Anda sedang mengedit kategori: <strong>{{ $category->name }}</strong>
                        </div>

                        <!-- Nama Kategori -->
                        <div class="mb-3">
                            <label for="edit_name_{{ $category->id }}" class="form-label">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_name_{{ $category->id }}" name="name"
                                value="{{ old('name', $category->name) }}" required>
                        </div>

                        <!-- Gambar Saat Ini -->
                        @if ($category->image)
                            <div class="mb-3">
                                <label class="form-label">Gambar Saat Ini</label>
                                <div class="text-center border rounded p-2">
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                        class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            </div>
                        @endif

                        <!-- Upload Gambar Baru -->
                        <div class="mb-3">
                            <label for="edit_image_{{ $category->id }}" class="form-label">
                                {{ $category->image ? 'Ganti Gambar' : 'Upload Gambar' }} <span
                                    class="text-muted">(Opsional)</span>
                            </label>
                            <input type="file" class="form-control" id="edit_image_{{ $category->id }}"
                                name="image" accept="image/*">
                            <div class="form-text">
                                <ion-icon name="information-circle-outline"></ion-icon>
                                Format: JPEG, PNG, JPG, GIF, SVG. Maksimal 2MB
                            </div>
                        </div>

                        <!-- Preview Gambar Baru -->
                        <div class="mb-3" id="edit_image_preview_container_{{ $category->id }}"
                            style="display: none;">
                            <label class="form-label">Preview Gambar Baru</label>
                            <div class="text-center border rounded p-2">
                                <img id="edit_image_preview_{{ $category->id }}" src="" alt="Preview"
                                    class="img-fluid rounded" style="max-height: 150px;">
                                <button type="button" class="btn btn-sm btn-danger mt-2"
                                    onclick="removeEditImage({{ $category->id }})">
                                    <ion-icon name="trash"></ion-icon> Hapus Gambar Baru
                                </button>
                            </div>
                        </div>

                        <!-- Pilih Audiens -->
                        <div class="mb-3">
                            <label class="form-label">
                                Pilih Audiens Target <span class="text-muted">(Opsional - Bisa lebih dari satu)</span>
                            </label>
                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                @php
                                    $selectedAudienceIds = old(
                                        'audience_ids',
                                        $category->audiences->pluck('id')->toArray(),
                                    );
                                @endphp
                                @forelse($audiences as $audience)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="audience_ids[]"
                                            value="{{ $audience->id }}"
                                            id="edit_audience_{{ $category->id }}_{{ $audience->id }}"
                                            {{ in_array($audience->id, $selectedAudienceIds) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="edit_audience_{{ $category->id }}_{{ $audience->id }}">
                                            {{ $audience->name }}
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0">Belum ada audiens. Silakan buat audiens terlebih dahulu.
                                    </p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Select/Deselect All -->
                        @if ($audiences->isNotEmpty())
                            <div class="mb-3">
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="selectAllAudiencesEdit({{ $category->id }})">
                                    <ion-icon name="checkmark-done-outline"></ion-icon> Pilih Semua
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                    onclick="deselectAllAudiencesEdit({{ $category->id }})">
                                    <ion-icon name="close-outline"></ion-icon> Batal Pilih Semua
                                </button>
                            </div>
                        @endif

                        <!-- Info terakhir diubah -->
                        <div class="text-muted small">
                            <ion-icon name="time-outline"></ion-icon>
                            Terakhir diubah: {{ $category->updated_at->format('d M Y, H:i') }}
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

    <script>
        // Preview gambar edit
        document.getElementById('edit_image_{{ $category->id }}').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('edit_image_preview_{{ $category->id }}').src = e.target.result;
                    document.getElementById('edit_image_preview_container_{{ $category->id }}').style.display =
                        'block';
                };
                reader.readAsDataURL(file);
            }
        });

        function removeEditImage(categoryId) {
            document.getElementById('edit_image_' + categoryId).value = '';
            document.getElementById('edit_image_preview_' + categoryId).src = '';
            document.getElementById('edit_image_preview_container_' + categoryId).style.display = 'none';
        }

        function selectAllAudiencesEdit(categoryId) {
            const checkboxes = document.querySelectorAll('#editCategoryModal' + categoryId +
                ' input[name="audience_ids[]"]');
            checkboxes.forEach(cb => cb.checked = true);
        }

        function deselectAllAudiencesEdit(categoryId) {
            const checkboxes = document.querySelectorAll('#editCategoryModal' + categoryId +
                ' input[name="audience_ids[]"]');
            checkboxes.forEach(cb => cb.checked = false);
        }
    </script>
@endif
