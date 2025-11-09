@if (isset($tag))
    <!-- Modal Edit Tag -->
    <div class="modal fade" id="editTagModal{{ $tag->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.master.tags.update', $tag->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <ion-icon name="pencil-outline" class="align-middle"></ion-icon>
                            Edit Tag
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Info tag yang diedit -->
                        <div class="alert alert-info">
                            <ion-icon name="information-circle"></ion-icon>
                            Anda sedang mengedit tag:
                            <span class="badge bg-info ms-1">
                                <ion-icon name="pricetag"></ion-icon>
                                {{ $tag->name }}
                            </span>
                        </div>

                        <!-- Nama Tag -->
                        <div class="mb-3">
                            <label for="editTagName{{ $tag->id }}" class="form-label">
                                Nama Tag <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="editTagName{{ $tag->id }}"
                                name="name" value="{{ $tag->name }}" required>
                        </div>

                        <!-- Info terakhir diubah -->
                        <div class="text-muted small">
                            <ion-icon name="time-outline"></ion-icon>
                            Terakhir diubah: {{ $tag->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <ion-icon name="save-outline"></ion-icon> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
