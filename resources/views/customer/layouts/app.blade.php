<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'ZynHope Apparel - Fashion Store')</title>
    <meta name="description" content="@yield('meta_description', 'ZynHope Apparel - Your Fashion Destination')">
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
    <link rel="stylesheet" href="{{ asset('assets-customer/css/fontawesome-pro.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customer/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customer/css/main.css') }}">

    @stack('styles')
</head>

<body>

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
    </div>

    <!-- Back to top -->
    <div class="backtotop-wrap cursor-pointer">
        <svg class="backtotop-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <!-- Search Area -->
    <div class="df-search-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="df-search-form">
                        <div class="df-search-close text-center mb-20">
                            <button class="df-search-close-btn df-search-close-btn"></button>
                        </div>
                        <form action="#">
                            <div class="df-search-input mb-10">
                                <input type="text" placeholder="Search for product...">
                                <button type="submit"><i class="flaticon-search-1"></i></button>
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
    <script src="{{ asset('assets/js/jQuery 3.5.1.min.js') }}"></script>
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
    <script src="{{ asset('assets-customer/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
