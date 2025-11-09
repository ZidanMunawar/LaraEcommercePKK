@extends('customer.layouts.app')

@section('title', $product->name . ' - ZynHope Apparel')

@section('content')
    <!-- ========== BREADCRUMB ========== -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">{{ Str::limit($product->name, 50) }}</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><a href="{{ route('customer.products') }}">Produk</a></li>
                                    <li><span>Detail</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== PRODUCT DETAILS ========== -->
    <div class="product__details-area section-space">
        <div class="container">
            <div class="row g-4">
                <!-- ========== GAMBAR PRODUK ========== -->
                <div class="col-lg-6">
                    <div class="product__details-thumb-wrapper d-sm-flex align-items-start mr-50">
                        <!-- THUMBNAIL -->
                        <div class="product__details-thumb-tab mr-20">
                            <nav>
                                <div class="nav nav-tabs flex-nowrap flex-sm-column" id="nav-tab" role="tablist">
                                    @if ($product->images->isNotEmpty())
                                        @foreach ($product->images as $index => $image)
                                            <button class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                                id="img-{{ $index }}-tab" data-bs-toggle="tab"
                                                data-bs-target="#img-{{ $index }}" type="button" role="tab"
                                                aria-controls="img-{{ $index }}"
                                                aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                                <img src="{{ asset('storage/' . $image->image_url) }}"
                                                    alt="{{ $product->name }}">
                                            </button>
                                        @endforeach
                                    @else
                                        <button class="nav-link active" id="img-0-tab" data-bs-toggle="tab"
                                            data-bs-target="#img-0" type="button" role="tab" aria-controls="img-0"
                                            aria-selected="true">
                                            <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                alt="{{ $product->name }}">
                                        </button>
                                    @endif
                                </div>
                            </nav>
                        </div>

                        <!-- MAIN IMAGE -->
                        <div class="product__details-thumb-tab-content">
                            <div class="tab-content" id="productthumbcontent">
                                @if ($product->images->isNotEmpty())
                                    @foreach ($product->images as $index => $image)
                                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                            id="img-{{ $index }}" role="tabpanel"
                                            aria-labelledby="img-{{ $index }}-tab">
                                            <div class="product__details-thumb-big w-img main-image-container">
                                                <img src="{{ asset('storage/' . $image->image_url) }}"
                                                    alt="{{ $product->name }}" class="main-img">
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="tab-pane fade show active" id="img-0" role="tabpanel"
                                        aria-labelledby="img-0-tab">
                                        <div class="product__details-thumb-big w-img main-image-container">
                                            <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                alt="{{ $product->name }}" class="main-img">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========== INFO PRODUK ========== -->
                <div class="col-lg-6">
                    <div class="product-info">
                        <!-- Kategori -->
                        <div class="d-flex align-items-center gap-3 mb-3">
                            @if ($product->categories->isNotEmpty())
                                <span class="badge bg-primary" style="font-size: 13px; padding: 8px 12px;">
                                    <i class="bi bi-tag me-1"></i>{{ $product->categories->first()->name }}
                                </span>
                            @endif
                        </div>

                        <!-- Nama Produk -->
                        <h3 class="product-title mb-3" style="font-size: 28px; font-weight: 700; line-height: 1.3;">
                            {{ $product->name }}</h3>

                        <!-- Harga -->
                        <div class="product-price mb-4">
                            @if ($product->old_price && $product->old_price > $product->price)
                                <span class="text-muted text-decoration-line-through me-2" style="font-size: 18px;">
                                    Rp {{ number_format($product->old_price, 0, ',', '.') }}
                                </span>
                            @endif
                            <span class="text-primary fw-bold" style="font-size: 36px;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Varian: Warna -->
                        @if ($product->colors->isNotEmpty())
                            <div class="mb-4">
                                <label class="form-label fw-semibold" style="font-size: 14px; margin-bottom: 12px;">
                                    <i class="bi bi-palette me-2"></i>Pilih Warna
                                </label>
                                <div class="d-flex gap-3 flex-wrap">
                                    @foreach ($product->colors as $color)
                                        <label class="color-option">
                                            <input type="radio" name="color" value="{{ $color->id }}"
                                                {{ $loop->first ? 'checked' : '' }}>
                                            <span class="color-swatch"
                                                style="background-color: {{ $color->code }}; width: 45px; height: 45px; border-radius: 50%; border: 3px solid #D4A574; display: inline-block; cursor: pointer; transition: all 0.3s;"
                                                title="{{ $color->name }}"></span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Varian: Ukuran -->
                        @if ($product->sizes->isNotEmpty())
                            <div class="mb-4">
                                <label class="form-label fw-semibold" style="font-size: 14px; margin-bottom: 12px;">
                                    <i class="bi bi-rulers me-2"></i>Pilih Ukuran
                                </label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach ($product->sizes as $size)
                                        <label class="size-option">
                                            <input type="radio" name="size" value="{{ $size->id }}"
                                                {{ $loop->first ? 'checked' : '' }}>
                                            <span class="size-box"
                                                style="padding: 12px 20px; border: 2px solid #D4A574; border-radius: 8px; display: inline-block; cursor: pointer; font-weight: 700; transition: all 0.3s;">
                                                {{ $size->size }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Quantity -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="font-size: 14px; margin-bottom: 12px;">
                                <i class="bi bi-box me-2"></i>Jumlah
                            </label>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary qty-btn" id="decreaseQty"
                                    style="width: 44px; height: 44px; padding: 0; display: flex; align-items: center; justify-content: center; font-weight: 700; transition: all 0.3s;">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                <input type="text" id="quantity" value="1" readonly
                                    class="form-control text-center fw-bold"
                                    style="width: 70px; height: 44px; font-size: 16px;">
                                <button type="button" class="btn btn-outline-secondary qty-btn" id="increaseQty"
                                    style="width: 44px; height: 44px; padding: 0; display: flex; align-items: center; justify-content: center; font-weight: 700; transition: all 0.3s;">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 mb-4">
                            @auth('customer')
                                @if ($product->is_available && $product->quantity > 0)
                                    <!-- BUY NOW -->
                                    <button type="button" class="btn btn-lg action-btn" id="buyNowBtn"
                                        data-product="{{ $product->id_produk }}"
                                        style="background: linear-gradient(135deg, #A0826D, #8B6F47); color: white; font-weight: 700; border: none; transition: all 0.3s;">
                                        <i class="bi bi-lightning-charge-fill me-2"></i>Beli Sekarang
                                    </button>
                                    <!-- ADD TO CART -->
                                    <button type="button" class="btn btn-lg action-btn" id="addToCartBtn"
                                        data-product="{{ $product->id_produk }}"
                                        style="background: linear-gradient(135deg, #A0826D, #8B6F47); color: white; font-weight: 700; border: none; transition: all 0.3s; opacity: 0.85;">
                                        <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                                    </button>
                                    <!-- WISHLIST -->
                                    <button type="button" class="btn btn-lg action-btn" id="addToWishlistBtn"
                                        data-product="{{ $product->id_produk }}"
                                        style="color: #A0826D; border: 2px solid #A0826D; font-weight: 700; transition: all 0.3s;">
                                        <i class="bi bi-heart me-2"></i>Tambah ke Wishlist
                                    </button>
                                @else
                                    <button type="button" class="btn btn-lg" disabled
                                        style="background: #ccc; color: white; font-weight: 700; border: none;">
                                        <i class="bi bi-x-circle me-2"></i>Stok Habis
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('customer.login') }}" class="btn btn-lg action-btn"
                                    style="background: linear-gradient(135deg, #A0826D, #8B6F47); color: white; font-weight: 700; border: none; text-decoration: none;">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Membeli
                                </a>
                            @endauth
                        </div>

                        <!-- Meta Info -->
                        <div class="product-meta border-top pt-4" style="border-color: #e9ecef;">
                            <p class="mb-2" style="font-size: 14px;">
                                <strong>SKU:</strong>
                                <span
                                    class="text-muted">PRD-{{ str_pad($product->id_produk, 6, '0', STR_PAD_LEFT) }}</span>
                            </p>
                            @if ($product->categories->isNotEmpty())
                                <p class="mb-2" style="font-size: 14px;">
                                    <strong>Kategori:</strong>
                                    @foreach ($product->categories as $category)
                                        <span class="badge bg-light text-dark"
                                            style="margin-left: 4px; background: linear-gradient(135deg, #E8D4B8, #D4A574) !important; color: #8B6F47 !important;">{{ $category->name }}</span>
                                    @endforeach
                                </p>
                            @endif
                            @if ($product->tags->isNotEmpty())
                                <p class="mb-0" style="font-size: 14px;">
                                    <strong>Tag:</strong>
                                    @foreach ($product->tags as $tag)
                                        <span class="badge bg-secondary"
                                            style="margin-left: 4px; background: linear-gradient(135deg, #A0826D, #8B6F47) !important;">{{ $tag->name }}</span>
                                    @endforeach
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========== TABS SECTION ========== -->
            <div class="row mt-5">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="productTabs" role="tablist" style="border-bottom: 2px solid #D4A574;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button"
                                style="border: none; font-weight: 600; color: #A0826D;">
                                <i class="bi bi-file-text me-2"></i>Deskripsi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                                type="button" style="border: none; font-weight: 600; color: #A0826D;">
                                <i class="bi bi-info-circle me-2"></i>Informasi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="size-guide-tab" data-bs-toggle="tab"
                                data-bs-target="#size-guide" type="button"
                                style="border: none; font-weight: 600; color: #A0826D;">
                                <i class="bi bi-ruler me-2"></i>Panduan Ukuran
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content border border-top-0 p-4" id="productTabsContent"
                        style="border-color: #D4A574; background: #fff;">
                        <!-- Tab: Deskripsi -->
                        <div class="tab-pane fade show active" id="description">
                            <h5 class="mb-3" style="font-weight: 700; color: #2c2c2c;">Deskripsi Produk</h5>
                            <p style="line-height: 1.8; color: #666; font-size: 15px;">{{ $product->description }}</p>

                            <h6 class="mt-4 mb-2" style="font-weight: 700; color: #2c2c2c;">Status Stok:</h6>
                            @if ($product->is_available && $product->quantity > 0)
                                <p class="text-success fw-bold mb-0" style="font-size: 15px;">
                                    <i class="bi bi-check-circle me-2"></i>Tersedia ({{ $product->quantity }} item)
                                </p>
                            @else
                                <p class="text-danger fw-bold mb-0" style="font-size: 15px;">
                                    <i class="bi bi-x-circle me-2"></i>Tidak Tersedia
                                </p>
                            @endif
                        </div>

                        <!-- Tab: Informasi -->
                        <div class="tab-pane fade" id="info">
                            <h5 class="mb-3" style="font-weight: 700; color: #2c2c2c;">Informasi Produk</h5>
                            <table class="table table-hover" style="font-size: 15px;">
                                <tbody>
                                    @if ($product->colors->isNotEmpty())
                                        <tr>
                                            <td width="30%" style="font-weight: 700; color: #A0826D;">Warna Tersedia
                                            </td>
                                            <td>{{ $product->colors->pluck('name')->join(', ') }}</td>
                                        </tr>
                                    @endif
                                    @if ($product->sizes->isNotEmpty())
                                        <tr>
                                            <td style="font-weight: 700; color: #A0826D;">Ukuran Tersedia</td>
                                            <td>{{ $product->sizes->pluck('size')->join(', ') }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td style="font-weight: 700; color: #A0826D;">SKU</td>
                                        <td>PRD-{{ str_pad($product->id_produk, 6, '0', STR_PAD_LEFT) }}</td>
                                    </tr>
                                    @if ($product->categories->isNotEmpty())
                                        <tr>
                                            <td style="font-weight: 700; color: #A0826D;">Kategori</td>
                                            <td>{{ $product->categories->first()->name }}</td>
                                        </tr>
                                    @endif
                                    @if ($product->audiences->isNotEmpty())
                                        <tr>
                                            <td style="font-weight: 700; color: #A0826D;">Target Pasar</td>
                                            <td>{{ $product->audiences->pluck('name')->join(', ') }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td style="font-weight: 700; color: #A0826D;">Brand</td>
                                        <td>ZynHope Apparel</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Tab: Panduan Ukuran -->
                        <div class="tab-pane fade" id="size-guide">
                            <h5 class="mb-4" style="font-weight: 700; color: #2c2c2c;">Panduan Ukuran Baju</h5>
                            <div class="text-center">
                                <img src="{{ asset('assets/images/Hitam Minimalis Ukuran Kaos Diagram.jpg') }}"
                                    alt="Panduan Ukuran" class="img-fluid"
                                    style="max-width: 100%; height: auto; border: 2px solid #D4A574; border-radius: 8px;">
                            </div>
                            <p class="text-muted small mt-3 text-center" style="font-size: 13px;">
                                <i class="bi bi-info-circle me-1"></i>Ukuran dapat bervariasi ±1-2 cm dari standar
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========== RELATED PRODUCTS ========== -->
            @if ($relatedProducts->isNotEmpty())
                <div class="row mt-5">
                    <div class="col-12">
                        <h4 class="mb-4" style="font-weight: 700; color: #A0826D;">
                            <i class="bi bi-shop me-2"></i>Produk Terkait
                        </h4>
                    </div>
                    @foreach ($relatedProducts as $related)
                        <div class="col-6 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 border-0 shadow-sm"
                                style="transition: all 0.3s; border-radius: 12px; border: 1px solid #E8D4B8;">
                                @if ($related->old_price && $related->old_price > $related->price)
                                    @php
                                        $discount = round(
                                            (($related->old_price - $related->price) / $related->old_price) * 100,
                                        );
                                    @endphp
                                    <span class="badge position-absolute top-0 start-0 m-2"
                                        style="z-index: 10; font-size: 12px; background: linear-gradient(135deg, #A0826D, #8B6F47);">{{ $discount }}%
                                        OFF</span>
                                @endif
                                <div
                                    style="height: 200px; background: linear-gradient(135deg, #f5f1ed, #e8d4b8); display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                                    <a href="{{ route('customer.product.detail', $related->id_produk) }}"
                                        style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                        @if ($related->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $related->images->first()->image_url) }}"
                                                alt="{{ $related->name }}"
                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @else
                                            <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                alt="{{ $related->name }}"
                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @endif
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title" style="font-size: 14px; font-weight: 600; line-height: 1.3;">
                                        <a href="{{ route('customer.product.detail', $related->id_produk) }}"
                                            class="text-decoration-none text-dark">
                                            {{ Str::limit($related->name, 40) }}
                                        </a>
                                    </h6>
                                    <div class="price" style="margin-top: 10px;">
                                        @if ($related->old_price && $related->old_price > $related->price)
                                            <span class="text-muted text-decoration-line-through small"
                                                style="font-size: 13px;">
                                                Rp {{ number_format($related->old_price, 0, ',', '.') }}
                                            </span>
                                            <br>
                                        @endif
                                        <span class="text-primary fw-bold"
                                            style="font-size: 16px; color: #A0826D !important;">
                                            Rp {{ number_format($related->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .main-image-container {
            background: linear-gradient(135deg, #f5f1ed, #e8d4b8);
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #D4A574;
        }

        .main-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .product__details-thumb-tab .nav-link {
            border: 3px solid #D4A574 !important;
            border-radius: 8px;
            overflow: hidden;
            background: linear-gradient(135deg, #f5f1ed, #e8d4b8);
            transition: all 0.3s;
        }

        .product__details-thumb-tab .nav-link:hover {
            border-color: #8B6F47 !important;
            transform: scale(1.05);
        }

        .product__details-thumb-tab .nav-link.active {
            border-color: #8B6F47 !important;
            box-shadow: 0 0 0 2px white, 0 0 0 4px #8B6F47;
        }

        .text-primary {
            color: #A0826D !important;
        }

        .color-option input[type="radio"],
        .size-option input[type="radio"] {
            display: none;
        }

        .color-option input[type="radio"]:checked+.color-swatch {
            border-color: #8B6F47 !important;
            box-shadow: 0 0 0 2px white, 0 0 0 4px #8B6F47;
            transform: scale(1.2);
        }

        .size-box {
            border: 2px solid #D4A574 !important;
            color: #2c2c2c;
            transition: all 0.3s ease;
        }

        .size-option input[type="radio"]:checked+.size-box {
            background: linear-gradient(135deg, #A0826D, #8B6F47) !important;
            color: white !important;
            border-color: #8B6F47 !important;
            transform: scale(1.08);
        }

        .qty-btn {
            border: 2px solid #D4A574 !important;
            color: #A0826D !important;
            transition: all 0.3s ease;
        }

        .qty-btn:hover {
            background: linear-gradient(135deg, #A0826D, #8B6F47) !important;
            color: white !important;
            border-color: #8B6F47 !important;
            transform: scale(1.1);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(160, 130, 109, 0.3);
        }

        #addToWishlistBtn:hover {
            background: linear-gradient(135deg, #E8D4B8, #D4A574) !important;
            border-color: #A0826D !important;
            color: #8B6F47 !important;
        }

        @media (max-width: 768px) {
            .main-image-container {
                height: 350px;
            }

            .product-title {
                font-size: 22px !important;
            }

            .product-price {
                font-size: 28px !important;
            }

            .product__details-content {
                padding-right: 0 !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ========== QUANTITY ==========
            $('#decreaseQty').click(function() {
                let val = parseInt($('#quantity').val());
                if (val > 1) $('#quantity').val(val - 1);
            });

            $('#increaseQty').click(function() {
                let val = parseInt($('#quantity').val());
                $('#quantity').val(val + 1);
            });

            // ========== BUY NOW ==========
            $('#buyNowBtn').click(function() {
                const productId = $(this).data('product');
                const quantity = parseInt($('#quantity').val());
                const color = $('input[name="color"]:checked').val();
                const size = $('input[name="size"]:checked').val();

                $(this).prop('disabled', true);

                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: '{{ route('customer.buy.now') }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity,
                        color_id: color,
                        size_id: size
                    },
                    success: function(res) {
                        Swal.close();
                        window.location.href = '{{ route('customer.buy.now.checkout') }}';
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON?.message || 'Terjadi kesalahan',
                            'error');
                        $('#buyNowBtn').prop('disabled', false);
                    }
                });
            });

            // ========== ADD TO CART ==========
            $('#addToCartBtn').click(function() {
                const productId = $(this).data('product');
                const quantity = parseInt($('#quantity').val());
                const color = $('input[name="color"]:checked').val();
                const size = $('input[name="size"]:checked').val();

                $(this).prop('disabled', true);

                Swal.fire({
                    title: 'Menambahkan...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: '{{ route('customer.cart.add') }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity,
                        color_id: color,
                        size_id: size
                    },
                    success: function(res) {
                        $('#cart-badge-count').text(res.cart_count);
                        Swal.fire('Berhasil!', res.message, 'success');
                        $('#addToCartBtn').prop('disabled', false);
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON?.message || 'Terjadi kesalahan',
                            'error');
                        $('#addToCartBtn').prop('disabled', false);
                    }
                });
            });

            // ========== ADD TO WISHLIST ==========
            $('#addToWishlistBtn').click(function() {
                const productId = $(this).data('product');
                $(this).prop('disabled', true);

                $.ajax({
                    url: '{{ route('customer.wishlist.store') }}',
                    method: 'POST',
                    data: {
                        product_id: productId
                    },
                    success: function(res) {
                        $('#wishlist-badge-count').text(res.wishlist_count);
                        $('#addToWishlistBtn i').removeClass('bi-heart').addClass(
                            'bi-heart-fill');
                        Swal.fire('Ditambahkan!', res.message, 'success');
                        $('#addToWishlistBtn').prop('disabled', false);
                    },
                    error: function(xhr) {
                        let msg = xhr.status === 409 ? 'Sudah ada di wishlist!' :
                            'Terjadi kesalahan';
                        Swal.fire('Info', msg, xhr.status === 409 ? 'info' : 'error');
                        $('#addToWishlistBtn').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush
