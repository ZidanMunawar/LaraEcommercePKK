@extends('admin.layouts.mainLayout')
@section('title', 'Promo Codes')

@section('content')
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master Data</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><ion-icon
                                name="home-sharp"></ion-icon></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Promo Codes</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPromoCodeModal">Add
                Promo Code</button>
        </div>
    </div>
    <!--end breadcrumb-->

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

    <!-- Promo Codes Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0">Promo Codes</h5>
                <form class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><ion-icon
                            name="search-sharp"></ion-icon></div>
                    <input class="form-control ps-5" type="text" id="searchInput" placeholder="search">
                </form>
            </div>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Image</th>
                            <th>Discount</th>
                            <th>Status</th>
                            <th>Expires At</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="promoCodesTable">
                        @forelse($promocodes as $index => $promocode)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge bg-primary">{{ $promocode->code }}</span></td>
                                <td>
                                    @if ($promocode->image)
                                        <img src="{{ asset('storage/' . $promocode->image) }}" alt="{{ $promocode->code }}"
                                            class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ number_format($promocode->discount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $promocode->status_class }}">
                                        {{ $promocode->status }}
                                    </span>
                                </td>
                                <td>{{ $promocode->expires_at->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $promocode->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-2 fs-3">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editPromoCodeModal{{ $promocode->id }}">
                                            <ion-icon name="pencil"></ion-icon>Edit
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deletePromoCodeModal{{ $promocode->id }}">
                                            <ion-icon name="trash"></ion-icon>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            @include('admin.modals.master.promocodes.edit', ['promocode' => $promocode])
                            @include('admin.modals.master.promocodes.delete', ['promocode' => $promocode])
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <ion-icon name="ticket-outline" style="font-size: 48px; color: #ccc;"></ion-icon>
                                    <p class="text-muted mt-2">No promo codes available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.modals.master.promocodes.add')

    <!-- Auto-close Alerts -->
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
            const tableBody = document.getElementById('promoCodesTable');

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
