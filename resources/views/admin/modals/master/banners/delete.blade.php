@if ($banner)
    <!-- Delete Banner Modal -->
    <div class="modal fade" id="deleteBannerModal{{ $banner->id }}" tabindex="-1"
        aria-labelledby="deleteBannerModalLabel{{ $banner->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteBannerModalLabel{{ $banner->id }}">
                        <ion-icon name="warning" class="align-middle"></ion-icon> Konfirmasi Hapus Banner
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.master.banners.destroy', $banner->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <ion-icon name="alert-circle" style="font-size: 64px; color: #dc3545;"></ion-icon>
                        </div>
                        <p class="text-center">Apakah Anda yakin ingin menghapus banner ini?</p>

                        <!-- Banner Preview -->
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center mb-2">
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->promotion }}"
                                        class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                                @if ($banner->promotion)
                                    <p class="text-center mb-0"><strong>{{ $banner->promotion }}</strong></p>
                                @endif
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3 mb-0" role="alert">
                            <small>
                                <ion-icon name="warning" class="align-middle"></ion-icon>
                                <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan.
                                Banner dan gambarnya akan dihapus secara permanen.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <ion-icon name="trash"></ion-icon> Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
