@extends('admin.layouts.mainLayout')
@section('title', 'Edit Product')

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
                    <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
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

    <form action="{{ route('admin.products.update', $product->id_produk) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                                name="name" value="{{ old('name', $product->name) }}" placeholder="Enter product name"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="5" placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
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
                                    id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01"
                                    min="0" placeholder="0" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="old_price" class="form-label">Old Price (Rp) <small
                                        class="text-muted">(Optional)</small></label>
                                <input type="number" class="form-control @error('old_price') is-invalid @enderror"
                                    id="old_price" name="old_price" value="{{ old('old_price', $product->old_price) }}"
                                    step="0.01" min="0" placeholder="0">
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
                                id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}"
                                min="0" placeholder="0" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Di dalam card Basic Information, ganti bagian Promotion Text dengan ini: -->

                        <!-- Promotion -->
                        <div class="mb-3">
                            <label for="promotion_id" class="form-label">Promotion <small
                                    class="text-muted">(Optional)</small></label>
                            <select class="form-select @error('promotion_id') is-invalid @enderror" id="promotion_id"
                                name="promotion_id">
                                <option value="">-- No Promotion --</option>
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
                            <small class="text-muted">Select a promotion tag for this product</small>
                        </div>
                    </div>
                </div>

                <!-- Product Images -->
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <ion-icon name="images" class="align-middle me-2"></ion-icon>
                            Product Images
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Existing Images -->
                        <div class="mb-3">
                            <label class="form-label">Current Images</label>
                            <div class="row g-2" id="existingImages">
                                @foreach ($product->images as $image)
                                    <div class="col-6 col-md-4 col-lg-3 image-item" data-image-id="{{ $image->id }}">
                                        <div class="position-relative">
                                            @if ($image->is_primary)
                                                <span
                                                    class="position-absolute top-0 start-0 m-2 badge bg-primary">Primary</span>
                                            @endif
                                            <button type="button"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 delete-image-btn"
                                                data-image-id="{{ $image->id }}">
                                                <ion-icon name="trash"></ion-icon>
                                            </button>
                                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Product Image"
                                                class="img-fluid rounded"
                                                style="width: 100%; height: 150px; object-fit: cover; border: 2px solid #ddd;">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="radio" name="primary_image"
                                                    value="{{ $image->id }}" id="primary_{{ $image->id }}"
                                                    {{ $image->is_primary ? 'checked' : '' }}>
                                                <label class="form-check-label" for="primary_{{ $image->id }}">
                                                    Set as Primary
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Add New Images -->
                        <div class="mb-3">
                            <label class="form-label">Add New Images <small class="text-muted">(Optional, Max
                                    total
                                    10)</small></label>
                            <input type="file"
                                class="form-control @error('new_images') is-invalid @enderror @error('new_images.*') is-invalid @enderror"
                                id="new_images" name="new_images[]" accept="image/*" multiple>
                            @error('new_images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('new_images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Current: {{ $product->images->count() }} images. You can add
                                more up
                                to 10 total.</small>
                        </div>

                        <!-- New Image Preview -->
                        <div id="newImagePreview" class="row g-2"></div>
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
                                                {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                        </div>

                        <!-- Sizes -->
                        <div class="mb-3">
                            <label class="form-label">Sizes <span class="text-danger">*</span></label>
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
                        </div>

                        <!-- Tags -->
                        <div class="mb-3">
                            <label class="form-label">Tags <span class="text-danger">*</span></label>
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
                        </div>

                        <!-- Audiences -->
                        <div class="mb-3">
                            <label class="form-label">Audiences <span class="text-danger">*</span></label>
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
                                value="1" {{ old('is_available', $product->is_available) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">
                                <strong>Available for Sale</strong>
                                <br><small class="text-muted">Product can be purchased</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_new" name="is_new"
                                value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_new">
                                <strong>Mark as New</strong>
                                <br><small class="text-muted">Show "New" badge</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <strong>Featured Product</strong>
                                <br><small class="text-muted">Show on homepage</small>
                            </label>
                        </div>

                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="is_best_seller" name="is_best_seller"
                                value="1" {{ old('is_best_seller', $product->is_best_seller) ? 'checked' : '' }}>
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
                                Update Product
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg">
                                <ion-icon name="close" class="align-middle me-2"></ion-icon>
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <ion-icon name="information-circle" class="align-middle me-1"></ion-icon>
                            Product Info
                        </h6>
                    </div>
                    <div class="card-body">
                        <small>
                            <p class="mb-2"><strong>Created:</strong>
                                {{ $product->created_at->format('d M Y, H:i') }}
                            </p>
                            <p class="mb-2"><strong>Last Updated:</strong>
                                {{ $product->updated_at->format('d M Y, H:i') }}</p>
                            <p class="mb-0"><strong>Total Images:</strong> {{ $product->images->count() }} / 10
                            </p>
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

        .delete-image-btn {
            z-index: 10;
        }
    </style>

    <!-- Scripts -->
    <script>
        // New Image Preview
        document.getElementById('new_images').addEventListener('change', function(e) {
            const preview = document.getElementById('newImagePreview');
            preview.innerHTML = '';

            const files = Array.from(e.target.files);
            const currentCount = {{ $product->images->count() }};

            if (currentCount + files.length > 10) {
                alert('Total images cannot exceed 10! Current: ' + currentCount);
                e.target.value = '';
                return;
            }

            files.forEach((file) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-6 col-md-4 col-lg-3';

                        col.innerHTML = `
                            <div class="position-relative">
                                <img src="${e.target.result}" alt="New Image"
                                     class="img-fluid rounded"
                                     style="width: 100%; height: 150px; object-fit: cover; border: 2px solid #28a745;">
                                <span class="position-absolute top-0 start-0 m-2 badge bg-success">New</span>
                            </div>
                        `;

                        preview.appendChild(col);
                    };

                    reader.readAsDataURL(file);
                }
            });
        });

        // Delete Image
        document.querySelectorAll('.delete-image-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!confirm('Are you sure you want to delete this image?')) {
                    return;
                }

                const imageId = this.getAttribute('data-image-id');
                const imageItem = this.closest('.image-item');

                fetch(`/admin/products/image/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            imageItem.remove();
                            alert(data.message);

                            // Reload if needed
                            const remainingImages = document.querySelectorAll('.image-item').length;
                            if (remainingImages === 0) {
                                location.reload();
                            }
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        alert('Error deleting image');
                        console.error('Error:', error);
                    });
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
