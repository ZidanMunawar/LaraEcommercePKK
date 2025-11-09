@extends('admin.layouts.mainLayout')
@section('title', 'Profil Saya')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Akun</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <ion-icon name="home-sharp"></ion-icon>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Alert Sukses -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <div class="d-flex align-items-center">
                <div class="fs-4 text-success me-2">
                    <ion-icon name="checkmark-circle"></ion-icon>
                </div>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Alert Error -->
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <div class="d-flex align-items-center">
                <div class="fs-4 text-danger me-2">
                    <ion-icon name="alert-circle"></ion-icon>
                </div>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Kolom Kiri - Profile Card & Info Akun -->
        <div class="col-lg-4">
            <!-- Profile Card dengan Avatar -->
            <div class="card text-center">
                <div class="card-body">
                    <!-- Avatar Besar -->
                    <div class="mb-3 position-relative d-inline-block">
                        @if ($admin->avatar)
                            <img src="{{ asset('storage/' . $admin->avatar) }}" alt="{{ $admin->nama_lengkap }}"
                                class="rounded-circle shadow-lg"
                                style="width: 150px; height: 150px; object-fit: cover; border: 5px solid #fff;">
                        @else
                            <div class="rounded-circle shadow-lg d-flex align-items-center justify-content-center"
                                style="width: 150px; height: 150px; background: linear-gradient(135deg, #ff8c27 0%, #deb51f 100%); border: 5px solid #fff; margin: 0 auto;">
                                <ion-icon name="person" style="font-size: 80px; color: white;"></ion-icon>
                            </div>
                        @endif

                        <!-- Tombol Edit Avatar -->
                        <button type="button" class="btn btn-sm btn-primary rounded-circle position-absolute"
                            style="bottom: 10px; right: 10px; width: 40px; height: 40px;" data-bs-toggle="modal"
                            data-bs-target="#avatarModal" title="Ganti Foto Profil">
                            <ion-icon name="camera"></ion-icon>
                        </button>
                    </div>

                    <!-- Nama & Username -->
                    <h4 class="mb-1">{{ $admin->nama_lengkap }}</h4>
                    <p class="text-muted mb-2">{{ '@' . $admin->username }}</p>

                    <!-- Role Badge -->
                    <div class="mb-3">
                        @if ($admin->role == 'owner')
                            <span class="badge bg-danger" style="font-size: 14px; padding: 8px 16px;">
                                <ion-icon name="shield-checkmark" class="align-middle"></ion-icon>
                                Owner
                            </span>
                        @elseif($admin->role == 'admin')
                            <span class="badge bg-primary" style="font-size: 14px; padding: 8px 16px;">
                                <ion-icon name="person" class="align-middle"></ion-icon>
                                Admin
                            </span>
                        @else
                            <span class="badge bg-info" style="font-size: 14px; padding: 8px 16px;">
                                <ion-icon name="people" class="align-middle"></ion-icon>
                                Petugas
                            </span>
                        @endif
                    </div>

                    <!-- Email & Phone -->
                    <div class="text-start">
                        <p class="mb-2">
                            <ion-icon name="mail" class="align-middle me-2"></ion-icon>
                            <small>{{ $admin->email }}</small>
                        </p>
                        <p class="mb-0">
                            <ion-icon name="call" class="align-middle me-2"></ion-icon>
                            <small>{{ $admin->no_telp ?? 'Belum diisi' }}</small>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Info Akun -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <ion-icon name="information-circle" class="align-middle me-2"></ion-icon>
                        Detail Akun
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Akun</label>
                        <div>
                            @if ($admin->status == 'active')
                                <span class="badge bg-success">
                                    <ion-icon name="checkmark-circle" class="align-middle"></ion-icon>
                                    Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <ion-icon name="close-circle" class="align-middle"></ion-icon>
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Dibuat -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Akun Dibuat</label>
                        <div class="text-muted">
                            <ion-icon name="calendar" class="align-middle me-1"></ion-icon>
                            {{ $admin->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <!-- Terakhir Diupdate -->
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Terakhir Diubah</label>
                        <div class="text-muted">
                            <ion-icon name="time" class="align-middle me-1"></ion-icon>
                            {{ $admin->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan - Form Edit -->
        <div class="col-lg-8">
            <!-- Edit Informasi Profil -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <ion-icon name="person-circle" class="align-middle me-2"></ion-icon>
                        Informasi Profil
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Username -->
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">
                                    Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username', $admin->username) }}"
                                    required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Username untuk login</small>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Nama Lengkap -->
                            <div class="col-md-6 mb-3">
                                <label for="nama_lengkap" class="form-label">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    id="nama_lengkap" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $admin->nama_lengkap) }}" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- No Telepon -->
                            <div class="col-md-6 mb-3">
                                <label for="no_telp" class="form-label">
                                    No. Telepon <span class="text-muted">(Opsional)</span>
                                </label>
                                <input type="text" class="form-control @error('no_telp') is-invalid @enderror"
                                    id="no_telp" name="no_telp" value="{{ old('no_telp', $admin->no_telp) }}"
                                    placeholder="08123456789">
                                @error('no_telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <ion-icon name="save" class="align-middle me-2"></ion-icon>
                                Perbarui Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="card mt-3">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">
                        <ion-icon name="lock-closed" class="align-middle me-2"></ion-icon>
                        Ganti Password
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Password Saat Ini -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                Password Saat Ini <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('current_password')">
                                    <ion-icon name="eye-outline"></ion-icon>
                                </button>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Password Baru -->
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label">
                                    Password Baru <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                        class="form-control @error('new_password') is-invalid @enderror" id="new_password"
                                        name="new_password" required>
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('new_password')">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </button>
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Minimal 6 karakter</small>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="col-md-6 mb-3">
                                <label for="new_password_confirmation" class="form-label">
                                    Konfirmasi Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new_password_confirmation"
                                        name="new_password_confirmation" required>
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('new_password_confirmation')">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info">
                            <ion-icon name="information-circle" class="align-middle me-2"></ion-icon>
                            <small>Pastikan password baru Anda kuat dan berbeda dari password sebelumnya.</small>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-warning">
                                <ion-icon name="key" class="align-middle me-2"></ion-icon>
                                Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ganti Avatar -->
    <div class="modal fade" id="avatarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <ion-icon name="camera-outline" class="align-middle"></ion-icon>
                            Ganti Foto Profil
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Preview Avatar Saat Ini -->
                        <div class="text-center mb-3">
                            <label class="form-label">Foto Profil Saat Ini</label>
                            <div>
                                @if ($admin->avatar)
                                    <img src="{{ asset('storage/' . $admin->avatar) }}" alt="Avatar"
                                        class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width: 120px; height: 120px; background: linear-gradient(135deg, #f46d05 0%, #fedb29 100%);">
                                        <ion-icon name="person" style="font-size: 60px; color: white;"></ion-icon>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Upload Avatar Baru -->
                        <div class="mb-3">
                            <label for="avatar" class="form-label">
                                Upload Foto Baru <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                id="avatar" name="avatar" accept="image/*" required>
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG, JPEG (Maks 2MB)</small>
                        </div>

                        <!-- Preview Upload -->
                        <div id="avatarPreview" class="text-center" style="display: none;">
                            <label class="form-label">Preview</label>
                            <div>
                                <img id="avatarPreviewImg" src="" alt="Preview" class="rounded-circle"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <ion-icon name="save-outline"></ion-icon> Simpan Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Auto close alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });

        // Toggle Password Visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling;
            const icon = button.querySelector('ion-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.setAttribute('name', 'eye-off-outline');
            } else {
                field.type = 'password';
                icon.setAttribute('name', 'eye-outline');
            }
        }

        // Avatar Preview
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreviewImg').src = e.target.result;
                    document.getElementById('avatarPreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
