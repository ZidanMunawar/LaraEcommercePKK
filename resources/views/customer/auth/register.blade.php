@extends('customer.layouts.app')

@section('title', 'Daftar - ZynHope Apparel')

@section('content')
    <!-- Breadcrumb area start -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Daftar</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><span>Daftar</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Breadcrumb area end -->

    <!-- Register area start -->
    <div class="register-area section-space" style="background: linear-gradient(to bottom, #fff, #f5f1ed); padding: 80px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="card border-0 shadow-lg"
                        style="border-radius: 20px; overflow: hidden; box-shadow: 0 10px 40px rgba(139, 111, 71, 0.2) !important;">
                        <div class="card-body p-0">
                            <!-- Header Card -->
                            <div class="text-center p-4"
                                style="background: linear-gradient(135deg, #A0826D, #8B6F47); color: white;">
                                <div
                                    style="width: 80px; height: 80px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; backdrop-filter: blur(10px);">
                                    <i class="bi bi-person-plus-fill" style="font-size: 48px; color: white;"></i>
                                </div>
                                <h3 style="font-weight: 700; margin-bottom: 8px; font-size: 26px;">Bergabung dengan ZynHope
                                </h3>
                                <p style="color: #f5f1ed; margin: 0; font-size: 14px;">Buat akun dan mulai berbelanja
                                    sekarang!</p>
                            </div>

                            <!-- Form Body -->
                            <div class="p-4" style="background: linear-gradient(to bottom, #fff, #f5f1ed);">
                                <!-- Alert Messages -->
                                @if (session('error'))
                                    <div class="alert alert-dismissible fade show mb-4"
                                        style="background: #fff5f5; border-left: 4px solid #dc3545; border-radius: 8px; padding: 15px;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-exclamation-triangle me-2"
                                                style="color: #dc3545; font-size: 20px;"></i>
                                            <div>
                                                <strong style="color: #dc3545;">Error!</strong>
                                                <span style="color: #666;">{{ session('error') }}</span>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            style="font-size: 12px;"></button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-dismissible fade show mb-4"
                                        style="background: #fff5f5; border-left: 4px solid #dc3545; border-radius: 8px; padding: 15px;">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-exclamation-triangle me-2"
                                                style="color: #dc3545; font-size: 20px;"></i>
                                            <div>
                                                <strong style="color: #dc3545;">Mohon perbaiki error berikut:</strong>
                                                <ul class="mb-0 mt-2" style="color: #666; font-size: 14px;">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            style="font-size: 12px;"></button>
                                    </div>
                                @endif

                                <!-- Register Form -->
                                <form action="{{ route('customer.register') }}" method="POST" id="registerForm">
                                    @csrf

                                    <!-- Personal Information -->
                                    <div class="mb-4" style="border-bottom: 2px solid #D4A574; padding-bottom: 10px;">
                                        <h5 style="color: #5a4a3a; font-weight: 700; font-size: 18px; margin: 0;">
                                            <i class="bi bi-person-circle me-2" style="color: #A0826D;"></i>Informasi
                                            Pribadi
                                        </h5>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                style="color: #8B6F47; font-weight: 600; font-size: 13px;">
                                                Nama Lengkap <span style="color: #dc3545;">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                                name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                                placeholder="Nama lengkap Anda" required
                                                style="border: 2px solid #D4A574; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;"
                                                onfocus="this.style.borderColor='#A0826D'; this.style.boxShadow='0 0 0 0.2rem rgba(160, 130, 109, 0.15)'"
                                                onblur="this.style.borderColor='#D4A574'; this.style.boxShadow='none'">
                                            @error('nama_lengkap')
                                                <div class="invalid-feedback" style="font-size: 12px;">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                style="color: #8B6F47; font-weight: 600; font-size: 13px;">
                                                Username <span style="color: #dc3545;">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('username') is-invalid @enderror" name="username"
                                                value="{{ old('username') }}" placeholder="Pilih username" required
                                                style="border: 2px solid #D4A574; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;"
                                                onfocus="this.style.borderColor='#A0826D'; this.style.boxShadow='0 0 0 0.2rem rgba(160, 130, 109, 0.15)'"
                                                onblur="this.style.borderColor='#D4A574'; this.style.boxShadow='none'">
                                            @error('username')
                                                <div class="invalid-feedback" style="font-size: 12px;">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                style="color: #8B6F47; font-weight: 600; font-size: 13px;">
                                                Email <span style="color: #dc3545;">*</span>
                                            </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" placeholder="email@example.com"
                                                required
                                                style="border: 2px solid #D4A574; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;"
                                                onfocus="this.style.borderColor='#A0826D'; this.style.boxShadow='0 0 0 0.2rem rgba(160, 130, 109, 0.15)'"
                                                onblur="this.style.borderColor='#D4A574'; this.style.boxShadow='none'">
                                            @error('email')
                                                <div class="invalid-feedback" style="font-size: 12px;">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                style="color: #8B6F47; font-weight: 600; font-size: 13px;">
                                                Nomor Telepon <span style="color: #dc3545;">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('no_telp') is-invalid @enderror" name="no_telp"
                                                value="{{ old('no_telp') }}" placeholder="08xxxxxxxxxx" required
                                                style="border: 2px solid #D4A574; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;"
                                                onfocus="this.style.borderColor='#A0826D'; this.style.boxShadow='0 0 0 0.2rem rgba(160, 130, 109, 0.15)'"
                                                onblur="this.style.borderColor='#D4A574'; this.style.boxShadow='none'">
                                            @error('no_telp')
                                                <div class="invalid-feedback" style="font-size: 12px;">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Address Information -->
                                    <div class="mb-4 mt-4"
                                        style="border-bottom: 2px solid #D4A574; padding-bottom: 10px;">
                                        <h5 style="color: #5a4a3a; font-weight: 700; font-size: 18px; margin: 0;">
                                            <i class="bi bi-geo-alt me-2" style="color: #A0826D;"></i>Informasi Alamat
                                        </h5>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label"
                                                style="color: #8B6F47; font-weight: 600; font-size: 13px;">
                                                Alamat Lengkap <span style="color: #dc3545;">*</span>
                                            </label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="2"
                                                placeholder="Jl. Merdeka No. 123, RT 01/RW 02" required
                                                style="border: 2px solid #D4A574; border-radius: 10px; padding: 12px 16px; font-size: 14px; resize: vertical; transition: all 0.3s;"
                                                onfocus="this.style.borderColor='#A0826D'; this.style.boxShadow='0 0 0 0.2rem rgba(160, 130, 109, 0.15)'"
                                                onblur="this.style.borderColor='#D4A574'; this.style.boxShadow='none'">{{ old('alamat') }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback" style="font-size: 12px;">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                style="color: #8B6F47; font-weight: 600; font-size: 13px;">
                                                Provinsi <span style="color: #dc3545;">*</span>
                                            </label>
                                            <select id="province"
                                                class="form-select @error('province_name') is-invalid @enderror" required
                                                style="border: 2px solid #D4A574; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;"
                                                onfocus="this.style.borderColor='#A0826D'; this.style.boxShadow='0 0 0 0.2rem rgba(160, 130, 109, 0.15)'"
                                                onblur="this.style.borderColor='#D4A574'; this.style.boxShadow='none'">
                                                <option value="">-- Pilih Provinsi --</option>
                                            </select>
                                            <input type="hidden" name="province_name" id="province_name"
                                                value="{{ old('province_name') }}">
                                            @error('province_name')
                                                <div class="invalid-feedback d-block" style="font-size: 12px;">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                style="color: #8B6F47; font-weight: 600; font-size: 13px;">
                                                Kota/Kabupaten <span style="color: #dc3545;">*</span>
                                            </label>
                                            <select id="regency"
                                                class="form-select @error('regency_name') is-invalid @enderror" required
                                                disabled
                                                style="border: 2px solid #D4A574; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;">
                                                <option value="">-- Pilih Provinsi Dulu --</option>
                                            </select>
                                            <input type="hidden" name="regency_name" id="regency_name"
                                                value="{{ old('regency_name') }}">
                                            @error('regency_name')
                                                <div class="invalid-feedback d-block" style="font-size: 12px;">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                style="color: #8B6F47; font-weight: 600; font-size: 13px;">
                                                Kecamatan <span style="color: #dc3545;">*</span>
                                            </label>
                                            <select id="district"
                                                class="form-select @error('district_name') is-invalid @enderror" required
                                                disabled
                                                style="border: 2px solid #D4A574; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;">
                                                <option value="">-- Pilih Kota Dulu --</option>
                                            </select>
                                            <input type="hidden" name="district_name" id="district_name"
                                                value="{{ old('district_name') }}">
                                            @error('district_name')
                                                <div class="invalid-feedback d-block" style="font-size: 12px;">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                style="color: #8B6F47; font-weight: 600; font-size: 13px;">
                                                Kelurahan <span style="color: #dc3545;">*</span>
                                            </label>
                                            <select id="village"
                                                class="form-select @error('village_name') is-invalid @enderror" required
                                                disabled
                                                style="border: 2px solid #D4A574; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;">
                                                <option value="">-- Pilih Kecamatan Dulu --</option>
                                            </select>
                                            <input type="hidden" name="village_name" id="village_name"
                                                value="{{ old('village_name') }}">
                                            @error('village_name')
                                                <div class="invalid-feedback d-block" style="font-size: 12px;">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                style="color: #8B6F47; font-weight: 600; font-size: 13px;">
                                                Kode Pos
                                            </label>
                                            <input type="text"
                                                class="form-control @error('postal_code') is-invalid @enderror"
                                                name="postal_code" value="{{ old('postal_code') }}" placeholder="12345"
                                                maxlength="10"
                                                style="border: 2px solid #D4A574; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;"
                                                onfocus="this.style.borderColor='#A0826D'; this.style.boxShadow='0 0 0 0.2rem rgba(160, 130, 109, 0.15)'"
                                                onblur="this.style.borderColor='#D4A574'; this.style.boxShadow='none'">
                                            @error('postal_code')
                                                <div class="invalid-feedback" style="font-size: 12px;">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Account Security -->
                                    <div class="mb-4 mt-4"
                                        style="border-bottom: 2px solid #D4A574; padding-bottom: 10px;">
                                        <h5 style="color: #5a4a3a; font-weight: 700; font-size: 18px; margin: 0;">
                                            <i class="bi bi-shield-lock me-2" style="color: #A0826D;"></i>Keamanan Akun
                                        </h5>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                style="color: #8B6F47; font-weight: 600; font-size: 13px;">
                                                Password <span style="color: #dc3545;">*</span>
                                            </label>
                                            <div class="position-relative">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password" placeholder="Minimal 6 karakter"
                                                    required
                                                    style="border: 2px solid #D4A574; border-radius: 10px; padding: 12px 48px 12px 16px; font-size: 14px; transition: all 0.3s;"
                                                    onfocus="this.style.borderColor='#A0826D'; this.style.boxShadow='0 0 0 0.2rem rgba(160, 130, 109, 0.15)'"
                                                    onblur="this.style.borderColor='#D4A574'; this.style.boxShadow='none'">
                                                <span class="password-toggle"
                                                    style="position: absolute; right: 18px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #A0826D; font-size: 18px;"
                                                    onclick="togglePassword('password', 'icon1')">
                                                    <i class="bi bi-eye" id="icon1"></i>
                                                </span>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback d-block" style="font-size: 12px;">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"
                                                style="color: #8B6F47; font-weight: 600; font-size: 13px;">
                                                Konfirmasi Password <span style="color: #dc3545;">*</span>
                                            </label>
                                            <div class="position-relative">
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation" placeholder="Ulangi password" required
                                                    style="border: 2px solid #D4A574; border-radius: 10px; padding: 12px 48px 12px 16px; font-size: 14px; transition: all 0.3s;"
                                                    onfocus="this.style.borderColor='#A0826D'; this.style.boxShadow='0 0 0 0.2rem rgba(160, 130, 109, 0.15)'"
                                                    onblur="this.style.borderColor='#D4A574'; this.style.boxShadow='none'">
                                                <span class="password-toggle"
                                                    style="position: absolute; right: 18px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #A0826D; font-size: 18px;"
                                                    onclick="togglePassword('password_confirmation', 'icon2')">
                                                    <i class="bi bi-eye" id="icon2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Terms -->
                                    <div class="mb-4 p-3"
                                        style="background: #f5f1ed; border-left: 4px solid #A0826D; border-radius: 8px;">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="terms" required
                                                style="border: 2px solid #D4A574; cursor: pointer;">
                                            <label class="form-check-label" for="terms"
                                                style="color: #666; font-size: 14px; cursor: pointer;">
                                                Saya setuju dengan <a href="#"
                                                    style="color: #A0826D; font-weight: 600; text-decoration: none;">Syarat
                                                    & Ketentuan</a> yang berlaku
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-grid mb-3">
                                        <button type="submit" class="btn btn-lg" id="submitBtn"
                                            style="background: linear-gradient(135deg, #A0826D, #8B6F47); color: white; border: none; border-radius: 10px; padding: 14px; font-weight: 700; font-size: 16px; box-shadow: 0 4px 15px rgba(160, 130, 109, 0.3); transition: all 0.3s;"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 25px rgba(160, 130, 109, 0.5)'"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(160, 130, 109, 0.3)'">
                                            <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                                        </button>
                                    </div>

                                    <!-- Login Link -->
                                    <div class="text-center">
                                        <p style="color: #666; font-size: 14px; margin: 0;">
                                            Sudah punya akun?
                                            <a href="{{ route('customer.login') }}"
                                                style="color: #A0826D; font-weight: 700; text-decoration: none; transition: color 0.3s;"
                                                onmouseover="this.style.color='#8B6F47'"
                                                onmouseout="this.style.color='#A0826D'">
                                                Masuk Di Sini
                                            </a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register area end -->
@endsection

@push('styles')
    <style>
        /* Form Check Custom */
        .form-check-input:checked {
            background-color: #A0826D;
            border-color: #A0826D;
        }

        .form-check-input:focus {
            border-color: #A0826D;
            box-shadow: 0 0 0 0.2rem rgba(160, 130, 109, 0.15);
        }

        /* Select Focus */
        .form-select:focus {
            border-color: #A0826D;
            box-shadow: 0 0 0 0.2rem rgba(160, 130, 109, 0.15);
        }

        /* Alert Animation */
        .alert {
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Password Toggle Hover */
        .password-toggle:hover {
            color: #8B6F47 !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .breadcrumb__title {
                font-size: 2rem !important;
            }

            .card-body .p-4 {
                padding: 1.5rem !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Password Toggle
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        // API Wilayah Indonesia
        $(document).ready(function() {
            const API_BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';

            // Load Provinces
            loadProvinces();

            function loadProvinces() {
                $('#province').html('<option value="">Loading...</option>');

                $.get(`${API_BASE}/provinces.json`, function(data) {
                    let options = '<option value="">-- Pilih Provinsi --</option>';
                    data.forEach(item => {
                        options +=
                            `<option value="${item.id}" data-name="${item.name}">${item.name}</option>`;
                    });
                    $('#province').html(options);

                    // Restore old value
                    const oldProvince = "{{ old('province_name') }}";
                    if (oldProvince) {
                        $('#province option').filter(function() {
                            return $(this).data('name') === oldProvince;
                        }).prop('selected', true);
                        $('#province').trigger('change');
                    }
                });
            }

            // Province Change
            $('#province').change(function() {
                const id = $(this).val();
                const name = $(this).find('option:selected').data('name');

                $('#province_name').val(name);
                $('#regency').prop('disabled', true).html('<option value="">Loading...</option>');
                $('#district').prop('disabled', true).html(
                    '<option value="">-- Pilih Kota Dulu --</option>');
                $('#village').prop('disabled', true).html(
                    '<option value="">-- Pilih Kecamatan Dulu --</option>');

                $('#regency_name, #district_name, #village_name').val('');

                if (id) {
                    $.get(`${API_BASE}/regencies/${id}.json`, function(data) {
                        let options = '<option value="">-- Pilih Kota/Kabupaten --</option>';
                        data.forEach(item => {
                            options +=
                                `<option value="${item.id}" data-name="${item.name}">${item.name}</option>`;
                        });
                        $('#regency').prop('disabled', false).html(options);

                        const oldRegency = "{{ old('regency_name') }}";
                        if (oldRegency) {
                            $('#regency option').filter(function() {
                                return $(this).data('name') === oldRegency;
                            }).prop('selected', true);
                            $('#regency').trigger('change');
                        }
                    });
                }
            });

            // Regency Change
            $('#regency').change(function() {
                const id = $(this).val();
                const name = $(this).find('option:selected').data('name');

                $('#regency_name').val(name);
                $('#district').prop('disabled', true).html('<option value="">Loading...</option>');
                $('#village').prop('disabled', true).html(
                    '<option value="">-- Pilih Kecamatan Dulu --</option>');

                $('#district_name, #village_name').val('');

                if (id) {
                    $.get(`${API_BASE}/districts/${id}.json`, function(data) {
                        let options = '<option value="">-- Pilih Kecamatan --</option>';
                        data.forEach(item => {
                            options +=
                                `<option value="${item.id}" data-name="${item.name}">${item.name}</option>`;
                        });
                        $('#district').prop('disabled', false).html(options);

                        const oldDistrict = "{{ old('district_name') }}";
                        if (oldDistrict) {
                            $('#district option').filter(function() {
                                return $(this).data('name') === oldDistrict;
                            }).prop('selected', true);
                            $('#district').trigger('change');
                        }
                    });
                }
            });

            // District Change
            $('#district').change(function() {
                const id = $(this).val();
                const name = $(this).find('option:selected').data('name');

                $('#district_name').val(name);
                $('#village').prop('disabled', true).html('<option value="">Loading...</option>');
                $('#village_name').val('');

                if (id) {
                    $.get(`${API_BASE}/villages/${id}.json`, function(data) {
                        let options = '<option value="">-- Pilih Kelurahan --</option>';
                        data.forEach(item => {
                            options += `<option value="${item.name}">${item.name}</option>`;
                        });
                        $('#village').prop('disabled', false).html(options);

                        const oldVillage = "{{ old('village_name') }}";
                        if (oldVillage) {
                            $('#village').val(oldVillage);
                        }
                    });
                }
            });

            // Village Change
            $('#village').change(function() {
                $('#village_name').val($(this).val());
            });

            // Form Submit Validation
            $('#registerForm').submit(function(e) {
                if (!$('#province_name').val() || !$('#regency_name').val() || !$('#district_name').val() ||
                    !$('#village_name').val()) {
                    e.preventDefault();
                    alert('⚠️ Mohon lengkapi alamat (Provinsi, Kota/Kabupaten, Kecamatan, dan Kelurahan)');
                    return false;
                }

                $('#submitBtn').prop('disabled', true).html(
                    '<i class="bi bi-hourglass-split me-2"></i>Mendaftarkan...');
            });

            // Auto hide alerts
            setTimeout(() => {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@endpush
