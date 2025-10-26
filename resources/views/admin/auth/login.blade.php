<!doctype html>
<html lang="en" class="light-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <title>Login Admin - ZynHope</title>

    <style>
        .last-login-badge {
            background: #f0f0f0;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 38px;
            z-index: 10;
        }

        .position-relative-custom {
            position: relative;
        }

        /* Custom alert styles */
        .alert {
            border-radius: 8px;
            padding: 12px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideDown 0.3s ease-out;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c2c7;
            color: #842029;
        }

        .alert-success {
            background-color: #d1e7dd;
            border: 1px solid #badbcc;
            color: #0f5132;
        }

        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffecb5;
            color: #664d03;
        }

        .alert ion-icon {
            font-size: 22px;
            margin-right: 10px;
        }

        .alert-content {
            display: flex;
            align-items: center;
            flex: 1;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-close {
            background: transparent;
            border: none;
            font-size: 20px;
            opacity: 0.5;
            cursor: pointer;
            padding: 0;
            margin-left: 10px;
        }

        .btn-close:hover {
            opacity: 1;
        }
    </style>
</head>

<body class="bg-white">
    <div class="wrapper">
        <div class="row g-0 m-0">
            <div class="col-xl-6 col-lg-12">
                <div class="login-cover-wrapper">
                    <div class="card shadow-none">
                        <div class="card-body">
                            <div class="text-center">
                                <h4>Sign In</h4>
                                <p>Sign In to your admin account</p>
                            </div>

                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <div class="alert-content">
                                        <ion-icon name="alert-circle"></ion-icon>
                                        <span>{{ $errors->first() }}</span>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                                        <ion-icon name="close"></ion-icon>
                                    </button>
                                </div>
                            @endif

                            <!-- Success Messages -->
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    <div class="alert-content">
                                        <ion-icon name="checkmark-circle"></ion-icon>
                                        <span>{{ session('success') }}</span>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                                        <ion-icon name="close"></ion-icon>
                                    </button>
                                </div>
                            @endif

                            <!-- Warning Messages -->
                            @if (session('warning'))
                                <div class="alert alert-warning alert-dismissible fade show">
                                    <div class="alert-content">
                                        <ion-icon name="warning"></ion-icon>
                                        <span>{{ session('warning') }}</span>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                                        <ion-icon name="close"></ion-icon>
                                    </button>
                                </div>
                            @endif

                            <!-- Last Logged In User -->
                            @if (isset($lastEmail))
                                <div class="last-login-badge">
                                    <div>
                                        <small class="text-muted d-block mb-1">Last logged in:</small>
                                        <strong>{{ $lastEmail }}</strong>
                                    </div>
                                    <form action="{{ route('admin.clear.last.login') }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0"
                                            title="Login as different user">
                                            <ion-icon name="close-circle" style="font-size: 20px;"></ion-icon>
                                        </button>
                                    </form>
                                </div>
                            @endif

                            <form class="form-body row g-3" method="POST" action="{{ route('admin.login') }}">
                                @csrf
                                <div class="col-12">
                                    <label for="inputEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="inputEmail" name="email" value="{{ old('email', $lastEmail ?? '') }}"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 position-relative-custom">
                                    <label for="inputPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="inputPassword" name="password" required>
                                    <span class="password-toggle" onclick="togglePassword()">
                                        <ion-icon name="eye-outline" id="toggleIcon"
                                            style="font-size: 20px;"></ion-icon>
                                    </span>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                            id="flexSwitchCheckRemember" {{ isset($lastEmail) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexSwitchCheckRemember">
                                            Remember Me (15 days)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Sign In</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-12">
                <div class="position-fixed top-0 h-100 d-xl-block d-none login-cover-img"></div>
            </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('inputPassword');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.setAttribute('name', 'eye-off-outline');
            } else {
                passwordInput.type = 'password';
                toggleIcon.setAttribute('name', 'eye-outline');
            }
        }

        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>

</html>
