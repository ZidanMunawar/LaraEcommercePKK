@extends('admin.layouts.mainLayout')
@section('title', 'Products')

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
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <ion-icon name="add-circle" class="align-middle me-1"></ion-icon>
                Add Product
            </a>
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

    <!-- Products -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="mb-0">All Products</h5>

                <!-- View Toggle -->
                <div class="btn-group ms-3" role="group">
                    <button type="button" class="btn btn-sm btn-outline-primary active" id="listViewBtn">
                        <ion-icon name="list" class="align-middle"></ion-icon>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="gridViewBtn">
                        <ion-icon name="grid" class="align-middle"></ion-icon>
                    </button>
                </div>

                <!-- Search -->
                <form class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                        <ion-icon name="search-sharp"></ion-icon>
                    </div>
                    <input class="form-control ps-5" type="text" id="searchInput" placeholder="Search products...">
                </form>
            </div>

            <!-- List View -->
            <div id="listView">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Categories</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productsTable">
                            @forelse($products as $index => $product)
                                <tr class="product-item">
                                    <td>{{ $products->firstItem() + $index }}</td>
                                    <td>
                                        @if ($product->primaryImage)
                                            <img src="{{ asset('storage/' . $product->primaryImage->image_url) }}"
                                                alt="{{ $product->name }}" class="rounded"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="width: 60px; height: 60px;">
                                                <ion-icon name="image-outline"
                                                    style="font-size: 30px; color: #ccc;"></ion-icon>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        @if ($product->promotion)
                                            <span class="badge bg-danger ms-1">{{ $product->promotion->name }}</span>
                                        @endif
                                        @if ($product->is_new)
                                            <span class="badge bg-info ms-1">New</span>
                                        @endif
                                        @if ($product->is_featured)
                                            <span class="badge bg-warning ms-1">Featured</span>
                                        @endif
                                        @if ($product->is_best_seller)
                                            <span class="badge bg-success ms-1">Best Seller</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong class="text-primary">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</strong>
                                        @if ($product->old_price)
                                            <br>
                                            <small class="text-muted text-decoration-line-through">
                                                Rp {{ number_format($product->old_price, 0, ',', '.') }}
                                            </small>
                                            <span class="badge bg-danger ms-1">-{{ $product->discount_percentage }}%</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge
                                            @if ($product->quantity > 10) bg-success
                                            @elseif($product->quantity > 0) bg-warning
                                            @else bg-danger @endif">
                                            {{ $product->quantity }} pcs
                                        </span>
                                    </td>
                                    <td>
                                        @if ($product->is_available)
                                            <span class="badge bg-success">Available</span>
                                        @else
                                            <span class="badge bg-secondary">Unavailable</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($product->categories->take(2) as $category)
                                            <span class="badge bg-primary">{{ $category->name }}</span>
                                        @endforeach
                                        @if ($product->categories->count() > 2)
                                            <span
                                                class="badge bg-light text-dark">+{{ $product->categories->count() - 2 }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('admin.products.edit', $product->id_produk) }}"
                                                class="btn btn-sm btn-primary">
                                                <ion-icon name="pencil" class="align-middle"></ion-icon>
                                                Edit
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $product->id_produk }}">
                                                <ion-icon name="trash" class="align-middle"></ion-icon>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                @include('admin.modals.products.delete', ['product' => $product])
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <ion-icon name="cube-outline" style="font-size: 60px; color: #ccc;"></ion-icon>
                                        <p class="text-muted mt-2 mb-0">No products found</p>
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-3">
                                            <ion-icon name="add-circle" class="align-middle me-1"></ion-icon>
                                            Add Your First Product
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Grid View -->
            <div id="gridView" style="display: none;">
                <div class="row g-3">
                    @forelse($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 product-item">
                            <div class="card h-100">
                                <!-- Product Image -->
                                <div class="position-relative">
                                    @if ($product->primaryImage)
                                        <img src="{{ asset('storage/' . $product->primaryImage->image_url) }}"
                                            class="card-img-top" alt="{{ $product->name }}"
                                            style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                            style="height: 200px;">
                                            <ion-icon name="image-outline"
                                                style="font-size: 60px; color: #ccc;"></ion-icon>
                                        </div>
                                    @endif

                                    <!-- Badges -->
                                    <div class="position-absolute top-0 start-0 m-2">
                                        @if ($product->is_new)
                                            <span class="badge bg-info">New</span>
                                        @endif
                                        @if ($product->is_featured)
                                            <span class="badge bg-warning">Featured</span>
                                        @endif
                                        @if ($product->is_best_seller)
                                            <span class="badge bg-success">Best Seller</span>
                                        @endif
                                    </div>

                                    @if ($product->promotion)
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-danger">{{ $product->promotion->name }}</span>
                                        </div>
                                    @endif

                                    @if ($product->old_price)
                                        <div class="position-absolute bottom-0 end-0 m-2">
                                            <span class="badge bg-danger">-{{ $product->discount_percentage }}%</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <h6 class="card-title mb-2">{{ Str::limit($product->name, 50) }}</h6>

                                    <!-- Price -->
                                    <div class="mb-2">
                                        <strong class="text-primary">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</strong>
                                        @if ($product->old_price)
                                            <br>
                                            <small class="text-muted text-decoration-line-through">
                                                Rp {{ number_format($product->old_price, 0, ',', '.') }}
                                            </small>
                                        @endif
                                    </div>

                                    <!-- Stock & Status -->
                                    <div class="d-flex justify-content-between mb-2">
                                        <span
                                            class="badge
                                            @if ($product->quantity > 10) bg-success
                                            @elseif($product->quantity > 0) bg-warning
                                            @else bg-danger @endif">
                                            Stock: {{ $product->quantity }}
                                        </span>
                                        @if ($product->is_available)
                                            <span class="badge bg-success">Available</span>
                                        @else
                                            <span class="badge bg-secondary">Unavailable</span>
                                        @endif
                                    </div>

                                    <!-- Categories -->
                                    <div class="mb-3">
                                        @foreach ($product->categories->take(2) as $category)
                                            <span class="badge bg-primary">{{ $category->name }}</span>
                                        @endforeach
                                        @if ($product->categories->count() > 2)
                                            <span
                                                class="badge bg-light text-dark">+{{ $product->categories->count() - 2 }}</span>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id_produk) }}"
                                            class="btn btn-sm btn-primary">
                                            <ion-icon name="pencil" class="align-middle"></ion-icon>
                                            Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $product->id_produk }}">
                                            <ion-icon name="trash" class="align-middle"></ion-icon>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        @include('admin.modals.products.delete', ['product' => $product])
                    @empty
                        <div class="col-12 text-center py-5">
                            <ion-icon name="cube-outline" style="font-size: 60px; color: #ccc;"></ion-icon>
                            <p class="text-muted mt-2 mb-0">No products found</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-3">
                                <ion-icon name="add-circle" class="align-middle me-1"></ion-icon>
                                Add Your First Product
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if ($products->hasPages())
                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // View Toggle
            const listViewBtn = document.getElementById('listViewBtn');
            const gridViewBtn = document.getElementById('gridViewBtn');
            const listView = document.getElementById('listView');
            const gridView = document.getElementById('gridView');

            listViewBtn.addEventListener('click', function() {
                listView.style.display = 'block';
                gridView.style.display = 'none';
                listViewBtn.classList.add('active');
                gridViewBtn.classList.remove('active');
                localStorage.setItem('productView', 'list');
            });

            gridViewBtn.addEventListener('click', function() {
                listView.style.display = 'none';
                gridView.style.display = 'block';
                gridViewBtn.classList.add('active');
                listViewBtn.classList.remove('active');
                localStorage.setItem('productView', 'grid');
            });

            // Remember view preference
            const savedView = localStorage.getItem('productView');
            if (savedView === 'grid') {
                gridViewBtn.click();
            }

            // Search functionality
            const searchInput = document.getElementById('searchInput');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const items = document.querySelectorAll('.product-item');

                items.forEach(function(item) {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Auto close alerts
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
