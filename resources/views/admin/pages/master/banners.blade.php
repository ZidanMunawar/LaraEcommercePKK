@extends('admin.layouts.mainLayout')
@section('title', 'Banner')

@section('content')
    <!--start breadcrumb-->
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
                    <li class="breadcrumb-item active" aria-current="page">Banner</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @if ($banners->count() < 2)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBannerModal">
                    Add Banner
                </button>
            @else
                <button type="button" class="btn btn-secondary" disabled title="Maksimal 2 banner sudah tercapai">
                    Add Banner (Max 2)
                </button>
            @endif
        </div>
    </div>
    <!--end breadcrumb-->

    <!-- Display Alerts -->
    @if (session('success'))
        <div class="alert alert-dismissible fade show py-2 bg-success">
            <div class="d-flex align-items-center">
                <div class="fs-3 text-white">
                    <ion-icon name="checkmark-circle-sharp"></ion-icon>
                </div>
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
                <div class="fs-3 text-white">
                    <ion-icon name="close-circle-sharp"></ion-icon>
                </div>
                <div class="ms-3">
                    <div class="text-white">{{ session('error') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Banner Content -->
    @if ($banners->isNotEmpty())
        <div class="row">
            @foreach ($banners as $banner)
                <!-- Banner Card -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm" style="border-radius: 15px;">
                        <!-- Banner Image -->
                        <div class="position-relative"
                            style="height: 350px; overflow: hidden; border-radius: 15px 15px 0 0;">
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->promotion ?? 'Banner' }}"
                                class="w-100 h-100" style="object-fit: cover; cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#previewModal{{ $banner->id }}">

                            <!-- Badge Overlay -->
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-primary">
                                    <ion-icon name="image-outline" class="align-middle"></ion-icon> Banner
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <!-- Promotion Title -->
                            @if ($banner->promotion)
                                <h5 class="card-title mb-3 fw-bold">{{ $banner->promotion }}</h5>
                            @else
                                <h5 class="card-title mb-3 text-muted fst-italic">Tanpa Teks Promosi</h5>
                            @endif

                            <!-- Banner Details -->
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2 text-muted small">
                                    <ion-icon name="calendar-outline" class="me-2"></ion-icon>
                                    <span><strong>Dibuat:</strong> {{ $banner->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="d-flex align-items-center text-muted small">
                                    <ion-icon name="sync-outline" class="me-2"></ion-icon>
                                    <span><strong>Diperbarui:</strong>
                                        {{ $banner->updated_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-primary flex-fill" data-bs-toggle="modal"
                                    data-bs-target="#editBannerModal{{ $banner->id }}">
                                    <ion-icon name="pencil" class="align-middle"></ion-icon> Edit
                                </button>
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger flex-fill" data-bs-toggle="modal"
                                    data-bs-target="#deleteBannerModal{{ $banner->id }}">
                                    <ion-icon name="trash" class="align-middle"></ion-icon> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview Modal -->
                <div class="modal fade" id="previewModal{{ $banner->id }}" tabindex="-1"
                    aria-labelledby="previewModalLabel{{ $banner->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="previewModalLabel{{ $banner->id }}">
                                    Preview Banner - {{ $banner->promotion ?? 'No Title' }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center p-0">
                                <img src="{{ asset('storage/' . $banner->image) }}"
                                    alt="{{ $banner->promotion ?? 'Banner' }}" class="img-fluid w-100"
                                    style="max-height: 700px; object-fit: contain; background: #f8f9fa;">
                            </div>
                            @if ($banner->promotion)
                                <div class="modal-footer justify-content-center">
                                    <p class="mb-0 fw-bold fs-5">{{ $banner->promotion }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Include Modals for Each Banner -->
                @include('admin.modals.master.banners.edit', ['banner' => $banner])
                @include('admin.modals.master.banners.delete', ['banner' => $banner])
            @endforeach
        </div>

        <!-- Info Banner Count -->
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <ion-icon name="information-circle" class="fs-4 me-2"></ion-icon>
            <div>
                Jumlah Banner: <strong>{{ $banners->count() }}/2</strong>
                @if ($banners->count() >= 2)
                    - Maksimal banner sudah tercapai. Hapus banner yang ada untuk menambahkan yang baru.
                @endif
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <ion-icon name="images-outline" style="font-size: 120px; color: #e0e0e0;"></ion-icon>
                </div>
                <h3 class="mb-3 fw-bold">Belum Ada Banner</h3>
                <p class="text-muted mb-4">
                    Tidak ada banner yang tersedia saat ini. Mulai dengan menambahkan banner pertama Anda
                    untuk menampilkan promosi dan konten menarik kepada pelanggan.
                </p>
                <button type="button" class="btn btn-primary btn-lg shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#addBannerModal">
                    <ion-icon name="add-circle" class="align-middle"></ion-icon> Tambah Banner Pertama
                </button>
            </div>
        </div>
    @endif

    <!-- Include Add Banner Modal (hanya jika belum 2 banner) -->
    @if ($banners->count() < 2)
        @include('admin.modals.master.banners.add')
    @endif

    <!-- Custom Styles -->
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .card img {
            transition: transform 0.3s ease;
        }

        .card:hover img {
            transform: scale(1.05);
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover:not(:disabled) {
            transform: translateY(-2px);
        }

        ion-icon {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.5rem 0.75rem;
        }

        /* Alert Animation */
        .alert {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Modal image background */
        .modal-body img {
            background: repeating-conic-gradient(#f8f9fa 0% 25%, #e9ecef 0% 50%) 50% / 20px 20px;
        }
    </style>

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
