@extends('admin.layouts.mainLayout')
@section('title', 'Edit Produk')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Produk</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <ion-icon name="home-sharp"></ion-icon>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.products.index') }}">Produk</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <ion-icon name="arrow-back" class="align-middle me-1"></ion-icon>
                Kembali
            </a>
        </div>
    </div>

    <!-- Alert Error -->
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <div class="d-flex align-items-center">
                <div class="fs-4 text-danger me-2">
                    <ion-icon name="close-circle"></ion-icon>
                </div>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Alert Success -->
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

    <form action="{{ route('admin.products.update', $product->id_produk) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- KOLOM KIRI - Informasi Utama -->
            <div class="col-lg-8">
                <!-- Informasi Dasar -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <ion-icon name="information-circle" class="align-middle me-2"></ion-icon>
                            Informasi Dasar
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Nama Produk -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $product->name) }}" placeholder="Masukkan nama produk"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Produk</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="5" placeholder="Masukkan deskripsi produk...">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jelaskan detail produk, fitur, dan keunggulan</small>
                        </div>

                        <!-- Harga & Harga Lama -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Harga (Rp) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price', $product->price) }}"
                                    step="0.01" min="0" placeholder="100000" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="old_price" class="form-label">
                                    Harga Lama (Rp) <span class="text-muted">(Opsional)</span>
                                </label>
                                <input type="number" class="form-control @error('old_price') is-invalid @enderror"
                                    id="old_price" name="old_price" value="{{ old('old_price', $product->old_price) }}"
                                    step="0.01" min="0" placeholder="150000">
                                @error('old_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Kosongkan jika tidak ada diskon</small>
                            </div>
                        </div>

                        <!-- Stok -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}"
                                min="0" placeholder="0" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jumlah stok produk yang tersedia</small>
                        </div>

                        <!-- Promosi -->
                        <div class="mb-3">
                            <label for="promotion_id" class="form-label">
                                Promosi <span class="text-muted">(Opsional)</span>
                            </label>
                            <select class="form-select @error('promotion_id') is-invalid @enderror" id="promotion_id"
                                name="promotion_id">
                                <option value="">-- Tidak Ada Promosi --</option>
                                @foreach ($promotions as $promotion)
                                    <option value="{{ $promotion->id }}"
                                        {{ old('promotion_id', $product->promotion_id) == $promotion->id ? 'selected' : '' }}>
                                        {{ $promotion->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('promotion_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih label promosi untuk produk (Flash Sale, New Arrival,
                                dll)</small>
                        </div>
                    </div>
                </div>

                <!-- Gambar Produk -->
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <ion-icon name="images" class="align-middle me-2"></ion-icon>
                            Gambar Produk
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Gambar yang Ada -->
                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div class="row g-2" id="existingImages">
                                @foreach ($product->images as $image)
                                    <div class="col-6 col-md-4 col-lg-3 image-item" data-image-id="{{ $image->id }}">
                                        <div class="position-relative">
                                            @if ($image->is_primary)
                                                <span class="position-absolute top-0 start-0 m-2 badge bg-primary">
                                                    <ion-icon name="star"></ion-icon> Utama
                                                </span>
                                            @endif
                                            <button type="button"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 delete-image-btn"
                                                data-image-id="{{ $image->id }}"
                                                data-image-url="{{ asset('storage/' . $image->image_url) }}"
                                                title="Hapus gambar">
                                                <ion-icon name="trash"></ion-icon>
                                            </button>
                                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Gambar Produk"
                                                class="img-fluid rounded"
                                                style="width: 100%; height: 150px; object-fit: cover; border: 3px solid #ddd;">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="radio" name="primary_image"
                                                    value="{{ $image->id }}" id="primary_{{ $image->id }}"
                                                    {{ $image->is_primary ? 'checked' : '' }}>
                                                <label class="form-check-label" for="primary_{{ $image->id }}">
                                                    Jadikan Utama
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tambah Gambar Baru -->
                        <div class="mb-3">
                            <label class="form-label">
                                Tambah Gambar Baru <span class="text-muted">(Opsional, Maks total 10)</span>
                            </label>
                            <input type="file"
                                class="form-control @error('new_images') is-invalid @enderror @error('new_images.*') is-invalid @enderror"
                                id="new_images" name="new_images[]" accept="image/*" multiple>
                            @error('new_images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('new_images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <ion-icon name="information-circle-outline"></ion-icon>
                                Saat ini: {{ $product->images->count() }} gambar. Dapat menambah sampai total 10 gambar.
                            </small>
                        </div>

                        <!-- Preview Gambar Baru -->
                        <div id="newImagePreview" class="row g-2"></div>
                    </div>
                </div>

                <!-- Atribut Produk -->
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <ion-icon name="pricetags" class="align-middle me-2"></ion-icon>
                            Atribut Produk
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <div class="tags-input-container">
                                <div class="tags-input @error('categories') is-invalid @enderror" id="categories-tags">
                                    @foreach ($categories as $category)
                                        <label class="tag-item">
                                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <span class="tag-label">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('categories')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih minimal 1 kategori</small>
                        </div>

                        <!-- Warna -->
                        <div class="mb-3">
                            <label class="form-label">Warna <span class="text-danger">*</span></label>
                            <div class="tags-input-container">
                                <div class="tags-input @error('colors') is-invalid @enderror" id="colors-tags">
                                    @foreach ($colors as $color)
                                        <label class="tag-item color-tag">
                                            <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                                                {{ in_array($color->id, old('colors', $product->colors->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <span class="tag-label">
                                                <span class="color-box"
                                                    style="background-color: {{ $color->code }};"></span>
                                                {{ $color->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('colors')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih minimal 1 warna</small>
                        </div>

                        <!-- Ukuran -->
                        <div class="mb-3">
                            <label class="form-label">Ukuran <span class="text-danger">*</span></label>
                            <div class="tags-input-container">
                                <div class="tags-input @error('sizes') is-invalid @enderror" id="sizes-tags">
                                    @foreach ($sizes as $size)
                                        <label class="tag-item">
                                            <input type="checkbox" name="sizes[]" value="{{ $size->id }}"
                                                {{ in_array($size->id, old('sizes', $product->sizes->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <span class="tag-label">{{ $size->size }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('sizes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih minimal 1 ukuran</small>
                        </div>

                        <!-- Tag -->
                        <div class="mb-3">
                            <label class="form-label">Tag <span class="text-danger">*</span></label>
                            <div class="tags-input-container">
                                <div class="tags-input @error('tags') is-invalid @enderror" id="tags-tags">
                                    @foreach ($tags as $tag)
                                        <label class="tag-item">
                                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                                {{ in_array($tag->id, old('tags', $product->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <span class="tag-label">{{ $tag->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('tags')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih minimal 1 tag</small>
                        </div>

                        <!-- Audience -->
                        <div class="mb-3">
                            <label class="form-label">Target Audience <span class="text-danger">*</span></label>
                            <div class="tags-input-container">
                                <div class="tags-input @error('audiences') is-invalid @enderror" id="audiences-tags">
                                    @foreach ($audiences as $audience)
                                        <label class="tag-item">
                                            <input type="checkbox" name="audiences[]" value="{{ $audience->id }}"
                                                {{ in_array($audience->id, old('audiences', $product->audiences->pluck('id')->toArray())) ? 'checked' : '' }}>
                                            <span class="tag-label">{{ $audience->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('audiences')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih minimal 1 target audience</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN - Status & Aksi -->
            <div class="col-lg-4">
                <!-- Status Produk -->
                <div class="card mb-3">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0">
                            <ion-icon name="toggle" class="align-middle me-2"></ion-icon>
                            Status Produk
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_available" name="is_available"
                                value="1" {{ old('is_available', $product->is_available) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">
                                <strong>Tersedia Untuk Dijual</strong>
                                <br><small class="text-muted">Produk dapat dibeli customer</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_new" name="is_new"
                                value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_new">
                                <strong>Tandai Sebagai Baru</strong>
                                <br><small class="text-muted">Tampilkan badge "Baru"</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <strong>Produk Unggulan</strong>
                                <br><small class="text-muted">Tampilkan di halaman utama</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="is_best_seller" name="is_best_seller"
                                value="1" {{ old('is_best_seller', $product->is_best_seller) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_best_seller">
                                <strong>Best Seller</strong>
                                <br><small class="text-muted">Tampilkan badge "Terlaris"</small>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <ion-icon name="save" class="align-middle me-2"></ion-icon>
                                Perbarui Produk
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg">
                                <ion-icon name="close" class="align-middle me-2"></ion-icon>
                                Batal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Produk -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <ion-icon name="information-circle" class="align-middle me-1"></ion-icon>
                            Informasi Produk
                        </h6>
                    </div>
                    <div class="card-body">
                        <small>
                            <p class="mb-2">
                                <strong>Dibuat:</strong>
                                <br>{{ $product->created_at->format('d M Y, H:i') }}
                            </p>
                            <p class="mb-2">
                                <strong>Terakhir Diubah:</strong>
                                <br>{{ $product->updated_at->format('d M Y, H:i') }}
                            </p>
                            <p class="mb-0">
                                <strong>Total Gambar:</strong> {{ $product->images->count() }} / 10
                            </p>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- MODAL KONFIRMASI HAPUS GAMBAR -->
    <div class="modal fade" id="deleteImageModal" tabindex="-1" aria-labelledby="deleteImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteImageModalLabel">
                        <ion-icon name="warning" class="align-middle me-2"></ion-icon>
                        Konfirmasi Hapus Gambar
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <ion-icon name="trash" style="font-size: 64px; color: #dc3545;"></ion-icon>
                    </div>
                    <h5 class="mb-3">Apakah Anda yakin ingin menghapus gambar ini?</h5>
                    <div class="mb-3">
                        <img id="deleteImagePreview" src="" alt="Preview Gambar"
                            class="img-fluid rounded shadow" style="max-height: 200px;">
                    </div>
                    <p class="text-muted mb-0">Tindakan ini tidak dapat dibatalkan!</p>
                    <input type="hidden" id="deleteImageId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close" class="align-middle me-1"></ion-icon>
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteImage">
                        <ion-icon name="trash" class="align-middle me-1"></ion-icon>
                        Ya, Hapus Gambar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- CSS STYLES -->
    <style>
        /* Container tag input */
        .tags-input-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px;
            background: #f8f9fa;
        }

        .tags-input {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        /* Style untuk setiap tag item */
        .tag-item {
            display: inline-block;
            margin: 0;
            cursor: pointer;
        }

        .tag-item input[type="checkbox"] {
            display: none;
        }

        .tag-item .tag-label {
            display: inline-block;
            padding: 8px 16px;
            background: #fff;
            border: 2px solid #ddd;
            border-radius: 20px;
            font-size: 14px;
            transition: all 0.3s;
            user-select: none;
        }

        /* Style saat tag dipilih */
        .tag-item input[type="checkbox"]:checked+.tag-label {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
            transform: scale(1.05);
        }

        .tag-item:hover .tag-label {
            border-color: #0d6efd;
            transform: scale(1.05);
        }

        /* Box warna */
        .color-box {
            display: inline-block;
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 2px solid #fff;
            box-shadow: 0 0 0 1px #ddd;
            vertical-align: middle;
            margin-right: 6px;
        }

        /* Warna tag khusus warna */
        .color-tag input[type="checkbox"]:checked+.tag-label {
            background: #28a745;
            border-color: #28a745;
        }

        /* Tombol hapus gambar */
        .delete-image-btn {
            z-index: 10;
            padding: 4px 8px;
        }

        /* Hover effect pada gambar */
        .image-item img {
            transition: transform 0.3s;
        }

        .image-item:hover img {
            transform: scale(1.05);
        }

        /* Modal styling */
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
            justify-content: center;
        }

        #deleteImagePreview {
            border: 3px solid #dc3545;
        }
    </style>

    <!-- JAVASCRIPT -->
    <script>
        // Preview gambar baru yang diupload
        document.getElementById('new_images').addEventListener('change', function(e) {
            const preview = document.getElementById('newImagePreview');
            preview.innerHTML = '';

            const files = Array.from(e.target.files);
            const currentCount = {{ $product->images->count() }};

            // Validasi total gambar tidak lebih dari 10
            if (currentCount + files.length > 10) {
                alert('Total gambar tidak boleh lebih dari 10! Saat ini: ' + currentCount + ' gambar');
                e.target.value = '';
                return;
            }

            files.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-6 col-md-4 col-lg-3';

                        col.innerHTML = `
                            <div class="position-relative">
                                <img src="${e.target.result}" alt="Gambar Baru"
                                     class="img-fluid rounded"
                                     style="width: 100%; height: 150px; object-fit: cover; border: 3px solid #28a745;">
                                <span class="position-absolute top-0 start-0 m-2 badge bg-success">
                                    <ion-icon name="add-circle"></ion-icon> Baru
                                </span>
                                <span class="position-absolute top-0 end-0 m-2 badge bg-dark">
                                    ${currentCount + index + 1}
                                </span>
                            </div>
                        `;

                        preview.appendChild(col);
                    };

                    reader.readAsDataURL(file);
                }
            });
        });

        // Inisialisasi modal Bootstrap
        let deleteImageModal;
        document.addEventListener('DOMContentLoaded', function() {
            deleteImageModal = new bootstrap.Modal(document.getElementById('deleteImageModal'));
        });

        // Buka modal konfirmasi hapus gambar
        document.querySelectorAll('.delete-image-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const imageId = this.getAttribute('data-image-id');
                const imageUrl = this.getAttribute('data-image-url');

                // Set data ke modal
                document.getElementById('deleteImageId').value = imageId;
                document.getElementById('deleteImagePreview').src = imageUrl;

                // Tampilkan modal
                deleteImageModal.show();
            });
        });

        // Konfirmasi hapus gambar
        document.getElementById('confirmDeleteImage').addEventListener('click', function() {
            const imageId = document.getElementById('deleteImageId').value;
            const imageItem = document.querySelector(`.image-item[data-image-id="${imageId}"]`);
            const confirmBtn = this;

            // Disable button dan tambahkan loading
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghapus...';

            // Kirim request delete via AJAX
            fetch(`/admin/products/image/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hapus elemen gambar dari DOM
                        imageItem.remove();

                        // Tutup modal
                        deleteImageModal.hide();

                        // Tampilkan alert success
                        showAlert('success', data.message);

                        // Reload jika tidak ada gambar tersisa
                        const remainingImages = document.querySelectorAll('.image-item').length;
                        if (remainingImages === 0) {
                            setTimeout(function() {
                                alert('Minimal harus ada 1 gambar produk!');
                                location.reload();
                            }, 1000);
                        }
                    } else {
                        deleteImageModal.hide();
                        showAlert('danger', data.message);
                    }
                })
                .catch(error => {
                    deleteImageModal.hide();
                    showAlert('danger', 'Terjadi kesalahan saat menghapus gambar');
                    console.error('Error:', error);
                })
                .finally(() => {
                    // Reset button
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML =
                        '<ion-icon name="trash" class="align-middle me-1"></ion-icon>Ya, Hapus Gambar';
                });
        });

        // Function untuk menampilkan alert
        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="fs-4 text-${type} me-2">
                        <ion-icon name="${type === 'success' ? 'checkmark-circle' : 'close-circle'}"></ion-icon>
                    </div>
                    <div>${message}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            // Insert alert di awal content
            const content = document.querySelector('.page-breadcrumb').parentElement;
            content.insertBefore(alertDiv, content.firstChild);

            // Auto close setelah 5 detik
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alertDiv);
                bsAlert.close();
            }, 5000);
        }

        // Auto close alerts yang sudah ada
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
