{{-- resources/views/admin/modals/chat/assign-modal.blade.php --}}
<!-- Assign Chat Modal -->
<div class="modal fade" id="assignModal{{ $room->id_room }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.chat.assign', $room->id_room) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_admin" class="form-label">Assign to Admin</label>
                        <select class="form-select" id="id_admin" name="id_admin" required>
                            <option value="">Select Admin</option>
                            @foreach (\App\Models\Admin::where('status', 'active')->whereIn('role', ['admin', 'petugas'])->get() as $admin)
                                <option value="{{ $admin->id_admin }}"
                                    {{ $room->id_admin == $admin->id_admin ? 'selected' : '' }}>
                                    {{ $admin->nama_lengkap }} ({{ $admin->role }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <small>
                            <ion-icon name="information-circle"></ion-icon>
                            Chat ini akan ditugaskan ke admin yang dipilih. Admin tersebut akan menerima notifikasi.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Assign Chat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal"
    data-bs-target="#assignModal{{ $room->id_room }}">
    <ion-icon name="person-add"></ion-icon> Assign
</button>
