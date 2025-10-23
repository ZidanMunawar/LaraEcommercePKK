@extends('admin.layouts.mainLayout')
@section('title', 'Manage Admins')

@section('content')
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">User Management</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><ion-icon
                                name="home-sharp"></ion-icon></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Admins</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                Add Admin
            </button>
        </div>
    </div>
    <!--end breadcrumb-->

    <!-- Display Alerts -->
    @if (session('success'))
        <div class="alert alert-dismissible fade show py-2 bg-success">
            <div class="d-flex align-items-center">
                <div class="fs-3 text-white"><ion-icon name="checkmark-circle-sharp"></ion-icon></div>
                <div class="ms-3">
                    <div class="text-white">{{ session('success') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-dismissible fade show py-2 bg-danger">
            <div class="d-flex align-items-center">
                <div class="fs-3 text-white"><ion-icon name="close-circle-sharp"></ion-icon></div>
                <div class="ms-3">
                    <div class="text-white">{{ session('error') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Admin Users Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0">Admins</h5>
                <form class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                        <ion-icon name="search-sharp"></ion-icon>
                    </div>
                    <input class="form-control ps-5" type="text" id="searchInput" placeholder="Search Admins">
                </form>
            </div>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="adminsTable">
                        @forelse($admins as $index => $adminUser)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $adminUser->username }}</strong></td>
                                <td>{{ $adminUser->nama_lengkap }}</td>
                                <td>{{ $adminUser->email }}</td>
                                <td>{{ $adminUser->no_telp ?? '-' }}</td>
                                <td>
                                    @if ($adminUser->role == 'owner')
                                        <span class="badge bg-danger">Owner</span>
                                    @elseif($adminUser->role == 'admin')
                                        <span class="badge bg-primary">Admin</span>
                                    @else
                                        <span class="badge bg-info">Petugas</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($adminUser->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-2 fs-3">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editAdminModal{{ $adminUser->id_admin }}">
                                            <ion-icon name="pencil"></ion-icon>Edit
                                        </button>
                                        @if (auth('admin')->id() != $adminUser->id_admin)
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteAdminModal{{ $adminUser->id_admin }}">
                                                <ion-icon name="trash"></ion-icon>Delete
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-secondary" disabled
                                                title="Cannot delete your own account">
                                                <ion-icon name="trash"></ion-icon>Delete
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @include('admin.modals.users.admins.edit', ['adminUser' => $adminUser])
                            @include('admin.modals.users.admins.delete', ['adminUser' => $adminUser])
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <ion-icon name="people-outline" style="font-size: 48px; color: #ccc;"></ion-icon>
                                    <p class="text-muted mt-2 mb-0">No admins available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.modals.users.admins.add')

    <!-- Auto-close Alerts & Search -->
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

            // Simple search functionality
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('adminsTable');

            if (searchInput && tableBody) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = tableBody.getElementsByTagName('tr');

                    Array.from(rows).forEach(function(row) {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }
        });
    </script>
@endsection
