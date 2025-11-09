@if (isset($color))
    <!-- Modal Edit Warna -->
    <div class="modal fade" id="editColorModal{{ $color->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.master.colors.update', $color->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <ion-icon name="pencil-outline" class="align-middle"></ion-icon>
                            Edit Warna
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Info warna yang diedit -->
                        <div class="alert alert-info">
                            <ion-icon name="information-circle"></ion-icon>
                            Anda sedang mengedit warna: <strong>{{ $color->name }}</strong>
                        </div>

                        <!-- Nama Warna -->
                        <div class="mb-3">
                            <label for="editColorName{{ $color->id }}" class="form-label">
                                Nama Warna <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="editColorName{{ $color->id }}"
                                name="name" value="{{ $color->name }}" required>
                        </div>

                        <!-- Kode Warna -->
                        <div class="mb-3">
                            <label class="form-label">
                                Pilih Warna <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex gap-2 align-items-center">
                                <!-- Color Picker -->
                                <input type="color" class="form-control form-control-color"
                                    id="colorPicker{{ $color->id }}" name="code" value="{{ $color->code }}"
                                    required style="width: 80px; height: 45px;">

                                <!-- Kode Hex Input -->
                                <input type="text" class="form-control" id="colorCodeInput{{ $color->id }}"
                                    value="{{ strtoupper($color->code) }}" pattern="^#[0-9A-Fa-f]{6}$"
                                    title="Format: #RRGGBB" readonly>
                            </div>
                        </div>

                        <!-- Preview Warna -->
                        <div class="mb-3">
                            <label class="form-label">Preview Warna</label>
                            <div id="colorPreview{{ $color->id }}" class="border rounded p-3 text-center"
                                style="background-color: {{ $color->code }}; height: 80px;">
                                <span class="badge bg-dark bg-opacity-50" style="font-size: 14px;">
                                    <ion-icon name="eye-outline" class="align-middle"></ion-icon>
                                    Preview
                                </span>
                            </div>
                        </div>

                        <!-- Info terakhir diubah -->
                        <div class="text-muted small">
                            <ion-icon name="time-outline"></ion-icon>
                            Terakhir diubah: {{ $color->updated_at->format('d M Y, H:i') }}
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

    <!-- Script untuk modal edit -->
    <script>
        // Update preview saat color picker berubah
        document.getElementById('colorPicker{{ $color->id }}').addEventListener('input', function(event) {
            let color = event.target.value;
            document.getElementById('colorPreview{{ $color->id }}').style.backgroundColor = color;
            document.getElementById('colorCodeInput{{ $color->id }}').value = color.toUpperCase();
        });

        // Update preview saat input hex berubah
        document.getElementById('colorCodeInput{{ $color->id }}').addEventListener('input', function(event) {
            let color = event.target.value;
            if (/^#[0-9A-Fa-f]{6}$/.test(color)) {
                document.getElementById('colorPreview{{ $color->id }}').style.backgroundColor = color;
                document.getElementById('colorPicker{{ $color->id }}').value = color;
            }
        });
    </script>
@endif
