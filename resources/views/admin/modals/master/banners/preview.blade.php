@if ($banner)
    {{-- ============================================================
    MODAL PREVIEW BANNER FULLSCREEN
    Menampilkan gambar banner dalam ukuran penuh dengan overlay info
============================================================ --}}
    <div class="modal fade" id="previewModal{{ $banner->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 shadow-lg bg-dark">
                {{-- Header Modal --}}
                <div class="modal-header border-0 bg-transparent text-white">
                    <h5 class="modal-title fw-bold">
                        <ion-icon name="eye-outline" class="align-middle fs-4 me-2"></ion-icon>
                        Preview Banner
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                {{-- Body Modal dengan gambar --}}
                <div class="modal-body p-0 position-relative">
                    {{-- Gambar banner ukuran penuh --}}
                    <div class="preview-image-container text-center bg-dark">
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->promotion ?? 'Banner' }}"
                            class="img-fluid preview-image" id="previewImage{{ $banner->id }}"
                            style="max-height: 70vh; width: auto; object-fit: contain;">
                    </div>

                    {{-- Overlay informasi di pojok kanan atas --}}
                    <div class="position-absolute top-0 end-0 m-4">
                        <div class="info-badge bg-white bg-opacity-90 rounded shadow p-3">
                            <div class="small">
                                <div class="mb-2">
                                    <ion-icon name="calendar-outline" class="align-middle text-primary"></ion-icon>
                                    <strong>Dibuat:</strong><br>
                                    <span class="text-muted">{{ $banner->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div>
                                    <ion-icon name="sync-outline" class="align-middle text-primary"></ion-icon>
                                    <strong>Diubah:</strong><br>
                                    <span class="text-muted">{{ $banner->updated_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol zoom dan download floating --}}
                    <div class="position-absolute bottom-0 end-0 m-4">
                        <div class="btn-group shadow" role="group">
                            {{-- Tombol Zoom In --}}
                            <button type="button" class="btn btn-light" onclick="zoomImage{{ $banner->id }}('in')"
                                title="Perbesar">
                                <ion-icon name="add-outline"></ion-icon>
                            </button>

                            {{-- Tombol Zoom Out --}}
                            <button type="button" class="btn btn-light" onclick="zoomImage{{ $banner->id }}('out')"
                                title="Perkecil">
                                <ion-icon name="remove-outline"></ion-icon>
                            </button>

                            {{-- Tombol Reset Zoom --}}
                            <button type="button" class="btn btn-light" onclick="zoomImage{{ $banner->id }}('reset')"
                                title="Reset Ukuran">
                                <ion-icon name="scan-outline"></ion-icon>
                            </button>

                            {{-- Tombol Download --}}
                            <a href="{{ asset('storage/' . $banner->image) }}"
                                download="banner_{{ $banner->id }}.jpg" class="btn btn-primary"
                                title="Download Gambar">
                                <ion-icon name="download-outline"></ion-icon>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Footer Modal dengan informasi teks promosi --}}
                @if ($banner->promotion)
                    <div class="modal-footer border-0 bg-gradient-primary text-white justify-content-center">
                        <div class="text-center">
                            <ion-icon name="pricetag" class="fs-4 me-2"></ion-icon>
                            <h5 class="mb-0 d-inline fw-bold">{{ $banner->promotion }}</h5>
                        </div>
                    </div>
                @else
                    <div class="modal-footer border-0 bg-secondary text-white justify-content-center">
                        <div class="text-center">
                            <ion-icon name="information-circle-outline" class="fs-5 me-2"></ion-icon>
                            <span class="fst-italic">Banner tanpa teks promosi</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- JavaScript untuk zoom functionality --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentZoom{{ $banner->id }} = 1;
            const zoomStep = 0.2;
            const maxZoom = 3;
            const minZoom = 0.5;
            const previewImage{{ $banner->id }} = document.getElementById('previewImage{{ $banner->id }}');

            // Function untuk zoom gambar
            window.zoomImage{{ $banner->id }} = function(action) {
                if (action === 'in') {
                    currentZoom{{ $banner->id }} = Math.min(currentZoom{{ $banner->id }} + zoomStep,
                        maxZoom);
                } else if (action === 'out') {
                    currentZoom{{ $banner->id }} = Math.max(currentZoom{{ $banner->id }} - zoomStep,
                        minZoom);
                } else if (action === 'reset') {
                    currentZoom{{ $banner->id }} = 1;
                }

                // Apply zoom dengan smooth transition
                previewImage{{ $banner->id }}.style.transform = `scale(${currentZoom{{ $banner->id }}})`;
                previewImage{{ $banner->id }}.style.transition = 'transform 0.3s ease';
            };

            // Reset zoom saat modal ditutup
            const modal{{ $banner->id }} = document.getElementById('previewModal{{ $banner->id }}');
            modal{{ $banner->id }}.addEventListener('hidden.bs.modal', function() {
                currentZoom{{ $banner->id }} = 1;
                previewImage{{ $banner->id }}.style.transform = 'scale(1)';
            });

            // Keyboard shortcuts untuk zoom
            modal{{ $banner->id }}.addEventListener('shown.bs.modal', function() {
                document.addEventListener('keydown', function handleKeyPress(e) {
                    if (e.key === '+' || e.key === '=') {
                        zoomImage{{ $banner->id }}('in');
                    } else if (e.key === '-') {
                        zoomImage{{ $banner->id }}('out');
                    } else if (e.key === '0') {
                        zoomImage{{ $banner->id }}('reset');
                    }
                });
            });
        });
    </script>

    {{-- Custom CSS untuk preview modal --}}
    <style>
        /* Background modal gelap */
        #previewModal{{ $banner->id }} .modal-content {
            background-color: #1a1a1a;
        }

        /* Container gambar */
        .preview-image-container {
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        /* Gambar dengan cursor pointer */
        .preview-image {
            cursor: zoom-in;
            transition: transform 0.3s ease;
        }

        .preview-image:hover {
            opacity: 0.95;
        }

        /* Info badge styling */
        .info-badge {
            backdrop-filter: blur(10px);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Button group floating */
        .btn-group {
            border-radius: 50px;
            overflow: hidden;
        }

        .btn-group .btn {
            padding: 0.5rem 1rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-group .btn:hover {
            transform: scale(1.1);
        }

        /* Gradient footer */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .preview-image-container {
                padding: 1rem;
            }

            .info-badge {
                font-size: 0.75rem !important;
            }

            .btn-group .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.875rem;
            }
        }

        /* Smooth modal appearance */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: none;
        }
    </style>
@endif
