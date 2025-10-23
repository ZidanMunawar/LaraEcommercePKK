@extends('admin.layouts.mainLayout')
@section('title', 'Dashboard')
@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="text-center">
            <h1>Selamat datang, {{ auth('admin')->user()->nama_lengkap }}!</h1>
            <p class="lead">Anda login sebagai <strong>{{ ucfirst(auth('admin')->user()->role) }}</strong>.</p>
            <a href="{{ route('admin.logout') }}" class="btn btn-danger"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
@endsection
