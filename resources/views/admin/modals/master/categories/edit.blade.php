@if (isset($category))
    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1"
        aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.master.categories.update', $category->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">
                            <ion-icon name="pencil" class="align-middle"></ion-icon> Edit Category -
                            {{ $category->name }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Category Name -->
                        <div class="mb-3">
                            <label for="edit_name_{{ $category->id }}" class="form-label">
                                Category Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="edit_name_{{ $category->id }}" name="name"
                                value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if ($category->image)
                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <div class="text-center border rounded p-2">
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                        class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            </div>
                        @endif

                        <!-- New Image Upload -->
                        <div class="mb-3">
                            <label for="edit_image_{{ $category->id }}" class="form-label">
                                {{ $category->image ? 'Change Image' : 'Upload Image' }}
                                <span class="text-muted">(Optional)</span>
                            </label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="edit_image_{{ $category->id }}" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPEG, PNG, JPG, GIF, SVG. Max 2MB.</small>
                        </div>

                        <!-- New Image Preview -->
                        <div class="mb-3" id="edit_image_preview_container_{{ $category->id }}"
                            style="display: none;">
                            <label class="form-label">New Image Preview</label>
                            <div class="text-center border rounded p-2">
                                <img id="edit_image_preview_{{ $category->id }}" src="" alt="Preview"
                                    class="img-fluid rounded" style="max-height: 150px;">
                                <button type="button" class="btn btn-sm btn-danger mt-2"
                                    onclick="removeEditImage({{ $category->id }})">
                                    <ion-icon name="trash"></ion-icon> Remove New Image
                                </button>
                            </div>
                        </div>

                        <!-- Audiences (Multi-Select) -->
                        <div class="mb-3">
                            <label class="form-label">
                                Select Audiences <span class="text-muted">(Optional - Multiple Select)</span>
                            </label>
                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                @php
                                    $selectedAudienceIds = old(
                                        'audience_ids',
                                        $category->audiences->pluck('id')->toArray(),
                                    );
                                @endphp
                                @forelse($audiences as $audience)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="audience_ids[]"
                                            value="{{ $audience->id }}"
                                            id="edit_audience_{{ $category->id }}_{{ $audience->id }}"
                                            {{ in_array($audience->id, $selectedAudienceIds) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="edit_audience_{{ $category->id }}_{{ $audience->id }}">
                                            {{ $audience->name }}
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0">No audiences available. Please create audiences first.
                                    </p>
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
                                    onclick="selectAllAudiencesEdit({{ $category->id }})">
                                    <ion-icon name="checkmark-done-outline"></ion-icon> Select All
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                    onclick="deselectAllAudiencesEdit({{ $category->id }})">
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
                            <ion-icon name="save-outline"></ion-icon> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script for Edit Modal -->
    <script>
        // Image preview for edit
        document.getElementById('edit_image_{{ $category->id }}').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('edit_image_preview_{{ $category->id }}').src = e.target.result;
                    document.getElementById('edit_image_preview_container_{{ $category->id }}').style.display =
                        'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove new image preview
        function removeEditImage(categoryId) {
            document.getElementById('edit_image_' + categoryId).value = '';
            document.getElementById('edit_image_preview_' + categoryId).src = '';
            document.getElementById('edit_image_preview_container_' + categoryId).style.display = 'none';
        }

        // Select all audiences
        function selectAllAudiencesEdit(categoryId) {
            const checkboxes = document.querySelectorAll('#editCategoryModal' + categoryId +
                ' input[name="audience_ids[]"]');
            checkboxes.forEach(cb => cb.checked = true);
        }

        // Deselect all audiences
        function deselectAllAudiencesEdit(categoryId) {
            const checkboxes = document.querySelectorAll('#editCategoryModal' + categoryId +
                ' input[name="audience_ids[]"]');
            checkboxes.forEach(cb => cb.checked = false);
        }
    </script>
@endif
