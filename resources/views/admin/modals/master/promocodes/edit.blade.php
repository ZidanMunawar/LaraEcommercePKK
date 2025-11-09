@if (isset($promocode))
    <!-- Modal Edit Kode Promo -->
    <div class="modal fade" id="editPromoCodeModal{{ $promocode->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form action="{{ route('admin.master.promocodes.update', $promocode->id) }}" method="POST"
                    enctype="multipart/form-data" id="editPromoForm{{ $promocode->id }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <ion-icon name="pencil-outline" class="align-middle"></ion-icon>
                            Edit Kode Promo
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Info -->
                        <div class="alert alert-info border-0 mb-3">
                            <ion-icon name="information-circle" class="align-middle me-1"></ion-icon>
                            Mengedit: <strong>{{ $promocode->code }}</strong>
                        </div>

                        <!-- Kode Promo -->
                        <div class="mb-3">
                            <label for="edit_code_{{ $promocode->id }}" class="form-label fw-semibold">
                                Kode Promo <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control text-uppercase"
                                id="edit_code_{{ $promocode->id }}" name="code"
                                value="{{ old('code', $promocode->code) }}" required>
                            <small class="form-text text-muted">Huruf, angka, dash (-), underscore (_)</small>
                        </div>

                        <hr>

                        <!-- Tipe Diskon -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Tipe Diskon <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="discount_type"
                                        id="edit_percentage_{{ $promocode->id }}" value="percentage"
                                        {{ old('discount_type', $promocode->discount_type) == 'percentage' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit_percentage_{{ $promocode->id }}">
                                        <ion-icon name="percent-outline" class="align-middle"></ion-icon> Persentase (%)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="discount_type"
                                        id="edit_fixed_{{ $promocode->id }}" value="fixed"
                                        {{ old('discount_type', $promocode->discount_type) == 'fixed' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit_fixed_{{ $promocode->id }}">
                                        <ion-icon name="cash-outline" class="align-middle"></ion-icon> Nominal (Rp)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Nilai Diskon -->
                        <div class="mb-3">
                            <label for="edit_discount_{{ $promocode->id }}" class="form-label fw-semibold">
                                Nilai Diskon <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="edit_discount_{{ $promocode->id }}"
                                name="discount" value="{{ old('discount', $promocode->discount) }}" step="1"
                                min="0" max="{{ $promocode->discount_type == 'percentage' ? 100 : 999999999 }}"
                                required>
                            <small class="form-text text-muted" id="edit_discount_text_{{ $promocode->id }}">
                                @if ($promocode->discount_type == 'percentage')
                                    Masukkan persentase diskon (1-100)
                                @else
                                    Masukkan nominal diskon dalam rupiah
                                @endif
                            </small>
                        </div>

                        <!-- Minimal Pembelian -->
                        <div class="mb-3">
                            <label for="edit_min_purchase_{{ $promocode->id }}" class="form-label fw-semibold">
                                Minimal Pembelian <span class="text-muted">(Opsional)</span>
                            </label>
                            <input type="number" class="form-control" id="edit_min_purchase_{{ $promocode->id }}"
                                name="min_purchase" value="{{ old('min_purchase', $promocode->min_purchase) }}"
                                step="1000" min="0">
                            <small class="form-text text-muted">Isi 0 = tidak ada minimal</small>
                        </div>

                        <hr>

                        <!-- Tanggal Kadaluarsa -->
                        <div class="mb-3">
                            <label for="edit_expires_at_{{ $promocode->id }}" class="form-label fw-semibold">
                                Tanggal Kadaluarsa <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" class="form-control" id="edit_expires_at_{{ $promocode->id }}"
                                name="expires_at"
                                value="{{ old('expires_at', $promocode->expires_at->format('Y-m-d\TH:i')) }}" required>
                        </div>

                        <!-- Status -->
                        @php
                            $now = now();
                            $isExpired = $promocode->expires_at < $now;
                        @endphp
                        <div class="alert alert-{{ $isExpired ? 'danger' : 'success' }} border-0">
                            <ion-icon name="{{ $isExpired ? 'close-circle' : 'checkmark-circle' }}"
                                class="align-middle me-1"></ion-icon>
                            <strong>Status:</strong> {{ $isExpired ? 'Kadaluarsa' : 'Aktif' }}
                        </div>

                        <hr>

                        <!-- Gambar Saat Ini -->
                        @if ($promocode->image)
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Gambar Saat Ini</label>
                                <div class="text-center border rounded p-3 bg-light">
                                    <img src="{{ asset('storage/' . $promocode->image) }}"
                                        alt="{{ $promocode->code }}" class="img-fluid rounded"
                                        style="max-height: 140px;">
                                </div>
                            </div>
                        @endif

                        <!-- Upload Gambar Baru -->
                        <div class="mb-3">
                            <label for="edit_image_{{ $promocode->id }}" class="form-label fw-semibold">
                                {{ $promocode->image ? 'Ganti Gambar' : 'Upload Gambar' }} <span
                                    class="text-muted">(Opsional)</span>
                            </label>
                            <input type="file" class="form-control" id="edit_image_{{ $promocode->id }}"
                                name="image" accept="image/*">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin ubah. Max 2MB</small>
                        </div>

                        <!-- Preview Gambar Baru -->
                        <div class="mb-3" id="edit_image_preview_container_{{ $promocode->id }}"
                            style="display: none;">
                            <label class="form-label fw-semibold">Preview Baru</label>
                            <div class="text-center border rounded p-3 bg-light">
                                <img id="edit_image_preview_{{ $promocode->id }}" src="" alt="Preview"
                                    class="img-fluid rounded" style="max-height: 140px;">
                                <button type="button" class="btn btn-sm btn-danger mt-2"
                                    onclick="removeEditImage({{ $promocode->id }})">
                                    <ion-icon name="trash"></ion-icon> Hapus
                                </button>
                            </div>
                        </div>

                        <!-- Info Update -->
                        <div class="text-muted small mt-3">
                            <ion-icon name="time-outline" class="align-middle"></ion-icon>
                            Terakhir diubah: {{ $promocode->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline" class="align-middle"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <ion-icon name="save-outline" class="align-middle"></ion-icon> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Modal Edit -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preview gambar edit
            const editImageInput{{ $promocode->id }} = document.getElementById('edit_image_{{ $promocode->id }}');
            if (editImageInput{{ $promocode->id }}) {
                editImageInput{{ $promocode->id }}.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('edit_image_preview_{{ $promocode->id }}').src = e
                                .target.result;
                            document.getElementById(
                                    'edit_image_preview_container_{{ $promocode->id }}').style
                                .display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Auto uppercase kode promo
            const editCodeInput{{ $promocode->id }} = document.getElementById('edit_code_{{ $promocode->id }}');
            if (editCodeInput{{ $promocode->id }}) {
                editCodeInput{{ $promocode->id }}.addEventListener('input', function(e) {
                    this.value = this.value.toUpperCase();
                });
            }

            // ✅ UPDATE MAX/MIN BERDASARKAN TIPE DISKON
            const editDiscountInput{{ $promocode->id }} = document.getElementById(
                'edit_discount_{{ $promocode->id }}');
            const editDiscountText{{ $promocode->id }} = document.getElementById(
                'edit_discount_text_{{ $promocode->id }}');
            const editPercentageRadio{{ $promocode->id }} = document.getElementById(
                'edit_percentage_{{ $promocode->id }}');
            const editFixedRadio{{ $promocode->id }} = document.getElementById('edit_fixed_{{ $promocode->id }}');

            function updateEditDiscountLimit{{ $promocode->id }}() {
                if (editPercentageRadio{{ $promocode->id }} && editPercentageRadio{{ $promocode->id }}.checked) {
                    editDiscountInput{{ $promocode->id }}.max = 100;
                    editDiscountText{{ $promocode->id }}.textContent = 'Masukkan persentase diskon (1-100)';
                } else {
                    editDiscountInput{{ $promocode->id }}.max = 999999999;
                    editDiscountText{{ $promocode->id }}.textContent = 'Masukkan nominal diskon dalam rupiah';
                }
            }

            if (editPercentageRadio{{ $promocode->id }}) {
                editPercentageRadio{{ $promocode->id }}.addEventListener('change',
                    updateEditDiscountLimit{{ $promocode->id }});
            }
            if (editFixedRadio{{ $promocode->id }}) {
                editFixedRadio{{ $promocode->id }}.addEventListener('change',
                    updateEditDiscountLimit{{ $promocode->id }});
            }

            // ✅ VALIDASI FORM SEBELUM SUBMIT
            const editPromoForm{{ $promocode->id }} = document.getElementById(
            'editPromoForm{{ $promocode->id }}');
            if (editPromoForm{{ $promocode->id }}) {
                editPromoForm{{ $promocode->id }}.addEventListener('submit', function(e) {
                    const discountType = document.querySelector(
                            '#editPromoCodeModal{{ $promocode->id }} input[name="discount_type"]:checked')
                        .value;
                    const discountValue = parseInt(editDiscountInput{{ $promocode->id }}.value);

                    if (discountType === 'percentage' && discountValue > 100) {
                        e.preventDefault();
                        alert('Persentase diskon maksimal 100%');
                        editDiscountInput{{ $promocode->id }}.focus();
                        return false;
                    }

                    if (discountValue < 0) {
                        e.preventDefault();
                        alert('Diskon tidak boleh negatif');
                        editDiscountInput{{ $promocode->id }}.focus();
                        return false;
                    }
                });
            }
        });

        // Hapus preview gambar edit
        function removeEditImage(promocodeId) {
            document.getElementById('edit_image_' + promocodeId).value = '';
            document.getElementById('edit_image_preview_' + promocodeId).src = '';
            document.getElementById('edit_image_preview_container_' + promocodeId).style.display = 'none';
        }
    </script>
@endif
