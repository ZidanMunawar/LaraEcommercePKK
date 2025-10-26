@extends('customer.layouts.app')

@section('title', 'Shopping Cart - ZynHope Apparel')

@section('content')
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Shopping Cart</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Home</a></li>
                                    <li><span>Cart</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart area start -->
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

                    @if ($cartItems->isNotEmpty())
                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Images</th>
                                        <th class="cart-product-name">Product</th>
                                        <th class="product-price">Unit Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items">
                                    @foreach ($cartItems as $item)
                                        <tr data-item-id="{{ $item->id_cart_item }}">
                                            <td class="product-thumbnail">
                                                <a href="{{ route('customer.product.detail', $item->produk->id_produk) }}">
                                                    @if ($item->produk->images->isNotEmpty())
                                                        <img src="{{ asset('storage/' . $item->produk->images->first()->image_url) }}"
                                                            alt="{{ $item->produk->name }}" style="max-width: 100px;">
                                                    @else
                                                        <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                            alt="{{ $item->produk->name }}" style="max-width: 100px;">
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a href="{{ route('customer.product.detail', $item->produk->id_produk) }}">
                                                    {{ $item->produk->name }}
                                                </a>
                                                @if ($item->size || $item->color)
                                                    <br>
                                                    <small class="text-muted">
                                                        @if ($item->size)
                                                            Size: {{ $item->size->size }}
                                                        @endif
                                                        @if ($item->color)
                                                            {{ $item->size ? ' | ' : '' }}Color: {{ $item->color->name }}
                                                        @endif
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="product-price">
                                                <span class="amount">Rp
                                                    {{ number_format($item->harga, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="product-quantity text-center">
                                                <div class="product-quantity mt-10 mb-10">
                                                    <div class="product-quantity-form">
                                                        <form action="#">
                                                            <button type="button" class="cart-minus"
                                                                data-item-id="{{ $item->id_cart_item }}">
                                                                <i class="far fa-minus"></i>
                                                            </button>
                                                            <input class="cart-input" type="text"
                                                                value="{{ $item->qty }}" readonly
                                                                data-item-id="{{ $item->id_cart_item }}">
                                                            <button type="button" class="cart-plus"
                                                                data-item-id="{{ $item->id_cart_item }}">
                                                                <i class="far fa-plus"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="amount item-total-{{ $item->id_cart_item }}">
                                                    Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td class="product-remove">
                                                <a href="javascript:void(0)" class="remove-cart-item"
                                                    data-item-id="{{ $item->id_cart_item }}">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 ml-auto">
                                <div class="cart-page-total">
                                    <h2>Cart totals</h2>
                                    <ul class="mb-20">
                                        <li>Subtotal <span id="cart-subtotal">Rp
                                                {{ number_format($subtotal, 0, ',', '.') }}</span></li>
                                        <li><strong>Total</strong> <span id="cart-total"><strong>Rp
                                                    {{ number_format($subtotal, 0, ',', '.') }}</strong></span></li>
                                    </ul>
                                    <a class="fill-btn" href="{{ route('customer.checkout') }}">
                                        <span class="fill-btn-inner">
                                            <span class="fill-btn-normal">Proceed to checkout</span>
                                            <span class="fill-btn-hover">Proceed to checkout</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <h4>Your cart is empty</h4>
                            <p class="mb-4">Add some products to your cart and they will appear here.</p>
                            <a href="{{ route('customer.products') }}" class="fill-btn">
                                <span class="fill-btn-inner">
                                    <span class="fill-btn-normal">Continue Shopping</span>
                                    <span class="fill-btn-hover">Continue Shopping</span>
                                </span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Cart area end -->
@endsection

@push('scripts')
    <script>
        console.log('Cart Script Loaded');

        $(document).ready(function() {
            console.log('jQuery Ready - Cart');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ✅ FIX: Pakai event delegation dari document, tapi dengan ONE-TIME click
            $(document).on('click', '.cart-plus', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation(); // ✅ TAMBAH INI - Stop multiple triggers

                console.log('Plus clicked');

                let itemId = $(this).data('item-id');
                let input = $(`input.cart-input[data-item-id="${itemId}"]`);
                let currentQty = parseInt(input.val());
                let newQty = currentQty + 1;

                updateCartQuantity(itemId, newQty);
            });

            $(document).on('click', '.cart-minus', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation(); // ✅ TAMBAH INI

                console.log('Minus clicked');

                let itemId = $(this).data('item-id');
                let input = $(`input.cart-input[data-item-id="${itemId}"]`);
                let currentQty = parseInt(input.val());

                if (currentQty > 1) {
                    let newQty = currentQty - 1;
                    updateCartQuantity(itemId, newQty);
                }
            });

            $(document).on('click', '.remove-cart-item', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation(); // ✅ TAMBAH INI

                console.log('Remove clicked');

                let itemId = $(this).data('item-id');

                if (confirm('Remove this item from cart?')) {
                    removeCartItem(itemId);
                }
            });

            function updateCartQuantity(itemId, quantity) {
                console.log('Updating quantity:', itemId, quantity);

                $.ajax({
                    url: `/cart/${itemId}`,
                    method: 'PUT',
                    data: {
                        quantity: quantity
                    },
                    success: function(response) {
                        console.log('Update success:', response);

                        if (response.success) {
                            // Update input
                            $(`input.cart-input[data-item-id="${itemId}"]`).val(quantity);

                            // Update item total
                            $(`.item-total-${itemId}`).text('Rp ' + response.item_total);

                            // Update cart subtotal & total
                            $('#cart-subtotal').text('Rp ' + response.subtotal);
                            $('#cart-total strong').text('Rp ' + response.subtotal);

                            // ✅ UPDATE CART BADGE DENGAN ID SPESIFIK
                            $('#cart-badge-count').text(response.cart_count);
                        }
                    },
                    error: function(xhr) {
                        console.log('Update error:', xhr);

                        let message = 'Failed to update cart!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        alert(message);
                    }
                });
            }

            function removeCartItem(itemId) {
                console.log('Removing item:', itemId);

                $.ajax({
                    url: `/cart/${itemId}`,
                    method: 'DELETE',
                    success: function(response) {
                        console.log('Remove success:', response);

                        if (response.success) {
                            // Remove row
                            $(`tr[data-item-id="${itemId}"]`).fadeOut(300, function() {
                                $(this).remove();

                                // Update subtotal & total
                                $('#cart-subtotal').text('Rp ' + response.subtotal);
                                $('#cart-total strong').text('Rp ' + response.subtotal);

                                // ✅ UPDATE CART BADGE DENGAN ID SPESIFIK
                                $('#cart-badge-count').text(response.cart_count);

                                // Check if cart is empty
                                if (response.cart_count === 0) {
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
    </script>
@endpush
