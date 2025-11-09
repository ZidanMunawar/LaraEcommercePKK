@extends('customer.layouts.app')

@section('title', 'Profil Saya - ZynHope Apparel')

@section('content')
    <!-- Breadcrumb area start -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Profil Saya</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><span>Profil Saya</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb area end -->

    <!-- Profile area start -->
    <div class="profile-area section-space" style="background: linear-gradient(to bottom, #fff, #f5f1ed); padding: 80px 0;">
        <div class="container">
            <div class="row">
                <!-- Sidebar Menu -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                        <div class="card-header text-center p-4"
                            style="background: linear-gradient(135deg, #A0826D, #8B6F47);">
                            <div class="avatar-container mb-3">
                                <div class="avatar-circle"
                                    style="width: 100px; height: 100px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; backdrop-filter: blur(10px);">
                                    <i class="bi bi-person-fill" style="font-size: 48px; color: white;"></i>
                                </div>
                            </div>
                            <h5 class="text-white mb-1">{{ $customer->nama_lengkap }}</h5>
                            <p class="text-light mb-0">{{ $customer->email }}</p>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <a href="#profile-info"
                                    class="list-group-item list-group-item-action active-profile-menu d-flex align-items-center py-3"
                                    style="border: none; background: transparent; color: #8B6F47; font-weight: 600; border-bottom: 1px solid #f0f0f0;">
                                    <i class="bi bi-person me-3" style="font-size: 18px;"></i>
                                    Informasi Profil
                                </a>
                                <a href="#change-password"
                                    class="list-group-item list-group-item-action d-flex align-items-center py-3"
                                    style="border: none; background: transparent; color: #666; border-bottom: 1px solid #f0f0f0;">
                                    <i class="bi bi-shield-lock me-3" style="font-size: 18px;"></i>
                                    Ubah Password
                                </a>
                                <a href="{{ route('customer.orders') }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center py-3"
                                    style="border: none; background: transparent; color: #666; border-bottom: 1px solid #f0f0f0;">
                                    <i class="bi bi-bag me-3" style="font-size: 18px;"></i>
                                    Pesanan Saya
                                </a>
                                <a href="{{ route('customer.wishlist') }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center py-3"
                                    style="border: none; background: transparent; color: #666;">
                                    <i class="bi bi-heart me-3" style="font-size: 18px;"></i>
                                    Wishlist
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4"
                            style="border-radius: 15px; border-left: 4px solid #22c55e;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2" style="color: #22c55e;"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4"
                            style="border-radius: 15px; border-left: 4px solid #dc3545;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2" style="color: #dc3545;"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Profile Information -->
                    <div id="profile-info" class="card border-0 shadow-lg mb-4" style="border-radius: 20px;">
                        <div class="card-header p-4" style="background: transparent; border-bottom: 2px solid #f0f0f0;">
                            <h4 class="mb-0" style="color: #8B6F47; font-weight: 700;">
                                <i class="bi bi-person-gear me-2"></i>Informasi Profil
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('customer.profile.update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" style="color: #8B6F47; font-weight: 600;">
                                            <i class="bi bi-person me-2"></i>Nama Lengkap
                                        </label>
                                        <input type="text"
                                            class="form-control @error('nama_lengkap') is-invalid @enderror"
                                            name="nama_lengkap" value="{{ old('nama_lengkap', $customer->nama_lengkap) }}"
                                            style="border: 2px solid #D4A574; border-radius: 12px; padding: 12px 16px;">
                                        @error('nama_lengkap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" style="color: #8B6F47; font-weight: 600;">
                                            <i class="bi bi-envelope me-2"></i>Email
                                        </label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email', $customer->email) }}"
                                            style="border: 2px solid #D4A574; border-radius: 12px; padding: 12px 16px;">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" style="color: #8B6F47; font-weight: 600;">
                                            <i class="bi bi-telephone me-2"></i>Nomor Telepon
                                        </label>
                                        <input type="text" class="form-control @error('no_telp') is-invalid @enderror"
                                            name="no_telp" value="{{ old('no_telp', $customer->no_telp) }}"
                                            style="border: 2px solid #D4A574; border-radius: 12px; padding: 12px 16px;">
                                        @error('no_telp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label" style="color: #8B6F47; font-weight: 600;">
                                            <i class="bi bi-geo-alt me-2"></i>Alamat Lengkap
                                        </label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="3"
                                            style="border: 2px solid #D4A574; border-radius: 12px; padding: 12px 16px; resize: none;">{{ old('alamat', $customer->alamat) }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Wilayah Dropdown -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"
                                            style="color: #8B6F47; font-weight: 600;">Provinsi</label>
                                        <select id="province" name="province_name" class="form-select"
                                            style="border: 2px solid #D4A574; border-radius: 12px; padding: 12px 16px;">
                                            <option value="">Pilih Provinsi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"
                                            style="color: #8B6F47; font-weight: 600;">Kota/Kabupaten</label>
                                        <select id="regency" name="regency_name" class="form-select"
                                            style="border: 2px solid #D4A574; border-radius: 12px; padding: 12px 16px;">
                                            <option value="">Pilih Kota/Kabupaten</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"
                                            style="color: #8B6F47; font-weight: 600;">Kecamatan</label>
                                        <select id="district" name="district_name" class="form-select"
                                            style="border: 2px solid #D4A574; border-radius: 12px; padding: 12px 16px;">
                                            <option value="">Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"
                                            style="color: #8B6F47; font-weight: 600;">Kelurahan</label>
                                        <select id="village" name="village_name" class="form-select"
                                            style="border: 2px solid #D4A574; border-radius: 12px; padding: 12px 16px;">
                                            <option value="">Pilih Kelurahan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" style="color: #8B6F47; font-weight: 600;">Kode
                                            Pos</label>
                                        <input type="text" class="form-control" name="postal_code"
                                            value="{{ old('postal_code', $customer->postal_code) }}"
                                            style="border: 2px solid #D4A574; border-radius: 12px; padding: 12px 16px;">
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary"
                                        style="background: linear-gradient(135deg, #A0826D, #8B6F47); border: none; border-radius: 12px; padding: 12px 30px; font-weight: 600;">
                                        <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div id="change-password" class="card border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="card-header p-4" style="background: transparent; border-bottom: 2px solid #f0f0f0;">
                            <h4 class="mb-0" style="color: #8B6F47; font-weight: 700;">
                                <i class="bi bi-shield-lock me-2"></i>Ubah Password
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('customer.profile.updatePassword') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label" style="color: #8B6F47; font-weight: 600;">
                                            <i class="bi bi-lock me-2"></i>Password Saat Ini
                                        </label>
                                        <div class="position-relative">
                                            <input type="password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                name="current_password" required
                                                style="border: 2px solid #D4A574; border-radius: 12px; padding: 12px 48px 12px 16px;">
                                            <span class="password-toggle" onclick="togglePassword(this)"
                                                style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #A0826D;">
                                                <i class="bi bi-eye"></i>
                                            </span>
                                        </div>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" style="color: #8B6F47; font-weight: 600;">
                                            <i class="bi bi-lock-fill me-2"></i>Password Baru
                                        </label>
                                        <div class="position-relative">
                                            <input type="password"
                                                class="form-control @error('new_password') is-invalid @enderror"
                                                name="new_password" required
                                                style="border: 2px solid #D4A574; border-radius: 12px; padding: 12px 48px 12px 16px;">
                                            <span class="password-toggle" onclick="togglePassword(this)"
                                                style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #A0826D;">
                                                <i class="bi bi-eye"></i>
                                            </span>
                                        </div>
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" style="color: #8B6F47; font-weight: 600;">
                                            <i class="bi bi-lock-fill me-2"></i>Konfirmasi Password Baru
                                        </label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" name="new_password_confirmation"
                                                required
                                                style="border: 2px solid #D4A574; border-radius: 12px; padding: 12px 48px 12px 16px;">
                                            <span class="password-toggle" onclick="togglePassword(this)"
                                                style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #A0826D;">
                                                <i class="bi bi-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary"
                                        style="background: linear-gradient(135deg, #A0826D, #8B6F47); border: none; border-radius: 12px; padding: 12px 30px; font-weight: 600;">
                                        <i class="bi bi-key me-2"></i>Ubah Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile area end -->
@endsection

@push('styles')
    <style>
        .active-profile-menu {
            background: linear-gradient(135deg, #A0826D, #8B6F47) !important;
            color: white !important;
        }

        .list-group-item {
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background: rgba(160, 130, 109, 0.1) !important;
            color: #8B6F47 !important;
            padding-left: 20px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #A0826D !important;
            box-shadow: 0 0 0 0.2rem rgba(160, 130, 109, 0.15) !important;
        }

        .password-toggle:hover {
            color: #8B6F47 !important;
        }

        .avatar-circle {
            transition: transform 0.3s ease;
        }

        .avatar-circle:hover {
            transform: scale(1.05);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(160, 130, 109, 0.4) !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeIn 0.6s ease;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function togglePassword(element) {
            const input = element.parentElement.querySelector('input');
            const icon = element.querySelector('i');

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

        // Fetch and populate wilayah dropdowns
        async function fetchProvinces() {
            const res = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
            const provinces = await res.json();
            const provinceSelect = document.getElementById('province');
            provinces.forEach(prov => {
                const option = document.createElement('option');
                option.value = prov.name;
                option.dataset.id = prov.id;
                option.textContent = prov.name;
                provinceSelect.appendChild(option);
            });
            setSelectedFromOld('province', '{{ old('province_name', $customer->province_name) }}');
        }

        async function fetchRegencies(provinceId) {
            const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`);
            return await res.json();
        }

        async function fetchDistricts(regencyId) {
            const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`);
            return await res.json();
        }

        async function fetchVillages(districtId) {
            const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`);
            return await res.json();
        }

        function setSelectedFromOld(selectId, oldValue) {
            const select = document.getElementById(selectId);
            if (oldValue) {
                for (let option of select.options) {
                    if (option.value === oldValue) {
                        option.selected = true;
                        return;
                    }
                }
            }
        }

        async function populateRegencies(provinceName) {
            const provinceSelect = document.getElementById('province');
            const provinceOption = Array.from(provinceSelect.options).find(opt => opt.value === provinceName);
            const provinceId = provinceOption ? provinceOption.dataset.id : null;
            const regencySelect = document.getElementById('regency');
            regencySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
            if (!provinceId) return;

            const regencies = await fetchRegencies(provinceId);
            regencies.forEach(reg => {
                const option = document.createElement('option');
                option.value = reg.name;
                option.dataset.id = reg.id;
                option.textContent = reg.name;
                regencySelect.appendChild(option);
            });
            setSelectedFromOld('regency', '{{ old('regency_name', $customer->regency_name) }}');
        }

        async function populateDistricts(regencyName) {
            const regencySelect = document.getElementById('regency');
            const regencyOption = Array.from(regencySelect.options).find(opt => opt.value === regencyName);
            const regencyId = regencyOption ? regencyOption.dataset.id : null;
            const districtSelect = document.getElementById('district');
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            if (!regencyId) return;

            const districts = await fetchDistricts(regencyId);
            districts.forEach(dist => {
                const option = document.createElement('option');
                option.value = dist.name;
                option.dataset.id = dist.id;
                option.textContent = dist.name;
                districtSelect.appendChild(option);
            });
            setSelectedFromOld('district', '{{ old('district_name', $customer->district_name) }}');
        }

        async function populateVillages(districtName) {
            const districtSelect = document.getElementById('district');
            const districtOption = Array.from(districtSelect.options).find(opt => opt.value === districtName);
            const districtId = districtOption ? districtOption.dataset.id : null;
            const villageSelect = document.getElementById('village');
            villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
            if (!districtId) return;

            const villages = await fetchVillages(districtId);
            villages.forEach(vill => {
                const option = document.createElement('option');
                option.value = vill.name;
                option.textContent = vill.name;
                villageSelect.appendChild(option);
            });
            setSelectedFromOld('village', '{{ old('village_name', $customer->village_name) }}');
        }

        document.addEventListener('DOMContentLoaded', async function() {
            await fetchProvinces();

            const provinceSelect = document.getElementById('province');
            const regencySelect = document.getElementById('regency');
            const districtSelect = document.getElementById('district');
            const villageSelect = document.getElementById('village');

            provinceSelect.addEventListener('change', async () => {
                await populateRegencies(provinceSelect.value);
                districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
            });

            regencySelect.addEventListener('change', async () => {
                await populateDistricts(regencySelect.value);
                villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
            });

            districtSelect.addEventListener('change', async () => {
                await populateVillages(districtSelect.value);
            });

            // Populate regencies, districts, villages if old values exist (edit mode)
            if (provinceSelect.value) {
                await populateRegencies(provinceSelect.value);
            }
            if (regencySelect.value) {
                await populateDistricts(regencySelect.value);
            }
            if (districtSelect.value) {
                await populateVillages(districtSelect.value);
            }
        });

        // Smooth scroll untuk menu
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        // Update active menu
                        document.querySelectorAll('.list-group-item').forEach(i => {
                            i.classList.remove('active-profile-menu');
                            i.style.color = '#666';
                        });
                        this.classList.add('active-profile-menu');
                        this.style.color = 'white';

                        // Smooth scroll ke section
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

        // Auto hide alerts
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
