@if (isset($banner))
    <!-- Modal Hapus Banner -->
    <div class="modal fade" id="deleteBannerModal{{ $banner->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <ion-icon name="warning-outline" class="align-middle"></ion-icon>
                        Konfirmasi Hapus Banner
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.master.banners.destroy', $banner->id) }}" method="POST">
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
                            Apakah Anda yakin ingin menghapus banner ini?
                        </p>

                        <!-- Preview Banner yang akan dihapus -->
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="text-center mb-2">
                                    <img src="{{ asset('storage/' . $banner->image) }}"
                                        alt="{{ $banner->promotion ?? 'Banner' }}" class="img-fluid rounded"
                                        style="max-height: 150px;">
                                </div>
                                @if ($banner->promotion)
                                    <p class="text-center mb-0 fw-bold">{{ $banner->promotion }}</p>
                                @else
                                    <p class="text-center mb-0 text-muted fst-italic">Tanpa Teks Promosi</p>
                                @endif
                            </div>
                        </div>

                        <!-- Info Tambahan -->
                        <div class="alert alert-danger mt-3 mb-0">
                            <small>
                                <ion-icon name="warning" class="align-middle"></ion-icon>
                                <strong>Peringatan:</strong> Banner dan gambarnya akan dihapus secara permanen dari
                                server.
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <ion-icon name="trash-outline"></ion-icon> Ya, Hapus Banner!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
