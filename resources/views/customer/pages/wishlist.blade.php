@extends('customer.layouts.app')

@section('title', 'Wishlist - ZynHope Apparel')

@section('content')
    <!-- Breadcrumb area start -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">
                            <i class="bi bi-heart-fill text-danger me-2"></i>Wishlist Saya
                        </h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><span>Wishlist</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb area end -->

    <!-- Wishlist Content -->
    <div class="wishlist-area section-space wishlist-brown-theme">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Success Alert -->
                    @if (session('success'))
                        <div class="alert alert-dismissible fade show wishlist-alert-success" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>Berhasil!</strong> {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($wishlists->isNotEmpty())
                        <!-- Desktop View: Table -->
                        <div class="wishlist-table-wrapper d-none d-lg-block">
                            <div class="table-responsive">
                                <table class="table wishlist-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;">Gambar</th>
                                            <th style="width: 35%;">Produk</th>
                                            <th style="width: 15%;">Harga</th>
                                            <th style="width: 15%;">Stok</th>
                                            <th style="width: 15%;">Aksi</th>
                                            <th style="width: 10%; text-align: center;">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wishlists as $wishlist)
                                            <tr data-wishlist-id="{{ $wishlist->id_wishlist }}" class="wishlist-row">
                                                <!-- Gambar -->
                                                <td class="product-thumbnail">
                                                    <a href="{{ route('customer.product.detail', $wishlist->produk->id_produk) }}"
                                                        class="wishlist-img-link">
                                                        @if ($wishlist->produk->images->isNotEmpty())
                                                            <img src="{{ asset('storage/' . $wishlist->produk->images->first()->image_url) }}"
                                                                alt="{{ $wishlist->produk->name }}" class="wishlist-img">
                                                        @else
                                                            <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                                alt="{{ $wishlist->produk->name }}" class="wishlist-img">
                                                        @endif
                                                    </a>
                                                </td>

                                                <!-- Nama Produk -->
                                                <td class="product-name">
                                                    <a href="{{ route('customer.product.detail', $wishlist->produk->id_produk) }}"
                                                        class="wishlist-product-title">
                                                        {{ $wishlist->produk->name }}
                                                    </a>
                                                    @if ($wishlist->produk->categories->isNotEmpty())
                                                        <br>
                                                        <small class="wishlist-category">
                                                            <i
                                                                class="bi bi-tag-fill me-1"></i>{{ $wishlist->produk->categories->first()->name }}
                                                        </small>
                                                    @endif
                                                </td>

                                                <!-- Harga -->
                                                <td class="product-price">
                                                    @if ($wishlist->produk->old_price && $wishlist->produk->old_price > $wishlist->produk->price)
                                                        <del class="wishlist-old-price">
                                                            Rp
                                                            {{ number_format($wishlist->produk->old_price, 0, ',', '.') }}
                                                        </del>
                                                        <br>
                                                    @endif
                                                    <span class="wishlist-current-price">
                                                        Rp {{ number_format($wishlist->produk->price, 0, ',', '.') }}
                                                    </span>
                                                </td>

                                                <!-- Stok -->
                                                <td class="product-stock">
                                                    @if ($wishlist->produk->is_available && $wishlist->produk->quantity > 0)
                                                        <span class="wishlist-badge wishlist-badge-success">
                                                            <i class="bi bi-check-circle-fill me-1"></i>Tersedia
                                                        </span>
                                                    @else
                                                        <span class="wishlist-badge wishlist-badge-danger">
                                                            <i class="bi bi-x-circle-fill me-1"></i>Habis
                                                        </span>
                                                    @endif
                                                </td>

                                                <!-- Tombol Lihat -->
                                                <td class="product-add-cart">
                                                    <a href="{{ route('customer.product.detail', $wishlist->produk->id_produk) }}"
                                                        class="wishlist-btn-view">
                                                        <i class="bi bi-eye me-1"></i>Lihat
                                                    </a>
                                                </td>

                                                <!-- Tombol Hapus -->
                                                <td class="product-remove text-center">
                                                    <button type="button" class="wishlist-btn-remove remove-wishlist-item"
                                                        data-wishlist-id="{{ $wishlist->id_wishlist }}"
                                                        data-product-name="{{ $wishlist->produk->name }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Mobile View: Cards -->
                        <div class="wishlist-cards-wrapper d-lg-none">
                            @foreach ($wishlists as $wishlist)
                                <div class="wishlist-card" data-wishlist-id="{{ $wishlist->id_wishlist }}">
                                    <div class="wishlist-card-header">
                                        <a href="{{ route('customer.product.detail', $wishlist->produk->id_produk) }}">
                                            @if ($wishlist->produk->images->isNotEmpty())
                                                <img src="{{ asset('storage/' . $wishlist->produk->images->first()->image_url) }}"
                                                    alt="{{ $wishlist->produk->name }}" class="wishlist-card-img">
                                            @else
                                                <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                    alt="{{ $wishlist->produk->name }}" class="wishlist-card-img">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="wishlist-card-body">
                                        <h6 class="wishlist-card-title">
                                            <a href="{{ route('customer.product.detail', $wishlist->produk->id_produk) }}">
                                                {{ Str::limit($wishlist->produk->name, 50) }}
                                            </a>
                                        </h6>
                                        @if ($wishlist->produk->categories->isNotEmpty())
                                            <small class="wishlist-card-category">
                                                <i
                                                    class="bi bi-tag-fill me-1"></i>{{ $wishlist->produk->categories->first()->name }}
                                            </small>
                                        @endif

                                        <div class="wishlist-card-price mt-2">
                                            @if ($wishlist->produk->old_price && $wishlist->produk->old_price > $wishlist->produk->price)
                                                <del class="wishlist-old-price">
                                                    Rp {{ number_format($wishlist->produk->old_price, 0, ',', '.') }}
                                                </del>
                                                <br>
                                            @endif
                                            <span class="wishlist-current-price">
                                                Rp {{ number_format($wishlist->produk->price, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="wishlist-card-stock mt-2">
                                            @if ($wishlist->produk->is_available && $wishlist->produk->quantity > 0)
                                                <span class="wishlist-badge wishlist-badge-success">
                                                    <i class="bi bi-check-circle-fill me-1"></i>Tersedia
                                                </span>
                                            @else
                                                <span class="wishlist-badge wishlist-badge-danger">
                                                    <i class="bi bi-x-circle-fill me-1"></i>Habis
                                                </span>
                                            @endif
                                        </div>

                                        <div class="wishlist-card-actions mt-3">
                                            <a href="{{ route('customer.product.detail', $wishlist->produk->id_produk) }}"
                                                class="wishlist-btn-view w-100 mb-2">
                                                <i class="bi bi-eye me-1"></i>Lihat Detail
                                            </a>
                                            <button type="button" class="wishlist-btn-remove w-100 remove-wishlist-item"
                                                data-wishlist-id="{{ $wishlist->id_wishlist }}"
                                                data-product-name="{{ $wishlist->produk->name }}">
                                                <i class="bi bi-trash me-1"></i>Hapus dari Wishlist
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Statistik -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="wishlist-info-alert">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <strong>Total {{ $wishlists->count() }}</strong> produk di wishlist Anda
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="wishlist-empty-state">
                            <div class="wishlist-empty-icon">
                                <i class="bi bi-heart"></i>
                            </div>
                            <h4 class="wishlist-empty-title">Wishlist Anda Kosong</h4>
                            <p class="wishlist-empty-text">Belum ada produk favorit? Jelajahi koleksi kami sekarang juga!
                            </p>
                            <a href="{{ route('customer.products') }}" class="wishlist-btn-shop">
                                <i class="bi bi-shop me-2"></i>Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Brown Theme */
        .wishlist-brown-theme {
            background: linear-gradient(to bottom, #fff, #f5f1ed);
            padding: 80px 0;
        }

        /* Alert */
        .wishlist-alert-success {
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border-left: 4px solid #28a745;
        }

        /* Table Wrapper */
        .wishlist-table-wrapper {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(139, 111, 71, 0.15);
            background: white;
            border: 2px solid #D4A574;
        }

        /* Table */
        .wishlist-table {
            margin-bottom: 0;
        }

        .wishlist-table thead th {
            background: linear-gradient(135deg, #A0826D, #8B6F47);
            color: white;
            font-weight: 700;
            border: none;
            padding: 16px;
            font-size: 14px;
        }

        .wishlist-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .wishlist-table tbody tr:hover {
            background-color: #f5f1ed;
        }

        .wishlist-table tbody td {
            padding: 16px;
            vertical-align: middle;
        }

        /* Image */
        .wishlist-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #D4A574;
        }

        .wishlist-img-link:hover .wishlist-img {
            transform: scale(1.05);
            transition: transform 0.3s;
        }

        /* Product Title */
        .wishlist-product-title {
            color: #5a4a3a;
            font-weight: 600;
            text-decoration: none;
            font-size: 15px;
            transition: color 0.3s;
        }

        .wishlist-product-title:hover {
            color: #A0826D;
        }

        .wishlist-category {
            color: #8B6F47;
            font-size: 12px;
        }

        /* Price */
        .wishlist-old-price {
            color: #999;
            font-size: 12px;
        }

        .wishlist-current-price {
            color: #A0826D;
            font-weight: 700;
            font-size: 16px;
        }

        /* Badge */
        .wishlist-badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
        }

        .wishlist-badge-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .wishlist-badge-danger {
            background: linear-gradient(135deg, #dc3545, #fd7e14);
            color: white;
        }

        /* Buttons */
        .wishlist-btn-view {
            display: inline-block;
            padding: 8px 16px;
            background: linear-gradient(135deg, #A0826D, #8B6F47);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            text-align: center;
        }

        .wishlist-btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(160, 130, 109, 0.3);
            color: white;
        }

        .wishlist-btn-remove {
            padding: 8px 16px;
            background: transparent;
            color: #dc3545;
            border: 2px solid #dc3545;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
        }

        .wishlist-btn-remove:hover {
            background: #dc3545;
            color: white;
            transform: scale(1.05);
        }

        /* Mobile Cards */
        .wishlist-cards-wrapper {
            display: grid;
            gap: 20px;
        }

        .wishlist-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(139, 111, 71, 0.1);
            border: 2px solid #D4A574;
        }

        .wishlist-card-header {
            padding: 15px;
            background: #f5f1ed;
            text-align: center;
        }

        .wishlist-card-img {
            width: 100%;
            max-width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #D4A574;
        }

        .wishlist-card-body {
            padding: 15px;
        }

        .wishlist-card-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .wishlist-card-title a {
            color: #5a4a3a;
            text-decoration: none;
        }

        .wishlist-card-title a:hover {
            color: #A0826D;
        }

        .wishlist-card-category {
            color: #8B6F47;
            font-size: 12px;
        }

        /* Info Alert */
        .wishlist-info-alert {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            border-left: 4px solid #0c5460;
            padding: 15px;
            border-radius: 10px;
            color: #0c5460;
        }

        /* Empty State */
        .wishlist-empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .wishlist-empty-icon {
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

        .wishlist-empty-title {
            color: #5a4a3a;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .wishlist-empty-text {
            color: #666;
            font-size: 15px;
            margin-bottom: 30px;
        }

        .wishlist-btn-shop {
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

        .wishlist-btn-shop:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(160, 130, 109, 0.4);
            color: white;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .wishlist-card-img {
                max-width: 150px;
                height: 150px;
            }
        }

        @media (max-width: 576px) {
            .wishlist-brown-theme {
                padding: 40px 0;
            }

            .wishlist-card-img {
                max-width: 120px;
                height: 120px;
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

            $(document).on('click', '.remove-wishlist-item', function(e) {
                e.preventDefault();

                let wishlistId = $(this).data('wishlist-id');
                let productName = $(this).data('product-name');

                Swal.fire({
                    title: 'Hapus Produk?',
                    html: `<strong>${productName}</strong><br><small class="text-muted">akan dihapus dari wishlist</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="bi bi-trash"></i> Hapus',
                    cancelButtonText: '<i class="bi bi-x-circle"></i> Batal',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    customClass: {
                        popup: 'swal-brown-popup',
                        confirmButton: 'swal-brown-btn'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menghapus...',
                            html: 'Tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: `/wishlist/${wishlistId}`,
                            method: 'DELETE',
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    // Remove from table
                                    $(`tr[data-wishlist-id="${wishlistId}"]`).fadeOut(
                                        300,
                                        function() {
                                            $(this).remove();
                                        });

                                    // Remove from cards
                                    $(`.wishlist-card[data-wishlist-id="${wishlistId}"]`)
                                        .fadeOut(300, function() {
                                            $(this).remove();
                                        });

                                    // Update badge
                                    if ($('#wishlist-badge-count').length) {
                                        $('#wishlist-badge-count').text(response
                                            .wishlist_count);
                                    }

                                    // Reload if empty
                                    if (response.wishlist_count === 0) {
                                        setTimeout(() => {
                                            location.reload();
                                        }, 1500);
                                    }

                                    Swal.fire({
                                        title: 'Berhasil Dihapus!',
                                        text: 'Produk telah dihapus dari wishlist',
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#28a745'
                                    });
                                }
                            },
                            error: function(xhr) {
                                let errorMessage =
                                    'Gagal menghapus produk dari wishlist!';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }

                                Swal.fire({
                                    title: 'Gagal!',
                                    text: errorMessage,
                                    icon: 'error',
                                    confirmButtonText: 'Coba Lagi',
                                    confirmButtonColor: '#dc3545'
                                });
                            }
                        });
                    }
                });
            });

            // Auto hide alerts
            setTimeout(() => {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@endpush

@push('styles')
    <style>
        .swal-brown-popup {
            border-radius: 12px !important;
        }

        .swal-brown-btn {
            border-radius: 8px !important;
            font-weight: 600 !important;
        }
    </style>
@endpush
