<!-- Modal Add Resi Number -->
<div class="modal fade" id="addResiModal" tabindex="-1" aria-labelledby="addResiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addResiModalLabel">Add Tracking Number (Resi)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="addResiTransactionId">
                <div class="mb-3">
                    <label for="resiNumber" class="form-label">Resi Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="resiNumber" placeholder="Enter tracking number"
                        required>
                    <div class="form-text">Example: JNE123456789, SICEPAT987654321</div>
                </div>
                <div class="alert alert-warning">
                    <ion-icon name="warning-outline"></ion-icon>
                    <strong>Auto Update:</strong> Adding resi will automatically change status to "Shipped"
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="submitResiUpdate" onclick="submitResiUpdate()">
                    <ion-icon name="cube-outline"></ion-icon> Submit Resi
                </button>
            </div>
        </div>
    </div>
</div>
