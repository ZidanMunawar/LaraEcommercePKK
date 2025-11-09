<!doctype html>
<html class="no-js" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'ZynHope - T-Shirt')</title>
    <meta name="description" content="@yield('meta_description', 'ZynHope Apparel - Destinasi T-shirt anda')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets-customer/imgs/favicon.png') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets-customer/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customer/css/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customer/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customer/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customer/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customer/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customer/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customer/css/main.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    {{-- <!-- PACE Loading -->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" /> --}}

    @stack('styles')
</head>

<body>

    {{-- <!-- PACE Loading -->
    <div data-role="page">
        <div data-role="header"></div>
    </div>

    <!-- Preloader -->
    <div id="preloader">
        <div class="bd-loader-inner">
            <div class="bd-loader">
                <span class="bd-loader-item"></span>
                <span class="bd-loader-item"></span>
                <span class="bd-loader-item"></span>
                <span class="bd-loader-item"></span>
                <span class="bd-loader-item"></span>
                <span class="bd-loader-item"></span>
                <span class="bd-loader-item"></span>
                <span class="bd-loader-item"></span>
            </div>
        </div>
    </div> --}}

    <!-- Back to Top Button with Bootstrap Icon (Inline) -->
    <button type="button" class="btn-back-to-top" id="backToTopBtn" title="Kembali ke Atas"
        style="position: fixed;
               bottom: 30px;
               right: 30px;
               width: 50px;
               height: 50px;
               border-radius: 50%;
               background: linear-gradient(135deg, #b4916c, #a67f55);
               border: none;
               box-shadow: 0 4px 15px rgba(0, 0, 0, 0.13);
               color: #fff;
               align-items: center;
               justify-content: center;
               display: none;
               z-index: 999;
               cursor: pointer;
               transition: all 0.3s ease;">
        <i class="bi bi-arrow-up-short" style="font-size: 28px; vertical-align: middle;"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopBtn = document.getElementById('backToTopBtn');

            // Show button saat scroll > 250px
            window.addEventListener('scroll', function() {
                if (window.scrollY > 250) {
                    backToTopBtn.style.display = 'flex';
                } else {
                    backToTopBtn.style.display = 'none';
                }
            });

            // Smooth scroll ke atas
            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Hover effect
            backToTopBtn.addEventListener('mouseenter', function() {
                this.style.background = 'linear-gradient(135deg, #a67f55, #b4916c)';
                this.style.transform = 'translateY(-5px) scale(1.1)';
            });

            backToTopBtn.addEventListener('mouseleave', function() {
                this.style.background = 'linear-gradient(135deg, #b4916c, #a67f55)';
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>


    <!-- Search Area -->
    <div class="df-search-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="df-search-form">
                        <div class="df-search-close text-center mb-20">
                            <button class="df-search-close-btn">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <form action="{{ route('customer.products') }}" method="GET">
                            <div class="df-search-input mb-10">
                                <input type="text" name="search" placeholder="Cari produk...">
                                <button type="submit"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="body-overlay"></div>

    <!-- Offcanvas Sidebar -->
    @include('customer.layouts.offcanvas')

    <!-- Header -->
    @include('customer.layouts.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('customer.layouts.footer')

    <!-- JS -->
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <script src="{{ asset('assets-customer/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets-customer/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets-customer/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets-customer/js/meanmenu.min.js') }}"></script>
    <script src="{{ asset('assets-customer/js/swiper.min.js') }}"></script>
    <script src="{{ asset('assets-customer/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets-customer/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets-customer/js/counterup.js') }}"></script>
    <script src="{{ asset('assets-customer/js/wow.js') }}"></script>
    <script src="{{ asset('assets-customer/js/ajax-form.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets-customer/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
