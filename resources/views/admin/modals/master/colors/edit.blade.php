<!-- resources/views/admin/modal/master/colors/edit.blade.php -->

<div class="modal fade" id="editColorModal{{ $color->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Color - {{ $color->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.master.colors.update', $color->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="editColorName" class="form-label">Color Name</label>
                        <input type="text" class="form-control" id="editColorName" name="name"
                            value="{{ $color->name }}" required>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <label for="editColorCode" class="form-label me-2">Color Code</label>
                        <input type="color" class="form-control me-3" id="colorPicker{{ $color->id }}"
                            name="code" value="{{ $color->code }}" required>
                        <input type="text" class="form-control w-50" id="colorCodeInput{{ $color->id }}"
                            name="code_text" value="{{ $color->code }}" placeholder="#FF0000" required
                            pattern="^#[0-9A-Fa-f]{6}$" title="Valid hex color code, e.g. #FF0000">
                    </div>

                    <div class="mb-3">
                        <label for="colorPreview" class="form-label">Preview</label>
                        <div id="colorPreview{{ $color->id }}" class="form-control"
                            style="background-color: {{ $color->code }}; height: 40px;">
                            <!-- Color preview box -->
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Update the color preview when color picker or input changes
    document.getElementById('colorPicker{{ $color->id }}').addEventListener('input', function(event) {
        let color = event.target.value;
        document.getElementById('colorPreview{{ $color->id }}').style.backgroundColor = color;
        document.getElementById('colorCodeInput{{ $color->id }}').value = color;
    });

    document.getElementById('colorCodeInput{{ $color->id }}').addEventListener('input', function(event) {
        let color = event.target.value;
        if (/^#[0-9A-Fa-f]{6}$/.test(color)) {
            document.getElementById('colorPreview{{ $color->id }}').style.backgroundColor = color;
            document.getElementById('colorPicker{{ $color->id }}').value = color;
        }
    });
</script>
