@if (isset($slide))
    <!-- Edit Slide Modal -->
    <div class="modal fade" id="editSlideModal{{ $slide->id }}" tabindex="-1"
        aria-labelledby="editSlideModalLabel{{ $slide->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.master.slides.update', $slide->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSlideModalLabel{{ $slide->id }}">
                            Edit Slide
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Current Image -->
                        <div class="mb-3">
                            <label class="form-label">Current Image</label>
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $slide->image) }}" alt="Slide"
                                    class="img-fluid rounded" style="max-height: 150px;">
                            </div>
                        </div>

                        <!-- New Image Upload -->
                        <div class="mb-3">
                            <label for="edit_image_{{ $slide->id }}" class="form-label">
                                Change Image <span class="text-muted">(Optional)</span>
                            </label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="edit_image_{{ $slide->id }}" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPEG, PNG, JPG, GIF, SVG. Max 2MB. Recommended:
                                1920x600px</small>
                        </div>

                        <!-- New Image Preview -->
                        <div class="mb-3" id="edit_image_preview_container_{{ $slide->id }}"
                            style="display: none;">
                            <label class="form-label">New Image Preview</label>
                            <div class="text-center">
                                <img id="edit_image_preview_{{ $slide->id }}" src="" alt="Preview"
                                    class="img-fluid rounded" style="max-height: 150px;">
                            </div>
                        </div>

                        <!-- Promotion -->
                        <div class="mb-3">
                            <label for="edit_promotion_id_{{ $slide->id }}" class="form-label">
                                Promotion <span class="text-muted">(Optional)</span>
                            </label>
                            <select class="form-select @error('promotion_id') is-invalid @enderror"
                                id="edit_promotion_id_{{ $slide->id }}" name="promotion_id">
                                <option value="">Select Promotion</option>
                                @foreach ($promotions as $promotion)
                                    <option value="{{ $promotion->id }}"
                                        {{ old('promotion_id', $slide->promotion_id) == $promotion->id ? 'selected' : '' }}>
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
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script for Image Preview -->
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
    </script>
@endif
