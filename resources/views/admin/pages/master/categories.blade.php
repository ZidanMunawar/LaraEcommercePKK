@extends('admin.layouts.mainLayout')
@section('title', 'Categories')

@section('content')
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master Data</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><ion-icon
                                name="home-sharp"></ion-icon></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Categories</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <ion-icon name="add-circle-outline" class="align-middle"></ion-icon> Add Category
            </button>
        </div>
    </div>
    <!--end breadcrumb-->

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

    <!-- Categories Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0">Categories List</h5>
                <form class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                        <ion-icon name="search-sharp"></ion-icon>
                    </div>
                    <input class="form-control ps-5" type="text" id="searchInput" placeholder="Search categories...">
                </form>
            </div>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Audiences</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTable">
                        @forelse($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td>
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                            class="rounded"
                                            style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                                            onclick="showImageModal('{{ asset('storage/' . $category->image) }}', '{{ $category->name }}')">
                                    @else
                                        <span class="badge bg-secondary">No image</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($category->audiences->isNotEmpty())
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach ($category->audiences as $audience)
                                                <span class="badge bg-info">{{ $audience->name }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">No audiences</span>
                                    @endif
                                </td>
                                <td>{{ $category->created_at->format('d M Y, H:i') }}</td>
                                <td>{{ $category->updated_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editCategoryModal{{ $category->id }}">
                                            <ion-icon name="pencil" class="align-middle"></ion-icon> Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteCategoryModal{{ $category->id }}">
                                            <ion-icon name="trash" class="align-middle"></ion-icon> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            @include('admin.modals.master.categories.edit', [
                                'category' => $category,
                                'audiences' => $audiences,
                            ])
                            @include('admin.modals.master.categories.delete', ['category' => $category])
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <ion-icon name="file-tray-outline" style="font-size: 64px; color: #ccc;"></ion-icon>
                                    <p class="text-muted mt-3 mb-0">No categories available</p>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal"
                                        data-bs-target="#addCategoryModal">
                                        <ion-icon name="add-circle-outline"></ion-icon> Add First Category
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.modals.master.categories.add')

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImage" src="" alt="Preview" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto close alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('categoriesTable');

            if (searchInput && tableBody) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = tableBody.getElementsByTagName('tr');

                    Array.from(rows).forEach(function(row) {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }
        });

        // Show image preview modal
        function showImageModal(imageSrc, title) {
            document.getElementById('previewImage').src = imageSrc;
            document.getElementById('imagePreviewModalLabel').textContent = title;
            const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
            modal.show();
        }
    </script>
@endsection
