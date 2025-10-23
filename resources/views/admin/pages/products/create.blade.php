@extends('admin.layouts.mainLayout')
@section('title', 'Add New Product')

@section('content')
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Products</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <ion-icon name="home-sharp"></ion-icon>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.products.index') }}">Products</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <ion-icon name="arrow-back" class="align-middle me-1"></ion-icon>
                Back to Products
            </a>
        </div>
    </div>
    <!--end breadcrumb-->

    <!-- Display Alerts -->
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

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Left Column - Main Info -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <ion-icon name="information-circle" class="align-middle me-2"></ion-icon>
                            Basic Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="Enter product name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="5" placeholder="Enter product description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price & Old Price -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price (Rp) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price') }}" step="0.01" min="0"
                                    placeholder="0" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="old_price" class="form-label">Old Price (Rp) <small
                                        class="text-muted">(Optional)</small></label>
                                <input type="number" class="form-control @error('old_price') is-invalid @enderror"
                                    id="old_price" name="old_price" value="{{ old('old_price') }}" step="0.01"
                                    min="0" placeholder="0">
                                @error('old_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty if no discount</small>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Stock Quantity <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" value="{{ old('quantity', 0) }}" min="0"
                                placeholder="0" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Promotion -->
                        <div class="mb-3">
                            <label for="promotion_id" class="form-label">Promotion <small
                                    class="text-muted">(Optional)</small></label>
                            <select class="form-select @error('promotion_id') is-invalid @enderror" id="promotion_id"
                                name="promotion_id">
                                <option value="">-- No Promotion --</option>
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
                            <small class="text-muted">Select a promotion tag for this product</small>
                        </div>
                    </div>
                </div>
                <!-- Product Images -->
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <ion-icon name="images" class="align-middle me-2"></ion-icon>
                            Product Images (Max 10)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Upload Images <span class="text-danger">*</span></label>
                            <input type="file"
                                class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                                id="images" name="images[]" accept="image/*" multiple required>
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Select 1-10 images. First image will be primary. Supported:
                                JPG, PNG,
                                GIF (Max 2MB each)</small>
                        </div>

                        <!-- Image Preview -->
                        <div id="imagePreview" class="row g-2"></div>
                    </div>
                </div>

                <!-- Product Attributes -->
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <ion-icon name="pricetags" class="align-middle me-2"></ion-icon>
                            Product Attributes
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Categories -->
                        <div class="mb-3">
                            <label class="form-label">Categories <span class="text-danger">*</span></label>
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
                        </div>

                        <!-- Colors -->
                        <div class="mb-3">
                            <label class="form-label">Colors <span class="text-danger">*</span></label>
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
                        </div>

                        <!-- Sizes -->
                        <div class="mb-3">
                            <label class="form-label">Sizes <span class="text-danger">*</span></label>
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
                        </div>

                        <!-- Tags -->
                        <div class="mb-3">
                            <label class="form-label">Tags <span class="text-danger">*</span></label>
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
                        </div>

                        <!-- Audiences -->
                        <div class="mb-3">
                            <label class="form-label">Audiences <span class="text-danger">*</span></label>
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Status & Actions -->
            <div class="col-lg-4">
                <!-- Product Status -->
                <div class="card mb-3">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0">
                            <ion-icon name="toggle" class="align-middle me-2"></ion-icon>
                            Product Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_available" name="is_available"
                                value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">
                                <strong>Available for Sale</strong>
                                <br><small class="text-muted">Product can be purchased</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_new" name="is_new"
                                value="1" {{ old('is_new') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_new">
                                <strong>Mark as New</strong>
                                <br><small class="text-muted">Show "New" badge</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <strong>Featured Product</strong>
                                <br><small class="text-muted">Show on homepage</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="is_best_seller" name="is_best_seller"
                                value="1" {{ old('is_best_seller') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_best_seller">
                                <strong>Best Seller</strong>
                                <br><small class="text-muted">Show "Best Seller" badge</small>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <ion-icon name="save" class="align-middle me-2"></ion-icon>
                                Save Product
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg">
                                <ion-icon name="close" class="align-middle me-2"></ion-icon>
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <ion-icon name="help-circle" class="align-middle me-1"></ion-icon>
                            Quick Tips
                        </h6>
                    </div>
                    <div class="card-body">
                        <small>
                            <ul class="mb-0 ps-3">
                                <li>All fields marked with <span class="text-danger">*</span> are required</li>
                                <li>First uploaded image will be the primary image</li>
                                <li>You can select multiple categories, colors, sizes, tags, and audiences</li>
                                <li>Set old price to show discount percentage</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Styles -->
    <style>
        .tags-input-container {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
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
            padding: 6px 12px;
            background: #fff;
            border: 2px solid #ddd;
            border-radius: 20px;
            font-size: 14px;
            transition: all 0.2s;
            user-select: none;
        }

        .tag-item input[type="checkbox"]:checked+.tag-label {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .tag-item:hover .tag-label {
            border-color: #0d6efd;
        }

        .color-box {
            display: inline-block;
            width: 16px;
            height: 16px;
            border-radius: 3px;
            border: 1px solid #ddd;
            vertical-align: middle;
            margin-right: 5px;
        }

        .color-tag input[type="checkbox"]:checked+.tag-label {
            background: #28a745;
            border-color: #28a745;
        }

        #imagePreview .preview-item {
            position: relative;
        }

        #imagePreview img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #ddd;
        }

        #imagePreview .primary-badge {
            position: absolute;
            top: 5px;
            left: 5px;
            background: #0d6efd;
            color: white;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
        }
    </style>

    <!-- Scripts -->
    <script>
        // Image Preview
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            const files = Array.from(e.target.files);

            if (files.length > 10) {
                alert('Maximum 10 images allowed!');
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
                                ${index === 0 ? '<span class="primary-badge">Primary</span>' : ''}
                                <img src="${e.target.result}" alt="Preview">
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
