@extends('admin.layouts.mainLayout')
@section('title', '403 - Access Denied')

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
                    <li class="breadcrumb-item active" aria-current="page">403 Access Denied</li>
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
                        <span class="text-warning">3</span>
                    </h1>
                    <h2 class="font-weight-bold display-4 mb-3">Access Denied</h2>
                    <p class="lead mb-4">
                        {{ $exception->getMessage() ?? 'You do not have permission to access this page.' }}
                    </p>
                    <p class="text-muted mb-4">
                        Your current role does not have the required permissions to view this content.
                        <br>Please contact your administrator if you believe this is an error.
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
                    <ion-icon name="shield-off" style="font-size: 300px; color: #e0e0e0;"></ion-icon>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
@endsection
