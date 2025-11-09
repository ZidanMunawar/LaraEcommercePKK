<!-- Export Products Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <ion-icon name="download-outline"></ion-icon> Export Data Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="GET" action="{{ route('admin.products.export.pdf') }}" id="exportForm">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Filter Kategori -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="export_category" class="form-select">
                                    <option value="all">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Status -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status Produk</label>
                                <select name="export_status" class="form-select">
                                    <option value="all">Semua Status</option>
                                    <option value="available">Tersedia</option>
                                    <option value="unavailable">Tidak Tersedia</option>
                                    <option value="new">Baru</option>
                                    <option value="featured">Unggulan</option>
                                    <option value="best_seller">Terlaris</option>
                                    <option value="with_discount">Ada Diskon</option>
                                </select>
                            </div>

                            <!-- Filter Tanggal -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Rentang Tanggal</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="date" name="export_date_from" class="form-control"
                                            placeholder="Dari Tanggal">
                                    </div>
                                    <div class="col-6">
                                        <input type="date" name="export_date_to" class="form-control"
                                            placeholder="Sampai Tanggal">
                                    </div>
                                </div>
                                <small class="text-muted">Kosongkan untuk semua tanggal</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Pencarian -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pencarian</label>
                                <input type="text" name="export_search" class="form-control"
                                    placeholder="Cari nama atau deskripsi produk...">
                            </div>

                            <!-- Urutkan -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Urutkan Berdasarkan</label>
                                <select name="export_sort" class="form-select">
                                    <option value="latest">Terbaru</option>
                                    <option value="oldest">Terlama</option>
                                    <option value="name">Nama A-Z</option>
                                    <option value="price_low">Harga Terendah</option>
                                    <option value="price_high">Harga Tertinggi</option>
                                    <option value="quantity_low">Stok Terendah</option>
                                    <option value="quantity_high">Stok Tertinggi</option>
                                </select>
                            </div>

                            <!-- Preview Info -->
                            <div class="alert alert-info">
                                <div class="d-flex">
                                    <ion-icon name="information-circle-outline" class="flex-shrink-0 me-2"></ion-icon>
                                    <div>
                                        <strong>Format: PDF</strong><br>
                                        <small>Laporan lengkap dengan statistik dan detail produk</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Preview -->
                    <div class="border rounded p-3 bg-light mt-3">
                        <h6 class="fw-bold mb-3">Preview Filter:</h6>
                        <div class="row small text-muted">
                            <div class="col-md-3">
                                <strong>Kategori:</strong><br>
                                <span id="previewCategory">Semua</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Status:</strong><br>
                                <span id="previewStatus">Semua</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Urutan:</strong><br>
                                <span id="previewSort">Terbaru</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Tanggal:</strong><br>
                                <span id="previewDate">Semua</span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-3">
                        <ion-icon name="warning-outline" class="align-middle"></ion-icon>
                        <strong>Perhatian:</strong> Export mungkin memerlukan waktu beberapa detik untuk data yang
                        besar.
                    </div>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update preview real-time
            function updatePreview() {
                // Category preview
                const categorySelect = document.querySelector('select[name="export_category"]');
                const categoryText = categorySelect.options[categorySelect.selectedIndex].text;
                document.getElementById('previewCategory').textContent = categoryText;

                // Status preview
                const statusSelect = document.querySelector('select[name="export_status"]');
                const statusText = statusSelect.options[statusSelect.selectedIndex].text;
                document.getElementById('previewStatus').textContent = statusText;

                // Sort preview
                const sortSelect = document.querySelector('select[name="export_sort"]');
                const sortText = sortSelect.options[sortSelect.selectedIndex].text;
                document.getElementById('previewSort').textContent = sortText;

                // Date preview
                const dateFrom = document.querySelector('input[name="export_date_from"]').value;
                const dateTo = document.querySelector('input[name="export_date_to"]').value;
                let dateText = 'Semua';
                if (dateFrom && dateTo) {
                    dateText = `${formatDate(dateFrom)} - ${formatDate(dateTo)}`;
                } else if (dateFrom) {
                    dateText = `Dari ${formatDate(dateFrom)}`;
                } else if (dateTo) {
                    dateText = `Sampai ${formatDate(dateTo)}`;
                }
                document.getElementById('previewDate').textContent = dateText;
            }

            // Format date to DD/MM/YYYY
            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID');
            }

            // Add event listeners for real-time preview
            document.querySelectorAll('#exportForm select, #exportForm input').forEach(element => {
                element.addEventListener('change', updatePreview);
                element.addEventListener('input', updatePreview);
            });

            // Initialize preview on modal show
            const exportModal = document.getElementById('exportModal');
            if (exportModal) {
                exportModal.addEventListener('show.bs.modal', function() {
                    setTimeout(updatePreview, 100);
                });
            }

            // Set default date to today for date_to
            document.querySelector('input[name="export_date_to"]').value = new Date().toISOString().split('T')[0];

            // Initialize preview immediately
            updatePreview();
        });
    </script>
@endpush
