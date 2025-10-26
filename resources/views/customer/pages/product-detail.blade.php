@extends('customer.layouts.app')

@section('title', $product->name . ' - ZynHope Apparel')

@section('content')
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">{{ $product->name }}</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Home</a></li>
                                    <li><a href="{{ route('customer.products') }}">Shop</a></li>
                                    <li><span>{{ $product->name }}</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product details area start -->
    <div class="product__details-area section-space-medium">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-6 col-lg-6">
                    <div class="product__details-thumb-wrapper d-sm-flex align-items-start mr-50">
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
                        <div class="product__details-thumb-tab-content">
                            <div class="tab-content" id="productthumbcontent">
                                @if ($product->images->isNotEmpty())
                                    @foreach ($product->images as $index => $image)
                                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                            id="img-{{ $index }}" role="tabpanel"
                                            aria-labelledby="img-{{ $index }}-tab">
                                            <div class="product__details-thumb-big w-img">
                                                <img src="{{ asset('storage/' . $image->image_url) }}"
                                                    alt="{{ $product->name }}">
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="tab-pane fade show active" id="img-0" role="tabpanel"
                                        aria-labelledby="img-0-tab">
                                        <div class="product__details-thumb-big w-img">
                                            <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                alt="{{ $product->name }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-6">
                    <div class="product__details-content pr-80">
                        <div class="product__details-top d-sm-flex align-items-center mb-15">
                            @if ($product->categories->isNotEmpty())
                                <div class="product__details-tag mr-10">
                                    <a href="#">{{ $product->categories->first()->name }}</a>
                                </div>
                            @endif
                            <div class="product__details-rating mr-10">
                                @for ($i = 1; $i <= 5; $i++)
                                    <a href="#"><i class="fa-solid fa-star"></i></a>
                                @endfor
                            </div>
                            <div class="product__details-review-count">
                                <a href="#nav-review">0 Reviews</a>
                            </div>
                        </div>
                        <h3 class="product__details-title text-capitalize">{{ $product->name }}</h3>
                        <div class="product__details-price">
                            @if ($product->old_price && $product->old_price > $product->price)
                                <span class="old-price">Rp {{ number_format($product->old_price, 0, ',', '.') }}</span>
                            @endif
                            <span class="new-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <p>{{ $product->description }}</p>

                        @if ($product->colors->isNotEmpty() || $product->sizes->isNotEmpty())
                            <div class="product__details-variant mb-20">
                                @if ($product->colors->isNotEmpty())
                                    <div class="product__details-color mb-15">
                                        <h5>Color:</h5>
                                        <div class="product__details-color-list d-flex flex-wrap gap-2">
                                            @foreach ($product->colors as $color)
                                                <label class="color-option">
                                                    <input type="radio" name="color" value="{{ $color->id }}"
                                                        {{ $loop->first ? 'checked' : '' }}>
                                                    <span class="color-box" style="background-color: {{ $color->code }};"
                                                        title="{{ $color->name }}"></span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if ($product->sizes->isNotEmpty())
                                    <div class="product__details-size mb-15">
                                        <h5>Size:</h5>
                                        <div class="product__details-size-list d-flex flex-wrap gap-2">
                                            @foreach ($product->sizes as $size)
                                                <label class="size-option">
                                                    <input type="radio" name="size" value="{{ $size->id }}"
                                                        {{ $loop->first ? 'checked' : '' }}>
                                                    <span class="size-box">{{ $size->size }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="product__details-action mb-35">
                            <div class="product__quantity">
                                <div class="product-quantity-wrapper">
                                    <form action="#" id="qtyForm">
                                        <button type="button" class="cart-minus"><i class="fa-light fa-minus"></i></button>
                                        <input class="cart-input" type="text" value="1" id="quantity" readonly>
                                        <button type="button" class="cart-plus"><i class="fa-light fa-plus"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="product__add-cart">
                                @auth('customer')
                                    <a href="javascript:void(0)" class="fill-btn cart-btn" id="addToCartBtn"
                                        data-product="{{ $product->id_produk }}">
                                        <span class="fill-btn-inner">
                                            <span class="fill-btn-normal">Add To Cart<i
                                                    class="fa-solid fa-basket-shopping"></i></span>
                                            <span class="fill-btn-hover">Add To Cart<i
                                                    class="fa-solid fa-basket-shopping"></i></span>
                                        </span>
                                    </a>
                                @else
                                    <a href="{{ route('customer.login') }}" class="fill-btn cart-btn">
                                        <span class="fill-btn-inner">
                                            <span class="fill-btn-normal">Login to Add Cart<i
                                                    class="fa-solid fa-basket-shopping"></i></span>
                                            <span class="fill-btn-hover">Login to Add Cart<i
                                                    class="fa-solid fa-basket-shopping"></i></span>
                                        </span>
                                    </a>
                                @endauth
                            </div>
                            <div class="product__add-wish">
                                @auth('customer')
                                    <a href="javascript:void(0)" class="product__add-wish-btn" id="addToWishlistBtn"
                                        data-product="{{ $product->id_produk }}">
                                        <i class="fa-solid fa-heart"></i>
                                    </a>
                                @else
                                    <a href="{{ route('customer.login') }}" class="product__add-wish-btn">
                                        <i class="fa-regular fa-heart"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                        <div class="product__details-meta mb-20">
                            <div class="sku">
                                <span>SKU:</span>
                                <a href="#">PRD-{{ str_pad($product->id_produk, 6, '0', STR_PAD_LEFT) }}</a>
                            </div>
                            @if ($product->categories->isNotEmpty())
                                <div class="categories">
                                    <span>Categories:</span>
                                    @foreach ($product->categories as $category)
                                        <a href="#">{{ $category->name }}{{ !$loop->last ? ',' : '' }}</a>
                                    @endforeach
                                </div>
                            @endif
                            @if ($product->tags->isNotEmpty())
                                <div class="tag">
                                    <span>Tags:</span>
                                    @foreach ($product->tags as $tag)
                                        <a href="#">{{ $tag->name }}{{ !$loop->last ? ',' : '' }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="product__details-share">
                            <span>Share:</span>
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info Tabs -->
            <div class="product__details-additional-info section-space-medium-top">
                <div class="row">
                    <div class="col-xxl-3 col-xl-4 col-lg-4">
                        <div class="product__details-more-tab mr-15">
                            <nav>
                                <div class="nav nav-tabs flex-column" id="productmoretab" role="tablist">
                                    <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-description" type="button" role="tab"
                                        aria-controls="nav-description" aria-selected="true">Description</button>
                                    <button class="nav-link" id="nav-additional-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-additional" type="button" role="tab"
                                        aria-controls="nav-additional" aria-selected="false">Additional
                                        Information</button>
                                    <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-review" type="button" role="tab"
                                        aria-controls="nav-review" aria-selected="false">Reviews (0)</button>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xxl-9 col-xl-8 col-lg-8">
                        <div class="product__details-more-tab-content">
                            <div class="tab-content" id="productmorecontent">
                                <!-- Description Tab -->
                                <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                                    aria-labelledby="nav-description-tab">
                                    <div class="product__details-des">
                                        <p>{{ $product->description }}</p>
                                        @if ($product->is_available)
                                            <p><strong>Stock Status:</strong> In Stock ({{ $product->quantity }} items
                                                available)</p>
                                        @else
                                            <p><strong>Stock Status:</strong> Out of Stock</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Additional Info Tab -->
                                <div class="tab-pane fade" id="nav-additional" role="tabpanel"
                                    aria-labelledby="nav-additional-tab">
                                    <div class="product__details-info">
                                        <ul>
                                            @if ($product->colors->isNotEmpty())
                                                <li>
                                                    <h4>Available Colors</h4>
                                                    <span>{{ $product->colors->pluck('name')->join(', ') }}</span>
                                                </li>
                                            @endif
                                            @if ($product->sizes->isNotEmpty())
                                                <li>
                                                    <h4>Available Sizes</h4>
                                                    <span>{{ $product->sizes->pluck('size')->join(', ') }}</span>
                                                </li>
                                            @endif
                                            <li>
                                                <h4>SKU</h4>
                                                <span>PRD-{{ str_pad($product->id_produk, 6, '0', STR_PAD_LEFT) }}</span>
                                            </li>
                                            @if ($product->categories->isNotEmpty())
                                                <li>
                                                    <h4>Category</h4>
                                                    <span>{{ $product->categories->first()->name }}</span>
                                                </li>
                                            @endif
                                            @if ($product->audiences->isNotEmpty())
                                                <li>
                                                    <h4>Audience</h4>
                                                    <span>{{ $product->audiences->pluck('name')->join(', ') }}</span>
                                                </li>
                                            @endif
                                            <li>
                                                <h4>Brand</h4>
                                                <span>ZynHope Apparel</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Reviews Tab -->
                                <div class="tab-pane fade" id="nav-review" role="tabpanel"
                                    aria-labelledby="nav-review-tab">
                                    <div class="product__details-review">
                                        <h3 class="comments-title">Reviews for "{{ $product->name }}"</h3>
                                        <div class="latest-comments mb-50">
                                            <p class="text-center py-4">No reviews yet. Be the first to review!</p>
                                        </div>
                                        <div class="product__details-comment section-space-medium-bottom">
                                            <div class="comment-title mb-20">
                                                <h3>Add a review</h3>
                                                <p>Your email address will not be published. Required fields are marked *
                                                </p>
                                            </div>
                                            <div class="comment-rating mb-20">
                                                <span>Overall ratings</span>
                                                <ul>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fal fa-star"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="comment-input-box">
                                                <form action="#">
                                                    <div class="row">
                                                        <div class="col-xxl-12">
                                                            <div class="comment-input">
                                                                <textarea placeholder="Your review"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-6">
                                                            <div class="comment-input">
                                                                <input type="text" placeholder="Your Name*">
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-6">
                                                            <div class="comment-input">
                                                                <input type="email" placeholder="Your Email*">
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-12">
                                                            <div class="comment-submit">
                                                                <button type="submit" class="fill-btn">
                                                                    <span class="fill-btn-inner">
                                                                        <span class="fill-btn-normal">Submit Review</span>
                                                                        <span class="fill-btn-hover">Submit Review</span>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product details area end -->

    <!-- Related Products (Optional) -->
    @if ($relatedProducts->isNotEmpty())
        <section class="bd-product__area section-space-medium-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section__title-wrapper text-center mb-40">
                            <h2 class="section__title">Related Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="product-item">
                                @if ($relatedProduct->old_price && $relatedProduct->old_price > $relatedProduct->price)
                                    @php
                                        $discount = round(
                                            (($relatedProduct->old_price - $relatedProduct->price) /
                                                $relatedProduct->old_price) *
                                                100,
                                        );
                                    @endphp
                                    <div class="product-badge">
                                        <span class="product-trending">{{ $discount }}% off</span>
                                    </div>
                                @endif
                                <div class="product-thumb">
                                    <a href="{{ route('customer.product.detail', $relatedProduct->id_produk) }}">
                                        @if ($relatedProduct->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $relatedProduct->images->first()->image_url) }}"
                                                alt="{{ $relatedProduct->name }}">
                                        @else
                                            <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                alt="{{ $relatedProduct->name }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="product-content">
                                    <h4 class="product-title">
                                        <a
                                            href="{{ route('customer.product.detail', $relatedProduct->id_produk) }}">{{ $relatedProduct->name }}</a>
                                    </h4>
                                    <div class="product-price">
                                        @if ($relatedProduct->old_price && $relatedProduct->old_price > $relatedProduct->price)
                                            <span class="product-old-price"><del>Rp
                                                    {{ number_format($relatedProduct->old_price, 0, ',', '.') }}</del></span>
                                        @endif
                                        <span class="product-new-price">Rp
                                            {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@push('styles')
    <style>
        /* Color & Size Selector */
        .color-option input[type="radio"],
        .size-option input[type="radio"] {
            display: none;
        }

        .color-box {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #ddd;
            cursor: pointer;
            transition: all 0.3s;
        }

        .color-option input[type="radio"]:checked+.color-box {
            border-color: #000;
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px #000;
        }

        .size-box {
            display: inline-block;
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            min-width: 50px;
            text-align: center;
        }

        .size-option input[type="radio"]:checked+.size-box {
            background: #000;
            color: #fff;
            border-color: #000;
        }
    </style>
@endpush

@push('scripts')
    <script>
        console.log('Product Detail Script Loaded');

        $(document).ready(function() {
            console.log('jQuery Ready');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Quantity Controls
            $('.cart-minus').click(function(e) {
                e.preventDefault();
                let input = $('#quantity');
                let currentValue = parseInt(input.val());
                if (currentValue > 1) {
                    input.val(currentValue - 1);
                }
            });

            $('.cart-plus').click(function(e) {
                e.preventDefault();
                let input = $('#quantity');
                let currentValue = parseInt(input.val());
                input.val(currentValue + 1);
            });

            // Add to Cart
            $('#addToCartBtn').click(function() {
                console.log('Add to Cart Clicked');

                const productId = $(this).data('product');
                const quantity = parseInt($('#quantity').val());
                const selectedColor = $('input[name="color"]:checked').val();
                const selectedSize = $('input[name="size"]:checked').val();

                $(this).prop('disabled', true);

                $.ajax({
                    url: '{{ route('customer.cart.add') }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity,
                        color_id: selectedColor,
                        size_id: selectedSize
                    },
                    success: function(response) {
                        console.log('Success:', response);

                        if (response.success) {
                            // ✅ UPDATE CART BADGE DENGAN ID SPESIFIK
                            $('#cart-badge-count').text(response.cart_count);

                            alert(response.message);
                        }

                        $('#addToCartBtn').prop('disabled', false);
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);

                        let message = 'Failed to add to cart!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        alert(message);

                        $('#addToCartBtn').prop('disabled', false);
                    }
                });
            });

            // Add to Wishlist
            $('#addToWishlistBtn').click(function() {
                console.log('Add to Wishlist Clicked');

                const productId = $(this).data('product');

                $(this).prop('disabled', true);

                $.ajax({
                    url: '{{ route('customer.wishlist.add') }}',
                    method: 'POST',
                    data: {
                        product_id: productId
                    },
                    success: function(response) {
                        console.log('Success:', response);

                        if (response.success) {
                            // ✅ UPDATE WISHLIST BADGE DENGAN ID SPESIFIK
                            $('#wishlist-badge-count').text(response.wishlist_count);

                            // Change heart icon to filled
                            $('#addToWishlistBtn i').removeClass('fa-regular').addClass(
                                'fa-solid');

                            alert(response.message);
                        }

                        $('#addToWishlistBtn').prop('disabled', false);
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);

                        let message = 'Failed to add to wishlist!';
                        if (xhr.status === 409) {
                            message = 'Product already in wishlist!';
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        alert(message);

                        $('#addToWishlistBtn').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush
