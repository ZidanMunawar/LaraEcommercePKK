<header>
    <div class="header">
        <!-- Top Header -->
        <div class="header-top-area grocery__top-header">
            <div class="header-layout-4">
                <div class="header-to-main d-flex align-items-center justify-content-between">
                    <div class="link-text">
                        <span><i class="bi bi-telephone-fill text-white me-2"></i></span>
                        <a href="tel:+6283865941815" class="text-white">+62 838 6594 1815</a>
                    </div>

                    <div class="header-top-notice d-none d-md-block">
                        <p>DISKON <span class="text-white">Rp 15.000</span> GUNAKAN KODE "ZYNHOPE2024"</p>
                    </div>

                    <div class="tp-header-top-menu d-flex align-items-center justify-content-end">
                        @guest('customer')
                            <div class="header-lang-item">
                                <a href="{{ route('customer.login') }}" class="text-white">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> <span
                                        class="d-none d-sm-inline">Masuk</span>
                                </a>
                            </div>
                            <div class="header-lang-item">
                                <a href="{{ route('customer.register') }}" class="text-white">
                                    <i class="bi bi-person-plus me-1"></i> <span class="d-none d-sm-inline">Daftar</span>
                                </a>
                            </div>
                        @else
                            <div class="header-lang-item">
                                <div style="position: relative; display: inline-block;">
                                    <button type="button" id="profileBtn"
                                        style="background: none; border: none; color: white; cursor: pointer; font-size: 16px; padding: 0;"
                                        onclick="toggleProfileMenu()">
                                        <i class="bi bi-person-circle me-2"></i>
                                        <span
                                            class="d-none d-sm-inline">{{ Str::limit(Auth::guard('customer')->user()->nama_lengkap, 20) }}</span>
                                        <i class="bi bi-caret-down-fill ms-2"></i>
                                    </button>

                                    <div id="profileMenu"
                                        style="position: absolute; top: 100%; right: 0; background: white; border: 1px solid #e9ecef; border-radius: 8px; min-width: 240px; box-shadow: 0 5px 20px rgba(0,0,0,0.15); z-index: 1000; display: none; margin-top: 10px;">
                                        <a href="{{ route('customer.profile') }}"
                                            style="display: flex; align-items: center; padding: 12px 20px; color: #333; text-decoration: none; border-bottom: 1px solid #f1f3f5; transition: all 0.2s;"
                                            onmouseover="this.style.backgroundColor='#f8f9fa'"
                                            onmouseout="this.style.backgroundColor='transparent'">
                                            <i class="bi bi-person me-2 text-primary"></i>
                                            <span>Profil Saya</span>
                                        </a>
                                        <a href="{{ route('customer.orders') }}"
                                            style="display: flex; align-items: center; padding: 12px 20px; color: #333; text-decoration: none; border-bottom: 1px solid #f1f3f5; transition: all 0.2s;"
                                            onmouseover="this.style.backgroundColor='#f8f9fa'"
                                            onmouseout="this.style.backgroundColor='transparent'">
                                            <i class="bi bi-bag me-2 text-success"></i>
                                            <span>Pesanan Saya</span>
                                        </a>
                                        <a href="{{ route('customer.wishlist') }}"
                                            style="display: flex; align-items: center; padding: 12px 20px; color: #333; text-decoration: none; border-bottom: 1px solid #f1f3f5; transition: all 0.2s;"
                                            onmouseover="this.style.backgroundColor='#f8f9fa'"
                                            onmouseout="this.style.backgroundColor='transparent'">
                                            <i class="bi bi-heart me-2 text-danger"></i>
                                            <span>Wishlist</span>
                                        </a>
                                        <hr style="margin: 5px 0; border: none; border-top: 1px solid #e9ecef;">
                                        <form action="{{ route('customer.logout') }}" method="POST"
                                            style="display: block;">
                                            @csrf
                                            <button type="submit"
                                                style="width: 100%; text-align: left; background: none; border: none; padding: 12px 20px; color: #dc3545; cursor: pointer; display: flex; align-items: center; transition: all 0.2s;"
                                                onmouseover="this.style.backgroundColor='#f8f9fa'"
                                                onmouseout="this.style.backgroundColor='transparent'">
                                                <i class="bi bi-box-arrow-right me-2"></i>
                                                <span>Keluar</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
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
                    <div class="container-fluid">
                        <div class="header-main-4">
                            <div class="header-left">
                                <div class="header-logo">
                                    <a href="{{ route('customer.home') }}">
                                        <img src="{{ asset('assets/images/logo-icon-2.png') }}" class="logo-icon"
                                            alt="ZynHope Apparel" style="width: 100px; height: auto;">
                                    </a>
                                </div>

                                <div class="mean__menu-wrapper furniture__menu d-none d-lg-block">
                                    <div class="main-menu">
                                        <nav id="mobile-menu">
                                            <ul>
                                                <li><a href="{{ route('customer.home') }}"><i
                                                            class="bi bi-house-door me-1"></i> Beranda</a></li>
                                                <li><a href="{{ route('customer.about') }}"><i
                                                            class="bi bi-info-circle me-1"></i> Tentang</a></li>
                                                <li class="has-dropdown">
                                                    <a href="{{ route('customer.products') }}"><i
                                                            class="bi bi-shop me-1"></i> Belanja</a>
                                                    <ul class="submenu">
                                                        <li><a href="{{ route('customer.products') }}"><i
                                                                    class="bi bi-grid me-2"></i> Semua Produk</a></li>
                                                        @auth('customer')
                                                            <li><a href="{{ route('customer.cart') }}"><i
                                                                        class="bi bi-cart me-2"></i> Keranjang Belanja</a>
                                                            </li>
                                                            <li><a href="{{ route('customer.wishlist') }}"><i
                                                                        class="bi bi-heart me-2"></i> Wishlist</a></li>
                                                            <li><a href="{{ route('customer.checkout') }}"><i
                                                                        class="bi bi-credit-card me-2"></i> Checkout</a>
                                                            </li>
                                                        @endauth
                                                    </ul>
                                                </li>
                                                <li class="has-dropdown">
                                                    <a href="#"><i class="bi bi-tags me-1"></i> Kategori</a>
                                                    <ul class="submenu">
                                                        @php
                                                            $categories = \App\Models\Category::orderBy(
                                                                'name',
                                                                'asc',
                                                            )->get();
                                                        @endphp
                                                        @forelse($categories as $category)
                                                            <li><a
                                                                    href="{{ route('customer.products', ['category' => $category->id]) }}"><i
                                                                        class="bi bi-tag me-2"></i>
                                                                    {{ $category->name }}</a></li>
                                                        @empty
                                                            <li><a href="#">Tidak ada kategori</a></li>
                                                        @endforelse
                                                    </ul>
                                                </li>
                                                <li><a href="{{ route('customer.contact') }}"><i
                                                            class="bi bi-envelope me-1"></i> Kontak</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>

                            <div class="header-right d-inline-flex align-items-center justify-content-end">
                                <div class="header-search d-none d-xxl-block">
                                    <form action="{{ route('customer.products') }}" method="GET">
                                        <input type="text" name="search" placeholder="Cari produk..."
                                            value="{{ request('search') }}">
                                        <button type="submit"><i class="bi bi-search"></i></button>
                                    </form>
                                </div>

                                <div class="header-action d-flex align-items-center ml-30">
                                    @auth('customer')
                                        <div class="header-action-item">
                                            <div class="header-action-item">
                                                <a href="{{ route('customer.chat.index') }}" class="header-action-btn"
                                                    title="Chat">
                                                    <i class="bi bi-chat-dots"></i>
                                                    <span id="chatUnreadBadge" class="header-action-badge"
                                                        style="display: none;">0</span>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="header-action-item">
                                            <a href="{{ route('customer.wishlist') }}" class="header-action-btn"
                                                title="Wishlist">
                                                <i class="bi bi-heart"></i>
                                                <span class="header-action-badge bg-furniture" id="wishlist-badge-count">
                                                    @php
                                                        $wishlistCount =
                                                            Auth::guard('customer')->user()->wishlist()->count() ?? 0;
                                                    @endphp
                                                    {{ $wishlistCount }}
                                                </span>
                                            </a>
                                        </div>

                                        <div class="header-action-item">
                                            <a href="{{ route('customer.cart') }}"
                                                class="header-action-btn cartmini-open-btn" title="Keranjang">
                                                <i class="bi bi-cart3"></i>
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
                                    @endauth
                                </div>

                                <div class="header-humbager ml-30">
                                    <a class="sidebar__toggle" href="javascript:void(0)">
                                        <div class="bar-icon-2"><span></span><span></span><span></span></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@push('styles')
    <style>
        /* Header Top Area - Mobile Friendly */
        .header-top-area {
            background-color: #333;
            padding: 8px 0;
            font-size: 14px;
        }

        .header-to-main {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            padding: 0 15px;
        }

        .link-text a {
            text-decoration: none;
            font-weight: 500;
            white-space: nowrap;
        }

        .header-top-notice p {
            margin: 0;
            font-size: 13px;
            color: #ddd;
            text-align: center;
        }

        .header-top-notice .text-white {
            font-weight: bold;
        }

        .tp-header-top-menu {
            gap: 15px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .header-lang-item a {
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
            white-space: nowrap;
            display: flex;
            align-items: center;
        }

        .header-lang-item a:hover {
            opacity: 0.8;
        }

        /* Main Header - Sticky Fix */
        #header-sticky {
            position: sticky;
            top: 0;
            z-index: 999;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-main-4 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 15px;
        }

        .header-left {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .header-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex: 1;
        }

        /* Action Items */
        .header-action-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            min-width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            padding: 2px 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .bg-furniture {
            background-color: #ff6b6b;
        }

        .header-action-item {
            position: relative;
            margin-left: 15px;
        }

        .header-action-btn {
            position: relative;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
            font-size: 20px;
            color: #333;
            text-decoration: none;
        }

        .header-action-btn:hover {
            background-color: #f8f9fa;
            transform: scale(1.1);
        }

        /* Profile Menu */
        #profileBtn {
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        /* Hamburger Menu */
        .header-humbager {
            display: flex;
            align-items: center;
        }

        .bar-icon-2 {
            display: flex;
            flex-direction: column;
            width: 24px;
            height: 18px;
            cursor: pointer;
        }

        .bar-icon-2 span {
            display: block;
            height: 2px;
            width: 100%;
            background-color: #333;
            margin-bottom: 4px;
            transition: all 0.3s ease;
        }

        .bar-icon-2 span:last-child {
            margin-bottom: 0;
        }

        /* Responsive Adjustments */
        @media (max-width: 1199px) {
            .header-main-4 {
                padding: 8px 15px;
            }

            .header-action-item {
                margin-left: 12px;
            }

            .header-action-btn {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
        }

        @media (max-width: 991px) {
            .header-main-4 {
                padding: 5px 15px;
            }

            .header-action-item {
                margin-left: 10px;
            }

            .header-action-btn {
                width: 38px;
                height: 38px;
                font-size: 16px;
            }

            .header-humbager {
                margin-left: 15px !important;
            }
        }

        @media (max-width: 767px) {
            .header-top-area {
                padding: 6px 0;
                font-size: 12px;
            }

            .header-to-main {
                justify-content: space-between;
                padding: 0 10px;
            }

            .header-top-notice {
                display: none !important;
            }

            .header-main-4 {
                padding: 5px 10px;
            }

            .header-logo img {
                width: 80px !important;
            }

            .header-action-item {
                margin-left: 8px;
            }

            .header-action-btn {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }

            .header-action-badge {
                min-width: 18px;
                height: 18px;
                font-size: 10px;
                top: -6px;
                right: -6px;
            }

            .tp-header-top-menu {
                gap: 10px;
            }
        }

        @media (max-width: 575px) {
            .header-top-area {
                padding: 5px 0;
            }

            .header-to-main {
                padding: 0 8px;
                justify-content: center;
                gap: 15px;
            }

            .header-main-4 {
                padding: 3px 8px;
            }

            .header-action-item {
                margin-left: 5px;
            }

            .header-action-btn {
                width: 34px;
                height: 34px;
                font-size: 15px;
            }

            .tp-header-top-menu {
                gap: 8px;
            }
        }

        @media (max-width: 400px) {
            .link-text span {
                display: none;
            }

            .link-text a {
                font-size: 11px;
            }

            .header-lang-item a span {
                display: inline !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        /**
         * Simple Vanilla JS Dropdown Toggle
         */
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            if (menu) {
                menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
                console.log('✅ Profile menu toggled:', menu.style.display);
            }
        }

        // Close menu saat klik di luar
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('profileMenu');
            const btn = document.getElementById('profileBtn');

            if (menu && btn) {
                if (!menu.contains(e.target) && !btn.contains(e.target)) {
                    menu.style.display = 'none';
                }
            }
        });

        // Close menu saat click item
        document.addEventListener('DOMContentLoaded', function() {
            const menu = document.getElementById('profileMenu');
            if (menu) {
                const links = menu.querySelectorAll('a');
                links.forEach(link => {
                    link.addEventListener('click', function() {
                        menu.style.display = 'none';
                    });
                });
            }
        });

        // Sticky header behavior
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header-sticky');
            if (header) {
                if (window.scrollY > 50) {
                    header.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
                } else {
                    header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                }
            }
        });
    </script>
@endpush
