@extends('admin.layouts.mainLayout')
@section('title', 'Slides')

@section('content')
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master Data</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><ion-icon
                                name="home-sharp"></ion-icon></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Slides</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @if ($slides->count() < 4)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSlideModal">
                    Add Slide
                </button>
            @else
                <button type="button" class="btn btn-secondary" disabled title="Maksimal 4 slides sudah tercapai">
                    Add Slide (Max 4)
                </button>
            @endif
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

    <!-- Slides Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0">Slides</h5>
                <div class="ms-auto">
                    <span class="badge bg-info">{{ $slides->count() }}/4 Slides</span>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Promotion</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($slides as $index => $slide)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $slide->image) }}" alt="Slide {{ $index + 1 }}"
                                        class="rounded"
                                        style="width: 120px; height: 60px; object-fit: cover; cursor: pointer;"
                                        data-bs-toggle="modal" data-bs-target="#previewSlideModal{{ $slide->id }}">
                                </td>
                                <td>
                                    @if ($slide->promotion)
                                        <span class="badge bg-success">{{ $slide->promotion->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $slide->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $slide->updated_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-2 fs-3">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editSlideModal{{ $slide->id }}">
                                            <ion-icon name="pencil"></ion-icon>Edit
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteSlideModal{{ $slide->id }}">
                                            <ion-icon name="trash"></ion-icon>Delete
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
                                            <h5 class="modal-title">Slide Preview</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center p-0">
                                            <img src="{{ asset('storage/' . $slide->image) }}" alt="Slide"
                                                class="img-fluid w-100"
                                                style="max-height: 600px; object-fit: contain; background: #f8f9fa;">
                                        </div>
                                        @if ($slide->promotion)
                                            <div class="modal-footer justify-content-center">
                                                <p class="mb-0 fw-bold fs-5">{{ $slide->promotion->name }}</p>
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
                                <td colspan="6" class="text-center py-4">
                                    <ion-icon name="images-outline" style="font-size: 48px; color: #ccc;"></ion-icon>
                                    <p class="text-muted mt-2 mb-0">No slides available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include Add Slide Modal (hanya jika belum 4 slides) -->
    @if ($slides->count() < 4)
        @include('admin.modals.master.slides.add')
    @endif

    <!-- Info Alert -->
    @if ($slides->count() > 0)
        <div class="alert alert-info d-flex align-items-center mt-3" role="alert">
            <ion-icon name="information-circle" class="fs-4 me-2"></ion-icon>
            <div>
                Jumlah Slides: <strong>{{ $slides->count() }}/4</strong>
                @if ($slides->count() >= 4)
                    - Maksimal slides sudah tercapai. Hapus slide yang ada untuk menambahkan yang baru.
                @endif
            </div>
        </div>
    @endif

    <!-- Auto-close Alerts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-success, .alert-danger');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
@endsection
