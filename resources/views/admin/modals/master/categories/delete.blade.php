@if (isset($category))
    <!-- Delete Category Modal -->
    <div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1"
        aria-labelledby="deleteCategoryModalLabel{{ $category->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteCategoryModalLabel{{ $category->id }}">
                        <ion-icon name="warning" class="align-middle"></ion-icon> Delete Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.master.categories.destroy', $category->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <ion-icon name="alert-circle" style="font-size: 64px; color: #dc3545;"></ion-icon>
                        </div>
                        <p class="text-center fw-bold">Are you sure you want to delete this category?</p>

                        <!-- Category Preview Card -->
                        <div class="card border-danger">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    @if ($category->image)
                                        <div class="col-md-4 text-center mb-2">
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                alt="{{ $category->name }}" class="img-fluid rounded"
                                                style="max-height: 80px;">
                                        </div>
                                    @endif
                                    <div class="col-md-{{ $category->image ? '8' : '12' }}">
                                        <p class="mb-2"><strong>Name:</strong> {{ $category->name }}</p>
                                        <p class="mb-0">
                                            <strong>Audiences:</strong>
                                            @if ($category->audiences->isNotEmpty())
                                                <br>
                                                @foreach ($category->audiences as $audience)
                                                    <span class="badge bg-info me-1">{{ $audience->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No audiences</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3 mb-0" role="alert">
                            <small>
                                <ion-icon name="warning" class="align-middle"></ion-icon>
                                <strong>Warning:</strong> This action cannot be undone.
                                The category and all its relationships will be permanently deleted.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon> Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <ion-icon name="trash"></ion-icon> Delete Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
