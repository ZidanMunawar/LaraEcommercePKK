@if (isset($product))
    <!-- Modal Hapus Produk -->
    <div class="modal fade" id="deleteModal{{ $product->id_produk }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <ion-icon name="warning-outline" class="align-middle"></ion-icon>
                        Konfirmasi Hapus Produk
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.products.destroy', $product->id_produk) }}" method="POST">
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
                            Apakah Anda yakin ingin menghapus produk ini?
                        </p>

                        <!-- Preview Produk yang akan dihapus -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    @if ($product->primaryImage)
                                        <div class="col-4 text-center">
                                            <img src="{{ asset('storage/' . $product->primaryImage->image_url) }}"
                                                alt="{{ $product->name }}" class="img-fluid rounded shadow-sm"
                                                style="max-height: 120px; object-fit: cover;">
                                        </div>
                                    @endif
                                    <div class="col-{{ $product->primaryImage ? '8' : '12' }}">
                                        <h6 class="mb-2"><strong>{{ $product->name }}</strong></h6>
                                        <p class="mb-1">
                                            <strong>Harga:</strong>
                                            <span class="text-primary">Rp
                                                {{ number_format($product->price, 0, ',', '.') }}</span>
                                            @if ($product->old_price)
                                                <small class="text-muted text-decoration-line-through ms-1">
                                                    Rp {{ number_format($product->old_price, 0, ',', '.') }}
                                                </small>
                                            @endif
                                        </p>
                                        <p class="mb-1">
                                            <strong>Stok:</strong> {{ $product->quantity }} pcs
                                        </p>
                                        <p class="mb-0">
                                            <strong>Kategori:</strong>
                                            @foreach ($product->categories->take(3) as $category)
                                                <span class="badge bg-primary">{{ $category->name }}</span>
                                            @endforeach
                                            @if ($product->categories->count() > 3)
                                                <span
                                                    class="badge bg-light text-dark">+{{ $product->categories->count() - 3 }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Tambahan -->
                        <div class="alert alert-danger mt-3 mb-0">
                            <small>
                                <ion-icon name="warning" class="align-middle"></ion-icon>
                                <strong>Peringatan:</strong> Produk dan semua gambarnya akan dihapus secara permanen
                                dari server.
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <ion-icon name="trash-outline"></ion-icon> Ya, Hapus Produk!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
