<!-- Modal Tambah Warna -->
<div class="modal fade" id="addColorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.master.colors.store') }}" method="POST">
                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <ion-icon name="add-circle-outline" class="align-middle"></ion-icon>
                        Tambah Warna Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Nama Warna -->
                    <div class="mb-3">
                        <label for="colorName" class="form-label">
                            Nama Warna <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="colorName" name="name"
                            placeholder="Contoh: Merah, Biru, Hitam" required>
                        <div class="form-text">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            Masukkan nama warna yang mudah dipahami
                        </div>
                    </div>

                    <!-- Kode Warna -->
                    <div class="mb-3">
                        <label class="form-label">
                            Pilih Warna <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-2 align-items-center">
                            <!-- Color Picker -->
                            <input type="color" class="form-control form-control-color" id="colorPicker"
                                name="code" value="#FF0000" required style="width: 80px; height: 45px;">

                            <!-- Kode Hex Input -->
                            <input type="text" class="form-control" id="colorCodeInput" placeholder="#FF0000"
                                value="#FF0000" pattern="^#[0-9A-Fa-f]{6}$" title="Format: #RRGGBB" readonly>
                        </div>
                        <div class="form-text">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            Klik kotak warna untuk memilih, atau masukkan kode hex
                        </div>
                    </div>

                    <!-- Preview Warna -->
                    <div class="mb-3">
                        <label class="form-label">Preview Warna</label>
                        <div id="colorPreview" class="border rounded p-3 text-center"
                            style="background-color: #FF0000; height: 80px;">
                            <span class="badge bg-dark bg-opacity-50" style="font-size: 14px;">
                                <ion-icon name="eye-outline" class="align-middle"></ion-icon>
                                Preview
                            </span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close-outline"></ion-icon> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <ion-icon name="save-outline"></ion-icon> Simpan Warna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script untuk modal add -->
<script>
    // Update preview saat color picker berubah
    document.getElementById('colorPicker').addEventListener('input', function(event) {
        let color = event.target.value;
        document.getElementById('colorPreview').style.backgroundColor = color;
        document.getElementById('colorCodeInput').value = color.toUpperCase();
    });

    // Update preview saat input hex berubah
    document.getElementById('colorCodeInput').addEventListener('input', function(event) {
        let color = event.target.value;
        // Cek apakah format hex valid
        if (/^#[0-9A-Fa-f]{6}$/.test(color)) {
            document.getElementById('colorPreview').style.backgroundColor = color;
            document.getElementById('colorPicker').value = color;
        }
    });
</script>
