<header class="header-area header-wrapper">
    <div class="header-top-bar black-bg clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="login-register-area">
                        <ul>
                            {{-- <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <div class="social-search-area text-center">
                        <div class="social-icon socile-icon-style-2">
                            <ul>
                                <li><a href="#" title="facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" title="twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#" title="dribble"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#" title="behance"><i class="fa fa-behance"></i></a></li>
                                <li><a href="#" title="rss"><i class="fa fa-rss"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="cart-currency-area login-register-area text-end">
                        <ul>
                            <li>
                                <div class="header-currency">
                                    <select>
                                        <option value="1">USD</option>
                                        <option value="2">Pound</option>
                                        <option value="3">Euro</option>
                                        <option value="4">Dinar</option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <div class="header-cart">
                                    <div class="cart-icon">
                                        <a href="#">Cart<i class="zmdi zmdi-shopping-cart"></i></a>
                                        <span>2</span>
                                    </div>
                                    <div class="cart-content-wraper">
                                        <!-- Isi cart bisa di-generate dinamis nanti -->
                                        <div class="cart-subtotal"> Subtotal: <span>$200.00</span> </div>
                                        <div class="cart-check-btn">
                                            <div class="view-cart"><a class="btn-def" href="#">View
                                                    Cart</a></div>
                                            <div class="check-btn"><a class="btn-def" href="#">Checkout</a></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="sticky-header" class="header-middle-area">
        <div class="container">
            <div class="full-width-mega-dropdown">
                <div class="row">
                    <div class="col-md-2">
                        <div class="logo ptb-20">
                            <a href="#">
                                <img src="{{ asset('assets-customers/images/logo/logo.png') }}" alt="main logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-10 d-none d-md-block">
                        <nav id="primary-menu">
                            <ul class="main-menu">
                                <li class="#}}">
                                    <a class="#">Home</a>
                                </li>
                                <li><a href="#">Man</a></li>
                                <li><a href="#">Women</a></li>
                                <li><a href="#">Pages</a></li>
                                <li><a href="#">BLOG</a></li>
                                <li><a href="#">ABOUT</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-3 d-none d-lg-block">
                        <div class="search-box global-table">
                            <div class="global-row">
                                <div class="global-cell">
                                    <form action="#" method="GET">
                                        <div class="input-box">
                                            <input class="single-input" name="q" placeholder="Search anything"
                                                type="text">
                                            <button class="src-btn"><i class="fa fa-search"></i></button>
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

    <!-- Mobile Menu (opsional, bisa di-load via JS atau di-skip dulu) -->
    <div class="mobile-menu-area">
        <!-- ... (isi mobile menu jika diperlukan) ... -->
    </div>
</header>
