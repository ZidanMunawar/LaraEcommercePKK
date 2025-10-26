@extends('customer.layouts.app')

@section('title', 'Register - ZynHope Apparel')

@section('content')
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Create Account</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Home</a></li>
                                    <li><span>Register</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="register-area section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="card shadow-sm">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <h3>Join ZynHope Apparel</h3>
                                <p class="text-muted">Create your account and start shopping</p>
                            </div>

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <strong>Error!</strong> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <strong>Please fix the following errors:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('customer.register') }}" method="POST" id="registerForm">
                                @csrf

                                <!-- Personal Information -->
                                <h5 class="mb-3 border-bottom pb-2">Personal Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('nama_lengkap') is-invalid @enderror"
                                            name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                            placeholder="Enter your full name" required>
                                        @error('nama_lengkap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            name="username" value="{{ old('username') }}" placeholder="Choose a username"
                                            required>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" placeholder="your@email.com"
                                            required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('no_telp') is-invalid @enderror"
                                            name="no_telp" value="{{ old('no_telp') }}" placeholder="08xxxxxxxxxx"
                                            required>
                                        @error('no_telp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Address Information -->
                                <h5 class="mb-3 mt-4 border-bottom pb-2">Address Information</h5>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Street Address <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="2"
                                            placeholder="Jl. Merdeka No. 123, RT 01/RW 02" required>{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Province <span class="text-danger">*</span></label>
                                        <select id="province"
                                            class="form-select @error('province_name') is-invalid @enderror" required>
                                            <option value="">-- Select Province --</option>
                                        </select>
                                        <!-- CUMA NAME AJA, HAPUS CODE -->
                                        <input type="hidden" name="province_name" id="province_name"
                                            value="{{ old('province_name') }}">
                                        @error('province_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">City/Regency <span class="text-danger">*</span></label>
                                        <select id="regency"
                                            class="form-select @error('regency_name') is-invalid @enderror" required
                                            disabled>
                                            <option value="">-- Select Province First --</option>
                                        </select>
                                        <input type="hidden" name="regency_name" id="regency_name"
                                            value="{{ old('regency_name') }}">
                                        @error('regency_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">District <span class="text-danger">*</span></label>
                                        <select id="district"
                                            class="form-select @error('district_name') is-invalid @enderror" required
                                            disabled>
                                            <option value="">-- Select City/Regency First --</option>
                                        </select>
                                        <input type="hidden" name="district_name" id="district_name"
                                            value="{{ old('district_name') }}">
                                        @error('district_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Village <span class="text-danger">*</span></label>
                                        <select id="village"
                                            class="form-select @error('village_name') is-invalid @enderror" required
                                            disabled>
                                            <option value="">-- Select District First --</option>
                                        </select>
                                        <input type="hidden" name="village_name" id="village_name"
                                            value="{{ old('village_name') }}">
                                        @error('village_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Postal Code</label>
                                        <input type="text"
                                            class="form-control @error('postal_code') is-invalid @enderror"
                                            name="postal_code" value="{{ old('postal_code') }}" placeholder="12345"
                                            maxlength="10">
                                        @error('postal_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Account Security -->
                                <h5 class="mb-3 mt-4 border-bottom pb-2">Account Security</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" placeholder="Min. 6 characters" required>
                                            <span class="position-absolute"
                                                style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;"
                                                onclick="togglePassword('password', 'icon1')">
                                                <i class="far fa-eye" id="icon1"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Confirm Password <span
                                                class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" placeholder="Re-enter password" required>
                                            <span class="position-absolute"
                                                style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;"
                                                onclick="togglePassword('password_confirmation', 'icon2')">
                                                <i class="far fa-eye" id="icon2"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#" class="text-primary">Terms & Conditions</a>
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                        <i class="far fa-user-plus me-2"></i> Create Account
                                    </button>
                                </div>

                                <div class="text-center">
                                    <p class="mb-0">Already have an account?
                                        <a href="{{ route('customer.login') }}" class="text-primary fw-bold">Login
                                            Here</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Password Toggle
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
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
                    let options = '<option value="">-- Select Province --</option>';
                    data.forEach(item => {
                        options += `<option value="${item.name}">${item.name}</option>`;
                    });
                    $('#province').html(options);

                    // Restore old value if validation fails
                    const oldProvince = "{{ old('province_name') }}";
                    if (oldProvince) {
                        $('#province').val(oldProvince);
                        $('#province').trigger('change');
                    }
                }).fail(function() {
                    $('#province').html('<option value="">Failed to load provinces</option>');
                });
            }

            // Province Change
            $('#province').change(function() {
                const name = $(this).val();

                $('#province_name').val(name);
                $('#regency').prop('disabled', true).html(
                    '<option value="">-- Select Province First --</option>');
                $('#district').prop('disabled', true).html(
                    '<option value="">-- Select City/Regency First --</option>');
                $('#village').prop('disabled', true).html(
                    '<option value="">-- Select District First --</option>');

                // Reset hidden inputs
                $('#regency_name').val('');
                $('#district_name').val('');
                $('#village_name').val('');

                if (name) {
                    // Find province id to load regencies
                    $.get(`${API_BASE}/provinces.json`, function(provinces) {
                        const province = provinces.find(p => p.name === name);
                        if (province) {
                            loadRegencies(province.id);
                        }
                    });
                }
            });

            function loadRegencies(provinceId) {
                $('#regency').prop('disabled', false).html('<option value="">Loading...</option>');

                $.get(`${API_BASE}/regencies/${provinceId}.json`, function(data) {
                    let options = '<option value="">-- Select City/Regency --</option>';
                    data.forEach(item => {
                        options += `<option value="${item.name}">${item.name}</option>`;
                    });
                    $('#regency').html(options);

                    // Restore old value
                    const oldRegency = "{{ old('regency_name') }}";
                    if (oldRegency) {
                        $('#regency').val(oldRegency);
                        $('#regency').trigger('change');
                    }
                });
            }

            // Regency Change
            $('#regency').change(function() {
                const name = $(this).val();

                $('#regency_name').val(name);
                $('#district').prop('disabled', true).html(
                    '<option value="">-- Select City/Regency First --</option>');
                $('#village').prop('disabled', true).html(
                    '<option value="">-- Select District First --</option>');

                // Reset hidden inputs
                $('#district_name').val('');
                $('#village_name').val('');

                if (name) {
                    // Find regency id to load districts
                    const provinceSelect = $('#province').val();
                    $.get(`${API_BASE}/provinces.json`, function(provinces) {
                        const province = provinces.find(p => p.name === provinceSelect);
                        if (province) {
                            $.get(`${API_BASE}/regencies/${province.id}.json`, function(regencies) {
                                const regency = regencies.find(r => r.name === name);
                                if (regency) {
                                    loadDistricts(regency.id);
                                }
                            });
                        }
                    });
                }
            });

            function loadDistricts(regencyId) {
                $('#district').prop('disabled', false).html('<option value="">Loading...</option>');

                $.get(`${API_BASE}/districts/${regencyId}.json`, function(data) {
                    let options = '<option value="">-- Select District --</option>';
                    data.forEach(item => {
                        options += `<option value="${item.name}">${item.name}</option>`;
                    });
                    $('#district').html(options);

                    // Restore old value
                    const oldDistrict = "{{ old('district_name') }}";
                    if (oldDistrict) {
                        $('#district').val(oldDistrict);
                        $('#district').trigger('change');
                    }
                });
            }

            // District Change
            $('#district').change(function() {
                const name = $(this).val();

                $('#district_name').val(name);
                $('#village').prop('disabled', true).html(
                    '<option value="">-- Select District First --</option>');

                // Reset hidden input
                $('#village_name').val('');

                if (name) {
                    // Find district id to load villages
                    const provinceSelect = $('#province').val();
                    const regencySelect = $('#regency').val();

                    $.get(`${API_BASE}/provinces.json`, function(provinces) {
                        const province = provinces.find(p => p.name === provinceSelect);
                        if (province) {
                            $.get(`${API_BASE}/regencies/${province.id}.json`, function(regencies) {
                                const regency = regencies.find(r => r.name ===
                                    regencySelect);
                                if (regency) {
                                    $.get(`${API_BASE}/districts/${regency.id}.json`,
                                        function(districts) {
                                            const district = districts.find(d => d
                                                .name === name);
                                            if (district) {
                                                loadVillages(district.id);
                                            }
                                        });
                                }
                            });
                        }
                    });
                }
            });

            function loadVillages(districtId) {
                $('#village').prop('disabled', false).html('<option value="">Loading...</option>');

                $.get(`${API_BASE}/villages/${districtId}.json`, function(data) {
                    let options = '<option value="">-- Select Village --</option>';
                    data.forEach(item => {
                        options += `<option value="${item.name}">${item.name}</option>`;
                    });
                    $('#village').html(options);

                    // Restore old value
                    const oldVillage = "{{ old('village_name') }}";
                    if (oldVillage) {
                        $('#village').val(oldVillage);
                    }
                });
            }

            // Village Change
            $('#village').change(function() {
                const name = $(this).val();
                $('#village_name').val(name);
            });

            // Form Submit Validation
            $('#registerForm').submit(function(e) {
                // Check if all location fields are filled
                if (!$('#province_name').val() || !$('#regency_name').val() ||
                    !$('#district_name').val() || !$('#village_name').val()) {
                    e.preventDefault();
                    alert('Please select complete address (Province, City/Regency, District, and Village)');
                    return false;
                }

                // Disable submit button to prevent double submit
                $('#submitBtn').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin me-2"></i> Creating Account...');
            });
        });
    </script>
@endpush
