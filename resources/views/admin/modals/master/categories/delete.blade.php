@if (isset($category))
    <!-- Modal Hapus Kategori -->
    <div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <ion-icon name="warning-outline" class="align-middle"></ion-icon>
                        Konfirmasi Hapus Kategori
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
                        Apakah Anda yakin ingin menghapus kategori
                        <strong class="text-danger">{{ $category->name }}</strong>?
                    </p>

                    <!-- Info tambahan -->
                    @if ($category->image)
                        <p class="text-muted small mb-0">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            Gambar kategori juga akan dihapus dari server.
                        </p>
                    @endif
                </div>

                <div class="modal-footer">
                    <form action="{{ route('admin.master.categories.destroy', $category->id) }}" method="POST">
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
