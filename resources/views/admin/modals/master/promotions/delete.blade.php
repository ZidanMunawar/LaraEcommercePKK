@if (isset($promotion))
    <!-- Modal Hapus Promosi -->
    <div class="modal fade" id="deletePromotionModal{{ $promotion->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <ion-icon name="warning-outline" class="align-middle"></ion-icon>
                        Konfirmasi Hapus Promosi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.master.promotions.destroy', $promotion->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body">
                        <!-- Peringatan -->
                        <div class="alert alert-warning">
                            <ion-icon name="alert-circle"></ion-icon>
                            <strong>Perhatian!</strong> Tindakan ini tidak dapat dibatalkan.
                        </div>

                        <!-- Konfirmasi -->
                        <p class="text-center mb-3">
                            Apakah Anda yakin ingin menghapus promosi ini?
                        </p>

                        <!-- Preview Promosi yang akan dihapus -->
                        <div class="card">
                            <div class="card-body text-center p-3">
                                <span class="badge bg-gradient-cosmic" style="font-size: 18px; padding: 12px 24px;">
                                    <ion-icon name="megaphone"></ion-icon>
                                    {{ $promotion->name }}
                                </span>
                            </div>
                        </div>

                        <!-- Info Tambahan -->
                        <div class="alert alert-danger mt-3 mb-0">
                            <small>
                                <ion-icon name="warning" class="align-middle"></ion-icon>
                                <strong>Peringatan:</strong> Promosi yang dihapus tidak dapat dikembalikan.
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <ion-icon name="trash-outline"></ion-icon> Ya, Hapus Promosi!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom Style -->
    <style>
        .bg-gradient-cosmic {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
    </style>
@endif
