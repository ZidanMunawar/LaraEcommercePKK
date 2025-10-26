@extends('customer.layouts.app')

@section('title', 'Home - ZynHope Apparel')

@section('content')
    <!-- Hero Section Placeholder -->
    <div class="hero-area"
        style="min-height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
        <div class="container text-center text-white">
            <h1 class="display-3 mb-4">Welcome to ZynHope Apparel</h1>
            <p class="lead mb-4">Your Fashion Destination</p>
            <a href="{{ route('customer.products') }}" class="btn btn-light btn-lg">Shop Now</a>
        </div>
    </div>

    <!-- Content Coming Soon -->
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center">
                <h2>🚧 Page Under Construction 🚧</h2>
                <p class="lead">We're working hard to bring you an amazing shopping experience!</p>
            </div>
        </div>
    </div>
@endsection
