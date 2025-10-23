<!-- Add Slide Modal -->
<div class="modal fade" id="addSlideModal" tabindex="-1" aria-labelledby="addSlideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.master.slides.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addSlideModalLabel">Add Slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Slide Image -->
                    <div class="mb-3">
                        <label for="add_image" class="form-label">Slide Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="add_image"
                            name="image" accept="image/*" required>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPEG, PNG, JPG, GIF, SVG. Max 2MB. Recommended:
                            1920x600px</small>
                    </div>

                    <!-- Image Preview -->
                    <div class="mb-3" id="add_image_preview_container" style="display: none;">
                        <label class="form-label">Image Preview</label>
                        <div class="text-center">
                            <img id="add_image_preview" src="" alt="Preview" class="img-fluid rounded"
                                style="max-height: 200px;">
                        </div>
                    </div>

                    <!-- Promotion -->
                    <div class="mb-3">
                        <label for="add_promotion_id" class="form-label">Promotion <span
                                class="text-muted">(Optional)</span></label>
                        <select class="form-select @error('promotion_id') is-invalid @enderror" id="add_promotion_id"
                            name="promotion_id">
                            <option value="">Select Promotion</option>
                            @foreach ($promotions as $promotion)
                                <option value="{{ $promotion->id }}"
                                    {{ old('promotion_id') == $promotion->id ? 'selected' : '' }}>
                                    {{ $promotion->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('promotion_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Slide</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script for Image Preview -->
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
</script>
