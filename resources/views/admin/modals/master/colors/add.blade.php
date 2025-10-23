<!-- resources/views/admin/modal/master/colors/add.blade.php -->

<div class="modal fade" id="addColorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.master.colors.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="colorName" class="form-label">Color Name</label>
                        <input type="text" class="form-control" id="colorName" name="name"
                            placeholder="Enter color name" required>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <label for="colorCode" class="form-label me-2">Color Code</label>
                        <input type="color" class="form-control me-3" id="colorPicker" name="code" value="#FF0000"
                            required>
                        <input type="text" class="form-control w-50" id="colorCodeInput" name="code_text"
                            value="#FF0000" placeholder="#FF0000" required pattern="^#[0-9A-Fa-f]{6}$"
                            title="Valid hex color code, e.g. #FF0000">
                    </div>

                    <div class="mb-3">
                        <label for="colorPreview" class="form-label">Preview</label>
                        <div id="colorPreview" class="form-control" style="background-color: #FF0000; height: 40px;">
                            <!-- Color preview box -->
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Color</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Update the color preview when color picker or input changes
    document.getElementById('colorPicker').addEventListener('input', function(event) {
        let color = event.target.value;
        document.getElementById('colorPreview').style.backgroundColor = color;
        document.getElementById('colorCodeInput').value = color;
    });

    document.getElementById('colorCodeInput').addEventListener('input', function(event) {
        let color = event.target.value;
        if (/^#[0-9A-Fa-f]{6}$/.test(color)) {
            document.getElementById('colorPreview').style.backgroundColor = color;
            document.getElementById('colorPicker').value = color;
        }
    });
</script>
