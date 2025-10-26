@extends('customer.layouts.app')

@section('title', 'Shop - ZynHope Apparel')

@section('content')
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Shop</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Home</a></li>
                                    <li><span>Shop</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product area start -->
    <section class="bd-product__area section-space">
        <div class="container">
            <div class="row">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                    <div class="bd-product__result mb-30">
                        <h4>{{ $products->total() }} Items On List</h4>
                    </div>
                </div>
                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-6">
                    <div
                        class="product__filter-wrapper d-flex flex-wrap gap-3 align-items-center justify-content-md-end mb-30">
                        <div class="product__filter-count d-flex align-items-center">
                            <form method="GET" action="{{ route('customer.products') }}" class="d-flex gap-2">
                                <!-- Keep existing filters -->
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="category" value="{{ request('category') }}">
                                <input type="hidden" name="audience" value="{{ request('audience') }}">

                                <div class="btn-dropdown__options">
                                    <select name="show" onchange="this.form.submit()">
                                        <option value="12" {{ request('show') == 12 ? 'selected' : '' }}>Show 12
                                        </option>
                                        <option value="24" {{ request('show') == 24 ? 'selected' : '' }}>Show 24
                                        </option>
                                        <option value="36" {{ request('show') == 36 ? 'selected' : '' }}>Show 36
                                        </option>
                                        <option value="48" {{ request('show') == 48 ? 'selected' : '' }}>Show 48
                                        </option>
                                    </select>
                                </div>
                                <div class="btn-dropdown__options">
                                    <select name="sort" onchange="this.form.submit()">
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest
                                        </option>
                                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                            Price: Low to High</option>
                                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                            Price: High to Low</option>
                                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z
                                        </option>
                                    </select>
                                </div>
                            </form>
                            <div class="bd-product__filter-style nav nav-tabs" role="tablist">
                                <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-grid" type="button" role="tab" aria-selected="true">
                                    <i class="fa-solid fa-grid"></i>
                                </button>
                                <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab" data-bs-target="#nav-list"
                                    type="button" role="tab" aria-selected="false">
                                    <i class="fa-solid fa-bars"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-12">
                    <div class="product__filter-tab">
                        <div class="tab-content" id="nav-tabContent">
                            <!-- Grid View -->
                            <div class="tab-pane fade active show" id="nav-grid" role="tabpanel"
                                aria-labelledby="nav-grid-tab">
                                <div class="row g-5">
                                    @forelse($products as $product)
                                        <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                            <div class="product-item">
                                                @if ($product->old_price && $product->old_price > $product->price)
                                                    @php
                                                        $discount = round(
                                                            (($product->old_price - $product->price) /
                                                                $product->old_price) *
                                                                100,
                                                        );
                                                    @endphp
                                                    <div class="product-badge">
                                                        <span class="product-trending">{{ $discount }}% off</span>
                                                    </div>
                                                @elseif($product->is_new)
                                                    <div class="product-badge">
                                                        <span class="product-hot">NEW</span>
                                                    </div>
                                                @endif

                                                <div class="product-thumb">
                                                    <a href="{{ route('customer.product.detail', $product->id_produk) }}">
                                                        @if ($product->images->isNotEmpty())
                                                            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}"
                                                                alt="{{ $product->name }}">
                                                        @else
                                                            <img src="{{ asset('assets-customer/imgs/product/default.png') }}"
                                                                alt="{{ $product->name }}">
                                                        @endif
                                                    </a>
                                                </div>

                                                <div class="product-action-item">
                                                    @auth('customer')
                                                        <button type="button" class="product-action-btn add-to-cart"
                                                            data-product="{{ $product->id_produk }}">
                                                            <svg width="20" height="22" viewBox="0 0 20 22"
                                                                fill="none">
                                                                <path
                                                                    d="M13.0768 10.1416C13.0768 11.9228 11.648 13.3666 9.88542 13.3666C8.1228 13.3666 6.69401 11.9228 6.69401 10.1416M1.375 5.84163H18.3958M1.375 5.84163V12.2916C1.375 19.1359 2.57494 20.3541 9.88542 20.3541C17.1959 20.3541 18.3958 19.1359 18.3958 12.2916V5.84163M1.375 5.84163L2.91454 2.73011C3.27495 2.00173 4.01165 1.54163 4.81754 1.54163H14.9533C15.7592 1.54163 16.4959 2.00173 16.8563 2.73011L18.3958 5.84163"
                                                                    stroke="white" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                            <span class="product-tooltip">Add to Cart</span>
                                                        </button>
                                                    @else
                                                        <a href="{{ route('customer.login') }}" class="product-action-btn">
                                                            <svg width="20" height="22" viewBox="0 0 20 22"
                                                                fill="none">
                                                                <path
                                                                    d="M13.0768 10.1416C13.0768 11.9228 11.648 13.3666 9.88542 13.3666C8.1228 13.3666 6.69401 11.9228 6.69401 10.1416M1.375 5.84163H18.3958M1.375 5.84163V12.2916C1.375 19.1359 2.57494 20.3541 9.88542 20.3541C17.1959 20.3541 18.3958 19.1359 18.3958 12.2916V5.84163M1.375 5.84163L2.91454 2.73011C3.27495 2.00173 4.01165 1.54163 4.81754 1.54163H14.9533C15.7592 1.54163 16.4959 2.00173 16.8563 2.73011L18.3958 5.84163"
                                                                    stroke="white" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                            <span class="product-tooltip">Login to Add Cart</span>
                                                        </a>
                                                    @endauth

                                                    <a href="{{ route('customer.product.detail', $product->id_produk) }}"
                                                        class="product-action-btn">
                                                        <svg width="26" height="18" viewBox="0 0 26 18"
                                                            fill="none">
                                                            <path
                                                                d="M13.092 4.55026C10.5878 4.55026 8.55683 6.58125 8.55683 9.08541C8.55683 11.5896 10.5878 13.6206 13.092 13.6206C15.5961 13.6206 17.6271 11.5903 17.6271 9.08541C17.6271 6.5805 15.5969 4.55026 13.092 4.55026Z..."
                                                                fill="white" />
                                                        </svg>
                                                        <span class="product-tooltip">View Details</span>
                                                    </a>

                                                    @auth('customer')
                                                        <button type="button" class="product-action-btn add-to-wishlist"
                                                            data-product="{{ $product->id_produk }}">
                                                            <svg width="21" height="20" viewBox="0 0 21 20"
                                                                fill="none">
                                                                <path
                                                                    d="M19.2041 2.63262C18.6402 1.97669 17.932 1.44916 17.1305 1.08804..."
                                                                    fill="white" />
                                                            </svg>
                                                            <span class="product-tooltip">Add To Wishlist</span>
                                                        </button>
                                                    @else
                                                        <a href="{{ route('customer.login') }}" class="product-action-btn">
                                                            <svg width="21" height="20" viewBox="0 0 21 20"
                                                                fill="none">
                                                                <path
                                                                    d="M19.2041 2.63262C18.6402 1.97669 17.932 1.44916 17.1305 1.08804..."
                                                                    fill="white" />
                                                            </svg>
                                                            <span class="product-tooltip">Login to Wishlist</span>
                                                        </a>
                                                    @endauth
                                                </div>

                                                <div class="product-content">
                                                    <div class="product-tag">
                                                        @if ($product->categories->isNotEmpty())
                                                            <span>{{ $product->categories->first()->name }}</span>
                                                        @endif
                                                    </div>
                                                    <h4 class="product-title">
                                                        <a
                                                            href="{{ route('customer.product.detail', $product->id_produk) }}">{{ $product->name }}</a>
                                                    </h4>
                                                    <div class="product-price">
                                                        @if ($product->old_price && $product->old_price > $product->price)
                                                            <span class="product-old-price"><del>Rp
                                                                    {{ number_format($product->old_price, 0, ',', '.') }}</del></span>
                                                        @endif
                                                        <span class="product-new-price">Rp
                                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center py-5">
                                            <h4>No products found</h4>
                                            <p>Try adjusting your filters or search terms</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- List View (sama seperti grid, nanti bisa customize) -->
                            <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                                <div class="row g-5">
                                    @forelse($products as $product)
                                        <!-- Copy dari grid view, nanti customize kalau perlu -->
                                        <div class="col-xxl-4 col-xl-4 col-md-6 col-sm-6">
                                            <!-- Same content as grid -->
                                        </div>
                                    @empty
                                        <div class="col-12 text-center py-5">
                                            <h4>No products found</h4>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if ($products->hasPages())
                <div class="row">
                    <div class="bd-basic__pagination mt-50 d-flex align-items-center justify-content-center">
                        <nav>
                            <ul>
                                {{-- Previous Page Link --}}
                                @if ($products->onFirstPage())
                                    <li class="disabled"><span>«</span></li>
                                @else
                                    <li><a href="{{ $products->previousPageUrl() }}">«</a></li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li><span class="current">{{ $page }}</span></li>
                                    @else
                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($products->hasMorePages())
                                    <li><a href="{{ $products->nextPageUrl() }}">»</a></li>
                                @else
                                    <li class="disabled"><span>»</span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Product area end -->
@endsection
