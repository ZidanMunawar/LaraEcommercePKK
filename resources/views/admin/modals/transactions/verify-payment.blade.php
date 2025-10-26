<!-- Modal Verify Payment -->
<div class="modal fade" id="verifyPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <ion-icon name="card-outline"></ion-icon> Verify Payment Proof
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- PENTING: Hidden input untuk ID -->
                <input type="hidden" id="verifyPaymentTransactionId" value="">

                <!-- Payment Proof Image -->
                <div class="text-center mb-4">
                    <h6 class="mb-3">Payment Proof:</h6>
                    <img id="paymentProofImage" src="" alt="Payment Proof" class="img-fluid border rounded"
                        style="max-height: 400px; cursor: pointer;" onclick="window.open(this.src, '_blank')">
                    <p class="text-muted mt-2">
                        <small>Click image to view full size</small>
                    </p>
                </div>

                <!-- Transaction Info -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Order Number:</strong><br>
                                <span id="verifyOrderNumber">-</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Total Amount:</strong><br>
                                <span id="verifyTotalAmount" class="text-success fs-5">-</span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <strong>Payment Method:</strong><br>
                                <span id="verifyPaymentMethod">-</span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <strong>Uploaded At:</strong><br>
                                <span id="verifyUploadedAt">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Selection -->
                <div class="mb-3">
                    <label class="form-label">Action <span class="text-danger">*</span></label>
                    <select class="form-select" id="verifyAction" required>
                        <option value="">-- Select Action --</option>
                        <option value="approve">✓ Approve Payment</option>
                        <option value="reject">✗ Reject Payment</option>
                    </select>
                </div>

                <!-- Reject Reason (hidden by default) -->
                <div class="mb-3" id="rejectReasonDiv" style="display: none;">
                    <label class="form-label">Reject Reason <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="rejectReason" rows="3" placeholder="Enter reason for rejection..."></textarea>
                </div>

                <div class="alert alert-warning">
                    <ion-icon name="warning-outline"></ion-icon>
                    <strong>Important:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        <li><strong>Approve:</strong> Payment will be marked as paid and order status will change to
                            "Processing"</li>
                        <li><strong>Reject:</strong> Order will be cancelled and stock will be returned</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitPaymentVerification"
                    onclick="submitPaymentVerification()">
                    <ion-icon name="checkmark-outline"></ion-icon> Submit Verification
                </button>
            </div>
        </div>
    </div>
</div>
