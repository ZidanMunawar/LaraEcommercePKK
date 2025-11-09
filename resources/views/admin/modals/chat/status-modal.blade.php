{{-- resources/views/admin/modals/chat/status-modal.blade.php --}}
<!-- Status Chat Modal -->
<div class="modal fade" id="statusModal{{ $room->id_room }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Chat Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.chat.updateStatus', $room->id_room) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" {{ $room->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="pending" {{ $room->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="resolved" {{ $room->status == 'resolved' ? 'selected' : '' }}>Resolved
                            </option>
                        </select>
                    </div>
                    <div class="alert alert-warning">
                        <small>
                            <ion-icon name="warning"></ion-icon>
                            <strong>Resolved:</strong> Chat akan diarsipkan dan tidak muncul di daftar aktif.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
    data-bs-target="#statusModal{{ $room->id_room }}">
    <ion-icon name="flag"></ion-icon> Status
</button>
