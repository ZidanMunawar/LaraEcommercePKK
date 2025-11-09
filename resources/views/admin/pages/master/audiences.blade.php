@extends('admin.layouts.mainLayout')
@section('title', 'Data Audiens')

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
                    <li class="breadcrumb-item active" aria-current="page">Audiens</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <!-- Tombol tambah audiens -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAudienceModal">
                <ion-icon name="add-circle-outline" class="align-middle"></ion-icon>
                Tambah Audiens
            </button>
        </div>
    </div>

    <!-- Alert sukses/error -->
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

    <!-- Card Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="mb-0">Daftar Audiens</h5>

                <!-- Form pencarian realtime -->
                <div class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                        <ion-icon name="search-sharp"></ion-icon>
                    </div>
                    <input class="form-control ps-5" type="text" id="searchInput" placeholder="Cari audiens...">
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="80">#</th>
                            <th>Nama Audiens</th>
                            <th width="180">Dibuat</th>
                            <th width="180">Terakhir Diubah</th>
                            <th width="220" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="audiencesTable">
                        @forelse ($audiences as $index => $audience)
                            <tr>
                                <!-- Nomor urut -->
                                <td>{{ $index + 1 }}</td>

                                <!-- Nama audiens -->
                                <td>
                                    <strong>{{ $audience->name }}</strong>
                                </td>

                                <!-- Tanggal dibuat - GANTI CLASS BIAR KELIATAN DI DARK MODE -->
                                <td>
                                    <small>{{ $audience->created_at->format('d M Y, H:i') }}</small>
                                </td>

                                <!-- Tanggal diupdate - GANTI CLASS BIAR KELIATAN DI DARK MODE -->
                                <td>
                                    <small>{{ $audience->updated_at->format('d M Y, H:i') }}</small>
                                </td>

                                <!-- Tombol aksi -->
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Tombol edit -->
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $audience->id }}" title="Edit">
                                            <ion-icon name="pencil-outline" class="align-middle"></ion-icon>
                                            Edit
                                        </button>

                                        <!-- Tombol hapus -->
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $audience->id }}" title="Hapus">
                                            <ion-icon name="trash-outline" class="align-middle"></ion-icon>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Tampil kalau data kosong -->
                            <tr id="emptyRow">
                                <td colspan="5" class="text-center py-5">
                                    <ion-icon name="file-tray-outline" style="font-size: 64px; color: #ccc;"></ion-icon>
                                    <p class="text-muted mt-3 mb-0">Belum ada data audiens</p>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal"
                                        data-bs-target="#addAudienceModal">
                                        <ion-icon name="add-circle-outline"></ion-icon>
                                        Tambah Audiens Pertama
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Info hasil pencarian -->
            <div id="searchInfo" class="text-muted small mt-2" style="display: none;">
                Menampilkan <span id="resultCount">0</span> hasil
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    @include('admin.modals.master.audiences.add')

    <!-- Modal Edit (loop untuk setiap data) -->
    @foreach ($audiences as $audience)
        @include('admin.modals.master.audiences.edit', ['audience' => $audience])
    @endforeach

    <!-- Modal Delete (loop untuk setiap data) -->
    @foreach ($audiences as $audience)
        @include('admin.modals.master.audiences.delete', ['audience' => $audience])
    @endforeach

    <!-- JavaScript untuk realtime search -->
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

            // Realtime search functionality
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('audiencesTable');
            const searchInfo = document.getElementById('searchInfo');
            const resultCount = document.getElementById('resultCount');

            if (searchInput && tableBody) {
                // Event listener untuk setiap ketikan di search box
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = tableBody.getElementsByTagName('tr');
                    let visibleCount = 0;

                    // Loop semua row di table
                    Array.from(rows).forEach(function(row) {
                        // Skip row empty state
                        if (row.id === 'emptyRow') {
                            return;
                        }

                        // Ambil text dari row
                        const text = row.textContent.toLowerCase();

                        // Cek apakah row mengandung kata pencarian
                        if (text.includes(searchTerm)) {
                            row.style.display = ''; // Tampilkan row
                            visibleCount++;
                        } else {
                            row.style.display = 'none'; // Sembunyikan row
                        }
                    });

                    // Update info hasil pencarian
                    if (searchTerm) {
                        searchInfo.style.display = 'block';
                        resultCount.textContent = visibleCount;

                        // Kalau tidak ada hasil, tampilkan pesan
                        if (visibleCount === 0) {
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

                            // Hapus pesan "no result" yang lama kalau ada
                            const oldMessage = document.getElementById('noResultRow');
                            if (oldMessage) {
                                oldMessage.remove();
                            }

                            tableBody.appendChild(emptyMessage);
                        } else {
                            // Hapus pesan "no result" kalau ada hasil
                            const noResultRow = document.getElementById('noResultRow');
                            if (noResultRow) {
                                noResultRow.remove();
                            }
                        }
                    } else {
                        // Kalau search kosong, sembunyikan info
                        searchInfo.style.display = 'none';

                        // Hapus pesan "no result"
                        const noResultRow = document.getElementById('noResultRow');
                        if (noResultRow) {
                            noResultRow.remove();
                        }
                    }
                });
            }
        });
    </script>
@endsection
