@if (isset($promocode))
    <!-- Modal Hapus Kode Promo -->
    <div class="modal fade" id="deletePromoCodeModal{{ $promocode->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <ion-icon name="warning-outline" class="align-middle"></ion-icon>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.master.promocodes.destroy', $promocode->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body">
                        <!-- Peringatan Kompak -->
                        <div class="alert alert-warning border-0 mb-3">
                            <ion-icon name="alert-circle" class="align-middle me-1"></ion-icon>
                            <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                        </div>

                        <!-- Konfirmasi -->
                        <p class="text-center mb-3">
                            Apakah Anda yakin ingin menghapus kode promo:
                        </p>

                        <!-- Preview Kompak -->
                        <div class="card border-danger">
                            <div class="card-body p-3 text-center">
                                @if ($promocode->image)
                                    <img src="{{ asset('storage/' . $promocode->image) }}" alt="{{ $promocode->code }}"
                                        class="img-fluid rounded mb-2" style="max-height: 60px;">
                                @endif

                                <div class="mb-2">
                                    <span class="badge bg-primary"
                                        style="font-size: 15px; padding: 8px 12px; font-family: monospace;">
                                        <ion-icon name="ticket" class="align-middle"></ion-icon>
                                        {{ $promocode->code }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-center gap-3 mb-2">
                                    <small class="text-muted">
                                        <strong>Diskon:</strong>
                                        @if ($promocode->discount_type === 'percentage')
                                            {{ $promocode->discount }}%
                                        @else
                                            Rp {{ number_format($promocode->discount, 0, ',', '.') }}
                                        @endif
                                    </small>
                                    <small class="text-muted">
                                        @php
                                            $now = now();
                                            $isExpired = $promocode->expires_at < $now;
                                        @endphp
                                        <strong>Status:</strong>
                                        <span class="badge badge-sm bg-{{ $isExpired ? 'danger' : 'success' }}">
                                            {{ $isExpired ? 'Expired' : 'Aktif' }}
                                        </span>
                                    </small>
                                </div>

                                <small class="text-muted">
                                    <ion-icon name="calendar-outline" class="align-middle"></ion-icon>
                                    Kadaluarsa: {{ $promocode->expires_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>

                        <!-- Info Singkat -->
                        <div class="alert alert-danger border-0 mt-3 mb-0">
                            <small>
                                <ion-icon name="warning" class="align-middle me-1"></ion-icon>
                                Kode promo dan gambarnya akan dihapus permanen.
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline" class="align-middle"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <ion-icon name="trash-outline" class="align-middle"></ion-icon> Ya, Hapus!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
