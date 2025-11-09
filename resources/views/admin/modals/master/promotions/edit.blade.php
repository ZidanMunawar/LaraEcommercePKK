@if (isset($promotion))
    <!-- Modal Edit Promosi -->
    <div class="modal fade" id="editPromotionModal{{ $promotion->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.master.promotions.update', $promotion->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <ion-icon name="pencil-outline" class="align-middle"></ion-icon>
                            Edit Promosi
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Info promosi yang diedit -->
                        <div class="alert alert-info">
                            <ion-icon name="information-circle"></ion-icon>
                            Anda sedang mengedit promosi:
                            <span class="badge bg-gradient-cosmic ms-1">
                                <ion-icon name="megaphone"></ion-icon>
                                {{ $promotion->name }}
                            </span>
                        </div>

                        <!-- Nama Promosi -->
                        <div class="mb-3">
                            <label for="editPromotionName{{ $promotion->id }}" class="form-label">
                                Nama Promosi <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="editPromotionName{{ $promotion->id }}"
                                name="name" value="{{ $promotion->name }}" required>
                            <div class="form-text">
                                <ion-icon name="information-circle-outline"></ion-icon>
                                Maksimal 100 karakter
                            </div>
                        </div>

                        <!-- Info terakhir diubah -->
                        <div class="text-muted small">
                            <ion-icon name="time-outline"></ion-icon>
                            Terakhir diubah: {{ $promotion->updated_at->format('d M Y, H:i') }}
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

    <!-- Custom Style -->
    <style>
        .bg-gradient-cosmic {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
    </style>
@endif
