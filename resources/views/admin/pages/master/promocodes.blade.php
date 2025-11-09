@extends('admin.layouts.mainLayout')
@section('title', 'Data Kode Promo')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master Data</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <ion-icon name="home-outline"></ion-icon>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Kode Promo</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPromoCodeModal">
                <ion-icon name="add-circle-outline" class="align-middle"></ion-icon>
                Tambah Kode Promo
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

    <!-- Table Kode Promo -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="mb-0">Daftar Kode Promo</h5>
                <div class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                        <ion-icon name="search-sharp"></ion-icon>
                    </div>
                    <input class="form-control ps-5" type="text" id="searchInput" placeholder="Cari kode promo...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Kode Promo</th>
                            <th width="100">Gambar</th>
                            <th width="140">Diskon</th>
                            <th width="80">Status</th>
                            <th width="140">Kadaluarsa</th>
                            <th width="180">Dibuat</th>
                            <th width="200" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="promoCodesTable">
                        @forelse($promocodes as $index => $promocode)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge bg-gradient-promo"
                                        style="font-size: 13px; padding: 6px 10px; font-family: monospace;">
                                        <ion-icon name="ticket" class="align-middle"></ion-icon>
                                        {{ $promocode->code }}
                                    </span>
                                </td>
                                <td>
                                    @if ($promocode->image)
                                        <img src="{{ asset('storage/' . $promocode->image) }}" alt="{{ $promocode->code }}"
                                            class="rounded shadow-sm"
                                            style="width: 70px; height: 45px; object-fit: cover; cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#previewModal{{ $promocode->id }}">
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($promocode->discount_type === 'percentage')
                                        <span class="badge bg-success" style="font-size: 13px; padding: 6px 10px;">
                                            <ion-icon name="percent-outline" class="align-middle"></ion-icon>
                                            {{ $promocode->discount }}%
                                        </span>
                                    @else
                                        <span class="badge bg-info" style="font-size: 13px; padding: 6px 10px;">
                                            <ion-icon name="cash-outline" class="align-middle"></ion-icon>
                                            Rp {{ number_format($promocode->discount, 0, ',', '.') }}
                                        </span>
                                    @endif
                                    @if ($promocode->min_purchase > 0)
                                        <div class="text-muted small mt-1">
                                            Min: Rp {{ number_format($promocode->min_purchase, 0, ',', '.') }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $now = now();
                                        $isExpired = $promocode->expires_at < $now;
                                    @endphp
                                    @if ($isExpired)
                                        <span class="badge bg-danger">
                                            <ion-icon name="close-circle" class="align-middle"></ion-icon>
                                            Expired
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            <ion-icon name="checkmark-circle" class="align-middle"></ion-icon>
                                            Aktif
                                        </span>
                                    @endif
                                </td>
                                <td><small style="opacity: 0.7;">{{ $promocode->expires_at->format('d M Y, H:i') }}</small>
                                </td>
                                <td><small style="opacity: 0.7;">{{ $promocode->created_at->format('d M Y, H:i') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editPromoCodeModal{{ $promocode->id }}">
                                            <ion-icon name="pencil" class="align-middle"></ion-icon>
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deletePromoCodeModal{{ $promocode->id }}">
                                            <ion-icon name="trash" class="align-middle"></ion-icon>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Preview Modal -->
                            @if ($promocode->image)
                                <div class="modal fade" id="previewModal{{ $promocode->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <ion-icon name="eye-outline" class="align-middle"></ion-icon>
                                                    Preview - {{ $promocode->code }}
                                                </h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center p-3">
                                                <img src="{{ asset('storage/' . $promocode->image) }}"
                                                    alt="{{ $promocode->code }}" class="img-fluid rounded">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @include('admin.modals.master.promocodes.edit', ['promocode' => $promocode])
                            @include('admin.modals.master.promocodes.delete', ['promocode' => $promocode])
                        @empty
                            <tr id="emptyRow">
                                <td colspan="8" class="text-center py-5">
                                    <ion-icon name="ticket-outline" style="font-size: 64px; color: #ccc;"></ion-icon>
                                    <p class="text-muted mt-3 mb-0">Belum ada kode promo</p>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal"
                                        data-bs-target="#addPromoCodeModal">
                                        <ion-icon name="add-circle-outline"></ion-icon>
                                        Tambah Kode Promo Pertama
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include Modal Add -->
    @include('admin.modals.master.promocodes.add')

    <!-- Custom Styles -->
    <style>
        /* Gradient badge untuk kode promo */
        .bg-gradient-promo {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto close alerts setelah 5 detik
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Realtime search
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('promoCodesTable');

            if (searchInput && tableBody) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = tableBody.getElementsByTagName('tr');
                    let visibleCount = 0;

                    Array.from(rows).forEach(function(row) {
                        if (row.id === 'emptyRow') return;

                        const text = row.textContent.toLowerCase();

                        if (text.includes(searchTerm)) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Tampilkan pesan "tidak ada hasil"
                    if (searchTerm && visibleCount === 0) {
                        const noResultRow = document.getElementById('noResultRow');
                        if (!noResultRow) {
                            const emptyMessage = document.createElement('tr');
                            emptyMessage.id = 'noResultRow';
                            emptyMessage.innerHTML = `
                                <td colspan="8" class="text-center py-4">
                                    <ion-icon name="search-outline" style="font-size: 48px; color: #ccc;"></ion-icon>
                                    <p class="text-muted mt-2 mb-0">
                                        Tidak ada hasil untuk "<strong>${searchTerm}</strong>"
                                    </p>
                                </td>
                            `;
                            tableBody.appendChild(emptyMessage);
                        }
                    } else {
                        const noResultRow = document.getElementById('noResultRow');
                        if (noResultRow) noResultRow.remove();
                    }
                });
            }
        });
    </script>
@endsection
