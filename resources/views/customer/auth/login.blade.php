@extends('customer.layouts.app')

@section('title', 'Login - ZynHope Apparel')

@section('content')
    <!-- Breadcrumb area start -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Masuk</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><span>Masuk</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Breadcrumb area end -->

    <!-- Login area start -->
    <div class="login-area section-space" style="background: linear-gradient(to bottom, #fff, #f5f1ed); padding: 80px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="card border-0 shadow-lg"
                        style="border-radius: 20px; overflow: hidden; box-shadow: 0 10px 40px rgba(139, 111, 71, 0.2) !important;">
                        <div class="card-body p-0">
                            <!-- Header Card -->
                            <div class="text-center p-4"
                                style="background: linear-gradient(135deg, #A0826D, #8B6F47); color: white;">
                                <div
                                    style="width: 80px; height: 80px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; backdrop-filter: blur(10px);">
                                    <i class="bi bi-person-circle" style="font-size: 48px; color: white;"></i>
                                </div>
                                <h3 style="font-weight: 700; margin-bottom: 8px; font-size: 26px;">Selamat Datang Kembali!
                                </h3>
                                <p style="color: #f5f1ed; margin: 0; font-size: 14px;">Masuk ke akun ZynHope Anda</p>
                            </div>

                            <!-- Form Body -->
                            <div class="p-4" style="background: linear-gradient(to bottom, #fff, #f5f1ed);">
                                <!-- Alert Messages -->
                                @if ($errors->any())
                                    <div class="alert alert-dismissible fade show mb-3"
                                        style="background: #fff5f5; border-left: 4px solid #dc3545; border-radius: 8px; padding: 15px;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-exclamation-triangle me-2"
                                                style="color: #dc3545; font-size: 20px;"></i>
                                            <div>
                                                <strong style="color: #dc3545;">Oops!</strong>
                                                <span style="color: #666;">{{ $errors->first() }}</span>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            style="font-size: 12px;"></button>
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-dismissible fade show mb-3"
                                        style="background: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 8px; padding: 15px;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-check-circle me-2" style="color: #22c55e; font-size: 20px;"></i>
                                            <span style="color: #666;">{{ session('success') }}</span>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            style="font-size: 12px;"></button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-dismissible fade show mb-3"
                                        style="background: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 8px; padding: 15px;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-info-circle me-2" style="color: #f59e0b; font-size: 20px;"></i>
                                            <span style="color: #666;">{{ session('error') }}</span>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            style="font-size: 12px;"></button>
                                    </div>
                                @endif

                                <!-- Login Form -->
                                <form action="{{ route('customer.login') }}" method="POST">
                                    @csrf

                                    <!-- Email/Username -->
                                    <div class="mb-3">
                                        <label for="login" class="form-label"
                                            style="color: #8B6F47; font-weight: 600; font-size: 14px; margin-bottom: 8px;">
                                            <i class="bi bi-envelope me-2"></i>Email atau Username
                                        </label>
                                        <input type="text" class="form-control @error('login') is-invalid @enderror"
                                            id="login" name="login" value="{{ old('login') }}"
                                            placeholder="Masukkan email atau username" required
                                            style="border: 2px solid #D4A574; border-radius: 10px; padding: 14px 18px; font-size: 14px; transition: all 0.3s;"
                                            onfocus="this.style.borderColor='#A0826D'; this.style.boxShadow='0 0 0 0.2rem rgba(160, 130, 109, 0.15)'"
                                            onblur="this.style.borderColor='#D4A574'; this.style.boxShadow='none'">
                                        @error('login')
                                            <div class="invalid-feedback" style="font-size: 13px;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label"
                                            style="color: #8B6F47; font-weight: 600; font-size: 14px; margin-bottom: 8px;">
                                            <i class="bi bi-lock me-2"></i>Password
                                        </label>
                                        <div class="position-relative">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" id="password"
                                                name="password" placeholder="Masukkan password" required
                                                style="border: 2px solid #D4A574; border-radius: 10px; padding: 14px 48px 14px 18px; font-size: 14px; transition: all 0.3s;"
                                                onfocus="this.style.borderColor='#A0826D'; this.style.boxShadow='0 0 0 0.2rem rgba(160, 130, 109, 0.15)'"
                                                onblur="this.style.borderColor='#D4A574'; this.style.boxShadow='none'">
                                            <span class="password-toggle" onclick="togglePassword()"
                                                style="position: absolute; right: 18px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #A0826D; font-size: 18px;">
                                                <i class="bi bi-eye" id="toggleIcon"></i>
                                            </span>
                                            @error('password')
                                                <div class="invalid-feedback" style="font-size: 13px;">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Remember Me -->
                                    <div class="mb-4 d-flex align-items-center justify-content-between">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="remember" name="remember"
                                                style="border: 2px solid #D4A574; cursor: pointer;">
                                            <label class="form-check-label" for="remember"
                                                style="color: #666; font-size: 14px; cursor: pointer;">
                                                Ingat Saya
                                            </label>
                                        </div>
                                        <a href="#"
                                            style="color: #A0826D; text-decoration: none; font-size: 14px; font-weight: 600; transition: color 0.3s;"
                                            onmouseover="this.style.color='#8B6F47'"
                                            onmouseout="this.style.color='#A0826D'">
                                            Lupa Password?
                                        </a>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-grid mb-3">
                                        <button type="submit" class="btn btn-lg"
                                            style="background: linear-gradient(135deg, #A0826D, #8B6F47); color: white; border: none; border-radius: 10px; padding: 14px; font-weight: 700; font-size: 16px; box-shadow: 0 4px 15px rgba(160, 130, 109, 0.3); transition: all 0.3s;"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 25px rgba(160, 130, 109, 0.5)'"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(160, 130, 109, 0.3)'">
                                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
                                        </button>
                                    </div>

                                    <!-- Divider -->
                                    <div class="position-relative text-center mb-3">
                                        <hr style="border-color: #D4A574;">
                                        <span
                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 0 15px; color: #8B6F47; font-size: 13px; font-weight: 600;">
                                            ATAU
                                        </span>
                                    </div>

                                    <!-- Register Link -->
                                    <div class="text-center">
                                        <p style="color: #666; font-size: 14px; margin-bottom: 8px;">
                                            Belum punya akun?
                                        </p>
                                        <a href="{{ route('customer.register') }}" class="btn btn-outline-lg w-100"
                                            style="border: 2px solid #D4A574; color: #A0826D; border-radius: 10px; padding: 12px; font-weight: 700; font-size: 15px; background: transparent; transition: all 0.3s;"
                                            onmouseover="this.style.background='linear-gradient(135deg, #A0826D, #8B6F47)'; this.style.color='white'; this.style.borderColor='#A0826D'"
                                            onmouseout="this.style.background='transparent'; this.style.color='#A0826D'; this.style.borderColor='#D4A574'">
                                            <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="text-center mt-4">
                        <p style="color: #8B6F47; font-size: 13px;">
                            <i class="bi bi-shield-check me-2"></i>Data Anda aman dan terenkripsi
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login area end -->
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

        /* Focus Ring */
        .form-control:focus {
            border-color: #A0826D;
            box-shadow: 0 0 0 0.2rem rgba(160, 130, 109, 0.15);
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
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }

        // Auto hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
@endpush
