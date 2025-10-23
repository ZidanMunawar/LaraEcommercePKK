@if (isset($slide))
    <!-- Delete Slide Modal -->
    <div class="modal fade" id="deleteSlideModal{{ $slide->id }}" tabindex="-1"
        aria-labelledby="deleteSlideModalLabel{{ $slide->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteSlideModalLabel{{ $slide->id }}">
                        <ion-icon name="warning" class="align-middle"></ion-icon> Delete Slide
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.master.slides.destroy', $slide->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <ion-icon name="alert-circle" style="font-size: 64px; color: #dc3545;"></ion-icon>
                        </div>
                        <p class="text-center">Are you sure you want to delete this slide?</p>

                        <!-- Slide Preview -->
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center mb-2">
                                    <img src="{{ asset('storage/' . $slide->image) }}" alt="Slide"
                                        class="img-fluid rounded" style="max-height: 120px;">
                                </div>
                                @if ($slide->promotion)
                                    <p class="text-center mb-0">
                                        <strong>Promotion:</strong> {{ $slide->promotion->name }}
                                    </p>
                                @else
                                    <p class="text-center mb-0 text-muted">No promotion</p>
                                @endif
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3 mb-0" role="alert">
                            <small>
                                <ion-icon name="warning" class="align-middle"></ion-icon>
                                <strong>Warning:</strong> This action cannot be undone.
                                The slide and its image will be permanently deleted.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
