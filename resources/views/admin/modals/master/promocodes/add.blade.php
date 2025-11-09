<!-- Modal Tambah Kode Promo -->
<div class="modal fade" id="addPromoCodeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.master.promocodes.store') }}" method="POST" enctype="multipart/form-data"
                id="addPromoForm">
                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <ion-icon name="add-circle-outline" class="align-middle"></ion-icon>
                        Tambah Kode Promo Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- ✅ TAMBAH STYLE SCROLL DI BODY -->
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <!-- Info Alert -->
                    <div class="alert alert-info border-0 mb-3">
                        <ion-icon name="information-circle" class="align-middle me-1"></ion-icon>
                        Kode promo digunakan customer untuk mendapatkan diskon saat checkout.
                    </div>

                    <!-- Kode Promo -->
                    <div class="mb-3">
                        <label for="add_code" class="form-label fw-semibold">
                            Kode Promo <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control text-uppercase @error('code') is-invalid @enderror"
                            id="add_code" name="code" placeholder="Contoh: SALE50" value="{{ old('code') }}"
                            required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Huruf, angka, dash (-), underscore (_). Auto
                            uppercase.</small>
                    </div>

                    <!-- Quick Fill -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contoh Populer:</label>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-sm btn-outline-success"
                                onclick="document.getElementById('add_code').value='SALE50'">SALE50</button>
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                onclick="document.getElementById('add_code').value='NEWUSER'">NEWUSER</button>
                            <button type="button" class="btn btn-sm btn-outline-warning"
                                onclick="document.getElementById('add_code').value='FREESHIP'">FREESHIP</button>
                            <button type="button" class="btn btn-sm btn-outline-info"
                                onclick="document.getElementById('add_code').value='BOGO'">BOGO</button>
                        </div>
                    </div>

                    <hr>

                    <!-- Tipe Diskon -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tipe Diskon <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="discount_type" id="add_percentage"
                                    value="percentage" checked>
                                <label class="form-check-label" for="add_percentage">
                                    <ion-icon name="percent-outline" class="align-middle"></ion-icon> Persentase (%)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="discount_type" id="add_fixed"
                                    value="fixed">
                                <label class="form-check-label" for="add_fixed">
                                    <ion-icon name="cash-outline" class="align-middle"></ion-icon> Nominal (Rp)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Nilai Diskon -->
                    <div class="mb-3">
                        <label for="add_discount" class="form-label fw-semibold">
                            Nilai Diskon <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control @error('discount') is-invalid @enderror"
                            id="add_discount" name="discount" placeholder="20" step="1" min="0"
                            max="100" value="{{ old('discount') }}" required>
                        @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted" id="add_discount_helper">
                            <span id="add_discount_text">Masukkan persentase diskon (1-100)</span>
                        </small>
                    </div>

                    <!-- Minimal Pembelian -->
                    <div class="mb-3">
                        <label for="add_min_purchase" class="form-label fw-semibold">
                            Minimal Pembelian <span class="text-muted">(Opsional)</span>
                        </label>
                        <input type="number" class="form-control" id="add_min_purchase" name="min_purchase"
                            placeholder="100000" step="1000" min="0" value="0">
                        <small class="form-text text-muted">Minimal pembelian untuk bisa pakai promo. Isi 0 = tidak ada
                            minimal.</small>
                    </div>

                    <hr>

                    <!-- Tanggal Kadaluarsa -->
                    <div class="mb-3">
                        <label for="add_expires_at" class="form-label fw-semibold">
                            Tanggal Kadaluarsa <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror"
                            id="add_expires_at" name="expires_at" value="{{ old('expires_at') }}" required>
                        @error('expires_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Tanggal dan waktu di masa depan</small>
                    </div>

                    <hr>

                    <!-- Upload Gambar -->
                    <div class="mb-3">
                        <label for="add_image" class="form-label fw-semibold">
                            Gambar Promo <span class="text-muted">(Opsional)</span>
                        </label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                            id="add_image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">JPEG, PNG, JPG, GIF, SVG. Max 2MB</small>
                    </div>

                    <!-- Preview Gambar -->
                    <div class="mb-3" id="add_image_preview_container" style="display: none;">
                        <label class="form-label fw-semibold">Preview</label>
                        <div class="text-center border rounded p-3 bg-light">
                            <img id="add_image_preview" src="" alt="Preview" class="img-fluid rounded"
                                style="max-height: 180px;">
                            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeAddImage()">
                                <ion-icon name="trash"></ion-icon> Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close-outline" class="align-middle"></ion-icon> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <ion-icon name="save-outline" class="align-middle"></ion-icon> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script Modal Add -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview gambar
        const addImageInput = document.getElementById('add_image');
        if (addImageInput) {
            addImageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('add_image_preview').src = e.target.result;
                        document.getElementById('add_image_preview_container').style.display =
                            'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Auto uppercase kode promo
        const addCodeInput = document.getElementById('add_code');
        if (addCodeInput) {
            addCodeInput.addEventListener('input', function(e) {
                this.value = this.value.toUpperCase();
            });
        }

        // ✅ UPDATE MAX/MIN BERDASARKAN TIPE DISKON
        const addDiscountInput = document.getElementById('add_discount');
        const addDiscountText = document.getElementById('add_discount_text');
        const addPercentageRadio = document.getElementById('add_percentage');
        const addFixedRadio = document.getElementById('add_fixed');

        function updateAddDiscountLimit() {
            if (addPercentageRadio && addPercentageRadio.checked) {
                addDiscountInput.max = 100;
                addDiscountInput.placeholder = '10';
                addDiscountText.textContent = 'Masukkan persentase diskon (1-100)';
            } else {
                addDiscountInput.max = 999999999;
                addDiscountInput.placeholder = '50000';
                addDiscountText.textContent = 'Masukkan nominal diskon dalam rupiah (contoh: 50000)';
            }
        }

        if (addPercentageRadio) {
            addPercentageRadio.addEventListener('change', updateAddDiscountLimit);
        }
        if (addFixedRadio) {
            addFixedRadio.addEventListener('change', updateAddDiscountLimit);
        }

        // ✅ VALIDASI FORM SEBELUM SUBMIT
        const addPromoForm = document.getElementById('addPromoForm');
        if (addPromoForm) {
            addPromoForm.addEventListener('submit', function(e) {
                const discountType = document.querySelector('input[name="discount_type"]:checked')
                .value;
                const discountValue = parseInt(addDiscountInput.value);

                if (discountType === 'percentage' && discountValue > 100) {
                    e.preventDefault();
                    alert('Persentase diskon maksimal 100%');
                    addDiscountInput.focus();
                    return false;
                }

                if (discountValue < 0) {
                    e.preventDefault();
                    alert('Diskon tidak boleh negatif');
                    addDiscountInput.focus();
                    return false;
                }
            });
        }
    });

    // Hapus preview gambar
    function removeAddImage() {
        document.getElementById('add_image').value = '';
        document.getElementById('add_image_preview').src = '';
        document.getElementById('add_image_preview_container').style.display = 'none';
    }
</script>
