<!-- Add Promo Code Modal -->
<div class="modal fade" id="addPromoCodeModal" tabindex="-1" aria-labelledby="addPromoCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.master.promocodes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addPromoCodeModalLabel">Add Promo Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Promo Code -->
                    <div class="mb-3">
                        <label for="add_code" class="form-label">Promo Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror text-uppercase"
                            id="add_code" name="code" placeholder="e.g. SUMMER20" value="{{ old('code') }}"
                            required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Only letters, numbers, dash, and underscore allowed.</small>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="add_image" class="form-label">Promo Image <span
                                class="text-muted">(Optional)</span></label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="add_image"
                            name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPEG, PNG, JPG, GIF, SVG. Max 2MB.</small>
                    </div>

                    <!-- Image Preview -->
                    <div class="mb-3" id="add_image_preview_container" style="display: none;">
                        <label class="form-label">Image Preview</label>
                        <div class="text-center">
                            <img id="add_image_preview" src="" alt="Preview" class="img-fluid rounded"
                                style="max-height: 150px;">
                        </div>
                    </div>

                    <!-- Discount -->
                    <div class="mb-3">
                        <label for="add_discount" class="form-label">Discount <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('discount') is-invalid @enderror"
                            id="add_discount" name="discount" placeholder="e.g. 20 or 50000" step="0.01"
                            min="0" value="{{ old('discount') }}" required>
                        @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Can be percentage (%) or fixed amount (Rp).</small>
                    </div>

                    <!-- Expires At -->
                    <div class="mb-3">
                        <label for="add_expires_at" class="form-label">Expires At <span
                                class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror"
                            id="add_expires_at" name="expires_at" value="{{ old('expires_at') }}" required>
                        @error('expires_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Must be a future date and time.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Promo Code</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script for Image Preview and Auto Uppercase -->
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

    // Auto uppercase for promo code
    document.getElementById('add_code').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase();
    });
</script>
