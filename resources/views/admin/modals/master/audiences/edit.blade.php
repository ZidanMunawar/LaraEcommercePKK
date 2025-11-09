<!-- Modal Edit Audiens -->
<div class="modal fade" id="editModal{{ $audience->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Header modal -->
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <ion-icon name="pencil-outline" class="me-2"></ion-icon>
                    Edit Audiens
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body modal -->
            <div class="modal-body">
                <!-- Info audiens yang diedit -->
                <div class="alert alert-info">
                    <ion-icon name="information-circle"></ion-icon>
                    Anda sedang mengedit: <strong>{{ $audience->name }}</strong>
                </div>

                <form action="{{ route('admin.master.audiences.update', $audience->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Input nama audiens -->
                    <div class="mb-3">
                        <label for="editAudienceName{{ $audience->id }}" class="form-label">
                            Nama Audiens <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="editAudienceName{{ $audience->id }}" name="name"
                            value="{{ old('name', $audience->name) }}" required>

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Info terakhir diubah -->
                    <div class="text-muted small mb-3">
                        <ion-icon name="time-outline"></ion-icon>
                        Terakhir diubah: {{ $audience->updated_at->format('d M Y, H:i') }}
                    </div>

                    <!-- Tombol simpan -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning">
                            <ion-icon name="checkmark-outline" class="me-1"></ion-icon>
                            Simpan Perubahan
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
