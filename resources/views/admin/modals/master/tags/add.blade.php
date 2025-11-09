<!-- Modal Tambah Tag -->
<div class="modal fade" id="addTagModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.master.tags.store') }}" method="POST">
                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <ion-icon name="add-circle-outline" class="align-middle"></ion-icon>
                        Tambah Tag Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Nama Tag -->
                    <div class="mb-3">
                        <label for="tagName" class="form-label">
                            Nama Tag <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="tagName" name="name"
                            placeholder="Contoh: Bestseller, New Arrival, Sale" required>
                        <div class="form-text">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            Tag digunakan untuk menandai produk (seperti Bestseller, Hot Item)
                        </div>
                    </div>

                    <!-- Contoh Tag Umum -->
                    <div class="mb-3">
                        <label class="form-label">Contoh Tag Populer:</label>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-info" style="cursor: pointer;"
                                onclick="document.getElementById('tagName').value='Bestseller'">
                                <ion-icon name="star"></ion-icon> Bestseller
                            </span>
                            <span class="badge bg-success" style="cursor: pointer;"
                                onclick="document.getElementById('tagName').value='New Arrival'">
                                <ion-icon name="sparkles"></ion-icon> New Arrival
                            </span>
                            <span class="badge bg-danger" style="cursor: pointer;"
                                onclick="document.getElementById('tagName').value='Sale'">
                                <ion-icon name="pricetag"></ion-icon> Sale
                            </span>
                            <span class="badge bg-warning" style="cursor: pointer;"
                                onclick="document.getElementById('tagName').value='Limited Edition'">
                                <ion-icon name="flash"></ion-icon> Limited Edition
                            </span>
                            <span class="badge bg-secondary" style="cursor: pointer;"
                                onclick="document.getElementById('tagName').value='Trending'">
                                <ion-icon name="trending-up"></ion-icon> Trending
                            </span>
                        </div>
                        <small class="text-muted">Klik untuk mengisi cepat</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close-outline"></ion-icon> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <ion-icon name="save-outline"></ion-icon> Simpan Tag
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
