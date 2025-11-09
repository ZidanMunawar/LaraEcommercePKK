@if (isset($size))
    <!-- Modal Hapus Ukuran -->
    <div class="modal fade" id="deleteSizeModal{{ $size->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <ion-icon name="warning-outline" class="align-middle"></ion-icon>
                        Konfirmasi Hapus Ukuran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Peringatan -->
                    <div class="alert alert-warning">
                        <ion-icon name="alert-circle"></ion-icon>
                        <strong>Perhatian!</strong> Tindakan ini tidak dapat dibatalkan.
                    </div>

                    <!-- Konfirmasi -->
                    <p class="mb-2">
                        Apakah Anda yakin ingin menghapus ukuran
                        <span class="badge bg-primary" style="font-size: 16px;">{{ $size->size }}</span>?
                    </p>

                    <!-- Info tambahan -->
                    <p class="text-muted small mb-0">
                        <ion-icon name="information-circle-outline"></ion-icon>
                        Ukuran yang dihapus tidak dapat dikembalikan.
                    </p>
                </div>

                <div class="modal-footer">
                    <form action="{{ route('admin.master.sizes.destroy', $size->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <ion-icon name="trash-outline"></ion-icon> Ya, Hapus!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
