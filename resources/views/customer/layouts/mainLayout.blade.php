<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Home || Clothing')</title>
    <meta name="description" content="@yield('description', 'Clothing – eCommerce Fashion Template')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('assets-customers/images/icons/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets-customers/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customers/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customers/css/shortcode/shortcodes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customers/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customers/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customers/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-customers/css/color/skin-default.css') }}">
    <script src="{{ asset('assets-customers/js/vendor/modernizr-3.11.2.min.js') }}"></script>
    @stack('styles')
</head>

<body>
    <div class="wrapper home-one">
        @include('customer.partials.header')
        @yield('content')
        @include('customer.partials.footer')
    </div>
    <script src="{{ asset('assets-customers/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets-customers/js/vendor/jquery-migrate-3.3.2.min.js') }}"></script>
    <script src="{{ asset('assets-customers/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets-customers/js/slider/jquery.nivo.slider.pack.js') }}"></script>
    <script src="{{ asset('assets-customers/js/slider/nivo-active.js') }}"></script>
    <script src="{{ asset('assets-customers/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets-customers/js/plugins.js') }}"></script>
    <script src="{{ asset('assets-customers/js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>
