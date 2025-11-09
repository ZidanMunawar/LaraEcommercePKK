<!-- Modal Verifikasi Pembayaran -->
<div class="modal fade" id="verifyPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    <ion-icon name="card-outline" class="align-middle"></ion-icon>
                    Verifikasi Bukti Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Hidden Input ID -->
                <input type="hidden" id="verifyPaymentTransactionId" value="">

                <!-- Bukti Pembayaran -->
                <div class="text-center mb-4">
                    <h6 class="mb-3">Bukti Pembayaran:</h6>
                    <img id="paymentProofImage" src="" alt="Bukti Pembayaran"
                        class="img-fluid border rounded shadow-sm" style="max-height: 400px; cursor: pointer;"
                        onclick="window.open(this.src, '_blank')">
                    <p class="text-muted mt-2">
                        <small><ion-icon name="expand-outline"></ion-icon> Klik gambar untuk memperbesar</small>
                    </p>
                </div>

                <!-- Info Transaksi -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>No. Pesanan:</strong><br>
                                <span id="verifyOrderNumber">-</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Total Pembayaran:</strong><br>
                                <span id="verifyTotalAmount" class="text-success fs-5">-</span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <strong>Metode Pembayaran:</strong><br>
                                <span id="verifyPaymentMethod">-</span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <strong>Diupload:</strong><br>
                                <span id="verifyUploadedAt">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pilih Aksi -->
                <div class="mb-3">
                    <label class="form-label">Tindakan <span class="text-danger">*</span></label>
                    <select class="form-select" id="verifyAction" required>
                        <option value="">-- Pilih Tindakan --</option>
                        <option value="approve">✓ Setujui Pembayaran</option>
                        <option value="reject">✗ Tolak Pembayaran</option>
                    </select>
                </div>

                <!-- Alasan Penolakan (hidden default) -->
                <div class="mb-3" id="rejectReasonDiv" style="display: none;">
                    <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="rejectReason" rows="3" placeholder="Masukkan alasan penolakan..."></textarea>
                </div>

                <div class="alert alert-info">
                    <ion-icon name="information-circle-outline"></ion-icon>
                    <strong>Catatan:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        <li><strong>Setujui:</strong> Pembayaran akan ditandai lunas dan pesanan diproses</li>
                        <li><strong>Tolak:</strong> Pesanan dibatalkan dan stok dikembalikan</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <ion-icon name="close-outline"></ion-icon> Batal
                </button>
                <button type="button" class="btn btn-warning" id="submitPaymentVerification"
                    onclick="submitPaymentVerification()">
                    <ion-icon name="checkmark-outline"></ion-icon> Kirim Verifikasi
                </button>
            </div>
        </div>
    </div>
</div>
