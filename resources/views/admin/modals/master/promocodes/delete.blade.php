@if (isset($promocode))
    <!-- Delete Promo Code Modal -->
    <div class="modal fade" id="deletePromoCodeModal{{ $promocode->id }}" tabindex="-1"
        aria-labelledby="deletePromoCodeModalLabel{{ $promocode->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deletePromoCodeModalLabel{{ $promocode->id }}">
                        <ion-icon name="warning" class="align-middle"></ion-icon> Delete Promo Code
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.master.promocodes.destroy', $promocode->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <ion-icon name="alert-circle" style="font-size: 64px; color: #dc3545;"></ion-icon>
                        </div>
                        <p class="text-center">Are you sure you want to delete this promo code?</p>

                        <!-- Promo Code Preview -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @if ($promocode->image)
                                        <div class="col-md-4 text-center mb-2">
                                            <img src="{{ asset('storage/' . $promocode->image) }}"
                                                alt="{{ $promocode->code }}" class="img-fluid rounded"
                                                style="max-height: 80px;">
                                        </div>
                                    @endif
                                    <div class="col-md-{{ $promocode->image ? '8' : '12' }}">
                                        <p class="mb-1"><strong>Code:</strong> {{ $promocode->code }}</p>
                                        <p class="mb-1"><strong>Discount:</strong>
                                            {{ number_format($promocode->discount, 2) }}</p>
                                        <p class="mb-0"><strong>Expires:</strong>
                                            {{ $promocode->expires_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3 mb-0" role="alert">
                            <small>
                                <ion-icon name="warning" class="align-middle"></ion-icon>
                                <strong>Warning:</strong> This action cannot be undone.
                                The promo code will be permanently deleted.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
