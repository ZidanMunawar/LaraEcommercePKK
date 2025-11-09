<!-- Export Transactions Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <ion-icon name="download-outline"></ion-icon> Export Laporan Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="GET" action="{{ route('admin.transactions.export') }}" id="exportForm">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Format Export</label>
                        <div class="alert alert-info">
                            <ion-icon name="information-circle-outline" class="align-middle"></ion-icon>
                            <strong>PDF Report</strong> - Laporan lengkap data transaksi dengan statistik
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Filter Data</label>
                        <p class="text-muted small mb-2">Export akan menggunakan filter yang sedang aktif:</p>

                        <div class="border rounded p-3 bg-light">
                            @php
                                $currentFilters = [
                                    'Status Pesanan' => request('status') ?: 'Semua',
                                    'Status Pembayaran' => request('payment_status') ?: 'Semua',
                                    'Pencarian' => request('search') ?: 'Tidak ada',
                                ];
                            @endphp

                            @foreach ($currentFilters as $label => $value)
                                <div class="row mb-1">
                                    <div class="col-5"><small class="fw-bold">{{ $label }}:</small></div>
                                    <div class="col-7"><small>{{ $value }}</small></div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <ion-icon name="warning-outline" class="align-middle"></ion-icon>
                        <strong>Perhatian:</strong> Export mungkin memerlukan waktu beberapa detik untuk data yang
                        besar.
                    </div>

                    <!-- Hidden fields untuk mempertahankan filter -->
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="hidden" name="payment_status" value="{{ request('payment_status') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <ion-icon name="close-outline"></ion-icon> Batal
                </button>
                <button type="submit" form="exportForm" class="btn btn-success">
                    <ion-icon name="download-outline"></ion-icon> Download PDF
                </button>
            </div>
        </div>
    </div>
</div>
