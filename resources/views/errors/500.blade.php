@extends('admin.layouts.mainLayout')
@section('title', '500 - Server Error')

@section('content')
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Error</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <ion-icon name="home-outline"></ion-icon>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">500 Server Error</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                <ion-icon name="home" class="align-middle me-1"></ion-icon>
                Go to Dashboard
            </a>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card radius-10">
        <div class="row g-0 align-items-center">
            <div class="col-12 col-xl-5">
                <div class="card-body p-5">
                    <h1 class="display-1">
                        <span class="text-danger">5</span>
                        <span class="text-warning">0</span>
                        <span class="text-danger">0</span>
                    </h1>
                    <h2 class="font-weight-bold display-4 mb-3">Server Error</h2>
                    <p class="lead mb-4">
                        Oops! Something went wrong on our end.
                    </p>
                    <p class="text-muted mb-4">
                        We're experiencing an internal server error. Our team has been notified and is working on it.
                        <br>Please try again later or contact support if the problem persists.
                    </p>
                    <div class="mt-5">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg px-md-5 radius-30">
                            <ion-icon name="home" class="align-middle me-2"></ion-icon>
                            Go Home
                        </a>
                        <a href="javascript:location.reload()" class="btn btn-outline-dark btn-lg ms-3 px-md-5 radius-30">
                            <ion-icon name="refresh" class="align-middle me-2"></ion-icon>
                            Retry
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-7">
                <div class="p-4 text-center">
                    <ion-icon name="warning" style="font-size: 300px; color: #ffc107;"></ion-icon>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
@endsection
