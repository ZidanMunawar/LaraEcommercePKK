<!doctype html>
<html lang="en" class="light-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- loader -->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>

    <!-- plugins -->
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />

    <!-- CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="{{ asset('assets/css/dark-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/semi-dark.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/header-colors.css') }}" rel="stylesheet" />

    <title>@yield('title', 'Dashboard') - ZynHope</title>
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Top Header -->
        @include('admin.partials.topbar')

        <!-- Page Content -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- Breadcrumb (opsional) -->
                @if (isset($breadcrumb))
                    @include('admin.partials.breadcrumb')
                @endif

                <!-- Konten Utama -->
                @yield('content')
            </div>
        </div>

        <!-- Back to Top & Switcher -->
        <a href="javascript:;" class="back-to-top"><ion-icon name="arrow-up-outline"></ion-icon></a>
        <div class="switcher-body">
            {{-- hm --}}
        </div>
        <div class="overlay nav-toggle-icon"></div>
    </div>
    @include('admin.modals.logout')
    <!-- JS Files -->
    @include('admin.partials.scripts')
    @stack('scripts')
</body>

</html>
