<!-- Export Products Modal -->
<div class="modal fade" id="exportProductsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <ion-icon name="download-outline"></ion-icon> Export Data Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.products.export') }}" method="POST" id="exportProductsForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Statistics Cards -->
                        <div class="col-12 mb-4">
                            <div class="row g-3" id="exportStatistics">
                                <div class="col-md-4">
                                    <div class="card bg-primary bg-opacity-10 border-primary">
                                        <div class="card-body text-center p-3">
                                            <h4 class="text-primary mb-1" id="statTotal">0</h4>
                                            <small class="text-muted">Total Produk</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-success bg-opacity-10 border-success">
                                        <div class="card-body text-center p-3">
                                            <h4 class="text-success mb-1" id="statAvailable">0</h4>
                                            <small class="text-muted">Tersedia</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-warning bg-opacity-10 border-warning">
                                        <div class="card-body text-center p-3">
                                            <h4 class="text-warning mb-1" id="statOutOfStock">0</h4>
                                            <small class="text-muted">Habis</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Options -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Format Export</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="export_type" id="exportPDF"
                                        value="pdf" checked>
                                    <label class="form-check-label" for="exportPDF">
                                        <strong>PDF</strong> - Laporan lengkap dengan layout rapi
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="category" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Target Audience</label>
                                <select name="audience" class="form-select">
                                    <option value="">Semua Audience</option>
                                    @foreach ($audiences as $audience)
                                        <option value="{{ $audience->id }}">{{ $audience->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status Ketersediaan</label>
                                <select name="availability" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="available">Tersedia</option>
                                    <option value="out_of_stock">Habis</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Produk Unggulan</label>
                                <select name="featured" class="form-select">
                                    <option value="">Semua Produk</option>
                                    <option value="featured">Hanya Unggulan</option>
                                    <option value="not_featured">Bukan Unggulan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Rentang Tanggal</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="date" name="date_from" class="form-control"
                                            placeholder="Dari Tanggal">
                                    </div>
                                    <div class="col-6">
                                        <input type="date" name="date_to" class="form-control"
                                            placeholder="Sampai Tanggal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Info -->
                    <div class="alert alert-info mt-3">
                        <ion-icon name="information-circle-outline" class="align-middle"></ion-icon>
                        <strong>Info:</strong> Export akan mencakup semua data produk termasuk gambar, harga, stok,
                        kategori, dan informasi lengkap lainnya.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" id="submitExportBtn">
                        <ion-icon name="download-outline"></ion-icon> Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
