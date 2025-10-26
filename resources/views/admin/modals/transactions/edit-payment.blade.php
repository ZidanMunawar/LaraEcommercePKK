<!-- Modal Edit Payment Status -->
<div class="modal fade" id="editPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Payment Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editPaymentTransactionId">

                <div class="mb-3">
                    <label for="editPaymentStatus" class="form-label">Payment Status</label>
                    <select class="form-select" id="editPaymentStatus">
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="failed">Failed</option>
                        <option value="refunded">Refunded</option>
                    </select>
                </div>

                <div class="alert alert-info">
                    <ion-icon name="information-circle-outline"></ion-icon>
                    <strong>Note:</strong> Use this only for manual payment verification. Midtrans payments are updated
                    automatically.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitPaymentUpdate">
                    <ion-icon name="checkmark-outline"></ion-icon> Update Payment
                </button>
            </div>
        </div>
    </div>
</div>
