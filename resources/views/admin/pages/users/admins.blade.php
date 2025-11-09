@extends('admin.layouts.mainLayout')
@section('title', 'Kelola Admin')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Manajemen Pengguna</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <ion-icon name="home-sharp"></ion-icon>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Admin</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                <ion-icon name="person-add" class="align-middle me-1"></ion-icon>
                Tambah Admin
            </button>
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

    <!-- Tabel Admin -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="mb-0">Daftar Admin</h5>
                <div class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                        <ion-icon name="search-sharp"></ion-icon>
                    </div>
                    <input class="form-control ps-5" type="text" id="searchInput" placeholder="Cari admin...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th width="100">Role</th>
                            <th width="100">Status</th>
                            <th width="180" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="adminsTable">
                        @forelse($admins as $index => $adminUser)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $adminUser->username }}</strong></td>
                                <td>{{ $adminUser->nama_lengkap }}</td>
                                <td>{{ $adminUser->email }}</td>
                                <td><small style="opacity: 0.7;">{{ $adminUser->no_telp ?? '-' }}</small></td>
                                <td>
                                    @if ($adminUser->role == 'owner')
                                        <span class="badge bg-danger">
                                            <ion-icon name="shield-checkmark" class="align-middle"></ion-icon>
                                            Owner
                                        </span>
                                    @elseif($adminUser->role == 'admin')
                                        <span class="badge bg-primary">
                                            <ion-icon name="person" class="align-middle"></ion-icon>
                                            Admin
                                        </span>
                                    @else
                                        <span class="badge bg-info">
                                            <ion-icon name="people" class="align-middle"></ion-icon>
                                            Petugas
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($adminUser->status == 'active')
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
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editAdminModal{{ $adminUser->id_admin }}">
                                            <ion-icon name="pencil" class="align-middle"></ion-icon>
                                            Edit
                                        </button>
                                        @if (auth('admin')->id() != $adminUser->id_admin)
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteAdminModal{{ $adminUser->id_admin }}">
                                                <ion-icon name="trash" class="align-middle"></ion-icon>
                                                Hapus
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-secondary" disabled
                                                title="Tidak dapat menghapus akun sendiri">
                                                <ion-icon name="lock-closed" class="align-middle"></ion-icon>
                                                Hapus
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <ion-icon name="people-outline" style="font-size: 64px; color: #ccc;"></ion-icon>
                                    <p class="text-muted mt-3 mb-0">Belum ada admin</p>
                                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                        data-bs-target="#addAdminModal">
                                        <ion-icon name="person-add" class="align-middle me-1"></ion-icon>
                                        Tambah Admin Pertama
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include Modals -->
    @include('admin.modals.users.admins.add')

    @foreach ($admins as $adminUser)
        @include('admin.modals.users.admins.edit', ['adminUser' => $adminUser])
        @include('admin.modals.users.admins.delete', ['adminUser' => $adminUser])
    @endforeach

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto close alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Realtime search
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('adminsTable');

            if (searchInput && tableBody) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = tableBody.getElementsByTagName('tr');
                    let visibleCount = 0;

                    Array.from(rows).forEach(function(row) {
                        // Skip empty state row
                        if (row.querySelector('[colspan]')) return;

                        const text = row.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Show no result message
                    const noResultRow = document.getElementById('noResultRow');
                    if (searchTerm && visibleCount === 0) {
                        if (!noResultRow) {
                            const tr = document.createElement('tr');
                            tr.id = 'noResultRow';
                            tr.innerHTML = `
                                <td colspan="8" class="text-center py-4">
                                    <ion-icon name="search-outline" style="font-size: 48px; color: #ccc;"></ion-icon>
                                    <p class="text-muted mt-2 mb-0">
                                        Tidak ada hasil untuk "<strong>${searchTerm}</strong>"
                                    </p>
                                </td>
                            `;
                            tableBody.appendChild(tr);
                        }
                    } else if (noResultRow) {
                        noResultRow.remove();
                    }
                });
            }
        });
    </script>
@endsection
