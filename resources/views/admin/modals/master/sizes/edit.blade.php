<!-- resources/views/admin/modal/master/sizes/edit.blade.php -->

<div class="modal fade" id="editSizeModal{{ $size->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Size - {{ $size->size }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.master.sizes.update', $size->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editSizeName" class="form-label">Size</label>
                        <input type="text" class="form-control" id="editSizeName" name="size"
                            value="{{ $size->size }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
