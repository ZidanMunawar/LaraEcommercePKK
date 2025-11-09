@extends('admin.layouts.mainLayout')
@section('title', 'Tambah Produk Baru')

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
                    <li class="breadcrumb-item active" aria-current="page">Tambah Produk</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <ion-icon name="arrow-back" class="align-middle me-1"></ion-icon>
                Kembali ke Daftar Produk
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

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf

        <div class="row">
            <!-- KOLOM KIRI - Info Utama -->
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
                                name="name" value="{{ old('name') }}" placeholder="Contoh: Kaos Polos Cotton Premium"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Produk</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="5" placeholder="Jelaskan detail produk, bahan, cara perawatan, dll...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Deskripsi yang detail akan membantu customer memahami produk
                                Anda</small>
                        </div>

                        <!-- Harga & Harga Lama -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Harga Jual (Rp) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price') }}" step="1" min="0"
                                    placeholder="100000" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Harga yang akan dibayar customer</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="old_price" class="form-label">Harga Coret (Rp) <small
                                        class="text-muted">(Opsional)</small></label>
                                <input type="number" class="form-control @error('old_price') is-invalid @enderror"
                                    id="old_price" name="old_price" value="{{ old('old_price') }}" step="1"
                                    min="0" placeholder="150000">
                                @error('old_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Isi jika produk sedang diskon</small>
                            </div>
                        </div>

                        <!-- Jumlah Stok -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" value="{{ old('quantity', 0) }}" min="0"
                                placeholder="100" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jumlah produk yang tersedia untuk dijual</small>
                        </div>

                        <!-- Promosi -->
                        <div class="mb-3">
                            <label for="promotion_id" class="form-label">Tag Promosi <small
                                    class="text-muted">(Opsional)</small></label>
                            <select class="form-select @error('promotion_id') is-invalid @enderror" id="promotion_id"
                                name="promotion_id">
                                <option value="">-- Pilih Promosi --</option>
                                @foreach ($promotions as $promotion)
                                    <option value="{{ $promotion->id }}"
                                        {{ old('promotion_id') == $promotion->id ? 'selected' : '' }}>
                                        {{ $promotion->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('promotion_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Contoh: Flash Sale, New Arrival, dll</small>
                        </div>
                    </div>
                </div>

                <!-- Gambar Produk -->
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <ion-icon name="images" class="align-middle me-2"></ion-icon>
                            Gambar Produk (Maks 10)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Upload Gambar <span class="text-danger">*</span></label>
                            <input type="file"
                                class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                                id="images" name="images[]" accept="image/*" multiple required>
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <ion-icon name="information-circle-outline"></ion-icon>
                                Pilih 1-10 gambar. Gambar pertama akan menjadi gambar utama. Format: JPG, PNG, GIF (Maks 2MB
                                per gambar)
                            </small>
                        </div>

                        <!-- Preview Gambar -->
                        <div id="imagePreview" class="row g-2"></div>
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
                                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                            <span class="tag-label">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('categories')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih kategori yang sesuai dengan produk</small>
                        </div>

                        <!-- Warna -->
                        <div class="mb-3">
                            <label class="form-label">Warna <span class="text-danger">*</span></label>
                            <div class="tags-input-container">
                                <div class="tags-input @error('colors') is-invalid @enderror" id="colors-tags">
                                    @foreach ($colors as $color)
                                        <label class="tag-item color-tag">
                                            <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                                                {{ in_array($color->id, old('colors', [])) ? 'checked' : '' }}>
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
                            <small class="text-muted">Pilih warna yang tersedia untuk produk ini</small>
                        </div>

                        <!-- Ukuran -->
                        <div class="mb-3">
                            <label class="form-label">Ukuran <span class="text-danger">*</span></label>
                            <div class="tags-input-container">
                                <div class="tags-input @error('sizes') is-invalid @enderror" id="sizes-tags">
                                    @foreach ($sizes as $size)
                                        <label class="tag-item">
                                            <input type="checkbox" name="sizes[]" value="{{ $size->id }}"
                                                {{ in_array($size->id, old('sizes', [])) ? 'checked' : '' }}>
                                            <span class="tag-label">{{ $size->size }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('sizes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih ukuran yang tersedia untuk produk ini</small>
                        </div>

                        <!-- Tag -->
                        <div class="mb-3">
                            <label class="form-label">Tag <span class="text-danger">*</span></label>
                            <div class="tags-input-container">
                                <div class="tags-input @error('tags') is-invalid @enderror" id="tags-tags">
                                    @foreach ($tags as $tag)
                                        <label class="tag-item">
                                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                            <span class="tag-label">{{ $tag->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('tags')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih tag untuk mempermudah pencarian produk</small>
                        </div>

                        <!-- Target Audience -->
                        <div class="mb-3">
                            <label class="form-label">Target Audience <span class="text-danger">*</span></label>
                            <div class="tags-input-container">
                                <div class="tags-input @error('audiences') is-invalid @enderror" id="audiences-tags">
                                    @foreach ($audiences as $audience)
                                        <label class="tag-item">
                                            <input type="checkbox" name="audiences[]" value="{{ $audience->id }}"
                                                {{ in_array($audience->id, old('audiences', [])) ? 'checked' : '' }}>
                                            <span class="tag-label">{{ $audience->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('audiences')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih siapa target pembeli produk ini</small>
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
                                value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">
                                <strong>Tersedia untuk Dijual</strong>
                                <br><small class="text-muted">Customer bisa membeli produk ini</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_new" name="is_new"
                                value="1" {{ old('is_new') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_new">
                                <strong>Tandai sebagai Baru</strong>
                                <br><small class="text-muted">Tampilkan badge "Baru"</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <strong>Produk Unggulan</strong>
                                <br><small class="text-muted">Tampilkan di halaman utama</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="is_best_seller" name="is_best_seller"
                                value="1" {{ old('is_best_seller') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_best_seller">
                                <strong>Terlaris</strong>
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
                                Simpan Produk
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg">
                                <ion-icon name="close" class="align-middle me-2"></ion-icon>
                                Batal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bantuan -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <ion-icon name="help-circle" class="align-middle me-1"></ion-icon>
                            Tips Cepat
                        </h6>
                    </div>
                    <div class="card-body">
                        <small>
                            <ul class="mb-0 ps-3">
                                <li>Semua field bertanda <span class="text-danger">*</span> wajib diisi</li>
                                <li>Gambar pertama yang diupload akan menjadi gambar utama produk</li>
                                <li>Anda bisa memilih lebih dari satu kategori, warna, ukuran, tag, dan audience</li>
                                <li>Isi "Harga Coret" untuk menampilkan persentase diskon</li>
                                <li>Gunakan deskripsi yang jelas dan detail untuk meningkatkan penjualan</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Styles -->
    <style>
        /* Tag Input Container */
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
            transition: all 0.2s;
            user-select: none;
            font-weight: 500;
        }

        .tag-item input[type="checkbox"]:checked+.tag-label {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .tag-item:hover .tag-label {
            border-color: #0d6efd;
            transform: translateY(-2px);
        }

        /* Color Box */
        .color-box {
            display: inline-block;
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 2px solid #ddd;
            vertical-align: middle;
            margin-right: 6px;
        }

        .color-tag input[type="checkbox"]:checked+.tag-label {
            background: #28a745;
            border-color: #28a745;
        }

        /* Image Preview */
        #imagePreview .preview-item {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
        }

        #imagePreview img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border: 3px solid #ddd;
            transition: all 0.3s;
        }

        #imagePreview img:hover {
            border-color: #0d6efd;
            transform: scale(1.05);
        }

        #imagePreview .primary-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        /* Switch Styles */
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>

    <!-- Scripts -->
    <script>
        // Preview gambar saat dipilih
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            const files = Array.from(e.target.files);

            // Validasi maksimal 10 gambar
            if (files.length > 10) {
                alert('Maksimal 10 gambar diperbolehkan!');
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
                            <div class="preview-item">
                                ${index === 0 ? '<span class="primary-badge">Gambar Utama</span>' : ''}
                                <img src="${e.target.result}" alt="Preview ${index + 1}">
                            </div>
                        `;

                        preview.appendChild(col);
                    };

                    reader.readAsDataURL(file);
                }
            });
        });

        // Auto close alerts
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
