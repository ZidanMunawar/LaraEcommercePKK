<!-- Modal Hapus Audiens -->
<div class="modal fade" id="deleteModal{{ $audience->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Header modal -->
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <ion-icon name="warning-outline" class="me-2"></ion-icon>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body modal -->
            <div class="modal-body">
                <!-- Peringatan -->
                <div class="alert alert-warning">
                    <ion-icon name="alert-circle"></ion-icon>
                    <strong>Perhatian!</strong> Tindakan ini tidak dapat dibatalkan.
                </div>

                <!-- Konfirmasi -->
                <p class="mb-0">
                    Apakah Anda yakin ingin menghapus audiens
                    <strong class="text-danger">{{ $audience->name }}</strong>?
                </p>

                <!-- Info tambahan -->
                <div class="text-muted small mt-2">
                    <ion-icon name="information-circle-outline"></ion-icon>
                    Data yang sudah dihapus tidak dapat dikembalikan.
                </div>
            </div>

            <!-- Footer modal -->
            <div class="modal-footer">
                <form action="{{ route('admin.master.audiences.destroy', $audience->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <!-- Tombol batal -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close-outline" class="me-1"></ion-icon>
                        Batal
                    </button>

                    <!-- Tombol hapus -->
                    <button type="submit" class="btn btn-danger">
                        <ion-icon name="trash-outline" class="me-1"></ion-icon>
                        Ya, Hapus!
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
