<header>
    <div class="header">
        <!-- Top Header -->
        <div class="header-top-area grocery__top-header">
            <div class="header-layout-4">
                <div class="header-to-main d-none d-sm-flex">
                    <div class="link-text">
                        <span><img src="{{ asset('assets-customer/imgs/icons/call.png') }}" alt=""></span>
                        <a href="tel:+628123456789">+62 812 3456 789</a>
                    </div>
                    <div class="header-top-notice d-none d-lg-block">
                        <p>FREE SHIPPING ON ORDERS OVER <span class="text-white">IDR 500K</span> USE CODE "ZYNHOPE2024"
                        </p>
                    </div>
                    <div class="tp-header-top-menu d-flex align-items-center justify-content-end">
                        @guest('customer')
                            <div class="header-lang-item">
                                <a href="{{ route('customer.login') }}" class="text-white">
                                    <i class="far fa-sign-in"></i> Login
                                </a>
                            </div>
                            <div class="header-lang-item">
                                <a href="{{ route('customer.register') }}" class="text-white">
                                    <i class="far fa-user-plus"></i> Register
                                </a>
                            </div>
                        @else
                            <div class="header-lang-item tp-header-setting">
                                <span class="header-setting-toggle text-white" id="header-setting-toggle">
                                    <i class="far fa-user"></i> {{ Auth::guard('customer')->user()->nama_lengkap }}
                                </span>
                                <ul>
                                    <li>
                                        <a class="furniture-clr-hover" href="{{ route('customer.profile') }}">
                                            <i class="far fa-user"></i> My Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="furniture-clr-hover" href="{{ route('customer.orders') }}">
                                            <i class="far fa-box"></i> My Orders
                                        </a>
                                    </li>
                                    <li>
                                        <a class="furniture-clr-hover" href="{{ route('customer.wishlist') }}">
                                            <i class="far fa-heart"></i> Wishlist
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('customer.logout') }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="furniture-clr-hover"
                                                style="border:none; background:none; cursor:pointer; padding: 0; width: 100%; text-align: left;">
                                                <i class="far fa-sign-out"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <div class="header-layout-4 header-bottom">
            <div id="header-sticky" class="header-4">
                <div class="mega-menu-wrapper">
                    <div class="header-main-4">
                        <div class="header-left">
                            <div class="header-logo">
                                <a href="{{ route('customer.home') }}">
                                    <img src="{{ asset('assets-customer/imgs/logo/zynhope-logo.svg') }}"
                                        alt="ZynHope Apparel">
                                </a>
                            </div>
                            <div class="mean__menu-wrapper furniture__menu d-none d-lg-block">
                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul>
                                            <li><a href="{{ route('customer.home') }}">Home</a></li>
                                            <li><a href="{{ route('customer.about') }}">About</a></li>
                                            <li class="has-dropdown">
                                                <a href="{{ route('customer.products') }}">Shop</a>
                                                <ul class="submenu">
                                                    <li><a href="{{ route('customer.products') }}">All Products</a>
                                                    </li>
                                                    @auth('customer')
                                                        <li><a href="{{ route('customer.cart') }}">Shopping Cart</a></li>
                                                        <li><a href="{{ route('customer.wishlist') }}">Wishlist</a></li>
                                                        <li><a href="{{ route('customer.checkout') }}">Checkout</a></li>
                                                    @endauth
                                                </ul>
                                            </li>
                                            <li><a href="{{ route('customer.contact') }}">Contact</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="header-right d-inline-flex align-items-center justify-content-end">
                            <div class="header-search d-none d-xxl-block">
                                <form action="{{ route('customer.products') }}" method="GET">
                                    <input type="text" name="search" placeholder="Search products...">
                                    <button type="submit">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                            <path d="M13.4443 13.4445L16.9999 17" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M15.2222 8.11111C15.2222 12.0385 12.0385 15.2222 8.11111 15.2222C4.18375 15.2222 1 12.0385 1 8.11111C1 4.18375 4.18375 1 8.11111 1C12.0385 1 15.2222 4.18375 15.2222 8.11111Z"
                                                stroke="white" stroke-width="2" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <div class="header-action d-flex align-items-center ml-30">
                                @auth('customer')
                                    <!-- Chat Icon (Hanya muncul kalau login) -->
                                    <div class="header-action-item">
                                        <a href="{{ route('customer.chat') }}" class="header-action-btn"
                                            title="Chat with Admin">
                                            <svg width="23" height="23" viewBox="0 0 23 23" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0034 9.87812 19.6951 8.7 19.1L2 21L3.9 14.3C3.30493 13.1219 2.99656 11.8199 3 10.5C3.00061 8.92179 3.44061 7.37488 4.27072 6.03258C5.10083 4.69028 6.28825 3.6056 7.7 2.90003C8.87812 2.30496 10.1801 1.99659 11.5 2.00003H12C14.0843 2.11502 16.053 2.99479 17.5291 4.47089C19.0052 5.94699 19.885 7.91568 20 10V11.5Z"
                                                    stroke="black" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            @php
                                                $unreadMessages = 0; // Nanti diganti dengan logic real dari database
                                            @endphp
                                            @if ($unreadMessages > 0)
                                                <span class="header-action-badge bg-furniture">{{ $unreadMessages }}</span>
                                            @endif
                                        </a>
                                    </div>

                                    <!-- Wishlist Icon -->
                                    <div class="header-action-item">
                                        <a href="{{ route('customer.wishlist') }}" class="header-action-btn"
                                            title="Wishlist">
                                            <svg width="23" height="21" viewBox="0 0 23 21" fill="none">
                                                <path d="M21.2743 2.33413C20.6448 1.60193..." fill="black" />
                                            </svg>
                                            <!-- ✅ TAMBAH ID UNIK -->
                                            <span class="header-action-badge bg-furniture" id="wishlist-badge-count">
                                                @php
                                                    $wishlistCount =
                                                        Auth::guard('customer')->user()->wishlist()->count() ?? 0;
                                                @endphp
                                                {{ $wishlistCount }}
                                            </span>
                                        </a>
                                    </div>

                                    <!-- Cart Icon -->
                                    <div class="header-action-item">
                                        <a href="{{ route('customer.cart') }}"
                                            class="header-action-btn cartmini-open-btn" title="Shopping Cart">
                                            <svg width="21" height="23" viewBox="0 0 21 23" fill="none">
                                                <path d="M14.0625 10.6C14.0625..." stroke="black" stroke-width="2" />
                                            </svg>
                                            <!-- ✅ TAMBAH ID UNIK -->
                                            <span class="header-action-badge bg-furniture" id="cart-badge-count">
                                                @php
                                                    $cartCount = 0;
                                                    $keranjang = Auth::guard('customer')->user()->keranjang;
                                                    if ($keranjang) {
                                                        $cartCount = $keranjang->items()->sum('qty') ?? 0;
                                                    }
                                                @endphp
                                                {{ $cartCount }}
                                            </span>
                                        </a>
                                    </div>
                                @else
                                    <!-- Guest User - Show Login Prompt -->
                                    <div class="header-action-item">
                                        <a href="{{ route('customer.login') }}" class="header-action-btn"
                                            title="Login to see wishlist">
                                            <svg width="23" height="21" viewBox="0 0 23 21" fill="none">
                                                <path
                                                    d="M21.2743 2.33413C20.6448 1.60193 19.8543 1.01306 18.9596 0.609951C18.0649 0.206838 17.0883 -0.0004864 16.1002 0.00291444C14.4096 -0.0462975 12.7637 0.529279 11.5011 1.61122C10.2385 0.529279 8.59252 -0.0462975 6.90191 0.00291444C5.91383 -0.0004864 4.93727 0.206838 4.04257 0.609951C3.14788 1.01306 2.35732 1.60193 1.72785 2.33413C0.632101 3.61193 -0.514239 5.92547 0.245772 9.69587C1.4588 15.7168 10.5548 20.6578 10.9388 20.8601C11.11 20.9518 11.3028 21 11.4988 21C11.6948 21 11.8875 20.9518 12.0587 20.8601C12.445 20.6534 21.541 15.7124 22.7518 9.69587C23.5164 5.92547 22.37 3.61193 21.2743 2.33413Z"
                                                    fill="black" />
                                            </svg>
                                            <span class="header-action-badge bg-furniture">0</span>
                                        </a>
                                    </div>
                                    <div class="header-action-item">
                                        <a href="{{ route('customer.login') }}"
                                            class="header-action-btn cartmini-open-btn" title="Login to see cart">
                                            <svg width="21" height="23" viewBox="0 0 21 23" fill="none">
                                                <path
                                                    d="M14.0625 10.6C14.0625 12.5883 12.4676 14.2 10.5 14.2C8.53243 14.2 6.9375 12.5883 6.9375 10.6M1 5.8H20M1 5.8V13C1 20.6402 2.33946 22 10.5 22C18.6605 22 20 20.6402 20 13V5.8M1 5.8L2.71856 2.32668C3.12087 1.5136 3.94324 1 4.84283 1H16.1571C17.0568 1 17.8791 1.5136 18.2814 2.32668L20 5.8"
                                                    stroke="black" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            <span class="header-action-badge bg-furniture">0</span>
                                        </a>
                                    </div>
                                @endauth
                            </div>
                            <div class="header-humbager ml-30">
                                <a class="sidebar__toggle" href="javascript:void(0)">
                                    <div class="bar-icon-2">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
