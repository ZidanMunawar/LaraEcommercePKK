@if (isset($product))
    <!-- Delete Product Modal -->
    <div class="modal fade" id="deleteModal{{ $product->id_produk }}" tabindex="-1"
        aria-labelledby="deleteModalLabel{{ $product->id_produk }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel{{ $product->id_produk }}">
                        <ion-icon name="warning" class="align-middle me-2"></ion-icon>
                        Delete Product
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.products.destroy', $product->id_produk) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <ion-icon name="alert-circle" style="font-size: 64px; color: #dc3545;"></ion-icon>
                        </div>
                        <p class="text-center">Are you sure you want to delete this product?</p>

                        <!-- Product Preview -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @if ($product->primaryImage)
                                        <div class="col-md-4 text-center mb-2">
                                            <img src="{{ asset('storage/' . $product->primaryImage->image_url) }}"
                                                alt="{{ $product->name }}" class="img-fluid rounded"
                                                style="max-height: 100px;">
                                        </div>
                                    @endif
                                    <div class="col-md-{{ $product->primaryImage ? '8' : '12' }}">
                                        <p class="mb-1"><strong>Name:</strong> {{ $product->name }}</p>
                                        <p class="mb-1"><strong>Price:</strong> Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="mb-1"><strong>Stock:</strong> {{ $product->quantity }} pcs</p>
                                        <p class="mb-0"><strong>Categories:</strong>
                                            @foreach ($product->categories->take(3) as $category)
                                                <span class="badge bg-primary">{{ $category->name }}</span>
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3 mb-0" role="alert">
                            <small>
                                <ion-icon name="warning" class="align-middle me-1"></ion-icon>
                                <strong>Warning:</strong> This action cannot be undone.
                                All product data and images will be permanently deleted.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
