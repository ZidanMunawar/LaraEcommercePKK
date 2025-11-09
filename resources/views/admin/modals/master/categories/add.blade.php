<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.master.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Header modal -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <ion-icon name="add-circle-outline" class="align-middle"></ion-icon>
                        Tambah Kategori Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body modal -->
                <div class="modal-body">
                    <!-- Nama Kategori -->
                    <div class="mb-3">
                        <label for="add_name" class="form-label">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="add_name"
                            name="name" placeholder="Contoh: Kaos, Kemeja, Celana" value="{{ old('name') }}"
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Upload Gambar -->
                    <div class="mb-3">
                        <label for="add_image" class="form-label">
                            Gambar Kategori <span class="text-muted">(Opsional)</span>
                        </label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="add_image"
                            name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            Format: JPEG, PNG, JPG, GIF, SVG. Maksimal 2MB
                        </div>
                    </div>

                    <!-- Preview Gambar -->
                    <div class="mb-3" id="add_image_preview_container" style="display: none;">
                        <label class="form-label">Preview Gambar</label>
                        <div class="text-center border rounded p-3">
                            <img id="add_image_preview" src="" alt="Preview" class="img-fluid rounded"
                                style="max-height: 200px;">
                            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeAddImage()">
                                <ion-icon name="trash"></ion-icon> Hapus Gambar
                            </button>
                        </div>
                    </div>

                    <!-- Pilih Audiens -->
                    <div class="mb-3">
                        <label class="form-label">
                            Pilih Audiens Target <span class="text-muted">(Opsional - Bisa lebih dari satu)</span>
                        </label>
                        <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                            @forelse($audiences as $audience)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="audience_ids[]"
                                        value="{{ $audience->id }}" id="add_audience_{{ $audience->id }}"
                                        {{ in_array($audience->id, old('audience_ids', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="add_audience_{{ $audience->id }}">
                                        {{ $audience->name }}
                                    </label>
                                </div>
                            @empty
                                <p class="text-muted mb-0">
                                    Belum ada audiens. Silakan buat audiens terlebih dahulu.
                                </p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tombol Select/Deselect All -->
                    @if ($audiences->isNotEmpty())
                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="selectAllAudiencesAdd()">
                                <ion-icon name="checkmark-done-outline"></ion-icon> Pilih Semua
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                onclick="deselectAllAudiencesAdd()">
                                <ion-icon name="close-outline"></ion-icon> Batal Pilih Semua
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Footer modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close-outline"></ion-icon> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <ion-icon name="save-outline"></ion-icon> Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script untuk modal add -->
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

    // Centang semua audiens
    function selectAllAudiencesAdd() {
        const checkboxes = document.querySelectorAll('#addCategoryModal input[name="audience_ids[]"]');
        checkboxes.forEach(cb => cb.checked = true);
    }

    // Batal centang semua audiens
    function deselectAllAudiencesAdd() {
        const checkboxes = document.querySelectorAll('#addCategoryModal input[name="audience_ids[]"]');
        checkboxes.forEach(cb => cb.checked = false);
    }
</script>
