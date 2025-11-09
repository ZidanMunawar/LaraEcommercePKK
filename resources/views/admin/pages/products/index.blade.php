@extends('admin.layouts.mainLayout')
@section('title', 'Data Produk')

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
                    <li class="breadcrumb-item active" aria-current="page">Produk</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <ion-icon name="add-circle" class="align-middle me-1"></ion-icon>
                Tambah Produk
            </a>
            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                <ion-icon name="download-outline" class="align-middle"></ion-icon>
                Export PDF
            </button>
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

    <!-- Card Produk -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="mb-0">Semua Produk</h5>

                <!-- Toggle View (List/Grid) -->
                <div class="btn-group ms-3" role="group">
                    <button type="button" class="btn btn-sm btn-outline-primary active" id="listViewBtn"
                        title="Tampilan List">
                        <ion-icon name="list" class="align-middle"></ion-icon>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="gridViewBtn" title="Tampilan Grid">
                        <ion-icon name="grid" class="align-middle"></ion-icon>
                    </button>
                </div>

                <!-- Search -->
                <div class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                        <ion-icon name="search-sharp"></ion-icon>
                    </div>
                    <input class="form-control ps-5" type="text" id="searchInput" placeholder="Cari produk...">
                </div>
            </div>

            <!-- TAMPILAN LIST -->
            <div id="listView">
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th width="100">Gambar</th>
                                <th>Nama Produk</th>
                                <th width="150">Harga</th>
                                <th width="100">Stok</th>
                                <th width="100">Status</th>
                                <th width="150">Kategori</th>
                                <th width="180" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="productsTable">
                            @forelse($products as $index => $product)
                                <tr class="product-item">
                                    <td>{{ $products->firstItem() + $index }}</td>
                                    <td>
                                        @if ($product->primaryImage)
                                            <img src="{{ asset('storage/' . $product->primaryImage->image_url) }}"
                                                alt="{{ $product->name }}" class="rounded shadow-sm"
                                                style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imagePreviewModal{{ $product->id_produk }}">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 70px; height: 70px;">
                                                <ion-icon name="image-outline"
                                                    style="font-size: 30px; color: #ccc;"></ion-icon>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $product->name }}</strong>
                                            <div class="mt-1">
                                                @if ($product->promotion)
                                                    <span class="badge bg-danger">{{ $product->promotion->name }}</span>
                                                @endif
                                                @if ($product->is_new)
                                                    <span class="badge bg-info">Baru</span>
                                                @endif
                                                @if ($product->is_featured)
                                                    <span class="badge bg-warning">Unggulan</span>
                                                @endif
                                                @if ($product->is_best_seller)
                                                    <span class="badge bg-success">Terlaris</span>
                                                @endif
                                            </div>
                                        </div>
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
                                            <span class="badge bg-success">
                                                <ion-icon name="checkmark-circle" class="align-middle"></ion-icon>
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <ion-icon name="close-circle" class="align-middle"></ion-icon>
                                                Tidak Tersedia
                                            </span>
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
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.products.edit', $product->id_produk) }}"
                                                class="btn btn-sm btn-primary">
                                                <ion-icon name="pencil" class="align-middle"></ion-icon>
                                                Edit
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $product->id_produk }}">
                                                <ion-icon name="trash" class="align-middle"></ion-icon>
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyRow">
                                    <td colspan="8" class="text-center py-5">
                                        <ion-icon name="cube-outline" style="font-size: 64px; color: #ccc;"></ion-icon>
                                        <p class="text-muted mt-3 mb-0">Belum ada produk</p>
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-3">
                                            <ion-icon name="add-circle" class="align-middle me-1"></ion-icon>
                                            Tambah Produk Pertama
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAMPILAN GRID -->
            <div id="gridView" style="display: none;">
                <div class="row g-3">
                    @forelse($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 product-item">
                            <div class="card h-100 shadow-sm">
                                <!-- Product Image -->
                                <div class="position-relative" style="cursor: pointer;"
                                    @if ($product->primaryImage) data-bs-toggle="modal" data-bs-target="#imagePreviewModal{{ $product->id_produk }}" @endif>
                                    @if ($product->primaryImage)
                                        <img src="{{ asset('storage/' . $product->primaryImage->image_url) }}"
                                            class="card-img-top" alt="{{ $product->name }}"
                                            style="height: 220px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                            style="height: 220px;">
                                            <ion-icon name="image-outline"
                                                style="font-size: 60px; color: #ccc;"></ion-icon>
                                        </div>
                                    @endif

                                    <!-- Badges Atas Kiri -->
                                    <div class="position-absolute top-0 start-0 m-2">
                                        @if ($product->is_new)
                                            <span class="badge bg-info mb-1">Baru</span>
                                        @endif
                                        @if ($product->is_featured)
                                            <span class="badge bg-warning mb-1">Unggulan</span>
                                        @endif
                                        @if ($product->is_best_seller)
                                            <span class="badge bg-success">Terlaris</span>
                                        @endif
                                    </div>

                                    <!-- Badge Promosi Atas Kanan -->
                                    @if ($product->promotion)
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-danger">{{ $product->promotion->name }}</span>
                                        </div>
                                    @endif

                                    <!-- Badge Diskon Bawah Kanan -->
                                    @if ($product->old_price)
                                        <div class="position-absolute bottom-0 end-0 m-2">
                                            <span class="badge bg-danger">-{{ $product->discount_percentage }}%</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <h6 class="card-title mb-2" style="min-height: 40px;">
                                        {{ Str::limit($product->name, 50) }}
                                    </h6>

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
                                            Stok: {{ $product->quantity }}
                                        </span>
                                        @if ($product->is_available)
                                            <span class="badge bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Tersedia</span>
                                        @endif
                                    </div>

                                    <!-- Categories -->
                                    <div class="mb-3" style="min-height: 30px;">
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
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <ion-icon name="cube-outline" style="font-size: 64px; color: #ccc;"></ion-icon>
                            <p class="text-muted mt-3 mb-0">Belum ada produk</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-3">
                                <ion-icon name="add-circle" class="align-middle me-1"></ion-icon>
                                Tambah Produk Pertama
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

    <!-- MODAL SECTION  -->
    @foreach ($products as $product)
        <!-- Image Preview Modal -->
        @if ($product->primaryImage)
            <div class="modal fade" id="imagePreviewModal{{ $product->id_produk }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <ion-icon name="eye-outline" class="align-middle"></ion-icon>
                                Preview Gambar - {{ $product->name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-0">
                            <img src="{{ asset('storage/' . $product->primaryImage->image_url) }}"
                                alt="{{ $product->name }}" class="img-fluid w-100"
                                style="max-height: 600px; object-fit: contain; background: #f8f9fa;">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Delete Modal -->
        @include('admin.modals.products.delete', ['product' => $product])
        @include('admin.modals.products.export-modal')
    @endforeach

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle View (List/Grid)
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

            // Ingat preferensi view user
            const savedView = localStorage.getItem('productView');
            if (savedView === 'grid') {
                gridViewBtn.click();
            }

            // Realtime Search
            const searchInput = document.getElementById('searchInput');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const items = document.querySelectorAll('.product-item');
                let visibleCount = 0;

                items.forEach(function(item) {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        item.style.display = '';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Tampilkan pesan "tidak ada hasil"
                const noResultMessage = document.getElementById('noResultMessage');
                if (searchTerm && visibleCount === 0) {
                    if (!noResultMessage) {
                        const message = document.createElement('div');
                        message.id = 'noResultMessage';
                        message.className = 'text-center py-5';
                        message.innerHTML = `
                            <ion-icon name="search-outline" style="font-size: 48px; color: #ccc;"></ion-icon>
                            <p class="text-muted mt-2 mb-0">
                                Tidak ada hasil untuk "<strong>${searchTerm}</strong>"
                            </p>
                        `;

                        if (listView.style.display !== 'none') {
                            const tbody = document.getElementById('productsTable');
                            const tr = document.createElement('tr');
                            const td = document.createElement('td');
                            td.colSpan = 8;
                            td.appendChild(message);
                            tr.appendChild(td);
                            tbody.appendChild(tr);
                        } else {
                            const row = gridView.querySelector('.row');
                            const col = document.createElement('div');
                            col.className = 'col-12';
                            col.appendChild(message);
                            row.appendChild(col);
                        }
                    }
                } else if (noResultMessage) {
                    const parent = noResultMessage.closest('tr') || noResultMessage.closest('.col-12');
                    if (parent) parent.remove();
                }
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
