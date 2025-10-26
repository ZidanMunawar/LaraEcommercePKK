<!-- Modal Edit Status -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStatusModalLabel">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editStatusTransactionId">
                <div class="mb-3">
                    <label for="editStatus" class="form-label">Order Status</label>
                    <select class="form-select" id="editStatus">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <div class="form-text">
                        <small><strong>Status Workflow:</strong></small><br>
                        <small>Pending → Processing → Shipped → Completed</small>
                    </div>
                </div>
                <div class="alert alert-info">
                    <ion-icon name="information-circle-outline"></ion-icon>
                    <strong>Note:</strong> Changing status to "Processing" will auto-approve this order.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitStatusUpdate" onclick="submitStatusUpdate()">
                    <ion-icon name="checkmark-outline"></ion-icon> Update Status
                </button>
            </div>
        </div>
    </div>
</div>
