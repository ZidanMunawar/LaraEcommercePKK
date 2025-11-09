{{-- Card produk untuk tampilan Grid --}}
<div class="product-item card h-100 border-0 shadow-sm">
    {{-- Badge Diskon atau NEW --}}
    @if ($product->old_price && $product->old_price > $product->price)
        @php
            $discount = round((($product->old_price - $product->price) / $product->old_price) * 100);
        @endphp
        <div class="position-absolute top-0 start-0 m-2 z-index-1">
            <span class="badge bg-danger">{{ $discount }}% OFF</span>
        </div>
    @elseif($product->is_new)
        <div class="position-absolute top-0 start-0 m-2 z-index-1">
            <span class="badge bg-success">BARU</span>
        </div>
    @endif

    {{-- Gambar Produk --}}
    <div class="product-thumb position-relative overflow-hidden">
        <a href="{{ route('customer.product.detail', $product->id_produk) }}">
            @if ($product->images->isNotEmpty())
                <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" class="card-img-top"
                    alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
            @else
                <img src="{{ asset('assets-customer/imgs/product/default.png') }}" class="card-img-top"
                    alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
            @endif
        </a>

        {{-- Action Buttons Overlay --}}
        <div class="product-action-overlay position-absolute bottom-0 start-0 w-100 p-3 d-flex gap-2 justify-content-center"
            style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); opacity: 0; transition: opacity 0.3s;">
            @auth('customer')
                {{-- Tombol Add to Cart --}}
                <button type="button" class="btn btn-sm btn-primary add-to-cart-btn"
                    data-product-id="{{ $product->id_produk }}" title="Tambah ke Keranjang">
                    <i class="bi bi-cart-plus"></i>
                </button>

                {{-- Tombol Add to Wishlist --}}
                <button type="button" class="btn btn-sm btn-danger add-to-wishlist-btn"
                    data-product-id="{{ $product->id_produk }}" title="Tambah ke Wishlist">
                    <i class="bi bi-heart"></i>
                </button>
            @else
                <a href="{{ route('customer.login') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-cart-plus"></i>
                </a>
                <a href="{{ route('customer.login') }}" class="btn btn-sm btn-danger">
                    <i class="bi bi-heart"></i>
                </a>
            @endauth

            {{-- Tombol View Detail --}}
            <a href="{{ route('customer.product.detail', $product->id_produk) }}" class="btn btn-sm btn-info"
                title="Lihat Detail">
                <i class="bi bi-eye"></i>
            </a>
        </div>
    </div>

    {{-- Konten Produk --}}
    <div class="card-body">
        {{-- Kategori --}}
        @if ($product->categories->isNotEmpty())
            <div class="product-category mb-2">
                <small class="text-muted">
                    <i class="bi bi-tag me-1"></i>{{ $product->categories->first()->name }}
                </small>
            </div>
        @endif

        {{-- Nama Produk --}}
        <h5 class="card-title">
            <a href="{{ route('customer.product.detail', $product->id_produk) }}"
                class="text-decoration-none text-dark">
                {{ Str::limit($product->name, 40) }}
            </a>
        </h5>

        {{-- Harga --}}
        <div class="product-price">
            @if ($product->old_price && $product->old_price > $product->price)
                <span class="text-muted text-decoration-line-through me-2">
                    Rp {{ number_format($product->old_price, 0, ',', '.') }}
                </span>
            @endif
            <span class="fw-bold text-primary fs-5">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </span>
        </div>
    </div>
</div>

<style>
    .product-item:hover .product-action-overlay {
        opacity: 1 !important;
    }
</style>
