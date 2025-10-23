@extends('admin.layouts.mainLayout')
@section('title', '404 - Page Not Found')

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
                    <li class="breadcrumb-item active" aria-current="page">404 Error</li>
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
                        <span class="text-danger">4</span>
                        <span class="text-primary">0</span>
                        <span class="text-success">4</span>
                    </h1>
                    <h2 class="font-weight-bold display-4 mb-3">Lost in Space</h2>
                    <p class="lead mb-4">
                        You have reached the edge of the universe.
                        <br>The page you requested could not be found.
                    </p>
                    <p class="text-muted mb-4">
                        Don't worry and return to the previous page or go to the dashboard.
                    </p>
                    <div class="mt-5">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg px-md-5 radius-30">
                            <ion-icon name="home" class="align-middle me-2"></ion-icon>
                            Go Home
                        </a>
                        <a href="javascript:history.back()" class="btn btn-outline-dark btn-lg ms-3 px-md-5 radius-30">
                            <ion-icon name="arrow-back" class="align-middle me-2"></ion-icon>
                            Back
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-7">
                <div class="p-4 text-center">
                    <ion-icon name="planet" style="font-size: 300px; color: #e0e0e0;"></ion-icon>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
@endsection
