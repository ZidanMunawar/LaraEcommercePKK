@if (isset($promocode))
    <!-- Edit Promo Code Modal -->
    <div class="modal fade" id="editPromoCodeModal{{ $promocode->id }}" tabindex="-1"
        aria-labelledby="editPromoCodeModalLabel{{ $promocode->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.master.promocodes.update', $promocode->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPromoCodeModalLabel{{ $promocode->id }}">
                            Edit Promo Code - {{ $promocode->code }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Promo Code -->
                        <div class="mb-3">
                            <label for="edit_code_{{ $promocode->id }}" class="form-label">
                                Promo Code <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('code') is-invalid @enderror text-uppercase"
                                id="edit_code_{{ $promocode->id }}" name="code"
                                value="{{ old('code', $promocode->code) }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Only letters, numbers, dash, and underscore allowed.</small>
                        </div>

                        <!-- Current Image -->
                        @if ($promocode->image)
                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $promocode->image) }}" alt="{{ $promocode->code }}"
                                        class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            </div>
                        @endif

                        <!-- New Image Upload -->
                        <div class="mb-3">
                            <label for="edit_image_{{ $promocode->id }}" class="form-label">
                                Change Image <span class="text-muted">(Optional)</span>
                            </label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="edit_image_{{ $promocode->id }}" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPEG, PNG, JPG, GIF, SVG. Max 2MB.</small>
                        </div>

                        <!-- New Image Preview -->
                        <div class="mb-3" id="edit_image_preview_container_{{ $promocode->id }}"
                            style="display: none;">
                            <label class="form-label">New Image Preview</label>
                            <div class="text-center">
                                <img id="edit_image_preview_{{ $promocode->id }}" src="" alt="Preview"
                                    class="img-fluid rounded" style="max-height: 150px;">
                            </div>
                        </div>

                        <!-- Discount -->
                        <div class="mb-3">
                            <label for="edit_discount_{{ $promocode->id }}" class="form-label">
                                Discount <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control @error('discount') is-invalid @enderror"
                                id="edit_discount_{{ $promocode->id }}" name="discount"
                                value="{{ old('discount', $promocode->discount) }}" step="0.01" min="0"
                                required>
                            @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Can be percentage (%) or fixed amount (Rp).</small>
                        </div>

                        <!-- Expires At -->
                        <div class="mb-3">
                            <label for="edit_expires_at_{{ $promocode->id }}" class="form-label">
                                Expires At <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror"
                                id="edit_expires_at_{{ $promocode->id }}" name="expires_at"
                                value="{{ old('expires_at', $promocode->expires_at->format('Y-m-d\TH:i')) }}" required>
                            @error('expires_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Must be a future date and time.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script for Image Preview -->
    <script>
        document.getElementById('edit_image_{{ $promocode->id }}').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('edit_image_preview_{{ $promocode->id }}').src = e.target.result;
                    document.getElementById('edit_image_preview_container_{{ $promocode->id }}').style
                        .display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Auto uppercase for promo code
        document.getElementById('edit_code_{{ $promocode->id }}').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });
    </script>
@endif
