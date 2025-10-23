<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.master.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addCategoryModalLabel">
                        <ion-icon name="add-circle-outline" class="align-middle"></ion-icon> Add New Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Category Name -->
                    <div class="mb-3">
                        <label for="add_name" class="form-label">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="add_name"
                            name="name" placeholder="Enter category name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category Image -->
                    <div class="mb-3">
                        <label for="add_image" class="form-label">
                            Category Image <span class="text-muted">(Optional)</span>
                        </label>
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
                            <img id="add_image_preview" src="" alt="Preview" class="img-fluid rounded border"
                                style="max-height: 200px;">
                            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeAddImage()">
                                <ion-icon name="trash"></ion-icon> Remove Image
                            </button>
                        </div>
                    </div>

                    <!-- Audiences (Multi-Select) -->
                    <div class="mb-3">
                        <label class="form-label">
                            Select Audiences <span class="text-muted">(Optional - Multiple Select)</span>
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
                                <p class="text-muted mb-0">No audiences available. Please create audiences first.</p>
                            @endforelse
                        </div>
                        @error('audience_ids')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        @error('audience_ids.*')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Select All / Deselect All -->
                    @if ($audiences->isNotEmpty())
                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="selectAllAudiencesAdd()">
                                <ion-icon name="checkmark-done-outline"></ion-icon> Select All
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                onclick="deselectAllAudiencesAdd()">
                                <ion-icon name="close-outline"></ion-icon> Deselect All
                            </button>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close-outline"></ion-icon> Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <ion-icon name="save-outline"></ion-icon> Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts for Add Modal -->
<script>
    // Image preview
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

    // Remove image preview
    function removeAddImage() {
        document.getElementById('add_image').value = '';
        document.getElementById('add_image_preview').src = '';
        document.getElementById('add_image_preview_container').style.display = 'none';
    }

    // Select all audiences
    function selectAllAudiencesAdd() {
        const checkboxes = document.querySelectorAll('#addCategoryModal input[name="audience_ids[]"]');
        checkboxes.forEach(cb => cb.checked = true);
    }

    // Deselect all audiences
    function deselectAllAudiencesAdd() {
        const checkboxes = document.querySelectorAll('#addCategoryModal input[name="audience_ids[]"]');
        checkboxes.forEach(cb => cb.checked = false);
    }
</script>
