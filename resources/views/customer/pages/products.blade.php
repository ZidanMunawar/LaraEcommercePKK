@extends('customer.layouts.app')

@section('title', 'Belanja - ZynHope Apparel')

@section('content')
    <!-- Breadcrumb Area -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Belanja Produk</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><span>Belanja</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Area dengan Filter Sidebar -->
    <section class="bd-product__area section-space py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filter (Kiri) - Desktop -->
                <div class="col-lg-3 mb-4 d-none d-lg-block">
                    <div class="product-filter-sidebar">
                        <div class="filter-header d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Produk</h4>
                            <a href="{{ route('customer.products') }}" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </a>
                        </div>

                        <form method="GET" action="{{ route('customer.products') }}" id="filterForm">
                            <!-- Filter Kategori -->
                            <div class="filter-group mb-4">
                                <h5 class="filter-title mb-3">
                                    <i class="bi bi-grid me-2"></i>Kategori
                                </h5>
                                <div class="filter-options">
                                    @foreach ($categories as $category)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input filter-checkbox" type="radio" name="category"
                                                value="{{ $category->id }}" id="category{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'checked' : '' }}>
                                            <label class="form-check-label" for="category{{ $category->id }}">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr>

                            <!-- Filter Audience -->
                            <div class="filter-group mb-4">
                                <h5 class="filter-title mb-3">
                                    <i class="bi bi-people me-2"></i>Target Pembeli
                                </h5>
                                <div class="filter-options">
                                    @foreach ($audiences as $audience)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input filter-checkbox" type="radio" name="audience"
                                                value="{{ $audience->id }}" id="audience{{ $audience->id }}"
                                                {{ request('audience') == $audience->id ? 'checked' : '' }}>
                                            <label class="form-check-label" for="audience{{ $audience->id }}">
                                                {{ $audience->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr>

                            <!-- Filter Harga -->
                            <div class="filter-group mb-4">
                                <h5 class="filter-title mb-3"
                                    style="color: #8B6F47; font-weight: 700; font-size: 15px; border-bottom: 2px solid #D4A574; padding-bottom: 8px;">
                                    <i class="bi bi-currency-dollar me-2"></i>Rentang Harga
                                </h5>
                                <div class="price-filter">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="form-label"
                                                style="font-size: 11px; color: #8B6F47; font-weight: 600;">Min</label>
                                            <input type="number" class="form-control" name="min_price" placeholder="0"
                                                value="{{ request('min_price') }}"
                                                style="border: 2px solid #D4A574; border-radius: 8px; padding: 6px 10px; font-size: 13px; height: 32px;">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label"
                                                style="font-size: 11px; color: #8B6F47; font-weight: 600;">Max</label>
                                            <input type="number" class="form-control" name="max_price"
                                                placeholder="{{ number_format($maxPrice, 0, ',', '.') }}"
                                                value="{{ request('max_price') }}"
                                                style="border: 2px solid #D4A574; border-radius: 8px; padding: 6px 10px; font-size: 13px; height: 32px;">
                                        </div>
                                    </div>
                                    <div class="text-center mt-2">
                                        <small class="text-muted" style="font-size: 10px;">
                                            <i class="bi bi-info-circle me-1"></i>Dalam Rupiah (Rp)
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Filter Warna -->
                            @if (isset($colors) && $colors->count() > 0)
                                <div class="filter-group mb-4">
                                    <h5 class="filter-title mb-3">
                                        <i class="bi bi-palette me-2"></i>Warna
                                    </h5>
                                    <div class="filter-options color-filter">
                                        @foreach ($colors as $color)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="colors[]"
                                                    value="{{ $color->id }}" id="color{{ $color->id }}"
                                                    {{ in_array($color->id, request('colors', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label d-flex align-items-center"
                                                    for="color{{ $color->id }}">
                                                    <span class="color-box me-2"
                                                        style="background-color: {{ $color->code }};
                                                             width: 20px;
                                                             height: 20px;
                                                             display: inline-block;
                                                             border: 1px solid #ddd;
                                                             border-radius: 3px;">
                                                    </span>
                                                    {{ $color->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                            @endif

                            <!-- Filter Ukuran -->
                            @if (isset($sizes) && $sizes->count() > 0)
                                <div class="filter-group mb-4">
                                    <h5 class="filter-title mb-3">
                                        <i class="bi bi-rulers me-2"></i>Ukuran
                                    </h5>
                                    <div class="filter-options size-filter">
                                        @foreach ($sizes as $size)
                                            <div class="form-check form-check-inline mb-2">
                                                <input class="form-check-input" type="checkbox" name="sizes[]"
                                                    value="{{ $size->id }}" id="size{{ $size->id }}"
                                                    {{ in_array($size->id, request('sizes', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label badge bg-light text-dark border"
                                                    for="size{{ $size->id }}" style="cursor: pointer;">
                                                    {{ $size->size }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Hidden fields untuk mempertahankan search dan sort -->
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                            <input type="hidden" name="show" value="{{ request('show') }}">

                            <!-- Tombol Apply Filter -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check2-circle me-2"></i>Terapkan Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Product List Area (Kanan) -->
                <div class="col-lg-9">
                    <!-- Toolbar (Hasil, Sorting, View Mode) -->
                    <div class="row mb-4">
                        <div class="col-md-6 col-sm-8">
                            <div class="bd-product__result">
                                <h5 class="mb-0">
                                    <i class="bi bi-box-seam me-2"></i>
                                    <span id="productCount">{{ $products->total() }}</span> Produk Ditemukan
                                </h5>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-4">
                            <div
                                class="product__filter-wrapper d-flex flex-wrap gap-2 align-items-center justify-content-md-end">
                                <!-- Mobile Filter Button -->
                                <button class="btn btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas">
                                    <i class="bi bi-funnel me-1"></i> Filter
                                </button>

                                <!-- Form untuk Show dan Sort -->
                                <form method="GET" action="{{ route('customer.products') }}"
                                    class="d-flex gap-2 flex-wrap align-items-center">
                                    <!-- Pertahankan filter yang sudah dipilih -->
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                    <input type="hidden" name="audience" value="{{ request('audience') }}">
                                    @foreach (request('colors', []) as $colorId)
                                        <input type="hidden" name="colors[]" value="{{ $colorId }}">
                                    @endforeach
                                    @foreach (request('sizes', []) as $sizeId)
                                        <input type="hidden" name="sizes[]" value="{{ $sizeId }}">
                                    @endforeach
                                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">

                                    <!-- Select Show -->
                                    <select name="show" class="form-select form-select-sm d-none d-sm-inline-block"
                                        style="width: auto;" onchange="this.form.submit()">
                                        <option value="12" {{ request('show') == 12 ? 'selected' : '' }}>Tampilkan 12
                                        </option>
                                        <option value="24" {{ request('show') == 24 ? 'selected' : '' }}>Tampilkan 24
                                        </option>
                                        <option value="36" {{ request('show') == 36 ? 'selected' : '' }}>Tampilkan 36
                                        </option>
                                        <option value="48" {{ request('show') == 48 ? 'selected' : '' }}>Tampilkan 48
                                        </option>
                                    </select>

                                    <!-- Select Sort -->
                                    <select name="sort" class="form-select form-select-sm d-none d-sm-inline-block"
                                        style="width: auto;" onchange="this.form.submit()">
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru
                                        </option>
                                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                            Harga: Rendah ke Tinggi</option>
                                        <option value="price_high"
                                            {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah
                                        </option>
                                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama: A-Z
                                        </option>
                                    </select>
                                </form>

                                <!-- View Mode Toggle - Desktop Only -->
                                <div class="bd-product__filter-style btn-group d-none d-md-flex" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary active"
                                        id="gridViewBtn" onclick="switchView('grid')">
                                        <i class="bi bi-grid-3x3-gap"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="listViewBtn"
                                        onclick="switchView('list')">
                                        <i class="bi bi-list-ul"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Container -->
                    <div id="productContainer">
                        <!-- Grid View -->
                        <div id="gridView" class="row g-3">
                            @forelse($products as $product)
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                                    <!-- GRID CARD START -->
                                    <div class="product-item card h-100 border-0 shadow position-relative"
                                        style="border-radius: 15px; overflow: hidden;">
                                        {{-- Badge Container --}}
                                        <div class="position-absolute top-0 start-0 end-0 d-flex justify-content-between p-2"
                                            style="z-index: 10;">
                                            {{-- Badge Diskon/Baru --}}
                                            <div>
                                                @if ($product->old_price && $product->old_price > $product->price)
                                                    @php
                                                        $discount = round(
                                                            (($product->old_price - $product->price) /
                                                                $product->old_price) *
                                                                100,
                                                        );
                                                    @endphp
                                                    <span class="badge"
                                                        style="background: linear-gradient(135deg, #dc3545, #c82333); font-size: 10px; padding: 4px 8px; font-weight: 700; box-shadow: 0 3px 10px rgba(220, 53, 69, 0.4);">
                                                        <i class="bi bi-percent me-1"></i>{{ $discount }}% OFF
                                                    </span>
                                                @elseif($product->is_new)
                                                    <span class="badge"
                                                        style="background: linear-gradient(135deg, #28a745, #218838); font-size: 10px; padding: 4px 8px; font-weight: 700; box-shadow: 0 3px 10px rgba(40, 167, 69, 0.4);">
                                                        <i class="bi bi-star-fill me-1"></i>BARU
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Stock Badge --}}
                                            @if ($product->quantity <= 5 && $product->quantity > 0)
                                                <span class="badge bg-warning text-dark"
                                                    style="font-size: 8px; padding: 3px 6px;">
                                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $product->quantity }}
                                                    pcs
                                                </span>
                                            @elseif($product->quantity == 0)
                                                <span class="badge bg-secondary"
                                                    style="font-size: 8px; padding: 3px 6px;">
                                                    <i class="bi bi-x-circle me-1"></i>Habis
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Gambar Produk --}}
                                        <div class="position-relative"
                                            style="background: linear-gradient(135deg, #f5f1ed, #fff);">
                                            <a href="{{ route('customer.product.detail', $product->id_produk) }}">
                                                @if ($product->images->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $product->images->first()->image_url) }}"
                                                        class="card-img-top" alt="{{ $product->name }}"
                                                        style="height: 200px; object-fit: cover; transition: transform 0.4s;">
                                                @else
                                                    <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                        class="card-img-top" alt="{{ $product->name }}"
                                                        style="height: 200px; object-fit: cover; transition: transform 0.4s;">
                                                @endif
                                            </a>
                                        </div>

                                        {{-- Card Body --}}
                                        <div class="card-body"
                                            style="background: linear-gradient(to bottom, #fff, #f5f1ed); padding: 12px;">
                                            {{-- Kategori --}}
                                            @if ($product->categories->isNotEmpty())
                                                <div class="mb-2">
                                                    <span class="badge"
                                                        style="background: linear-gradient(135deg, #D4A574, #A0826D); font-size: 8px; padding: 3px 6px;">
                                                        <i
                                                            class="bi bi-tag-fill me-1"></i>{{ $product->categories->first()->name }}
                                                    </span>
                                                </div>
                                            @endif

                                            {{-- Nama Produk --}}
                                            <h6 class="card-title mb-2"
                                                style="min-height: 40px; line-height: 1.3; font-size: 12px;">
                                                <a href="{{ route('customer.product.detail', $product->id_produk) }}"
                                                    class="text-decoration-none fw-bold"
                                                    style="color: #5a4a3a; transition: color 0.3s;">
                                                    {{ Str::limit($product->name, 40) }}
                                                </a>
                                            </h6>

                                            {{-- Layout Row: Info Kiri + Harga & Icons Kanan --}}
                                            <div class="row g-1 align-items-center">
                                                {{-- INFO KIRI (Warna & Ukuran) --}}
                                                <div class="col-7">
                                                    @if ($product->colors->isNotEmpty())
                                                        <div class="mb-1">
                                                            <small
                                                                style="color: #8B6F47; font-weight: 600; font-size: 8px; display: block; margin-bottom: 2px;">
                                                                <i class="bi bi-palette me-1"></i>Warna:
                                                            </small>
                                                            <div class="d-flex gap-1 flex-wrap">
                                                                @foreach ($product->colors->take(2) as $color)
                                                                    <span class="d-inline-block"
                                                                        style="width: 14px; height: 14px; background-color: {{ $color->code }}; border: 1px solid #D4A574; border-radius: 50%; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
                                                                        title="{{ $color->name }}">
                                                                    </span>
                                                                @endforeach
                                                                @if ($product->colors->count() > 2)
                                                                    <small class="text-muted align-self-center"
                                                                        style="font-size: 8px;">+{{ $product->colors->count() - 2 }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if ($product->sizes->isNotEmpty())
                                                        <div>
                                                            <small
                                                                style="color: #8B6F47; font-weight: 600; font-size: 8px; display: block; margin-bottom: 2px;">
                                                                <i class="bi bi-rulers me-1"></i>Ukuran:
                                                            </small>
                                                            <div class="d-flex gap-1 flex-wrap">
                                                                @foreach ($product->sizes->take(2) as $size)
                                                                    <span class="badge"
                                                                        style="background: #fff; color: #8B6F47; border: 1px solid #D4A574; padding: 1px 3px; font-size: 8px;">{{ $size->size }}</span>
                                                                @endforeach
                                                                @if ($product->sizes->count() > 2)
                                                                    <span class="badge"
                                                                        style="background: #fff; color: #8B6F47; border: 1px solid #D4A574; padding: 1px 3px; font-size: 8px;">+{{ $product->sizes->count() - 2 }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- HARGA & ICONS KANAN --}}
                                                <div class="col-5 text-end">
                                                    {{-- Harga --}}
                                                    <div class="product-price mb-1">
                                                        @if ($product->old_price && $product->old_price > $product->price)
                                                            <div class="text-muted text-decoration-line-through"
                                                                style="font-size: 8px;">
                                                                Rp {{ number_format($product->old_price, 0, ',', '.') }}
                                                            </div>
                                                        @endif
                                                        <div class="fw-bold"
                                                            style="color: #A0826D; font-size: 0.9rem; line-height: 1.2;">
                                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                                        </div>
                                                    </div>

                                                    {{-- Action Icons --}}
                                                    <div class="d-flex gap-1 justify-content-end">
                                                        @auth('customer')
                                                            <button type="button"
                                                                class="btn btn-sm text-white add-to-cart-btn"
                                                                style="background: linear-gradient(135deg, #A0826D, #8B6F47); border: none; padding: 4px 6px; box-shadow: 0 2px 8px rgba(160, 130, 109, 0.3); border-radius: 6px; font-size: 10px;"
                                                                data-product-id="{{ $product->id_produk }}"
                                                                data-product-name="{{ $product->name }}"
                                                                title="Tambah ke Keranjang">
                                                                <i class="bi bi-cart-plus"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-sm {{ $product->isInWishlist() ? 'btn-danger' : 'btn-outline-danger' }} add-to-wishlist-btn"
                                                                style="padding: 4px 6px; border-radius: 6px; font-size: 10px;"
                                                                data-product-id="{{ $product->id_produk }}"
                                                                data-product-name="{{ $product->name }}"
                                                                data-in-wishlist="{{ $product->isInWishlist() ? 'true' : 'false' }}"
                                                                title="{{ $product->isInWishlist() ? 'Di Wishlist' : 'Wishlist' }}">
                                                                <i
                                                                    class="bi {{ $product->isInWishlist() ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                                            </button>
                                                            <a href="{{ route('customer.product.detail', $product->id_produk) }}"
                                                                class="btn btn-sm"
                                                                style="background: #fff; color: #A0826D; border: 1px solid #D4A574; padding: 4px 6px; border-radius: 6px; font-size: 10px;"
                                                                title="Detail">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('customer.login') }}"
                                                                class="btn btn-sm text-white"
                                                                style="background: linear-gradient(135deg, #A0826D, #8B6F47); border: none; padding: 4px 6px; box-shadow: 0 2px 8px rgba(160, 130, 109, 0.3); border-radius: 6px; font-size: 10px;"
                                                                title="Login">
                                                                <i class="bi bi-cart-plus"></i>
                                                            </a>
                                                            <a href="{{ route('customer.login') }}"
                                                                class="btn btn-sm btn-outline-danger"
                                                                style="padding: 4px 6px; border-radius: 6px; font-size: 10px;"
                                                                title="Login">
                                                                <i class="bi bi-heart"></i>
                                                            </a>
                                                            <a href="{{ route('customer.product.detail', $product->id_produk) }}"
                                                                class="btn btn-sm"
                                                                style="background: #fff; color: #A0826D; border: 1px solid #D4A574; padding: 4px 6px; border-radius: 6px; font-size: 10px;"
                                                                title="Detail">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        @endauth
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- GRID CARD END -->
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="text-center py-5"
                                        style="background: linear-gradient(135deg, #f5f1ed, #fff); border-radius: 15px; padding: 60px 20px;">
                                        <i class="bi bi-inbox" style="font-size: 80px; color: #D4A574;"></i>
                                        <h4 class="mt-4 mb-2" style="color: #8B6F47; font-weight: 700;">Tidak Ada Produk
                                        </h4>
                                        <p class="text-muted mb-4">Coba sesuaikan filter atau kata kunci pencarian Anda</p>
                                        <a href="{{ route('customer.products') }}" class="btn text-white"
                                            style="background: linear-gradient(135deg, #A0826D, #8B6F47); border: none; padding: 12px 30px; font-weight: 600; box-shadow: 0 4px 15px rgba(160, 130, 109, 0.3);">
                                            <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- List View (Hidden by default) -->
                        <div id="listView" class="d-none">
                            @forelse($products as $product)
                                <!-- LIST CARD START -->
                                <div class="product-item-list card mb-4 border-0 shadow position-relative"
                                    style="border-radius: 15px; overflow: hidden;">
                                    <div class="row g-0">
                                        {{-- Gambar Produk --}}
                                        <div class="col-md-3 position-relative"
                                            style="background: linear-gradient(135deg, #f5f1ed, #fff);">
                                            {{-- Badges --}}
                                            <div class="position-absolute top-0 start-0 p-2" style="z-index: 10;">
                                                @if ($product->old_price && $product->old_price > $product->price)
                                                    @php
                                                        $discount = round(
                                                            (($product->old_price - $product->price) /
                                                                $product->old_price) *
                                                                100,
                                                        );
                                                    @endphp
                                                    <span class="badge mb-1"
                                                        style="background: linear-gradient(135deg, #dc3545, #c82333); font-size: 12px; padding: 6px 10px; display: block; width: fit-content;">
                                                        {{ $discount }}% OFF
                                                    </span>
                                                @elseif($product->is_new)
                                                    <span class="badge mb-1"
                                                        style="background: linear-gradient(135deg, #28a745, #218838); font-size: 12px; padding: 6px 10px; display: block; width: fit-content;">
                                                        BARU
                                                    </span>
                                                @endif

                                                @if ($product->quantity <= 5 && $product->quantity > 0)
                                                    <span class="badge bg-warning text-dark"
                                                        style="font-size: 10px; padding: 4px 8px; display: block; width: fit-content;">
                                                        Stok: {{ $product->quantity }}
                                                    </span>
                                                @endif
                                            </div>

                                            <a href="{{ route('customer.product.detail', $product->id_produk) }}">
                                                @if ($product->images->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $product->images->first()->image_url) }}"
                                                        class="img-fluid rounded-start h-100" alt="{{ $product->name }}"
                                                        style="object-fit: cover; min-height: 250px; max-height: 250px; width: 100%;">
                                                @else
                                                    <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                        class="img-fluid rounded-start h-100" alt="{{ $product->name }}"
                                                        style="object-fit: cover; min-height: 250px; max-height: 250px; width: 100%;">
                                                @endif
                                            </a>
                                        </div>

                                        {{-- Detail Produk --}}
                                        <div class="col-md-6"
                                            style="background: linear-gradient(to right, #fff, #f5f1ed);">
                                            <div class="card-body py-4">
                                                {{-- Kategori --}}
                                                @if ($product->categories->isNotEmpty())
                                                    <div class="mb-3">
                                                        <span class="badge"
                                                            style="background: linear-gradient(135deg, #D4A574, #A0826D); font-size: 12px; padding: 6px 12px;">
                                                            <i
                                                                class="bi bi-tag-fill me-1"></i>{{ $product->categories->first()->name }}
                                                        </span>
                                                    </div>
                                                @endif

                                                {{-- Nama Produk --}}
                                                <h5 class="card-title mb-3 fw-bold"
                                                    style="color: #5a4a3a; line-height: 1.4;">
                                                    <a href="{{ route('customer.product.detail', $product->id_produk) }}"
                                                        class="text-decoration-none" style="color: #5a4a3a;">
                                                        {{ $product->name }}
                                                    </a>
                                                </h5>

                                                {{-- Deskripsi --}}
                                                <p class="card-text text-muted mb-3"
                                                    style="font-size: 14px; line-height: 1.6;">
                                                    {{ Str::limit(strip_tags($product->description), 120) }}
                                                </p>

                                                {{-- Warna & Ukuran --}}
                                                <div class="d-flex gap-4 mb-0 flex-wrap">
                                                    @if ($product->colors->isNotEmpty())
                                                        <div>
                                                            <small
                                                                style="color: #8B6F47; font-weight: 600; display: block; margin-bottom: 6px;">
                                                                <i class="bi bi-palette me-1"></i>Warna:
                                                            </small>
                                                            <div class="d-flex gap-1">
                                                                @foreach ($product->colors->take(5) as $color)
                                                                    <span class="d-inline-block"
                                                                        style="width: 26px; height: 26px; background-color: {{ $color->code }}; border: 2px solid #D4A574; border-radius: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.1);"
                                                                        title="{{ $color->name }}">
                                                                    </span>
                                                                @endforeach
                                                                @if ($product->colors->count() > 5)
                                                                    <small
                                                                        class="text-muted align-self-center ms-1">+{{ $product->colors->count() - 5 }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if ($product->sizes->isNotEmpty())
                                                        <div>
                                                            <small
                                                                style="color: #8B6F47; font-weight: 600; display: block; margin-bottom: 6px;">
                                                                <i class="bi bi-rulers me-1"></i>Ukuran:
                                                            </small>
                                                            <div class="d-flex gap-1">
                                                                @foreach ($product->sizes->take(4) as $size)
                                                                    <span class="badge"
                                                                        style="background: #fff; color: #8B6F47; border: 2px solid #D4A574; padding: 4px 8px;">{{ $size->size }}</span>
                                                                @endforeach
                                                                @if ($product->sizes->count() > 4)
                                                                    <span class="badge"
                                                                        style="background: #fff; color: #8B6F47; border: 2px solid #D4A574; padding: 4px 8px;">+{{ $product->sizes->count() - 4 }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Harga & Actions --}}
                                        <div class="col-md-3"
                                            style="background: linear-gradient(135deg, #f5f1ed, #fff); border-left: 2px solid #D4A574;">
                                            <div
                                                class="card-body d-flex flex-column justify-content-between h-100 py-4 px-3">
                                                {{-- Harga --}}
                                                <div class="text-center mb-3">
                                                    @if ($product->old_price && $product->old_price > $product->price)
                                                        <div class="text-muted text-decoration-line-through mb-1"
                                                            style="font-size: 13px;">
                                                            Rp {{ number_format($product->old_price, 0, ',', '.') }}
                                                        </div>
                                                    @endif
                                                    <div class="fw-bold" style="color: #A0826D; font-size: 1.6rem;">
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </div>
                                                </div>

                                                {{-- Action Buttons --}}
                                                <div class="d-grid gap-2">
                                                    @auth('customer')
                                                        <button type="button" class="btn btn-sm text-white add-to-cart-btn"
                                                            style="background: linear-gradient(135deg, #A0826D, #8B6F47); border: none; padding: 10px; font-weight: 600; box-shadow: 0 3px 10px rgba(160, 130, 109, 0.3);"
                                                            data-product-id="{{ $product->id_produk }}"
                                                            data-product-name="{{ $product->name }}">
                                                            <i class="bi bi-cart-plus me-2"></i>Tambah
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-sm {{ $product->isInWishlist() ? 'btn-danger' : 'btn-outline-danger' }} add-to-wishlist-btn"
                                                            style="padding: 10px; font-weight: 600;"
                                                            data-product-id="{{ $product->id_produk }}"
                                                            data-product-name="{{ $product->name }}"
                                                            data-in-wishlist="{{ $product->isInWishlist() ? 'true' : 'false' }}">
                                                            <i
                                                                class="bi {{ $product->isInWishlist() ? 'bi-heart-fill' : 'bi-heart' }} me-2"></i>
                                                            <span class="d-inline-block" style="min-width: 70px;">
                                                                {{ $product->isInWishlist() ? 'Di Wishlist' : 'Wishlist' }}
                                                            </span>
                                                        </button>
                                                    @else
                                                        <a href="{{ route('customer.login') }}"
                                                            class="btn btn-sm text-white"
                                                            style="background: linear-gradient(135deg, #A0826D, #8B6F47); border: none; padding: 10px; font-weight: 600;">
                                                            <i class="bi bi-cart-plus me-2"></i>Tambah
                                                        </a>
                                                        <a href="{{ route('customer.login') }}"
                                                            class="btn btn-sm btn-outline-danger"
                                                            style="padding: 10px; font-weight: 600;">
                                                            <i class="bi bi-heart me-2"></i>Wishlist
                                                        </a>
                                                    @endauth
                                                    <a href="{{ route('customer.product.detail', $product->id_produk) }}"
                                                        class="btn btn-sm"
                                                        style="background: #fff; color: #A0826D; border: 2px solid #D4A574; padding: 10px; font-weight: 600;">
                                                        <i class="bi bi-eye me-2"></i>Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- LIST CARD END -->
                            @empty
                                <div class="text-center py-5"
                                    style="background: linear-gradient(135deg, #f5f1ed, #fff); border-radius: 15px; padding: 60px 20px;">
                                    <i class="bi bi-inbox" style="font-size: 80px; color: #D4A574;"></i>
                                    <h4 class="mt-4 mb-2" style="color: #8B6F47; font-weight: 700;">Tidak Ada Produk</h4>
                                    <p class="text-muted mb-4">Coba sesuaikan filter atau kata kunci pencarian Anda</p>
                                    <a href="{{ route('customer.products') }}" class="btn text-white"
                                        style="background: linear-gradient(135deg, #A0826D, #8B6F47); border: none; padding: 12px 30px; font-weight: 600; box-shadow: 0 4px 15px rgba(160, 130, 109, 0.3);">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
                                    </a>
                                </div>
                            @endforelse
                        </div>

                    </div>

                    <!-- Pagination -->
                    @if ($products->hasPages())
                        <div class="row mt-5">
                            <div class="col-12">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        {{-- Previous Page Link --}}
                                        @if ($products->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $products->previousPageUrl() }}">
                                                    <i class="bi bi-chevron-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                            @if ($page == $products->currentPage())
                                                <li class="page-item active"><span
                                                        class="page-link">{{ $page }}</span></li>
                                            @else
                                                <li class="page-item"><a class="page-link"
                                                        href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($products->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $products->nextPageUrl() }}">
                                                    <i class="bi bi-chevron-right"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Offcanvas Filter untuk Mobile -->
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="filterOffcanvas"
        aria-labelledby="filterOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="filterOffcanvasLabel">
                <i class="bi bi-funnel me-2"></i>Filter Produk
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="product-filter-sidebar">
                <form method="GET" action="{{ route('customer.products') }}" id="filterFormMobile">
                    <!-- Filter Kategori -->
                    <div class="filter-group mb-4">
                        <h5 class="filter-title mb-3">
                            <i class="bi bi-grid me-2"></i>Kategori
                        </h5>
                        <div class="filter-options">
                            @foreach ($categories as $category)
                                <div class="form-check mb-2">
                                    <input class="form-check-input filter-checkbox" type="radio" name="category"
                                        value="{{ $category->id }}" id="mobileCategory{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mobileCategory{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <hr>

                    <!-- Filter Audience -->
                    <div class="filter-group mb-4">
                        <h5 class="filter-title mb-3">
                            <i class="bi bi-people me-2"></i>Target Pembeli
                        </h5>
                        <div class="filter-options">
                            @foreach ($audiences as $audience)
                                <div class="form-check mb-2">
                                    <input class="form-check-input filter-checkbox" type="radio" name="audience"
                                        value="{{ $audience->id }}" id="mobileAudience{{ $audience->id }}"
                                        {{ request('audience') == $audience->id ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mobileAudience{{ $audience->id }}">
                                        {{ $audience->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <hr>

                    <!-- Filter Harga -->
                    <div class="filter-group mb-4">
                        <h5 class="filter-title mb-3"
                            style="color: #8B6F47; font-weight: 700; font-size: 15px; border-bottom: 2px solid #D4A574; padding-bottom: 8px;">
                            <i class="bi bi-currency-dollar me-2"></i>Rentang Harga
                        </h5>
                        <div class="price-filter">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label"
                                        style="font-size: 11px; color: #8B6F47; font-weight: 600;">Min</label>
                                    <input type="number" class="form-control" name="min_price" placeholder="0"
                                        value="{{ request('min_price') }}"
                                        style="border: 2px solid #D4A574; border-radius: 8px; padding: 6px 10px; font-size: 13px; height: 32px;">
                                </div>
                                <div class="col-6">
                                    <label class="form-label"
                                        style="font-size: 11px; color: #8B6F47; font-weight: 600;">Max</label>
                                    <input type="number" class="form-control" name="max_price"
                                        placeholder="{{ number_format($maxPrice, 0, ',', '.') }}"
                                        value="{{ request('max_price') }}"
                                        style="border: 2px solid #D4A574; border-radius: 8px; padding: 6px 10px; font-size: 13px; height: 32px;">
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <small class="text-muted" style="font-size: 10px;">
                                    <i class="bi bi-info-circle me-1"></i>Dalam Rupiah (Rp)
                                </small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Filter Warna -->
                    @if (isset($colors) && $colors->count() > 0)
                        <div class="filter-group mb-4">
                            <h5 class="filter-title mb-3">
                                <i class="bi bi-palette me-2"></i>Warna
                            </h5>
                            <div class="filter-options color-filter">
                                @foreach ($colors as $color)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="colors[]"
                                            value="{{ $color->id }}" id="mobileColor{{ $color->id }}"
                                            {{ in_array($color->id, request('colors', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label d-flex align-items-center"
                                            for="mobileColor{{ $color->id }}">
                                            <span class="color-box me-2"
                                                style="background-color: {{ $color->code }};
                                                     width: 20px;
                                                     height: 20px;
                                                     display: inline-block;
                                                     border: 1px solid #ddd;
                                                     border-radius: 3px;">
                                            </span>
                                            {{ $color->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                    @endif

                    <!-- Filter Ukuran -->
                    @if (isset($sizes) && $sizes->count() > 0)
                        <div class="filter-group mb-4">
                            <h5 class="filter-title mb-3">
                                <i class="bi bi-rulers me-2"></i>Ukuran
                            </h5>
                            <div class="filter-options size-filter">
                                @foreach ($sizes as $size)
                                    <div class="form-check form-check-inline mb-2">
                                        <input class="form-check-input" type="checkbox" name="sizes[]"
                                            value="{{ $size->id }}" id="mobileSize{{ $size->id }}"
                                            {{ in_array($size->id, request('sizes', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label badge bg-light text-dark border"
                                            for="mobileSize{{ $size->id }}" style="cursor: pointer;">
                                            {{ $size->size }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Hidden fields untuk mempertahankan search dan sort -->
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <input type="hidden" name="show" value="{{ request('show') }}">

                    <!-- Tombol Apply Filter -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle me-2"></i>Terapkan Filter
                        </button>
                        <a href="{{ route('customer.products') }}" class="btn btn-outline-danger">
                            <i class="bi bi-arrow-clockwise me-2"></i> Reset Filter
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Notification untuk Feedback -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="toastNotification" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header" id="toastHeader">
                <i class="bi bi-check-circle-fill text-success me-2" id="toastIcon"></i>
                <strong class="me-auto" id="toastTitle">Notifikasi</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                Pesan notifikasi
            </div>
        </div>
    </div>


@endsection

@push('styles')
    <style>
        :root {
            --primary-brown: #A0826D;
            --dark-brown: #8B6F47;
            --light-brown: #D4A574;
            --cream: #F5F1ED;
            --hover-brown: #7A5C3D;
        }

        .product-filter-sidebar {
            background: linear-gradient(135deg, var(--cream), #fff);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(160, 130, 109, 0.15);
            border: 2px solid var(--light-brown);
        }

        .offcanvas .product-filter-sidebar {
            border: none;
            box-shadow: none;
            padding: 0;
        }

        .filter-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark-brown);
            border-bottom: 3px solid var(--light-brown);
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .filter-options {
            max-height: 250px;
            overflow-y: auto;
        }

        .form-check-label {
            cursor: pointer;
            font-size: 14px;
            color: #5a4a3a;
            transition: all 0.3s;
            font-weight: 500;
        }

        .form-check-label:hover {
            color: var(--primary-brown);
            transform: translateX(5px);
        }

        .form-check-input:checked {
            background-color: var(--primary-brown);
            border-color: var(--dark-brown);
            box-shadow: 0 0 10px rgba(160, 130, 109, 0.5);
        }

        .form-check-input:focus {
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 0.25rem rgba(160, 130, 109, 0.25);
        }

        .product-item {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 15px;
            overflow: hidden;
            border: 2px solid transparent;
            background: #fff;
        }

        .product-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(160, 130, 109, 0.25) !important;
            border: 2px solid var(--light-brown);
        }

        .product-item-list {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
            border: 2px solid var(--cream);
        }

        .product-item-list:hover {
            box-shadow: 0 10px 30px rgba(160, 130, 109, 0.2) !important;
            border: 2px solid var(--light-brown);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-brown), var(--dark-brown));
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(160, 130, 109, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--dark-brown), var(--hover-brown));
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(160, 130, 109, 0.5);
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .col-6 {
                padding-left: 5px;
                padding-right: 5px;
            }

            .product-item .card-body {
                padding: 8px !important;
            }

            .product-item .card-title {
                font-size: 11px !important;
                min-height: 32px !important;
            }

            .product-price div {
                font-size: 0.8rem !important;
            }

            .btn-sm {
                padding: 3px 5px !important;
                font-size: 9px !important;
            }
        }

        @media (max-width: 768px) {
            .bd-product__result h5 {
                font-size: 16px;
            }

            .product__filter-wrapper {
                justify-content: flex-end !important;
            }

            .form-select-sm {
                font-size: 12px;
            }

            /* Force grid view on mobile */
            #listView {
                display: none !important;
            }

            #gridView {
                display: flex !important;
            }
        }

        @keyframes flyToCart {
            0% {
                opacity: 1;
                transform: scale(1) translate(0, 0);
            }

            50% {
                opacity: 0.8;
                transform: scale(0.6) translate(200px, -200px);
            }

            100% {
                opacity: 0;
                transform: scale(0.2) translate(400px, -400px);
            }
        }

        .fly-to-cart {
            animation: flyToCart 0.8s cubic-bezier(0.5, 0, 0.5, 1);
            pointer-events: none;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-10px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(10px);
            }
        }

        .shake-animation {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes badgePulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(160, 130, 109, 0.7);
            }

            50% {
                transform: scale(1.2);
                box-shadow: 0 0 0 10px rgba(160, 130, 109, 0);
            }
        }

        .badge-pulse {
            animation: badgePulse 0.6s ease-in-out;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(245, 241, 237, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9998;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 6px solid var(--cream);
            border-top: 6px solid var(--primary-brown);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            box-shadow: 0 0 20px rgba(160, 130, 109, 0.3);
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .toast {
            min-width: 300px;
            border: 2px solid var(--light-brown);
            box-shadow: 0 4px 20px rgba(160, 130, 109, 0.2);
        }

        .toast-header {
            background: linear-gradient(135deg, var(--cream), #fff);
            border-bottom: 2px solid var(--light-brown);
            color: var(--dark-brown);
            font-weight: 600;
        }

        .badge {
            background: linear-gradient(135deg, var(--primary-brown), var(--dark-brown));
            color: #fff;
            font-weight: 600;
        }

        /* Mobile optimizations */
        @media (max-width: 991px) {
            .product-filter-sidebar {
                position: relative;
                top: 0;
                max-height: none;
            }

            .d-lg-none .product-filter-sidebar {
                padding: 0;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Simpan CSRF token untuk digunakan di AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        /**
         * ========================================
         * FUNGSI UTAMA - Switch View (Grid/List)
         * ========================================
         */
        function switchView(viewType) {
            // Auto disable list view di mobile
            if (window.innerWidth <= 768) {
                viewType = 'grid';
            }

            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');
            const gridBtn = document.getElementById('gridViewBtn');
            const listBtn = document.getElementById('listViewBtn');

            if (viewType === 'grid') {
                gridView.classList.remove('d-none');
                listView.classList.add('d-none');
                gridBtn.classList.add('active');
                listBtn.classList.remove('active');
                localStorage.setItem('productViewMode', 'grid');
            } else {
                gridView.classList.add('d-none');
                listView.classList.remove('d-none');
                listBtn.classList.add('active');
                gridBtn.classList.remove('active');
                localStorage.setItem('productViewMode', 'list');
            }
        }

        /**
         * ========================================
         * FUNGSI - Show Toast Notification
         * ========================================
         */
        function showToast(title, message, type = 'success') {
            const toastEl = document.getElementById('toastNotification');
            const toastHeader = document.getElementById('toastHeader');
            const toastIcon = document.getElementById('toastIcon');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');

            // Set warna header dan icon berdasarkan type
            const typeConfig = {
                success: {
                    icon: 'bi-check-circle-fill text-success',
                    header: 'bg-success bg-opacity-10'
                },
                error: {
                    icon: 'bi-x-circle-fill text-danger',
                    header: 'bg-danger bg-opacity-10'
                },
                warning: {
                    icon: 'bi-exclamation-triangle-fill text-warning',
                    header: 'bg-warning bg-opacity-10'
                },
                info: {
                    icon: 'bi-info-circle-fill text-info',
                    header: 'bg-info bg-opacity-10'
                }
            };

            const config = typeConfig[type] || typeConfig.success;

            toastIcon.className = `${config.icon} me-2`;
            toastHeader.className = `toast-header ${config.header}`;
            toastTitle.textContent = title;
            toastMessage.textContent = message;

            const toast = new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 3000
            });
            toast.show();
        }

        /**
         * ========================================
         * FUNGSI - Wishlist Handler
         * ========================================
         */
        async function handleWishlistToggle(button) {
            const productId = button.getAttribute('data-product-id');
            const productName = button.getAttribute('data-product-name');
            const isInWishlist = button.getAttribute('data-in-wishlist') === 'true';

            const originalHTML = button.innerHTML;
            const originalClass = button.className;
            const originalTitle = button.getAttribute('title');

            // Disable button sementara
            button.disabled = true;
            button.innerHTML = '<i class="bi bi-hourglass-split spinner-border spinner-border-sm"></i>';

            try {
                const response = await fetch(`/customer/wishlist/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    // Update UI berdasarkan action
                    const isNowInWishlist = data.action === 'added';

                    if (button.classList.contains('btn-outline-danger') || button.classList.contains('btn-danger')) {
                        // Button outline style (untuk grid view)
                        if (isNowInWishlist) {
                            button.innerHTML = '<i class="bi bi-heart-fill"></i>';
                            button.classList.remove('btn-outline-danger');
                            button.classList.add('btn-danger');
                            button.setAttribute('title', 'Di Wishlist');
                        } else {
                            button.innerHTML = '<i class="bi bi-heart"></i>';
                            button.classList.remove('btn-danger');
                            button.classList.add('btn-outline-danger');
                            button.setAttribute('title', 'Wishlist');
                        }
                    } else {
                        // Button regular style (untuk list view)
                        button.innerHTML = isNowInWishlist ?
                            '<i class="bi bi-heart-fill me-2"></i><span class="d-inline-block" style="min-width: 70px;">Di Wishlist</span>' :
                            '<i class="bi bi-heart me-2"></i><span class="d-inline-block" style="min-width: 70px;">Wishlist</span>';
                    }

                    // Update data attribute
                    button.setAttribute('data-in-wishlist', isNowInWishlist.toString());

                    // Update badge count
                    updateWishlistBadge(data.wishlist_count);

                    // Show toast
                    showToast('Berhasil!', data.message, 'success');

                } else {
                    throw new Error(data.message || 'Gagal memproses wishlist');
                }

            } catch (error) {
                console.error('Wishlist Error:', error);
                showToast('Error!', error.message || 'Terjadi kesalahan', 'error');
                button.innerHTML = originalHTML;
                button.className = originalClass;
                button.setAttribute('title', originalTitle);
            } finally {
                button.disabled = false;
            }
        }

        /**
         * ========================================
         * FUNGSI - Cart Handler
         * ========================================
         */
        async function handleAddToCart(button) {
            const productId = button.getAttribute('data-product-id');
            const productName = button.getAttribute('data-product-name');

            const originalHTML = button.innerHTML;

            // Disable button sementara
            button.disabled = true;
            button.innerHTML = '<i class="bi bi-hourglass-split spinner-border spinner-border-sm"></i>';

            try {
                const response = await fetch(`/customer/cart/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        quantity: 1
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    // Animasi fly to cart
                    flyToCart(button);

                    // Update badge count
                    updateCartBadge(data.cart_count || data.cartCount);

                    // Show success message
                    showToast('Berhasil!', data.message || `${productName} ditambahkan ke keranjang`, 'success');

                    // Reset button setelah animasi
                    setTimeout(() => {
                        button.disabled = false;
                        button.innerHTML = originalHTML;
                    }, 1000);

                } else {
                    throw new Error(data.message || 'Gagal menambahkan produk ke keranjang');
                }

            } catch (error) {
                console.error('Cart Error:', error);
                showToast('Error!', error.message || 'Terjadi kesalahan', 'error');
                button.disabled = false;
                button.innerHTML = originalHTML;
            }
        }

        /**
         * ========================================
         * FUNGSI - Animasi dan Update UI
         * ========================================
         */
        function flyToCart(element) {
            const clone = element.cloneNode(true);
            clone.style.position = 'fixed';
            clone.style.zIndex = '99999';
            clone.style.pointerEvents = 'none';

            const rect = element.getBoundingClientRect();
            clone.style.left = rect.left + 'px';
            clone.style.top = rect.top + 'px';
            clone.style.width = rect.width + 'px';
            clone.style.height = rect.height + 'px';

            document.body.appendChild(clone);

            const cartIcon = document.querySelector('.header-action-btn[title*="Keranjang"]') ||
                document.querySelector('[href*="cart"]');

            if (cartIcon) {
                const cartRect = cartIcon.getBoundingClientRect();

                setTimeout(() => {
                    clone.classList.add('fly-to-cart');
                }, 10);

                setTimeout(() => {
                    clone.remove();
                    cartIcon.classList.add('shake-animation');
                    setTimeout(() => cartIcon.classList.remove('shake-animation'), 500);
                }, 850);
            } else {
                setTimeout(() => clone.remove(), 850);
            }
        }

        function updateCartBadge(count) {
            const badge = document.getElementById('cart-badge-count');
            if (badge) {
                badge.textContent = count;
                badge.classList.add('badge-pulse');
                setTimeout(() => badge.classList.remove('badge-pulse'), 600);
            }
        }

        function updateWishlistBadge(count) {
            const badge = document.getElementById('wishlist-badge-count');
            if (badge) {
                badge.textContent = count;
                badge.classList.add('badge-pulse');
                setTimeout(() => badge.classList.remove('badge-pulse'), 600);
            }
        }

        /**
         * ========================================
         * EVENT LISTENERS - Document Ready
         * ========================================
         */
        document.addEventListener('DOMContentLoaded', function() {
            // Auto disable list view di mobile
            if (window.innerWidth <= 768) {
                localStorage.setItem('productViewMode', 'grid');
            }

            // Load view preference
            const savedView = localStorage.getItem('productViewMode') || 'grid';
            switchView(savedView);

            // Wishlist event listeners
            document.querySelectorAll('.add-to-wishlist-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    handleWishlistToggle(this);
                });
            });

            // Cart event listeners
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    handleAddToCart(this);
                });
            });

            // Auto-submit filter
            document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    setTimeout(() => {
                        document.getElementById('filterForm').submit();
                    }, 300);
                });
            });

            // Auto-submit filter mobile
            document.querySelectorAll('#filterFormMobile .filter-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    setTimeout(() => {
                        document.getElementById('filterFormMobile').submit();
                    }, 300);
                });
            });

            // Handle window resize untuk auto disable list view
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    switchView('grid');
                }
            });
        });
    </script>
@endpush
