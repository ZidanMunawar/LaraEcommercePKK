@extends('customer.layouts.app')

@section('title', 'Keranjang Belanja - ZynHope Apparel')

@section('content')
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">
                            <i class="bi bi-cart3 me-2"></i>Keranjang Belanja
                        </h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><span>Keranjang</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-area section-space cart-brown-theme">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-dismissible fade show cart-alert-success">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>Berhasil!</strong> {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($cartItems->isNotEmpty())
                        <!-- Alert untuk item yang belum lengkap -->
                        <div class="alert alert-warning d-none" id="incompleteItemsAlert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>
                                    <strong>Perhatian!</strong> Beberapa produk belum memiliki size dan warna yang lengkap.
                                    <span id="incompleteCount"></span>
                                </div>
                            </div>
                        </div>

                        <div class="cart-table-wrapper d-none d-lg-block">
                            <div class="table-responsive">
                                <table class="table cart-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 12%;">Gambar</th>
                                            <th style="width: 23%;">Produk</th>
                                            <th style="width: 20%;">Varian</th>
                                            <th style="width: 12%;">Harga</th>
                                            <th style="width: 15%;">Jumlah</th>
                                            <th style="width: 10%;">Total</th>
                                            <th style="width: 8%;" class="text-center">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cart-items">
                                        @foreach ($cartItems as $item)
                                            <tr data-item-id="{{ $item->id_cart_item }}"
                                                class="cart-row
                                                {{ !$item->id_size || !$item->id_color ? 'cart-row-incomplete' : '' }}">
                                                <td class="product-thumbnail">
                                                    <a href="{{ route('customer.product.detail', $item->produk->id_produk) }}"
                                                        class="cart-img-link">
                                                        @if ($item->produk->images->isNotEmpty())
                                                            <img src="{{ asset('storage/' . $item->produk->images->first()->image_url) }}"
                                                                alt="{{ $item->produk->name }}" class="cart-img">
                                                        @else
                                                            <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                                alt="{{ $item->produk->name }}" class="cart-img">
                                                        @endif
                                                    </a>
                                                </td>

                                                <td class="product-name">
                                                    <a href="{{ route('customer.product.detail', $item->produk->id_produk) }}"
                                                        class="cart-product-title">
                                                        {{ $item->produk->name }}
                                                    </a>
                                                    @if (!$item->id_size || !$item->id_color)
                                                        <br>
                                                        <small class="text-danger">
                                                            <i class="bi bi-exclamation-circle me-1"></i>
                                                            Pilih size dan warna!
                                                        </small>
                                                    @endif
                                                </td>

                                                <td class="product-variant">
                                                    <div class="variant-selectors">
                                                        <!-- Size Selector -->
                                                        <div class="mb-2">
                                                            <label class="form-label cart-variant-label">Size:</label>
                                                            <select class="form-select form-select-sm size-selector"
                                                                data-item-id="{{ $item->id_cart_item }}"
                                                                {{ $item->produk->sizes->isEmpty() ? 'disabled' : '' }}>
                                                                <option value="">Pilih Size</option>
                                                                @foreach ($item->produk->sizes as $size)
                                                                    <option value="{{ $size->id }}"
                                                                        {{ $item->id_size == $size->id ? 'selected' : '' }}>
                                                                        {{ $size->size }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Color Selector -->
                                                        <div class="mb-2">
                                                            <label class="form-label cart-variant-label">Warna:</label>
                                                            <select class="form-select form-select-sm color-selector"
                                                                data-item-id="{{ $item->id_cart_item }}"
                                                                {{ $item->produk->colors->isEmpty() ? 'disabled' : '' }}>
                                                                <option value="">Pilih Warna</option>
                                                                @foreach ($item->produk->colors as $color)
                                                                    <option value="{{ $color->id }}"
                                                                        {{ $item->id_color == $color->id ? 'selected' : '' }}
                                                                        data-color-code="{{ $color->code }}">
                                                                        {{ $color->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Color Preview -->
                                                        @if ($item->color)
                                                            <div class="color-preview mt-1">
                                                                <span class="color-box"
                                                                    style="background-color: {{ $item->color->code }}"></span>
                                                                <small>{{ $item->color->name }}</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td class="product-price">
                                                    <span class="cart-price">Rp
                                                        {{ number_format($item->harga, 0, ',', '.') }}</span>
                                                </td>

                                                <td class="product-quantity">
                                                    <div class="cart-qty-main"
                                                        style="display: flex; align-items: center; gap:12px;">
                                                        <button type="button" class="cart-qty-btn cart-minus"
                                                            data-item-id="{{ $item->id_cart_item }}">
                                                            <i class="bi bi-dash"></i>
                                                        </button>
                                                        <div class="cart-qty-num">
                                                            <input type="text" class="cart-qty-input"
                                                                value="{{ $item->qty }}"
                                                                data-item-id="{{ $item->id_cart_item }}">
                                                        </div>
                                                        <button type="button" class="cart-qty-btn cart-plus"
                                                            data-item-id="{{ $item->id_cart_item }}">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <!-- TAMBAHIN BUTTON UPDATE -->
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary mt-1 update-qty-btn"
                                                        data-item-id="{{ $item->id_cart_item }}" style="display: none;">
                                                        <i class="bi bi-check"></i> Update
                                                    </button>
                                                </td>

                                                <td class="product-subtotal">
                                                    <span class="cart-subtotal item-total-{{ $item->id_cart_item }}">
                                                        Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}
                                                    </span>
                                                </td>

                                                <td class="product-remove text-center">
                                                    <button type="button" class="cart-btn-remove remove-cart-item"
                                                        data-item-id="{{ $item->id_cart_item }}"
                                                        data-product-name="{{ $item->produk->name }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="cart-cards-wrapper d-lg-none">
                            @foreach ($cartItems as $item)
                                <div class="cart-card {{ !$item->id_size || !$item->id_color ? 'cart-card-incomplete' : '' }}"
                                    data-item-id="{{ $item->id_cart_item }}">
                                    <div class="cart-card-header">
                                        <a href="{{ route('customer.product.detail', $item->produk->id_produk) }}">
                                            @if ($item->produk->images->isNotEmpty())
                                                <img src="{{ asset('storage/' . $item->produk->images->first()->image_url) }}"
                                                    alt="{{ $item->produk->name }}" class="cart-card-img">
                                            @else
                                                <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                    alt="{{ $item->produk->name }}" class="cart-card-img">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="cart-card-body">
                                        <h6 class="cart-card-title">
                                            <a href="{{ route('customer.product.detail', $item->produk->id_produk) }}">
                                                {{ Str::limit($item->produk->name, 50) }}
                                            </a>
                                        </h6>

                                        @if (!$item->id_size || !$item->id_color)
                                            <div class="alert alert-warning py-1 mb-2">
                                                <small>
                                                    <i class="bi bi-exclamation-circle me-1"></i>
                                                    Pilih size dan warna!
                                                </small>
                                            </div>
                                        @endif

                                        <!-- Variant Selectors Mobile -->
                                        <div class="variant-selectors-mobile">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <label class="cart-card-label">Size:</label>
                                                    <select class="form-select form-select-sm size-selector"
                                                        data-item-id="{{ $item->id_cart_item }}"
                                                        {{ $item->produk->sizes->isEmpty() ? 'disabled' : '' }}>
                                                        <option value="">Pilih Size</option>
                                                        @foreach ($item->produk->sizes as $size)
                                                            <option value="{{ $size->id }}"
                                                                {{ $item->id_size == $size->id ? 'selected' : '' }}>
                                                                {{ $size->size }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <label class="cart-card-label">Warna:</label>
                                                    <select class="form-select form-select-sm color-selector"
                                                        data-item-id="{{ $item->id_cart_item }}"
                                                        {{ $item->produk->colors->isEmpty() ? 'disabled' : '' }}>
                                                        <option value="">Pilih Warna</option>
                                                        @foreach ($item->produk->colors as $color)
                                                            <option value="{{ $color->id }}"
                                                                {{ $item->id_color == $color->id ? 'selected' : '' }}
                                                                data-color-code="{{ $color->code }}">
                                                                {{ $color->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Color Preview Mobile -->
                                            @if ($item->color)
                                                <div class="color-preview-mobile mt-2">
                                                    <span class="color-box"
                                                        style="background-color: {{ $item->color->code }}"></span>
                                                    <small>{{ $item->color->name }}</small>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="cart-card-price mt-2">
                                            <span class="cart-price">Rp
                                                {{ number_format($item->harga, 0, ',', '.') }}</span>
                                        </div>

                                        <div class="cart-card-qty mt-3">
                                            <label class="cart-card-label">Jumlah:</label>
                                            <div class="cart-qty-wrapper">
                                                <button type="button" class="cart-qty-btn cart-minus"
                                                    data-item-id="{{ $item->id_cart_item }}">−</button>
                                                <input type="text" class="cart-qty-input" value="{{ $item->qty }}"
                                                    readonly data-item-id="{{ $item->id_cart_item }}">
                                                <button type="button" class="cart-qty-btn cart-plus"
                                                    data-item-id="{{ $item->id_cart_item }}">+</button>
                                                <!-- Button Update untuk Mobile -->
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary mt-1 update-qty-btn w-100"
                                                    data-item-id="{{ $item->id_cart_item }}" style="display: none;">
                                                    <i class="bi bi-check"></i> Update Quantity
                                                </button>
                                            </div>
                                        </div>

                                        <div class="cart-card-total mt-3">
                                            <span class="cart-card-label">Total:</span>
                                            <span class="cart-subtotal item-total-{{ $item->id_cart_item }}">
                                                Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <button type="button" class="cart-btn-remove-mobile remove-cart-item mt-3"
                                            data-item-id="{{ $item->id_cart_item }}"
                                            data-product-name="{{ $item->produk->name }}">
                                            <i class="bi bi-trash me-1"></i>Hapus dari Keranjang
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mt-5">
                            <div class="col-lg-6 ms-auto">
                                <div class="cart-summary">
                                    <h4 class="cart-summary-title">Ringkasan Belanja</h4>
                                    <ul class="cart-summary-list">
                                        <li>
                                            <span>Subtotal</span>
                                            <span id="cart-subtotal" class="cart-summary-value">Rp
                                                {{ number_format($subtotal, 0, ',', '.') }}</span>
                                        </li>
                                        <li class="cart-summary-total">
                                            <span>Total</span>
                                            <span id="cart-total" class="cart-summary-value-total">Rp
                                                {{ number_format($subtotal, 0, ',', '.') }}</span>
                                        </li>
                                    </ul>

                                    <!-- Checkout Button dengan Validasi -->
                                    <button type="button" class="cart-btn-checkout" id="checkoutBtn">
                                        <i class="bi bi-credit-card me-2"></i>Lanjut ke Checkout
                                    </button>

                                    <a href="{{ route('customer.products') }}" class="cart-btn-continue">
                                        <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="cart-empty-state">
                            <div class="cart-empty-icon">
                                <i class="bi bi-cart-x"></i>
                            </div>
                            <h4 class="cart-empty-title">Keranjang Anda Kosong</h4>
                            <p class="cart-empty-text">Tambahkan produk ke keranjang dan produk akan muncul di sini.</p>
                            <a href="{{ route('customer.products') }}" class="cart-btn-shop">
                                <i class="bi bi-shop me-2"></i>Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Validasi Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">
                        <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                        Validasi Keranjang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="checkoutModalBody">
                    <!-- Pesan validasi akan dimuat di sini -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="{{ route('customer.checkout') }}" class="btn btn-primary" id="proceedCheckoutBtn">
                        <i class="bi bi-check-circle me-2"></i>Lanjutkan Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Tambahan style untuk varian selector */
        .cart-row-incomplete {
            background-color: #fff3cd !important;
            border-left: 4px solid #ffc107;
        }

        .cart-card-incomplete {
            border: 2px solid #ffc107 !important;
            background-color: #fff3cd !important;
        }

        .cart-variant-label {
            font-size: 11px;
            color: #8B6F47;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .variant-selectors .form-select-sm {
            font-size: 12px;
            padding: 4px 8px;
            border: 1px solid #D4A574;
            border-radius: 6px;
        }

        .color-preview {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .color-box {
            width: 20px;
            height: 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
            display: inline-block;
        }

        .color-preview-mobile {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .variant-selectors-mobile .form-select-sm {
            font-size: 12px;
            padding: 6px 8px;
            border: 1px solid #D4A574;
            border-radius: 6px;
        }

        /* Style untuk table yang sudah ada */
        .cart-brown-theme {
            background: linear-gradient(to bottom, #fff, #f5f1ed);
            padding: 80px 0;
        }

        .cart-alert-success {
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border-left: 4px solid #28a745;
        }

        .cart-table-wrapper {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(139, 111, 71, 0.15);
            background: white;
            border: 2px solid #D4A574;
            margin-bottom: 30px;
        }

        .cart-table {
            margin-bottom: 0;
        }

        .cart-table thead th {
            background: linear-gradient(135deg, #A0826D, #8B6F47);
            color: white;
            font-weight: 700;
            border: none;
            padding: 16px;
            font-size: 14px;
        }

        .cart-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .cart-table tbody tr:hover {
            background-color: #f5f1ed;
        }

        .cart-table tbody td {
            padding: 20px 16px;
            vertical-align: middle;
        }

        .cart-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #D4A574;
        }

        .cart-img-link:hover .cart-img {
            transform: scale(1.05);
            transition: transform 0.3s;
        }

        .cart-product-title {
            color: #5a4a3a;
            font-weight: 600;
            text-decoration: none;
            font-size: 15px;
            transition: color 0.3s;
        }

        .cart-product-title:hover {
            color: #A0826D;
        }

        .cart-variant {
            color: #8B6F47;
            font-size: 12px;
        }

        .cart-price {
            color: #A0826D;
            font-weight: 700;
            font-size: 15px;
        }

        .cart-subtotal {
            color: #5a4a3a;
            font-weight: 700;
            font-size: 16px;
        }

        .cart-qty-wrapper {
            display: inline-flex;
            align-items: center;
            border: 2px solid #D4A574;
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }

        .cart-qty-btn {
            width: 38px;
            height: 38px;
            border: 1px solid #D4A574;
            background: white;
            color: #A0826D;
            font-size: 22px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            line-height: 1;
            transition: background-color 0.3s ease;
        }

        .cart-qty-btn:hover {
            background: linear-gradient(135deg, #A0826D, #8B6F47);
            color: white;
        }

        .cart-qty-input {
            width: 48px;
            height: 38px;
            border: none;
            text-align: center;
            font-weight: 700;
            font-size: 18px;
            color: #5a4a3a;
            background: white;
            pointer-events: none;
            user-select: none;
            margin: 0 4px;
        }

        .cart-btn-remove {
            width: 35px;
            height: 35px;
            border: 2px solid #dc3545;
            background: transparent;
            color: #dc3545;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .cart-btn-remove:hover {
            background: #dc3545;
            color: white;
            transform: scale(1.1);
        }

        .cart-cards-wrapper {
            display: grid;
            gap: 20px;
        }

        .cart-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(139, 111, 71, 0.1);
            border: 2px solid #D4A574;
        }

        .cart-card-header {
            padding: 15px;
            background: #f5f1ed;
            text-align: center;
        }

        .cart-card-img {
            width: 100%;
            max-width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #D4A574;
        }

        .cart-card-body {
            padding: 15px;
        }

        .cart-card-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .cart-card-title a {
            color: #5a4a3a;
            text-decoration: none;
        }

        .cart-card-title a:hover {
            color: #A0826D;
        }

        .cart-card-label {
            color: #8B6F47;
            font-weight: 600;
            font-size: 13px;
            margin-right: 10px;
        }

        .cart-btn-remove-mobile {
            width: 100%;
            padding: 10px;
            background: transparent;
            color: #dc3545;
            border: 2px solid #dc3545;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .cart-btn-remove-mobile:hover {
            background: #dc3545;
            color: white;
        }

        .cart-summary {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(139, 111, 71, 0.15);
            border: 2px solid #D4A574;
        }

        .cart-summary-title {
            color: #5a4a3a;
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #D4A574;
        }

        .cart-summary-list {
            list-style: none;
            padding: 0;
            margin-bottom: 25px;
        }

        .cart-summary-list li {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            color: #666;
            font-size: 15px;
        }

        .cart-summary-total {
            border-top: 2px solid #D4A574;
            padding-top: 15px !important;
            margin-top: 10px;
        }

        .cart-summary-total span {
            font-weight: 700;
            color: #5a4a3a;
            font-size: 18px;
        }

        .cart-summary-value {
            color: #A0826D;
            font-weight: 600;
        }

        .cart-summary-value-total {
            color: #A0826D;
            font-weight: 700;
            font-size: 20px;
        }

        .cart-btn-checkout {
            display: block;
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #A0826D, #8B6F47);
            color: white;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            font-weight: 700;
            transition: all 0.3s;
            margin-bottom: 12px;
            border: none;
            cursor: pointer;
        }

        .cart-btn-checkout:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(160, 130, 109, 0.4);
            color: white;
        }

        .cart-btn-checkout:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .cart-btn-continue {
            display: block;
            width: 100%;
            padding: 12px;
            background: transparent;
            color: #A0826D;
            border: 2px solid #D4A574;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .cart-btn-continue:hover {
            background: #f5f1ed;
            color: #8B6F47;
        }

        .cart-empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .update-qty-btn {
            font-size: 11px !important;
            padding: 3px 6px !important;
            border: 1px solid #A0826D !important;
            color: #A0826D !important;
        }

        .update-qty-btn:hover {
            background-color: #A0826D !important;
            color: white !important;
        }

        .cart-empty-icon {
            font-size: 80px;
            color: #ddd;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .cart-empty-title {
            color: #5a4a3a;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .cart-empty-text {
            color: #666;
            font-size: 15px;
            margin-bottom: 30px;
        }

        .cart-btn-shop {
            display: inline-block;
            padding: 14px 30px;
            background: linear-gradient(135deg, #A0826D, #8B6F47);
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 700;
            transition: all 0.3s;
        }

        .cart-btn-shop:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(160, 130, 109, 0.4);
            color: white;
        }

        @media (max-width: 991px) {
            .cart-card-img {
                max-width: 150px;
                height: 150px;
            }
        }

        @media (max-width: 576px) {
            .cart-brown-theme {
                padding: 40px 0;
            }

            .cart-summary {
                padding: 20px;
            }

            .cart-qty-btn {
                width: 35px;
                height: 35px;
                font-size: 20px;
            }

            .cart-qty-input {
                width: 42px;
                height: 35px;
                font-size: 16px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Update incomplete items count
            function updateIncompleteItemsCount() {
                let incompleteCount = $('.cart-row-incomplete, .cart-card-incomplete').length;
                if (incompleteCount > 0) {
                    $('#incompleteItemsAlert').removeClass('d-none');
                    $('#incompleteCount').text(`(${incompleteCount} produk)`);
                } else {
                    $('#incompleteItemsAlert').addClass('d-none');
                }
            }

            // Initialize incomplete count
            updateIncompleteItemsCount();

            // Show update button when quantity changes
            $(document).on('input change', '.cart-qty-input', function() {
                let itemId = $(this).data('item-id');
                $(`.update-qty-btn[data-item-id="${itemId}"]`).show();
            });

            // Handle update button click
            $(document).on('click', '.update-qty-btn', function() {
                let itemId = $(this).data('item-id');
                let input = $(`.cart-qty-input[data-item-id="${itemId}"]`);
                let quantity = parseInt(input.val());

                if (quantity < 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Quantity Invalid',
                        text: 'Jumlah minimal adalah 1',
                        confirmButtonColor: '#A0826D'
                    });
                    return;
                }

                updateCartQuantity(itemId, quantity);
            });

            // Handle quantity updates dengan button +/-
            $(document).on('click', '.cart-plus', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                let itemId = $(this).data('item-id');
                let input = $(`.cart-qty-input[data-item-id="${itemId}"]`);
                let currentQty = parseInt(input.val());
                let newQty = currentQty + 1;

                input.val(newQty);
                $(`.update-qty-btn[data-item-id="${itemId}"]`).show();
            });

            $(document).on('click', '.cart-minus', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                let itemId = $(this).data('item-id');
                let input = $(`.cart-qty-input[data-item-id="${itemId}"]`);
                let currentQty = parseInt(input.val());

                if (currentQty > 1) {
                    let newQty = currentQty - 1;
                    input.val(newQty);
                    $(`.update-qty-btn[data-item-id="${itemId}"]`).show();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Minimal 1 Item',
                        text: 'Jumlah minimal adalah 1. Gunakan tombol hapus untuk menghapus produk.',
                        confirmButtonColor: '#A0826D'
                    });
                }
            });

            // Function to update cart quantity
            function updateCartQuantity(itemId, quantity) {
                // Show loading state
                let updateBtn = $(`.update-qty-btn[data-item-id="${itemId}"]`);
                let originalText = updateBtn.html();
                updateBtn.html('<i class="bi bi-hourglass"></i> Updating...');
                updateBtn.prop('disabled', true);

                $.ajax({
                    url: `/cart/${itemId}`,
                    method: 'PUT',
                    data: {
                        quantity: quantity
                    },
                    success: function(response) {
                        console.log('Update response:', response);

                        if (response.success) {
                            // Hide update button
                            updateBtn.hide();
                            updateBtn.prop('disabled', false);
                            updateBtn.html(originalText);

                            // Update item total
                            $(`.item-total-${itemId}`).text('Rp ' + response.item_total);

                            // Update cart summary
                            $('#cart-subtotal').text('Rp ' + response.subtotal);
                            $('#cart-total').text('Rp ' + response.subtotal);

                            // Update cart badge
                            $('#cart-badge-count').text(response.cart_count);

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Quantity updated!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Update error:', xhr);

                        // Revert button state
                        updateBtn.prop('disabled', false);
                        updateBtn.html(originalText);

                        let message = 'Failed to update quantity!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: message,
                            confirmButtonColor: '#A0826D'
                        });
                    }
                });
            }

            // Handle size selection
            $(document).on('change', '.size-selector', function() {
                let itemId = $(this).data('item-id');
                let sizeId = $(this).val();
                let colorId = $(`.color-selector[data-item-id="${itemId}"]`).val();

                if (sizeId && colorId) {
                    updateCartVariant(itemId, sizeId, colorId);
                }
            });

            // Handle color selection
            $(document).on('change', '.color-selector', function() {
                let itemId = $(this).data('item-id');
                let colorId = $(this).val();
                let sizeId = $(`.size-selector[data-item-id="${itemId}"]`).val();

                // Update color preview
                let selectedOption = $(this).find('option:selected');
                let colorCode = selectedOption.data('color-code');
                let colorName = selectedOption.text();

                let colorPreview = $(this).closest('.variant-selectors').find('.color-preview');
                if (colorPreview.length === 0) {
                    colorPreview = $('<div class="color-preview mt-1"></div>');
                    $(this).closest('.variant-selectors').append(colorPreview);
                }

                if (colorId) {
                    colorPreview.html(`
                        <span class="color-box" style="background-color: ${colorCode}"></span>
                        <small>${colorName}</small>
                    `);
                } else {
                    colorPreview.empty();
                }

                // Mobile color preview
                let colorPreviewMobile = $(this).closest('.variant-selectors-mobile').find(
                    '.color-preview-mobile');
                if (colorPreviewMobile.length === 0) {
                    colorPreviewMobile = $('<div class="color-preview-mobile mt-2"></div>');
                    $(this).closest('.variant-selectors-mobile').append(colorPreviewMobile);
                }

                if (colorId) {
                    colorPreviewMobile.html(`
                        <span class="color-box" style="background-color: ${colorCode}"></span>
                        <small>${colorName}</small>
                    `);
                } else {
                    colorPreviewMobile.empty();
                }

                if (sizeId && colorId) {
                    updateCartVariant(itemId, sizeId, colorId);
                }
            });

            // Update cart variant
            function updateCartVariant(itemId, sizeId, colorId) {
                $.ajax({
                    url: `/cart/variant/${itemId}`,
                    method: 'PUT',
                    data: {
                        size_id: sizeId,
                        color_id: colorId
                    },
                    success: function(response) {
                        if (response.success) {
                            // Remove incomplete styling
                            $(`.cart-row[data-item-id="${itemId}"]`).removeClass('cart-row-incomplete');
                            $(`.cart-card[data-item-id="${itemId}"]`).removeClass(
                                'cart-card-incomplete');

                            // Remove warning message
                            $(`.cart-row[data-item-id="${itemId}"] .text-danger`).remove();
                            $(`.cart-card[data-item-id="${itemId}"] .alert-warning`).remove();

                            // If items were merged, remove the old row/card
                            if (response.merged && response.removed_item_id) {
                                $(`[data-item-id="${response.removed_item_id}"]`).fadeOut(300,
                                    function() {
                                        $(this).remove();
                                        updateIncompleteItemsCount();
                                    });
                            }

                            updateIncompleteItemsCount();

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Varian berhasil diupdate!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Gagal mengupdate varian!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: message,
                            confirmButtonColor: '#A0826D'
                        });
                    }
                });
            }

            $(document).on('click', '.remove-cart-item', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                let itemId = $(this).data('item-id');
                let productName = $(this).data('product-name');

                Swal.fire({
                    title: 'Hapus Produk?',
                    html: `<strong>${productName}</strong><br><small class="text-muted">akan dihapus dari keranjang</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="bi bi-trash"></i> Hapus',
                    cancelButtonText: '<i class="bi bi-x-circle"></i> Batal',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        removeCartItem(itemId);
                    }
                });
            });

            function removeCartItem(itemId) {
                $.ajax({
                    url: `/cart/${itemId}`,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            $(`tr[data-item-id="${itemId}"]`).fadeOut(300, function() {
                                $(this).remove();
                            });
                            $(`.cart-card[data-item-id="${itemId}"]`).fadeOut(300, function() {
                                $(this).remove();
                            });

                            // Update cart summary
                            $('#cart-subtotal').text('Rp ' + response.subtotal);
                            $('#cart-total').text('Rp ' + response.subtotal);
                            $('#cart-badge-count').text(response.cart_count);

                            updateIncompleteItemsCount();

                            if (response.cart_count === 0) {
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Dihapus!',
                                text: 'Produk telah dihapus dari keranjang',
                                confirmButtonColor: '#28a745'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menghapus produk!',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            }

            // Handle checkout validation
            $('#checkoutBtn').on('click', function() {
                validateCartBeforeCheckout();
            });

            function validateCartBeforeCheckout() {
                $.ajax({
                    url: '/cart/validate',
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            // Jika valid, redirect ke checkout
                            window.location.href = "{{ route('customer.checkout') }}";
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<ul class="mb-0">';
                            errors.forEach(error => {
                                errorHtml += `<li class="text-danger">${error}</li>`;
                            });
                            errorHtml += '</ul>';

                            $('#checkoutModalBody').html(errorHtml);
                            $('#checkoutModal').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat validasi keranjang.',
                                confirmButtonColor: '#A0826D'
                            });
                        }
                    }
                });
            }

            // Auto-hide alerts
            setTimeout(() => {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@endpush
