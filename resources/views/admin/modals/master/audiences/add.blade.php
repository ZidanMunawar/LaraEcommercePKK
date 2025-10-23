<!-- resources/views/admin/modal/audiences/add.blade.php -->

<div class="modal fade" id="addAudienceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Audience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.master.audiences.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="audienceName" class="form-label">Audience Name</label>
                        <input type="text" class="form-control" id="audienceName" name="name"
                            placeholder="Enter audience name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Audience</button>
                </form>
            </div>
        </div>
    </div>
</div>
