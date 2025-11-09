<!-- Modal Tambah Audiens -->
<div class="modal fade" id="addAudienceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Header modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <ion-icon name="add-circle-outline" class="me-2"></ion-icon>
                    Tambah Audiens Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body modal -->
            <div class="modal-body">
                <form action="{{ route('admin.master.audiences.store') }}" method="POST" id="addAudienceForm">
                    @csrf

                    <!-- Input nama audiens -->
                    <div class="mb-3">
                        <label for="audienceName" class="form-label">
                            Nama Audiens <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="audienceName"
                            name="name" placeholder="Contoh: Pria, Wanita, Anak-anak" value="{{ old('name') }}"
                            required>

                        <!-- Error message -->
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <!-- Helper text -->
                        <div class="form-text">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            Masukkan target audiens produk (mis: Pria, Wanita, Unisex)
                        </div>
                    </div>

                    <!-- Tombol simpan -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <ion-icon name="save-outline" class="me-1"></ion-icon>
                            Simpan Audiens
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline" class="me-1"></ion-icon>
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
