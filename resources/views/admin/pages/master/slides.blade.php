@extends('admin.layouts.mainLayout')
@section('title', 'Data Slide')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master Data</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <ion-icon name="home-sharp"></ion-icon>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Slide</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @if ($slides->count() < 4)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSlideModal">
                    <ion-icon name="add-circle-outline" class="align-middle"></ion-icon>
                    Tambah Slide
                </button>
            @else
                <button type="button" class="btn btn-secondary" disabled title="Maksimal 4 slide sudah tercapai">
                    <ion-icon name="lock-closed-outline" class="align-middle"></ion-icon>
                    Tambah Slide (Maks 4)
                </button>
            @endif
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

    <!-- Table Slide -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="mb-0">Daftar Slide</h5>
                <div class="ms-auto">
                    <span class="badge bg-info" style="font-size: 14px; padding: 8px 12px;">
                        <ion-icon name="images" class="align-middle"></ion-icon>
                        {{ $slides->count() }}/4 Slide
                    </span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th width="200">Gambar Slide</th>
                            <th>Promosi</th>
                            <th width="180">Dibuat</th>
                            <th width="180">Terakhir Diubah</th>
                            <th width="200" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($slides as $index => $slide)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $slide->image) }}" alt="Slide {{ $index + 1 }}"
                                        class="rounded shadow-sm"
                                        style="width: 150px; height: 75px; object-fit: cover; cursor: pointer;"
                                        data-bs-toggle="modal" data-bs-target="#previewSlideModal{{ $slide->id }}">
                                </td>
                                <td>
                                    @if ($slide->promotion)
                                        <span class="badge bg-success" style="font-size: 13px; padding: 6px 12px;">
                                            <ion-icon name="pricetag" class="align-middle"></ion-icon>
                                            {{ $slide->promotion->name }}
                                        </span>
                                    @else
                                        <span class="text-muted">Tanpa Promosi</span>
                                    @endif
                                </td>
                                <td><small style="opacity: 0.7;">{{ $slide->created_at->format('d M Y, H:i') }}</small></td>
                                <td><small style="opacity: 0.7;">{{ $slide->updated_at->format('d M Y, H:i') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editSlideModal{{ $slide->id }}">
                                            <ion-icon name="pencil" class="align-middle"></ion-icon>
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteSlideModal{{ $slide->id }}">
                                            <ion-icon name="trash" class="align-middle"></ion-icon>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Preview Modal -->
                            <div class="modal fade" id="previewSlideModal{{ $slide->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <ion-icon name="eye-outline" class="align-middle"></ion-icon>
                                                Preview Slide #{{ $index + 1 }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center p-0">
                                            <img src="{{ asset('storage/' . $slide->image) }}"
                                                alt="Slide {{ $index + 1 }}" class="img-fluid w-100"
                                                style="max-height: 600px; object-fit: contain; background: #f8f9fa;">
                                        </div>
                                        @if ($slide->promotion)
                                            <div class="modal-footer justify-content-center">
                                                <p class="mb-0 fw-bold fs-5">
                                                    <ion-icon name="pricetag" class="align-middle"></ion-icon>
                                                    {{ $slide->promotion->name }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @include('admin.modals.master.slides.edit', [
                                'slide' => $slide,
                                'promotions' => $promotions,
                            ])
                            @include('admin.modals.master.slides.delete', ['slide' => $slide])
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <ion-icon name="images-outline" style="font-size: 64px; color: #ccc;"></ion-icon>
                                    <p class="text-muted mt-3 mb-0">Belum ada slide</p>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal"
                                        data-bs-target="#addSlideModal">
                                        <ion-icon name="add-circle-outline"></ion-icon>
                                        Tambah Slide Pertama
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include Add Modal -->
    @if ($slides->count() < 4)
        @include('admin.modals.master.slides.add')
    @endif

    <!-- Info Alert -->
    @if ($slides->count() > 0)
        <div class="alert alert-info d-flex align-items-center">
            <ion-icon name="information-circle" class="fs-4 me-2"></ion-icon>
            <div>
                Jumlah Slide: <strong>{{ $slides->count() }}/4</strong>
                @if ($slides->count() >= 4)
                    - Maksimal slide sudah tercapai. Hapus slide yang ada untuk menambahkan yang baru.
                @endif
            </div>
        </div>
    @endif

    <!-- Auto-close Alerts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
@endsection
