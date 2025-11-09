@if (isset($size))
    <!-- Modal Edit Ukuran -->
    <div class="modal fade" id="editSizeModal{{ $size->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.master.sizes.update', $size->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <ion-icon name="pencil-outline" class="align-middle"></ion-icon>
                            Edit Ukuran
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Info ukuran yang diedit -->
                        <div class="alert alert-info">
                            <ion-icon name="information-circle"></ion-icon>
                            Anda sedang mengedit ukuran: <strong>{{ $size->size }}</strong>
                        </div>

                        <!-- Ukuran -->
                        <div class="mb-3">
                            <label for="editSizeName{{ $size->id }}" class="form-label">
                                Ukuran <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="editSizeName{{ $size->id }}"
                                name="size" value="{{ $size->size }}" required style="text-transform: uppercase;">
                        </div>

                        <!-- Info terakhir diubah -->
                        <div class="text-muted small">
                            <ion-icon name="time-outline"></ion-icon>
                            Terakhir diubah: {{ $size->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <ion-icon name="save-outline"></ion-icon> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
