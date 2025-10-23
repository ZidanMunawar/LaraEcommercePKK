@extends('customer.layouts.mainLayout')

@section('title', 'Home || Clothing')

@section('content')
    <!-- Slider -->
    <div class="slider-area pos-rltv carosule-pagi cp-line">
        <div class="active-slider">
            <div class="single-slider pos-rltv">
                <div class="slider-img"><img src="{{ asset('assets-customers/images/slider/slider01.jpg') }}" alt="">
                </div>
                <div class="slider-content pos-abs">
                    <h4>Best Collection</h4>
                    <h1 class="uppercase pos-rltv underline">exclusive Fashion 2025</h1>
                    <a href="#" class="btn-def btn-white">Shop Now</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delivery Service -->
    <div class="delivery-service-area ptb-30">
        <div class="container">
            <div class="row">
                <!-- ... isi sesuai kebutuhan ... -->
            </div>
        </div>
    </div>

    <!-- Lanjutkan dengan section lain seperti New Arrival, Banner, dll -->
@endsection
