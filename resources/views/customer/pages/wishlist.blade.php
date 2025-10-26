@extends('customer.layouts.app')

@section('title', 'Wishlist - ZynHope Apparel')

@section('content')
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">My Wishlist</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Home</a></li>
                                    <li><span>Wishlist</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wishlist area start -->
    <div class="cart-area section-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($wishlists->isNotEmpty())
                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Images</th>
                                        <th class="cart-product-name">Product</th>
                                        <th class="product-price">Unit Price</th>
                                        <th class="product-stock">Stock Status</th>
                                        <th class="product-add-cart">Add to Cart</th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody id="wishlist-items">
                                    @foreach ($wishlists as $wishlist)
                                        <tr data-wishlist-id="{{ $wishlist->id_wishlist }}">
                                            <td class="product-thumbnail">
                                                <a
                                                    href="{{ route('customer.product.detail', $wishlist->produk->id_produk) }}">
                                                    @if ($wishlist->produk->images->isNotEmpty())
                                                        <img src="{{ asset('storage/' . $wishlist->produk->images->first()->image_url) }}"
                                                            alt="{{ $wishlist->produk->name }}" style="max-width: 100px;">
                                                    @else
                                                        <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                            alt="{{ $wishlist->produk->name }}" style="max-width: 100px;">
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a
                                                    href="{{ route('customer.product.detail', $wishlist->produk->id_produk) }}">
                                                    {{ $wishlist->produk->name }}
                                                </a>
                                                @if ($wishlist->produk->categories->isNotEmpty())
                                                    <br>
                                                    <small
                                                        class="text-muted">{{ $wishlist->produk->categories->first()->name }}</small>
                                                @endif
                                            </td>
                                            <td class="product-price">
                                                @if ($wishlist->produk->old_price && $wishlist->produk->old_price > $wishlist->produk->price)
                                                    <del class="text-muted">Rp
                                                        {{ number_format($wishlist->produk->old_price, 0, ',', '.') }}</del><br>
                                                @endif
                                                <span class="amount">Rp
                                                    {{ number_format($wishlist->produk->price, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="product-stock">
                                                @if ($wishlist->produk->is_available && $wishlist->produk->quantity > 0)
                                                    <span class="badge bg-success">In Stock</span>
                                                @else
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                @endif
                                            </td>
                                            <td class="product-add-cart">
                                                <a href="{{ route('customer.product.detail', $wishlist->produk->id_produk) }}"
                                                    class="btn btn-sm btn-primary">
                                                    View Product
                                                </a>
                                            </td>
                                            <td class="product-remove">
                                                <a href="javascript:void(0)" class="remove-wishlist-item"
                                                    data-wishlist-id="{{ $wishlist->id_wishlist }}">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <h4>Your wishlist is empty</h4>
                            <p class="mb-4">Save your favorite items here!</p>
                            <a href="{{ route('customer.products') }}" class="fill-btn">
                                <span class="fill-btn-inner">
                                    <span class="fill-btn-normal">Browse Products</span>
                                    <span class="fill-btn-hover">Browse Products</span>
                                </span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Wishlist area end -->
@endsection

@push('scripts')
    <script>
        console.log('Wishlist Script Loaded');

        $(document).ready(function() {
            console.log('jQuery Ready - Wishlist');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.remove-wishlist-item', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation(); // ✅ TAMBAH INI

                console.log('Remove wishlist clicked');

                let wishlistId = $(this).data('wishlist-id');

                if (confirm('Remove this item from wishlist?')) {
                    console.log('Removing wishlist:', wishlistId);

                    $.ajax({
                        url: `/wishlist/${wishlistId}`,
                        method: 'DELETE',
                        success: function(response) {
                            console.log('Remove success:', response);

                            if (response.success) {
                                $(`tr[data-wishlist-id="${wishlistId}"]`).fadeOut(300,
                                function() {
                                    $(this).remove();

                                    // ✅ UPDATE WISHLIST BADGE DENGAN ID SPESIFIK
                                    $('#wishlist-badge-count').text(response
                                        .wishlist_count);

                                    // Reload if empty
                                    if (response.wishlist_count === 0) {
                                        location.reload();
                                    }
                                });

                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            console.log('Remove error:', xhr);
                            alert('Failed to remove item!');
                        }
                    });
                }
            });
        });
    </script>
@endpush
