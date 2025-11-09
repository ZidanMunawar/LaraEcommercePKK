@extends('admin.layouts.mainLayout')
@section('title', 'Data Tag')

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
                    <li class="breadcrumb-item active" aria-current="page">Tag</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTagModal">
                <ion-icon name="add-circle-outline" class="align-middle"></ion-icon>
                Tambah Tag
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

    <!-- Table Tag -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="mb-0">Daftar Tag</h5>
                <div class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                        <ion-icon name="search-sharp"></ion-icon>
                    </div>
                    <input class="form-control ps-5" type="text" id="searchInput" placeholder="Cari tag...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Nama Tag</th>
                            <th width="180">Dibuat</th>
                            <th width="180">Terakhir Diubah</th>
                            <th width="200" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tagsTable">
                        @forelse($tags as $index => $tag)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge bg-info" style="font-size: 14px; padding: 6px 12px;">
                                        <ion-icon name="pricetag" class="align-middle"></ion-icon>
                                        {{ $tag->name }}
                                    </span>
                                </td>
                                <td><small style="opacity: 0.7;">{{ $tag->created_at->format('d M Y, H:i') }}</small></td>
                                <td><small style="opacity: 0.7;">{{ $tag->updated_at->format('d M Y, H:i') }}</small></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editTagModal{{ $tag->id }}">
                                            <ion-icon name="pencil" class="align-middle"></ion-icon>
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteTagModal{{ $tag->id }}">
                                            <ion-icon name="trash" class="align-middle"></ion-icon>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            @include('admin.modals.master.tags.edit', ['tag' => $tag])
                            @include('admin.modals.master.tags.delete', ['tag' => $tag])
                        @empty
                            <tr id="emptyRow">
                                <td colspan="5" class="text-center py-5">
                                    <ion-icon name="pricetags-outline" style="font-size: 64px; color: #ccc;"></ion-icon>
                                    <p class="text-muted mt-3 mb-0">Belum ada data tag</p>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal"
                                        data-bs-target="#addTagModal">
                                        <ion-icon name="add-circle-outline"></ion-icon>
                                        Tambah Tag Pertama
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
    @include('admin.modals.master.tags.add')

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
            const tableBody = document.getElementById('tagsTable');

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
                                <td colspan="5" class="text-center py-4">
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
