<!-- resources/views/admin/modal/master/sizes/add.blade.php -->

<div class="modal fade" id="addSizeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Size</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.master.sizes.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="sizeName" class="form-label">Size</label>
                        <input type="text" class="form-control" id="sizeName" name="size"
                            placeholder="Enter size" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Size</button>
                </form>
            </div>
        </div>
    </div>
</div>
